<!DOCTYPE html>
<html lang="en">
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

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 transition-colors duration-500">

    <div class="w-full max-w-sm mx-auto animate__animated animate__fadeInUp">
        <div class="bg-white shadow-lg rounded-lg p-6 dark:bg-gray-800 transition-colors duration-500">
            <!-- Dark/Light Mode Toggle -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Welcome Back</h1>
                <button id="themeToggle" class="focus:outline-none">
                    <i class="fas fa-adjust text-gray-600 dark:text-gray-400"></i>
                </button>
            </div>

            <!-- Logo (optional) -->
            <div class="text-center mb-6">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" class="w-20 mx-auto">
            </div>

            <p class="text-center text-gray-500 mb-6 dark:text-gray-400">Please login to your account</p>

            <form method="POST" action="{{ route('login.prosesForm') }}" id="loginForm">
                @csrf

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                               placeholder="Enter your email" required autofocus>
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                               class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('password') border-red-500 @enderror dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                               placeholder="Enter your password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        Remember Me
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>

                <!-- Forgot Password Link -->
                @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        Forgot Your Password?
                    </a>
                </div>
                @endif

                <!-- Registration Link -->
                @if (Route::has('register'))
                <div class="text-center mt-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500">Register Here</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Progress Bar -->
    <div id="progressBar" class="hidden fixed top-0 left-0 right-0 h-1 bg-blue-600 transition-all duration-300"></div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Password toggle visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        themeToggle.addEventListener('click', () => {
            const isDarkMode = body.classList.toggle('dark');
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        });

        // Load theme from local storage
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            body.classList.add('dark');
        }

        // AJAX form submission with fetch API
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            const form = this;
            const progressBar = document.getElementById('progressBar');
            progressBar.classList.remove('hidden');
            progressBar.style.width = '0%';
            progressBar.style.transition = 'none'; // Disable transition for immediate effect

            // Create a FormData object to gather form data
            const formData = new FormData(form);

            // Simulating progress
            let width = 0;
            const interval = setInterval(() => {
                if (width >= 100) {
                    clearInterval(interval);
                    progressBar.style.width = '100%'; // Finalize progress bar

                    // Submit form data via AJAX using fetch()
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, // Include CSRF token
                        },
                        body: formData,
                    })
                    .then(response => response.json()) // Parse response as JSON
                    .then(data => {
                        console.log(data,'data');
                        if (data.success) {
                            Toastify({
                                text: "Login successful! Redirecting...",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: 'center',
                                backgroundColor: "green",
                                stopOnFocus: true,
                            }).showToast();

                            setTimeout(() => {
                                window.location.href = data.redirect || "/home"; // Redirect to the dashboard
                            }, 3000);
                        } else {
                            // If login fails, show error toast with the response message
                            Toastify({
                                text: data.message || "Login failed. Please check your credentials.",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: 'center',
                                backgroundColor: "red",
                                stopOnFocus: true,
                            }).showToast();
                            progressBar.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        // Handle any errors that occur during the fetch
                        console.error('Error:', error);
                        Toastify({
                            text: "An error occurred. Please try again later.",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: 'center',
                            backgroundColor: "red",
                            stopOnFocus: true,
                        }).showToast();
                        progressBar.classList.add('hidden');
                    });
                } else {
                    width += 10;
                    progressBar.style.width = width + '%';
                    progressBar.style.transition = 'width 0.3s';
                }
            }, 300);
        });
    </script>

</body>
</html>
