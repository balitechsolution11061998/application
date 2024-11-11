<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV of I Wayan Bayu Sulaksana</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.2.2/cdn.js"></script>
    <style>
        /* Progress bar animation and design */
        .progress-bar-container {
            width: 100%;
            background-color: #e5e7eb;
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 1rem;
            border-radius: 9999px;
            background-image: linear-gradient(90deg, #3b82f6, #60a5fa);
            animation: fillProgress 2s ease forwards;
            background-size: 200% 100%;
        }

        .progress-bar::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-image: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.2) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0.2) 75%,
                    transparent 75%,
                    transparent);
            background-size: 1rem 1rem;
            animation: stripe 1s linear infinite;
        }

        @keyframes fillProgress {
            from {
                width: 0;
            }

            to {
                width: var(--progress-width);
            }
        }

        @keyframes stripe {
            from {
                background-position: 1rem 0;
            }

            to {
                background-position: 0 0;
            }
        }

      /* Loading Spinner */
      .loading {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f4f6;
            border-top: 4px solid #4caf50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Lightbox Styling */
        .lightbox-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .lightbox-img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
            opacity: 0;
            transition: opacity 0.5s ease; /* Fade-in effect */
        }
        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
        }

        /* Spinner Styling */
        .spinner-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2000;
        }

        /* Profile Section Animation */
        .profile-content {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .profile-content.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Profile Image Fade-In and Zoom Effect */
        .profile-image {
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .profile-image.visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Zoom effect for profile image hover */
        .profile-image:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="max-w-3xl mx-auto my-8 p-6 bg-white shadow-lg rounded-lg relative">
        <!-- Profile Section -->
        <!-- Profile Section -->
        <div class="max-w-3xl mx-auto my-8 p-6 bg-white shadow-lg rounded-lg relative" id="resume-content">
            <!-- Loading Spinner -->
            <div id="loading" class="flex justify-center items-center h-32">
                <div class="loading"></div>
            </div>

            <!-- Profile Content (Initially hidden until loading is complete) -->
            <div id="profile-content" class="profile-content flex flex-col items-center mb-6">
                <img src="https://via.placeholder.com/200" alt="Profile Photo" class="w-32 h-32 rounded-full shadow-md mb-4 photo-effect profile-image" id="profile-image">
                <h1 class="text-4xl font-semibold text-gray-800">I Wayan Bayu Sulaksana</h1>
                <p class="text-xl text-gray-600">Informatics Student & Full Stack Developer</p>
                <p class="text-gray-500 mt-2">Jl. Raya Ubud No.123, Ubud, Bali, Indonesia</p>
                <p class="text-gray-500">Phone: +62 812 3456 7890 | Email: wayan.bayu@example.com</p>
            </div>

            <!-- Lightbox -->
            <div class="lightbox-overlay" id="lightbox">
                <span class="lightbox-close" id="close-lightbox">✖</span>
                <div class="spinner-container" id="spinner-container">
                    <div class="loading"></div> <!-- Spinner -->
                </div>
                <img src="" id="lightbox-image" class="lightbox-img">
            </div>
        </div>
        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Profile</h2>
            <p class="text-gray-700 mt-2">An Informatics student passionate about web and application development, with
                skills in programming, data analysis, and developing modern technology-based applications. Focused on
                problem-solving and creating efficient, user-friendly applications.</p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Education</h2>
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-gray-800">Bachelor's Degree in Informatics Engineering</h3>
                <p class="text-gray-600">Udayana University, Bali | 2020 - Present</p>
                <p class="text-gray-600">GPA: 3.8/4.0</p>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Skills</h2>
            <div class="mt-4">
                <div class="mb-4">
                    <p class="text-gray-800">HTML</p>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="--progress-width: 90%;"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-gray-800">CSS & Tailwind</p>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="--progress-width: 85%;"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-gray-800">JavaScript</p>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="--progress-width: 88%;"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-gray-800">React & Node.js</p>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="--progress-width: 80%;"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="text-gray-800">Python & Machine Learning</p>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="--progress-width: 70%;"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Organizational Experience</h2>
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-gray-800">Informatics Student Association (HIMATIKA)</h3>
                <p class="text-gray-600">Head of IT Division | 2022 - Present</p>
                <ul class="list-disc list-inside mt-2 text-gray-700">
                    <li>Coordinating the team to manage the organization’s website and membership database.</li>
                    <li>Leading the development of a web-based application for the student activity information system.
                    </li>
                </ul>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Work Experience</h2>
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-gray-800">Web Development Intern</h3>
                <p class="text-gray-600">PT. Techno Solution, Bali | Jan 2023 - Present</p>
                <ul class="list-disc list-inside mt-2 text-gray-700">
                    <li>Participated in the development of a responsive web application using React and Node.js.</li>
                    <li>Collaborated with designers for implementing user-friendly UI.</li>
                </ul>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Projects</h2>
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-gray-800">Personal Portfolio Website</h3>
                <p class="text-gray-600">Created a personal portfolio using HTML, CSS, and JavaScript to showcase
                    projects and skills.</p>
            </div>
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-gray-800">E-commerce Information System (Final Project)</h3>
                <p class="text-gray-600">Built a prototype of an e-commerce platform using the MERN stack, including
                    user authentication, shopping cart, and payment integration features.</p>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Certifications</h2>
            <div class="mt-4">
                <p class="text-gray-800">Google IT Support Professional Certificate</p>
                <p class="text-gray-600">Issued by Google | Completed in 2022</p>
            </div>
            <div class="mt-4">
                <p class="text-gray-800">JavaScript and Web Development Certificate</p>
                <p class="text-gray-600">Issued by Udemy | Completed in 2023</p>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700">Extracurriculars</h2>
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-gray-800">Member of Game Development Club</h3>
                <p class="text-gray-600">Udayana University | 2021 - Present</p>
                <ul class="list-disc list-inside mt-2 text-gray-700">
                    <li>Participated in a project to create simple games using Unity and C#.</li>
                    <li>Improved skills in programming and game design.</li>
                </ul>
            </div>
        </section>

        <footer class="text-center mt-8">
            <p class="text-gray-600">Contact me at:
                <a href="https://www.linkedin.com/in/wayanbayu" class="text-blue-600">LinkedIn</a> |
                <a href="https://github.com/wayanbayu" class="text-blue-600">GitHub</a>
            </p>
            <p class="text-gray-600">© 2024 I Wayan Bayu Sulaksana</p>
        </footer>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.style.width = entry.target.style.getPropertyValue(
                            '--progress-width');
                    }
                });
            }, {
                threshold: 0.2
            });

            document.querySelectorAll(".progress-bar").forEach((bar) => {
                observer.observe(bar);
            });
        });

        // Simulate content loading
        window.onload = function() {
            // Simulating a delay for loading
            setTimeout(function() {
                document.getElementById('loading').style.display = 'none'; // Hide the loading animation
                document.getElementById('profile-content').classList.add('visible'); // Add animation class to show profile content
                document.getElementById('profile-image').classList.add('visible'); // Add animation to show profile image
            }, 1500); // Adjust the delay as needed
        };

        // Lightbox functionality
        const profileImage = document.getElementById('profile-image');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const closeLightbox = document.getElementById('close-lightbox');
        const spinnerContainer = document.getElementById('spinner-container');

        // Open lightbox when image is clicked
        profileImage.addEventListener('click', function() {
            lightbox.style.display = 'flex';
            lightboxImage.src = profileImage.src; // Set the large image source

            // Show the spinner while the image is loading
            spinnerContainer.style.display = 'flex';
            lightboxImage.style.opacity = 0; // Ensure the image is initially invisible

            // Once the image is fully loaded, hide the spinner and show the image with fade-in
            lightboxImage.onload = function() {
                spinnerContainer.style.display = 'none'; // Hide spinner
                lightboxImage.style.opacity = 1; // Fade-in the image
            };
        });

        // Close lightbox when the close button is clicked
        closeLightbox.addEventListener('click', function() {
            lightbox.style.display = 'none';
            lightboxImage.style.opacity = 0; // Fade-out the lightbox image
        });

        // Close lightbox when clicking outside the image
        lightbox.addEventListener('click', function(event) {
            if (event.target === lightbox) {
                lightbox.style.display = 'none';
                lightboxImage.style.opacity = 0; // Fade-out the lightbox image
            }
        });
    </script>
</body>

</html>
