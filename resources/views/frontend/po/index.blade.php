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
                    </div>
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
                                <th>Order No</th>
                                <th>Store</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold" id="purchase-order-body">
                        </tbody>
                    </table>
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
                ajax: {
                    url: '/purchase-orders/data', // Adjust the URL as necessary
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row) {
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
                        render: function(data, type, row) {
                            // Create a badge for the order number
                            return `
                            <span class="badge bg-info" style="padding: 5px 10px; color: #fff;">
                                <i class="fas fa-file-invoice" style="margin-right: 5px;"></i>
                                ${data}
                            </span>
                        `;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'store_name',
                        render: function(data, type, row) {
                            // Create a badge with padding and Font Awesome icon for store name
                            return `
                            <div style="padding: 5px; display: flex; align-items: center;">
                                <i class="fas fa-store" style="margin-right: 5px; color: #fff;"></i>
                                <span class="badge bg-primary" style="padding: 5px 10px; color: #fff;">
                                    ${data} (${row.store})
                                </span>
                            </div>
                        `;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'supp_code',
                        render: function(data, type, row) {
                            // Create a badge with padding and a different Font Awesome icon for supplier
                            return `
                <div style="padding: 5px; display: flex; align-items: center;">
                    <i class="fas fa-truck" style="margin-right: 5px; color: #fff;"></i> <!-- Changed icon to truck -->
                    <span class="badge bg-primary" style="padding: 5px 10px; color: #fff;">
                       ${row.supp_name} (${data})
                    </span>
                </div>
            `;
                        },
                        orderable: false,
                        searchable: true
                    }
                ],
                order: [
                    [1, 'asc']
                ], // Default order by Order No
            });
        });
    </script>
@endsection
@endsection
