<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Province;
use App\Models\Tps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TpsController extends Controller
{
    //
    public function syncTps($provinceId, $kabupatenId, $kecamatanId, $kelurahanId)
    {

        // Check if the province and kabupaten exist
        $province = Province::where('kode', $provinceId)->get();
        $kabupaten = Kabupaten::where('kode', $kabupatenId)->get();
        $kecamatan = Kecamatan::where('kode', $kecamatanId)->get();
        $kelurahan = Kelurahan::where('kode', $kelurahanId)->get();


        if (!$province || !$kabupaten || !$kecamatan || !$kelurahan) {
            return response()->json(['message' => 'Data not found!'], 404);
        }


        // Define the URL and related IDs
        $url = "https://sirekappilkada-obj-data.kpu.go.id/wilayah/pilkada/pkwkp/{$provinceId}/{$kabupatenId}/{$kecamatanId}/{$kelurahanId}.json";
        try {
            // Fetch data from the URL
            $response = Http::get($url);
            if ($response->successful()) {
                $tpsData = $response->json();
                // Start a database transaction
                // DB::beginTransaction();

                // Insert or update TPS data
                foreach ($tpsData as $tps) {
                    Tps::updateOrCreate(
                        ['kode' => $tps['kode']], // Use unique kode as the identifier
                        [
                            'nama' => $tps['nama'],
                            'tingkat' => $tps['tingkat'],
                            'province_id' => $provinceId,
                            'kabupaten_id' => $kabupatenId,
                            'kecamatan_id' => $kecamatanId,
                            'kelurahan_id' => $kelurahanId,
                        ]
                    );

                }

                // Commit transaction
                // DB::commit();

                return response()->json([
                    'message' => 'Tps data synced successfully!',
                    'code' => 200,
                ], 200);
            } else {
                return response()->json(['error' => 'Failed to fetch TPS data'], 500);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Rollback transaction on error
            // DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function dataTps(Request $request)
    {
        // Validate required query parameters
        $provinceId = $request->query('province_id');
        $kabupatenId = $request->query('kabupaten_id');
        $kecamatanId = $request->query('kecamatan_id');
        $kelurahanId = $request->query('kelurahan_id');

        if (!$provinceId || !$kabupatenId || !$kecamatanId || !$kelurahanId) {
            return response()->json([
                'message' => 'Province ID, Kabupaten ID, Kecamatan ID, and Kelurahan ID are required.'
            ], 400);
        }

        // Fetch TPS data based on query parameters
        $tps = Tps::where('province_id', $provinceId)
                  ->where('kabupaten_id', $kabupatenId)
                  ->where('kecamatan_id', $kecamatanId)
                  ->where('kelurahan_id', $kelurahanId)
                  ->get(['kode', 'nama']); // Select only required fields

        // Check if data is available
        if ($tps->isEmpty()) {
            return response()->json([
                'message' => 'No TPS found for the given parameters.'
            ], 404);
        }

        // Return the TPS data as JSON
        return response()->json($tps, 200);
    }

}
