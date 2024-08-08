<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    //
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
                        // Prepare data for store
                        $storeData = [
                            "store" => $dataItem['store'] ?? null,
                            "store_name" => $dataItem['store_name'] ?? null,
                            "store_add1" => $dataItem['store_add1'] ?? null,
                            "store_add2" => $dataItem['store_add2'] ?? null,
                            "store_city" => $dataItem['store_city'] ?? null,
                            "region" => $dataItem['region'] ?? null,
                        ];

                        // Process store data
                        $uniqueAttributes = ["store" => $dataItem['store'] ?? null];
                        $existingRecord = DB::table('store')->where($uniqueAttributes)->first();

                        if ($existingRecord) {
                            DB::table('store')->where('id', $existingRecord->id)->update($storeData);
                        } else {
                            DB::table('store')->insert($storeData);
                        }

                        $successCountChunk++;

                    } catch (Exception $e) {
                        $failCountChunk++;
                        $errorsChunk[] = [
                            'store' => $dataItem['store'] ?? null,
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
                'store' => null,
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
