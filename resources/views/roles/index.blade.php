<x-default-layout>
    @section('title')
        Roles Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('roles') }}
    @endsection

    <!-- Card Start -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Roles Management</h5>
        </div>
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-4">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Roles" />
                </div>
                <!--end::Search-->

                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="tooltip" title="Coming Soon">
                        <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span class="path2"></span></i>
                        Filter
                    </button>
                    <!--end::Filter-->

                    <!--begin::Add Role-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" title="Add Role">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Add Role
                    </button>
                    <!--end::Add Role-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Datatable-->
            <table id="roles-table" class="table align-middle table-striped table-hover fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Name</th>
                        <th>Permissions</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                </tbody>
            </table>
            <!--end::Datatable-->
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
            var table = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('roles.data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        render: function(data) {
                            return data.map(p => `<span class="badge bg-info">${p.name}</span>`).join(' ');
                        }
                    },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <a href="/roles/${data}/edit" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/roles/${data}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            `;
                        }
                    }
                ]
            });

            // Custom search input integration
            $('input[data-kt-docs-table-filter="search"]').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</x-default-layout>
