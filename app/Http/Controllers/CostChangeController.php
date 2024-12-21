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
            'active_date' => 'required|date_format:d-M-y', // Validate the date format
            'cost_change_detail' => 'required|array',
            'cost_change_detail.*.ccext_no' => 'required|integer',
            'cost_change_detail.*.supplier' => 'required|integer',
            'cost_change_detail.*.sku' => 'required|string',
            'cost_change_detail.*.unit_cost' => 'required|numeric',
            'cost_change_detail.*.old_unit_cost' => 'required|integer',
        ]);

        try {
            // Create DateTime object from the validated active_date
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
                    'active_date' => $activeDate->format('Y-m-d'), // Convert to YYYY-MM-DD
                    'create_date' => now(),
                ]
            );

            // ... rest of your code remains unchanged

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
