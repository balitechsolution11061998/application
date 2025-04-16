@extends('pos.index')

@section('content')
<div x-show="isLoggedIn" class="hide-print">
    <!-- Enhanced Header with Quick Stats -->
    <header class="bg-gradient-to-r from-cyan-600 to-blue-600 shadow-lg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <img src="/img/logo/logotamansari.jpeg" alt="Logo" class="h-10 w-10 rounded-full mr-3 border-2 border-white">
                        <h1 class="text-xl font-bold">TAMAN SARI POS</h1>
                    </div>
                    <div class="hidden md:flex space-x-6">
                        <button @click="activeTab = 'pos'" class="px-3 py-1 rounded-lg transition-all" 
                                :class="{'bg-white text-cyan-600 shadow-md': activeTab === 'pos', 'hover:bg-cyan-700': activeTab !== 'pos'}">
                            <i class="fas fa-cash-register mr-2"></i> POS
                        </button>
                        <button @click="activeTab = 'products'" class="px-3 py-1 rounded-lg transition-all"
                                :class="{'bg-white text-cyan-600 shadow-md': activeTab === 'products', 'hover:bg-cyan-700': activeTab !== 'products'}">
                            <i class="fas fa-boxes mr-2"></i> Products
                        </button>
                        <button @click="activeTab = 'reports'" class="px-3 py-1 rounded-lg transition-all"
                                :class="{'bg-white text-cyan-600 shadow-md': activeTab === 'reports', 'hover:bg-cyan-700': activeTab !== 'reports'}">
                            <i class="fas fa-chart-bar mr-2"></i> Reports
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Quick Stats -->
                    <div class="hidden md:flex space-x-4">
                        <div class="text-center px-3 py-1 bg-white bg-opacity-20 rounded-lg">
                            <div class="text-xs opacity-80">Today's Sales</div>
                            <div class="font-bold">Rp <span x-text="numberFormat(3450000)"></span></div>
                        </div>
                        <div class="text-center px-3 py-1 bg-white bg-opacity-20 rounded-lg">
                            <div class="text-xs opacity-80">Transactions</div>
                            <div class="font-bold" x-text="24"></div>
                        </div>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=0D8ABC" alt="">
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-user-circle mr-2"></i> Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                            <a href="#" @click.prevent="logout()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Tabs -->
    <div class="md:hidden bg-white shadow-sm">
        <div class="flex justify-around">
            <button @click="activeTab = 'pos'" class="py-3 px-4 text-center"
                    :class="{'text-cyan-600 border-b-2 border-cyan-600': activeTab === 'pos', 'text-gray-500': activeTab !== 'pos'}">
                <i class="fas fa-cash-register block text-xl mb-1"></i>
                <span class="text-xs">POS</span>
            </button>
            <button @click="activeTab = 'products'" class="py-3 px-4 text-center"
                    :class="{'text-cyan-600 border-b-2 border-cyan-600': activeTab === 'products', 'text-gray-500': activeTab !== 'products'}">
                <i class="fas fa-boxes block text-xl mb-1"></i>
                <span class="text-xs">Products</span>
            </button>
            <button @click="activeTab = 'reports'" class="py-3 px-4 text-center"
                    :class="{'text-cyan-600 border-b-2 border-cyan-600': activeTab === 'reports', 'text-gray-500': activeTab !== 'reports'}">
                <i class="fas fa-chart-bar block text-xl mb-1"></i>
                <span class="text-xs">Reports</span>
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- POS Interface (Default View) -->
        <div x-show="activeTab === 'pos'" x-transition>
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Product Search and Grid -->
                <div class="flex-1 bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" x-model="keyword"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-lg"
                                   placeholder="Search products...">
                        </div>
                    </div>

                    <div class="h-full overflow-hidden">
                        <div class="h-full overflow-y-auto p-4">
                            <!-- Empty State -->
                            <div x-show="products.length === 0" class="flex flex-col items-center justify-center py-12 text-gray-400">
                                <i class="fas fa-box-open text-5xl mb-4"></i>
                                <p class="text-xl font-medium">No products available</p>
                                <p class="text-sm mt-1">Add products to get started</p>
                            </div>

                            <!-- Search Empty State -->
                            <div x-show="filteredProducts().length === 0 && keyword.length > 0" class="flex flex-col items-center justify-center py-12 text-gray-400">
                                <i class="fas fa-search text-5xl mb-4"></i>
                                <p class="text-xl font-medium">No results found</p>
                                <p class="text-sm mt-1">Try a different search term</p>
                            </div>

                            <!-- Loading State -->
                            <div x-show="isLoading" class="flex justify-center py-12">
                                <i class="fas fa-spinner fa-spin text-4xl text-cyan-500"></i>
                            </div>

                            <!-- Product Grid -->
                            <div x-show="filteredProducts().length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <template x-for="product in filteredProducts()" :key="product.id">
                                    <div @click="addToCart(product)" 
                                         class="group relative bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow cursor-pointer">
                                        <!-- Product Loading -->
                                        <div x-show="product.isLoading" class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center z-10">
                                            <i class="fas fa-spinner fa-spin text-2xl text-cyan-500"></i>
                                        </div>
                                        
                                        <!-- Product Image -->
                                        <div class="h-32 bg-gray-100 flex items-center justify-center overflow-hidden">
                                            <img :src="product.image" :alt="product.name" 
                                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                 @load="handleImageLoad(product)">
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="p-3">
                                            <h3 class="font-semibold text-gray-800 truncate" x-text="product.name"></h3>
                                            <div class="mt-1 flex justify-between items-center">
                                                <span class="text-sm text-gray-500">
                                                    <i class="fas fa-barcode mr-1"></i>
                                                    <span x-text="product.upc || 'N/A'"></span>
                                                </span>
                                                <span class="font-bold text-cyan-600" x-text="priceFormat(product.price)"></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Quick Add Badge -->
                                        <div class="absolute top-2 right-2 bg-cyan-500 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-md">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shopping Cart -->
                <div class="w-full lg:w-96 bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Order Summary
                            <span x-show="cart.length > 0" class="ml-auto bg-cyan-500 text-white text-xs font-bold px-2 py-1 rounded-full" x-text="getItemsCount()"></span>
                        </h2>
                    </div>

                    <!-- Empty Cart -->
                    <div x-show="cart.length === 0" class="flex flex-col items-center justify-center py-12 text-gray-400">
                        <i class="fas fa-shopping-cart text-5xl mb-4"></i>
                        <p class="text-lg font-medium">Your cart is empty</p>
                        <p class="text-sm mt-1">Add products to continue</p>
                    </div>

                    <!-- Cart Items -->
                    <div x-show="cart.length > 0" class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                        <template x-for="(item, index) in cart" :key="item.productId">
                            <div class="p-3 hover:bg-gray-50 transition-colors relative">
                                <!-- Loading Overlay -->
                                <div x-show="item.isLoading" class="absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center z-10">
                                    <i class="fas fa-spinner fa-spin text-xl text-cyan-500"></i>
                                </div>
                                
                                <div class="flex items-start">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-lg overflow-hidden">
                                        <img :src="item.image" :alt="item.name" class="h-full w-full object-cover">
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="ml-3 flex-1">
                                        <h3 class="text-sm font-medium text-gray-800" x-text="item.name"></h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <span x-text="priceFormat(item.price)"></span>
                                            <span x-show="item.qty > 1" class="ml-1">
                                                × <span x-text="item.qty"></span> = <span class="font-semibold" x-text="priceFormat(item.price * item.qty)"></span>
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="ml-2">
                                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                            <button @click="addQty(item, -1)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 transition-colors">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input x-model.number="item.qty" type="text" 
                                                   class="w-10 text-center border-0 focus:ring-0 focus:outline-none">
                                            <button @click="addQty(item, 1)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Remove Button -->
                                    <button @click="removeFromCart(index)" class="ml-2 text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Payment Summary -->
                    <div x-show="cart.length > 0" class="border-t border-gray-100 p-4">
                        <div class="space-y-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total:</span>
                                <span x-text="priceFormat(getTotalPrice())"></span>
                            </div>
                            
                            <!-- Cash Input -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cash Payment</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">Rp</span>
                                    </div>
                                    <input x-bind:value="numberFormat(cash)" @keyup="updateCash($event.target.value)"
                                           type="text" class="focus:ring-cyan-500 focus:border-cyan-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md py-3">
                                </div>
                                
                                <!-- Quick Cash Buttons -->
                                <div class="grid grid-cols-4 gap-2 mt-2">
                                    <template x-for="money in moneys">
                                        <button @click="addCash(money)" class="text-xs bg-gray-100 hover:bg-gray-200 rounded-md py-1 transition-colors">
                                            +<span x-text="numberFormat(money)"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Change Display -->
                            <div x-show="change !== 0" class="p-3 rounded-lg"
                                 :class="{'bg-green-50 text-green-800': change > 0, 'bg-red-50 text-red-800': change < 0}">
                                <div class="flex justify-between font-medium">
                                    <span x-text="change > 0 ? 'Change:' : 'Amount Due:'"></span>
                                    <span x-text="priceFormat(Math.abs(change))"></span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2 pt-2">
                                <button @click="clear()" class="flex-1 bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                                    <i class="fas fa-trash-alt mr-2"></i> Clear
                                </button>
                                <button @click="submit()" :disabled="!submitable()"
                                        class="flex-1 py-3 rounded-lg font-medium transition-colors flex items-center justify-center"
                                        :class="{
                                            'bg-cyan-500 hover:bg-cyan-600 text-white': submitable(),
                                            'bg-gray-200 text-gray-500 cursor-not-allowed': !submitable()
                                        }">
                                    <i class="fas fa-check-circle mr-2"></i> Process
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Management Tab -->
        <div x-show="activeTab === 'products'" x-transition class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="fas fa-boxes mr-2"></i>
                    Product Management
                </h2>
            </div>
            
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500" placeholder="Search products...">
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-md flex items-center transition-colors">
                        <i class="fas fa-plus mr-2"></i> Add Product
                    </button>
                </div>
                
                <!-- Products Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40?text=PB" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Banana Boat</div>
                                            <div class="text-sm text-gray-500">Water Sports</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">PROD-001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 250,000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-cyan-600 hover:text-cyan-900 mr-3"><i class="fas fa-edit"></i></button>
                                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <!-- More product rows... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reports Tab -->
        <div x-show="activeTab === 'reports'" x-transition class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Sales Reports
                </h2>
            </div>
            
            <div class="p-4">
                <!-- Date Range Selector -->
                <div class="flex items-center space-x-4 mb-6">
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700">From:</label>
                        <input type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                    </div>
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700">To:</label>
                        <input type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                    </div>
                    <button class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-md flex items-center transition-colors">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-money-bill-wave text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total Sales</h3>
                                <p class="text-2xl font-semibold text-gray-900">Rp 12,450,000</p>
                                <p class="text-xs text-green-600 mt-1"><i class="fas fa-arrow-up mr-1"></i> 12% from last week</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-shopping-cart text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Transactions</h3>
                                <p class="text-2xl font-semibold text-gray-900">84</p>
                                <p class="text-xs text-green-600 mt-1"><i class="fas fa-arrow-up mr-1"></i> 8% from last week</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Customers</h3>
                                <p class="text-2xl font-semibold text-gray-900">56</p>
                                <p class="text-xs text-red-600 mt-1"><i class="fas fa-arrow-down mr-1"></i> 3% from last week</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sales Chart -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Sales Overview</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-sm bg-cyan-500 text-white rounded-md">Daily</button>
                            <button class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded-md">Weekly</button>
                            <button class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded-md">Monthly</button>
                        </div>
                    </div>
                    <div class="h-64">
                        <!-- Chart would go here - using a placeholder -->
                        <div class="w-full h-full bg-gray-100 rounded flex items-center justify-center text-gray-400">
                            <i class="fas fa-chart-line text-4xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Top Products -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Top Selling Products</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                                <i class="fas fa-ship"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <span class="text-sm font-medium">Banana Boat</span>
                                    <span class="text-sm font-semibold">Rp 3,250,000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                        <!-- More top products... -->
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- First Time Modal -->
<div x-show="firstTime" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-cyan-100 mb-4">
                <i class="fas fa-store text-cyan-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome to Taman Sari POS</h3>
            <p class="text-sm text-gray-500 mb-6">Get started by loading sample data or setting up your own products</p>
            
            <div class="space-y-3">
                <button @click="startWithSampleData()" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i> Load Sample Data
                </button>
                <button @click="startBlank()" class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i> Start Fresh
                </button>
            </div>
        </div>
    </div>
</div>


@endsection