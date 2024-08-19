<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #dddddd;
        }
        .header img {
            max-width: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #333333;
        }
        .content {
            text-align: center;
            padding: 20px 0;
            color: #666666;
        }
        .content p {
            font-size: 18px;
            margin-bottom: 25px;
        }
        .otp-code {
            font-size: 30px;
            font-weight: bold;
            color: #17a2b8;
            margin-bottom: 25px;
            letter-spacing: 4px;
        }
        .content .button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #17a2b8;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dddddd;
            font-size: 14px;
            color: #999999;
        }
        .footer a {
            color: #17a2b8;
            text-decoration: none;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://yourcompanylogo.com/logo.png" alt="Company Logo">
            <h1>Your OTP Code</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>Your OTP code is:</p>
            <div class="otp-code">{{ $otpCode }}</div>
            <p>Please enter this code on the verification page to activate your account.</p>
            <a href="{{ url('/verify') }}" class="button">Verify Now</a>
        </div>
        <div class="footer">
            <p>If you didn't request this code, please <a href="#">contact support</a>.</p>
            <p>&copy; 2024 Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
