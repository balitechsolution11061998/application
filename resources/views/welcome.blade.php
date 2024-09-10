<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Educational Blog Landing Page</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        .slide-up {
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 1s forwards;
        }
        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .carousel {
            position: relative;
            overflow: hidden;
        }
        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-item {
            min-width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto flex items-center justify-between p-4">
            <a href="#" class="text-2xl font-bold">YourLogo</a>
            <div class="hidden md:flex space-x-4">
                <a href="#services" class="hover:underline">Services</a>
                <a href="#about" class="hover:underline">About</a>
                <a href="#blog" class="hover:underline">Blog</a>
                <a href="#education" class="hover:underline">Education</a>
                <a href="#contact" class="hover:underline">Contact</a>
                <a href="login/form" class="bg-white text-blue-600 py-2 px-4 rounded-full font-semibold transition-transform transform hover:scale-105">Login</a>
            </div>
            <button class="md:hidden text-white" id="menu-toggle">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
        <div class="md:hidden hidden" id="menu">
            <a href="#services" class="block py-2 px-4 text-center hover:bg-blue-500 transition-transform transform hover:scale-105">Services</a>
            <a href="#about" class="block py-2 px-4 text-center hover:bg-blue-500 transition-transform transform hover:scale-105">About</a>
            <a href="#blog" class="block py-2 px-4 text-center hover:bg-blue-500 transition-transform transform hover:scale-105">Blog</a>
            <a href="#education" class="block py-2 px-4 text-center hover:bg-blue-500 transition-transform transform hover:scale-105">Education</a>
            <a href="#contact" class="block py-2 px-4 text-center hover:bg-blue-500 transition-transform transform hover:scale-105">Contact</a>
            <a href="login/form" class="block py-2 px-4 text-center bg-white text-blue-600 font-semibold rounded-full hover:bg-gray-200 transition-transform transform hover:scale-105">Login</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="carousel relative">
                <div class="carousel-inner">
                    <div class="carousel-item bg-cover bg-center h-full" style="background-image: url('https://via.placeholder.com/1500x1000');"></div>
                    <div class="carousel-item bg-cover bg-center h-full" style="background-image: url('https://via.placeholder.com/1500x1000/0000FF/808080');"></div>
                    <div class="carousel-item bg-cover bg-center h-full" style="background-image: url('https://via.placeholder.com/1500x1000/FF0000/FFFFFF');"></div>
                </div>
                <button class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-blue-800 text-white p-2 rounded-full" id="prevSlide">&lt;</button>
                <button class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-blue-800 text-white p-2 rounded-full" id="nextSlide">&gt;</button>
            </div>
        </div>
        <div class="text-center relative z-10 fade-in">
            <h1 class="text-5xl font-bold mb-4">Welcome to Our Blog & Learning Hub</h1>
            <p class="text-lg mb-8">Explore tutorials, educational resources, and more to boost your knowledge.</p>
            <a href="#blog" class="bg-white text-blue-600 py-3 px-6 rounded-full text-lg font-semibold hover:bg-gray-100 transition-transform transform hover:scale-105">Explore Blog</a>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 slide-up">
                <h2 class="text-4xl font-bold mb-4">Our Services</h2>
                <p class="text-lg text-gray-600">Explore our wide range of services designed to meet your needs.</p>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:scale-105">
                        <h3 class="text-xl font-semibold mb-4">Service 1</h3>
                        <p class="text-gray-600">High-quality service with professional support.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:scale-105">
                        <h3 class="text-xl font-semibold mb-4">Service 2</h3>
                        <p class="text-gray-600">Innovative solutions tailored to your needs.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:scale-105">
                        <h3 class="text-xl font-semibold mb-4">Service 3</h3>
                        <p class="text-gray-600">Exceptional quality and reliability in every aspect.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 slide-up">
                <h2 class="text-4xl font-bold mb-4">Our Blog</h2>
                <p class="text-lg text-gray-600">Read our latest posts and stay updated with valuable insights.</p>
            </div>
            <div class="flex flex-wrap -mx-4">
                <!-- Blog Post 1 -->
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <img src="https://via.placeholder.com/400x250" alt="Blog Post" class="mb-4 w-full h-48 object-cover rounded-lg">
                        <h3 class="text-xl font-semibold mb-2">Blog Post Title 1</h3>
                        <p class="text-gray-600 mb-4">Brief description or summary of the blog post goes here.</p>
                        <a href="#" class="text-blue-600 hover:underline">Read more</a>
                    </div>
                </div>
                <!-- Blog Post 2 -->
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <img src="https://via.placeholder.com/400x250" alt="Blog Post" class="mb-4 w-full h-48 object-cover rounded-lg">
                        <h3 class="text-xl font-semibold mb-2">Blog Post Title 2</h3>
                        <p class="text-gray-600 mb-4">Brief description or summary of the blog post goes here.</p>
                        <a href="#" class="text-blue-600 hover:underline">Read more</a>
                    </div>
                </div>
                <!-- Blog Post 3 -->
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <img src="https://via.placeholder.com/400x250" alt="Blog Post" class="mb-4 w-full h-48 object-cover rounded-lg">
                        <h3 class="text-xl font-semibold mb-2">Blog Post Title 3</h3>
                        <p class="text-gray-600 mb-4">Brief description or summary of the blog post goes here.</p>
                        <a href="#" class="text-blue-600 hover:underline">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section id="education" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 slide-up">
                <h2 class="text-4xl font-bold mb-4">Educational Resources</h2>
                <p class="text-lg text-gray-600">Access various resources to enhance your learning experience.</p>
            </div>
            <div class="flex flex-wrap -mx-4">
                <!-- Educational Resource 1 -->
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                        <h3 class="text-xl font-semibold mb-4">Resource 1</h3>
                        <p class="text-gray-600 mb-4">A brief description of the educational resource.</p>
                        <a href="#" class="bg-blue-600 text-white py-2 px-4 rounded-full hover:bg-blue-700">Explore</a>
                    </div>
                </div>
                <!-- Educational Resource 2 -->
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                        <h3 class="text-xl font-semibold mb-4">Resource 2</h3>
                        <p class="text-gray-600 mb-4">A brief description of the educational resource.</p>
                        <a href="#" class="bg-blue-600 text-white py-2 px-4 rounded-full hover:bg-blue-700">Explore</a>
                    </div>
                </div>
                <!-- Educational Resource 3 -->
                <div class="w-full md:w-1/3 px-4 mb-8 slide-up">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                        <h3 class="text-xl font-semibold mb-4">Resource 3</h3>
                        <p class="text-gray-600 mb-4">A brief description of the educational resource.</p>
                        <a href="#" class="bg-blue-600 text-white py-2 px-4 rounded-full hover:bg-blue-700">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <div class="flex flex-wrap justify-center mb-6">
                <a href="#services" class="mx-4 text-gray-400 hover:text-white transition">Services</a>
                <a href="#about" class="mx-4 text-gray-400 hover:text-white transition">About</a>
                <a href="#blog" class="mx-4 text-gray-400 hover:text-white transition">Blog</a>
                <a href="#education" class="mx-4 text-gray-400 hover:text-white transition">Education</a>
                <a href="#contact" class="mx-4 text-gray-400 hover:text-white transition">Contact</a>
            </div>
            <div class="flex justify-center space-x-4 mb-6">
                <a href="https://facebook.com" class="text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.406.593 24 1.325 24H12.82v-9.294H9.692V11.01h3.128V8.367c0-3.1 1.894-4.787 4.658-4.787 1.325 0 2.463.098 2.793.143v3.24H18.15c-1.617 0-1.931.77-1.931 1.897v2.486h3.862l-.504 3.695h-3.358V24h6.586C23.406 24 24 23.406 24 22.676V1.325C24 .593 23.406 0 22.675 0z"/>
                    </svg>
                </a>
                <a href="https://twitter.com" class="text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.954 4.569c-.885.39-1.83.654-2.825.775a4.932 4.932 0 0 0 2.163-2.723c-.951.555-2.005.959-3.127 1.175a4.92 4.92 0 0 0-8.384 4.482A13.978 13.978 0 0 1 1.671 3.149a4.93 4.93 0 0 0 1.523 6.574 4.903 4.903 0 0 1-2.23-.616c-.053 2.281 1.581 4.415 3.949 4.894a4.935 4.935 0 0 1-2.224.085 4.936 4.936 0 0 0 4.604 3.417A9.87 9.87 0 0 1 0 19.539 13.94 13.94 0 0 0 7.548 21c9.142 0 14.307-7.72 14.307-14.415 0-.22 0-.435-.015-.648a10.282 10.282 0 0 0 2.512-2.645z"/>
                    </svg>
                </a>
                <a href="https://linkedin.com" class="text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.557 3H4.443A1.444 1.444 0 0 0 3 4.443v15.114A1.444 1.444 0 0 0 4.443 21h15.114A1.444 1.444 0 0 0 21 19.557V4.443A1.444 1.444 0 0 0 19.557 3zM8.54 18.31H5.872v-8.64H8.54v8.64zm-1.33-9.938a1.597 1.597 0 1 1 0-3.193 1.597 1.597 0 0 1 0 3.193zm11.3 9.937h-2.666v-4.173c0-.993-.358-1.672-1.253-1.672-.683 0-1.09.468-1.27.919-.065.158-.082.377-.082.598v4.328h-2.666V9.67h2.666v1.176h.038a2.92 2.92 0 0 1 2.63-1.434c1.916 0 3.356 1.251 3.356 3.936v5.963z"/>
                    </svg>
                </a>
            </div>
            <p class="text-gray-400 text-sm">© 2024 Your Blog Name. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script>
        // Mobile menu toggle
        document.getElementById('menu-toggle').addEventListener('click', () => {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });

        // Carousel functionality
        let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;

        document.getElementById('nextSlide').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
        });

        document.getElementById('prevSlide').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateCarousel();
        });

        function updateCarousel() {
            const offset = -currentIndex * 100;
            document.querySelector('.carousel-inner').style.transform = `translateX(${offset}%)`;
        }
    </script>
</body>
</html>
