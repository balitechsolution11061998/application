<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Analytics Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        powerbi: {
                            dark: '#2B2B2B',
                            light: '#F2F2F2',
                            accent: '#01B8AA',
                            secondary: '#374649',
                            text: '#333333',
                        },
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- PivotTable.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.css">
    <style>
        .pvtUi {
            color: #4b5563;
            font-size: 0.875rem;
        }
        .pvtAxisContainer, .pvtVals {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
        }
        .pvtTable {
            font-size: 0.75rem;
        }
        .pvtTable th {
            background-color: #f3f4f6;
        }
        .pvtRowTotal, .pvtColTotal {
            font-weight: 600;
            background-color: #e5e7eb !important;
        }
        .pvtTotalLabel {
            font-weight: 600;
            background-color: #f3f4f6 !important;
        }
        .field-item {
            transition: all 0.2s;
        }
        .field-item:hover {
            transform: translateX(2px);
        }
        .chart-tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            pointer-events: none;
            z-index: 100;
        }
        .dropdown-enter {
            transition: all 0.2s ease-out;
        }
        .dropdown-enter-from {
            opacity: 0;
            transform: translateY(-10px);
        }
        .dropdown-enter-to {
            opacity: 1;
            transform: translateY(0);
        }
        .dropdown-leave {
            transition: all 0.2s ease-in;
        }
        .dropdown-leave-from {
            opacity: 1;
            transform: translateY(0);
        }
        .dropdown-leave-to {
            opacity: 0;
            transform: translateY(-10px);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <!-- Navigation Bar -->
    <nav class="bg-gray-900 text-white shadow-lg">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-chart-pie text-blue-400 mr-2"></i>
                        <span class="text-xl font-semibold">Analytics Dashboard</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="refreshBtn" class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-sync-alt mr-2"></i> Refresh
                    </button>
                    <button class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-save mr-2"></i> Save
                    </button>
                    <button class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-share mr-2"></i> Share
                    </button>
                    <button class="flex items-center text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </button>
                    <div class="ml-4 flex items-center relative" x-data="{ open: false }">
                        <button @click="open = !open" class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center focus:outline-none">
                            <span class="text-white text-sm">AD</span>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                            x-transition:enter="dropdown-enter"
                            x-transition:enter-start="dropdown-enter-from"
                            x-transition:enter-end="dropdown-enter-to"
                            x-transition:leave="dropdown-leave"
                            x-transition:leave-start="dropdown-leave-from"
                            x-transition:leave-end="dropdown-leave-to"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-gray-200">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <nav class="flex-1 px-2 space-y-1">
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md bg-blue-50 text-blue-700">
                            <i class="fas fa-home mr-3 text-blue-500"></i>
                            Home
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <i class="fas fa-table mr-3 text-gray-400"></i>
                            Data Model
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <i class="fas fa-chart-line mr-3 text-gray-400"></i>
                            Reports
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <i class="fas fa-map-marked-alt mr-3 text-gray-400"></i>
                            Maps
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <i class="fas fa-sliders-h mr-3 text-gray-400"></i>
                            Parameters
                        </a>
                        <div class="mt-8">
                            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Data</h3>
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <i class="fas fa-database mr-3 text-gray-400"></i>
                                Data Sources
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <i class="fas fa-history mr-3 text-gray-400"></i>
                                Refresh History
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">Admin User</p>
                            <p class="text-xs font-medium text-gray-500">admin@example.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <!-- Region Filter -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Region</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="region-east" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="region-east" class="ml-2 text-sm text-gray-700">East</label>
                            </div>
                            <div class="flex items-center">
                                <input id="region-west" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="region-west" class="ml-2 text-sm text-gray-700">West</label>
                            </div>
                            <div class="flex items-center">
                                <input id="region-north" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="region-north" class="ml-2 text-sm text-gray-700">North</label>
                            </div>
                            <div class="flex items-center">
                                <input id="region-south" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="region-south" class="ml-2 text-sm text-gray-700">South</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Filter -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Product</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="product-a" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="product-a" class="ml-2 text-sm text-gray-700">Product A</label>
                            </div>
                            <div class="flex items-center">
                                <input id="product-b" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="product-b" class="ml-2 text-sm text-gray-700">Product B</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date Range Filter -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Date Range</h3>
                        <select id="dateRange" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option>Last 30 Days</option>
                            <option selected>Last 60 Days</option>
                            <option>Last 90 Days</option>
                            <option>Custom Range</option>
                        </select>
                    </div>
                    
                    <!-- Customer Type Filter -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Customer Type</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="cust-regular" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="cust-regular" class="ml-2 text-sm text-gray-700">Regular</label>
                            </div>
                            <div class="flex items-center">
                                <input id="cust-premium" type="checkbox" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="cust-premium" class="ml-2 text-sm text-gray-700">Premium</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <!-- Total Sales -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                    <i class="fas fa-dollar-sign text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Sales</dt>
                                        <dd>
                                            <div class="text-lg font-medium text-gray-900" id="total-sales">$12,450</div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <div class="text-sm flex justify-between items-center">
                                <span class="text-green-600 font-medium">
                                    <i class="fas fa-arrow-up mr-1"></i> <span id="sales-change">12.5</span>%
                                </span>
                                <span class="text-gray-500">vs last period</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Quantity -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                    <i class="fas fa-shopping-cart text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Quantity</dt>
                                        <dd>
                                            <div class="text-lg font-medium text-gray-900" id="total-quantity">156</div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <div class="text-sm flex justify-between items-center">
                                <span class="text-green-600 font-medium">
                                    <i class="fas fa-arrow-up mr-1"></i> <span id="quantity-change">8.3</span>%
                                </span>
                                <span class="text-gray-500">vs last period</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Avg. Profit Margin -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                    <i class="fas fa-percent text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Avg. Profit Margin</dt>
                                        <dd>
                                            <div class="text-lg font-medium text-gray-900" id="avg-profit">32.5%</div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <div class="text-sm flex justify-between items-center">
                                <span class="text-red-600 font-medium">
                                    <i class="fas fa-arrow-down mr-1"></i> <span id="profit-change">1.2</span>%
                                </span>
                                <span class="text-gray-500">vs last period</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Orders -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                    <i class="fas fa-clipboard-list text-white"></i>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                                        <dd>
                                            <div class="text-lg font-medium text-gray-900" id="orders">24</div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <div class="text-sm flex justify-between items-center">
                                <span class="text-green-600 font-medium">
                                    <i class="fas fa-arrow-up mr-1"></i> <span id="orders-change">4.3</span>%
                                </span>
                                <span class="text-gray-500">vs last period</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Sales Analysis Chart -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-chart-bar text-blue-500 mr-2"></i> Sales Analysis
                            </h3>
                            <div class="flex items-center space-x-2">
                                <button class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-chart-line mr-1"></i> Line Chart
                                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" 
                                        x-transition:enter="dropdown-enter"
                                        x-transition:enter-start="dropdown-enter-from"
                                        x-transition:enter-end="dropdown-enter-to"
                                        x-transition:leave="dropdown-leave"
                                        x-transition:leave-start="dropdown-leave-from"
                                        x-transition:leave-end="dropdown-leave-to"
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                        <div class="py-1">
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false" data-chart="line"><i class="fas fa-chart-line mr-2"></i> Line Chart</a>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false" data-chart="bar"><i class="fas fa-chart-bar mr-2"></i> Bar Chart</a>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false" data-chart="pie"><i class="fas fa-chart-pie mr-2"></i> Pie Chart</a>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false" data-chart="area"><i class="fas fa-chart-area mr-2"></i> Area Chart</a>
                                            <div class="border-t border-gray-100"></div>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false" data-chart="table"><i class="fas fa-table mr-2"></i> Table View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 h-80">
                            <div class="chart-container relative h-full w-full">
                                <canvas id="mainChart"></canvas>
                                <div id="mainChartTooltip" class="chart-tooltip opacity-0"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Regional Performance -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i> Regional Performance
                            </h3>
                        </div>
                        <div class="p-4 h-80">
                            <div class="chart-container relative h-full w-full">
                                <canvas id="mapChart"></canvas>
                                <div id="mapChartTooltip" class="chart-tooltip opacity-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pivot Table and Additional Visualizations -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px" id="analysisTabs">
                            <button data-tab="pivot" class="w-1/4 py-4 px-1 text-center border-b-2 border-blue-500 font-medium text-sm text-blue-600 flex items-center justify-center tab-button active">
                                <i class="fas fa-table mr-2"></i> Pivot Table
                            </button>
                            <button data-tab="trends" class="w-1/4 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center tab-button">
                                <i class="fas fa-chart-line mr-2"></i> Trends
                            </button>
                            <button data-tab="composition" class="w-1/4 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center tab-button">
                                <i class="fas fa-chart-pie mr-2"></i> Composition
                            </button>
                            <button data-tab="data" class="w-1/4 py-4 px-1 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center justify-center tab-button">
                                <i class="fas fa-database mr-2"></i> Raw Data
                            </button>
                        </nav>
                    </div>
                    <div class="p-4">
                        <!-- Pivot Table Tab -->
                        <div id="pivot-tab-content" class="tab-content active">
                            <div class="flex">
                                <!-- Fields Panel -->
                                <div class="w-1/4 pr-4">
                                    <div class="bg-gray-50 rounded-lg p-4 h-full">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3 flex items-center">
                                            <i class="fas fa-list-ul mr-2"></i> Fields
                                        </h4>
                                        <div class="mb-3">
                                            <input type="text" id="fieldSearch" placeholder="Search fields..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <ul class="space-y-2 max-h-96 overflow-y-auto" id="fieldList">
                                            <!-- Fields will be added dynamically -->
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- Pivot Table -->
                                <div class="w-3/4">
                                    <div class="flex justify-between items-center mb-3">
                                        <div class="flex space-x-2">
                                            <button id="pivot-export-csv" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-file-csv mr-1"></i> Export CSV
                                            </button>
                                            <button id="pivot-export-excel" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                                            </button>
                                        </div>
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-cog mr-1"></i> Settings
                                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                            </button>
                                            <div x-show="open" @click.away="open = false" 
                                                x-transition:enter="dropdown-enter"
                                                x-transition:enter-start="dropdown-enter-from"
                                                x-transition:enter-end="dropdown-enter-to"
                                                x-transition:leave="dropdown-leave"
                                                x-transition:leave-start="dropdown-leave-from"
                                                x-transition:leave-end="dropdown-leave-to"
                                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                                <div class="py-1">
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false"><i class="fas fa-redo mr-2"></i> Reset Layout</a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false"><i class="fas fa-palette mr-2"></i> Change Theme</a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false"><i class="fas fa-columns mr-2"></i> Column Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pivotTable" class="overflow-auto border border-gray-200 rounded-lg" style="max-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Trends Tab -->
                        <div id="trends-tab-content" class="tab-content hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Sales Trend by Month</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="trendChart1"></canvas>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Profit Trend by Month</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="trendChart2"></canvas>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Quantity Trend by Month</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="trendChart3"></canvas>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Order Trend by Month</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="trendChart4"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Composition Tab -->
                        <div id="composition-tab-content" class="tab-content hidden">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Sales by Category</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="pieChart1"></canvas>
                                    <div id="pieChart1Tooltip" class="chart-tooltip opacity-0"></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Sales by Customer Type</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="pieChart2"></canvas>
                                        <div id="pieChart2Tooltip" class="chart-tooltip opacity-0"></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Sales by Product</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="pieChart3"></canvas>
                                        <div id="pieChart3Tooltip" class="chart-tooltip opacity-0"></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Profit by Region</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="pieChart4"></canvas>
                                        <div id="pieChart4Tooltip" class="chart-tooltip opacity-0"></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Quantity by Product</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="pieChart5"></canvas>
                                        <div id="pieChart5Tooltip" class="chart-tooltip opacity-0"></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 h-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Orders by Month</h4>
                                    <div class="chart-container relative h-full w-full">
                                        <canvas id="pieChart6"></canvas>
                                        <div id="pieChart6Tooltip" class="chart-tooltip opacity-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Raw Data Tab -->
                        <div id="data-tab-content" class="tab-content hidden">
                            <div class="mb-4 flex justify-between items-center">
                                <div class="flex items-center">
                                    <input type="text" id="dataSearch" placeholder="Search data..." class="w-64 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <button id="clearSearch" class="ml-2 text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="flex space-x-2">
                                    <button id="export-data-csv" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-file-csv mr-1"></i> Export CSV
                                    </button>
                                    <button id="export-data-json" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-file-code mr-1"></i> Export JSON
                                    </button>
                                </div>
                            </div>
                            <div class="overflow-auto" style="max-height: 500px;">
                                <table class="min-w-full divide-y divide-gray-200" id="rawDataTable">
                                    <thead class="bg-gray-50 sticky top-0">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="dataTableBody">
                                        <!-- Data will be added dynamically -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    Showing <span id="startItem">1</span> to <span id="endItem">10</span> of <span id="totalItems">16</span> entries
                                </div>
                                <div class="flex space-x-1">
                                    <button id="prevPage" class="px-3 py-1 border border-gray-300 rounded text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                        Previous
                                    </button>
                                    <button id="nextPage" class="px-3 py-1 border border-gray-300 rounded text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- jQuery (required by PivotTable.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- PivotTable.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.js"></script>
    <!-- Additional renderers -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/plotly_renderers.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/d3_renderers.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <!-- FileSaver.js for exporting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <!-- Papa Parse for CSV export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <!-- xlsx for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Sample data with more records for pagination
            const sampleData = [
                {region: "East", product: "A", category: "Electronics", sales: 150, quantity: 10, profit: 35, date: "2023-01-01", customer: "Regular"},
                {region: "East", product: "B", category: "Furniture", sales: 200, quantity: 15, profit: 45, date: "2023-01-02", customer: "Premium"},
                {region: "West", product: "A", category: "Electronics", sales: 180, quantity: 12, profit: 42, date: "2023-01-03", customer: "Regular"},
                {region: "West", product: "B", category: "Furniture", sales: 220, quantity: 18, profit: 55, date: "2023-01-04", customer: "Premium"},
                {region: "North", product: "A", category: "Electronics", sales: 90, quantity: 6, profit: 20, date: "2023-01-05", customer: "Regular"},
                {region: "North", product: "B", category: "Furniture", sales: 110, quantity: 8, profit: 25, date: "2023-01-06", customer: "Regular"},
                {region: "South", product: "A", category: "Electronics", sales: 130, quantity: 9, profit: 30, date: "2023-01-07", customer: "Premium"},
                {region: "South", product: "B", category: "Furniture", sales: 170, quantity: 13, profit: 40, date: "2023-01-08", customer: "Premium"},
                {region: "East", product: "A", category: "Electronics", sales: 160, quantity: 11, profit: 38, date: "2023-02-01", customer: "Regular"},
                {region: "East", product: "B", category: "Furniture", sales: 210, quantity: 16, profit: 50, date: "2023-02-02", customer: "Premium"},
                {region: "West", product: "A", category: "Electronics", sales: 190, quantity: 13, profit: 45, date: "2023-02-03", customer: "Regular"},
                {region: "West", product: "B", category: "Furniture", sales: 230, quantity: 19, profit: 60, date: "2023-02-04", customer: "Premium"},
                {region: "North", product: "A", category: "Electronics", sales: 95, quantity: 7, profit: 22, date: "2023-02-05", customer: "Regular"},
                {region: "North", product: "B", category: "Furniture", sales: 115, quantity: 9, profit: 28, date: "2023-02-06", customer: "Regular"},
                {region: "South", product: "A", category: "Electronics", sales: 140, quantity: 10, profit: 33, date: "2023-02-07", customer: "Premium"},
                {region: "South", product: "B", category: "Furniture", sales: 180, quantity: 14, profit: 45, date: "2023-02-08", customer: "Premium"},
                {region: "East", product: "A", category: "Electronics", sales: 155, quantity: 11, profit: 36, date: "2023-03-01", customer: "Regular"},
                {region: "East", product: "B", category: "Furniture", sales: 205, quantity: 16, profit: 48, date: "2023-03-02", customer: "Premium"},
                {region: "West", product: "A", category: "Electronics", sales: 185, quantity: 13, profit: 43, date: "2023-03-03", customer: "Regular"},
                {region: "West", product: "B", category: "Furniture", sales: 225, quantity: 19, profit: 58, date: "2023-03-04", customer: "Premium"},
                {region: "North", product: "A", category: "Electronics", sales: 92, quantity: 7, profit: 21, date: "2023-03-05", customer: "Regular"},
                {region: "North", product: "B", category: "Furniture", sales: 112, quantity: 9, profit: 26, date: "2023-03-06", customer: "Regular"},
                {region: "South", product: "A", category: "Electronics", sales: 135, quantity: 10, profit: 31, date: "2023-03-07", customer: "Premium"},
                {region: "South", product: "B", category: "Furniture", sales: 175, quantity: 14, profit: 43, date: "2023-03-08", customer: "Premium"}
            ];
            
            // Initialize variables
            let currentData = sampleData;
            let filteredData = [...currentData];
            let currentPage = 1;
            const itemsPerPage = 10;
            let pivotTableInstance;
            
            // Initialize pivot table
            function initPivotTable() {
                pivotTableInstance = $("#pivotTable").pivotUI(currentData, {
                    rows: ["region", "product"],
                    cols: ["customer"],
                    vals: ["sales"],
                    aggregatorName: "Sum",
                    rendererName: "Table",
                    renderers: $.extend(
                        $.pivotUtilities.renderers,
                        $.pivotUtilities.plotly_renderers,
                        $.pivotUtilities.d3_renderers
                    ),
                    onRefresh: function(config) {
                        // Save configuration to localStorage
                        localStorage.setItem("pivotConfig", JSON.stringify(config));
                    }
                });
                
                // Load saved configuration if exists
                const savedConfig = localStorage.getItem("pivotConfig");
                if (savedConfig) {
                    $("#pivotTable").pivotUI(JSON.parse(savedConfig));
                }
            }
            
            // Initialize charts with custom tooltips
            function initCharts() {
                // Main Chart (Line)
                const mainCtx = document.getElementById('mainChart').getContext('2d');
                const mainChart = new Chart(mainCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar'],
                        datasets: [
                            {
                                label: 'Product A',
                                data: [550, 585, 532],
                                borderColor: 'rgba(59, 130, 246, 1)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Product B',
                                data: [700, 735, 712],
                                borderColor: 'rgba(16, 185, 129, 1)',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true,
                                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                enabled: false,
                                external: function(context) {
                                    const tooltip = document.getElementById('mainChartTooltip');
                                    const dataIndex = context.tooltip.dataPoints[0].dataIndex;
                                    const datasetIndex = context.tooltip.dataPoints[0].datasetIndex;
                                    const value = context.tooltip.dataPoints[0].raw;
                                    
                                    tooltip.innerHTML = `
                                        <div class="font-semibold">${context.tooltip.dataPoints[0].label}</div>
                                        <div class="flex items-center mt-1">
                                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: ${context.tooltip.dataPoints[0].dataset.borderColor}"></div>
                                            ${context.tooltip.dataPoints[0].dataset.label}: $${value}
                                        </div>
                                    `;
                                    
                                    const chartRect = context.chart.canvas.getBoundingClientRect();
                                    tooltip.style.opacity = 1;
                                    tooltip.style.left = chartRect.left + context.tooltip.caretX + 'px';
                                    tooltip.style.top = chartRect.top + context.tooltip.caretY + 'px';
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                grid: {
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        elements: {
                            line: {
                                borderWidth: 2
                            }
                        }
                    }
                });
                
                // Map Chart (Doughnut)
                const mapCtx = document.getElementById('mapChart').getContext('2d');
                const mapChart = new Chart(mapCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['East', 'West', 'North', 'South'],
                        datasets: [{
                            data: [1110, 1140, 519, 630],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(245, 158, 11, 0.7)',
                                'rgba(139, 92, 246, 0.7)'
                            ],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                enabled: false,
                                external: function(context) {
                                    const tooltip = document.getElementById('mapChartTooltip');
                                    const label = context.tooltip.dataPoints[0].label;
                                    const value = context.tooltip.dataPoints[0].raw;
                                    const percentage = Math.round(context.tooltip.dataPoints[0].parsed);
                                    
                                    tooltip.innerHTML = `
                                        <div class="font-semibold">${label}</div>
                                        <div class="mt-1">$${value} (${percentage}%)</div>
                                    `;
                                    
                                    const chartRect = context.chart.canvas.getBoundingClientRect();
                                    tooltip.style.opacity = 1;
                                    tooltip.style.left = chartRect.left + context.tooltip.caretX + 'px';
                                    tooltip.style.top = chartRect.top + context.tooltip.caretY + 'px';
                                }
                            }
                        }
                    }
                });
                
                // Trend Charts
                const trendCtx1 = document.getElementById('trendChart1').getContext('2d');
                new Chart(trendCtx1, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar'],
                        datasets: [{
                            label: 'Sales Trend',
                            data: [1250, 1320, 1244],
                            fill: false,
                            borderColor: 'rgba(59, 130, 246, 1)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: getTrendChartOptions('Monthly Sales Trend')
                });
                
                const trendCtx2 = document.getElementById('trendChart2').getContext('2d');
                new Chart(trendCtx2, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar'],
                        datasets: [{
                            label: 'Profit Trend',
                            data: [35, 38, 36],
                            fill: false,
                            borderColor: 'rgba(16, 185, 129, 1)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.3,
                            pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: getTrendChartOptions('Monthly Profit Trend (%)')
                });
                
                const trendCtx3 = document.getElementById('trendChart3').getContext('2d');
                new Chart(trendCtx3, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar'],
                        datasets: [{
                            label: 'Quantity Trend',
                            data: [84, 96, 90],
                            fill: false,
                            borderColor: 'rgba(245, 158, 11, 1)',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            tension: 0.3,
                            pointBackgroundColor: 'rgba(245, 158, 11, 1)',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: getTrendChartOptions('Monthly Quantity Trend')
                });
                
                const trendCtx4 = document.getElementById('trendChart4').getContext('2d');
                new Chart(trendCtx4, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar'],
                        datasets: [{
                            label: 'Order Trend',
                            data: [8, 8, 8],
                            fill: false,
                            borderColor: 'rgba(139, 92, 246, 1)',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            tension: 0.3,
                            pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: getTrendChartOptions('Monthly Order Trend')
                });
                
                // Pie Charts
                const pieCtx1 = document.getElementById('pieChart1').getContext('2d');
                initPieChart(pieCtx1, ['Electronics', 'Furniture'], [1697, 2137], 'Sales by Category');
                
                const pieCtx2 = document.getElementById('pieChart2').getContext('2d');
                initPieChart(pieCtx2, ['Regular', 'Premium'], [1532, 2302], 'Sales by Customer Type');
                
                const pieCtx3 = document.getElementById('pieChart3').getContext('2d');
                initPieChart(pieCtx3, ['Product A', 'Product B'], [1667, 2167], 'Sales by Product');
                
                const pieCtx4 = document.getElementById('pieChart4').getContext('2d');
                initPieChart(pieCtx4, ['East', 'West', 'North', 'South'], [1110, 1140, 519, 630], 'Profit by Region');
                
                const pieCtx5 = document.getElementById('pieChart5').getContext('2d');
                initPieChart(pieCtx5, ['Product A', 'Product B'], [108, 162], 'Quantity by Product');
                
                const pieCtx6 = document.getElementById('pieChart6').getContext('2d');
                initPieChart(pieCtx6, ['Jan', 'Feb', 'Mar'], [8, 8, 8], 'Orders by Month');
                
                // Hide tooltips when mouse leaves chart
                document.getElementById('mainChart').addEventListener('mouseout', function() {
                    document.getElementById('mainChartTooltip').style.opacity = 0;
                });
                
                document.getElementById('mapChart').addEventListener('mouseout', function() {
                    document.getElementById('mapChartTooltip').style.opacity = 0;
                });
            }
            
            function getTrendChartOptions(title) {
                return {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: title,
                            font: {
                                size: 14
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        },
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                };
            }
            
            function initPieChart(ctx, labels, data, title) {
                return new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(245, 158, 11, 0.7)',
                                'rgba(139, 92, 246, 0.7)',
                                'rgba(236, 72, 153, 0.7)',
                                'rgba(20, 184, 166, 0.7)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: title,
                                font: {
                                    size: 14
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            },
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Populate field list with icons based on data type
            function populateFieldList() {
                const fields = Object.keys(currentData[0]);
                const fieldList = $('#fieldList');
                fieldList.empty();
                
                fields.forEach(field => {
                    let fieldType = 'categorical';
                    let icon = 'tag';
                    let color = 'text-blue-500';
                    
                    if (typeof currentData[0][field] === 'number') {
                        fieldType = 'numeric';
                        icon = 'calculator';
                        color = 'text-green-500';
                    } else if (!isNaN(Date.parse(currentData[0][field]))) {
                        fieldType = 'date';
                        icon = 'calendar';
                        color = 'text-purple-500';
                    }
                    
                    fieldList.append(`
                        <li class="field-item p-2 rounded-md hover:bg-gray-100 cursor-pointer flex items-center" data-field="${field}" data-type="${fieldType}">
                            <i class="fas fa-${icon} ${color} mr-2 text-sm"></i>
                            <span class="text-sm text-gray-700">${field}</span>
                            <span class="ml-auto text-xs text-gray-500 uppercase">${fieldType}</span>
                        </li>
                    `);
                });
                
                // Make fields draggable
                $('.field-item').on('mousedown', function() {
                    $(this).addClass('dragging bg-blue-50');
                });
                
                $(document).on('mouseup', function() {
                    $('.field-item').removeClass('dragging bg-blue-50');
                });
            }
            
            // Populate raw data table with pagination
            function populateRawDataTable() {
                const tableBody = $('#dataTableBody');
                tableBody.empty();
                
                const startIndex = (currentPage - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, filteredData.length);
                
                for (let i = startIndex; i < endIndex; i++) {
                    const row = filteredData[i];
                    tableBody.append(`
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.region}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.product}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.category}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${row.sales}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.quantity}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.profit}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${row.customer}</td>
                        </tr>
                    `);
                }
                
                // Update pagination info
                $('#startItem').text(startIndex + 1);
                $('#endItem').text(endIndex);
                $('#totalItems').text(filteredData.length);
                
                // Update button states
                $('#prevPage').prop('disabled', currentPage === 1);
                $('#nextPage').prop('disabled', endIndex >= filteredData.length);
            }
            
            // Filter data based on search input
            function filterData() {
                const searchTerm = $('#dataSearch').val().toLowerCase();
                if (searchTerm === '') {
                    filteredData = [...currentData];
                } else {
                    filteredData = currentData.filter(row => {
                        return Object.values(row).some(val => 
                            String(val).toLowerCase().includes(searchTerm)
                        );
                    });
                }
                currentPage = 1;
                populateRawDataTable();
            }
            
            // Initialize the dashboard
            initPivotTable();
            initCharts();
            populateFieldList();
            populateRawDataTable();
            
            // Tab switching functionality
            $('.tab-button').click(function() {
                const tabId = $(this).data('tab');
                
                // Update active tab button
                $('.tab-button').removeClass('active border-blue-500 text-blue-600').addClass('border-transparent text-gray-500');
                $(this).addClass('active border-blue-500 text-blue-600').removeClass('border-transparent text-gray-500');
                
                // Show corresponding tab content
                $('.tab-content').addClass('hidden').removeClass('active');
                $(`#${tabId}-tab-content`).removeClass('hidden').addClass('active');
            });
            
            // Chart type switcher
            $('[data-chart]').click(function(e) {
                e.preventDefault();
                const chartType = $(this).data('chart');
                const mainChart = Chart.getChart("mainChart");
                
                if (chartType === 'table') {
                    // Switch to table view
                    $('#mainChart').hide();
                    // In a real implementation, you would show a table here
                } else {
                    $('#mainChart').show();
                    mainChart.config.type = chartType;
                    
                    // Adjust options based on chart type
                    if (chartType === 'pie' || chartType === 'doughnut') {
                        mainChart.options.scales = {};
                        mainChart.options.cutout = chartType === 'pie' ? 0 : '50%';
                    } else {
                        mainChart.options.scales = {
                            y: {
                                beginAtZero: false,
                                grid: {
                                    drawBorder: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        };
                    }
                    
                    mainChart.update();
                }
            });
            
            // Field search functionality
            $('#fieldSearch').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.field-item').each(function() {
                    const fieldName = $(this).data('field').toLowerCase();
                    if (fieldName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
            
            // Data search functionality
            $('#dataSearch').on('input', function() {
                filterData();
            });
            
            $('#clearSearch').click(function() {
                $('#dataSearch').val('');
                filterData();
            });
            
            // Pagination controls
            $('#prevPage').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    populateRawDataTable();
                }
            });
            
            $('#nextPage').click(function() {
                if ((currentPage * itemsPerPage) < filteredData.length) {
                    currentPage++;
                    populateRawDataTable();
                }
            });
            
            // Export functionality
            $('#pivot-export-csv').click(function() {
                const csv = $.pivotUtilities.Exporters.getCSV($("#pivotTable").data("pivotUIRenderer"));
                const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
                saveAs(blob, "pivot_table.csv");
                showToast("CSV exported successfully!", "success");
            });
            
            $('#pivot-export-excel').click(function() {
                const csv = $.pivotUtilities.Exporters.getTSV($("#pivotTable").data("pivotUIRenderer"));
                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.aoa_to_sheet(csv.split('\n').map(row => row.split('\t')));
                XLSX.utils.book_append_sheet(wb, ws, "PivotTable");
                XLSX.writeFile(wb, "pivot_table.xlsx");
                showToast("Excel file exported successfully!", "success");
            });
            
            $('#export-data-csv').click(function() {
                const fields = Object.keys(currentData[0]);
                const csv = Papa.unparse({
                    fields: fields,
                    data: filteredData
                });
                const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
                saveAs(blob, "data_export.csv");
                showToast("CSV exported successfully!", "success");
            });
            
            $('#export-data-json').click(function() {
                const json = JSON.stringify(filteredData, null, 2);
                const blob = new Blob([json], { type: "application/json;charset=utf-8;" });
                saveAs(blob, "data_export.json");
                showToast("JSON exported successfully!", "success");
            });
            
            // Refresh button
            $('#refreshBtn').click(function() {
                // Simulate data refresh
                showToast("Data refreshed successfully!", "success");
                
                // Update KPIs with random changes to simulate fresh data
                const salesChange = (Math.random() * 10).toFixed(1);
                const quantityChange = (Math.random() * 5).toFixed(1);
                const profitChange = (Math.random() * 3).toFixed(1);
                const ordersChange = (Math.random() * 4).toFixed(1);
                
                $('#sales-change').text(salesChange);
                $('#quantity-change').text(quantityChange);
                $('#profit-change').text(profitChange);
                $('#orders-change').text(ordersChange);
                
                // Update direction indicators
                $('#sales-change').parent().toggleClass('text-green-600 text-red-600', Math.random() > 0.5);
                $('#quantity-change').parent().toggleClass('text-green-600 text-red-600', Math.random() > 0.5);
                $('#profit-change').parent().toggleClass('text-green-600 text-red-600', Math.random() > 0.5);
                $('#orders-change').parent().toggleClass('text-green-600 text-red-600', Math.random() > 0.5);
                
                // Update arrow icons
                $('#sales-change').prev().toggleClass('fa-arrow-up fa-arrow-down', Math.random() > 0.5);
                $('#quantity-change').prev().toggleClass('fa-arrow-up fa-arrow-down', Math.random() > 0.5);
                $('#profit-change').prev().toggleClass('fa-arrow-up fa-arrow-down', Math.random() > 0.5);
                $('#orders-change').prev().toggleClass('fa-arrow-up fa-arrow-down', Math.random() > 0.5);
            });
            
            // Filter change handlers
            $('input[type="checkbox"]').change(function() {
                // In a real implementation, you would filter the data based on these selections
                showToast("Filters applied", "info");
            });
            
            $('#dateRange').change(function() {
                showToast(`Date range changed to ${$(this).val()}`, "info");
            });
            
            // Helper function to show toast notifications
            function showToast(message, type) {
                const toast = $(`
                    <div class="fixed bottom-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg border-l-4 ${type === 'success' ? 'border-green-500' : type === 'error' ? 'border-red-500' : 'border-blue-500'}" role="alert">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${type === 'success' ? 'text-green-500 bg-green-100' : type === 'error' ? 'text-red-500 bg-red-100' : 'text-blue-500 bg-blue-100'} rounded-lg">
                            <i class="fas ${type === 'success' ? 'fa-check' : type === 'error' ? 'fa-times' : 'fa-info-circle'}"></i>
                        </div>
                        <div class="ml-3 text-sm font-normal">${message}</div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast-success" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);
                
                $('body').append(toast);
                
                // Auto-remove after 3 seconds
                setTimeout(() => {
                    toast.fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 3000);
                
                // Manual close
                toast.find('button').click(function() {
                    toast.fadeOut(500, function() {
                        $(this).remove();
                    });
                });
            }
        });
    </script>
</body>
</html>