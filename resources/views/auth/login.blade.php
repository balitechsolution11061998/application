<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('image/logo.png') }}">
    <title>Bayu Sulaksana System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha384-B4gt1jrGC7Jh4AgG1I10pVwxElp34I1LwztIMJxkmTZUt/6x5YFFK3sDd54mE1bA" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

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
            border-radius: 50%;
            overflow: hidden;
            width: 350px;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .rounded-image {
            border-radius: 50%;
            width: 80%;
            height: 80%;
            object-fit: cover;
            position: absolute;
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
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="rounded-image-container left-box-content">
                    <img src="{{ asset('image/sistem_information.png') }}" class="rounded-image">
                </div>
                {{-- <small class="text-white text-wrap text-center text-animate" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">
                    Sistem Informasi Ujian Online Madrasah Aliyah Al Furqan
                </small> --}}
            </div>

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4 spacing">
                        <h2>Hello Again</h2>
                        <p>We are happy to have you back.</p>
                        <p class="fs-5">Welcome to our system</p>
                    </div>
                    <form method="POST" action="{{ route('formlogin.check_login') }}" id="sign_in_form">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Please Insert NIP Or NIS" name="username" id="username" required>
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" name="password" id="password" required>
                        </div>
                        {{-- <div class="g-recaptcha" data-sitekey="6LdVDSAqAAAAABHtK30oRyrlBLabcghRCeLoY_py" data-action="LOGIN"></div> --}}
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-action="LOGIN"></div>
                        <div class="input-group mb-3">
                            <input type="submit" class="submit btn btn-lg btn-primary w-100 fs-6" value="LOGIN">
                        </div>
                    </form>
                    <div class="input-group mb-3">
                        <a href="{{ route('google.login') }}" class="btn btn-danger w-100 fs-6">
                            <i class="fab fa-google me-2"></i> Sign in with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script>
$(document).ready(function() {
    $("#sign_in_form").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        var username = $("#username").val();
        var password = $("#password").val();
        var token = $("meta[name='csrf-token']").attr("content");

        // Check if APP_DEBUG is true (this can be passed to your view from the backend)
        var appDebug = "{{ config('app.debug') }}";

        var recaptchaResponse = appDebug == '1' ? "debug-bypass" : grecaptcha.getResponse(); // Bypass reCAPTCHA in debug mode

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
                                document.querySelector('.toastify').innerHTML = `
                                    <div style="display: flex; align-items: center;">
                                        <i class="fas fa-exclamation-circle" style="font-size: 20px; margin-right: 10px;"></i>
                                        <span>${response.message}</span>
                                    </div>`;
                            }
                        }).showToast();
                    }
                },
                error: function(xhr, status, error) {
                    Toastify({
                        text: error,
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
                                    <span>${error}</span>
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
