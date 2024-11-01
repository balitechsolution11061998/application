<?php

namespace App\Services\Rcv;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Rcv\RcvRepository;
use App\Repositories\OrdHead\OrdHeadRepository;
use App\Repositories\RcvDetail\RcvDetailRepository;
use App\Repositories\RcvHead\RcvHeadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
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
        DB::beginTransaction(); // Start transaction
        try {
            $chunkSize = 100;

            // Insert data in chunks
            collect($data)->chunk($chunkSize)->each(function ($chunk) {
                DB::table('temp_rcv')->insert($chunk->toArray());
            });

            // Fetch records that do not exist in rcvhead
            $rcvNotExists = DB::table('temp_rcv')
                ->select('temp_rcv.*')
                ->leftJoin('rcvhead', 'temp_rcv.receive_no', '=', 'rcvhead.receive_no')
                ->whereNull('rcvhead.receive_no')
                ->get();

            $groupedData = $rcvNotExists->groupBy('receive_no');

            foreach ($groupedData as $receiveNo => $dataGroup) {
                $totalServiceLevel = 0;
                $subTotal = 0;
                $subTotalVatCost = 0;
                $totalItems = $dataGroup->count();

                $rcvHeadData = $this->prepareRcvHeadData($dataGroup);

                // Check if we need to insert or update
                $rcvHead = $this->rcvHeadRepository->updateOrCreate(
                    ["receive_no" => $receiveNo],
                    $rcvHeadData
                );

                // Log activity for insert/update
                activity()
                    ->performedOn($rcvHead)
                    ->log($rcvHead->wasRecentlyCreated ? 'Inserted RcvHead' : 'Updated RcvHead');

                foreach ($dataGroup as $detail) {
                    $serviceLevel = ($detail->qty_expected > 0) ? ($detail->qty_received / $detail->qty_expected) * 100 : 0;

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
                        "service_level" => $serviceLevel,
                    ];

                    $rcvDetail = $this->rcvDetailRepository->updateOrCreate(
                        ['rcvhead_id' => $rcvHead->id, 'sku' => $detail->sku, 'receive_no' => $detail->receive_no],
                        $rcvDetailData
                    );

                    // Log activity for insert/update
                    activity()
                        ->performedOn($rcvDetail)
                        ->log($rcvDetail->wasRecentlyCreated ? 'Inserted RcvDetail' : 'Updated RcvDetail');

                    $totalServiceLevel += $serviceLevel;
                    $subTotal += $detail->qty_received * $detail->unit_cost;
                    $subTotalVatCost += $detail->vat_cost * $detail->qty_received;
                }

                $averageServiceLevel = $totalItems > 0 ? $totalServiceLevel / $totalItems : 0;

                $rcvHead->update([
                    'average_service_level' => $averageServiceLevel,
                    'sub_total' => $subTotal,
                    'sub_total_vat_cost' => $subTotalVatCost,
                ]);

                // Log activity for updating average service level
                activity()
                    ->performedOn($rcvHead)
                    ->log('Updated average service level for RcvHead');

                $this->updateOrderStatus($dataGroup[0]->order_no, $averageServiceLevel, $dataGroup[0]->receive_date);
            }

            DB::table('temp_rcv')->truncate();
            DB::commit(); // Commit transaction

        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback transaction on error
            throw $th;
        }
    }

    private function prepareRcvHeadData($dataGroup)
    {
        return [
            "receive _date" => $dataGroup[0]->receive_date,
            "created_date" => $dataGroup[0]->created_date,
            "receive_id" => $dataGroup[0]->receive_id,
            "order_no" => $dataGroup[0]->order_no,
            "ref_no" => $dataGroup[0]->ref_no,
            "order_type" => $dataGroup[0]->order_type ,
            "status_ind" => $dataGroup[0]->status_ind,
            "approval_date" => $dataGroup[0]->approval_date,
            "approval_id" => $dataGroup[0]->approval_id,
            "store" => $dataGroup[0]->store,
            "store_name" => $dataGroup[0]->store_name,
            "supplier" => $dataGroup[0]->supplier,
            "sup_name" => $dataGroup[0]->sup_name,
            'status' => 'n',
            "comment_desc" => $dataGroup[0]->comment_desc,
        ];
    }

    private function updateOrderStatus($orderNo, $averageServiceLevel, $receiveDate)
    {
        $podata = $this->ordHeadRepository->where('order_no', $orderNo)->first();

        if ($podata != null) {
            if ($averageServiceLevel == 100) {
                $podata->update([
                    'status' => 'Completed',
                    'estimated_delivery_date' => $receiveDate,
                ]);
            } else {
                $podata->update([
                    'status' => 'Incompleted',
                    'estimated_delivery_date' => $receiveDate,
                ]);
            }

            // Log activity for updating order status
            activity()
                ->performedOn($podata)
                ->log($averageServiceLevel == 100 ? 'Updated order status to Completed' : 'Updated order status to Incompleted');
        }
    }
}
