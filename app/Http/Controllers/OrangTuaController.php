<?php
namespace App\Http\Controllers;

use App\Models\OrangTua;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangTua = OrangTua::withTrashed()->get();
        return view('orang_tua.index', compact('orangTua'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:orang_tua,nik',
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'nullable|email|unique:orang_tua,email',
            'telepon' => 'nullable',
            'pekerjaan' => 'nullable',
            'hubungan' => 'required',
        ]);

        OrangTua::create($validatedData);

        return response()->json(['message' => 'Data Orang Tua berhasil disimpan.']);
    }

    public function update(Request $request, OrangTua $orangTua)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:orang_tua,nik,' . $orangTua->id,
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'nullable|email|unique:orang_tua,email,' . $orangTua->id,
            'telepon' => 'nullable',
            'pekerjaan' => 'nullable',
            'hubungan' => 'required',
        ]);

        $orangTua->update($validatedData);

        return response()->json(['message' => 'Data Orang Tua berhasil diperbarui.']);
    }

    public function destroy(OrangTua $orangTua)
    {
        $orangTua->delete();
        return response()->json(['message' => 'Data Orang Tua berhasil dihapus.']);
    }

    public function restore($id)
    {
        $orangTua = OrangTua::withTrashed()->find($id);
        if ($orangTua) {
            $orangTua->restore();
            return response()->json(['message' => 'Data Orang Tua berhasil dipulihkan.']);
        }

        return response()->json(['message' => 'Data Orang Tua tidak ditemukan.'], 404);
    }
}
