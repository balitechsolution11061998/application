<?php

// app/Http/Controllers/SiswaController.php
namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        Siswa::updateOrCreate(['id' => $request->id], $data);

        return response()->json(['success' => 'Siswa saved successfully.']);
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }

    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return response()->json(['success' => 'Siswa deleted successfully.']);
    }

    public function data()
    {
        return datatables()->of(Siswa::with('rombel')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm editSiswa" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm deleteSiswa" data-id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return response()->json(['success' => 'Siswa imported successfully.']);
    }
}
