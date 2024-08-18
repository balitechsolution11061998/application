<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wedding Invitation</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Dancing+Script:wght@400&family=Montserrat:wght@500&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Raleway:wght@400;700&family=Roboto:wght@300;400&display=swap">

    <style>
        /* Basic Reset */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Lora', serif;
            background-color: #f0f2f5;
        }

        /* Section Styling */
        #section-cover {
            border-radius: 15px; /* Rounded corners */
            overflow: hidden; /* Ensure content fits within rounded corners */
            background-image: url('https://example.com/your-wedding-image.jpg'); /* Replace with your image URL */
            background-size: cover; /* Cover the entire section */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Prevent repeating the image */
            color: #fff; /* Light text color for contrast */
            padding: 40px;
            margin: 20px auto;
            max-width: 800px;
            text-align: center; /* Center content */
            position: relative;
        }

        /* Overlay to enhance text readability */
        #section-cover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Darker overlay for better contrast */
            z-index: 1;
        }

        /* Content Styling */
        .elementor-widget-wrap {
            position: relative;
            z-index: 2;
        }

        /* Heading Styling */
        .elementor-widget-heading h2 {
            margin: 20px 0;
            color: #fff; /* Light text color for readability on dark background */
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s ease-out forwards;
        }

        /* Main Names Styling */
        .elementor-widget-heading h2.special {
            font-family: 'Dancing Script', cursive;
            font-size: 4rem; /* Larger font size for names */
            font-weight: 400;
        }

        /* 'Special Invitation to' Styling */
        .elementor-widget-heading h2.invitation {
            font-family: 'Montserrat', sans-serif; /* Modern sans-serif font */
            font-size: 2.5rem; /* Adjust size to suit design */
            font-weight: 500; /* Medium weight for a clean look */
            letter-spacing: 1px; /* Slight spacing for elegance */
        }

        /* Button Styling */
        .elementor-widget-button .elementor-button {
            background-color: #007bff; /* Primary button color */
            color: #fff; /* White text color */
            border-radius: 25px; /* Rounded button corners */
            padding: 12px 24px;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-top: 20px; /* Space above button */
        }

        .elementor-widget-button .elementor-button:hover {
            background-color: #0056b3; /* Darker button color on hover */
            transform: scale(1.05); /* Slightly enlarge button on hover */
        }

        /* Animation Keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Section Styling */
#section-cover {
    border-radius: 15px; /* Rounded corners */
    overflow: hidden; /* Ensure content fits within rounded corners */
    background-image: url('https://example.com/your-wedding-image.jpg'); /* Replace with your image URL */
    background-size: cover; /* Cover the entire section */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Prevent repeating the image */
    color: #fff; /* Light text color for contrast */
    padding: 40px;
    margin: 20px auto;
    max-width: 800px;
    text-align: center; /* Center content */
    position: relative;
}

/* Overlay to enhance text readability */
#section-cover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Darker overlay for better contrast */
    z-index: 1;
}

/* Content Styling */
.elementor-widget-wrap {
    position: relative;
    z-index: 2;
}

/* Special Invitation to Styling */
.elementor-widget-heading h2.special-invitation {
    font-family: 'Playfair Display', serif; /* Elegant font for invitations */
    font-size: 2.5rem; /* Size can be adjusted */
    font-weight: 700; /* Bold for emphasis */
    color: #fff; /* Light color for contrast */
    margin: 20px 0;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s ease-out forwards;
}

/* Bayu Sulaksana Styling */
.elementor-widget-heading h2.bayu-sulaksana {
    font-family: 'Raleway', sans-serif; /* Modern and clean font */
    font-size: 3rem; /* Larger size for names */
    font-weight: 700; /* Bold for emphasis */
    color: #fff; /* Light color for contrast */
    margin: 20px 0;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s ease-out forwards;
}

/* Invitation Message Styling */
.elementor-widget-heading h2.invitation-message {
    font-family: 'Roboto', sans-serif; /* Simple and readable font */
    font-size: 1.5rem; /* Adjust size for readability */
    font-weight: 300; /* Light weight for a softer look */
    color: #fff; /* Light color for contrast */
    margin: 20px 0;
    line-height: 1.5; /* Increased line height for readability */
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s ease-out forwards;
}

/* Button Styling */
.elementor-widget-button .elementor-button {
    background-color: #007bff; /* Primary button color */
    color: #fff; /* White text color */
    border-radius: 25px; /* Rounded button corners */
    padding: 12px 24px;
    text-transform: uppercase;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    margin-top: 20px; /* Space above button */
}

.elementor-widget-button .elementor-button:hover {
    background-color: #0056b3; /* Darker button color on hover */
    transform: scale(1.05); /* Slightly enlarge button on hover */
}

/* Animation Keyframes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

    </style>
</head>
<body>
    <section class="elementor-section elementor-top-section elementor-element elementor-element-57ea5949 elementor-section-height-min-height elementor-section-content-middle elementor-section-full_width elementor-section-height-default elementor-section-items-middle cover-show" id="section-cover">
        <div class="elementor-background-overlay"></div>
        <div class="elementor-container elementor-column-gap-no">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5a7f1e70">
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-widget elementor-widget-heading">
                        <div class="elementor-widget-container">
                            <h2 class="elementor-heading-title elementor-size-default special">Kevin &amp; Riani</h2>
                        </div>
                    </div>
                    <div class="elementor-widget elementor-widget-heading">
                        <div class="elementor-widget-container">
                            <h2 class="elementor-heading-title elementor-size-default invitation">Special Invitation to</h2>
                        </div>
                    </div>
                    <div class="elementor-widget elementor-widget-heading">
                        <div class="elementor-widget-container">
                            <h2 class="elementor-heading-title elementor-size-default">Bayu Sulaksana</h2>
                        </div>
                    </div>
                    <div class="elementor-widget elementor-widget-heading">
                        <div class="elementor-widget-container">
                            <h2 class="elementor-heading-title elementor-size-default">Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara pernikahan kami.</h2>
                        </div>
                    </div>
                    <div class="elementor-align-center elementor-widget elementor-widget-button">
                        <div class="elementor-widget-container">
                            <a class="elementor-button elementor-button-link elementor-size-sm" href="#">
                                <span class="elementor-button-content-wrapper">
                                    <span class="elementor-button-text">Buka Undangan</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
