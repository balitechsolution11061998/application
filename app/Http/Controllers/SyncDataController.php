<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Province;
use App\Models\SyncData;
use App\Models\Tps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SyncDataController extends Controller
{
    //
    public function syncDataPemilihan($provinceId, $kabupatenId, $kecamatanId, $kelurahanId, $tpsId)
    {
        // Fetch the relevant data
        $province = Province::where('kode', $provinceId)->first();
        $kabupaten = Kabupaten::where('kode', $kabupatenId)->first();
        $kecamatan = Kecamatan::where('kode', $kecamatanId)->first();
        $kelurahan = Kelurahan::where('kode', $kelurahanId)->first();
        $tps = Tps::where('kode', $tpsId)->first();

        // Validate data
        if (!$province || !$kabupaten || !$kecamatan || !$kelurahan || !$tps) {
            return response()->json(['message' => 'Data not found!'], 404);
        }

        // Corrected URL
        $url = "https://sirekappilkada-obj-data.kpu.go.id/pilkada/hhcw/pkwkp/{$provinceId}/{$kabupatenId}/{$kecamatanId}/{$kelurahanId}/{$tpsId}.json";


        try {
            // Fetch data from the URL
            $response = Http::get($url);

            // Check if the response is successful
            if ($response->successful()) {
                $pilkadaData = $response->json();

                // Insert the data into the `sync_data` table
                $syncData = SyncData::firstOrCreate(
                    [
                        'province_id' => $provinceId,
                        'kabupaten_id' => $kabupatenId,
                        'kecamatan_id' => $kecamatanId,
                        'kelurahan_id' => $kelurahanId,
                        'tps_id' => $tpsId,
                    ],
                    [
                        'mode' => $pilkadaData['mode'],
                        'tungsura_chart' => json_encode($pilkadaData['tungsura']['chart'] ?? null),
                        'tungsura_administrasi' => json_encode($pilkadaData['tungsura']['administrasi'] ?? null),
                        'psu' => json_encode($pilkadaData['psu'] ?? null),
                        'status_suara' => $pilkadaData['status_suara'] ?? false,
                        'status_adm' => $pilkadaData['status_adm'] ?? false,
                        'images' => json_encode($pilkadaData['images'] ?? null),
                        'ts' => $pilkadaData['ts'] ?? null,
                    ]
                );


                return response()->json([
                    'message' => 'Data synced and stored successfully!',
                    'data' => $syncData,
                    'code' => 200,
                ], 201);
            } else {
                return response()->json(['error' => 'Failed to fetch TPS data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function dataPilkada(Request $request)
    {
        // Validate required query parameters
        $provinceId = $request->query('province_id');
        $kabupatenId = $request->query('kabupaten_id');
        $kecamatanId = $request->query('kecamatan_id');
        $kelurahanId = $request->query('kelurahan_id');
        $tpsId = $request->query('tps_id');

        // Build the query
        $query = SyncData::where('province_id', (int)$provinceId);

        // Apply filters only if they are not null
        if ($kabupatenId !== null) {
            $query->where('kabupaten_id', (int)$kabupatenId);
        }
        if ($kecamatanId !== null) {
            $query->where('kecamatan_id', (int)$kecamatanId);
        }
        if ($kelurahanId !== null) {
            $query->where('kelurahan_id', (int)$kelurahanId);
        }
        // Apply TPS ID filter only if it's not null
        if ($tpsId !== null) {
            $query->where('tps_id', (int)$tpsId);
        }

        // Fetch TPS data
        $tps = $query->get();

        // Check if data is available
        if ($tps->isEmpty()) {
            return response()->json([
                'message' => 'No TPS found for the given parameters.'
            ], 404);
        }

        // Return the TPS data as JSON
        return response()->json([
            'code' => 200,
            'message' => 'TPS data fetched successfully.',
            'data' => $tps,
        ], 200);
    }

}
