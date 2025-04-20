@extends('pos.index')

@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Products Management</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Efficiently manage your product inventory with advanced controls</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('product.create') }}"
                class="flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-lg shadow-md transition-all duration-300">
                <i class="fas fa-plus-circle mr-2"></i> Add Product
            </a>
            <button id="exportBtn" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                <i class="fas fa-file-export mr-2"></i> Export
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Filters Section -->
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="relative w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150"
                        placeholder="Search products...">
                </div>
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    <div class="relative flex-1 md:w-48">
                        <select id="statusFilter" class="appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    <div class="relative flex-1 md:w-48">
                        <select id="companyFilter" class="appearance-none w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 pr-8 text-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition duration-150">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    <button id="resetFilters" class="px-4 py-2.5 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition-colors duration-200">
                        <i class="fas fa-filter-circle-xmark mr-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table id="productsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
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
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col md:flex-row items-center justify-between bg-gray-50 dark:bg-gray-700/30">
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 md:mb-0" id="tableInfo">
                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> products
            </div>
            <div class="flex items-center space-x-2" id="pagination">
                <!-- Pagination will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-t-xl sm:rounded-t-none sm:rounded-b-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" id="closeModal" class="bg-white dark:bg-gray-700 rounded-md text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times h-6 w-6"></i>
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-2xl leading-6 font-bold text-gray-900 dark:text-white pb-2 border-b border-gray-200 dark:border-gray-700" id="modalTitle">
                            Product Details
                        </h3>
                        <div class="mt-6" id="modalContent">
                            <!-- Content will be loaded via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-xl">
                <button type="button" id="printModal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
                <button type="button" id="closeModalBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    <i class="fas fa-times mr-2"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick View Panel (Slide-over) -->
<div id="quickViewPanel" class="fixed inset-y-0 right-0 z-40 w-full max-w-md transform transition-transform duration-300 translate-x-full bg-white dark:bg-gray-800 shadow-xl">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick View</h3>
        <button id="closeQuickView" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
            <i class="fas fa-times h-6 w-6"></i>
        </button>
    </div>
    <div class="p-6 overflow-y-auto h-[calc(100%-65px)]" id="quickViewContent">
        <!-- Content will be loaded here -->
    </div>
</div>
<div id="quickViewOverlay" class="fixed inset-0 z-30 bg-black bg-opacity-50 hidden"></div>
@endsection


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
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    .dark ::-webkit-scrollbar-track {
        background: #374151;
    }

    .dark ::-webkit-scrollbar-thumb {
        background: #6b7280;
    }

    /* Table row hover effect */
    #productsTable tbody tr {
        transition: all 0.2s ease;
    }

    #productsTable tbody tr:hover {
        background-color: #f8fafc;
    }

    .dark #productsTable tbody tr:hover {
        background-color: #1f2937;
    }

    /* Status badges */
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .dark .status-active {
        background-color: #14532d;
        color: #bbf7d0;
    }

    .dark .status-inactive {
        background-color: #7f1d1d;
        color: #fecaca;
    }

    /* Quick view panel animation */
    .quick-view-transition {
        transition: transform 0.3s ease-out;
    }
</style>

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
                url: "{{ route('product.data') }}",
                type: "GET",
                data: function(d) {
                    d.status = $('#statusFilter').val();
                    d.company = $('#companyFilter').val();
                }
            },
            columns: [{
                    data: 'image',
                    name: 'image',
                    render: function(data, type, row) {
                        return `<img src="${row.image_url}" alt="${row.name}" 
            class="w-12 h-12 rounded-lg object-cover shadow-sm cursor-pointer hover:shadow-md transition-shadow duration-200 quick-view-btn"
            data-id="${row.id}">`;
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
                        return `<span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-md text-sm font-mono">${data}</span>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'price',
                    name: 'price',
                    render: function(data, type, row) {
                        return `<div class="font-medium">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data)}</div>
                            <div class="text-xs ${row.discount_price ? 'text-green-600 dark:text-green-400' : 'text-gray-400'}">
                                ${row.discount_price ? 'Discounted: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(row.discount_price) : ''}
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

                        return `<div class="flex items-center">
                                <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mr-2">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: ${Math.min(100, (data/row.stock_threshold)*100)}%"></div>
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
                        return `<div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2 overflow-hidden">
                                    ${row.company_logo ? 
                                        `<img src="${row.company_logo}" alt="${data}" class="w-full h-full object-cover">` : 
                                        `<span class="text-xs font-medium">${data.substring(0, 2).toUpperCase()}</span>`}
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">${data}</span>
                            </div>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    render: function(data, type, row) {
                        return data ?
                            `<span class="status-badge status-active"><i class="fas fa-check-circle mr-1"></i> Active</span>` :
                            `<span class="status-badge status-inactive"><i class="fas fa-times-circle mr-1"></i> Inactive</span>`;
                    },
                    className: 'py-3'
                },
                {
                    data: 'id',
                    name: 'actions',
                    render: function(data, type, row) {
                        return `
                        <div class="flex justify-end space-x-2">
                            <button class="quick-view-btn p-2 text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 rounded-full hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors duration-200" 
                                    data-id="${data}" 
                                    title="Quick View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="/products/${data}/edit" 
                               class="p-2 text-green-600 hover:text-green-800 dark:hover:text-green-400 rounded-full hover:bg-green-50 dark:hover:bg-green-900/30 transition-colors duration-200"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/products/${data}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="delete-btn p-2 text-red-600 hover:text-red-800 dark:hover:text-red-400 rounded-full hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors duration-200"
                                        title="Delete"
                                        data-id="${data}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <form action="/products/${data}/toggle-status" method="POST" class="inline toggle-form">
                                @csrf
                                <button type="button" 
                                        class="toggle-status-btn p-2 ${row.is_active ? 'text-yellow-600 hover:text-yellow-800 dark:hover:text-yellow-400' : 'text-purple-600 hover:text-purple-800 dark:hover:text-purple-400'} rounded-full ${row.is_active ? 'hover:bg-yellow-50 dark:hover:bg-yellow-900/30' : 'hover:bg-purple-50 dark:hover:bg-purple-900/30'} transition-colors duration-200"
                                        title="${row.is_active ? 'Deactivate' : 'Activate'}"
                                        data-id="${data}">
                                    <i class="fas ${row.is_active ? 'fa-toggle-on' : 'fa-toggle-off'}"></i>
                                </button>
                            </form>
                        </div>
                    `;
                    },
                    orderable: false,
                    searchable: false,
                    className: 'py-3'
                }
            ],
            order: [
                [1, 'asc']
            ],
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between"<"mb-4"B><"mb-4 md:mb-0"l><"md:ml-4"f>>rt<"flex flex-col md:flex-row items-center justify-between"<"mb-4 md:mb-0"i><"md:ml-4"p>>',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                    className: 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6] // Exclude image and actions columns
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    className: 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow-md transition-colors duration-200',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6] // Exclude image and actions columns
                    }
                },
            ],
            language: {
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
                },
                processing: '<div class="flex justify-center items-center h-64"><div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div></div>',
                emptyTable: `
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Products Found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">We couldn't find any products matching your criteria</p>
                    <div class="flex justify-center space-x-3">
                        <button id="resetFiltersEmpty" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-filter-circle-xmark mr-2"></i> Reset Filters
                        </button>
                        <a href="{{ route('product.create') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-plus-circle mr-2"></i> Add Product
                        </a>
                    </div>
                </div>
            `,
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
        $('#resetFilters').click(function() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            $('#companyFilter').val('');
            table.search('').draw();
            table.ajax.reload();
        });

        // Export button
        $('#exportBtn').click(function() {
            $('.buttons-excel').click();
        });

        // View modal (detailed view)
        $(document).on('click', '.view-btn', function() {
            const productId = $(this).data('id');
            $.get(`/products/${productId}/detail`, function(data) {
                $('#modalTitle').text(data.name);
                $('#modalContent').html(`
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="col-span-1">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 flex items-center justify-center h-64">
                            <img src="${data.image_url}" alt="${data.name}" class="max-h-full max-w-full object-contain rounded-lg shadow-md">
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 text-center">
                                <div class="text-blue-600 dark:text-blue-400 text-sm font-medium">SKU</div>
                                <div class="mt-1 text-gray-900 dark:text-white font-mono">${data.sku}</div>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3 text-center">
                                <div class="text-purple-600 dark:text-purple-400 text-sm font-medium">UPC</div>
                                <div class="mt-1 text-gray-900 dark:text-white font-mono">${data.upc || 'N/A'}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h4>
                                <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                    ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.price)}
                                </p>
                                ${data.discount_price ? `
                                <p class="text-sm text-green-600 dark:text-green-400">
                                    <span class="line-through mr-2">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.price)}</span>
                                    ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.discount_price)}
                                </p>
                                ` : ''}
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h4>
                                <p class="mt-1 text-2xl font-bold ${data.stock < 5 ? 'text-red-600 dark:text-red-400' : data.stock < 10 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400'}">
                                    ${data.stock}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Threshold: ${data.stock_threshold}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Company</h4>
                                <div class="mt-1 flex items-center">
                                    ${data.company.logo ? `
                                    <img src="${data.company.logo_url}" alt="${data.company.name}" class="w-8 h-8 rounded-full mr-2 object-cover">
                                    ` : `
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2">
                                        <span class="text-xs font-medium">${data.company.name.substring(0, 2).toUpperCase()}</span>
                                    </div>
                                    `}
                                    <span class="text-gray-900 dark:text-white">${data.company.name}</span>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h4>
                                <p class="mt-1">
                                    ${data.is_active ? 
                                        '<span class="status-badge status-active"><i class="fas fa-check-circle mr-1"></i> Active</span>' : 
                                        '<span class="status-badge status-inactive"><i class="fas fa-times-circle mr-1"></i> Inactive</span>'}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h4>
                            <div class="mt-2 prose dark:prose-invert max-w-none">
                                ${data.description ? data.description.replace(/\n/g, '<br>') : '<p class="text-gray-400 italic">No description available</p>'}
                            </div>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</h4>
                                <p class="mt-1 text-gray-900 dark:text-white">${new Date(data.created_at).toLocaleString()}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h4>
                                <p class="mt-1 text-gray-900 dark:text-white">${new Date(data.updated_at).toLocaleString()}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `);
                $('#viewModal').removeClass('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });

        // Quick view panel (slide-over)
        // Quick view panel (slide-over)
        $(document).on('click', '.quick-view-btn', function() {
            const productId = $(this).data('id');
            // Ambil data langsung dari row DataTable yang sudah dimuat
            const rowData = table.row($(this).closest('tr')).data();

            if (rowData) {
                $('#quickViewContent').html(`
            <div class="space-y-6">
                <div class="flex justify-center">
                    <img src="${rowData.image_url}" alt="${rowData.name}" class="h-48 object-contain rounded-lg shadow-md">
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
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Stock</p>
                        <p class="font-medium ${rowData.stock < 5 ? 'text-red-600 dark:text-red-400' : rowData.stock < 10 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400'}">
                            ${rowData.stock}
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
                
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex space-x-3">
                        <a href="/products/${rowData.id}/edit" 
                           class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <form action="/products/${rowData.id}/toggle-status" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white ${rowData.is_active ? 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500' : 'bg-purple-600 hover:bg-purple-700 focus:ring-purple-500'} focus:outline-none focus:ring-2 focus:ring-offset-2">
                                <i class="fas ${rowData.is_active ? 'fa-toggle-on' : 'fa-toggle-off'} mr-2"></i> ${rowData.is_active ? 'Deactivate' : 'Activate'}
                            </button>
                        </form>
                    </div>
                    <form action="/products/${rowData.id}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
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

        // Close modal
        $('#closeModal, #closeModalBtn').click(function() {
            $('#viewModal').addClass('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        // Close quick view
        $('#closeQuickView, #quickViewOverlay').click(function() {
            $('#quickViewPanel').addClass('translate-x-full');
            $('#quickViewOverlay').addClass('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        // Print modal
        $('#printModal').click(function() {
            const printContent = `
            <html>
                <head>
                    <title>Product Details: ${$('#modalTitle').text()}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        h1 { color: #111827; font-size: 24px; margin-bottom: 10px; }
                        .grid { display: grid; gap: 20px; }
                        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                        .bg-gray-100 { background-color: #f3f4f6; padding: 15px; border-radius: 8px; }
                        .text-sm { font-size: 14px; }
                        .text-xs { font-size: 12px; }
                        .font-medium { font-weight: 500; }
                        .font-bold { font-weight: 700; }
                        .text-gray-500 { color: #6b7280; }
                        .text-gray-900 { color: #111827; }
                        .text-blue-600 { color: #2563eb; }
                        .text-green-600 { color: #16a34a; }
                        .text-red-600 { color: #dc2626; }
                        .text-yellow-600 { color: #ca8a04; }
                        .text-purple-600 { color: #9333ea; }
                        .mt-1 { margin-top: 4px; }
                        .mt-2 { margin-top: 8px; }
                        .mt-4 { margin-top: 16px; }
                        .mt-6 { margin-top: 24px; }
                        .rounded-lg { border-radius: 8px; }
                        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
                        .max-w-full { max-width: 100%; }
                        .max-h-full { max-height: 100%; }
                        .object-contain { object-fit: contain; }
                        .flex { display: flex; }
                        .items-center { align-items: center; }
                        .justify-center { justify-content: center; }
                        .mr-2 { margin-right: 8px; }
                        .p-3 { padding: 12px; }
                        .text-center { text-align: center; }
                        .border-t { border-top: 1px solid #e5e7eb; }
                        .pt-4 { padding-top: 16px; }
                        .space-y-6 > * + * { margin-top: 24px; }
                        .space-x-3 > * + * { margin-left: 12px; }
                        .status-badge { display: inline-flex; align-items: center; font-size: 12px; padding: 4px 8px; border-radius: 9999px; }
                        .status-active { background-color: #dcfce7; color: #166534; }
                        .status-inactive { background-color: #fee2e2; color: #991b1b; }
                        .line-through { text-decoration: line-through; }
                        .italic { font-style: italic; }
                    </style>
                </head>
                <body>
                    <h1>Product Details: ${$('#modalTitle').text()}</h1>
                    ${$('#modalContent').html()}
                    <div class="text-xs text-gray-500 mt-8 text-center">
                        Printed on ${new Date().toLocaleString()} from {{ config('app.name') }}
                    </div>
                </body>
            </html>
        `;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        });
    });
</script>