@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Header Section with Glass Morphism Effect -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 rounded-xl p-6 mb-6 shadow-lg backdrop-blur-sm bg-opacity-90">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white">Products Management</h1>
                <p class="text-blue-100 dark:text-blue-200 mt-1 sm:mt-2 text-sm sm:text-base">Efficiently manage your product inventory</p>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-3 w-full md:w-auto mt-3 sm:mt-0">
                <a href="{{ route('products.create') }}"
                    class="flex-1 md:flex-none flex items-center justify-center px-4 sm:px-5 py-2 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-600 dark:text-white rounded-lg shadow-md transition-all duration-300 group">
                    <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap">Add Product</span>
                </a>
                <button id="exportBtn" class="px-3 sm:px-4 py-2 border border-white dark:border-gray-600 rounded-lg bg-transparent text-white hover:bg-white hover:text-blue-600 dark:hover:bg-gray-700 transition-colors duration-200 flex items-center">
                    <i class="fas fa-file-export mr-1 sm:mr-2"></i>
                    <span class="hidden sm:inline">Export</span>
                </button>
                <button id="importExcelBtn" class="flex-1 md:flex-none flex items-center justify-center px-4 sm:px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg shadow-md transition-all duration-300 group">
                    <i class="fas fa-file-import mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap">Import Excel</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50 w-full max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="p-4 sm:p-5 md:p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-blue-50/70 to-indigo-50/70 dark:from-gray-800/50 dark:to-gray-700/50">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Product Inventory</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Browse, search and manage your product catalog</p>
                </div>
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-medium text-blue-600 dark:text-blue-400">16</span> total products
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="p-3 sm:p-4 md:p-5 border-b border-gray-200/50 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-700/30">
            <div class="flex flex-col space-y-3 sm:space-y-4">
                <!-- Search Bar -->
                <div class="relative w-full group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search text-sm sm:text-base"></i>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-10 pr-4 py-2 sm:py-2.5 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 group-hover:shadow-md text-sm sm:text-base"
                        placeholder="Search products...">
                </div>

                <!-- Filter Controls -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3">
                    <!-- Status Filter -->
                    <div class="relative group">
                        <label for="statusFilter" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 ml-1">Status</label>
                        <select id="statusFilter" x-model="statusFilter" class="appearance-none w-full bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 group-hover:shadow-md text-sm sm:text-base">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="pointer-events-none absolute right-0 bottom-0 flex items-center px-2 sm:px-3 py-2 sm:py-2.5 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-chevron-down text-xs sm:text-sm"></i>
                        </div>
                    </div>

                    <!-- Company Filter -->
                    <div class="relative group">
                        <label for="companyFilter" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 ml-1">Company</label>
                        <select id="companyFilter" x-model="companyFilter" class="appearance-none w-full bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 group-hover:shadow-md text-sm sm:text-base">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute right-0 bottom-0 flex items-center px-2 sm:px-3 py-2 sm:py-2.5 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-chevron-down text-xs sm:text-sm"></i>
                        </div>
                    </div>

                    <!-- Stock Filter -->
                    <div class="relative group">
                        <label for="stockFilter" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 ml-1">Stock Level</label>
                        <select id="stockFilter" x-model="stockFilter" class="appearance-none w-full bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 group-hover:shadow-md text-sm sm:text-base">
                            <option value="">All Stock Levels</option>
                            <option value="in_stock">In Stock</option>
                            <option value="low_stock">Low Stock</option>
                            <option value="critical">Critical Stock</option>
                        </select>
                        <div class="pointer-events-none absolute right-0 bottom-0 flex items-center px-2 sm:px-3 py-2 sm:py-2.5 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-chevron-down text-xs sm:text-sm"></i>
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <div class="flex items-center sm:justify-end">
                        <button @click="applyFilters()" class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-1 sm:gap-2 shadow-sm hover:shadow-md text-sm sm:text-base">
                            <i class="fas fa-filter text-sm sm:text-base"></i>
                            <span>Apply Filters</span>
                        </button>
                        <button @click="resetFilters()" class="w-full sm:w-auto px-3 sm:px-4 py-2 text-gray-600 dark:text-gray-300 bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 flex items-center justify-center gap-1 sm:gap-2 shadow-sm hover:shadow-md text-sm sm:text-base">
                            <i class="fas fa-filter-circle-xmark text-sm sm:text-base"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div x-data="productTable()" x-init="init()" class="flex flex-col h-full">
            <!-- Table Section -->
            <div class="overflow-x-auto flex-1">
                <!-- Desktop Table -->
                <table class="hidden md:table min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    <thead class="bg-gray-50/70 dark:bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                @click="changeSort('name')">
                                Product
                                <i class="fas ml-1"
                                    :class="{
                               'fa-sort': sortField !== 'name',
                               'fa-sort-up': sortField === 'name' && sortDirection === 'asc',
                               'fa-sort-down': sortField === 'name' && sortDirection === 'desc'
                           }"></i>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                @click="changeSort('sku')">
                                SKU
                                <i class="fas ml-1"
                                    :class="{
                               'fa-sort': sortField !== 'sku',
                               'fa-sort-up': sortField === 'sku' && sortDirection === 'asc',
                               'fa-sort-down': sortField === 'sku' && sortDirection === 'desc'
                           }"></i>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                @click="changeSort('price')">
                                Price
                                <i class="fas ml-1"
                                    :class="{
                               'fa-sort': sortField !== 'price',
                               'fa-sort-up': sortField === 'price' && sortDirection === 'asc',
                               'fa-sort-down': sortField === 'price' && sortDirection === 'desc'
                           }"></i>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                @click="changeSort('stock')">
                                Stock
                                <i class="fas ml-1"
                                    :class="{
                               'fa-sort': sortField !== 'stock',
                               'fa-sort-up': sortField === 'stock' && sortDirection === 'asc',
                               'fa-sort-down': sortField === 'stock' && sortDirection === 'desc'
                           }"></i>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                @click="changeSort('status')">
                                Status
                                <i class="fas ml-1"
                                    :class="{
                               'fa-sort': sortField !== 'status',
                               'fa-sort-up': sortField === 'status' && sortDirection === 'asc',
                               'fa-sort-down': sortField === 'status' && sortDirection === 'desc'
                           }"></i>
                            </th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/50 dark:bg-gray-800/30 divide-y divide-gray-200/50 dark:divide-gray-700/50">
                        <template x-for="product in products" :key="product.id">
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors duration-150 group">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600 mr-3">
                                            <i class="fas fa-box text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" x-text="product.name"></div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400" x-text="product.category || 'No category'"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <span class="font-mono" x-text="product.sku"></span>
                                        <button @click="copyToClipboard(product.sku)" class="ml-2 text-gray-400 hover:text-blue-500 transition-colors" title="Copy to clipboard">
                                            <i class="far fa-copy text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white" x-text="formatPrice(product.price)"></td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <span x-text="product.stock"></span>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">(Min: <span x-text="product.min_stock"></span>)</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300" x-text="product.company"></td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full flex items-center justify-center w-20"
                                        :class="{
                                      'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': product.status === 'active',
                                      'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': product.status === 'inactive',
                                      'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': product.status === 'pending'
                                  }">
                                        <span class="w-2 h-2 rounded-full mr-2"
                                            :class="{
                                          'bg-green-500': product.status === 'active',
                                          'bg-red-500': product.status === 'inactive',
                                          'bg-yellow-500': product.status === 'pending'
                                      }"></span>
                                        <span x-text="product.status"></span>
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button @click="viewProduct(product.id)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors p-1 rounded-md hover:bg-blue-100/50 dark:hover:bg-blue-900/30">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button @click="editProduct(product.id)" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors p-1 rounded-md hover:bg-yellow-100/50 dark:hover:bg-yellow-900/30">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="confirmDelete(product.id)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors p-1 rounded-md hover:bg-red-100/50 dark:hover:bg-red-900/30">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <!-- Loading state -->
                        <tr x-show="loading">
                            <td colspan="7" class="px-4 py-6 text-center">
                                <div class="flex justify-center">
                                    <i class="fas fa-circle-notch fa-spin text-2xl text-blue-500"></i>
                                </div>
                            </td>
                        </tr>

                        <!-- Empty state -->
                        <tr x-show="!loading && products.length === 0">
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No products found
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Mobile Cards -->
                <div class="md:hidden p-3 space-y-3">
                    <template x-for="product in products" :key="product.id">
                        <div class="bg-white/70 dark:bg-gray-800/50 rounded-lg shadow p-4 border border-gray-200/50 dark:border-gray-700/50 transition-all duration-200 hover:shadow-md hover:border-blue-300/50 dark:hover:border-blue-700/50">
                            <div class="flex items-start space-x-3">
                                <div class="h-12 w-12 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600">
                                    <i class="fas fa-box text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-gray-900 dark:text-white truncate" x-text="product.name"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="product.category || 'No category'"></div>

                                    <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <div class="text-gray-500 dark:text-gray-400 text-xs">SKU</div>
                                            <div class="text-gray-700 dark:text-gray-300 font-mono" x-text="product.sku"></div>
                                        </div>
                                        <div>
                                            <div class="text-gray-500 dark:text-gray-400 text-xs">Price</div>
                                            <div class="text-gray-700 dark:text-gray-300" x-text="formatPrice(product.price)"></div>
                                        </div>
                                        <div>
                                            <div class="text-gray-500 dark:text-gray-400 text-xs">Stock</div>
                                            <div class="text-gray-700 dark:text-gray-300">
                                                <span x-text="product.stock"></span>
                                                <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">(Min: <span x-text="product.min_stock"></span>)</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-gray-500 dark:text-gray-400 text-xs">Status</div>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full flex items-center justify-center w-20"
                                                :class="{
        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': product.status === 'active',
        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': product.status === 'inactive',
        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': product.status === 'pending'
    }">
                                                <span class="w-2 h-2 rounded-full mr-2"
                                                    :class="{
            'bg-green-500': product.status === 'active',
            'bg-red-500': product.status === 'inactive',
            'bg-yellow-500': product.status === 'pending'
        }"></span>
                                                <span x-text="product.status === 'active' ? 'Active' : 'Inactive'"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 flex justify-end space-x-2 border-t border-gray-100 dark:border-gray-700 pt-3">
                                <button @click="viewProduct(product.id)" class="p-2 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-800/50 transition-colors">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="editProduct(product.id)" class="p-2 rounded-md bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-100 dark:hover:bg-yellow-800/50 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="confirmDelete(product.id)" class="p-2 rounded-md bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-800/50 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Loading state -->
                    <div x-show="loading" class="flex justify-center py-6">
                        <i class="fas fa-circle-notch fa-spin text-2xl text-blue-500"></i>
                    </div>

                    <!-- Empty state -->
                    <div x-show="!loading && products.length === 0" class="text-center py-6 text-gray-500 dark:text-gray-400">
                        No products found
                    </div>
                </div>
            </div>

            <!-- Enhanced Pagination -->
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200/50 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between bg-gray-50/70 dark:bg-gray-700/30">
                <div class="mb-3 sm:mb-0 text-sm text-gray-600 dark:text-gray-400">
                    Showing <span class="font-medium text-gray-800 dark:text-gray-200" x-text="from"></span> to <span class="font-medium text-gray-800 dark:text-gray-200" x-text="to"></span> of <span class="font-medium text-gray-800 dark:text-gray-200" x-text="total"></span> products
                </div>

                <div class="flex items-center space-x-1">
                    <button @click="previousPage()" :disabled="currentPage === 1" class="px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <template x-for="page in pages" :key="page">
                        <button @click="changePage(page)"
                            class="px-3 py-1.5 rounded-md border transition-colors"
                            :class="{
                        'border-blue-500 bg-blue-500 text-white hover:bg-blue-600': currentPage === page,
                        'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600': currentPage !== page
                    }"
                            x-text="page"></button>
                    </template>

                    <button @click="nextPage()" :disabled="currentPage === lastPage" class="px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Quick View Panel (Slide-over) with Glass Morphism -->
<div id="quickViewPanel" class="fixed inset-y-0 right-0 z-40 w-full max-w-md transform transition-transform duration-300 translate-x-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-xl border-l border-gray-200/50 dark:border-gray-700/50">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick View</h3>
        <button id="closeQuickView" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
            <i class="fas fa-times h-6 w-6"></i>
        </button>
    </div>
    <div class="p-6 overflow-y-auto h-[calc(100%-65px)]" id="quickViewContent">
        <!-- Content will be loaded here -->
    </div>
</div>
<div id="quickViewOverlay" class="fixed inset-0 z-30 bg-black/50 hidden"></div>

<!-- Success Notification -->
<div id="successNotification" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="successMessage"></span>
    </div>
</div>

<!-- Error Notification -->
<div id="errorNotification" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span id="errorMessage"></span>
    </div>
</div>

@endsection

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
        transition: background 0.3s;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }

    .dark ::-webkit-scrollbar-track {
        background: #374151;
    }

    .dark ::-webkit-scrollbar-thumb {
        background: #6b7280;
    }

    .dark ::-webkit-scrollbar-thumb:hover {
        background: #4b5563;
    }

    /* Table row hover effect */
    #productsTable tbody tr {
        transition: all 0.2s ease;
    }

    #productsTable tbody tr:hover {
        background-color: rgba(248, 250, 252, 0.7);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .dark #productsTable tbody tr:hover {
        background-color: rgba(31, 41, 55, 0.7);
    }

    /* Status badges */
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s;
    }

    .status-badge i {
        margin-right: 0.25rem;
    }

    .status-active {
        background-color: rgba(220, 252, 231, 0.7);
        color: #166534;
    }

    .status-inactive {
        background-color: rgba(254, 226, 226, 0.7);
        color: #991b1b;
    }

    .dark .status-active {
        background-color: rgba(20, 83, 45, 0.7);
        color: #bbf7d0;
    }

    .dark .status-inactive {
        background-color: rgba(127, 29, 29, 0.7);
        color: #fecaca;
    }

    /* Quick view panel animation */
    .quick-view-transition {
        transition: transform 0.3s ease-out;
    }

    /* Fade-in animation */
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

    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    /* Pulse animation for loading */
    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@push('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    // Ensure Alpine.js is fully loaded before defining the component
    document.addEventListener('alpine:init', () => {
        Alpine.magic('formatCurrency', () => {
            return (value) => {
                if (value === null || value === undefined) return 'Rp 0';
                const num = typeof value === 'string' ? parseFloat(value.replace(/[^0-9.-]/g, '')) : value;
                return 'Rp ' + num.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            };
        });
        Alpine.data('productTable', function() {
            return {
                // Explicitly initialize all properties with default values
                products: [],
                loading: false,
                sortField: 'name',
                sortDirection: 'asc',
                currentPage: 1,
                perPage: 10,
                total: 0,
                pages: [],
                lastPage: 1,
                searchQuery: '',
                statusFilter: '',
                companyFilter: '',
                stockFilter: '',
                searchTimeout: null,

                // Lifecycle method to ensure proper initialization
                init() {
                    // Explicitly set loading to false
                    this.loading = false;
                    this.products = [];

                    // Initial data fetch
                    this.fetchData();

                    // Watchers for filters
                    this.$watch('statusFilter', () => this.applyFilters());
                    this.$watch('companyFilter', () => this.applyFilters());
                    this.$watch('stockFilter', () => this.applyFilters());

                    // Search input handler
                    const searchInput = document.getElementById('searchInput');
                    if (searchInput) {
                        searchInput.addEventListener('input', (e) => {
                            this.searchQuery = e.target.value;
                            clearTimeout(this.searchTimeout);
                            this.searchTimeout = setTimeout(() => {
                                this.applyFilters();
                            }, 500);
                        });
                    }
                },

                async fetchData() {
                    // Explicitly set loading state at the start of fetch
                    this.loading = true;
                    this.products = [];

                    try {
                        const params = new URLSearchParams({
                            sort: this.sortField,
                            direction: this.sortDirection,
                            page: this.currentPage,
                            per_page: this.perPage,
                            status: this.statusFilter,
                            company: this.companyFilter,
                            stock_status: this.stockFilter,
                            search: this.searchQuery
                        });

                        const response = await fetch(`/product/list-data?${params.toString()}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        const data = await response.json();

                        // Map products with safe defaults
                        this.products = data.data.map(product => ({
                            ...product,
                            companyName: product.company?.name || 'Internal Operations',
                            status: product.status,  // Use the existing status field
                            displayStatus: product.status === 'active' ? 'Active' : 'Inactive',
                            imageUrl: product.image_url || '/images/default-product.png',
                            formattedPrice: `Rp ${this.formatNumber(product.price)}`
                        }));

                        this.currentPage = data.current_page;
                        this.perPage = data.per_page;
                        this.total = data.total;
                        this.lastPage = data.last_page;

                        this.updatePagination();

                    } catch (error) {
                        console.error('Error:', error);
                        this.products = [];
                        this.total = 0;
                        this.lastPage = 1;
                    } finally {
                        // Ensure loading is set to false after fetch
                        this.loading = false;
                    }
                },

                applyFilters() {
                    this.currentPage = 1;
                    this.fetchData();
                },

                // Rest of the methods remain the same
                changeSort(field) {
                    if (this.sortField === field) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortField = field;
                        this.sortDirection = 'asc';
                    }
                    this.fetchData();
                },

                changePage(page) {
                    if (page >= 1 && page <= this.lastPage) {
                        this.currentPage = page;
                        this.fetchData();
                    }
                },

                nextPage() {
                    if (this.currentPage < this.lastPage) {
                        this.currentPage++;
                        this.fetchData();
                    }
                },

                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.fetchData();
                    }
                },

                updatePagination() {
                    const pages = [];
                    const maxVisiblePages = 5;
                    let startPage, endPage;

                    if (this.lastPage <= maxVisiblePages) {
                        startPage = 1;
                        endPage = this.lastPage;
                    } else {
                        if (this.currentPage <= Math.ceil(maxVisiblePages / 2)) {
                            startPage = 1;
                            endPage = maxVisiblePages;
                        } else if (this.currentPage + Math.floor(maxVisiblePages / 2) >= this.lastPage) {
                            startPage = this.lastPage - maxVisiblePages + 1;
                            endPage = this.lastPage;
                        } else {
                            startPage = this.currentPage - Math.floor(maxVisiblePages / 2);
                            endPage = this.currentPage + Math.floor(maxVisiblePages / 2);
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        pages.push(i);
                    }

                    this.pages = pages;
                },

                resetFilters() {
                    this.statusFilter = '';
                    this.companyFilter = '';
                    this.stockFilter = '';
                    this.searchQuery = '';

                    // Reset input fields
                    const inputs = [
                        'searchInput',
                        'statusFilter',
                        'companyFilter',
                        'stockFilter'
                    ];

                    inputs.forEach(inputId => {
                        const input = document.getElementById(inputId);
                        if (input) input.value = '';
                    });

                    this.sortField = 'name';
                    this.sortDirection = 'asc';
                    this.currentPage = 1;
                    this.fetchData();
                },

                formatNumber(num) {
                    return num ? num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '0';
                },

                formatPrice(price) {
                    return price ? `Rp ${this.formatNumber(price)}` : 'Rp 0';
                },

                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.showNotification('success', 'SKU copied to clipboard!');
                    }).catch(err => {
                        console.error('Failed to copy:', err);
                    });
                },

                showNotification(type, message) {
                    const notification = document.getElementById(`${type}Notification`);
                    const messageElement = document.getElementById(`${type}Message`);

                    if (notification && messageElement) {
                        messageElement.textContent = message;
                        notification.classList.remove('hidden');
                        setTimeout(() => {
                            notification.classList.add('hidden');
                        }, 3000);
                    }
                },

                viewProduct(id) {
                    window.location.href = `/products/${id}`;
                },

                editProduct(id) {
                    window.location.href = `/products/${id}/edit`;
                },

                async confirmDelete(id) {
                    if (confirm('Are you sure you want to delete this product?')) {
                        try {
                            const response = await fetch(`/products/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                    'Accept': 'application/json'
                                }
                            });

                            if (response.ok) {
                                this.fetchData();
                                this.showNotification('success', 'Product deleted successfully');
                            } else {
                                throw new Error('Failed to delete product');
                            }
                        } catch (error) {
                            console.error('Error deleting product:', error);
                            this.showNotification('error', 'Error deleting product');
                        }
                    }
                }
            };
        });
    });
</script>
@endpush