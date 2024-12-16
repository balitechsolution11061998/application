<?php

namespace App\Http\Controllers;

use App\Helpers\SystemUsageHelper;
use App\Models\OrdHead;
use App\Models\OrdSku;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Facades\Activity;
use Exception;
use Illuminate\Support\Facades\Auth;

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
        try {
            $data = $request->all(); // Get the orders array

            foreach ($data as $chunk) {
                // Call the orderService for each chunk
                $this->orderService->store($chunk);

                // Log each action in Spatie Activity Log
                activity()
                    ->causedBy(auth()->user()) // Log the user who performed the action
                    ->withProperties(['chunk' => $chunk]) // Optional: Log chunk details
                    ->log('Stored a new Purchase Order');
            }

            // Return success response
            return response()->json([
                'message' => 'Data PO stored successfully',
                'title' => 'PO Stored Success',
            ]);
        } catch (Exception $e) {
            // Log the exception in Spatie Activity Log
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $e->getMessage()])
                ->log('Failed to store Purchase Order');

            // Return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($order_no)
    {
        $order_no = base64_decode($order_no);

        // Capture start time and memory usage
        $startTime = microtime(true);
        $startMemory = memory_get_usage(); // Memory in bytes

        try {
            // Check if the user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login'); // Redirect to login if not authenticated
            }

            // Fetch the order to log it as the subject
            $order = OrdHead::where('order_no', $order_no)->first();
            if (!$order) {
                return redirect()->back()->with([
                    'message' => 'Order not found.',
                    'code' => 404,
                ]);
            }

            // Get the user's IP address
            $userIp = request()->ip();

            // Log activity: User is viewing an order
            activity()
                ->causedBy(Auth::user())
                ->performedOn($order) // Set the subject to the order
                ->withProperties([
                    'order_no' => $order_no,
                    'execution_time_ms' => round((microtime(true) - $startTime) * 1000, 2), // Time in ms
                    'memory_usage_m' => round($startMemory / 1024 / 1024, 2), // Memory in M
                    'timestamp' => now(),
                    'log_name' => 'Custom Log Name: Viewed Order', // Custom log name
                    'user_ip' => $userIp, // Add user IP address
                ])
                ->log('User accessed order details'); // Custom log message

            // Fetch order details with related store and supplier information
            $orderDetails = $this->getOrderDetails($order_no);

            // Check if the order exists
            if (!$orderDetails) {
                return view('orders.notfound'); // Render a "not found" view
            }

            // Fetch all order items (ordsku details)
            $orderItems = $this->getOrderItems($order_no);

            // Prepare data for the view
            $data = $this->prepareOrderData($orderDetails, $orderItems);

            // Log system usage
            SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderData');

            // Return the view with data
            return view('orders.show', compact('data'));
        } catch (\Exception $e) {
            // Log system usage in case of an error
            SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderDataError');

            // Log the exception details for debugging
            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'order_no' => $order_no,
                    'error' => $e->getMessage(),
                    'execution_time_ms' => round((microtime(true) - $startTime) * 1000, 2), // Time in ms
                    'memory_usage_m' => round($startMemory / 1024 / 1024, 2), // Memory in M
                    'timestamp' => now(),
                    'log_name' => 'Custom Log Name: Error Viewing Order', // Custom log name
                    'user_ip' => $userIp, // Add user IP address
                ])
                ->log('Error accessing order details'); // Custom log message

            // Return back with an error message and status code
            return redirect()->back()->with([
                'message' => 'An error occurred while retrieving the order details.',
                'error' => $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function getOrdersSupplier(){
        return view('frontend.po.index');
    }





    private function getOrderDetails($order_no)
    {
        return DB::table('ordhead')
            ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
            ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
            ->leftJoin('rcvhead', 'ordhead.order_no', '=', 'rcvhead.order_no')
            ->select(
                'ordhead.*',
                'store.store as store_code',
                'store.store_name as store_name',
                'store.store_add1 as store_address',
                'store.store_add2 as store_address1',
                'store.store_city as store_city',
                'store.latitude',
                'store.longitude',
                'supplier.supp_code as supplier_code',
                'supplier.supp_name as supplier_name',
                'supplier.contact_name as supplier_contact',
                'supplier.contact_phone as supplier_phone',
                'supplier.address_1 as supp_address',
                'supplier.tax_ind as tax_ind',
                'rcvhead.receive_date as receive_date',
                'rcvhead.receive_no as receive_no'
            )
            ->where('ordhead.order_no', $order_no)
            ->first();
    }

    private function getOrderItems($order_no)
    {
        return OrdSku::with('itemSupplier')
            ->where('ordsku.order_no', $order_no)
            ->select(
                'ordsku.sku',
                'ordsku.sku_desc',
                'ordsku.upc',
                'ordsku.tag_code',
                DB::raw('SUM(ordsku.qty_ordered) as qty_ordered'),
                DB::raw('SUM(ordsku.unit_cost) as unit_cost'),
                'ordsku.unit_retail',
                'ordsku.vat_cost',
                'ordsku.luxury_cost',
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
            ->groupBy('ordsku.sku', 'ordsku.sku_desc', 'ordsku.upc', 'ordsku.tag_code', 'ordsku.unit_retail', 'ordsku.vat_cost', 'ordsku.luxury_cost', 'ordsku.qty_fulfilled', 'ordsku.qty_received', 'ordsku.unit_discount', 'ordsku.unit_permanent_discount', 'ordsku.purchase_uom', 'ordsku.supp_pack_size', 'ordsku.permanent_disc_pct', 'ordsku.created_at', 'ordsku.updated_at')
            ->get();
    }

    private function prepareOrderData($orderDetails, $orderItems)
    {
        return [
            'orderDetails' => $orderDetails,
            'store' => [
                'store_code' => $orderDetails->store_code,
                'store_name' => $orderDetails->store_name,
                'store_address' => $orderDetails->store_address,
                'store_address1' => $orderDetails->store_address1,
                'store_city' => $orderDetails->store_city,
                'latitude' => $orderDetails->latitude,
                'longitude' => $orderDetails->longitude,
            ],
            'supplier' => [
                'supplier_code' => $orderDetails->supplier_code,
                'supplier_name' => $orderDetails->supplier_name,
                'supplier_contact' => $orderDetails->supplier_contact,
                'supplier_phone' => $orderDetails->supplier_phone,
                'supp_address' => $orderDetails->supp_address,
                'tax_ind' => $orderDetails->tax_ind,
            ],
            'orderItems' => $orderItems,
        ];
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Start tracking performance
                $startTime = microtime(true);
                $startMemory = memory_get_usage();

                // Base query with joins and selections
                $query = DB::table('ordhead')
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
                    ->orderBy('approval_date', 'desc');

                // Apply filters
                if (!empty($request->order_no)) {
                    $query->where('ordhead.order_no', $request->order_no);
                }

                if (!empty($request->filterDate)) {
                    [$startDate, $endDate] = explode(' - ', $request->filterDate);
                    $query->whereBetween('ordhead.approval_date', [$startDate, $endDate]);
                }

                // Prepare results for DataTables using chunking
                $results = [];
                $query->chunk(1000, function ($chunk) use (&$results) {
                    foreach ($chunk as $row) {
                        $results[] = $row;
                    }
                });

                // Transform the results for DataTables
                return DataTables::of($results)
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

                    ->rawColumns(['action']) // Allow HTML rendering
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching data. ' . $e->getMessage()], 500);
            } finally {
                // Log performance metrics
                // Calculate performance metrics
                // Calculate performance metrics
                $executionTimeMs = round((microtime(true) - $startTime) * 1000, 2); // Time in ms
                $memoryUsageM = round((memory_get_usage() - $startMemory) / 1024 / 1024, 2); // Memory in MB

                // Log performance metrics
                $lastOrder = OrdHead::latest()->first(); // Get the last order for logging
                if ($lastOrder) {
                    activity()
                        ->causedBy(Auth::user()) // Log the user who triggered the action
                        ->performedOn($lastOrder) // Log the last order as the subject
                        ->withProperties([
                            'execution_time' => $executionTimeMs . " MS",
                            'memory_usage' => $memoryUsageM . " MB",
                            'timestamp' => now(),
                            'log_name' => 'Custom Log Name: Order Data Fetch', // Custom log name
                        ])
                        ->log('Fetched order data'); // Custom log message
                }

                SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderData');
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
