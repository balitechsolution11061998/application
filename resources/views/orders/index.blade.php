<x-default-layout>
    @section('title')
        Purchase Orders Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection

    <!-- Card Start -->
    <div class="card rounded">
        <div class="card-header">
            <h5 class="card-title">Purchase Orders Management</h5>
        </div>
        <div class="card-body">
            <!-- Search and Toolbar -->
            <div class="d-flex flex-stack mb-4">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"></i>
                    <input type="text" data-kt-docs-table-filter="search"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Orders" />
                </div>

            </div>

            <!-- DataTable -->
            <table id="po_table" class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-100px">...</th>
                        <th class="min-w-100px">ORDER NO</th>
                        <th class="text-end min-w-150px">STORE</th>
                        <th class="text-end min-w-100px">SUPPLIER</th>
                        <th class="text-end min-w-100px">APPROVAL DATE</th>
                        <th class="text-end min-w-100px">EXPIRED DATE</th>
                        <th class="text-end min-w-50px">Status</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <!-- SubTable Template -->

                </tbody>
            </table>
        </div>
    </div>
    <!-- Card End -->

    @push('scripts')
        @foreach (getGlobalAssets() as $path)
            {!! sprintf('<script src="%s"></script>', asset($path)) !!}
        @endforeach
        @foreach (getVendors('js') as $path)
            {!! sprintf('<script src="%s"></script>', asset($path)) !!}
        @endforeach
        <script>
            $(document).ready(function() {
                var table = $('#po_table').DataTable({
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    ajax: '{{ route('purchase-orders.data') }}',
                    columns: [{
                            data: null, // This will hold the buttons
                            orderable: false, // Disable sorting for this column
                            searchable: false, // Disable searching for this column
                            render: function(data, type, row) {
                                return '<button class="btn btn-sm btn-info detail-btn" data-id="' + row
                                    .id + '">' +
                                    '<i class="fas fa-info-circle"></i> Details</button>' +
                                    ' <button class="btn btn-sm btn-success confirm-btn" data-id="' +
                                    row.id + '">' +
                                    '<i class="fas fa-check"></i> Confirmed</button>';
                            }
                        },
                        {
                            data: 'order_no',
                            name: 'order_no'
                        },
                        {
                            data: 'store_name', // Assuming you have store_name in your data
                            name: 'store_name',
                            render: function(data, type, row) {
                                return data + ' (' + row.store +
                                ')'; // Format as store_name(store_code)
                            }
                        },

                        {
                            data: 'supp_name', // Assuming you have supp_name in your data
                            name: 'supp_name',
                            render: function(data, type, row) {
                                // Check if supp_name exists; if not, return the custom message
                                if (!data) {
                                    return 'Tidak ada data supplier, silahkan untuk release supplier terlebih dahulu';
                                }
                                return data + ' (' + row.supp_code +
                                ')'; // Format as supp_name(supp_code)
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'expired_date',
                            name: 'expired_date'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusText = '';
                                let icon = '';

                                // Determine the status class, text, and icon
                                switch (data) {
                                    case 'Confirmed':
                                        statusClass = 'badge badge-light-primary';
                                        statusText = 'Confirmed';
                                        icon = '<i class="fas fa-check-circle"></i>';
                                        break;
                                    case 'Progress':
                                        statusClass = 'badge badge-light-warning';
                                        statusText = 'Progress';
                                        icon = '<i class="fas fa-clock"></i>';
                                        break;
                                    case 'Cancelled':
                                        statusClass = 'badge badge-light-danger';
                                        statusText = 'Cancelled';
                                        icon = '<i class="fas fa-times-circle"></i>';
                                        break;
                                    default:
                                        statusClass = 'badge badge-light-secondary';
                                        statusText = 'Unknown';
                                        icon = '<i class="fas fa-question-circle"></i>';
                                        break;
                                }

                                // Return the status badge
                                return '<span class="' + statusClass + '">' + icon + ' ' + statusText +
                                    '</span>';
                            }
                        }
                    ]
                });

                // Event listener for detail button
                $('#po_table tbody').on('click', '.detail-btn', function() {
                    var orderId = $(this).data('id');
                    // Handle the detail action here, e.g., open a modal with order details
                    console.log('View details for order ID:', orderId);
                });

                // Event listener for confirm button
                $('#po_table tbody').on('click', '.confirm-btn', function() {
                    var orderId = $(this).data('id');
                    // Handle the confirm action here, e.g., send an AJAX request to confirm the order
                    console.log('Confirm order ID:', orderId);
                });
            });
        </script>
    @endpush

</x-default-layout>
