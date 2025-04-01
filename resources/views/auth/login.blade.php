<!DOCTYPE html>
<html lang="en" class="transition-colors duration-500">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <meta name="google-adsense-account" content="ca-pub-7503392728334197">

    <!-- Preconnect to CDNs -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('assets/css/toastr/toastr.css')}}">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            transition: background-color 0.5s ease;
        }

        .light-mode {
            background: linear-gradient(135deg, #f0f4ff, #e6ebff);
        }

        .dark-mode {
            background: linear-gradient(135deg, #1a202c, #2d3748);
        }

        .welcome-section {
            transition: background-color 0.5s ease;
        }

        .welcome-section.light-mode {
            background-color: transparent;
            /* No background for welcome section in light mode */
            color: black;
            /* Black text in light mode */
        }

        .welcome-section.dark-mode {
            background-color: #2d3748;
            /* Dark background for welcome section */
            color: white;
            /* White text in dark mode */
        }

        .login-form {
            transition: background-color 0.5s ease, box-shadow 0.5s ease;
        }

        .login-form.light-mode {
            background-color: #ffffff;
            /* Light background for login form */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .login-form.dark-mode {
            background-color: #2d3748;
            /* Dark background for login form */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.3);
        }

        .rounded-l-xl {
            border-top-left-radius: 1rem;
            border-bottom-left-radius: 1rem;
        }

        .rounded-r-xl {
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .transition-transform {
            transition: transform 0.3s ease-in-out;
        }

        .transform {
            transform: scale(1);
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        /* For the modal scrollable content */
        .max-h-96 {
            max-height: 24rem;
        }

        /* For the modal transition */
        .modal-transition {
            transition: all 0.3s ease-out;
        }
        @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
.hover\:animate-pulse:hover {
    animation: pulse 1.5s infinite;
}
    </style>

</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100 transition-colors duration-500 light-mode">

    <div class="grid grid-cols-1 md:grid-cols-2 w-full max-w-4xl mx-auto animate__animated animate__fadeInUp">
        <!-- Kolom Kiri: Gambar Ponsel -->
        <div
            class="hidden md:flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-l-xl overflow-hidden shadow-lg transition-transform transform hover:scale-105">
            <img src="{{ asset('img/background/supplier.png') }}" alt="Phone Image" class="w-3/4 md:w-2/3">
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div
            class="login-form light-mode shadow-2xl rounded-r-xl p-8 dark:bg-gray-800 transition-colors duration-500 hover:shadow-2xl">
            <!-- Dark/Light Mode Toggle -->
            <div class="welcome-section light-mode" id="welcomeSection">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Welcome Back</h1>
                    <button id="themeToggle"
                        class="focus:outline-none text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-500">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </div>

            <div class="text-center mb-6">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" class="w-20 mx-auto rounded-full">
            </div>

            <p class="text-center text-gray-500 mb-6 dark:text-gray-400">Login to your account</p>

            <form method="POST" action="{{ route('login.prosesForm') }}" id="loginForm">
                @csrf

                <div class="mb-5">
                    <label for="login" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email or
                        Username</label>
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input id="login" type="text" name="login" value="{{ old('login') }}"
                            class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            placeholder="Enter your username or email" required autofocus>
                        @error('login')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            placeholder="Enter your password">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400"></i>
                        </button>
                        @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember"
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Remember
                        Me</label>
                </div>
                <div class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center mb-4">
                        <input
                            type="checkbox"
                            name="terms"
                            id="terms"
                            class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all duration-200 ease-in-out cursor-pointer"
                            required>
                        <label
                            for="terms"
                            class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer select-none hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-200">
                            I agree to the
                            <a
                                href="#"
                                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500 font-semibold underline underline-offset-2 transition-colors duration-200"
                                id="showTerms">
                                Terms and Conditions
                            </a>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <button type="submit" id="loginButton"
                        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300 ease-in-out">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>

                <!-- Google Login Button -->
                <div class="mb-4">
                    <a href="{{ route('google.login') }}"
                        class="w-full flex items-center justify-center bg-red-600 text-white font-semibold py-2 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-300 ease-in-out">
                        <i class="fab fa-google mr-2"></i> Login with Google
                    </a>
                </div>

                @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Forgot
                        Your Password?</a>
                </div>
                @endif

                @if (Route::has('register'))
                <div class="text-center mt-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Don't have an account?</span>
                    <a href="{{ route('register') }}"
                        class="text-blue-600 hover:text-blue-700 dark :text-blue-400 dark:hover:text-blue-500">Register
                        Here</a>
                </div>
                @endif


            </form>
            <!-- Terms Modal -->

        </div>
    </div>
    <!-- Terms Modal -->
    <div id="termsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">Terms and Conditions</h3>

                <div class="mt-2 px-4 py-2 max-h-96 overflow-y-auto text-sm text-gray-500 dark:text-gray-300">
                    <!-- Your terms content here -->
                    <h4 class="font-bold mb-2">1. Acceptance of Terms</h4>
                    <p class="mb-4">By accessing this website, you agree to be bound by these Terms and Conditions.</p>

                    <h4 class="font-bold mb-2">2. User Responsibilities</h4>
                    <p class="mb-4">You agree not to use the service for any unlawful purpose or in any way that might harm the service.</p>

                    <h4 class="font-bold mb-2">3. Privacy Policy</h4>
                    <p class="mb-4">Your data will be handled according to our Privacy Policy.</p>

                    <h4 class="font-bold mb-2">4. Changes to Terms</h4>
                    <p>We may modify these terms at any time without notice.</p>
                </div>

                <div class="items-center px-4 py-3">
                    <button id="acceptTerms"
                        class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        I Accept
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Update your handleLogin function to include form validation
        function handleLogin() {
            // Get form values
            const login = $('#login').val().trim();

            const password = $('#password').val().trim();
            const termsChecked = $('#terms').is(':checked');

            // Validate form fields
            if (!login) {
                toastr.error("Please enter your email or username", "Error");
                $('#login').focus();
                return;
            }

            if (!password) {
                toastr.error("Please enter your password", "Error");
                $('#password').focus();
                return;
            }

            if (!termsChecked) {
                toastr.error("You must accept the Terms and Conditions to proceed", "Error");
                return;
            }

            // Show loading indicator
            Swal.fire({
                title: 'Logging in...',
                html: '<i class="fas fa-spinner fa-spin"></i> Please wait while we log you in.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit via AJAX
            $.ajax({
                url: $('#loginForm').attr('action'),
                type: 'POST',
                data: $('#loginForm').serialize(),
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        toastr.success(response.message, "Success");
                        window.location.href = response.redirect;
                    } else {
                        toastr.error(response.message || "Login failed", "Error");
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    if (xhr.status === 401) {
                        toastr.error("Invalid username, email, or password.", "Error");
                    } else if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            toastr.error(errors[field][0], "Error");
                        }
                    } else if (xhr.status === 500) {
                        toastr.error("Server error. Please try again later.", "Error");
                    } else {
                        toastr.error("An unexpected error occurred.", "Error");
                    }
                    console.error(xhr); // For debugging
                }
            });
        }

        // Trigger login on button click
        $('#loginButton').on('click', function(e) {
            e.preventDefault();
            handleLogin();
        });

        // Trigger login on Enter key press
        $('#loginForm').on('keypress', function(e) {
            if (e.which === 13) { // 13 is the Enter key
                e.preventDefault(); // Prevent the default form submission
                handleLogin();
            }
        });

        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const welcomeSection = document.getElementById('welcomeSection');
        const loginForm = document.querySelector('.login-form');

        // Load theme from local storage
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            html.classList.add('dark');
            document.body.classList.remove('light-mode');
            document.body.classList.add('dark-mode');
            welcomeSection.classList.remove('light-mode');
            welcomeSection.classList.add('dark-mode');
            loginForm.classList.remove('light-mode');
            loginForm.classList.add('dark-mode');
            themeToggle.querySelector('i').classList.remove('fa-moon');
            themeToggle.querySelector('i').classList.add('fa-sun');
        } else {
            document.body.classList.add('light-mode');
            welcomeSection.classList.add('light-mode');
            welcomeSection.classList.remove('dark-mode');
            loginForm.classList.add('light-mode');
            loginForm.classList.remove('dark-mode');
        }

        themeToggle.addEventListener('click', () => {
            const isDarkMode = html.classList.toggle('dark');
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
            // Change background class based on theme
            if (isDarkMode) {
                document.body.classList.remove('light-mode');
                document.body.classList.add('dark-mode');
                welcomeSection.classList.remove('light-mode');
                welcomeSection.classList.add('dark-mode');
                loginForm.classList.remove('light-mode');
                loginForm.classList.add('dark-mode');
                themeToggle.querySelector('i').classList.remove('fa-moon');
                themeToggle.querySelector('i').classList.add('fa-sun');
            } else {
                document.body.classList.remove('dark-mode');
                document.body.classList.add('light-mode');
                welcomeSection.classList.remove('dark-mode');
                welcomeSection.classList.add('light-mode');
                loginForm.classList.remove('dark-mode');
                loginForm.classList.add('light-mode');
                themeToggle.querySelector('i').classList.remove('fa-sun');
                themeToggle.querySelector('i').classList.add('fa-moon');
            }
        });
        // Add this to your script section
        document.getElementById('showTerms').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Terms and Conditions',
                html: `
            <div class="text-left">
                <h3 class="font-bold mb-2">1. Acceptance of Terms</h3>
                <p class="mb-4">By accessing this website, you agree to be bound by these Terms and Conditions.</p>
                
                <h3 class="font-bold mb-2">2. User Responsibilities</h3>
                <p class="mb-4">You agree not to use the service for any unlawful purpose or in any way that might harm the service.</p>
                
                <h3 class="font-bold mb-2">3. Privacy Policy</h3>
                <p class="mb-4">Your data will be handled according to our Privacy Policy.</p>
                
                <h3 class="font-bold mb-2">4. Changes to Terms</h3>
                <p>We may modify these terms at any time without notice.</p>
            </div>
        `,
                confirmButtonText: 'I Understand',
                width: '800px'
            });
        });
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7503392728334197"
        crossorigin="anonymous"></script>
</body>

</html>