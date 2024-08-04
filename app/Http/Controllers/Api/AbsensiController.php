<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Presensi;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $niks = $request->input('nik'); // assume you're passing an array of nik values
            if (!$niks) {
                throw new \Exception('Nik values are required');
            }
            $absensi = Absensi::where('nik', $niks)->get();
            return response()->json($absensi);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
            // Extract input values
            $nik = $request->input('nik');
            $tgl_presensi = $request->input('tgl_presensi');
            $jam_in = $request->input('jam_in');
            $kode_jam_kerja = $request->input('kode_jam_kerja');

            // Determine the current day of the week
            $currentDay = date('l', strtotime($tgl_presensi)); // Gets full day name (e.g., 'Monday')

            // Check if a valid jam kerja configuration exists for the current day
            $config = DB::table('konfigurasi_jam_kerja')
                ->where('nik', $nik)
                ->where('hari', $currentDay)
                ->where('kode_jam_kerja', $kode_jam_kerja)
                ->first();

            // If no valid configuration is found, return an error
            if (!$config) {
                return response()->json(['error' => 'No valid jam kerja configuration found for the specified details.'], 400);
            }

            // Check if jam_in is within the valid working hours
            $jam_in_time = strtotime($jam_in);
            $start_time = strtotime($config->jam_mulai); // Assuming jam_mulai is the start time in configuration
            $end_time = strtotime($config->jam_selesai); // Assuming jam_selesai is the end time in configuration

            if ($jam_in_time < $start_time || $jam_in_time > $end_time) {
                return response()->json(['error' => 'Jam in is outside of the allowed working hours.'], 400);
            }

            // Proceed with absensi creation
            $absensi = new Absensi();
            $absensi->nik = $nik;
            $absensi->tgl_presensi = $tgl_presensi;
            $absensi->jam_in = $jam_in;
            $absensi->jam_out = $request->input('jam_out');
            $absensi->lokasi_in = $request->input('lokasi_in');
            $absensi->lokasi_out = $request->input('lokasi_out');
            $absensi->status = $request->input('status');
            $absensi->kode_izin = $request->input('kode_izin');

            // Handle file uploads for foto_in and foto_out
            if ($request->hasFile('foto_in')) {
                $file = $request->file('foto_in');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/absensi/foto_in', $filename);
                $absensi->foto_in = $filename;
            }

            if ($request->hasFile('foto_out')) {
                $file = $request->file('foto_out');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/absensi/foto_out', $filename);
                $absensi->foto_out = $filename;
            }

            // Save the absensi record
            $absensi->save();
            return response()->json($absensi, 201);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json(['error' => $e->getMessage()], 400);
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
        $absensi = Absensi::find($id);
        if (!$absensi) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($absensi);
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
        $absensi = Absensi::find($id);
        if (!$absensi) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $absensi->nik = $request->input('nik');
        $absensi->tgl_presensi = $request->input('tgl_presensi');
        $absensi->jam_in = $request->input('jam_in');
        $absensi->jam_out = $request->input('jam_out');
        $absensi->foto_in = $request->input('foto_in');
        $absensi->foto_out = $request->input('foto_out');
        $absensi->lokasi_in = $request->input('lokasi_in');
        $absensi->lokasi_out = $request->input('lokasi_out');
        $absensi->kode_jam_kerja = $request->input('kode_jam_kerja');
        $absensi->status = $request->input('status');
        $absensi->kode_izin = $request->input('kode_izin');
        $absensi->save();
        return response()->json($absensi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $absensi = Absensi::find($id);
        if (!$absensi) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $absensi->delete();
        return response()->json(null, 204);
    }
}
