<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketSoal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Faker\Factory as Faker;

class PaketSoalSeeder extends Seeder
{
    public function run()
    {
        // Set Faker locale to Indonesian
        $faker = Faker::create('id_ID');

        // Fetch existing Kelas and MataPelajaran records
        $kelasIds = Kelas::pluck('id')->toArray();
        $mataPelajaranIds = MataPelajaran::pluck('id')->toArray();

        $paketSoal = [];

        for ($i = 1; $i <= 40; $i++) {
            $paketSoal[] = [
                'kode_kelas' => $faker->randomElement($kelasIds),
                'kode_mata_pelajaran' => $faker->randomElement($mataPelajaranIds),
                'kode_paket' => 'PAKET' . $i,
                'nama_paket_soal' => 'Paket Soal ' . $i,
                'keterangan' => $faker->sentence, // Sentence in Indonesian
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        PaketSoal::insert($paketSoal);
    }
}
