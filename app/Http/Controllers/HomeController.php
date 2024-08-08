<?php

namespace App\Http\Controllers;

use App\Models\OrdHead;
use App\Models\QueryPerformanceLog;
use App\Models\RcvHead;
use App\Services\Order\OrderService;
use App\Services\Rcv\RcvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    protected $orderService;
    protected $rcvService;

    public function __construct(
        OrderService $orderService,
        RcvService $rcvService,
    ) {

        $this->orderService = $orderService;
        $this->rcvService = $rcvService;
        $this->middleware('auth');

    }
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $id = $user->id;
            $messengerColor = '#ff0000'; // Example color; replace with actual value
            $dark_mode = 'dark'; // or 'light'

            if ($user->hasRole('superadministrator')) {
                return view('home', [
                    'id' => $id,
                    'messengerColor' => $messengerColor,
                    'dark_mode' => $dark_mode,
                ]);
            } elseif ($user->hasRole('admin_karyawan') || $user->hasRole('karyawan')) {
                return view('home.home3', [
                    'id' => $id,
                    'messengerColor' => $messengerColor,
                    'dark_mode' => $dark_mode,
                ]);
            } elseif ($user->hasRole('admin_cbt') || $user->hasRole('siswa') || $user->hasRole('guru')) {
                return view('home2', [
                    'id' => $id,
                    'messengerColor' => $messengerColor,
                    'dark_mode' => $dark_mode,
                ]);
            } else {
                // Handle cases where the user role does not match any predefined roles
                return view('home.default', [ // Adjust this as needed
                    'id' => $id,
                    'messengerColor' => $messengerColor,
                    'dark_mode' => $dark_mode,
                ]);
            }
        }

        // If the user is not authenticated, redirect to a login page or an error page
        return redirect()->route('login');
    }


    public function index2()
    {
            return view('home2');

    }

    public function index3()
    {
            return view('home3');

    }


    public function countDataPoPerDays(Request $request)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            // Capture filters from the request
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;

            // Fetch data from the service
            $data = $this->orderService->countDataPoPerDays($filterDate, $filterSupplier);

            // Example: Assume $data is an array or collection
            $totalCount = count($data);
            $processedCount = $totalCount; // Assuming all records are processed, adjust if necessary

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Determine performance status based on execution time
            $status = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

            // Create or update performance analysis record
            $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
                'total_count' => $totalCount,
                'processed_count' => $processedCount,
                'success_count' => $processedCount, // Assuming all processed are successful, adjust if necessary
                'fail_count' => 0, // Adjust if you have failure cases
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $status
            ]);

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data PO Per Days',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id
            ]);

            // Return the data as a JSON response
            return response()->json([
                'success' => true,
                'data' => $data,
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);
        } catch (\Throwable $th) {
            // Handle exceptions and return a JSON response
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function countDataPoPerDate(Request $request)
    {
        $date = $request->query('date'); // Get the date parameter from the request
        $status = $request->query('status'); // Get the status parameter from the request

        try {
            $startTime = microtime(true); // Start timing

            // Fetch and process data for the specified date and status
            $query = OrdHead::whereDate('approval_date', $date);

            if ($status) {
                // Check if the status is 'In Progress', and if so, set it to 'progress'
                if ($status === 'In Progress') {
                    $status = 'progress';
                    // Filter for status 'progress' where estimated_delivery_date is null
                    $query->where(function ($q) {
                        $q->whereNull('estimated_delivery_date')
                          ->where('status', 'progress');
                    });
                } else {
                    // Filter by status if provided
                    $query->where('status', $status);
                }
            }

            // Fetch the data
            $data = $query->get();

            // Process the data to update statuses
            $totalCount = $data->count(); // Total records fetched
            $processedCount = 0; // To track how many records are processed

            foreach ($data as $record) {
                // Check if there is a related record in the receiving process
                $existsInReceiving = RcvHead::where('order_no', $record->order_no)->exists();

                if ($existsInReceiving) {
                    // Update the status to 'completed'
                    $record->status = 'completed';
                    $record->save();
                } elseif ($record->estimated_delivery_date !== null) {
                    // Update the status to 'confirmed' if estimated_delivery_date is not null
                    $record->status = 'confirmed';
                    $record->save();
                } elseif (!$existsInReceiving && $record->not_after_date && Carbon::parse($record->not_after_date)->isPast()) {
                    // Update the status to 'expired' if not_after_date is past and no receiving records
                    $record->status = 'expired';
                    $record->save();
                }

                $processedCount++; // Increment processed count
            }

            // Fetch the updated data after status updates
            $data = $query->get();

            $endTime = microtime(true); // End timing
            $executionTime = $endTime - $startTime; // Calculate execution time
            $memoryUsage = memory_get_usage(); // Get memory usage

            // Determine performance status based on execution time
            $status = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

            // Create or update performance analysis record
            $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
                'total_count' => $totalCount,
                'processed_count' => $processedCount,
                'success_count' => $processedCount, // Assuming all processed are successful, adjust if necessary
                'fail_count' => 0, // Adjust if you have failure cases
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $status
            ]);

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data PO Per Date',
                'parameters' => json_encode(['date' => $date, 'status' => $status]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id
            ]);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function countDataPo(Request $request)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;

            // Fetch the total count of data
            $total = $this->orderService->countDataPo($filterDate, $filterSupplier);

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Determine performance status based on execution time
            $status = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

            // Create or update performance analysis record
            $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
                'total_count' => $total, // Assuming 'total' represents total_count
                'processed_count' => $total, // Assuming all data counted are processed
                'success_count' => $total, // Assuming all processed are successful
                'fail_count' => 0, // Adjust if you have failure cases
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $status
            ]);

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data Purchase Order',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id // Ensure this ID is provided
            ]);

            return response()->json([
                'success' => true,
                'total' => $total,
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);
        } catch (\Throwable $th) {
            // Log the exception for debugging
            \Log::error('Failed to count data PO: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function countDataRcv(Request $request){

        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->input('filterDate'); // Ensure this is an array if required
            $filterSupplier = $request->input('filterSupplier');
            // Determine filter year and month
            if (is_null($filterDate) || $filterDate == "null" || empty($filterDate)) {
                $currentDate = Carbon::now();
                $filterYear = $currentDate->year;
                $filterMonth = $currentDate->month;
            } else {
                $filterYear = Carbon::parse($filterDate)->year;
                $filterMonth = Carbon::parse($filterDate)->month;
            }

            // Calculate the start and end date of the given month
            $startDate = Carbon::create($filterYear, $filterMonth, 1)->startOfMonth()->toDateString();
            $endDate = Carbon::create($filterYear, $filterMonth, 1)->endOfMonth()->toDateString();

            $supplierUser = Auth::user();

            // Build the query
            $dailyCountsQuery = RcvHead::join('rcvdetail', 'rcvhead.id', '=', 'rcvdetail.rcvhead_id')
                ->join('ordhead', 'rcvhead.order_no', '=', 'ordhead.order_no')
                ->select([
                    'rcvhead.order_no',
                    DB::raw('DATE(receive_date) as tanggal'),
                    DB::raw('COUNT(DISTINCT rcvhead.id) as jumlah'),
                    DB::raw('SUM(rcvdetail.unit_cost * rcvdetail.qty_received + rcvdetail.vat_cost * rcvdetail.qty_received) as total_cost'),
                ])
                ->whereBetween('receive_date', [$startDate, $endDate])
                ->whereYear('ordhead.approval_date', $filterYear)
                ->whereMonth('ordhead.approval_date', $filterMonth)
                ->groupBy('rcvhead.order_no', 'tanggal')
                ->when($supplierUser->hasRole('supplier'), function ($query) use ($supplierUser) {
                    $query->where('rcvhead.supplier', $supplierUser->username);
                })
                ->when(!empty($filterSupplier), function ($query) use ($filterSupplier) {
                    $query->whereIn('rcvhead.supplier', (array) $filterSupplier);
                });

            // Get the results
            $dailyCounts = $dailyCountsQuery->get();

            // Calculate totals
            $totals = $dailyCounts->reduce(function ($carry, $item) {
                $carry['totalRcv'] += $item->jumlah;
                $carry['totalCostRcv'] += $item->total_cost;
                return $carry;
            }, ['totalRcv' => 0, 'totalCostRcv' => 0]);

            // Calculate performance metrics
            $totalCount = $dailyCounts->count(); // Total number of records
            $processedCount = $totalCount; // Assuming all fetched records are processed
            $successCount = $processedCount; // Assuming all processed records are successful
            $failCount = 0; // Assuming no failed records in this context

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
                'function_name' => 'Count Data RCV',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id
            ]);

            return [
                'totalRcv' => $totals['totalRcv'],
                'totalCostRcv' => $totals['totalCostRcv'],
                'month' => str_pad($filterMonth, 2, '0', STR_PAD_LEFT),
                'year' => (string)$filterYear,
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






    public function countDataRcvPerDays(Request $request){
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;
            $total = $this->rcvService->countDataRcvPerDays($filterDate, $filterSupplier);

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'countDataPo',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);

            return response()->json([
                'success' => true,
                'total' => $total,
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

}
