<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRcvJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RcvController extends Controller
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

        $chunkSize = 1000;
        $delayInMicroseconds = 100000;

        try {
            $chunks = array_chunk($data, $chunkSize);

            foreach ($chunks as $chunk) {
                $successCountChunk = 0;
                $failCountChunk = 0;
                $errorsChunk = [];

                foreach ($chunk as $dataItem) {
                    try {
                        // Prepare data for rcvhead
                        $rcvHeadData = [
                            "receive_no" => $dataItem['receive_no'] ?? 'unknown',
                            "receive_date" => $dataItem['receive_date'] ?? null,
                            "created_date" => $dataItem['created_date'] ?? null,
                            "receive_id" => $dataItem['receive_id'] ?? null,
                            "order_no" => $dataItem['order_no'] ?? null,
                            "ref_no" => $dataItem['ref_no'] ?? null,
                            "order_type" => $dataItem['order_type'] ?? null,
                            "status_ind" => $dataItem['status_ind'] ?? null,
                            "approval_date" => $dataItem['approval_date'] ?? null,
                            "approval_id" => $dataItem['approval_id'] ?? null,
                            "store" => $dataItem['store'] ?? null,
                            "store_name" => $dataItem['store_name'] ?? null,
                            "supplier" => $dataItem['supplier'] ?? null,
                            "sup_name" => $dataItem['sup_name'] ?? null,
                            "comment_desc" => $dataItem['comment_desc'] ?? null,
                            "sub_total_vat_cost" => $dataItem['sub_total_vat_cost'] ?? null,
                            "sub_total" => $dataItem['sub_total'] ?? null,
                            "average_service_level" => $dataItem['average_service_level'] ?? null,
                        ];

                        // Process rcvhead
                        $uniqueAttributes = ["receive_no" => $dataItem['receive_no'] ?? 'unknown'];
                        $existingRecord = DB::table('rcvhead')->where($uniqueAttributes)->first();

                        if ($existingRecord) {
                            DB::table('rcvhead')->where('id', $existingRecord->id)->update($rcvHeadData);
                            $rcvHeadId = $existingRecord->id;
                        } else {
                            $rcvHeadId = DB::table('rcvhead')->insertGetId(array_merge($uniqueAttributes, $rcvHeadData));
                        }

                        // Process rcvdetail
                        foreach ($dataItem['rcv_detail'] as $detail) {
                            $rcvSkuData = [
                                "rcvhead_id" => $rcvHeadId,
                                "receive_no" => $dataItem['receive_no'] ?? 'unknown',
                                "sku" => $detail['sku'] ?? 'unknown',
                                "sku_desc" => $detail['sku_desc'] ?? null,
                                "upc" => $detail['upc'] ?? null,
                                "qty_expected" => $detail['qty_expected'] ?? 0,
                                "qty_received" => $detail['qty_received'] ?? 0,
                                "unit_cost" => $detail['unit_cost'] ?? 0,
                                "unit_retail" => $detail['unit_retail'] ?? 0,
                                "vat_cost" => $detail['vat_cost'] ?? 0,
                                "unit_cost_disc" => $detail['unit_cost_disc'] ?? 0,
                                "service_level" => $detail['qty_expected'] > 0 ? ($detail['qty_received'] / $detail['qty_expected']) * 100 : 0,
                            ];

                            DB::table('rcvdetail')->updateOrInsert(
                                [
                                    "receive_no" => $dataItem['receive_no'] ?? 'unknown',
                                    "sku" => $detail['sku'] ?? 'unknown',
                                    "upc" => $detail['upc'] ?? null
                                ],
                                $rcvSkuData
                            );
                        }

                        $successCountChunk++;

                    } catch (Exception $e) {
                        $failCountChunk++;
                        $errorsChunk[] = [
                            'receive_no' => $dataItem['receive_no'] ?? 'unknown',
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
                'receive_no' => 'unknown',
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
