<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Tungsura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardPilkadaController extends Controller
{
    //
    public function index()
    {
        $tungsura = Tungsura::latest()->first();
        $provinces = Province::get(); // Fetch all provinces or apply filters as needed

        return view('dashboard.pilkada.index', compact('tungsura', 'provinces'));
    }


    public function fetchData()
    {
        // URL API
        $url = 'https://sirekappilkada-obj-data.kpu.go.id/pilkada/hhcw/pkwkk/51/5103/510303/5103032008/5103032008001.json';

        // Ambil data dari API
        $response = Http::get($url);
        if ($response->ok()) {
            $data = $response->json();

            // Simpan data ke database
            Tungsura::create([
                'chart' => json_encode($data['tungsura']['chart']),
                'suara_sah' => $data['tungsura']['administrasi']['suara_sah'],
                'suara_total' => $data['tungsura']['administrasi']['suara_total'],
                'pemilih_dpt_j' => $data['tungsura']['administrasi']['pemilih_dpt_j'],
                'pemilih_dpt_l' => $data['tungsura']['administrasi']['pemilih_dpt_l'],
                'pemilih_dpt_p' => $data['tungsura']['administrasi']['pemilih_dpt_p'],
                'pengguna_dpt_j' => $data['tungsura']['administrasi']['pengguna_dpt_j'],
                'pengguna_dpt_l' => $data['tungsura']['administrasi']['pengguna_dpt_l'],
                'pengguna_dpt_p' => $data['tungsura']['administrasi']['pengguna_dpt_p'],
                'suara_tidak_sah' => $data['tungsura']['administrasi']['suara_tidak_sah'],
                'images' => json_encode($data['images']),
                'timestamp' => $data['ts'],
            ]);

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        }

        return response()->json(['message' => 'Gagal mengambil data'], 500);
    }
}
