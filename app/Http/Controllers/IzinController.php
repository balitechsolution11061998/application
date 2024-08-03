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
        $query = Izin::query(); // Use the Izin model directly

        // Apply filters if any
        if ($request->has('search') && $request->search) {
            $query->where('nik', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_izin', 'like', '%' . $request->search . '%');
        }
        if ($request->has('cabang') && $request->cabang) {
            $query->where('cabang_id', $request->cabang); // Ensure 'cabang_id' exists in your Izin model
        }
        if ($request->has('department') && $request->department) {
            $query->where('departemen_id', $request->department); // Ensure 'departemen_id' exists in your Izin model
        }
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tgl_izin_dari', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tgl_izin_sampai', '<=', $request->end_date);
        }

        // Return data in DataTables format
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('kode_izin', function ($row) {
                return $row->kode_izin;
            })
            ->editColumn('tgl_izin_dari', function ($row) {
                return $row->tgl_izin_dari ? $row->tgl_izin_dari->format('d F Y') : 'N/A'; // Adjust date format if needed
            })
            ->editColumn('tgl_izin_sampai', function ($row) {
                return $row->tgl_izin_sampai ? $row->tgl_izin_sampai->format('d F Y') : 'N/A'; // Adjust date format if needed
            })
            ->editColumn('nik', function ($row) {
                return $row->nik;
            })
            ->editColumn('nama_karyawan', function ($row) {
                return $row->user ? $row->user->nama_karyawan : 'N/A'; // Access user data if available
            })
            ->editColumn('jabatan', function ($row) {
                return $row->user ? $row->user->jabatan : 'N/A'; // Access user data if available
            })
            ->editColumn('departemen', function ($row) {
                return $row->user && $row->user->departemen ? $row->user->departemen->name : 'N/A'; // Access related department data if available
            })
            ->editColumn('cabang', function ($row) {
                return $row->user && $row->user->cabang ? $row->user->cabang->name : 'N/A'; // Access related cabang data if available
            })
            ->editColumn('status', function ($row) {
                return $row->status;
            })
            ->editColumn('file', function ($row) {
                return $row->doc_sid ? '<a href="' . asset('storage/izins/' . $row->doc_sid) . '" target="_blank">View File</a>' : 'No File';
            })
            ->editColumn('keterangan', function ($row) {
                return $row->keterangan ? $row->keterangan : 'No Keterangan';
            })
            ->editColumn('status_approved', function ($row) {
                return $row->status_approved;
            })
            ->addColumn('aksi', function ($row) {
                return '<button class="btn btn-info btn-sm">View</button>'; // Adjust actions if needed
            })
            ->rawColumns(['file', 'aksi']) // Make sure to render HTML for 'file' and 'aksi'
            ->make(true);
    }


}
