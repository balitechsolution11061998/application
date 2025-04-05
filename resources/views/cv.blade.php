<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmer Portfolio | Your Name</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        dark: '#1F2937',
                        light: '#F9FAFB',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['Fira Code', 'monospace'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-reverse': 'float-reverse 6s ease-in-out infinite',
                        'spin-slow': 'spin 8s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        'float-reverse': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        .code-font {
            font-family: 'Fira Code', monospace;
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #3B82F6, #10B981);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .transition-all {
            transition: all 0.3s ease;
        }
        
        .blob {
            position: absolute;
            z-index: -1;
            filter: blur(40px);
            opacity: 0.7;
        }
        
        .service-card:hover .service-icon {
            transform: rotateY(180deg);
        }
        
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 7px;
            top: 24px;
            height: 100%;
            width: 2px;
            background: #E5E7EB;
        }
        
        .testimonial-card:hover .testimonial-quote {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-light text-dark">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 backdrop-blur-sm bg-opacity-80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold gradient-text">DevPort</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-600 hover:text-primary transition-all">Home</a>
                    <a href="#about" class="text-gray-600 hover:text-primary transition-all">About</a>
                    <a href="#skills" class="text-gray-600 hover:text-primary transition-all">Skills</a>
                    <a href="#services" class="text-gray-600 hover:text-primary transition-all">Services</a>
                    <a href="#projects" class="text-gray-600 hover:text-primary transition-all">Projects</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-primary transition-all">Testimonials</a>
                    <a href="/pariwisata" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-all">
                        Pariwisata
                    </a>
                </div>
                <div class="md:hidden flex items-center">
                    <button id="menu-btn" class="text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white pb-4 px-4">
            <a href="#home" class="block py-2 text-gray-600 hover:text-primary">Home</a>
            <a href="#about" class="block py-2 text-gray-600 hover:text-primary">About</a>
            <a href="#skills" class="block py-2 text-gray-600 hover:text-primary">Skills</a>
            <a href="#services" class="block py-2 text-gray-600 hover:text-primary">Services</a>
            <a href="#projects" class="block py-2 text-gray-600 hover:text-primary">Projects</a>
            <a href="#testimonials" class="block py-2 text-gray-600 hover:text-primary">Testimonials</a>
            <a href="/pariwisata" class="block py-2 text-primary font-medium">Pariwisata</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="py-20 bg-gradient-to-r from-blue-50 to-green-50 relative overflow-hidden">
        <!-- Animated blobs -->
        <div class="blob w-64 h-64 bg-blue-400 rounded-full top-10 left-10 animation-float"></div>
        <div class="blob w-80 h-80 bg-green-400 rounded-full bottom-10 right-10 animation-float-reverse"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        Hi, I'm <span class="gradient-text">John Doe</span>
                    </h1>
                    <h2 class="text-2xl md:text-3xl font-semibold mb-6 text-gray-600">
                        Full Stack Developer
                    </h2>
                    <p class="text-lg text-gray-600 mb-8">
                        I build exceptional digital experiences with clean, efficient code and innovative solutions.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#contact" class="bg-primary text-white px-6 py-3 rounded-md hover:bg-blue-600 transition-all transform hover:-translate-y-1">
                            Contact Me
                        </a>
                        <a href="#projects" class="border border-primary text-primary px-6 py-3 rounded-md hover:bg-blue-50 transition-all transform hover:-translate-y-1">
                            View Work
                        </a>
                    </div>
                    
                    <div class="mt-10 flex items-center space-x-6">
                        <div class="flex -space-x-2">
                            <img src="https://randomuser.me/api/portraits/women/12.jpg" class="w-10 h-10 rounded-full border-2 border-white" alt="Client">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-10 h-10 rounded-full border-2 border-white" alt="Client">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-10 h-10 rounded-full border-2 border-white" alt="Client">
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Trusted by 50+ clients worldwide</p>
                            <div class="flex">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="ml-2 text-gray-600">5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center" data-aos="fade-left">
                    <div class="relative">
                        <div class="w-64 h-64 md:w-80 md:h-80 bg-primary rounded-full overflow-hidden border-4 border-white shadow-xl">
                            <img src="https://images.unsplash.com/photo-1571171637578-41bc2dd41cd2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80" 
                                 alt="Programmer" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-5 -right-5 bg-white p-4 rounded-lg shadow-md">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                <span class="text-sm font-medium">Available for work</span>
                            </div>
                        </div>
                        <div class="absolute -top-5 -left-5 bg-white p-3 rounded-full shadow-md">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-primary">
                                <i class="fas fa-code text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clients Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center">
                <div class="flex justify-center opacity-70 hover:opacity-100 transition-all" data-aos="zoom-in">
                    <img src="https://logo.clearbit.com/google.com" alt="Google" class="h-8">
                </div>
                <div class="flex justify-center opacity-70 hover:opacity-100 transition-all" data-aos="zoom-in" data-aos-delay="50">
                    <img src="https://logo.clearbit.com/amazon.com" alt="Amazon" class="h-8">
                </div>
                <div class="flex justify-center opacity-70 hover:opacity-100 transition-all" data-aos="zoom-in" data-aos-delay="100">
                    <img src="https://logo.clearbit.com/microsoft.com" alt="Microsoft" class="h-8">
                </div>
                <div class="flex justify-center opacity-70 hover:opacity-100 transition-all" data-aos="zoom-in" data-aos-delay="150">
                    <img src="https://logo.clearbit.com/spotify.com" alt="Spotify" class="h-8">
                </div>
                <div class="flex justify-center opacity-70 hover:opacity-100 transition-all" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://logo.clearbit.com/airbnb.com" alt="Airbnb" class="h-8">
                </div>
                <div class="flex justify-center opacity-70 hover:opacity-100 transition-all" data-aos="zoom-in" data-aos-delay="250">
                    <img src="https://logo.clearbit.com/uber.com" alt="Uber" class="h-8">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">About <span class="gradient-text">Me</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
            </div>
            
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3 mb-10 md:mb-0 flex justify-center" data-aos="fade-right">
                    <div class="relative">
                        <div class="w-64 h-64 bg-gradient-to-r from-primary to-secondary rounded-lg shadow-lg flex items-center justify-center">
                            <i class="fas fa-code text-white text-8xl"></i>
                        </div>
                        <div class="absolute -bottom-5 -left-5 bg-dark text-white p-3 rounded-lg shadow-md">
                            <span class="code-font text-sm">console.log("Hello World!");</span>
                        </div>
                        <div class="absolute -top-5 -right-5 bg-white p-3 rounded-full shadow-md">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <i class="fas fa-check text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-2/3 md:pl-16" data-aos="fade-left">
                    <h3 class="text-2xl font-semibold mb-6">Who am I?</h3>
                    <p class="text-gray-600 mb-6">
                        I'm a passionate Full Stack Developer with 5+ years of experience building web applications. 
                        I specialize in JavaScript technologies across the whole stack (React.js, Node.js, Express, MongoDB).
                    </p>
                    <p class="text-gray-600 mb-6">
                        My journey in programming started when I was 15 years old, and since then I've been constantly 
                        learning new technologies and improving my skills. I love solving complex problems and creating 
                        efficient, scalable solutions.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-primary mr-3"></i>
                            <span><strong>Age:</strong> 28</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-primary mr-3"></i>
                            <span><strong>Email:</strong> john.doe@example.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-primary mr-3"></i>
                            <span><strong>Phone:</strong> +1 234 567 890</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-primary mr-3"></i>
                            <span><strong>Location:</strong> San Francisco, CA</span>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-dark text-white px-6 py-2 rounded-md hover:bg-gray-800 transition-all transform hover:-translate-y-1 flex items-center">
                            <i class="fas fa-download mr-2"></i> Download CV
                        </a>
                        <a href="/pariwisata" class="border border-dark text-dark px-6 py-2 rounded-md hover:bg-gray-100 transition-all transform hover:-translate-y-1 flex items-center">
                            <i class="fas fa-globe mr-2"></i> Pariwisata Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">My <span class="gradient-text">Skills</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Technical Skills -->
                <div class="bg-white p-8 rounded-xl shadow-md transition-all card-hover" data-aos="fade-up">
                    <h3 class="text-xl font-semibold mb-6 flex items-center">
                        <i class="fas fa-laptop-code text-primary mr-3"></i>
                        Technical Skills
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">JavaScript/TypeScript</span>
                                <span class="text-gray-600">95%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary h-2.5 rounded-full" style="width: 95%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">React.js/Next.js</span>
                                <span class="text-gray-600">90%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary h-2.5 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Node.js/Express</span>
                                <span class="text-gray-600">88%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary h-2.5 rounded-full" style="width: 88%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Python/Django</span>
                                <span class="text-gray-600">80%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary h-2.5 rounded-full" style="width: 80%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Database (SQL/NoSQL)</span>
                                <span class="text-gray-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary h-2.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Professional Skills -->
                <div class="bg-white p-8 rounded-xl shadow-md transition-all card-hover" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-xl font-semibold mb-6 flex items-center">
                        <i class="fas fa-user-tie text-secondary mr-3"></i>
                        Professional Skills
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Problem Solving</span>
                                <span class="text-gray-600">95%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-secondary h-2.5 rounded-full" style="width: 95%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Teamwork</span>
                                <span class="text-gray-600">90%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-secondary h-2.5 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Communication</span>
                                <span class="text-gray-600">88%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-secondary h-2.5 rounded-full" style="width: 88%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Project Management</span>
                                <span class="text-gray-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-secondary h-2.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Creativity</span>
                                <span class="text-gray-600">92%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-secondary h-2.5 rounded-full" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tools & Technologies -->
            <div class="mt-16">
                <h3 class="text-xl font-semibold mb-8 text-center" data-aos="fade-up">Tools & Technologies I Work With</h3>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-6">
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="zoom-in">
                        <i class="fab fa-js text-yellow-400 text-4xl mb-2"></i>
                        <span class="text-sm">JavaScript</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="zoom-in" data-aos-delay="50">
                        <i class="fab fa-react text-blue-500 text-4xl mb-2"></i>
                        <span class="text-sm">React</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="zoom-in" data-aos-delay="100">
                        <i class="fab fa-node-js text-green-600 text-4xl mb-2"></i>
                        <span class="text-sm">Node.js</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="zoom-in" data-aos-delay="150">
                        <i class="fab fa-python text-blue-700 text-4xl mb-2"></i>
                        <span class="text-sm">Python</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="zoom-in" data-aos-delay="200">
                        <i class="fas fa-database text-blue-400 text-4xl mb-2"></i>
                        <span class="text-sm">MongoDB</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all transform hover:-translate-y-1" data-aos="zoom-in" data-aos-delay="250">
                        <i class="fab fa-git-alt text-orange-600 text-4xl mb-2"></i>
                        <span class="text-sm">Git</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">My <span class="gradient-text">Services</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    I offer a range of services to help bring your digital ideas to life with cutting-edge technology.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-all card-hover service-card" data-aos="fade-up">
                    <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary mb-6 mx-auto service-icon transition-all duration-500">
                        <i class="fas fa-laptop-code text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-center">Web Development</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Custom web applications built with modern technologies like React, Next.js, and Node.js for optimal performance.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Responsive Design</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>SEO Optimized</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Performance Focused</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Service 2 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-all card-hover service-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary mb-6 mx-auto service-icon transition-all duration-500">
                        <i class="fas fa-mobile-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-center">Mobile Development</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Cross-platform mobile apps using React Native that work seamlessly on both iOS and Android devices.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Native Performance</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Offline Support</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>App Store Deployment</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Service 3 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-md transition-all card-hover service-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary mb-6 mx-auto service-icon transition-all duration-500">
                        <i class="fas fa-server text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-center">Backend Development</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Robust backend systems with Node.js, Django, or Laravel to power your applications and APIs.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>RESTful APIs</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Database Design</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Cloud Deployment</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">My <span class="gradient-text">Projects</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Here are some of my recent projects. Each one was built to solve specific problems and deliver value.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Project 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover border border-gray-100" data-aos="fade-up">
                    <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-shopping-cart text-white text-6xl z-10"></i>
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">E-Commerce Platform</h3>
                        <p class="text-gray-600 mb-4">
                            A full-featured e-commerce platform with payment integration, product management, and user accounts.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">React</span>
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">Node.js</span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">MongoDB</span>
                            <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">Stripe API</span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="#" class="text-primary hover:underline flex items-center">
                                Live Demo <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                            </a>
                            <a href="#" class="text-gray-600 hover:underline flex items-center">
                                Source Code <i class="fab fa-github ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Project 2 - Pariwisata -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                    <div class="h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-map-marked-alt text-white text-6xl z-10"></i>
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Pariwisata App</h3>
                        <p class="text-gray-600 mb-4">
                            A tourism discovery platform showcasing local attractions, with interactive maps and booking features.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">Next.js</span>
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">Tailwind CSS</span>
                            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">Firebase</span>
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full">Mapbox</span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="/pariwisata" class="text-primary hover:underline flex items-center">
                                Live Demo <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                            </a>
                            <a href="#" class="text-gray-600 hover:underline flex items-center">
                                Source Code <i class="fab fa-github ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Project 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="h-48 bg-gradient-to-r from-purple-400 to-purple-600 flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-comments text-white text-6xl z-10"></i>
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Real-time Chat App</h3>
                        <p class="text-gray-600 mb-4">
                            A real-time messaging application with private and group chats, built with WebSockets.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">React</span>
                            <span class="bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">Socket.io</span>
                            <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full">TypeScript</span>
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">Node.js</span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="#" class="text-primary hover:underline flex items-center">
                                Live Demo <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                            </a>
                            <a href="#" class="text-gray-600 hover:underline flex items-center">
                                Source Code <i class="fab fa-github ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12" data-aos="fade-up">
                <a href="#" class="inline-flex items-center px-6 py-3 border border-primary text-primary rounded-md hover:bg-blue-50 transition-all transform hover:-translate-y-1">
                    View All Projects
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">Client <span class="gradient-text">Testimonials</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Don't just take my word for it - here's what my clients have to say about working with me.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm testimonial-card relative" data-aos="fade-up">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" class="w-12 h-12 rounded-full mr-4" alt="Client">
                        <div>
                            <h4 class="font-semibold">Sarah Johnson</h4>
                            <p class="text-gray-600 text-sm">CEO, TechStart Inc.</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "John completely transformed our e-commerce platform. His attention to detail and problem-solving skills are exceptional. The project was delivered on time and exceeded our expectations."
                    </p>
                    <div class="flex">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <div class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-tl-xl testimonial-quote opacity-0 transform translate-y-2 transition-all">
                        <i class="fas fa-quote-right"></i>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm testimonial-card relative" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/54.jpg" class="w-12 h-12 rounded-full mr-4" alt="Client">
                        <div>
                            <h4 class="font-semibold">Michael Chen</h4>
                            <p class="text-gray-600 text-sm">CTO, Digital Solutions</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "Working with John was a pleasure. He took our complex requirements and delivered a solution that was both elegant and scalable. His communication throughout the project was excellent."
                    </p>
                    <div class="flex">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <div class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-tl-xl testimonial-quote opacity-0 transform translate-y-2 transition-all">
                        <i class="fas fa-quote-right"></i>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm testimonial-card relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-12 h-12 rounded-full mr-4" alt="Client">
                        <div>
                            <h4 class="font-semibold">Emily Rodriguez</h4>
                            <p class="text-gray-600 text-sm">Product Manager, TravelGo</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">
                        "The Pariwisata app John developed for us has been a game-changer. It's user-friendly, fast, and has significantly increased engagement with our tourism services. Highly recommended!"
                    </p>
                    <div class="flex">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <div class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-tl-xl testimonial-quote opacity-0 transform translate-y-2 transition-all">
                        <i class="fas fa-quote-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience & Education -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Experience -->
                <div>
                    <h3 class="text-2xl font-semibold mb-8 flex items-center" data-aos="fade-right">
                        <i class="fas fa-briefcase text-primary mr-3"></i>
                        Work Experience
                    </h3>
                    
                    <div class="space-y-8">
                        <!-- Experience 1 -->
                        <div class="relative pl-8 pb-8 border-l-2 border-primary timeline-item" data-aos="fade-right">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-primary"></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold">Senior Full Stack Developer</h4>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">2021 - Present</span>
                                </div>
                                <h5 class="text-gray-600 font-medium mb-3">Tech Solutions Inc.</h5>
                                <p class="text-gray-600">
                                    Led a team of 5 developers to build enterprise-level web applications. Architected scalable solutions and mentored junior developers.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Experience 2 -->
                        <div class="relative pl-8 pb-8 border-l-2 border-primary timeline-item" data-aos="fade-right" data-aos-delay="100">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-primary"></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold">Frontend Developer</h4>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">2018 - 2021</span>
                                </div>
                                <h5 class="text-gray-600 font-medium mb-3">Digital Creations</h5>
                                <p class="text-gray-600">
                                    Developed responsive user interfaces for client projects. Collaborated with designers to implement pixel-perfect UIs.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Education -->
                <div>
                    <h3 class="text-2xl font-semibold mb-8 flex items-center" data-aos="fade-left">
                        <i class="fas fa-graduation-cap text-secondary mr-3"></i>
                        Education
                    </h3>
                    
                    <div class="space-y-8">
                        <!-- Education 1 -->
                        <div class="relative pl-8 pb-8 border-l-2 border-secondary timeline-item" data-aos="fade-left">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-secondary"></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold">MSc in Computer Science</h4>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">2016 - 2018</span>
                                </div>
                                <h5 class="text-gray-600 font-medium mb-3">Stanford University</h5>
                                <p class="text-gray-600">
                                    Specialized in Artificial Intelligence and Web Technologies. Thesis on "Neural Networks for Web Security".
                                </p>
                            </div>
                        </div>
                        
                        <!-- Education 2 -->
                        <div class="relative pl-8 border-l-2 border-secondary timeline-item" data-aos="fade-left" data-aos-delay="100">
                            <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-secondary"></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold">BSc in Software Engineering</h4>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">2012 - 2016</span>
                                </div>
                                <h5 class="text-gray-600 font-medium mb-3">MIT</h5>
                                <p class="text-gray-600">
                                    Graduated with honors. Focused on full-stack development and software architecture.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">Get In <span class="gradient-text">Touch</span></h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                    Have a project in mind or want to discuss potential opportunities? Feel free to reach out!
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-sm" data-aos="fade-right">
                    <h3 class="text-xl font-semibold mb-6">Send Me a Message</h3>
                    <form>
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 mb-2">Your Name</label>
                            <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 mb-2">Your Email</label>
                            <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                        <div class="mb-6">
                            <label for="subject" class="block text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 mb-2">Your Message</label>
                            <textarea id="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-3 px-6 rounded-md hover:bg-blue-600 transition-all transform hover:-translate-y-1">
                            Send Message
                        </button>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div data-aos="fade-left">
                    <h3 class="text-xl font-semibold mb-6">Contact Information</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-full mr-4">
                                <i class="fas fa-map-marker-alt text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Location</h4>
                                <p class="text-gray-600">San Francisco, California, USA</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-full mr-4">
                                <i class="fas fa-envelope text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Email</h4>
                                <p class="text-gray-600">john.doe@example.com</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-full mr-4">
                                <i class="fas fa-phone text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Phone</h4>
                                <p class="text-gray-600">+1 234 567 890</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-full mr-4">
                                <i class="fas fa-clock text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Working Hours</h4>
                                <p class="text-gray-600">Monday - Friday: 9am - 5pm</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-12">
                        <h4 class="font-semibold mb-4">Follow Me</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-800 hover:text-white transition-all transform hover:-translate-y-1">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-blue-400 hover:text-white transition-all transform hover:-translate-y-1">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-blue-500 hover:text-white transition-all transform hover:-translate-y-1">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-pink-600 hover:text-white transition-all transform hover:-translate-y-1">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:bg-red-600 hover:text-white transition-all transform hover:-translate-y-1">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <span class="text-xl font-bold gradient-text">DevPort</span>
                    <p class="text-gray-400 mt-2">Building digital experiences that matter.</p>
                </div>
                <div class="flex flex-col items-center md:items-end">
                    <div class="flex space-x-6 mb-4">
                        <a href="#home" class="text-gray-400 hover:text-white transition-all">Home</a>
                        <a href="#about" class="text-gray-400 hover:text-white transition-all">About</a>
                        <a href="#skills" class="text-gray-400 hover:text-white transition-all">Skills</a>
                        <a href="#projects" class="text-gray-400 hover:text-white transition-all">Projects</a>
                        <a href="/pariwisata" class="text-primary hover:text-blue-400 transition-all">Pariwisata</a>
                        <a href="#contact" class="text-gray-400 hover:text-white transition-all">Contact</a>
                    </div>
                    <p class="text-gray-500 text-sm">© 2023 John Doe. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 w-12 h-12 bg-primary text-white rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all transform hover:scale-110">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: false
        });
        
        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Back to top button
        const backToTopBtn = document.getElementById('back-to-top');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'visible');
                backToTopBtn.classList.add('opacity-0', 'invisible');
            }
        });
        
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });
    </script>
</body>
</html>