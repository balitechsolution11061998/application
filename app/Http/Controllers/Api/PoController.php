<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiffCostPo;
use App\Models\OrdHead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity; // Import the Activity model

class PoController extends Controller
{

    public function getData(Request $request)
    {
        $user = Auth::user();
        
        activity()
            ->on(new OrdHead())
            ->by($user)
            ->withProperties(['filter_date' => $request->filterDate])
            ->log('Attempting to fetch PO data');

        try {
            $approval_date = $request->filterDate;
            $orders = [];
            $count = 0;

            OrdHead::with(['ordsku', 'stores', 'suppliers'])
                ->where('approval_date', $approval_date)
                ->chunk(100, function ($chunk) use (&$orders, &$count, $user) {
                    foreach ($chunk as $order) {
                        $orders[] = $order;
                        $count++;
                        
                        // Log each order retrieval
                        activity()
                            ->on($order)
                            ->by($user)
                            ->log('Retrieved order data for order: ' . $order->order_no);
                    }
                });

            activity()
                ->on(new OrdHead())
                ->by($user)
                ->withProperties(['count' => $count])
                ->log('Successfully fetched ' . $count . ' orders');

            return response()->json([
                'title' => 'Sync PO Successfully',
                'message' => 'Data Order Found',
                'data' => $orders,
                'count' => $count,
                'success' => true
            ]);

        } catch (\Exception $e) {
            $errorMessage = substr($e->getMessage(), 0, 200);
            
            activity()
                ->on(new OrdHead())
                ->by($user)
                ->withProperties(['error' => $errorMessage])
                ->log('Failed to fetch PO data: ' . $errorMessage);

            return response()->json([
                'title' => 'Error',
                'message' => 'Failed to load data order',
                'error' => $errorMessage,
                'success' => false
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $successCount = 0;
        $failCount = 0;
        $totalPo = 0;
        $errors = [];
        $historyMessage = '';
        $user = Auth::user();

        // Log start of batch processing
        activity()
            ->on(new DiffCostPo())
            ->by($user)
            ->withProperties(['batch_size' => count($request->all())])
            ->log('Starting batch PO processing');

        DB::beginTransaction();

        try {
            $requestData = $request->all();
            $chunkSize = 1000;

            // Log temp table clearing
            activity()
                ->on(new DiffCostPo())
                ->by($user)
                ->log('Clearing temp_po table before processing');

            DB::table('temp_po')->truncate();

            // Process data chunks
            foreach (array_chunk($requestData, $chunkSize) as $chunkIndex => $chunk) {
                try {
                    DB::table('temp_po')->upsert(
                        $chunk,
                        ['order_no', 'ship_to', 'supplier', 'sku'],
                        ['unit_cost', 'qty_ordered', 'qty_received']
                    );

                    // Log successful chunk processing
                    activity()
                        ->on(new DiffCostPo())
                        ->by($user)
                        ->withProperties([
                            'chunk_index' => $chunkIndex,
                            'chunk_size' => count($chunk)
                        ])
                        ->log('Successfully processed chunk ' . ($chunkIndex + 1));

                } catch (\Exception $e) {
                    $errorMessage = substr($e->getMessage(), 0, 200);

                    activity()
                        ->on(new DiffCostPo())
                        ->by($user)
                        ->withProperties([
                            'chunk_index' => $chunkIndex,
                            'error' => $errorMessage
                        ])
                        ->log('Failed to process chunk ' . ($chunkIndex + 1));

                    throw $e;
                }
            }

            $datas = collect(DB::table('temp_po')->get())->groupBy('order_no');
            $totalPo = $datas->count();

            // Log total orders found
            activity()
                ->on(new DiffCostPo())
                ->by($user)
                ->withProperties(['total_orders' => $totalPo])
                ->log('Found ' . $totalPo . ' orders to process');

            foreach ($datas as $orderNo => $data) {
                $firstItem = $data->first();
                
                try {
                    // Log start of order processing
                    activity()
                        ->on(new DiffCostPo())
                        ->by($user)
                        ->withProperties(['order_no' => $orderNo])
                        ->log('Starting processing for order: ' . $orderNo);

                    $diffCost = $this->findCostDifferences($data, $orderNo);
                    $ordheadId = $this->processOrderHeader($data, $firstItem);
                    $this->processOrderItems($data, $ordheadId, $firstItem->supplier);

                    if ($diffCost->isNotEmpty()) {
                        $this->handlePriceDifferences($diffCost, $user, $firstItem, $errors);
                        $historyMessage = 'Price differences found';
                        $successCount++;
                    } else {
                        $historyMessage = 'Success';
                        $successCount++;
                    }

                    // Log successful order processing
                    activity()
                        ->on(new DiffCostPo())
                        ->by($user)
                        ->withProperties([
                            'order_no' => $orderNo,
                            'status' => $historyMessage
                        ])
                        ->log('Completed processing for order: ' . $orderNo);

                } catch (\Exception $e) {
                    $failCount++;
                    $errorMessage = substr($e->getMessage(), 0, 200);
                    $errors[] = [
                        'order_no' => $orderNo,
                        'message' => $errorMessage
                    ];

                    // Log order processing failure
                    activity()
                        ->on(new DiffCostPo())
                        ->by($user)
                        ->withProperties([
                            'order_no' => $orderNo,
                            'error' => $errorMessage
                        ])
                        ->log('Failed to process order: ' . $orderNo);
                    
                    continue;
                }

                DB::table('upload_history')->insert([
                    'order_no' => $orderNo,
                    'status' => $historyMessage,
                    'message' => json_encode($errors),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            // Log successful batch completion
            activity()
                ->on(new DiffCostPo())
                ->by($user)
                ->withProperties([
                    'success_count' => $successCount,
                    'fail_count' => $failCount
                ])
                ->log('Successfully completed batch processing');

        } catch (\Exception $e) {
            DB::rollBack();
            $failCount = $totalPo;
            $errorMessage = substr($e->getMessage(), 0, 200);
            $errors[] = ['order_no' => 'batch', 'message' => $errorMessage];

            // Log batch failure
            activity()
                ->on(new DiffCostPo())
                ->by($user)
                ->withProperties([
                    'error' => $errorMessage,
                    'total_orders' => $totalPo
                ])
                ->log('Batch processing failed: ' . $errorMessage);
        }

        DB::table('temp_po')->truncate();

        // Log final cleanup
        activity()
            ->on(new DiffCostPo())
            ->by($user)
            ->log('Cleaned up temp_po table after processing');

        return response()->json([
            'status' => $failCount > 0 ? 'partial' : 'success',
            'message' => $failCount > 0 ? 'Some orders failed to process' : 'All orders processed successfully',
            'success_upload' => $successCount,
            'fail_upload' => $failCount,
            'total_po' => $totalPo,
            'differentMessage' => $errors,
            'different_count' => count($errors),
        ]);
    }
    
    // Helper method to find cost differences
    protected function findCostDifferences($data, $orderNo)
    {
        return DB::table('temp_po as a')
            ->distinct()
            ->select(
                'a.order_no',
                'a.supplier',
                'b.sup_name',
                'a.sku',
                'a.sku_desc',
                'a.unit_cost as cost_po',
                'b.unit_cost as cost_supplier'
            )
            ->join('item_supplier as b', function($join) {
                $join->on('a.supplier', '=', 'b.supplier')
                     ->on('a.sku', '=', 'b.sku');
            })
            ->where(function($query) {
                $query->whereRaw('FLOOR(a.unit_cost * 100) / 100 != FLOOR(b.unit_cost * 100) / 100')
                      ->orWhereNull('b.unit_cost');
            })
            ->where('a.order_no', $orderNo)
            ->get();
    }
    
    // Helper method to process order header
    protected function processOrderHeader($data, $firstItem)
    {
        $status = $this->determineOrderStatus($firstItem);
        
        $dataOrder = [
            "order_no" => $firstItem->order_no,
            "ship_to" => $firstItem->ship_to,
            "supplier" => $firstItem->supplier,
            "terms" => $firstItem->terms,
            "status_ind" => $firstItem->status_ind,
            "written_date" => $firstItem->written_date,
            "not_before_date" => $firstItem->not_before_date,
            "not_after_date" => $firstItem->not_after_date,
            "approval_date" => $firstItem->approval_date,
            "approval_id" => $firstItem->approval_id,
            "cancelled_date" => $firstItem->cancelled_date,
            "canceled_id" => $firstItem->canceled_id,
            "cancelled_amt" => $firstItem->cancelled_amt,
            "total_cost" => $firstItem->total_cost,
            "total_retail" => $firstItem->total_retail,
            "outstand_cost" => $firstItem->outstand_cost,
            "total_discount" => $firstItem->total_discount,
            "comment_desc" => $firstItem->comment_desc,
            "buyer" => $firstItem->buyer,
            "status" => $status,
        ];
    
        // First try to find existing record
        $existingRecord = DB::table('ordhead')
            ->where('order_no', $firstItem->order_no)
            ->first();
    
        if ($existingRecord) {
            DB::table('ordhead')
                ->where('id', $existingRecord->id)
                ->update($dataOrder);
            return $existingRecord->id;
        } else {
            return DB::table('ordhead')->insertGetId($dataOrder);
        }
    }
    
    // Helper method to determine order status
    protected function determineOrderStatus($item)
    {
        if ($item->status_ind == 15 && $item->cancelled_date) {
            return 'Canceled';
        } elseif ($item->status_ind == 20) {
            return 'Completed';
        }
        return 'Progress';
    }
    
    // Helper method to process order items
    protected function processOrderItems($data, $ordheadId, $supplier)
    {
        foreach ($data as $detail) {
            $itemSupplier = DB::table('item_supplier')
                ->where('supplier', $supplier)
                ->where('sku', $detail->sku)
                ->first();
    
            $ordSkuData = [
                "ordhead_id" => $ordheadId,
                "order_no" => $detail->order_no,
                "sku" => $detail->sku,
                "sku_desc" => $detail->sku_desc,
                "upc" => $detail->upc,
                "tag_code" => $detail->tag_code,
                "unit_cost" => $itemSupplier->unit_cost ?? $detail->unit_cost,
                "unit_retail" => $detail->unit_retail,
                "vat_cost" => $detail->vat_cost,
                "luxury_cost" => $detail->luxury_cost,
                "qty_ordered" => ($itemSupplier && $itemSupplier->unit_cost != $detail->unit_cost) 
                    ? 0 : $detail->qty_ordered,
                "qty_received" => $detail->qty_received,
                "unit_discount" => $detail->unit_discount,
                "unit_permanent_discount" => $detail->unit_permanent_discount,
                "purchase_uom" => $detail->purchase_uom,
                "supp_pack_size" => $detail->supp_pack_size,
                "permanent_disc_pct" => $detail->permanent_disc_pct,
            ];
    
            DB::table('ordsku')->updateOrInsert(
                [
                    "order_no" => $detail->order_no,
                    "sku" => $detail->sku,
                    "upc" => $detail->upc
                ],
                $ordSkuData
            );
        }
    }
    
    // Helper method to handle price differences
    protected function handlePriceDifferences($diffCost, $user, $firstItem, &$errors)
    {
        foreach ($diffCost as $detail) {
            // Delete existing differences for this item
            DiffCostPo::where('order_no', $detail->order_no)
                ->where('supplier', $detail->supplier)
                ->where('sku', $detail->sku)
                ->delete();
    
            // Create new difference record
            DiffCostPo::create([
                'order_no' => $detail->order_no,
                'supplier' => $detail->supplier,
                'sup_name' => $detail->sup_name,
                'sku' => $detail->sku,
                'sku_desc' => $detail->sku_desc,
                'cost_po' => $detail->cost_po,
                'cost_supplier' => $detail->cost_supplier,
            ]);
    
            $errors[] = [
                'supplier' => $firstItem->supplier,
                'sup_name' => $detail->sup_name,
                'order_no' => $firstItem->order_no,
                'sku' => $detail->sku,
                'sku_desc' => $detail->sku_desc,
                'message' => 'Price differences found. Old price: ' . $detail->cost_supplier . ', New price: ' . $detail->cost_po,
                'cost_supplier' => $detail->cost_supplier,
                'cost_po' => $detail->cost_po,
            ];
    
            // Log price difference activity
            activity()
                ->on(new DiffCostPo())
                ->by($user)
                ->withProperties([
                    'order_no' => $detail->order_no,
                    'sku' => $detail->sku,
                    'old_price' => $detail->cost_supplier,
                    'new_price' => $detail->cost_po
                ])
                ->log("Price difference detected for SKU {$detail->sku} in order {$detail->order_no}");
        }
    }
}
