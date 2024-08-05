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
            $jam_out = $request->input('jam_out');

            // Convert jam_in from time string to timestamp
            $jam_in_time = strtotime($jam_in);
            $jam_out_time = strtotime($jam_out);

            // Determine the current day of the week in English
            $currentDay = date('l', strtotime($tgl_presensi));

            // Check if a valid jam kerja configuration exists for the current day
            $config = DB::table('konfigurasi_jam_kerja')
                ->join('jam_kerja', 'jam_kerja.kode_jk', '=', 'konfigurasi_jam_kerja.kode_jam_kerja')
                ->where('nik', $nik)
                ->where('hari', $currentDay)
                ->first();

            // If no valid configuration is found, return an error
            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid working hour configuration found for the specified details.'
                ], 400);
            }

            // Convert the end of working time to timestamp
            $akhir_jam_masuk = strtotime($config->akhir_jam_masuk);
            $jam_pulang = strtotime($config->jam_pulang);

            // Allowable grace period (2 hours)
            $grace_period = 2 * 60 * 60; // 2 hours in seconds

            $lateness_hours = 0;
            $lateness_minutes = 0;
            $status = 'On Time';
            $can_absen_pulang = true;

            // Check if jam_in_time is after the end of working time
            if ($jam_in_time > $akhir_jam_masuk) {
                // Calculate lateness based on the end of working time
                $lateness_seconds = $jam_in_time - $akhir_jam_masuk;
                $lateness_hours = floor($lateness_seconds / 3600);
                $lateness_minutes = floor(($lateness_seconds % 3600) / 60);

                // Set status to 'Telat' if late
                $status = 'Telat';
                // Check if lateness exceeds 2 hours
                if ($lateness_seconds > $grace_period) {

                    // If lateness exceeds grace period, check jam_pulang
                    if ($jam_out_time < $jam_pulang) {
                        $can_absen_pulang = false;
                    }
                }
            }

            // Proceed with creating the absensi record
            $absensi = new Absensi();
            $absensi->nik = $nik;
            $absensi->tgl_presensi = $tgl_presensi;
            $absensi->jam_in = $jam_in;
            $absensi->jam_out = $can_absen_pulang ? $jam_out : null;
            $absensi->lokasi_in = $request->input('lokasi_in');
            $absensi->lokasi_out = $request->input('lokasi_out');
            $absensi->status = $status; // Set status based on lateness
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

            // Return a success response with lateness details if applicable
            return response()->json([
                'success' => true,
                'message' => 'Absensi record has been successfully created.',
                'lateness' => $lateness_hours > 0 || $lateness_minutes > 0 ? 'Total lateness: ' . $lateness_hours . ' hours and ' . $lateness_minutes . ' minutes.' : 'No lateness recorded.',
                'data' => $absensi
            ], 201);

        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
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
