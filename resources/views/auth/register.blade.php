<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Form with Progress Bars</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-container { padding: 30px; border-radius: 15px; background-color: #fff; transition: transform 0.3s, box-shadow 0.3s; }
        .form-container:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); }
        .form-label-custom { font-weight: bold; color: #495057; }
        .input-group { border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .form-control, .form-select { border-radius: 8px; padding: 10px 15px; font-size: 16px; }
        .form-control:focus, .form-select:focus { border-color: #80bdff; box-shadow: 0 0 8px rgba(128, 189, 255, 0.5); }
        .progress-bar { border-radius: 10px; transition: width 0.3s; }
        .btn-primary { border-radius: 8px; padding: 10px; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
        .btn-primary:hover { background-color: #0056b3; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); }
        .form-image { width: 100%; height: auto; border-radius: 15px; }
        .btn-google { background-color: #db4437; color: white; }
        .btn-google:hover { background-color: #c13527; }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row g-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">

            <!-- Image Column -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('img/logo/m-mart.svg') }}" alt="Registration Image" class="form-image">
            </div>

            <!-- Form Column -->
            <div class="col-md-6 p-4 form-container">
                <h3 class="text-center mb-4">Register</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Username and Name Fields -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label-custom">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                                @error('username')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label-custom">Name</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label-custom">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password and Confirm Password Fields -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label-custom">Password</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required onkeyup="checkPasswordStrength()">
                                <div id="password-feedback" class="invalid-feedback"></div>
                                @error('password')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="progress mt-2">
                                <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small id="passwordHelp" class="form-text text-muted">Password strength will be shown here.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label-custom">Confirm Password</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required onkeyup="checkPasswordMatch()">
                            </div>

                            <div class="progress mt-2">
                                <div id="password-match-bar" class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small id="passwordMatchHelp" class="form-text text-muted">Password match status will be shown here.</small>
                        </div>
                    </div>

                    <!-- Additional Fields -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="whatshapp_no" class="form-label-custom">WhatsApp Number</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input id="whatshapp_no" type="text" class="form-control @error('whatshapp_no') is-invalid @enderror" name="whatshapp_no" value="{{ old('whatshapp_no') }}">
                                @error('whatshapp_no')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="channel_id" class="form-label-custom">Channel ID</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input id="channel_id" type="text" class="form-control @error('channel_id') is-invalid @enderror" name="channel_id" value="{{ old('channel_id') }}">
                                @error('channel_id')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label-custom">Status</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="y" {{ old('status') == 'y' ? 'selected' : '' }}>Active</option>
                                <option value="n" {{ old('status') == 'n' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="all_supplier" class="form-label-custom">All Supplier</label>
                            <select id="all_supplier" name="all_supplier" class="form-select @error('all_supplier') is-invalid @enderror">
                                <option value="y" {{ old('all_supplier') == 'y' ? 'selected' : '' }}>Yes</option>
                                <option value="n" {{ old('all_supplier') == 'n' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('all_supplier')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </div>
                </form>

                <!-- Google Sign-In Button -->
                <div class="text-center mt-4">
                    <a href="{{ route('google.login') }}" class="btn btn-google">
                        <i class="fab fa-google"></i> Sign in with Google
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('password-strength-bar');
            const feedback = document.getElementById('password-feedback');
            let strength = 0;

            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;

            if (strength === 100) {
                strengthBar.className = 'progress-bar bg-success';
                feedback.textContent = 'Strong password';
            } else if (strength >= 75) {
                strengthBar.className = 'progress-bar bg-warning';
                feedback.textContent = 'Medium strength password';
            } else {
                strengthBar.className = 'progress-bar bg-danger';
                feedback.textContent = 'Weak password';
            }

            strengthBar.style.width = `${strength}%`;
            strengthBar.setAttribute('aria-valuenow', strength);
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchBar = document.getElementById('password-match-bar');
            const matchHelp = document.getElementById('passwordMatchHelp');

            if (password === confirmPassword) {
                matchBar.className = 'progress-bar bg-success';
                matchHelp.textContent = 'Passwords match';
                matchBar.style.width = '100%';
                matchBar.setAttribute('aria-valuenow', '100');
            } else {
                matchBar.className = 'progress-bar bg-danger';
                matchHelp.textContent = 'Passwords do not match';
                matchBar.style.width = '0%';
                matchBar.setAttribute('aria-valuenow', '0');
            }
        }
    </script>
</body>
</html>
