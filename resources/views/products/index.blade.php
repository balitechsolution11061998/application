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
                        <select id="statusFilter" class="appearance-none w-full bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 group-hover:shadow-md text-sm sm:text-base">
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
                        <select id="companyFilter" class="appearance-none w-full bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 group-hover:shadow-md text-sm sm:text-base">
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
                        <select id="stockFilter" class="appearance-none w-full bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-all duration-200 group-hover:shadow-md text-sm sm:text-base">
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
                        <button id="resetFilters" class="w-full sm:w-auto px-3 sm:px-4 py-2 text-gray-600 dark:text-gray-300 bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 flex items-center justify-center gap-1 sm:gap-2 shadow-sm hover:shadow-md text-sm sm:text-base">
                            <i class="fas fa-filter-circle-xmark text-sm sm:text-base"></i>
                            <span>Reset Filters</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <!-- Desktop Table -->
            <table class="hidden md:table min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                <thead class="bg-gray-50/70 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">SKU</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white/50 dark:bg-gray-800/30 divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    <!-- Product Rows -->
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors duration-150 group">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600 mr-3">
                                    <i class="fas fa-box text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Janggolan Luar Up</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">No category</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <span class="font-mono">JANGGOLAN-LUAR-UP</span>
                                <button class="ml-2 text-gray-400 hover:text-blue-500 transition-colors" title="Copy to clipboard">
                                    <i class="far fa-copy text-xs"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">Rp 25.000</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <span>0</span>
                                <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">(Min: 0)</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">Internal Inter Company</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 flex items-center justify-center w-20">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors p-1 rounded-md hover:bg-blue-100/50 dark:hover:bg-blue-900/30">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors p-1 rounded-md hover:bg-yellow-100/50 dark:hover:bg-yellow-900/30">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors p-1 rounded-md hover:bg-red-100/50 dark:hover:bg-red-900/30">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Additional product rows would go here -->
                </tbody>
            </table>

            <!-- Mobile Cards -->
            <div class="md:hidden p-3 space-y-3">
                <!-- Product Card -->
                <div class="bg-white/70 dark:bg-gray-800/50 rounded-lg shadow p-4 border border-gray-200/50 dark:border-gray-700/50 transition-all duration-200 hover:shadow-md hover:border-blue-300/50 dark:hover:border-blue-700/50">
                    <div class="flex items-start space-x-3">
                        <div class="h-12 w-12 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600">
                            <i class="fas fa-box text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900 dark:text-white truncate">Janggolan Luar Up</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">No category</div>

                            <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">SKU</div>
                                    <div class="text-gray-700 dark:text-gray-300 font-mono">JANGGOLAN-LUAR-UP</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">Price</div>
                                    <div class="text-gray-700 dark:text-gray-300">Rp 25.000</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">Stock</div>
                                    <div class="text-gray-700 dark:text-gray-300">
                                        <span>0</span>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">(Min: 0)</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">Status</div>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 inline-flex items-center">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span>
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 flex justify-end space-x-2 border-t border-gray-100 dark:border-gray-700 pt-3">
                        <button class="p-2 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-800/50 transition-colors">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="p-2 rounded-md bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-100 dark:hover:bg-yellow-800/50 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="p-2 rounded-md bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-800/50 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Additional product cards would go here -->
            </div>
        </div>

        <!-- Enhanced Pagination -->
        <div class="px-4 sm:px-6 py-4 border-t border-gray-200/50 dark:border-gray-700/50 flex flex-col sm:flex-row items-center justify-between bg-gray-50/70 dark:bg-gray-700/30">
            <div class="mb-3 sm:mb-0 text-sm text-gray-600 dark:text-gray-400">
                Showing <span class="font-medium text-gray-800 dark:text-gray-200">1</span> to <span class="font-medium text-gray-800 dark:text-gray-200">4</span> of <span class="font-medium text-gray-800 dark:text-gray-200">16</span> products
            </div>

            <div class="flex items-center space-x-1">
                <button class="px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button class="px-3 py-1.5 rounded-md border border-blue-500 bg-blue-500 text-white hover:bg-blue-600 transition-colors">
                    1
                </button>

                <button class="px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    2
                </button>

                <button class="px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-ellipsis-h"></i>
                </button>

                <button class="px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    4
                </button>

                <button class="px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
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

@push('styles')
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
@endpush

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with advanced configuration and animations
        const table = $('#productsTable').DataTable({
            paginate: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('products.data') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.status = $('#statusFilter').val();
                    d.company = $('#companyFilter').val();
                    d.stock_status = $('#stockFilter').val(); // New filter for stock status
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401 || xhr.status === 419) {
                        // Session expired animation
                        $('body').append('<div class="fixed inset-0 flex items-center justify-center bg-black/70 z-50" id="sessionExpired"><div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-2xl animate__animated animate__fadeInDown"><i class="fas fa-lock text-5xl text-red-500 mb-4"></i><h2 class="text-xl font-bold mb-2">Session Expired</h2><p class="mb-4">Your session has expired. Redirecting to login page...</p><div class="animate-pulse bg-blue-500 h-1 w-full rounded"></div></div></div>');
                        setTimeout(() => window.location.reload(), 2500);
                    } else {
                        showError('Failed to load products data. Please try again.');
                    }
                }
            },
            columns: [{
                    data: 'image_url',
                    name: 'image',
                    render: function(data, type, row) {
                        return `<div class="relative group transform transition-all duration-300 hover:scale-105">
                        <div class="h-16 w-16 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                            <img src="${data}" alt="${row.name}" 
                                class="w-full h-full object-cover quick-view-btn"
                                data-id="${row.id}">
                            <div class="absolute inset-0 bg-gradient-to-tr from-black/60 to-black/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <i class="fas fa-eye text-white text-lg"></i>
                            </div>
                        </div>
                    </div>`;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'py-3'
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        // Add tooltip with truncation for long names
                        const truncated = data.length > 30 ? data.substring(0, 30) + '...' : data;
                        return `<div class="group">
                        <div class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200 cursor-pointer quick-view-btn" data-id="${row.id}" title="${data}">${truncated}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ${row.category ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'}">
                                <i class="fas fa-tag mr-1 text-xs"></i> ${row.category || 'No category'}
                            </span>
                        </div>
                    </div>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'sku',
                    name: 'sku',
                    render: function(data, type, row) {
                        // Copy to clipboard functionality
                        return `<div class="group relative">
                        <span class="px-2.5 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-md text-sm font-mono group-hover:bg-gray-200 dark:group-hover:bg-gray-600 transition-colors cursor-copy" onclick="navigator.clipboard.writeText('${data}').then(() => showTooltip(this))">
                            ${data}
                            <i class="fas fa-copy ml-1 opacity-0 group-hover:opacity-100 text-gray-500 dark:text-gray-400 text-xs"></i>
                        </span>
                        <div class="tooltip-text hidden absolute left-0 mt-1 px-2 py-1 bg-black/80 text-white text-xs rounded">Copied!</div>
                    </div>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'price',
                    name: 'price',
                    render: function(data, type, row) {
                        // Enhanced price display with animations
                        const priceFormatted = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(data);
                        const discountFormatted = row.discount_price ?
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(row.discount_price) : '';

                        // Calculate discount percentage if available
                        let discountPercentage = '';
                        if (row.discount_price && data > 0) {
                            const percentage = Math.round((data - row.discount_price) / data * 100);
                            discountPercentage = `<div class="absolute -top-3 -right-3 flex items-center justify-center bg-red-500 text-white text-xs font-bold h-8 w-8 rounded-full animate-pulse">
                            -${percentage}%
                        </div>`;
                        }

                        return `<div class="relative group">
                        ${row.discount_price ? discountPercentage : ''}
                        <div class="font-medium ${row.discount_price ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-800 dark:text-gray-200'}">${priceFormatted}</div>
                        ${row.discount_price ? `
                        <div class="text-sm font-semibold text-green-600 dark:text-green-400 group-hover:scale-105 transition-transform">
                            ${discountFormatted}
                        </div>
                        ` : ''}
                    </div>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'stock',
                    name: 'stock',
                    render: function(data, type, row) {
                        // Improved stock visualization
                        let stockClass = 'text-green-600 dark:text-green-400';
                        let stockStatus = 'In Stock';
                        let stockIcon = 'fa-check-circle';

                        if (data <= row.stock_threshold * 0.5 && data > row.stock_threshold * 0.25) {
                            stockClass = 'text-yellow-600 dark:text-yellow-400';
                            stockStatus = 'Low Stock';
                            stockIcon = 'fa-exclamation-circle';
                        } else if (data <= row.stock_threshold * 0.25) {
                            stockClass = 'text-red-600 dark:text-red-400';
                            stockStatus = 'Critical Stock';
                            stockIcon = 'fa-exclamation-triangle';
                        }

                        // Calculate percentage with safety check
                        const threshold = row.stock_threshold || 1; // Prevent division by zero
                        const percentage = Math.min(100, Math.max(0, (data / threshold) * 100));

                        // Determine progress color with gradient effect
                        let progressColor;
                        if (percentage < 25) {
                            progressColor = 'bg-gradient-to-r from-red-500 to-red-400';
                        } else if (percentage < 50) {
                            progressColor = 'bg-gradient-to-r from-yellow-500 to-yellow-400';
                        } else {
                            progressColor = 'bg-gradient-to-r from-green-500 to-green-400';
                        }

                        return `<div class="group">
                        <div class="flex items-center mb-1">
                            <i class="fas ${stockIcon} ${stockClass} mr-2"></i>
                            <span class="${stockClass} font-medium">${data}</span>
                            <span class="ml-1 text-gray-400 dark:text-gray-500 text-xs">(Min: ${row.stock_threshold})</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="h-2 rounded-full ${progressColor} transition-all duration-500 group-hover:brightness-110" style="width: ${percentage}%"></div>
                        </div>
                        <div class="text-xs ${stockClass} mt-1 opacity-0 group-hover:opacity-100 transition-opacity">${stockStatus}</div>
                    </div>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'company.name',
                    name: 'company.name',
                    render: function(data, type, row) {
                        // Enhanced company display with hover effects
                        const initials = data ? data.substring(0, 2).toUpperCase() : 'NA';
                        return `<div class="flex items-center group">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-600 dark:to-blue-900 flex items-center justify-center mr-3 overflow-hidden shadow-md group-hover:shadow-lg transition-all duration-300 group-hover:scale-110">
                            ${row.company_logo ? 
                                `<img src="${row.company_logo}" alt="${data}" class="w-full h-full object-cover">` : 
                                `<span class="text-sm font-bold text-white">${initials}</span>`}
                        </div>
                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors font-medium">${data || 'N/A'}</span>
                    </div>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    render: function(data, type, row) {
                        // Interactive status toggle with better visual indicator
                        const statusClasses = data ?
                            'bg-gradient-to-r from-green-500 to-green-400 hover:from-green-600 hover:to-green-500' :
                            'bg-gradient-to-r from-red-500 to-red-400 hover:from-red-600 hover:to-red-500';

                        return `<div class="toggle-status-wrapper relative" data-id="${row.id}" data-current="${data ? 1 : 0}">
                        <button class="status-badge w-full py-1.5 px-3 ${statusClasses} text-white rounded-full shadow hover:shadow-md transition-all duration-300 toggle-status-btn" data-form="#toggleForm${row.id}">
                            <i class="fas ${data ? 'fa-check-circle' : 'fa-times-circle'} mr-1.5"></i>
                            <span>${data ? 'Active' : 'Inactive'}</span>
                        </button>
                        <form id="toggleForm${row.id}" action="/products/${row.id}/toggle-status" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'id',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'py-3 text-right whitespace-nowrap',
                    width: '120px',
                    render: function(data, type, row, meta) {
                        return `
                            <div class="flex justify-end gap-2">
                                <button 
                                data-id="${row.id}" 
                                class="view-btn bg-blue-500 hover:bg-blue-600 text-white rounded-md p-2 transition-colors duration-200"
                                title="View details">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                                </button>
                                <button 
                                data-id="${row.id}" 
                                class="edit-btn bg-yellow-500 hover:bg-yellow-600 text-white rounded-md p-2 transition-colors duration-200"
                                title="Edit item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                                </button>
                                <button 
                                data-id="${row.id}" 
                                class="delete-btn bg-red-500 hover:bg-red-600 text-white rounded-md p-2 transition-colors duration-200"
                                title="Delete item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                </button>
                            </div>
                            `;
                    },
                    createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                        // Add event listeners after cell is created
                        $(cell).find('.view-btn').on('click', function() {
                            const id = $(this).data('id');
                            viewDetails(id);
                        });

                        $(cell).find('.edit-btn').on('click', function() {
                            const id = $(this).data('id');
                            openEditModal(id);
                        });

                        $(cell).find('.delete-btn').on('click', function() {
                            const id = $(this).data('id');
                            confirmDelete(id);
                        });
                    }
                }
            ],
            order: [
                [1, 'asc']
            ],
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between"<"mb-4"B><"mb-4 md:mb-0"l><"md:ml-4"f>>rt<"flex flex-col md:flex-row items-center justify-between"<"mb-4 md:mb-0"i><"md:ml-4"p>>',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                    className: 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition-all hover:shadow-lg',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    },
                    // Add animation when hovering the export button
                    init: function(api, node) {
                        $(node).hover(
                            function() {
                                $(this).find('i').addClass('animate__animated animate__bounceIn');
                            },
                            function() {
                                $(this).find('i').removeClass('animate__animated animate__bounceIn');
                            }
                        );
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    className: 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-md transition-all hover:shadow-lg',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    },
                    // Add animation when hovering the export button
                    init: function(api, node) {
                        $(node).hover(
                            function() {
                                $(this).find('i').addClass('animate__animated animate__bounceIn');
                            },
                            function() {
                                $(this).find('i').removeClass('animate__animated animate__bounceIn');
                            }
                        );
                    }
                }
            ],
            language: {
                processing: `
                <div class="flex justify-center items-center h-64">
                    <div class="loading-spinner">
                        <div class="w-16 h-16 relative">
                            <div class="absolute top-0 w-4 h-4 rounded-full bg-blue-600 animate-ping" style="animation-delay: 0s;"></div>
                            <div class="absolute top-0 left-6 w-4 h-4 rounded-full bg-blue-600 animate-ping" style="animation-delay: 0.1s;"></div>
                            <div class="absolute top-6 left-12 w-4 h-4 rounded-full bg-blue-600 animate-ping" style="animation-delay: 0.2s;"></div>
                            <div class="absolute top-12 left-6 w-4 h-4 rounded-full bg-blue-600 animate-ping" style="animation-delay: 0.3s;"></div>
                            <div class="absolute top-6 left-0 w-4 h-4 rounded-full bg-blue-600 animate-ping" style="animation-delay: 0.4s;"></div>
                        </div>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">Loading products...</p>
                    </div>
                </div>
            `,
                emptyTable: `
            <div class="text-center py-12 fade-in">
                <div class="mx-auto w-24 h-24 text-gray-400 mb-4 animate__animated animate__fadeIn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2 animate__animated animate__fadeIn animate__delay-1s">No Products Found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6 animate__animated animate__fadeIn animate__delay-1s">We couldn't find any products matching your criteria</p>
                <div class="flex justify-center space-x-3 animate__animated animate__fadeIn animate__delay-2s">
                    <button id="resetFiltersEmpty" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all hover:shadow-lg">
                        <i class="fas fa-filter-circle-xmark mr-2"></i> Reset Filters
                    </button>
                    <a href="{{ route('products.create') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all hover:shadow-lg">
                        <i class="fas fa-plus-circle mr-2"></i> Add Product
                    </a>
                </div>
            </div>
            `,
                info: 'Showing <span class="font-semibold text-blue-600 dark:text-blue-400">_START_</span> to <span class="font-semibold text-blue-600 dark:text-blue-400">_END_</span> of <span class="font-semibold text-blue-600 dark:text-blue-400">_TOTAL_</span> products',
                infoEmpty: 'Showing 0 to 0 of 0 products',
                infoFiltered: '(filtered from _MAX_ total products)',
                lengthMenu: 'Show <span class="font-semibold">_MENU_</span> products',
                search: '',
                searchPlaceholder: 'Search products...',
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                },
                // Custom loading animation for AJAX requests
                loadingRecords: `
                <div class="flex justify-center items-center p-4">
                    <div class="dot-flashing"></div>
                </div>
            `
            },
            initComplete: function() {
                // Enhanced styling for DataTables elements
                $('#productsTable_filter input').addClass('form-input rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500');
                $('#productsTable_length select').addClass('form-select rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500');

                // Add stock status filter
                $('<div class="relative flex-1 md:w-48 ml-0 md:ml-3 mt-3 md:mt-0">')
                    .append(`
                    <select id="stockFilter" class="appearance-none w-full bg-white/50 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-4 py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150">
                        <option value="">All Stock Levels</option>
                        <option value="in_stock">In Stock</option>
                        <option value="low_stock">Low Stock</option>
                        <option value="critical">Critical Stock</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                `)
                    .insertAfter('#companyFilter').parent();

                // Initialize tooltips


                // Animate table appearance on first load
                $('#productsTable').addClass('animate__animated animate__fadeIn');

                // Apply special styling to pagination
            },
            drawCallback: function(settings) {
                const api = this.api();
                $('#startRecord').text(api.page.info().start + 1);
                $('#endRecord').text(api.page.info().end);
                $('#totalRecords').text(api.page.info().recordsTotal);

                // Enhance pagination controls

                // Add row animations
                $('tbody tr').each(function(index) {
                    $(this).css('opacity', '0').css('transform', 'translateY(20px)');
                    setTimeout(() => {
                        $(this).css('transition', 'all 0.3s ease').css('opacity', '1').css('transform', 'translateY(0)');
                    }, 50 * index);
                });
            }
        });

        // Custom pagination function with enhanced styling
        function customizePagination() {
            const pagination = $('#pagination');
            pagination.empty();

            const api = table.api();
            const pageInfo = api.page.info();
            const pagesTotal = pageInfo.pages;
            const currentPage = pageInfo.page;

            // Previous button
            const prevDisabled = currentPage === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700';
            pagination.append(`
            <button class="pagination-btn ${prevDisabled} rounded-l-lg border border-gray-300 dark:border-gray-600 px-3 py-1.5" 
                    ${currentPage === 0 ? 'disabled' : ''}
                    onclick="table.page('previous').draw('page')">
                <i class="fas fa-chevron-left"></i>
            </button>
        `);

            // Page numbers
            const visiblePages = 5; // Number of visible page buttons
            let startPage, endPage;

            if (pagesTotal <= visiblePages) {
                startPage = 0;
                endPage = pagesTotal - 1;
            } else {
                const maxPagesBeforeCurrent = Math.floor(visiblePages / 2);
                const maxPagesAfterCurrent = Math.ceil(visiblePages / 2) - 1;

                if (currentPage <= maxPagesBeforeCurrent) {
                    startPage = 0;
                    endPage = visiblePages - 1;
                } else if (currentPage + maxPagesAfterCurrent >= pagesTotal) {
                    startPage = pagesTotal - visiblePages;
                    endPage = pagesTotal - 1;
                } else {
                    startPage = currentPage - maxPagesBeforeCurrent;
                    endPage = currentPage + maxPagesAfterCurrent;
                }
            }

            // First page + ellipsis if needed
            if (startPage > 0) {
                pagination.append(`
                <button class="pagination-btn hover:bg-gray-100 dark:hover:bg-gray-700 border-t border-b border-gray-300 dark:border-gray-600 px-3 py-1.5" 
                        onclick="table.page(0).draw('page')">
                    1
                </button>
            `);

                if (startPage > 1) {
                    pagination.append(`
                    <span class="px-3 py-1.5 border-t border-b border-gray-300 dark:border-gray-600">...</span>
                `);
                }
            }

            // Page numbers
            for (let i = startPage; i <= endPage; i++) {
                const activeClass = i === currentPage ?
                    'bg-blue-600 text-white border-blue-600' :
                    'hover:bg-gray-100 dark:hover:bg-gray-700 border-gray-300 dark:border-gray-600';

                pagination.append(`
                <button class="pagination-btn ${activeClass} border-t border-b px-3 py-1.5" 
                        onclick="table.page(${i}).draw('page')">
                    ${i + 1}
                </button>
            `);
            }

            // Last page + ellipsis if needed
            if (endPage < pagesTotal - 1) {
                if (endPage < pagesTotal - 2) {
                    pagination.append(`
                    <span class="px-3 py-1.5 border-t border-b border-gray-300 dark:border-gray-600">...</span>
                `);
                }

                pagination.append(`
                <button class="pagination-btn hover:bg-gray-100 dark:hover:bg-gray-700 border-t border-b border-gray-300 dark:border-gray-600 px-3 py-1.5" 
                        onclick="table.page(${pagesTotal - 1}).draw('page')">
                    ${pagesTotal}
                </button>
            `);
            }

            // Next button
            const nextDisabled = currentPage === pagesTotal - 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700';
            pagination.append(`
            <button class="pagination-btn ${nextDisabled} rounded-r-lg border border-gray-300 dark:border-gray-600 px-3 py-1.5" 
                    ${currentPage === pagesTotal - 1 ? 'disabled' : ''}
                    onclick="table.page('next').draw('page')">
                <i class="fas fa-chevron-right"></i>
            </button>
        `);

            // Page length selector
            pagination.prepend(`
            <div class="flex items-center mr-4">
                <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Show:</span>
                <select class="page-length-select bg-white/50 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    ${[10, 25, 50, 100].map(option => `
                        <option value="${option}" ${api.page.len() === option ? 'selected' : ''}>
                            ${option === -1 ? 'All' : option}
                        </option>
                    `).join('')}
                </select>
            </div>
        `);

            // Handle page length change
            $('.page-length-select').off('change').on('change', function() {
                api.page.len(parseInt($(this).val())).draw();
            });

            // Add hover animations to pagination buttons
            $('.pagination-btn').not('.disabled').hover(
                function() {
                    if (!$(this).hasClass('bg-blue-600')) {
                        $(this).addClass('transform hover:-translate-y-0.5 transition-transform');
                    }
                },
                function() {
                    $(this).removeClass('transform hover:-translate-y-0.5 transition-transform');
                }
            );
        }


        // Custom search input
        $('#searchInput').keyup(function() {
            table.search($(this).val()).draw();
        });

        // Status filter
        $('#statusFilter, #companyFilter').change(function() {
            table.ajax.reload();
        });

        // Reset filters
        $('#resetFilters, #resetFiltersEmpty').click(function() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#companyFilter').val('');
            table.search('').draw();
            table.ajax.reload();
            showSuccess('Filters reset successfully');
        });

        // Export button
        $('#exportBtn').click(function() {
            $('.buttons-excel').click();
        });

        // Quick view implementation
        $(document).on('click', '.quick-view-btn', function() {
            const productId = $(this).data('id');
            const rowData = table.row($(this).closest('tr')).data();

            if (rowData) {
                $('#quickViewContent').html(`
                <div class="space-y-6 fade-in">
                    <div class="flex justify-center">
                        <div class="relative group">
                            <img src="${rowData.image_url}" alt="${rowData.name}" class="h-48 w-full object-contain rounded-lg shadow-md">
                            <div class="absolute inset-0 bg-black/30 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="text-white font-medium">View Full Image</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">${rowData.name}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">${rowData.category || 'No category'}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">SKU</p>
                            <p class="font-medium text-gray-900 dark:text-white">${rowData.sku}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(rowData.price)}
                            </p>
                            ${rowData.discount_price ? `
                            <p class="text-xs text-green-600 dark:text-green-400">
                                Discounted: ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(rowData.discount_price)}
                            </p>
                            ` : ''}
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Stock</p>
                            <p class="font-medium ${rowData.stock < 5 ? 'text-red-600 dark:text-red-400' : rowData.stock < 10 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400'}">
                                ${rowData.stock} / ${rowData.stock_threshold}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p>
                                ${rowData.is_active ? 
                                    '<span class="status-badge status-active"><i class="fas fa-check-circle mr-1"></i> Active</span>' : 
                                    '<span class="status-badge status-inactive"><i class="fas fa-times-circle mr-1"></i> Inactive</span>'}
                            </p>
                        </div>
                    </div>
                    
                    ${rowData.description ? `
                    <div class="pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                        <p class="mt-1 text-gray-700 dark:text-gray-300">${rowData.description}</p>
                    </div>
                    ` : ''}
                    
                    <div class="pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
                        <div class="flex space-x-3">
                            <a href="/products/${rowData.id}/edit" 
                               class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:shadow-md">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                            <form action="/products/${rowData.id}/toggle-status" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white ${rowData.is_active ? 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500' : 'bg-purple-600 hover:bg-purple-700 focus:ring-purple-500'} focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all hover:shadow-md">
                                    <i class="fas ${rowData.is_active ? 'fa-toggle-on' : 'fa-toggle-off'} mr-2"></i> ${rowData.is_active ? 'Deactivate' : 'Activate'}
                                </button>
                            </form>
                        </div>
                        <form action="/products/${rowData.id}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all hover:shadow-md"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            `);

                $('#quickViewOverlay').removeClass('hidden');
                $('#quickViewPanel').removeClass('translate-x-full');
                document.body.classList.add('overflow-hidden');
            }
        });

        // Close quick view
        $('#closeQuickView, #quickViewOverlay').click(function() {
            $('#quickViewPanel').addClass('translate-x-full');
            $('#quickViewOverlay').addClass('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        // Notification functions
        function showSuccess(message) {
            $('#successMessage').text(message);
            $('#successNotification').removeClass('hidden').addClass('fade-in');
            setTimeout(() => {
                $('#successNotification').addClass('hidden').removeClass('fade-in');
            }, 3000);
        }

        function showError(message) {
            $('#errorMessage').text(message);
            $('#errorNotification').removeClass('hidden').addClass('fade-in');
            setTimeout(() => {
                $('#errorNotification').addClass('hidden').removeClass('fade-in');
            }, 3000);
        }

        // Handle delete confirmation
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        table.ajax.reload();
                        showSuccess('Product deleted successfully');
                    },
                    error: function(xhr) {
                        showError('Failed to delete product');
                    }
                });
            }
        });

        // Handle status toggle
        $(document).on('click', '.toggle-status-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    table.ajax.reload();
                    showSuccess('Product status updated successfully');
                },
                error: function(xhr) {
                    showError('Failed to update product status');
                }
            });
        });
    });
</script>