<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio Premium | Nama Anda</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Portofolio profesional Nama Anda sebagai Web Developer & UI/UX Designer">
    <meta name="keywords" content="portofolio, web developer, designer, bootstrap, html, css">
    <meta name="author" content="Nama Anda">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Glightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    
    <!-- Swiper JS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3f78e0;
            --secondary-color: #2c3e50;
            --accent-color: #ff6b6b;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --text-color: #495057;
            --text-light: #6c757d;
            --font-primary: 'Poppins', sans-serif;
            --font-secondary: 'Playfair Display', serif;
            --transition: all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        body {
            font-family: var(--font-primary);
            color: var(--text-color);
            overflow-x: hidden;
            scroll-behavior: smooth;
            line-height: 1.7;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-secondary);
            font-weight: 700;
            color: var(--dark-color);
        }
        
        a {
            text-decoration: none;
            transition: var(--transition);
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2d63d1;
            border-color: #2d63d1;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Navbar */
        .navbar {
            padding: 15px 0;
            transition: var(--transition);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        .navbar.scrolled {
            padding: 10px 0;
            background-color: white !important;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 500;
            padding: 8px 15px !important;
            color: var(--dark-color);
        }
        
        .nav-link.active, .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        /* Hero Section */
        #hero {
            background: linear-gradient(135deg, var(--primary-color), #5d9cec);
            color: white;
            padding: 180px 0 100px;
            position: relative;
            overflow: hidden;
        }
        
        #hero::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23ffffff"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23ffffff"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23ffffff"></path></svg>');
            background-size: cover;
            background-repeat: no-repeat;
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 30px;
        }
        
        .hero-img {
            border-radius: 20px;
            box-shadow: var(--shadow-hover);
            transform: perspective(1000px) rotateY(-10deg);
            transition: var(--transition);
            border: 5px solid rgba(255, 255, 255, 0.2);
        }
        
        .hero-img:hover {
            transform: perspective(1000px) rotateY(0deg);
        }
        
        .social-links-hero {
            margin-top: 30px;
        }
        
        .social-links-hero a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            transition: var(--transition);
        }
        
        .social-links-hero a:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-5px);
        }
        
        /* About Section */
        #about {
            padding: 100px 0;
            background-color: white;
        }
        
        .section-title {
            margin-bottom: 60px;
            position: relative;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: capitalize;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        .about-img {
            border-radius: 15px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .about-img:hover {
            transform: scale(1.03);
            box-shadow: var(--shadow-hover);
        }
        
        .about-content h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .about-content .fst-italic {
            color: var(--text-light);
            border-left: 3px solid var(--primary-color);
            padding-left: 15px;
            margin-bottom: 20px;
        }
        
        .about-info {
            margin-bottom: 30px;
        }
        
        .about-info ul {
            list-style: none;
            padding: 0;
        }
        
        .about-info li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .about-info i {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        /* Skills Section */
        #skills {
            padding: 100px 0;
            background-color: var(--light-color);
        }
        
        .skill-item {
            margin-bottom: 30px;
        }
        
        .skill-name {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .skill-name span {
            font-weight: 600;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
            background-color: #e9ecef;
        }
        
        .progress-bar {
            border-radius: 5px;
            background-color: var(--primary-color);
        }
        
        /* Portfolio Section */
        #portfolio {
            padding: 100px 0;
            background-color: white;
        }
        
        .portfolio-filter {
            margin-bottom: 40px;
        }
        
        .portfolio-filter button {
            background: none;
            border: none;
            font-weight: 500;
            color: var(--text-color);
            margin: 0 10px;
            padding: 8px 20px;
            border-radius: 30px;
            transition: var(--transition);
        }
        
        .portfolio-filter button.active, 
        .portfolio-filter button:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .portfolio-item {
            margin-bottom: 30px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }
        
        .portfolio-item:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }
        
        .portfolio-img {
            height: 250px;
            width: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .portfolio-item:hover .portfolio-img {
            transform: scale(1.1);
        }
        
        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(63, 120, 224, 0.9);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        
        .portfolio-item:hover .portfolio-overlay {
            opacity: 1;
        }
        
        .portfolio-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: white;
            color: var(--primary-color);
            border-radius: 50%;
            margin: 0 5px;
            transition: var(--transition);
        }
        
        .portfolio-links a:hover {
            background: var(--dark-color);
            color: white;
        }
        
        .portfolio-info {
            padding: 20px;
            background: white;
        }
        
        .portfolio-info h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        
        .portfolio-info p {
            color: var(--text-light);
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        /* Experience Section */
        #experience {
            padding: 100px 0;
            background-color: var(--light-color);
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
            background-color: var(--primary-color);
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
            border: 4px solid var(--primary-color);
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
            border: medium solid var(--light-color);
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent white;
        }
        
        .right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            left: 30px;
            border: medium solid var(--light-color);
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }
        
        .right::after {
            left: -12px;
        }
        
        .timeline-content {
            padding: 20px 30px;
            background-color: white;
            position: relative;
            border-radius: 10px;
            box-shadow: var(--shadow);
        }
        
        .timeline-content h4 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }
        
        .timeline-content h5 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .timeline-date {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: block;
        }
        
        /* Testimonials Section */
        #testimonials {
            padding: 100px 0;
            background-color: white;
        }
        
        .testimonial-slider {
            padding: 40px 0;
        }
        
        .testimonial-item {
            background: var(--light-color);
            padding: 30px;
            border-radius: 15px;
            margin: 0 15px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .testimonial-item:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }
        
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        
        .testimonial-name {
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .testimonial-position {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: block;
        }
        
        .testimonial-text {
            position: relative;
            padding-top: 15px;
        }
        
        .testimonial-text::before {
            content: '\201C';
            font-size: 4rem;
            color: var(--primary-color);
            opacity: 0.3;
            position: absolute;
            top: -20px;
            left: -10px;
            font-family: Georgia, serif;
        }
        
        .testimonial-rating {
            color: #ffc107;
            margin-top: 15px;
        }
        
        /* Contact Section */
        #contact {
            padding: 100px 0;
            background: linear-gradient(rgba(63, 120, 224, 0.9), rgba(63, 120, 224, 0.9)), url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }
        
        .contact-info {
            margin-bottom: 30px;
        }
        
        .contact-info-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .contact-info-box:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .contact-icon {
            font-size: 2rem;
            color: white;
            margin-bottom: 20px;
        }
        
        .contact-info-box h4 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        
        .contact-info-box p {
            margin-bottom: 0;
        }
        
        .contact-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: var(--shadow-hover);
        }
        
        .contact-form .form-control {
            height: 50px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            padding: 10px 15px;
            margin-bottom: 20px;
        }
        
        .contact-form textarea.form-control {
            height: auto;
            min-height: 150px;
        }
        
        .contact-form .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }
        
        /* Footer */
        footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 60px 0 20px;
        }
        
        .footer-logo {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .footer-about p {
            margin-bottom: 20px;
            opacity: 0.8;
        }
        
        .footer-links h4 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-links h4::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background: var(--primary-color);
            bottom: 0;
            left: 0;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            transition: var(--transition);
        }
        
        .footer-social a:hover {
            background: var(--primary-color);
            transform: translateY(-5px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 40px;
        }
        
        .copyright {
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Animations */
        .animate-up {
            transform: translateY(50px);
            opacity: 0;
            transition: var(--transition);
        }
        
        .animate-up.show {
            transform: translateY(0);
            opacity: 1;
        }
        
        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.3rem;
            }
            
            .timeline::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-item::after {
                left: 18px;
            }
            
            .left::before, .right::before {
                left: 60px;
                border: medium solid white;
                border-width: 10px 10px 10px 0;
                border-color: transparent white transparent transparent;
            }
            
            .left::after, .right::after {
                left: 18px;
            }
            
            .right {
                left: 0%;
            }
        }
        
        @media (max-width: 767.98px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .contact-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navbar -->
    <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Portofolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#skills">Keahlian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#experience">Pengalaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content animate-up">
                    <h1 class="hero-title">Hai, Saya <span class="text-white">Nama Anda</span></h1>
                    <h2 class="hero-subtitle">Web Developer & UI/UX Designer</h2>
                    <p class="mb-4">Saya membuat aplikasi web yang indah, fungsional, dan responsif dengan teknologi terbaru. Dengan pengalaman lebih dari 5 tahun di industri ini, saya siap membantu mewujudkan ide Anda menjadi kenyataan.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#portfolio" class="btn btn-light btn-lg px-4">Lihat Karya</a>
                        <a href="#contact" class="btn btn-outline-light btn-lg px-4">Hubungi Saya</a>
                    </div>
                    
                    <div class="social-links-hero mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 animate-up" style="animation-delay: 0.2s;">
                    <img src="https://via.placeholder.com/600x600" alt="Profile" class="img-fluid hero-img">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="section-title text-center">
                <h2>Tentang Saya</h2>
                <p>Kenali saya lebih dalam</p>
            </div>
            
            <div class="row">
                <div class="col-lg-5 animate-up">
                    <img src="https://via.placeholder.com/500x600" alt="About" class="img-fluid about-img">
                </div>
                <div class="col-lg-7 pt-4 pt-lg-0 animate-up" style="animation-delay: 0.2s;">
                    <h3>Web Developer & UI/UX Designer Profesional</h3>
                    <p class="fst-italic">
                        Saya seorang profesional di bidang pengembangan web dan desain antarmuka dengan fokus pada pengalaman pengguna yang optimal.
                    </p>
                    
                    <div class="row about-info">
                        <div class="col-md-6">
                            <ul>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Tanggal Lahir:</strong> 1 Januari 1990
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Website:</strong> www.contoh.com
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Telepon:</strong> +62 123 4567 890
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Kota:</strong> Jakarta, Indonesia
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Umur:</strong> 33
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Pendidikan:</strong> Sarjana
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Email:</strong> email@contoh.com
                                </li>
                                <li>
                                    <i class="fas fa-chevron-right"></i>
                                    <strong>Freelance:</strong> Tersedia
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <p>
                        Dengan latar belakang pendidikan di bidang Teknik Informatika dan pengalaman kerja di berbagai perusahaan teknologi, saya memiliki pemahaman mendalam tentang seluruh siklus pengembangan perangkat lunak. Saya ahli dalam HTML, CSS, JavaScript, dan berbagai framework modern seperti React dan Vue.js.
                    </p>
                    <p>
                        Selain keterampilan teknis, saya juga memiliki kemampuan desain yang kuat, memastikan bahwa setiap produk yang saya buat tidak hanya berfungsi dengan baik tetapi juga memberikan pengalaman pengguna yang luar biasa.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="section-padding bg-light">
        <div class="container">
            <div class="section-title text-center">
                <h2>Keahlian</h2>
                <p>Kemampuan teknis dan profesional saya</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 animate-up">
                    <h3 class="mb-4">Kemampuan Teknis</h3>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>HTML/CSS</span>
                            <span>95%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 95%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>JavaScript</span>
                            <span>90%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Bootstrap</span>
                            <span>95%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 95%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>React</span>
                            <span>85%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Node.js</span>
                            <span>80%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 animate-up" style="animation-delay: 0.2s;">
                    <h3 class="mb-4">Kemampuan Profesional</h3>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Komunikasi</span>
                            <span>95%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 95%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Kerja Tim</span>
                            <span>90%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Manajemen Proyek</span>
                            <span>85%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Kreativitas</span>
                            <span>90%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Pemecahan Masalah</span>
                            <span>88%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 88%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="section-padding">
        <div class="container">
            <div class="section-title text-center">
                <h2>Portofolio</h2>
                <p>Karya terbaik saya</p>
            </div>
            
            <div class="row justify-content-center animate-up">
                <div class="col-lg-8">
                    <div class="portfolio-filter text-center">
                        <button type="button" class="active" data-filter="*">Semua</button>
                        <button type="button" data-filter=".web">Web</button>
                        <button type="button" data-filter=".app">App</button>
                        <button type="button" data-filter=".design">Design</button>
                    </div>
                </div>
            </div>
            
            <div class="row portfolio-container animate-up" style="animation-delay: 0.2s;">
                <!-- Project 1 -->
                <div class="col-lg-4 col-md-6 portfolio-item web">
                    <div class="portfolio-wrap">
                        <img src="https://via.placeholder.com/600x400" class="img-fluid portfolio-img" alt="Project 1">
                        <div class="portfolio-overlay">
                            <div class="portfolio-links">
                                <a href="https://via.placeholder.com/600x400" class="glightbox" title="Project 1">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="project-details.html" title="More Details">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h4>Project 1</h4>
                            <p>Web Development</p>
                        </div>
                    </div>
                </div>
                
                <!-- Project 2 -->
                <div class="col-lg-4 col-md-6 portfolio-item app">
                    <div class="portfolio-wrap">
                        <img src="https://via.placeholder.com/600x400" class="img-fluid portfolio-img" alt="Project 2">
                        <div class="portfolio-overlay">
                            <div class="portfolio-links">
                                <a href="https://via.placeholder.com/600x400" class="glightbox" title="Project 2">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="project-details.html" title="More Details">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h4>Project 2</h4>
                            <p>Mobile App</p>
                        </div>
                    </div>
                </div>
                
                <!-- Project 3 -->
                <div class="col-lg-4 col-md-6 portfolio-item design">
                    <div class="portfolio-wrap">
                        <img src="https://via.placeholder.com/600x400" class="img-fluid portfolio-img" alt="Project 3">
                        <div class="portfolio-overlay">
                            <div class="portfolio-links">
                                <a href="https://via.placeholder.com/600x400" class="glightbox" title="Project 3">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="project-details.html" title="More Details">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h4>Project 3</h4>
                            <p>UI/UX Design</p>
                        </div>
                    </div>
                </div>
                
                <!-- Project 4 -->
                <div class="col-lg-4 col-md-6 portfolio-item web">
                    <div class="portfolio-wrap">
                        <img src="https://via.placeholder.com/600x400" class="img-fluid portfolio-img" alt="Project 4">
                        <div class="portfolio-overlay">
                            <div class="portfolio-links">
                                <a href="https://via.placeholder.com/600x400" class="glightbox" title="Project 4">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="project-details.html" title="More Details">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h4>Project 4</h4>
                            <p>Web Development</p>
                        </div>
                    </div>
                </div>
                
                <!-- Project 5 -->
                <div class="col-lg-4 col-md-6 portfolio-item app">
                    <div class="portfolio-wrap">
                        <img src="https://via.placeholder.com/600x400" class="img-fluid portfolio-img" alt="Project 5">
                        <div class="portfolio-overlay">
                            <div class="portfolio-links">
                                <a href="https://via.placeholder.com/600x400" class="glightbox" title="Project 5">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="project-details.html" title="More Details">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h4>Project 5</h4>
                            <p>Mobile App</p>
                        </div>
                    </div>
                </div>
                
                <!-- Project 6 -->
                <div class="col-lg-4 col-md-6 portfolio-item design">
                    <div class="portfolio-wrap">
                        <img src="https://via.placeholder.com/600x400" class="img-fluid portfolio-img" alt="Project 6">
                        <div class="portfolio-overlay">
                            <div class="portfolio-links">
                                <a href="https://via.placeholder.com/600x400" class="glightbox" title="Project 6">
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="project-details.html" title="More Details">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portfolio-info">
                            <h4>Project 6</h4>
                            <p>UI/UX Design</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="section-padding bg-light">
        <div class="container">
            <div class="section-title text-center">
                <h2>Pengalaman & Pendidikan</h2>
                <p>Perjalanan karir dan pendidikan saya</p>
            </div>
            
            <div class="timeline">
                <!-- Experience 1 -->
                <div class="timeline-item left animate-up">
                    <div class="timeline-content">
                        <h4>Senior Web Developer</h4>
                        <h5>Perusahaan ABC</h5>
                        <span class="timeline-date">Jan 2020 - Sekarang</span>
                        <p>
                            Memimpin tim pengembangan untuk membangun aplikasi web modern menggunakan React dan Node.js. Bertanggung jawab atas arsitektur sistem dan implementasi fitur-fitur utama.
                        </p>
                    </div>
                </div>
                
                <!-- Experience 2 -->
                <div class="timeline-item right animate-up" style="animation-delay: 0.2s;">
                    <div class="timeline-content">
                        <h4>Web Developer</h4>
                        <h5>Startup XYZ</h5>
                        <span class="timeline-date">Mar 2018 - Des 2019</span>
                        <p>
                            Mengembangkan aplikasi web responsif menggunakan Vue.js dan Laravel. Berkolaborasi dengan tim desain untuk menciptakan antarmuka pengguna yang intuitif dan menarik.
                        </p>
                    </div>
                </div>
                
                <!-- Experience 3 -->
                <div class="timeline-item left animate-up" style="animation-delay: 0.4s;">
                    <div class="timeline-content">
                        <h4>Junior Web Developer</h4>
                        <h5>Digital Agency</h5>
                        <span class="timeline-date">Jun 2016 - Feb 2018</span>
                        <p>
                            Membangun dan memelihara website klien menggunakan HTML, CSS, JavaScript, dan WordPress. Belajar praktik terbaik dalam pengembangan web dan bekerja dalam tim agile.
                        </p>
                    </div>
                </div>
                
                <!-- Education 1 -->
                <div class="timeline-item right animate-up" style="animation-delay: 0.6s;">
                    <div class="timeline-content">
                        <h4>Sarjana Teknik Informatika</h4>
                        <h5>Universitas Indonesia</h5>
                        <span class="timeline-date">2012 - 2016</span>
                        <p>
                            Lulus dengan predikat cumlaude. Fokus pada pengembangan web dan interaksi manusia-komputer. Aktif dalam organisasi mahasiswa dan kompetisi pengembangan perangkat lunak.
                        </p>
                    </div>
                </div>
                
                <!-- Education 2 -->
                <div class="timeline-item left animate-up" style="animation-delay: 0.8s;">
                    <div class="timeline-content">
                        <h4>SMA Negeri 1 Jakarta</h4>
                        <h5>Jurusan IPA</h5>
                        <span class="timeline-date">2009 - 2012</span>
                        <p>
                            Lulus dengan nilai tertinggi di bidang matematika dan fisika. Mengikuti berbagai olimpiade sains dan menjadi ketua klub pemrograman sekolah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="section-padding">
        <div class="container">
            <div class="section-title text-center">
                <h2>Testimoni</h2>
                <p>Apa yang dikatakan klien dan kolega tentang saya</p>
            </div>
            
            <div class="testimonial-slider animate-up">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <!-- Testimonial 1 -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="https://via.placeholder.com/150" alt="Client 1" class="testimonial-img">
                                <h5 class="testimonial-name">John Doe</h5>
                                <span class="testimonial-position">CEO Perusahaan ABC</span>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="testimonial-text">
                                    Nama Anda adalah salah satu developer terbaik yang pernah saya pekerjakan. Dia tidak hanya memberikan kode yang bersih dan efisien, tetapi juga memahami kebutuhan bisnis kami. Projek selesai tepat waktu dan melebihi harapan kami.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Testimonial 2 -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="https://via.placeholder.com/150" alt="Client 2" class="testimonial-img">
                                <h5 class="testimonial-name">Jane Smith</h5>
                                <span class="testimonial-position">Direktur Startup XYZ</span>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="testimonial-text">
                                    Bekerja dengan Nama Anda adalah pengalaman yang menyenangkan. Dia sangat profesional, komunikatif, dan memiliki solusi untuk setiap tantangan teknis yang kami hadapi. Aplikasi yang dia kembangkan membantu bisnis kami berkembang pesat.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Testimonial 3 -->
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="https://via.placeholder.com/150" alt="Client 3" class="testimonial-img">
                                <h5 class="testimonial-name">Robert Johnson</h5>
                                <span class="testimonial-position">Manajer Proyek</span>
                                <div class="testimonial-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <p class="testimonial-text">
                                    Nama Anda adalah anggota tim yang berharga. Dia tidak hanya ahli dalam coding tetapi juga memiliki pemahaman yang baik tentang UX/UI. Dia selalu mencari cara untuk meningkatkan produk kami dan memberikan nilai tambah.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-padding">
        <div class="container">
            <div class="section-title text-center">
                <h2>Kontak</h2>
                <p>Hubungi saya untuk proyek atau pertanyaan</p>
            </div>
            
            <div class="row">
                <div class="col-lg-5 animate-up">
                    <div class="contact-info-box">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Lokasi:</h4>
                        <p>Jl. Contoh No. 123, Jakarta, Indonesia</p>
                    </div>
                    
                    <div class="contact-info-box">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email:</h4>
                        <p>info@contoh.com</p>
                    </div>
                    
                    <div class="contact-info-box">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Telepon:</h4>
                        <p>+62 123 4567 890</p>
                    </div>
                    
                    <div class="contact-info-box">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Jam Kerja:</h4>
                        <p>Senin-Jumat: 09:00 - 17:00</p>
                    </div>
                </div>
                
                <div class="col-lg-7 animate-up" style="animation-delay: 0.2s;">
                    <form class="contact-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Nama Anda" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 animate-up">
                    <a href="#" class="footer-logo">Portofolio</a>
                    <div class="footer-about">
                        <p>
                            Saya adalah seorang Web Developer dan UI/UX Designer profesional dengan passion untuk menciptakan solusi digital yang indah dan fungsional.
                        </p>
                    </div>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 animate-up" style="animation-delay: 0.2s;">
                    <div class="footer-links">
                        <h4>Link Cepat</h4>
                        <ul>
                            <li><a href="#hero">Home</a></li>
                            <li><a href="#about">Tentang</a></li>
                            <li><a href="#skills">Keahlian</a></li>
                            <li><a href="#portfolio">Portofolio</a></li>
                            <li><a href="#contact">Kontak</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 animate-up" style="animation-delay: 0.4s;">
                    <div class="footer-links">
                        <h4>Layanan Saya</h4>
                        <ul>
                            <li><a href="#">Web Development</a></li>
                            <li><a href="#">UI/UX Design</a></li>
                            <li><a href="#">Mobile App Development</a></li>
                            <li><a href="#">SEO Optimization</a></li>
                            <li><a href="#">Digital Marketing</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 animate-up" style="animation-delay: 0.6s;">
                    <div class="footer-links">
                        <h4>Hubungi Saya</h4>
                        <ul>
                            <li><i class="fas fa-map-marker-alt me-2"></i> Jakarta, Indonesia</li>
                            <li><i class="fas fa-envelope me-2"></i> info@contoh.com</li>
                            <li><i class="fas fa-phone-alt me-2"></i> +62 123 4567 890</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p class="copyright">© <script>document.write(new Date().getFullYear())</script> Portofolio. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="copyright">Designed with <i class="fas fa-heart text-danger"></i> by Nama Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Isotope JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
    
    <!-- Glightbox JS -->
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.style.transition = 'opacity 0.5s';
            preloader.style.opacity = '0';
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 500);
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Back to top button
        const backToTop = document.querySelector('.back-to-top');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('active');
            } else {
                backToTop.classList.remove('active');
            }
        });
        
        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 70,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu when clicking a link
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                        bsCollapse.hide();
                    }
                }
            });
        });
        
        // Active nav link on scroll
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');
        
        window.addEventListener('scroll', function() {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (pageYOffset >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
        
        // Scroll animation
        const animateElements = document.querySelectorAll('.animate-up');
        
        function checkScroll() {
            animateElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementTop < windowHeight - 100) {
                    element.classList.add('show');
                }
            });
        }
        
        window.addEventListener('scroll', checkScroll);
        window.addEventListener('load', checkScroll);
        
        // Initialize Isotope for portfolio filtering
        document.addEventListener('DOMContentLoaded', function() {
            const portfolioFilter = document.querySelector('.portfolio-filter');
            const portfolioContainer = document.querySelector('.portfolio-container');
            
            if (portfolioContainer) {
                const iso = new Isotope(portfolioContainer, {
                    itemSelector: '.portfolio-item',
                    layoutMode: 'fitRows'
                });
                
                portfolioFilter.addEventListener('click', function(e) {
                    if (!e.target.matches('button')) return;
                    
                    const filterValue = e.target.getAttribute('data-filter');
                    iso.arrange({ filter: filterValue });
                    
                    // Update active class on buttons
                    portfolioFilter.querySelectorAll('button').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    e.target.classList.add('active');
                });
            }
        });
        
        // Initialize GLightbox
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = GLightbox({
                selector: '.glightbox'
            });
        });
        
        // Initialize Swiper
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    }
                }
            });
        });
    </script>
</body>
</html>