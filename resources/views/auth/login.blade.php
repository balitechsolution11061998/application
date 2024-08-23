<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="{{ asset('css/bootstrap.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('css/toastr.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('css/toastify.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('css/font.css') }}" as="style">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">


    <link rel="shortcut icon" href="{{ asset('image/logo.png') }}">
    <title>Bayu Sulaksana System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #ececec;
        }

        .box-area {
            width: 930px;
        }

        .right-box {
            padding: 40px 30px 40px 40px;
        }

        ::placeholder {
            font-size: 16px;
        }

        .rounded-4 {
            border-radius: 20px;
        }

        .rounded-5 {
            border-radius: 30px;
        }

        @media only screen and (max-width: 768px) {
            .box-area {
                margin: 0 10px;
            }

            .left-box {
                height: 100px;
                overflow: hidden;
            }

            .right-box {
                padding: 20px;
            }
        }

        .rounded-image-container {
            border-radius: 10%;
            overflow: hidden;
            width: 100%;
            /* Make container responsive */
            max-width: 350px;
            /* Set a max-width if needed */
            height: auto;
            /* Height should be adjusted according to content */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .rounded-image {
            border-radius: 10%;
            width: 100%;
            height: auto;
            /* Maintain aspect ratio */
            object-fit: cover;
            /* Ensure the image covers the container */
        }

        @media only screen and (max-width: 768px) {
            .rounded-image-container {
                width: 100%;
                /* Full width on mobile */
                max-width: 250px;
                /* Adjust max-width as needed */
                height: auto;
            }

            .rounded-image {
                width: 100%;
                height: auto;
                object-fit: cover;
            }
        }

        @media only screen and (max-width: 768px) {
            .left-box {
                height: auto;
                /* Adjust height on smaller screens */
                padding: 20px;
                /* Adjust padding as needed */
            }
        }

        .left-box-content {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 1.5s forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .spacing {
            margin-bottom: 2rem;
        }

        .text-animate {
            opacity: 0;
            animation: fadeIn 2s forwards, slideUp 1.5s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Custom styles for password strength meter */
        #password-strength {
            height: 5px;
        }

        #password-strength-text {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #103cbe;">
                <div class="rounded-image-container left-box-content">
                    <img
                    src="/image/learning.png"
                    srcset="/image/learning.png 480w, /image/learning.png 768w, /image/learning.png 1024w"
                    sizes="(max-width: 480px) 480px, (max-width: 768px) 768px, 1024px"
                    width="480"
                    height="320"
                    class="rounded-image"
                    alt="Descriptive Image Alt Text">

                </div>
            </div>


            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4 spacing">
                        <h2 id="form-title">Hello Again</h2>
                        <p id="form-subtitle">We are happy to have you back.</p>
                        <p class="fs-5">Welcome to our system</p>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('formlogin.check_login') }}" id="sign_in_form"
                        class="form">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Please Insert NIP Or NIS" name="username" id="username" required>
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password" name="password" id="password" required>
                        </div>
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"
                            data-action="LOGIN"></div>
                        <div class="input-group mb-3">
                            <input type="submit" class="submit btn btn-lg btn-primary w-100 fs-6" value="LOGIN">
                        </div>
                        <div class="input-group mb-3">
                            <a href="{{ route('google.login') }}" class="btn btn-danger w-100 fs-6">
                                <i class="fab fa-google me-2"></i> Sign in with Google
                            </a>
                        </div>
                        <div class="input-group mb-3">
                            <a href="{{ route('github.login') }}" class="btn btn-dark w-100 fs-6">
                                <i class="fab fa-github me-2"></i> Sign in with GitHub
                            </a>
                        </div>
                    </form>


                    <!-- Registration Form (Hidden by default) -->
                    <form method="POST" action="{{ route('formRegister') }}" id="register_form" class="form d-none">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Full Name" name="name" id="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Email Address" name="email" id="email" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Username" name="username" id="reg-username" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password" name="password" id="reg-password" required>
                        </div>
                        <!-- Password Strength Meter -->
                        <div class="progress mb-3" id="password-strength">
                            <div class="progress-bar" role="progressbar"></div>
                        </div>
                        <div id="password-strength-text" class="mb-3 text-muted"></div>
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"
                            data-action="REGISTER"></div>
                        <div class="input-group mb-3">
                            <input type="submit" class="submit btn btn-lg btn-primary w-100 fs-6" value="REGISTER">
                        </div>
                    </form>


                    <!-- Toggle Forms Links -->
                    <div class="input-group mb-3">
                        <button class="btn btn-link w-100 fs-6" id="toggle-register">Don't have an account? Register
                            here</button>
                        <button class="btn btn-link w-100 fs-6 d-none" id="toggle-login">Already have an account?
                            Login
                            here</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Load reCAPTCHA API asynchronously -->
    <script src="{{asset('js/jquery-3.6.0.min.js')}}" crossorigin="anonymous" ></script>



    <!-- Your custom scripts that depend on jQuery -->
    <script src="{{ asset('js/recaptchaapi.js') }}" async defer></script>
    <script src="{{ asset('js/toastr.min.js') }}" defer></script>
    <script src="{{ asset('js/toastify-js.js') }}" defer></script>
    <script>
        document.getElementById('reg-password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('password-strength');
            const strengthText = document.getElementById('password-strength-text');
            const progressBar = strengthMeter.querySelector('.progress-bar');

            let strength = 0;
            if (password.length >= 8) strength += 1; // Length check
            if (/[A-Z]/.test(password)) strength += 1; // Uppercase letter
            if (/[a-z]/.test(password)) strength += 1; // Lowercase letter
            if (/[0-9]/.test(password)) strength += 1; // Number
            if (/[^A-Za-z0-9]/.test(password)) strength += 1; // Special character

            switch (strength) {
                case 1:
                    progressBar.style.width = '20%';
                    progressBar.className = 'progress-bar bg-danger';
                    strengthText.textContent = 'Very Weak';
                    break;
                case 2:
                    progressBar.style.width = '40%';
                    progressBar.className = 'progress-bar bg-warning';
                    strengthText.textContent = 'Weak';
                    break;
                case 3:
                    progressBar.style.width = '60%';
                    progressBar.className = 'progress-bar bg-info';
                    strengthText.textContent = 'Medium';
                    break;
                case 4:
                    progressBar.style.width = '80%';
                    progressBar.className = 'progress-bar bg-primary';
                    strengthText.textContent = 'Strong';
                    break;
                case 5:
                    progressBar.style.width = '100%';
                    progressBar.className = 'progress-bar bg-success';
                    strengthText.textContent = 'Very Strong';
                    break;
                default:
                    progressBar.style.width = '0%';
                    strengthText.textContent = '';
            }
        });

        $(document).ready(function() {
            $("#toggle-register").click(function() {
                $("#sign_in_form").addClass("d-none");
                $("#register_form").removeClass("d-none");
                $("#toggle-register").addClass("d-none");
                $("#toggle-login").removeClass("d-none");
                $("#form-title").text("Register");
                $("#form-subtitle").text("Create your account to get started.");
            });

            $("#toggle-login").click(function() {
                $("#register_form").addClass("d-none");
                $("#sign_in_form").removeClass("d-none");
                $("#toggle-login").addClass("d-none");
                $("#toggle-register").removeClass("d-none");
                $("#form-title").text("Hello Again");
                $("#form-subtitle").text("We are happy to have you back.");
            });
            $("#sign_in_form").submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var username = $("#username").val();
                var password = $("#password").val();
                var token = $("meta[name='csrf-token']").attr("content");

                // Check if APP_DEBUG is true (this can be passed to your view from the backend)
                var appDebug = "{{ config('app.debug') }}";

                var recaptchaResponse = appDebug == '1' ? "debug-bypass" : grecaptcha
                    .getResponse(); // Bypass reCAPTCHA in debug mode

                if (username.length === 0) {
                    Toastify({
                        text: 'Alamat Username Wajib Diisi !',
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        close: true,
                        className: "toastify-error",
                        escapeMarkup: false,
                        onClick: function() {},
                        callback: function() {
                            document.querySelector('.toastify').innerHTML = `
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-exclamation-circle" style="font-size: 20px; margin-right: 10px;"></i>
                            <span>Alamat Username Wajib Diisi !</span>
                        </div>`;
                        }
                    }).showToast();
                } else if (password.length === 0) {
                    Toastify({
                        text: 'Password Wajib Diisi !',
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        close: true,
                        className: "toastify-error",
                        escapeMarkup: false,
                        onClick: function() {},
                        callback: function() {
                            document.querySelector('.toastify').innerHTML = `
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-exclamation-circle" style="font-size: 20px; margin-right: 10px;"></i>
                            <span>Password Wajib Diisi !</span>
                        </div>`;
                        }
                    }).showToast();
                } else if (recaptchaResponse.length === 0 && appDebug != '1') {
                    Toastify({
                        text: 'Please complete the reCAPTCHA!',
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        close: true,
                        className: "toastify-error",
                        escapeMarkup: false,
                        onClick: function() {},
                        callback: function() {
                            document.querySelector('.toastify').innerHTML = `
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-exclamation-circle" style="font-size: 20px; margin-right: 10px;"></i>
                            <span>Please complete the reCAPTCHA!</span>
                        </div>`;
                        }
                    }).showToast();
                } else {
                    $.ajax({
                        url: "{{ route('formlogin.check_login') }}",
                        type: "POST",
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify({
                            "username": username,
                            "password": password,
                            "g-recaptcha-response": recaptchaResponse // Include reCAPTCHA response
                        }),
                        success: function(response) {
                            console.log(response, 'response');
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    window.location.href = '/home';
                                }, 2000);
                            } else {
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                    close: true,
                                    className: "toastify-error",
                                    escapeMarkup: false,
                                    onClick: function() {},
                                    callback: function() {
                                        document.querySelector('.toastify')
                                            .innerHTML = `
                                    <div style="display: flex; align-items: center;">
                                        <i class="fas fa-exclamation-circle" style="font-size: 20px; margin-right: 10px;"></i>
                                        <span>${response.message}</span>
                                    </div>`;
                                    }
                                }).showToast();
                            }
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.status === 401 ? xhr.responseJSON.message :
                                error;
                            Toastify({
                                text: errorMessage,
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                close: true,
                                className: "toastify-error",
                                escapeMarkup: false,
                                onClick: function() {},
                                callback: function() {
                                    document.querySelector('.toastify').innerHTML = `
                                    <div style="display: flex; align-items: center;">
                                        <i class="fas fa-exclamation-circle" style="font-size: 20px; margin-right: 10px;"></i>
                                        <span>${errorMessage}</span>
                                    </div>`;
                                }
                            }).showToast();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
