<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education IT Landing Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background-color: #343a40;
            padding: 1rem 0;
        }
        .navbar-brand {
            color: #f8f9fa;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .navbar-nav .nav-link {
            color: #f8f9fa;
            font-size: 1.1rem;
            margin-left: 1rem;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        /* Header Section */
        header {
            background: url('https://via.placeholder.com/1920x600') no-repeat center center/cover;
            color: white;
            padding: 5rem 0;
            text-align: center;
            position: relative;
            border-radius: 0 0 20px 20px;
        }
        header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        header p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        header .btn {
            font-size: 1.25rem;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
        }

        /* Features Section */
        #features .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            padding: 1rem;
            background-color: #f8f9fa;
            margin-bottom: 2rem;
        }
        #features .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        #features .card-body {
            text-align: center;
        }
        #features .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        /* Courses Section */
        #courses .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 2rem;
            background-color: #ffffff;
        }
        #courses .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        #courses .card-img-top {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        #courses .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1rem;
        }
        #courses .card-text {
            margin-top: 1rem;
        }
        #courses .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            margin-top: 1rem;
        }
        #courses .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Contact Section */
        #contact {
            background-color: #f8f9fa;
            padding: 4rem 0;
        }
        #contact h2 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
        }
        #contact .form-control {
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        #contact .btn-primary {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            margin-top: 1rem;
        }

        /* Footer Section */
        footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }
        footer p {
            margin: 0;
            font-size: 0.9rem;
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
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Expert Instructors</h5>
                            <p class="card-text">Learn from industry professionals with years of experience.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-2s">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Hands-On Projects</h5>
                            <p class="card-text">Work on real-world projects to apply your knowledge.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 animate__animated animate__fadeIn animate__delay-3s">
                    <div class="card">
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
        <div class="container">
            <h2 class="animate__animated animate__fadeIn text-center">Our Popular Courses</h2>
            <div class="row text-center">
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
                            <p class="card-text">Protect networks and systems from cyber threats.</p>
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center animate__animated animate__fadeIn">Get in Touch</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="5" placeholder="Your Message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <p>&copy; 2024 IT Education. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
