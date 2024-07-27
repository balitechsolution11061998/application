<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoalSeeder extends Seeder
{
    public function run()
    {
        // Insert data into soal table
        DB::table('soal')->insert([
            [
                'paket_soal_id' => 1, // Replace with actual Paket Soal ID
                'jenis' => 'pilihan_ganda',
                'pertanyaan' => 'Apa hasil dari 2 + 2?',
                'media' => 'media_url', // Optional
                'ulang_media' => 'ulang_media_url', // Optional
                'jawaban_benar' => 'A',
            ],
            // Add more soal if needed
        ]);
    }
}
