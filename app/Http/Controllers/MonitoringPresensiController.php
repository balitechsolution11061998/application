<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MonitoringPresensiController extends Controller
{
    //
    public function index(){
        return view('monitoring-presensi.index');
    }

    public function data(Request $request)
    {
        try {
            // Start building the query
            $query = Absensi::with('user', 'jamKerja');

            // Apply search filter if provided
            if ($request->filled('search')) {
                $query->where(function ($query) use ($request) {
                    $query->where('nik', 'like', '%' . $request->search . '%')
                          ->orWhereHas('user', function ($query) use ($request) {
                              $query->where('name', 'like', '%' . $request->search . '%');
                          });
                });
            }

            // Apply cabang filter if provided
            if ($request->filled('cabang')) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('cabang_id', $request->cabang);
                });
            }

            // Apply department filter if provided
            if ($request->filled('department')) {
                $query->whereHas('user', function ($query) use ($request) {
                    $query->where('department_id', $request->department);
                });
            }

            // Apply date range filter if provided
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('tgl_presensi', [$request->start_date, $request->end_date]);
            }

            // Fetch the data and return as DataTables
            return DataTables::of($query)
                ->addIndexColumn() // Automatically add an index column (No.)
                ->make(true);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve monitoring data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }






}
