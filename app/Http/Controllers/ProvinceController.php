<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Province;

class ProvinceController extends Controller
{
    //
    public function syncProvinces()
    {
        // Fetch data from the external API
        $url = 'https://sirekappilkada-obj-data.kpu.go.id/wilayah/pilkada/pkwkp/0.json';
        $response = Http::get($url);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();

            // Loop through the data and insert each province into the database
            foreach ($data as $provinceData) {
                Province::updateOrCreate(
                    ['id' => $provinceData['id']], // Ensure this matches the API's unique identifier
                    [
                        'nama' => $provinceData['nama'],
                        'kode' => $provinceData['kode'],
                        'tingkat' => $provinceData['tingkat'],
                    ]
                );
            }

            // Return success response with custom message and code
            return response()->json([
                'message' => 'Provinces data synced successfully!',
                'code' => 200
            ], 200); // 200 OK HTTP status code
        }

        // Return failure response with custom message and code if API request fails
        return response()->json([
            'message' => 'Failed to fetch data from the API.',
            'code' => 500
        ], 500); // 500 Internal Server Error status code
    }

    public function dataProvinces(Request $request)
    {
        try {
            $searchTerm = $request->get('search', '');

            // Fetch unique provinces based on 'nama'
            $provinces = Province::where('nama', 'like', '%' . $searchTerm . '%')
                ->distinct('nama')  // Ensure distinct provinces based on 'nama'
                ->get();

            return response()->json([
                'code' => 200,
                'provinces' => $provinces,

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to fetch provinces: ' . $e->getMessage(),
            ], 500);
        }
    }




}
