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
                    ajax: '{{ route('purchase-orders.data') }}',
                    columns: [{
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusText = '';
                                let icon = '';

                                switch (data) {
                                    case 'Confirmed':
                                        statusClass = 'badge badge-light-primary';
                                        statusText = 'Confirmed';
                                        icon = '<i class="fas fa-check-circle"></i>';
                                        break;
                                    case 'Pending':
                                        statusClass = 'badge badge-light-warning';
                                        statusText = 'Pending';
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

                                // Add buttons for "Detail" and "Confirmed" next to the status
                                return '<span class="' + statusClass + '">' + icon + ' ' + statusText +
                                    '</span>' +
                                    ' <button class="btn btn-sm btn-info detail-btn" data-id="' + row
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
                            data: 'written_date',
                            name: 'written_date'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
                        },
                        {
                            data: 'total_cost',
                            name: 'total_cost'
                        },

                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusText = '';
                                let icon = '';

                                switch (data) {
                                    case 'Confirmed':
                                        statusClass = 'badge badge-light-primary';
                                        statusText = 'Confirmed';
                                        icon = '<i class="fas fa-check-circle"></i>';
                                        break;
                                    case 'Pending':
                                        statusClass = 'badge badge-light-warning';
                                        statusText = 'Pending';
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

                                return '<span class="' + statusClass + '">' + icon + ' ' + statusText +
                                    '</span>';
                            }
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    @endpush

</x-default-layout>
