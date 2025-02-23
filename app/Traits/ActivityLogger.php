<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\Activity;

trait ActivityLogger
{
    protected function logActivity($message, $subject = null, $event = 'login', Request $request = null, $startTime = null, $memoryBefore = null, $additionalProperties = [])
    {
        // Calculate execution time and memory usage if provided
        $executionTime = $startTime ? (microtime(true) - $startTime) : null;
        $memoryUsed = $memoryBefore ? (memory_get_usage() - $memoryBefore) : null;

        // Fetch IP address from the request
        $ipAddress = $request ? $request->ip() : null;

        // Fetch geolocation data using a geolocation service
        $location = $this->getGeoLocation($ipAddress);

        // Start building the activity log
        $activity = activity($event) // Set the event name
            ->causedBy(Auth::user()); // Associate the activity with the authenticated user

        if ($subject) {
            $activity->performedOn($subject); // Set the subject of the activity if provided
        }

        // Add properties to the activity log
        $properties = array_merge($additionalProperties, [
            'execution_time' => $executionTime,
            'memory_used' => $memoryUsed,
            'ip_address' => $ipAddress,
            'user_agent' => $request ? $request->userAgent() : null,
            'location' => $location, // Include location data
            'user_id' => Auth::id(), // Log the user ID
            'user_name' => Auth::user() ? Auth::user()->name : 'Guest', // Log the user name
        ]);

        $activity->withProperties($properties) // Add properties to the activity
            ->log($message); // Log the message
    }

    protected function getGeoLocation($ipAddress)
    {
        if (!$ipAddress) {
            return 'Unknown Location';
        }

        try {
            $response = file_get_contents("http://ip-api.com/json/{$ipAddress}");
            $data = json_decode($response, true);

            if ($data && $data['status'] === 'success') {
                return $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
            }
        } catch (\Exception $e) {
            return 'Failed to retrieve location';
        }

        return 'Unknown Location';
    }
}
