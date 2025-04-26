@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6 max-w-7xl mx-auto">
    <!-- Header Section with Enhanced Animation -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-6 mb-8 shadow-xl transform transition-all duration-500 hover:scale-[1.005] hover:shadow-2xl relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-20 w-32 h-32 rounded-full bg-white animate-pulse" style="animation-delay: 0.5s"></div>
            <div class="absolute bottom-5 right-10 w-40 h-40 rounded-full bg-white animate-pulse" style="animation-delay: 1s"></div>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="h-16 w-16 rounded-full border-4 border-white/80 shadow-lg overflow-hidden bg-white/20 backdrop-blur-sm flex items-center justify-center transition-transform duration-300 hover:rotate-6">
                    @if($paguyuban->logo)
                    <img src="{{ asset('storage/'.$paguyuban->logo) }}" alt="{{ $paguyuban->name }}" class="h-full w-full object-cover transform transition-transform duration-500 hover:scale-110">
                    @else
                    <i class="fas fa-users text-white/80 text-3xl"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight animate-fade-in-up">
                        {{ $paguyuban->name }}
                    </h1>
                    <div class="flex items-center mt-2 space-x-3">
                        <div class="status-badge relative">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-white/20 text-white backdrop-blur-sm' : 'bg-red-500/90 text-white' }} animate-pulse cursor-pointer">
                                <span class="w-2 h-2 rounded-full mr-2 {{ $paguyuban->is_active ? 'bg-green-300' : 'bg-red-300' }}"></span>
                                {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="status-tooltip hidden absolute z-10 w-48 p-2 mt-2 text-sm text-white bg-gray-800 rounded-lg shadow-lg">
                                {{ $paguyuban->is_active ? 'This community is currently active' : 'This community is currently inactive' }}
                            </div>
                        </div>
                        <span class="text-white/80 text-sm transition-all duration-300 hover:text-white flex items-center">
                            <i class="fas fa-users mr-1"></i>
                            {{ $paguyuban->members_count }} members
                        </span>
                        <span class="text-white/80 text-sm transition-all duration-300 hover:text-white flex items-center">
                            <i class="fas fa-tags mr-1"></i>
                            {{ $paguyuban->products_count }} special products
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 w-full md:w-auto mt-3 sm:mt-0">
                <a href="{{ route('pos.community.edit', $paguyuban) }}" class="flex items-center justify-center px-5 py-2.5 bg-white/90 hover:bg-white text-indigo-600 rounded-xl shadow-sm transition-all duration-300 group hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Edit Community</span>
                </a>
                <button onclick="toggleMembersList()" class="flex items-center justify-center px-5 py-2.5 bg-indigo-700/90 hover:bg-indigo-600 text-white rounded-xl shadow-sm transition-all duration-300 group hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Manage Members</span>
                </button>
                <a href="{{ route('pos.community.index') }}" class="flex items-center justify-center px-5 py-2.5 border border-white/50 rounded-xl bg-white/10 text-white hover:bg-white/20 transition-colors duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Back</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Members List Modal (Hidden by default) -->
    <div id="membersListModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="membersModalContent">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $paguyuban->name }} Members
                </h3>
                <button onclick="toggleMembersList()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mb-4 flex justify-between items-center">
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="memberSearch" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search members...">
                </div>
                <button onclick="openAddMemberModal()" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i> Add Member
                </button>
            </div>
            
            <div class="space-y-3 max-h-96 overflow-y-auto" id="membersListContainer">
                <!-- Members will be loaded here via AJAX -->
                <div class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-indigo-500"></i>
                    <p class="text-gray-500 mt-2">Loading members...</p>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing <span id="membersFrom" class="font-medium">0</span> to <span id="membersTo" class="font-medium">0</span> of <span id="membersTotal" class="font-medium">0</span> members
                </div>
                <div class="flex space-x-2">
                    <button id="prevMembersPage" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-0.5 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Previous
                    </button>
                    <button id="nextMembersPage" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:translate-x-0.5 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Member Modal -->
    <div id="addMemberModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="addMemberModalContent">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add New Member
                </h3>
                <button onclick="closeAddMemberModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="addMemberForm">
                @csrf
                <input type="hidden" name="paguyuban_id" value="{{ $paguyuban->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label for="memberName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Member Name</label>
                        <input type="text" id="memberName" name="name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="memberEmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                        <input type="email" id="memberEmail" name="email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="memberPhone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                        <input type="tel" id="memberPhone" name="phone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="memberAddress" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                        <textarea id="memberAddress" name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddMemberModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add Member
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Details and Stats -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Community Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-info-circle text-indigo-500 mr-2 animate-bounce" style="animation-duration: 2s"></i>
                        Community Details
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-5">
                        <!-- Description with read more/less functionality -->
                        <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Description</p>
                            <div class="relative">
                                <p id="communityDescription" class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed overflow-hidden" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                    {{ $paguyuban->description ?? 'No description provided' }}
                                </p>
                                @if(strlen($paguyuban->description) > 150)
                                <button onclick="toggleDescription()" class="text-indigo-600 dark:text-indigo-400 text-xs font-medium mt-1 focus:outline-none">
                                    Read more
                                </button>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Status Card -->
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' }} {{ $paguyuban->is_active ? 'animate-pulse' : '' }}" style="animation-duration: 3s">
                                        {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                            
                            <!-- Members Count Card -->
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Members</p>
                                <p class="text-gray-700 dark:text-gray-300 font-medium animate-count" data-count="{{ $paguyuban->members_count }}">
                                    0
                                </p>
                            </div>
                            
                            <!-- Products Count Card -->
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Special Products</p>
                                <p class="text-gray-700 dark:text-gray-300 font-medium animate-count" data-count="{{ $paguyuban->products_count }}">
                                    0
                                </p>
                            </div>
                            
                            <!-- Discount Rate Card -->
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Avg. Discount</p>
                                <p class="text-gray-700 dark:text-gray-300 font-medium">
                                    <span class="text-green-600 dark:text-green-400 animate-count" data-count="{{ $paguyuban->average_discount ?? 0 }}">0</span>%
                                </p>
                            </div>
                        </div>

                        <!-- Created date -->
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4 transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Created</p>
                            <div class="flex items-center text-gray-700 dark:text-gray-300 text-sm">
                                <i class="far fa-calendar-alt mr-2 text-gray-400 transition-transform duration-300 hover:scale-110"></i>
                                {{ $paguyuban->created_at->format('M d, Y') }}
                                <span class="text-gray-400 ml-1">({{ $paguyuban->created_at->diffForHumans() }})</span>
                            </div>
                        </div>

                        <!-- Last updated -->
                        <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Last Updated</p>
                            <div class="flex items-center text-gray-700 dark:text-gray-300 text-sm">
                                <i class="far fa-clock mr-2 text-gray-400 transition-transform duration-300 hover:scale-110"></i>
                                {{ $paguyuban->updated_at->format('M d, Y') }}
                                <span class="text-gray-400 ml-1">({{ $paguyuban->updated_at->diffForHumans() }})</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Stats Card -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-chart-line text-indigo-500 mr-2 animate-pulse" style="animation-duration: 1.5s"></i>
                        Performance Stats
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Monthly Sales Chart -->
                        <div class="animate-progress">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Sales</span>
                                <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($paguyuban->monthly_sales ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                <div class="bg-indigo-600 h-2 rounded-full progress-bar" style="width: 0%" data-width="{{ min(($paguyuban->monthly_sales ?? 0) / 20000000 * 100, 100) }}"></div>
                            </div>
                        </div>

                        <!-- Member Growth Chart -->
                        <div class="animate-progress" style="animation-delay: 0.2s">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Growth</span>
                                <span class="text-sm font-semibold {{ ($paguyuban->member_growth ?? 0) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ ($paguyuban->member_growth ?? 0) >= 0 ? '+' : '' }}{{ number_format($paguyuban->member_growth ?? 0, 1) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                <div class="{{ ($paguyuban->member_growth ?? 0) >= 0 ? 'bg-green-500' : 'bg-red-500' }} h-2 rounded-full progress-bar" style="width: 0%" data-width="{{ min(abs($paguyuban->member_growth ?? 0), 100) }}"></div>
                            </div>
                        </div>

                        <!-- Product Discounts Chart -->
                        <div class="animate-progress" style="animation-delay: 0.4s">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Product Discounts</span>
                                <span class="text-sm font-semibold text-purple-600 dark:text-purple-400">{{ $paguyuban->discounted_products_count ?? 0 }} Items</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                <div class="bg-purple-500 h-2 rounded-full progress-bar" style="width: 0%" data-width="{{ min(($paguyuban->discounted_products_count ?? 0) / ($paguyuban->products_count ?: 1) * 100, 100) }}"></div>
                            </div>
                        </div>

                        <!-- Average Discount Chart -->
                        <div class="animate-progress" style="animation-delay: 0.6s">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Discount</span>
                                <span class="text-sm font-semibold text-yellow-600 dark:text-yellow-400">{{ number_format($paguyuban->average_discount ?? 0, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                <div class="bg-yellow-500 h-2 rounded-full progress-bar" style="width: 0%" data-width="{{ min($paguyuban->average_discount ?? 0, 100) }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-bolt text-indigo-500 mr-2 animate-pulse" style="animation-duration: 1s"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-3">
                     
                        <button onclick="openModal()" class="flex flex-col items-center justify-center p-3 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-300 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors duration-200 transform hover:-translate-y-1">
                            <i class="fas fa-tag text-xl mb-2"></i>
                            <span class="text-xs font-medium">Add Product</span>
                        </button>
                        <a href="#" class="flex flex-col items-center justify-center p-3 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-300 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors duration-200 transform hover:-translate-y-1">
                            <i class="fas fa-file-export text-xl mb-2"></i>
                            <span class="text-xs font-medium">Export Data</span>
                        </a>
                   
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Products and Activity -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Products Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-tags text-indigo-500 mr-2 animate-bounce" style="animation-duration: 2.5s"></i>
                            Special Pricing
                        </h3>
                        <div class="flex space-x-3">
                            <button onclick="openModal()" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5 animate-pulse-slow">
                                <i class="fas fa-plus mr-2"></i> Add Product
                            </button>
                            <div class="relative">
                                <button id="filterDropdownButton" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-xl shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5">
                                    <i class="fas fa-filter mr-2"></i> Filter
                                </button>
                                <div id="filterDropdown" class="hidden absolute z-10 mt-1 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                                    <div class="p-3">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                                        <select id="productSort" class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <option value="name_asc">Name (A-Z)</option>
                                            <option value="name_desc">Name (Z-A)</option>
                                            <option value="price_asc">Price (Low to High)</option>
                                            <option value="price_desc">Price (High to Low)</option>
                                            <option value="discount_asc">Discount (Low to High)</option>
                                            <option value="discount_desc">Discount (High to Low)</option>
                                        </select>
                                    </div>
                                    <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter</label>
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <input id="filter_discounted" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                                                <label for="filter_discounted" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Discounted Only</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter_premium" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                                                <label for="filter_premium" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Premium Products</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg flex justify-between">
                                        <button id="resetFilters" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100">Reset</button>
                                        <button id="applyFilters" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($paguyuban->products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Regular Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Special Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Discount
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($paguyuban->products as $product)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-colors duration-150 transform hover:scale-[1.005]">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600 mr-3 transition-transform duration-300 hover:scale-110">
                                            @if($product->image)
                                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transform transition-transform duration-500 hover:scale-125">
                                            @else
                                            <i class="fas fa-box text-gray-400 dark:text-gray-500"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $product->sku }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-600 dark:text-gray-300 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $product->pivot->price < $product->price ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : ($product->pivot->price > $product->price ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }} transition-all duration-300 hover:scale-105">
                                        @if($product->pivot->price < $product->price)
                                            <i class="fas fa-arrow-down mr-1 text-xs"></i>
                                            {{ number_format(100 - ($product->pivot->price / $product->price * 100), 0) }}%
                                            @elseif($product->pivot->price > $product->price)
                                            <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                            {{ number_format(($product->pivot->price / $product->price * 100) - 100, 0) }}%
                                            @else
                                            Same
                                            @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="openEditModal({{ $product->id }}, {{ $product->pivot->price }}, '{{ $product->name }}', {{ $product->price }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors p-2 rounded-lg hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transform hover:scale-110" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button onclick="confirmDelete({{ $product->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2 rounded-lg hover:bg-red-50/50 dark:hover:bg-red-900/20 transform hover:scale-110" title="Remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">{{ $paguyuban->products->count() }}</span> of <span class="font-medium">{{ $paguyuban->products->count() }}</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-0.5 disabled:opacity-50" disabled>
                            Previous
                        </button>
                        <button class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:translate-x-0.5 disabled:opacity-50" disabled>
                            Next
                        </button>
                    </div>
                </div>
                @else
                <div class="text-center py-12 animate-fade-in">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300 mb-4 transform transition-transform duration-500 hover:rotate-360">
                        <i class="fas fa-box-open text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No special pricing</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">This community doesn't have any special pricing for products yet. Add products to provide exclusive pricing.</p>
                    <button onclick="openModal()" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5 animate-pulse-slow">
                        <i class="fas fa-plus mr-2"></i> Add Product Pricing
                    </button>
                </div>
                @endif
            </div>

            <!-- Activity Log with Enhanced Features -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-history text-indigo-500 mr-2 animate-spin" style="animation-duration: 10s"></i>
                            Recent Activity Log
                        </h3>
                        <button onclick="fetchActivityLogs({{ $paguyuban->id }})" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4" id="activityLogsContainer">
                        <!-- Activity logs will be inserted here by JavaScript -->
                        <div class="text-center py-8">
                            <i class="fas fa-spinner fa-spin text-2xl text-indigo-500"></i>
                            <p class="text-gray-500 mt-2">Loading activity logs...</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4" id="activityPagination">
                        <!-- Pagination will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Pricing Modal -->
<div id="addPricingModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Add Special Pricing
            </h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="addPricingForm" action="{{ route('pos.community.add-pricing', $paguyuban) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="animate-fade-in-up" style="animation-delay: 0.1s">
                    <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
                    <select id="product_id" name="product_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-300 hover:shadow-md">
                        <option value="">Select a product</option>
                        @foreach($availableProducts as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.2s">
                    <label for="regular_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Regular Price</label>
                    <input type="text" id="regular_price" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-300 hover:shadow-md">
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.3s">
                    <label for="special_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Special Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input type="number" id="special_price" name="price" required class="pl-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-300 hover:shadow-md">
                    </div>
                    <p id="price_difference" class="mt-1 text-sm animate-pulse" style="animation-duration: 1.5s"></p>
                </div>
                
                <div class="animate-fade-in-up" style="animation-delay: 0.4s">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pricing Type</label>
                    <div class="grid grid-cols-3 gap-3">
                        <button type="button" onclick="setDiscountType('percentage', 10)" class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">10% Off</span>
                        </button>
                        <button type="button" onclick="setDiscountType('percentage', 20)" class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">20% Off</span>
                        </button>
                        <button type="button" onclick="setDiscountType('percentage', 30)" class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">30% Off</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700 space-x-3 animate-fade-in-up" style="animation-delay: 0.5s">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-1">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300 transform hover:translate-x-1">
                    Save Pricing
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Pricing Modal -->
<div id="editPricingModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="editModalContent">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Edit Special Pricing
            </h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="editPricingForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
                    <p id="editProductName" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></p>
                </div>

                <div>
                    <label for="editRegularPrice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Regular Price</label>
                    <input type="text" id="editRegularPrice" readonly class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label for="editSpecialPrice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Special Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input type="number" id="editSpecialPrice" name="price" required class="pl-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <p id="editPriceDifference" class="mt-1 text-sm animate-pulse" style="animation-duration: 1.5s"></p>
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quick Adjustments</label>
                    <div class="grid grid-cols-4 gap-2">
                        <button type="button" onclick="adjustPrice(-1000)" class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">-1,000</span>
                        </button>
                        <button type="button" onclick="adjustPrice(1000)" class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">+1,000</span>
                        </button>
                        <button type="button" onclick="adjustPrice(-5000)" class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">-5,000</span>
                        </button>
                        <button type="button" onclick="adjustPrice(5000)" class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="block text-xs text-gray-500 dark:text-gray-400">+5,000</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700 space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Update Pricing
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-300 mb-4 animate-pulse">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Delete Pricing</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Are you sure you want to remove this special pricing? This action cannot be undone.</p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Yes, Delete It
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div id="qrCodeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="qrModalContent">
        <div class="p-6 text-center">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Community Join Code
                </h3>
                <button onclick="closeQRCodeModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="qrCodeContainer" class="flex justify-center mb-6">
                <!-- QR Code will be generated here -->
                <div class="p-4 bg-white rounded-lg border border-gray-200 dark:border-gray-600">
                    <canvas id="qrCanvas" width="200" height="200"></canvas>
                </div>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Share this code with members to let them join:</p>
                <div class="flex items-center justify-center">
                    <input id="joinCodeInput" type="text" readonly class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg bg-gray-50 dark:bg-gray-700 dark:text-white text-center font-mono" style="width: 150px;">
                    <button onclick="copyJoinCode()" class="px-3 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex justify-center space-x-3">
                <button onclick="printQRCode()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
                <button onclick="downloadQRCode()" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    <i class="fas fa-download mr-2"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed bottom-4 right-4 space-y-2 z-50"></div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulseSlow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOut {
        to {
            opacity: 0;
            transform: translateX(20px);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .animate-pulse-slow {
        animation: pulseSlow 2s infinite;
    }

    .animate-count {
        transition: all 1s ease-out;
    }

    .animate-progress {
        opacity: 0;
        transform: translateY(10px);
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .toast {
        padding: 12px 16px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        max-width: 350px;
        opacity: 0;
        transform: translateX(20px);
        animation: slideInRight 0.3s ease-out forwards;
        position: relative;
    }

    .toast.toast-success {
        border-left: 4px solid #10B981;
    }

    .toast.toast-error {
        border-left: 4px solid #EF4444;
    }

    .toast.toast-info {
        border-left: 4px solid #3B82F6;
    }

    .toast.toast-warning {
        border-left: 4px solid #F59E0B;
    }

    .toast-icon {
        margin-right: 12px;
        font-size: 20px;
    }

    .toast-success .toast-icon {
        color: #10B981;
    }

    .toast-error .toast-icon {
        color: #EF4444;
    }

    .toast-info .toast-icon {
        color: #3B82F6;
    }

    .toast-warning .toast-icon {
        color: #F59E0B;
    }

    .toast-message {
        flex: 1;
        font-size: 14px;
        color: #374151;
    }

    .toast-close {
        margin-left: 12px;
        color: #9CA3AF;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .toast-close:hover {
        color: #6B7280;
    }
</style>

<script>
    // Toastr notification function
    function showToast(message, type = 'success', duration = 5000) {
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-times-circle',
            info: 'fas fa-info-circle',
            warning: 'fas fa-exclamation-circle'
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <i class="${icons[type]} toast-icon"></i>
            <span class="toast-message">${message}</span>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        const container = document.getElementById('toast-container');
        container.appendChild(toast);

        // Trigger the animation
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0)';
        }, 10);

        // Auto remove after duration
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, duration);
    }

    // Display any existing flash messages as toasts
    @if(session('success'))
    showToast("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
    showToast("{{ session('error') }}", 'error');
    @endif
    @if(session('info'))
    showToast("{{ session('info') }}", 'info');
    @endif
    @if(session('warning'))
    showToast("{{ session('warning') }}", 'warning');
    @endif

    // Toggle description read more/less
    function toggleDescription() {
        const desc = document.getElementById('communityDescription');
        const button = desc.nextElementSibling;
        
        if (desc.style.webkitLineClamp === '3') {
            desc.style.webkitLineClamp = 'unset';
            button.textContent = 'Read less';
        } else {
            desc.style.webkitLineClamp = '3';
            button.textContent = 'Read more';
        }
    }

    // Members list modal functions
    function toggleMembersList() {
        const modal = document.getElementById('membersListModal');
        const content = document.getElementById('membersModalContent');
        
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.body.classList.add('overflow-hidden');
            
            // Load members when modal opens
            fetchMembers(1);
        } else {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            modal.classList.remove('opacity-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }
    }

    // Add member modal functions
    function openAddMemberModal() {
        const modal = document.getElementById('addMemberModal');
        const content = document.getElementById('addMemberModalContent');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeAddMemberModal() {
        const modal = document.getElementById('addMemberModal');
        const content = document.getElementById('addMemberModalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // QR Code modal functions
    function showQRCode(joinCode) {
        const modal = document.getElementById('qrCodeModal');
        const content = document.getElementById('qrModalContent');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
        
        // Set the join code in the input
        document.getElementById('joinCodeInput').value = joinCode;
        
        // Generate QR code
        generateQRCode(joinCode);
    }

    function closeQRCodeModal() {
        const modal = document.getElementById('qrCodeModal');
        const content = document.getElementById('qrModalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function generateQRCode(text) {
        const canvas = document.getElementById('qrCanvas');
        const qrCode = new QRious({
            element: canvas,
            value: text,
            size: 200,
            level: 'H'
        });
    }

    function copyJoinCode() {
        const input = document.getElementById('joinCodeInput');
        input.select();
        document.execCommand('copy');
        
        showToast('Join code copied to clipboard!', 'success');
    }

    function printQRCode() {
        const canvas = document.getElementById('qrCanvas');
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print QR Code</title>
                    <style>
                        body { text-align: center; padding: 20px; font-family: Arial, sans-serif; }
                        h1 { margin-bottom: 10px; }
                        p { margin-bottom: 20px; color: #666; }
                        img { margin: 20px auto; display: block; }
                        .code { font-family: monospace; font-size: 18px; margin-top: 20px; }
                    </style>
                </head>
                <body>
                    <h1>{{ $paguyuban->name }}</h1>
                    <p>Scan this QR code to join the community</p>
                    <img src="${canvas.toDataURL()}" width="200" height="200">
                    <div class="code">Join Code: ${document.getElementById('joinCodeInput').value}</div>
                    <script>
                        window.onload = function() {
                            setTimeout(function() {
                                window.print();
                                window.close();
                            }, 200);
                        };
                    <\/script>
                </body>
            </html>
        `);
        printWindow.document.close();
    }

    function downloadQRCode() {
        const canvas = document.getElementById('qrCanvas');
        const link = document.createElement('a');
        link.download = '{{ $paguyuban->name }}-QR-Code.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }

    // Modal functions
    function openModal() {
        const modal = document.getElementById('addPricingModal');
        const content = document.getElementById('modalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        const modal = document.getElementById('addPricingModal');
        const content = document.getElementById('modalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // Edit Modal functions
    function openEditModal(productId, currentPrice, productName, regularPrice) {
        const modal = document.getElementById('editPricingModal');
        const content = document.getElementById('editModalContent');

        document.getElementById('editProductName').textContent = productName;
        document.getElementById('editRegularPrice').value = formatRupiah(regularPrice);
        document.getElementById('editSpecialPrice').value = currentPrice;
        document.getElementById('editPricingForm').action = `/paguyuban/{{ $paguyuban->id }}/pricing/${productId}`;

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');

        // Calculate initial difference
        calculateEditPriceDifference();
    }

    function closeEditModal() {
        const modal = document.getElementById('editPricingModal');
        const content = document.getElementById('editModalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // Delete Modal functions
    function confirmDelete(productId) {
        const modal = document.getElementById('deleteConfirmationModal');
        const content = document.getElementById('deleteModalContent');

        document.getElementById('deleteForm').action = `/paguyuban/{{ $paguyuban->id }}/pricing/${productId}`;

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteConfirmationModal');
        const content = document.getElementById('deleteModalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // Adjust price in edit modal
    function adjustPrice(amount) {
        const specialPriceInput = document.getElementById('editSpecialPrice');
        const currentValue = parseFloat(specialPriceInput.value) || 0;
        const newValue = currentValue + amount;
        
        if (newValue >= 0) {
            specialPriceInput.value = newValue;
            calculateEditPriceDifference();
        }
    }

    // Set discount type in add modal
    function setDiscountType(type, value) {
        const productSelect = document.getElementById('product_id');
        const regularPrice = parseFloat(productSelect.options[productSelect.selectedIndex]?.getAttribute('data-price')) || 0;
        const specialPriceInput = document.getElementById('special_price');
        
        if (type === 'percentage' && regularPrice > 0) {
            const discountAmount = regularPrice * (value / 100);
            specialPriceInput.value = Math.round(regularPrice - discountAmount);
            calculatePriceDifference();
        }
    }

    // Update regular price when product is selected
    document.getElementById('product_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const regularPrice = selectedOption.getAttribute('data-price');
        document.getElementById('regular_price').value = formatRupiah(regularPrice);

        // Also update special price field with regular price as default
        document.getElementById('special_price').value = regularPrice;
        calculatePriceDifference();
    });

    // Calculate price difference for add modal
    document.getElementById('special_price').addEventListener('input', calculatePriceDifference);

    function calculatePriceDifference() {
        const productSelect = document.getElementById('product_id');
        const regularPrice = parseFloat(productSelect.options[productSelect.selectedIndex]?.getAttribute('data-price')) || 0;
        const specialPrice = parseFloat(document.getElementById('special_price').value) || 0;
        const differenceElement = document.getElementById('price_difference');

        if (regularPrice > 0 && specialPrice > 0) {
            const difference = specialPrice - regularPrice;
            const percentage = (difference / regularPrice * 100).toFixed(2);

            if (difference < 0) {
                differenceElement.innerHTML = `<span class="text-green-600 dark:text-green-400"><i class="fas fa-arrow-down mr-1"></i> ${Math.abs(percentage)}% lower than regular price (Rp ${formatRupiah(Math.abs(difference))} less)</span>`;
            } else if (difference > 0) {
                differenceElement.innerHTML = `<span class="text-red-600 dark:text-red-400"><i class="fas fa-arrow-up mr-1"></i> ${percentage}% higher than regular price (Rp ${formatRupiah(difference)} more)</span>`;
            } else {
                differenceElement.innerHTML = `<span class="text-gray-600 dark:text-gray-400">Same as regular price</span>`;
            }
        } else {
            differenceElement.textContent = '';
        }
    }

    // Calculate price difference for edit modal
    document.getElementById('editSpecialPrice').addEventListener('input', calculateEditPriceDifference);

    function calculateEditPriceDifference() {
        const regularPriceInput = document.getElementById('editRegularPrice');
        const regularPrice = parseFloat(regularPriceInput.value.replace(/[^0-9.-]+/g, "")) || 0;
        const specialPrice = parseFloat(document.getElementById('editSpecialPrice').value) || 0;
        const differenceElement = document.getElementById('editPriceDifference');

        if (regularPrice > 0 && specialPrice > 0) {
            const difference = specialPrice - regularPrice;
            const percentage = (difference / regularPrice * 100).toFixed(2);

            if (difference < 0) {
                differenceElement.innerHTML = `<span class="text-green-600 dark:text-green-400"><i class="fas fa-arrow-down mr-1"></i> ${Math.abs(percentage)}% lower than regular price (Rp ${formatRupiah(Math.abs(difference))} less)</span>`;
            } else if (difference > 0) {
                differenceElement.innerHTML = `<span class="text-red-600 dark:text-red-400"><i class="fas fa-arrow-up mr-1"></i> ${percentage}% higher than regular price (Rp ${formatRupiah(difference)} more)</span>`;
            } else {
                differenceElement.innerHTML = `<span class="text-gray-600 dark:text-gray-400">Same as regular price</span>`;
            }
        } else {
            differenceElement.textContent = '';
        }
    }

    // Format currency
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(amount);
    }

    // Filter dropdown toggle
    document.getElementById('filterDropdownButton').addEventListener('click', function() {
        const dropdown = document.getElementById('filterDropdown');
        dropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('filterDropdown');
        const button = document.getElementById('filterDropdownButton');
        
        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Apply filters
    document.getElementById('applyFilters').addEventListener('click', function() {
        const sortBy = document.getElementById('productSort').value;
        const discountedOnly = document.getElementById('filter_discounted').checked;
        const premiumOnly = document.getElementById('filter_premium').checked;
        
        // In a real app, you would apply these filters to the product list
        // For demo, we'll just show a toast
        showToast('Filters applied!', 'success');
        document.getElementById('filterDropdown').classList.add('hidden');
    });

    // Reset filters
    document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('productSort').value = 'name_asc';
        document.getElementById('filter_discounted').checked = false;
        document.getElementById('filter_premium').checked = false;
    });

    // Add member form submission
    document.getElementById('addMemberForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/paguyuban/{{ $paguyuban->id }}/add-member', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Member added successfully!', 'success');
                closeAddMemberModal();
                fetchMembers(1); // Refresh members list
            } else {
                showToast(data.message || 'Failed to add member', 'error');
            }
        })
        .catch(error => {
            showToast('An error occurred. Please try again.', 'error');
            console.error('Error:', error);
        });
    });

    // Fetch members with pagination
    let currentMembersPage = 1;
    
    function fetchMembers(page) {
        currentMembersPage = page;
        
        fetch(`/paguyuban/{{ $paguyuban->id }}/members?page=${page}`)
        .then(response => response.json())
        .then(data => {
            renderMembers(data.members.data);
            updateMembersPagination(data.members);
        })
        .catch(error => {
            console.error('Error fetching members:', error);
            showToast('Failed to load members', 'error');
        });
    }
    
    function renderMembers(members) {
        const container = document.getElementById('membersListContainer');
        container.innerHTML = '';
        
        if (members.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No members found</p>
                </div>
            `;
            return;
        }
        
        members.forEach(member => {
            const memberElement = document.createElement('div');
            memberElement.className = 'flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors';
            
            memberElement.innerHTML = `
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-300 mr-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">${member.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${member.email || 'No email'}</p>
                    </div>
                </div>
                <button onclick="confirmRemoveMember(${member.id}, '${member.name}')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2 rounded-lg hover:bg-red-50/50 dark:hover:bg-red-900/20">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            
            container.appendChild(memberElement);
        });
    }
    
    function updateMembersPagination(pagination) {
        document.getElementById('membersFrom').textContent = pagination.from;
        document.getElementById('membersTo').textContent = pagination.to;
        document.getElementById('membersTotal').textContent = pagination.total;
        
        const prevButton = document.getElementById('prevMembersPage');
        const nextButton = document.getElementById('nextMembersPage');
        
        prevButton.disabled = pagination.current_page === 1;
        nextButton.disabled = pagination.current_page === pagination.last_page;
        
        prevButton.onclick = () => pagination.prev_page_url && fetchMembers(pagination.current_page - 1);
        nextButton.onclick = () => pagination.next_page_url && fetchMembers(pagination.current_page + 1);
    }
    
    function confirmRemoveMember(memberId, memberName) {
        if (confirm(`Are you sure you want to remove ${memberName} from this community?`)) {
            fetch(`/paguyuban/{{ $paguyuban->id }}/remove-member/${memberId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Member removed successfully!', 'success');
                    fetchMembers(currentMembersPage); // Refresh current page
                } else {
                    showToast(data.message || 'Failed to remove member', 'error');
                }
            })
            .catch(error => {
                showToast('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        }
    }

    // Fetch activity logs with pagination
    function fetchActivityLogs(paguyubanId, page = 1) {
        fetch(`/paguyuban/${paguyubanId}/activity-log?page=${page}`)
            .then(response => response.json())
            .then(data => {
                renderActivityLogs(data.activities.data);
                setupActivityPagination(data.activities);
            })
            .catch(error => {
                console.error('Error fetching activity logs:', error);
                showToast('Failed to load activity logs', 'error');
            });
    }

    function renderActivityLogs(activities) {
        const container = document.getElementById('activityLogsContainer');
        container.innerHTML = '';

        if (activities.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No activity logs found</p>
                </div>
            `;
            return;
        }

        activities.forEach((activity, index) => {
            const activityItem = document.createElement('div');
            activityItem.className = `flex items-start animate-fade-in-up`;
            activityItem.style.animationDelay = `${index * 0.1}s`;

            // Determine icon and color based on activity type
            const { iconClass, bgClass, textClass } = getActivityStyles(activity.description);
            
            // Format properties if they exist
            let propertiesHtml = '';
            if (activity.properties && Object.keys(activity.properties).length > 0) {
                propertiesHtml = renderActivityProperties(activity.properties);
            }

            activityItem.innerHTML = `
                <div class="flex-shrink-0 h-10 w-10 rounded-full ${bgClass} ${textClass} flex items-center justify-center mr-3 transition-transform duration-300 hover:rotate-12">
                    <i class="${iconClass}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            ${activity.description}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 ml-2 whitespace-nowrap">
                            ${new Date(activity.created_at).toLocaleString()}
                        </p>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        ${activity.causer ? `By ${activity.causer.name}` : 'System generated'}
                    </p>
                    ${propertiesHtml}
                </div>
            `;

            container.appendChild(activityItem);
        });
    }

    function setupActivityPagination(paginationData) {
        const paginationContainer = document.getElementById('activityPagination');
        if (!paginationContainer) return;

        paginationContainer.innerHTML = `
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Showing <span class="font-medium">${paginationData.from}</span> to 
                <span class="font-medium">${paginationData.to}</span> of 
                <span class="font-medium">${paginationData.total}</span> results
            </div>
            <div class="flex space-x-2">
                ${paginationData.prev_page_url ? 
                    `<button onclick="fetchActivityLogs({{ $paguyuban->id }}, ${paginationData.current_page - 1})" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-0.5">
                        Previous
                    </button>` : ''
                }
                ${paginationData.next_page_url ? 
                    `<button onclick="fetchActivityLogs({{ $paguyuban->id }}, ${paginationData.current_page + 1})" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:translate-x-0.5">
                        Next
                    </button>` : ''
                }
            </div>
        `;
    }

    // Helper function to determine activity styles
    function getActivityStyles(description) {
        const lowerDesc = description.toLowerCase();
        
        if (lowerDesc.includes('added') || lowerDesc.includes('created')) {
            return {
                iconClass: 'fas fa-plus',
                bgClass: 'bg-green-100 dark:bg-green-900/50',
                textClass: 'text-green-600 dark:text-green-300'
            };
        } else if (lowerDesc.includes('updated') || lowerDesc.includes('changed')) {
            return {
                iconClass: 'fas fa-pencil-alt',
                bgClass: 'bg-blue-100 dark:bg-blue-900/50',
                textClass: 'text-blue-600 dark:text-blue-300'
            };
        } else if (lowerDesc.includes('deleted') || lowerDesc.includes('removed')) {
            return {
                iconClass: 'fas fa-trash-alt',
                bgClass: 'bg-red-100 dark:bg-red-900/50',
                textClass: 'text-red-600 dark:text-red-300'
            };
        } else {
            return {
                iconClass: 'fas fa-info-circle',
                bgClass: 'bg-indigo-100 dark:bg-indigo-900/50',
                textClass: 'text-indigo-600 dark:text-indigo-300'
            };
        }
    }

    // Function to render activity properties
    function renderActivityProperties(properties) {
        let html = '';
        const filteredProps = Object.entries(properties).filter(
            ([key]) => !['attributes', 'old'].includes(key)
        );

        if (filteredProps.length > 0) {
            html += `<div class="mt-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg p-3 text-xs">`;
            html += `<div class="grid grid-cols-2 gap-2">`;
            
            filteredProps.forEach(([key, value]) => {
                const formattedKey = key.replace(/_/g, ' ');
                const formattedValue = formatPropertyValue(key, value);
                
                html += `
                    <div class="break-words">
                        <span class="font-medium text-gray-500 dark:text-gray-400 capitalize">${formattedKey}:</span>
                        ${formattedValue}
                    </div>
                `;
            });
            
            html += `</div></div>`;
        }

        return html;
    }

    // Helper function to format property values
    function formatPropertyValue(key, value) {
        if (isNumeric(value) && ['regular_price', 'special_price', 'old_price', 'new_price', 'removed_price'].includes(key)) {
            return `<span class="text-gray-700 dark:text-gray-300">Rp ${formatRupiah(value)}</span>`;
        } else if (key === 'discount_percentage' || key === 'change_percentage') {
            const colorClass = value < 0 ? 'text-green-600 dark:text-green-400' : 
                              (value > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-gray-300');
            return `<span class="${colorClass}">${value}%</span>`;
        } else {
            return `<span class="text-gray-700 dark:text-gray-300">${value}</span>`;
        }
    }

    // Helper function to check if value is numeric
    function isNumeric(value) {
        return !isNaN(parseFloat(value)) && isFinite(value);
    }

    // Animate progress bars on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });

        // Animate counters
        const counters = document.querySelectorAll('.animate-count');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const step = target / (duration / 16); // 60fps

            let current = 0;
            const interval = setInterval(() => {
                current += step;
                if (current >= target) {
                    clearInterval(interval);
                    current = target;
                }
                counter.textContent = Math.floor(current);
            }, 16);
        });

        // Load activity logs
        fetchActivityLogs({{ $paguyuban->id }});

        // Add animation to elements when they come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endsection