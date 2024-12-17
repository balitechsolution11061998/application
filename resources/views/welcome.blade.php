@extends('layouts.master')
@section('title', 'Supplier Dashboard')
@section('content')

<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    :root {
        --background-color: #121212; /* Dark background for dark mode */
        --card-background-color: #1e1e1e; /* Darker card background */
        --text-color: #ffffff; /* White text for dark mode */
        --card-text-color: #ffffff; /* White text for card content */
    }

    /* Light mode colors */
    @media (prefers-color-scheme: light) {
        :root {
            --background-color: #f8f9fa; /* Light background for light mode */
            --card-background-color: #ffffff; /* White card background */
            --text-color: #000000; /* Black text for light mode */
            --card-text-color: #000000; /* Black text for card content */
        }
    }

    body {
        background-color: var(--background-color); /* Use the background color variable */
        color: var(--text-color); /* Use the text color variable */
    }
    .card {
        background-color: var(--card-background-color); /* Use the card background color variable */
        border: none; /* Remove card border */
        transition: transform 0.2s, box-shadow 0.2s; /* Smooth transition for hover effects */
    }
    .card:hover {
        transform: scale(1.05); /* Scale effect on hover */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Shadow effect on hover */
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--card-text-color); /* Use the card text color variable */
    }
    .card-text {
        font-size: 1.2rem; /* Adjusted font size for better readability */
        color: var(--card-text-color); /* Use the card text color variable */
    }
    .icon {
        position: absolute;
        bottom: 10px;
        right: 10px;
        opacity: 0.3; /* Subtle icon visibility */
        color: var(--card-text-color); /* Use the card text color variable */
    }
    .supplier-profile {
        background-color: var(--card-background-color); /* Use the card background color variable */
        border: none; /* Remove border */
        padding: 20px; /* Add padding for better spacing */
        border-radius: 10px; /* Rounded corners */
    }
    .profile-header {
        font-size: 2rem; /* Larger font size for the header */
        font-weight: bold;
        margin-bottom: 20px; /* Space below the header */
    }
    .profile-info {
        margin-bottom: 10px; /* Space between info items */
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-4" style="color: var(--text-color);">Supplier Dashboard</h1>
    <div class="row">
        <!-- Purchase Orders Card -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body position-relative">
                    <h5 class="card-title">Purchase Orders</h5>
                    <h2 class="card-text">{{ $purchaseOrdersCount }}</h2>
                    <i class="fas fa-shopping-cart fa-3x icon"></i>
                </div>
            </div>
        </div>

        <!-- Receiving Card -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body position-relative">
                    <h5 class="card-title">Receiving</h5>
                    <h2 class="card-text">{{ $receivingCount }}</h2>
                    <i class="fas fa-box fa-3x icon"></i>
                </div>
            </div>
        </div>

        <!-- Returns Card -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body position-relative">
                    <h5 class="card-title">Returns</h5>
                    <h2 class="card-text">{{ $returnsCount }}</h2>
                    <i class="fas fa-undo fa-3x icon"></i>
                </div>
            </div>
        </div>

        <!-- Tanda Terima Card -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body position-relative">
                    <h5 class="card-title">Tanda Terima</h5>
                    <h2 class="card-text">{{ $tandaTerimaCount }}</h2>
                    <i class="fas fa-receipt fa-3x icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplier Profile Section -->
    <div class="card mt-4 supplier-profile">
        <div class="card-body">
            <h5 class="profile-header">Supplier Profile</h5>
            <p class="profile-info"><strong>Name:</strong> {{ $supplier->name }}</p>
            <p class="profile-info"><strong>Email:</strong> {{ $supplier->email }}</p>
            <p class="profile-info"><strong>Phone:</strong> {{ $supplier->phone ? $supplier->phone : 'N/A' }}</p>
            <p class="profile-info"><strong>Address:</strong> {{ $supplier->address }}</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
