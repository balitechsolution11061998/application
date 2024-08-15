<?php

namespace App\Http\Controllers;

use App\Helpers\PerformanceHelper;
use App\Jobs\LogQueryPerformance;
use App\Jobs\ProcessOrdersJob;
use App\Models\DiffCostPo;
use App\Models\OrdHead;
use App\Models\PerformanceAnalysis;
use App\Models\QueryPerformanceLog;
use App\Models\User;
use App\Services\Order\OrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class OrdHeadController extends Controller
{
    //
    protected $orderService;
    protected $rcvService;

    public function __construct(
        OrderService $orderService,
    ) {

        $this->orderService = $orderService;
        $this->middleware('auth');

    }
    public function index(){
        return view('order.index');
    }

    public function getOrderDetails(Request $request) {
        try {
            // Validate the request
            $validated = $request->validate([
                'order_no' => 'required|string',
            ]);

            $orderNo = $validated['order_no'];

            // Fetch order details including related ordskus
            $orderDetails = OrdHead::with('ordDetail','stores','suppliers','rcvHead','rcvHead.tandaTerimaDetail','rcvHead.rcvDetail')->where('order_no', $orderNo)->first();

            if ($orderDetails) {
                // Return the order details and associated ordskus as JSON response
                return response()->json([
                    'status' => 'success',
                    'details' => $orderDetails
                ]);
            } else {
                // Handle case where order details are not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order details not found'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request parameters',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }



public function count(Request $request)
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage();

    try {
        $filterDate = $request->filterDate;
        $filterSupplier = $request->filterSupplier;
        // If filterDate is null or an empty string, set it to the current year and month
        if (is_null($filterDate) || $filterDate == "null" || empty($filterDate)) {
            $currentDate = Carbon::now();
            $filterYear = $currentDate->year;
            $filterMonth = $currentDate->month;
        } else {
            // Extract year and month from the provided filterDate
            $filterYear = Carbon::parse($filterDate)->year;
            $filterMonth = Carbon::parse($filterDate)->month;
        }

        // Calculate the start and end date of the given month
        $startDate = Carbon::create($filterYear, $filterMonth, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($filterYear, $filterMonth, 1)->endOfMonth()->toDateString();

        // Get the supplier user and filter supplier from the request
        $supplierUser = auth()->user();
        $filterSupplier = request()->input('filterSupplier');

        // Build the query
        $dailyCountsQuery = OrdHead::with('suppliers')
            ->select([
                DB::raw('DATE(approval_date) as tanggal'),
                DB::raw('COUNT(DISTINCT ordhead.id) as jumlah'),
                DB::raw('SUM(ordsku.unit_cost * ordsku.qty_ordered + ordsku.vat_cost * ordsku.qty_ordered) as total_cost'),
            ])
            ->leftJoin('ordsku', 'ordhead.id', '=', 'ordsku.ordhead_id')
            ->whereBetween('approval_date', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->when(optional($supplierUser)->hasRole('supplier'), function ($query) use ($supplierUser) {
                $query->where('ordhead.supplier', $supplierUser->username);
            })
            ->when(!empty($filterSupplier), function ($query) use ($filterSupplier) {
                $query->whereIn('ordhead.supplier', (array) $filterSupplier);
            });

        // Execute the query and get the results
        $dailyCounts = $dailyCountsQuery->get();

        // Calculate totals
        $totalCount = $dailyCounts->count(); // Total number of records
        $processedCount = $totalCount; // Assuming all fetched records are processed
        $successCount = $processedCount; // Assuming all processed records are successful
        $failCount = 0; // Assuming no failed records in this context

        $totals = $dailyCounts->reduce(function ($carry, $item) {
            $carry['totalPo'] += $item->jumlah;
            $carry['totalCost'] += $item->total_cost;
            return $carry;
        }, ['totalPo' => 0, 'totalCost' => 0]);

        // Calculate execution time and memory usage
        $executionTime = microtime(true) - $startTime;
        $memoryUsage = memory_get_usage() - $startMemory;

        // Create or update performance analysis record
        $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
            'total_count' => $totalCount,
            'processed_count' => $processedCount,
            'success_count' => $successCount,
            'fail_count' => $failCount,
            'errors' => null,
            'execution_time' => $executionTime,
            'status' => $executionTime > 1 ? 'slow' : 'fast' // Example status based on execution time
        ]);

        // Log performance metrics
        QueryPerformanceLog::create([
            'function_name' => 'Count Data PO',
            'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
            'execution_time' => $executionTime,
            'memory_usage' => $memoryUsage,
            'performance_analysis_id' => $performanceAnalysis->id
        ]);

        return [
            'totalPo' => $totals['totalPo'],
            'totalCost' => $totals['totalCost'],
            'month' => str_pad($filterMonth, 2, '0', STR_PAD_LEFT), // Ensure month is two digits
            'year' => (string)$filterYear, // Convert year to string
            'total_count' => $totalCount,
            'processed_count' => $processedCount,
            'success_count' => $successCount,
            'fail_count' => $failCount
        ];
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'error' => $th->getMessage()
        ], 500);
    }
}




public function store(Request $request)
{
    $startTime = microtime(true); // Start timing

    $data = $request->input('data');

    // Initialize progress counters
    $totalCount = count($data);
    $processedCount = 0;
    $successCount = 0;
    $failCount = 0;
    $errors = [];

    $chunkSize = 10;
    $delayInMicroseconds = 100000;

    try {
        $chunks = array_chunk($data, $chunkSize);

        foreach ($chunks as $chunk) {
            $successCountChunk = 0;
            $failCountChunk = 0;
            $errorsChunk = [];

            foreach ($chunk as $dataItem) {
                try {
                    // Prepare data for ordhead
                    $ordHeadData = [
                        "order_no" => $dataItem['order_no'] ?? 'unknown',
                        "ship_to" => $dataItem['ship_to'] ?? null,
                        "supplier" => $dataItem['supplier'] ?? null,
                        "terms" => $dataItem['terms'] ?? null,
                        "status_ind" => $dataItem['status_ind'] ?? null,
                        "written_date" => $dataItem['written_date'] ?? null,
                        "not_before_date" => $dataItem['not_before_date'] ?? null,
                        "not_after_date" => $dataItem['not_after_date'] ?? null,
                        "approval_date" => $dataItem['approval_date'] ?? null,
                        "approval_id" => $dataItem['approval_id'] ?? null,
                        "cancelled_date" => $dataItem['cancelled_date'] ?? null,
                        "canceled_id" => $dataItem['canceled_id'] ?? null,
                        "cancelled_amt" => $dataItem['cancelled_amt'] ?? 0,
                        "total_cost" => $dataItem['total_cost'] ?? 0,
                        "total_retail" => $dataItem['total_retail'] ?? 0,
                        "outstand_cost" => $dataItem['outstand_cost'] ?? 0,
                        "total_discount" => $dataItem['total_discount'] ?? 0,
                        "comment_desc" => $dataItem['comment_desc'] ?? null,
                        "buyer" => $dataItem['buyer'] ?? null,
                        "status" => $dataItem['status'] ?? "Progress",
                        "estimated_delivery_date" => $dataItem['estimated_delivery_date'] ?? null,
                    ];

                    // Handle ordhead data
                    $uniqueAttributes = ["order_no" => $dataItem['order_no'] ?? 'unknown'];
                    $existingRecord = DB::table('ordhead')->where($uniqueAttributes)->first();

                    if ($existingRecord) {
                        DB::table('ordhead')->where('id', $existingRecord->id)->update($ordHeadData);
                        $ordHeadId = $existingRecord->id;
                    } else {
                        $ordHeadId = DB::table('ordhead')->insertGetId(array_merge($uniqueAttributes, $ordHeadData));
                    }

                    // Process order details
                    foreach ($dataItem['ord_detail'] as $detail) {
                        $ordSkuData = [
                            "ordhead_id" => $ordHeadId,
                            "order_no" => $dataItem['order_no'] ?? 'unknown',
                            "sku" => $detail['sku'] ?? 'unknown',
                            "sku_desc" => $detail['sku_desc'] ?? null,
                            "upc" => $detail['upc'] ?? null,
                            "tag_code" => $detail['tag_code'] ?? null,
                            "unit_cost" => $detail['unit_cost'] ?? 0,
                            "unit_retail" => $detail['unit_retail'] ?? 0,
                            "vat_cost" => $detail['vat_cost'] ?? 0,
                            "luxury_cost" => $detail['luxury_cost'] ?? 0,
                            "qty_ordered" => $detail['qty_ordered'] ?? 0,
                            "qty_received" => $detail['qty_received'] ?? 0,
                            "unit_discount" => $detail['unit_discount'] ?? 0,
                            "unit_permanent_discount" => $detail['unit_permanent_discount'] ?? 0,
                            "purchase_uom" => $detail['purchase_uom'] ?? null,
                            "supp_pack_size" => $detail['supp_pack_size'] ?? null,
                            "permanent_disc_pct" => $detail['permanent_disc_pct'] ?? 0,
                        ];

                        DB::table('ordsku')->updateOrInsert(
                            [
                                "order_no" => $dataItem['order_no'] ?? 'unknown',
                                "sku" => $detail['sku'] ?? 'unknown',
                                "upc" => $detail['upc'] ?? null
                            ],
                            $ordSkuData
                        );
                    }

                    $successCountChunk++;

                } catch (Exception $e) {
                    $failCountChunk++;
                    $errorsChunk[] = [
                        'order_no' => $dataItem['order_no'] ?? 'unknown',
                        'message' => $e->getMessage()
                    ];
                }
            }

            // Update counters
            $processedCount += count($chunk);
            $successCount += $successCountChunk;
            $failCount += $failCountChunk;
            $errors = array_merge($errors, $errorsChunk);

            // Introduce delay
            usleep($delayInMicroseconds);
        }

    } catch (Exception $e) {
        $failCount++;
        $errors[] = [
            'order_no' => 'unknown',
            'message' => $e->getMessage()
        ];
    }

    $endTime = microtime(true); // End timing
    $executionTime = $endTime - $startTime; // Calculate execution time

    // Determine status
    $status = $executionTime < 5 ? 'fast' : 'slow'; // Adjust the threshold as needed

    // Insert performance metrics into performance_analysis table
    $performanceAnalysis = PerformanceAnalysis::create([
        'total_count' => $totalCount,
        'processed_count' => $processedCount,
        'success_count' => $successCount,
        'fail_count' => $failCount,
        'errors' => json_encode($errors), // Encode errors array as JSON
        'execution_time' => $executionTime,
        'status' => $status
    ]);

    // Insert performance logs
    foreach ($data as $dataItem) {
        QueryPerformanceLog::create([
            'function_name' => 'Store PO', // Example function name
            'parameters' => json_encode($dataItem),
            'execution_time' => $executionTime,
            'memory_usage' => memory_get_usage(),
            'ping' => null, // Replace with actual ping if available
            'download_speed' => null, // Replace with actual download speed if available
            'upload_speed' => null, // Replace with actual upload speed if available
            'ip_user' => $request->ip(),
            'performance_analysis_id' => $performanceAnalysis->id
        ]);
    }

    // Return a response indicating the processing results
    return response()->json([
        'status' => 'success',
        'message' => 'Data processed',
        'progress' => [
            'total_count' => $totalCount,
            'processed_count' => $processedCount,
            'success_count' => $successCount,
            'fail_count' => $failCount,
            'errors' => $errors
        ],
        'execution_time' => $executionTime, // Include execution time in the response
        'status' => $status // Include status in the response
    ]);
}

// public function data(Request $request)
// {
//     $startTime = microtime(true);
//     $startMemory = memory_get_usage();

//     try {
//         // Capture filters from request
//         $filterDate = $request->input('filterDate');
//         $filterSupplier = $request->input('filterSupplier');
//         $filterOrderNo = $request->input('filterOrderNo');

//         // Default filter date to current date if null
//         $filterDate = $filterDate ?? date('Y-m');

//         // Extract the year and month from the filter date
//         $filterYear = date('Y', strtotime($filterDate));
//         $filterMonth = date('m', strtotime($filterDate));

//         // Initialize the query builder
//         $query = DB::table('ordhead')
//             ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
//             ->leftJoin('ordsku', 'ordhead.order_no', '=', 'ordsku.order_no')
//             ->leftJoin('rcvhead', 'ordhead.order_no', '=', 'rcvhead.order_no')
//             ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
//             ->select([
//                 'ordhead.id',
//                 'ordhead.order_no',
//                 'supplier.supp_code',
//                 'supplier.supp_name',
//                 'store.store',
//                 'store.store_name',
//                 'ordhead.approval_date',
//                 'ordhead.status',
//                 'ordhead.estimated_delivery_date',
//                 DB::raw('SUM(ordsku.qty_ordered) as qty_ordered'),
//                 DB::raw('MAX(rcvhead.receive_date) as last_receive_date'),
//                 DB::raw('COUNT(CASE WHEN ordhead.status = "confirmed" THEN 1 END) as confirmed_count'),
//                 DB::raw('MAX(ordhead.id) as max_id'),
//             ])
//             ->groupBy([
//                 'ordhead.order_no',
//                 'supplier.supp_code',
//                 'supplier.supp_name',
//                 'store.store',
//                 'store.store_name',
//                 'ordhead.approval_date',
//                 'ordhead.status',
//                 'ordhead.estimated_delivery_date',
//             ])
//             ->orderByDesc('max_id');

//         // Apply filters if provided
//         if ($filterSupplier) {
//             $query->where('ordhead.supplier', $filterSupplier);
//         }

//         if ($filterOrderNo) {
//             $query->where('ordhead.order_no', $filterOrderNo);
//         }

//         // Apply date filter
//         $query->whereYear('ordhead.approval_date', $filterYear)
//               ->whereMonth('ordhead.approval_date', $filterMonth);

//         // Execute the query and get the results
//         $data = $query->get();

//         // Calculate execution time and memory usage
//         $executionTime = microtime(true) - $startTime;
//         $memoryUsage = memory_get_usage() - $startMemory;

//         // Determine performance status based on execution time
//         $status = $executionTime > 1 ? 'slow' : 'fast';

//         // Prepare performance data
//         $performanceData = [
//             'total_count' => $data->count(),
//             'processed_count' => $data->count(),
//             'success_count' => $data->count(),
//             'fail_count' => 0,
//             'errors' => null,
//             'execution_time' => $executionTime,
//             'status' => $status,
//             'memory_usage' => $memoryUsage,
//             'performance_analysis_id' => null // Placeholder, to be updated by job if needed
//         ];

//         // Dispatch job with performance data and query parameters
//         LogQueryPerformance::dispatch($performanceData, [
//             'filterDate' => $filterDate,
//             'filterSupplier' => $filterSupplier,
//             'filterOrderNo' => $filterOrderNo
//         ]);

//         // Return the data as a DataTable JSON response
//         return DataTables::of($data)
//             ->addColumn('actions', function($row) {
//                 return '<button class="btn btn-sm btn-primary">Action</button>';
//             })
//             ->rawColumns(['actions'])
//             ->toJson();
//     } catch (\Throwable $th) {
//         // Handle exceptions and return a JSON response
//         return response()->json([
//             'success' => false,
//             'error' => 'An error occurred while fetching data: ' . $th->getMessage(),
//         ], 500);
//     }
// }

public function data(Request $request)
{
    $date = $request->query('date');

    try {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        // Get filter inputs
        $filterDate = $request->input('filterDate');
        $filterSupplier = $request->input('filterSupplier');
        $filterOrderNo = $request->input('filterOrderNo');

        $data = $this->orderService->getOrderData($filterDate, $filterSupplier, $filterOrderNo);

        // Calculate execution time and memory usage
        $executionTime = microtime(true) - $startTime;
        $memoryUsage = memory_get_usage() - $startMemory;

        // Log performance metrics
        PerformanceHelper::logPerformanceMetrics(
            'Data PO',              // Function name
            $date,                  // Date parameter
            $executionTime,         // Execution time
            $memoryUsage,           // Memory usage
            $data->count(),         // Total count
            $data->count(),         // Processed count
            $data->count()          // Success count
        );

        // Return the data in DataTables format
        return DataTables::of($data)
            ->addColumn('actions', function ($row) {
                return '<button class="btn btn-sm btn-primary">Action</button>';
            })
            ->rawColumns(['actions'])
            ->toJson();

    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'error' => 'An error occurred while fetching data: ' . $th->getMessage(),
        ], 500);
    }
}



public function delivery(Request $request)
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage();

    try {
        $filterDate = $request->filterDate;
        $filterSupplier = $request->filterSupplier;

        // Initialize the query with eager loading
        $query = OrdHead::with('stores')
            ->whereIn('status', ['confirmed', 'printed'])
            ->where('estimated_delivery_date', '>', now());

        // Apply filters if provided
        if ($filterDate) {
            $query->whereDate('created_at', $filterDate);
        }

        if ($filterSupplier) {
            $query->where('supplier_id', $filterSupplier);
        }

        // Execute the query and get the results
        $data = $query->get();

        // Calculate execution time and memory usage
        $executionTime = microtime(true) - $startTime;
        $memoryUsage = memory_get_usage() - $startMemory;

        // Determine the status of the operation
        $status = 'success';

        // Create or update performance analysis record
        $performanceAnalysis = PerformanceAnalysis::create([
            'total_count' => $data->count(),
            'processed_count' => $data->count(), // Assuming all records are processed, modify as needed
            'success_count' => $data->count(), // Assuming all processed are successful, modify as needed
            'fail_count' => 0, // Update as needed based on actual processing
            'errors' => null, // Log any errors here if needed
            'execution_time' => $executionTime,
            'status' => $status
        ]);

        // Log performance metrics
        QueryPerformanceLog::create([
            'function_name' => 'Data PO',
            'parameters' => json_encode([
                'filterDate' => $filterDate,
                'filterSupplier' => $filterSupplier,
            ]),
            'execution_time' => $executionTime,
            'memory_usage' => $memoryUsage,
            'performance_analysis_id' => $performanceAnalysis->id // Link to the performance analysis record
        ]);

        return DataTables::of($data)
            ->addColumn('actions', function($row) {
                return '<button class="btn btn-sm btn-primary">Action</button>';
            })
            ->rawColumns(['actions'])
            ->toJson();
    } catch (\Throwable $th) {
        // Log the error for debugging purposes
        $status = 'failure';
        $errorMessage = $th->getMessage();

        // Create or update performance analysis record in case of failure
        $performanceAnalysis = PerformanceAnalysis::create([
            'total_count' => 0,
            'processed_count' => 0,
            'success_count' => 0,
            'fail_count' => 1, // Since the operation failed
            'errors' => $errorMessage,
            'execution_time' => microtime(true) - $startTime, // Calculate up to the error point
            'status' => $status
        ]);

        // Log performance metrics with error information
        QueryPerformanceLog::create([
            'function_name' => 'Data PO',
            'parameters' => json_encode([
                'filterDate' => $filterDate,
                'filterSupplier' => $filterSupplier,
            ]),
            'execution_time' => microtime(true) - $startTime,
            'memory_usage' => memory_get_usage() - $startMemory,
            'performance_analysis_id' => $performanceAnalysis->id,
            'error_message' => $errorMessage
        ]);

        return response()->json([
            'success' => false,
            'error' => 'An error occurred while processing your request. Please try again later.'
        ], 500);
    }
}

public function receiving(Request $request)
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage();

    try {
        $filterDate = $request->filterDate;
        $filterSupplier = $request->filterSupplier;
        $now = now(); // Current date-time

        // Initialize the query with eager loading
        $query = OrdHead::with(['stores', 'rcvHead'])
            ->where('status', 'completed')
            ->whereHas('rcvHead', function ($q) use ($filterDate, $now) {
                $q->whereDate('receive_date', $filterDate ?? $now);
            });

        // Apply additional filters if provided
        if ($filterDate) {
            $query->whereDate('created_at', $filterDate);
        }

        if ($filterSupplier) {
            $query->where('supplier_id', $filterSupplier);
        }

        // Execute the query and get the results
        $data = $query->get();

        // Calculate execution time and memory usage
        $executionTime = microtime(true) - $startTime;
        $memoryUsage = memory_get_usage() - $startMemory;

        // Determine the status of the operation
        $status = 'success';

        // Create or update performance analysis record
        $performanceAnalysis = PerformanceAnalysis::create([
            'total_count' => $data->count(),
            'processed_count' => $data->count(), // Assuming all records are processed, modify as needed
            'success_count' => $data->count(), // Assuming all processed are successful, modify as needed
            'fail_count' => 0, // Update as needed based on actual processing
            'errors' => null, // Log any errors here if needed
            'execution_time' => $executionTime,
            'status' => $status
        ]);

        // Log performance metrics
        QueryPerformanceLog::create([
            'function_name' => 'Data PO',
            'parameters' => json_encode([
                'filterDate' => $filterDate,
                'filterSupplier' => $filterSupplier,
            ]),
            'execution_time' => $executionTime,
            'memory_usage' => $memoryUsage,
            'performance_analysis_id' => $performanceAnalysis->id // Link to the performance analysis record
        ]);

        return DataTables::of($data)
            ->addColumn('actions', function($row) {
                return '<button class="btn btn-sm btn-primary">Action</button>';
            })
            ->rawColumns(['actions'])
            ->toJson();
    } catch (\Exception $th) {
        dd($th->getMessage());
        // Log the error for debugging purposes
        $status = 'failure';
        $errorMessage = $th->getMessage();

        // Create or update performance analysis record in case of failure
        $performanceAnalysis = PerformanceAnalysis::create([
            'total_count' => 0,
            'processed_count' => 0,
            'success_count' => 0,
            'fail_count' => 1, // Since the operation failed
            'errors' => $errorMessage,
            'execution_time' => microtime(true) - $startTime, // Calculate up to the error point
            'status' => $status
        ]);

        // Log performance metrics with error information
        QueryPerformanceLog::create([
            'function_name' => 'Data PO',
            'parameters' => json_encode([
                'filterDate' => $filterDate,
                'filterSupplier' => $filterSupplier,
            ]),
            'execution_time' => microtime(true) - $startTime,
            'memory_usage' => memory_get_usage() - $startMemory,
            'performance_analysis_id' => $performanceAnalysis->id,
            'error_message' => $errorMessage
        ]);

        return response()->json([
            'success' => false,
            'error' => 'An error occurred while processing your request. Please try again later.'
        ], 500);
    }
}



}
