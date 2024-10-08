<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiffCostPo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PoController extends Controller
{
    //
    public function store(Request $request)
    {
        $successCount = 0;
        $failCount = 0;
        $totalPo = 0;
        $errors = [];
        $historyMessage = '';

        try {
            $user = Auth::user();
            $requestData = $request->all();
            $chunkSize = 500;

            // Store data to temp_po table
            foreach (array_chunk($requestData, $chunkSize) as $chunk) {
                DB::table('temp_po')->insert($chunk);
            }

            // Select data from temp_po
            $poNotExists = DB::select("SELECT * FROM temp_po");
            $datas = collect($poNotExists);
            $totalPo = $datas->groupBy('order_no')->count();

            foreach ($datas->groupBy('order_no') as $data) {
                // Retrieve cost differences
                // $diffCost = DB::table('temp_po as a')
                //     ->distinct()
                //     ->select('a.order_no', 'a.supplier', 'b.sup_name', 'a.sku', 'a.sku_desc', 'a.unit_cost as cost_po', 'b.unit_cost as cost_supplier')
                //     ->join('item_supplier as b', function ($join) {
                //         $join->on('a.supplier', '=', 'b.supplier')
                //             ->on('a.sku', '=', 'b.sku');
                //     })
                //     ->where(function ($query) use ($data) {
                //         $query->whereRaw('FLOOR(a.unit_cost * 100) / 100 != FLOOR(b.unit_cost * 100) / 100')
                //               ->orWhereNull('b.unit_cost');
                //     })
                //     ->where('a.order_no', $data[0]->order_no)
                //     ->get();
                $diffCost = DB::table('temp_po as a')
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
                    ->join('item_supplier as b', function ($join) {
                        $join->on('a.supplier', '=', 'b.supplier')
                            ->on('a.sku', '=', 'b.sku');
                    })
                    ->where(function ($query) use ($data) {
                        $query->whereRaw('FLOOR(a.unit_cost * 100) / 100 != FLOOR(b.unit_cost * 100) / 100')
                            ->orWhereNull('b.unit_cost');
                    })
                    ->where('a.order_no', $data[0]->order_no)
                    ->get();
                $uniqueAttributes = ["order_no" => $data[0]->order_no];

                $existingRecord = DB::table('ordhead')->where($uniqueAttributes)->first();

                $status = $existingRecord ? $existingRecord->status : "Progress";

                $dataOrder = [
                    "order_no" => $data[0]->order_no,
                    "ship_to" => $data[0]->ship_to,
                    "supplier" => $data[0]->supplier,
                    "terms" => $data[0]->terms,
                    "status_ind" => $data[0]->status_ind,
                    "written_date" => $data[0]->written_date,
                    "not_before_date" => $data[0]->not_before_date,
                    "not_after_date" => $data[0]->not_after_date,
                    "approval_date" => $data[0]->approval_date,
                    "approval_id" => $data[0]->approval_id,
                    "cancelled_date" => $data[0]->cancelled_date,
                    "canceled_id" => $data[0]->canceled_id,
                    "cancelled_amt" => $data[0]->cancelled_amt,
                    "total_cost" => $data[0]->total_cost,
                    "total_retail" => $data[0]->total_retail,
                    "outstand_cost" => $data[0]->outstand_cost,
                    "total_discount" => $data[0]->total_discount,
                    "comment_desc" => $data[0]->comment_desc,
                    "buyer" => $data[0]->buyer,
                    "status" => $status,
                ];



                if ($existingRecord) {
                    DB::table('ordhead')->where('id', $existingRecord->id)->update($dataOrder);
                    $ordheadId = $existingRecord->id;
                } else {
                    $ordheadId = DB::table('ordhead')->insertGetId(array_merge($uniqueAttributes, $dataOrder));
                }

                foreach ($data as $detail) {
                    $ordSkuData = [
                        "ordhead_id" => $ordheadId,
                        "order_no" => $detail->order_no,
                        "sku" => $detail->sku,
                        "sku_desc" => $detail->sku_desc,
                        "upc" => $detail->upc,
                        "tag_code" => $detail->tag_code,
                        "unit_cost" => $detail->unit_cost,
                        "unit_retail" => $detail->unit_retail,
                        "vat_cost" => $detail->vat_cost,
                        "luxury_cost" => $detail->luxury_cost,
                        "qty_ordered" => $detail->qty_ordered,
                        "qty_received" => $detail->qty_received,
                        "unit_discount" => $detail->unit_discount,
                        "unit_permanent_discount" => $detail->unit_permanent_discount,
                        "purchase_uom" => $detail->purchase_uom,
                        "supp_pack_size" => $detail->supp_pack_size,
                        "permanent_disc_pct" => $detail->permanent_disc_pct,
                    ];

                    // Check if there is a price difference
                    $itemSupplier = DB::table('item_supplier')->where('supplier', $detail->supplier)
                        ->where('sku', $detail->sku)
                        ->first();

                    if ($itemSupplier && $itemSupplier->unit_cost != $detail->unit_cost) {
                        // Update the quantity to 0 and unit cost to the price in item_supplier
                        $ordSkuData['qty_ordered'] = 0;
                        $ordSkuData['unit_cost'] = $itemSupplier->unit_cost;
                    }

                    $uniqueAttributes = [
                        "order_no" => $detail->order_no,
                        "sku" => $detail->sku,
                        "upc" => $detail->upc
                    ];

                    DB::table('ordsku')->updateOrInsert($uniqueAttributes, $ordSkuData);
                    $dataOrder['ord_detail'][] = $ordSkuData;
                }

                // Send email to the supplier
                // Send email to the supplier only if the PO does not exist
                if (!$existingRecord) {
                    $supplierNo = (string)$data[0]->supplier;
                    $emailSupplier = User::where('username', $supplierNo)->get();

                    if ($emailSupplier->count() > 0) {
                        foreach ($emailSupplier as $value) {
                            $dataOrder['order_no'] = $data[0]->order_no;
                            $dataOrder['supplier_email'] = $value->email;
                            $dataOrder['supplier_name'] = $value->name;
                            $dataOrder['download_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;
                            $dataOrder['detail_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;

                            // event(new OrderStoredEvent($dataOrder));
                        }


                    }
                }
                // $supplierNo = (string)$data[0]->supplier;
                // $emailSupplier = User::where('username', $supplierNo)->get();

                // if ($emailSupplier->count() > 0) {
                //     foreach ($emailSupplier as $value) {
                //         $dataOrder['order_no'] = $data[0]->order_no;
                //         $dataOrder['supplier_email'] = $value->email;
                //         $dataOrder['supplier_name'] = $value->name;
                //         $dataOrder['download_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;
                //         $dataOrder['detail_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;

                //         event(new OrderStoredEvent($dataOrder));
                //     }
                // }

                if (collect($diffCost)->count() > 0) {
                    // foreach ($diffCost as $detail) {
                    //     DiffCostPo::where('order_no', $detail->order_no)
                    //         ->where('supplier', $detail->supplier)
                    //         ->where('sku', $detail->sku)
                    //         ->delete();

                    //     DiffCostPo::create((array)$detail);

                    //     $errors[] = [
                    //         'order_no' => $data[0]->order_no,
                    //         'sku' => $data[0]->sku,
                    //         'message' => 'Price differences found.'
                    //     ];
                    //     $historyMessage = 'Price differences found';
                    // }

                    foreach ($diffCost as $detail) {
                        DiffCostPo::where('order_no', $detail->order_no)
                            ->where('supplier', $detail->supplier)
                            ->where('sku', $detail->sku)
                            ->delete();

                        DiffCostPo::create((array)$detail);

                        $errors[] = [
                            'supplier' => $data[0]->supplier,
                            'sup_name' => $detail->sup_name,
                            'order_no' => $data[0]->order_no,
                            'sku' => $detail->sku,
                            'sku_desc' => $detail->sku_desc,
                            'message' => 'Price differences found. Old price: ' . $detail->cost_supplier . ', New price: ' . $detail->cost_po,
                            'cost_supplier' => $detail->cost_supplier,
                            'cost_po' => $detail->cost_po,
                        ];
                        $historyMessage = 'Price differences found';
                    }


                    $successCount++;
                } else {
                    $historyMessage = 'Success';
                    $successCount++;
                }

                // Insert into upload history
                DB::table('upload_history')->insert([
                    'order_no' => $data[0]->order_no,
                    'status' => $historyMessage,
                    'message' => json_encode($errors)
                ]);
            }

            DB::table('temp_po')->truncate();
        } catch (\Exception $e) {
            $historyMessage = 'Error';
            $failCount++;
            $errors[] = [
                'order_no' => 'unknown',
                'message' => $e->getMessage()
            ];
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data uploaded successfully',
            'success_upload' => $successCount,
            'fail_upload' => $failCount,
            'total_po' => $totalPo,
            'differentMessage' => $errors,
            'different_count' => count($errors),
        ]);
    }
}
