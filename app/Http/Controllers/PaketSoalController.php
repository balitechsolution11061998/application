<?php

namespace App\Http\Controllers;

use App\Models\PaketSoal;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class PaketSoalController extends Controller
{
    public function index()
    {
        return view('paket_soal.index');
    }

    public function data(Request $request)
    {
        $data = PaketSoal::with(['kelas', 'mataPelajaran'])->latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('kelas', function($row) {
                return $row->kelas ? $row->kelas->name : 'N/A';
            })
            ->addColumn('mata_pelajaran', function($row) {
                return $row->mataPelajaran ? $row->mataPelajaran->nama : 'N/A';
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editPaketSoal" title="Edit"><i class="fas fa-edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm deletePaketSoal" title="Delete"><i class="fas fa-trash-alt"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function dataoptions()
    {
        // Fetch all classes
        $paketSoal = PaketSoal::select('id', 'nama_paket_soal')->get();

        // Return the classes as JSON
        return response()->json($paketSoal);
    }

    public function store(Request $request)
    {
        PaketSoal::updateOrCreate(['id' => $request->id], $request->all());
        return response()->json(['success' => 'Paket Soal saved successfully.']);
    }

    public function update(Request $request, $id)
{
    // Find the PaketSoal record by ID
    $paketSoal = PaketSoal::findOrFail($id);

    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'kode_kelas' => 'required|exists:kelas,id',
        'kode_mata_pelajaran' => 'required|max:255',
        'kode_paket' => 'required|max:255',
        'nama_paket_soal' => 'required|max:255',
        'keterangan' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Update the PaketSoal record
    $paketSoal->update($request->all());

    // Return a success response
    return response()->json(['success' => 'Paket Soal updated successfully']);
}

    public function edit($id)
    {
        $paketSoal = PaketSoal::find($id);
        return response()->json($paketSoal);
    }

    public function destroy($id)
    {
        PaketSoal::find($id)->delete();
        return response()->json(['success' => 'Paket Soal deleted successfully.']);
    }
}
