<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tailwind POS</title>
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
  <!-- POS System Login Form -->
  <div x-show="!isLoading && !isLoggedIn && !hasActiveSession()"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="fixed inset-0 flex justify-center items-center bg-gray-100 z-50">

    <div class="w-full max-w-md mx-4">
      <!-- POS-style card with clean business look -->
      <div class="relative bg-white rounded-lg overflow-hidden shadow-xl border border-gray-200">
        <!-- POS header stripe -->
        <div class="bg-blue-600 py-3 px-6 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
          <h2 class="text-xl font-bold text-white">POS System Login</h2>
        </div>

        <!-- Main content -->
        <div class="p-6">
          <!-- Store branding -->
          <div class="flex flex-col items-center mb-6">
            <div class="w-16 h-16 bg-white border-2 border-blue-500 rounded-lg flex items-center justify-center shadow-sm mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Store Name</h3>
            <p class="text-sm text-gray-500">Version 3.2.1</p>
          </div>

          <!-- Session notification -->
          <div x-show="hasActiveSession()" class="mb-4 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 rounded flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <div>
              <p class="font-medium text-sm">Active session detected</p>
              <p class="text-xs">Please logout from the current register first</p>
            </div>
          </div>

          <!-- Login Form -->
          <form x-on:submit.prevent="login" class="space-y-4">
            <!-- Username Input -->
            <div>
              <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Employee ID</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input id="username" type="text" x-model="username" placeholder="Enter your employee ID" required
                  class="w-full pl-10 pr-4 py-2.5 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors duration-200 placeholder-gray-400 bg-gray-50">
              </div>
            </div>

            <!-- Password Input -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">PIN</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input id="password" type="password" x-model="password" placeholder="Enter your 4-digit PIN" required
                  class="w-full pl-10 pr-4 py-2.5 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors duration-200 placeholder-gray-400 bg-gray-50">
              </div>
            </div>

            <!-- Register Selection -->
            <div>
              <label for="register" class="block text-sm font-medium text-gray-700 mb-1">Register</label>
              <select id="register" class="w-full py-2.5 px-3 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-gray-50">
                <option>Register 1</option>
                <option>Register 2</option>
                <option>Register 3</option>
                <option>Register 4</option>
              </select>
            </div>

            <!-- Submit Button -->
            <button type="submit"
              class="w-full bg-blue-600 text-white py-2.5 px-4 rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 mt-2">
              <span class="flex items-center justify-center">
                <span x-show="!isLoggingIn">Sign In to Register</span>
                <span x-show="isLoggingIn">Processing...</span>
                <svg x-show="isLoggingIn" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 animate-spin" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
              </span>
            </button>
          </form>

          <!-- Emergency buttons -->
          <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-3">
              <button class="text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 py-2 px-3 rounded-md transition-colors duration-200">
                Manager Override
              </button>
              <button class="text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 py-2 px-3 rounded-md transition-colors duration-200">
                Shift Change
              </button>
            </div>
          </div>

          <!-- Footer -->
          <div class="mt-6 text-center text-xs text-gray-500">
            <p>© 2023 POS System v3.2.1</p>
            <p class="mt-1">For technical support, call (555) 123-4567</p>
          </div>
        </div>
      </div>
    </div>
  </div>

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
      <div class="flex flex-row w-auto flex-shrink-0 pl-4 pr-2 py-4">
        <!-- Sidebar dengan ikon dan menu -->
        <div class="flex flex-col items-center py-4 flex-shrink-0 w-20 bg-cyan-500 rounded-3xl">
          <a href="#" class="flex items-center justify-center h-12 w-12 bg-cyan-50 text-cyan-700 rounded-full overflow-hidden">
            <!-- Ganti dengan tag img untuk menampilkan gambar -->
            <img src="/img/logo/logotamansari.jpeg" alt="Logo Tamansari" class="h-full w-full object-cover">
          </a>
          <ul class="flex flex-col space-y-2 mt-12">
            <!-- Existing menu items -->
            <li>
              <a href="#" class="flex items-center">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl">
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                  </svg>
                </span>
              </a>
            </li>

            <!-- User Modal Button -->
            <li>
              <button x-on:click="isLoading = true; showUserModal = true; isLoading = false"
                class="flex items-center w-full focus:outline-none">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-cyan-400 h-12 w-12 rounded-2xl">
                  <i class="fas fa-user-circle fa-lg"></i>
                </span>
              </button>
            </li>

            <!-- Logout Button -->
            <li>
              <button x-on:click="requestLogout()"
                class="flex items-center w-full focus:outline-none">
                <span class="flex items-center justify-center text-cyan-100 hover:bg-red-400 h-12 w-12 rounded-2xl">
                  <i class="fas fa-sign-out-alt fa-lg"></i>
                </span>
              </button>
            </li>
          </ul>
        </div>
      </div>
      <!-- page content -->
      <div class="flex-grow flex">
        <!-- store menu -->
        <div class="flex flex-col bg-blue-gray-50 h-full w-full py-4">
          <div class="flex px-2 flex-row relative">
            <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-cyan-500 text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <input type="text"
              class="bg-white rounded-3xl shadow text-lg full w-full h-16 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none"
              placeholder="Cari menu ..." x-model="keyword" />
          </div>
          <div class="h-full overflow-hidden mt-4">
            <div class="h-full overflow-y-auto px-2">
              <div
                class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                x-show="products.length === 0">
                <div class="w-full text-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                  </svg>
                  <p class="text-xl">
                    YOU DON'T HAVE
                    <br />
                    ANY PRODUCTS TO SHOW
                  </p>
                </div>
              </div>
              <div
                class="select-none bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full opacity-25"
                x-show="filteredProducts().length === 0 && keyword.length > 0">
                <div class="w-full text-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                  <p class="text-xl">
                    EMPTY SEARCH RESULT
                    <br />
                    "<span x-text="keyword" class="font-semibold"></span>"
                  </p>
                </div>
              </div>
              <div x-show="isLoading"
                class="fixed inset-0 flex justify-center items-center bg-white bg-opacity-75 z-50">
                <i class="fas fa-spinner fa-spin text-4xl text-blue-gray-500"></i>
              </div>
              <div x-show="filteredProducts().length" class="grid grid-cols-4 gap-4 pb-3">
                <template x-for="product in filteredProducts()" :key="product.id">
                  <div role="button"
                    class="select-none cursor-pointer transition-shadow overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg relative"
                    :title="product.name" x-on:click="addToCart(product)">
                    <!-- Loading Spinner untuk Produk -->
                    <div x-show="product.isLoading"
                      class="absolute inset-0 flex justify-center items-center bg-white bg-opacity-75">
                      <i class="fas fa-spinner fa-spin text-3xl text-blue-gray-500"></i>
                    </div>

                    <!-- Gambar Produk -->
                    <img :src="product.image" :alt="product.name" class="w-full h-40 object-cover"
                      @load="handleImageLoad(product)">

                    <!-- Informasi Produk -->
                    <div class="p-3">
                      <!-- Nama Produk -->
                      <p class="text-lg font-semibold text-blue-gray-800 truncate" x-text="product.name"></p>

                      <!-- SKU dan Barcode dengan Ikon -->
                      <div class="mt-2 space-y-1">
                        <!-- SKU -->
                        <p class="text-sm text-blue-gray-500">
                          <i class="fas fa-tag mr-2"></i> <!-- Ikon untuk SKU -->
                          <span class="font-medium">SKU:</span>
                          <span x-text="product.sku || 'N/A'"></span>
                        </p>

                        <!-- Barcode -->
                        <p class="text-sm text-blue-gray-500">
                          <i class="fas fa-barcode mr-2"></i> <!-- Ikon untuk Barcode -->
                          <span class="font-medium">Barcode:</span>
                          <span x-text="product.upc || 'N/A'"></span>
                        </p>
                      </div>

                      <!-- Harga Produk -->
                      <p class="mt-2 text-right text-lg font-bold text-cyan-600" x-text="priceFormat(product.price)">
                      </p>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
        <!-- end of store menu -->

        <!-- right sidebar -->
        <div class="w-5/12 flex flex-col bg-blue-gray-50 h-full bg-white pr-4 pl-2 py-4">
          <div class="bg-white rounded-3xl flex flex-col h-full shadow">
            <!-- empty cart -->
            <div x-show="cart.length === 0"
              class="flex-1 w-full p-4 opacity-25 select-none flex flex-col flex-wrap content-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 inline-block" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <p>
                CART EMPTY
              </p>
            </div>

            <!-- cart items -->
            <div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-auto">
              <div class="h-16 text-center flex justify-center">
                <div class="pl-8 text-left text-lg py-4 relative">
                  <!-- cart icon -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 inline-block" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  <div x-show="getItemsCount() > 0"
                    class="text-center absolute bg-cyan-500 text-white w-5 h-5 text-xs p-0 leading-5 rounded-full -right-2 top-3"
                    x-text="getItemsCount()"></div>
                </div>
                <div class="flex-grow px-8 text-right text-lg py-4 relative">

                  <!-- trash button -->
                  <button x-on:click="clear()" class="text-blue-gray-300 hover:text-pink-500 focus:outline-none mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>

                  <!-- Tombol untuk Menampilkan Modal User -->

                </div>
              </div>

              <!-- Modal untuk Menampilkan Informasi User -->


              <div class="flex-1 w-full px-4 overflow-auto">
                <template x-for="item in cart" :key="item.productId">
                  <div
                    class="select-none mb-3 bg-blue-gray-50 rounded-lg w-full text-blue-gray-700 py-2 px-2 flex justify-center relative">
                    <!-- Gambar Produk -->
                    <img :src="item.image" alt="" class="rounded-lg h-10 w-10 bg-white shadow mr-2">

                    <!-- Informasi Produk -->
                    <div class="flex-grow">
                      <!-- Nama Produk -->
                      <h5 class="text-sm" x-text="item.name"></h5>

                      <!-- Harga Produk -->
                      <p class="text-xs block" x-text="priceFormat(item.price)"></p>

                      <!-- SKU dan Barcode -->
                      <div class="mt-1 space-y-1">
                        <!-- SKU -->
                        <p class="text-xs text-blue-gray-500">
                          <i class="fas fa-tag mr-1"></i> <!-- Ikon untuk SKU -->
                          <span class="font-medium">SKU:</span>
                          <span x-text="item.sku"></span>
                        </p>

                        <!-- Barcode -->
                        <p class="text-xs text-blue-gray-500">
                          <i class="fas fa-barcode mr-1"></i> <!-- Ikon untuk Barcode -->
                          <span class="font-medium">Barcode:</span>
                          <span x-text="item.barcode"></span>
                        </p>
                      </div>
                    </div>

                    <!-- Tombol Tambah/Kurang Qty -->
                    <div class="py-1">
                      <div class="w-28 grid grid-cols-3 gap-2 ml-2">
                        <!-- Tombol Kurang Qty -->
                        <button x-on:click="addQty(item, -1)"
                          class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                          </svg>
                        </button>

                        <!-- Input Qty -->
                        <input x-model.number="item.qty" type="text"
                          class="bg-white rounded-lg text-center shadow focus:outline-none focus:shadow-lg text-sm">

                        <!-- Tombol Tambah Qty -->
                        <button x-on:click="addQty(item, 1)"
                          class="rounded-lg text-center py-1 text-white bg-blue-gray-600 hover:bg-blue-gray-700 focus:outline-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-3 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                          </svg>
                        </button>
                      </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div x-show="item.isLoading"
                      class="absolute inset-0 flex justify-center items-center bg-blue-gray-50 bg-opacity-75 rounded-lg">
                      <i class="fas fa-spinner fa-spin text-2xl text-blue-gray-500"></i>
                    </div>
                  </div>
                </template>
              </div>
            </div>
            <!-- end of cart items -->


            <!-- payment info -->
            <div class="select-none h-auto w-full text-center pt-3 pb-4 px-4">
              <div class="flex mb-3 text-lg font-semibold text-blue-gray-700">
                <div>TOTAL</div>
                <div class="text-right w-full" x-text="priceFormat(getTotalPrice())"></div>
              </div>
              <div class="mb-3 text-blue-gray-700 px-3 pt-2 pb-3 rounded-lg bg-blue-gray-50">
                <div class="flex text-lg font-semibold">
                  <div class="flex-grow text-left">CASH</div>
                  <div class="flex text-right">
                    <div class="mr-2">Rp</div>
                    <input x-bind:value="numberFormat(cash)" x-on:keyup="updateCash($event.target.value)" type="text"
                      class="w-28 text-right bg-white shadow rounded-lg focus:bg-white focus:shadow-lg px-2 focus:outline-none">
                  </div>
                </div>
                <hr class="my-2">
                <div class="grid grid-cols-3 gap-2 mt-2">
                  <template x-for="money in moneys">
                    <button x-on:click="addCash(money)"
                      class="bg-white rounded-lg shadow hover:shadow-lg focus:outline-none inline-block px-2 py-1 text-sm">
                      <i class="fas fa-money-bill mr-1"></i> <!-- Ikon untuk uang -->
                      +<span x-text="numberFormat(money)"></span>
                    </button>
                  </template>
                </div>
              </div>
              <div x-show="change > 0"
                class="flex mb-3 text-lg font-semibold bg-cyan-50 text-blue-gray-700 rounded-lg py-2 px-3">
                <div class="text-cyan-800">CHANGE</div>
                <div class="text-right flex-grow text-cyan-600" x-text="priceFormat(change)">
                </div>
              </div>
              <div x-show="change < 0"
                class="flex mb-3 text-lg font-semibold bg-pink-100 text-blue-gray-700 rounded-lg py-2 px-3">
                <div class="text-right flex-grow text-pink-600" x-text="priceFormat(change)">
                </div>
              </div>
              <div x-show="change == 0 && cart.length > 0"
                class="flex justify-center mb-3 text-lg font-semibold bg-cyan-50 text-cyan-700 rounded-lg py-2 px-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                </svg>
              </div>

              <!-- Tombol Clear dengan Ikon -->
              <button
                class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none bg-red-500 hover:bg-red-600 mb-3"
                x-on:click="clear()">
                <i class="fas fa-trash-alt mr-2"></i> <!-- Ikon untuk Clear -->
                CLEAR
              </button>
              <!-- Tombol Submit dengan Ikon -->
              <button class="text-white rounded-2xl text-lg w-full py-3 focus:outline-none" x-bind:class="{
                'bg-cyan-500 hover:bg-cyan-600': submitable(),
                'bg-blue-gray-200': !submitable()
              }" :disabled="!submitable()" x-on:click="submit()">
                <i class="fas fa-check-circle mr-2"></i> <!-- Ikon untuk Submit -->
                SUBMIT
              </button>
            </div>
            <!-- end of payment info -->
          </div>
        </div>
        <!-- end of right sidebar -->
      </div>

      <!-- modal first time -->
      <div x-show="firstTime"
        class="fixed glass w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
        <div class="w-96 rounded-3xl p-8 bg-white shadow-xl">
          <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block" width="123.3" height="123.233"
              viewBox="0 0 32.623 32.605">
              <path
                d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z"
                fill="#fff" />
              <path
                d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z"
                fill="#00dace" />
              <path
                d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z"
                fill="#00bcd4" />
              <g>
                <path
                  d="M15.612 0c-.36.003-.705.01-1.03.021C8.657.223 5.742 1.123 3.4 3.472.714 6.166-.145 9.758.019 17.607c.137 6.52.965 9.271 3.542 11.768 1.31 1.269 2.658 2 4.73 2.57.846.232 2.73.547 3.56.596.36.021 2.336.048 4.392.06 3.162.018 4.031-.016 5.63-.221 3.915-.504 6.43-1.778 8.234-4.173 1.806-2.396 2.514-5.731 2.516-11.846.001-4.407-.42-7.59-1.278-9.643-1.463-3.501-4.183-5.53-8.394-6.258-1.634-.283-4.823-.475-7.339-.46z"
                  fill="#fff" />
                <path
                  d="M16.202 13.758c-.056 0-.11 0-.16.003-.926.031-1.38.172-1.747.538-.42.421-.553.982-.528 2.208.022 1.018.151 1.447.553 1.837.205.198.415.313.739.402.132.036.426.085.556.093.056.003.365.007.686.009.494.003.63-.002.879-.035.611-.078 1.004-.277 1.286-.651.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.147-.072zM16.22 19.926c-.056 0-.11 0-.16.003-.925.031-1.38.172-1.746.539-.42.42-.554.981-.528 2.207.02 1.018.15 1.448.553 1.838.204.198.415.312.738.4.132.037.426.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.034.61-.08 1.003-.278 1.285-.652.282-.374.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.863-1.31-.977a7.91 7.91 0 00-1.146-.072zM22.468 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.205.198.415.313.739.401.132.037.426.086.556.094.056.003.364.007.685.009.494.003.63-.002.88-.035.611-.078 1.004-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.065-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072z"
                  fill="#00dace" />
                <path
                  d="M9.937 13.736c-.056 0-.11.001-.161.003-.925.032-1.38.172-1.746.54-.42.42-.554.98-.528 2.207.021 1.018.15 1.447.553 1.837.204.198.415.313.738.401.133.037.427.086.556.094.056.003.365.007.686.009.494.003.63-.002.88-.035.61-.078 1.003-.277 1.285-.651.282-.375.393-.895.393-1.85 0-.688-.066-1.185-.2-1.506-.228-.547-.653-.864-1.31-.977a7.91 7.91 0 00-1.146-.072zM16.202 7.59c-.056 0-.11 0-.16.002-.926.032-1.38.172-1.747.54-.42.42-.553.98-.528 2.206.022 1.019.151 1.448.553 1.838.205.198.415.312.739.401.132.037.426.086.556.093.056.003.365.007.686.01.494.002.63-.003.879-.035.611-.079 1.004-.278 1.286-.652.282-.374.392-.895.393-1.85 0-.688-.066-1.185-.2-1.505-.228-.547-.653-.864-1.31-.978a7.91 7.91 0 00-1.147-.071z"
                  fill="#00bcd4" />
              </g>
            </svg>
            <h3 class="text-center text-2xl mb-8">FIRST TIME?</h3>
          </div>
          <div class="text-left">
            <button x-on:click="startWithSampleData()"
              class="text-left w-full mb-3 rounded-xl bg-blue-gray-500 text-white focus:outline-none hover:bg-cyan-400 px-4 py-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block -mt-1 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
              </svg>
              LOAD SAMPLE DATA
            </button>
            <button x-on:click="startBlank()"
              class="text-left w-full rounded-xl bg-blue-gray-500 text-white focus:outline-none hover:bg-teal-400 px-4 py-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block -mt-1 mr-2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
              LEAVE IT EMPTY
            </button>
          </div>
        </div>
      </div>

      <!-- modal receipt -->
      <div x-show="isShowModalReceipt"
        class="fixed w-full h-screen left-0 top-0 z-10 flex flex-wrap justify-center content-center p-24">
        <div x-show="isShowModalReceipt" class="fixed glass w-full h-screen left-0 top-0 z-0"
          x-on:click="closeModalReceipt()" x-transition:enter="transition ease-out duration-100"
          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
          x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"></div>
        <div x-show="isShowModalReceipt" class="w-96 rounded-3xl bg-white shadow-xl overflow-hidden z-10"
          x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-90">
          <div id="receipt-content" class="text-left w-full text-sm p-6 overflow-auto">
            <div class="text-center">
              <img src="/pos/img/receipt-logo.png" alt="Tailwind POS" class="mb-3 w-8 h-8 inline-block">
              <h2 class="text-xl font-semibold">TAILWIND POS</h2>
              <p>CABANG KONOHA SELATAN</p>
            </div>
            <div class="flex mt-4 text-xs">
              <div class="flex-grow">No: <span x-text="receiptNo"></span></div>
              <div x-text="receiptDate"></div>
            </div>
            <hr class="my-2">
            <div>
              <table class="w-full text-xs">
                <thead>
                  <tr>
                    <th class="py-1 w-1/12 text-center">#</th>
                    <th class="py-1 text-left">Item</th>
                    <th class="py-1 w-2/12 text-center">Qty</th>
                    <th class="py-1 w-3/12 text-right">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="(item, index) in cart" :key="item">
                    <tr>
                      <td class="py-2 text-center" x-text="index+1"></td>
                      <td class="py-2 text-left">
                        <span x-text="item.name"></span>
                        <br />
                        <small x-text="priceFormat(item.price)"></small>
                      </td>
                      <td class="py-2 text-center" x-text="item.qty"></td>
                      <td class="py-2 text-right" x-text="priceFormat(item.qty * item.price)"></td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
            <hr class="my-2">
            <div>
              <div class="flex font-semibold">
                <div class="flex-grow">TOTAL</div>
                <div x-text="priceFormat(getTotalPrice())"></div>
              </div>
              <div class="flex text-xs font-semibold">
                <div class="flex-grow">PAY AMOUNT</div>
                <div x-text="priceFormat(cash)"></div>
              </div>
              <hr class="my-2">
              <div class="flex text-xs font-semibold">
                <div class="flex-grow">CHANGE</div>
                <div x-text="priceFormat(change)"></div>
              </div>
            </div>
          </div>
          <div class="p-4 w-full">
            <button class="bg-cyan-500 text-white text-lg px-4 py-3 rounded-2xl w-full focus:outline-none"
              x-on:click="printAndProceed()">PROCEED</button>
          </div>
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