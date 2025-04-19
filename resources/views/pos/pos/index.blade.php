@extends('pos.index')
@section('content')
<!-- Main Content Area -->
<div class="flex-grow flex h-screen overflow-hidden">
  <!-- Product Menu Section -->
  <div class="flex flex-col bg-gradient-to-br from-gray-50 to-gray-100 h-full w-full py-6 px-4">
    <!-- Search Bar (Fixed) -->
    <div class="flex px-2 flex-row relative mb-6">
      <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white shadow-md transform hover:scale-105 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input type="text"
        class="bg-white rounded-2xl shadow-lg text-lg full w-full h-14 py-4 pl-16 transition-all duration-300 focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-cyan-300 border border-gray-200"
        placeholder="Search menu ..." x-model="keyword" />
    </div>
    <!-- Add this section below the search bar and above the product grid -->
    <div class="px-2 mb-4">
      <!-- Community Filter -->
      <div class="mb-4">
        <div class="flex items-center justify-between mb-2">
          <h3 class="text-sm font-medium text-gray-700 flex items-center">
            <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
              <i class="fas fa-users text-blue-500"></i>
            </span>
            Partner Communities
          </h3>
          <button @click="communityScrollLeft()" class="text-gray-400 hover:text-blue-500 p-1">
            <i class="fas fa-chevron-left"></i>
          </button>
        </div>

        <div class="relative">
          <div class="overflow-hidden">
            <div x-ref="communitySlider" class="flex space-x-2 transition-transform duration-300 pb-2"
              style="scroll-behavior: smooth;">
              <button @click="activeCommunity = ''"
                class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap flex items-center flex-shrink-0 transition-all"
                :class="activeCommunity === '' ? 
                   'bg-blue-500 text-white shadow-md' : 
                   'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 hover:border-blue-200'">
                <i class="fas fa-globe mr-2"></i>
                All
              </button>

              <template x-for="community in communities" :key="community.id">
                <button @click="activeCommunity = community.id"
                  class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap flex items-center flex-shrink-0 transition-all group relative"
                  :class="activeCommunity === community.id ? 
                     'bg-blue-500 text-white shadow-md' : 
                     'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 hover:border-blue-200'">
                  <div class="absolute -top-1 -right-1 bg-white rounded-full p-1 shadow-sm"
                    x-show="activeCommunity === community.id">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <img :src="community.logo" class="w-5 h-5 rounded-full mr-2 object-cover border border-gray-200">
                  <span x-text="community.name"></span>
                </button>
              </template>
            </div>
          </div>
          <button @click="communityScrollRight()" class="absolute right-0 top-0 text-gray-400 hover:text-blue-500 p-1">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- Company Filter -->
      <div>
        <div class="flex items-center justify-between mb-2">
          <h3 class="text-sm font-medium text-gray-700 flex items-center">
            <span class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center mr-2">
              <i class="fas fa-building text-cyan-500"></i>
            </span>
            Partner Companies
          </h3>
          <button @click="companyScrollLeft()" class="text-gray-400 hover:text-cyan-500 p-1">
            <i class="fas fa-chevron-left"></i>
          </button>
        </div>

        <div class="relative">
          <div class="overflow-hidden">
            <div x-ref="companySlider" class="flex space-x-2 transition-transform duration-300 pb-2"
              style="scroll-behavior: smooth;">
              <button @click="activeCompany = ''"
                class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap flex items-center flex-shrink-0 transition-all"
                :class="activeCompany === '' ? 
                   'bg-cyan-500 text-white shadow-md' : 
                   'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 hover:border-cyan-200'">
                <i class="fas fa-briefcase mr-2"></i>
                All
              </button>

              <template x-for="company in companies" :key="company.id">
                <button @click="activeCompany = company.id"
                  class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap flex items-center flex-shrink-0 transition-all group"
                  :class="activeCompany === company.id ? 
                     'bg-cyan-500 text-white shadow-md' : 
                     'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 hover:border-cyan-200'">
                  <div class="relative mr-2">
                    <img :src="company.logo" class="w-5 h-5 rounded-full object-cover border border-gray-200">
                    <div class="absolute -top-1 -right-1 bg-white rounded-full p-0.5 shadow-sm"
                      x-show="activeCompany === company.id">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                      </svg>
                    </div>
                  </div>
                  <span x-text="company.name"></span>
                  <span x-show="company.discount"
                    class="ml-2 px-2 py-0.5 text-xs rounded-full font-bold"
                    :class="activeCompany === company.id ? 
                       'bg-white text-cyan-600' : 
                       'bg-cyan-100 text-cyan-800'">
                    <span x-text="company.discount + '%'"></span>
                  </span>
                </button>
              </template>
            </div>
          </div>
          <button @click="companyScrollRight()" class="absolute right-0 top-0 text-gray-400 hover:text-cyan-500 p-1">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    


    <!-- Product Grid (Scrollable) -->
    <div class="flex-1 overflow-hidden">
      <div class="h-full overflow-y-auto px-2">
        <!-- No Products State -->
        <div class="select-none bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex flex-wrap content-center justify-center h-full opacity-80"
          x-show="products.length === 0">
          <div class="w-full text-center p-8">
            <div class="inline-block p-4 bg-white rounded-full shadow-lg mb-4 transform hover:rotate-12 transition-transform">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
              </svg>
            </div>
            <p class="text-xl font-medium text-gray-700">
              NO PRODUCTS AVAILABLE
            </p>
            <p class="text-gray-600 mt-2">Please add products to get started</p>
          </div>
        </div>

        <!-- Empty Search Result -->
        <div class="select-none bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex flex-wrap content-center justify-center h-full opacity-80"
          x-show="filteredProducts().length === 0 && keyword.length > 0">
          <div class="w-full text-center p-8">
            <div class="inline-block p-4 bg-white rounded-full shadow-lg mb-4 transform hover:rotate-12 transition-transform">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <p class="text-xl font-medium text-gray-700">
              NO RESULTS FOUND
            </p>
            <p class="text-gray-600 mt-2">for "<span x-text="keyword" class="font-semibold text-gray-800"></span>"</p>
          </div>
        </div>

        <!-- Loading State -->
        <div x-show="isLoading" class="fixed inset-0 flex justify-center items-center bg-white/90 backdrop-blur-sm z-50">
          <div class="text-center">
            <div class="relative h-24 w-24 mx-auto mb-6">
              <div class="absolute inset-0 border-4 border-t-indigo-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin"></div>
              <div class="absolute inset-4 border-4 border-t-cyan-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin animation-delay-200"></div>
              <div class="absolute inset-8 border-4 border-t-purple-500 border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin animation-delay-400"></div>
              <div class="absolute inset-6 flex items-center justify-center">
                <img src="/img/logo/logotamansari.jpeg" alt="Logo" class="h-12 w-12 object-contain rounded-full shadow-md">
              </div>
            </div>
            <p class="text-lg font-semibold text-gray-700">Loading Products</p>
            <p class="text-sm text-gray-500 mt-2">Please wait while we load the menu</p>
          </div>
        </div>

        <!-- Product Grid -->
        <div x-show="filteredProducts().length" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-6">
          <template x-for="product in filteredProducts()" :key="product.id">
            <div role="button"
              class="select-none cursor-pointer transition-all duration-300 overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl relative group border border-gray-100 hover:border-cyan-200"
              :title="product.name" x-on:click="addToCart(product)">
              <!-- Product Loading Spinner -->
              <div x-show="product.isLoading"
                class="absolute inset-0 flex justify-center items-center bg-white/90 backdrop-blur-sm z-10">
                <i class="fas fa-spinner fa-spin text-3xl text-cyan-500"></i>
              </div>

              <!-- Product Image -->
              <div class="relative overflow-hidden h-40">
                <img :src="product.image || '/img/no-image.jpg'" :alt="product.name"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                  @load="handleImageLoad(product)">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <!-- Discount Badge -->
                <div x-show="product.discount" class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full z-10 shadow-md">
                  <span x-text="product.discount + '% OFF'"></span>
                </div>
              </div>

              <!-- Product Info -->
              <div class="p-4">
                <!-- Product Name -->
                <p class="text-lg font-semibold text-gray-800 truncate" x-text="product.name"></p>

                <!-- Category -->
                <div x-show="product.category" class="mt-1">
                  <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full" x-text="product.category"></span>
                </div>

                <!-- Price -->
                <div class="mt-3 flex items-end justify-between">
                  <div x-show="product.stock" class="text-xs text-gray-500">
                    Stock: <span x-text="product.stock" :class="{'text-red-500': product.stock < 5, 'text-green-500': product.stock >= 5}"></span>
                  </div>
                  <div class="text-right">
                    <p x-show="product.discount" class="text-xs line-through text-gray-400" x-text="priceFormat(product.price)"></p>
                    <p class="text-lg font-bold bg-gradient-to-r from-cyan-500 to-blue-500 bg-clip-text text-transparent">
                      <span x-text="priceFormat(product.discount ? product.price * (1 - product.discount/100) : product.price)"></span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
  <!-- End Product Menu Section -->

  <!-- Cart Section (Fixed Height) -->
  <div class="w-full md:w-5/12 flex flex-col bg-gradient-to-b from-white to-gray-50 h-screen px-4 py-6 border-l border-gray-200 overflow-hidden">
    <div class="bg-white rounded-xl flex flex-col h-full shadow-lg border border-gray-100">
      <!-- Empty Cart State -->
      <div x-show="cart.length === 0"
        class="flex-1 w-full p-6 opacity-80 select-none flex flex-col flex-wrap content-center justify-center">
        <div class="inline-block p-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full shadow-inner mb-6 transform hover:rotate-12 transition-transform">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <p class="text-xl font-medium text-gray-700 text-center">
          YOUR CART IS EMPTY
        </p>
        <p class="text-gray-600 text-center mt-2">Add products to start a transaction</p>
      </div>

      <!-- Cart Items (Fixed Height with Scroll) -->
      <div x-show="cart.length > 0" class="flex-1 flex flex-col overflow-hidden">
        <!-- Cart Header (Fixed) -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="ml-2 font-medium text-gray-700">Current Order</span>
            <div x-show="getItemsCount() > 0"
              class="ml-2 bg-cyan-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-sm"
              x-text="getItemsCount()"></div>
          </div>

          <!-- Clear Cart Button -->
          <button x-on:click="clear()" class="text-gray-400 hover:text-red-500 focus:outline-none transition-colors transform hover:scale-110" title="Clear cart">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
          </button>
        </div>

        <!-- Cart Items List (Scrollable) -->
        <div class="flex-1 w-full px-4 py-4 overflow-y-auto">
          <template x-for="item in cart" :key="item.productId">
            <div class="select-none mb-3 bg-gradient-to-br from-gray-50 to-white rounded-lg w-full text-gray-700 py-3 px-3 flex items-center relative group hover:bg-gray-50 transition-all border border-gray-100 shadow-sm">
              <!-- Loading Spinner -->
              <div x-show="item.isLoading"
                class="absolute inset-0 flex justify-center items-center bg-white/90 backdrop-blur-sm rounded-lg z-10">
                <i class="fas fa-spinner fa-spin text-xl text-cyan-500"></i>
              </div>

              <!-- Product Image -->
              <div class="relative">
                <img :src="item.image || '/img/no-image.jpg'" :alt="item.name" class="rounded-lg h-12 w-12 object-cover shadow-sm border border-gray-200">
                <div class="absolute -top-1 -right-1 bg-cyan-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-sm" x-text="item.qty"></div>
              </div>

              <!-- Product Info -->
              <div class="flex-grow ml-3">
                <!-- Product Name -->
                <h5 class="text-sm font-medium" x-text="item.name"></h5>

                <!-- Price -->
                <div class="flex items-center">
                  <p x-show="item.discount" class="text-xs line-through text-gray-400 mr-1" x-text="priceFormat(item.price)"></p>
                  <p class="text-xs text-cyan-600 font-semibold"
                    x-text="priceFormat(item.discount ? item.price * (1 - (item.discount/100)) : item.price)"></p>
                </div>

                <!-- SKU and Barcode -->
                <div class="mt-1 flex flex-wrap gap-x-3 gap-y-1">
                  <span class="text-xs text-gray-500">
                    <i class="fas fa-tag mr-1 text-gray-400"></i>
                    <span x-text="item.sku || 'N/A'"></span>
                  </span>
                  <span class="text-xs text-gray-500">
                    <i class="fas fa-barcode mr-1 text-gray-400"></i>
                    <span x-text="item.barcode || 'N/A'"></span>
                  </span>
                </div>
              </div>

              <!-- Quantity Controls -->
              <div class="ml-3">
                <div class="w-28 grid grid-cols-3 gap-2">
                  <!-- Decrease Quantity -->
                  <button x-on:click="addQty(item, -1)"
                    class="rounded-lg text-center py-1 text-white bg-gradient-to-b from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 focus:outline-none shadow-sm transition-all transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                  </button>

                  <!-- Quantity Input -->
                  <input x-model.number="item.qty" type="text"
                    class="bg-white rounded-lg text-center shadow-sm focus:outline-none focus:ring-1 focus:ring-cyan-500 text-sm border border-gray-200">

                  <!-- Increase Quantity -->
                  <button x-on:click="addQty(item, 1)"
                    class="rounded-lg text-center py-1 text-white bg-gradient-to-b from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 focus:outline-none shadow-sm transition-all transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
      <!-- End Cart Items -->

      <!-- Payment Summary (Fixed) -->
      <div class="w-full px-6 py-4 border-t border-gray-100 bg-gradient-to-b from-white to-gray-50">
        <!-- Total Amount -->
        <div class="flex items-center justify-between mb-4">
          <span class="text-lg font-bold text-gray-700">TOTAL</span>
          <span class="text-xl font-bold bg-gradient-to-r from-cyan-500 to-blue-500 bg-clip-text text-transparent" x-text="priceFormat(getTotalPrice())"></span>
        </div>

        <!-- Cash Input -->
        <div class="mb-4 bg-gradient-to-br from-gray-50 to-white rounded-lg p-4 shadow-inner border border-gray-200">
          <!-- <div class="flex items-center justify-between mb-2">
            <span class="font-medium text-gray-700">CASH</span>
            <div class="flex items-center">
              <span class="mr-2 text-gray-500">Rp</span>
              <input x-bind:value="numberFormat(cash)" x-on:keyup="updateCash($event.target.value)" type="text"
                class="w-32 text-right bg-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none px-3 py-2 font-medium border border-gray-200">
            </div>
          </div> -->
          <!-- Cash Input -->
          <div class="flex items-center justify-between mb-2">
            <span class="font-medium text-gray-700">CASH</span>
            <div class="flex items-center">
              <span class="mr-2 text-gray-500">Rp</span>
              <input x-bind:value="numberFormat(cash)" x-on:keyup="updateCash($event.target.value)" type="text"
                class="w-32 text-right rounded-lg shadow-sm focus:outline-none px-3 py-2 font-medium border transition-colors"
                :class="{
                'border-green-500 text-green-600': cash >= getTotalPrice(),
                'border-gray-300': cash < getTotalPrice()
              }">
            </div>
          </div>

          <!-- Quick Cash Buttons -->
          <div class="grid grid-cols-3 gap-2">
            <template x-for="money in moneys">
              <button x-on:click="addCash(money)"
                class="bg-white rounded-lg shadow-sm hover:shadow-md focus:outline-none px-2 py-2 text-sm transition-all hover:bg-cyan-50 hover:text-cyan-600 border border-gray-200 transform hover:scale-105">
                <i class="fas fa-money-bill-wave mr-1"></i>
                +<span x-text="numberFormat(money)"></span>
              </button>
            </template>
          </div>
        </div>

        <!-- Change Display -->
        <div x-show="change < 0" class="flex items-center justify-between mb-4 rounded-lg p-3 border"
          :class="{
              'bg-green-50 border-green-200 text-green-700': change > 0,
              'bg-red-50 border-red-200 text-red-700': change < 0
            }">
          <span class="font-medium">CHANGE</span>
          <span class="font-bold text-red-600" x-text="priceFormat(Math.abs(change))"></span>
        </div>



        <div x-show="change == 0 && cart.length > 0" class="flex items-center justify-center mb-4 bg-cyan-50 rounded-lg p-3 border border-cyan-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span class="text-cyan-600 font-medium">Exact amount</span>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-2 gap-3">
          <!-- Clear Button -->
          <button x-on:click="clear()"
            class="bg-gradient-to-b from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl py-3 focus:outline-none transition-all shadow-md hover:shadow-lg flex items-center justify-center transform hover:scale-[1.02]">
            <i class="fas fa-trash-alt mr-2"></i>
            CLEAR
          </button>

          <!-- Submit Button -->
          <button class="text-white rounded-xl py-3 focus:outline-none transition-all shadow-md hover:shadow-lg flex items-center justify-center transform hover:scale-[1.02]"
            x-bind:class="{
              'bg-gradient-to-b from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600': submitable(),
              'bg-gray-300 cursor-not-allowed': !submitable(),
              'ring-2 ring-red-500 animate-pulse': !useCustomDate && cart.length > 0
            }"
            :disabled="!submitable()"
            x-on:click="submit()"
            :title="!useCustomDate ? 'Please set transaction date first' : ''">
            <i class="fas fa-check-circle mr-2"></i>
            SUBMIT
          </button>
        </div>
      </div>
      <!-- End Payment Summary -->
    </div>
  </div>
  <!-- End Cart Section -->
</div>

<!-- First Time Setup Modal -->
<div x-show="firstTime" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
  <div class="w-full max-w-md bg-white rounded-2xl overflow-hidden shadow-2xl transform transition-all">
    <div class="p-8 text-center">
      <div class="inline-block p-4 bg-gradient-to-r from-cyan-100 to-blue-100 rounded-full shadow-inner mb-6 transform hover:rotate-6 transition-transform">
        <img src="/img/logo/logotamansari.jpeg" alt="Taman Sari Logo" class="h-16 w-16 rounded-full object-cover border-2 border-white shadow-md">
      </div>
      <h3 class="text-2xl font-bold text-gray-800 mb-2">FIRST TIME SETUP</h3>
      <p class="text-gray-600 mb-8">How would you like to start?</p>

      <div class="space-y-4">
        <button x-on:click="startWithSampleData()"
          class="w-full text-left rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500 text-white focus:outline-none hover:shadow-lg px-6 py-4 transition-all flex items-center transform hover:scale-[1.02]">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
          </svg>
          LOAD SAMPLE DATA
        </button>

        <button x-on:click="startBlank()"
          class="w-full text-left rounded-xl bg-gradient-to-r from-gray-500 to-gray-600 text-white focus:outline-none hover:shadow-lg px-6 py-4 transition-all flex items-center transform hover:scale-[1.02]">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          START WITH EMPTY SYSTEM
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Receipt Modal -->
<div x-show="isShowModalReceipt" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" x-on:click="closeModalReceipt()"></div>

  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden z-10 transform transition-all border border-gray-200">
    <!-- Receipt Content -->
    <div id="receipt-content" class="w-full text-sm p-6 overflow-auto bg-white">
      <div class="text-center">
        <!-- Logo and Header -->
        <div class="flex justify-center mb-3">
          <img src="/img/logo/logotamansari.jpeg" alt="Taman Sari Watersport"
            class="w-16 h-16 object-contain rounded-full border-2 border-cyan-500 shadow-md">
        </div>
        <h2 class="text-xl font-bold text-gray-800 uppercase">Taman Sari Watersport</h2>
        <p class="text-sm text-gray-600 font-medium">POS Tanjung Benoa</p>
        <p class="text-xs text-gray-500 mt-1">Jl. Pratama, Tanjung Benoa, Bali</p>
        <p class="text-xs text-gray-500">Tel: (0361) 1234567</p>

        <!-- Receipt Info -->
        <div class="mt-4 border-t-2 border-b-2 border-gray-200 py-2">
          <p class="text-sm font-bold">SALES RECEIPT</p>
          <div class="flex justify-between text-xs mt-1">
            <span>No: <span x-text="receiptNo" class="font-medium"></span></span>
            <span x-text="receiptDate" class="text-gray-600"></span>
          </div>
        </div>
      </div>

      <!-- Items List -->
      <table class="w-full text-xs mb-2">
        <thead>
          <tr class="border-b border-gray-300">
            <th class="py-1 w-1/12 text-left">No</th>
            <th class="py-1 text-left">Item</th>
            <th class="py-1 w-3/12 text-right">Price</th>
            <th class="py-1 w-2/12 text-center">Qty</th>
            <th class="py-1 w-3/12 text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="(item, index) in cart" :key="item">
            <tr class="border-b border-gray-100">
              <td class="py-2 text-left" x-text="index+1"></td>
              <td class="py-2 text-left">
                <span x-text="item.name" class="font-medium block"></span>
                <span x-show="item.sku" class="text-gray-500 text-xxs" x-text="'SKU: ' + item.sku"></span>
              </td>
              <td class="py-2 text-right" x-text="priceFormat(item.discount ? item.price * (1 - item.discount/100) : item.price)"></td>
              <td class="py-2 text-center" x-text="item.qty"></td>
              <td class="py-2 text-right font-medium"
                x-text="priceFormat(item.qty * (item.discount ? item.price * (1 - item.discount/100) : item.price))"></td>
            </tr>
          </template>
        </tbody>
      </table>

      <!-- Totals -->
      <div class="space-y-2 mt-4">
        <div class="flex justify-between text-sm">
          <span class="font-medium">Subtotal:</span>
          <span x-text="priceFormat(getTotalPrice())"></span>
        </div>

        <div class="flex justify-between text-sm">
          <span class="font-medium">Cash:</span>
          <span x-text="priceFormat(cash)"></span>
        </div>

        <div class="flex justify-between text-lg font-bold mt-2 pt-2 border-t-2 border-gray-200">
          <span>Change:</span>
          <span x-text="priceFormat(change)"
            :class="{'text-green-600': change > 0, 'text-red-600': change < 0}"></span>
        </div>
      </div>

      <!-- Payment Method -->
      <div class="mt-4 text-center text-xs">
        <p class="font-medium">Payment Method: CASH</p>
      </div>

      <!-- Footer Message -->
      <div class="text-center mt-6 text-xs text-gray-500 space-y-1">
        <p>Thank you for your purchase!</p>
        <p class="text-xxs">** Please keep this receipt for warranty purposes **</p>
        <div class="mt-4 pt-2 border-t border-gray-200">
          <p class="text-xxs">Powered by Taman Sari POS System</p>
          <p class="text-xxs" x-text="new Date().getFullYear() + ' © All Rights Reserved'"></p>
        </div>
      </div>
    </div>

    <!-- Action Button -->
    <div class="p-4 bg-gray-50 border-t border-gray-200 no-print">
      <button class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white py-3 rounded-xl focus:outline-none hover:shadow-lg transition-all flex items-center justify-center transform hover:scale-[1.02]"
        x-on:click="printAndProceed()">
        <i class="fas fa-print mr-2"></i>
        PRINT & CONTINUE
      </button>
    </div>
  </div>
</div>
@endsection