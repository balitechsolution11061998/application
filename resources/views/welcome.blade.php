<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Article Filter
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #4A90E2;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .hidden {
            display: none;
        }

        .pretty-checkbox {
            appearance: none;
            background-color: #fff;
            border: 2px solid #d1d5db;
            border-radius: 0.25rem;
            width: 1.25rem;
            height: 1.25rem;
            display: inline-block;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .pretty-checkbox:checked {
            background-color: #4A90E2;
            border-color: #4A90E2;
        }

        .pretty-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 0.1rem;
            left: 0.35rem;
            width: 0.25rem;
            height: 0.5rem;
            border: solid white;
            border-width: 0 0.2rem 0.2rem 0;
            transform: rotate(45deg);
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .slideshow-container {
            position: relative;
            max-width: 100%;
            margin: auto;
        }

        .slideshow-image {
            display: none;
            width: 100%;
            border-radius: 0.5rem;
        }

        .active {
            display: block;
        }

        .slideshow-container {
            position: relative;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .slideshow-item {
            position: relative;
            display: none;
        }

        .slideshow-item.active {
            display: block;
        }

        .slideshow-image {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            transition: all 0.5s ease-in-out;
        }

        .slide-text {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            max-width: 80%;
        }

        .slide-text h2 {
            font-size: 1.5rem;
            margin: 0 0 10px;
            font-family: 'Montserrat', sans-serif;
        }

        .slide-text p {
            font-size: 1rem;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        /* Add responsiveness */
        @media (max-width: 768px) {
            .slide-text {
                max-width: 95%;
                bottom: 10px;
                font-size: 0.9rem;
            }

            .slide-text h2 {
                font-size: 1.2rem;
            }

            .slide-text p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold text-gray-800" href="#">
                MyWebsite
            </a>
            <div class="flex items-center space-x-4">
                <a class="text-gray-800 hover:text-blue-500" href="#">
                    Home
                </a>
                <a class="text-gray-800 hover:text-blue-500" href="#">
                    About
                </a>
                <a class="text-gray-800 hover:text-blue-500" href="#">
                    Contact
                </a>
            </div>
        </div>
    </nav>
    <!-- Slideshow -->
    <div class="slideshow-container my-4">
        <div class="slideshow-item">
            <img alt="Slideshow image 1" class="slideshow-image active"
                src="https://placehold.co/800x300?text=Slide+1" />
            <div class="slide-text">
                <h2>Slide 1 Title</h2>
                <p>This is a description for Slide 1.</p>
            </div>
        </div>
        <div class="slideshow-item">
            <img alt="Slideshow image 2" class="slideshow-image" src="https://placehold.co/800x300?text=Slide+2" />
            <div class="slide-text">
                <h2>Slide 2 Title</h2>
                <p>This is a description for Slide 2.</p>
            </div>
        </div>
        <div class="slideshow-item">
            <img alt="Slideshow image 3" class="slideshow-image" src="https://placehold.co/800x300?text=Slide+3" />
            <div class="slide-text">
                <h2>Slide 3 Title</h2>
                <p>This is a description for Slide 3.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-4">
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-1/4 p-4 bg-white rounded-lg shadow-md">
                <button class="w-full bg-red-500 text-white py-2 px-4 rounded-lg mb-4 flex items-center justify-center">
                    <i class="fas fa-filter mr-2">
                    </i>
                    Filters Articles
                </button>
                <div class="mb-4">
                    <h2 class="text-lg font-semibold mb-2">
                        Type
                    </h2>
                    <div class="flex items-center mb-2">
                        <input class="pretty-checkbox mr-2" id="gratis" name="type" type="radio" />
                        <label class="text-gray-700" for="gratis">
                            Gratis (Rp. 0)
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input class="pretty-checkbox mr-2" id="premium" name="type" type="radio" />
                        <label class="text-gray-700" for="premium">
                            Premium
                        </label>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-2">
                        Technology
                    </h2>
                    <div class="flex items-center mb-2">
                        <input class="pretty-checkbox mr-2" id="adonis" type="checkbox" />
                        <label class="flex items-center" for="adonis">
                            <img alt="Adonis Js logo" class="mr-2 rounded-full" src="https://placehold.co/24x24" />
                            Adonis Js
                        </label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input class="pretty-checkbox mr-2" id="alpine" type="checkbox" />
                        <label class="flex items-center" for="alpine">
                            <img alt="Alpine Js logo" class="mr-2 rounded-full" src="https://placehold.co/24x24" />
                            Alpine Js
                        </label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input class="pretty-checkbox mr-2" id="bun" type="checkbox" />
                        <label class="flex items-center" for="bun">
                            <img alt="Bun logo" class="mr-2 rounded-full" src="https://placehold.co/24x24" />
                            Bun
                        </label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input class="pretty-checkbox mr-2" id="codeigniter" type="checkbox" />
                        <label class="flex items-center" for="codeigniter">
                            <img alt="CodeIgniter logo" class="mr-2 rounded-full" src="https://placehold.co/24x24" />
                            CodeIgniter
                        </label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input class="pretty-checkbox mr-2" id="dart" type="checkbox" />
                        <label class="flex items-center" for="dart">
                            <img alt="Dart logo" class="mr-2 rounded-full" src="https://placehold.co/24x24" />
                            Dart
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input class="pretty-checkbox mr-2" id="devops" type="checkbox" />
                        <label class="flex items-center" for="devops">
                            <img alt="DevOps logo" class="mr-2 rounded-full" src="https://placehold.co/24x24" />
                            DevOps
                        </label>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="w-3/4 p-4">
                <div class="flex items-center mb-4">
                    <input class="w-full p-2 border border-gray-300 rounded-lg"
                        placeholder="Apa yang ingin Anda pelajari?" type="text" />
                    <i class="fas fa-search ml-2 text-gray-500">
                    </i>
                </div>
                <div class="flex justify-center items-center h-64" id="spinner">
                    <div class="spinner">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 hidden fade-in" id="content">
                    <!-- Article Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img alt="Express MongoDB tutorial image" class="w-full"
                            src="https://placehold.co/600x400" />
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="bg-blue-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Express JS
                                </span>
                                <span class="bg-gray-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Prisma
                                </span>
                                <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded">
                                    MongoDB
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">
                                Tutorial RESTful API Express dan MongoDB #8: Enable CORS di Express
                            </h3>
                            <div class="flex items-center">
                                <img alt="Author's profile picture" class="w-6 h-6 rounded-full mr-2"
                                    src="https://placehold.co/24x24" />
                                <span class="text-gray-700">
                                    Fika Ridaul Maulayya
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Article Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img alt="Express MongoDB tutorial image" class="w-full"
                            src="https://placehold.co/600x400" />
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="bg-blue-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Express JS
                                </span>
                                <span class="bg-gray-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Prisma
                                </span>
                                <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded">
                                    MongoDB
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">
                                Tutorial RESTful API Express dan MongoDB #7: Delete Data dari Database
                            </h3>
                            <div class="flex items-center">
                                <img alt="Author's profile picture" class="w-6 h-6 rounded-full mr-2"
                                    src="https://placehold.co/24x24" />
                                <span class="text-gray-700">
                                    Fika Ridaul Maulayya
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Article Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img alt="Express MongoDB tutorial image" class="w-full"
                            src="https://placehold.co/600x400" />
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="bg-blue-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Express JS
                                </span>
                                <span class="bg-gray-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Prisma
                                </span>
                                <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded">
                                    MongoDB
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">
                                Tutorial RESTful API Express dan MongoDB #8: Enable CORS di Express
                            </h3>
                            <div class="flex items-center">
                                <img alt="Author's profile picture" class="w-6 h-6 rounded-full mr-2"
                                    src="https://placehold.co/24x24" />
                                <span class="text-gray-700">
                                    Fika Ridaul Maulayya
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Article Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img alt="Express MongoDB tutorial image" class="w-full"
                            src="https://placehold.co/600x400" />
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="bg-blue-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Express JS
                                </span>
                                <span class="bg-gray-500 text-white text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                    Prisma
                                </span>
                                <span class="bg-green-500 text-white text-xs font-semibold px-2.5 py-0.5 rounded">
                                    MongoDB
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">
                                Tutorial RESTful API Express dan MongoDB #7: Delete Data dari Database
                            </h3>
                            <div class="flex items-center">
                                <img alt="Author's profile picture" class="w-6 h-6 rounded-full mr-2"
                                    src="https://placehold.co/24x24" />
                                <span class="text-gray-700">
                                    Fika Ridaul Maulayya
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                document.getElementById("spinner").classList.add("hidden");
                document.getElementById("content").classList.remove("hidden");
            }, 2000); // Simulate loading time

            let slideIndex = 0;
            showSlides();

            function showSlides() {
                let slides = document.getElementsByClassName("slideshow-image");
                for (let i = 0; i < slides.length; i++) {
                    slides[i].classList.remove("active");
                }
                slideIndex++;
                if (slideIndex > slides.length) {
                    slideIndex = 1;
                }
                slides[slideIndex - 1].classList.add("active");
                setTimeout(showSlides, 3000); // Change image every 3 seconds
            }
        });
    </script>
</body>

</html>
