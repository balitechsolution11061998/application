<x-default-layout>
    @section('title')
        Permissions Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('permissions') }}
    @endsection

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.css">

    <div class="card shadow-sm">
        <!-- Card header -->
        <div class="card-header border-0 pt-6 bg-light">
            <div class="card-title d-flex justify-content-between w-100">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5 text-muted"></i>
                    <input type="text" id="search-box"
                        class="form-control form-control-solid form-control-lg w-250px ps-13"
                        placeholder="Search Permissions" />
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addPermissionModal">
                        <i class="fas fa-plus"></i> Add New Permission
                    </button>
                </div>
            </div>
        </div>

        <!-- Card body -->
        <div class="card-body py-4">
            <div class="table-wrapper">
                <table class="table table-striped table-bordered table-hover align-middle fs-6 gy-5"
                    id="permissionsTable">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0 bg-light">
                            <th class="min-w-150px">ID</th>
                            <th class="min-w-150px">Permission Name</th>
                            <th class="min-w-150px">Display Name</th>
                            <th class="min-w-150px">Description</th>
                            <th class="min-w-150px">Created At</th>
                            <th class="min-w-100px text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 fw-semibold">
                        <!-- Data populated by DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Permission Modal -->
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="addPermissionForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPermissionModalLabel">Add New Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permissionName" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="permissionName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="displayName" class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="displayName" name="display_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="permissionDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="permissionDescription" name="description" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Permission Modal -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editPermissionForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editPermissionId">
                        <div class="mb-3">
                            <label for="editPermissionName" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="editPermissionName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDisplayName" class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="editDisplayName" name="display_name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editPermissionDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editPermissionDescription" name="description" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Delete Permission Modal -->
    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermissionModalLabel">Delete Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this permission?</p>
                    <input type="hidden" id="deletePermissionId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.js"></script>
        <script src="{{ asset('js/helpers/datatables.js') }}"></script>

        <script>
     $(document).ready(function() {
    let permissionsTable = $('#permissionsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        ajax: '{{ route('permissions.data') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'display_name', name: 'display_name' },
            { data: 'description', name: 'description' },
            { data: 'created_at', name: 'created_at' },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>`;
                }
            }
        ]
    });

    // Add Permission
    $('#addPermissionForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Add Permission',
            text: "Are you sure you want to add this permission?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('permissions.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addPermissionModal').modal('hide');
                        $('#addPermissionForm')[0].reset(); // Reset the form
                        permissionsTable.ajax.reload();
                        Swal.fire('Added!', 'Permission added successfully!', 'success');
                    },
                    error: function(response) {
                        Swal.fire('Error', 'There was an error adding the permission.', 'error');
                        console.log(response);
                    }
                });
            }
        });
    });

    // Edit Permission
    $('#permissionsTable').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        $.get(`{{ url('permissions') }}/${id}/edit`, function(permission) {
            $('#editPermissionId').val(permission.data.id);
            $('#editPermissionName').val(permission.data.name);
            $('#editDisplayName').val(permission.data.display_name);
            $('#editpermission.dataDescription').val(permission.data.description);
            $('#editPermissionModal').modal('show');
        });
    });

    $('#editPermissionForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editPermissionId').val();
        Swal.fire({
            title: 'Update Permission',
            text: "Are you sure you want to update this permission?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: `{{ url('permissions') }}/${id}`,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editPermissionModal').modal('hide');
                        $('#editPermissionForm')[0].reset(); // Reset the form
                        permissionsTable.ajax.reload();
                        Swal.fire('Updated!', 'Permission updated successfully!', 'success');
                    },
                    error: function(response) {
                        Swal.fire('Error', 'There was an error updating the permission.', 'error');
                        console.log(response);
                    }
                });
            }
        });
    });

    // Delete Permission
    $('#permissionsTable').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Delete Permission',
            text: "Are you sure you want to delete this permission?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: `{{ url('permissions') }}/${id}`,
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        permissionsTable.ajax.reload();
                        Swal.fire('Deleted!', 'Permission deleted successfully!', 'success');
                    },
                    error: function(response) {
                        Swal.fire('Error', 'There was an error deleting the permission.', 'error');
                        console.log(response);
                    }
                });
            }
        });
    });
});

        </script>
    @endpush
</x-default-layout>
