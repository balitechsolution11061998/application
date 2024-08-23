<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coding Tutorials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            background-color: #f4f7f8;
            margin: 0;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #007bff, #0056b3);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.75rem;
            transition: color 0.3s;
        }

        .navbar-brand:hover {
            color: #e2e6ea;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-size: 1.1rem;
            margin-left: 1rem;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #d0d0d0;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"%3e%3cpath stroke="rgba(255, 255, 255, 0.8)" stroke-width="2" d="M5 8h20M5 15h20M5 22h20"/%3e%3c/svg%3e');
        }

        /* Opening Message Section */
        .opening-message {
            background-color: #007bff;
            color: #fff;
            padding: 4rem 0;
            text-align: center;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .opening-message h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .opening-message p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .opening-message .btn {
            font-size: 1.1rem;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .opening-message .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Category Filter Section */
        .category-filter {
            margin: 2rem 0;
            text-align: center;
        }

        .category-filter button {
            margin: 0.5rem;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .category-filter button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        /* Search Bar */
        .search-bar {
            margin: 2rem auto;
            text-align: center;
        }

        .search-bar input {
            width: 80%;
            max-width: 500px;
            padding: 0.75rem;
            border-radius: 25px;
            border: 1px solid #007bff;
        }

        /* Tutorials Section */
        #tutorials {
            margin-top: 2rem;
            padding: 2rem 0;
        }

        .tutorial-card {
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .tutorial-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .tutorial-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        .tutorial-card .card-body {
            text-align: center;
        }

        .tutorial-card .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        .tutorial-card .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        /* About Me Section */
        .about-me {
            background-color: #f4f7f8;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }

        .about-me h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .about-me p {
            font-size: 1.25rem;
            color: #6c757d;
        }

        /* Footer Section */
        footer {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 1rem 0;
            text-align: center;
            margin-top: 2rem;
            border-radius: 10px;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .opening-message h1 {
                font-size: 2rem;
            }

            .category-filter button {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }

            .tutorial-card .card-title {
                font-size: 1.25rem;
            }

            .search-bar input {
                width: 90%;
            }

            .about-me h2 {
                font-size: 1.5rem;
            }
        }

        .about-me {
            padding: 60px 0;
            background: linear-gradient(135deg, #5c6bc0, #8e99f3);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .about-me .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s ease-out forwards;
        }

        .about-me h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #fff;
            position: relative;
            z-index: 2;
        }

        .about-me p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #f5f5f5;
            position: relative;
            z-index: 2;
        }

        .about-me::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
            transform: rotate(45deg);
            z-index: 1;
            animation: rotate 15s linear infinite;
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

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .category-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .category-filter .btn {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .category-filter .btn i {
            margin-right: 8px;
            font-size: 18px;
        }

        .category-filter .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .category-filter .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .category-filter .btn-outline-primary {
            background-color: transparent;
            border-color: #007bff;
            color: #007bff;
        }

        .category-filter .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .about-me {
            font-family: 'Roboto', sans-serif;
            color: #333;
            padding: 60px 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .about-me h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        .about-me p {
            font-size: 18px;
            line-height: 1.6;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-me {
            font-family: 'Roboto', sans-serif;
            color: #333;
            padding: 60px 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: center;
        }

        .about-text {
            animation: fadeInLeft 1s ease-out forwards;
        }

        .about-image {
            animation: fadeInRight 1s ease-out forwards;
        }

        .about-image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .about-me h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 20px;
        }

        .about-me p {
            font-size: 18px;
            line-height: 1.6;
        }

        @keyframes fadeInLeft {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            0% {
                opacity: 0;
                transform: translateX(20px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Scroll Animation Trigger */
        .scroll-reveal {
            opacity: 1;
            transform: translateY(0);
        }

        /* Pagination Container */
        .pagination {
            margin-top: 20px;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            color: #007bff;
            border-radius: 50px;
            border: 2px solid #007bff;
            padding: 10px 15px;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .page-link:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            color: #ccc;
            border-color: #ccc;
        }

        .page-link i {
            font-size: 18px;
        }

        /* Spinner Container */
        .spinner-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.3em;
            border-color: #007bff transparent transparent transparent;
            animation: spin 1s linear infinite;
        }

        /* Animation for Data Loading */
        .tutorial-card-wrapper {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .tutorial-card-wrapper.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Spinner Animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Utility Classes */
        .d-none {
            display: none !important;
        }

        /* Spinner Container */
        .spinner-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.3em;
            border-color: #007bff transparent transparent transparent;
            animation: spin 1s linear infinite;
        }

        /* Animation for Data Loading */
        .tutorial-card-wrapper {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .tutorial-card-wrapper.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            padding-left: 0;
            list-style: none;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-link {
            border-radius: 50%;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            transition: background-color 0.3s;
        }

        .page-link:hover {
            background-color: #0056b3;
        }

        .page-item.disabled .page-link {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }

        .page-item.active .page-link {
            background-color: #0056b3;
            color: #fff;
        }

        /* Spinner Animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Utility Classes */
        .d-none {
            display: none !important;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding-left: 0;
            list-style: none;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-link {
            border-radius: 50%;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            transition: background-color 0.3s;
        }

        .page-link:hover {
            background-color: #0056b3;
        }

        .page-item.disabled .page-link {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }

        .page-item.active .page-link {
            background-color: #0056b3;
            color: #fff;
        }

        /* Spinner Styles */
        .spinner-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.5rem;
        }

        /* Card Styles */
        .tutorial-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tutorial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .btn-action {
            background-color: #007bff;
            color: white;
            border-radius: 50px;
            padding: 0.5rem 1rem;
            text-align: center;
            font-size: 0.875rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-action:hover {
            background-color: #0056b3;
            text-decoration: none;
            transform: scale(1.05);
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 1rem;
            border-top: 1px solid #e9ecef;
            text-align: center;
        }

        .category-tags {
            margin-top: 1rem;
        }

        .category-tag {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            color: #fff;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .category-tag:hover {
            transform: scale(1.1);
        }

        .category-html {
            background-color: #ff5722;
            /* HTML */
        }

        .category-css {
            background-color: #ff9800;
            /* CSS */
        }

        .category-js {
            background-color: #03a9f4;
            /* JavaScript */
        }

        .category-python {
            background-color: #4caf50;
            /* Python */
        }

        .category-php {
            background-color: #9c27b0;
            /* PHP */
        }

        .category-advanced {
            background-color: #673ab7;
            /* Advanced Programming */
        }

        .tutorial-card-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .tutorial-card {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
        }

        .tutorial-card .card-img-top {
            object-fit: cover;
            height: 200px;
            /* Atur tinggi gambar agar seragam */
            width: 100%;
        }

        .tutorial-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .tutorial-card .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .tutorial-card .card-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Batas maksimal 3 baris */
            -webkit-box-orient: vertical;
            white-space: normal;
        }

        .tutorial-card .category-tags {
            margin-top: 0.5rem;
        }

        .tutorial-card .card-footer {
            margin-top: auto;
            text-align: center;
        }

        .dropdown-menu {
            min-width: 250px;
            border-radius: 8px;
            overflow: hidden;
            padding: 0;
        }

        .dropdown-header {
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        .dropdown-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .dropdown-header h6 {
            margin: 0;
        }

        .dropdown-item {
            padding: 10px 20px;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .navbar {
            z-index: 1000;
            /* Ensure the navbar is above other content */
        }

        /* Navbar styling */
        .navbar {
            background-color: #343a40;
            /* Dark background */
            border-bottom: 1px solid #6c757d;
            /* Border for visual separation */
        }

        .navbar-brand {
            font-weight: bold;
            /* Emphasize brand name */
            font-size: 1.5rem;
            /* Larger font size for the brand */
        }

        .nav-link {
            color: #f8f9fa !important;
            /* Light color for text */
            transition: color 0.3s ease;
            /* Smooth color transition */
            font-size: 1rem;
            /* Default font size */
        }

        .nav-link:hover {
            color: #adb5bd !important;
            /* Change color on hover */
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            border-radius: 0.375rem;
            /* Rounded corners */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            /* Shadow for depth */
        }

        .dropdown-item {
            transition: background-color 0.3s ease;
            /* Smooth background transition */
        }

        .dropdown-item:hover {
            background-color: #e9ecef;
            /* Light gray background on hover */
        }

        /* Avatar styling */
        .dropdown-header img {
            border: 2px solid #ffffff;
            /* Border around avatar */
            margin-right: 10px;
        }

        /* Responsive font sizes */
        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1.25rem;
                /* Slightly smaller on medium screens */
            }

            .nav-link {
                font-size: 0.9rem;
                /* Slightly smaller on medium screens */
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.125rem;
                /* Smaller on small screens */
            }

            .nav-link {
                font-size: 0.85rem;
                /* Smaller on small screens */
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem;
                /* Smaller on extra-small screens */
            }

            .nav-link {
                font-size: 0.8rem;
                /* Smaller on extra-small screens */
            }
        }
        .modal-header.bg-primary {
    background-color: #007bff; /* Bootstrap Primary Color */
}

.modal-header .modal-title {
    font-weight: bold;
    font-size: 1.25rem;
}

.modal-body {
    padding: 20px;
}

#modalImage {
    border-radius: 8px;
}

#modalTitle {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
}

#modalDescription {
    font-size: 1rem;
    text-align: center;
}

#modalCategoryTags .category-tag {
    background-color: #f0f0f0;
    color: #333;
    border-radius: 12px;
    padding: 0.25rem 0.5rem;
    margin-right: 5px;
    margin-bottom: 5px;
    display: inline-block;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    padding-top: 15px;
    padding-bottom: 15px;
}
/* Rounded corners and shadows for modal */
.modal-content {
    border-radius: 1rem; /* Rounded corners */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Soft shadow */
}

/* Gradient background and rounded corners for the modal header */
.modal-header.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3); /* Gradient background */
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
}

/* White close button for contrast */
.modal-header .btn-close-white {
    filter: invert(1); /* Invert to make close button white */
}

/* Styling for the modal image */
#modalImage {
    border-radius: 0.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Soft shadow */
}

/* Responsive and centered modal title */
#modalTitle {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
}

/* Responsive and centered modal description */
#modalDescription {
    font-size: 1rem;
    text-align: center;
}

/* Category tags styling */
#modalCategoryTags .category-tag {
    background-color: #f8f9fa;
    color: #495057;
    border-radius: 2rem;
    padding: 0.5rem 1rem;
    margin: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-block;
    border: 1px solid #dee2e6;
}

/* Modal footer with centered button */
.modal-footer {
    border-top: none;
    padding-top: 15px;
    padding-bottom: 15px;
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
}

/* Rounded button style */
.btn-rounded {
    border-radius: 2rem;
    padding: 0.5rem 1.5rem;
    font-size: 0.875rem;
}
/* Base style for category tags */
.category-tag {
    display: inline-block;
    padding: 0.4rem 1rem; /* Padding to make tags more substantial */
    margin: 0.2rem; /* Space between tags */
    font-size: 0.875rem; /* Slightly smaller font size */
    font-weight: 500; /* Semi-bold text */
    color: #ffffff; /* White text */
    background-color: #007bff; /* Default blue background */
    border-radius: 20px; /* Fully rounded edges */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
    transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effect */
}

/* Specific category colors (example) */
.category-tag.category-html {
    background-color: #e34c26; /* HTML color */
}

.category-tag.category-css {
    background-color: #264de4; /* CSS color */
}

.category-tag.category-js {
    background-color: #f0db4f; /* JavaScript color */
    color: #323330; /* Dark text */
}

/* Hover effect for tags */
.category-tag:hover {
    background-color: #0056b3; /* Darker blue on hover */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Slightly more pronounced shadow */
}

    </style>
</head>

<body>
    <!-- Navbar -->
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark animate__animated animate__fadeIn">
        <div class="container">
            <a class="navbar-brand" href="#">Coding Tutorials</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#"><i class="fas fa-home"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#tutorials"><i
                                class="fas fa-book"></i> Tutorials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#about"><i class="fas fa-user"></i>
                            About Me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link animate__animated animate__fadeIn" href="#contact"><i
                                class="fas fa-envelope"></i> Contact</a>
                    </li>

                    @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle animate__animated animate__fadeIn" href="#"
                                id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn"
                                aria-labelledby="navbarDropdown">
                                <li class="dropdown-header">
                                    <img src="{{ Auth::user()->avatar_url ?? 'https://via.placeholder.com/50' }}"
                                        alt="User Avatar" class="rounded-circle" style="width: 50px; height: 50px;">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <small>{{ Auth::user()->email }}</small>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link animate__animated animate__fadeIn" href="{{ route('login') }}"><i
                                    class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link animate__animated animate__fadeIn" href="{{ route('register') }}"><i
                                    class="fas fa-user-plus"></i> Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>




    <!-- Opening Message Section -->
    <section class="opening-message animate__animated animate__fadeIn">
        <div class="container">
            <h1>Welcome to Coding Tutorials!</h1>
            <p>Explore our curated collection of coding tutorials designed to help you master new skills and advance
                your career.</p>
            <a href="#tutorials" class="btn btn-light">Get Started</a>
        </div>
    </section>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="search-input" placeholder="Search tutorials..." onkeyup="filterTutorials()">
    </div>

    <!-- Category Filter Section -->
    <div class="category-filter">
        <button class="btn btn-primary"><i class="fas fa-list-alt"></i> All</button>
        <button class="btn btn-outline-primary"><i class="fab fa-html5"></i> HTML</button>
        <button class="btn btn-outline-primary"><i class="fab fa-css3-alt"></i> CSS</button>
        <button class="btn btn-outline-primary"><i class="fab fa-js"></i> JavaScript</button>
        <button class="btn btn-outline-primary"><i class="fab fa-python"></i> Python</button>
        <button class="btn btn-outline-primary"><i class="fab fa-php"></i> PHP</button>
        <button class="btn btn-outline-primary"><i class="fab fa-laravel"></i> Laravel</button>
        <button class="btn btn-outline-primary"><i class="fab fa-react"></i> React</button>
        <button class="btn btn-outline-primary"><i class="fab fa-vuejs"></i> Vue.js</button>
    </div>

    <div class="container mt-5">
        <div id="spinner" class="spinner-container">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div id="tutorials-content" class="row d-none">
            <!-- Tutorial cards will be dynamically inserted here -->
        </div>
        <div id="pagination" class="mt-4">
            <!-- Pagination links will be dynamically inserted here -->
        </div>
    </div>



    <!-- About Me Section -->
    <section id="about" class="about-me">
        <div class="container">
            <div class="grid">
                <div class="about-text">
                    <h2>About Me</h2>
                    <p>Hello! I'm a passionate coder and web developer with years of experience in the industry. My
                        mission is
                        to help others learn to code and build a successful career in tech. Through these tutorials, I
                        aim to
                        share my knowledge and insights in a way that's easy to understand and apply.</p>
                </div>
                <div class="about-image">
                    <img src="{{ asset('image/illustration.png') }}" alt="About Me Image">
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="tutorialDetailModal" tabindex="-1" aria-labelledby="tutorialDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                    <h5 class="modal-title" id="tutorialDetailModalLabel">Tutorial Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center">
                        <img id="modalImage" src="" class="img-fluid mb-3 rounded-3 shadow-sm" alt="Tutorial Image" style="max-height: 300px; object-fit: cover;">
                        <h5 id="modalTitle" class="text-primary mb-3"></h5>
                        <p id="modalDescription" class="text-muted"></p>
                    </div>
                    <hr>
                    <div id="modalCategoryTags" class="d-flex flex-wrap justify-content-center mb-3"></div>
                    <div id="modalDetails" class="text-secondary"></div>
                </div>
                <div class="modal-footer justify-content-center rounded-bottom-4">
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Coding Tutorials. All rights reserved.</p>
    </footer>
    <script>
        // Search Functionality
        function filterTutorials() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const tutorials = document.querySelectorAll('.tutorial-card');

            tutorials.forEach(tutorial => {
                const title = tutorial.querySelector('.card-title').textContent.toLowerCase();
                const text = tutorial.querySelector('.card-text').textContent.toLowerCase();

                if (title.includes(searchInput) || text.includes(searchInput)) {
                    tutorial.style.display = 'block';
                } else {
                    tutorial.style.display = 'none';
                }
            });
        }

        function truncateText(text, maxLength) {
            if (text.length > maxLength) {
                return text.substring(0, maxLength) + '...';
            }
            return text;
        }

        function fetchDataTutorial(page = 1) {
            $.ajax({
                url: `/website/data?page=${page}`,
                method: 'GET',
                success: function(response) {
                    $('#spinner').hide();
                    $('#tutorials-content').removeClass('d-none');

                    if (response.data.length === 0) {
                        // Jika tidak ada data
                        $('#tutorials-content').html(`
                    <div class="col-12 text-center">
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">No Tutorials Found</h4>
                            <p>It looks like there are no tutorials available at the moment. Please check back later or <a href="#" class="alert-link">contact support</a> if you need assistance.</p>
                        </div>
                    </div>
                `);
                    } else {
                        // Data ditemukan, buat kartu
                        $('#tutorials-content').html(response.data.map(tutorial => {
                            let categoryTags = JSON.parse(tutorial.category_tags).map(tag =>
                                `<span class="category-tag category-${tag.toLowerCase()}">${tag}</span>`
                            ).join('');

                            let truncatedDescription = truncateText(tutorial.description,
                                100); // Batasi panjang deskripsi
                            // Bagian dalam loop yang membuat kartu
                            return `
    <div class="col-md-4 mb-4 tutorial-card-wrapper">
        <div class="card tutorial-card h-100">
            <img src="${tutorial.image_url}" class="card-img-top" alt="${tutorial.title}">
            <div class="card-body">
                <h5 class="card-title">${tutorial.title}</h5>
                <p class="card-text">${truncateText(tutorial.description, 100)}</p>
                <div class="category-tags">
                    ${categoryTags}
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary btn-explore" onclick="tutorial(${tutorial.id})">Explore</button>
            </div>
        </div>
    </div>
`;

                        }).join(''));

                        // Render pagination links
                        let paginationHtml = response.links.map(link => `
                    <li class="page-item ${link.active ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${link.url ? new URL(link.url).searchParams.get('page') : 1}">
                            ${link.label}
                        </a>
                    </li>
                `).join('');

                        $('#pagination').html(`
                    <nav>
                        <ul class="pagination">
                            ${paginationHtml}
                        </ul>
                    </nav>
                `);
                    }
                },
                error: function() {
                    $('#spinner').hide();
                    $('#tutorials-content').html('<p class="text-danger">Failed to load tutorials.</p>');
                }
            });
        }

        function tutorial(id) {
            // Show the modal
            $('#tutorialDetailModal').modal('show');

            // Show the spinner and clear the modal content
            $('#modalImage').hide();
            $('#modalTitle').text('');
            $('#modalDescription').text('');
            $('#modalCategoryTags').html('');
            $('#modalDetails').html('');
            $('#tutorialDetailModal .modal-body').append(
                '<div id="loading-spinner" class="text-center"><i class="fas fa-spinner fa-spin fa-3x"></i></div>');

            // Fetch tutorial details via AJAX
            $.ajax({
                url: `/website/${id}`, // Adjust the URL to match your route
                method: 'GET',
                success: function(response) {
                    // Hide the spinner
                    $('#loading-spinner').remove();

                    // Update the modal with the fetched data
                    $('#modalImage').attr('src', response.image_url).show();
                    $('#modalTitle').text(response.title);
                    $('#modalDescription').text(response.description);



                    // Handle category tags
                    let categoryTags = JSON.parse(response.category_tags).map(tag =>
                        `<span class="category-tag">${tag}</span>`
                    ).join('');
                    $('#modalCategoryTags').html(categoryTags);


                    // Additional details (if any)
                    $('#modalDetails').html(response.additional_details);
                },
                error: function() {
                    // Hide the spinner
                    $('#loading-spinner').remove();

                    // Show error message
                    $('#modalDetails').html('<p class="text-danger">Failed to load tutorial details.</p>');
                }
            });
        }



        // Fetch initial data



        document.addEventListener('DOMContentLoaded', function() {
            const aboutSection = document.querySelector('.about-me');

            function revealOnScroll() {
                const windowHeight = window.innerHeight;
                const sectionTop = aboutSection.getBoundingClientRect().top;
                const revealPoint = 150;

                if (sectionTop < windowHeight - revealPoint) {
                    aboutSection.classList.add('scroll-reveal');
                }
            }

            window.addEventListener('scroll', revealOnScroll);

            const spinner = document.getElementById('spinner');
            const content = document.getElementById('tutorials-content');

            // Function to simulate data loading
            function loadData() {
                // Show spinner
                spinner.classList.remove('d-none');
                content.classList.add('d-none');

                // Simulate a delay for data loading
                setTimeout(() => {
                    // Hide spinner
                    spinner.classList.add('d-none');
                    content.classList.remove('d-none');

                    // Animate data display
                    document.querySelectorAll('.tutorial-card-wrapper').forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('show');
                        }, index * 100); // Staggered animation
                    });
                }, 2000); // Adjust the delay as needed
            }


            // Initial data loading
            loadData();
            fetchDataTutorial();

            // Handle pagination link clicks
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                fetchDataTutorial(page);
            });



        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7503392728334197"
    crossorigin="anonymous"></script>
</body>

</html>
