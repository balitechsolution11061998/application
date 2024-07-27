<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            // SD subjects
            ['kode' => 'SD-001', 'nama' => 'Matematika SD'],
            ['kode' => 'SD-002', 'nama' => 'Bahasa Indonesia SD'],
            ['kode' => 'SD-003', 'nama' => 'Ilmu Pengetahuan Alam SD'],
            ['kode' => 'SD-004', 'nama' => 'Ilmu Pengetahuan Sosial SD'],
            ['kode' => 'SD-005', 'nama' => 'Pendidikan Agama SD'],
            ['kode' => 'SD-006', 'nama' => 'Pendidikan Kewarganegaraan SD'],
            ['kode' => 'SD-007', 'nama' => 'Seni Budaya SD'],
            ['kode' => 'SD-008', 'nama' => 'Pendidikan Jasmani SD'],

            // SMP subjects
            ['kode' => 'SMP-001', 'nama' => 'Matematika SMP'],
            ['kode' => 'SMP-002', 'nama' => 'Bahasa Indonesia SMP'],
            ['kode' => 'SMP-003', 'nama' => 'Ilmu Pengetahuan Alam SMP'],
            ['kode' => 'SMP-004', 'nama' => 'Ilmu Pengetahuan Sosial SMP'],
            ['kode' => 'SMP-005', 'nama' => 'Bahasa Inggris SMP'],
            ['kode' => 'SMP-006', 'nama' => 'Pendidikan Agama SMP'],
            ['kode' => 'SMP-007', 'nama' => 'Pendidikan Kewarganegaraan SMP'],
            ['kode' => 'SMP-008', 'nama' => 'Seni Budaya SMP'],
            ['kode' => 'SMP-009', 'nama' => 'Pendidikan Jasmani SMP'],

            // SMA subjects
            ['kode' => 'SMA-001', 'nama' => 'Matematika SMA'],
            ['kode' => 'SMA-002', 'nama' => 'Bahasa Indonesia SMA'],
            ['kode' => 'SMA-003', 'nama' => 'Fisika SMA'],
            ['kode' => 'SMA-004', 'nama' => 'Kimia SMA'],
            ['kode' => 'SMA-005', 'nama' => 'Biologi SMA'],
            ['kode' => 'SMA-006', 'nama' => 'Sejarah SMA'],
            ['kode' => 'SMA-007', 'nama' => 'Geografi SMA'],
            ['kode' => 'SMA-008', 'nama' => 'Ekonomi SMA'],
            ['kode' => 'SMA-009', 'nama' => 'Bahasa Inggris SMA'],
            ['kode' => 'SMA-010', 'nama' => 'Pendidikan Agama SMA'],
            ['kode' => 'SMA-011', 'nama' => 'Pendidikan Kewarganegaraan SMA'],
            ['kode' => 'SMA-012', 'nama' => 'Seni Budaya SMA'],
            ['kode' => 'SMA-013', 'nama' => 'Pendidikan Jasmani SMA'],
        ];

        MataPelajaran::insert($subjects);
    }
}
