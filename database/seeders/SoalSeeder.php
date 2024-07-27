<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\SoalPilihan;
use App\Models\PaketSoal;
use Faker\Factory as Faker;

class SoalSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');  // Set Faker locale to Indonesian

        // Get all PaketSoal IDs
        $faker = Faker::create('id_ID');  // Set Faker locale to Indonesian

        // Get all PaketSoal IDs
        $paketSoalIds = PaketSoal::pluck('id')->toArray();

        // Ensure each PaketSoal gets exactly 40 questions
        foreach ($paketSoalIds as $paketSoalId) {
            for ($i = 1; $i <= 50; $i++) {
                $soal = Soal::create([
                    'paket_soal_id' => $faker->randomElement($paketSoalIds),
                    'jenis' => 'pilihan_ganda',  // Set to 'pilihan_ganda'
                    'pertanyaan' => $faker->sentence,  // Generates a sentence in Indonesian
                    'pertanyaan_a' => $faker->sentence,
                    'pertanyaan_b' => $faker->sentence,
                    'pertanyaan_c' => $faker->sentence,
                    'pertanyaan_d' => $faker->sentence,
                    'media' => $faker->imageUrl(),
                    'ulang_media' => $faker->imageUrl(),
                    'jawaban_benar' => $faker->randomElement(['a', 'b', 'c', 'd']),
                ]);

                // Insert SoalPilihan data for each question
                for ($j = 1; $j <= 4; $j++) {
                    SoalPilihan::create([
                        'soal_id' => $soal->id,
                        'jawaban' => $faker->sentence,  // Generates a sentence in Indonesian
                        'media' => $faker->imageUrl(),
                    ]);
                }
            }
        }
    }
}
