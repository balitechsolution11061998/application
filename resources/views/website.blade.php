<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coding Tutorials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            background-color: #f4f7f8;
            margin: 0;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #007bff, #0056b3);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.75rem;
            transition: color 0.3s;
        }

        .navbar-brand:hover {
            color: #e2e6ea;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-size: 1.1rem;
            margin-left: 1rem;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #d0d0d0;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"%3e%3cpath stroke="rgba(255, 255, 255, 0.8)" stroke-width="2" d="M5 8h20M5 15h20M5 22h20"/%3e%3c/svg%3e');
        }

        /* Opening Message Section */
        .opening-message {
            background-color: #007bff;
            color: #fff;
            padding: 4rem 0;
            text-align: center;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .opening-message h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .opening-message p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .opening-message .btn {
            font-size: 1.1rem;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .opening-message .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Category Filter Section */
        .category-filter {
            margin: 2rem 0;
            text-align: center;
        }

        .category-filter button {
            margin: 0.5rem;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .category-filter button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        /* Search Bar */
        .search-bar {
            margin: 2rem auto;
            text-align: center;
        }

        .search-bar input {
            width: 80%;
            max-width: 500px;
            padding: 0.75rem;
            border-radius: 25px;
            border: 1px solid #007bff;
        }

        /* Tutorials Section */
        #tutorials {
            margin-top: 2rem;
            padding: 2rem 0;
        }

        .tutorial-card {
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .tutorial-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .tutorial-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        .tutorial-card .card-body {
            text-align: center;
        }

        .tutorial-card .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        .tutorial-card .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        /* About Me Section */
        .about-me {
            background-color: #f4f7f8;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }

        .about-me h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .about-me p {
            font-size: 1.25rem;
            color: #6c757d;
        }

        /* Footer Section */
        footer {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 1rem 0;
            text-align: center;
            margin-top: 2rem;
            border-radius: 10px;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .opening-message h1 {
                font-size: 2rem;
            }

            .category-filter button {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }

            .tutorial-card .card-title {
                font-size: 1.25rem;
            }

            .search-bar input {
                width: 90%;
            }

            .about-me h2 {
                font-size: 1.5rem;
            }
        }

        .about-me {
            padding: 60px 0;
            background: linear-gradient(135deg, #5c6bc0, #8e99f3);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .about-me .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s ease-out forwards;
        }

        .about-me h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #fff;
            position: relative;
            z-index: 2;
        }

        .about-me p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #f5f5f5;
            position: relative;
            z-index: 2;
        }

        .about-me::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
            transform: rotate(45deg);
            z-index: 1;
            animation: rotate 15s linear infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
        .category-filter {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 20px;
}

.category-filter .btn {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.category-filter .btn i {
    margin-right: 8px;
    font-size: 18px;
}

.category-filter .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.category-filter .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.category-filter .btn-outline-primary {
    background-color: transparent;
    border-color: #007bff;
    color: #007bff;
}

.category-filter .btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
}
.about-me {
    font-family: 'Roboto', sans-serif;
    color: #333;
    padding: 60px 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.about-me h2 {
    font-family: 'Montserrat', sans-serif;
    font-size: 36px;
    font-weight: 700;
    color: #007bff;
    margin-bottom: 20px;
    text-align: center;
}

.about-me p {
    font-size: 18px;
    line-height: 1.6;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}
.about-me {
    font-family: 'Roboto', sans-serif;
    color: #333;
    padding: 60px 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    align-items: center;
}

.about-text {
    animation: fadeInLeft 1s ease-out forwards;
}

.about-image {
    animation: fadeInRight 1s ease-out forwards;
}

.about-image img {
    max-width: 100%;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.about-me h2 {
    font-family: 'Montserrat', sans-serif;
    font-size: 36px;
    font-weight: 700;
    color: #007bff;
    margin-bottom: 20px;
}

.about-me p {
    font-size: 18px;
    line-height: 1.6;
}

@keyframes fadeInLeft {
    0% {
        opacity: 0;
        transform: translateX(-20px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    0% {
        opacity: 0;
        transform: translateX(20px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Scroll Animation Trigger */
.scroll-reveal {
    opacity: 1;
    transform: translateY(0);
}
/* Pagination Container */
.pagination {
    margin-top: 20px;
}

.page-item {
    margin: 0 5px;
}

.page-link {
    color: #007bff;
    border-radius: 50px;
    border: 2px solid #007bff;
    padding: 10px 15px;
    font-size: 16px;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

.page-link:hover {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.page-item.disabled .page-link {
    color: #ccc;
    border-color: #ccc;
}

.page-link i {
    font-size: 18px;
}
/* Spinner Container */
.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
    border-width: 0.3em;
    border-color: #007bff transparent transparent transparent;
    animation: spin 1s linear infinite;
}

/* Animation for Data Loading */
.tutorial-card-wrapper {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.tutorial-card-wrapper.show {
    opacity: 1;
    transform: translateY(0);
}

/* Spinner Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Utility Classes */
.d-none {
    display: none !important;
}
/* Spinner Container */
.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
    border-width: 0.3em;
    border-color: #007bff transparent transparent transparent;
    animation: spin 1s linear infinite;
}

/* Animation for Data Loading */
.tutorial-card-wrapper {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.tutorial-card-wrapper.show {
    opacity: 1;
    transform: translateY(0);
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    padding-left: 0;
    list-style: none;
}

.page-item {
    margin: 0 2px;
}

.page-link {
    border-radius: 50%;
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    transition: background-color 0.3s;
}

.page-link:hover {
    background-color: #0056b3;
}

.page-item.disabled .page-link {
    background-color: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
}

.page-item.active .page-link {
    background-color: #0056b3;
    color: #fff;
}

/* Spinner Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Utility Classes */
.d-none {
    display: none !important;
}

.pagination {
    display: flex;
    justify-content: center;
    padding-left: 0;
    list-style: none;
}

.page-item {
    margin: 0 2px;
}

.page-link {
    border-radius: 50%;
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    transition: background-color 0.3s;
}

.page-link:hover {
    background-color: #0056b3;
}

.page-item.disabled .page-link {
    background-color: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
}

.page-item.active .page-link {
    background-color: #0056b3;
    color: #fff;
}

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark animate__animated animate__fadeIn">
        <div class="container">
            <a class="navbar-brand" href="#">Coding Tutorials</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#"><i class="fas fa-home"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#tutorials"><i
                                class="fas fa-book"></i> Tutorials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#about"><i class="fas fa-user"></i>
                            About Me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#contact"><i
                                class="fas fa-envelope"></i> Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Opening Message Section -->
    <section class="opening-message animate__animated animate__fadeIn">
        <div class="container">
            <h1>Welcome to Coding Tutorials!</h1>
            <p>Explore our curated collection of coding tutorials designed to help you master new skills and advance
                your career.</p>
            <a href="#tutorials" class="btn btn-light">Get Started</a>
        </div>
    </section>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="search-input" placeholder="Search tutorials..." onkeyup="filterTutorials()">
    </div>

    <!-- Category Filter Section -->
    <div class="category-filter">
        <button class="btn btn-primary"><i class="fas fa-list-alt"></i> All</button>
        <button class="btn btn-outline-primary"><i class="fab fa-html5"></i> HTML</button>
        <button class="btn btn-outline-primary"><i class="fab fa-css3-alt"></i> CSS</button>
        <button class="btn btn-outline-primary"><i class="fab fa-js"></i> JavaScript</button>
        <button class="btn btn-outline-primary"><i class="fab fa-python"></i> Python</button>
        <button class="btn btn-outline-primary"><i class="fab fa-php"></i> PHP</button>
        <button class="btn btn-outline-primary"><i class="fab fa-laravel"></i> Laravel</button>
        <button class="btn btn-outline-primary"><i class="fab fa-react"></i> React</button>
        <button class="btn btn-outline-primary"><i class="fab fa-vuejs"></i> Vue.js</button>
    </div>


    <!-- Tutorials Section -->
    <div id="tutorials" class="container my-5">
        <!-- Spinner -->
        <div id="spinner" class="spinner-container d-none">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Data Container -->
        <div id="tutorials-content" class="row">
            <!-- Tutorial Card 1 -->
            <div class="col-md-4 mb-4 tutorial-card-wrapper">
                <div class="card tutorial-card">
                    <img src="https://source.unsplash.com/600x400/?coding" class="card-img-top" alt="HTML Tutorial">
                    <div class="card-body">
                        <h5 class="card-title">Learn HTML</h5>
                        <p class="card-text">Start from the basics of HTML and build your way up to advanced topics.</p>
                    </div>
                </div>
            </div>
            <!-- Tutorial Card 2 -->
            <div class="col-md-4 mb-4 tutorial-card-wrapper">
                <div class="card tutorial-card">
                    <img src="https://source.unsplash.com/600x400/?code" class="card-img-top" alt="CSS Tutorial">
                    <div class="card-body">
                        <h5 class="card-title">Master CSS</h5>
                        <p class="card-text">Style your web pages like a pro with our comprehensive CSS tutorials.</p>
                    </div>
                </div>
            </div>
            <!-- Tutorial Card 3 -->
            <div class="col-md-4 mb-4 tutorial-card-wrapper">
                <div class="card tutorial-card">
                    <img src="https://source.unsplash.com/600x400/?coding" class="card-img-top" alt="JavaScript Tutorial">
                    <div class="card-body">
                        <h5 class="card-title">JavaScript Essentials</h5>
                        <p class="card-text">Learn JavaScript from scratch and create dynamic, interactive web pages.</p>
                    </div>
                </div>
            </div>
            <!-- Tutorial Card 4 -->
            <div class="col-md-4 mb-4 tutorial-card-wrapper">
                <div class="card tutorial-card">
                    <img src="https://source.unsplash.com/600x400/?python" class="card-img-top" alt="Python Tutorial">
                    <div class="card-body">
                        <h5 class="card-title">Python Basics</h5>
                        <p class="card-text">Discover the fundamentals of Python programming with hands-on examples.</p>
                    </div>
                </div>
            </div>
            <!-- Tutorial Card 5 -->
            <div class="col-md-4 mb-4 tutorial-card-wrapper">
                <div class="card tutorial-card">
                    <img src="https://source.unsplash.com/600x400/?php" class="card-img-top" alt="PHP Tutorial">
                    <div class="card-body">
                        <h5 class="card-title">PHP for Beginners</h5>
                        <p class="card-text">Learn PHP from the ground up and start building dynamic web applications.</p>
                    </div>
                </div>
            </div>
            <!-- Tutorial Card 6 -->
            <div class="col-md-4 mb-4 tutorial-card-wrapper">
                <div class="card tutorial-card">
                    <img src="https://source.unsplash.com/600x400/?programming" class="card-img-top" alt="Advanced Programming">
                    <div class="card-body">
                        <h5 class="card-title">Advanced Programming</h5>
                        <p class="card-text">Take your coding skills to the next level with advanced programming concepts and techniques.</p>
                    </div>
                </div>
            </div>
            <!-- Add more cards as needed -->
        </div>

        <!-- Pagination -->
        <nav aria-label="Tutorial pagination" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">4</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>



    <!-- About Me Section -->
    <section id="about" class="about-me">
        <div class="container">
            <div class="grid">
                <div class="about-text">
                    <h2>About Me</h2>
                    <p>Hello! I'm a passionate coder and web developer with years of experience in the industry. My mission is
                        to help others learn to code and build a successful career in tech. Through these tutorials, I aim to
                        share my knowledge and insights in a way that's easy to understand and apply.</p>
                </div>
                <div class="about-image">
                    <img src="{{ asset('image/illustration.png') }}" alt="About Me Image">
                </div>
            </div>
        </div>
    </section>



    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Coding Tutorials. All rights reserved.</p>
    </footer>

    <script>
        // Search Functionality
        function filterTutorials() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const tutorials = document.querySelectorAll('.tutorial-card');

            tutorials.forEach(tutorial => {
                const title = tutorial.querySelector('.card-title').textContent.toLowerCase();
                const text = tutorial.querySelector('.card-text').textContent.toLowerCase();

                if (title.includes(searchInput) || text.includes(searchInput)) {
                    tutorial.style.display = 'block';
                } else {
                    tutorial.style.display = 'none';
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function () {
    const aboutSection = document.querySelector('.about-me');

    function revealOnScroll() {
        const windowHeight = window.innerHeight;
        const sectionTop = aboutSection.getBoundingClientRect().top;
        const revealPoint = 150;

        if (sectionTop < windowHeight - revealPoint) {
            aboutSection.classList.add('scroll-reveal');
        }
    }

    window.addEventListener('scroll', revealOnScroll);

    const spinner = document.getElementById('spinner');
    const content = document.getElementById('tutorials-content');

    // Function to simulate data loading
    function loadData() {
        // Show spinner
        spinner.classList.remove('d-none');
        content.classList.add('d-none');

        // Simulate a delay for data loading
        setTimeout(() => {
            // Hide spinner
            spinner.classList.add('d-none');
            content.classList.remove('d-none');

            // Animate data display
            document.querySelectorAll('.tutorial-card-wrapper').forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('show');
                }, index * 100); // Staggered animation
            });
        }, 2000); // Adjust the delay as needed
    }


    // Initial data loading
    loadData();
});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFyZWToLz5rnJM5I4bsM7qK/4FUjD5e78GkQ5Qx04p5O4NCKtrSYlTTO0" crossorigin="anonymous"></script>
</body>

</html>
