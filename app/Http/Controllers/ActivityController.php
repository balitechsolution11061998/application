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

                // Fetch activities, eager load the user relationship, and filter by action_type 'login' and today's date
                $activities = ActivityLog::with('user')
                    ->where('action_type', 'login')
                    ->whereDate('created_at', today()) // Filter by today's date
                    ->select('authentications_monitoring.*')
                    ->get(); // Get all records first

                // Group by user ID and get the first occurrence for each user
                $uniqueActivities = $activities->groupBy('user_id')->map(function ($group) {
                    return $group->first(); // Get the first activity for each user
                })->values(); // Reset keys

                // Adding location data based on IP for each user
                foreach ($uniqueActivities as $activity) {
                    // Fetch the user's IP
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    } else {
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }

                    // Get the geolocation information for the IP
                    $url = "https://tools.keycdn.com/geo.json?host=$ip";
                    $dt = file_get_contents($url);
                    $dt = json_decode($dt, true);

                    // Extract relevant location data
                    $lat = $dt['data']['geo']['latitude'];
                    $lng = $dt['data']['geo']['longitude'];
                    $regional = $dt['data']['geo']['region_name'];
                    $city_name = $dt['data']['geo']['city'];

                    // Combine city and region to form the location
                    $location = $city_name . " - " . $regional;

                    // Add location data to the activity
                    $activity->location = $location;
                }

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
                    ->addColumn('location', function ($activity) {
                        return $activity->location ?? 'Location not available'; // Display the location
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
