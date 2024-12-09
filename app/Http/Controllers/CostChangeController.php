<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CostChangeController extends Controller
{
    //
    public function store(Request $request)
    {
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

        // Insert into ccext_head
        $head = CcextHead::create([
            'cost_change_no' => $request->cost_change_no,
            'cost_change_desc' => $request->cost_change_desc,
            'reason' => $request->reason,
            'status' => $request->status,
            'active_date' => $request->active_date,
            'create_date' => now(),
        ]);

        // Insert into ccext_detail
        foreach ($request->cost_change_detail as $detail) {
            CcextDetail::create([
                'ccext_no' => $detail['ccext_no'],
                'supplier' => $detail['supplier'],
                'sku' => $detail['sku'],
                'unit_cost' => $detail['unit_cost'],
                'old_unit_cost' => $detail['old_unit_cost'],
                'created_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Data inserted successfully'], 201);
    }
}
