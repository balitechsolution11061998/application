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
                    $newStore = Store::create([
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
                        ->performedOn($newStore) // Set the subject to the newly created store
                        ->causedBy(auth()->user()) // Log the user who caused the action
                        ->withProperties([
                            'record' => $record,
                            'event' => 'insert', // Custom event name
                            'subject_id' => $newStore->id, // ID of the created store
                            'causer_type' => get_class(auth()->user()), // Type of the causer (e.g., User)
                            'causer_id' => auth()->user()->id, // ID of the causer
                        ])
                        ->log('Store record inserted successfully: {store_name}', ['store_name' => Arr::get($record, 'store_name')]);
                } catch (\Exception $e) {
                    // Increment failure count if there's an issue inserting this record
                    $failureCount++;

                    // Log failed activity with custom name and properties
                    activity()
                        ->performedOn(new Store()) // Set the subject to a new Store instance (not saved)
                        ->causedBy(auth()->user()) // Log the user who caused the action
                        ->withProperties([
                            'record' => $record,
                            'error' => $e->getMessage(),
                            'event' => 'insert_failed', // Custom event name for failure
                            'subject_id' => null, // No subject ID since the insert failed
                            'causer_type' => get_class(auth()->user()), // Type of the causer
                            'causer_id' => auth()->user()->id, // ID of the causer
                        ])
                        ->log('Failed to insert store record: {store_name}', ['store_name' => Arr::get($record, 'store_name')]);

                    // Optionally, you can log the error to the default log for further debugging
                    Log::error('Failed to insert store record: ' . Arr::get($record, 'store_name') . ' Error: ' . $e->getMessage());
                }
            }

            // Return a success response with the counts
            return response()->json([
                'message' => 'Data processed successfully',
                'success' => true,
                'total_data' => $totalData,
                'success_count' => $success Count,
                'failure_count' => $failureCount,
            ], 200);
        } catch (\Exception $e) {
            // Handle the exception, log it, and return an error response

            // Log the overall failure with custom name and properties
            activity()
                ->causedBy(auth()->user()) // Log the user who caused the action
                ->withProperties([
                    'error' => $e->getMessage(),
                    'event' => 'processing_failed', // Custom event name for overall failure
                    'subject_id' => null, // No subject ID since the process failed
                    'causer_type' => get_class(auth()->user()), // Type of the causer
                    'causer_id' => auth()->user()->id, // ID of the causer
                ])
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
