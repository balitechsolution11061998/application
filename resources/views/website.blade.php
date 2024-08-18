<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education IT Landing Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Navbar */
        .navbar {
            background: #343a40;
        }
        .navbar-brand {
            color: #f8f9fa;
        }
        .navbar-nav .nav-link {
            color: #f8f9fa;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        /* Header Section */
        header {
            background: url('https://via.placeholder.com/1920x600') no-repeat center center/cover;
            color: white;
            border-radius: 0 0 20px 20px;
            padding: 5rem 0;
            text-align: center;
            position: relative;
        }
        header h1 {
            font-size: 4rem;
            font-weight: bold;
        }
        header p {
            font-size: 1.75rem;
            margin: 1rem 0;
        }
        header .btn {
            font-size: 1.25rem;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
        }

        /* Features Section */
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            padding: 2rem;
            text-align: center;
        }

        /* Courses Section */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .card-body {
            padding: 1.5rem;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Contact Section */
        form .form-control {
            border-radius: 15px;
            padding: 1rem;
        }
        .form-control::placeholder {
            color: #6c757d;
        }
        .btn-primary {
            border-radius: 25px;
        }

        /* Footer Section */
        footer {
            background-color: #343a40;
            color: white;
            padding: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            header h1 {
                font-size: 2.5rem;
            }
            header p {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">IT Education</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#courses">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header>
        <div class="container">
            <h1 class="animate__animated animate__fadeIn">Advance Your IT Skills</h1>
            <p class="lead animate__animated animate__fadeIn animate__delay-1s">Learn from experts and get ahead in the tech industry</p>
            <a href="#courses" class="btn btn-light btn-lg animate__animated animate__fadeIn animate__delay-2s">Explore Courses</a>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-1s">
                    <div class="card border-light shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Expert Instructors</h5>
                            <p class="card-text">Learn from industry professionals with years of experience.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-2s">
                    <div class="card border-light shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Hands-On Projects</h5>
                            <p class="card-text">Work on real-world projects to apply your knowledge.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-3s">
                    <div class="card border-light shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Certification</h5>
                            <p class="card-text">Earn certifications to showcase your skills to potential employers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="bg-light py-5">
        <div class="container text-center">
            <h2 class="animate__animated animate__fadeIn">Our Popular Courses</h2>
            <div class="row">
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-1s">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Course 1">
                        <div class="card-body">
                            <h5 class="card-title">Web Development</h5>
                            <p class="card-text">Build modern websites and web applications using the latest technologies.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-2s">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Course 2">
                        <div class="card-body">
                            <h5 class="card-title">Data Science</h5>
                            <p class="card-text">Analyze and interpret complex data to drive decision-making.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-3s">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Course 3">
                        <div class="card-body">
                            <h5 class="card-title">Cybersecurity</h5>
                            <p class="card-text">Protect systems and networks from cyber threats and attacks.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container text-center">
            <h2 class="animate__animated animate__fadeIn">Contact Us</h2>
            <p class="lead animate__animated animate__fadeIn animate__delay-1s">Have any questions? Feel free to reach out!</p>
            <form class="animate__animated animate__fadeIn animate__delay-2s">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Your Email" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" placeholder="Your Message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p>&copy; 2024 IT Education. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap and Animate.css JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
