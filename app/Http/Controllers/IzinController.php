<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IzinController extends Controller
{
    //
    public function index(){
        return view('izin.index');
    }

    public function data(Request $request)
    {
        $query = Izin::with('user') // Include the user relationship
            ->select('izin.*'); // Adjust table name if needed

        // Apply filters if any
        if ($request->has('search') && $request->search) {
            $query->where('user.nama_karyawan', 'like', '%' . $request->search . '%');
        }
        if ($request->has('cabang') && $request->cabang) {
            $query->where('user.cabang_id', $request->cabang);
        }
        if ($request->has('department') && $request->department) {
            $query->where('user.departemen_id', $request->department);
        }
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Return data in DataTables format
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('kode_izin', function ($row) {
                return $row->kode_izin;
            })
            ->editColumn('tanggal', function ($row) {
                return $row->tanggal->format('d F Y'); // Adjust date format if needed
            })
            ->editColumn('nik', function ($row) {
                return $row->user->nik; // Access user data
            })
            ->editColumn('nama_karyawan', function ($row) {
                return $row->user->nama_karyawan; // Access user data
            })
            ->editColumn('jabatan', function ($row) {
                return $row->user->jabatan; // Access user data
            })
            ->editColumn('departemen', function ($row) {
                return $row->user->departemen->name; // Access related department data
            })
            ->editColumn('cabang', function ($row) {
                return $row->user->cabang->name; // Access related cabang data
            })
            ->editColumn('status', function ($row) {
                return $row->status;
            })
            ->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . asset('storage/izins/' . $row->file) . '" target="_blank">View File</a>' : 'No File';
            })
            ->editColumn('keterangan', function ($row) {
                return $row->keterangan ? $row->keterangan : 'No Keterangan';
            })
            ->editColumn('status_approve', function ($row) {
                return $row->status_approve;
            })
            ->addColumn('aksi', function ($row) {
                return '<button class="btn btn-info btn-sm">View</button>'; // Adjust actions if needed
            })
            ->rawColumns(['file', 'aksi']) // Make sure to render HTML for 'file' and 'aksi'
            ->make(true);
    }


}
