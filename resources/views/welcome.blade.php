<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV of I Wayan Bayu Sulaksana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .profile-image {
            transition: transform 0.3s ease;
            border: 4px solid #3b82f6; /* Blue border */
        }

        .profile-image:hover {
            transform: scale(1.1);
        }

        .progress {
            height: 1.5rem;
            border-radius: 9999px;
        }

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

        .section-title {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #3b82f6;
        }

        .project-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .project-card:hover {
            transform: translateY(-5px);
        }

        footer {
            background-color: #f1f1f1;
            padding: 20px 0;
            border-radius: 0 0 15px 15px;
        }

        .btn-custom {
            background-color: #3b82f6;
            color: white;
        }

        .btn-custom:hover {
            background-color: #2563eb;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="card shadow-lg">
            <!-- Loading Spinner -->
            <div id="loading" class="d-flex justify-content-center align-items-center" style="height: 200px;">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- Profile Content (Initially hidden until loading is complete) -->
            <div id="profile-content" class="profile-content text-center mb-4 opacity-0" style="transition: opacity 0.5s ease;">
                <img src="https://via.placeholder.com/200" alt="Profile Photo" class="profile-image rounded-circle mb-4" id="profile-image">
                <h1 class="display-4">I Wayan Bayu Sulaksana</h1>
                <p class="lead">Informatics Student & Full Stack Developer</p>
                <p class="text-muted">Jl. Raya Ubud No.123, Ubud, Bali, Indonesia</p>
                <p class="text-muted">Phone: +62 812 3456 7890 | Email: wayan.bayu@example.com</p>
            </div>

            <!-- Lightbox -->
            <div class="lightbox-overlay" id="lightbox">
                <span class="lightbox-close" id="close-lightbox">✖</span>
                <img src="" id="lightbox-image" class="lightbox-img">
            </div>

            <div class="card-body">
                <section class="mb-4">
                    <h2 class="h4 section-title">Profile</h2>
                    <p>An Informatics student passionate about web and application development, with skills in programming, data analysis, and developing modern technology-based applications. Focused on problem-solving and creating efficient, user-friendly applications.</p>
                </section>

                <section class="mb-4">
                    <h2 class="h4 section-title">Education</h2>
                    <div>
                        <h5>Bachelor's Degree in Informatics Engineering</h5>
                        <p class="text-muted">Udayana University, Bali | 2020 - Present</p>
                        <p class="text-muted">GPA: 3.8/4.0</p>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="h4 section-title">Skills</h2>
                    <div class="mb-3">
                        <p>HTML</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>CSS & Tailwind</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>JavaScript</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 88%;" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>React & Node.js</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>Python & Machine Learning</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </section>

                <section class="mb-4 bg-light p-3 rounded">
                    <h2 class="h4 section-title">Projects</h2>
                    <div class="mt-3">
                        <div class="d-flex align-items-start mb-3">
                            <img src="https://via.placeholder.com/100" alt="Project 1" class="me-3" style="width: 100px; height: 100px;">
                            <div>
                                <h5>Personal Portfolio Website</h5>
                                <p class="text-muted">Created a personal portfolio using HTML, CSS, and JavaScript to showcase projects and skills.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="https://via.placeholder.com/100" alt="Project 2" class="me-3" style="width: 100px; height: 100px;">
                            <div>
                                <h5>E-commerce Information System</h5>
                                <p class="text-muted">Built a prototype of an e-commerce platform using the MERN stack, including user authentication, shopping cart, and payment integration features.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="https://via.placeholder.com/100" alt="Project 3" class="me-3" style="width: 100px; height: 100px;">
                            <div>
                                <h5>Task Management App</h5>
                                <p class="text-muted">Developed a task management application using React and Firebase for real-time data synchronization.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="https://via.placeholder.com/100" alt="Project 4" class="me-3" style="width: 100px; height: 100px;">
                            <div>
                                <h5>Blog Platform</h5>
                                <p class="text-muted">Created a blogging platform with user authentication, allowing users to create, edit, and delete posts.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="h4 section-title">Certifications</h2>
                    <div class="mt-3">
                        <p class="text-gray-800">Google IT Support Professional Certificate</p>
                        <p class="text-muted">Issued by Google | Completed in 2022</p>
                    </div>
                    <div class="mt-3">
                        <p class="text-gray-800">JavaScript and Web Development Certificate</p>
                        <p class="text-muted">Issued by Udemy | Completed in 2023</p>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="h4 section-title">Extracurriculars</h2>
                    <div class="mt-3">
                        <h5>Member of Game Development Club</h5>
                        <p class="text-muted">Udayana University | 2021 - Present</p>
                        <ul class="list-unstyled">
                            <li>Participated in a project to create simple games using Unity and C#.</li>
                            <li>Improved skills in programming and game design.</li>
                        </ul>
                    </div>
                </section>

                <footer class="text-center mt-4">
                    <p class="text-muted">Contact me at:
                        <a href="mailto:wayan.bayu@example.com" class="text-primary">wayan.bayu@example.com</a>
                    </p>
                    <p class="text-muted">Follow me on social media:</p>
                    <div class="d-flex justify-content-center mt-2">
                        <a href="https://linkedin.com/in/wayanbayusulaksana" class="text-primary me-3">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://github.com/wayanbayu" class="text-dark">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </footer>

                <!-- Login Button -->
                <div class="text-center mt-4">
                    <a href="/login/form" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                </div>
            </div>
        </div>
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
