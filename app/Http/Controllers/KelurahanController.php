<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KelurahanController extends Controller
{
    //
      //
      public function syncKelurahan($provinceId, $kabupatenId,$kecamatanId)
      {
          // Check if the province and kabupaten exist
          $province = Province::where('kode',$provinceId)->get();
          $kabupaten = Kabupaten::where('kode',$kabupatenId)->get();
          $kecamatan = Kecamatan::where('kode',$kecamatanId)->get();

          if (!$province || !$kabupaten || !$kecamatan) {
              return response()->json(['message' => 'Province or Kabupaten not found!'], 404);
          }

          // Fetch data from the external API
          $url = "https://sirekappilkada-obj-data.kpu.go.id/wilayah/pilkada/pkwkp/{$provinceId}/{$kabupatenId}/{$kecamatanId}.json";
          $response = Http::get($url);
          if ($response->successful()) {
              $data = $response->json();

              foreach ($data as $kecamatanData) {
                  Kelurahan::updateOrCreate(
                      ['kode' => $kecamatanData['kode']], // Use unique kode as the identifier
                      [
                          'nama' => $kecamatanData['nama'],
                          'tingkat' => $kecamatanData['tingkat'],
                          'province_id' => $provinceId,
                          'kabupaten_id' => $kabupatenId,
                          'kecamatan_id' => $kecamatanId,
                      ]
                  );
              }

              return response()->json([
                  'message' => 'Kelurahan data synced successfully!',
                  'code' => 200,
              ], 200);
          }

          return response()->json(['message' => 'Failed to fetch kecamatan data.'], 500);
      }
      public function dataKelurahan(Request $request)
      {
          // Validate required query parameters
          $provinceId = $request->query('province_id');
          $kabupatenId = $request->query('kabupaten_id');
          $kecamatanId = $request->query('kecamatan_id');

          if (!$provinceId || !$kabupatenId || !$kecamatanId) {
              return response()->json(['message' => 'Province ID,Kabupaten ID and Kecamatan ID are required.'], 400);
          }

          // Fetch kecamatan data based on province_id and kabupaten_id
          $kecamatan = Kelurahan::where('province_id', $provinceId)
                                ->where('kabupaten_id', $kabupatenId)
                                ->where('kecamatan_id', $kecamatanId)
                                ->get(['kode', 'nama']);

          if ($kecamatan->isEmpty()) {
              return response()->json(['message' => 'No kecamatan found for the given province and kabupaten.'], 404);
          }

          return response()->json($kecamatan, 200);
      }
}
