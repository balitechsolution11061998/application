@extends('layouts.master')
@section('title', 'Purchase Order')
@section('content')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title">Purchase Orders</h3>
                        <button id="printButton" class="btn btn-primary">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#kt_datatable_example_1 .form-check-input"
                                                value="1" />
                                        </div>
                                    </th>
                                    <th>Purchase Order</th>
                                    <th>Store</th>
                                    <th>Supplier</th>
                                    <th>Approval Date (PO Date)</th>
                                    <th>Expired Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold" id="purchase-order-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with server-side processing
            $('#kt_datatable_example_1').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                deferRender: true,
                ajax: {
                    url: '/purchase-orders/data', // Adjust the URL as necessary
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        render: function(data) {
                            return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" value="${data}"/>
                            </div>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order_no',
                        render: function(data) {
                            return `
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info" style="padding: 5px 10px; color: #fff;">
                                    <i class="fas fa-file-invoice me-1"></i>
                                    ${data}
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'store_name',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-store me-1" style="color: #000;"></i>
                                <span class="badge bg-primary" style="padding: 5px 10px; color: #fff;">
                                    ${data} (${row.store})
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'supp_code',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-truck me-1" style="color: #000;"></i>
                                <span class="badge bg-primary" style="padding: 5px 10px; color: #fff;">
                                    ${row.supp_name} (${data})
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'approval_date',
                        render: function(data) {
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                locale: 'id-ID'
                            };
                            const date = new Date(data);
                            const formattedDate = date.toLocaleDateString('id-ID', options);

                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-1" style="color: black;"></i>
                                <span class="badge bg-success" style="padding: 5px 10px; color: black;">
                                    ${formattedDate}
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'not_after_date',
                        render: function(data) {
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                locale: 'id-ID'
                            };
                            const date = new Date(data);
                            const formattedDate = date.toLocaleDateString('id-ID', options);

                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-times me-1" style="color: black;"></i>
                                <span class="badge bg-danger" style="padding: 5px 10px; color: black;">
                                    ${formattedDate}
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status',
                        render: function(data, row) {
                            let iconClass, badgeClass, iconColor, noReceivingText = '';

                            // Determine the icon and classes based on the status
                            if (data === 'Completed') {
                                iconClass = 'fas fa-check-circle';
                                badgeClass = 'bg-success';
                                iconColor = 'green';
                                noReceivingText =
                                    ` - No Receiving: ${row.no_receiving}`; // Only show No Receiving for Completed
                            } else if (data === 'Printed') {
                                iconClass = 'fas fa-print';
                                badgeClass = 'bg-success';
                                iconColor = 'green';
                            } else if (data === 'Expired') {
                                iconClass = 'fas fa-print';
                                badgeClass = 'bg-success';
                                iconColor = 'green';
                            } else {
                                iconClass = 'fas fa-clock';
                                badgeClass = 'bg-warning';
                                iconColor = 'orange';
                            }

                            return `
                    <div class="d-flex align-items-center">
                        <i class="${iconClass} me-1" style="color: ${iconColor};"></i>
                        <span class="badge ${badgeClass}" style="padding: 5px 10px; color: #fff;">
                            ${data}${noReceivingText} <!-- Display No Receiving only if Completed -->
                        </span>
                    </div>`;
                        },
                        orderable: false,
                        searchable: true
                    }
                ],
                order: [
                    [1, 'asc']
                ], // Default order by Order No
            });

            // Print functionality
            $('#printButton').on('click', function() {
                window.print();
            });
        });
    </script>
@endsection
@endsection
