<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Models\Activity;

class ActivityLogContoller extends Controller
{
    //

    public function index()
    {
        return view('activity_logs.index');
    }

    public function data(Request $request)
    {
        // Start the query for activity logs
        $logs = Activity::with(['causer', 'subject']) // Eager load relationships
            ->select('id', 'log_name', 'description', 'subject_type', 'event', 'subject_id', 'causer_type', 'causer_id', 'properties', 'batch_uuid', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc'); // Order by created_at in descending order

        // Apply filtering based on request parameters
        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $logs->where(function ($query) use ($searchValue) {
                $query->where('log_name', 'like', "%{$searchValue}%")
                    ->orWhere('description', 'like', "%{$searchValue}%")
                    ->orWhere('subject_type', 'like', "%{$searchValue}%")
                    ->orWhere('event', 'like', "%{$searchValue}%");
            });
        }

        // Return the DataTables response
        return DataTables::of($logs)
            ->addIndexColumn()
            ->editColumn('created_at', function ($log) {
                return $log->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($log) {
                return $log->updated_at->format('Y-m-d H:i:s');
            })
            ->editColumn('subject.order_no', function ($log) {
                // Check if the subject exists and has order_no
                if ($log->subject) {
                    if ($log->subject_type === 'App\\Models\\OrdHead') {
                        return $log->subject->order_no ?? 'N/A'; // Assuming OrdHead has order_no
                    } elseif ($log->subject_type === 'App\\Models\\ItemSupplier') {
                        return $log->subject->order_no ?? 'N/A'; // Assuming ItemSupplier has order_no
                    }
                }
                return 'N/A'; // Default if no subject or order_no
            })
            ->make(true);
    }


}
