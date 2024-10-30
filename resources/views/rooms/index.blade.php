<x-default-layout>
    @section('title')
        Rooms Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('rooms') }}
    @endsection

    <!-- Card Start -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Rooms Management</h5>
        </div>
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-4">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Rooms" />
                </div>
                <!--end::Search-->

                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    <!--begin::Add Room-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Add Room
                    </button>
                    <!--end::Add Room-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Datatable-->
            <table id="rooms-table" class="table align-middle table-striped table-hover fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created By</th>
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

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addRoomForm">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                        <div class="mb-3">
                            <label for="name" class="form-label">Room Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables Initialization Script -->
    <script>
        $(document).ready(function() {
            var table = $('#rooms-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('rooms.data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'created_by', name: 'created_by' },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <a href="/rooms/${data}/edit" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/rooms/${data}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
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

            // Add Room Form Submission
            $('#addRoomForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('rooms.store') }}',
                    data: $(this).serialize(),
                    success: function(data) {
                        table.ajax.reload();
                        $('#addRoomModal').modal('hide');
                    }
                });
            });
        });
    </script>
</x-default-layout>
