<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center align text */
        }
        .header {
            background-color: #007bff; /* Header background color */
            padding: 20px;
            border-radius: 8px 8px 0 0;
            color: white;
        }
        .header img {
            max-width: 120px; /* Adjust logo size */
            margin-bottom: 10px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 24px; /* Increased font size */
        }
        h2 {
            color: #555;
            font-size: 20px; /* Subheading style */
            margin: 10px 0;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin: 10px 0; /* Added margin for spacing */
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            color: white;
            background-color: #28a745; /* Green button */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s; /* Smooth transition */
        }
        .button:hover {
            background-color: #218838; /* Darker green on hover */
        }
        @media (max-width: 600px) {
            .container {
                padding: 20px; /* Adjust padding for smaller screens */
            }
            h1 {
                font-size: 22px; /* Responsive font size */
            }
            .button {
                padding: 10px 20px; /* Adjust button size for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://yourlogo.com/logo.png" alt="Company Logo"> <!-- Replace with your logo URL -->
            <h1>Welcome to Supplier Management System</h1>
            <p>(PT. Global Retailindo Pratama)</p>
        </div>
        <h2>Hello, {{ $username }}!</h2>
        <p>You can start sending invoices, bidding on projects, and collaborating with your team today.</p>
        <p><strong>Username:</strong> {{ $username }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>
        <p>Please keep your account information secure.</p>
        <a href="https://yourapp.com/login" class="button">Log In Now</a>
        <div class="footer">
            <p>Thank you for choosing our service!</p>
            <p>– The Team</p>
        </div>
    </div>
</body>
</html>
