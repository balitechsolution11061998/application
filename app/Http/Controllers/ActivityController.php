<?php

namespace App\Http\Controllers;

use App\Helpers\SystemUsageHelper;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    //
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Start timing and memory tracking
                $startTime = microtime(true);
                $startMemory = memory_get_usage();

                // Fetch activities, eager load the user relationship, and filter by action_type 'login'
                $activities = ActivityLog::with('user')
                    ->where('action_type', 'login')
                    ->select('authentications_monitoring.*')
                    ->get(); // Get all records first

                // Group by user ID and get the first occurrence for each user
                $uniqueActivities = $activities->groupBy('user_id')->map(function ($group) {
                    return $group->first(); // Get the first activity for each user
                })->values(); // Reset keys

                // Prepare data for DataTables
                $result = DataTables::of($uniqueActivities)
                    ->addIndexColumn() // Add index column
                    ->addColumn('user', function ($activity) {
                        return $activity->user ? $activity->user->name : 'N/A'; // Adjust 'name' to the actual field in User model
                    })
                    ->addColumn('action', function ($activity) {
                        return '<button class="btn btn-sm btn-danger delete" data-id="' . $activity->id . '">Delete</button>';
                    })
                    ->addColumn('timestamp', function ($activity) {
                        // Return formatted timestamp of the activity
                        return $activity->created_at->format('Y-m-d H:i:s');
                    })
                    ->make(true);

                // Log memory usage and load time using the helper function
                SystemUsageHelper::logUsage($startTime, $startMemory);

                // Return the result to DataTables
                return $result;
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching data. ' . $e->getMessage()], 500);
            }
        }
    }

}
