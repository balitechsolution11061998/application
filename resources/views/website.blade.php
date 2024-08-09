<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Learning Platform Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1, h2, h5 {
            font-family: 'Montserrat', sans-serif;
        }

        /* Navbar Styles */
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .navbar:hover {
            background-color: #343a40;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        /* Header Section */
        header {
            background: url('https://via.placeholder.com/1920x600?text=Blog+Header') no-repeat center center/cover;
            color: white;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
            position: relative;
            padding: 5rem 0;
            animation: fadeIn 2s ease-out;
        }

        header:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        header .container {
            position: relative;
            z-index: 2;
        }

        header h1 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            opacity: 0;
            animation: fadeInUp 1s 0.5s forwards;
        }

        header p.lead {
            font-size: 1.25rem;
            opacity: 0;
            animation: fadeInUp 1s 1s forwards;
        }

        header .btn {
            font-size: 1.125rem;
            padding: 0.75rem 1.5rem;
            opacity: 0;
            animation: fadeInUp 1s 1.5s forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Carousel Section */
        #topics-carousel h2 {
            margin-bottom: 2rem;
            font-weight: 700;
            animation: fadeIn 2s ease-out;
        }

        .carousel-item img {
            filter: brightness(0.8);
            transition: transform 0.5s ease-in-out;
        }

        .carousel-item:hover img {
            transform: scale(1.1);
        }

        .carousel-caption h5 {
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        }

        .carousel-caption p {
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Categories Section */
        .btn-category {
            font-size: 1rem;
            margin: 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
            display: inline-block;
            padding: 0.5rem 1rem;
        }

        .btn-category:hover {
            transform: scale(1.05);
        }

        .category-tag {
            display: inline-block;
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            background-color: #e9ecef;
            color: #495057;
            margin: 0.25rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .category-tag:hover {
            background-color: #343a40;
            color: #ffffff;
        }

        /* Blog Section */
        .blog-post {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
            transition: box-shadow 0.3s ease;
        }

        .blog-post:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .blog-post img {
            max-width: 100%;
            height: auto;
        }

        .blog-post h2 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .blog-post p {
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background-color: #343a40;
            padding: 2rem 0;
            text-align: center;
            color: white;
        }

    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">IT Learning</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="text-center">
        <div class="container">
            <h1>Welcome to IT Learning Blog</h1>
            <p class="lead">Your gateway to mastering IT skills</p>
            <a href="#" class="btn btn-warning btn-lg">Get Started</a>
        </div>
    </header>

    <!-- Carousel Section -->
    <section id="topics-carousel" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Explore Popular Topics</h2>
            <div id="carouselExampleIndicators" class="carousel slide">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://via.placeholder.com/800x500?text=Laravel" class="d-block w-100" alt="Laravel">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Learn Laravel</h5>
                            <p>Master one of the most popular PHP frameworks for modern web development.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/800x500?text=React+JS" class="d-block w-100" alt="React">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>React JS</h5>
                            <p>Build dynamic and fast web applications with React, a powerful JavaScript library.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/800x500?text=Python" class="d-block w-100" alt="Python">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Python for Data Science</h5>
                            <p>Explore the world of data science with Python, one of the most versatile programming languages.</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">Categories</h2>
            <div class="d-flex justify-content-center flex-wrap">
                <a href="#" class="btn btn-primary btn-category">Web Development</a>
                <a href="#" class="btn btn-secondary btn-category">Data Science</a>
                <a href="#" class="btn btn-success btn-category">Machine Learning</a>
                <a href="#" class="btn btn-info btn-category">Cloud Computing</a>
                <a href="#" class="btn btn-warning btn-category">DevOps</a>
                <a href="#" class="btn btn-danger btn-category">Cyber Security</a>
            </div>
        </div>
    </section>

    <!-- Blog Posts Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Latest Blog Posts</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="blog-post p-3 bg-white rounded">
                        <img src="https://via.placeholder.com/400x250?text=Blog+Post+1" class="img-fluid rounded" alt="Blog Post 1">
                        <h2 class="mt-3">Understanding the Basics of Laravel</h2>
                        <div class="mb-3">
                            <span class="badge bg-primary">Laravel</span>
                            <span class="badge bg-secondary">PHP</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vehicula, leo vel fermentum gravida, velit orci blandit mi, sit amet fringilla libero purus ut erat.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="blog-post p-3 bg-white rounded">
                        <img src="https://via.placeholder.com/400x250?text=Blog+Post+2" class="img-fluid rounded" alt="Blog Post 2">
                        <h2 class="mt-3">Getting Started with React JS</h2>
                        <div class="mb-3">
                            <span class="badge bg-success">React</span>
                            <span class="badge bg-info">JavaScript</span>
                        </div>
                        <p>Maecenas euismod, dolor in condimentum pretium, ligula augue egestas urna, a bibendum lorem arcu in ex. Vestibulum at bibendum dolor.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="blog-post p-3 bg-white rounded">
                        <img src="https://via.placeholder.com/400x250?text=Blog+Post+3" class="img-fluid rounded" alt="Blog Post 3">
                        <h2 class="mt-3">Top 10 Python Libraries for Data Science</h2>
                        <div class="mb-3">
                            <span class="badge bg-warning text-dark">Python</span>
                            <span class="badge bg-danger">Data Science</span>
                        </div>
                        <p>Donec euismod, tortor in gravida facilisis, lorem sem fermentum velit, a fringilla urna libero et urna. Suspendisse potenti.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-white py-4 bg-dark">
        <div class="container">
            <p>&copy; 2024 IT Learning Platform. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
