<x-default-layout>
    @section('title', 'Roles Management')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('roles') }}
    @endsection

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Roles Management</h5>
            <div class="card-toolbar">
                <a href="{{ route('roles.create') }}" class="btn btn-light">
                    <i class="fas fa-plus"></i> Add Role
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="roles-table" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Name</th>
                        <th>Permissions</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold"></tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('roles.data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        render: function(data) {
                            return data.map(permission => `
                                <span class="badge badge-info me-1 p-2">
                                    <i class="fas fa-check-circle text-white"></i> ${permission}
                                </span>
                            `).join(' ');
                        }
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <a href="/roles/${data}/edit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="/roles/${data}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
    @endpush
    @push('styles')
    <style>
        /* Custom styles for padding and design */
        .card {
            padding: 20px;
        }

        .card-header {
            padding: 15px;
        }

        .table {
            margin-top: 20px;
        }

        .badge {
            margin-right: 5px;
            padding: 5px 10px;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .btn-light {
            background-color: #f8f9fa;
            color: #000;
        }

        .btn-light:hover {
            background-color: #e2e6ea;
        }

        /* New styles for Font Awesome icons */
        .fas {
            padding: 5px; /* Adjust padding as needed */
            margin-right: 5px; /* Space between icon and text */
        }
    </style>
    @endpush

</x-default-layout>
