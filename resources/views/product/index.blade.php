<x-default-layout>
    @section('title')
        Product
    @endsection

    @push('styles')
    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Product Lists</h6>
            <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Product">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="product-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Is Featured</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Size</th>
                            <th>Condition</th>
                            <th>Brand</th>
                            <th>Stock</th>
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
            $('#product-dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('product.data') }}', // Adjust this route to your data fetching route
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category' },
                    {
                        data: 'is_featured',
                        name: 'is_featured',
                        render: function(data) {
                            return data ? '<i class="fas fa-star text-warning"></i>' : '';
                        }
                    },
                    { data: 'price', name: 'price' },
                    {
                        data: 'discount',
                        name: 'discount',
                        render: function(data) {
                            return data + '%';
                        }
                    },
                    { data: 'size', name: 'size' },
                    {
                        data: 'condition',
                        name: 'condition',
                        render: function(data) {
                            return data === 'new' ? '<i class="fas fa-check-circle text-success"></i> New' : '<i class="fas fa-times-circle text-danger"></i> Used';
                        }
                    },
                    { data: 'brand', name: 'brand' },
                    {
                        data: 'stock',
                        name: 'stock',
                        render: function(data) {
                            return data > 0 ? '<i class="fas fa-boxes text-success"></i> In Stock' : '<i class="fas fa-box text-danger"></i> Out of Stock';
                        }
                    },
                      {
                                data: 'photo',
                                name: 'photo'
                            },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            return data === 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
    @endpush
</x-default-layout>
