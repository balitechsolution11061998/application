@extends('layouts.master')
@section('title','Purchase Order')
@section('content')
<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1"/>
                            </div>
                        </th>
                        <th>Order No</th>
                        <th class="text-end min-w-100px">Actions</th>
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
            columns: [
                { data: 'id', render: function(data, type, row) {
                    return `
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" value="${data}"/>
                        </div>`;
                }, orderable: false, searchable: false },
                { data: 'order_no' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']], // Default order by Order No
        });
    });
</script>
@endsection
@endsection
