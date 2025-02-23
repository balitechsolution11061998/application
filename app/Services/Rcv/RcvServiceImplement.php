<?php

namespace App\Services\Rcv;

use App\Models\RcvDetail;
use App\Models\RcvHead;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Rcv\RcvRepository;
use App\Repositories\OrdHead\OrdHeadRepository;
use App\Repositories\RcvDetail\RcvDetailRepository;
use App\Repositories\RcvHead\RcvHeadRepository;
use Illuminate\Support\Facades\DB;

class RcvServiceImplement extends ServiceApi implements RcvService
{
    protected string $title = "";
    protected OrdHeadRepository $ordHeadRepository;
    protected RcvDetailRepository $rcvDetailRepository;
    protected RcvHeadRepository $rcvHeadRepository;

    public function __construct(
        OrdHeadRepository $ordHeadRepository,
        RcvDetailRepository $rcvDetailRepository,
        RcvHeadRepository $rcvHeadRepository
    ) {
        $this->ordHeadRepository = $ordHeadRepository;
        $this->rcvDetailRepository = $rcvDetailRepository;
        $this->rcvHeadRepository = $rcvHeadRepository;
    }

    public function store($data)
    {
        try {
            $requestData = $data;
            $chunkSize = 100;

            // Insert into temp_rcv in chunks
            collect($requestData)->chunk($chunkSize)->each(function ($chunk) {
                DB::table('temp_rcv')->insert($chunk->toArray());
            });
            activity()->log("Data inserted into temp_rcv in chunks of {$chunkSize}.");

            // Process temp_rcv data and check for duplicates
            collect($requestData)->chunk($chunkSize)->each(function ($chunk) {
                foreach ($chunk as $item) {
                    $exists = DB::table('temp_rcv')
                        ->where('receive_no', $item['receive_no'])
                        ->where('sku', $item['sku'])
                        ->exists();

                    if ($exists) {
                        activity()
                            ->causedBy(auth()->user())
                            ->withProperties(['receive_no' => $item['receive_no'], 'sku' => $item['sku']])
                            ->log("Duplicate entry skipped for temp_rcv: receive_no {$item['receive_no']}, sku {$item['sku']}");
                    } else {
                        DB::table('temp_rcv')->insert($item);
                    }
                }
            });

            // Process non-existing data in RcvHead
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

                $existingRcvHead = RcvHead::where('receive_no', $data[0]->receive_no)->first();
                $existingRcvHead = $this->rcvHeadRepository->findByReceiveNo($data[0]->receive_no);

                if ($existingRcvHead) {
                    activity()
                        ->performedOn($existingRcvHead)
                        ->withProperties(['before_update' => $existingRcvHead->toArray()])
                        ->log("Existing RcvHead state before update for receive_no {$data[0]->receive_no}");
                }

                if (!$existingRcvHead || $existingRcvHead->status !== 'y') {
                    $rcvHeadData['status'] = 'n';
                }

                $rcvHead = $this->rcvHeadRepository->updateOrCreate(
                    ["receive_no" => $data[0]->receive_no],
                    $rcvHeadData
                );

                activity()
                    ->performedOn($rcvHead)
                    ->withProperties([
                        'receive_no' => $data[0]->receive_no,
                        'status' => $existingRcvHead && $existingRcvHead->status === 'y' ? 'Unchanged' : 'Updated to n',
                        'after_update' => $rcvHead->toArray(),
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
                        "service_level" => $detail->qty_received / $detail->qty_expected * 100,
                    ];

                    $existingRcvDetail = RcvDetail::where([
                        'rcvhead_id' => $rcvHead->id,
                        'sku' => $detail->sku,
                        'receive_no' => $detail->receive_no,
                    ])->first();

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

                    activity()
                        ->performedOn($rcvDetail)
                        ->withProperties([
                            'receive_no' => $detail->receive_no,
                            'sku' => $detail->sku,
                            'qty_expected' => $detail->qty_expected,
                            'qty_received' => $detail->qty_received,
                            'service_level' => $rcvDetailData['service_level'],
                            'after_update' => $rcvDetail->toArray(),
                        ])
                        ->log("RcvDetail for receive_no {$detail->receive_no} " . ($rcvDetail->wasRecentlyCreated ? 'Inserted' : 'Updated'));

                    $totalServiceLevel += ($detail->qty_received / $detail->qty_expected) * 100;
                    $sub_total += $detail->qty_received * $detail->unit_cost;
                    $sub_total_vat_cost += $detail->vat_cost * $detail->qty_received;
                }

                $averageServiceLevel = $totalItems > 0 ? $totalServiceLevel / $totalItems : 0;

                $rcvHead->update([
                    'average_service_level' => $averageServiceLevel,
                    'sub_total' => $sub_total,
                    'sub_total_vat_cost' => $sub_total_vat_cost,
                ]);

                activity()
                    ->performedOn($rcvHead)
                    ->withProperties([
                        'average_service_level' => $averageServiceLevel,
                        'sub_total' => $sub_total,
                        'sub_total_vat_cost' => $sub_total_vat_cost,
                        'after_update' => $rcvHead->toArray(),
                    ])
                    ->log("Updated RcvHead with calculated values for receive_no {$data[0]->receive_no}");

                $podata = $this->ordHeadRepository->where('order_no', $data[0]->order_no)->first();

                if ($podata != null) {
                    $newStatus = $averageServiceLevel == 100 ? 'Completed' : 'Incompleted';
                    $podata->update([
                        'status' => $newStatus,
                        'estimated_delivery_date' => $data[0]->receive_date,
                    ]);

                    activity()
                        ->performedOn($podata)
                        ->withProperties([
                            'order_no' => $data[0]->order_no,
                            'status' => $newStatus,
                            'estimated_delivery_date' => $data[0]->receive_date,
                        ])
                        ->log("Updated ordHead status to '{$newStatus}' for order_no {$data[0]->order_no}");
                }
            }

            DB::table('temp_rcv')->truncate();
            activity()->log("Processed all receive_no groups and cleared temp_rcv table.");

        } catch (\Throwable $th) {
            activity()->withProperties(['error' => $th->getMessage()])
                ->log("Error processing data in RcvService.");
            throw $th;
        }
    }
}
