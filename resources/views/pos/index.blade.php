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

    /* Enhanced styles */
    .sidebar-item {
      transition: all 0.3s ease;
      position: relative;
    }

    .sidebar-item::after {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 3px;
      height: 0;
      background: white;
      transition: height 0.3s ease;
    }

    .sidebar-item:hover::after {
      height: 100%;
    }

    .sidebar-item.active::after {
      height: 100%;
    }

    .card-hover {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .glow-on-hover {
      transition: box-shadow 0.3s ease;
    }

    .glow-on-hover:hover {
      box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
    }

    .smooth-transition {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .neumorphic {
      border-radius: 16px;
      background: #f0f0f0;
      box-shadow: 8px 8px 16px #d9d9d9,
        -8px -8px 16px #ffffff;
    }

    .neumorphic-inset {
      border-radius: 16px;
      background: #f0f0f0;
      box-shadow: inset 8px 8px 16px #d9d9d9,
        inset -8px -8px 16px #ffffff;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #a1a1a1;
    }

    /* Floating animation */
    @keyframes float {
      0% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }

      100% {
        transform: translateY(0px);
      }
    }

    .floating {
      animation: float 6s ease-in-out infinite;
    }

    /* Pulse animation */
    @keyframes pulse {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0.5;
      }

      100% {
        opacity: 1;
      }
    }

    .pulse {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Custom gradient text */
    .gradient-text {
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
    }

    /* Custom SweetAlert Style */
    .swal2-popup {
      border-radius: 20px !important;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .swal2-title {
      font-size: 1.5rem !important;
      color: #1a365d !important;
    }

    .swal2-html-container {
      font-size: 1.1rem !important;
      color: #4a5568 !important;
    }

    .swal2-confirm {
      background: linear-gradient(45deg, #667eea, #764ba2) !important;
      border-radius: 10px !important;
      padding: 12px 24px !important;
      border: none !important;
      transition: all 0.3s ease !important;
    }

    .swal2-cancel {
      background: #e2e8f0 !important;
      color: #4a5568 !important;
      border-radius: 10px !important;
      padding: 12px 24px !important;
      border: none !important;
      transition: all 0.3s ease !important;
    }

    .swal2-timer-progress-bar {
      background: linear-gradient(45deg, #667eea, #764ba2) !important;
      border-radius: 20px !important;
    }

    @media print {
      body * {
        visibility: hidden;
      }

      #receipt-content,
      #receipt-content * {
        visibility: visible;
      }

      #receipt-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 0;
        box-shadow: none;
        border: none;
      }

      /* Sembunyikan tombol print */
      #receipt-content+div {
        display: none;
      }
    }
    
  </style>
</head>

<body class="bg-gray-50" x-data="initApp()" x-init="initDatabase(); checkSession(); startActivityMonitor();">
  <!-- Loading Spinner -->
  <div x-show="isLoading" class="fixed inset-0 flex justify-center items-center bg-white bg-opacity-90 z-50">
    <div class="text-center">
      <div class="relative h-32 w-32 mx-auto mb-6">
        <!-- Outer spinning ring -->
        <div class="absolute inset-0 border-4 border-t-indigo-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin"></div>

        <!-- Middle spinning ring -->
        <div class="absolute inset-4 border-4 border-t-cyan-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin animation-delay-200"></div>

        <!-- Inner spinning ring -->
        <div class="absolute inset-8 border-4 border-t-purple-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin animation-delay-400"></div>

        <!-- Your logo centered -->
        <div class="absolute inset-6 flex items-center justify-center">
          <img src="/img/logo/logotamansari.jpeg" alt="Logo" class="h-16 w-16 object-contain rounded-full shadow-md">
        </div>
      </div>

      <!-- Loading text with pulse animation -->
      <p class="text-xl font-semibold text-gray-700 mb-1">Loading System</p>
      <p class="text-sm text-gray-500 flex items-center justify-center">
        <span class="inline-block h-2 w-2 rounded-full bg-indigo-500 mr-1"></span>
        <span class="inline-block h-2 w-2 rounded-full bg-indigo-500 mr-1 animation-delay-100"></span>
        <span class="inline-block h-2 w-2 rounded-full bg-indigo-500 animation-delay-200"></span>
      </p>
    </div>
  </div>

  <!-- Product Loading Spinner -->
  <div x-show="products.length === 0 && !isLoading" class="fixed inset-0 flex justify-center items-center bg-white bg-opacity-75 z-40">
    <div class="text-center">
      <!-- Spinning logo with gradient border -->
      <div class="relative h-20 w-20 mx-auto mb-4">
        <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-indigo-500 border-r-purple-500 border-b-cyan-500 border-l-pink-500 animate-spin"></div>
        <div class="absolute inset-2 flex items-center justify-center rounded-full bg-white shadow-sm">
          <img src="/img/logo/logotamansari.jpeg" alt="Logo" class="h-10 w-10 object-contain rounded-full">
        </div>
      </div>

      <!-- Loading text with gradient -->
      <p class="text-lg font-medium bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 gradient-text mb-1">
        Loading products...
      </p>
      <p class="text-xs text-gray-500">Please wait while we prepare your products</p>
    </div>
  </div>

  <!-- Login Form -->
  @yield('content_login')

  <!-- Logout Confirmation Modal -->
  <div x-show="showLogoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="bg-white rounded-xl p-6 w-96 max-w-sm shadow-xl transform transition-all duration-300 scale-95"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95">
      <div class="text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
          <i class="fas fa-sign-out-alt text-red-500 text-xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Confirm Logout</h3>
        <p class="text-gray-500 mb-6">Are you sure you want to logout from the system?</p>

        <div class="flex justify-center space-x-4">
          <button @click="confirmLogout()"
            class="px-6 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg hover:shadow-lg transition-all duration-300">
            Yes, Logout
          </button>
          <button @click="showLogoutModal = false"
            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Date Setting Modal -->
  <div x-show="showDateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="bg-white rounded-xl p-6 w-96 max-w-sm shadow-xl transform transition-all duration-300 scale-95"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95">
      <div class="text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 mb-4">
          <i class="fas fa-calendar-alt text-indigo-500 text-xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Set Transaction Date</h3>
        <p class="text-gray-500 mb-4">Please set the date for this transaction</p>

        <div class="mb-6">
          <label for="transactionDate" class="block text-sm font-medium text-gray-700 mb-2 text-left">Transaction Date</label>
          <div class="relative">
            <input type="datetime-local" id="transactionDate" x-model="transactionDate"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <i class="fas fa-clock text-gray-400"></i>
            </div>
          </div>
        </div>

        <div class="flex justify-center space-x-4">
          <button @click="confirmDate()"
            class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg hover:shadow-lg transition-all duration-300">
            Confirm Date
          </button>
          <button @click="useCurrentDate()"
            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
            Use Current
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Layout (when logged in) -->
  <div x-show="isLoggedIn" class="flex h-screen">
    <!-- Sidebar -->
   

  

      <!-- Navigation Menu -->
      @include('pos.sidebar')
    
    

    <!-- Main Content Area -->
    <div class="flex-1 overflow-y-auto">
      <div class="flex-grow flex flex-col">
        <!-- Main Dashboard Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          @isset($header)
          <div class="mb-10">
            {{ $header }}
          </div>
          @endisset
          @yield('content')

          @isset($footer)
          <div class="mt-10">
            {{ $footer }}
          </div>
          @endisset
        </main>
      </div>
    </div>


  </div>

  <!-- Floating Action Button for Date Setting -->
  <div class="fixed bottom-8 right-8 z-30" x-show="isLoggedIn">
    <button x-on:click="showDateSetting()"
      class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-5 rounded-full shadow-xl hover:shadow-2xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300 floating"
      title="Set Transaction Date">
      <i class="fas fa-calendar-alt text-xl"></i>
    </button>
  </div>

  <!-- Print Area -->
  <div id="print-area" class="print-area"></div>

  <script>
    if (typeof toastr !== 'undefined') {
      toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: true,
        timeOut: 5000,
        showMethod: 'slideDown',
        hideMethod: 'fadeOut',
        showEasing: 'swing',
        hideEasing: 'linear'
      };
    }

    // Add animation delay utility
    document.addEventListener('DOMContentLoaded', function() {
      const style = document.createElement('style');
      style.textContent = `
        .animation-delay-100 { animation-delay: 0.1s; }
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-300 { animation-delay: 0.3s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-500 { animation-delay: 0.5s; }
      `;
      document.head.appendChild(style);
    });
  </script>
</body>

</html>