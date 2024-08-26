<x-default-layout>
    @section('title')
        Banner
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('banner') }}
    @endsection

    @push('styles')
        <!-- DataTables CSS -->
    @endpush

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">Banners List</h6>
            <a href="{{ route('banner.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                data-bs-placement="bottom" title="Add Banner">
                <i class="fas fa-plus"></i> Add Banner
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="banner-dataTable" width="100%"
                    cellspacing="0">
                    <thead class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Photo</th>
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
                $('#banner-dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('banner.data') }}",
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
                            data: 'photo',
                            name: 'photo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
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
