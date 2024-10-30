<!DOCTYPE html>
<html lang="en" class="transition-colors duration-500">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f0f4ff, #e6ebff);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 transition-colors duration-500 dark:bg-gray-900">

    <div class="w-full max-w-sm mx-auto animate__animated animate__fadeInUp">
        <div class="bg-white shadow-2xl rounded-xl p-8 dark:bg-gray-800 transition-colors duration-500">
            <!-- Dark/Light Mode Toggle -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Welcome Back</h1>
                <button id="themeToggle" class="focus:outline-none text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-500">
                    <i class="fas fa-moon"></i>
                </button>
            </div>

            <div class="text-center mb-6">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" class="w-20 mx-auto rounded-full">
            </div>

            <p class="text-center text-gray-500 mb-6 dark:text-gray-400">Login to your account</p>

            <form method="POST" action="{{ route('login.prosesForm') }}" id="loginForm">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                               placeholder="Enter your email" required autofocus>
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                               class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                               placeholder="Enter your password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
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
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Remember Me
                    </label>
                </div>

                <div class="mb-4">
                    <button type="button" id="loginButton" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>

                @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        Forgot Your Password?
                    </a>
                </div>
                @endif

                @if (Route::has('register'))
                <div class="text-center mt-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500">Register Here</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        $('#loginButton').on('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Confirm login attempt",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, login'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('#loginForm').attr('action'),
                            type: 'POST',
                            data: $('#loginForm').serialize(),
                            success: function (response) {
                                Toastify({
                                    text: "Login successful!",
                                    backgroundColor: "green",
                                    className: "info",
                                }).showToast();
                                // Redirect if needed
                                window.location.href = "/home";
                            },
                            error: function () {
                                Toastify({
                                    text: "Login failed! Check your credentials.",
                                    backgroundColor: "red",
                                    className: "info",
                                }).showToast();
                            }
                        });
                    }
                });
            });

        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const isDarkMode = html.classList.toggle('dark');
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        });

        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            html.classList.add('dark');
        }


    </script>
</body>
</html>
