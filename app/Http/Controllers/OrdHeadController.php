<?php

namespace App\Http\Controllers;

use App\Models\QueryPerformanceLog;
use App\Services\Order\OrderService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function data(Request $request)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;
            $data = $this->orderService->data($filterDate, $filterSupplier);

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Show Data PO',
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
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
