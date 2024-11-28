<x-default-layout>
    @section('title')
        User Profile
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user_profile') }}
    @endsection

    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 animate__animated animate__fadeIn animate__faster">
                    <div class="card-header bg-gradient-primary text-white text-center py-4">
                        <h4 class="mb-0">User Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <!-- Current Profile Picture -->
                            <a href="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('img/background/blank.jpg') }}"
                                data-lightbox="profile-picture" data-title="{{ $user->name }}'s Profile Picture"
                                title="Click to enlarge">
                                <img id="profilePreview"
                                    src="{{ $user->profile_picture ? asset('storage/profile_pictures/' . $user->profile_picture) : asset('img/background/blank.jpg') }}"
                                    alt="{{ $user->name }}'s Profile Picture"
                                    class="rounded-circle img-fluid shadow-lg" width="150" height="150"
                                    style="animation: bounceIn 1.2s;">
                            </a>



                            <!-- Change Profile Picture Button -->
                            <div class="mt-3">
                                <button class="btn btn-sm btn-primary" id="openFileManager">
                                    <i class="fas fa-upload me-2"></i> Choose Profile Picture
                                </button>
                            </div>

                            <!-- Drag-and-Drop Area -->


                            <!-- Hidden Input for File URL -->
                            <input type="hidden" id="profilePicturePath" name="profile_picture">
                        </div>




                        {{-- Profile details --}}
                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-user me-2 text-primary"></i> Name:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">{{ $user->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-envelope me-2 text-primary"></i> Email:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">
                                    <!-- Masked email -->
                                    @php
                                        $email = $user->email;
                                        $emailParts = explode('@', $email);
                                        $maskedEmail =
                                            substr($emailParts[0], 0, 2) .
                                            str_repeat('*', strlen($emailParts[0]) - 2) .
                                            '@' .
                                            $emailParts[1];
                                    @endphp
                                    {{ $maskedEmail }}
                                    <!-- Ubah link -->
                                    {{-- <a href="{{ route('user.email.edit', $user->id) }}" class="text-primary ms-2">Ubah</a> --}}
                                </p>
                            </div>
                        </div>


                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-phone me-2 text-primary"></i> Phone:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2 d-flex align-items-center">
                                    @if ($user->phone_number)
                                        @php
                                            // Format the phone number: Replace leading '0' with '+62' for Indonesian numbers
                                            $formattedPhoneNumber = preg_replace('/^0/', '+62', $user->phone_number);

                                            // Mask the phone number except for the last 2 digits
                                            $maskedPhoneNumber =
                                                str_repeat('*', strlen($formattedPhoneNumber) - 2) .
                                                substr($formattedPhoneNumber, -2);
                                        @endphp
                                        @if (preg_match('/^\+62/', $formattedPhoneNumber))
                                            <!-- Display Indonesian flag -->
                                            <img src="{{ asset('img/flag/indonesia.png') }}" alt="Indonesian Flag"
                                                class="me-2" style="width: 20px; height: 14px; border-radius: 3px;">
                                        @endif
                                        <!-- Display masked phone number -->
                                        {{ $maskedPhoneNumber }}
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </p>
                            </div>
                        </div>



                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-user-tag me-2 text-primary"></i> Roles:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">
                                    @forelse ($user->roles as $role)
                                        <span
                                            class="badge bg-primary text-white rounded-pill d-inline-flex align-items-center me-1 px-3 py-2">
                                            <i class="fas fa-check-circle me-2 text-white"></i>
                                            {{ $role->display_name ?? $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted">No roles assigned</span>
                                    @endforelse
                                </p>
                            </div>
                        </div>

                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-toggle-on me-2 text-success"></i> Status:
                            </label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext border-bottom pb-2">
                                    @if ($user->status == 'y')
                                        <!-- Assuming is_active is the field indicating status -->
                                        <span
                                            class="badge bg-primary text-white rounded-pill d-inline-flex align-items-center px-3 py-2">
                                            <i class="fas fa-check-circle me-2 text-white"></i> Active
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-danger text-white rounded-pill d-inline-flex align-items-center px-3 py-2">
                                            <i class="fas fa-times-circle me-2 text-white"></i> Not Active
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Password Change Section --}}
                        <div class="row mb-4 align-items-center">
                            <label class="col-md-3 fw-bold text-end">
                                <i class="fas fa-lock me-2 text-primary"></i> Password:
                            </label>
                            <div class="col-md-9 position-relative">
                                <input type="password" id="userPassword"
                                    class="form-control form-control-sm border-2 rounded-pill shadow-sm"
                                    value="{{ $user->password_show }}" disabled>
                                <button type="button"
                                    class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-3"
                                    onclick="togglePasswordVisibility('userPassword')">
                                    <i id="passwordIcon" class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                            </a>
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

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered animate__animated animate__zoomIn">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <form id="changePasswordForm" action="{{ route('users.changePassword') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="form-control form-control-sm" id="user_id" name="user_id"
                            value="{{ $user->id }}">

                        <div class="mb-4 position-relative">
                            <label for="current_password" class="form-label text-primary fw-semibold">
                                <i class="fas fa-lock me-2"></i> Current Password
                            </label>
                            <input type="password"
                                class="form-control form-control-sm border-2 rounded-pill shadow-sm"
                                id="current_password" name="current_password" placeholder="Enter current password"
                                value="{{ $user->password_show }}" required>
                            <button type="button"
                                class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePassword('current_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <div class="mb-4 position-relative">
                            <label for="new_password" class="form-label text-primary fw-semibold">
                                <i class="fas fa-unlock-alt me-2"></i> New Password
                            </label>
                            <input type="password"
                                class="form-control form-control-sm border-2 rounded-pill shadow-sm" id="new_password"
                                name="new_password" placeholder="Enter new password" required>
                            <button type="button"
                                class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePassword('new_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                onclick="generatePassword()">
                                <i class="fas fa-random me-1"></i> Generate Password
                            </button>
                        </div>

                        <div class="mb-4 position-relative">
                            <label for="new_password_confirmation" class="form-label text-primary fw-semibold">
                                <i class="fas fa-check-circle me-2"></i> Confirm New Password
                            </label>
                            <input type="password"
                                class="form-control form-control-sm border-2 rounded-pill shadow-sm"
                                id="confirm_password" name="new_password_confirmation"
                                placeholder="Confirm new password" required>
                            <button type="button"
                                class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-4"
                            data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const enableDragDropCheckbox = document.getElementById('enableDragDrop');
                const dragDropArea = document.getElementById('dragDropArea');
                const profilePreview = document.getElementById('profilePreview');
                const profilePicturePath = document.getElementById('profilePicturePath');
                const openFileManagerBtn = document.getElementById('openFileManager');

                // Toggle Drag-and-Drop Visibility
                enableDragDropCheckbox.addEventListener('change', (event) => {
                    if (event.target.checked) {
                        dragDropArea.style.display = 'flex';
                    } else {
                        dragDropArea.style.display = 'none';
                    }
                });

                // Open Laravel File Manager
                openFileManagerBtn.addEventListener('click', () => {
                    window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
                    window.SetUrl = function(url) {
                        profilePreview.src = url; // Update profile preview
                        profilePicturePath.value = url; // Store file path in hidden input
                    };
                });

                // Drag-and-Drop Events
                dragDropArea.addEventListener('dragover', (event) => {
                    event.preventDefault();
                    dragDropArea.style.borderColor = '#28a745'; // Green border on hover
                });

                dragDropArea.addEventListener('dragleave', () => {
                    dragDropArea.style.borderColor = '#007bff'; // Reset to original color
                });

                dragDropArea.addEventListener('drop', (event) => {
                    event.preventDefault();
                    dragDropArea.style.borderColor = '#007bff'; // Reset to original color

                    const file = event.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        uploadFile(file);
                    } else {
                        alert('Please upload a valid image file.');
                    }
                });

                // Handle File Upload and Preview
                function uploadFile(file) {
                    const formData = new FormData();
                    formData.append('file', file);

                    fetch('/laravel-filemanager/upload', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.url) {
                                profilePreview.src = data.url; // Update preview
                                profilePicturePath.value = data.url; // Update hidden input
                            } else {
                                alert('Failed to upload image.');
                            }
                        })
                        .catch(error => console.error('Error uploading file:', error));
                }

                // Click Event for Drag-and-Drop Area to Open File Dialog
                dragDropArea.addEventListener('click', () => {
                    openFileManagerBtn.click();
                });
                // Initialize Lightbox with custom options
                lightbox.option({
                    'resizeDuration': 200, // Smooth resize animation
                    'wrapAround': true, // Enable navigation between images
                    'alwaysShowNavOnTouchDevices': true, // Show navigation on mobile
                    'fadeDuration': 300 // Fade effect duration
                });
            });

            function togglePasswordVisibility(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const passwordIcon = document.getElementById(iconId);
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                } else {
                    passwordInput.type = "password";
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                }
            }
            // Toggle visibility of password fields
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
            }

            // Generate a memorable password
            function generatePassword() {
                const memorableWords = ['sunny', 'river', 'mountain', 'cloud', 'forest', 'ocean', 'stone'];
                const numbers = Math.floor(100 + Math.random() * 900); // Three random numbers
                const password = `${memorableWords[Math.floor(Math.random() * memorableWords.length)]}${numbers}`;
                document.getElementById('new_password').value = password;
                document.getElementById('confirm_password').value = password;
            }


            // Submit the form with SweetAlert confirmation
            document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Toastr configuration
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right', // Toastr position
                    timeOut: 3000, // Duration in milliseconds
                    extendedTimeOut: 1000, // Additional timeout after hover
                    showEasing: 'swing',
                    hideEasing: 'linear',
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut',
                    onHidden: function() {
                        // Reload the page after the toast is hidden
                        window.location.reload();
                    }
                };

                // SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to change the password!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Prepare AJAX submission
                        const form = document.getElementById('changePasswordForm');
                        const formData = new FormData(form);

                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Show success notification
                                    toastr.success(data.message, 'Success');
                                    $('#changePasswordModal').modal('hide'); // Hide the modal
                                    form.reset(); // Reset the form
                                } else if (data.errors) {
                                    // Handle validation errors
                                    for (const field in data.errors) {
                                        data.errors[field].forEach(error => {
                                            toastr.error(error, 'Validation Error');
                                        });
                                    }
                                } else {
                                    // Show generic error message
                                    toastr.error(data.message || 'Something went wrong.', 'Error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                toastr.error('An unexpected error occurred.', 'Error');
                            });
                    }
                });
            });
        </script>
    @endpush
    <!-- Lightbox J S -->

</x-default-layout>
