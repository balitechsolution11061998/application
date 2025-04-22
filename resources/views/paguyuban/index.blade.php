@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Toastr Notifications -->
    @if(session('success'))
        <div class="toastr-notification fixed top-5 right-5 z-50">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-up">
                <i class="fas fa-check-circle mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="toastr-notification fixed top-5 right-5 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-up">
                <i class="fas fa-exclamation-circle mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-xl p-6 mb-6 shadow-lg transform transition-all duration-300 hover:shadow-xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="transform transition-all duration-300 hover:scale-[1.01]">
                <h1 class="text-2xl sm:text-3xl font-bold text-white drop-shadow-md">Paguyuban Management</h1>
                <p class="text-indigo-100 mt-1 sm:mt-2 text-sm sm:text-base opacity-90">Manage your community groups and their special pricing</p>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-3 w-full md:w-auto mt-3 sm:mt-0">
                <a href="{{ route('pos.community.create') }}"
                    class="flex-1 md:flex-none flex items-center justify-center px-4 sm:px-5 py-2 bg-white hover:bg-gray-100 text-indigo-600 rounded-lg shadow-md transition-all duration-300 group hover:shadow-lg hover:-translate-y-0.5">
                    <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                    <span class="whitespace-nowrap font-medium">Add Paguyuban</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50 transform transition-all duration-300 hover:shadow-xl">
        <!-- Filters Section -->
        <div class="p-4 border-b border-gray-200/50 dark:border-gray-700/50 bg-gray-50/70 dark:bg-gray-700/30">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="relative w-full max-w-md group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Search paguyubans..."
                        class="block w-full pl-10 pr-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200 group-hover:shadow-md focus:shadow-lg">
                </div>
                <div class="flex items-center space-x-2">
                    <select id="statusFilter" class="appearance-none bg-white/70 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-3 py-2 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200 hover:shadow-md">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                <thead class="bg-gray-50/70 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Paguyuban
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Products
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white/50 dark:bg-gray-800/30 divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse ($paguyubans as $paguyuban)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors duration-150 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600 mr-3 group-hover:border-indigo-300 transition-colors duration-200">
                                    @if($paguyuban->logo)
                                        <img src="{{ asset('storage/'.$paguyuban->logo) }}" alt="{{ $paguyuban->name }}" class="h-full w-full object-cover">
                                    @else
                                        <i class="fas fa-users text-indigo-500 dark:text-indigo-300"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">{{ $paguyuban->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $paguyuban->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full flex items-center justify-center w-20 transition-all duration-200 {{ $paguyuban->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 group-hover:bg-green-200 dark:group-hover:bg-green-800' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 group-hover:bg-red-200 dark:group-hover:bg-red-800' }}">
                                <span class="w-2 h-2 rounded-full mr-2 {{ $paguyuban->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-300 mr-2">{{ $paguyuban->products_count ?? 0 }} products</span>
                                @if($paguyuban->products_count > 0)
                                <span class="text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">+{{ $paguyuban->discount_percentage ?? 0 }}%</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('pos.community.show', $paguyuban) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-all duration-200 p-2 rounded-md hover:bg-blue-100/50 dark:hover:bg-blue-900/30 hover:scale-110"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pos.community.edit', $paguyuban) }}" 
                                   class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-all duration-200 p-2 rounded-md hover:bg-yellow-100/50 dark:hover:bg-yellow-900/30 hover:scale-110"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pos.community.destroy', $paguyuban) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-all duration-200 p-2 rounded-md hover:bg-red-100/50 dark:hover:bg-red-900/30 hover:scale-110" 
                                            title="Delete" 
                                            onclick="return confirmDelete()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                <i class="fas fa-users-slash text-4xl mb-3 opacity-50"></i>
                                <p class="text-lg font-medium">No paguyubans found</p>
                                <p class="text-sm mt-1">Start by adding a new paguyuban</p>
                                <a href="{{ route('pos.community.create') }}" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 inline-flex items-center">
                                    <i class="fas fa-plus mr-2"></i> Add Paguyuban
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
        <div class="px-6 py-4 border-t border-gray-200/50 dark:border-gray-700/50 bg-gray-50/70 dark:bg-gray-700/30">
            {{ $paguyubans->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Toastr auto-hide
    @if(session('success') || session('error'))
    setTimeout(() => {
        document.querySelector('.toastr-notification').classList.add('animate-fade-out');
        setTimeout(() => {
            document.querySelector('.toastr-notification').remove();
        }, 300);
    }, 5000);
    @endif

    // Confirm delete function with Toastr
    function confirmDelete() {
        return Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            background: '{{ config('app.theme') === 'dark' ? '#1f2937' : '#ffffff' }}',
            color: '{{ config('app.theme') === 'dark' ? '#ffffff' : '#000000' }}'
        }).then((result) => {
            return result.isConfirmed;
        });
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('td:first-child div.font-medium').textContent.toLowerCase();
            if (name.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Status filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
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
</script>
@endpush

<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
    
    .animate-fade-out {
        animation: fadeOut 0.3s ease-in;
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
    
    /* Custom pagination styles */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }
    
    .pagination li {
        margin: 0 4px;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid rgba(156, 163, 175, 0.3);
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .pagination .page-link:hover {
        background-color: #e5e7eb;
    }
    
    .pagination .active .page-link {
        background-color: #6366f1;
        color: white;
        border-color: #6366f1;
    }
    
    .pagination .disabled .page-link {
        opacity: 0.5;
        pointer-events: none;
    }
</style>
@endsection