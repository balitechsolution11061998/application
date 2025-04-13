<x-default-layout>
    @section('title', 'Dashboard Kependudukan')

    @section('breadcrumbs')
    {{ Breadcrumbs::render('kependudukan') }}
    @endsection

    <!-- CSS Custom -->
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --primary-lighter: #4cc9f0;
            --secondary: #f8f9fa;
            --success: #2dce89;
            --info: #11cdef;
            --warning: #fb6340;
            --danger: #f5365c;
            --dark: #212529;
            --light: #f8f9fa;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --white: #ffffff;
        }

        /* Dark Mode Variables */
        .dark-mode {
            --primary: #4895ef;
            --primary-light: #4cc9f0;
            --secondary: #1a1a2e;
            --dark: #f8f9fa;
            --light: #16213e;
            --gray: #adb5bd;
            --gray-light: #2a2a3c;
            --white: #1a1a2e;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--secondary);
            color: var(--dark);
            line-height: 1.6;
        }

        .dark-mode body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Header */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 1.75rem 2rem;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 6px 30px rgba(67, 97, 238, 0.25);
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }

        .dashboard-header h1 {
            font-weight: 700;
            letter-spacing: -0.5px;
            position: relative;
        }

        .dashboard-header p {
            opacity: 0.9;
            font-weight: 400;
        }

        /* Stat Cards */
        .stat-card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            background: var(--white);
            height: 100%;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .dark-mode .stat-card {
            background: var(--light);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            border-color: rgba(255,255,255,0.05);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--info));
        }

        .stat-card-primary::before {
            background: linear-gradient(90deg, var(--primary), #6a4ce0);
        }

        .stat-card-success::before {
            background: linear-gradient(90deg, var(--success), #2dceb6);
        }

        .stat-card-info::before {
            background: linear-gradient(90deg, var(--info), #11a8ef);
        }

        .stat-card-warning::before {
            background: linear-gradient(90deg, var(--warning), #fb9340);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-card h3 {
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0.5rem 0;
        }

        .stat-card small {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Charts */
        .chart-container {
            width: 100%;
            height: 380px;
            background: var(--white);
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            padding: 1.25rem;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .dark-mode .chart-container {
            background: var(--light);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            border-color: rgba(255,255,255,0.05);
        }

        .chart-container h5 {
            font-weight: 600;
            color: var(--dark);
        }

        .dark-mode .chart-container h5 {
            color: var(--light);
        }

        /* Avatar */
        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .avatar-primary {
            background-color: var(--primary);
        }

        .avatar-danger {
            background-color: var(--danger);
        }

        /* Badges */
        .badge-status {
            padding: 6px 12px;
            border-radius: 24px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-success {
            background-color: rgba(45, 206, 137, 0.12);
            color: var(--success);
        }

        .badge-warning {
            background-color: rgba(251, 99, 64, 0.12);
            color: var(--warning);
        }

        .badge-primary {
            background-color: rgba(67, 97, 238, 0.12);
            color: var(--primary);
        }

        .badge-danger {
            background-color: rgba(245, 54, 92, 0.12);
            color: var(--danger);
        }

        /* Search Box */
        .search-box {
            position: relative;
            width: 240px;
        }

        .search-box .form-control {
            padding-left: 42px;
            border-radius: 24px;
            border: 1px solid var(--gray-light);
            height: 38px;
            font-size: 0.9rem;
        }

        .dark-mode .search-box .form-control {
            background: var(--light);
            border-color: rgba(255,255,255,0.1);
            color: var(--gray);
        }

        .search-box i {
            position: absolute;
            left: 16px;
            top: 10px;
            color: var(--gray);
            font-size: 1rem;
        }

        /* Tables */
        .table-responsive {
            border-radius: 14px;
            overflow: hidden;
            background: var(--white);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0,0,0,0.03);
        }

        .dark-mode .table-responsive {
            background: var(--light);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            border-color: rgba(255,255,255,0.05);
        }

        .table {
            margin-bottom: 0;
            color: inherit;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: var(--gray);
            background: var(--secondary);
            padding: 1rem 1.25rem;
        }

        .dark-mode .table th {
            background: rgba(0,0,0,0.1);
            color: var(--gray);
        }

        .table td {
            vertical-align: middle;
            border-top: 1px solid var(--gray-light);
            padding: 1rem 1.25rem;
        }

        .dark-mode .table td {
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(var(--primary), 0.03);
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255,255,255,0.03);
        }

        /* Action Buttons */
        .action-btn {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
            transition: all 0.2s;
            border: none;
            background: transparent;
        }

        .action-btn:hover {
            transform: scale(1.1);
            opacity: 0.9;
        }

        .btn-view {
            background-color: rgba(17, 205, 239, 0.12);
            color: var(--info);
        }

        .btn-edit {
            background-color: rgba(251, 99, 64, 0.12);
            color: var(--warning);
        }

        .btn-delete {
            background-color: rgba(245, 54, 92, 0.12);
            color: var(--danger);
        }

        /* Modals */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .dark-mode .modal-content {
            background: var(--light);
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem 1.5rem 0;
        }

        .modal-header h5 {
            font-weight: 700;
        }

        .modal-footer {
            border-top: none;
            padding: 0 1.5rem 1.5rem;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .dark-mode .form-label {
            color: var(--gray);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 10px 16px;
            border: 1px solid var(--gray-light);
            font-size: 0.9rem;
        }

        .dark-mode .form-control,
        .dark-mode .form-select {
            background: rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.1);
            color: var(--gray);
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(var(--primary), 0.2);
            border-color: var(--primary);
        }

        .dark-mode .form-control:focus,
        .dark-mode .form-select:focus {
            box-shadow: 0 0 0 3px rgba(var(--primary), 0.3);
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 26px;
        }

        .dark-mode-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .dark-mode-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-light);
            transition: .4s;
            border-radius: 34px;
        }

        .dark-mode-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .dark-mode-slider {
            background-color: var(--primary);
        }

        input:checked + .dark-mode-slider:before {
            transform: translateX(26px);
        }

        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            box-shadow: 0 6px 25px rgba(67, 97, 238, 0.3);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: none;
        }

        .fab:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 30px rgba(67, 97, 238, 0.4);
            background: var(--primary-light);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-light);
        }

        .dark-mode ::-webkit-scrollbar-track {
            background: var(--light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Nav Tabs */
        .nav-tabs {
            border-bottom: 1px solid var(--gray-light);
        }

        .dark-mode .nav-tabs {
            border-bottom-color: rgba(255,255,255,0.1);
        }

        .nav-tabs .nav-link {
            border: none;
            padding: 0.75rem 1.25rem;
            font-weight: 500;
            color: var(--gray);
            border-radius: 0;
            position: relative;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary);
            background: transparent;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
            border-radius: 3px 3px 0 0;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .chart-container {
                height: 320px;
            }
            
            .search-box {
                width: 180px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.5rem 1.25rem;
            }
            
            .stat-card h3 {
                font-size: 1.5rem;
            }
            
            .chart-container {
                height: 280px;
                padding: 1rem;
            }
            
            .search-box {
                width: 100%;
                margin-bottom: 1rem;
            }
        }

        /* Utility Classes */
        .opacity-75 {
            opacity: 0.75;
        }

        .opacity-90 {
            opacity: 0.9;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .required:after {
            content: " *";
            color: var(--danger);
        }
    </style>

    <!-- Header -->
    <div class="dashboard-header animate-fade-in">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">
                    <i class="bi bi-people-fill me-2"></i> Dashboard <span class="text-gradient">Kependudukan</span>
                </h1>
                <p class="mb-0 opacity-90">Analisis data kependudukan terbaru secara real-time</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="me-3 d-flex align-items-center">
                    <span class="me-2 d-none d-sm-inline opacity-75">Dark Mode</span>
                    <label class="dark-mode-toggle">
                        <input type="checkbox" id="darkModeToggle">
                        <span class="dark-mode-slider"></span>
                    </label>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-download me-2"></i> <span>Export</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-excel me-2"></i> Excel</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-pdf me-2"></i> PDF</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-printer me-2"></i> Print</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-4 animate-fade-in" style="animation-delay: 0.1s">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted mb-1 d-block">Total Penduduk</span>
                            <h3 class="mb-1 counter" data-target="{{ number_format($totalPenduduk) }}">0</h3>
                            <small class="text-success fw-semibold">
                                <i class="bi bi-arrow-up"></i> 12% dari tahun lalu
                            </small>
                        </div>
                        <div class="stat-icon bg-primary animate-float">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted mb-1 d-block">Laki-laki</span>
                            <h3 class="mb-1 counter" data-target="{{ number_format($totalLaki) }}">0</h3>
                            <small class="text-muted">{{ number_format(($totalLaki/$totalPenduduk)*100, 1) }}% dari total</small>
                        </div>
                        <div class="stat-icon bg-success animate-float" style="animation-delay: 0.2s">
                            <i class="bi bi-gender-male"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted mb-1 d-block">Perempuan</span>
                            <h3 class="mb-1 counter" data-target="{{ number_format($totalPerempuan) }}">0</h3>
                            <small class="text-muted">{{ number_format(($totalPerempuan/$totalPenduduk)*100, 1) }}% dari total</small>
                        </div>
                        <div class="stat-icon bg-info animate-float" style="animation-delay: 0.4s">
                            <i class="bi bi-gender-female"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted mb-1 d-block">KTP Elektronik</span>
                            <h3 class="mb-1 counter" data-target="{{ number_format($totalKtpElektronik) }}">0</h3>
                            <small class="text-danger fw-semibold">
                                <i class="bi bi-arrow-down"></i> {{ number_format(100 - ($totalKtpElektronik/$totalPenduduk)*100, 1) }}% belum
                            </small>
                        </div>
                        <div class="stat-icon bg-warning animate-float" style="animation-delay: 0.6s">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Chart -->
    <div class="row g-4 mb-4 animate-fade-in" style="animation-delay: 0.2s">
        <div class="col-xl-8">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Distribusi Usia Penduduk</h5>
                    <div class="btn-group btn-group-sm shadow-sm">
                        <button type="button" class="btn btn-outline-secondary active">2023</button>
                        <button type="button" class="btn btn-outline-secondary">2022</button>
                        <button type="button" class="btn btn-outline-secondary">2021</button>
                    </div>
                </div>
                <div id="usiaChart" class="chart" style="height: 320px;"></div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Status Perkawinan</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Tampilkan Berdasarkan</h6></li>
                            <li><a class="dropdown-item" href="#">Kelurahan</a></li>
                            <li><a class="dropdown-item" href="#">Pendidikan</a></li>
                            <li><a class="dropdown-item" href="#">Pekerjaan</a></li>
                        </ul>
                    </div>
                </div>
                <div id="statusKawinChart" class="chart" style="height: 320px;"></div>
            </div>
        </div>
    </div>

    <!-- Peta dan Data Tambahan -->
    <div class="row g-4 mb-4 animate-fade-in" style="animation-delay: 0.3s">
        <div class="col-lg-6">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Persebaran Penduduk</h5>
                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center">
                        <i class="bi bi-fullscreen me-1"></i> Fullscreen
                    </button>
                </div>
                <div id="petaChart" class="chart" style="height: 300px;">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center">
                            <i class="bi bi-map text-muted animate-float" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-muted">Peta persebaran penduduk</p>
                            <button class="btn btn-sm btn-primary px-4">Aktifkan Peta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="chart-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Statistik Pendidikan</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Export as PNG</a></li>
                            <li><a class="dropdown-item" href="#">Export as CSV</a></li>
                        </ul>
                    </div>
                </div>
                <div id="pendidikanChart" class="chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Penduduk -->
    <div class="card shadow-sm border-0 animate-fade-in" style="animation-delay: 0.4s">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-2 mb-md-0">
                    <i class="bi bi-table me-2"></i> Data Penduduk
                </h5>
                <div class="d-flex flex-wrap">
                    <div class="search-box me-3 mb-2 mb-md-0">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control" placeholder="Cari penduduk..." id="searchInput">
                    </div>
                    <div class="dropdown me-2 mb-2 mb-md-0">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Filter Data</h6></li>
                            <li><a class="dropdown-item" href="#">Semua</a></li>
                            <li><a class="dropdown-item" href="#">KTP Elektronik</a></li>
                            <li><a class="dropdown-item" href="#">Belum Kawin</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Reset Filter</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#tambahPendudukModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="pendudukTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Usia</th>
                            <th>Status</th>
                            <th>KTP Elektronik</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penduduk as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3 avatar-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }}">
                                        {{ substr($item->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $item->nama }}</h6>
                                        <small class="text-muted">{{ $item->pekerjaan ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} thn</td>
                            <td>
                                <span class="badge badge-status bg-{{ $item->status_kawin == 'BELUM KAWIN' ? 'success' : ($item->status_kawin == 'KAWIN' ? 'warning' : 'primary') }}">
                                    {{ $item->status_kawin }}
                                </span>
                            </td>
                            <td>
                                @if($item->ktp_elektronik)
                                <span class="badge badge-status bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Ya
                                </span>
                                @else
                                <span class="badge badge-status bg-danger">
                                    <i class="bi bi-x-circle me-1"></i> Tidak
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-view action-btn me-2" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-edit action-btn me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-delete action-btn" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $item->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <div class="text-muted">
                    Menampilkan data 1 sampai 10 dari {{ count($penduduk) }} entri
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <button class="fab animate-fade-in" style="animation-delay: 0.5s" data-bs-toggle="modal" data-bs-target="#tambahPendudukModal">
        <i class="bi bi-plus-lg"></i>
    </button>

    <!-- Modal Tambah Penduduk -->
    <div class="modal fade" id="tambahPendudukModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Penduduk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <ul class="nav nav-tabs mb-4" id="formTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="data-diri-tab" data-bs-toggle="tab" data-bs-target="#data-diri" type="button">Data Diri</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="data-keluarga-tab" data-bs-toggle="tab" data-bs-target="#data-keluarga" type="button">Data Keluarga</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="data-lainnya-tab" data-bs-toggle="tab" data-bs-target="#data-lainnya" type="button">Lainnya</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="formTabsContent">
                            <!-- Tab Data Diri -->
                            <div class="tab-pane fade show active" id="data-diri" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">NIK</label>
                                        <input type="text" name="nik" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-select" required>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Agama</label>
                                        <select name="agama" class="form-select" required>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">No. KK</label>
                                        <input type="text" name="no_kk" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Data Keluarga -->
                            <div class="tab-pane fade" id="data-keluarga" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nama Bapak</label>
                                        <input type="text" name="nama_bapak" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">RT</label>
                                        <input type="text" name="rt" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">RW</label>
                                        <input type="text" name="rw" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Data Lainnya -->
                            <div class="tab-pane fade" id="data-lainnya" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pendidikan</label>
                                        <select name="pendidikan" class="form-select">
                                            <option value="">Pilih Pendidikan</option>
                                            <option value="Tidak Sekolah">Tidak Sekolah</option>
                                            <option value="SD">SD</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                            <option value="D1-D3">D1-D3</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Golongan Darah</label>
                                        <select name="golongan_darah" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">Status Kawin</label>
                                        <select name="status_kawin" class="form-select" required>
                                            <option value="BELUM KAWIN">Belum Kawin</option>
                                            <option value="KAWIN">Kawin</option>
                                            <option value="KAWIN TERCATAT">Kawin Tercatat</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">KTP Elektronik</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="ktp_elektronik" value="1">
                                            <label class="form-check-label">Ya</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Dark Mode Toggle
        document.getElementById('darkModeToggle').addEventListener('change', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', this.checked);

            // Update charts theme
            if (this.checked) {
                am5.theme.set(am5themes_Dark);
            } else {
                am5.theme.set(am5themes_Animated);
            }
        });

        // Check saved preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            document.getElementById('darkModeToggle').checked = true;
        }

        // Animated Counter
        document.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.getAttribute('data-target').replace(/,/g, '');
            const increment = target / 50;
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current).toLocaleString();
                    setTimeout(updateCounter, 20);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };

            updateCounter();
        });

        // Initialize DataTable
        $(document).ready(function() {
            $('#pendudukTable').DataTable({
                responsive: true,
                dom: '<"top"<"d-flex justify-content-between align-items-center"fB>>rt<"bottom"lip><"clear">',
                language: {
                    search: "",
                    searchPlaceholder: "Cari...",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari total _MAX_ data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                buttons: [{
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-excel me-1"></i> Excel',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer me-1"></i> Print',
                        className: 'btn btn-sm btn-outline-secondary'
                    }
                ]
            });

            // Usia Chart
            am5.ready(function() {
                var root = am5.Root.new("usiaChart");
                root.setThemes([
                    am5themes_Animated.new(root),
                    localStorage.getItem('darkMode') === 'true' ? am5themes_Dark.new(root) : null
                ].filter(Boolean));

                var chart = root.container.children.push(
                    am5xy.XYChart.new(root, {
                        panX: false,
                        panY: false,
                        wheelX: "panX",
                        wheelY: "zoomX",
                        pinchZoomX: true,
                        paddingLeft: 0,
                        paddingRight: 0
                    })
                );

                // Add cursor
                chart.set("cursor", am5xy.XYCursor.new(root, {
                    behavior: "zoomX"
                }));

                // Data
                var data = {!! json_encode(array_map(function($range, $count) {
                    return ['range' => $range, 'count' => $count];
                }, ['0-5', '6-12', '13-19', '20-30', '31-45', '46-60', '>60'], $distribusiUsia)) !!};

                // X Axis
                var xAxis = chart.xAxes.push(
                    am5xy.CategoryAxis.new(root, {
                        categoryField: "range",
                        renderer: am5xy.AxisRendererX.new(root, {
                            minGridDistance: 30,
                            cellStartLocation: 0.1,
                            cellEndLocation: 0.9
                        }),
                        tooltip: am5.Tooltip.new(root, {})
                    })
                );
                xAxis.data.setAll(data);

                // Y Axis
                var yAxis = chart.yAxes.push(
                    am5xy.ValueAxis.new(root, {
                        renderer: am5xy.AxisRendererY.new(root, {
                            strokeOpacity: 0.1
                        })
                    })
                );

                // Bar Series
                var barSeries = chart.series.push(
                    am5xy.ColumnSeries.new(root, {
                        name: "Jumlah",
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "count",
                        categoryXField: "range",
                        tooltip: am5.Tooltip.new(root, {
                            labelText: "{valueY} orang"
                        })
                    })
                );
                barSeries.columns.template.setAll({
                    tooltipY: am5.percent(10),
                    width: am5.percent(70),
                    fillOpacity: 0.8,
                    strokeOpacity: 0,
                    cornerRadiusBR: 4,
                    cornerRadiusTR: 4
                });
                barSeries.data.setAll(data);

                // Line Series (Trend)
                var lineSeries = chart.series.push(
                    am5xy.LineSeries.new(root, {
                        name: "Trend",
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "count",
                        categoryXField: "range",
                        stroke: am5.color("#11CDEF"),
                        strokeWidth: 3,
                        tooltip: am5.Tooltip.new(root, {
                            labelText: "Trend: {valueY}"
                        })
                    })
                );
                lineSeries.data.setAll(data);

                // Add Legend
                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50,
                        marginTop: 20
                    })
                );
                legend.data.setAll(chart.series.values);

                // Add Scrollbar
                chart.set("scrollbarX", am5.Scrollbar.new(root, {
                    orientation: "horizontal"
                }));

                chart.appear(1000, 100);
            });

            // Status Kawin Chart
            am5.ready(function() {
                var root = am5.Root.new("statusKawinChart");
                root.setThemes([
                    am5themes_Animated.new(root),
                    localStorage.getItem('darkMode') === 'true' ? am5themes_Dark.new(root) : null
                ].filter(Boolean));

                var chart = root.container.children.push(
                    am5percent.PieChart.new(root, {
                        layout: root.verticalLayout,
                        innerRadius: am5.percent(40),
                        radius: am5.percent(90)
                    })
                );

                var series = chart.series.push(
                    am5percent.PieSeries.new(root, {
                        name: "Status",
                        valueField: "value",
                        categoryField: "status",
                        alignLabels: false,
                        startAngle: 180,
                        endAngle: 360,
                        innerRadius: am5.percent(40),
                        sequencedAnimation: true
                    })
                );

                series.slices.template.setAll({
                    stroke: am5.color(0xffffff),
                    strokeWidth: 2,
                    strokeOpacity: 1,
                    templateField: "sliceSettings"
                });

                series.labels.template.setAll({
                    textType: "circular",
                    radius: 8,
                    inside: true,
                    fill: am5.color(0xffffff)
                });

                series.ticks.template.set("visible", false);

                // Data dengan efek 3D
                series.data.setAll({
                                    !!json_encode(array_map(function($status, $count) {
                                            return [
                                                'status' => $status,
                                                'value' => $count,
                                                'sliceSettings' => [
                                                    'fill' => ['#2DCE89', '#FB6340', '#5E72E4'][array_rand(['#2DCE89', '#FB6340', '#5E72E4'])]
                                                ]
                                            ];
                                        }, array_keys($statusKawin), array_values($statusKawin)) !!
                                    });

                // Add Legend
                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50,
                        marginTop: 25,
                        marginBottom: 25
                    })
                );
                legend.data.setAll(series.dataItems);

                chart.appear(1000, 100);
            });

            // Pendidikan Chart
            am5.ready(function() {
                var root = am5.Root.new("pendidikanChart");
                root.setThemes([
                    am5themes_Animated.new(root),
                    localStorage.getItem('darkMode') === 'true' ? am5themes_Dark.new(root) : null
                ].filter(Boolean));

                var chart = root.container.children.push(
                    am5xy.XYChart.new(root, {
                        panX: false,
                        panY: false,
                        wheelX: "none",
                        wheelY: "none",
                        paddingLeft: 0,
                        paddingRight: 0
                    })
                );

                // Data pendidikan (contoh)
                var pendidikanData = [
                    {"pendidikan": "Tidak Sekolah", "jumlah": 120},
                    {"pendidikan": "SD", "jumlah": 450},
                    {"pendidikan": "SMP", "jumlah": 320},
                    {"pendidikan": "SMA", "jumlah": 280},
                    {"pendidikan": "Diploma", "jumlah": 150},
                    {"pendidikan": "Sarjana", "jumlah": 200},
                    {"pendidikan": "Pascasarjana", "jumlah": 50}
                ];

                // X Axis
                var xAxis = chart.xAxes.push(
                    am5xy.CategoryAxis.new(root, {
                        categoryField: "pendidikan",
                        renderer: am5xy.AxisRendererX.new(root, {
                            minGridDistance: 30
                        })
                    })
                );
                xAxis.data.setAll(pendidikanData);

                // Y Axis
                var yAxis = chart.yAxes.push(
                    am5xy.ValueAxis.new(root, {
                        renderer: am5xy.AxisRendererY.new(root, {
                            strokeOpacity: 0.1
                        })
                    })
                );

                // Series
                var series = chart.series.push(
                    am5xy.ColumnSeries.new(root, {
                        name: "Jumlah",
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "jumlah",
                        categoryXField: "pendidikan",
                        tooltip: am5.Tooltip.new(root, {
                            labelText: "{valueY} orang"
                        })
                    })
                );
                series.columns.template.setAll({
                    tooltipY: am5.percent(10),
                    width: am5.percent(80),
                    fillOpacity: 0.8,
                    strokeOpacity: 0,
                    cornerRadiusBR: 4,
                    cornerRadiusTR: 4
                });

                series.set("colors", am5.ColorSet.new(root, {
                    colors: [
                        am5.color("#4361ee"),
                        am5.color("#4895ef"),
                        am5.color("#4cc9f0"),
                        am5.color("#2dce89"),
                        am5.color("#fb6340"),
                        am5.color("#5603ad"),
                        am5.color("#8965e0")
                    ]
                }));

                series.data.setAll(pendidikanData);

                chart.appear(1000, 100);
            });
        });
    </script>
    @endpush
</x-default-layout>