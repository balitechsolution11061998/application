<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $startTime = microtime(true); // Start timing

        $data = $request->input('data');

        // Initialize progress counters
        $totalCount = count($data);
        $processedCount = 0;
        $successCount = 0;
        $failCount = 0;
        $errors = [];

        $chunkSize = 10; // Size of data chunks for processing
        $delayInMicroseconds = 100000; // Delay to simulate processing time

        try {
            $chunks = array_chunk($data, $chunkSize);

            foreach ($chunks as $chunk) {
                $successCountChunk = 0;
                $failCountChunk = 0;
                $errorsChunk = [];

                foreach ($chunk as $dataItem) {
                    try {
                        // Prepare data for storing or updating
                        $storeData = [
                            "supp_code" => $dataItem['supp_code'] ?? null,
                            "supp_name" => $dataItem['supp_name'] ?? null,
                            "terms" => $dataItem['terms'] ?? null,
                            "contact_name" => $dataItem['contact_name'] ?? null,
                            "contact_phone" => $dataItem['contact_phone'] ?? null,
                            "contact_fax" => $dataItem['contact_fax'] ?? null,
                            "email" => $dataItem['email'] ?? null,
                            "address_1" => $dataItem['address_1'] ?? null,
                            "address_2" => $dataItem['address_2'] ?? null,
                            "city" => $dataItem['city'] ?? null,
                            "post_code" => $dataItem['post_code'] ?? null,
                            "tax_ind" => $dataItem['tax_ind'] ?? null,
                            "tax_no" => $dataItem['tax_no'] ?? null,
                            "retur_ind" => $dataItem['retur_ind'] ?? null,
                            "consig_ind" => $dataItem['consig_ind'] ?? null,
                            "status" => $dataItem['status'] ?? null,
                            "created_at" => $dataItem['created_at'] ?? now(),
                            "updated_at" => $dataItem['updated_at'] ?? now(),
                        ];

                        // Process supplier data
                        $uniqueAttributes = ["supp_code" => $dataItem['supp_code'] ?? null];
                        $existingRecord = DB::table('supplier')->where($uniqueAttributes)->first();

                        if ($existingRecord) {
                            DB::table('supplier')->where('id', $existingRecord->id)->update($storeData);
                        } else {
                            DB::table('supplier')->insert($storeData);
                        }

                        $successCountChunk++;

                    } catch (Exception $e) {
                        $failCountChunk++;
                        $errorsChunk[] = [
                            'supp_code' => $dataItem['supp_code'] ?? null,
                            'message' => $e->getMessage()
                        ];
                    }
                }

                // Update counters
                $processedCount += count($chunk);
                $successCount += $successCountChunk;
                $failCount += $failCountChunk;
                $errors = array_merge($errors, $errorsChunk);

                // Introduce delay
                usleep($delayInMicroseconds);
            }

        } catch (Exception $e) {
            $failCount++;
            $errors[] = [
                'supp_code' => null,
                'message' => $e->getMessage()
            ];
        }

        $endTime = microtime(true); // End timing
        $executionTime = $endTime - $startTime; // Calculate execution time

        // Determine status
        $status = $executionTime < 5 ? 'fast' : 'slow'; // Adjust the threshold as needed

        // Insert performance metrics into the database
        DB::table('performance_analysis')->insert([
            'total_count' => $totalCount,
            'processed_count' => $processedCount,
            'success_count' => $successCount,
            'fail_count' => $failCount,
            'errors' => json_encode($errors), // Encode errors array as JSON
            'execution_time' => $executionTime,
            'status' => $status
        ]);

        // Return a response indicating the processing results
        return response()->json([
            'status' => 'success',
            'message' => 'Data processed',
            'progress' => [
                'total_count' => $totalCount,
                'processed_count' => $processedCount,
                'success_count' => $successCount,
                'fail_count' => $failCount,
                'errors' => $errors
            ],
            'execution_time' => $executionTime, // Include execution time in the response
            'status' => $status // Include status in the response
        ]);
    }
}
