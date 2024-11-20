<?php

namespace App\Http\Controllers;

use App\Helpers\SystemUsageHelper;
use App\Models\OrdHead;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        try {



            $data = $request->all(); // Get the orders array

            foreach ($data as $chunk) {
                // Call the orderService for each chunk
                $this->orderService->store($chunk);
            }

            // Return success response
            return response()->json([
                'message' => 'Data po stored successfully',
                'title' => 'Po stored success',
            ]);
        } catch (Exception $e) {
            // Log or handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function data(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Start timing and memory tracking
                $startTime = microtime(true);
                $startMemory = memory_get_usage();

                // Initialize an empty array to hold the results
                $result = collect();

                // Use chunking to process records in smaller batches
                DB::table('ordhead')
                    ->leftJoin('ordsku', 'ordsku.order_no', '=', 'ordhead.order_no')
                    ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
                    ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
                    ->select(
                        'ordhead.*',
                        'store.store as store',
                        'store.store_name as store_name',
                        'supplier.supp_code as supp_code',
                        'supplier.supp_name as supp_name',
                        'ordhead.not_after_date as expired_date',
                        'ordhead.approval_date as approval_date'
                    )
                    ->distinct()
                    ->orderBy('approval_date', 'desc')
                    ->chunk(1000, function ($chunk) use ($result) {
                        foreach ($chunk as $row) {
                            $result->push($row);
                        }
                    });


                // Prepare the data for DataTables
                $datatableResult = DataTables::of($result)
                    ->addColumn('action', function ($row) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-docs-datatable-subtable="expand_row">
                                    <span class="svg-icon fs-3 m-0 toggle-off">...</span>
                                    <span class="svg-icon fs-3 m-0 toggle-on">...</span>
                                </button>';
                    })
                    ->editColumn('total_cost', function ($row) {
                        return '$' . number_format($row->total_cost, 2);
                    })
                    ->editColumn('total_retail', function ($row) {
                        return '$' . number_format($row->total_retail, 2);
                    })
                    ->editColumn('supp_name', function ($row) {
                        return $row->supp_name ?? 'Not Found';
                    })
                    ->rawColumns(['status', 'action']) // Allow HTML rendering
                    ->make(true);

                // Log memory usage and load time using the helper function
                SystemUsageHelper::logUsage($startTime, $startMemory);

                // Return the result to DataTables
                return $datatableResult;
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching data. ' . $e->getMessage()], 500);
            }
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($order_no)
    {
        try {
            // Fetch order details with related store and supplier information
            $orderDetails = DB::table('ordhead')
                ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
                ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
                ->select(
                    'ordhead.*', // Select all columns from ordhead
                    'store.store as store_code',
                    'store.store_name as store_name',
                    'store.store_add1 as store_address',
                    'store.store_add2 as store_address1',
                    'store.store_city as store_city',
                    'store.latitude', // Include latitude
                    'store.longitude', // Include longitude
                    'supplier.supp_code as supplier_code',
                    'supplier.supp_name as supplier_name',
                    'supplier.contact_name as supplier_contact',
                    'supplier.contact_phone as supplier_phone',
                    'supplier.address_1 as supp_address',

                )
                ->where('ordhead.order_no', $order_no)
                ->first();

            // Fetch all order items (ordsku details)
            $orderItems = DB::table('ordsku')
                ->where('ordsku.order_no', $order_no)
                ->select(
                    'ordsku.id',
                    'ordsku.sku',
                    'ordsku.sku_desc',
                    'ordsku.upc',
                    'ordsku.tag_code',
                    'ordsku.unit_cost',
                    'ordsku.unit_retail',
                    'ordsku.vat_cost',
                    'ordsku.luxury_cost',
                    'ordsku.qty_ordered',
                    'ordsku.qty_fulfilled',
                    'ordsku.qty_received',
                    'ordsku.unit_discount',
                    'ordsku.unit_permanent_discount',
                    'ordsku.purchase_uom',
                    'ordsku.supp_pack_size',
                    'ordsku.permanent_disc_pct',
                    'ordsku.created_at',
                    'ordsku.updated_at'
                )
                ->get();

            // Check if the order exists
            if (!$orderDetails) {
                return response()->json([
                    'message' => 'Order not found.',
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            // Prepare response with order details and line items
            $response = [
                'order_details' => [
                    'orderDetails' => $orderDetails,
                    'store' => [
                        'store_code' => $orderDetails->store_code,
                        'store_name' => $orderDetails->store_name,
                        'store_address' => $orderDetails->store_address,
                        'store_address1' => $orderDetails->store_address1,
                        'store_city' => $orderDetails->store_city,
                        'latitude' => $orderDetails->latitude, // Add latitude
                        'longitude' => $orderDetails->longitude, // Add longitude
                    ],
                    'supplier' => [
                        'supplier_code' => $orderDetails->supplier_code,
                        'supplier_name' => $orderDetails->supplier_name,
                        'supplier_contact' => $orderDetails->supplier_contact,
                        'supplier_phone' => $orderDetails->supplier_phone,
                        'supp_address' => $orderDetails->supp_address,
                    ],
                ],
                'order_items' => $orderItems
            ];

            // Return success response
            return response()->json([
                'message' => 'Order details retrieved successfully.',
                'data' => $response,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'message' => 'An error occurred while retrieving the order details.',
                'data' => null,
                'code' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }






    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
