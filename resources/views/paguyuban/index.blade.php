@extends('pos.index')

@section('content')
<div class="w-full px-0 py-0">
    <!-- Toastr Notifications -->
    @if(session('success'))
    <div class="toastr-notification fixed top-5 right-5 z-50">
        <div class="bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-xl flex items-center animate-fade-in-up">
            <i class="fas fa-check-circle mr-3 text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="toastr-notification fixed top-5 right-5 z-50">
        <div class="bg-rose-500 text-white px-6 py-3 rounded-xl shadow-xl flex items-center animate-fade-in-up">
            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 mb-6 shadow-lg w-full">
        <div class="w-full mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="transform transition-all duration-300 hover:scale-[1.01]">
                <h1 class="text-3xl sm:text-4xl font-bold text-white drop-shadow-md">Paguyuban Management</h1>
                <p class="text-indigo-100 mt-2 text-base sm:text-lg opacity-90">Manage community groups and their special pricing</p>
            </div>
            <div class="flex items-center space-x-3 w-full md:w-auto mt-3 sm:mt-0">
                <a href="{{ route('pos.community.create') }}"
                    class="flex-1 md:flex-none flex items-center justify-center px-5 py-3 bg-white hover:bg-gray-50 text-indigo-600 rounded-xl shadow-md transition-all duration-300 group hover:shadow-lg hover:-translate-y-0.5">
                    <i class="fas fa-plus-circle mr-3 text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap font-semibold">Add New Paguyuban</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content - Full Width -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Communities</p>
                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">{{ $paguyubans->total() }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <span class="h-2 w-2 rounded-full bg-indigo-500 mr-2"></span>
                        <span>{{ $activeCount = $paguyubans->where('is_active', true)->count() }} active</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                        <span class="h-2 w-2 rounded-full bg-gray-300 dark:bg-gray-600 mr-2"></span>
                        <span>{{ $paguyubans->total() - $activeCount }} inactive</span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Products</p>
                        <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $totalProducts }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-300">
                        <i class="fas fa-boxes text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-medium">{{ $paguyubans->sum('products_count') }}</span> special pricing entries
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Discount</p>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ number_format($averageDiscount, 1) }}%</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-300">
                        <i class="fas fa-percentage text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Across all community pricing
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md mb-6 overflow-hidden border border-gray-200/50 dark:border-gray-700/50 w-full">
            <div class="p-5">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 w-full">
                    <div class="relative w-full max-w-xl group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-search text-lg"></i>
                        </div>
                        <input type="text" id="searchInput" placeholder="Search paguyubans by name..."
                            class="block w-full pl-12 pr-5 py-3 border border-gray-300/50 dark:border-gray-600/50 rounded-xl bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200 group-hover:shadow-md focus:shadow-lg">
                    </div>
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <select id="statusFilter" class="w-full md:w-auto appearance-none bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-xl px-4 py-3 pr-10 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200 hover:shadow-md">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <button id="resetFilters" class="w-full md:w-auto px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl shadow-sm transition-all duration-200 hover:shadow-md">
                            <i class="fas fa-sync-alt mr-2"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50 w-full">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50 bg-gray-50/70 dark:bg-gray-700/30 w-full">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between w-full gap-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Paguyuban List</h3>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Showing {{ $paguyubans->firstItem() }} to {{ $paguyubans->lastItem() }} of {{ $paguyubans->total() }} entries
                    </div>
                </div>
            </div>

            <!-- Table Content - Full Width -->
            <div class="w-full overflow-x-auto">
                <table class="w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    <thead class="bg-gray-50/70 dark:bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider min-w-[250px]">
                                Community
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider min-w-[120px]">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider min-w-[200px]">
                                Products & Pricing
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider min-w-[150px]">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/50 dark:bg-gray-800/30 divide-y divide-gray-200/50 dark:divide-gray-700/50">
                        @forelse ($paguyubans as $paguyuban)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors duration-150 group">
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center overflow-hidden border-2 border-gray-200 dark:border-gray-600 mr-4 group-hover:border-indigo-300 transition-colors duration-200">
                                        @if($paguyuban->logo)
                                        <img src="{{ asset('storage/'.$paguyuban->logo) }}" alt="{{ $paguyuban->name }}" class="h-full w-full object-cover">
                                        @else
                                        <i class="fas fa-users text-indigo-500 dark:text-indigo-300 text-xl"></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200 text-lg truncate">{{ $paguyuban->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $paguyuban->description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex flex-col items-start">
                                    <span class="px-3 py-1.5 text-sm font-medium rounded-full flex items-center justify-center transition-all duration-200 {{ $paguyuban->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 group-hover:bg-green-200 dark:group-hover:bg-green-800' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 group-hover:bg-red-200 dark:group-hover:bg-red-800' }}">
                                        <span class="w-2.5 h-2.5 rounded-full mr-2 {{ $paguyuban->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Created: {{ $paguyuban->created_at->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <div class="flex items-center">
                                        <span class="text-base text-gray-700 dark:text-gray-300 mr-3 font-medium">{{ $paguyuban->products_count ?? 0 }} products</span>
                                        @if($paguyuban->products_count > 0)
                                        <span class="text-sm px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 font-medium">
                                            <i class="fas fa-tag mr-1"></i> {{ $paguyuban->discount_percentage ?? 0 }}% discount
                                        </span>
                                        @endif
                                    </div>
                                    @if($paguyuban->products_count > 0)
                                    <div class="mt-2">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ min(($paguyuban->products_count / 50) * 100, 100) }}%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex justify-between">
                                            <span>{{ $paguyuban->products_count }} of max 50 products</span>
                                            <span class="font-medium">Total savings: Rp{{ number_format($paguyuban->products->sum(function($product) { return ($product->price - $product->pivot->price) * 100; }), 0) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('pos.community.show', $paguyuban) }}"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-all duration-200 p-2.5 rounded-xl hover:bg-blue-100/50 dark:hover:bg-blue-900/30 hover:scale-110 flex flex-col items-center"
                                        title="View Details">
                                        <i class="fas fa-eye text-lg"></i>
                                        <span class="text-xs mt-1">View</span>
                                    </a>
                                    <a href="{{ route('pos.community.edit', $paguyuban) }}"
                                        class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-all duration-200 p-2.5 rounded-xl hover:bg-yellow-100/50 dark:hover:bg-yellow-900/30 hover:scale-110 flex flex-col items-center"
                                        title="Edit">
                                        <i class="fas fa-edit text-lg"></i>
                                        <span class="text-xs mt-1">Edit</span>
                                    </a>
                                    <button type="button"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-all duration-200 p-2.5 rounded-xl hover:bg-red-100/50 dark:hover:bg-red-900/30 hover:scale-110 flex flex-col items-center"
                                        title="Delete"
                                        data-delete-url="{{ route('pos.community.destroy', $paguyuban) }}"
                                        onclick="confirmDelete(event, this)">
                                        <i class="fas fa-trash text-lg"></i>
                                        <span class="text-xs mt-1">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center w-full">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 w-full">
                                    <div class="bg-indigo-100 dark:bg-indigo-900/50 p-6 rounded-full mb-4">
                                        <i class="fas fa-users-slash text-4xl text-indigo-500 dark:text-indigo-400"></i>
                                    </div>
                                    <p class="text-xl font-semibold mb-1">No paguyubans found</p>
                                    <p class="text-sm mb-4 max-w-md text-center">You haven't created any paguyuban groups yet. Start by adding your first community group to manage special pricing.</p>
                                    <a href="{{ route('pos.community.create') }}" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md transition-colors duration-200 inline-flex items-center">
                                        <i class="fas fa-plus mr-2"></i> Create New Paguyuban
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($paguyubans->hasPages())
            <div class="px-6 py-4 border-t border-gray-200/50 dark:border-gray-700/50 bg-gray-50/70 dark:bg-gray-700/30 w-full">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Showing {{ $paguyubans->firstItem() }} to {{ $paguyubans->lastItem() }} of {{ $paguyubans->total() }} entries
                    </div>
                    {{ $paguyubans->links('vendor.pagination.tailwind') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toastr auto-hide
    @if(session('success') || session('error'))
    setTimeout(() => {
        const toast = document.querySelector('.toastr-notification');
        if (toast) {
            toast.classList.add('animate-fade-out');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }, 5000);
    @endif

    // Confirm delete function with SweetAlert
    function confirmDelete(event, button) {
        event.preventDefault();
        const deleteUrl = button.getAttribute('data-delete-url');

        Swal.fire({
            title: 'Confirm Deletion',
            html: `<div class="text-center">
                     <i class="fas fa-exclamation-triangle text-5xl text-yellow-500 mb-4"></i>
                     <p class="text-lg font-medium mb-2">Are you sure you want to delete this paguyuban?</p>
                     <p class="text-sm text-gray-500">This action cannot be undone and will remove all associated data.</p>
                   </div>`,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-5 py-2.5 rounded-lg',
                cancelButton: 'px-5 py-2.5 rounded-lg'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrf);

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (row.querySelector('td:first-child div.font-semibold')) {
                    const name = row.querySelector('td:first-child div.font-semibold').textContent.toLowerCase();
                    if (name.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    }

    // Status filter functionality
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const statusValue = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (!row.querySelector('td:nth-child(2) span')) return;

                const status = row.querySelector('td:nth-child(2) span').textContent.trim().toLowerCase();
                if (statusValue === '' || status === statusValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Reset filters
    const resetFilters = document.getElementById('resetFilters');
    if (resetFilters) {
        resetFilters.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = '';

            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        });
    }
</script>
@endpush

<style>
    /* Animation styles */
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .animate-fade-out {
        animation: fadeOut 0.3s ease-in forwards;
    }

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

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(20px);
        }
    }

    /* Custom scrollbar for table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a5b4fc;
    }

    .dark .overflow-x-auto::-webkit-scrollbar-track {
        background: #374151;
    }

    .dark .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #4f46e5;
    }

    .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #4338ca;
    }

    /* Enhanced pagination styles */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .pagination li {
        margin: 0 3px;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid rgba(156, 163, 175, 0.3);
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s;
        padding: 0 12px;
    }

    .pagination .page-link:hover {
        background-color: #e5e7eb;
        transform: translateY(-1px);
    }

    .pagination .active .page-link {
        background-color: #6366f1;
        color: white;
        border-color: #6366f1;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
    }

    .pagination .disabled .page-link {
        opacity: 0.5;
        pointer-events: none;
    }

    .dark .pagination .page-link {
        color: #d1d5db;
        border-color: rgba(75, 85, 99, 0.5);
    }

    .dark .pagination .page-link:hover {
        background-color: #4b5563;
    }

    .dark .pagination .active .page-link {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    /* Responsive table adjustments */
    @media (max-width: 768px) {
        table {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        thead {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        tr {
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
        }

        td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 1rem;
            border: none;
        }

        td::before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
            color: #6b7280;
        }

        .px-8 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }
</style>
@endsection