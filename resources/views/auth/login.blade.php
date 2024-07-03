<!DOCTYPE html>
<html>
<head>
	<title>Application All</title>
	<!-- Site favicon -->
	<link rel="shortcut icon" href="{{ asset('login/images/favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700" rel="stylesheet">
	<!-- Icon Font -->
	<link rel="stylesheet" href="{{ asset('login/fonts/ionicons/css/ionicons.css') }}">
	<!-- Text Font -->
	<link rel="stylesheet" href="{{ asset('login/fonts/font.css') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('login/css/bootstrap.css') }}">
	<!-- Normal style CSS -->
	<link rel="stylesheet" href="{{ asset('login/css/style.css') }}">
	<!-- Normal media CSS -->
	<link rel="stylesheet" href="{{ asset('login/css/media.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">
</head>
<body>


	<main class="cd-main">
		<section class="cd-section index visible ">
			<div class="cd-content style1">
				<div class="login-box d-md-flex align-items-center">
					<h1 class="title">Good Morning</h1>
					<h3 class="subtitle">Have a great journey ahead!</h3>
					<div class="login-form-box">
						<div class="login-form-slider">
							<!-- login slide start -->
							<div class="login-slide slide login-style1">
                                <form method="POST" action="{{ route('login.check_login') }}"
                                id="sign_in_form">
                                @csrf
									<div class="form-group">
										<label class="label">User name</label>
										<input type="text" class="form-control bg-dark text-light"
                                                            name="username" id="username" placeholder="test ..."
                                                            required>
									</div>
									<div class="form-group">
										<label class="label">Password</label>
                                        <input type="password" class="form-control bg-dark text-light"
                                                            name="password" id="password" placeholder="12345"
                                                            required>
									</div>
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="customCheck1">
											<label class="custom-control-label" for="customCheck1">Remember me</label>
										</div>
									</div>
									<div class="form-group">
										<input type="submit" class="submit" value="Sign In">
									</div>
								</form>
								<div class="sign-up-txt">
									Don't have an account? <a href="javascript:;" class="sign-up-click">Sign Up</a>
								</div>
								<div class="forgot-txt">
									<a href="javascript:;" class="forgot-password-click">Forgot Password</a>
								</div>
								<div class="login-with">
									<h3>Login with social</h3>
									<ul class="social-login-btn">
										<li class="facebook-btn"><a href="#"><i class="ion-social-facebook"></i></a></li>
										<li class="twitter-btn"><a href="#"><i class="ion-social-twitter"></i></a></li>
										<li class="google-btn"><a href="#"><img src="images/google.svg"></a></li>
									</ul>
								</div>
							</div>
							<!-- login slide end -->
							<!-- signup slide start -->
							<div class="signup-slide slide login-style1">
								<div class="d-flex height-100-percentage">
									<div class="align-self-center width-100-percentage">
										<form>
											<div class="form-group">
												<label class="label">Name</label>
												<input type="text" class="form-control">
											</div>
											<div class="form-group">
												<label class="label">Email</label>
												<input type="email" class="form-control">
											</div>
											<div class="form-group">
												<label class="label">Password</label>
												<input type="password" class="form-control">
											</div>
											<div class="form-group">
												<label class="label">Confirm Password</label>
												<input type="password" class="form-control">
											</div>
											<div class="form-group padding-top-15px">
												<input type="submit" class="submit" value="Sign Up">
											</div>
										</form>
										<div class="sign-up-txt">
											if you have an account? <a href="javascript:;" class="login-click">login</a>
										</div>
									</div>
								</div>
							</div>
							<!-- signup slide end -->
							<!-- forgot password slide start -->
							<div class="forgot-password-slide slide login-style1">
								<div class="d-flex height-100-percentage">
									<div class="align-self-center width-100-percentage">
										<form>
											<div class="form-group">
												<label class="label">Enter your email address to reset your password</label>
												<input type="email" class="form-control">
											</div>
											<div class="form-group">
												<input type="submit" class="submit" value="Submit">
											</div>
										</form>
										<div class="sign-up-txt">
											if you remember your password? <a href="javascript:;" class="login-click">login</a>
										</div>
									</div>
								</div>
							</div>
							<!-- forgot password slide end -->
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<div id="cd-loading-bar" data-scale="1"></div>
	<!-- JS File -->
	<script src="js/modernizr.js"></script>
	<script type="text/javascript" src="{{ asset('login/js/jquery.js')}}"></script>
	<script type="text/javascript" src="{{ asset('login/js/popper.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('login/js/bootstrap.js')}}"></script>
	<script src="{{ asset('login/js/velocity.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('login/js/script.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>


    <script>
        @if (session('toast'))
            toastr.{{ session('toast.type') }}("{{ session('toast.message') }}", "{{ session('toast.title') }}");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $("#sign_in_form").submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var username = $("#username").val();
                var password = $("#password").val();
                var remember_me = $("#remember_me").val();

                var token = $("meta[name='csrf-token']").attr("content");

                if (username.length == "") {
                    Toastify({
                        text: "Alamat Username Wajib Diisi !",
                        duration: 3000,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        close: true
                    }).showToast();
                } else if (password.length == "") {
                    Toastify({
                        text: "Password Wajib Diisi !",
                        duration: 3000,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        close: true
                    }).showToast();
                } else {
                    $.ajax({
                        url: "{{ route('login.check_login') }}",
                        type: "POST",
                        dataType: "JSON",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': token, // Include CSRF token in request headers
                            'Content-Type': 'application/json' // Set Content-Type to JSON
                        },
                        data: JSON.stringify({
                            "username": username,
                            "password": password,
                        }),
                        success: function(response) {
                            // Check if the login was successful
                            if (response.success) {
                                // Show success message
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                    close: true
                                }).showToast();
                                setTimeout(function() {
                                    window.location.href = "{{ route('home') }}";
                                }, 3000); // Redirect after 3 seconds
                            } else {
                                // Show error message
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                    close: true
                                }).showToast();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error, 'masuk sini');
                            // Show error message
                            Toastify({
                                text: `<strong>Server Error</strong><br>${xhr.responseJSON.message}`,
                                duration: 3000,
                                gravity: "top", // `top` or `bottom`
                                position: "right", // `left`, `center` or `right`
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                close: true,
                                escapeMarkup: false // Allows HTML content in the text
                            }).showToast();
                        }
                    });
                }
            });

        });
    </script>
</body>
</html>
{{-- <!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">

    <style>
        .card {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom styles for dark theme */
        .card-body {
            background-color: #343a40;
            /* Dark background color */
        }

        .form-control {
            background-color: #495057;
            /* Darker background for form controls */
            color: #f8f9fa;
            /* Light text color */
            border: 1px solid #6c757d;
            /* Border color to match dark theme */
        }

        .form-check-input {
            background-color: #495057;
            /* Dark background for checkboxes */
            border-color: #6c757d;
            /* Border color for checkboxes */
        }

        .btn-login {
            background-color: #6c757d;
            /* Darker button background */
            color: #f8f9fa;
            /* Light text color */
        }

        .link-secondary {
            color: #adb5bd;
            /* Lighter link color for better contrast */
        }
    </style>
</head>

<body>
    <section class="bg-light p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">
                    <div class="card border-dark shadow-sm rounded bg-dark text-light">
                        <div class="row g-0">
                            <div class="col-12 col-md-6">
                                <img class="img-fluid rounded-start object-fit-cover" loading="lazy"
                                    src="{{ asset('/image/9085059.jpg') }}" alt="Welcome back you've been missed!"
                                    style="height: 100%">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div class="card-body p-3 p-md-4 p-xl-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-5">
                                                    <div class="text-center mb-4">
                                                        <a href="#!">
                                                            <img src="{{ asset('/image/logo.webp') }}"
                                                                alt="BootstrapBrain Logo" width="175" height="175">
                                                        </a>
                                                    </div>
                                                    <h4 class="text-center">Welcome back you've been missed!</h4>
                                                    <div class="text-center">
                                                        <span class="centered-text">Supplier Management System</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="text-center mt-4 mb-5">Or sign in with</p>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('login.check_login') }}"
                                            id="sign_in_form">
                                            @csrf

                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control bg-dark text-light"
                                                            name="username" id="username" placeholder="test ..."
                                                            required>
                                                        <label for="username" class="form-label">Username</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control bg-dark text-light"
                                                            name="password" id="password" value=""
                                                            placeholder="Password" required>
                                                        <label for="password" class="form-label">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input bg-dark text-light"
                                                            type="checkbox" value="" name="remember_me"
                                                            id="remember_me">
                                                        <label class="form-check-label text-secondary"
                                                            for="remember_me">
                                                            Keep me logged in
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button class="btn btn-light btn-sm btn-login rounded">Log in
                                                            now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                                    <a href="#!" class="link-secondary text-decoration-none">Forgot
                                                        password</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>


    <script>
        @if (session('toast'))
            toastr.{{ session('toast.type') }}("{{ session('toast.message') }}", "{{ session('toast.title') }}");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $("#sign_in_form").submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var username = $("#username").val();
                var password = $("#password").val();
                var remember_me = $("#remember_me").val();

                var token = $("meta[name='csrf-token']").attr("content");

                if (username.length == "") {
                    Toastify({
                        text: "Alamat Username Wajib Diisi !",
                        duration: 3000,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        close: true
                    }).showToast();
                } else if (password.length == "") {
                    Toastify({
                        text: "Password Wajib Diisi !",
                        duration: 3000,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        close: true
                    }).showToast();
                } else {
                    $.ajax({
                        url: "{{ route('login.check_login') }}",
                        type: "POST",
                        dataType: "JSON",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': token, // Include CSRF token in request headers
                            'Content-Type': 'application/json' // Set Content-Type to JSON
                        },
                        data: JSON.stringify({
                            "username": username,
                            "password": password,
                        }),
                        success: function(response) {
                            // Check if the login was successful
                            if (response.success) {
                                // Show success message
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                    close: true
                                }).showToast();
                                setTimeout(function() {
                                    window.location.href = "{{ route('home') }}";
                                }, 3000); // Redirect after 3 seconds
                            } else {
                                // Show error message
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                    close: true
                                }).showToast();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error, 'masuk sini');
                            // Show error message
                            Toastify({
                                text: `<strong>Server Error</strong><br>${xhr.responseJSON.message}`,
                                duration: 3000,
                                gravity: "top", // `top` or `bottom`
                                position: "right", // `left`, `center` or `right`
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                close: true,
                                escapeMarkup: false // Allows HTML content in the text
                            }).showToast();
                        }
                    });
                }
            });

        });
    </script>
</body>

</html> --}}
