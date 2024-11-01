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
             body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            width: 90%;
            margin: 20px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .form-label-custom {
            font-weight: bold;
            color: #495057;
        }

        .input-group {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus, .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 8px rgba(128, 189, 255, 0.5);
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.3s;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 10px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            transition: background-color 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .form-control, .form-select, .input-group-text {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="form-container shadow-sm">
            <h3 class="text-center mb-4">Register</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label-custom">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label-custom">Name </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label-custom">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label-custom">Role</label>
                        <select id="role" name="role" class="form-select custom-select-box" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label-custom">Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required onkeyup="checkPasswordStrength()">
                            <div id="password-feedback" class="invalid-feedback"></div>
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Strength Bar -->
                        <div class="progress mt-2">
                            <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small id="passwordHelp" class="form-text text-muted">Password strength will be shown here.</small>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label-custom">Confirm Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required onkeyup="checkPasswordMatch()">
                        </div>

                        <!-- Password Match Bar -->
                        <div class="progress mt-2">
                            <div id="password-match-bar" class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small id="passwordMatchHelp" class="form-text text-muted">Password match status will be shown here.</small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
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
                strengthBar.className = 'progress-bar medium';
                feedback.textContent = 'Medium password';
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
