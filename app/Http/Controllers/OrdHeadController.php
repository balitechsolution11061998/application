<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrdersJob;
use App\Models\DiffCostPo;
use App\Models\OrdHead;
use App\Models\PerformanceAnalysis;
use App\Models\QueryPerformanceLog;
use App\Models\User;
use App\Services\Order\OrderService;
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

    public function count(Request $request)
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage();

    try {
        // Get filter parameters from the request
        $filterDate = $request->filterDate;
        $filterSupplier = $request->filterSupplier;

        // Use the orderService to get the query builder with filters applied
        $query = $this->orderService->countDataPo($filterDate, $filterSupplier);

        // Count total records before pagination


        // Calculate execution time and memory usage
        $executionTime = microtime(true) - $startTime;
        $memoryUsage = memory_get_usage() - $startMemory;

        // Log performance metrics
        QueryPerformanceLog::create([
            'function_name' => 'Count Data PO',
            'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
            'execution_time' => $executionTime,
            'memory_usage' => $memoryUsage
        ]);

        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $query,
        ]);
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

public function data(Request $request)
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage();

    try {
        // Capture filters from request
        $filterDate = $request->filterDate;
        $filterSupplier = $request->filterSupplier;
        $filterOrderNo = $request->filterOrderNo;

        // Fetch data from the service
        $data = $this->orderService->data($filterDate, $filterSupplier, $filterOrderNo);

        // Example: Assume that $data is a collection or array
        $totalCount = count($data);
        $processedCount = $totalCount; // Assuming all records are processed, modify as needed

        // Calculate execution time and memory usage
        $executionTime = microtime(true) - $startTime;
        $memoryUsage = memory_get_usage() - $startMemory;

        // Determine performance status based on execution time
        $status = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

        // Create or update performance analysis record
        $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
            'total_count' => $totalCount,
            'processed_count' => $processedCount,
            'success_count' => $processedCount, // Assuming all processed are successful, modify as needed
            'fail_count' => 0, // Update as needed
            'errors' => null,
            'execution_time' => $executionTime,
            'status' => $status
        ]);

        // Log performance metrics
        QueryPerformanceLog::create([
            'function_name' => 'Data PO',
            'parameters' => json_encode([
                'filterDate' => $filterDate,
                'filterSupplier' => $filterSupplier,
                'filterOrderNo' => $filterOrderNo // Include all filters in the log
            ]),
            'execution_time' => $executionTime,
            'memory_usage' => $memoryUsage,
            'performance_analysis_id' => $performanceAnalysis->id
        ]);

        // Return the data as a DataTable JSON response
        return DataTables::of($data)
            ->addColumn('actions', function($row) {
                return '<button class="btn btn-sm btn-primary">Action</button>';
            })
            ->rawColumns(['actions'])
            ->toJson();
    } catch (\Throwable $th) {
        // Handle exceptions and return a JSON response
        return response()->json([
            'success' => false,
            'error' => $th->getMessage()
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

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Show Confirmed PO',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);

            return DataTables::of($data)
                ->addColumn('actions', function($row) {
                    return '<button class="btn btn-sm btn-primary">Action</button>';
                })
                ->rawColumns(['actions'])
                ->toJson();
        } catch (\Throwable $th) {
            // Log the error for debugging purposes

            return response()->json([
                'success' => false,
                'error' => 'An error occurred while processing your request. Please try again later.'
            ], 500);
        }
    }


}
