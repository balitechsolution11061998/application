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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">Categories List</h6>
            <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                data-bs-placement="bottom" title="Add Category">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="category-dataTable" width="100%"
                    cellspacing="0">
                    <thead class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Is Parent</th>
                            <th>Parent Category</th>
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
                $('#category-dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('category.data') }}",
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'title', name: 'title' },
                        { data: 'slug', name: 'slug' },
                        { data: 'is_parent', name: 'is_parent' },
                        { data: 'parent_id', name: 'parent_id' },
                        { data: 'photo', name: 'photo', orderable: false, searchable: false },
                        { data: 'status', name: 'status', orderable: false, searchable: false },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ],
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    pageLength: 10,
                    order: [[0, 'desc']]
                });
            });
        </script>
    @endpush
</x-default-layout>
