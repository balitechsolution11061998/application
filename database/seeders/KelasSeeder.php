<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $classes = [];

        // Kelas 1-12
        for ($i = 1; $i <= 12; $i++) {
            $classes[] = [
                'name' => "Kelas $i",
                'description' => "Kelas $i",
            ];
        }

        Kelas::insert($classes);
    }
}
