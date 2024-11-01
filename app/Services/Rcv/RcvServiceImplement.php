<?php

namespace App\Services\Rcv;

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
        $successCount = 0;
        $failureCount = 0;

        try {
            // Start transaction

            // Validate data before processing
            if (empty($data)) {
                throw new Exception("No data provided for processing.");
            }

            // Insert data in chunks
            $chunkSize = 100;
            collect($data)->chunk($chunkSize)->each(function ($chunk) {
                DB::table('temp_rcv')->insert($chunk->toArray());
            });

            $rcvNotExists = DB::table('temp_rcv')
                ->select('temp_rcv.*')
                ->leftJoin('rcvhead', function ($join) {
                    $join->on('temp_rcv.receive_no', '=', 'rcvhead.receive_no');
                })
                ->whereNull('rcvhead.receive_no')
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
                    'status' => 'n',
                    "comment_desc" => $data[0]->comment_desc,
                ];

                // Insert or update RcvHead
                $rcvHead = $this->rcvHeadRepository->updateOrCreate(
                    ["receive_no" => $data[0]->receive_no],
                    $rcvHeadData
                );

                // Log activity for RcvHead insert/update
                activity()
                    ->performedOn($rcvHead)
                    ->log("RcvHead for receive_no {$data[0]->receive_no} " . ($rcvHead->wasRecentlyCreated ? 'Inserted' : 'Updated'));

                $successCount++; // Increment success count for RcvHead

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
                        "service_level" => $detail->qty_expected > 0 ? ($detail->qty_received / $detail->qty_expected) * 100 : 0,
                    ];

                    // Insert or update RcvDetail
                    $rcvDetail = $this->rcvDetailRepository->updateOrCreate(
                        ['rcvhead_id' => $rcvHead->id, 'sku' => $detail->sku, 'receive_no' => $detail->receive_no],
                        $rcvDetailData
                    );

                    // Log activity for RcvDetail insert/update
                    activity()
                        ->performedOn($rcvDetail)
                        ->log("RcvDetail for receive_no {$detail->receive_no} " . ($rcvDetail->wasRecentlyCreated ? 'Inserted' : 'Updated'));

                    $successCount++; // Increment success count for RcvDetail

                    // Calculate totals
                    if ($detail->qty_expected > 0) {
                        $totalServiceLevel += ($detail->qty_received / $detail->qty_expected) * 100;
                    }
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

                // Log activity for updating average service level
                activity()
                    ->performedOn($rcvHead)
                    ->log("Updated average service level for receive_no {$data[0]->receive_no}");

                $podata = $this->ordHeadRepository->where('order_no', $data[0]->order_no)->first();

                if ($podata != null && $averageServiceLevel == 100) {
                    $podata->update([
                        'status' => 'Completed',
                        'estimated_delivery_date' => $data[0]->receive_date,
                    ]);

                    // Log activity for updating order status to Completed
                    activity()
                        ->performedOn($podata)
                        ->log("Updated order status to Completed for order_no {$data[0]->order_no}");

                    $successCount++; // Increment success count for order status update
                } else if ($podata != null && $averageServiceLevel < 100) {
                    $podata->update([
                        'status' => 'Incompleted',
                        'estimated_delivery_date' => $data[0]->receive_date,
                    ]);

                    // Log activity for updating order status to Incompleted
                    activity()
                        ->performedOn($podata)
                        ->log("Updated order status to Incompleted for order_no {$data[0]->order_no}");

                    $successCount++; // Increment success count for order status update
                }
            }

            DB::table('temp_rcv')->truncate();

            // Log activity for successful operation
            activity()
                ->log("Successfully processed $successCount records.");

        } catch (\Throwable $th) {

            // Log activity for failed operation with detailed error message
            activity()
                ->log("Failed to process data. $failureCount records failed to process. Error: " . $th->getMessage());

            throw $th; // Rethrow the exception for further handling
        }
    }
}
