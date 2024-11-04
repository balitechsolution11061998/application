<?php

namespace App\Http\Controllers;

use App\Models\OrdHead;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function data(Request $request)
    {
        if ($request->ajax()) {
            // Start the query with necessary joins and selects
            $data = OrdHead::with(['ordsku', 'store', 'supplier']) // Eager load relationships
                ->select('ordhead.*') // Select necessary columns from ordhead
                ->join('store', 'ordhead.ship_to', '=', 'store.store') // Join with stores
                ->join('supplier', 'ordhead.supplier', '=', 'supplier.supp_code') // Join with suppliers
                ->select('ordhead.*', 'store.store_name as store_name', 'supplier.supp_name as supp_name'); // Select additional fields

            return DataTables::of($data)
                ->addColumn('action', function($row) {
                    return '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-docs-datatable-subtable="expand_row">
                                <span class="svg-icon fs-3 m-0 toggle-off">...</span>
                                <span class="svg-icon fs-3 m-0 toggle-on">...</span>
                            </button>';
                })
                ->editColumn('total_cost', function($row) {
                    return '$' . number_format($row->total_cost, 2);
                })
                ->editColumn('total_retail', function($row) {
                    return '$' . number_format($row->total_retail, 2);
                })
                ->rawColumns(['status', 'action']) // Allow HTML rendering
                ->make(true);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
