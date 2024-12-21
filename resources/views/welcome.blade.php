@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<style>
    /* Add this CSS to your styles */
    body {
        background-color: #f0f4f8; /* Light background color for the body */
        font-family: 'Arial', sans-serif; /* Change to a clean font */
    }

    .card {
        background-color: #ffffff; /* White background for the card */
        border-radius: 15px; /* Rounded corners */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        transition: transform 0.3s; /* Smooth hover effect */
    }

    .card:hover {
        transform: translateY(-5px); /* Lift effect on hover */
    }

    .card-title {
        color: #343a40; /* Dark text color for the title */
        font-size: 2.5rem; /* Increase font size */
        font-weight: bold; /* Bold title */
    }

    .card-text {
        color: #6c757d; /* Gray text color for the paragraph */
        font-size: 1.2rem; /* Increase font size */
        margin-bottom: 20px; /* Space below the text */
    }

    .btn-primary {
        background-color: #007bff; /* Bootstrap primary color */
        border-color: #007bff; /* Match border color */
        padding: 10px 20px; /* Increase padding for a larger button */
        font-size: 1.1rem; /* Slightly larger font size */
        border-radius: 25px; /* Rounded button */
        transition: background-color 0.3s; /* Smooth transition */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Darker shade on hover */
        border-color: #0056b3; /* Match border color on hover */
    }

    .welcome-image {
        max-width: 100%; /* Ensure the image is responsive */
        overflow: hidden; /* Hide overflow */
        display: flex; /* Use flexbox for centering */
        justify-content: center; /* Center the image */
        align-items: center; /* Center the image vertically */
    }

    .welcome-image img {
        max-width: 100%; /* Ensure the image is responsive */
        height: auto; /* Maintain aspect ratio */
        border-radius: 15px; /* Match card corners */
        width: auto; /* Allow width to adjust automatically */
        max-height: 400px; /* Set a maximum height for the image */
    }

    .container {
        max-width: 100%; /* Full width container */
    }

    .icon {
        font-size: 3rem; /* Increase icon size */
        color: #007bff; /* Primary color for icons */
    }

    /* Additional styling for the layout */
    .header {
        margin-bottom: 20px; /* Space below the header */
    }
</style>
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10"> <!-- Adjusted column width for more space -->
            <div class="card rounded shadow border-0">
                <div class="card-body text-center">
                    <div class="header">
                        <i class="fas fa-warehouse icon mb-3"></i> <!-- Font Awesome icon -->
                        <h1 class="card-title">Welcome to Portal Supplier</h1>
                        <p class="card-text">(Supplier Management System) PT. Global Retailindo Pratama</p>
                    </div>
                    <div class="welcome-image mb-4">
                        <img src="{{ asset('img/background/portalsupplier.png') }}" alt="Welcome Image" class="img-fluid rounded" />
                    </div>
                    <a href="#" class="btn btn-primary btn-lg"><i class="fas fa-arrow-right"></i> Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
