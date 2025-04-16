@extends('pos.index')
@section('content_login')
<div x-show="!isLoading && !isLoggedIn && !hasActiveSession()"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="fixed inset-0 flex justify-center items-center bg-gradient-to-br from-gray-50 to-blue-50 z-50">

    <div class="w-full max-w-sm mx-4">
      <!-- Clean card design -->
      <div class="relative bg-white rounded-xl overflow-hidden shadow-lg border border-gray-200">
        <!-- Header with logo -->
        <div class="bg-white py-8 px-8 flex flex-col items-center justify-center">
          <div class="mb-6">
            <img src="/img/logo/logotamansari.jpeg" alt="Taman Sari Watersport"
              class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md">
          </div>
          <h2 class="text-2xl font-bold text-gray-800 text-center">
            <span class="block">TAMAN SARI</span>
            <span class="block text-blue-600">WATERSPORT</span>
          </h2>
          <p class="text-sm text-gray-500 mt-3">Nice to see you again</p>
          <p class="text-lg font-medium text-gray-700 mt-1">WELCOME BACK</p>
        </div>

        <!-- Main content -->
        <div class="px-8 pb-8">
          <p class="text-sm text-gray-500 text-center mb-6">
            Let the user use a quick, interactive desktop device.<br>
            A simple and easy-to-use version of a desktop device is available.
          </p>

          <div class="border-t border-gray-200 my-6"></div>

          <!-- Login Form -->
          <form x-on:submit.prevent="login" class="space-y-4">
            <!-- Username Input -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Login Account</label>
              <div class="relative rounded-lg shadow-sm">
                <input type="text" x-model="username" placeholder="Enter your employee ID" required
                  class="input-field w-full py-2.5 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 placeholder-gray-400 bg-white text-gray-800">
              </div>
            </div>

            <!-- Password Input -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <div class="relative rounded-lg shadow-sm">
                <input type="password" x-model="password" placeholder="Enter your password" required
                  class="input-field w-full py-2.5 px-4 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 placeholder-gray-400 bg-white text-gray-800">
              </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input id="remember-me" name="remember-me" type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                  Keep me signed in
                </label>
              </div>
              <div class="text-sm">
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                  Create ID
                </a>
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
              class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 mt-4 shadow-sm hover:shadow-md">
              <span class="flex items-center justify-center">
                <span x-show="!isLoggingIn">LOGIN</span>
                <span x-show="isLoggingIn" class="flex items-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Processing...
                </span>
              </span>
            </button>
          </form>

          <div class="mt-4 text-center text-sm text-gray-500">
            Already a member?
            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Sign in</a>
          </div>

          <!-- Footer -->
          <div class="mt-8 text-center text-xs text-gray-400">
            <p>© 2023 Taman Sari Watersport - Tanjung Benoa, Bali</p>
            <p class="mt-1">SUBSORDB</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
