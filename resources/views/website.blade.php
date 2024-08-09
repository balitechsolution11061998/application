<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Learning Platform Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@300;400;700&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/stylewebsite.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Spinner Loading -->
    <div id="spinner" class="spinner-overlay">
        <div class="spinner-container">
            <img src="{{ asset('/image/logo.png') }}" alt="Logo" class="spinner-logo">
            <div class="spinner-border text-warning" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">IT Learning</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="courses">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="contact">Contact</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2 search-input" type="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-warning search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header>
        <div class="header-content container">
            <div class="col-md-6">
                <h1>
                    <strong class="text-warning">Ayo Ngoding</strong><br>
                    Media Pembelajaran Pemrograman Web &amp; Mobile serta Media Dokumentasi Coding
                </h1>
                <a href="#mulai-belajar" class="btn btn-lg btn-dark">Mulai Belajar</a>
            </div>
            <div class="col-md-6 mac-screen">
                <!-- SVG Image -->
                <img src="{{ asset('image/8106515.webp') }}" alt="SVG Image">
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="container main-container mt-5">
        <div class="row">
            <div class="col-md-4 sidebar">
                <h4>Programming Languages</h4>
                <div class="card rounded animated-card" data-target="#js-lessons">
                    <img src="{{ asset('image/js.png') }}" alt="JavaScript" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">JavaScript</h5>
                    </div>
                </div>
                <div class="card rounded animated-card" data-target="#laravel-lessons">
                    <img src="{{ asset('image/laravel.jpg') }}" alt="Laravel" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Laravel</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-lg p-4 mb-5 bg-white rounded">
                    <div class="card-body">
                        <h4 class="mb-4">Content Area</h4>
                        <p class="text-muted">This is where your main content will go. Add interesting information here.
                        </p>

                        <!-- Lesson Content -->
                        <div id="js-lessons" class="card lesson-content mb-4 shadow-sm rounded">
                            <div class="card-body">
                                <h5 class="card-title text-primary">JavaScript Lessons</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Introduction to JavaScript</li>
                                    <li class="list-group-item">JavaScript Variables and Data Types</li>
                                    <li class="list-group-item">JavaScript Functions and Loops</li>
                                </ul>
                            </div>
                        </div>

                        <div id="laravel-lessons" class="card lesson-content mb-4 shadow-sm rounded">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Laravel Dasar</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" id="pengenalan-laravel">Pengenalan Laravel</li>
                                    <li class="list-group-item">Instalasi Laravel</li>
                                    <li class="list-group-item">Routing Dasar</li>
                                    <li class="list-group-item">Blade Templating</li>
                                    <li class="list-group-item">MVC di Laravel</li>
                                    <li class="list-group-item">Database dan Eloquent ORM</li>
                                    <li class="list-group-item">Form Handling dan Validation</li>
                                    <li class="list-group-item">Authentication Dasar</li>
                                </ul>

                                <!-- Detailed Content for Pengenalan Laravel -->
                                <div id="pengenalan-laravel-content" class="mt-3" style="display: none;">
                                    <h6>Detail Pengenalan Laravel</h6>
                                    <p class="text-muted">Laravel adalah framework PHP yang dikembangkan oleh Taylor
                                        Otwell pada tahun 2011. Framework ini memudahkan pengembangan aplikasi web
                                        dengan menyediakan berbagai fitur seperti routing, middleware, autentikasi, dan
                                        masih banyak lagi. Laravel memiliki sintaks yang elegan dan mudah dipahami,
                                        sehingga sangat populer di kalangan developer web.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white py-4 bg-dark">
        <div class="container">
            <p>&copy; 2024 IT Learning Platform. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- Custom JS -->
    <script>
        window.addEventListener('load', function() {
            const spinner = document.getElementById('spinner');
            spinner.style.display = 'none';
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('click', () => {
                    // Hide all lesson contents
                    document.querySelectorAll('.lesson-content').forEach(content => {
                        content.classList.remove('active');
                    });

                    // Show the targeted lesson content
                    const target = card.getAttribute('data-target');
                    document.querySelector(target).classList.add('active');
                });
            });
        });

        document.getElementById('pengenalan-laravel').addEventListener('click', function() {
            var detailContent = document.getElementById('pengenalan-laravel-content');
            if (detailContent.style.display === "none" || detailContent.style.display === "") {
                detailContent.style.display = "block";
            } else {
                detailContent.style.display = "none";
            }
        });
    </script>
</body>

</html>
