<?php

namespace App\Http\Controllers;

use App\Models\CcextDetail;
use App\Models\CcextHead;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class CostChangeController extends Controller
{
    //
    public function store(Request $request)
    {
        // Start time measurement
        $startTime = microtime(true);

        // Get initial memory usage
        $initialMemory = memory_get_usage();

        // Validate the incoming request
        $request->validate([
            'cost_change_no' => 'required|integer',
            'cost_change_desc' => 'required|string',
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

            // Insert into ccext_head
            $head = CcextHead::create([
                'cost_change_no' => $request->cost_change_no,
                'cost_change_desc' => $request->cost_change_desc,
                'reason' => $request->reason,
                'status' => $request->status,
                'active_date' => $activeDate->format('Y-m-d'), // Convert to YYYY-MM-DD
                'create_date' => now(),
            ]);

            $successCount = 0;
            $failureCount = 0;
            $failedDetails = [];

            // Insert into ccext_detail
            foreach ($request->cost_change_detail as $detail) {
                try {
                    CcextDetail::create([
                        'ccext_no' => $detail['ccext_no'],
                        'supplier' => $detail['supplier'],
                        'sku' => $detail['sku'],
                        'unit_cost' => $detail['unit_cost'],
                        'old_unit_cost' => $detail['old_unit_cost'],
                        'created_at' => now(),
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    $failureCount++;
                    $failedDetails[] = [
                        'detail' => $detail,
                        'error' => $e->getMessage(),
                    ];
                }
            }

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
                ->log('Inserted cost change data successfully');

            return response()->json([
                'message' => 'Data processed successfully',
                'success_count' => $successCount,
                'failure_count' => $failureCount,
                'failed_details' => $failedDetails,
            ], 201);
        } catch (\Exception $e) {
            // Log the error activity
            activity()
                ->withProperties([
                    'execution_time' => microtime(true) - $startTime,
                    'memory_used' => memory_get_usage() - $initialMemory,
                    'error' => $e->getMessage(),
                ])
                ->log('Failed to insert cost change data');

            return response()->json(['message' => 'Failed to insert data', 'error' => $e->getMessage()], 500);
        }
    }


}
