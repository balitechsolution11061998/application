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

        // Validate the incoming request
        $request->validate([
            'ccext_no' => 'required|integer',
            'ccext_desc' => 'required|string',
            'reason' => 'required|integer',
            'status' => 'required|integer',
            'active_date' => 'required|date',
            'cost_change_detail' => 'required|array',
            'cost_change_detail.*.ccext_no' => 'required|integer',
            'cost_change_detail.*.supplier' => 'required|integer',
            'cost_change_detail.*.sku' => 'required|string',
            'cost_change_detail.*.unit_cost' => 'required|numeric',
            'cost_change_detail.*.old_unit_cost' => 'required|integer',
        ]);

        try {
            $activeDate = \DateTime::createFromFormat('d-M-y', $request->active_date);
            if (!$activeDate) {
                throw new \Exception('Invalid date format for active_date. Expected format: d-M-y');
            }

            // Update or create the head record
            $head = CcextHead::updateOrCreate(
                ['ccext_no' => $request->ccext_no],
                [
                    'ccext_no' => $request->ccext_no,
                    'ccext_desc' => $request->ccext_desc,
                    'reason' => $request->reason,
                    'status' => $request->status,
                    'active_date' => $activeDate->format('Y-m-d'),
                    'create_date' => now(),
                ]
            );

            $successCount = 0;
            $failureCount = 0;
            $failedDetails = [];

            // Start a transaction
            DB::beginTransaction();

            // Delete existing details that are not in the incoming request
            $existingDetails = CcextDetail::where('ccext_no', $request->ccext_no)->get();
            $existingCcextNos = $existingDetails->pluck('ccext_no')->toArray();

            // Delete records that are not present in the incoming request
            foreach ($existingCcextNos as $existingCcextNo) {
                if (!in_array($existingCcextNo, array_column($request->cost_change_detail, 'ccext_no'))) {
                    try {
                        CcextDetail::where('ccext_no', $existingCcextNo)->delete();
                        $successCount++; // Increment success count for deletion
                    } catch (\Exception $e) {
                        $failureCount++;
                        $failedDetails[] = [
                            'detail' => ['ccext_no' => $existingCcextNo],
                            'error' => 'Failed to delete record: ' . $e->getMessage(),
                        ];
                    }
                }
            }

            // Prepare data for batch insertion
            $insertData = [];
            foreach ($request->cost_change_detail as $detail) {
                $insertData[] = [
                    'ccext_no' => $detail['ccext_no'], // Unique identifier
                    'supplier' => $detail['supplier'],
                    'sku' => $detail['sku'],
                    'unit_cost' => $detail['unit_cost'],
                    'old_unit_cost' => $detail['old_unit_cost'],
                    'created_at' => now(), // Set created_at for new records
                    'updated_at' => now(), // Set updated_at for new records
                ];
            }

            // Perform batch insert
            if (!empty($insertData)) {
                try {
                    CcextDetail::insert($insertData);
                    $successCount += count($insertData); // Increment success count for insertions
                } catch (\Exception $e) {
                    $failureCount++;
                    $failedDetails[] = [
                        'detail' => 'Batch insert failed',
                        'error' => $e->getMessage(),
                    ];
                }
            }

            // Commit the transaction
            DB::commit();

            // Log the successful activity
            activity()
                ->performedOn($head)
                ->withProperties([
                    'execution_time' => microtime(true) - $startTime,
                    'memory_used' => memory_get_usage() - $initialMemory,
                    'success_count' => $successCount,
                    'failure_count' => $failureCount,
                    'failed_details' => $failedDetails,
                ])
                ->log('Processed cost change data successfully');

            return response()->json([
                'message' => 'Data processed successfully',
                'success_count' => $successCount,
                'failure_count' => $failureCount,
                'failed_details' => $failedDetails,
            ], 200); // Changed to 200 for successful updates
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
