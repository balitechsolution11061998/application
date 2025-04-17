<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taman Sari POS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/pos/css/style.css">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <script src="https://unpkg.com/idb/build/iife/index-min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script src="/pos/js/script.js"></script>

  <style>
    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .fa-spinner {
      animation: spin 1s linear infinite;
    }

    /* Animasi untuk tombol date */
    .fa-calendar-alt {
      transition: transform 0.3s ease;
    }

    button:hover .fa-calendar-alt {
      transform: scale(1.1);
    }

    /* Untuk floating button */
    .fixed.floating-btn {
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .fixed.floating-btn:hover {
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
      transform: translateY(-2px);
    }

    @media print {
      #receipt-content {
        font-size: 12px !important;
        padding: 8px !important;
      }

      #receipt-content img {
        max-height: 48px !important;
      }
    }

    /* Add to your existing style tag */
    .login-card {
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      transition: all 0.3s ease;
    }

    .login-card:hover {
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      transform: translateY(-2px);
    }

    .input-field {
      transition: all 0.2s ease;
    }

    .input-field:focus {
      box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.3);
    }
  </style>
</head>

<body class="bg-blue-gray-50" x-data="initApp()"
  x-init="initDatabase(); checkSession(); startActivityMonitor();">
  <!-- Loading Spinner -->
  <div x-show="isLoading" class="fixed inset-0 flex justify-center items-center bg-white bg-opacity-90 z-50">
    <div class="text-center">
      <i class="fas fa-spinner fa-spin fa-3x text-cyan-500"></i>
      <p class="mt-4 text-gray-700">Logging in...</p>
    </div>
  </div>

  <!-- Main Loading Spinner with Logo -->
  <div x-show="isLoading" class="fixed inset-0 flex justify-center items-center bg-white bg-opacity-90 z-50">
    <div class="text-center">
      <!-- Logo with spinning container -->
      <div class="relative h-24 w-24 mx-auto mb-4">
        <!-- Outer spinning ring -->
        <div class="absolute inset-0 border-4 border-t-cyan-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin"></div>

        <!-- Your logo centered -->
        <div class="absolute inset-4 flex items-center justify-center">
          <img src="/img/logo/logotamansari.jpeg" alt="Logo" class="h-16 w-16 object-contain">
        </div>
      </div>

      <!-- Loading text -->
      <p class="text-lg font-medium text-gray-700">Loading System...</p>
      <p class="text-sm text-gray-500 mt-1">Please wait a moment</p>
    </div>
  </div>

  <!-- Product Loading Spinner (shown during product loading) -->
  <div x-show="products.length === 0 && !isLoading" class="fixed inset-0 flex justify-center items-center bg-white bg-opacity-75 z-40">
    <div class="text-center">
      <!-- Spinning logo (smaller version) -->
      <div class="relative h-16 w-16 mx-auto mb-3">
        <div class="absolute inset-0 border-4 border-t-cyan-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin"></div>
        <div class="absolute inset-2 flex items-center justify-center">
          <img src="/img/logo/logotamansari.jpeg" alt="Logo" class="h-10 w-10 object-contain">
        </div>
      </div>

      <!-- Loading text -->
      <p class="text-gray-700">Loading products...</p>
      <p class="text-xs text-gray-500 mt-1">Fetching product data</p>
    </div>
  </div>

  <!-- Login Form -->
  @yield('content_login')

  <!-- Tambahkan modal konfirmasi logout -->
  <div x-show="showLogoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-96">
      <div class="text-center">
        <i class="fas fa-sign-out-alt text-3xl text-cyan-500 mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Konfirmasi Logout</h3>
        <p class="mb-6">Apakah Anda yakin ingin logout dari sistem?</p>

        <div class="flex justify-center space-x-4">
          <button @click="confirmLogout()"
            class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600">
            Ya, Logout
          </button>
          <button @click="showLogoutModal = false"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Date Setting Modal -->
  <div x-show="showDateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-96">
      <div class="text-center">
        <i class="fas fa-calendar-alt text-3xl text-cyan-500 mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Set Transaction Date</h3>
        <p class="mb-4">Please set the date for this transaction</p>

        <div class="mb-4">
          <label for="transactionDate" class="block text-sm font-medium text-gray-700 mb-1">Transaction Date</label>
          <input type="datetime-local" id="transactionDate" x-model="transactionDate"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500">
        </div>

        <div class="flex justify-center space-x-4">
          <button @click="confirmDate()"
            class="px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600">
            Confirm Date
          </button>
          <button @click="useCurrentDate()"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
            Use Current Date
          </button>
        </div>
      </div>
    </div>
  </div>

  <div x-show="isLoggedIn">
    <!-- Header dengan tombol logout dan informasi pengguna -->
    <!-- noprint-area -->
    <div class="hide-print flex flex-row h-screen antialiased text-blue-gray-800">
      <!-- left sidebar -->
      @include('pos.sidebar')

      <!-- Main Dashboard Content -->
      <div x-show="isLoggedIn" class="hide-print w-full overflow-y-auto">
    
      <div class="flex-grow flex">


        <!-- Main Dashboard Content -->
        @yield('content')
      </div>
      </div>
    </div>
    <!-- end of noprint-area -->
  </div>
  <!-- Tambahkan sebelum penutup </body> -->
  <div class="fixed bottom-20 right-20 z-30" x-show="isLoggedIn">
    <button x-on:click="showDateSetting()"
      class="bg-purple-500 text-white p-4 rounded-full shadow-lg hover:bg-purple-600 focus:outline-none"
      title="Set Transaction Date">
      <i class="fas fa-calendar-alt fa-lg"></i>
    </button>
  </div>
  <div id="print-area" class="print-area"></div>
  <script>
    if (typeof toastr !== 'undefined') {
      toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: true,
        timeOut: 5000
      };
    }
  </script>
</body>

</html>