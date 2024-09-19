<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeeder extends Seeder
{
    public function run(): void
    {
        // List of Indonesian provinces
        $regions = [
            ['name' => 'Aceh', 'region_code' => 'AC'],
            ['name' => 'Bali', 'region_code' => 'BA'],
            ['name' => 'Banten', 'region_code' => 'BT'],
            ['name' => 'Bengkulu', 'region_code' => 'BE'],
            ['name' => 'DI Yogyakarta', 'region_code' => 'YO'],
            ['name' => 'DKI Jakarta', 'region_code' => 'JK'],
            ['name' => 'Gorontalo', 'region_code' => 'GO'],
            ['name' => 'Jambi', 'region_code' => 'JA'],
            ['name' => 'Jawa Barat', 'region_code' => 'JB'],
            ['name' => 'Jawa Tengah', 'region_code' => 'JT'],
            ['name' => 'Jawa Timur', 'region_code' => 'JI'],
            ['name' => 'Kalimantan Barat', 'region_code' => 'KB'],
            ['name' => 'Kalimantan Selatan', 'region_code' => 'KS'],
            ['name' => 'Kalimantan Tengah', 'region_code' => 'KT'],
            ['name' => 'Kalimantan Timur', 'region_code' => 'KI'],
            ['name' => 'Kalimantan Utara', 'region_code' => 'KU'],
            ['name' => 'Kepulauan Bangka Belitung', 'region_code' => 'BB'],
            ['name' => 'Kepulauan Riau', 'region_code' => 'KR'],
            ['name' => 'Lampung', 'region_code' => 'LA'],
            ['name' => 'Maluku', 'region_code' => 'MA'],
            ['name' => 'Maluku Utara', 'region_code' => 'MU'],
            ['name' => 'Nusa Tenggara Barat', 'region_code' => 'NB'],
            ['name' => 'Nusa Tenggara Timur', 'region_code' => 'NT'],
            ['name' => 'Papua', 'region_code' => 'PA'],
            ['name' => 'Papua Barat', 'region_code' => 'PB'],
            ['name' => 'Papua Pegunungan', 'region_code' => 'PP'],
            ['name' => 'Papua Tengah', 'region_code' => 'PT'],
            ['name' => 'Papua Selatan', 'region_code' => 'PS'],
            ['name' => 'Riau', 'region_code' => 'RI'],
            ['name' => 'Sulawesi Barat', 'region_code' => 'SR'],
            ['name' => 'Sulawesi Selatan', 'region_code' => 'SN'],
            ['name' => 'Sulawesi Tengah', 'region_code' => 'ST'],
            ['name' => 'Sulawesi Tenggara', 'region_code' => 'SG'],
            ['name' => 'Sulawesi Utara', 'region_code' => 'SA'],
            ['name' => 'Sumatera Barat', 'region_code' => 'SB'],
            ['name' => 'Sumatera Selatan', 'region_code' => 'SS'],
            ['name' => 'Sumatera Utara', 'region_code' => 'SU'],
        ];

        // Insert the regions into the database
        DB::table('region')->insert($regions);
    }
}
