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
        DB::table('tutorials')->insert([
            [
                'title' => 'Pengenalan HTML',
                'description' => 'HTML (HyperText Markup Language) adalah bahasa standar yang digunakan untuk membuat halaman web. Dalam tutorial ini, Anda akan mempelajari pengertian dasar HTML, sejarahnya, dan bagaimana bahasa ini menjadi fondasi dari seluruh pengembangan web. Tutorial ini sangat cocok bagi pemula yang ingin memahami apa itu HTML dan bagaimana penggunaannya.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Pengantar']),
            ],
            [
                'title' => 'Struktur Dasar HTML',
                'description' => 'Pelajari bagaimana dokumen HTML diorganisasikan melalui struktur dasar yang terdiri dari elemen-elemen seperti <html>, <head>, dan <body>. Anda akan mempelajari pentingnya DOCTYPE, meta tags, serta bagaimana elemen-elemen ini bekerja bersama untuk membentuk halaman web yang valid dan terstruktur dengan baik.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Dasar']),
            ],
            [
                'title' => 'Menggunakan Elemen HTML',
                'description' => 'Tutorial ini akan memperkenalkan Anda pada berbagai elemen HTML yang digunakan untuk membangun konten web. Anda akan mempelajari cara membuat paragraf, heading, daftar, tabel, dan masih banyak lagi. Setiap elemen dijelaskan dengan detail beserta contoh penerapannya sehingga Anda bisa memahami cara membangun halaman web dengan baik.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Elemen']),
            ],
            [
                'title' => 'Atribut dan Properti HTML',
                'description' => 'Selain elemen, HTML juga memiliki atribut yang memberikan informasi tambahan pada elemen-elemen tersebut. Dalam tutorial ini, Anda akan mempelajari berbagai atribut yang sering digunakan, seperti id, class, style, dan lain-lain. Anda juga akan mempelajari bagaimana atribut ini dapat mempengaruhi tampilan dan fungsi dari elemen HTML.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Atribut']),
            ],
            [
                'title' => 'Formulir di HTML',
                'description' => 'Formulir adalah komponen penting dalam interaksi pengguna dengan situs web. Tutorial ini akan membahas cara membuat formulir menggunakan elemen HTML seperti input teks, textarea, checkbox, radio button, dan tombol submit. Anda juga akan belajar cara mengelola data yang dikirimkan melalui formulir.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Formulir']),
            ],
            [
                'title' => 'Menyisipkan Multimedia',
                'description' => 'HTML memungkinkan Anda untuk menyisipkan elemen multimedia seperti gambar, video, dan audio ke dalam halaman web. Dalam tutorial ini, Anda akan mempelajari cara menggunakan tag <img>, <video>, dan <audio>, serta cara menyesuaikan properti-properti yang terkait agar multimedia tersebut tampil dengan optimal.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Multimedia']),
            ],
            [
                'title' => 'HTML Semantik',
                'description' => 'HTML Semantik memperkenalkan elemen-elemen yang memberikan makna lebih pada konten web, seperti <article>, <section>, <header>, dan <footer>. Tutorial ini akan menjelaskan pentingnya penggunaan elemen semantik dalam meningkatkan aksesibilitas dan SEO, serta bagaimana mereka membantu dalam strukturisasi konten yang lebih baik.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Semantik']),
            ],
            [
                'title' => 'Link dan Navigasi',
                'description' => 'Hyperlink atau tautan adalah salah satu fitur utama dari HTML yang menghubungkan berbagai halaman web. Dalam tutorial ini, Anda akan mempelajari cara membuat hyperlink menggunakan tag <a>, cara mengatur target link, dan bagaimana membangun navigasi yang efektif dan user-friendly.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Navigasi']),
            ],
            [
                'title' => 'HTML untuk Desain Responsif',
                'description' => 'Desain web responsif adalah teknik yang memungkinkan halaman web untuk menyesuaikan tampilan berdasarkan ukuran layar perangkat pengguna. Dalam tutorial ini, Anda akan mempelajari cara menggunakan tag HTML dan meta viewport untuk membuat desain web yang fleksibel dan responsif di berbagai perangkat, dari desktop hingga smartphone.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Responsif']),
            ],
            [
                'title' => 'HTML dan SEO',
                'description' => 'Search Engine Optimization (SEO) adalah teknik untuk meningkatkan peringkat situs web Anda di mesin pencari. Tutorial ini akan mengajarkan Anda cara menggunakan elemen-elemen HTML dengan bijak untuk meningkatkan SEO situs web Anda, termasuk penggunaan heading, alt text pada gambar, dan struktur URL yang ramah SEO.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'SEO']),
            ],
            [
                'title' => 'Penggunaan CSS dengan HTML',
                'description' => 'Cascading Style Sheets (CSS) adalah bahasa yang digunakan untuk mendesain tampilan halaman web yang dibuat dengan HTML. Meskipun CSS adalah topik tersendiri, tutorial ini memberikan pengantar tentang bagaimana HTML dan CSS bekerja bersama untuk menciptakan halaman web yang menarik dan responsif.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'CSS']),
            ],
            [
                'title' => 'Best Practices dalam HTML',
                'description' => 'Untuk membuat kode HTML yang bersih, terstruktur, dan mudah dipelihara, penting untuk mengikuti best practices. Tutorial ini akan memberikan tips dan trik tentang penulisan kode HTML yang baik, termasuk penamaan yang konsisten, penggunaan komentar, dan pemisahan struktur dan gaya.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Best Practices']),
            ],
            [
                'title' => 'HTML5 dan Fitur Barunya',
                'description' => 'HTML5 adalah versi terbaru dari HTML yang membawa banyak fitur baru untuk mempermudah pengembangan web. Dalam tutorial ini, Anda akan mempelajari fitur-fitur baru seperti elemen canvas, elemen video/audio, local storage, dan API lainnya yang membuat HTML5 lebih kuat dan fleksibel.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'HTML5']),
            ],
            [
                'title' => 'Pengujian dan Debugging HTML',
                'description' => 'Tutorial ini akan mengajarkan teknik-teknik pengujian dan debugging pada kode HTML Anda untuk memastikan bahwa halaman web berfungsi dengan baik di berbagai browser. Anda akan belajar tentang alat-alat pengujian, validasi HTML, dan cara memperbaiki bug yang sering muncul dalam pengembangan web.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Debugging']),
            ],
            [
                'title' => 'Proyek Akhir: Membangun Situs Web Lengkap dengan HTML',
                'description' => 'Sebagai penutup dari seri tutorial ini, Anda akan diajak untuk membangun sebuah situs web lengkap menggunakan HTML dari awal hingga akhir. Proyek ini akan mencakup semua yang telah Anda pelajari, dari struktur dasar hingga penerapan elemen dan fitur lanjutan, memberikan Anda pengalaman praktis dalam pengembangan web.',
                'image_url' => '/image/html.svg',
                'category_tags' => json_encode(['HTML', 'Proyek']),
            ],
        ]);
    }
}
