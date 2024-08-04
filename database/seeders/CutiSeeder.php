<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuti = [
            [
                'kode_cuti' => 'CT01',
                'nama_cuti' => 'Cuti Tahunan',
                'jumlah_hari' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT02',
                'nama_cuti' => 'Cuti Sakit',
                'jumlah_hari' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT03',
                'nama_cuti' => 'Cuti Melahirkan',
                'jumlah_hari' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT04',
                'nama_cuti' => 'Cuti Pernikahan',
                'jumlah_hari' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT05',
                'nama_cuti' => 'Cuti Kematian',
                'jumlah_hari' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT06',
                'nama_cuti' => 'Cuti Besar',
                'jumlah_hari' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT07',
                'nama_cuti' => 'Cuti Pendidikan',
                'jumlah_hari' => 365,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT08',
                'nama_cuti' => 'Cuti Ibadah Haji',
                'jumlah_hari' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT09',
                'nama_cuti' => 'Cuti Umroh',
                'jumlah_hari' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_cuti' => 'CT10',
                'nama_cuti' => 'Cuti Kelahiran Anak',
                'jumlah_hari' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('cuti')->insert($cuti);
    }
}
