<?php

namespace App\Services\Rcv;

use App\Models\RcvDetail;
use App\Models\RcvHead;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Rcv\RcvRepository;
use App\Repositories\OrdHead\OrdHeadRepository;
use App\Repositories\RcvDetail\RcvDetailRepository;
use App\Repositories\RcvHead\RcvHeadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RcvServiceImplement extends ServiceApi implements RcvService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "";
     /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */

    protected OrdHeadRepository $ordHeadRepository;
    protected RcvDetailRepository $rcvDetailRepository;
    protected RcvHeadRepository $rcvHeadRepository;

     public function __construct(OrdHeadRepository $ordHeadRepository, RcvDetailRepository $rcvDetailRepository, RcvHeadRepository $rcvHeadRepository)
    {
      $this->ordHeadRepository = $ordHeadRepository;
      $this->rcvDetailRepository = $rcvDetailRepository;
      $this->rcvHeadRepository = $rcvHeadRepository;
    }



    public function store($data)
    {
        try {
            $requestData = $data;

            $chunkSize = 100;

            collect($requestData)->chunk($chunkSize)->each(function ($chunk) {
                DB::table('temp_rcv')->insert($chunk->toArray());
            });

            $rcvNotExists = DB::table('temp_rcv')
                ->select('temp_rcv.*')
                ->leftJoin('rcvhead', function ($join) {
                    $join->on('temp_rcv.receive_no', '=', 'rcvhead.receive_no');
                })
                ->get();

            $datas = collect($rcvNotExists);

            foreach ($datas->groupBy('receive_no') as $data) {
                $totalServiceLevel = 0;
                $sub_total = 0;
                $sub_total_vat_cost = 0;
                $totalItems = count($data);

                $rcvHeadData = [
                    "receive_date" => $data[0]->receive_date,
                    "created_date" => $data[0]->created_date,
                    "receive_id" => $data[0]->receive_id,
                    "order_no" => $data[0]->order_no,
                    "ref_no" => $data[0]->ref_no,
                    "order_type" => $data[0]->order_type,
                    "status_ind" => $data[0]->status_ind,
                    "approval_date" => $data[0]->approval_date,
                    "approval_id" => $data[0]->approval_id,
                    "store" => $data[0]->store,
                    "store_name" => $data[0]->store_name,
                    "supplier" => $data[0]->supplier,
                    "sup_name" => $data[0]->sup_name,
                    "comment_desc" => $data[0]->comment_desc,
                ];

                // Use Eloquent model to check for existing RcvHead
                $existingRcvHead = RcvHead::where('receive_no', $data[0]->receive_no)->first();

                // Log existing RcvHead state before update
                if ($existingRcvHead) {
                    activity()
                        ->performedOn($existingRcvHead) // Now it's an Eloquent model
                        ->withProperties(['before_update' => $existingRcvHead->toArray()])
                        ->log("Existing RcvHead state before update for receive_no {$data[0]->receive_no}");
                }

                // Set status based on existing record
                if (!$existingRcvHead || $existingRcvHead->status !== 'y') {
                    $rcvHeadData['status'] = 'n';
                }

                $rcvHead = $this->rcvHeadRepository->updateOrCreate(
                    ["receive_no" => $data[0]->receive_no],
                    $rcvHeadData
                );

                // Log activity for RcvHead insert/update
                activity()
                    ->performedOn($rcvHead)
                    ->withProperties([
                        'receive_no' => $data[0]->receive_no,
                        'order_no' => $data[0]->order_no,
                        'status' => $existingRcvHead && $existingRcvHead->status === 'y' ? 'Unchanged' : 'Updated to n',
                    ])
                    ->log("RcvHead for receive_no {$data[0]->receive_no} " . ($rcvHead->wasRecentlyCreated ? 'Inserted' : 'Updated'));

                foreach ($data as $detail) {
                    $rcvDetailData = [
                        "store" => $detail->store,
                        "sku" => $detail->sku,
                        "upc" => $detail->upc,
                        "sku_desc" => $detail->sku_desc,
                        "qty_expected" => $detail->qty_expected,
                        "qty_received" => $detail->qty_received,
                        "unit_cost" => $detail->unit_cost,
                        "unit_retail" => $detail->unit_retail,
                        "vat_cost" => $detail->vat_cost,
                        "unit_cost_disc" => $detail->unit_cost_disc,
                        "service_level" =>  $detail->qty_received / $detail->qty_expected * 100,
                    ];

                    // Use Eloquent model to check for existing RcvDetail
                    $existingRcvDetail = RcvDetail::where(['rcvhead_id' => $rcvHead->id, 'sku' => $detail->sku, 'receive_no' => $detail->receive_no])->first();

                    // Log existing RcvDetail state before update
                    if ($existingRcvDetail) {
                        activity()
                            ->performedOn($existingRcvDetail)
                            ->withProperties(['before_update' => $existingRcvDetail->toArray()])
                            ->log("Existing RcvDetail state before update for SKU {$detail->sku}");
                    }

                    $rcvDetail = $this->rcvDetailRepository->updateOrCreate(
                        ['rcvhead_id' => $rcvHead->id, 'sku' => $detail->sku, 'receive_no' => $detail->receive_no],
                        $rcvDetailData
                    );

                    // Log activity for RcvDetail insert/update
                    activity()
                        ->performedOn($rcvDetail)
                        ->withProperties([
                            'receive_no' => $detail->receive_no,
                            'sku' => $detail->sku,
                            'qty_expected' => $detail->qty_expected,
                            'qty_received' => $detail->qty_received,
                            'service_level' => $rcvDetailData['service_level'],
                        ])
                        ->log("RcvDetail for receive_no {$detail->receive_no} " . ($rcvDetail->wasRecentlyCreated ? 'Inserted' : 'Updated'));

                    $totalServiceLevel += ($detail->qty_received / $detail->qty_expected) * 100;
                    $sub_total += $detail->qty_received * $detail->unit_cost;
                    $sub_total_vat_cost += $detail->vat_cost * $detail->qty_received;
                }

                $averageServiceLevel = $totalItems > 0 ? $totalServiceLevel / $totalItems : 0;

                // Update RcvHead with calculated values
                $rcvHead->update([
                    'average_service_level' => $averageServiceLevel,
                    'sub_total' => $sub_total,
                    'sub_total_vat_cost' => $sub_total_vat_cost,
                ]);

                // Log update for RcvHead with calculated values
                activity()
                    ->performedOn($rcvHead)
                    ->withProperties([
                        'average_service_level' => $averageServiceLevel,
                        'sub_total' => $sub_total,
                        'sub_total_vat_cost' => $sub_total_vat_cost,
                    ])
                    ->log("Updated RcvHead with calculated values for receive_no {$data[0]->receive_no}");

                $podata = $this->ordHeadRepository->where('order_no', $data[0]->order_no)->first();

                if ($podata != null && $averageServiceLevel == 100) {
                    $podata->update([
                        'status' => 'Completed',
                        'estimated_delivery_date' => $data[0]->receive_date,
                    ]);
                    activity()
                        ->performedOn($podata)
                        ->withProperties([
                            'order_no' => $data[0]->order_no,
                            'status' => 'Completed',
                            'estimated_delivery_date' => $data[0]->receive_date,
                        ])
                        ->log("Updated ordHead status to 'Completed' for order_no {$data[0]->order_no}");
                } else if ($podata != null && $averageServiceLevel < 100) {
                    $podata->update([
                        'status' => 'Incompleted',
                        'estimated_delivery_date' => $data[0]->receive_date,
                    ]);
                    activity()
                        ->performedOn($podata)
                        ->withProperties([
                            'order_no' => $data[0]->order_no,
                            'status' => 'Incompleted',
                            'estimated_delivery_date' => $data[0]->receive_date,
                        ])
                        ->log("Updated ordHead status to 'Incompleted' for order_no {$data[0]->order_no}");
                }
            }

            DB::table('temp_rcv')->truncate();
            activity()->log("Processed all receive_no groups and cleared temp_rcv table.");

        } catch (\Throwable $th) {
            activity()->withProperties(['error' => $th->getMessage()])->log("Error processing data");
            throw $th;
        }
    }




}
