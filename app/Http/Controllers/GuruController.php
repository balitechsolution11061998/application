<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\GuruExport;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\User;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapel = MataPelajaran::orderBy('nama')->get();
        $max = Guru::max('id_card');
        return view('guru.index', compact('mapel', 'max'));
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
        try {
            $this->validate($request, [
                'id_card' => 'required',
                'nama_guru' => 'required',
                'mapel_id' => 'required',
                'kode' => 'required|string|unique:guru|min:2|max:3',
                'jk' => 'required'
            ]);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $new_foto = date('siHdmY') . "_" . $foto->getClientOriginalName();
                $foto->move(public_path('uploads/guru'), $new_foto);
                $nameFoto = 'uploads/guru/' . $new_foto;
            } else {
                if ($request->jk == 'L') {
                    $nameFoto = 'uploads/guru/35251431012020_male.jpg';
                } else {
                    $nameFoto = 'uploads/guru/23171022042020_female.jpg';
                }
            }

            $guru = Guru::create([
                'id_card' => $request->id_card,
                'nip' => $request->nip,
                'nama_guru' => $request->nama_guru,
                'mapel_id' => $request->mapel_id,
                'kode' => $request->kode,
                'jk' => $request->jk,
                'telp' => $request->telp,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'foto' => $nameFoto
            ]);

            Nilai::create([
                'guru_id' => $guru->id
            ]);

            return redirect()->back()->with('success', 'Successfully added new teacher data!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log the error message for debugging

            // Return a response with an error message
            return redirect()->back()->with('error', 'Failed to add new teacher data. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        return view('guru.details', compact('guru'));
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
        $guru = Guru::findorfail($id);
        $mapel = MataPelajaran::all();
        return view('guru.edit', compact('guru', 'mapel'));
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
        $this->validate($request, [
            'nama_guru' => 'required',
            'mapel_id' => 'required',
            'jk' => 'required',
        ]);

        $guru = Guru::findorfail($id);

        $user = User::where('id_card', $guru->id_card)->first();
        if ($user) {
            $user_data = [
                'name' => $request->nama_guru
            ];
            $user->update($user_data);
        } else {
        }
        $guru_data = [
            'nama_guru' => $request->nama_guru,
            'mapel_id' => $request->mapel_id,
            'jk' => $request->jk,
            'telp' => $request->telp,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir
        ];
        $guru->update($guru_data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the guru record or throw a ModelNotFoundException
            $guru = Guru::findOrFail($id);
            // Check and delete related Jadwal records
            $countJadwal = Jadwal::where('guru_id', $guru->id)->count();
            if ($countJadwal >= 1) {
                Jadwal::where('guru_id', $guru->id)->delete();
            }

            // Check and delete related User records
            $countUser = User::where('id_card', $guru->id_card)->count();
            if ($countUser >= 1) {
                User::where('id_card', $guru->id_card)->delete();
            }

            // Delete the guru record
            $guru->delete();

            // Redirect with a success message
            return redirect()->route('guru.index')->with('warning', 'Data guru berhasil dihapus! (Silahkan cek trash data guru)');
        } catch (\Exception $e) {
            // Log the error message
            dd($e->getMessage());

            // Redirect with an error message
            return redirect()->route('guru.index')->with('error', 'Terjadi kesalahan saat menghapus data guru. Silahkan coba lagi.');
        }
    }


    public function trash()
    {
        $guru = Guru::onlyTrashed()->get();
        return view('admin.guru.trash', compact('guru'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::withTrashed()->findorfail($id);
        $countJadwal = Jadwal::withTrashed()->where('guru_id', $guru->id)->count();
        if ($countJadwal >= 1) {
            $jadwal = Jadwal::withTrashed()->where('guru_id', $guru->id)->restore();
        } else {
        }
        $countUser = User::withTrashed()->where('id_card', $guru->id_card)->count();
        if ($countUser >= 1) {
            $user = User::withTrashed()->where('id_card', $guru->id_card)->restore();
        } else {
        }
        $guru->restore();
        return redirect()->back()->with('info', 'Data guru berhasil direstore! (Silahkan cek data guru)');
    }

    public function kill($id)
    {
        $guru = Guru::withTrashed()->findorfail($id);
        $countJadwal = Jadwal::withTrashed()->where('guru_id', $guru->id)->count();
        if ($countJadwal >= 1) {
            $jadwal = Jadwal::withTrashed()->where('guru_id', $guru->id)->forceDelete();
        } else {
        }
        $countUser = User::withTrashed()->where('id_card', $guru->id_card)->count();
        if ($countUser >= 1) {
            $user = User::withTrashed()->where('id_card', $guru->id_card)->forceDelete();
        } else {
        }
        $guru->forceDelete();
        return redirect()->back()->with('success', 'Data guru berhasil dihapus secara permanent');
    }

    public function ubah_foto($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        return view('admin.guru.ubah-foto', compact('guru'));
    }

    public function update_foto(Request $request, $id)
    {
        $this->validate($request, [
            'foto' => 'required'
        ]);

        $guru = Guru::findorfail($id);
        $foto = $request->foto;
        $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
        $guru_data = [
            'foto' => 'uploads/guru/' . $new_foto,
        ];
        $foto->move('uploads/guru/', $new_foto);
        $guru->update($guru_data);

        return redirect()->route('guru.index')->with('success', 'Berhasil merubah foto!');
    }

    public function mapel($id)
    {
        $id = Crypt::decrypt($id);
        $mapel = MataPelajaran::findorfail($id);
        $guru = Guru::where('mapel_id', $id)->orderBy('kode', 'asc')->get();
        return view('guru.show', compact('mapel', 'guru'));
    }

    public function absen()
    {
        $absen = Absen::where('tanggal', date('Y-m-d'))->get();
        $kehadiran = Kehadiran::limit(4)->get();
        return view('guru.absen', compact('absen', 'kehadiran'));
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'id_card' => 'required',
            'kehadiran_id' => 'required'
        ]);
        $cekGuru = Guru::where('id_card', $request->id_card)->count();
        if ($cekGuru >= 1) {
            $guru = Guru::where('id_card', $request->id_card)->first();
            if ($guru->id_card == Auth::user()->id_card) {
                $cekAbsen = Absen::where('guru_id', $guru->id)->where('tanggal', date('Y-m-d'))->count();
                if ($cekAbsen == 0) {
                    if (date('w') != '0' && date('w') != '6') {
                        if (date('H:i:s') >= '06:00:00') {
                            if (date('H:i:s') >= '09:00:00') {
                                if (date('H:i:s') >= '16:15:00') {
                                    Absen::create([
                                        'tanggal' => date('Y-m-d'),
                                        'guru_id' => $guru->id,
                                        'kehadiran_id' => '6',
                                    ]);
                                    return redirect()->back()->with('info', 'Maaf sekarang sudah waktunya pulang!');
                                } else {
                                    if ($request->kehadiran_id == '1') {
                                        $terlambat = date('H') - 9 . ' Jam ' . date('i') . ' Menit';
                                        if (date('H') - 9 == 0) {
                                            $terlambat = date('i') . ' Menit';
                                        }
                                        Absen::create([
                                            'tanggal' => date('Y-m-d'),
                                            'guru_id' => $guru->id,
                                            'kehadiran_id' => '5',
                                        ]);
                                        return redirect()->back()->with('warning', 'Maaf anda terlambat ' . $terlambat . '!');
                                    } else {
                                        Absen::create([
                                            'tanggal' => date('Y-m-d'),
                                            'guru_id' => $guru->id,
                                            'kehadiran_id' => $request->kehadiran_id,
                                        ]);
                                        return redirect()->back()->with('success', 'Anda hari ini berhasil absen!');
                                    }
                                }
                            } else {
                                Absen::create([
                                    'tanggal' => date('Y-m-d'),
                                    'guru_id' => $guru->id,
                                    'kehadiran_id' => $request->kehadiran_id,
                                ]);
                                return redirect()->back()->with('success', 'Anda hari ini berhasil absen tepat waktu!');
                            }
                        } else {
                            return redirect()->back()->with('info', 'Maaf absensi di mulai jam 6 pagi!');
                        }
                    } else {
                        $namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
                        $d = date('w');
                        $hari = $namaHari[$d];
                        return redirect()->back()->with('info', 'Maaf sekolah hari ' . $hari . ' libur!');
                    }
                } else {
                    return redirect()->back()->with('warning', 'Maaf absensi tidak bisa dilakukan 2x!');
                }
            } else {
                return redirect()->back()->with('error', 'Maaf id card ini bukan milik anda!');
            }
        } else {
            return redirect()->back()->with('error', 'Maaf id card ini tidak terdaftar!');
        }
    }

    public function absensi()
    {
        $guru = Guru::all();
        return view('guru.absen', compact('guru'));
    }

    public function kehadiran($id)
    {
        $id = Crypt::decrypt($id);
        $guru = Guru::findorfail($id);
        $absen = Absen::orderBy('tanggal', 'desc')->where('guru_id', $id)->get();
        return view('guru.kehadiran', compact('guru', 'absen'));
    }

    public function export_excel()
    {
        return Excel::download(new GuruExport, 'guru.xlsx');
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('file_guru', $nama_file);
        Excel::import(new GuruImport, public_path('/file_guru/' . $nama_file));
        return redirect()->back()->with('success', 'Data Guru Berhasil Diimport!');
    }

    public function deleteAll()
    {
        $guru = Guru::all();
        if ($guru->count() >= 1) {
            Guru::whereNotNull('id')->delete();
            Guru::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table guru berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table guru kosong!');
        }
    }
}