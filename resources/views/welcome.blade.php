<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif; /* Apply Poppins font */
        }

        .hero {
            background-image: url('img/background/schollbackground.jpg'); /* Set the background image */
            background-size: cover; /* Cover the entire hero area */
            background-position: center; /* Center the image */
            color: white;
            padding: 60px 0;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            position: relative;
            border-radius: 0 0 20px 20px; /* Rounded corners only at the bottom */
            overflow: hidden; /* Ensure child elements respect the border radius */
            height: 60vh; /* Set height to 60% of the viewport height for responsiveness */
        }

        .hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
            z-index: 1; /* Ensure overlay is above the background image */
        }

        .hero .container {
            position: relative;
            z-index: 2; /* Ensure text is above the overlay */
        }

        .navbar {
            transition: background-color 0.3s, box-shadow 0.3s;
            background-color: transparent; /* Start with transparent */
            border-radius: 0 0 20px 20px; /* Rounded corners only at the bottom */
        }

        .navbar.scrolled {
            background-color: #007bff; /* Change to blue on scroll */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        .navbar .navbar-brand {
            color: white; /* Set brand text color to white */
            font-weight: bold; /* Make brand text bold */
        }

        .navbar .navbar-nav .nav-link {
            color: white; /* Set text color to white */
            font-weight: bold; /* Make text bold */
            transition: color 0.3s, background-color 0.3s; /* Smooth transition for color and background */
            padding: 10px 15px; /* Add padding for better hover effect */
        }

        .navbar .nav-link:hover {
            color: #ffc107; /* Change text color on hover */
            background-color: rgba(255, 255, 255, 0.2); /* Add a semi-transparent background on hover */
            border-radius: 5px; /* Rounded corners for hover effect */
        }

        .section-title {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #3b82f6;
        }

        footer {
            background-color: #f1f1f1;
            padding: 20px 0;
            border-radius: 15px 15px 0 0;
        }

        .btn-custom {
            background-color: #007bff; /* Change button color to blue */
            color: white;
            transition: background-color 0.3s, transform 0.3s;
            border-radius: 20px; /* Rounded button */
        }

        .btn-custom:hover {
            background-color: #0056b3; /* Darker blue on hover */
            transform: scale(1.05);
        }

        .card {
            transition: transform 0.3s;
            border-radius: 15px; /* Rounded card */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .card:hover {
            transform: translateY(-5px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .progress {
            height: 1.5rem;
            border-radius: 9999px;
        }

        /* Loader Styles */
        .loader {
            width: 80px;
            aspect-ratio: 1;
            padding: 10px;
            box-sizing: border-box;
            background: #fff;
            display: grid;
            filter: blur(5px) contrast(15) hue-rotate(120deg);
            mix-blend-mode: darken;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999; /* Ensure loader is on top */
        }

        .loader:before,
        .loader:after {
            content: "";
            grid-area: 1/1;
            margin: 5px;
            background: #ff00ff;
        }

        .loader:after {
            margin: 17px;
            animation: l9 2s infinite;
        }

        @keyframes l9 {
            12.5% {
                transform: translate(-60%, 60%)
            }
            25% {
                transform: translate(65%, -65%)
            }
            37.5% {
                transform: translate(0, 0)
            }
            50% {
                transform: translate(60%, 60%)
            }
            67.5% {
                transform: translate(-65%, -70%)
            }
            75% {
                transform: translate(60%, -60%)
            }
        }

        /* Carousel Styles */
        .carousel-inner {
            background-color: #007bff; /* Set carousel background color to blue */
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for better readability */
            border-radius: 10px; /* Rounded corners for caption background */
            padding: 10px; /* Padding for caption */
        }

        /* Logo Styles */
        .navbar-brand img,
        .carousel-logo {
            width: 40px; /* Set logo width */
            height: 40px; /* Set logo height */
            border-radius: 50%; /* Make logo rounded */
            margin-right: 10px; /* Space between logo and text */
        }

        .school-introduction {
            background-color: #007bff; /* Blue background for the introduction */
            color: white; /* White text color */
            padding: 20px; /* Padding for the introduction */
            border-radius: 15px; /* Rounded corners */
            margin: 20px 0; /* Margin for spacing */
            animation: fadeIn 1s ease-in-out; /* Fade-in animation */
        }

        /* Title Animation */
        .title-animated {
            color: transparent; /* Start with transparent */
            transition: color 0.5s ease; /* Smooth transition for color */
        }

        .title-animated.scrolled {
            color: white; /* Change to white when scrolled */
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div class="loader" id="loader" style="display: none;">
        <i class="fas fa-spinner fa-spin"></i> <!-- Font Awesome spinner -->
    </div>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo/logo.png') }}" alt="School Logo"> <!-- Add your logo image here -->
                SMP N 1 Kuta Selatan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#visi-misi">Visi & Misi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sejarah">Sejarah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#guru">Guru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pegawai">Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#berita">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Galeri</a>
                    </li>
                </ul>
                <a href="/login/form" class="btn btn-custom ms-3">Login <i class="fas fa-sign-in-alt"></i></a>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="overlay"></div>
        <div class="container">
            <img src="{{ asset('img/logo/logo.png') }}" alt="School Logo" class="mb-4" style="width: 100px; height: auto;"> <!-- Logo above the welcome message -->
            <h1 class="display-4">Selamat Datang di SMP N 1 Kuta Selatan</h1> <!-- Changed to school name -->
            <p class="lead">Kelola pembayaran biaya sekolah Anda dengan mudah dan efisien.</p>
        </div>
    </div>

    <div class="container my-5">
        <!-- Home Section -->
        <section id="home">
            <h2 class="h4 section-title">Beranda</h2>
            <p>Selamat datang di situs resmi SMP N 1 Kuta Selatan. Di sini Anda dapat menemukan semua informasi yang Anda butuhkan tentang sekolah kami.</p>
        </section>

        <!-- Visi & Misi Section -->
        <section id="visi-misi" class="mt-5">
            <h2 class="h4 section-title">Visi & Misi</h2>
            <p>Visi kami adalah menjadi lembaga pendidikan terkemuka yang membina siswa untuk menjadi individu yang bertanggung jawab dan sukses. Misi kami adalah memberikan pendidikan berkualitas dan membina lingkungan belajar yang mendukung.</p>
        </section>

        <!-- Sejarah Section -->
        <section id="sejarah" class="mt-5">
            <h2 class="h4 section-title">Sejarah</h2>
            <p>SMP N 1 Kuta Selatan didirikan pada [Tahun]. Sejak saat itu, kami berkomitmen untuk memberikan pendidikan berkualitas dan membina kecintaan terhadap belajar di antara siswa kami.</p>
        </section>

        <!-- Guru Section -->
        <section id="guru" class="mt-5">
            <h2 class="h4 section-title">Guru</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('img/guru1.jpg') }}" class="card-img-top" alt="Guru 1"> <!-- Image for Teacher 1 -->
                        <div class="card-body">
                            <h5 class="card-title">Budi Santoso</h5>
                            <p class="card-text">Guru Matematika dengan pengalaman lebih dari 10 tahun dalam mengajar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('img/guru2.jpg') }}" class="card-img-top" alt="Guru 2"> <!-- Image for Teacher 2 -->
                        <div class="card-body">
                            <h5 class="card-title">Siti Aminah</h5>
                            <p class="card-text">Guru Bahasa Inggris yang berkomitmen untuk meningkatkan kemampuan berbahasa siswa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('img/guru3.jpg') }}" class="card-img-top" alt="Guru 3"> <!-- Image for Teacher 3 -->
                        <div class="card-body">
                            <h5 class="card-title">Ahmad Rizal</h5>
                            <p class="card-text">Guru IPA yang selalu berusaha membuat pelajaran menjadi menarik dan menyenangkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Pegawai Section -->
        <section id="pegawai" class="mt-5">
            <h2 class="h4 section-title">Pegawai</h2>
            <p>Staf administrasi kami bekerja tanpa lelah di belakang layar untuk memastikan semuanya berjalan lancar di SMP N 1 Kuta Selatan.</p>
        </section>

        <!-- Berita Section -->
        <section id="berita" class="mt-5">
            <h2 class="h4 section-title">Berita</h2>
            <p>Ikuti berita terbaru dan acara yang terjadi di sekolah kami. Kami secara rutin memposting pembaruan di situs web dan saluran media sosial kami.</p>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="mt-5">
            <h2 class="h4 section-title">Galeri</h2>
            <p>Jelajahi galeri kami untuk melihat foto-foto acara sekolah, kegiatan, dan kehidupan yang dinamis di SMP N 1 Kuta Selatan.</p>
        </section>

        <!-- About Our School Section -->
        <section class="school-introduction mt-5">
            <h2 class="h4 section-title" style="color: white;">Tentang Sekolah Kami</h2>
            <p>
                SMP N 1 Kuta Selatan berkomitmen untuk memberikan pendidikan berkualitas tinggi yang mendorong keunggulan akademis dan pertumbuhan pribadi. Misi kami adalah menciptakan lingkungan yang mendukung di mana siswa dapat berkembang dan mengembangkan keterampilan mereka untuk masa depan.
            </p>
            <p>
                Kami menawarkan kurikulum yang komprehensif yang mencakup berbagai mata pelajaran, kegiatan ekstrakurikuler, dan peluang keterlibatan masyarakat. Guru-guru kami yang berpengalaman berkomitmen untuk membimbing siswa melalui perjalanan pendidikan mereka, memastikan mereka siap menghadapi tantangan di depan.
            </p>
            <p>
                Di SMP N 1 Kuta Selatan, kami percaya akan pentingnya pengembangan karakter dan penanaman nilai-nilai seperti rasa hormat, tanggung jawab, dan integritas. Kami berusaha untuk menciptakan komunitas yang mendukung yang mendorong kolaborasi dan pembelajaran seumur hidup.
            </p>
        </section>
    </div>

    <footer class="text-center mt-4">
        <p class="text-muted">Hubungi kami di:
            <a href="mailto:info@sppmanagement.com" class="text-primary">info@sppmanagement.com</a>
        </p>
        <p class="text-muted">Ikuti kami di media sosial:</p>
        <div class="d-flex justify-content-center mt-2">
            <a href="#" class="text-primary me-3">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="text-primary me-3">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="text-primary">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hide loader after the page is fully loaded
        window.onload = function() {
            document.getElementById('loader').style.display = 'none'; // Hide the loader
        };

        // Change navbar color on scroll
        window.onscroll = function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };

        // Show loader on navbar link click
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('loader').style.display = 'grid'; // Show the loader
                setTimeout(() => {
                    document.getElementById('loader').style.display = 'none'; // Hide the loader after 1 second
                }, 1000); // Adjust the duration as needed
            });
        });
    </script>
</body>

</html>
