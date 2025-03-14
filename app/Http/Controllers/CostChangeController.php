<?php

namespace App\Http\Controllers;

use App\Models\CcextDetail;
use App\Models\CcextHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class CostChangeController extends Controller
{
    public function store(Request $request)
    {
        // Start time measurement
        $startTime = microtime(true);

        // Get initial memory usage
        $initialMemory = memory_get_usage();

        // Validate the incoming request with custom messages
        $request->validate([
            'ccext_no' => 'required|integer',
            'ccext_desc' => 'required|string',
            'reason' => 'required|integer',
            'status' => 'required|integer',
            'active_date' => 'required|date', // Validate the date format
            'cost_change_detail' => 'required|array',
            'cost_change_detail.*.ccext_no' => 'required|integer',
            'cost_change_detail.*.supplier' => 'required|integer',
            'cost_change_detail.*.sku' => 'required|string',
            'cost_change_detail.*.unit_cost' => 'required|numeric',
            'cost_change_detail.*.old_unit_cost' => 'required|integer',
        ], [
            'ccext_no.required' => 'The cost change number is required.',
            'ccext_desc.required' => 'The description is required.',
            'reason.required' => 'The reason is required.',
            'status.required' => 'The status is required.',
            'active_date.required' => 'The active date is required.',
            'cost_change_detail.required' => 'Cost change details are required.',
            'cost_change_detail.*.ccext_no.required' => 'The cost change number for each detail is required.',
            'cost_change_detail.*.supplier.required' => 'The supplier for each detail is required.',
            'cost_change_detail.*.sku.required' => 'The SKU for each detail is required.',
            'cost_change_detail.*.unit_cost.required' => 'The unit cost for each detail is required.',
            'cost_change_detail.*.old_unit_cost.required' => 'The old unit cost for each detail is required.',
        ]);

        // Initialize arrays to track results
        $successfulInserts = [];
        $failedInserts = [];
        $successfulCount = 0; // Count of successful inserts
        $failedCount = 0; // Count of failed inserts

        try {
            // Update or create the head record
            $head = CcextHead::updateOrCreate(
                ['ccext_no' => $request->ccext_no],
                [
                    'ccext_no' => $request->ccext_no,
                    'ccext_desc' => $request->ccext_desc,
                    'reason' => $request->reason,
                    'status' => $request->status,
                    'active_date' => $request->active_date, // Ensure it's in YYYY-MM-DD format
                    'create_date' => now(),
                ]
            );

            // Chunk the cost_change_detail array into batches of 100
            $chunks = array_chunk($request->cost_change_detail, 100);

            foreach ($chunks as $chunk) {
                // Insert each chunk
                foreach ($chunk as $detail) {
                    try {
                        $insertedDetail = CcextDetail::updateOrCreate(
                            ['id' => $detail['id']], // Assuming 'id' is the unique identifier for the detail
                            [
                                'ccext_no' => $detail['ccext_no'],
                                'supplier' => $detail['supplier'],
                                'sku' => $detail['sku'],
                                'unit_cost' => $detail['unit_cost'],
                                'old_unit_cost' => $detail['old_unit_cost'],
                            ]
                        );
                        // Track successful inserts
                        $successfulInserts[] = $insertedDetail->id; // Store the ID of the inserted record
                        $successfulCount++; // Increment successful count
                    } catch (\Exception $e) {
                        // Track failed inserts
                        $failedInserts[] = [
                            'sku' => $detail['sku'], // Store the SKU of the failed insert
                            'error' => $e->getMessage(),
                        ];
                        $failedCount++; // Increment failed count
                    }
                }

                // Delay for 1 second to control the insertion rate
                sleep(1); // Sleep for 1 second
            }

            // Commit the transaction if everything is successful
            DB::commit();

            // Prepare the response
            return response()->json([
                'message' => 'Data processed successfully',
                'total_successful_count' => $successfulCount,
                'total_failed_count' => $failedCount,
                'successful_inserts' => $successfulInserts,
                'failed_inserts' => $failedInserts, // Return the SKUs of failed inserts
            ], 200);

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error activity
            activity()
                ->withProperties([
                    'execution_time' => microtime(true) - $startTime,
                    'memory_used' => memory_get_usage() - $initialMemory,
                    'error' => $e->getMessage(),
                ])
                ->log('Failed to process cost change data');

            return response()->json(['message' => 'Failed to process data', 'error' => $e->getMessage()], 500);
        }
    }



}
