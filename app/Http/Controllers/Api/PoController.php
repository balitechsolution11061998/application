<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderStoredEvent;
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
        // DB::beginTransaction();
        $successCount = 0;
        $failCount = 0;
        $totalPo = 0;
        $errors = [];
        try {
            $user = Auth::user();


            $requestData = $request->all();
            $chunkSize = 500;

            // Store data to temp_po table
            foreach (array_chunk($requestData, $chunkSize) as $chunk) {
                DB::table('temp_po')->insert($chunk);
            }


            $poNotExists = DB::select("
                SELECT * FROM temp_po a
            ");

            $datas = collect($poNotExists);
            $totalPo = count($datas);
            foreach ($datas->groupBy('order_no') as $data) {
                $diffCost = DB::table('temp_po as a')
                    ->select('a.order_no', 'a.supplier', 'b.sup_name', 'a.sku', 'a.sku_desc', 'a.unit_cost as cost_po', 'b.unit_cost as cost_supplier')
                    ->join('item_supplier as b', function ($join) {
                        $join->on('a.supplier', '=', 'b.supplier')
                            ->on('a.sku', '=', 'b.sku');
                    })
                    ->where(function ($query) use ($data) {
                        $query->where('a.unit_cost', '!=', DB::raw('b.unit_cost'))
                            ->orWhereNull('b.unit_cost');
                    })
                    ->where('a.order_no', $data[0]->order_no)
                    ->get();

                if (collect($diffCost)->count() == 0) {
                    // Prepare the order header data
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
                        "buyer" => $datas[0]->buyer,
                        "status" => "Progress",
                    ];
                    // Define the unique attributes to check for an existing record
                    $uniqueAttributes = [
                        "order_no" => $data[0]->order_no
                    ];

                    // Use updateOrInsert to either update or insert the record

                    $existingRecord = DB::table('ordhead')->where($uniqueAttributes)->first();

                    if ($existingRecord) {
                        // If the record exists, update it and get the ID
                        DB::table('ordhead')->where('id', $existingRecord->id)->update($dataOrder);
                        $ordheadId = $existingRecord->id;
                    } else {
                        // If the record doesn't exist, insert a new one and get the ID
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

                        $uniqueAttributes = [
                            "order_no" => $detail->order_no,
                            "sku" => $detail->sku,
                            "upc" => $detail->upc
                        ];

                        DB::table('ordsku')->updateOrInsert(
                            $uniqueAttributes,
                            $ordSkuData
                        );

                        $dataOrder['ord_detail'][] = $ordSkuData;
                    }

                    // Sending email to the supplier
                    $supplierNo = (string) $data[0]->supplier;
                    $emailSupplier = User::where('username', '=', $supplierNo)->get();

                    if ($emailSupplier->count() > 0) {
                        foreach ($emailSupplier as $key => $value) {
                            $dataOrder['order_no'] = $data[0]->order_no;
                            $dataOrder['supplier_email'] = $value->email;
                            $dataOrder['supplier_name'] = $value->name;
                            $dataOrder['download_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;
                            $dataOrder['detail_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;


                            event(new OrderStoredEvent($dataOrder));
                        }
                    }
                } else if (collect($diffCost)->count() > 0) {
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
                        "buyer" => $datas[0]->buyer,
                        "status" => "Progress",
                    ];

                    // Define the unique attributes to check for an existing record
                    $uniqueAttributes = [
                        "order_no" => $data[0]->order_no
                    ];

                    // Use updateOrInsert to either update or insert the record
                    $existingRecord = DB::table('ordhead')->where($uniqueAttributes)->first();

                    if ($existingRecord) {
                        // If the record exists, update it and get the ID
                        DB::table('ordhead')->where('id', $existingRecord->id)->update($dataOrder);
                        $ordheadId = $existingRecord->id;
                    } else {
                        // If the record doesn't exist, insert a new one and get the ID
                        $ordheadId = DB::table('ordhead')->insertGetId(array_merge($uniqueAttributes, $dataOrder));
                    }

                    // Get the cost differences
                    $diffCost = DB::table('temp_po as a')
                        ->select('a.order_no', 'a.supplier', 'b.sup_name', 'a.sku', 'a.sku_desc', 'a.unit_cost as cost_po', 'b.unit_cost as cost_supplier')
                        ->join('item_supplier as b', function ($join) {
                            $join->on('a.supplier', '=', 'b.supplier')
                                ->on('a.sku', '=', 'b.sku');
                        })
                        ->where(function ($query) use ($data) {
                            $query->where('a.unit_cost', '!=', DB::raw('b.unit_cost'))
                                ->orWhereNull('b.unit_cost');
                        })
                        ->where('a.order_no', $data[0]->order_no)
                        ->get();

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

                        $uniqueAttributes = [
                            "order_no" => $detail->order_no,
                            "sku" => $detail->sku,
                            "upc" => $detail->upc
                        ];

                        // Check if the cost_supplier differs from unit_cost
                        $diffCostItem = $diffCost->firstWhere('sku', $detail->sku);
                        if ($diffCostItem && $diffCostItem->cost_supplier != $detail->unit_cost) {
                            $ordSkuData['qty_ordered'] = 0; // Set qty_ordered to 0 if costs are different
                        }

                        DB::table('ordsku')->updateOrInsert($uniqueAttributes, $ordSkuData);

                        $dataOrder['ord_detail'][] = $ordSkuData;
                    }

                    // Sending email to the supplier
                    $supplierNo = (string) $data[0]->supplier;
                    $emailSupplier = User::where('username', '=', $supplierNo)->get();
                    foreach ($diffCost as $detail) {
                        DiffCostPo::where('order_no', $detail->order_no)
                            ->where('supplier', $detail->supplier)
                            ->where('sku', $detail->sku)
                            ->delete();

                        DiffCostPo::create((array) $detail);
                    }
                    if ($emailSupplier->count() > 0) {
                        foreach ($emailSupplier as $key => $value) {
                            $dataOrder['order_no'] = $data[0]->order_no;
                            $dataOrder['supplier_email'] = $value->email;
                            $dataOrder['supplier_name'] = $value->name;
                            $dataOrder['download_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;
                            $dataOrder['detail_link'] = env('APP_URL') . "/po/pdf?id=" . $data[0]->order_no;

                            event(new OrderStoredEvent($dataOrder));
                        }
                    }
                } else {
                    // Insert into DiffCostPo table
                    foreach ($diffCost as $detail) {
                        DiffCostPo::where('order_no', $detail->order_no)
                            ->where('supplier', $detail->supplier)
                            ->where('sku', $detail->sku)
                            ->delete();

                        DiffCostPo::create((array) $detail);
                    }
                }
                            $successCount++;

            }
            // Truncate temp_po table
            DB::table('temp_po')->truncate();



        } catch (\Throwable $th) {
            dd($th->getMessage());
            // Save error log
            DB::table('order_log')->insert([
                'order_no' => $request->order_no ?? null,
                'status' => 'error',
                'message' => $th->getMessage(),
                'created_at' => now(),
            ]);

            $failCount++;
            $errors[] = $th->getMessage();
        }
        return response()->json([
            'success' => true,
            'message' => 'Success release Order',
            // 'diffCost' => $diffCost,
            'total'=>$totalPo,
            'successCount' => $successCount,
            'failCount' => $failCount,
            'errors' => $errors
        ]);
    }
}
