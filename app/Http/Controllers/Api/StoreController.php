<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    //
    public function get(Request $request)
    {
        try {
            // Define the columns you want to retrieve
            $columns = ['store', 'store_name', 'store_add1', 'store_add2', 'store_city', 'region'];

            // Retrieve the data from the store table, selecting the defined columns
            $storeData = DB::table('store')->select($columns)->get();

            // Return a success response with the retrieved data
            return response()->json([
                'message' => 'Data retrieved successfully',
                'success' => true,
                'data' => $storeData,
            ], 200);

        } catch (\Exception $e) {
            // Handle the exception, you can log it or return an error response
            return response()->json([
                'message' => 'An error occurred while retrieving data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function store(Request $request)
    {
        // Truncate the store table to start fresh
        DB::table('store')->truncate();

        $totalData = 0;
        $successCount = 0;
        $failureCount = 0;

        try {
            $data = $request->data; // Get all request data
            $totalData = count($data); // Total number of records

            foreach ($data as $record) {
                try {
                    // Create a new store record
                    Store::create([
                        'store' => (int) Arr::get($record, 'store', 0), // Ensure 'store' is an integer
                        'store_name' => Arr::get($record, 'store_name', ''),
                        'store_add1' => Arr::get($record, 'store_add1', ''),
                        'store_add2' => Arr::get($record, 'store_add2', ''),
                        'store_city' => Arr::get($record, 'store_city', ''),
                        'region' => (int) Arr::get($record, 'region', 0), // Ensure 'region' is an integer
                        // Add more fields if needed
                    ]);
                    $successCount++;

                    // Log successful activity with custom name and properties
                    activity()
                        ->performedOn(new Store())
                        ->causedBy(auth()->user()) // Optional: log the user who caused the action
                        ->withProperties(['record' => $record]) // Add record properties
                        ->log('Store record inserted successfully: {store_name}', ['store_name' => Arr::get($record, 'store_name')]);

                } catch (\Exception $e) {
                    // Increment failure count if there's an issue inserting this record
                    $failureCount++;

                    // Log failed activity with custom name and properties
                    activity()
                        ->performedOn(new Store())
                        ->causedBy(auth()->user()) // Optional: log the user who caused the action
                        ->withProperties(['record' => $record, 'error' => $e->getMessage()]) // Add record and error properties
                        ->log('Failed to insert store record: {store_name}', ['store_name' => Arr::get($record, 'store_name')]);
                }
            }

            // Return a success response with the counts
            return response()->json([
                'message' => 'Data processed successfully',
                'success' => true,
                'total_data' => $totalData,
                'success_count' => $successCount,
                'failure_count' => $failureCount,
            ], 200);

        } catch (\Exception $e) {
            // Handle the exception, log it, and return an error response
            Log::error('An error occurred while processing data: ' . $e->getMessage());

            // Log the overall failure with custom name and properties
            activity()
                ->causedBy(auth()->user()) // Optional: log the user who caused the action
                ->withProperties(['error' => $e->getMessage()]) // Add error properties
                ->log('An error occurred while processing data');

            return response()->json([
                'message' => 'An error occurred while processing data',
                'error' => $e->getMessage(),
                'total_data' => $totalData,
                'success_count' => $successCount,
                'failure_count' => $failureCount,
            ], 500);
        }
    }

}
