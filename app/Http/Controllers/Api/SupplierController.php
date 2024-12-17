<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity; // Import the Activity model
class SupplierController extends Controller
{


    //
    public function store(Request $request)
    {
        $data = $request->data;
        $response = [];
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            foreach ($data as $key => $value) {
                // Check if the supplier already exists
                $cekDataSupplier = DB::table('supplier')->where('supp_code', $value['supp_code'])->first();

                // Prepare the data to be inserted/updated
                $dataInsert = [
                    'supp_name' => $value['supp_name'],
                    'terms' => $value['terms'],
                    'contact_name' => $value['contact_name'],
                    'contact_phone' => $value['contact_phone'],
                    'contact_fax' => $value['contact_fax'],
                    'address_1' => $value['address_1'],
                    'address_2' => $value['address_2'],
                    'city' => $value['city'],
                    'tax_ind' => $value['tax_ind'],
                    'consig_ind' => $value['consig_ind'],
                    'status' => $value['status'],
                ];

                // Handle optional fields
                $dataInsert['post_code'] = ($value['post_code'] != '-----') ? $value['post_code'] : null;
                $dataInsert['tax_no'] = (!empty($value['collect_tax_no'])) ? $value['collect_tax_no'] : "N";

                if ($cekDataSupplier != null) {
                    // Update existing supplier
                    DB::table('supplier')
                        ->where('id', $cekDataSupplier->id)
                        ->update($dataInsert);

                    $response = [
                        'message' => 'Supplier berhasil diperbaharui',
                        'status' => true,
                        'success' => true,
                    ];
                } else {
                    // Insert new supplier
                    $dataInsert['supp_code'] = $value['supp_code']; // Only set supp_code for new records
                    DB::table('supplier')->insert($dataInsert);

                    $response = [
                        'message' => 'Sukses menambahkan supplier',
                        'status' => true,
                        'success' => true,
                    ];
                }
            }

            // Log successful operation
            $executionTimeMs = round((microtime(true) - $startTime) * 1000, 2); // Time in ms
            $memoryUsageM = round((memory_get_usage() - $startMemory) / 1024 / 1024, 2); // Memory in MB

            activity()
                ->causedBy(Auth::user()) // Log the user who triggered the action
                ->withProperties([
                    'execution_time' => $executionTimeMs . " MS",
                    'memory_usage' => $memoryUsageM . " MB",
                    'timestamp' => now(),
                    'log_name' => 'Supplier Data Store', // Custom log name
                ])
                ->log('Successfully processed supplier data'); // Custom log message

        } catch (\Exception $e) {
            // Return an error response
            $response = [
                'message' => 'Error processing supplier data: ' . $e->getMessage(),
                'status' => false,
            ];

            // Log the error
            $executionTimeMs = round((microtime(true) - $startTime) * 1000, 2); // Time in ms
            $memoryUsageM = round((memory_get_usage() - $startMemory) / 1024 / 1024, 2); // Memory in MB

            activity()
                ->causedBy(Auth::user()) // Log the user who triggered the action
                ->withProperties([
                    'execution_time' => $executionTimeMs . " MS",
                    'memory_usage' => $memoryUsageM . " MB",
                    'timestamp' => now(),
                    'log_name' => 'Supplier Data Store Error', // Custom log name for error
                ])
                ->log('Error processing supplier data: ' . $e->getMessage()); // Custom log message for error
        }

        return response()->json($response);
    }

    public function data(Request $request)
    {
        // Initialize the response array
        $response = [
            'data' => [],
            'status' => true,
            'message' => 'Data retrieved successfully.',
        ];

        try {
            // Query the suppliers table with an orderBy clause
            $query = DB::table('supplier')->orderBy('id'); // Specify the order by clause

            // Chunk the data to handle large datasets
            $chunkSize = 1000; // Define the size of each chunk
            $query->chunk($chunkSize, function ($suppliers) use (&$response) {
                foreach ($suppliers as $supplier) {
                    $response['data'][] = [
                        'id' => $supplier->id,
                        'supp_code' => $supplier->supp_code,
                        'supp_name' => $supplier->supp_name,
                        'terms' => $supplier->terms,
                        'contact_name' => $supplier->contact_name,
                        'contact_phone' => $supplier->contact_phone,
                        'contact_fax' => $supplier->contact_fax,
                        'address_1' => $supplier->address_1,
                        'address_2' => $supplier->address_2,
                        'city' => $supplier->city,
                        'post_code' => $supplier->post_code,
                        'tax_no' => $supplier->tax_no,
                        'tax_ind' => $supplier->tax_ind,
                        'consig_ind' => $supplier->consig_ind,
                        'status' => $supplier->status,
                    ];
                }
            });

            // Log the activity
            activity()
                ->causedBy($request->user()) // Log the user who caused the activity
                ->log('Retrieved supplier data successfully.'); // Log the activity message

        } catch (\Exception $e) {
            // Handle any errors that occur during the query
            $response['status'] = false;
            $response['message'] = 'Error retrieving supplier data: ' . $e->getMessage();

            // Log the error
            activity()
                ->causedBy($request->user()) // Log the user who caused the error
                ->log('Error retrieving supplier data: ' . $e->getMessage()); // Log the error message
        }

        // Return the response as JSON
        return response()->json($response);
    }



}
