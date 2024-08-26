<x-default-layout>
    @section('title')
        Brands
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('brands') }}
    @endsection

    @push('styles')
        <!-- DataTables CSS -->
    @endpush

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Edit Brands</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('brands.update', $brand->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="inputTitle" class="form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ $brand->title }}" class="form-control">
                    @error('title')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
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
