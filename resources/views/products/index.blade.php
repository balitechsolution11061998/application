@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Header Section with Gradient Background -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800 rounded-xl p-6 mb-6 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Products Management</h1>
                <p class="text-blue-100 dark:text-blue-200 mt-2">Efficiently manage your product inventory with advanced controls</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('products.create') }}"
                    class="flex items-center px-5 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-600 dark:text-white rounded-lg shadow-md transition-all duration-300">
                    <i class="fas fa-plus-circle mr-2"></i> Add Product
                </a>
                <button id="exportBtn" class="px-4 py-2.5 border border-white dark:border-gray-600 rounded-lg bg-transparent text-white hover:bg-white hover:text-blue-600 dark:hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-file-export mr-2"></i> Export
                </button>
            </div>
        </div>
    </div>

    <!-- Main Card with Glass Morphism Effect -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
        <!-- Filters Section -->
        <div class="p-5 border-b border-gray-200/50 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-700/30">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="relative w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150"
                        placeholder="Search products...">
                </div>
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    <div class="relative flex-1 md:w-48">
                        <select id="statusFilter" class="appearance-none w-full bg-white/50 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-4 py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    <div class="relative flex-1 md:w-48">
                        <select id="companyFilter" class="appearance-none w-full bg-white/50 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-lg px-4 py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    <button id="resetFilters" class="px-4 py-2.5 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        <i class="fas fa-filter-circle-xmark mr-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table id="productsTable" class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-700/50">
                <thead class="bg-gray-50/50 dark:bg-gray-700/30">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">SKU</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white/50 dark:bg-gray-800/30 divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="px-6 py-4 border-t border-gray-200/50 dark:border-gray-700/50 flex flex-col md:flex-row items-center justify-between bg-gray-50/30 dark:bg-gray-700/20">
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 md:mb-0" id="tableInfo">
                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> products
            </div>
            <div class="flex items-center space-x-2" id="pagination">
                <!-- Pagination will be inserted here -->
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
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    /* Pulse animation for loading */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush

@push('scripts')
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
    // Initialize DataTable with server-side processing
    const table = $('#productsTable').DataTable({
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
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 401 || xhr.status === 419) {
                    window.location.reload(); // Session expired, reload page
                } else {
                    showError('Failed to load products data. Please try again.');
                }
            }
        },
        columns: [
            {
                data: 'image_url',
                name: 'image',
                render: function(data, type, row) {
                    return `<div class="relative group">
                        <img src="${data}" alt="${row.name}" 
                            class="w-12 h-12 rounded-lg object-cover shadow-sm cursor-pointer hover:shadow-md transition-all duration-300 quick-view-btn"
                            data-id="${row.id}">
                        <div class="absolute inset-0 bg-black/30 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <i class="fas fa-eye text-white"></i>
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
                    return `<div class="font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 cursor-pointer quick-view-btn" data-id="${row.id}">${data}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">${row.category || 'No category'}</div>`;
                },
                className: 'py-3'
            },
            {
                data: 'sku',
                name: 'sku',
                render: function(data, type, row) {
                    return `<span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-md text-sm font-mono hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">${data}</span>`;
                },
                className: 'py-3'
            },
            {
                data: 'price',
                name: 'price',
                render: function(data, type, row) {
                    const discountBadge = row.discount_price ? 
                        `<span class="absolute -top-2 -right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full animate-bounce">SALE</span>` : '';
                    
                    return `<div class="relative">
                        ${discountBadge}
                        <div class="font-medium">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data)}</div>
                        ${row.discount_price ? `
                        <div class="text-xs text-green-600 dark:text-green-400">
                            <span class="line-through mr-2">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data)}</span>
                            ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(row.discount_price)}
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
                    let stockClass = 'text-green-600 dark:text-green-400';
                    if (data < 10) stockClass = 'text-yellow-600 dark:text-yellow-400';
                    if (data < 5) stockClass = 'text-red-600 dark:text-red-400';

                    const percentage = Math.min(100, (data/row.stock_threshold)*100);
                    const progressColor = percentage < 20 ? 'bg-red-500' : percentage < 50 ? 'bg-yellow-500' : 'bg-green-500';

                    return `<div class="flex items-center">
                        <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mr-2">
                            <div class="h-2.5 rounded-full ${progressColor} transition-all duration-500" style="width: ${percentage}%"></div>
                        </div>
                        <span class="${stockClass} font-medium">${data}</span>
                    </div>`;
                },
                className: 'py-3'
            },
            {
                data: 'company.name',
                name: 'company.name',
                render: function(data, type, row) {
                    return `<div class="flex items-center group">
                        <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2 overflow-hidden transition-transform group-hover:scale-110">
                            ${row.company_logo ? 
                                `<img src="${row.company_logo}" alt="${data}" class="w-full h-full object-cover">` : 
                                `<span class="text-xs font-medium">${data ? data.substring(0, 2).toUpperCase() : 'NA'}</span>`}
                        </div>
                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">${data || 'N/A'}</span>
                    </div>`;
                },
                className: 'py-3'
            },
            {
                data: 'is_active',
                name: 'is_active',
                render: function(data, type, row) {
                    return data ?
                        `<span class="status-badge status-active hover:shadow-md"><i class="fas fa-check-circle"></i> Active</span>` :
                        `<span class="status-badge status-inactive hover:shadow-md"><i class="fas fa-times-circle"></i> Inactive</span>`;
                },
                className: 'py-3'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'py-3'
            }
        ],
        order: [[1, 'asc']],
        dom: '<"flex flex-col md:flex-row md:items-center md:justify-between"<"mb-4"B><"mb-4 md:mb-0"l><"md:ml-4"f>>rt<"flex flex-col md:flex-row items-center justify-between"<"mb-4 md:mb-0"i><"md:ml-4"p>>',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                className: 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition-all hover:shadow-lg',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                className: 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-md transition-all hover:shadow-lg',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print mr-2"></i> Print',
                className: 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition-all hover:shadow-lg',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            }
        ],
        language: {
            processing: '<div class="flex justify-center items-center h-64"><div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div></div>',
            emptyTable: `
            <div class="text-center py-12 fade-in">
                <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Products Found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">We couldn't find any products matching your criteria</p>
                <div class="flex justify-center space-x-3">
                    <button id="resetFiltersEmpty" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all hover:shadow-lg">
                        <i class="fas fa-filter-circle-xmark mr-2"></i> Reset Filters
                    </button>
                    <a href="{{ route('products.create') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all hover:shadow-lg">
                        <i class="fas fa-plus-circle mr-2"></i> Add Product
                    </a>
                </div>
            </div>
            `,
            info: 'Showing _START_ to _END_ of _TOTAL_ products',
            infoEmpty: 'Showing 0 to 0 of 0 products',
            infoFiltered: '(filtered from _MAX_ total products)',
            lengthMenu: 'Show _MENU_ products',
            search: '',
            searchPlaceholder: 'Search products...',
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
            }
        },
        initComplete: function() {
            $('#productsTable_filter input').addClass('form-input rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500');
            $('#productsTable_length select').addClass('form-select rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500');
        },
        drawCallback: function(settings) {
            const api = this.api();
            $('#startRecord').text(api.page.info().start + 1);
            $('#endRecord').text(api.page.info().end);
            $('#totalRecords').text(api.page.info().recordsTotal);
        }
    });

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
@endpush