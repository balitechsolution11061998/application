@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-xl p-6 mb-6 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="h-16 w-16 rounded-full border-4 border-white dark:border-gray-700 shadow-md overflow-hidden bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                    @if($paguyuban->logo)
                        <img src="{{ asset('storage/'.$paguyuban->logo) }}" alt="{{ $paguyuban->name }}" class="h-full w-full object-cover">
                    @else
                        <i class="fas fa-users text-indigo-500 dark:text-indigo-300 text-3xl"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $paguyuban->name }}</h1>
                    <p class="text-indigo-100 mt-1 text-sm sm:text-base">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                            {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-3 w-full md:w-auto mt-3 sm:mt-0">
                <a href="{{ route('pos.community.edit', $paguyuban) }}" class="flex-1 md:flex-none flex items-center justify-center px-4 sm:px-5 py-2 bg-white hover:bg-gray-100 text-indigo-600 rounded-lg shadow-md transition-all duration-300 group">
                    <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap">Edit</span>
                </a>
                <a href="{{ route('pos.community.index') }}" class="flex-1 md:flex-none flex items-center justify-center px-4 sm:px-5 py-2 border border-white dark:border-gray-600 rounded-lg bg-transparent text-white hover:bg-white hover:text-indigo-600 dark:hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>
                    <span class="whitespace-nowrap">Back</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Details Card -->
        <div class="lg:col-span-1 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gray-50/70 dark:bg-gray-700/30">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Details</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $paguyuban->description ?? 'No description provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paguyuban->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Created</p>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $paguyuban->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $paguyuban->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="lg:col-span-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
            <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gray-50/70 dark:bg-gray-700/30">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Special Pricing</h3>
                    <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-plus mr-1"></i> Add Product
                    </button>
                </div>
            </div>
            <div class="p-6">
                @if($paguyuban->products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
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
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600 mr-3">
                                                <i class="fas fa-box text-gray-400 dark:text-gray-500"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-600 dark:text-gray-300">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</span>
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $product->pivot->price < $product->price ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : ($product->pivot->price > $product->price ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }}">
                                            @if($product->pivot->price < $product->price)
                                                <i class="fas fa-arrow-down mr-1"></i>
                                                {{ number_format(100 - ($product->pivot->price / $product->price * 100), 0) }}%
                                            @elseif($product->pivot->price > $product->price)
                                                <i class="fas fa-arrow-up mr-1"></i>
                                                {{ number_format(($product->pivot->price / $product->price * 100) - 100, 0) }}%
                                            @else
                                                Same
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors p-1 rounded-md hover:bg-yellow-100/50 dark:hover:bg-yellow-900/30" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors p-1 rounded-md hover:bg-red-100/50 dark:hover:bg-red-900/30" title="Remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <i class="fas fa-box-open text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No special pricing</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">This paguyuban has no special pricing for any products yet.</p>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-2"></i> Add Product Pricing
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection