<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universitas Teknologi Maju - Unggul, Inovatif, Berkarakter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        secondary: '#1e40af',
                        accent: '#3b82f6',
                        dark: '#0f172a',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        heading: ['Montserrat', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 6s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap');
        
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .transition-all {
            transition: all 0.3s ease;
        }
        
        .text-gradient {
            background: linear-gradient(90deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
        }
        
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: #3b82f6;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
            border-radius: 10px;
        }
        
        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            box-sizing: border-box;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -12px;
            background-color: white;
            border: 4px solid #3b82f6;
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }
        
        .left {
            left: 0;
        }
        
        .right {
            left: 50%;
        }
        
        .left::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            right: 30px;
            border: medium solid #3b82f6;
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent #3b82f6;
        }
        
        .right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            left: 30px;
            border: medium solid #3b82f6;
            border-width: 10px 10px 10px 0;
            border-color: transparent #3b82f6 transparent transparent;
        }
        
        .right::after {
            left: -12px;
        }
        
        .timeline-content {
            padding: 20px 30px;
            background-color: white;
            position: relative;
            border-radius: 6px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        @media screen and (max-width: 768px) {
            .timeline::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-item::before {
                left: 60px;
                border: medium solid #3b82f6;
                border-width: 10px 10px 10px 0;
                border-color: transparent #3b82f6 transparent transparent;
            }
            
            .left::after, .right::after {
                left: 18px;
            }
            
            .right {
                left: 0%;
            }
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Announcement Bar -->
    <div class="bg-accent text-white text-center py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center justify-center mb-2 md:mb-0">
                <i class="fas fa-bullhorn mr-2 animate-pulse"></i>
                <span class="text-sm font-medium">Pendaftaran Mahasiswa Baru Tahun Akademik 2023/2024 Telah Dibuka!</span>
            </div>
            <a href="#pendaftaran" class="text-sm font-bold hover:underline flex items-center">
                Daftar Sekarang <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-12" src="https://via.placeholder.com/150x50?text=UTM-Logo" alt="Logo Universitas">
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-6">
                            <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-primary border-b-2 border-primary">Beranda</a>
                            <a href="#tentang" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-primary transition-all">Tentang</a>
                            <a href="#fakultas" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-primary transition-all">Fakultas</a>
                            <a href="#prestasi" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-primary transition-all">Prestasi</a>
                            <a href="#fasilitas" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-primary transition-all">Fasilitas</a>
                            <a href="#berita" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-primary transition-all">Berita</a>
                            <a href="#kontak" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-primary transition-all">Kontak</a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-gray-600 hover:text-primary transition-all">
                            <i class="fas fa-search"></i>
                        </a>
                        <a href="#pendaftaran" class="bg-primary text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-secondary transition-all flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i> Pendaftaran
                        </a>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-primary focus:outline-none" aria-controls="mobile-menu" aria-expanded="false" id="menu-button">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="hidden md:hidden bg-white shadow-xl rounded-b-lg" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-primary bg-blue-50">Beranda</a>
                <a href="#tentang" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-blue-50">Tentang</a>
                <a href="#fakultas" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-blue-50">Fakultas</a>
                <a href="#prestasi" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-blue-50">Prestasi</a>
                <a href="#fasilitas" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-blue-50">Fasilitas</a>
                <a href="#berita" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-blue-50">Berita</a>
                <a href="#kontak" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-blue-50">Kontak</a>
                <a href="#pendaftaran" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary hover:bg-secondary text-center">
                    <i class="fas fa-user-graduate mr-2"></i> Pendaftaran Online
                </a>
                <div class="relative mt-2">
                    <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Cari...">
                    <button class="absolute right-3 top-2 text-gray-500">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black opacity-30"></div>
            <div class="absolute top-0 right-0 w-1/3 h-full">
                <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-l from-primary to-transparent opacity-80"></div>
                <div class="floating-element absolute top-1/4 right-1/4 w-32 h-32 rounded-full bg-white opacity-10 animate-float"></div>
                <div class="floating-element absolute top-1/3 right-1/3 w-20 h-20 rounded-full bg-white opacity-10 animate-float" style="animation-delay: 1s;"></div>
                <div class="floating-element absolute bottom-1/4 right-1/4 w-24 h-24 rounded-full bg-white opacity-10 animate-float" style="animation-delay: 2s;"></div>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32 relative z-10">
            <div class="md:flex items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-4 py-1 mb-6">
                        <span class="text-sm font-medium">#1 Teknologi & Inovasi</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 font-heading animate__animated animate__fadeInDown">
                        Universitas <span class="text-gradient">Teknologi Maju</span>
                    </h1>
                    <p class="text-xl mb-8 max-w-lg animate__animated animate__fadeIn animate__delay-1s">Mencetak generasi unggul, inovatif, dan berkarakter untuk masa depan Indonesia yang lebih baik.</p>
                    <div class="flex flex-col sm:flex-row gap-4 animate__animated animate__fadeIn animate__delay-2s">
                        <a href="#pendaftaran" class="bg-white text-primary px-8 py-3 rounded-md font-medium hover:bg-gray-100 text-center transition-all flex items-center justify-center">
                            <i class="fas fa-user-graduate mr-2"></i> Daftar Sekarang
                        </a>
                        <a href="#program" class="border-2 border-white text-white px-8 py-3 rounded-md font-medium hover:bg-white hover:text-primary text-center transition-all flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i> Jelajahi Program
                        </a>
                    </div>
                    <div class="mt-8 flex items-center space-x-6 animate__animated animate__fadeIn animate__delay-3s">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/12.jpg" alt="">
                                <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
                                <img class="w-10 h-10 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/45.jpg" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium">10,000+ Mahasiswa</div>
                                <div class="text-xs text-white text-opacity-80">Bergabung bersama kami</div>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 bg-white bg-opacity-20 rounded-full">
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <div class="ml-2">
                                    <div class="text-sm font-medium">Akreditasi A</div>
                                    <div class="text-xs text-white text-opacity-80">BAN-PT</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center animate__animated animate__fadeInRight">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Kampus Universitas Teknologi Maju" class="rounded-xl shadow-2xl border-4 border-white w-full max-w-lg">
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg hidden md:block">
                            <div class="flex items-center">
                                <div class="bg-primary p-3 rounded-lg text-white">
                                    <i class="fas fa-graduation-cap text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm text-gray-500">Lulusan Terbaik</div>
                                    <div class="font-bold text-primary">95% Kerja</div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -top-6 -right-6 bg-white p-4 rounded-xl shadow-lg hidden md:block">
                            <div class="flex items-center">
                                <div class="bg-primary p-3 rounded-lg text-white">
                                    <i class="fas fa-globe text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm text-gray-500">Kerjasama</div>
                                    <div class="font-bold text-primary">50+ Negara</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner Logos -->
    <div class="bg-white py-8 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-6">
                <p class="text-gray-500 text-sm">Berkolaborasi dengan perusahaan dan institusi ternama</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center">
                <img src="https://via.placeholder.com/150x60?text=Google" alt="Google" class="h-10 opacity-60 hover:opacity-100 transition-all mx-auto">
                <img src="https://via.placeholder.com/150x60?text=Microsoft" alt="Microsoft" class="h-10 opacity-60 hover:opacity-100 transition-all mx-auto">
                <img src="https://via.placeholder.com/150x60?text=Toyota" alt="Toyota" class="h-10 opacity-60 hover:opacity-100 transition-all mx-auto">
                <img src="https://via.placeholder.com/150x60?text=IBM" alt="IBM" class="h-10 opacity-60 hover:opacity-100 transition-all mx-auto">
                <img src="https://via.placeholder.com/150x60?text=Intel" alt="Intel" class="h-10 opacity-60 hover:opacity-100 transition-all mx-auto">
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-6 rounded-lg border border-gray-200 hover:shadow-md transition-all group">
                    <div class="text-4xl font-bold text-primary mb-2 flex justify-center">
                        <span class="group-hover:text-secondary transition-all">25+</span>
                    </div>
                    <div class="text-gray-600 group-hover:text-gray-800 transition-all">Program Studi</div>
                    <div class="mt-2 h-1 w-10 bg-primary mx-auto group-hover:bg-secondary transition-all"></div>
                </div>
                <div class="p-6 rounded-lg border border-gray-200 hover:shadow-md transition-all group">
                    <div class="text-4xl font-bold text-primary mb-2 flex justify-center">
                        <span class="group-hover:text-secondary transition-all">10K+</span>
                    </div>
                    <div class="text-gray-600 group-hover:text-gray-800 transition-all">Mahasiswa</div>
                    <div class="mt-2 h-1 w-10 bg-primary mx-auto group-hover:bg-secondary transition-all"></div>
                </div>
                <div class="p-6 rounded-lg border border-gray-200 hover:shadow-md transition-all group">
                    <div class="text-4xl font-bold text-primary mb-2 flex justify-center">
                        <span class="group-hover:text-secondary transition-all">500+</span>
                    </div>
                    <div class="text-gray-600 group-hover:text-gray-800 transition-all">Dosen</div>
                    <div class="mt-2 h-1 w-10 bg-primary mx-auto group-hover:bg-secondary transition-all"></div>
                </div>
                <div class="p-6 rounded-lg border border-gray-200 hover:shadow-md transition-all group">
                    <div class="text-4xl font-bold text-primary mb-2 flex justify-center">
                        <span class="group-hover:text-secondary transition-all">50+</span>
                    </div>
                    <div class="text-gray-600 group-hover:text-gray-800 transition-all">Kerjasama Internasional</div>
                    <div class="mt-2 h-1 w-10 bg-primary mx-auto group-hover:bg-secondary transition-all"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Jelajahi Kampus Kami</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Lihat langsung suasana dan fasilitas kampus Universitas Teknologi Maju melalui video tur virtual kami.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="rounded-xl overflow-hidden shadow-xl max-w-4xl mx-auto">
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/7X8II6J-6mU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Universitas -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Tentang Universitas Teknologi Maju</h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
            </div>
            
            <div class="md:flex items-center gap-12">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <div class="relative rounded-xl overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" alt="Tentang UTM" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-white">
                            <h3 class="text-2xl font-semibold mb-2">Sejak 1985</h3>
                            <p>Berkomitmen pada keunggulan pendidikan tinggi berbasis teknologi dan inovasi</p>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4 font-heading">Visi dan Misi</h3>
                    <p class="text-gray-600 mb-6">Universitas Teknologi Maju (UTM) didirikan pada tahun 1985 dengan komitmen untuk menjadi pusat keunggulan dalam pendidikan tinggi berbasis teknologi dan inovasi. Saat ini, UTM telah berkembang menjadi salah satu universitas terkemuka di Indonesia dengan reputasi internasional.</p>
                    
                    <div class="mb-8">
                        <h4 class="text-lg font-medium text-primary mb-2 flex items-center">
                            <i class="fas fa-eye mr-2"></i> Visi
                        </h4>
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-primary">
                            <p class="text-gray-600 italic">"Menjadi universitas berkelas dunia yang unggul dalam pengembangan ilmu pengetahuan dan teknologi untuk kesejahteraan masyarakat."</p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-medium text-primary mb-2 flex items-center">
                            <i class="fas fa-bullseye mr-2"></i> Misi
                        </h4>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="bg-primary text-white p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Menyelenggarakan pendidikan tinggi yang berkualitas dan relevan dengan kebutuhan zaman</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary text-white p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Melakukan penelitian inovatif yang bermanfaat bagi masyarakat</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary text-white p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Mengabdikan ilmu pengetahuan dan teknologi untuk memecahkan masalah masyarakat</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary text-white p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Membangun jaringan kerjasama nasional dan internasional</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="mt-16 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-2xl font-semibold text-center text-gray-900 mb-8 font-heading">Pimpinan Universitas</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center group">
                        <div class="relative inline-block mb-4">
                            <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="Rektor" class="w-40 h-40 rounded-full mx-auto border-4 border-primary object-cover group-hover:border-secondary transition-all">
                            <div class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 group-hover:bg-secondary transition-all">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-medium text-gray-900 group-hover:text-primary transition-all">Prof. Dr. Ahmad Santoso, M.Sc.</h4>
                        <p class="text-gray-600">Rektor</p>
                        <div class="mt-2 flex justify-center space-x-2">
                            <a href="#" class="text-gray-400 hover:text-primary transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition-all">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-center group">
                        <div class="relative inline-block mb-4">
                            <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Wakil Rektor 1" class="w-40 h-40 rounded-full mx-auto border-4 border-primary object-cover group-hover:border-secondary transition-all">
                            <div class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 group-hover:bg-secondary transition-all">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-medium text-gray-900 group-hover:text-primary transition-all">Dr. Siti Rahayu, M.Eng.</h4>
                        <p class="text-gray-600">Wakil Rektor Bidang Akademik</p>
                        <div class="mt-2 flex justify-center space-x-2">
                            <a href="#" class="text-gray-400 hover:text-primary transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition-all">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-center group">
                        <div class="relative inline-block mb-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Wakil Rektor 2" class="w-40 h-40 rounded-full mx-auto border-4 border-primary object-cover group-hover:border-secondary transition-all">
                            <div class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 group-hover:bg-secondary transition-all">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-medium text-gray-900 group-hover:text-primary transition-all">Dr. Bambang Wijaya, M.T.</h4>
                        <p class="text-gray-600">Wakil Rektor Bidang Keuangan</p>
                        <div class="mt-2 flex justify-center space-x-2">
                            <a href="#" class="text-gray-400 hover:text-primary transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition-all">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Sejarah -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Sejarah Perjalanan UTM</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Perjalanan panjang Universitas Teknologi Maju sejak berdiri hingga menjadi salah satu universitas terbaik di Indonesia.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="timeline">
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3 class="font-bold text-primary">1985</h3>
                        <p>Pendirian Universitas Teknologi Maju dengan 3 fakultas dan 5 program studi.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h3 class="font-bold text-primary">1992</h3>
                        <p>Peresmian kampus baru di lokasi saat ini dengan luas 50 hektar.</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3 class="font-bold text-primary">2001</h3>
                        <p>Mendapatkan akreditasi A untuk pertama kalinya dari BAN-PT.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h3 class="font-bold text-primary">2008</h3>
                        <p>Kerjasama internasional pertama dengan universitas di Jepang.</p>
                    </div>
                </div>
                <div class="timeline-item left">
                    <div class="timeline-content">
                        <h3 class="font-bold text-primary">2015</h3>
                        <p>Pembangunan gedung riset dan inovasi berteknologi tinggi.</p>
                    </div>
                </div>
                <div class="timeline-item right">
                    <div class="timeline-content">
                        <h3 class="font-bold text-primary">2020</h3>
                        <p>Pencapaian sebagai universitas dengan tingkat penyerapan lulusan tertinggi se-Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fakultas dan Program Studi -->
    <section id="fakultas" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Fakultas dan Program Studi</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Kami menawarkan berbagai program studi unggulan yang dirancang untuk memenuhi kebutuhan industri masa depan.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Fakultas 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all group">
                    <div class="bg-primary p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white bg-opacity-10"></div>
                        <div class="absolute -right-5 -bottom-5 w-20 h-20 rounded-full bg-white bg-opacity-10"></div>
                        <h3 class="text-xl font-semibold relative z-10">Fakultas Teknologi Informasi</h3>
                        <div class="absolute right-6 top-6 text-white opacity-30 group-hover:opacity-70 transition-all">
                            <i class="fas fa-laptop-code text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-laptop-code text-xs"></i>
                                </div>
                                <span>S1 Teknik Informatika <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded ml-2">A</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-database text-xs"></i>
                                </div>
                                <span>S1 Sistem Informasi <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded ml-2">A</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-shield-alt text-xs"></i>
                                </div>
                                <span>S1 Cyber Security <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-brain text-xs"></i>
                                </div>
                                <span>S2 Artificial Intelligence <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded ml-2">Baru</span></span>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center">
                            <a href="#" class="inline-flex items-center text-primary font-medium hover:text-secondary">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <span class="text-xs bg-blue-50 text-blue-800 px-2 py-1 rounded">Kuota: 200</span>
                        </div>
                    </div>
                </div>
                
                <!-- Fakultas 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all group">
                    <div class="bg-primary p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white bg-opacity-10"></div>
                        <div class="absolute -right-5 -bottom-5 w-20 h-20 rounded-full bg-white bg-opacity-10"></div>
                        <h3 class="text-xl font-semibold relative z-10">Fakultas Teknik</h3>
                        <div class="absolute right-6 top-6 text-white opacity-30 group-hover:opacity-70 transition-all">
                            <i class="fas fa-cogs text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-cogs text-xs"></i>
                                </div>
                                <span>S1 Teknik Mesin <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded ml-2">A</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-bolt text-xs"></i>
                                </div>
                                <span>S1 Teknik Elektro <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-industry text-xs"></i>
                                </div>
                                <span>S1 Teknik Industri <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-building text-xs"></i>
                                </div>
                                <span>S1 Teknik Sipil <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center">
                            <a href="#" class="inline-flex items-center text-primary font-medium hover:text-secondary">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <span class="text-xs bg-blue-50 text-blue-800 px-2 py-1 rounded">Kuota: 180</span>
                        </div>
                    </div>
                </div>
                
                <!-- Fakultas 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all group">
                    <div class="bg-primary p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white bg-opacity-10"></div>
                        <div class="absolute -right-5 -bottom-5 w-20 h-20 rounded-full bg-white bg-opacity-10"></div>
                        <h3 class="text-xl font-semibold relative z-10">Fakultas Bisnis & Ekonomi</h3>
                        <div class="absolute right-6 top-6 text-white opacity-30 group-hover:opacity-70 transition-all">
                            <i class="fas fa-chart-line text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-chart-line text-xs"></i>
                                </div>
                                <span>S1 Manajemen <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded ml-2">A</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-money-bill-wave text-xs"></i>
                                </div>
                                <span>S1 Akuntansi <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-globe text-xs"></i>
                                </div>
                                <span>S1 Bisnis Digital <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded ml-2">Baru</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-shipping-fast text-xs"></i>
                                </div>
                                <span>S1 Logistik & Supply Chain <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center">
                            <a href="#" class="inline-flex items-center text-primary font-medium hover:text-secondary">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <span class="text-xs bg-blue-50 text-blue-800 px-2 py-1 rounded">Kuota: 150</span>
                        </div>
                    </div>
                </div>
                
                <!-- Fakultas 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all group">
                    <div class="bg-primary p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white bg-opacity-10"></div>
                        <div class="absolute -right-5 -bottom-5 w-20 h-20 rounded-full bg-white bg-opacity-10"></div>
                        <h3 class="text-xl font-semibold relative z-10">Fakultas Kedokteran</h3>
                        <div class="absolute right-6 top-6 text-white opacity-30 group-hover:opacity-70 transition-all">
                            <i class="fas fa-user-md text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-user-md text-xs"></i>
                                </div>
                                <span>S1 Pendidikan Dokter <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-pills text-xs"></i>
                                </div>
                                <span>S1 Farmasi <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-dna text-xs"></i>
                                </div>
                                <span>S1 Biomedik <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded ml-2">Baru</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-heartbeat text-xs"></i>
                                </div>
                                <span>S1 Keperawatan <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center">
                            <a href="#" class="inline-flex items-center text-primary font-medium hover:text-secondary">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <span class="text-xs bg-blue-50 text-blue-800 px-2 py-1 rounded">Kuota: 120</span>
                        </div>
                    </div>
                </div>
                
                <!-- Fakultas 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all group">
                    <div class="bg-primary p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white bg-opacity-10"></div>
                        <div class="absolute -right-5 -bottom-5 w-20 h-20 rounded-full bg-white bg-opacity-10"></div>
                        <h3 class="text-xl font-semibold relative z-10">Fakultas Desain & Kreatif</h3>
                        <div class="absolute right-6 top-6 text-white opacity-30 group-hover:opacity-70 transition-all">
                            <i class="fas fa-paint-brush text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-paint-brush text-xs"></i>
                                </div>
                                <span>S1 Desain Komunikasi Visual <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-film text-xs"></i>
                                </div>
                                <span>S1 Film & Animasi <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded ml-2">Baru</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-gamepad text-xs"></i>
                                </div>
                                <span>S1 Desain Game <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded ml-2">Baru</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-tshirt text-xs"></i>
                                </div>
                                <span>S1 Desain Fashion <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center">
                            <a href="#" class="inline-flex items-center text-primary font-medium hover:text-secondary">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <span class="text-xs bg-blue-50 text-blue-800 px-2 py-1 rounded">Kuota: 100</span>
                        </div>
                    </div>
                </div>
                
                <!-- Fakultas 6 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all group">
                    <div class="bg-primary p-6 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-white bg-opacity-10"></div>
                        <div class="absolute -right-5 -bottom-5 w-20 h-20 rounded-full bg-white bg-opacity-10"></div>
                        <h3 class="text-xl font-semibold relative z-10">Program Pascasarjana</h3>
                        <div class="absolute right-6 top-6 text-white opacity-30 group-hover:opacity-70 transition-all">
                            <i class="fas fa-graduation-cap text-5xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-xs"></i>
                                </div>
                                <span>S2 Teknologi Informasi <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded ml-2">A</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-xs"></i>
                                </div>
                                <span>S2 Manajemen Teknologi <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-xs"></i>
                                </div>
                                <span>S3 Ilmu Komputer <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded ml-2">A</span></span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-graduation-cap text-xs"></i>
                                </div>
                                <span>S3 Teknik Industri <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded ml-2">B</span></span>
                            </li>
                        </ul>
                        <div class="mt-6 flex justify-between items-center">
                            <a href="#" class="inline-flex items-center text-primary font-medium hover:text-secondary">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <span class="text-xs bg-blue-50 text-blue-800 px-2 py-1 rounded">Kuota: 50</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary transition-all">
                    <i class="fas fa-list mr-2"></i> Lihat Semua Program Studi
                </a>
            </div>
        </div>
    </section>

    <!-- Proses Belajar -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Proses Belajar di UTM</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Metode pembelajaran modern yang dirancang untuk mempersiapkan mahasiswa menghadapi tantangan masa depan.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md text-center card-hover transition-all">
                    <div class="bg-primary bg-opacity-10 text-primary w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Pembelajaran Hybrid</h3>
                    <p class="text-gray-600">Kombinasi optimal antara pembelajaran tatap muka dan online dengan platform digital canggih.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md text-center card-hover transition-all">
                    <div class="bg-primary bg-opacity-10 text-primary w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-flask text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Project-Based Learning</h3>
                    <p class="text-gray-600">Belajar melalui proyek nyata yang relevan dengan industri dan masalah dunia nyata.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md text-center card-hover transition-all">
                    <div class="bg-primary bg-opacity-10 text-primary w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-briefcase text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Magang Industri</h3>
                    <p class="text-gray-600">Program magang wajib di perusahaan mitra untuk pengalaman kerja langsung.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md text-center card-hover transition-all">
                    <div class="bg-primary bg-opacity-10 text-primary w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-globe-americas text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Global Exposure</h3>
                    <p class="text-gray-600">Kesempatan pertukaran pelajar dan program double degree dengan universitas luar negeri.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Prestasi -->
    <section id="prestasi" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Prestasi & Pencapaian</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Mahasiswa dan dosen kami terus menorehkan prestasi di tingkat nasional maupun internasional.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200 text-center card-hover transition-all group">
                    <div class="text-5xl text-primary mb-4 group-hover:text-secondary transition-all">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 group-hover:text-primary transition-all">Juara 1 Kompetisi Robotik Internasional</h3>
                    <p class="text-gray-600 group-hover:text-gray-800 transition-all">Tim robotik UTM meraih juara 1 dalam International Robotics Competition di Tokyo, Jepang tahun 2023.</p>
                    <div class="mt-4 flex justify-center">
                        <a href="#" class="text-sm text-primary font-medium hover:text-secondary flex items-center">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200 text-center card-hover transition-all group">
                    <div class="text-5xl text-primary mb-4 group-hover:text-secondary transition-all">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 group-hover:text-primary transition-all">Akreditasi Internasional ABET</h3>
                    <p class="text-gray-600 group-hover:text-gray-800 transition-all">Program studi Teknik Informatika meraih akreditasi internasional ABET untuk standar pendidikan global.</p>
                    <div class="mt-4 flex justify-center">
                        <a href="#" class="text-sm text-primary font-medium hover:text-secondary flex items-center">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200 text-center card-hover transition-all group">
                    <div class="text-5xl text-primary mb-4 group-hover:text-secondary transition-all">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 group-hover:text-primary transition-all">Penelitian Terbaik Kemenristek</h3>
                    <p class="text-gray-600 group-hover:text-gray-800 transition-all">Penelitian dosen UTM tentang energi terbarukan meraih penghargaan dari Kemenristek tahun 2022.</p>
                    <div class="mt-4 flex justify-center">
                        <a href="#" class="text-sm text-primary font-medium hover:text-secondary flex items-center">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="bg-primary rounded-xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-32 h-32 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 rounded-full bg-white"></div>
                </div>
                <div class="relative z-10 md:flex items-center">
                    <div class="md:w-2/3 mb-6 md:mb-0">
                        <h3 class="text-2xl font-bold mb-4">Bergabunglah dengan Komunitas Prestasi UTM</h3>
                        <p>Dapatkan kesempatan untuk mengembangkan potensi Anda melalui berbagai program unggulan dan kompetisi yang kami selenggarakan.</p>
                    </div>
                    <div class="md:w-1/3 text-center md:text-right">
                        <a href="#pendaftaran" class="inline-block bg-white text-primary px-8 py-3 rounded-md font-medium hover:bg-gray-100 transition-all">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-12">
                <h3 class="text-2xl font-semibold text-center text-gray-900 mb-8 font-heading">Prestasi Mahasiswa Terbaru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200 card-hover transition-all">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" alt="Prestasi 1" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-primary font-semibold mb-1">KOMPETISI NASIONAL • 15 JUNI 2023</div>
                            <h4 class="font-bold mb-2">Juara 1 Lomba Karya Tulis Ilmiah Nasional</h4>
                            <p class="text-sm text-gray-600">Tim mahasiswa UTM meraih juara 1 LKTIN dengan karya inovatif di bidang energi terbarukan.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200 card-hover transition-all">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Prestasi 2" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-primary font-semibold mb-1">OLIMPIADE INTERNASIONAL • 5 MEI 2023</div>
                            <h4 class="font-bold mb-2">Medali Emas Olimpiade Matematika Asia</h4>
                            <p class="text-sm text-gray-600">Mahasiswa UTM meraih medali emas dalam kompetisi matematika tingkat Asia di Singapura.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200 card-hover transition-all">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Prestasi 3" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-primary font-semibold mb-1">HACKATHON • 22 APRIL 2023</div>
                            <h4 class="font-bold mb-2">Juara Hackathon Fintech Internasional</h4>
                            <p class="text-sm text-gray-600">Tim developer UTM menciptakan solusi fintech terbaik dalam kompetisi 48 jam non-stop.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200 card-hover transition-all">
                        <div class="h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" alt="Prestasi 4" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-primary font-semibold mb-1">PAMERAN • 10 MARET 2023</div>
                            <h4 class="font-bold mb-2">Karya Desain Dipamerkan di Milan Design Week</h4>
                            <p class="text-sm text-gray-600">Karya mahasiswa desain UTM terpilih untuk dipamerkan dalam ajang bergengsi di Italia.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-primary bg-primary bg-opacity-10 hover:bg-opacity-20 transition-all">
                        <i class="fas fa-trophy mr-2"></i> Lihat Semua Prestasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section id="fasilitas" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Fasilitas Kampus</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Kami menyediakan fasilitas lengkap untuk mendukung proses belajar mengajar yang optimal.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="relative rounded-xl overflow-hidden shadow-lg card-hover transition-all group">
                    <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1476&q=80" alt="Perpustakaan" class="w-full h-64 object-cover group-hover:scale-105 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-xl font-semibold mb-2">Perpustakaan Modern</h3>
                        <p>Koleksi lebih dari 100.000 buku dan akses ke ribuan jurnal internasional.</p>
                    </div>
                    <div class="absolute top-4 right-4 bg-white text-primary p-2 rounded-full">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden shadow-lg card-hover transition-all group">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Laboratorium" class="w-full h-64 object-cover group-hover:scale-105 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-xl font-semibold mb-2">Laboratorium Canggih</h3>
                        <p>Peralatan terkini untuk mendukung praktikum dan penelitian mahasiswa.</p>
                    </div>
                    <div class="absolute top-4 right-4 bg-white text-primary p-2 rounded-full">
                        <i class="fas fa-flask"></i>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden shadow-lg card-hover transition-all group">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Asrama" class="w-full h-64 object-cover group-hover:scale-105 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-xl font-semibold mb-2">Asrama Mahasiswa</h3>
                        <p>Tempat tinggal yang nyaman dengan fasilitas lengkap untuk mahasiswa.</p>
                    </div>
                    <div class="absolute top-4 right-4 bg-white text-primary p-2 rounded-full">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden shadow-lg card-hover transition-all group">
                    <img src="https://images.unsplash.com/photo-1547347298-4074fc3086f0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Fasilitas Olahraga" class="w-full h-64 object-cover group-hover:scale-105 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-xl font-semibold mb-2">Fasilitas Olahraga</h3>
                        <p>Lapangan olahraga lengkap dan gedung serbaguna untuk kegiatan mahasiswa.</p>
                    </div>
                    <div class="absolute top-4 right-4 bg-white text-primary p-2 rounded-full">
                        <i class="fas fa-running"></i>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden shadow-lg card-hover transition-all group">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Kantin" class="w-full h-64 object-cover group-hover:scale-105 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-xl font-semibold mb-2">Kantin Sehat</h3>
                        <p>Menyediakan makanan sehat dengan harga terjangkau untuk mahasiswa.</p>
                    </div>
                    <div class="absolute top-4 right-4 bg-white text-primary p-2 rounded-full">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
                
                <div class="relative rounded-xl overflow-hidden shadow-lg card-hover transition-all group">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1473&q=80" alt="Parkir" class="w-full h-64 object-cover group-hover:scale-105 transition-all duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-80"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="text-xl font-semibold mb-2">Area Parkir Luas</h3>
                        <p>Area parkir yang aman dan luas untuk kendaraan mahasiswa dan dosen.</p>
                    </div>
                    <div class="absolute top-4 right-4 bg-white text-primary p-2 rounded-full">
                        <i class="fas fa-parking"></i>
                    </div>
                </div>
            </div>
            
            <div class="mt-12">
                <h3 class="text-2xl font-semibold text-center text-gray-900 mb-8 font-heading">Virtual Tour Kampus</h3>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/2">
                            <div class="video-container">
                                <iframe src="https://www.youtube.com/embed/7X8II6J-6mU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="md:w-1/2 p-8">
                            <h4 class="text-xl font-bold mb-4">Jelajahi Kampus Kami Secara Virtual</h4>
                            <p class="text-gray-600 mb-6">Nikmati pengalaman berkeliling kampus UTM dari mana saja melalui tur virtual 360° kami. Lihat fasilitas, ruang kelas, laboratorium, dan lingkungan kampus secara interaktif.</p>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-full mr-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span class="text-gray-700">Pengalaman 360° interaktif</span>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-full mr-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span class="text-gray-700">Navigasi mudah ke semua area kampus</span>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-full mr-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span class="text-gray-700">Informasi detail setiap fasilitas</span>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary transition-all">
                                    <i class="fas fa-vr-cardboard mr-2"></i> Mulai Virtual Tour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita & Acara -->
    <section id="berita" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Berita & Acara Terkini</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Ikuti perkembangan terbaru seputar kegiatan dan informasi dari Universitas Teknologi Maju.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Berita 1" class="w-full h-full object-cover transition-all duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="bg-primary bg-opacity-10 text-primary px-2 py-1 rounded mr-3">Berita</span>
                            <span>15 Juni 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">UTM Meraih Peringkat 1 Universitas Teknologi Terbaik 2023</h3>
                        <p class="text-gray-600 mb-4">Universitas Teknologi Maju berhasil meraih peringkat pertama sebagai universitas teknologi terbaik di Indonesia versi Kemenristekdikti tahun 2023.</p>
                        <a href="#" class="text-primary font-medium hover:text-secondary flex items-center">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" alt="Berita 2" class="w-full h-full object-cover transition-all duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded mr-3">Acara</span>
                            <span>10 Juni 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">UTM Tech Expo 2023: Pameran Inovasi Teknologi Terbesar</h3>
                        <p class="text-gray-600 mb-4">UTM akan menyelenggarakan pameran teknologi terbesar dengan menampilkan berbagai inovasi karya mahasiswa dan dosen.</p>
                        <a href="#" class="text-primary font-medium hover:text-secondary flex items-center">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" alt="Berita 3" class="w-full h-full object-cover transition-all duration-500 hover:scale-105">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded mr-3">Prestasi</span>
                            <span>5 Juni 2023</span>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Tim UTM Juara Dunia Kompetisi AI di San Francisco</h3>
                        <p class="text-gray-600 mb-4">Tim mahasiswa UTM berhasil mengalahkan peserta dari 30 negara dalam kompetisi Artificial Intelligence di Amerika Serikat.</p>
                        <a href="#" class="text-primary font-medium hover:text-secondary flex items-center">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary transition-all">
                    <i class="fas fa-newspaper mr-2"></i> Lihat Semua Berita & Acara
                </a>
            </div>
            
            <div class="mt-16 bg-primary rounded-xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-32 h-32 rounded-full bg-white"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 rounded-full bg-white"></div>
                </div>
                <div class="relative z-10 md:flex items-center justify-between">
                    <div class="md:w-2/3 mb-6 md:mb-0">
                        <h3 class="text-2xl font-bold mb-4">Dapatkan Update Terbaru dari UTM</h3>
                        <p>Berlangganan newsletter kami untuk mendapatkan informasi terbaru seputar kegiatan, beasiswa, dan event di UTM.</p>
                    </div>
                    <div class="md:w-1/3">
                        <form class="flex">
                            <input type="email" placeholder="Email Anda" class="w-full px-4 py-3 rounded-l-md text-gray-800 focus:outline-none">
                            <button type="submit" class="bg-secondary text-white px-6 py-3 rounded-r-md hover:bg-blue-700 transition-all">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Apa Kata Mereka?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Testimoni dari mahasiswa dan alumni Universitas Teknologi Maju.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200 card-hover transition-all">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Alumni" class="w-12 h-12 rounded-full mr-4 object-cover">
                        <div>
                            <h4 class="font-semibold">Budi Santoso</h4>
                            <p class="text-sm text-gray-600">Alumni Teknik Informatika, 2020 • Software Engineer di Google</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"Kuliah di UTM memberikan saya fondasi yang kuat untuk karir di bidang IT. Kurikulum yang up-to-date dan dosen yang kompeten membuat saya siap bekerja setelah lulus. Saya sekarang bekerja di Google berkat jaringan alumni UTM yang kuat."</p>
                    <div class="mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200 card-hover transition-all">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Mahasiswa" class="w-12 h-12 rounded-full mr-4 object-cover">
                        <div>
                            <h4 class="font-semibold">Ani Wijaya</h4>
                            <p class="text-sm text-gray-600">Mahasiswa Manajemen, Angkatan 2021 • Ketua BEM UTM</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"Fasilitas kampus sangat lengkap dan mendukung kegiatan belajar. Saya juga senang dengan banyaknya kegiatan ekstrakurikuler yang bisa mengembangkan soft skill. Sebagai ketua BEM, saya mendapat banyak pengalaman berharga dalam kepemimpinan."</p>
                    <div class="mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200 card-hover transition-all">
                    <div class="flex items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/63.jpg" alt="Orang Tua" class="w-12 h-12 rounded-full mr-4 object-cover">
                        <div>
                            <h4 class="font-semibold">Ibu Siti</h4>
                            <p class="text-sm text-gray-600">Orang Tua Mahasiswa • Anak di Fakultas Kedokteran</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"Sebagai orang tua, saya sangat puas dengan sistem pendidikan di UTM. Anak saya berkembang tidak hanya secara akademik tapi juga secara karakter dan kepribadian. Lingkungan kampus yang aman dan nyaman membuat saya tenang."</p>
                    <div class="mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary transition-all">
                    <i class="fas fa-comment-alt mr-2"></i> Lihat Lebih Banyak Testimoni
                </a>
            </div>
        </div>
    </section>

    <!-- Galeri -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Galeri Kampus</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Momen-momen berharga dan pemandangan indah di lingkungan kampus UTM.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Galeri 1" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" alt="Galeri 2" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" alt="Galeri 3" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Galeri 4" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" alt="Galeri 5" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Galeri 6" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Galeri 7" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
                <a href="#" class="group relative block overflow-hidden rounded-xl">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1473&q=80" alt="Galeri 8" class="h-64 w-full object-cover transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </a>
            </div>
            
            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary transition-all">
                    <i class="fas fa-images mr-2"></i> Lihat Galeri Lengkap
                </a>
            </div>
        </div>
    </section>

    <!-- Pendaftaran -->
    <section id="pendaftaran" class="py-20 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h2 class="text-3xl font-bold mb-6 font-heading">Pendaftaran Mahasiswa Baru</h2>
                    <p class="text-xl mb-8">Tahun Akademik 2023/2024 telah dibuka! Daftarkan diri Anda sekarang dan raih masa depan gemilang bersama UTM.</p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start bg-white bg-opacity-10 p-4 rounded-lg">
                            <i class="fas fa-check-circle text-accent mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium">Gelombang 1: 1 Januari - 31 Maret 2023</h4>
                                <p class="text-sm text-white text-opacity-80">Diskon 20% biaya pendaftaran & beasiswa prestasi</p>
                            </div>
                        </div>
                        <div class="flex items-start bg-white bg-opacity-10 p-4 rounded-lg">
                            <i class="fas fa-check-circle text-accent mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium">Gelombang 2: 1 April - 30 Juni 2023</h4>
                                <p class="text-sm text-white text-opacity-80">Diskon 10% biaya pendaftaran</p>
                            </div>
                        </div>
                        <div class="flex items-start bg-white bg-opacity-10 p-4 rounded-lg">
                            <i class="fas fa-check-circle text-accent mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium">Gelombang 3: 1 Juli - 30 September 2023</h4>
                                <p class="text-sm text-white text-opacity-80">Pendaftaran reguler</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-phone-alt mr-3"></i>
                            <span>Hotline Pendaftaran: (021) 12345678</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>Email: admisi@utm.ac.id</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            <span>Kantor Admisi: Gedung Rektorat Lt. 1</span>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-1/2 bg-white rounded-xl p-8 text-gray-800 shadow-2xl">
                    <h3 class="text-2xl font-semibold mb-6 text-center font-heading">Formulir Pendaftaran Online</h3>
                    <form>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium" for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium" for="email">Email</label>
                                <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium" for="hp">No. Handphone</label>
                                <input type="tel" id="hp" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium" for="pendidikan">Pendidikan Terakhir</label>
                                <select id="pendidikan" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="sma">SMA/SMK</option>
                                    <option value="d3">D3</option>
                                    <option value="s1">S1</option>
                                    <option value="s2">S2</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium" for="gelombang">Gelombang Pendaftaran</label>
                                <select id="gelombang" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Pilih Gelombang</option>
                                    <option value="1">Gelombang 1</option>
                                    <option value="2">Gelombang 2</option>
                                    <option value="3">Gelombang 3</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium" for="program">Program Studi yang Dipilih</label>
                            <select id="program" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Pilih Program Studi</option>
                                <option value="informatika">S1 Teknik Informatika</option>
                                <option value="sistem-informasi">S1 Sistem Informasi</option>
                                <option value="manajemen">S1 Manajemen</option>
                                <option value="kedokteran">S1 Pendidikan Dokter</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2 font-medium" for="pertanyaan">Pertanyaan atau Pesan</label>
                            <textarea id="pertanyaan" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="agree" name="agree" type="checkbox" class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="agree" class="text-gray-700">Saya menyetujui syarat dan ketentuan pendaftaran</label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-md font-medium hover:bg-secondary transition-all flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pendaftaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Beasiswa -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Program Beasiswa</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Berbagai program beasiswa untuk mendukung pendidikan mahasiswa berprestasi.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all">
                    <div class="bg-primary p-6 text-white text-center">
                        <h3 class="text-xl font-semibold">Beasiswa Prestasi</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-3xl font-bold text-primary mb-4 text-center">100% - 50%</div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Untuk lulusan SMA dengan nilai rata-rata UN ≥ 85</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Mengisi formulir pendaftaran beasiswa</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Melampirkan sertifikat prestasi (jika ada)</span>
                            </li>
                        </ul>
                        <a href="#" class="w-full block text-center bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-md font-medium hover:bg-opacity-20 transition-all">
                            Selengkapnya
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all">
                    <div class="bg-primary p-6 text-white text-center">
                        <h3 class="text-xl font-semibold">Beasiswa KIP-Kuliah</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-3xl font-bold text-primary mb-4 text-center">100%</div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Untuk mahasiswa dari keluarga kurang mampu</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Penerima KIP atau memenuhi kriteria KIP Kuliah</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Melampirkan dokumen pendukung</span>
                            </li>
                        </ul>
                        <a href="#" class="w-full block text-center bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-md font-medium hover:bg-opacity-20 transition-all">
                            Selengkapnya
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 card-hover transition-all">
                    <div class="bg-primary p-6 text-white text-center">
                        <h3 class="text-xl font-semibold">Beasiswa Mitra Perusahaan</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-3xl font-bold text-primary mb-4 text-center">50% - 100%</div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Kerjasama dengan perusahaan mitra</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Ikut seleksi dari perusahaan terkait</span>
                            </li>
                            <li class="flex items-start">
                                <div class="bg-primary bg-opacity-10 text-primary p-1 rounded-full mr-3 mt-1 flex-shrink-0">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-gray-600">Ikatan dinas setelah lulus (opsional)</span>
                            </li>
                        </ul>
                        <a href="#" class="w-full block text-center bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-md font-medium hover:bg-opacity-20 transition-all">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary transition-all">
                    <i class="fas fa-graduation-cap mr-2"></i> Informasi Lengkap Beasiswa
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Temukan jawaban atas pertanyaan umum seputar pendaftaran dan studi di UTM.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="max-w-3xl mx-auto">
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                            <span class="text-lg font-medium text-gray-900">Bagaimana cara mendaftar di UTM?</span>
                            <i class="fas fa-chevron-down text-primary transition-transform duration-200"></i>
                        </button>
                        <div class="px-6 pb-6 hidden">
                            <p class="text-gray-600">Pendaftaran dapat dilakukan secara online melalui website resmi UTM. Anda perlu mengisi formulir pendaftaran, mengunggah dokumen yang diperlukan, dan mengikuti prosedur seleksi yang berlaku. Untuk panduan lengkap, silakan kunjungi halaman pendaftaran kami.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                            <span class="text-lg font-medium text-gray-900">Apa saja persyaratan pendaftaran?</span>
                            <i class="fas fa-chevron-down text-primary transition-transform duration-200"></i>
                        </button>
                        <div class="px-6 pb-6 hidden">
                            <p class="text-gray-600">Persyaratan umum meliputi fotokopi ijazah dan transkrip nilai yang telah dilegalisir, fotokopi KTP/Kartu Pelajar, pas foto terbaru, dan dokumen pendukung lainnya tergantung program studi. Untuk informasi lengkap, silakan lihat persyaratan khusus di halaman program studi yang Anda minati.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                            <span class="text-lg font-medium text-gray-900">Apakah UTM menyediakan asrama?</span>
                            <i class="fas fa-chevron-down text-primary transition-transform duration-200"></i>
                        </button>
                        <div class="px-6 pb-6 hidden">
                            <p class="text-gray-600">Ya, UTM menyediakan asrama mahasiswa dengan fasilitas lengkap seperti kamar ber-AC, wifi, area belajar, kantin, dan keamanan 24 jam. Asrama tersedia untuk mahasiswa baru dan dapat diajukan bersamaan dengan pendaftaran.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                            <span class="text-lg font-medium text-gray-900">Bagaimana sistem pembayaran uang kuliah?</span>
                            <i class="fas fa-chevron-down text-primary transition-transform duration-200"></i>
                        </button>
                        <div class="px-6 pb-6 hidden">
                            <p class="text-gray-600">UTM menerapkan sistem UKT (Uang Kuliah Tunggal) yang dibayar per semester. Besaran UKT bervariasi berdasarkan program studi dan kemampuan ekonomi mahasiswa. Pembayaran dapat dilakukan secara penuh atau dicicil maksimal 4 kali per semester.</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                            <span class="text-lg font-medium text-gray-900">Apakah lulusan UTM mudah mendapatkan pekerjaan?</span>
                            <i class="fas fa-chevron-down text-primary transition-transform duration-200"></i>
                        </button>
                        <div class="px-6 pb-6 hidden">
                            <p class="text-gray-600">Berdasarkan data tracer study, 95% lulusan UTM mendapatkan pekerjaan dalam waktu 6 bulan setelah wisuda. UTM memiliki Career Development Center yang aktif membantu mahasiswa dalam mencari pekerjaan melalui job fair, pelatihan karir, dan jaringan dengan perusahaan mitra.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 text-center">
                    <p class="text-gray-600 mb-6">Masih ada pertanyaan lain?</p>
                    <a href="#kontak" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary transition-all">
                        <i class="fas fa-headset mr-2"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak & Lokasi -->
    <section id="kontak" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 font-heading">Kontak & Lokasi Kampus</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Kami siap membantu Anda untuk informasi lebih lanjut tentang Universitas Teknologi Maju.</p>
                <div class="w-20 h-1 bg-primary mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-xl font-semibold mb-6">Informasi Kontak</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Alamat Kampus</h4>
                                <p class="text-gray-600">Jl. Teknologi No. 123, Kota Maju, Jawa Barat, Indonesia 12345</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                                <i class="fas fa-phone-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Telepon</h4>
                                <p class="text-gray-600">(021) 12345678 (Hunting)</p>
                                <p class="text-gray-600">0812-3456-7890 (WhatsApp)</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Email</h4>
                                <p class="text-gray-600">info@utm.ac.id</p>
                                <p class="text-gray-600">admisi@utm.ac.id (Pendaftaran)</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Jumat: 08.00 - 16.00 WIB</p>
                                <p class="text-gray-600">Sabtu: 08.00 - 12.00 WIB</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                            <div class="bg-primary text-white p-3 rounded-lg mr-4 flex-shrink-0">
                                <i class="fas fa-share-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Media Sosial</h4>
                                <div class="flex space-x-4 mt-2">
                                    <a href="#" class="text-primary hover:text-secondary text-2xl"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="text-primary hover:text-secondary text-2xl"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="text-primary hover:text-secondary text-2xl"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="text-primary hover:text-secondary text-2xl"><i class="fab fa-youtube"></i></a>
                                    <a href="#" class="text-primary hover:text-secondary text-2xl"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold mb-6">Kirim Pesan kepada Kami</h3>
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 mb-2" for="nama-kontak">Nama Lengkap</label>
                                    <input type="text" id="nama-kontak" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2" for="email-kontak">Email</label>
                                    <input type="email" id="email-kontak" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="subjek">Subjek</label>
                                <input type="text" id="subjek" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="pesan">Pesan</label>
                                <textarea id="pesan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-primary text-white py-3 rounded-md font-medium hover:bg-secondary transition-all">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-6 mt-8">Lokasi Kampus</h3>
                    <div class="rounded-xl overflow-hidden shadow-lg">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8191613506864!3d-6.194741395493371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e839560a85ab!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1629780000000!5m2!1sen!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6 font-heading">Siap Memulai Perjalanan Akademis Anda?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Bergabunglah dengan komunitas akademik yang dinamis dan inovatif di Universitas Teknologi Maju.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#pendaftaran" class="bg-white text-primary px-8 py-3 rounded-md font-medium hover:bg-gray-100 text-center transition-all flex items-center justify-center">
                    <i class="fas fa-user-graduate mr-2"></i> Daftar Sekarang
                </a>
                <a href="#kontak" class="border-2 border-white text-white px-8 py-3 rounded-md font-medium hover:bg-white hover:text-primary text-center transition-all flex items-center justify-center">
                    <i class="fas fa-headset mr-2"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <img src="https://via.placeholder.com/150x50?text=UTM-Logo" alt="Logo Universitas" class="h-10 mb-4">
                    <p class="text-gray-400 mb-4">Universitas Teknologi Maju merupakan perguruan tinggi terkemuka di Indonesia yang berkomitmen pada keunggulan dalam pendidikan, penelitian, dan pengabdian masyarakat.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Beranda</a></li>
                        <li><a href="#tentang" class="text-gray-400 hover:text-white transition-all">Tentang UTM</a></li>
                        <li><a href="#fakultas" class="text-gray-400 hover:text-white transition-all">Fakultas</a></li>
                        <li><a href="#pendaftaran" class="text-gray-400 hover:text-white transition-all">Pendaftaran</a></li>
                        <li><a href="#beasiswa" class="text-gray-400 hover:text-white transition-all">Beasiswa</a></li>
                        <li><a href="#kontak" class="text-gray-400 hover:text-white transition-all">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Perpustakaan Digital</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Sistem Informasi Akademik</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">E-Learning</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Beasiswa</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-all">Alumni</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak Kami</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>Jl. Teknologi No. 123, Kota Maju, Jawa Barat, Indonesia 12345</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3"></i>
                            <span>(021) 12345678</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3"></i>
                            <span>info@utm.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8">
                <div class="md:flex md:items-center md:justify-between">
                    <p class="text-gray-400 text-center md:text-left">© 2023 Universitas Teknologi Maju. All rights reserved.</p>
                    <div class="flex justify-center md:justify-end space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            Kebijakan Privasi
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            Syarat & Ketentuan
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-all">
                            Peta Situs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-primary text-white p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Mobile menu toggle
        document.getElementById('menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobile-menu');
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });
        
        // FAQ accordion
        document.querySelectorAll('.border button').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.classList.add('transform', 'rotate-180');
                } else {
                    content.classList.add('hidden');
                    icon.classList.remove('transform', 'rotate-180');
                }
            });
        });
        
        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Animation on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate__animated');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    const animation = element.getAttribute('data-animation');
                    element.classList.add(animation);
                }
            });
        }
        
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
    </script>
</body>
</html>