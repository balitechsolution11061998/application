<x-default-layout>
    @section('title', 'Edit Role')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('roles.edit', $role) }}
    @endsection

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Edit Role</h5>
        </div>
        <div class="card-body">
            <form id="edit-role-form" action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
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
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
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
                    <i class="fas fa-save"></i> Update Role
                </button>
            </form>
        </div>
    </div>

    <!-- Include SweetAlert and Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#edit-role-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to update this role!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form
                        this.submit();
                    }
                });
            });

            // Display success message using Toastr
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            // Animation on checkbox change
            $('.form-check-input').change(function() {
                const label = $(this).next('label');
                if ($(this).is(':checked')) {
                    label.addClass('checked-animation');
                } else {
                    label.removeClass('checked-animation');
                }
            });
        });
    </script>

    <style>
        /* Add some animation to the button */
        .btn-primary {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade on hover */
            transform: scale(1.05); /* Slightly enlarge the button */
        }

        /* Animation for checkbox label */
        .checked-animation {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-5px);
            }
            60% {
                transform: translateY(-3px);
            }
        }
    </style>
</x-default-layout>
