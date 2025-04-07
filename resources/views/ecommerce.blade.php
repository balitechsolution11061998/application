<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern E-commerce</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#f59e0b',
                        dark: '#1e293b',
                        light: '#f8fafc',
                    },
                    animation: {
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 3s infinite',
                    }
                }
            }
        }
    </script>
    <style>
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #f59e0b;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Top Announcement Bar -->
    <div class="bg-primary text-white text-center py-2 px-4 animate__animated animate__fadeInDown">
        <p class="text-sm">🔥 Free shipping on orders over $50 | Use code: SHOP50</p>
    </div>

    <!-- Header/Navbar -->
    <header class="sticky top-0 z-50 bg-white shadow-md animate__animated animate__fadeIn">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-dark flex items-center">
                        <i class="fas fa-shopping-bag text-primary mr-2"></i>
                        Shop<span class="text-primary">Hub</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 mx-8">
                    <div class="relative w-full max-w-xl">
                        <input type="text" placeholder="Search for products..." 
                               class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <button class="absolute right-0 top-0 h-full px-4 text-gray-600 hover:text-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-700 hover:text-primary transition">Home</a>
                    
                    <!-- Dropdown Categories -->
                    <div class="dropdown relative">
                        <button class="text-gray-700 hover:text-primary transition flex items-center">
                            Categories <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="dropdown-menu absolute hidden mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 animate__animated animate__fadeIn">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Electronics</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Fashion</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Home & Garden</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Sports</a>
                        </div>
                    </div>
                    
                    <a href="#" class="text-gray-700 hover:text-primary transition">About</a>
                    <a href="#" class="text-gray-700 hover:text-primary transition">Contact</a>
                </div>

                <!-- Icons -->
                <div class="flex items-center space-x-5 ml-6">
                    <a href="#" class="text-gray-700 hover:text-primary transition relative">
                        <i class="far fa-user text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-700 hover:text-primary transition relative">
                        <i class="far fa-heart text-xl"></i>
                        <span class="cart-badge">3</span>
                    </a>
                    <a href="#" class="text-gray-700 hover:text-primary transition relative" id="cart-icon">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-badge">5</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700 focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden bg-white py-2 px-4 shadow-md" id="mobile-menu">
            <div class="flex flex-col space-y-3">
                <input type="text" placeholder="Search..." class="w-full px-4 py-2 rounded border border-gray-300 mb-2">
                <a href="#" class="text-gray-700 hover:text-primary">Home</a>
                <a href="#" class="text-gray-700 hover:text-primary">Categories</a>
                <a href="#" class="text-gray-700 hover:text-primary">About</a>
                <a href="#" class="text-gray-700 hover:text-primary">Contact</a>
                <div class="pt-2 border-t border-gray-200">
                    <a href="#" class="text-gray-700 hover:text-primary">Account</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary to-indigo-600 text-white py-16 animate__animated animate__fadeIn">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0 animate__animated animate__fadeInLeft">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Summer Collection 2023</h1>
                <p class="text-xl mb-6">Discover the latest trends in fashion and accessories</p>
                <div class="flex space-x-4">
                    <button class="bg-white text-primary px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                        Shop Now
                    </button>
                    <button class="border-2 border-white text-white px-6 py-3 rounded-full font-semibold hover:bg-white hover:text-primary transition transform hover:scale-105">
                        View Sale
                    </button>
                </div>
            </div>
            <div class="md:w-1/2 animate__animated animate__fadeInRight animate__delay-1s">
                <img src="https://via.placeholder.com/600x400" alt="Hero Image" class="rounded-lg shadow-xl w-full max-w-md mx-auto">
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-12 bg-white animate__animated animate__fadeIn animate__delay-1s">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Category 1 -->
                <div class="category-card bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <a href="#" class="block">
                        <img src="https://via.placeholder.com/300x200" alt="Electronics" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-dark">Electronics</h3>
                            <p class="text-gray-600 text-sm">200+ Products</p>
                        </div>
                    </a>
                </div>
                
                <!-- Category 2 -->
                <div class="category-card bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <a href="#" class="block">
                        <img src="https://via.placeholder.com/300x200" alt="Fashion" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-dark">Fashion</h3>
                            <p class="text-gray-600 text-sm">500+ Products</p>
                        </div>
                    </a>
                </div>
                
                <!-- Category 3 -->
                <div class="category-card bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <a href="#" class="block">
                        <img src="https://via.placeholder.com/300x200" alt="Home & Garden" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-dark">Home & Garden</h3>
                            <p class="text-gray-600 text-sm">300+ Products</p>
                        </div>
                    </a>
                </div>
                
                <!-- Category 4 -->
                <div class="category-card bg-gray-100 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <a href="#" class="block">
                        <img src="https://via.placeholder.com/300x200" alt="Sports" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-dark">Sports</h3>
                            <p class="text-gray-600 text-sm">150+ Products</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-12 bg-gray-50 animate__animated animate__fadeIn animate__delay-1s">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Featured Products</h2>
                <a href="#" class="text-primary hover:underline">View All</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- Product 1 -->
                <div class="product-card bg-white rounded-lg overflow-hidden shadow-md p-4 transition duration-300">
                    <div class="relative group">
                        <img src="https://via.placeholder.com/300x300" alt="Product 1" class="w-full h-64 object-contain">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300 flex items-center justify-center">
                            <button class="bg-primary text-white px-4 py-2 rounded-full opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition duration-300 quick-view-btn">
                                Quick View
                            </button>
                        </div>
                        <div class="absolute top-2 right-2">
                            <button class="bg-white rounded-full p-2 shadow-md text-gray-600 hover:text-red-500">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <span class="absolute top-2 left-2 bg-secondary text-white text-xs font-bold px-2 py-1 rounded">Sale</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-dark">Wireless Headphones</h3>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-600 text-sm ml-2">(42)</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                <span class="text-primary font-bold text-lg">$89.99</span>
                                <span class="text-gray-500 text-sm line-through ml-2">$129.99</span>
                            </div>
                            <button class="add-to-cart bg-primary text-white p-2 rounded-full hover:bg-indigo-700 transition">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="product-card bg-white rounded-lg overflow-hidden shadow-md p-4 transition duration-300">
                    <div class="relative group">
                        <img src="https://via.placeholder.com/300x300" alt="Product 2" class="w-full h-64 object-contain">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300 flex items-center justify-center">
                            <button class="bg-primary text-white px-4 py-2 rounded-full opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition duration-300 quick-view-btn">
                                Quick View
                            </button>
                        </div>
                        <div class="absolute top-2 right-2">
                            <button class="bg-white rounded-full p-2 shadow-md text-gray-600 hover:text-red-500">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-dark">Smart Watch Pro</h3>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm ml-2">(28)</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                <span class="text-primary font-bold text-lg">$199.99</span>
                            </div>
                            <button class="add-to-cart bg-primary text-white p-2 rounded-full hover:bg-indigo-700 transition">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="product-card bg-white rounded-lg overflow-hidden shadow-md p-4 transition duration-300">
                    <div class="relative group">
                        <img src="https://via.placeholder.com/300x300" alt="Product 3" class="w-full h-64 object-contain">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300 flex items-center justify-center">
                            <button class="bg-primary text-white px-4 py-2 rounded-full opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition duration-300 quick-view-btn">
                                Quick View
                            </button>
                        </div>
                        <div class="absolute top-2 right-2">
                            <button class="bg-white rounded-full p-2 shadow-md text-gray-600 hover:text-red-500">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">-30%</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-dark">Bluetooth Speaker</h3>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm ml-2">(56)</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                <span class="text-primary font-bold text-lg">$59.99</span>
                                <span class="text-gray-500 text-sm line-through ml-2">$85.99</span>
                            </div>
                            <button class="add-to-cart bg-primary text-white p-2 rounded-full hover:bg-indigo-700 transition">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 4 -->
                <div class="product-card bg-white rounded-lg overflow-hidden shadow-md p-4 transition duration-300">
                    <div class="relative group">
                        <img src="https://via.placeholder.com/300x300" alt="Product 4" class="w-full h-64 object-contain">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300 flex items-center justify-center">
                            <button class="bg-primary text-white px-4 py-2 rounded-full opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition duration-300 quick-view-btn">
                                Quick View
                            </button>
                        </div>
                        <div class="absolute top-2 right-2">
                            <button class="bg-white rounded-full p-2 shadow-md text-gray-600 hover:text-red-500">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">New</span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-dark">4K Action Camera</h3>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-600 text-sm ml-2">(34)</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                <span class="text-primary font-bold text-lg">$249.99</span>
                            </div>
                            <button class="add-to-cart bg-primary text-white p-2 rounded-full hover:bg-indigo-700 transition">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    <section class="py-12 animate__animated animate__fadeIn">
        <div class="container mx-auto px-4">
            <div class="bg-primary rounded-xl p-8 md:p-12 text-white overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white bg-opacity-10 rounded-full"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Summer Sale!</h2>
                    <p class="text-xl mb-6 max-w-lg">Up to 50% off on selected items. Limited time offer!</p>
                    <button class="bg-white text-primary px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition transform hover:scale-105 animate__animated animate__pulse animate__infinite">
                        Shop the Sale
                    </button>
                </div>
                <div class="absolute right-0 bottom-0 hidden md:block">
                    <img src="https://via.placeholder.com/400x300" alt="Banner" class="h-64 object-contain">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-12 bg-white animate__animated animate__fadeIn">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">What Our Customers Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"The quality of the products is amazing! Fast shipping and excellent customer service. Will definitely shop here again."</p>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/50x50" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold">Sarah Johnson</h4>
                            <p class="text-gray-600 text-sm">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"Great selection of products at competitive prices. The website is easy to navigate and checkout was a breeze."</p>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/50x50" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold">Michael Chen</h4>
                            <p class="text-gray-600 text-sm">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">"I'm impressed with how quickly I received my order. The product exceeded my expectations. Highly recommend!"</p>
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/50x50" alt="Customer" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold">David Wilson</h4>
                            <p class="text-gray-600 text-sm">Verified Buyer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-12 bg-gray-100 animate__animated animate__fadeIn">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8">Subscribe to our newsletter for the latest products, promotions, and news.</p>
            <div class="max-w-md mx-auto flex">
                <input type="email" placeholder="Your email address" class="flex-1 px-4 py-3 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary">
                <button class="bg-primary text-white px-6 py-3 rounded-r-lg font-semibold hover:bg-indigo-700 transition">
                    Subscribe
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-12 pb-6 animate__animated animate__fadeIn">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Column 1 -->
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-shopping-bag text-primary mr-2"></i>
                        Shop<span class="text-primary">Hub</span>
                    </h3>
                    <p class="text-gray-400 mb-4">Your one-stop shop for all your needs. Quality products at affordable prices.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Column 2 -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Products</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Special Offers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>
                
                <!-- Column 3 -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">My Account</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Order Tracking</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Wishlist</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Shipping Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Returns & Refunds</a></li>
                    </ul>
                </div>
                
                <!-- Column 4 -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                            <span>123 Street, City, Country</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary"></i>
                            <span>+1 234 567 890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary"></i>
                            <span>info@shophub.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2023 ShopHub. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition">Cookies Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Quick View Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden" id="quick-view-modal">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-screen overflow-y-auto animate__animated animate__fadeInUp">
            <div class="p-4 flex justify-end">
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="md:w-1/2">
                        <div class="bg-gray-100 rounded-lg p-4 mb-4">
                            <img src="https://via.placeholder.com/500x500" alt="Product" class="w-full h-80 object-contain" id="modal-product-image">
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <div class="border rounded p-1 cursor-pointer">
                                <img src="https://via.placeholder.com/100x100" alt="Thumbnail" class="w-full h-16 object-cover">
                            </div>
                            <div class="border rounded p-1 cursor-pointer">
                                <img src="https://via.placeholder.com/100x100" alt="Thumbnail" class="w-full h-16 object-cover">
                            </div>
                            <div class="border rounded p-1 cursor-pointer">
                                <img src="https://via.placeholder.com/100x100" alt="Thumbnail" class="w-full h-16 object-cover">
                            </div>
                            <div class="border rounded p-1 cursor-pointer">
                                <img src="https://via.placeholder.com/100x100" alt="Thumbnail" class="w-full h-16 object-cover">
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <h2 class="text-2xl font-bold mb-2" id="modal-product-title">Wireless Headphones</h2>
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400 mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-600 text-sm">(42 Reviews)</span>
                        </div>
                        <div class="mb-4">
                            <span class="text-primary font-bold text-2xl">$89.99</span>
                            <span class="text-gray-500 text-lg line-through ml-2">$129.99</span>
                            <span class="bg-red-100 text-red-800 text-sm font-semibold ml-2 px-2 py-1 rounded">30% OFF</span>
                        </div>
                        <p class="text-gray-700 mb-6" id="modal-product-description">
                            High-quality wireless headphones with noise cancellation feature. Up to 30 hours of battery life. Comfortable over-ear design with soft cushioning.
                        </p>
                        <div class="mb-6">
                            <h4 class="font-semibold mb-2">Color:</h4>
                            <div class="flex space-x-2">
                                <button class="w-8 h-8 rounded-full bg-black border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary"></button>
                                <button class="w-8 h-8 rounded-full bg-blue-500 border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary"></button>
                                <button class="w-8 h-8 rounded-full bg-red-500 border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary"></button>
                            </div>
                        </div>
                        <div class="mb-6">
                            <h4 class="font-semibold mb-2">Quantity:</h4>
                            <div class="flex items-center">
                                <button class="bg-gray-200 px-3 py-1 rounded-l focus:outline-none">-</button>
                                <input type="text" value="1" class="w-12 text-center border-t border-b border-gray-300 py-1">
                                <button class="bg-gray-200 px-3 py-1 rounded-r focus:outline-none">+</button>
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <button class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition flex-1 add-to-cart-modal">
                                <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                            </button>
                            <button class="border border-primary text-primary px-6 py-3 rounded-lg font-semibold hover:bg-primary hover:text-white transition">
                                <i class="far fa-heart mr-2"></i> Wishlist
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shopping Cart Sidebar -->
    <div class="fixed inset-y-0 right-0 w-full md:w-96 bg-white shadow-lg transform translate-x-full transition duration-300 z-50" id="cart-sidebar">
        <div class="h-full flex flex-col">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Your Cart (<span id="cart-count">5</span>)
                </h3>
                <button class="text-gray-500 hover:text-gray-700 close-cart">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4">
                <!-- Cart Item 1 -->
                <div class="flex py-4 border-b">
                    <div class="w-20 h-20 bg-gray-100 rounded flex-shrink-0">
                        <img src="https://via.placeholder.com/100x100" alt="Product" class="w-full h-full object-contain">
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-medium">Wireless Headphones</h4>
                        <p class="text-gray-600 text-sm">Color: Black</p>
                        <div class="flex justify-between items-center mt-1">
                            <div class="flex items-center">
                                <button class="text-gray-500 hover:text-primary">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="mx-2">1</span>
                                <button class="text-gray-500 hover:text-primary">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <span class="font-semibold">$89.99</span>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-red-500 ml-2">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
                
                <!-- Cart Item 2 -->
                <div class="flex py-4 border-b">
                    <div class="w-20 h-20 bg-gray-100 rounded flex-shrink-0">
                        <img src="https://via.placeholder.com/100x100" alt="Product" class="w-full h-full object-contain">
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-medium">Smart Watch Pro</h4>
                        <p class="text-gray-600 text-sm">Color: Silver</p>
                        <div class="flex justify-between items-center mt-1">
                            <div class="flex items-center">
                                <button class="text-gray-500 hover:text-primary">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="mx-2">2</span>
                                <button class="text-gray-500 hover:text-primary">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <span class="font-semibold">$399.98</span>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-red-500 ml-2">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-4 border-t">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal:</span>
                    <span class="font-semibold">$489.97</span>
                </div>
                <div class="flex justify-between mb-4">
                    <span class="text-gray-600">Shipping:</span>
                    <span class="font-semibold">Free</span>
                </div>
                <div class="flex justify-between text-lg font-bold mb-6">
                    <span>Total:</span>
                    <span>$489.97</span>
                </div>
                <button class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition mb-2">
                    Proceed to Checkout
                </button>
                <button class="w-full border border-primary text-primary py-3 rounded-lg font-semibold hover:bg-primary hover:text-white transition">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" id="backdrop"></div>

    <!-- jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Quick view modal
        const quickViewButtons = document.querySelectorAll('.quick-view-btn');
        const quickViewModal = document.getElementById('quick-view-modal');
        const closeModalButton = document.querySelector('.close-modal');
        const backdrop = document.getElementById('backdrop');

        quickViewButtons.forEach(button => {
            button.addEventListener('click', function() {
                quickViewModal.classList.remove('hidden');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        });

        closeModalButton.addEventListener('click', function() {
            quickViewModal.classList.add('hidden');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        });

        backdrop.addEventListener('click', function() {
            quickViewModal.classList.add('hidden');
            this.classList.add('hidden');
            document.body.style.overflow = '';
        });

        // Cart sidebar
        const cartIcon = document.getElementById('cart-icon');
        const cartSidebar = document.getElementById('cart-sidebar');
        const closeCartButton = document.querySelector('.close-cart');

        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            cartSidebar.classList.remove('translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        closeCartButton.addEventListener('click', function() {
            cartSidebar.classList.add('translate-x-full');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        });

        backdrop.addEventListener('click', function() {
            cartSidebar.classList.add('translate-x-full');
            this.classList.add('hidden');
            document.body.style.overflow = '';
        });

        // Add to cart functionality with Toastr
        const addToCartButtons = document.querySelectorAll('.add-to-cart, .add-to-cart-modal');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Update cart count
                const cartCount = document.getElementById('cart-count');
                let count = parseInt(cartCount.textContent);
                cartCount.textContent = count + 1;
                
                // Show toast notification
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-bottom-right",
                    showMethod: 'slideDown',
                    hideMethod: 'slideUp',
                    timeOut: 3000
                };
                
                toastr.success('Item added to cart!', 'Success');
                
                // Animate cart icon
                const cartIcon = document.getElementById('cart-icon');
                cartIcon.classList.add('animate__animated', 'animate__bounce');
                setTimeout(() => {
                    cartIcon.classList.remove('animate__animated', 'animate__bounce');
                }, 1000);
            });
        });

        // Product card hover animation
        const productCards = document.querySelectorAll('.product-card');
        
        productCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('animate__animated', 'animate__pulse');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('animate__animated', 'animate__pulse');
            });
        });
    </script>
</body>
</html>