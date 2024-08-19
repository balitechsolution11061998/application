<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TutorialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Seed tabel tutorials
        DB::table('tutorials')->insert([
            [
                'title' => 'Pengenalan HTML',
                'description' => 'Pelajari dasar-dasar HTML, bahasa utama untuk membuat struktur halaman web.',
                'image_url' => 'image/html.svg',
                'category_tags' => json_encode(['HTML', 'Dasar-dasar']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'CSS untuk Pemula',
                'description' => 'Mulai mengatur tampilan halaman web Anda dengan CSS, bahasa yang membawa desain ke web.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['CSS', 'Styling']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Dasar-Dasar JavaScript',
                'description' => 'Menyelami JavaScript, bahasa pemrograman yang menggerakkan konten dinamis pada web.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['JavaScript', 'Pemrograman']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Desain Web Responsif',
                'description' => 'Pelajari cara membuat halaman web yang terlihat bagus di semua perangkat dengan teknik desain responsif.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['CSS', 'Desain Responsif']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed tabel tutorial_details
        DB::table('tutorial_details')->insert([
            // Detail Tutorial HTML
            [
                'tutorial_id' => 1,
                'detail_number' => 1,
                'detail_description' => 'HTML adalah singkatan dari HyperText Markup Language dan digunakan untuk membuat struktur halaman web.',
                'detail_image_url' => '/image/details/html_detail_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 1,
                'detail_number' => 2,
                'detail_description' => 'Elemen HTML adalah blok penyusun halaman HTML.',
                'detail_image_url' => '/image/details/html_detail_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 1,
                'detail_number' => 3,
                'detail_description' => 'Pelajari tentang tag HTML umum seperti <h1> untuk judul dan <p> untuk paragraf.',
                'detail_image_url' => '/image/details/html_detail_3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Detail Tutorial CSS
            [
                'tutorial_id' => 2,
                'detail_number' => 1,
                'detail_description' => 'CSS adalah singkatan dari Cascading Style Sheets dan digunakan untuk mengontrol tata letak dan tampilan halaman web.',
                'detail_image_url' => '/image/details/css_detail_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 2,
                'detail_number' => 2,
                'detail_description' => 'Pelajari tentang selector CSS, yang digunakan untuk menargetkan dan menata elemen HTML.',
                'detail_image_url' => '/image/details/css_detail_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 2,
                'detail_number' => 3,
                'detail_description' => 'Temukan cara menggunakan CSS untuk membuat tata letak dengan float, grid, dan flexbox.',
                'detail_image_url' => '/image/details/css_detail_3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Detail Tutorial JavaScript
            [
                'tutorial_id' => 3,
                'detail_number' => 1,
                'detail_description' => 'JavaScript adalah bahasa pemrograman yang digunakan untuk membuat konten dinamis dan interaktif pada halaman web.',
                'detail_image_url' => '/image/details/js_detail_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 3,
                'detail_number' => 2,
                'detail_description' => 'Pelajari tentang variabel JavaScript, fungsi, dan penanganan event.',
                'detail_image_url' => '/image/details/js_detail_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 3,
                'detail_number' => 3,
                'detail_description' => 'Temukan cara memanipulasi DOM (Document Object Model) dengan JavaScript untuk membuat elemen interaktif.',
                'detail_image_url' => '/image/details/js_detail_3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Detail Tutorial Desain Web Responsif
            [
                'tutorial_id' => 4,
                'detail_number' => 1,
                'detail_description' => 'Desain web responsif memastikan bahwa situs web Anda terlihat bagus di semua perangkat, mulai dari desktop hingga smartphone.',
                'detail_image_url' => '/image/details/responsive_detail_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 4,
                'detail_number' => 2,
                'detail_description' => 'Pelajari cara menggunakan media query untuk menerapkan gaya berbeda berdasarkan ukuran layar.',
                'detail_image_url' => '/image/details/responsive_detail_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tutorial_id' => 4,
                'detail_number' => 3,
                'detail_description' => 'Pahami cara membuat tata letak yang fleksibel dengan lebar berbasis persentase dan gambar yang fleksibel.',
                'detail_image_url' => '/image/details/responsive_detail_3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
