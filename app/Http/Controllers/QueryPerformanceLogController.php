<?php

namespace App\Http\Controllers;

use App\Models\QueryPerformanceLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class QueryPerformanceLogController extends Controller
{

    public function getChartData()
    {
        // Fetch the data from the database
        $data = QueryPerformanceLog::query()
            ->select([
                'function_name',
                DB::raw('AVG(execution_time) as avg_execution_time'),
                DB::raw('AVG(ping) as avg_ping'),
                DB::raw('AVG(memory_usage) as avg_memory_usage') // Add this line
            ])
            ->groupBy('function_name')
            ->get();

        // Prepare data for chart
        $chartData = [
            'labels' => $data->pluck('function_name')->toArray(),
            'executionTimes' => $data->pluck('avg_execution_time')->toArray(),
            'pings' => $data->pluck('avg_ping')->toArray(),
            'memoryUsages' => $data->pluck('avg_memory_usage')->toArray() // Add this line
        ];

        // Return the data as JSON
        return response()->json($chartData);
    }


    public function getLogs(Request $request)
    {
        if ($request->ajax()) {
            // Query to get grouped data and calculate averages
            $data = QueryPerformanceLog::query()
                ->select([
                    'function_name',
                    DB::raw('AVG(execution_time) as avg_execution_time'),
                    DB::raw('AVG(ping) as avg_ping'),
                    DB::raw('AVG(download_speed) as avg_download_speed'),
                    DB::raw('AVG(upload_speed) as avg_upload_speed')
                ])
                ->groupBy('function_name')
                ->get();

            // Format the data for DataTables
            $dataTable = DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('avg_execution_time', function ($row) {
                    return number_format($row->avg_execution_time, 2) . ' ms';
                })
                ->editColumn('avg_ping', function ($row) {
                    return $row->avg_ping ? number_format($row->avg_ping, 2) . ' ms' : 'N/A';
                })
                ->editColumn('avg_download_speed', function ($row) {
                    return $row->avg_download_speed ? number_format($row->avg_download_speed, 2) . ' Mbps' : 'N/A';
                })
                ->editColumn('avg_upload_speed', function ($row) {
                    return $row->avg_upload_speed ? number_format($row->avg_upload_speed, 2) . ' Mbps' : 'N/A';
                })
                ->make(true);

            return $dataTable;
        }
    }
}
