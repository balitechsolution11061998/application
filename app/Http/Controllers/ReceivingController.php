<?php

namespace App\Http\Controllers;

use App\Models\RcvDetail;
use App\Models\RcvHead;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReceivingController extends Controller
{
    //
    public function index(){
        return view('rcv.index');
    }
    public function data(Request $request)
    {
        // Query to get the receiving head data
        $query = RcvHead::with('details'); // Assuming you have a relationship defined

        // Apply filters if any
        if ($request->has('order_no') && $request->order_no != '') {
            $query->where('order_no', 'like', '%' . $request->order_no . '%');
        }

        if ($request->has('filterDate') && $request->filterDate != '') {
            $dates = explode(' - ', $request->filterDate);
            $query->whereBetween('approval_date', [trim($dates[0]), trim($dates[1])]);
        }

        return DataTables::of($query)
        ->addColumn('action', function ($row) {
            return '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-docs-datatable-subtable="expand_row">
                        <span class="svg-icon fs-3 m-0 toggle-off">...</span>
                        <span class="svg-icon fs-3 m-0 toggle-on">...</span>
                    </button>';
        })

            ->make(true);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $rcv = $request->input('rcv');
        foreach ($rcv as $rcv) {
            // Create a new receiving record
            $receiving = RcvHead::create([
                'receive_no' => $rcv['receive_no'],
                'receive_date' => $rcv['receive_date'],
                'created_date' => $rcv['created_date'],
                'receive_id' => $rcv['receive_id'],
                'order_no' => $rcv['order_no'],
                'order_type' => $rcv['order_type'],
                'status_ind' => $rcv['status_ind'],
                'approval_date' => $rcv['approval_date'],
                'approval_id' => $rcv['approval_id'],
                'store' => $rcv['store'],
                'store_name' => $rcv['store_name'],
                'supplier' => $rcv['supplier'],
                'sup_name' => $rcv['sup_name'],
                'comment_desc' => $rcv['comment_desc'],
                'status' => $rcv['status'],
                'sub_total' => $rcv['sub_total'],
                'sub_total_vat_cost' => $rcv['sub_total_vat_cost'],
                'average_service_level' => $rcv['average_service_level'],
                // Add other necessary fields
            ]);

            // Insert related details
            foreach ($rcv['rcv_detail'] as $detail) {
                RcvDetail::create([
                    'rcvhead_id' => $receiving->id, // Foreign key to RcvHead
                    'receive_no' => $detail['receive_no'],
                    'store' => $detail['store'],
                    'sku' => $detail['sku'],
                    'upc' => $detail['upc'],
                    'sku_desc' => $detail['sku_desc'],
                    'qty_expected' => $detail['qty_expected'],
                    'qty_received' => $detail['qty_received'],
                    'unit_cost' => $detail['unit_cost'],
                    'unit_cost_disc' => $detail['unit_cost_disc'],
                    'vat_cost' => $detail['vat_cost'],
                    'unit_retail' => $detail['unit_retail'],
                    'service_level' => $detail['service_level'],
                    'created_at' => $detail['created_at'], // Optional: if you want to set created_at
                    'updated_at' => $detail['updated_at'], // Optional: if you want to set updated_at
                    // Add other necessary fields
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data inserted successfully']);
    }
}
