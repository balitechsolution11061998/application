<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
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
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #28a745; /* Green background color */
            padding: 20px;
            border-radius: 12px 12px 0 0; /* Rounded top corners */
            color: white; /* White text color */
            text-align: center; /* Center align text */
        }
        .header img {
            max-width: 120px; /* Adjust logo size */
            margin-bottom: 10px;
        }
        h1 {
            color: white; /* White text color */
            margin-bottom: 10px;
            font-size: 24px; /* Increased font size */
            font-family: 'Arial', sans-serif; /* Pretty font style */
        }
        .company-name {
            color: white; /* White text color for company name */
            font-size: 18px; /* Font size for company name */
            margin: 5px 0; /* Margin for spacing */
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
            text-align: center; /* Center align footer text */
        }
        .button {
            display: inline-block;
            padding: 10px 20px; /* Adjusted padding for a better look */
            font-size: 16px; /* Font size */
            color: white;
            background-color: #28a745; /* Green button */
            border: none;
            border-radius: 25px; /* Rounded corners */
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s; /* Smooth transition */
            text-align: center; /* Center align button text */
        }
        .button:hover {
            background-color: #218838; /* Darker green on hover */
        }
        .account-info {
            text-align: left; /* Left align account info */
            margin-top: 20px;
        }
        .icon {
            margin-right: 10px; /* Space between icon and text */
            color: #007bff; /* Icon color */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://yourlogo.com/logo.png" alt="Company Logo"> <!-- Replace with your logo URL -->
            <h1>Welcome to Supplier Management System</h1>
            <p class="company-name">(PT. Global Retailindo Pratama)</p> <!-- Set company name to white -->
        </div>
        <h2>Hello, {{ $username }}!</h2>
        <p>You can start sending invoices, bidding on projects, and collaborating with your team today.</p>
        <div class="account-info">
            <p><i class="fas fa-user icon"></i><strong>Username:</strong> {{ $username }}</p>
            <p><i class="fas fa-envelope icon"></i><strong>Email:</strong> {{ $email }}</p>
            <p><i class="fas fa-lock icon"></i><strong>Password:</strong> {{ $password }}</p>
        </div>
        <p>Please keep your account information secure.</p>
        <a href="https://yourapp.com/login" class="button">
            <i class="fas fa-sign-in-alt"></i> Log In Now
        </a>
        <div class="footer">
            <p>Thank you for choosing our service!</p>
            <p>– The Team</p>
        </div>
    </div>
</body>
</html>
