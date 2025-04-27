@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6 max-w-7xl mx-auto">
    <!-- Enhanced Header Section with Glass Morphism Effect -->
    <div class="relative bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-6 mb-8 shadow-2xl backdrop-blur-md bg-opacity-90 border border-white/20 transform transition-all duration-500 hover:shadow-3xl hover:-translate-y-1 overflow-hidden">
        <!-- Floating particles decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-10 -left-10 w-24 h-24 rounded-full bg-white/10 backdrop-blur-sm animate-float-slow"></div>
            <div class="absolute -bottom-5 -right-5 w-20 h-20 rounded-full bg-white/15 backdrop-blur-sm animate-float-medium"></div>
            <div class="absolute top-1/4 right-1/4 w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm animate-float-fast"></div>
            <div class="absolute bottom-1/3 left-1/4 w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm animate-float"></div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="h-16 w-16 rounded-full border-4 border-white/80 shadow-lg overflow-hidden bg-white/20 backdrop-blur-sm flex items-center justify-center transition-transform duration-300 hover:rotate-6 hover:shadow-xl">
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
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-white/20 text-white backdrop-blur-sm' : 'bg-red-500/90 text-white' }} animate-pulse">
                            <span class="w-2 h-2 rounded-full mr-2 {{ $paguyuban->is_active ? 'bg-green-300' : 'bg-red-300' }}"></span>
                            {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="text-white/80 text-sm transition-all duration-300 hover:text-white flex items-center">
                            <i class="fas fa-users mr-1"></i>
                            {{ $paguyuban->members_count }} members
                        </span>
                        <span class="text-white/80 text-sm transition-all duration-300 hover:text-white flex items-center">
                            <i class="fas fa-tags mr-1"></i>
                            {{ $paguyuban->products->count() }} special products
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 w-full md:w-auto mt-3 sm:mt-0">
                <a href="{{ route('pos.community.edit', $paguyuban) }}" class="flex items-center justify-center px-5 py-2.5 bg-white/90 hover:bg-white text-indigo-600 rounded-xl shadow-sm transition-all duration-300 group hover:shadow-md transform hover:-translate-y-0.5 hover:scale-105">
                    <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Edit</span>
                </a>
                <a href="{{ route('pos.community.index') }}" class="flex items-center justify-center px-5 py-2.5 border border-white/50 rounded-xl bg-white/10 text-white hover:bg-white/20 transition-colors duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Back</span>
                </a>
                <button onclick="showQuickActionsMenu()" class="flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white shadow-md transition-all duration-300 transform hover:-translate-y-0.5 hover:scale-105 group">
                    <i class="fas fa-bolt mr-2 group-hover:animate-bounce"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Quick Actions</span>
                    <i class="fas fa-chevron-down ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions Dropdown (Hidden by default) -->
    <div id="quickActionsMenu" class="hidden absolute right-4 mt-2 w-56 rounded-xl shadow-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 z-50 transform transition-all duration-300 origin-top-right scale-95 opacity-0 divide-y divide-gray-100 dark:divide-gray-700">
        <div class="py-1">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 group">
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/20 flex items-center justify-center mr-3 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/30 transition-colors">
                    <i class="fas fa-user-plus text-blue-500 dark:text-blue-300 text-sm"></i>
                </div>
                <div>
                    <p class="font-medium">Add Members</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Bulk import members</p>
                </div>
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 group">
                <div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center mr-3 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/30 transition-colors">
                    <i class="fas fa-envelope text-purple-500 dark:text-purple-300 text-sm"></i>
                </div>
                <div>
                    <p class="font-medium">Send Notification</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Email/SMS members</p>
                </div>
            </a>
        </div>
        <div class="py-1">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 group">
                <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/20 flex items-center justify-center mr-3 group-hover:bg-green-200 dark:group-hover:bg-green-800/30 transition-colors">
                    <i class="fas fa-chart-pie text-green-500 dark:text-green-300 text-sm"></i>
                </div>
                <div>
                    <p class="font-medium">Generate Report</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Export community data</p>
                </div>
            </a>
        </div>
        <div class="py-1">
            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 group">
                <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/20 flex items-center justify-center mr-3 group-hover:bg-orange-200 dark:group-hover:bg-orange-800/30 transition-colors">
                    <i class="fas fa-cog text-orange-500 dark:text-orange-300 text-sm"></i>
                </div>
                <div>
                    <p class="font-medium">Community Settings</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Configure preferences</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Details and Performance -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Enhanced Details Card with Interactive Elements -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/20 dark:to-gray-800/30">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-info-circle text-indigo-500 mr-2 animate-bounce" style="animation-duration: 2s"></i>
                        Community Details
                        <button onclick="toggleDetailsEdit()" class="ml-auto text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 px-2 py-1 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors flex items-center">
                            <i class="fas fa-pencil-alt mr-1"></i> Edit
                        </button>
                    </h3>
                </div>
                <div class="p-6">
                    <div id="detailsView" class="space-y-5">
                        <!-- View Mode -->
                        <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Description</p>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                {{ $paguyuban->description ?? 'No description provided' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' }} {{ $paguyuban->is_active ? 'animate-pulse' : '' }}" style="animation-duration: 3s">
                                        {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Members</p>
                                <p class="text-gray-700 dark:text-gray-300 font-medium animate-count" data-count="{{ $paguyuban->members_count }}">
                                    0
                                </p>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4 transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Created</p>
                            <div class="flex items-center text-gray-700 dark:text-gray-300 text-sm">
                                <i class="far fa-calendar-alt mr-2 text-gray-400 transition-transform duration-300 hover:scale-110"></i>
                                {{ $paguyuban->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Last Updated</p>
                            <div class="flex items-center text-gray-700 dark:text-gray-300 text-sm">
                                <i class="far fa-clock mr-2 text-gray-400 transition-transform duration-300 hover:scale-110"></i>
                                {{ $paguyuban->updated_at->format('M d, Y') }}
                                <span class="text-gray-400 ml-1">({{ $paguyuban->updated_at->diffForHumans() }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Mode (Hidden by default) -->
                    <div id="detailsEdit" class="hidden space-y-4">
                        <form action="{{ route('pos.community.update', $paguyuban) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="description" class="block text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Description</label>
                                <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300">{{ $paguyuban->description }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div class="relative">
                                        <select name="is_active" class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                                            <option value="1" {{ $paguyuban->is_active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$paguyuban->is_active ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Logo</label>
                                    <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" onclick="toggleDetailsEdit()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 flex items-center">
                                    <i class="fas fa-save mr-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Performance Card with Interactive Charts -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/20 dark:to-gray-800/30">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-chart-line text-indigo-500 mr-2 animate-pulse" style="animation-duration: 1.5s"></i>
                        Performance Analytics
                        <div class="ml-auto flex items-center space-x-2">
                            <select id="timeRange" class="text-xs bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                <option value="7">Last 7 days</option>
                                <option value="30" selected>Last 30 days</option>
                                <option value="90">Last 90 days</option>
                            </select>
                        </div>
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Mini Line Chart -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Sales Trend</span>
                                <span class="text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 px-2 py-0.5 rounded-lg">+12.5%</span>
                            </div>
                            <div class="h-40">
                                <canvas id="salesTrendChart"></canvas>
                            </div>
                        </div>

                        <!-- Bar Chart -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Top Products</span>
                                <span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-300 px-2 py-0.5 rounded-lg">By Revenue</span>
                            </div>
                            <div class="h-40">
                                <canvas id="topProductsChart"></canvas>
                            </div>
                        </div>

                        <!-- Progress Bars -->
                        <div class="space-y-4">
                            <div class="animate-progress">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Sales</span>
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">Rp 12.5M</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                    <div class="bg-indigo-600 h-2 rounded-full progress-bar" style="width: 0%" data-width="75"></div>
                                </div>
                            </div>

                            <div class="animate-progress" style="animation-delay: 0.2s">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Growth</span>
                                    <span class="text-sm font-semibold text-green-600 dark:text-green-400">+24%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                    <div class="bg-green-500 h-2 rounded-full progress-bar" style="width: 0%" data-width="45"></div>
                                </div>
                            </div>

                            <div class="animate-progress" style="animation-delay: 0.4s">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Product Discounts</span>
                                    <span class="text-sm font-semibold text-purple-600 dark:text-purple-400">32 Items</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                    <div class="bg-purple-500 h-2 rounded-full progress-bar" style="width: 0%" data-width="60"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member Engagement Card -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/20 dark:to-gray-800/30">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-users text-indigo-500 mr-2 animate-pulse" style="animation-duration: 2s"></i>
                        Member Engagement
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 mr-3">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Active Shoppers</p>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">1,248</p>
                                </div>
                            </div>
                            <span class="text-xs bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-300 px-2 py-1 rounded-lg">+8.2%</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-300 mr-3">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Monthly Visits</p>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">3,456</p>
                                </div>
                            </div>
                            <span class="text-xs bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-300 px-2 py-1 rounded-lg">-2.1%</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-300 mr-3">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Feedback Received</p>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">189</p>
                                </div>
                            </div>
                            <span class="text-xs bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 px-2 py-1 rounded-lg">+15.7%</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button onclick="showMemberEngagementModal()" class="w-full py-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800/30 transition-colors flex items-center justify-center group">
                            <i class="fas fa-chart-bar mr-2 group-hover:animate-bounce"></i> View Detailed Analytics
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Products and Activity -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Products Card with Enhanced Features -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/20 dark:to-gray-800/30">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-tags text-indigo-500 mr-2 animate-bounce" style="animation-duration: 2.5s"></i>
                            Special Pricing
                            <span class="ml-2 text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 px-2 py-0.5 rounded-full">
                                {{ $paguyuban->products->count() }} products
                            </span>
                        </h3>
                        <div class="flex space-x-3">
                            <button onclick="openModal()" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5 animate-pulse-slow group">
                                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i> Add Product
                            </button>
                            <div class="relative">
                                <button onclick="toggleFilterDropdown()" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-xl shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5 group">
                                    <i class="fas fa-filter mr-2"></i> Filter
                                    <i class="fas fa-chevron-down ml-2 text-xs transition-transform group-hover:rotate-180"></i>
                                </button>
                                <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 z-10 divide-y divide-gray-100 dark:divide-gray-700">
                                    <div class="p-2">
                                        <div class="mb-2">
                                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Category</label>
                                            <select class="w-full text-xs border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                                <option>All Categories</option>
                                                <option>Food & Beverage</option>
                                                <option>Electronics</option>
                                                <option>Household</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Discount Range</label>
                                            <select class="w-full text-xs border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                                <option>Any Discount</option>
                                                <option>0-10%</option>
                                                <option>10-20%</option>
                                                <option>20%+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <button class="w-full px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700 flex items-center justify-center">
                                            <i class="fas fa-check-circle mr-2"></i> Apply Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button onclick="openProductManagement()" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5 animate-pulse-slow group">
                                <i class="fas fa-table mr-2 group-hover:scale-110 transition-transform"></i> Manage Pricing
                            </button>
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
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 border-gray-200 dark:border-gray-600 mr-3 transition-transform duration-300 hover:scale-110">
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->pivot->price < $product->price ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : ($product->pivot->price > $product->price ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }} transition-all duration-300 hover:scale-105">
                                        @if($product->pivot->price < $product->price)
                                            <i class="fas fa-arrow-down mr-1 text-xs"></i>
                                            {{ number_format(100 - ($product->pivot->price / $product->price * 100), 0 )}}%
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
                                        <button onclick="openEditModal({{ $product->id }}, {{ $product->pivot->price }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors p-2 rounded-lg hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transform hover:scale-110" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button onclick="confirmDelete({{ $product->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2 rounded-lg hover:bg-red-50/50 dark:hover:bg-red-900/20 transform hover:scale-110" title="Remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button onclick="showProductDetails({{ $product->id }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors p-2 rounded-lg hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transform hover:scale-110" title="Details">
                                            <i class="fas fa-eye"></i>
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
                        <button class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-0.5">
                            Previous
                        </button>
                        <button class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:translate-x-0.5">
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
                    <button onclick="openModal()" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5 animate-pulse-slow group">
                        <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i> Add Product Pricing
                    </button>
                </div>
                @endif
            </div>

            <!-- Recent Activity with Timeline View -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/20 dark:to-gray-800/30">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-history text-indigo-500 mr-2 animate-spin" style="animation-duration: 10s"></i>
                            Recent Activity Timeline
                        </h3>
                        <button onclick="fetchActivityLogs({{ $paguyuban->id }})" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-all duration-300 transform hover:scale-105 flex items-center">
                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <!-- Timeline -->
                        <div class="border-l-2 border-indigo-200 dark:border-indigo-800 absolute h-full left-5 top-0"></div>

                        <div class="space-y-6" id="activityLogsContainer">
                            <!-- Activity items will be inserted here by JavaScript -->
                            <div class="text-center py-8">
                                <i class="fas fa-spinner fa-spin text-2xl text-indigo-500"></i>
                                <p class="text-gray-500 mt-2">Loading activity logs...</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4" id="activityPagination">
                        <!-- Pagination will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Product Performance Highlights -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/20 dark:to-gray-800/30">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2 animate-pulse" style="animation-duration: 1.5s"></i>
                        Product Performance Highlights
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Top Performing Product -->
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-xl border border-green-100 dark:border-green-800 transform transition-all duration-300 hover:scale-[1.02] group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-green-600 dark:text-green-300 mb-1">Top Performer</p>
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Organic Rice 5kg</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Highest sales volume</p>
                                </div>
                                <div class="bg-green-100 dark:bg-green-800/50 text-green-600 dark:text-green-300 p-3 rounded-lg group-hover:animate-bounce">
                                    <i class="fas fa-trophy text-lg"></i>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Sales</span>
                                <span class="text-sm font-semibold text-green-600 dark:text-green-300">1,248 units</span>
                            </div>
                        </div>

                        <!-- Most Discounted Product -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800 transform transition-all duration-300 hover:scale-[1.02] group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-blue-600 dark:text-blue-300 mb-1">Best Discount</p>
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Premium Coffee 250g</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">25% off regular price</p>
                                </div>
                                <div class="bg-blue-100 dark:bg-blue-800/50 text-blue-600 dark:text-blue-300 p-3 rounded-lg group-hover:animate-bounce">
                                    <i class="fas fa-percentage text-lg"></i>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Savings</span>
                                <span class="text-sm font-semibold text-blue-600 dark:text-blue-300">Rp 25,000/unit</span>
                            </div>
                        </div>

                        <!-- Newest Addition -->
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-xl border border-purple-100 dark:border-purple-800 transform transition-all duration-300 hover:scale-[1.02] group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-purple-600 dark:text-purple-300 mb-1">Newest Addition</p>
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Honey 500ml</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Added 2 days ago</p>
                                </div>
                                <div class="bg-purple-100 dark:bg-purple-800/50 text-purple-600 dark:text-purple-300 p-3 rounded-lg group-hover:animate-bounce">
                                    <i class="fas fa-bolt text-lg"></i>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Sales</span>
                                <span class="text-sm font-semibold text-purple-600 dark:text-purple-300">87 units</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Pricing Modal with Enhanced UI -->
<div id="addPricingModal" class="hidden fixed inset-0 bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-2xl rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add Special Pricing
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Set exclusive pricing for community members</p>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal content -->
        <form id="addPricingForm" action="{{ route('pos.community.add-pricing', $paguyuban) }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="animate-fade-in-up" style="animation-delay: 0.1s">
                    <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Product</label>
                    <div class="relative">
                        <select id="product_id" name="product_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-300 hover:shadow-md pr-8">
                            <option value="">Search or select a product</option>
                            @foreach($availableProducts as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="animate-fade-in-up" style="animation-delay: 0.2s">
                        <label for="regular_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Regular Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="text" id="regular_price" readonly class="bg-gray-100 pl-10 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-300 hover:shadow-md">
                        </div>
                    </div>
                    <div class="animate-fade-in-up" style="animation-delay: 0.3s">
                        <label for="special_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Special Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="number" id="special_price" name="price" required class="bg-gray-50 pl-10 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-300 hover:shadow-md">
                        </div>
                    </div>
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.4s">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-blue-600 dark:text-blue-300 mb-1">Price Difference</p>
                                <p id="price_difference" class="text-sm font-medium animate-pulse" style="animation-duration: 1.5s">Select a product to see savings</p>
                            </div>
                            <div class="bg-blue-100 dark:bg-blue-800/50 text-blue-600 dark:text-blue-300 p-2 rounded-lg">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.5s">
                    <label for="effective_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Effective Date</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="far fa-calendar text-gray-400"></i>
                        </div>
                        <input type="date" id="effective_date" name="effective_date" class="bg-gray-50 pl-10 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700 space-x-3 animate-fade-in-up" style="animation-delay: 0.6s">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-1">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300 transform hover:translate-x-1 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Save Pricing
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Pricing Modal -->
<div id="editPricingModal" class="hidden fixed inset-0 bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-2xl rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="editModalContent">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Special Pricing
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update pricing for community members</p>
            </div>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal content -->
        <form id="editPricingForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
                    <div class="bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5">
                        <p id="editProductName" class="font-medium"></p>
                        <p id="editProductSku" class="text-xs text-gray-500 dark:text-gray-400 mt-1"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="editRegularPrice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Regular Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="text" id="editRegularPrice" readonly class="bg-gray-100 pl-10 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label for="editSpecialPrice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Special Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="number" id="editSpecialPrice" name="price" required class="bg-gray-50 pl-10 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-100 dark:border-purple-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-purple-600 dark:text-purple-300 mb-1">Price Impact</p>
                                <p id="editPriceDifference" class="text-sm font-medium animate-pulse" style="animation-duration: 1.5s"></p>
                            </div>
                            <div class="bg-purple-100 dark:bg-purple-800/50 text-purple-600 dark:text-purple-300 p-2 rounded-lg">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="editEffectiveDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Effective Until</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="far fa-calendar text-gray-400"></i>
                        </div>
                        <input type="date" id="editEffectiveDate" name="effective_until" class="bg-gray-50 pl-10 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700 space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 flex items-center">
                    <i class="fas fa-save mr-2"></i> Update Pricing
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal with Enhanced UI -->
<div id="deleteConfirmationModal" class="hidden fixed inset-0 bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-2xl rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-300 mb-4 animate-pulse">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Confirm Removal</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Are you sure you want to remove this special pricing? This action cannot be undone and will affect all community members.</p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 transition-all duration-300 hover:-translate-x-1">
                    <i class="fas fa-times mr-2"></i> Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-300 hover:translate-x-1">
                        <i class="fas fa-trash-alt mr-2"></i> Yes, Remove
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Product Details Modal -->
<div id="productDetailsModal" class="hidden fixed inset-0 bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-2xl rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="detailsModalContent">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-box-open text-indigo-500 mr-2"></i>
                    Product Details
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Detailed information about this product</p>
            </div>
            <button onclick="closeProductDetails()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/3 flex justify-center">
                    <div class="h-40 w-40 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 border-gray-200 dark:border-gray-600">
                        <img id="productDetailImage" src="" alt="Product Image" class="h-full w-full object-cover">
                        <i id="productDetailIcon" class="fas fa-box text-3xl text-gray-400 dark:text-gray-500 hidden"></i>
                    </div>
                </div>
                <div class="w-full md:w-2/3">
                    <h2 id="productDetailName" class="text-xl font-bold text-gray-900 dark:text-white mb-2"></h2>
                    <p id="productDetailSku" class="text-sm text-gray-500 dark:text-gray-400 mb-3"></p>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Category</p>
                            <p id="productDetailCategory" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Stock</p>
                            <p id="productDetailStock" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                        </div>
                    </div>
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-3 rounded-lg">
                        <p class="text-xs font-medium text-indigo-600 dark:text-indigo-300 mb-1">Special Pricing</p>
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Regular Price</p>
                                <p id="productDetailRegularPrice" class="text-lg font-bold text-gray-700 dark:text-gray-300"></p>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 mx-2 mb-2"></i>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Special Price</p>
                                <p id="productDetailSpecialPrice" class="text-lg font-bold text-indigo-600 dark:text-indigo-400"></p>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs text-gray-500 dark:text-gray-400">You Save</p>
                                <p id="productDetailSavings" class="text-lg font-bold text-green-600 dark:text-green-400"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Sales Performance</p>
                    <div class="h-32">
                        <canvas id="productSalesChart"></canvas>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Member Engagement</p>
                    <div class="h-32">
                        <canvas id="productEngagementChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <button onclick="closeProductDetails()" class="w-full py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Close Details
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Member Engagement Analytics Modal -->
<div id="memberEngagementModal" class="hidden fixed inset-0 bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-4 mx-auto p-5 border w-full max-w-4xl shadow-2xl rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="engagementModalContent">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-chart-bar text-indigo-500 mr-2"></i>
                    Member Engagement Analytics
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Detailed insights about community member activity</p>
            </div>
            <button onclick="closeMemberEngagementModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-700 p-4 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-3">Active Members Over Time</p>
                    <div class="h-64">
                        <canvas id="memberActivityChart"></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-700 p-4 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-3">Purchase Frequency</p>
                    <div class="h-64">
                        <canvas id="purchaseFrequencyChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 p-4 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-3">Top Members by Engagement</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Visits</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Purchases</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Last Active</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-300 mr-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">John Doe</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Gold Member</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">24</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">18</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">2 hours ago</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-300 mr-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Jane Smith</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Silver Member</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">19</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">12</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">1 day ago</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-300 mr-2">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">Robert Johnson</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Bronze Member</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">15</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">8</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">3 days ago</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                <button onclick="closeMemberEngagementModal()" class="w-full py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Close Analytics
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Product Management Modal -->
<div id="productManagementModal" class="hidden fixed inset-0 bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-4 mx-auto p-5 border w-full max-w-6xl shadow-2xl rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="spreadsheetModalContent">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-table text-indigo-500 mr-2 animate-pulse"></i>
                Product Pricing Management
                <span class="ml-2 text-xs bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 px-2 py-0.5 rounded-full">
                    Bulk Edit Mode
                </span>
            </h3>
            <div class="flex space-x-2">
                <button onclick="saveSpreadsheet()" class="flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md group">
                    <i class="fas fa-save mr-2 group-hover:animate-bounce"></i> Save Changes
                </button>
                <button onclick="closeSpreadsheetModal()" class="flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:scale-105 group">
                    <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform"></i> Close
                </button>
            </div>
        </div>

        <!-- Modal content -->
        <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800 transform transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-300 mr-3">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-blue-800 dark:text-blue-200">Instructions</h4>
                            <p class="text-sm text-blue-600 dark:text-blue-300">Edit prices directly in the table. Use right-click for more options.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-100 dark:border-purple-800 transform transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-800 text-purple-600 dark:text-purple-300 mr-3">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-purple-800 dark:text-purple-200">Quick Actions</h4>
                            <div class="flex flex-wrap gap-2 mt-1">
                                <button onclick="applyPercentageChange(-5)" class="text-xs px-2 py-1 bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-600 text-purple-800 dark:text-purple-200 rounded transition-all transform hover:scale-105">
                                    -5%
                                </button>
                                <button onclick="applyPercentageChange(-10)" class="text-xs px-2 py-1 bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-600 text-purple-800 dark:text-purple-200 rounded transition-all transform hover:scale-105">
                                    -10%
                                </button>
                                <button onclick="applyPercentageChange(5)" class="text-xs px-2 py-1 bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-600 text-purple-800 dark:text-purple-200 rounded transition-all transform hover:scale-105">
                                    +5%
                                </button>
                                <button onclick="applyPercentageChange(10)" class="text-xs px-2 py-1 bg-purple-100 dark:bg-purple-700 hover:bg-purple-200 dark:hover:bg-purple-600 text-purple-800 dark:text-purple-200 rounded transition-all transform hover:scale-105">
                                    +10%
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-100 dark:border-green-800 transform transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-300 mr-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-green-800 dark:text-green-200">Statistics</h4>
                            <p class="text-sm text-green-600 dark:text-green-300" id="statsInfo">
                                Loading product stats...
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div id="spreadsheet" class="w-full"></div>
            </div>

            <div class="mt-4 flex justify-between items-center">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span id="rowCount">0</span> products loaded |
                    <span id="modifiedCount">0</span> modifications
                </div>
                <div class="flex space-x-2">
                    <button onclick="addNewRow()" class="flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg transition-all transform hover:scale-105 shadow-sm group">
                        <i class="fas fa-plus mr-1 group-hover:rotate-90 transition-transform"></i> Add Row
                    </button>
                    <button onclick="showImportModal()" class="flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition-all transform hover:scale-105 shadow-sm group">
                        <i class="fas fa-file-import mr-1 group-hover:animate-bounce"></i> Import
                    </button>
                    <button onclick="exportToExcel()" class="flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-sm rounded-lg transition-all transform hover:scale-105 shadow-sm group">
                        <i class="fas fa-file-export mr-1 group-hover:animate-pulse"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="hidden fixed inset-0 bg-gray-600/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-2xl rounded-2xl bg-white dark:bg-gray-800">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                <i class="fas fa-file-import text-blue-500 mr-2"></i>
                Import Product Data
            </h3>
            <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="py-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Select Excel/CSV File
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl hover:border-indigo-500 transition-colors duration-300">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                            <label for="file-upload" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none">
                                <span>Upload a file</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Excel, CSV up to 5MB
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex items-center mb-4">
                <input id="replaceData" name="replaceData" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="replaceData" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Replace existing data
                </label>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800 rounded-lg p-3 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-300"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Import Notice</h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>Ensure your file includes all required columns: Product ID, Name, Regular Price, and Special Price.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
            <button onclick="closeImportModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 mr-2">
                Cancel
            </button>
            <button onclick="processImport()" class="px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 flex items-center group">
                <i class="fas fa-upload mr-2 group-hover:animate-bounce"></i> Import Data
            </button>
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

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes floatFast {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-15px);
        }
    }

    @keyframes floatMedium {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .animate-pulse-slow {
        animation: pulseSlow 2s infinite;
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animate-float-fast {
        animation: floatFast 4s ease-in-out infinite;
    }

    .animate-float-medium {
        animation: floatMedium 5s ease-in-out infinite;
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
        display: flex;
        align-items: center;
        padding: 1rem;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        max-width: 24rem;
        margin-left: auto;
        opacity: 0;
        transform: translateX(100%);
        animation: slideInRight 0.3s ease-out forwards;
    }

    .toast-success {
        border-left: 4px solid #10B981;
    }

    .toast-error {
        border-left: 4px solid #EF4444;
    }

    .toast-info {
        border-left: 4px solid #3B82F6;
    }

    .toast-warning {
        border-left: 4px solid #F59E0B;
    }

    .toast-icon {
        margin-right: 0.75rem;
        font-size: 1.25rem;
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
        font-size: 0.875rem;
        color: #374151;
    }

    .toast-close {
        margin-left: 0.75rem;
        color: #9CA3AF;
        background: none;
        border: none;
        cursor: pointer;
    }

    .shadow-3xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .hover\:shadow-3xl:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Enhanced glass morphism effect */
    .backdrop-blur-md {
        backdrop-filter: blur(12px);
    }
    
    .bg-opacity-90 {
        background-opacity: 0.9;
    }
    
    .border-white\/20 {
        border-color: rgba(255, 255, 255, 0.2);
    }
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jexcel@4.5.0/dist/jexcel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsuites@4.5.0/dist/jsuites.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jexcel@4.5.0/dist/jexcel.min.css">

<script>
    // Initialize variables
    let spreadsheet = null;
    let productsData = [];
    let modifiedRows = new Set();
    let salesTrendChart = null;
    let topProductsChart = null;
    let memberActivityChart = null;
    let purchaseFrequencyChart = null;
    let productSalesChart = null;
    let productEngagementChart = null;

    // Quick Actions Menu
    function showQuickActionsMenu() {
        const menu = document.getElementById('quickActionsMenu');
        const button = document.querySelector('[onclick="showQuickActionsMenu()"]');

        if (menu.classList.contains('hidden')) {
            // Position the dropdown below the button
            const rect = button.getBoundingClientRect();
            menu.style.top = `${rect.bottom + window.scrollY + 4}px`;
            menu.style.right = `${window.innerWidth - rect.right}px`;

            menu.classList.remove('hidden');
            setTimeout(() => {
                menu.classList.remove('opacity-0');
                menu.classList.remove('scale-95');
                menu.classList.add('opacity-100');
                menu.classList.add('scale-100');
            }, 10);
        } else {
            menu.classList.remove('opacity-100');
            menu.classList.remove('scale-100');
            menu.classList.add('opacity-0');
            menu.classList.add('scale-95');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        }
    }

    // Close quick actions menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('quickActionsMenu');
        const button = document.querySelector('[onclick="showQuickActionsMenu()"]');

        if (!menu.contains(event.target) && !button.contains(event.target)) {
            menu.classList.remove('opacity-100');
            menu.classList.remove('scale-100');
            menu.classList.add('opacity-0');
            menu.classList.add('scale-95');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        }
    });

    // Toggle filter dropdown
    function toggleFilterDropdown() {
        const dropdown = document.getElementById('filterDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Toggle details edit mode
    function toggleDetailsEdit() {
        document.getElementById('detailsView').classList.toggle('hidden');
        document.getElementById('detailsEdit').classList.toggle('hidden');
    }

    // Initialize charts when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });

        // Initialize sales trend chart
        const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
        salesTrendChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [12000000, 19000000, 15000000, 18000000, 21000000, 19000000, 23000000],
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toLocaleString('id-ID') + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Initialize top products chart
        const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
        topProductsChart = new Chart(topProductsCtx, {
            type: 'bar',
            data: {
                labels: ['Rice 5kg', 'Coffee 250g', 'Sugar 1kg', 'Oil 1L', 'Tea 100g'],
                datasets: [{
                    label: 'Revenue',
                    data: [5000000, 3500000, 2800000, 2200000, 1800000],
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(79, 70, 229, 0.7)',
                        'rgba(67, 56, 202, 0.7)',
                        'rgba(55, 48, 163, 0.7)',
                        'rgba(49, 46, 129, 0.7)'
                    ],
                    borderColor: [
                        'rgba(99, 102, 241, 1)',
                        'rgba(79, 70, 229, 1)',
                        'rgba(67, 56, 202, 1)',
                        'rgba(55, 48, 163, 1)',
                        'rgba(49, 46, 129, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toLocaleString('id-ID') + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Animate counter
        const counter = document.querySelector('.animate-count');
        if (counter) {
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
        }

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

        // Time range selector
        document.getElementById('timeRange').addEventListener('change', function() {
            updateCharts(this.value);
        });

        // Fetch initial activity logs
        const paguyubanId = {{ $paguyuban->id }};
        fetchActivityLogs(paguyubanId);
    });

    // Update charts based on time range
    function updateCharts(days) {
        // In a real app, you would fetch new data based on the time range
        // For demo purposes, we'll just adjust the existing data

        let salesData, labels;

        if (days === '7') {
            labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            salesData = [3200000, 2800000, 4000000, 3500000, 4200000, 3800000, 4500000];
        } else if (days === '30') {
            labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            salesData = [12000000, 15000000, 14000000, 18000000];
        } else if (days === '90') {
            labels = ['Month 1', 'Month 2', 'Month 3'];
            salesData = [45000000, 52000000, 48000000];
        }

        // Update sales trend chart
        salesTrendChart.data.labels = labels;
        salesTrendChart.data.datasets[0].data = salesData;
        salesTrendChart.update();

        // Show loading state
        showToast(`Loading ${days} days of data...`, 'info', 1500);

        // Simulate loading new data
        setTimeout(() => {
            showToast('Charts updated successfully', 'success');
        }, 1500);
    }

    // Product Management Spreadsheet
    function openProductManagement() {
        const modal = document.getElementById('productManagementModal');
        const content = document.getElementById('spreadsheetModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');

        loadProductData();
    }

    function closeSpreadsheetModal() {
        const modal = document.getElementById('productManagementModal');
        const content = document.getElementById('spreadsheetModalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function loadProductData() {
        // Show loading state
        document.getElementById('statsInfo').textContent = "Loading product data...";

        // In a real app, you would fetch this from your API
        fetch(`/api/paguyuban/{{ $paguyuban->id }}/products`)
            .then(response => response.json())
            .then(data => {
                productsData = data;
                initializeSpreadsheet();
                updateStats();
            })
            .catch(error => {
                console.error('Error loading product data:', error);
                showToast('Failed to load product data', 'error');
                // Fallback to empty data
                productsData = [];
                initializeSpreadsheet();
            });
    }

    function initializeSpreadsheet() {
        const container = document.getElementById('spreadsheet');

        if (spreadsheet) {
            spreadsheet.destroy();
        }

        // Prepare data for spreadsheet
        const spreadsheetData = productsData.map(product => [
            product.id,
            product.name,
            product.sku,
            product.category,
            product.regular_price,
            product.special_price || product.regular_price,
            calculateDiscountPercentage(product.regular_price, product.special_price || product.regular_price),
            product.stock,
            product.status
        ]);

        // If no data, create empty row
        if (spreadsheetData.length === 0) {
            spreadsheetData.push(['', '', '', '', '', '', '', '', 'Active']);
        }

        spreadsheet = jexcel(container, {
            data: spreadsheetData,
            columns: [
                {
                    type: 'hidden',
                    title: 'ID',
                    width: 50
                },
                {
                    type: 'text',
                    title: 'Product Name',
                    width: 200,
                    wordWrap: true
                },
                {
                    type: 'text',
                    title: 'SKU',
                    width: 120
                },
                {
                    type: 'dropdown',
                    title: 'Category',
                    width: 150,
                    source: ['Food', 'Beverage', 'Electronics', 'Clothing', 'Other'],
                    autocomplete: true
                },
                {
                    type: 'numeric',
                    title: 'Regular Price',
                    width: 120,
                    mask: 'Rp #,##,###',
                    decimal: ',',
                    thousand: '.',
                    precision: 0
                },
                {
                    type: 'numeric',
                    title: 'Special Price',
                    width: 120,
                    mask: 'Rp #,##,###',
                    decimal: ',',
                    thousand: '.',
                    precision: 0
                },
                {
                    type: 'numeric',
                    title: 'Discount %',
                    width: 100,
                    mask: '#%',
                    decimal: '.',
                    precision: 2,
                    readOnly: true
                },
                {
                    type: 'numeric',
                    title: 'Stock',
                    width: 80
                },
                {
                    type: 'dropdown',
                    title: 'Status',
                    width: 100,
                    source: ['Active', 'Inactive']
                }
            ],
            allowExport: true,
            allowInsertRow: true,
            allowDeleteRow: true,
            allowInsertColumn: false,
            allowDeleteColumn: false,
            allowRenameColumn: false,
            allowComments: false,
            tableOverflow: true,
            tableHeight: '500px',
            onchange: function(instance, cell, x, y, value) {
                // Track modified rows
                modifiedRows.add(y);
                document.getElementById('modifiedCount').textContent = modifiedRows.size;

                // Auto-calculate discount when prices change
                if (x === 4 || x === 5) { // Regular Price or Special Price columns
                    const regularPrice = parseFloat(instance.getData()[y][4]) || 0;
                    const specialPrice = parseFloat(instance.getData()[y][5]) || 0;
                    const discount = calculateDiscountPercentage(regularPrice, specialPrice);
                    instance.setValueFromCoords(6, y, discount);
                }
            },
            contextMenu: function(obj, x, y, e) {
                const items = {
                    insertRowAbove: {
                        name: '<i class="fas fa-arrow-up mr-2"></i>Insert row above',
                        function: function() {
                            obj.insertRow(1, undefined, y);
                        }
                    },
                    insertRowBelow: {
                        name: '<i class="fas fa-arrow-down mr-2"></i>Insert row below',
                        function: function() {
                            obj.insertRow(1, undefined, y + 1);
                        }
                    },
                    deleteRow: {
                        name: '<i class="fas fa-trash mr-2"></i>Delete row',
                        function: function() {
                            if (confirm('Are you sure you want to delete this row?')) {
                                obj.deleteRow(y);
                            }
                        }
                    },
                    sep1: '---------',
                    apply5Discount: {
                        name: '<i class="fas fa-percentage mr-2"></i>Apply 5% discount',
                        function: function() {
                            applyDiscountToRow(obj, y, 5);
                        }
                    },
                    apply10Discount: {
                        name: '<i class="fas fa-percentage mr-2"></i>Apply 10% discount',
                        function: function() {
                            applyDiscountToRow(obj, y, 10);
                        }
                    },
                    apply20Discount: {
                        name: '<i class="fas fa-percentage mr-2"></i>Apply 20% discount',
                        function: function() {
                            applyDiscountToRow(obj, y, 20);
                        }
                    }
                };
                return items;
            }
        });

        // Update row count
        document.getElementById('rowCount').textContent = spreadsheetData.length;
        document.getElementById('modifiedCount').textContent = '0';
        modifiedRows = new Set();
    }

    function calculateDiscountPercentage(regularPrice, specialPrice) {
        if (!regularPrice || !specialPrice || regularPrice <= 0) return 0;
        return ((regularPrice - specialPrice) / regularPrice * 100).toFixed(2);
    }

    function applyDiscountToRow(spreadsheet, row, discountPercent) {
        const regularPrice = parseFloat(spreadsheet.getValueFromCoords(4, row)) || 0;
        if (regularPrice > 0) {
            const discountAmount = regularPrice * (discountPercent / 100);
            const specialPrice = regularPrice - discountAmount;
            spreadsheet.setValueFromCoords(5, row, specialPrice.toFixed(0));

            // Track this modification
            modifiedRows.add(row);
            document.getElementById('modifiedCount').textContent = modifiedRows.size;
        }
    }

    function applyPercentageChange(percent) {
        if (!spreadsheet) return;

        const data = spreadsheet.getData();
        data.forEach((row, index) => {
            const regularPrice = parseFloat(row[4]) || 0;
            if (regularPrice > 0) {
                const changeAmount = regularPrice * (percent / 100);
                const newPrice = regularPrice + changeAmount;
                spreadsheet.setValueFromCoords(5, index, Math.round(newPrice));

                // Track all modified rows
                modifiedRows.add(index);
            }
        });

        document.getElementById('modifiedCount').textContent = modifiedRows.size;
        showToast(`Applied ${percent > 0 ? '+' : ''}${percent}% change to all products`, 'success');
    }

    function updateStats() {
        if (!productsData.length) {
            document.getElementById('statsInfo').textContent = "No product data available";
            return;
        }

        const regularPrices = productsData.map(p => parseFloat(p.regular_price) || 0);
        const specialPrices = productsData.map(p => parseFloat(p.special_price) || parseFloat(p.regular_price) || 0);

        const totalRegular = regularPrices.reduce((a, b) => a + b, 0);
        const totalSpecial = specialPrices.reduce((a, b) => a + b, 0);
        const totalDiscount = totalRegular - totalSpecial;
        const avgDiscount = (totalDiscount / totalRegular * 100) || 0;

        const activeProducts = productsData.filter(p => p.status === 'Active').length;

        document.getElementById('statsInfo').innerHTML = `
            <span class="font-medium">${activeProducts}/${productsData.length}</span> active | 
            <span class="text-green-600 dark:text-green-400">${avgDiscount.toFixed(1)}%</span> avg discount
        `;
    }

    function saveSpreadsheet() {
    if (!spreadsheet) return;

    const data = spreadsheet.getData();
    const paguyubanId = {{ $paguyuban->id }};
    
    // Prepare batch update data
    const updates = data.map(row => ({
        product_id: row[0],
        price: parseFloat(row[5]) || 0,
        effective_date: row[9] || null, // Assuming column 9 is effective_date
        expiry_date: row[10] || null    // Assuming column 10 is expiry_date
    })).filter(item => item.product_id); // Filter out empty rows

    // Show loading state
    showToast('Saving changes...', 'info');

    // Send updates to the server
    fetch(`/paguyuban/${paguyubanId}/pricing/batch-update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            updates: updates
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast(`Successfully updated ${data.updated_count} products`, 'success');
            // Reset modified rows tracking
            modifiedRows = new Set();
            document.getElementById('modifiedCount').textContent = '0';
            // Reload data to reflect changes
            loadProductData();
        } else {
            throw new Error(data.message || 'Update failed');
        }
    })
    .catch(error => {
        console.error('Update error:', error);
        showToast(error.message || 'Failed to save changes', 'error');
    });
}

    function addNewRow() {
        if (!spreadsheet) return;

        spreadsheet.insertRow(1, ['', '', '', '', '', '', '', '', 'Active'], spreadsheet.options.data.length);
        document.getElementById('rowCount').textContent = spreadsheet.options.data.length;
        showToast('New row added', 'success');
    }

    function showImportModal() {
        const modal = document.getElementById('importModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeImportModal() {
        const modal = document.getElementById('importModal');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function processImport() {
        const fileInput = document.getElementById('file-upload');
        const replaceData = document.getElementById('replaceData').checked;

        if (!fileInput.files.length) {
            showToast('Please select a file to import', 'error');
            return;
        }

        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('replace', replaceData);
        formData.append('paguyuban_id', {{ $paguyuban->id }});

        showToast('Importing data...', 'info');

        fetch('/api/products/import', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(`Successfully imported ${data.imported} products`, 'success');
                    closeImportModal();
                    // Reload the spreadsheet
                    loadProductData();
                } else {
                    showToast(data.message || 'Import failed', 'error');
                }
            })
            .catch(error => {
                console.error('Import error:', error);
                showToast('Failed to import data', 'error');
            });
    }

    function exportToExcel() {
        if (!spreadsheet) return;

        // Show loading state
        showToast('Preparing export...', 'info');

        // In a real app, you might want to format this differently
        spreadsheet.download();

        setTimeout(() => {
            showToast('Export completed', 'success');
        }, 1000);
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

    function openEditModal(productId, currentPrice) {
        // In a real app, you would fetch the product details
        const product = productsData.find(p => p.id == productId) || {
            id: productId,
            name: 'Loading...',
            sku: '',
            price: currentPrice
        };

        document.getElementById('editProductName').textContent = product.name;
        document.getElementById('editProductSku').textContent = product.sku || 'SKU: N/A';
        document.getElementById('editRegularPrice').value = product.price;
        document.getElementById('editSpecialPrice').value = currentPrice;
        document.getElementById('editPricingForm').action = `/pos/community/{{ $paguyuban->id }}/pricing/${productId}`;

        // Calculate and show price difference
        updatePriceDifference('edit');

        const modal = document.getElementById('editPricingModal');
        const content = document.getElementById('editModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
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

    function confirmDelete(productId) {
        document.getElementById('deleteForm').action = `/pos/community/{{ $paguyuban->id }}/pricing/${productId}`;

        const modal = document.getElementById('deleteConfirmationModal');
        const content = document.getElementById('deleteModalContent');

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

    function showProductDetails(productId) {
        // In a real app, you would fetch the product details
        const product = productsData.find(p => p.id == productId) || {
            id: productId,
            name: 'Loading...',
            sku: 'N/A',
            category: 'Unknown',
            stock: 0,
            price: 0,
            special_price: 0,
            image: null
        };

        document.getElementById('productDetailName').textContent = product.name;
        document.getElementById('productDetailSku').textContent = `SKU: ${product.sku}`;
        document.getElementById('productDetailCategory').textContent = product.category || 'Uncategorized';
        document.getElementById('productDetailStock').textContent = product.stock || '0 in stock';
        document.getElementById('productDetailRegularPrice').textContent = `Rp ${product.price.toLocaleString('id-ID')}`;
        document.getElementById('productDetailSpecialPrice').textContent = `Rp ${(product.special_price || product.price).toLocaleString('id-ID')}`;

        const savings = product.price - (product.special_price || product.price);
        document.getElementById('productDetailSavings').textContent = `Rp ${savings.toLocaleString('id-ID')}`;

        if (product.image) {
            document.getElementById('productDetailImage').src = `/storage/${product.image}`;
            document.getElementById('productDetailImage').classList.remove('hidden');
            document.getElementById('productDetailIcon').classList.add('hidden');
        } else {
            document.getElementById('productDetailImage').classList.add('hidden');
            document.getElementById('productDetailIcon').classList.remove('hidden');
        }

        // Initialize product charts
        initProductCharts(productId);

        const modal = document.getElementById('productDetailsModal');
        const content = document.getElementById('detailsModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeProductDetails() {
        const modal = document.getElementById('productDetailsModal');
        const content = document.getElementById('detailsModalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function showMemberEngagementModal() {
        // Initialize member engagement charts
        initMemberEngagementCharts();

        const modal = document.getElementById('memberEngagementModal');
        const content = document.getElementById('engagementModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function closeMemberEngagementModal() {
        const modal = document.getElementById('memberEngagementModal');
        const content = document.getElementById('engagementModalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    function initProductCharts(productId) {
        // Destroy existing charts if they exist
        if (productSalesChart) {
            productSalesChart.destroy();
        }
        if (productEngagementChart) {
            productEngagementChart.destroy();
        }

        // Sample data - in a real app, you would fetch this from your API
        const salesCtx = document.getElementById('productSalesChart').getContext('2d');
        productSalesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Units Sold',
                    data: [45, 60, 52, 70],
                    backgroundColor: 'rgba(79, 70, 229, 0.7)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const engagementCtx = document.getElementById('productEngagementChart').getContext('2d');
        productEngagementChart = new Chart(engagementCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Views',
                    data: [120, 190, 170, 210, 240, 190, 230],
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function initMemberEngagementCharts() {
        // Destroy existing charts if they exist
        if (memberActivityChart) {
            memberActivityChart.destroy();
        }
        if (purchaseFrequencyChart) {
            purchaseFrequencyChart.destroy();
        }

        // Sample data - in a real app, you would fetch this from your API
        const activityCtx = document.getElementById('memberActivityChart').getContext('2d');
        memberActivityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Active Members',
                    data: [120, 190, 170, 210, 240, 220, 250],
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const frequencyCtx = document.getElementById('purchaseFrequencyChart').getContext('2d');
        purchaseFrequencyChart = new Chart(frequencyCtx, {
            type: 'doughnut',
            data: {
                labels: ['1-2 times', '3-5 times', '6-10 times', '10+ times'],
                datasets: [{
                    data: [15, 30, 25, 10],
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(79, 70, 229, 0.7)',
                        'rgba(67, 56, 202, 0.7)',
                        'rgba(55, 48, 163, 0.7)'
                    ],
                    borderColor: [
                        'rgba(99, 102, 241, 1)',
                        'rgba(79, 70, 229, 1)',
                        'rgba(67, 56, 202, 1)',
                        'rgba(55, 48, 163, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }

    // Product select change handler
    document.getElementById('product_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const regularPrice = selectedOption.getAttribute('data-price') || 0;

        document.getElementById('regular_price').value = regularPrice;
        document.getElementById('special_price').value = regularPrice;

        updatePriceDifference();
    });

    document.getElementById('special_price')?.addEventListener('input', function() {
        updatePriceDifference();
    });

    document.getElementById('editSpecialPrice')?.addEventListener('input', function() {
        updatePriceDifference('edit');
    });

    function updatePriceDifference(mode = 'add') {
    const prefix = mode === 'edit' ? 'edit' : '';
    const regularPriceElement = document.getElementById(`regular_price`);
    const specialPriceElement = document.getElementById(`special_price`);
    const differenceElement = document.getElementById(`price_difference`);

    // Check if all required elements exist
    if (!regularPriceElement || !specialPriceElement || !differenceElement) {
        console.error('Required elements not found for price difference calculation');
        return;
    }

    const regularPrice = parseFloat(regularPriceElement.value) || 0;
    const specialPrice = parseFloat(specialPriceElement.value) || 0;

    const difference = regularPrice - specialPrice;
    const percentage = regularPrice > 0 ? (difference / regularPrice * 100) : 0;

    let message = '';
    let colorClass = '';

    if (difference > 0) {
        message = `Members save Rp ${difference.toLocaleString('id-ID')} (${percentage.toFixed(2)}%)`;
        colorClass = 'text-green-600 dark:text-green-400';
    } else if (difference < 0) {
        message = `Members pay Rp ${Math.abs(difference).toLocaleString('id-ID')} more (${Math.abs(percentage).toFixed(2)}%)`;
        colorClass = 'text-red-600 dark:text-red-400';
    } else {
        message = 'No price difference';
        colorClass = 'text-gray-600 dark:text-gray-400';
    }

    differenceElement.innerHTML = message;
    differenceElement.className = `text-sm font-medium animate-pulse ${colorClass}`;
}

    function fetchActivityLogs(paguyubanId, page = 1) {
        const container = document.getElementById('activityLogsContainer');
        const pagination = document.getElementById('activityPagination');

        container.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-2xl text-indigo-500"></i>
                <p class="text-gray-500 mt-2">Loading activity logs...</p>
            </div>
        `;

        // In a real app, you would fetch this from your API
        fetch(`/paguyuban/${paguyubanId}/activity-log?page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.activities.data && data.activities.data.length > 0) {
                    renderActivityLogs(data.activities.data);
                    renderActivityPagination(data.activities);
                } else {
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-history text-2xl text-gray-400"></i>
                            <p class="text-gray-500 mt-2">No activity logs found</p>
                        </div>
                    `;
                    pagination.innerHTML = '';
                }
            })
            .catch(error => {
                console.error('Error fetching activity logs:', error);
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                        <p class="text-gray-500 mt-2">Failed to load activity logs</p>
                    </div>
                `;
                pagination.innerHTML = '';
            });
    }

    function renderActivityLogs(logs) {
        const container = document.getElementById('activityLogsContainer');
        container.innerHTML = '';

        logs.forEach((log, index) => {
            const iconClass = {
                'price_update': 'fas fa-tag text-purple-500',
                'member_added': 'fas fa-user-plus text-blue-500',
                'member_removed': 'fas fa-user-minus text-red-500',
                'community_updated': 'fas fa-edit text-indigo-500',
                'product_added': 'fas fa-box-open text-green-500'
            }[log.type] || 'fas fa-info-circle text-gray-500';

            const bgColor = {
                'price_update': 'bg-purple-100 dark:bg-purple-900/50',
                'member_added': 'bg-blue-100 dark:bg-blue-900/50',
                'member_removed': 'bg-red-100 dark:bg-red-900/50',
                'community_updated': 'bg-indigo-100 dark:bg-indigo-900/50',
                'product_added': 'bg-green-100 dark:bg-green-900/50'
            }[log.type] || 'bg-gray-100 dark:bg-gray-700';

            const logElement = document.createElement('div');
            logElement.className = `relative pl-8 pb-6 ${index === logs.length - 1 ? '' : 'border-l-2 border-indigo-200 dark:border-indigo-800'}`;
            logElement.innerHTML = `
                <div class="absolute -left-2.5 top-0 h-5 w-5 rounded-full ${bgColor} border-4 border-white dark:border-gray-800 flex items-center justify-center">
                    <i class="${iconClass} text-xs"></i>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md hover:border-gray-200 dark:hover:border-gray-600 transform hover:-translate-x-1">
                    <div class="flex items-start">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">${log.description}</p>
                            <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="far fa-clock mr-1"></i>
                                ${new Date(log.created_at).toLocaleString()} (${timeAgo(new Date(log.created_at))})
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(logElement);
        });
    }

    function renderActivityPagination(data) {
        const pagination = document.getElementById('activityPagination');

        if (data.last_page <= 1) {
            pagination.innerHTML = '';
            return;
        }

        let html = `
            <div class="flex items-center justify-between w-full">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing ${data.from} to ${data.to} of ${data.total} entries
                </div>
                <div class="flex space-x-2">
        `;

        // Previous button
        if (data.current_page > 1) {
            html += `
                <button onclick="fetchActivityLogs(${data.paguyuban_id}, ${data.current_page - 1})" 
                    class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-0.5">
                    Previous
                </button>
            `;
        }

        // Page numbers
        for (let i = 1; i <= data.last_page; i++) {
            if (i === data.current_page) {
                html += `
                    <button class="px-3 py-1 rounded-lg bg-indigo-600 text-white">
                        ${i}
                    </button>
                `;
            } else {
                html += `
                    <button onclick="fetchActivityLogs(${data.paguyuban_id}, ${i})" 
                        class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        ${i}
                    </button>
                `;
            }
        }

        // Next button
        if (data.current_page < data.last_page) {
            html += `
                <button onclick="fetchActivityLogs(${data.paguyuban_id}, ${data.current_page + 1})" 
                    class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:translate-x-0.5">
                    Next
                </button>
            `;
        }

        html += `</div></div>`;
        pagination.innerHTML = html;
    }

    function timeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);

        let interval = Math.floor(seconds / 31536000);
        if (interval >= 1) return interval + " year" + (interval === 1 ? "" : "s") + " ago";

        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) return interval + " month" + (interval === 1 ? "" : "s") + " ago";

        interval = Math.floor(seconds / 86400);
        if (interval >= 1) return interval + " day" + (interval === 1 ? "" : "s") + " ago";

        interval = Math.floor(seconds / 3600);
        if (interval >= 1) return interval + " hour" + (interval === 1 ? "" : "s") + " ago";

        interval = Math.floor(seconds / 60);
        if (interval >= 1) return interval + " minute" + (interval === 1 ? "" : "s") + " ago";

        return Math.floor(seconds) + " second" + (seconds === 1 ? "" : "s") + " ago";
    }

    // Toast notification system
    function showToast(message, type = 'info', duration = 3000) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');

        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };

        toast.className = `toast toast-${type} animate-slide-in-right`;
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="${icons[type]}"></i>
            </div>
            <div class="toast-message">${message}</div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        container.appendChild(toast);

        // Auto-remove after duration
        if (duration > 0) {
            setTimeout(() => {
                toast.classList.remove('animate-slide-in-right');
                toast.classList.add('animate-slide-out');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, duration);
        }

        return toast;
    }

    function openProductManagement() {
        const modal = document.getElementById('productManagementModal');
        const content = document.getElementById('spreadsheetModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.classList.add('overflow-hidden');

        loadProductData();
    }

    // Close all toasts
    function closeAllToasts() {
        const container = document.getElementById('toast-container');
        container.innerHTML = '';
    }
</script>
@endpush