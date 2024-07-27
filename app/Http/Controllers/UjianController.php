<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UjianController extends Controller
{

    public function index(Request $request)
    {
        return view('ujians.index');
    }

    public function data()
    {
        $ujians = Ujian::with('paketSoal', 'rombel', 'mataPelajaran', 'kelas')->get();
        return DataTables::of($ujians)
            ->addIndexColumn() // This will add DT_RowIndex
            ->addColumn('action', function ($row) {
                $editBtn = '<button class="btn btn-primary btn-sm editUjian" data-id="' . $row->id . '">
                                <i class="fas fa-edit"></i> Edit
                            </button>';
                $deleteBtn = '<button class="btn btn-danger btn-sm deleteUjian" data-id="' . $row->id . '">
                                <i class="fas fa-trash"></i> Delete
                            </button>';
                return $editBtn . ' ' . $deleteBtn;
            })

            ->make(true);
    }

    public function edit($id)
{
    $ujian = Ujian::with('paketSoal', 'rombel', 'mataPelajaran', 'kelas')->findOrFail($id);
    return response()->json($ujian);
}




    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'paket_soal_id' => 'required|exists:paket_soal,id',
            'rombel_id' => 'required',
            'waktu_mulai' => 'required|date',
            'durasi' => 'required|integer',
            'poin_benar' => 'required|integer',
            'poin_salah' => 'required|integer',
            'poin_tidak_jawab' => 'required|integer',
            'keterangan' => 'nullable|string',
            'kelas' => 'required',
            'tampilkan_nilai' => 'nullable|boolean',
            'tampilkan_hasil' => 'nullable|boolean',
            'gunakan_token' => 'nullable|boolean',
            'mata_pelajaran_id' => 'required'
        ]);

        // Store the data in the database
        $ujian = Ujian::updateOrCreate(
            ['id' => $request->id], // This will update existing record or create a new one if ID doesn't exist
            $validatedData
        );

        // Return a success response
        return response()->json(['success' => true, 'data' => $ujian]);
    }

    public function show($id)
    {
        $ujian = Ujian::find($id);
        return response()->json($ujian);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'paket_soal_id' => 'required|exists:paket_soal,id',
            'rombel_id' => 'required|exists:rombels,id',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'durasi' => 'required|integer',
            'tampil_hasil' => 'nullable|integer',
            'detail_hasil' => 'nullable|integer',
            'token' => 'nullable|string|max:255',
        ]);

        $ujian = Ujian::find($id);
        $ujian->update($data);

        return response()->json(['success' => 'Ujian updated successfully.']);
    }

    public function destroy($id)
    {
        Ujian::destroy($id);
        return response()->json(['success' => 'Ujian deleted successfully.']);
    }
}
