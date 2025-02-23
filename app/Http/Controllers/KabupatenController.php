<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KabupatenController extends Controller
{
    //
    // In ProvinceController.php

    public function syncKabupaten($provinceId)
    {

        // Check if the province exists in the 'provinces' table
        $province = Province::where('kode', $provinceId)->first();


        if (!$province) {
            return response()->json(['message' => 'Province not found!'], 404); // Return an error if the province does not exist
        }

        // Build the URL with the province_id parameter
        $url = "https://sirekappilkada-obj-data.kpu.go.id/wilayah/pilkada/pkwkp/{$provinceId}.json"; // Replace with the actual API URL and use the province_id

        // Fetch data from the external API for Kabupaten
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            // Loop through the data and insert each Kabupaten into the database
            foreach ($data as $kabupatenData) {
                Kabupaten::updateOrCreate(
                    ['id' => $kabupatenData['id']], // Ensure this matches the API's unique identifier
                    [
                        'nama' => $kabupatenData['nama'],
                        'kode' => $kabupatenData['kode'],
                        'tingkat' => $kabupatenData['tingkat'],
                        'province_id' => $provinceId, // Associate the province_id with the kabupaten
                        // Add other fields as necessary
                    ]
                );
            }

            return response()->json([
                'message' => 'Kabupaten data synced successfully!',
                'code' => 200,
            ], 200);
        }

        return response()->json(['message' => 'Failed to fetch data from the API.'], 500);
    }
    public function dataKabupaten(Request $request)
    {
        $provinceId = $request->query('province_id');

        if (!$provinceId) {
            return response()->json(['message' => 'Province ID is required.'], 400);
        }

        $kabupaten = Kabupaten::where('province_id', $provinceId)->get(['kode', 'nama']);

        if ($kabupaten->isEmpty()) {
            return response()->json(['message' => 'No kabupaten found for this province.'], 404);
        }

        return response()->json($kabupaten, 200);
    }
}
