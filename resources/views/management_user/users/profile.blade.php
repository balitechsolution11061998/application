<x-default-layout>
    @section('title')
        User Profile
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user_profile') }}
    @endsection
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.css">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 animate__animated animate__fadeIn animate__faster">
                    <div class="card-header bg-gradient-primary text-white text-center py-4">
                        <h4 class="mb-0">User Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/profile_pictures/profile_no_pictur.jpg') }}" alt="User Avatar"
                                class="rounded-circle img-fluid shadow-lg" width="150" height="150"
                                style="animation: bounceIn 1.2s;">
                        </div>

                        {{-- Name --}}
                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-user me-2 text-primary"></i> Name:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">{{ $user->name }}</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-envelope me-2 text-primary"></i> Email:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">{{ $user->email }}</p>
                            </div>
                        </div>

                        {{-- Roles --}}
                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-user-tag me-2 text-primary"></i> Roles:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-gradient-primary me-1">{{ $role->name }}</span>
                                    @endforeach
                                </p>
                            </div>
                        </div>



                        {{-- Profile Created On --}}
                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-calendar-check me-2 text-primary"></i> Profile Created On:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">
                                    {{ $user->created_at->format('d M Y') }} ({{ $user->created_at->diffForHumans() }})
                                </p>
                            </div>
                        </div>

                        {{-- Last Updated --}}
                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-clock me-2 text-primary"></i> Last Updated:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">
                                    {{ $user->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        {{-- Button Actions --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
                            {{-- Change Password Button --}}
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                <i class="fas fa-key me-1"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Change Password Modal --}}
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered animate__animated animate__zoomIn">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="changePasswordForm" action="{{ route('management.users.changePassword') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Hidden input for user ID -->
                        <input type="hidden" class="form-control form-control-sm" id="user_id" name="user_id"
                            value="{{ $user->id }}">

                        <!-- Current Password Field -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control form-control-sm" id="current_password"
                                name="current_password" required>
                        </div>

                        <!-- New Password Field -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control form-control-sm" id="new_password"
                                name="new_password" required>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control form-control-sm" id="confirm_password"
                                name="new_password_confirmation" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.js"></script>

    <script>
document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    let formData = new FormData(this);

    // Clear any previous errors
    document.querySelectorAll('.form-control').forEach(function(input) {
        input.classList.remove('is-invalid');
        if (input.nextElementSibling) {
            input.nextElementSibling.textContent = ''; // Clear previous error messages
        }
    });

    fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url; // Manually handle the redirect
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Success handling
                Toastify({
                    text: "Password changed successfully!",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745",
                    stopOnFocus: true
                }).showToast();

                let modalElement = document.getElementById('changePasswordModal');
                let modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();
            } else {
                // Handle validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(function(key) {
                        let input = document.querySelector(`[name="${key}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            if (input.nextElementSibling) {
                                input.nextElementSibling.textContent = data.errors[key][0]; // Show specific error message
                            }
                        }
                    });

                    // Show a specific Toastify message for the new_password error
                    if (data.errors.new_password) {
                        Toastify({
                            text: data.errors.new_password[0], // Display "The new password cannot be the same as the current password."
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#dc3545",
                            stopOnFocus: true
                        }).showToast();
                    } else {
                        // General form error message
                        Toastify({
                            text: "Please correct the errors in the form.",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#dc3545",
                            stopOnFocus: true
                        }).showToast();
                    }
                }
            }
        })
        .catch(error => {
            // General error handling for network/server issues
            Toastify({
                text: "An error occurred. Please try again.",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#dc3545",
                stopOnFocus: true
            }).showToast();
            console.error('Error:', error);
        });
});


    </script>
</x-default-layout>
