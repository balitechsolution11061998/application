<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Spatie\Activitylog\Facades\Activity; // Ensure you import the Activity facade

trait IpGeolocationTrait
{
    private function getAddressFromIp($ipAddress,Request $request = null)
    {
        if (!$ipAddress) {
            return 'Unknown Location';
        }

        try {
            // Using ip-api.com for geolocation
            $response = file_get_contents("http://ip-api.com/json/{$ipAddress}");
            $data = json_decode($response, true);

            if ($data && $data['status'] === 'success') {
                // Construct and return the formatted address
                $formattedAddress = $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];

                // Log the successful geolocation retrieval
                $this->logActivity('IP Geolocation Successful', null, 'ip_geolocation', $request, null, null);

                return $formattedAddress;
            } else {
                // Log if the response was not successful
                $this->logActivity('IP Geolocation Failed', null, 'ip_geolocation', $request, null, null);
            }
        } catch (\Exception $e) {
            // Log the exception using the logActivity method
            $this->logActivity('IP Geolocation Exception', null, 'ip_geolocation', $request, null, null);
        }

        return 'Unknown Location'; // Fallback if the request fails or no data is found
    }
}
