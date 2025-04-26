<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sri Angelia Barus - Fotografer Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        /* Hover effect for portfolio items */
        .portfolio-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .portfolio-item:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans leading-normal tracking-normal">
    <!-- Sticky Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-10 h-10 mr-3 rounded-full overflow-hidden border-2 border-blue-500">
                    <img src="/img/portofolio1/img1.jpg" alt="Sri Angelia Barus" class="w-full h-full object-cover">
                </div>
                <div class="text-xl font-bold text-gray-800">Sri Angelia Barus</div>
            </div>
            <div class="space-x-4 hidden md:block">
                <a href="#home" class="text-gray-600 hover:text-blue-600 transition duration-300">Beranda</a>
                <a href="#about" class="text-gray-600 hover:text-blue-600 transition duration-300">Tentang</a>
                <a href="#skills" class="text-gray-600 hover:text-blue-600 transition duration-300">Keahlian</a>
                <a href="#portfolio" class="text-gray-600 hover:text-blue-600 transition duration-300">Portofolio</a>
                <a href="#experience" class="text-gray-600 hover:text-blue-600 transition duration-300">Pengalaman</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-gray-600 hover:text-blue-600">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="#home" class="block text-gray-600 hover:text-blue-600 py-2">Beranda</a>
                <a href="#about" class="block text-gray-600 hover:text-blue-600 py-2">Tentang</a>
                <a href="#skills" class="block text-gray-600 hover:text-blue-600 py-2">Keahlian</a>
                <a href="#portfolio" class="block text-gray-600 hover:text-blue-600 py-2">Portofolio</a>
                <a href="#experience" class="block text-gray-600 hover:text-blue-600 py-2">Pengalaman</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Parallax-like Effect -->
    <header id="home" class="relative bg-gradient-to-r from-blue-500 to-purple-600 text-white pt-24 pb-20 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <svg class="absolute top-0 left-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="pattern" width="100" height="100" patternUnits="userSpaceOnUse">
                        <path d="M0 0 L50 50 L100 0 L50 100 Z" fill="rgba(255,255,255,0.1)" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)" />
            </svg>
        </div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <div class="w-52 h-52 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-lg">
                <img src="/img/portofolio1/img1.jpg" alt="Sri Angelia Barus" class="w-full h-full object-cover">
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in">Sri Angelia Barus</h1>
            <p class="text-xl md:text-2xl mb-6 animate-fade-in delay-300">Fotografer Kreatif & Storyteller Visual</p>
            <div class="flex justify-center space-x-4">
                <a href="#contact" class="bg-white text-blue-600 px-8 py-3 rounded-full hover:bg-blue-50 transition duration-300 shadow-lg">Hubungi Saya</a>
                <a href="#portfolio" class="bg-transparent border-2 border-white px-8 py-3 rounded-full hover:bg-white hover:text-blue-600 transition duration-300">Lihat Portofolio</a>
            </div>
        </div>
    </header>

    <!-- About Me Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Tentang Saya</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Saya adalah seorang fotografer muda berbakat lulusan SMK Multimedia dengan passion yang mendalam dalam menangkap momen-momen berharga. Dengan pendekatan estetis dan kreatif, saya mengubah setiap bidikan menjadi sebuah cerita visual yang memukau.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Berlatar belakang pendidikan multimedia, saya tidak hanya mahir dalam fotografi, tetapi juga memiliki keahlian dalam videografi, editing, dan desain visual yang memungkinkan saya menciptakan karya-karya berkualitas tinggi.
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-4 text-blue-800">Data Diri</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-birthday-cake mr-3 text-blue-600"></i>
                                <span>Tempat, Tanggal Lahir: [Isi Tempat, Tanggal Lahir]</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-graduation-cap mr-3 text-blue-600"></i>
                                <span>Pendidikan: SMK Multimedia</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-3 text-blue-600"></i>
                                <span>Lokasi: [Kota Asal]</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-language mr-3 text-blue-600"></i>
                                <span>Bahasa: Indonesia, [Bahasa Lain]</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-20 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Keahlian & Alat</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center transform transition duration-300 hover:scale-105">
                    <i class="fas fa-camera text-5xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-4">Foto Editing Profesional</h3>
                    <p class="text-gray-600 mb-4">Mahir dalam Adobe Lightroom dan Photoshop untuk editing berkualitas tinggi.</p>
                    <div class="flex justify-center space-x-2">
                        <img src="/img/portofolio1/photoshop-lightroom.png" alt="Lightroom" class="w-12 h-12 rounded-md">
                        <img src="/img/portofolio1/adobe-photoshop.png" alt="Photoshop" class="w-12 h-12 rounded-md">
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center transform transition duration-300 hover:scale-105">
                    <i class="fas fa-video text-5xl text-purple-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-4">Videografi Kreatif</h3>
                    <p class="text-gray-600 mb-4">Kemampuan produksi video dari konsep hingga editing menggunakan Premiere Pro.</p>
                    <div class="flex justify-center space-x-2">
                        <img src="/img/portofolio1/premiere-pro.png" alt="Premiere Pro" class="w-12 h-12 rounded-md">
                        <img src="/img/portofolio1/capcut-logo.png" alt="CapCut" class="w-12 h-12 rounded-md">
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center transform transition duration-300 hover:scale-105">
                    <i class="fas fa-camera-retro text-5xl text-green-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-4">Peralatan Profesional</h3>
                    <p class="text-gray-600 mb-4">Menggunakan kamera dan perlengkapan berkualitas tinggi.</p>
                    <div class="flex justify-center space-x-2">
                        <img src="/img/portofolio1/canon.jpeg" alt="Canon" class="w-12 h-12 rounded-md">
                        <img src="/img/portofolio1/3997786.png" alt="Lighting" class="w-12 h-12 rounded-md">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Portofolio</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Dokumentasi Event</h3>
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe 
                                src="https://drive.google.com/embeddedfolderview?id=1jeVTKB9RNP-YwHOicsUSo1dwD-OsShhR#grid" 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                allowfullscreen 
                                class="rounded-lg"
                            ></iframe>
                        </div>
                        <p class="text-gray-600 mt-4">Koleksi foto dokumentasi berbagai acara penting dengan kualitas profesional.</p>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-md">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Fotografi Potret & Outdoor</h3>
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe 
                                src="https://drive.google.com/embeddedfolderview?id=1ANvJM7T-iZPq0jt35Bj69cfzj9cEVJFN#grid" 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                allowfullscreen 
                                class="rounded-lg"
                            ></iframe>
                        </div>
                        <p class="text-gray-600 mt-4">Karya-karya fotografi potret dan pemandangan outdoor yang memukau.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-20 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Pengalaman Profesional</h2>
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-blue-800">Freelance Photographer</h3>
                        <span class="text-gray-600 text-sm">2023 - Sekarang</span>
                    </div>
                    <ul class="text-gray-700 list-disc list-inside space-y-2">
                        <li>Melayani jasa fotografi untuk berbagai acara seperti syukuran dan wisuda</li>
                        <li>Menghasilkan dokumentasi event dengan kualitas profesional</li>
                        <li>Bekerjasama dengan berbagai klien dari berbagai latar belakang</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-blue-800">Anggota Paskibra</h3>
                        <span class="text-gray-600 text-sm">2 Tahun</span>
                    </div>
                    <ul class="text-gray-700 list-disc list-inside space-y-2">
                        <li>Peserta aktif lomba LPKBB SPECTA VIRTUAL 2021 Se-Indonesia</li>
                        <li>Mengembangkan kepemimpinan dan kedisiplinan</li>
                        <li>Meningkatkan keterampilan kerja tim dan koordinasi</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-blue-800">Magang di Eko Pelaminan</h3>
                        <span class="text-gray-600 text-sm">2022</span>
                    </div>
                    <ul class="text-gray-700 list-disc list-inside space-y-2">
                        <li>Membantu sesi photoshoot acara pernikahan</li>
                        <li>Berkontribusi dalam proses dekorasi pelaminan</li>
                        <li>Mempraktikkan keterampilan fotografi dalam setting profesional</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Testimoni</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-100 p-6 rounded-lg shadow-md relative">
                    <div class="absolute top-0 left-0 mt-[-20px] ml-4 text-6xl text-blue-300">"</div>
                    <p class="text-gray-700 mb-4 italic relative z-10">Sri sangat profesional dalam mengambil foto. Hasilnya selalu di luar ekspektasi kami. Detail dan kreativitasnya sungguh luar biasa!</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img src="/api/placeholder/100/100" alt="Klien" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Nama Klien</h4>
                            <p class="text-gray-600 text-sm">Klien Pernikahan</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg shadow-md relative">
                    <div class="absolute top-0 left-0 mt-[-20px] ml-4 text-6xl text-blue-300">"</div>
                    <p class="text-gray-700 mb-4 italic relative z-10">Dokumentasi event kami terlihat sangat profesional berkat keahlian Sri. Dia berhasil menangkap momen-momen penting dengan cara yang sangat indah.</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img src="/api/placeholder/100/100" alt="Klien" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Nama Klien</h4>
                            <p class="text-gray-600 text-sm">Klien Event</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4">Hubungi Saya</h2>
                <p class="text-xl text-blue-100">Tertarik bekerjasama atau memiliki proyek foto/video?</p>
            </div>
            <div class="grid md:grid-cols-2 gap-10">
                <div>
                    <h3 class="text-2xl font-semibold mb-6">Informasi Kontak</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-4 text-2xl"></i>
                            <a href="mailto:sriangeliabarus@email.com" class="hover:text-blue-200 transition duration-300">sriangeliabarus@email.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-4 text-2xl"></i>
                            <a href="tel:+6282123456789" class="hover:text-blue-200 transition duration-300">+62 821-2345-6789</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-4 text-2xl"></i>
                            <span>[Alamat Lengkap]</span>
                        </li>
                    </ul>
                    <div class="mt-8 flex space-x-6">
                        <a href="#" class="text-3xl hover:text-blue-200 transition duration-300"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-3xl hover:text-blue-200 transition duration-300"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-3xl hover:text-blue-200 transition duration-300"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-3xl hover:text-blue-200 transition duration-300"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold mb-6">Kirim Pesan</h3>
                    <form class="space-y-4">
                        <div>
                            <label for="name" class="block mb-2">Nama</label>
                            <input type="text" id="name" name="name" placeholder="Nama Anda" class="w-full px-4 py-2 rounded-md bg-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white">
                        </div>
                        <div>
                            <label for="email" class="block mb-2">Email</label>
                            <input type="email" id="email" name="email" placeholder="email@example.com" class="w-full px-4 py-2 rounded-md bg-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white">
                        </div>
                        <div>
                            <label for="message" class="block mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="4" placeholder="Tulis pesan Anda di sini" class="w-full px-4 py-2 rounded-md bg-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-white text-blue-600 px-6 py-3 rounded-full hover:bg-blue-50 transition duration-300">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <p class="mb-4">&copy; 2024 Sri Angelia Barus. All Rights Reserved.</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="text-gray-400 hover:text-white transition duration-300">Privasi</a>
                <a href="#" class="text-gray-400 hover:text-white transition duration-300">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>