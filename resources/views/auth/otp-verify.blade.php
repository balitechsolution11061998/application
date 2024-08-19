<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .verification-container {
            max-width: 400px;
            width: 100%;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            z-index: 10;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .verification-container h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #343a40;
            text-align: center;
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .otp-input {
            width: 45px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border-radius: 10px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
            animation: focusEffect 1s ease infinite;
        }

        .otp-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        @keyframes focusEffect {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .otp-inputs input:focus~.otp-input:nth-child(2),
        .otp-inputs input:focus~.otp-input:nth-child(3),
        .otp-inputs input:focus~.otp-input:nth-child(4),
        .otp-inputs input:focus~.otp-input:nth-child(5),
        .otp-inputs input:focus~.otp-input:nth-child(6) {
            animation-delay: 0.2s;
        }

        .verification-container .btn-primary {
            border-radius: 10px;
            height: 50px;
            font-size: 18px;
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .verification-container .btn-primary:hover {
            background-color: #0056b3;
        }

        .verification-container .text-muted {
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }

        .verification-container .text-muted a {
            color: #007bff;
            text-decoration: none;
        }

        .verification-container .text-muted a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body>
    <div class="verification-container">
        <h3>OTP Verification</h3>

        <div class="otp-inputs">
            <input type="text" class="form-control otp-input" maxlength="1" autofocus>
            <input type="text" class="form-control otp-input" maxlength="1">
            <input type="text" class="form-control otp-input" maxlength="1">
            <input type="text" class="form-control otp-input" maxlength="1">
            <input type="text" class="form-control otp-input" maxlength="1">
            <input type="text" class="form-control otp-input" maxlength="1">
        </div>

        <button type="submit" class="btn btn-primary w-100" id="verifyBtn">Verify</button>

        <div class="text-muted mt-3">
            Didn’t receive the OTP? <a href="#">Resend</a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const inputs = document.querySelectorAll('.otp-input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && index > 0 && !e.target.value) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
    <script>
 document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('verifyBtn').addEventListener('click', function(e) {
        e.preventDefault();

        // Assuming the OTP is gathered from the inputs
        let otp = '';
        document.querySelectorAll('.otp-input').forEach(input => otp += input.value);

        if (otp.length !== 6) {
            Toastify({
                text: "Please enter a 6-digit OTP",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                duration: 3000
            }).showToast();
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to verify your OTP!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, verify it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form via AJAX or normal form submission
                fetch('/post/otp-verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        otp_code: otp
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Toastify({
                            text: data.message,
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                            duration: 3000
                        }).showToast();

                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 1500);
                    } else {
                        Toastify({
                            text: data.message,
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                            duration: 3000
                        }).showToast();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toastify({
                        text: "An error occurred, please try again later.",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        duration: 3000
                    }).showToast();
                });
            }
        });
    });
});

    </script>
</body>

</html>
