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
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Orders" />
                </div>

            </div>

            <!-- DataTable -->
            <table id="kt_docs_datatable_subtable" class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-100px">Order ID</th>
                        <th class="text-end min-w-100px">Created</th>
                        <th class="text-end min-w-150px">Customer</th>
                        <th class="text-end min-w-100px">Total</th>
                        <th class="text-end min-w-100px">Profit</th>
                        <th class="text-end min-w-50px">Status</th>
                        <th class="text-end"></th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <!-- SubTable Template -->
                    <tr data-kt-docs-datatable-subtable="subtable_template" class="d-none">
                        <td colspan="2">
                            <div class="d-flex align-items-center gap-3">
                                <a href="#" class="symbol symbol-50px bg-secondary bg-opacity-25 rounded">
                                    <img src="/assets/media/stock/ecommerce/" alt="" data-kt-docs-datatable-subtable="template_image" />
                                </a>
                                <div class="d-flex flex-column text-muted">
                                    <a href="#" class="text-gray-900 text-hover-primary fw-bold" data-kt-docs-datatable-subtable="template_name">Product name</a>
                                    <div class="fs-7" data-kt-docs-datatable-subtable="template_description">Product description</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end" data-kt-docs-datatable-subtable="template_cost">Cost</td>
                        <td class="text-end" data-kt-docs-datatable-subtable="template_qty">Qty</td>
                        <td class="text-end" data-kt-docs-datatable-subtable="template_total">Total</td>
                        <td class="text-end" data-kt-docs-datatable-subtable="template_stock">On hand</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Card End -->

    <!-- Include jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables Initialization Script -->
    <script>
        $(document).ready(function() {
            var table = $('#kt_docs_datatable_subtable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('purchase-orders.data') }}',
                columns: [
                    { data: 'order_no', name: 'order_no' },
                    { data: 'written_date', name: 'written_date' },
                    { data: 'supplier', name: 'supplier' },
                    { data: 'total_cost', name: 'total_cost' },
                    { data: 'total_retail', name: 'total_retail' },
                    { data: 'status', name: 'status' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
</x-default-layout>
