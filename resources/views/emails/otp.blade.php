<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .header {
            background-color: #4CAF50; /* Green background */
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px 5px 0 0; /* Rounded top corners */
        }
        h2 {
            color: #333;
            margin: 0; /* Remove default margin */
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            background-color: #4CAF50; /* Green background */
            color: white;
            text-align: center;
            padding: 10px 20px;
            border-radius: 0 0 5px 5px; /* Rounded bottom corners */
            margin-top: 20px; /* Space above footer */
        }
        p {
            margin: 10px 0; /* Add some margin to paragraphs */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Your OTP Code</h2>
        </div>
        <p>🔑 Your OTP is: <span class="otp">{{ $otp }}</span></p>
        <p>It will expire in 5 minutes.</p>
        <div class="footer">
            <p>Thank you for using our service!</p>
        </div>
    </div>
</body>
</html>
