<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use PDF;
use App\Exports\JadwalExport;
use App\Imports\JadwalImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Hari;
use App\Models\Kelas;
use App\Models\Ruang;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hari = Hari::all();
        $kelas = Kelas::OrderBy('name', 'asc')->get();
        $ruang = Ruang::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('jadwal.index', compact('hari', 'kelas', 'guru', 'ruang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'hari_id' => 'required',
            'kelas_id' => 'required',
            'guru_id' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruang_id' => 'required',
        ]);

        $guru = Guru::findorfail($request->guru_id);
        Jadwal::updateOrCreate(
            [
                'id' => $request->jadwal_id
            ],
            [
                'hari_id' => $request->hari_id,
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $guru->mapel_id,
                'guru_id' => $request->guru_id,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'ruang_id' => $request->ruang_id,
            ]
        );

        return redirect()->back()->with('success', 'Data jadwal berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // Attempt to decrypt the ID
            $id = Crypt::decrypt($id);

            // Retrieve the Kelas record
            $kelas = Kelas::findOrFail($id);

            // Retrieve the Jadwal records associated with the Kelas
            $jadwal = Jadwal::orderBy('hari_id', 'asc')
                            ->orderBy('jam_mulai', 'asc')
                            ->where('kelas_id', $id)
                            ->get();

            // Return the view with the data
            return view('jadwal.show', compact('jadwal', 'kelas'));

        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle decryption errors
            return redirect()->route('jadwal.index')->with('error', 'Invalid data provided.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle not found errors
            return redirect()->route('jadwal.index')->with('error', 'Data not found.');

        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle other possible errors
            return redirect()->route('jadwal.index')->with('error', 'An unexpected error occurred.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = Jadwal::findorfail($id);
        $hari = Hari::all();
        $kelas = Kelas::all();
        $ruang = Ruang::all();
        $guru = Guru::OrderBy('kode', 'asc')->get();
        return view('jadwal.edit', compact('jadwal', 'hari', 'kelas', 'guru', 'ruang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findorfail($id);
        $jadwal->delete();

        return redirect()->back()->with('warning', 'Data jadwal berhasil dihapus! (Silahkan cek trash data jadwal)');
    }

    public function trash()
    {
        $jadwal = Jadwal::onlyTrashed()->get();
        return view('admin.jadwal.trash', compact('jadwal'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $jadwal = Jadwal::withTrashed()->findorfail($id);
        $jadwal->restore();
        return redirect()->back()->with('info', 'Data jadwal berhasil direstore! (Silahkan cek data jadwal)');
    }

    public function kill($id)
    {
        $jadwal = Jadwal::withTrashed()->findorfail($id);
        $jadwal->forceDelete();
        return redirect()->back()->with('success', 'Data jadwal berhasil dihapus secara permanent');
    }

    public function view(Request $request)
    {
        $jadwal = Jadwal::OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('kelas_id', $request->id)->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'hari' => $val->hari->nama_hari,
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->kelas->nama_kelas,
                'guru' => $val->guru->nama_guru,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
            );
        }
        return response()->json($newForm);
    }

    public function jadwalSekarang(Request $request)
    {
        $jadwal = Jadwal::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('kelas_id')->where('hari_id', $request->hari)->where('jam_mulai', '<=', $request->jam)->where('jam_selesai', '>=', $request->jam)->get();
        foreach ($jadwal as $val) {
            $newForm[] = array(
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->kelas->nama_kelas,
                'guru' => $val->guru->nama_guru,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
                'ket' => $val->absen($val->guru_id),
            );
        }
        return response()->json($newForm);
    }

    public function cetak_pdf(Request $request)
    {
        $jadwal = Jadwal::OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('kelas_id', $request->id)->get();
        $kelas = Kelas::findorfail($request->id);
        $pdf = PDF::loadView('jadwal-pdf', ['jadwal' => $jadwal, 'kelas' => $kelas]);
        return $pdf->stream();
        // return $pdf->stream('jadwal-pdf.pdf');
    }

    public function guru()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();

        // Check if $guru is null
        if (!$guru) {
            // Handle the case where the guru is not found
            return redirect()->back()->with('error', 'Guru not found.');
        }

        $jadwal = Jadwal::orderBy('hari_id')
                        ->orderBy('jam_mulai')
                        ->where('guru_id', $guru->id)
                        ->get();

        return view('guru.jadwal', compact('jadwal', 'guru'));
    }

    public function siswa()
    {
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('hari_id')->OrderBy('jam_mulai')->where('kelas_id', $kelas->id)->get();
        return view('siswa.jadwal', compact('jadwal', 'kelas', 'siswa'));
    }

    public function export_excel()
    {
        return Excel::download(new JadwalExport, 'jadwal.xlsx');
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_jadwal', $nama_file);
        Excel::import(new JadwalImport, public_path('/file_jadwal/' . $nama_file));
        return redirect()->back()->with('success', 'Data Siswa Berhasil Diimport!');
    }

    public function deleteAll()
    {
        $jadwal = Jadwal::all();
        if ($jadwal->count() >= 1) {
            Jadwal::whereNotNull('id')->delete();
            Jadwal::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table jadwal berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table jadwal kosong!');
        }
    }
}