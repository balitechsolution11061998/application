<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusPOS Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        'primary-dark': '#4f46e5',
                        secondary: '#10b981',
                        'secondary-dark': '#059669',
                        dark: '#1e293b',
                        light: '#f8fafc',
                        danger: '#ef4444',
                        warning: '#f59e0b',
                        info: '#3b82f6'
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 2s infinite'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #6366f1, #10b981);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Premium Top Bar -->
        <header class="bg-gradient-to-r from-dark to-gray-800 text-white shadow-xl">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="text-3xl font-extrabold gradient-text">NexusPOS</div>
                    <div class="hidden xl:flex items-center space-x-6 text-sm">
                        <a href="#" class="flex items-center space-x-1 px-3 py-1 rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 transition">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="#" class="flex items-center space-x-1 px-3 py-1 rounded-full bg-primary hover:bg-primary-dark transition font-medium">
                            <i class="fas fa-cash-register"></i>
                            <span>POS Terminal</span>
                        </a>
                        <a href="#" class="flex items-center space-x-1 px-3 py-1 rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 transition">
                            <i class="fas fa-boxes"></i>
                            <span>Inventory</span>
                        </a>
                        <a href="#" class="flex items-center space-x-1 px-3 py-1 rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 transition">
                            <i class="fas fa-chart-network"></i>
                            <span>Analytics</span>
                        </a>
                        <a href="#" class="flex items-center space-x-1 px-3 py-1 rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 transition">
                            <i class="fas fa-users"></i>
                            <span>Customers</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative group">
                        <button class="p-2 rounded-full hover:bg-gray-700 transition relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-0 right-0 h-3 w-3 rounded-full bg-danger animate-pulse-slow"></span>
                        </button>
                        <div class="absolute right-0 mt-2 w-80 bg-white text-dark rounded-lg shadow-2xl z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-1 group-hover:translate-y-0">
                            <div class="p-4 border-b">
                                <h3 class="font-bold">Notifications (3)</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <a href="#" class="block p-3 hover:bg-gray-50 border-b transition">
                                    <div class="flex items-start">
                                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-box text-blue-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">New shipment arrived</p>
                                            <p class="text-xs text-gray-500">5 minutes ago</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block p-3 hover:bg-gray-50 border-b transition">
                                    <div class="flex items-start">
                                        <div class="bg-green-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-chart-line text-green-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">Daily sales target achieved</p>
                                            <p class="text-xs text-gray-500">1 hour ago</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block p-3 hover:bg-gray-50 transition">
                                    <div class="flex items-start">
                                        <div class="bg-yellow-100 p-2 rounded-full mr-3">
                                            <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">Low stock alert: Cappuccino</p>
                                            <p class="text-xs text-gray-500">3 hours ago</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-3 text-center bg-gray-50">
                                <a href="#" class="text-sm text-primary font-medium">View All Notifications</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <button class="flex items-center space-x-2 group">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center text-white font-medium shadow-md">
                                JD
                            </div>
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-medium">John Doe</p>
                                <p class="text-xs text-gray-300">Admin</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs hidden lg:block transition-transform group-hover:rotate-180"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-56 bg-white text-dark rounded-lg shadow-2xl z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-1 group-hover:translate-y-0">
                            <div class="p-4 border-b">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center text-white font-medium">
                                        JD
                                    </div>
                                    <div>
                                        <p class="font-medium">John Doe</p>
                                        <p class="text-xs text-gray-500">admin@example.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50 transition"><i class="fas fa-user mr-2 text-gray-500"></i> Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50 transition"><i class="fas fa-cog mr-2 text-gray-500"></i> Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50 transition"><i class="fas fa-bell mr-2 text-gray-500"></i> Notifications</a>
                            </div>
                            <div class="py-1 border-t">
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-50 text-danger transition"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 container mx-auto px-4 py-6 flex flex-col lg:flex-row gap-6">
            <!-- Left Panel - Products -->
            <div class="lg:w-3/5 flex flex-col gap-6">
                <!-- Quick Access Toolbar -->
                <div class="bg-white rounded-xl shadow-lg p-3 flex items-center justify-between">
                    <div class="flex items-center space-x-2 overflow-x-auto scrollbar-hide pb-2">
                        <button class="px-4 py-2 bg-primary text-white rounded-lg font-medium whitespace-nowrap hover:bg-primary-dark transition flex items-center">
                            <i class="fas fa-plus mr-2"></i> New Order
                        </button>
                        <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg font-medium whitespace-nowrap hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-search mr-2"></i> Find Order
                        </button>
                        <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg font-medium whitespace-nowrap hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-clock mr-2"></i> Recent Orders
                        </button>
                        <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg font-medium whitespace-nowrap hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-star mr-2"></i> Favorites
                        </button>
                    </div>
                    <div class="hidden md:flex items-center space-x-2">
                        <button class="p-2 text-gray-500 hover:text-primary hover:bg-gray-100 rounded-full transition">
                            <i class="fas fa-expand"></i>
                        </button>
                        <button class="p-2 text-gray-500 hover:text-primary hover:bg-gray-100 rounded-full transition">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>

                <!-- Search and Categories -->
                <div class="bg-white rounded-xl shadow-lg p-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="relative flex-1">
                            <input type="text" placeholder="Search products by name, SKU, or barcode..." 
                                   class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                            <button class="absolute right-3 top-3 text-gray-400 hover:text-primary">
                                <i class="fas fa-barcode"></i>
                            </button>
                        </div>
                        <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2 md:pb-0">
                            <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium whitespace-nowrap">All Items</button>
                            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium whitespace-nowrap">Food</button>
                            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium whitespace-nowrap">Beverages</button>
                            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium whitespace-nowrap">Desserts</button>
                            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium whitespace-nowrap">Alcohol</button>
                            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium whitespace-nowrap">Specials</button>
                        </div>
                    </div>
                </div>

                <!-- Product Grid with Floating Animation -->
                <div class="bg-white rounded-xl shadow-lg p-4 flex-1">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        <!-- Product Card 1 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float">
                            <div class="h-40 bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Burger" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$8.99</div>
                                <div class="absolute top-2 left-2 bg-secondary text-white text-xs px-2 py-1 rounded-full shadow-md">BEST</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Cheeseburger Deluxe</h3>
                                <p class="text-xs text-gray-500 mt-1">Fast Food • SKU: FD-001</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock: 25</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card 2 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float" style="animation-delay: 0.2s">
                            <div class="h-40 bg-gradient-to-br from-orange-50 to-yellow-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Pizza" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$12.99</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Pepperoni Pizza</h3>
                                <p class="text-xs text-gray-500 mt-1">Italian • SKU: FD-002</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock: 18</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card 3 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float" style="animation-delay: 0.4s">
                            <div class="h-40 bg-gradient-to-br from-brown-50 to-amber-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Coffee" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$4.50</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Artisan Cappuccino</h3>
                                <p class="text-xs text-gray-500 mt-1">Hot Drinks • SKU: BV-001</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Low Stock: 3</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card 4 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float" style="animation-delay: 0.6s">
                            <div class="h-40 bg-gradient-to-br from-green-50 to-teal-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1546793665-c74683f339c1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Salad" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$9.75</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Caesar Salad</h3>
                                <p class="text-xs text-gray-500 mt-1">Healthy • SKU: FD-003</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock: 12</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card 5 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float">
                            <div class="h-40 bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1554866585-cd94860890b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Soda" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$2.50</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Premium Cola</h3>
                                <p class="text-xs text-gray-500 mt-1">Soft Drinks • SKU: BV-002</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock: 42</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card 6 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float" style="animation-delay: 0.2s">
                            <div class="h-40 bg-gradient-to-br from-purple-50 to-indigo-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1516559828984-fb3b99548b21?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Ice Cream" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$5.25</div>
                                <div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full shadow-md">NEW</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Vanilla Dream</h3>
                                <p class="text-xs text-gray-500 mt-1">Desserts • SKU: DS-001</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock: 15</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card 7 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float" style="animation-delay: 0.4s">
                            <div class="h-40 bg-gradient-to-br from-amber-50 to-orange-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1513309914637-65c20a5962e1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Beer" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$6.00</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Craft Beer</h3>
                                <p class="text-xs text-gray-500 mt-1">Alcohol • SKU: AL-001</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock: 24</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Card 8 -->
                        <div class="border rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer group animate-float" style="animation-delay: 0.6s">
                            <div class="h-40 bg-gradient-to-br from-yellow-50 to-amber-50 flex items-center justify-center relative">
                                <img src="https://images.unsplash.com/photo-1585109649139-366815a0d713?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Fries" class="h-full object-cover">
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-full shadow-md">$3.99</div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-primary transition">Truffle Fries</h3>
                                <p class="text-xs text-gray-500 mt-1">Snacks • SKU: FD-004</p>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">In Stock: 32</span>
                                    <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded-full transition transform hover:scale-110">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Cart and Payment -->
            <div class="lg:w-2/5 flex flex-col gap-6">
                <!-- Customer Info with Floating Labels -->
                <div class="bg-white rounded-xl shadow-lg p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-bold text-xl gradient-text">Customer</h2>
                        <button class="text-primary hover:text-primary-dark font-medium flex items-center">
                            <i class="fas fa-plus mr-1"></i> New Customer
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="relative">
                            <select class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary appearance-none">
                                <option selected disabled></option>
                                <option>Walk-in Customer</option>
                                <option>John Smith (VIP)</option>
                                <option>Sarah Johnson</option>
                                <option>Michael Brown</option>
                            </select>
                            <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">Customer</label>
                            <i class="fas fa-chevron-down absolute right-3 top-4 text-gray-400 pointer-events-none"></i>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="text" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder=" ">
                                <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">First Name</label>
                            </div>
                            <div class="relative">
                                <input type="text" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder=" ">
                                <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">Last Name</label>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <input type="email" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder=" ">
                            <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">Email</label>
                        </div>
                        
                        <div class="relative">
                            <input type="tel" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder=" ">
                            <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">Phone</label>
                        </div>
                    </div>
                </div>

                <!-- Cart Items with Floating Animation -->
                <div class="bg-white rounded-xl shadow-lg p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <h2 class="font-bold text-xl gradient-text">Current Order</h2>
                            <p class="text-xs text-gray-500">#ORD-1245 • Today, 2:45 PM</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-2 text-gray-500 hover:text-danger hover:bg-red-50 rounded-full transition">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="p-2 text-gray-500 hover:text-primary hover:bg-blue-50 rounded-full transition">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto scrollbar-hide space-y-4 pr-2">
                        <!-- Cart Item 1 -->
                        <div class="flex gap-3 border-b pb-4 group">
                            <div class="h-16 w-16 bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Burger" class="h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h3 class="font-bold">Cheeseburger Deluxe</h3>
                                    <p class="font-bold">$8.99</p>
                                </div>
                                <p class="text-xs text-gray-500">Fast Food • SKU: FD-001</p>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-2 py-1 text-gray-500 hover:bg-gray-100 transition">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <span class="px-2 border-x">1</span>
                                        <button class="px-2 py-1 text-gray-500 hover:bg-gray-100 transition">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    <button class="text-gray-400 hover:text-danger transition opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Item 2 -->
                        <div class="flex gap-3 border-b pb-4 group">
                            <div class="h-16 w-16 bg-gradient-to-br from-orange-50 to-yellow-50 rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Pizza" class="h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h3 class="font-bold">Pepperoni Pizza</h3>
                                    <p class="font-bold">$25.98</p>
                                </div>
                                <p class="text-xs text-gray-500">Italian • SKU: FD-002</p>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-2 py-1 text-gray-500 hover:bg-gray-100 transition">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <span class="px-2 border-x">2</span>
                                        <button class="px-2 py-1 text-gray-500 hover:bg-gray-100 transition">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    <button class="text-gray-400 hover:text-danger transition opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Item 3 -->
                        <div class="flex gap-3 border-b pb-4 group">
                            <div class="h-16 w-16 bg-gradient-to-br from-red-50 to-pink-50 rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1554866585-cd94860890b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" alt="Cola" class="h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h3 class="font-bold">Premium Cola</h3>
                                    <p class="font-bold">$2.50</p>
                                </div>
                                <p class="text-xs text-gray-500">Soft Drinks • SKU: BV-002</p>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-2 py-1 text-gray-500 hover:bg-gray-100 transition">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <span class="px-2 border-x">1</span>
                                        <button class="px-2 py-1 text-gray-500 hover:bg-gray-100 transition">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    <button class="text-gray-400 hover:text-danger transition opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes and Discount -->
                    <div class="mt-4 space-y-3">
                        <div class="relative">
                            <textarea class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" rows="2" placeholder=" "></textarea>
                            <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">Order Notes</label>
                        </div>
                        
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <input type="text" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder=" ">
                                <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">Discount Code</label>
                            </div>
                            <button class="bg-secondary hover:bg-secondary-dark text-white px-4 rounded-lg font-medium transition">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary with Advanced Features -->
                <div class="bg-white rounded-xl shadow-lg p-5">
                    <h2 class="font-bold text-xl gradient-text mb-4">Payment Summary</h2>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal (3 items)</span>
                            <span class="font-medium">$37.47</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax (10%)</span>
                            <span class="font-medium">$3.75</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Discount</span>
                            <span class="font-medium text-secondary">-$5.00</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span class="gradient-text">$36.22</span>
                        </div>
                    </div>

                    <!-- Quick Payment Actions -->
                    <div class="grid grid-cols-4 gap-2 mb-4">
                        <button class="bg-blue-50 hover:bg-blue-100 text-blue-800 p-2 rounded-lg transition flex flex-col items-center">
                            <i class="fas fa-credit-card mb-1"></i>
                            <span class="text-xs">Card</span>
                        </button>
                        <button class="bg-green-50 hover:bg-green-100 text-green-800 p-2 rounded-lg transition flex flex-col items-center">
                            <i class="fas fa-money-bill-wave mb-1"></i>
                            <span class="text-xs">Cash</span>
                        </button>
                        <button class="bg-purple-50 hover:bg-purple-100 text-purple-800 p-2 rounded-lg transition flex flex-col items-center">
                            <i class="fab fa-paypal mb-1"></i>
                            <span class="text-xs">PayPal</span>
                        </button>
                        <button class="bg-yellow-50 hover:bg-yellow-100 text-yellow-800 p-2 rounded-lg transition flex flex-col items-center">
                            <i class="fas fa-mobile-alt mb-1"></i>
                            <span class="text-xs">Mobile</span>
                        </button>
                    </div>

                    <!-- Tender Amount -->
                    <div class="mb-4">
                        <div class="relative">
                            <input type="number" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" placeholder=" " value="40.00">
                            <label class="absolute left-3 -top-2 bg-white px-1 text-xs text-gray-500 pointer-events-none">Tender Amount</label>
                            <span class="absolute right-3 top-3 text-gray-500">$</span>
                        </div>
                        <div class="flex justify-between mt-1 text-sm">
                            <span class="text-gray-500">Change Due</span>
                            <span class="font-medium text-green-600">$3.78</span>
                        </div>
                    </div>

                    <!-- Complete Order Button with Animation -->
                    <button class="w-full bg-gradient-to-r from-primary to-secondary hover:from-primary-dark hover:to-secondary-dark text-white py-4 rounded-lg font-bold text-lg transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.01] flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane animate-bounce-slow"></i>
                        Complete Order
                    </button>
                </div>
            </div>
        </main>

        <!-- Floating Action Button -->
        <div class="fixed bottom-6 right-6 z-50">
            <button class="h-14 w-14 bg-primary hover:bg-primary-dark text-white rounded-full shadow-xl flex items-center justify-center transition-transform hover:scale-110">
                <i class="fas fa-question text-xl"></i>
            </button>
        </div>
    </div>
</body>
</html>