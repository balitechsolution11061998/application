@extends('layouts.master')
@section('title', 'Supplier Profile')
@section('content')
    <style>
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            /* Use Roboto font */
            background-color: #f4f4f4;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 2rem;
            /* Increased font size for title */
            font-weight: 700;
            /* Bold title */
            color: #333;
            margin-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
            /* Use Montserrat for titles */
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            transition: border-color 0.3s;
            font-size: 1rem;
            /* Font size for input fields */
        }

        .form-control:focus {
            border-color: #09ff00;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn {
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 600;
            /* Bold button text */
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            /* Green color */
        }

        .btn-success:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        .text-danger {
            color: #dc3545;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #09ff00;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .header-card {
            background-color: #09ff00;
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .header-card h2 {
            margin: 0;
            font-size: 2.5rem;
            /* Increased font size for header */
        }

        /* Additional styles for icons */
        .form-group label {
            display: flex;
            align-items: center;
            font-weight: 500;
            /* Medium weight for labels */
        }

        .form-group label i {
            margin-right: 10px;
            /* Space between icon and label */
            color: #09ff00;
            /* Icon color */
        }

        .input-group {
            display: flex;
            align-items: center;
            /* Center align items vertically */
        }

        .input-group .form-control {
            border-radius: 5px 0 0 5px;
            /* Rounded corners for the left side */
            border: 1px solid #ced4da;
            /* Default border color */
        }

        .input-group .input-group-append .btn {
            border-radius: 0 5px 5px 0;
            /* Rounded corners for the right side */
            border: 1px solid #ced4da;
            /* Match the border with the input */
            border-left: none;
            /* Remove left border to connect with input */
        }

        .input-group .input-group-append .btn:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr;
                /* Single column layout on mobile */
            }

            .btn {
                width: 100%;
                /* Full width buttons on mobile */
                margin-top: 10px;
                /* Adjust margin for mobile */
            }
        }

        /* Default label color */
        .form-group label {
            color: #000;
            /* Default color */
        }

        /* Dark mode label color */
        .dark-mode .form-group label {
            color: #000;
            /* Set to black in dark mode */
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 1rem;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group .form-control {
            flex: 1;
            /* Allow the input to take up available space */
        }

        .input-group-append {
            margin-left: 0.5rem;
            /* Space between input and button */
        }

        .btn-success {
            white-space: nowrap;
            /* Prevent button text from wrapping */
        }
        .container {
            max-width: 600px; /* Limit the width of the form */
            margin-top: 50px; /* Add some top margin */
            padding: 20px; /* Add padding */
            background-color: #ffffff; /* White background for the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .card {
            border: none; /* Remove card border */
        }
        .profile-image {
            width: 100px; /* Set a fixed width for the profile image */
            height: auto; /* Maintain aspect ratio */
            border-radius: 50%; /* Make the image circular */
            margin-bottom: 10px; /* Space below the image */
        }
        .btn {
            margin-top: 10px; /* Add some space above buttons */
        }
        .input-group .btn {
            margin-left: 5px; /* Space between input and button */
        }
    </style>

    <div class="container">
        <div class="card p-4">
            <h2 class="card-title text-center mb-4">Profile Settings</h2>
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo/m-mart.svg') }}" alt="Profile Image" class="profile-image">
                <h5>{{ $supplierData->name }}</h5>
                <p class="text-muted">{{ $supplierData->email }}</p>
            </div>
            <form id="profileForm" action="{{ route('users.supplier.updateSupplierProfile', $supplierData->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label"><i class="fas fa-user"></i> Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ $supplierData->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="surname" class="form-label"><i class="fas fa-user-tag"></i> Username</label>
                    <input type="text" class="form-control" id="surname" name="surname"
                        value="{{ $supplierData->username }}" required>
                </div>

                <div class="mb-3">
                    <label for="channel_id" class="form-label"><i class="fas fa-id-badge"></i> Channel ID</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="channel_id" name="channel_id"
                            value="{{ $supplierData->channel_id }}" required>
                        <button type="button" class="btn btn-success" onclick="checkChatId()">
                            <i class="fas fa-check"></i> Check
                        </button>
                    </div>
                </div>

                <h2 class="text-center mb-4">Secure Login</h2>

                <div class="mb-3">
                    <label for="otp" class="form-label"><i class="fas fa-key"></i> OTP</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP">
                        <button type="button" class="btn btn-success" id="sendOtpButton" onclick="sendOtp()">
                            <i class="fas fa-paper-plane"></i> Send OTP
                        </button>
                        <button type="button" class="btn btn-info" id="checkOtpButton" onclick="checkOtp()" disabled>
                            <i class="fas fa-check"></i> Check OTP
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required
                            value="{{ $supplierData->password_show }}" disabled>
                        <button type="button" class="btn btn-success" id="togglePassword"
                            onclick="togglePasswordVisibility()" disabled>
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    <div id="otp-message" class="text-danger mt-2"></div> <!-- Message for OTP timer -->
                </div>

                <div class="mb-3">
                    <label for="whatsapp" class="form-label"><i class="fab fa-whatsapp"></i> WhatsApp Number</label>
                    <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                        value="{{ $supplierData->whatsapp }}" required>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label"><i class="fas fa-phone"></i> Mobile Number</label>
                    <input type="text" class="form-control" id="mobile" name="mobile"
                        value="{{ $supplierData->contact_phone }}" required>
                </div>

                <div class="mb-3">
                    <label for="address1" class="form-label"><i class="fas fa-map-marker-alt"></i> Address Line 1</label>
                    <input type="text" class="form-control" id="address1" name="address1"
                        value="{{ $supplierData->address_1 }}" required>
                </div>

                <div class="mb-3">
                    <label for="address2" class="form-label"><i class="fas fa-map-marker-alt"></i> Address Line 2</label>
                    <input type="text" class="form-control" id="address2" name="address2"
                        value="{{ $supplierData->address_2 }}">
                </div>

                <div class="mb-3">
                    <label for="postcode" class="form-label"><i class="fas fa-code"></i> Postcode</label>
                    <input type="text" class="form-control" id="postcode" name="postcode"
                        value="{{ $supplierData->post_code }}" required>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label"><i class="fas fa-city"></i> City</label>
                    <input type="text" class="form-control" id="city" name="city"
                        value="{{ $supplierData->city }}" required>
                </div>

                <div class="mb-3">
                    <label for="tax_no" class="form-label"><i class="fas fa-map"></i> Tax No</label>
                    <input type="text" class="form-control" id="tax_no" name="tax_no"
                        value="{{ $supplierData->tax_no }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email ID</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ $supplierData->email }}" required>
                </div>



                <div class="mb-3">
                    <label for="country" class="form-label"><i class="fas fa-globe"></i> Country</label>
                    <input type="text" class="form-control" id="country" name="country"
                        value="{{ $supplierData->country }}" required>
                </div>

                <div class="mb-3">
                    <label for="state_region" class="form-label"><i class="fas fa-map-marker-alt"></i>
                        State/Region</label>
                    <input type="text" class="form-control" id="state_region" name="state_region"
                        value="{{ $supplierData->state_region }}" required>
                </div>

                @if (empty($supplierData->channel_id))
                    <!-- Check if channel_id is empty -->
                    <a href="https://t.me/NotificationSupplierBot" class="btn btn-outline-primary" target="_blank">
                        <i class="fab fa-telegram"></i> Chat with Bot
                    </a>
                @endif

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Profile</button>
            </form>


        </div>
    </div>


    <script>
        function checkChatId() {
            // Show loading spinner with SweetAlert and auto-close alert
            Swal.fire({
                title: "Retrieving Chat ID...",
                html: "Tunggu sebentar, sistem akan mendapatkan Chat ID Anda dalam <b></b> detik.", // Updated text
                timer: 2000, // Set the timer for 2000 milliseconds (2 seconds)
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading(); // Show loading spinner
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        // Calculate remaining time in seconds
                        const remainingTime = Math.ceil(Swal.getTimerLeft() /
                            1000); // Convert milliseconds to seconds
                        timer.textContent = remainingTime; // Update the timer text
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval); // Clear the interval when closing
                }
            });

            // Fetch the Chat ID
            fetch('/get-chat-id', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Close the loading spinner
                    Swal.close();

                    if (data.success) {
                        // Show success message with Toastr
                        toastr.success('Chat ID retrieved successfully: ' + data.chat_id);
                        // Set the Channel ID field
                        document.getElementById('channel_id').value = data.chat_id;
                    } else {
                        // Show error message with Toastr
                        toastr.error('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    // Close the loading spinner
                    Swal.close();
                    console.error('Error:', error);
                    // Show error message with Toastr
                    toastr.error('An error occurred while retrieving the chat ID.');
                });
        }
        let passwordVisible = false; // Track if the password is currently visible
        let otpValid = false; // Track if the OTP is valid
        let otpExpirationTime = 60; // OTP expiration time in seconds (1 minute)
        let otpTimer; // Timer for OTP expiration
        let passwordTimer; // Timer for password visibility

        function sendOtp() {
            const channelId = document.getElementById('channel_id').value;

            if (!channelId) {
                toastr.error('Please enter your Channel ID.');
                return;
            }

            // Show loading spinner
            Swal.fire({
                title: "Sending OTP...",
                html: "Please wait while we send the OTP.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send OTP request to the server
            fetch('/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    body: JSON.stringify({
                        channel_id: channelId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close(); // Close the loading spinner

                    if (data.success) {
                        toastr.success('OTP sent successfully! Please check your Telegram.');
                        otpValid = true; // Set OTP as valid
                        startOtpTimer(); // Start the OTP expiration timer
                        document.getElementById('checkOtpButton').disabled = false; // Enable Check OTP button
                        document.getElementById('password').disabled = false; // Enable password input
                    } else {
                        toastr.error('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Error:', error);
                    toastr.error('An error occurred while sending the OTP.');
                });
        }

        function checkOtp() {
            const otpInput = document.getElementById('otp').value;

            if (!otpInput) {
                toastr.error('Please enter the OTP.');
                return;
            }

            // Check if the OTP is valid
            fetch('/check-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    body: JSON.stringify({
                        otp: otpInput
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('OTP is valid! You can now view the password.');
                        otpValid = true; // Set OTP as valid
                        document.getElementById('togglePassword').disabled = false; // Enable toggle button
                        startPasswordTimer(
                            otpExpirationTime); // Start the password visibility timer for the same duration as OTP
                    } else {
                        toastr.error('Invalid OTP. Please try again.');
                        otpValid = false; // Set OTP as invalid
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while checking the OTP.');
                });
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (otpValid) { // Check if OTP is still valid
                if (!passwordVisible) {
                    passwordInput.type = 'text'; // Change to text to show password
                    eyeIcon.classList.remove('fa-eye'); // Change icon to eye-slash
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password'; // Change back to password
                    eyeIcon.classList.remove('fa-eye-slash'); // Change icon back to eye
                    eyeIcon.classList.add('fa-eye');
                }

                passwordVisible = !passwordVisible; // Toggle the visibility state
            } else {
                toastr.error('OTP has expired. Please request a new one.'); // Show error if OTP is not valid
            }
        }

        function startPasswordTimer(duration) {
            let timeLeft = duration;
            const otpMessage = document.getElementById('otp-message');
            otpMessage.textContent = `Password will be visible for ${timeLeft} seconds.`;

            passwordTimer = setInterval(() => {
                timeLeft--;
                otpMessage.textContent = `Password will be visible for ${timeLeft} seconds.`;

                if (timeLeft <= 0) {
                    clearInterval(passwordTimer);
                    // Hide the password and reset the button
                    const passwordInput = document.getElementById('password');
                    const eyeIcon = document.getElementById('eyeIcon');
                    passwordInput.type = 'password'; // Change back to password
                    eyeIcon.classList.remove('fa-eye-slash'); // Change icon back to eye
                    eyeIcon.classList.add('fa-eye');
                    passwordVisible = false; // Reset visibility state
                    otpMessage.textContent = 'Password visibility has expired.'; // Update message
                }
            }, 1000);
        }

        function startOtpTimer() {
            let timeLeft = otpExpirationTime;
            const otpMessage = document.getElementById('otp-message');
            otpMessage.textContent = `OTP will expire in ${timeLeft} seconds.`;

            otpTimer = setInterval(() => {
                timeLeft--;
                otpMessage.textContent = `OTP will expire in ${timeLeft} seconds.`;

                if (timeLeft <= 0) {
                    clearInterval(otpTimer);
                    otpValid = false; // Set OTP as invalid
                    otpMessage.textContent = 'OTP has expired. Please request a new one.';
                    document.getElementById('password').disabled = true; // Disable password input
                    document.getElementById('togglePassword').disabled = true; // Disable toggle button
                    document.getElementById('checkOtpButton').disabled = true; // Disable Check OTP button
                }
            }, 1000);
        }
        $('#profileForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Show loading spinner
            Swal.fire({
                title: "Updating Profile...",
                html: "Please wait while we update your profile.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Gather form data
            var formData = $(this).serialize(); // Serialize the form data

            // Send AJAX request
            $.ajax({
                url: $(this).attr('action'), // Get the form action URL
                type: 'POST', // Use POST method
                data: formData, // Send the serialized form data
                success: function(response) {
                    Swal.close(); // Close the loading spinner
                    if (response.success) {
                        toastr.success(response.message); // Show success message
                    } else {
                        toastr.error('Error: ' + response.message); // Show error message
                    }
                },
                error: function(xhr) {
                    Swal.close(); // Close the loading spinner
                    var errors = xhr.responseJSON.errors; // Get validation errors
                    if (errors) {
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); // Show each error message
                        });
                    } else {
                        toastr.error('An error occurred while updating the profile.'); // General error message
                    }
                }
            });
        });
    </script>

@endsection
