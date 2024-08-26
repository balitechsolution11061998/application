<x-default-layout>
    @section('title')
        Category
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('category') }}
    @endsection

    @push('styles')
        <!-- DataTables CSS -->
    @endpush

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-start">Brand List</h6>
            <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm " data-bs-toggle="tooltip"
                data-bs-placement="bottom" title="Add Brand">
                <i class="fas fa-plus"></i> Add Brand
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="brand-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#brand-dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('brands.data') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'slug',
                            name: 'slug'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ]
                });
            });
        </script>
    @endpush
</x-default-layout>
