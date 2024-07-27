<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoalPilihanSeeder extends Seeder
{
    public function run()
    {
        // Insert data into soal_pilihan table
        DB::table('soal_pilihan')->insert([
            [
                'soal_id' => 1, // Replace with actual Soal ID
                'pilihan' => 'A',
                'jawaban' => '4',
                'media' => 'media_url', // Optional
            ],
            [
                'soal_id' => 1, // Replace with actual Soal ID
                'pilihan' => 'B',
                'jawaban' => '3',
                'media' => 'media_url', // Optional
            ],
            [
                'soal_id' => 1, // Replace with actual Soal ID
                'pilihan' => 'C',
                'jawaban' => '5',
                'media' => 'media_url', // Optional
            ],
            [
                'soal_id' => 1, // Replace with actual Soal ID
                'pilihan' => 'D',
                'jawaban' => '6',
                'media' => 'media_url', // Optional
            ],
            // Add more choices if needed
        ]);
    }
}
