<x-default-layout>
    @section('title', 'Members Management')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('members') }}
    @endsection

    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-light mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Members Management</h5>
                        <div>
                            <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-user-plus"></i> Add Member
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" id="search-box" class="form-control" placeholder="Search Members" aria-label="Search Members" />
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                        </div>
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="members_table">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Join Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#members_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('members.data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address' },
                    { data: 'phone', name: 'phone' },
                    { data: 'email', name: 'email' },
                    { data: 'join_date', name: 'join_date' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            // Handle delete button click
            $(document).on('click', '.delete-member', function() {
                var memberId = $(this).data('id');
                var deleteUrl = '{{ route("members.destroy", ":id") }}'.replace(':id', memberId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform the delete action
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // Show success message
                                toastr.success(response.message, 'Success', { timeOut: 5000 });
                                // Reload the DataTable
                                $('#members_table').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                // Show error message
                                toastr.error(xhr.responseJSON.message, 'Error', { timeOut: 5000 });
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</x-default-layout>
