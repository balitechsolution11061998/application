<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koperasi Artha Niaga</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      scroll-behavior: smooth; /* Enable smooth scrolling */
    }

    .navbar {
      background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
      backdrop-filter: blur(10px); /* Optional: adds a blur effect */
      z-index: 1000; /* Ensure navbar is above other elements */
    }

    .navbar-nav .nav-link {
      transition: color 0.3s ease, transform 0.3s ease; /* Transition for color and transform */
    }

    .navbar-nav .nav-link:hover {
      color: #007bff; /* Change color on hover */
      transform: scale(1.1); /* Slightly scale up on hover */
    }

    .hero-section {
      background: linear-gradient(rgba(255, 223, 0, 0.8), rgba(255, 223, 0, 0.8)), url('background-image.jpg') no-repeat center center;
      background-size: cover;
      color: white;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
    }

    .hero-title {
      font-size: 3rem;
      font-weight: bold;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .hero-subtitle {
      font-size: 1.5rem;
      margin-top: 10px;
      color: #f8f9fa;
    }

    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      width: 100px;
    }

    .animated-title {
      animation: fadeInDown 2s;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .content-section {
      padding: 60px 0;
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .footer {
      background-color: #343a40;
      color: white;
      padding: 20px 0;
      text-align: center;
    }

    .footer a {
      color: #f8f9fa;
      margin: 0 10px;
    }

    .footer a:hover {
      color: #ffc107;
    }

    .testimonial {
      background-color: #e9ecef;
      border-radius: 10px;
      padding: 20px;
      margin: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .about-section {
      display: none; /* Initially hidden */
      animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    /* Custom styles for the loan calculation section */
    .loan-calculation-card {
      background-color: #ffffff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .loan-calculation-card h2 {
      margin-bottom: 20px;
      color: #007bff; /* Primary color */
      font-family: 'Montserrat', sans-serif; /* Use Montserrat for headings */
    }

    .result {
      margin-top: 20px;
      padding: 15px;
      border: 1px solid #ced4da;
      border-radius: 10px; /* Rounded corners */
      background-color: #f8f9fa;
      text-align: left; /* Align text to the left */
      animation: fadeIn 0.5s ease-in-out; /* Animation for showing results */
    }

    .input-group-text {
      background-color: #007bff; /* Primary color */
      color: white;
    }

    .btn-primary {
      background-color: #007bff; /* Primary color */
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0056b3; /* Darker shade on hover */
      border-color: #0056b3;
    }

    /* Styles for Contact Us section */
    .contact-card {
      background-color: #e9ecef; /* Light background color */
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      margin-top: 40px;
    }

    .contact-card h2 {
      margin-bottom: 20px;
      color: #007bff; /* Primary color */
      font-family: 'Montserrat', sans-serif; /* Use Montserrat for headings */
    }

    .form-control {
      border-radius: 5px; /* Rounded corners for input fields */
    }

    .btn-left {
      float: left; /* Align button to the left */
    }

    /* Styles for Testimonials Section */
    .testimonial-card {
      background-color: #ffffff; /* White background for testimonials */
      border-radius: 10px;
      padding: 20px;
      margin: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .testimonial-card h5 {
      color: #007bff; /* Primary color */
    }

    /* Back to Top Button */
    #backToTop {
      position: fixed;
      bottom: 20px;
      right: 20px;
      display: none; /* Hidden by default */
      background-color: #007bff; /* Primary color */
      color: white;
      border: none;
      border-radius: 50%;
      padding: 10px 15px;
      font-size: 18px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    #backToTop:hover {
      background-color: #0056b3; /* Darker shade on hover */
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-transparent position-absolute w-100 px-4">
    <div class="container">
      <img src="{{ asset('img/logo/logokoperasi.png') }}" alt="Logo" class="logo">
      <div class="navbar-nav ms-auto">
        <a href="#aboutSection" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
        <a href="#contactSection" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a>
        <a href="#" class="nav-link"><i class="fas fa-home"></i> Home</a>
        <a href="#" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container animated-title">
      <h1 class="hero-title">Koperasi Simpan Pinjam <br> Artha Niaga</h1>
      <h3 class="hero-subtitle">(Primer Nasional)</h3>
      <p class="mt-4">
        BADAN HUKUM: NO. 353/BH/XIV/16/III/2008<br>
        PAD: 305/PAD/DEP.1/X/2018
      </p>
      <p class="mt-4">
        Alamat: Jl. Grecol RT003/002 Kalimanah, Purbalingga
      </p>
    </div>
  </section>

  <!-- About Section -->
  <section id="aboutSection" class="content-section collapse about-section">
    <div class="container text-center">
      <h2>About Us</h2>
      <p class="mt-4">Koperasi Artha Niaga is a cooperative that provides financial services to its members. Our mission is to promote savings and provide loans to help our members achieve their financial goals.</p>
      <p>Founded in 2008, we have been committed to serving our community with integrity and transparency.</p>
      <p>We believe in empowering our members through financial education and support, ensuring that everyone has the opportunity to achieve their financial aspirations.</p>
    </div>
  </section>

  <!-- Loan Calculation Section -->
  <section class="content-section">
    <div class="container text-center">
      <div class="loan-calculation-card">
        <h2><i class="fas fa-calculator"></i> Hitung Pinjaman</h2>
        <form id="loanForm">
          <div class="mb-3">
            <label for="loanAmount" class="form-label">Jumlah Pinjaman (IDR)</label>
            <input type="text" class="form-control" id="loanAmount" required onkeyup="formatCurrency(this)">
          </div>
          <button type="submit" class="btn btn-primary">Hitung</button>
        </form>
        <div id="result" class="result mt-4"></div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="content-section" style="background-color: #f0f4ff;"> <!-- Set a soft background color -->
    <div class="container text-center">
      <h2 class="mb-4" style="font-family: 'Montserrat', sans-serif; color: #007bff;">What Our Members Say</h2>
      <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="max-width: 800px; margin: auto;"> <!-- Set max width and center the carousel -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="testimonial-card card rounded">
              <div class="card-body">
                <blockquote class="blockquote">
                  <p class="mb-0">"Koperasi Artha Niaga has helped me achieve my financial goals!"</p>
                  <footer class="blockquote-footer" style="padding-top: 10px;">John Doe <i class="fas fa-user-friends"></i></footer> <!-- Added padding -->
                </blockquote>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="testimonial-card card rounded">
              <div class="card-body">
                <blockquote class="blockquote">
                  <p class="mb-0">"The loan process was quick and easy!"</p>
                  <footer class="blockquote-footer" style="padding-top: 10px;">Jane Smith <i class="fas fa-user-friends"></i></footer> <!-- Added padding -->
                </blockquote>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="testimonial-card card rounded">
              <div class="card-body">
                <blockquote class="blockquote">
                  <p class="mb-0">"I love the savings plans offered here!"</p>
                  <footer class="blockquote-footer" style="padding-top: 10px;">Alice Johnson <i class="fas fa-user-friends"></i></footer> <!-- Added padding -->
                </blockquote>
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>

  <!-- Contact Us Section -->
  <section id="contactSection" class="content-section">
    <div class="container text-center">
      <div class="contact-card">
        <h2><i class="fas fa-envelope"></i> Contact Us</h2>
        <form>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="name" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input type="email" class="form-control" id="email" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-comment"></i></span>
              <textarea class="form-control" id="message" rows="4" required></textarea>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-left">Send Message</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="content-section">
    <div class="container text-center">
      <h2>Our Services</h2>
      <div class="row mt-4">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Savings</h5>
              <p class="card-text">We offer various savings plans to help you grow your wealth.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Loans</h5>
              <p class="card-text">Flexible loan options to meet your financial needs.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Investment</h5>
              <p class="card-text">Investment opportunities to secure your future.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2024 Koperasi Artha Niaga. All rights reserved.</p>
      <p>Follow us on
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </p>
    </div>
  </footer>

  <!-- Back to Top Button -->
  <button id="backToTop" onclick="scrollToTop()"><i class="fas fa-chevron-up"></i></button>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function formatCurrency(input) {
      // Remove non-numeric characters
      let value = input.value.replace(/[^0-9]/g, '');
      // Format as currency
      const formattedValue = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      }).format(value);
      // Update the input value
      input.value = formattedValue;
    }

    document.getElementById('loanForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form submission
      const loanAmount = parseFloat(document.getElementById('loanAmount').value.replace(/[^0-9]/g, '')); // Get numeric value
      if (!isNaN(loanAmount)) {
        const totalRepayment = loanAmount * 1.2; // 120% of loan amount
        const profit = totalRepayment - loanAmount; // Profit for the cooperative
        const mandatorySavings = loanAmount * 0.05; // 5% of loan amount

        // Format numbers to Indonesian Rupiah
        const formatRupiah = (amount) => {
          return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
          }).format(amount);
        };

        // Display results
        document.getElementById('result').innerHTML = `
          <h4>Hasil Perhitungan:</h4>
          <p>Total Pengembalian: ${formatRupiah(totalRepayment)}</p>
          <p>Keuntungan Koperasi: ${formatRupiah(profit)}</p>
          <p>Tabungan Wajib: ${formatRupiah(mandatorySavings)}</p>
        `;
      } else {
        document.getElementById('result').innerHTML = ''; // Clear results if input is invalid
      }
    });

    // Back to Top Functionality
    window.onscroll = function() {
      const backToTopButton = document.getElementById("backToTop");
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTopButton.style.display = "block"; // Show button
      } else {
        backToTopButton.style.display = "none"; // Hide button
      }
    };

    function scrollToTop() {
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    }
  </script>

  <style>
    /* Back to Top Button */
    #backToTop {
      position: fixed;
      bottom: 20px;
      right: 20px;
      display: none; /* Hidden by default */
      background-color: #007bff; /* Primary color */
      color: white;
      border: none;
      border-radius: 50%;
      padding: 10px 15px;
      font-size: 18px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    #backToTop:hover {
      background-color: #0056b3; /* Darker shade on hover */
    }
  </style>
</body>
</html>
