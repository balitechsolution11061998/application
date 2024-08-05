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
        if (Auth::check() && Auth::user()->hasRole('superadministrator')) {
            return view('home');
        }elseif (Auth::user()->hasRole('admin_karyawan')) {
            return redirect()->route('home.epresensi'); // Replace 'home2.route' with the actual route name for the karyawan view
        }
        elseif (Auth::user()->hasRole('karyawan')) {
            return redirect()->route('home.epresensi'); // Replace 'home2.route' with the actual route name for the karyawan view
        } elseif (Auth::user()->hasRole('admin_cbt')) {
            return redirect()->route('home.cbt'); // Replace 'home3.route' with the actual route name for the siswa view
        }elseif (Auth::user()->hasRole('siswa')) {
            return redirect()->route('home.cbt'); // Replace 'home3.route' with the actual route name for the siswa view
        }elseif (Auth::user()->hasRole('guru')) {
            return redirect()->route('home.cbt'); // Replace 'home3.route' with the actual route name for the siswa view
        }
    }

    public function index2()
    {
            return view('home2');

    }

    public function index3()
    {
            return view('home3');

    }


    public function countDataPoPerDays(Request $request){
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;
            $data = $this->orderService->countDataPoPerDays($filterDate, $filterSupplier);

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data PO Per Days',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);

            return response()->json([
                'success' => true,
                'data' => $data,
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

    public function countDataPoPerDate(Request $request)
    {
        $date = $request->query('date'); // Get the date parameter from the request
        $status = $request->query('status'); // Get the status parameter from the request

        try {
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

            // Check and update statuses based on conditions
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
            }

            // Fetch the updated data after status updates
            $data = $query->get();

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




    public function countDataPo(Request $request) {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;
            $total = $this->orderService->countDataPo($filterDate, $filterSupplier);

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data Purchase Order',
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

    public function countDataRcv(Request $request) {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;
            $total = $this->rcvService->countDataRcv($filterDate, $filterSupplier);

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'countDataRcv',
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
