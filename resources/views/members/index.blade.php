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
                            <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm">Add Member</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" id="search-box" class="form-control" placeholder="Search Members" aria-label="Search Members" />
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
                        </div>
                        <table class="table table-striped table-bordered table-hover align-middle fs-6 gy-5" id="members_table">
                            <thead>
                                <tr>
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
        });
    </script>
    @endpush

    <style>
        /* Custom styles for the card and table */
        .card {
            border-radius: 0.5rem;
        }

        .card-header {
            border-bottom: 1px solid #e0e0e0;
        }

        .input-group .form-control {
            border-radius: 0.5rem 0 0 0.5rem;
        }

        .input-group .btn {
            border-radius: 0 0.5rem 0.5rem 0;
        }

        table.dataTable thead th {
            background-color: #f8f9fa;
            color: #495057;
        }

        table.dataTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        table.dataTable tbody tr {
            transition: background-color 0.3s;
        }
    </style>
</x-default-layout>
