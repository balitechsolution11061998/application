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
            $data = OrdHead::with('ordsku')->select('ordhead.*'); // Adjust the model name as necessary

            return DataTables::of($data)
                ->addColumn('action', function($row){
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
                ->editColumn('status', function($row) {
                    $statusClass = '';
                    $statusText = '';
                    $icon = '';

                    switch ($row->status) {
                        case 'Confirmed':
                            $statusClass = 'badge badge-light-primary';
                            $statusText = 'Confirmed';
                            $icon = '<i class="fas fa-check-circle"></i>';
                            break;
                        case 'Pending':
                            $statusClass = 'badge badge-light-warning';
                            $statusText = 'Pending';
                            $icon = '<i class="fas fa-clock"></i>';
                            break;
                        case 'Cancelled':
                            $statusClass = 'badge badge-light-danger';
                            $statusText = 'Cancelled';
                            $icon = '<i class="fas fa-times-circle"></i>';
                            break;
                        default:
                            $statusClass = 'badge badge-light-secondary';
                            $statusText = 'Unknown';
                            $icon = '<i class="fas fa-question-circle"></i>';
                            break;
                    }

                    return '<span class="' . $statusClass . '">' . $icon . ' ' . $statusText . '</span>';
                })
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
