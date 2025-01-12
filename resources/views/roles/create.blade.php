<x-default-layout>
    @section('title', 'Create Role')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('roles.create') }}
    @endsection

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Create Role</h5>
        </div>
        <div class="card-body">
            <form id="create-role-form" action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Permissions</label>
                    @php
                        // Group permissions by their prefix
                        $groupedPermissions = [];
                        foreach ($permissions as $permission) {
                            // Extract the prefix (e.g., "user" from "user-show")
                            $prefix = explode('-', $permission->name)[0];
                            $groupedPermissions[$prefix][] = $permission;
                        }
                    @endphp

                    @foreach($groupedPermissions as $prefix => $perms)
                        <div class="mb-3">
                            <h6 class="mt-3">{{ ucfirst($prefix) }}</h6> <!-- Display category name -->
                            <div class="form-check">
                                @foreach($perms as $permission)
                                    <div class="form-check form-check-inline mb-2">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}">
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Create Role
                </button>
            </form>
        </div>
    </div>

    <!-- Include SweetAlert and Toastr -->
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#create-role-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to create this role!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form via AJAX
                        $.ajax({
                            url: $(this).attr('action'), // Get the form action URL
                            type: 'POST',
                            data: $(this).serialize(), // Serialize the form data
                            success: function(response) {
                                // Show success message using Toastr
                                toastr.success(response.message);
                                // Redirect to roles index
                                window.location.href = "{{ route('roles.index') }}"; // Redirect to roles index
                            },
                            error: function(xhr) {
                                // Handle validation errors
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        toastr.error(value[0]); // Show the first error message
                                    });
                                } else {
                                    // Show general error message
                                    toastr.error(xhr.responseJSON.message || 'An error occurred while creating the role. Please try again.');
                                }
                            }
                        });
                    }
                });
            });

            // Display success message using Toastr
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            // Display error message using Toastr
            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>
    @endpush


    @push('styles')
    <style>
        /* Add some animation to the button */
        .btn-primary {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade on hover */
            transform: scale(1.05); /* Slightly enlarge the button */
        }
    </style>
    @endpush
</x-default-layout>
