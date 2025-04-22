@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6 max-w-7xl mx-auto">
    <!-- Header Section with Animation -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-6 mb-8 shadow-xl transform transition-all duration-500 hover:scale-[1.005] hover:shadow-2xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
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
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-white/20 text-white backdrop-blur-sm' : 'bg-red-500/90 text-white' }} animate-pulse">
                            <span class="w-2 h-2 rounded-full mr-2 {{ $paguyuban->is_active ? 'bg-green-300' : 'bg-red-300' }}"></span>
                            {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="text-white/80 text-sm transition-all duration-300 hover:text-white">
                            {{ $paguyuban->members_count }} members
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 w-full md:w-auto mt-3 sm:mt-0">
                <a href="{{ route('pos.community.edit', $paguyuban) }}" class="flex items-center justify-center px-5 py-2.5 bg-white/90 hover:bg-white text-indigo-600 rounded-xl shadow-sm transition-all duration-300 group hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Edit</span>
                </a>
                <a href="{{ route('pos.community.index') }}" class="flex items-center justify-center px-5 py-2.5 border border-white/50 rounded-xl bg-white/10 text-white hover:bg-white/20 transition-colors duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="whitespace-nowrap text-sm font-medium">Back</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Details Card with Animation -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-info-circle text-indigo-500 mr-2 animate-bounce" style="animation-duration: 2s"></i>
                        Community Details
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-5">
                        <!-- Animated description section -->
                        <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Description</p>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                {{ $paguyuban->description ?? 'No description provided' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Status with pulse animation -->
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' }} {{ $paguyuban->is_active ? 'animate-pulse' : '' }}" style="animation-duration: 3s">
                                        {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                            <!-- Members count with counter animation -->
                            <div class="transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Members</p>
                                <p class="text-gray-700 dark:text-gray-300 font-medium animate-count" data-count="{{ $paguyuban->members_count }}">
                                    0
                                </p>
                            </div>
                        </div>

                        <!-- Created date with hover effect -->
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4 transition-all duration-300 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 p-3 rounded-lg">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Created</p>
                            <div class="flex items-center text-gray-700 dark:text-gray-300 text-sm">
                                <i class="far fa-calendar-alt mr-2 text-gray-400 transition-transform duration-300 hover:scale-110"></i>
                                {{ $paguyuban->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <!-- Last updated with hover effect -->
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

            <!-- Performance Card with Animated Progress Bars -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-chart-line text-indigo-500 mr-2 animate-pulse" style="animation-duration: 1.5s"></i>
                        Performance
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Animated progress bars -->
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

        <!-- Products Card with Animation -->
        <div class="lg:col-span-2 space-y-6">
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
                            <button class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-xl shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5">
                                <i class="fas fa-filter mr-2"></i> Filter
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
                                        <span class="ml-3 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $product->pivot->price < $product->price ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : ($product->pivot->price > $product->price ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }} transition-all duration-300 hover:scale-105">
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
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="openEditModal({{ $product->id }}, {{ $product->pivot->price }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors p-2 rounded-lg hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transform hover:scale-110" title="Edit">
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
                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">24</span> results
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
                    <button onclick="openModal()" class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all hover:shadow-md transform hover:-translate-y-0.5 animate-pulse-slow">
                        <i class="fas fa-plus mr-2"></i> Add Product Pricing
                    </button>
                </div>
                @endif
            </div>

            <!-- Recent Activity with Animation -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-history text-indigo-500 mr-2 animate-spin" style="animation-duration: 10s"></i>
                        Recent Activity
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Activity items with staggered animation -->
                        <div class="flex items-start animate-fade-in-up" style="animation-delay: 0.1s">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-300 mr-3 transition-transform duration-300 hover:rotate-12">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Profile updated</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Community details were updated by Admin</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-start animate-fade-in-up" style="animation-delay: 0.2s">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center text-green-600 dark:text-green-300 mr-3 transition-transform duration-300 hover:rotate-12">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Pricing added</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Special price for "Organic Rice 5kg" was added</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">1 day ago</p>
                            </div>
                        </div>
                        <div class="flex items-start animate-fade-in-up" style="animation-delay: 0.3s">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-300 mr-3 transition-transform duration-300 hover:rotate-12">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Members added</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">5 new members joined the community</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">3 days ago</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-all duration-300 transform hover:scale-105">
                            View all activity
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Pricing Modal with Animation -->
<div id="addPricingModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-2xl bg-white dark:bg-gray-800 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Add Special Pricing
            </h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal content -->
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
                    <input type="number" id="special_price" name="price" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-300 hover:shadow-md">
                    <p id="price_difference" class="mt-1 text-sm animate-pulse" style="animation-duration: 1.5s"></p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200 dark:border-gray-700 space-x-3 animate-fade-in-up" style="animation-delay: 0.4s">
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
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Edit Special Pricing
            </h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200 hover:rotate-90">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal content -->
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
                    <input type="number" id="editSpecialPrice" name="price" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <p id="editPriceDifference" class="mt-1 text-sm animate-pulse" style="animation-duration: 1.5s"></p>
                </div>
            </div>

            <!-- Modal footer -->
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

<!-- Recent Activity with Enhanced Animation -->
<div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/20">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-history text-indigo-500 mr-2 animate-spin" style="animation-duration: 10s"></i>
                Recent Activity Log
            </h3>
            <button onclick="fetchActivityLogs({{ $paguyuban->id }})" 
                   class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-all duration-300 transform hover:scale-105">
                Refresh
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

<!-- ... (keep the rest of your existing code) ... -->

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

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.8;
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

      // Enhanced activity log hover effects
      document.querySelectorAll('.activity-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.querySelector('.activity-details').classList.remove('hidden');
            this.querySelector('.activity-icon').classList.add('rotate-12', 'scale-110');
        });
        
        item.addEventListener('mouseleave', function() {
            this.querySelector('.activity-details').classList.add('hidden');
            this.querySelector('.activity-icon').classList.remove('rotate-12', 'scale-110');
        });
    });

    document.querySelectorAll('.status-badge').forEach(badge => {
        badge.addEventListener('mouseenter', () => {
            const tooltip = badge.querySelector('.status-tooltip');
            tooltip.classList.remove('hidden');
        });
        
        badge.addEventListener('mouseleave', () => {
            const tooltip = badge.querySelector('.status-tooltip');
            tooltip.classList.add('hidden');
        });
    });

    // Function to fetch activity logs
function fetchActivityLogs(paguyubanId) {
    fetch(`/paguyuban/${paguyubanId}/activity-log`)
        .then(response => response.json())
        .then(data => {
            renderActivityLogs(data.activities.data);
            setupPagination(data.activities);
        })
        .catch(error => {
            console.error('Error fetching activity logs:', error);
            showToast('Failed to load activity logs', 'error');
        });
}

// Function to render activity logs
function renderActivityLogs(activities) {
    const container = document.getElementById('activityLogsContainer');
    container.innerHTML = ''; // Clear existing content

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
        const activityItem = createActivityItem(activity, index);
        container.appendChild(activityItem);
    });
}

// Function to create an activity item element
function createActivityItem(activity, index) {
    const item = document.createElement('div');
    item.className = `flex items-start animate-fade-in-up`;
    item.style.animationDelay = `${index * 0.1}s`;

    // Determine icon and color based on activity type
    const { iconClass, bgClass, textClass } = getActivityStyles(activity.description);
    
    // Format properties if they exist
    let propertiesHtml = '';
    if (activity.properties && Object.keys(activity.properties).length > 0) {
        propertiesHtml = renderActivityProperties(activity.properties);
    }

    item.innerHTML = `
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

    return item;
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

// Function to setup pagination
function setupPagination(paginationData) {
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
                `<button onclick="fetchPage('${paginationData.prev_page_url}')" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:-translate-x-0.5">
                    Previous
                </button>` : ''
            }
            ${paginationData.next_page_url ? 
                `<button onclick="fetchPage('${paginationData.next_page_url}')" class="px-3 py-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300 transform hover:translate-x-0.5">
                    Next
                </button>` : ''
            }
        </div>
    `;
}

// Function to fetch a specific page
function fetchPage(url) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            renderActivityLogs(data.activities.data);
            setupPagination(data.activities);
            // Scroll to top of activity section
            document.getElementById('activityLogsContainer').scrollIntoView({
                behavior: 'smooth'
            });
        })
        .catch(error => {
            console.error('Error fetching activity logs:', error);
            showToast('Failed to load activity logs', 'error');
        });
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
    function openEditModal(productId, currentPrice) {
        const modal = document.getElementById('editPricingModal');
        const content = document.getElementById('editModalContent');

        // In a real app, you would fetch the product details here
        // For demo, we'll just set some values
        document.getElementById('editProductName').textContent = "Product " + productId;
        document.getElementById('editRegularPrice').value = formatRupiah(currentPrice * 1.2); // Example regular price
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
        const regularPrice = parseFloat(document.getElementById('product_id').options[document.getElementById('product_id').selectedIndex]?.getAttribute('data-price')) || 0;
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
        const regularPrice = parseFloat(document.getElementById('editRegularPrice').value.replace(/[^0-9.-]+/g, "")) || 0;
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

    // Animate progress bars on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });

            // Assuming you have the paguyuban ID available
    const paguyubanId = {{ $paguyuban->id }};
    fetchActivityLogs(paguyubanId);

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
    });
</script>
@endsection