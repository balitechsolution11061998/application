<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    //
    public function getData()
    {
        // Fetch activities, eager load the user relationship, and filter by action_type 'login'
        $activities = ActivityLog::with('user')
            ->where('action_type', 'login')
            ->select('authentications_monitoring.*')
            ->get(); // Get all records first

        // Group by user ID and get the first occurrence for each user
        $uniqueActivities = $activities->groupBy('user_id')->map(function ($group) {
            return $group->first(); // Get the first activity for each user
        })->values(); // Reset keys

        return DataTables::of($uniqueActivities)
            ->addIndexColumn() // Add this line to include an index column
            ->addColumn('user', function ($activity) {
                return $activity->user ? $activity->user->name : 'N/A'; // Adjust 'name' to the actual field in User model
            })
            ->addColumn('action', function ($activity) {
                return '<button class="btn btn-sm btn-danger delete" data-id="' . $activity->id . '">Delete</button>';
            })
            ->make(true);
    }
}
