<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanjung Benoa Adventure - Wisata Air Terbaik di Bali</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        .hero-gradient {
            background: linear-gradient(135deg, rgba(0, 119, 182, 0.85) 0%, rgba(0, 180, 216, 0.85) 100%), 
                        url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .activity-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .activity-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .price-tag {
            position: relative;
            display: inline-block;
        }
        .price-tag::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 10px;
            background: rgba(59, 130, 246, 0.2);
            z-index: -1;
        }
        .floating-button {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .wave-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .wave-shape svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 100px;
        }
        .wave-shape .shape-fill {
            fill: #FFFFFF;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <i class="fas fa-umbrella-beach text-2xl text-blue-500 mr-2"></i>
                        <span class="font-bold text-xl text-gray-800">Tanjung Benoa Adventure</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-800 hover:text-blue-500 font-medium">Beranda</a>
                    <a href="#activities" class="text-gray-800 hover:text-blue-500 font-medium">Aktivitas</a>
                    <a href="#gallery" class="text-gray-800 hover:text-blue-500 font-medium">Galeri</a>
                    <a href="#testimonials" class="text-gray-800 hover:text-blue-500 font-medium">Testimoni</a>
                    <a href="#contact" class="text-gray-800 hover:text-blue-500 font-medium">Kontak</a>
                </div>
                <div class="md:hidden">
                    <button class="mobile-menu-button p-2 focus:outline-none">
                        <i class="fas fa-bars text-gray-600 text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden bg-white pb-4 px-4">
            <a href="#home" class="block py-2 text-gray-800 hover:text-blue-500">Beranda</a>
            <a href="#activities" class="block py-2 text-gray-800 hover:text-blue-500">Aktivitas</a>
            <a href="#gallery" class="block py-2 text-gray-800 hover:text-blue-500">Galeri</a>
            <a href="#testimonials" class="block py-2 text-gray-800 hover:text-blue-500">Testimoni</a>
            <a href="#contact" class="block py-2 text-gray-800 hover:text-blue-500">Kontak</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient text-white py-32 px-4 md:px-10 lg:px-20 relative">
        <div class="max-w-6xl mx-auto text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">Petualangan Air Terbaik di <span class="text-yellow-300">Tanjung Benoa</span></h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Rasakan sensasi wisata air yang memacu adrenalin dengan pemandangan pantai eksotis Bali</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="#activities" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-4 px-8 rounded-full text-lg transition duration-300 inline-block transform hover:scale-105 shadow-lg">
                    <i class="fas fa-binoculars mr-2"></i> Jelajahi Aktivitas
                </a>
                <a href="#contact" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white font-bold py-4 px-8 rounded-full text-lg transition duration-300 inline-block transform hover:scale-105">
                    <i class="fas fa-phone-alt mr-2"></i> Hubungi Kami
                </a>
            </div>
        </div>
        <div class="wave-shape">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 md:px-10 lg:px-20">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="p-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">10+</div>
                    <div class="text-gray-600">Jenis Aktivitas</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">15.000+</div>
                    <div class="text-gray-600">Pengunjung/Tahun</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">98%</div>
                    <div class="text-gray-600">Kepuasan Pelanggan</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold text-blue-600 mb-2">12</div>
                    <div class="text-gray-600">Jam Operasional</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 px-4 md:px-10 lg:px-20 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Mengapa Memilih Kami?</h2>
                <div class="w-20 h-1 bg-blue-500 mx-auto"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md activity-card text-center">
                    <div class="text-blue-500 text-4xl mb-4"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Keamanan Terjamin</h3>
                    <p class="text-gray-600">Peralatan standar internasional dengan instruktur bersertifikat untuk pengalaman yang aman dan nyaman.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md activity-card text-center">
                    <div class="text-blue-500 text-4xl mb-4"><i class="fas fa-tags"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Harga Terbaik</h3>
                    <p class="text-gray-600">Harga kompetitif dengan kualitas pelayanan premium. Garansi harga terbaik untuk paket wisata kami.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md activity-card text-center">
                    <div class="text-blue-500 text-4xl mb-4"><i class="fas fa-clock"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Fleksibel</h3>
                    <p class="text-gray-600">Jadwal fleksibel dengan sistem booking online yang mudah. Bebas pilih waktu sesuai keinginan Anda.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-md activity-card text-center">
                    <div class="text-blue-500 text-4xl mb-4"><i class="fas fa-camera"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Foto Profesional</h3>
                    <p class="text-gray-600">Dapatkan foto profesional dari setiap aktivitas Anda secara gratis sebagai kenang-kenangan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="activities" class="py-16 px-4 md:px-10 lg:px-20 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Paket Wisata Tanjung Benoa</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Pilih berbagai aktivitas seru dengan harga terbaik untuk pengalaman tak terlupakan</p>
                <div class="w-20 h-1 bg-blue-500 mx-auto mt-4"></div>
            </div>
            
            <!-- Activity Tabs -->
            <div class="mb-12">
                <div class="flex flex-wrap justify-center border-b border-gray-200 mb-8">
                    <button class="tab-button active px-6 py-3 font-medium text-gray-600 hover:text-blue-500 border-b-2 border-blue-500" data-tab="water-sports">Water Sports</button>
                    <button class="tab-button px-6 py-3 font-medium text-gray-600 hover:text-blue-500 border-b-2 border-transparent" data-tab="snorkeling">Snorkeling</button>
                    <button class="tab-button px-6 py-3 font-medium text-gray-600 hover:text-blue-500 border-b-2 border-transparent" data-tab="cruise">Cruise</button>
                    <button class="tab-button px-6 py-3 font-medium text-gray-600 hover:text-blue-500 border-b-2 border-transparent" data-tab="combo">Paket Kombo</button>
                </div>
                
                <!-- Water Sports Tab Content -->
                <div id="water-sports" class="tab-content active">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Banana Boat -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden activity-card">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1530549387789-4c1017266635?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Banana Boat" class="w-full h-56 object-cover">
                                <div class="absolute top-4 right-4 bg-yellow-400 text-gray-900 font-bold px-3 py-1 rounded-full text-sm">POPULER</div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Banana Boat</h3>
                                <p class="text-gray-600 mb-4">Rasakan sensasi meluncur di atas air dengan perahu berbentuk pisang yang ditarik speedboat.</p>
                                <ul class="mb-6 space-y-2 text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Durasi: 15 menit</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Maksimal 6 orang</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Termasuk asuransi</span>
                                    </li>
                                </ul>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-2xl font-bold text-blue-600 price-tag">Rp 150.000</span>
                                        <span class="text-gray-500 text-sm">/orang</span>
                                    </div>
                                    <button class="book-button bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300 transform hover:scale-105" data-activity="Banana Boat" data-price="150000">
                                        <i class="fas fa-shopping-cart mr-2"></i> Pesan
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Parasailing -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden activity-card">
                            <div class="relative">
                                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Parasailing" class="w-full h-56 object-cover">
                                <div class="absolute top-4 right-4 bg-red-500 text-white font-bold px-3 py-1 rounded-full text-sm">TERLARIS</div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Parasailing</h3>
                                <p class="text-gray-600 mb-4">Terbang tinggi di atas laut dengan parasut yang ditarik speedboat. Nikmati pemandangan indah.</p>
                                <ul class="mb-6 space-y-2 text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Durasi: 10-15 menit</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Ketinggian hingga 80m</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Termasuk foto dari udara</span>
                                    </li>
                                </ul>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-2xl font-bold text-blue-600 price-tag">Rp 350.000</span>
                                        <span class="text-gray-500 text-sm">/orang</span>
                                    </div>
                                    <button class="book-button bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300 transform hover:scale-105" data-activity="Parasailing" data-price="350000">
                                        <i class="fas fa-shopping-cart mr-2"></i> Pesan
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Jet Ski -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden activity-card">
                            <img src="https://images.unsplash.com/photo-1512054502234-5c0c04b52cbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Jet Ski" class="w-full h-56 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Jet Ski</h3>
                                <p class="text-gray-600 mb-4">Rasakan adrenalin mengendarai jet ski di perairan Tanjung Benoa dengan pemandangan eksotis.</p>
                                <ul class="mb-6 space-y-2 text-gray-600">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Durasi: 15 menit</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Bisa untuk 1-2 orang</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        <span>Instruktur profesional</span>
                                    </li>
                                </ul>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-2xl font-bold text-blue-600 price-tag">Rp 250.000</span>
                                        <span class="text-gray-500 text-sm">/orang</span>
                                    </div>
                                    <button class="book-button bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300 transform hover:scale-105" data-activity="Jet Ski" data-price="250000">
                                        <i class="fas fa-shopping-cart mr-2"></i> Pesan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Other tabs content would go here -->
            </div>
            
            <!-- Package Deal -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-8 md:p-12 text-white">
                        <h3 class="text-2xl font-bold mb-4">Paket Kombo Hemat</h3>
                        <p class="mb-6">Nikmati berbagai aktivitas dengan harga lebih hemat dalam satu paket lengkap!</p>
                        <ul class="mb-8 space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-yellow-300 mt-1 mr-3"></i>
                                <span>Banana Boat + Parasailing + Jet Ski</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-yellow-300 mt-1 mr-3"></i>
                                <span>Hemat hingga Rp 150.000</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-yellow-300 mt-1 mr-3"></i>
                                <span>Gratis minuman segar</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-yellow-300 mt-1 mr-3"></i>
                                <span>Foto profesional semua aktivitas</span>
                            </li>
                        </ul>
                        <div class="flex items-center mb-6">
                            <span class="text-4xl font-bold">Rp 600.000</span>
                            <span class="ml-2 text-blue-100">/orang</span>
                            <span class="ml-4 px-3 py-1 bg-white text-blue-600 rounded-full text-sm font-bold">Hemat 20%</span>
                        </div>
                        <button class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 flex items-center justify-center" data-activity="Paket Kombo 3 Aktivitas" data-price="600000">
                            <i class="fas fa-gift mr-2"></i> Pesan Paket Hemat
                        </button>
                    </div>
                    <div class="hidden lg:block bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-16 px-4 md:px-10 lg:px-20 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Galeri Kegiatan</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Momen-momen berkesan para pengunjung di Tanjung Benoa</p>
                <div class="w-20 h-1 bg-blue-500 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <a href="https://images.unsplash.com/photo-1505118380757-91f5f5632de0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1505118380757-91f5f5632de0?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 1" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
                <a href="https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 2" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
                <a href="https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 3" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
                <a href="https://images.unsplash.com/photo-1566438480900-0609be27a4be?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1566438480900-0609be27a4be?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 4" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
                <a href="https://images.unsplash.com/photo-1512054502234-5c0c04b52cbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1512054502234-5c0c04b52cbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 5" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
                <a href="https://images.unsplash.com/photo-1530549387789-4c1017266635?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1530549387789-4c1017266635?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 6" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
                <a href="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 7" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
                <a href="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="gallery-item overflow-hidden rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gallery 8" class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
                </a>
            </div>
            
            <div class="text-center mt-12">
                <button class="bg-white hover:bg-gray-100 text-blue-600 font-bold py-3 px-8 rounded-full border-2 border-blue-600 transition duration-300 inline-block transform hover:scale-105">
                    <i class="fab fa-instagram mr-2"></i> Lihat Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 px-4 md:px-10 lg:px-20 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Apa Kata Mereka?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Testimoni jujur dari pengunjung yang sudah merasakan pengalaman seru bersama kami</p>
                <div class="w-20 h-1 bg-blue-500 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Andi Saputra" class="w-16 h-16 rounded-full object-cover border-4 border-blue-100">
                        <div class="ml-4">
                            <h4 class="font-semibold text-lg">Andi Saputra</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Parasailing di Tanjung Benoa luar biasa! Pemandangan dari atas sangat indah. Pelayanan juga ramah dan profesional. Pasti akan kembali lagi!"</p>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i> 15 Maret 2023
                    </div>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Siti Dewi" class="w-16 h-16 rounded-full object-cover border-4 border-blue-100">
                        <div class="ml-4">
                            <h4 class="font-semibold text-lg">Siti Dewi</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Anak-anak sangat senang main banana boat. Tim sangat memperhatikan keselamatan dan membuat kami merasa nyaman. Foto-fotonya juga bagus!"</p>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i> 2 Februari 2023
                    </div>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Rudi Jatmiko" class="w-16 h-16 rounded-full object-cover border-4 border-blue-100">
                        <div class="ml-4">
                            <h4 class="font-semibold text-lg">Rudi Jatmiko</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Paket kombo sangat worth it! Kami bisa mencoba beberapa aktivitas dengan harga lebih murah. Jet ski-nya seru banget, instrukturnya juga sabar."</p>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i> 28 Januari 2023
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section class="py-16 px-4 md:px-10 lg:px-20 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-8 md:p-10 bg-blue-600">
                    <h3 class="text-2xl font-bold mb-4">Pesan Aktivitas Anda Sekarang</h3>
                    <p class="mb-6">Isi form pemesanan dan kami akan segera menghubungi Anda untuk konfirmasi.</p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-yellow-300 mt-1 mr-3"></i>
                            <span>Konfirmasi instan via WhatsApp</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-yellow-300 mt-1 mr-3"></i>
                            <span>Pembayaran mudah & aman</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-yellow-300 mt-1 mr-3"></i>
                            <span>Gratis pembatalan 24 jam sebelumnya</span>
                        </li>
                    </ul>
                </div>
                <div class="p-8 md:p-10 bg-white text-gray-800">
                    <form id="booking-form" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="activity" class="block text-sm font-medium text-gray-700 mb-1">Aktivitas</label>
                            <select id="activity" name="activity" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Pilih Aktivitas</option>
                                <option value="Banana Boat">Banana Boat (Rp 150.000/orang)</option>
                                <option value="Parasailing">Parasailing (Rp 350.000/orang)</option>
                                <option value="Jet Ski">Jet Ski (Rp 250.000/orang)</option>
                                <option value="Paket Kombo 3 Aktivitas">Paket Kombo 3 Aktivitas (Rp 600.000/orang)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" id="date" name="date" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="participants" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Orang</label>
                                <input type="number" id="participants" name="participants" min="1" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 mt-4">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 px-4 md:px-10 lg:px-20 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Pertanyaan yang Sering Diajukan</h2>
                <div class="w-20 h-1 bg-blue-500 mx-auto"></div>
            </div>
            
            <div class="space-y-4">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left font-semibold text-gray-800">
                        <span>Apa saja persyaratan untuk mengikuti aktivitas water sports?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden mt-4 text-gray-600">
                        <p>Peserta minimal berusia 7 tahun dan dalam kondisi kesehatan yang baik. Untuk anak-anak di bawah 12 tahun wajib didampingi orang dewasa. Semua peserta akan diberikan pelampung dan peralatan keselamatan sesuai standar internasional.</p>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left font-semibold text-gray-800">
                        <span>Bagaimana jika cuaca buruk pada hari pemesanan?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden mt-4 text-gray-600">
                        <p>Kami memantau kondisi cuaca secara real-time. Jika aktivitas harus dibatalkan karena cuaca buruk, Anda dapat memilih untuk reschedule di hari lain atau mendapatkan refund penuh. Keputusan pembatalan akan diinformasikan minimal 2 jam sebelumnya.</p>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left font-semibold text-gray-800">
                        <span>Apakah ada fasilitas kamar mandi dan loker?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden mt-4 text-gray-600">
                        <p>Ya, kami menyediakan fasilitas kamar mandi dengan shower, loker penyimpanan barang, dan ruang ganti yang nyaman. Anda juga bisa menggunakan kolam renang dan area bersantai di lokasi kami sebelum atau setelah aktivitas.</p>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left font-semibold text-gray-800">
                        <span>Bagaimana cara pembayarannya?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content hidden mt-4 text-gray-600">
                        <p>Pembayaran dapat dilakukan melalui transfer bank (BCA, Mandiri, BRI), Dana, OVO, atau tunai di lokasi. Untuk pemesanan online, Anda hanya perlu membayar DP 20% untuk mengkonfirmasi booking, sisanya dibayar saat check-in di lokasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 md:px-10 lg:px-20 bg-gradient-to-r from-blue-600 to-blue-700 text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-yellow-300"></div>
            <div class="absolute bottom-1/3 right-1/4 w-48 h-48 rounded-full bg-yellow-300"></div>
        </div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap untuk Pengalaman Tak Terlupakan di Tanjung Benoa?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Pesan sekarang dan dapatkan promo spesial untuk pembelian hari ini!</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="https://wa.me/6281234567890?text=Saya%20ingin%20bertanya%20tentang%20aktivitas%20di%20Tanjung%20Benoa" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                    <i class="fab fa-whatsapp mr-2 text-xl"></i> WhatsApp Kami
                </a>
                <a href="#booking-form" class="bg-white hover:bg-gray-100 text-blue-600 font-bold py-4 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check mr-2"></i> Booking Online
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 px-4 md:px-10 lg:px-20 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h2>
                <div class="w-20 h-1 bg-blue-500 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-xl shadow-md text-center">
                    <div class="text-blue-500 text-3xl mb-4"><i class="fas fa-map-marker-alt"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Lokasi</h3>
                    <p class="text-gray-600">Jl. Pratama No. 168X, Tanjung Benoa, Kuta Sel., Kabupaten Badung, Bali 80363</p>
                    <a href="https://goo.gl/maps/example" class="inline-block mt-4 text-blue-500 hover:text-blue-600 font-medium">
                        <i class="fas fa-directions mr-2"></i> Lihat di Peta
                    </a>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl shadow-md text-center">
                    <div class="text-blue-500 text-3xl mb-4"><i class="fas fa-phone-alt"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Telepon</h3>
                    <p class="text-gray-600 mb-2">+62 812-3456-7890</p>
                    <p class="text-gray-600">+62 361 1234567</p>
                    <a href="tel:+6281234567890" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        <i class="fas fa-phone mr-2"></i> Telepon Sekarang
                    </a>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-xl shadow-md text-center">
                    <div class="text-blue-500 text-3xl mb-4"><i class="fas fa-envelope"></i></div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Email</h3>
                    <p class="text-gray-600">info@tanjungbenoaadventure.com</p>
                    <p class="text-gray-600">booking@tanjungbenoaadventure.com</p>
                    <a href="mailto:info@tanjungbenoaadventure.com" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Email
                    </a>
                </div>
            </div>
            
            <div class="mt-16 bg-gray-50 rounded-xl shadow-md overflow-hidden">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.016260836722!2d115.22072231533886!3d-8.762944193758292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd244bc39fb3da7%3A0x6cae8cb2a990cae9!2sTanjung%20Benoa!5e0!3m2!1sen!2sid!4v1621234567890!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890?text=Saya%20ingin%20bertanya%20tentang%20aktivitas%20di%20Tanjung%20Benoa" class="fixed bottom-8 right-8 bg-green-500 text-white w-16 h-16 rounded-full flex items-center justify-center text-3xl shadow-xl floating-button z-50">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Footer -->
    <footer class="py-12 px-4 md:px-10 lg:px-20 bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center mb-4">
                    <i class="fas fa-umbrella-beach text-2xl text-blue-500 mr-2"></i>
                    <span class="font-bold text-xl">Tanjung Benoa Adventure</span>
                </div>
                <p class="text-gray-400 mb-4">Penyedia wisata air terbaik di Tanjung Benoa, Bali dengan pengalaman lebih dari 10 tahun melayani ribuan pengunjung.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div>
                <h4 class="font-semibold text-lg mb-4">Aktivitas</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Banana Boat</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Parasailing</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Jet Ski</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Flyboard</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Snorkeling</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-lg mb-4">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="#home" class="text-gray-400 hover:text-white">Beranda</a></li>
                    <li><a href="#activities" class="text-gray-400 hover:text-white">Paket Wisata</a></li>
                    <li><a href="#gallery" class="text-gray-400 hover:text-white">Galeri</a></li>
                    <li><a href="#testimonials" class="text-gray-400 hover:text-white">Testimoni</a></li>
                    <li><a href="#contact" class="text-gray-400 hover:text-white">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-lg mb-4">Jam Operasional</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-start">
                        <i class="fas fa-calendar-alt mt-1 mr-3"></i>
                        <span>Setiap Hari</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-clock mt-1 mr-3"></i>
                        <span>08:00 - 17:00 WITA</span>
                    </li>
                </ul>
                <div class="mt-6">
                    <h4 class="font-semibold text-lg mb-2">Pembayaran</h4>
                    <div class="flex flex-wrap gap-2">
                        <div class="bg-white p-2 rounded-md">
                            <img src="https://via.placeholder.com/30x20?text=BCA" alt="BCA" class="h-5">
                        </div>
                        <div class="bg-white p-2 rounded-md">
                            <img src="https://via.placeholder.com/30x20?text=Mandiri" alt="Mandiri" class="h-5">
                        </div>
                        <div class="bg-white p-2 rounded-md">
                            <img src="https://via.placeholder.com/30x20?text=BRI" alt="BRI" class="h-5">
                        </div>
                        <div class="bg-white p-2 rounded-md">
                            <img src="https://via.placeholder.com/30x20?text=DANA" alt="DANA" class="h-5">
                        </div>
                        <div class="bg-white p-2 rounded-md">
                            <img src="https://via.placeholder.com/30x20?text=OVO" alt="OVO" class="h-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-6xl mx-auto mt-12 pt-6 border-t border-gray-800 text-center text-gray-400">
            <p>© 2023 Tanjung Benoa Adventure. All rights reserved.</p>
        </div>
    </footer>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl max-w-md w-full mx-4 p-8 relative">
            <button id="close-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Konfirmasi Pemesanan</h3>
            <p class="text-gray-600 mb-6">Silakan periksa detail pemesanan Anda</p>
            
            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Aktivitas:</span>
                    <span class="font-semibold" id="modal-activity">Banana Boat</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Harga per orang:</span>
                    <span class="font-semibold" id="modal-price">Rp 150.000</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Jumlah orang:</span>
                    <span class="font-semibold" id="modal-participants">1</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-semibold text-blue-600 text-lg" id="modal-total">Rp 150.000</span>
                </div>
            </div>
            
            <p class="text-gray-600 mb-6">Kami akan mengirimkan detail pembayaran ke WhatsApp Anda dalam waktu 5 menit.</p>
            
            <div class="flex flex-col space-y-3">
                <a href="#" id="whatsapp-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                    <i class="fab fa-whatsapp mr-2"></i> Konfirmasi via WhatsApp
                </a>
                <button id="cancel-booking" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                    Batalkan
                </button>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.classList.remove('border-blue-500');
                    btn.classList.add('border-transparent');
                });
                
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                button.classList.add('border-blue-500');
                button.classList.remove('border-transparent');
                
                const tabId = button.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // FAQ accordion
        const faqButtons = document.querySelectorAll('.faq-button');
        
        faqButtons.forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                // Toggle content
                content.classList.toggle('hidden');
                
                // Rotate icon
                if (content.classList.contains('hidden')) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        });
        
        // Booking functionality
        const bookButtons = document.querySelectorAll('.book-button');
        const bookingModal = document.getElementById('booking-modal');
        const closeModal = document.getElementById('close-modal');
        const cancelBooking = document.getElementById('cancel-booking');
        
        bookButtons.forEach(button => {
            button.addEventListener('click', () => {
                const activity = button.getAttribute('data-activity');
                const price = parseInt(button.getAttribute('data-price'));
                
                document.getElementById('modal-activity').textContent = activity;
                document.getElementById('modal-price').textContent = `Rp ${price.toLocaleString('id-ID')}`;
                
                // Default to 1 participant
                document.getElementById('modal-participants').textContent = '1';
                document.getElementById('modal-total').textContent = `Rp ${price.toLocaleString('id-ID')}`;
                
                // Set WhatsApp link
                const whatsappButton = document.getElementById('whatsapp-button');
                const whatsappMessage = `Halo, saya ingin memesan ${activity} untuk 1 orang dengan total Rp ${price.toLocaleString('id-ID')}. Mohon info lebih lanjut.`;
                whatsappButton.href = `https://wa.me/6281234567890?text=${encodeURIComponent(whatsappMessage)}`;
                
                // Show modal
                bookingModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Close modal
        closeModal.addEventListener('click', () => {
            bookingModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
        
        cancelBooking.addEventListener('click', () => {
            bookingModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
        
        // Close modal when clicking outside
        bookingModal.addEventListener('click', (e) => {
            if (e.target === bookingModal) {
                bookingModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Form submission
        const bookingForm = document.getElementById('booking-form');
        
        bookingForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const activity = document.getElementById('activity').value;
            const date = document.getElementById('date').value;
            const participants = document.getElementById('participants').value;
            
            // Format date
            const formattedDate = new Date(date).toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            
            // Create WhatsApp message
            const whatsappMessage = `Halo, saya ${name} ingin memesan:\n\nAktivitas: ${activity}\nTanggal: ${formattedDate}\nJumlah Orang: ${participants}\n\nEmail: ${email}\nNo. HP: ${phone}\n\nMohon info lebih lanjut mengenai pembayaran. Terima kasih.`;
            
            // Redirect to WhatsApp
            window.location.href = `https://wa.me/6281234567890?text=${encodeURIComponent(whatsappMessage)}`;
        });
    </script>
</body>
</html>