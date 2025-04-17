@extends('pos.index')

@section('content')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Glassmorphism Header with Floating Elements -->
    <div class="mb-10 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-2xl p-8 text-white relative overflow-hidden transform transition-all hover:scale-[1.01] duration-300 group">
        <!-- Floating bubbles -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-purple-500/20 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
        <div class="absolute bottom-0 left-10 w-32 h-32 bg-indigo-500/20 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
        <div class="absolute top-1/4 left-1/4 w-16 h-16 bg-white/10 rounded-full group-hover:translate-x-10 transition-transform duration-1000"></div>
        
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-6">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-white to-purple-200">Dashboard Overview</h1>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-calendar-day mr-2 text-purple-200"></i>
                            <span class="font-medium">{{ date('l, F j, Y') }}</span>
                        </div>
                        <div class="flex items-center bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm">
                            <i class="fas fa-clock mr-2 text-purple-200"></i>
                            <span class="font-medium">{{ date('h:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm shadow-lg transform group-hover:rotate-6 transition-transform duration-500">
                    <i class="fas fa-chart-pie text-4xl text-purple-100"></i>
                </div>
            </div>
            
            <!-- Mini Stats with Glow Hover -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm shadow-md hover:shadow-purple-500/30 transition-all duration-300 hover:bg-white/15">
                    <p class="text-sm text-purple-100">Monthly Target</p>
                    <p class="text-2xl font-bold">85%</p>
                    <div class="w-full h-1.5 bg-white/20 rounded-full mt-2 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-cyan-400 to-purple-400 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm shadow-md hover:shadow-purple-500/30 transition-all duration-300 hover:bg-white/15">
                    <p class="text-sm text-purple-100">Customer Rating</p>
                    <p class="text-2xl font-bold">4.8</p>
                    <div class="flex mt-1 space-x-0.5">
                        <i class="fas fa-star text-yellow-300 text-xs"></i>
                        <i class="fas fa-star text-yellow-300 text-xs"></i>
                        <i class="fas fa-star text-yellow-300 text-xs"></i>
                        <i class="fas fa-star text-yellow-300 text-xs"></i>
                        <i class="fas fa-star-half-alt text-yellow-300 text-xs"></i>
                    </div>
                </div>
                <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm shadow-md hover:shadow-purple-500/30 transition-all duration-300 hover:bg-white/15">
                    <p class="text-sm text-purple-100">Active Products</p>
                    <p class="text-2xl font-bold" x-text="products.length"></p>
                    <p class="text-xs mt-1 text-purple-200 flex items-center">
                        <span class="bg-white/10 px-1 rounded mr-1">+5</span> this week
                    </p>
                </div>
                <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm shadow-md hover:shadow-purple-500/30 transition-all duration-300 hover:bg-white/15">
                    <p class="text-sm text-purple-100">New Customers</p>
                    <p class="text-2xl font-bold">12</p>
                    <p class="text-xs mt-1 text-purple-200 flex items-center">
                        <span class="bg-white/10 px-1 rounded mr-1">3</span> active now
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Cards with Floating Icons -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Today's Sales Card -->
        <div class="bg-gradient-to-br from-white to-indigo-50 rounded-2xl shadow-lg p-6 group hover:transform hover:-translate-y-2 transition-all duration-300 border border-indigo-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-100 rounded-full opacity-20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-indigo-400 mb-2">Today's Sales</p>
                        <p class="text-3xl font-bold text-indigo-600">Rp <span x-text="numberFormat(3450000)"></span></p>
                    </div>
                    <div class="bg-indigo-500 p-3 rounded-lg shadow-lg text-white group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-wallet text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>12%
                    </span>
                    <span class="ml-2 text-sm text-gray-500">vs yesterday</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-400 to-cyan-400 rounded-full w-3/4 animate-pulse"></div>
                </div>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg p-6 group hover:transform hover:-translate-y-2 transition-all duration-300 border border-blue-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-100 rounded-full opacity-20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-blue-400 mb-2">Transactions</p>
                        <p class="text-3xl font-bold text-blue-600">42</p>
                    </div>
                    <div class="bg-blue-500 p-3 rounded-lg shadow-lg text-white group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-exchange-alt text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>8%
                    </span>
                    <span class="ml-2 text-sm text-gray-500">vs last week</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full w-1/2 animate-pulse"></div>
                </div>
            </div>
        </div>

        <!-- Top Product Card -->
        <div class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg p-6 group hover:transform hover:-translate-y-2 transition-all duration-300 border border-purple-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-purple-100 rounded-full opacity-20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-purple-400 mb-2">Top Product</p>
                        <p class="text-2xl font-bold text-purple-600">Green Tea</p>
                    </div>
                    <div class="bg-purple-500 p-3 rounded-lg shadow-lg text-white group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-crown text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-xs font-medium">
                        128 sold
                    </span>
                    <span class="ml-2 text-sm text-gray-500">this week</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-400 to-pink-400 rounded-full w-5/6 animate-pulse"></div>
                </div>
            </div>
        </div>

        <!-- Inventory Value Card -->
        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg p-6 group hover:transform hover:-translate-y-2 transition-all duration-300 border border-amber-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-100 rounded-full opacity-20"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-amber-400 mb-2">Inventory Value</p>
                        <p class="text-3xl font-bold text-amber-600">Rp <span x-text="numberFormat(12500000)"></span></p>
                    </div>
                    <div class="bg-amber-500 p-3 rounded-lg shadow-lg text-white group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-boxes text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span class="bg-amber-100 text-amber-600 px-2 py-1 rounded-full text-xs font-medium">
                        <i class="fas fa-exclamation-triangle mr-1"></i>3 low
                    </span>
                    <span class="ml-2 text-sm text-gray-500">stock items</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full mt-4 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-400 to-orange-400 rounded-full w-2/3 animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Chart Section with Ultra Rounded Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
        <!-- Sales Chart - Wider -->
        <div class="bg-white rounded-3xl shadow-xl p-6 lg:col-span-3 border border-gray-100 hover:shadow-2xl transition-shadow duration-300 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-100 rounded-full opacity-10"></div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-chart-line text-indigo-600 mr-2"></i>
                    Sales Performance
                </h3>
                <div class="relative">
                    <select class="appearance-none bg-indigo-50 text-indigo-700 py-2 pl-4 pr-8 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 border border-indigo-100">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>This Year</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-3 text-indigo-500 text-sm"></i>
                </div>
            </div>
            <div class="h-80" id="salesChart"></div>
        </div>

        <!-- Revenue Breakdown - Narrower -->
        <div class="bg-white rounded-3xl shadow-xl p-6 lg:col-span-2 border border-gray-100 hover:shadow-2xl transition-shadow duration-300 relative overflow-hidden">
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-purple-100 rounded-full opacity-10"></div>
            <h3 class="text-lg font-bold text-gray-800 mb-6">
                <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
                Revenue Breakdown
            </h3>
            <div class="h-80" id="pieChart"></div>
        </div>
    </div>

    <!-- New Section: Recent Orders & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6 mb-8">
        <!-- Recent Orders Table -->
        <div class="bg-white rounded-3xl shadow-xl p-6 lg:col-span-4 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-shopping-bag text-indigo-600 mr-2"></i>
                    Recent Orders
                </h3>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium flex items-center">
                    View All
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3 rounded-l-lg">Order ID</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Amount</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 rounded-r-lg">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="text-sm hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-800">#ORD-2305</td>
                            <td class="px-4 py-3">Siti Rahma</td>
                            <td class="px-4 py-3 font-medium">Rp 135.000</td>
                            <td class="px-4 py-3">
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Completed</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">10:24 AM</td>
                        </tr>
                        <tr class="text-sm hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-800">#ORD-2304</td>
                            <td class="px-4 py-3">Budi Santoso</td>
                            <td class="px-4 py-3 font-medium">Rp 85.000</td>
                            <td class="px-4 py-3">
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">Processing</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">9:45 AM</td>
                        </tr>
                        <tr class="text-sm hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-800">#ORD-2303</td>
                            <td class="px-4 py-3">Rini Wijaya</td>
                            <td class="px-4 py-3 font-medium">Rp 210.000</td>
                            <td class="px-4 py-3">
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Completed</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">Yesterday</td>
                        </tr>
                        <tr class="text-sm hover:bg-indigo-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-800">#ORD-2302</td>
                            <td class="px-4 py-3">Agus Purnomo</td>
                            <td class="px-4 py-3 font-medium">Rp 150.000</td>
                            <td class="px-4 py-3">
                                <span class="bg-amber-100 text-amber-700 text-xs px-2 py-1 rounded-full">Pending</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">Yesterday</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-3xl shadow-xl p-6 lg:col-span-3 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
            <h3 class="text-lg font-bold text-gray-800 mb-6">
                <i class="fas fa-bolt text-amber-500 mr-2"></i>
                Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="bg-indigo-50 hover:bg-indigo-100 rounded-xl p-4 text-center transition-colors duration-300">
                    <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-plus text-indigo-600 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">New Order</p>
                </a>
                <a href="#" class="bg-green-50 hover:bg-green-100 rounded-xl p-4 text-center transition-colors duration-300">
                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-box text-green-600 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Add Product</p>
                </a>
                <a href="#" class="bg-blue-50 hover:bg-blue-100 rounded-xl p-4 text-center transition-colors duration-300">
                    <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">New Customer</p>
                </a>
                <a href="#" class="bg-purple-50 hover:bg-purple-100 rounded-xl p-4 text-center transition-colors duration-300">
                    <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-700">View Reports</p>
                </a>
            </div>

            <!-- Inventory Alerts -->
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-exclamation-triangle text-amber-500 mr-2"></i>
                    Low Stock Alerts
                </h4>
                <div class="space-y-2">
                    <div class="flex items-center justify-between bg-amber-50 px-3 py-2 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-amber-100 p-1 rounded mr-2">
                                <i class="fas fa-wine-bottle text-amber-600 text-sm"></i>
                            </div>
                            <span class="text-sm">Green Tea</span>
                        </div>
                        <span class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded-full">3 left</span>
                    </div>
                    <div class="flex items-center justify-between bg-amber-50 px-3 py-2 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-amber-100 p-1 rounded mr-2">
                                <i class="fas fa-coffee text-amber-600 text-sm"></i>
                            </div>
                            <span class="text-sm">Arabica Coffee</span>
                        </div>
                        <span class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded-full">5 left</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Section: Product Performance -->
    <div class="bg-white rounded-3xl shadow-xl p-6 mb-8 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
        <h3 class="text-lg font-bold text-gray-800 mb-6">
            <i class="fas fa-star text-amber-400 mr-2"></i>
            Product Performance
        </h3>
        <div class="h-96" id="barChart"></div>
    </div>

    <!-- Performance Metrics -->
    <div class="bg-white rounded-3xl shadow-xl p-6 mb-8 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
        <h3 class="text-lg font-bold text-gray-800 mb-6">
            <i class="fas fa-tachometer-alt text-indigo-600 mr-2"></i>
            Performance Metrics
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-sm font-medium text-gray-500 mb-1">Sales Target</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-bold text-indigo-600">78%</p>
                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500 rounded-full" style="width: 78%"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-sm font-medium text-gray-500 mb-1">Conversion Rate</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-bold text-green-600">42%</p>
                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: 42%"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-sm font-medium text-gray-500 mb-1">Avg. Order Value</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-bold text-blue-600">Rp 125K</p>
                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-sm font-medium text-gray-500 mb-1">Customer Retention</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-bold text-purple-600">89%</p>
                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-500 rounded-full" style="width: 89%"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-xl">
                <p class="text-sm font-medium text-gray-500 mb-1">Inventory Turnover</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-bold text-amber-600">3.2x</p>
                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: 64%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Required AmCharts core -->
<!-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize ultra rounded line chart with AmCharts
        am5.ready(function() {
            // Create root element
            var root = am5.Root.new("salesChart");
            
            // Set themes
            root.setThemes([am5themes_Animated.new(root)]);
            
            // Create chart
            var chart = root.container.children.push(
                am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true,
                    paddingLeft: 0,
                    paddingRight: 0
                })
            );
            
            // Add cursor
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none"
            }));
            cursor.lineY.set("visible", false);
            
            // Create axes
            var xAxis = chart.xAxes.push(
                am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "month",
                    renderer: am5xy.AxisRendererX.new(root, {
                        minGridDistance: 30,
                        strokeOpacity: 0.1
                    }),
                    tooltip: am5.Tooltip.new(root, {})
                })
            );
            
            var yAxis = chart.yAxes.push(
                am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1
                    })
                })
            );
            
            // Create series
            var series = chart.series.push(
                am5xy.LineSeries.new(root, {
                    name: "Sales",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "value",
                    categoryXField: "month",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "Rp {valueY}",
                        background: am5.RoundedRectangle.new(root, {
                            cornerRadiusTL: 10,
                            cornerRadiusTR: 10,
                            cornerRadiusBL: 10,
                            cornerRadiusBR: 10,
                            fill: am5.color("#6366F1"),
                            fillOpacity: 0.9
                        })
                    }),
                    stroke: am5.color("#6366F1"),
                    fill: am5.color("#6366F1")
                })
            );
            
            // Configure series appearance
            series.fills.template.setAll({
                fillOpacity: 0.2,
                visible: true
            });
            
            // Corrected way to set line properties
            series.strokes.template.setAll({
                strokeWidth: 4,
                strokeDasharray: [0, 0],
                lineJoin: "round",
                lineCap: "round"
            });
            
            // Add rounded bullets for data points
            series.bullets.push(function() {
                var circle = am5.Circle.new(root, {
                    radius: 6,
                    fill: am5.color("#6366F1"),
                    stroke: am5.color("#ffffff"),
                    strokeWidth: 2
                });
                
                circle.set("shadow", am5.Shadow.new(root, {
                    blur: 5,
                    opacity: 0.5,
                    color: am5.color("#6366F1"),
                    offsetX: 0,
                    offsetY: 0
                }));
                
                return am5.Bullet.new(root, {
                    sprite: circle,
                    dynamic: true,
                    dynamicSize: true
                });
            });
            
            // Set data
            var data = [
                { month: "Jan", value: 6500000 },
                { month: "Feb", value: 5900000 },
                { month: "Mar", value: 8000000 },
                { month: "Apr", value: 8100000 },
                { month: "May", value: 5600000 },
                { month: "Jun", value: 7500000 },
                { month: "Jul", value: 8200000 },
                { month: "Aug", value: 7800000 },
                { month: "Sep", value: 9000000 }
            ];
            
            xAxis.data.setAll(data);
            series.data.setAll(data);
            
            // Add scrollbar with rounded corners
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal",
                background: am5.RoundedRectangle.new(root, {
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5,
                    cornerRadiusBL: 5,
                    cornerRadiusBR: 5,
                    fill: am5.color("#E5E7EB")
                })
            }));
            
            // Make the chart animate
            series.appear(1000);
            chart.appear(1000, 100);
        });
        
        // Initialize ultra rounded pie chart with AmCharts
        am5.ready(function() {
            // Create root element
            var root = am5.Root.new("pieChart");
            
            // Set themes
            root.setThemes([am5themes_Animated.new(root)]);
            
            // Create chart
            var chart = root.container.children.push(
                am5percent.PieChart.new(root, {
                    layout: root.verticalLayout,
                    innerRadius: am5.percent(50),
                    radius: am5.percent(90)
                })
            );
            
            // Create series
            var series = chart.series.push(
                am5percent.PieSeries.new(root, {
                    valueField: "value",
                    categoryField: "category",
                    alignLabels: true,
                    innerRadius: am5.percent(50),
                    startAngle: 180,
                    endAngle: 360
                })
            );
            
            // Configure slices with ultra rounded corners
            series.slices.template.setAll({
                strokeWidth: 2,
                stroke: am5.color(0xffffff),
                cornerRadius: 15,
                fillOpacity: 0.9
            });
            
            // Add effects to slices on hover
            series.slices.template.states.create("hover", {
                fillOpacity: 1,
                scale: 1.03
            });
            
            // Configure labels
            series.labels.template.setAll({
                fontSize: 12,
                fontWeight: "500",
                textType: "circular",
                radius: 10,
                inside: true,
                text: "{category}: {valuePercentTotal.formatNumber('0.0')}%"
            });
            
            // Configure tooltips with rounded corners
            series.slices.template.set("tooltip", am5.Tooltip.new(root, {
                labelText: "{category}: Rp {value} ({valuePercentTotal.formatNumber('0.0')}%)",
                background: am5.RoundedRectangle.new(root, {
                    cornerRadiusTL: 10,
                    cornerRadiusTR: 10,
                    cornerRadiusBL: 10,
                    cornerRadiusBR: 10,
                    fill: am5.color("#ffffff"),
                    fillOpacity: 0.95,
                    stroke: am5.color("#E5E7EB"),
                    strokeWidth: 1
                })
            }));
            
            // Add legend with rounded items
            var legend = chart.children.push(
                am5.Legend.new(root, {
                    centerX: am5.percent(50),
                    x: am5.percent(50),
                    marginTop: 15,
                    marginBottom: 15,
                    layout: am5.GridLayout.new(root, {
                        maxColumns: 2,
                        fixedWidthGrid: true
                    })
                })
            );
            
            legend.markers.template.setAll({
                width: 12,
                height: 12,
                cornerRadius: 6
            });
            
            legend.valueLabels.template.setAll({
                textAlign: "right"
            });
            
            legend.labels.template.setAll({
                fontSize: 12
            });
            
            legend.data.setAll(series.dataItems);
            
            // Set data
            series.data.setAll([
                { category: "Food & Beverage", value: 65, color: am5.color("#6366F1") },
                { category: "Electronics", value: 15, color: am5.color("#EC4899") },
                { category: "Fashion", value: 12, color: am5.color("#10B981") },
                { category: "Home Goods", value: 5, color: am5.color("#F59E0B") },
                { category: "Others", value: 3, color: am5.color("#3B82F6") }
            ]);
            
            // Play initial series animation
            series.appear(1000, 100);
        });
        
        // Initialize rounded bar chart for product performance
        am5.ready(function() {
            // Create root element
            var root = am5.Root.new("barChart");
            
            // Set themes
            root.setThemes([am5themes_Animated.new(root)]);
            
            // Create chart
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
            
            // Create axes
            var yAxis = chart.yAxes.push(
                am5xy.CategoryAxis.new(root, {
                    categoryField: "product",
                    renderer: am5xy.AxisRendererY.new(root, {
                        minGridDistance: 20,
                        strokeOpacity: 0.1,
                        cellStartLocation: 0.1,
                        cellEndLocation: 0.9
                    })
                })
            );
            
            var xAxis = chart.xAxes.push(
                am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererX.new(root, {
                        strokeOpacity: 0.1
                    })
                })
            );
            
            // Create series
            var series = chart.series.push(
                am5xy.ColumnSeries.new(root, {
                    name: "Sales",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueXField: "sales",
                    categoryYField: "product",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{product}: Rp {valueX}",
                        background: am5.RoundedRectangle.new(root, {
                            cornerRadiusTL: 10,
                            cornerRadiusTR: 10,
                            cornerRadiusBL: 10,
                            cornerRadiusBR: 10,
                            fill: am5.color("#ffffff"),
                            fillOpacity: 0.95,
                            stroke: am5.color("#E5E7EB"),
                            strokeWidth: 1
                        })
                    })
                })
            );
            
            // Configure columns with rounded corners
            series.columns.template.setAll({
                width: am5.percent(70),
                strokeOpacity: 0,
                cornerRadiusTL: 10,
                cornerRadiusTR: 10,
                cornerRadiusBL: 10,
                cornerRadiusBR: 10,
                tooltipY: 0
            });
            
            // Add gradient fill to columns
            series.columns.template.adapters.add("fill", function(fill, target) {
                return am5.Color.brighten(am5.color("#6366F1"), target.dataItem.index * 0.2);
            });
            
            // Add rounded bullets for data points
            series.bullets.push(function() {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: "{valueX}",
                        fill: am5.color("#ffffff"),
                        centerX: am5.percent(50),
                        centerY: am5.percent(50),
                        populateText: true
                    })
                });
            });
            
            // Set data
            var data = [
                { product: "Green Tea", sales: 1280000 },
                { product: "Arabica Coffee", sales: 980000 },
                { product: "Milk Tea", sales: 750000 },
                { product: "Black Coffee", sales: 620000 },
                { product: "Chocolate", sales: 480000 },
                { product: "Latte", sales: 420000 }
            ];
            
            yAxis.data.setAll(data);
            series.data.setAll(data);
            
            // Add scrollbar with rounded corners
            chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal",
                background: am5.RoundedRectangle.new(root, {
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5,
                    cornerRadiusBL: 5,
                    cornerRadiusBR: 5,
                    fill: am5.color("#E5E7EB")
                })
            }));
            
            // Make the chart animate
            series.appear(1000);
            chart.appear(1000, 100);
        });
    });
</script> -->