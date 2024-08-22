<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Models\OrdHead;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PoController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(){

        return view('po.index');
    }


    public function data(Request $request)
    {
        try {
            $search = $request->all();

            $user = Auth::user();

            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            if (isset($search['menu']) && $search['menu'] == "dashboard") {
                $approval_date = $request->approval_date;
                $statusPo = $search['statusPo'];
            } else {
                $approval_date = null;
                $statusPo = null;
            }

            $orderData = $this->orderService->getOrderData(null,null,null,null);

            return DataTables::of($orderData)->make(true);

        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle exceptions
            return ResponseJson::response('Order not found', 'error', $e->getMessage(), 500);
        }
    }

    public function show($order_no)
    {
        try {
            // Fetch the order with its details
            $order = OrdHead::with('ordDetail','suppliers','stores')->where('order_no', $order_no)->first();

            // Check if the order exists
            if (!$order) {
                return ResponseJson::response('Order not found', 'error', [], 404);
            }

            // Return a successful response with the order data
            return ResponseJson::response('Order is available', 'success', $order->toArray(), 200);

        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            \Log::error("Error fetching order: " . $e->getMessage());

            // Return a generic error message
            return ResponseJson::response('An error occurred while retrieving the order', 'error', [], 500);
        }
    }

    // public function print($order_no)
    // {
    //     try {
    //         // Your code to fetch data
    //         $printHistory = PrintPo::with('user')->where('order_no', $order_no)->get();

    //         if (Auth::user()->hasRole('supplier')) {
    //             Ordhead::where('order_no', $order_no)->update(['status' => 'Printed']);
    //             // Return a success response specifically for suppliers
    //             return response()->json([
    //                 'success' => true,
    //                 'data' => [],
    //                 'icon' => 'success',
    //                 'message' => 'Status updated successfully for supplier.',
    //             ]);
    //         }

    //         // Return a success response with data for other roles
    //         return response()->json([
    //             'success' => true,
    //             'data' => $printHistory,
    //             'icon' => 'success',
    //             'message' => 'Print history data fetched successfully.',
    //         ]);
    //     } catch (\Exception $e) {
    //         // Return an error response in case of exception
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred while fetching data.',
    //             'error' => $e->getMessage(), // Optionally include the error message for debugging
    //         ], 500);
    //     }
    // }



    // public function pdf(Request $request)
    // {
    //     $user = Auth::user();
    //     $settingsUser = $user->settings_user;

    //     $getHeadId = OrdHead::with('store', 'ordDetail')->where('order_no', $request->id)->first();
    //     if (!$getHeadId) {
    //         return response()->json(['message' => 'Order not found.', 'status' => 'error'], 404);
    //     }

    //     $supplier = Supplier::where('supp_code', $getHeadId->supplier)->first();
    //     $systemVariable = SystemVariable::first();

    //     $data = [
    //         'title' => $getHeadId->order_no,
    //         'order_no' => $getHeadId->order_no,
    //         'ship_to' => $getHeadId->ship_to,
    //         'supplier' => $getHeadId->supplier,
    //         'supp_name' => optional($supplier)->supp_name,
    //         'contact_name' => optional($supplier)->contact_name,
    //         'contact_phone' => optional($supplier)->contact_phone,
    //         'contact_fax' => optional($supplier)->contact_fax,
    //         'address_1' => optional($supplier)->address_1,
    //         'terms' => $getHeadId->terms,
    //         'print_date' => now()->format('d-M-y'),
    //         'cetak_vega' => (new DateTime($getHeadId->created_at))->format('d-M-y'),
    //         'order_date' => Carbon::parse($getHeadId->written_date)->format('d-M-y'),
    //         'delivery_before' => Carbon::parse($getHeadId->not_before_date)->format('d-M-y'),
    //         'expired_po' => Carbon::parse($getHeadId->not_after_date)->format('d-M-y'),
    //         'po_note' => $systemVariable->po_note,
    //         'fax_note' => $systemVariable->fax_note,
    //         'comment' => $getHeadId->comment_desc,
    //         'total_cost' => $getHeadId->total_cost,
    //         'total_discount' => $getHeadId->total_discount,
    //         'company' => $systemVariable->company,
    //         'govt_tax_no' => $systemVariable->govt_tax_no,
    //         'detail_order' => $getHeadId->ordDetail->toArray(),
    //         'store_name' => optional($getHeadId->store)->store_name,
    //         'store_add1' => optional($getHeadId->store)->store_add1,
    //         'store_add2' => optional($getHeadId->store)->store_add2,
    //     ];

    //     $printPoCount = PrintPo::where('user_id', $user->id)->where('order_no', $request->id)->count();
    //     $data['cetakanKeBerapa'] = PrintPo::where('user_id', $user->id)->where('order_no', $request->id)->count();
    //     if (Auth::user()->hasRole('supplier')) {
    //         Ordhead::where('order_no',  $request->id)->update(['status' => 'Printed']);
    //     }
    //     if ($settingsUser != null && $printPoCount <= $settingsUser->po_print) {
    //         PrintPo::create([
    //             'user_id' => $user->id,
    //             'order_no' => $request->id,
    //             'description' => 'Print PO tanggal ' . now(),
    //         ]);

    //         return PDF::loadView('po.export', $data)->setPaper('a4', 'landscape')->stream();
    //     } elseif ($settingsUser == null) {
    //         // User settings not found
    //         PrintPo::create([
    //             'user_id' => $user->id,
    //             'order_no' => $request->id,
    //             'description' => 'Print PO tanggal ' . now(),
    //         ]);

    //         return PDF::loadView('po.export', $data)->setPaper('a4', 'landscape')->stream();
    //     }
    // }


    // public function confirmPo(Request $request){
    //     try {
    //         DB::beginTransaction();

    //         // Your code to handle the request goes here
    //         $id = $request->input('id');
    //         $estimatedDeliveryDate = $request->input('estimatedDeliveryDate');

    //         $orderIds = $request->input('order_id');
    //         $qtyFulfilled = $request->input('qty_fulfilled');

    //         if($request->reason == null){
    //                // Update the estimated_delivery_date in the ordHead table
    //             OrdHead::where('id', $id)
    //             ->update([
    //                 'estimated_delivery_date' => $estimatedDeliveryDate,
    //                 'status' => 'Confirmed'
    //             ]);
    //         }else{
    //             OrdHead::where('id', $id)
    //             ->update([
    //                 'status' => 'Reject',
    //                 'reason' => $request->reason
    //             ]);
    //         }


    //         foreach ($orderIds as $key => $orderId) {
    //             // Get the corresponding qty_fulfilled value
    //             $qtyFulfilledValue = $qtyFulfilled[$key];

    //             // Update the qty_fulfilled in the ordDetail table
    //             OrdSku::where('id', $orderId)
    //                 ->update(['qty_fulfilled' => $qtyFulfilledValue]);
    //         }

    //         DB::commit();

    //         return response()->json(['message' => 'Po updated successfully', 'success' => true], 200);

    //     } catch (\Exception $e) {
    //         // If an exception occurs, rollback the transaction
    //         // DB::rollBack();
    //         return $e->getMessage();

    //         // Log the exception or handle it as needed
    //         \Log::error('Error occurred in confirmPo method: ' . $e->getMessage());

    //         // Return a response indicating the error
    //         return response()->json(['error' => 'An error occurred while processing your request.'], 500);
    //     }
    // }


    // public function store(Request $request)
    // {
    //     $data = $request->all();
    //     try {
    //         // Begin transaction
    //         // DB::beginTransaction();

    //         // Chunk data to process in smaller batches
    //         $chunkSize = 100; // Adjust the chunk size as needed
    //         foreach (array_chunk($data, $chunkSize) as $chunk) {
    //             // Process each chunk
    //             foreach ($chunk as $dataOrder) {
    //                 $ordHead = OrdHead::updateOrCreate(
    //                     // Conditions to find the record (based on unique keys, e.g., 'order_no')
    //                     [
    //                         'id' => $dataOrder['id'],
    //                         'order_no' => $dataOrder['order_no'],
    //                     ],
    //                     // Data to update or create the record
    //                     [
    //                         'ship_to' => $dataOrder['ship_to'],
    //                         'supplier' => $dataOrder['supplier'],
    //                         'terms' => $dataOrder['terms'],
    //                         'status_ind' => $dataOrder['status_ind'],
    //                         'written_date' => $dataOrder['written_date'],
    //                         'not_before_date' => $dataOrder['not_before_date'],
    //                         'not_after_date' => $dataOrder['not_after_date'],
    //                         'approval_date' => $dataOrder['approval_date'],
    //                         'approval_id' => $dataOrder['approval_id'],
    //                         'cancelled_date' => $dataOrder['cancelled_date'],
    //                         'canceled_id' => $dataOrder['canceled_id'],
    //                         'cancelled_amt' => $dataOrder['cancelled_amt'],
    //                         'total_cost' => $dataOrder['total_cost'],
    //                         'total_retail' => $dataOrder['total_retail'],
    //                         'outstand_cost' => $dataOrder['outstand_cost'],
    //                         'total_discount' => $dataOrder['total_discount'],
    //                         'comment_desc' => $dataOrder['comment_desc'],
    //                         'buyer' => $dataOrder['buyer'],
    //                         'status' => 'Progress',
    //                         // Add other fields
    //                     ]
    //                 );

    //                 foreach ($dataOrder['ord_detail'] as $item) {
    //                     OrdSku::updateOrCreate(
    //                         [
    //                             'ordhead_id' => $ordHead->id,
    //                             'sku' => $item['sku'],
    //                             'order_no' => $item['order_no']
    //                         ],
    //                         [
    //                             'sku_desc' => $item['sku_desc'],
    //                             'upc' => $item['upc'],
    //                             'tag_code' => $item['tag_code'],
    //                             'unit_cost' => $item['unit_cost'],
    //                             'unit_retail' => $item['unit_retail'],
    //                             'vat_cost' => $item['vat_cost'],
    //                             'luxury_cost' => $item['luxury_cost'],
    //                             'qty_ordered' => $item['qty_ordered'],
    //                             'qty_received' => $item['qty_received'],
    //                             'unit_discount' => $item['unit_discount'],
    //                             'unit_permanent_discount' => $item['unit_permanent_discount'],
    //                             'purchase_uom' => $item['purchase_uom'],
    //                             'supp_pack_size' => $item['supp_pack_size'],
    //                             'permanent_disc_pct' => $item['permanent_disc_pct'],
    //                             // Add other fields
    //                         ]
    //                     );
    //                 }
    //                 $supplierNo = (string) $ordHead->supplier;

    //                 $emailSupplier = User::where('username','=',$supplierNo)->get();
    //                 if(count($emailSupplier) > 0){
    //                     foreach($emailSupplier as $key => $value){
    //                         $dataOrder['supplier_email'] = $value->email;
    //                         $dataOrder['supplier_name'] = $value->name;
    //                         $dataOrder['download_link'] = env('APP_URL')."/po/pdf?id=".$dataOrder['order_no'];
    //                         event(new OrderStoredEvent($dataOrder));
    //                     }
    //                 }
    //             }
    //         }

    //         // Commit transaction
    //         // DB::commit();

    //         // Return success response
    //         return response()->json([
    //             'message' => 'Data po stored successfully',
    //             'title'=>'Po stored success',
    //         ]);
    //     } catch (Exception $e) {
    //         dd($e->getMessage());
    //         // Rollback transaction on error
    //         // DB::rollBack();

    //         // Log or handle the exception
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    // public function delete(Request $request){
    //     try {
    //         $this->orderService->delete($request->order_no);
    //         return response()->json(['message' => 'PO deleted successfully'], 200);
    //     } catch (\Exception $e) {
    //         // Handle the exception
    //         // Log the error, return a custom error message, or perform any other action as needed

    //         // Example of logging the error:
    //         // Log::error('Error deleting PO: ' . $e->getMessage());

    //         // Return an error response
    //         return response()->json(['error' => 'Failed to delete PO'], 500);
    //     }
    // }

    // public function deleteSku(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();

    //         // Find the OrdSku record by ID
    //         $sku = OrderSkuService::findById($request->id);

    //         if ($sku) {
    //             // Store the order number before deleting the record
    //             $orderNo = $sku->order_no;

    //             // Delete the OrdSku record
    //             $sku->delete();

    //             DB::commit();

    //             // Retrieve the OrdHead record using the stored order number
    //             $ordHead = OrdHead::where('order_no', $orderNo)->first();

    //             if ($ordHead) {
    //                 // Convert the OrdHead record to an array
    //                 $ordHeadArray = $ordHead->toArray();

    //                 return ResponseJson::response('OrdSku deleted successfully', 'success', $ordHeadArray, 200);
    //             } else {
    //                 return ResponseJson::response('OrdHead not found', 'error', [], 404);
    //             }
    //         } else {
    //             // If the record is not found, return an error response
    //             return ResponseJson::response('OrdSku not found', 'error', [], 404);
    //         }

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logMessage('Failed to delete OrdSku', 'error', [
    //             'user' => Auth::user()->name,
    //             'message' => $e->getMessage(),
    //         ]);

    //         $errorResponse = [
    //             'message' => $e->getMessage(),
    //             'e'=>$e,
    //         ];

    //         return ResponseJson::response('Failed to delete OrdSku', 'error', $errorResponse, 500);
    //     }
    // }


}
