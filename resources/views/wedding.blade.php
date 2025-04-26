<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Undangan Pernikahan Bali - I Made & Ni Luh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    :root {
      --gold: #d4af37;
      --light-gold: #f0e6d2;
      --dark-green: #1a5f3e;
      --light-green: #e8f5e9;
      --cream: #fff9f0;
      --dark-cream: #f5e8d0;
    }
    body {
      background-color: var(--cream);
      font-family: 'Poppins', sans-serif;
      color: #333;
      overflow-x: hidden;
    }
    h1, h2, h3, h4, h5, .display-3 {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
    }
    .script-font {
      font-family: 'Dancing Script', cursive;
    }
    .bali-ornament {
      background: url('https://svgshare.com/i/12R0.svg') center top repeat-x;
      background-size: 120px 40px;
      height: 40px;
      opacity: 0.8;
    }
    .bali-ornament-bottom {
      transform: rotate(180deg);
    }
    .fade-in-up {
      opacity: 0;
      transform: translateY(40px);
      animation: fadeInUp 1s ease-out forwards;
    }
    @keyframes fadeInUp {
      to { opacity: 1; transform: translateY(0);}
    }
    .timeline::before {
      content: "";
      position: absolute;
      left: 50%;
      top: 0;
      bottom: 0;
      width: 4px;
      background: var(--gold);
      transform: translateX(-50%);
    }
    .timeline-item {
      position: relative;
      width: 50%;
      padding: 2rem 1rem;
    }
    .timeline-item.left {
      left: 0;
      text-align: right;
    }
    .timeline-item.right {
      left: 50%;
      text-align: left;
    }
    .timeline-dot {
      position: absolute;
      top: 2rem;
      left: 50%;
      width: 20px;
      height: 20px;
      background: var(--gold);
      border-radius: 50%;
      border: 3px solid var(--cream);
      transform: translateX(-50%);
      z-index: 1;
    }
    .couple-img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      transition: all 0.3s ease;
    }
    .couple-img:hover {
      transform: scale(1.05);
    }
    .floating-petal {
      position: absolute;
      background-size: contain;
      background-repeat: no-repeat;
      opacity: 0.6;
      z-index: 0;
    }
    .card-event {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
      background-color: white;
    }
    .card-event:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .card-event .card-header {
      background-color: var(--gold);
      color: white;
      font-weight: 600;
      border-bottom: none;
    }
    .gallery-img {
      transition: all 0.3s ease;
      cursor: pointer;
      border: 3px solid white;
    }
    .gallery-img:hover {
      transform: scale(1.03);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .btn-gold {
      background-color: var(--gold);
      color: white;
      font-weight: 600;
      border: none;
    }
    .btn-gold:hover {
      background-color: #c9a227;
      color: white;
    }
    .bg-light-gold {
      background-color: var(--light-gold);
    }
    .text-gold {
      color: var(--gold);
    }
    .bg-dark-green {
      background-color: var(--dark-green);
    }
    .text-dark-green {
      color: var(--dark-green);
    }
    .btn-dark-green {
      background-color: var(--dark-green);
      color: white;
    }
    .btn-dark-green:hover {
      background-color: #12402a;
      color: white;
    }
    .btn-outline-dark-green {
      border-color: var(--dark-green);
      color: var(--dark-green);
    }
    .btn-outline-dark-green:hover {
      background-color: var(--dark-green);
      color: white;
    }
    .floral-divider {
      height: 30px;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 30" preserveAspectRatio="none"><path d="M0,15 C20,0 40,30 60,15 C80,0 100,30 120,15 L120,30 L0,30 Z" fill="%23d4af37"/></svg>') center bottom no-repeat;
      background-size: 120px 30px;
      margin: 2rem 0;
    }
    .floating-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: var(--gold);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      z-index: 100;
      animation: pulse 2s infinite;
      border: none;
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    .parallax {
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }
    .hero-text {
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .couple-name {
      font-size: 3.5rem;
      background: linear-gradient(to right, var(--gold), #f5d062);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 1rem;
    }
    .date-badge {
      background-color: rgba(255,255,255,0.2);
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 50px;
      padding: 8px 20px;
      display: inline-block;
    }
    .family-tree {
      position: relative;
      padding: 20px 0;
    }
    .family-tree::before {
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 50%;
      width: 2px;
      background-color: var(--gold);
      transform: translateX(-50%);
    }
    .family-member {
      position: relative;
      margin-bottom: 30px;
    }
    .family-member::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 20px;
      height: 2px;
      background-color: var(--gold);
    }
    .family-member.left::after {
      right: 0;
    }
    .family-member.right::after {
      left: 0;
    }
    .modal-backdrop {
      background-color: rgba(0,0,0,0.8);
    }
    .modal-content {
      background-color: transparent;
      border: none;
    }
    .modal-body img {
      max-height: 80vh;
    }
    .music-control {
      position: fixed;
      bottom: 90px;
      right: 20px;
      background-color: white;
      border-radius: 50px;
      padding: 8px 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      z-index: 99;
      display: flex;
      align-items: center;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.3s ease;
    }
    .music-control.show {
      opacity: 1;
      transform: translateY(0);
    }
    .music-info {
      margin-right: 10px;
      font-size: 12px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 120px;
    }
    .protocol-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }
    .gift-icon {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--gold);
    }
    .language-switcher {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 101;
    }
    .language-btn {
      background-color: rgba(255,255,255,0.8);
      border: none;
      border-radius: 50px;
      padding: 5px 15px;
      font-size: 14px;
      backdrop-filter: blur(5px);
    }
    .save-date {
      background-color: rgba(0,0,0,0.5);
      backdrop-filter: blur(5px);
      padding: 15px;
      border-radius: 10px;
      margin-top: 20px;
    }
    .save-date-btn {
      background-color: var(--gold);
      color: white;
      border: none;
      padding: 8px 20px;
      border-radius: 50px;
      font-size: 14px;
      margin-top: 10px;
    }
    .travel-tips {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .travel-icon {
      font-size: 1.5rem;
      color: var(--gold);
      margin-right: 10px;
    }
    .testimonial-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .testimonial-img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 15px;
    }
    .hashtag {
      color: var(--gold);
      font-weight: bold;
    }
    .floating-petal {
      position: absolute;
      width: 50px;
      height: 50px;
      background-size: contain;
      background-repeat: no-repeat;
      opacity: 0.3;
      z-index: -1;
      animation: float 6s infinite ease-in-out;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(5deg); }
    }
    @media (max-width: 767px) {
      .timeline::before { left: 8px; }
      .timeline-item, .timeline-item.left, .timeline-item.right {
        width: 100%;
        left: 0;
        text-align: left;
        padding-left: 2.5rem;
      }
      .timeline-dot { left: 8px; }
      .couple-img {
        width: 140px;
        height: 140px;
      }
      .couple-name {
        font-size: 2.5rem;
      }
      .family-tree::before {
        left: 20px;
      }
      .family-member::after {
        left: 20px;
      }
      .family-member.left::after,
      .family-member.right::after {
        left: 20px;
      }
      .music-control {
        bottom: 80px;
        right: 10px;
        padding: 5px 10px;
      }
      .music-info {
        max-width: 80px;
        font-size: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- Language Switcher -->
  <div class="language-switcher">
    <button class="language-btn">
      <i class="fas fa-language me-1"></i>ID/EN
    </button>
  </div>

  <!-- Floating Music Button -->
  <div class="floating-btn" id="musicBtn">
    <i class="fas fa-music"></i>
  </div>
  
  <!-- Music Control -->
  <div class="music-control" id="musicControl">
    <div class="music-info" id="musicInfo">Bali Traditional Music</div>
    <button class="btn btn-sm p-0" id="musicToggle">
      <i class="fas fa-play"></i>
    </button>
    <audio id="bgMusic" loop>
      <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>
  </div>

  <!-- Ornamen Bali Atas -->
  <div class="bali-ornament"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-gold" href="#">
        <i class="fas fa-leaf me-2"></i>Made & Luh Wedding
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#couple">Pasangan</a></li>
          <li class="nav-item"><a class="nav-link" href="#event">Acara</a></li>
          <li class="nav-item"><a class="nav-link" href="#location">Lokasi</a></li>
          <li class="nav-item"><a class="nav-link" href="#gallery">Galeri</a></li>
          <li class="nav-item"><a class="nav-link" href="#rsvp">RSVP</a></li>
          <li class="nav-item"><a class="nav-link" href="#guestbook">Ucapan</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <header class="position-relative text-center text-white" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&w=1500&q=80') center/cover no-repeat; min-height: 100vh;">
    <!-- Floating Petals -->
    <div class="floating-petal" style="top: 10%; left: 5%; background-image: url('https://svgshare.com/i/12YF.svg'); animation-delay: 0s;"></div>
    <div class="floating-petal" style="top: 30%; right: 8%; background-image: url('https://svgshare.com/i/12YF.svg'); animation-delay: 1s;"></div>
    <div class="floating-petal" style="bottom: 20%; left: 7%; background-image: url('https://svgshare.com/i/12YF.svg'); animation-delay: 2s;"></div>
    <div class="floating-petal" style="bottom: 15%; right: 10%; background-image: url('https://svgshare.com/i/12YF.svg'); animation-delay: 3s;"></div>
    
    <div class="container position-relative py-5 d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
      <div class="mb-4 fade-in-up">
        <img src="https://svgshare.com/i/12YF.svg" width="80" alt="Bali Ornament">
      </div>
      <h1 class="display-3 fw-bold mb-3 fade-in-up hero-text">Undangan Pernikahan</h1>
      <h2 class="couple-name script-font fade-in-up" style="animation-delay: 0.2s;">Made & Luh</h2>
      <p class="lead fs-2 mb-2 fade-in-up hero-text" style="animation-delay: 0.3s; font-family: 'Playfair Display', serif;">I Made Sudana &amp; Ni Luh Ayu</p>
      <p class="mb-4 fs-5 fade-in-up hero-text" style="animation-delay: 0.4s;"><i class="fas fa-calendar-alt me-2"></i>Sabtu, 17 Mei 2025 | <i class="fas fa-map-marker-alt me-2"></i>Puri Ubud, Bali</p>
      <div id="countdown" class="mb-4 fs-4 fw-bold fade-in-up p-3 bg-dark-green rounded-pill text-white" style="animation-delay: 0.5s;"></div>
      <a href="#rsvp" class="btn btn-gold btn-lg px-5 shadow fade-in-up" style="animation-delay: 0.6s;">
        <i class="fas fa-heart me-2"></i>Konfirmasi Kehadiran
      </a>
      
      <div class="save-date fade-in-up" style="animation-delay: 0.7s;">
        <p class="mb-2">Simpan tanggal kami</p>
        <button class="save-date-btn">
          <i class="fas fa-calendar-plus me-2"></i>Tambahkan ke Kalender
        </button>
      </div>
    </div>
    
    <div class="position-absolute bottom-0 start-0 end-0 text-center pb-3">
      <a href="#couple" class="text-white fs-1 animate__animated animate__bounce animate__infinite" style="display: inline-block;">
        <i class="fas fa-chevron-down"></i>
      </a>
    </div>
  </header>

  <!-- Quotes Bali -->
  <section class="py-5 bg-light-gold">
    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <blockquote class="blockquote fs-4 text-dark-green mb-2 fade-in-up">
            <i class="fas fa-quote-left text-gold me-2"></i>
            Asa ring ajengan, prasida ngidangang rasa tresna sane sujati.
            <i class="fas fa-quote-right text-gold ms-2"></i>
          </blockquote>
          <figcaption class="blockquote-footer text-dark-green fade-in-up">
            Semoga di pelaminan, dapat menghadirkan cinta yang sejati
          </figcaption>
        </div>
      </div>
    </div>
  </section>

  <!-- Couple Section -->
  <section id="couple" class="py-5 bg-white position-relative">
    <div class="floral-divider"></div>
    <div class="container text-center">
      <h2 class="fw-bold mb-4 text-dark-green fade-in-up">Om Swastyastu</h2>
      <p class="text-muted mb-5 fade-in-up" style="max-width: 700px; margin: 0 auto;">
        Dengan memohon rahmat Sang Hyang Widhi Wasa, kami bermaksud menyelenggarakan upacara Manusa Yadnya Pawiwahan 
        (Pernikahan) putra-putri kami. Mohon kehadiran dan doa restu dari Bapak/Ibu/Saudara/i.
      </p>
      
      <div class="row justify-content-center align-items-center my-5">
        <div class="col-12 col-md-4 mb-4 fade-in-up">
          <div class="position-relative d-inline-block">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80" 
                 class="rounded-circle border border-gold border-4 shadow couple-img" alt="I Made">
            <div class="position-absolute top-0 start-100 translate-middle">
              <img src="https://svgshare.com/i/12YF.svg" width="40" alt="Bali Ornament">
            </div>
          </div>
          <h4 class="fw-bold mt-3">I Made Sudana</h4>
          <p class="text-muted">Putra pertama dari</p>
          <p class="text-dark-green">Bapak Ketut Wijaya & Ibu Wayan Sari</p>
          <div class="d-flex justify-content-center gap-3 mt-3">
            <a href="#" class="text-gold"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#" class="text-gold"><i class="fab fa-whatsapp fa-lg"></i></a>
          </div>
        </div>
        
        <div class="col-12 col-md-4 text-center mb-4 fade-in-up" style="animation-delay: 0.3s;">
          <div class="d-inline-block p-3 rounded-circle bg-light-gold">
            <i class="fas fa-heart text-gold" style="font-size: 2.5rem;"></i>
          </div>
          <p class="mt-3 text-gold fw-bold">17 Mei 2025</p>
          <div class="date-badge mt-2">
            <i class="fas fa-calendar-day me-2"></i>Sabtu Wage
          </div>
        </div>
        
        <div class="col-12 col-md-4 mb-4 fade-in-up" style="animation-delay: 0.6s;">
          <div class="position-relative d-inline-block">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80" 
                 class="rounded-circle border border-gold border-4 shadow couple-img" alt="Ni Luh">
            <div class="position-absolute top-0 start-0 translate-middle">
              <img src="https://svgshare.com/i/12YF.svg" width="40" alt="Bali Ornament">
            </div>
          </div>
          <h4 class="fw-bold mt-3">Ni Luh Ayu</h4>
          <p class="text-muted">Putri kedua dari</p>
          <p class="text-dark-green">Bapak Nyoman Artawan & Ibu Kadek Suryani</p>
          <div class="d-flex justify-content-center gap-3 mt-3">
            <a href="#" class="text-gold"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#" class="text-gold"><i class="fab fa-whatsapp fa-lg"></i></a>
          </div>
        </div>
      </div>
      
      <!-- Family Tree -->
      <div class="family-tree mt-5 fade-in-up">
        <h4 class="text-center text-dark-green mb-4">Keluarga Kami</h4>
        <div class="row">
          <div class="col-md-6 text-end family-member left">
            <div class="d-inline-block text-end p-3">
              <h5>Keluarga Made</h5>
              <p class="mb-1">Bapak Ketut Wijaya</p>
              <p class="mb-1">Ibu Wayan Sari</p>
              <p class="mb-1">Adik: Kadek Ari</p>
              <p class="mb-0">Adik: Komang Putu</p>
            </div>
          </div>
          <div class="col-md-6 text-start family-member right">
            <div class="d-inline-block text-start p-3">
              <h5>Keluarga Luh</h5>
              <p class="mb-1">Bapak Nyoman Artawan</p>
              <p class="mb-1">Ibu Kadek Suryani</p>
              <p class="mb-1">Kakak: Wayan Sri</p>
              <p class="mb-0">Adik: Ketut Dewi</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Timeline Love Story -->
  <section class="py-5 bg-light-gold position-relative">
    <div class="container">
      <h3 class="text-center fw-bold text-dark-green mb-5 fade-in-up">Perjalanan Cinta Kami</h3>
      <div class="position-relative timeline">
        <div class="timeline-item left fade-in-up">
          <div class="timeline-dot"></div>
          <h5 class="text-gold">Pertemuan Pertama</h5>
          <p class="text-muted">Juni 2018</p>
          <p>Bertemu pertama kali di Pasar Seni Ubud saat festival seni tahunan. Made sedang memamerkan lukisannya 
            sedangkan Luh adalah pengunjung yang tertarik dengan karyanya.</p>
          <div class="mt-2">
            <img src="https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&w=200&q=80" 
                 class="img-fluid rounded-3" alt="Pertemuan pertama">
          </div>
        </div>
        <div class="timeline-item right fade-in-up" style="animation-delay: 0.2s;">
          <div class="timeline-dot"></div>
          <h5 class="text-gold">Pacaran</h5>
          <p class="text-muted">Januari 2019</p>
          <p>Mulai menjalin hubungan setelah beberapa bulan saling mengenal. Sering menghabiskan waktu bersama 
            menikmati sunset di Tanah Lot dan mencoba berbagai kuliner khas Bali.</p>
          <div class="mt-2">
            <img src="https://images.unsplash.com/photo-1518621736915-f3b1c41bfd00?auto=format&fit=crop&w=200&q=80" 
                 class="img-fluid rounded-3" alt="Momen pacaran">
          </div>
        </div>
        <div class="timeline-item left fade-in-up" style="animation-delay: 0.4s;">
          <div class="timeline-dot"></div>
          <h5 class="text-gold">Lamaran</h5>
          <p class="text-muted">Desember 2023</p>
          <p>Prosesi lamaran adat Bali (Mepamit) dilaksanakan di rumah keluarga Luh dengan upacara Madengen-dengen. 
            Kedua keluarga sepakat untuk menyatukan kami dalam ikatan pernikahan.</p>
          <div class="mt-2">
            <img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=200&q=80" 
                 class="img-fluid rounded-3" alt="Momen lamaran">
          </div>
        </div>
        <div class="timeline-item right fade-in-up" style="animation-delay: 0.6s;">
          <div class="timeline-dot"></div>
          <h5 class="text-gold">Pernikahan</h5>
          <p class="text-muted">Mei 2025</p>
          <p>Akad nikah akan dilaksanakan di Puri Ubud dengan upacara adat Bali lengkap, dilanjutkan dengan 
            resepsi dan pesta pernikahan yang meriah.</p>
          <div class="mt-2">
            <img src="https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=200&q=80" 
                 class="img-fluid rounded-3" alt="Foto prewedding">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Wedding Details -->
  <section id="event" class="py-5 bg-white position-relative">
    <div class="container text-center">
      <h3 class="fw-bold text-dark-green mb-5 fade-in-up">Detail Acara</h3>
      
      <div class="row justify-content-center mb-5">
        <div class="col-md-5 mb-4 fade-in-up">
          <div class="card card-event h-100">
            <div class="card-header py-3">
              <h5 class="mb-0"><i class="fas fa-ring me-2"></i>Akad Nikah & Mesegehagung</h5>
            </div>
            <div class="card-body">
              <p class="card-text">
                <i class="fas fa-calendar-alt text-gold me-2"></i>Sabtu, 17 Mei 2025<br>
                <i class="fas fa-clock text-gold me-2"></i>09.00 - 11.00 WITA<br>
                <i class="fas fa-map-marker-alt text-gold me-2"></i>Puri Ubud, Gianyar, Bali
              </p>
              <hr>
              <p class="text-start">
                Prosesi akad nikah menurut agama Islam dan upacara Mesegehagung (Pernikahan adat Bali) akan dilaksanakan 
                di bale kembang Puri Ubud dengan tata cara adat Bali yang lengkap.
              </p>
              <div class="mt-3">
                <a href="#" class="btn btn-outline-dark btn-sm me-2"><i class="fas fa-map-marked-alt me-1"></i> Peta Lokasi</a>
                <a href="#" class="btn btn-outline-dark btn-sm"><i class="fas fa-car me-1"></i> Petunjuk Jalan</a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-5 mb-4 fade-in-up" style="animation-delay: 0.2s;">
          <div class="card card-event h-100">
            <div class="card-header py-3">
              <h5 class="mb-0"><i class="fas fa-glass-cheers me-2"></i>Resepsi Pernikahan</h5>
            </div>
            <div class="card-body">
              <p class="card-text">
                <i class="fas fa-calendar-alt text-gold me-2"></i>Sabtu, 17 Mei 2025<br>
                <i class="fas fa-clock text-gold me-2"></i>11.00 - 15.00 WITA<br>
                <i class="fas fa-map-marker-alt text-gold me-2"></i>Taman Puri Ubud, Gianyar, Bali
              </p>
              <hr>
              <p class="text-start">
                Resepsi pernikahan akan dilaksanakan di taman Puri Ubud dengan dekorasi bernuansa Bali modern. 
                Akan ada hiburan tari tradisional Bali dan live akustik.
              </p>
              <div class="mt-3">
                <a href="#" class="btn btn-outline-dark btn-sm me-2"><i class="fas fa-utensils me-1"></i> Menu Makanan</a>
                <a href="#" class="btn btn-outline-dark btn-sm"><i class="fas fa-music me-1"></i> Daftar Musik</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row justify-content-center">
        <div class="col-lg-8 fade-in-up" style="animation-delay: 0.4s;">
          <div class="card card-event">
            <div class="card-header py-3">
              <h5 class="mb-0"><i class="fas fa-hotel me-2"></i>Informasi Akomodasi</h5>
            </div>
            <div class="card-body text-start">
              <p>Bagi tamu yang membutuhkan penginapan, kami telah menyiapkan blok kamar khusus dengan harga khusus di beberapa hotel:</p>
              <ul>
                <li><strong>The Ubud Village Hotel</strong> - Diskon 20% dengan kode "MADELUHWEDDING"</li>
                <li><strong>Pertiwi Resort</strong> - Kamar mulai Rp 800.000/malam termasuk sarapan</li>
                <li><strong>Tegal Sari Accommodation</strong> - Hubungi +62 812-3456-7890 (Ibu Komang)</li>
              </ul>
              <p class="mb-0">Transportasi dari hotel ke lokasi acara akan disediakan panitia pada jam tertentu.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Travel Tips -->
  <section class="py-5 bg-light-gold">
    <div class="container">
      <h3 class="text-center fw-bold text-dark-green mb-4 fade-in-up">Tips Perjalanan ke Bali</h3>
      <p class="text-center text-muted mb-5 fade-in-up">Beberapa informasi berguna untuk tamu yang akan datang ke Bali</p>
      
      <div class="row g-4">
        <div class="col-md-6 fade-in-up">
          <div class="travel-tips h-100">
            <h5 class="text-gold"><i class="fas fa-plane travel-icon"></i>Transportasi ke Bali</h5>
            <ul>
              <li>Bandara Internasional Ngurah Rai (DPS) adalah pintu masuk utama ke Bali</li>
              <li>Penerbangan langsung tersedia dari Jakarta, Surabaya, Singapura, Kuala Lumpur, dll</li>
              <li>Dari bandara ke Ubud membutuhkan waktu sekitar 1-1.5 jam dengan mobil</li>
              <li>Kami dapat membantu mengatur transportasi dari bandara untuk tamu</li>
            </ul>
          </div>
        </div>
        
        <div class="col-md-6 fade-in-up" style="animation-delay: 0.2s;">
          <div class="travel-tips h-100">
            <h5 class="text-gold"><i class="fas fa-umbrella-beach travel-icon"></i>Aktivitas di Ubud</h5>
            <ul>
              <li>Kunjungi Monkey Forest, Tegalalang Rice Terrace, dan Goa Gajah</li>
              <li>Coba pengalaman spa tradisional Bali</li>
              <li>Nikmati pertunjukan tari Kecak atau Legong di berbagai venue</li>
              <li>Jelajahi pasar seni Ubud untuk oleh-oleh unik</li>
            </ul>
          </div>
        </div>
        
        <div class="col-md-6 fade-in-up" style="animation-delay: 0.4s;">
          <div class="travel-tips h-100">
            <h5 class="text-gold"><i class="fas fa-tshirt travel-icon"></i>Dress Code</h5>
            <ul>
              <li>Untuk upacara adat: Sarung dan selendang akan disediakan di lokasi</li>
              <li>Untuk resepsi: Semi formal dengan nuansa Bali (batik atau kebaya)</li>
              <li>Warna yang disarankan: Emas, putih, pastel, atau warna alam</li>
              <li>Hindari warna hitam polos karena dianggap kurang sesuai untuk acara bahagia</li>
            </ul>
          </div>
        </div>
        
        <div class="col-md-6 fade-in-up" style="animation-delay: 0.6s;">
          <div class="travel-tips h-100">
            <h5 class="text-gold"><i class="fas fa-info-circle travel-icon"></i>Informasi Penting</h5>
            <ul>
              <li>Mata uang: Rupiah (IDR), banyak tempat menerima kartu kredit</li>
              <li>Bahasa: Bahasa Indonesia dan Inggris cukup umum digunakan</li>
              <li>Listrik: 220V, colokan tipe C/F (sama dengan Eropa)</li>
              <li>Waktu: WITA (UTC+8), sama dengan Jakarta</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
  <section id="location" class="py-5 bg-white">
    <div class="container text-center">
      <h3 class="fw-bold text-dark-green mb-4 fade-in-up">Lokasi Acara</h3>
      <div class="row justify-content-center">
        <div class="col-lg-8 fade-in-up">
          <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.195248350974!2d115.26301431533267!3d-8.50606939388444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd219c4bbf0e7d7%3A0x5030bfbca832c7!2sUbud%2C%20Gianyar%2C%20Bali!5e0!3m2!1sen!2sid!4v1615366769161!5m2!1sen!2sid" 
                    allowfullscreen="" loading="lazy"></iframe>
          </div>
          <div class="mt-4 fade-in-up" style="animation-delay: 0.2s;">
            <a href="https://goo.gl/maps/9j2jQK1nGQK2" target="_blank" class="btn btn-dark-green px-4 me-2">
              <i class="fas fa-map-marked-alt me-2"></i>Lihat di Google Maps
            </a>
            <a href="#" class="btn btn-outline-dark-green px-4">
              <i class="fas fa-directions me-2"></i>Petunjuk Arah
            </a>
          </div>
          <div class="mt-4 fade-in-up" style="animation-delay: 0.4s;">
            <div class="card bg-light-gold shadow-sm p-3 text-start">
              <h5 class="text-gold"><i class="fas fa-info-circle me-2"></i>Informasi Parkir</h5>
              <p class="mb-0">Area parkir tersedia di sebelah timur Puri Ubud. Untuk tamu undangan akan diberikan kartu parkir khusus yang bisa diambil di posko pendaftaran.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery -->
  <section id="gallery" class="py-5 bg-light-gold">
    <div class="container">
      <h3 class="text-center fw-bold text-dark-green mb-4 fade-in-up">Galeri Kami</h3>
      <p class="text-center text-muted mb-5 fade-in-up">Beberapa momen indah dalam perjalanan hubungan kami</p>
      
      <div class="row g-3">
        <div class="col-6 col-md-3 fade-in-up">
          <img src="https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Pertemuan Pertama" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1523438885200-e635ba2c371e?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Pertemuan pertama kami di Pasar Seni Ubud, Juni 2018">
        </div>
        <div class="col-6 col-md-3 fade-in-up" style="animation-delay: 0.1s;">
          <img src="https://images.unsplash.com/photo-1518621736915-f3b1c41bfd00?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Liburan di Nusa Penida" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1518621736915-f3b1c41bfd00?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Liburan bersama di Nusa Penida, Agustus 2019">
        </div>
        <div class="col-6 col-md-3 fade-in-up" style="animation-delay: 0.2s;">
          <img src="https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Foto Prewedding" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Sesi foto prewedding kami di Tegalalang Rice Terrace">
        </div>
        <div class="col-6 col-md-3 fade-in-up" style="animation-delay: 0.3s;">
          <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Sesi Foto Adat" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Sesi foto dengan pakaian adat Bali">
        </div>
        <div class="col-6 col-md-3 fade-in-up" style="animation-delay: 0.4s;">
          <img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Momen Lamaran" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Momen lamaran di rumah keluarga Luh, Desember 2023">
        </div>
        <div class="col-6 col-md-3 fade-in-up" style="animation-delay: 0.5s;">
          <img src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Sesi Foto di Pantai" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Sesi foto di Pantai Pandawa">
        </div>
        <div class="col-6 col-md-3 fade-in-up" style="animation-delay: 0.6s;">
          <img src="https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Foto Keluarga" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1517842645767-c639042777db?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Foto bersama keluarga besar">
        </div>
        <div class="col-6 col-md-3 fade-in-up" style="animation-delay: 0.7s;">
          <img src="https://images.unsplash.com/photo-1518621736915-f3b1c41bfd00?auto=format&fit=crop&w=400&q=80" 
               class="img-fluid rounded-4 shadow-sm gallery-img" alt="Foto di Pura" data-bs-toggle="modal" data-bs-target="#galleryModal" data-bs-img="https://images.unsplash.com/photo-1518621736915-f3b1c41bfd00?auto=format&fit=crop&w=1200&q=80" data-bs-caption="Kunjungan ke Pura Tanah Lot">
        </div>
      </div>
      
      <div class="text-center mt-4 fade-in-up" style="animation-delay: 0.8s;">
        <a href="#" class="btn btn-outline-dark-green">
          <i class="fab fa-instagram me-2"></i>Lihat Lebih Banyak di Instagram Kami
        </a>
      </div>
    </div>
  </section>

  <!-- Gallery Modal -->
  <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header border-0">
          <button type="button" class="btn-close bg-white rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImage" src="" class="img-fluid rounded-3" alt="">
          <p id="modalCaption" class="text-white mt-3"></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Testimonials -->
  <section class="py-5 bg-white">
    <div class="container">
      <h3 class="text-center fw-bold text-dark-green mb-4 fade-in-up">Kata Mereka Tentang Kami</h3>
      <p class="text-center text-muted mb-5 fade-in-up">Apa yang dikatakan teman dan keluarga tentang pasangan kami</p>
      
      <div class="row">
        <div class="col-md-4 fade-in-up">
          <div class="testimonial-card">
            <div class="d-flex align-items-center mb-3">
              <img src="https://randomuser.me/api/portraits/women/45.jpg" class="testimonial-img" alt="Testimoni">
              <div>
                <h6 class="mb-1">Wayan Sri</h6>
                <p class="small text-muted">Kakak Luh</p>
              </div>
            </div>
            <p>"Sejak pertama kali Made datang ke rumah, aku langsung tahu dia orang yang tepat untuk adikku. Sopan, bertanggung jawab, dan sangat mencintai Luh."</p>
          </div>
        </div>
        
        <div class="col-md-4 fade-in-up" style="animation-delay: 0.2s;">
          <div class="testimonial-card">
            <div class="d-flex align-items-center mb-3">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" class="testimonial-img" alt="Testimoni">
              <div>
                <h6 class="mb-1">Ketut Wira</h6>
                <p class="small text-muted">Teman Made</p>
              </div>
            </div>
            <p>"Made dan Luh adalah pasangan yang sangat cocok. Mereka saling melengkapi - Made yang kreatif dan Luh yang terorganisir. Selamat untuk kalian berdua!"</p>
          </div>
        </div>
        
        <div class="col-md-4 fade-in-up" style="animation-delay: 0.4s;">
          <div class="testimonial-card">
            <div class="d-flex align-items-center mb-3">
              <img src="https://randomuser.me/api/portraits/women/65.jpg" class="testimonial-img" alt="Testimoni">
              <div>
                <h6 class="mb-1">Kadek Sri</h6>
                <p class="small text-muted">Sahabat Luh</p>
              </div>
            </div>
            <p>"Aku sudah melihat dari awal bagaimana hubungan mereka berkembang. Cinta mereka tulus dan penuh pengertian. Semoga langgeng sampai tua!"</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Protokol Kesehatan -->
  <section class="py-5 bg-dark-green text-white">
    <div class="container text-center">
      <h3 class="fw-bold mb-4 fade-in-up">Protokol Kesehatan</h3>
      <p class="mb-5 fade-in-up">Demi kenyamanan dan keamanan bersama, kami menerapkan protokol kesehatan selama acara berlangsung.</p>
      
      <div class="row justify-content-center">
        <div class="col-6 col-md-3 mb-4 fade-in-up">
          <div class="p-3 bg-white rounded-4 text-dark-green h-100">
            <div class="protocol-icon">😷</div>
            <h5>Pakai Masker</h5>
            <p class="small">Wajib menggunakan masker selama di lokasi acara</p>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-4 fade-in-up" style="animation-delay: 0.2s;">
          <div class="p-3 bg-white rounded-4 text-dark-green h-100">
            <div class="protocol-icon">🧴</div>
            <h5>Hand Sanitizer</h5>
            <p class="small">Tersedia hand sanitizer di berbagai titik</p>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-4 fade-in-up" style="animation-delay: 0.4s;">
          <div class="p-3 bg-white rounded-4 text-dark-green h-100">
            <div class="protocol-icon">↔️</div>
            <h5>Jaga Jarak</h5>
            <p class="small">Tempat duduk diatur dengan jarak aman</p>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-4 fade-in-up" style="animation-delay: 0.6s;">
          <div class="p-3 bg-white rounded-4 text-dark-green h-100">
            <div class="protocol-icon">🌡️</div>
            <h5>Cek Suhu</h5>
            <p class="small">Pengecekan suhu tubuh di pintu masuk</p>
          </div>
        </div>
      </div>
      
      <div class="mt-4 fade-in-up" style="animation-delay: 0.8s;">
        <div class="alert alert-warning d-inline-flex align-items-center">
          <i class="fas fa-info-circle me-2 fs-4"></i>
          <div>
            Bagi tamu yang sedang tidak sehat, mohon beristirahat di rumah. Kami akan mengirimkan video rekaman acara.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gift Section -->
  <section class="py-5 bg-light-gold">
    <div class="container text-center">
      <h3 class="fw-bold text-dark-green mb-4 fade-in-up">Hadiah Pernikahan</h3>
      <p class="mb-4 fade-in-up">Doa dan restu Anda sudah menjadi hadiah terindah bagi kami. Namun jika Anda ingin memberikan hadiah, berikut beberapa pilihan:</p>
      
      <div class="row justify-content-center">
        <div class="col-md-4 mb-4 fade-in-up">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="gift-icon">
                <i class="fas fa-gift"></i>
              </div>
              <h5>Kirim Hadiah Fisik</h5>
              <p>Alamat pengiriman hadiah:</p>
              <p class="fw-bold">Rumah Orang Tua Made<br>Jl. Raya Ubud No. 123<br>Gianyar, Bali 80571</p>
              <p>Kontak: Ibu Wayan (0812-3456-7890)</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4 fade-in-up" style="animation-delay: 0.2s;">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="gift-icon">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <h5>Transfer Digital</h5>
              <p>Jika lebih memilih hadiah dalam bentuk uang:</p>
              <div class="text-start">
                <p class="mb-1"><strong>BCA</strong> 123 456 7890<br>a.n. I Made Sudana</p>
                <p class="mb-1"><strong>Mandiri</strong> 987 654 3210<br>a.n. Ni Luh Ayu</p>
                <p class="mb-0"><strong>DANA/OVO</strong> 0812-3456-7890<br>a.n. I Made Sudana</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4 fade-in-up" style="animation-delay: 0.4s;">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="gift-icon">
                <i class="fas fa-hands-helping"></i>
              </div>
              <h5>Donasi Amal</h5>
              <p>Kami juga membuka opsi donasi untuk:</p>
              <ul class="text-start">
                <li>Panti Asuhan Dharma Laksana, Gianyar</li>
                <li>Yayasan Peduli Kanker Bali</li>
                <li>Bantuan pendidikan anak kurang mampu</li>
              </ul>
              <p>Informasi lebih lanjut bisa ditanyakan via WhatsApp.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mt-3 fade-in-up" style="animation-delay: 0.6s;">
        <p class="small text-muted">*Tidak ada kewajiban untuk memberikan hadiah. Kehadiran Anda sudah sangat berarti bagi kami.</p>
      </div>
    </div>
  </section>

  <!-- RSVP Section -->
  <section id="rsvp" class="py-5 bg-white">
    <div class="container">
      <h3 class="text-center fw-bold text-dark-green mb-4 fade-in-up">Konfirmasi Kehadiran</h3>
      <p class="text-center text-muted mb-5 fade-in-up">Mohon konfirmasi kehadiran Anda paling lambat 10 Mei 2025</p>
      
      <div class="row justify-content-center">
        <div class="col-lg-8 fade-in-up">
          <form class="bg-light-gold p-4 p-md-5 rounded-4 shadow-sm">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email">
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Nomor WhatsApp</label>
                <input type="tel" class="form-control" id="phone" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="guests" class="form-label">Jumlah Tamu</label>
                <select class="form-select" id="guests" required>
                  <option value="" selected disabled>Pilih jumlah tamu</option>
                  <option value="1">1 Orang</option>
                  <option value="2">2 Orang</option>
                  <option value="3">3 Orang</option>
                  <option value="4">4 Orang</option>
                  <option value="5">5 Orang</option>
                </select>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="attendance" class="form-label">Konfirmasi Kehadiran</label>
              <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="attendance" id="attendYes" value="yes" required>
                  <label class="form-check-label" for="attendYes">
                    Hadir
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="attendance" id="attendNo" value="no">
                  <label class="form-check-label" for="attendNo">
                    Tidak Hadir
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="attendance" id="attendMaybe" value="maybe">
                  <label class="form-check-label" for="attendMaybe">
                    Masih Ragu
                  </label>
                </div>
              </div>
            </div>
            
            <div class="mb-3" id="eventSelection">
              <label class="form-label">Acara yang akan dihadiri</label>
              <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="attendAkad" value="akad">
                  <label class="form-check-label" for="attendAkad">
                    Akad Nikah (09.00 WITA)
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="attendResepsi" value="resepsi">
                  <label class="form-check-label" for="attendResepsi">
                    Resepsi (11.00 WITA)
                  </label>
                </div>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="message" class="form-label">Pesan untuk Pengantin (opsional)</label>
              <textarea class="form-control" id="message" rows="3"></textarea>
            </div>
            
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-dark-green px-5">
                <i class="fas fa-paper-plane me-2"></i>Kirim Konfirmasi
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Guestbook Section -->
  <section id="guestbook" class="py-5 bg-light-gold">
    <div class="container">
      <h3 class="text-center fw-bold text-dark-green mb-4 fade-in-up">Buku Tamu</h3>
      <p class="text-center text-muted mb-5 fade-in-up">Tinggalkan ucapan dan doa untuk kami</p>
      
      <div class="row justify-content-center">
        <div class="col-lg-8 fade-in-up">
          <form id="guestbookForm" class="bg-white p-4 rounded-4 shadow-sm mb-5">
            <div class="row">
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="guestName" placeholder="Nama Anda" required>
              </div>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="guestRelation" placeholder="Hubungan dengan pengantin">
              </div>
            </div>
            <div class="mb-3">
              <textarea class="form-control" id="guestMessage" rows="4" placeholder="Tulis ucapan atau doa..." required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-gold px-4">
                <i class="fas fa-heart me-2"></i>Kirim Ucapan
              </button>
            </div>
          </form>
          
          <div id="guestbookMessages" class="bg-white p-4 rounded-4 shadow-sm">
            <h5 class="text-center text-muted mb-4">Ucapan dari Tamu</h5>
            
            <div class="d-flex mb-4">
              <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="50" height="50" alt="Tamu">
              <div>
                <h6 class="mb-1">Ni Wayan Sari</h6>
                <p class="small text-muted mb-1">Bibi dari mempelai wanita</p>
                <p class="mb-0">Semoga pernikahan kalian diberkati oleh Sang Hyang Widhi Wasa. Semoga bahagia selalu dan menjadi keluarga yang harmonis.</p>
                <p class="small text-muted mt-2">2 jam yang lalu</p>
              </div>
            </div>
            
            <div class="d-flex mb-4">
              <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="50" height="50" alt="Tamu">
              <div>
                <h6 class="mb-1">Ketut Wira</h6>
                <p class="small text-muted mb-1">Teman kerja Made</p>
                <p class="mb-0">Selamat atas pernikahannya Made & Luh! Semoga menjadi keluarga yang sakinah mawaddah warahmah. Sampai ketemu di hari bahagianya!</p>
                <p class="small text-muted mt-2">5 jam yang lalu</p>
              </div>
            </div>
            
            <div class="d-flex">
              <img src="https://randomuser.me/api/portraits/women/63.jpg" class="rounded-circle me-3" width="50" height="50" alt="Tamu">
              <div>
                <h6 class="mb-1">Kadek Sri</h6>
                <p class="small text-muted mb-1">Sahabat SMA Luh</p>
                <p class="mb-0">Akhirnya Luh menikah juga! Dari dulu udah kelihatan klian berdua cocok banget. Semoga langgeng sampai tua nanti ya!</p>
                <p class="small text-muted mt-2">Kemarin</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Live Streaming Info -->
  <section class="py-5 bg-dark-green text-white">
    <div class="container text-center">
      <h3 class="fw-bold mb-4 fade-in-up">Live Streaming</h3>
      <p class="mb-4 fade-in-up">Bagi yang tidak dapat hadir secara langsung, dapat menyaksikan acara kami melalui live streaming</p>
      
      <div class="row justify-content-center">
        <div class="col-lg-6 fade-in-up">
          <div class="card bg-light-gold text-dark-green p-4">
            <h5 class="mb-3"><i class="fas fa-video me-2"></i>Informasi Live Streaming</h5>
            <p>Akad Nikah: Sabtu, 17 Mei 2025 pukul 09.00 WITA</p>
            <p>Resepsi: Sabtu, 17 Mei 2025 pukul 11.00 WITA</p>
            <p>Tautan live streaming akan dibagikan melalui WhatsApp dan Instagram kami 1 hari sebelum acara.</p>
            <div class="mt-3">
              <a href="#" class="btn btn-dark-green me-2"><i class="fab fa-whatsapp me-1"></i> Grup WhatsApp</a>
              <a href="#" class="btn btn-outline-dark-green"><i class="fab fa-instagram me-1"></i> Instagram</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Hashtag Section -->
  <section class="py-5 bg-white">
    <div class="container text-center">
      <h3 class="fw-bold text-dark-green mb-4 fade-in-up">Bagikan Momen Bahagia Kami</h3>
      <p class="mb-4 fade-in-up">Gunakan hashtag berikut saat memposting foto dari acara pernikahan kami</p>
      <div class="d-flex justify-content-center flex-wrap gap-3 fade-in-up">
        <span class="hashtag">#MadeLuhWedding</span>
        <span class="hashtag">#MadeLuh2025</span>
        <span class="hashtag">#BaliWedding</span>
        <span class="hashtag">#PernikahanAdatBali</span>
      </div>
    </div>
  </section>

  <!-- Ornamen Bali Bawah -->
  <div class="bali-ornament bali-ornament-bottom"></div>

  <!-- Footer -->
  <footer class="bg-dark-green text-white py-5">
    <div class="container text-center">
      <div class="mb-4">
        <img src="https://svgshare.com/i/12YF.svg" width="60" alt="Bali Ornament" class="mb-3">
        <h3 class="fw-bold mb-3">I Made &amp; Ni Luh</h3>
        <p class="mb-4">Sabtu, 17 Mei 2025<br>Puri Ubud, Gianyar, Bali</p>
        <div class="d-flex justify-content-center gap-3 fs-4 mb-4">
          <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-white"><i class="fab fa-whatsapp"></i></a>
          <a href="#" class="text-white"><i class="fas fa-envelope"></i></a>
        </div>
      </div>
      <hr class="mx-auto my-4" style="max-width: 300px; border-color: rgba(255,255,255,0.1);">
      <p class="mb-0">© 2025 Pernikahan I Made & Ni Luh. Dibuat dengan <i class="fas fa-heart text-danger"></i> di Bali.</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Countdown Timer Script -->
  <script>
    var countDownDate = new Date("May 17, 2025 09:00:00").getTime();
    var countdown = document.getElementById("countdown");
    var x = setInterval(function() {
      var now = new Date().getTime();
      var distance = countDownDate - now;
      if (distance < 0) {
        countdown.innerHTML = "Acara telah dimulai!";
        clearInterval(x);
        return;
      }
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      countdown.innerHTML = days + " hari " + hours + " jam " + minutes + " menit " + seconds + " detik";
    }, 1000);
  </script>
  
  <!-- Guestbook Script -->
  <script>
    const form = document.getElementById('guestbookForm');
    const messagesDiv = document.getElementById('guestbookMessages');
    
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const name = document.getElementById('guestName').value.trim();
      const relation = document.getElementById('guestRelation').value.trim();
      const message = document.getElementById('guestMessage').value.trim();
      
      if (name && message) {
        const div = document.createElement('div');
        div.className = "d-flex mb-4";
        div.innerHTML = `
          <img src="https://randomuser.me/api/portraits/${Math.random() > 0.5 ? 'men' : 'women'}/${Math.floor(Math.random()*100)}.jpg" 
               class="rounded-circle me-3" width="50" height="50" alt="Tamu">
          <div>
            <h6 class="mb-1">${name}</h6>
            ${relation ? `<p class="small text-muted mb-1">${relation}</p>` : ''}
            <p class="mb-0">${message}</p>
            <p class="small text-muted mt-2">Baru saja</p>
          </div>
        `;
        messagesDiv.insertBefore(div, messagesDiv.children[1]);
        form.reset();
      }
    });
  </script>
  
  <!-- Gallery Modal Script -->
  <script>
    const galleryModal = document.getElementById('galleryModal');
    if (galleryModal) {
      galleryModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const imgSrc = button.getAttribute('data-bs-img');
        const imgCaption = button.getAttribute('data-bs-caption');
        const modalImage = galleryModal.querySelector('#modalImage');
        const modalCaption = galleryModal.querySelector('#modalCaption');
        modalImage.src = imgSrc;
        modalCaption.textContent = imgCaption;
      });
    }
  </script>
  
  <!-- Music Control Script -->
  <script>
    const musicBtn = document.getElementById('musicBtn');
    const musicControl = document.getElementById('musicControl');
    const musicToggle = document.getElementById('musicToggle');
    const bgMusic = document.getElementById('bgMusic');
    const musicInfo = document.getElementById('musicInfo');
    let isPlaying = false;
    
    // Song list
    const songs = [
      { title: "Bali Traditional Music", src: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" },
      { title: "Kecak Dance Music", src: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3" },
      { title: "Balinese Gamelan", src: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3" }
    ];
    let currentSong = 0;
    
    musicBtn.addEventListener('click', function() {
      musicControl.classList.toggle('show');
    });
    
    musicToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleMusic();
    });
    
    function toggleMusic() {
      if (isPlaying) {
        bgMusic.pause();
        musicToggle.innerHTML = '<i class="fas fa-play"></i>';
      } else {
        bgMusic.play();
        musicToggle.innerHTML = '<i class="fas fa-pause"></i>';
      }
      isPlaying = !isPlaying;
    }
    
    // Initialize first song
    bgMusic.src = songs[currentSong].src;
    musicInfo.textContent = songs[currentSong].title;
    
    // Allow clicking anywhere outside to close music control
    document.addEventListener('click', function(e) {
      if (!musicControl.contains(e.target) {
        musicControl.classList.remove('show');
      }
    });
  </script>
  
  <!-- Animation Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const fadeElements = document.querySelectorAll('.fade-in-up');
      
      const fadeInOnScroll = function() {
        fadeElements.forEach(element => {
          const elementTop = element.getBoundingClientRect().top;
          const windowHeight = window.innerHeight;
          
          if (elementTop < windowHeight - 100) {
            const delay = element.getAttribute('style') && element.getAttribute('style').includes('animation-delay') 
              ? parseFloat(element.getAttribute('style').split('animation-delay: ')[1].replace('s', '')) * 1000 
              : 0;
            
            setTimeout(() => {
              element.style.opacity = 1;
              element.style.transform = 'translateY(0)';
            }, delay);
          }
        });
      };
      
      // Initial check
      fadeInOnScroll();
      
      // Check on scroll
      window.addEventListener('scroll', fadeInOnScroll);
    });
  </script>
  
  <!-- Save the Date Script -->
  <script>
    document.querySelector('.save-date-btn').addEventListener('click', function() {
      // Create ICS file for calendar
      const icsContent = `BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//MadeLuhWedding//ID
BEGIN:VEVENT
UID:20250517T090000@madeluhwedding.com
DTSTAMP:20240101T000000
DTSTART:20250517T090000
DTEND:20250517T150000
SUMMARY:Pernikahan Made & Luh
DESCRIPTION:Undangan pernikahan I Made Sudana dan Ni Luh Ayu di Puri Ubud, Bali
LOCATION:Puri Ubud, Gianyar, Bali
END:VEVENT
END:VCALENDAR`;
      
      const blob = new Blob([icsContent], { type: 'text/calendar' });
      const url = URL.createObjectURL(blob);
      
      const a = document.createElement('a');
      a.href = url;
      a.download = 'Pernikahan-Made-Luh.ics';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    });
  </script>
</body>
</html>