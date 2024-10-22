<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    #drop-zone {
        border: 2px dashed #6c757d;
        padding: 40px;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    #drop-zone:hover {
        border-color: #007bff;
    }

    #preview-container {
        border: 1px solid #ddd;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
        height: 250px;
    }

    #loading-spinner {
        font-size: 3rem;
    }

    #image-preview {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Dropzone Hover Effect */
    #drop-zone:hover {
        border-color: #007bff;
        background-color: #f0f8ff;
        transform: scale(1.02);
    }

    /* Upload Progress Bar Styling */
    .progress-bar.bg-gradient {
        background-image: linear-gradient(to right, #007bff, #00c6ff);
        transition: width 0.4s ease;
    }
</style>
<div class="col-12">
    <div class="card shadow-lg p-4 mb-5 bg-white rounded-4 w-100">
        <div class="card-header bg-primary text-white rounded-top-4 p-4">
            <h4 class="mb-0 fw-bold">User Information Form</h4>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <input type="hidden" name="id" id="id" value="{{ $user->id ?? '' }}">

                <!-- Drag and Drop File Upload -->
                <!-- Drag and Drop File Upload -->
                <div class="col-md-12 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Upload File</label>
                        <div id="drop-zone"
                            class="border border-secondary rounded-3 shadow-lg p-4 text-center bg-light position-relative"
                            style="cursor: pointer; transition: all 0.3s ease; border-style: dashed;"
                            ondragover="event.preventDefault()" ondrop="handleFileDrop(event)"
                            onclick="triggerFileInput()">
                            <i class="fas fa-upload fa-3x text-primary mb-3"></i>
                            <p class="text-muted fw-bold">Drag & drop an image here or <span class="text-primary">click
                                    to upload</span></p>
                            <input type="file" id="fileInput" name="file" class="d-none" accept="image/*"
                                onchange="handleFileSelect(event)" />
                        </div>
                        <div class="mt-3" id="file-info" style="display: none;">
                            <p class="text-success fw-bold">File selected: <span id="file-name"></span></p>
                        </div>
                    </div>
                </div>

                <!-- Image Preview Section -->
                <div class="col-md-12 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Image Preview</label>
                        <div id="preview-container"
                            class="d-flex align-items-center justify-content-center border border-secondary rounded-3 p-3 bg-light shadow-sm"
                            style="height: 250px; overflow: hidden;">
                            <i class="fas fa-spinner fa-spin fa-3x text-muted" id="loading-spinner"
                                style="display: none;"></i>
                            <img id="image-preview" src="" alt="Uploaded Image" class="img-fluid d-none"
                                style="max-height: 100%; max-width: 100%;" />
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="col-md-12 mb-4">
                    <div class="progress"
                        style="height: 30px; border-radius: 20px; overflow: hidden; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);">
                        <div id="upload-progress"
                            class="progress-bar progress-bar-striped progress-bar-animated bg-gradient"
                            role="progressbar" style="width: 0%; transition: width 0.4s ease;" aria-valuenow="0"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>


                <!-- Progress Bar -->
                <div class="col-md-12 mb-4">
                    <div class="progress">
                        <div id="upload-progress" class="progress-bar" role="progressbar" style="width: 0%;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>


                <!-- Username Field -->
                <div class="col-md-6 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Username</label>
                        <input type="text"
                            class="form-control form-control-solid form-control-lg border border-secondary rounded-3 shadow-sm"
                            id="username_add" name="username_add" placeholder="Enter your username"
                            value="{{ $user->username ?? '' }}" />
                    </div>
                </div>

                <!-- Name Field -->
                <div class="col-md-6 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Name</label>
                        <input type="text"
                            class="form-control form-control-solid form-control-lg border border-secondary rounded-3 shadow-sm"
                            id="name" name="name" placeholder="Enter your name"
                            value="{{ $user->name ?? '' }}" />
                    </div>
                </div>

                <!-- Email Field -->
                <div class="col-md-6 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Email</label>
                        <input type="email"
                            class="form-control form-control-solid form-control-lg border border-secondary rounded-3 shadow-sm"
                            id="email_add" name="email_add" placeholder="Enter your email"
                            value="{{ $user->email ?? '' }}" />
                    </div>
                </div>

                <!-- Phone Number Field -->
                <div class="col-md-6 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Phone Number</label>
                        <input type="tel"
                            class="form-control form-control-solid form-control-lg border border-secondary rounded-3 shadow-sm"
                            id="phone" name="phone" placeholder="Enter your phone number"
                            value="{{ $user->phone_number ?? '' }}" />
                    </div>
                </div>

                <!-- Region Field -->
                <div class="col-md-6 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Region</label>
                        <select class="form-select form-control-lg border border-secondary rounded-3 shadow-sm"
                            id="region" name="region_id" data-control="select2"
                            data-placeholder="Select an option">
                            <option value="">Select your region</option>
                            <!-- Options will be populated dynamically by JavaScript -->
                        </select>
                    </div>
                </div>

                <!-- Role Field -->
                <div class="col-md-6 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Role</label>
                        <select class="form-select form-control-lg border border-secondary rounded-3 shadow-sm"
                            id="roles" name="roles" data-control="select2"
                            data-placeholder="Select an option">
                            <option value="">Select a role</option>
                            <!-- Options will be populated dynamically by JavaScript -->
                        </select>
                    </div>
                </div>

                <!-- Password and Confirmation Fields -->
                <div class="col-md-6 mb-4">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Password</label>
                        <div class="input-group">
                            <input type="password" id="password"
                                class="form-control form-control-solid form-control-lg border border-secondary rounded-3 shadow-sm"
                                name="password" placeholder="Enter your password" />
                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                <i class="fas fa-eye" id="toggle-icon"></i>
                            </button>
                        </div>
                        <div class="progress mt-2" id="password-strength-bar" style="height: 8px;">
                            <div id="password-strength" class="progress-bar bg-success" role="progressbar"
                                style="width: 0%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6 mb-4" id="confirmPasswordField" style="display: none;">
                    <div class="form-group w-100">
                        <label class="form-label fw-bold text-dark mb-2">Confirm Password</label>
                        <input type="password" id="confirmPassword"
                            class="form-control form-control-solid form-control-lg border border-secondary rounded-3 shadow-sm"
                            name="password_confirmation" placeholder="Confirm your password" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-12 d-flex justify-content-center">
                    <button type="button" class="btn btn-primary btn-lg shadow-sm rounded-pill px-5 py-2"
                        onclick="saveUser()">
                        <i class="fas fa-save me-2"></i>Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- JavaScript to toggle password visibility and strength -->
<script>
    // Trigger file input when drop zone is clicked
    function triggerFileInput() {
        document.getElementById('fileInput').click();
    }

    // Handle file drop event
    function handleFileDrop(event) {
        event.preventDefault();
        const file = event.dataTransfer.files[0];
        handleFileUpload(file);
    }

    // Handle file select event
    function handleFileSelect(event) {
        const file = event.target.files[0];
        handleFileUpload(file);
    }

    // Handle file upload and display preview
    function handleFileUpload(file) {
        if (file && file.type.startsWith('image/')) {
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-info').style.display = 'block';

            // Show loading spinner and hide the preview until the image is loaded
            document.getElementById('loading-spinner').style.display = 'block';
            document.getElementById('image-preview').classList.add('d-none');

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('loading-spinner').style.display = 'none';
                document.getElementById('image-preview').classList.remove('d-none');
            };
            reader.readAsDataURL(file);

            // Simulate file upload with a progress bar
            uploadFileWithProgress(file);
        }
    }

    // Simulate file upload with progress bar
    function uploadFileWithProgress(file) {
        const progressBar = document.getElementById('upload-progress');
        const xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                progressBar.style.width = percentComplete + '%';
                progressBar.setAttribute('aria-valuenow', percentComplete);
            }
        });

        xhr.addEventListener('load', function() {
            if (xhr.status === 200) {
                // Upload complete
                console.log('Upload complete');
            } else {
                console.error('Upload failed');
            }
        });

        xhr.addEventListener('error', function() {
            console.error('Upload error');
        });

        xhr.open('POST', '/upload-profile-picture'); // Replace with your actual upload URL
        const formData = new FormData();
        formData.append('file', file);
        xhr.send(formData);
    }




    document.getElementById('toggle-password').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('toggle-icon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });

    // Show Confirm Password field and progress bar only if password is changed
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirmPasswordField');
    const passwordStrengthBar = document.getElementById('password-strength-bar');
    const passwordStrength = document.getElementById('password-strength');

    passwordField.addEventListener('input', function() {
        const passwordValue = passwordField.value;
        if (passwordValue) {
            confirmPasswordField.style.display = 'block'; // Show confirm password field
            passwordStrengthBar.style.display = 'block'; // Show progress bar
            updatePasswordStrength(passwordValue);
        } else {
            confirmPasswordField.style.display = 'none'; // Hide confirm password field
            passwordStrengthBar.style.display = 'none'; // Hide progress bar
            passwordStrength.style.width = '0%';
        }
    });

    // Password Strength Validation
    function updatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength += 20;
        if (/[A-Z]/.test(password)) strength += 20;
        if (/[a-z]/.test(password)) strength += 20;
        if (/[0-9]/.test(password)) strength += 20;
        if (/[\W_]/.test(password)) strength += 20;

        passwordStrength.style.width = strength + '%';

        if (strength < 40) {
            passwordStrength.classList.add('bg-danger');
            passwordStrength.classList.remove('bg-warning', 'bg-success');
        } else if (strength < 80) {
            passwordStrength.classList.add('bg-warning');
            passwordStrength.classList.remove('bg-danger', 'bg-success');
        } else {
            passwordStrength.classList.add('bg-success');
            passwordStrength.classList.remove('bg-danger', 'bg-warning');
        }
    }

    // Add jQuery click event for saving user details


    document.addEventListener("DOMContentLoaded", function() {
        fetchRegions();
        fetchRoles();

        $('#roles').select2({
            placeholder: "Select an option",
            allowClear: true // Allows clearing of the selection
        });
    });

    // Function to fetch regions and set the current user's region
    function fetchRegions() {
        fetch("/regions/data") // Update the URL to your API endpoint
            .then((response) => response.json())
            .then((data) => {
                const regionSelect = document.getElementById("region");
                const userRegionId =
                    "{{ $user->region_id ?? '' }}"; // Get user's region ID or default to an empty string
                regionSelect.innerHTML = '<option value="">Select Region</option>'; // Reset options

                data.forEach((region) => {
                    const option = document.createElement("option");
                    option.value = region.id;
                    option.textContent = region.name;

                    if (region.id == userRegionId) {
                        option.selected = true; // Preselect the user's region
                    }

                    regionSelect.appendChild(option);
                });
            })
            .catch((error) => console.error("Error fetching regions:", error));
    }

    // Function to fetch roles and set the current user's role
    function fetchRoles() {
        $.ajax({
            url: "/roles/getRoles", // Ensure this matches the route defined
            method: "GET",
            success: function(response) {
                const rolesSelect = $("#roles");

                const userRoles = @json($user ? $user->roles->pluck('id') : []);

                rolesSelect.empty(); // Clear existing options
                rolesSelect.append('<option value="">Select roles</option>'); // Add default option

                response.forEach(function(role) {
                    const option = new Option(role.name, role.id);

                    // Check if the role ID is in the user's roles
                    if (userRoles.includes(role.id)) {
                        option.selected = true; // Preselect the user's roles
                    }

                    rolesSelect.append(option);
                });
            },
            error: function() {
                alert("Error fetching roles.");
            },
        });
    }


    // Save user details via AJAX
    function saveUser() {
        let formData = new FormData();
        formData.append("id", $("#id").val());
        formData.append("username", $("#username_add").val());
        formData.append("name", $("#name").val());
        formData.append("email", $("#email_add").val());
        formData.append("password", $("#password").val());
        formData.append("password_confirmation", $("#confirmPassword").val());
        formData.append("region_id", $("#region").val());
        formData.append("roles", $("#roles").val());

        // Check if passwords match
        if ($("#password").val() !== $("#confirmPassword").val()) {
            Swal.fire("Error", "Passwords do not match!", "error");
            return;
        }

        // Show confirmation dialog before submitting
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to save these changes?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading Toastify notification
                let loadingToast = Toastify({
                    text: `<i class="fas fa-spinner fa-spin"></i> Saving user profile...`,
                    duration: -1, // Toast will stay indefinitely until manually closed
                    close: false,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#ffc107", // Loading (warning) color
                    escapeMarkup: false, // Allow HTML for the spinner
                    stopOnFocus: true,
                }).showToast();

                // Proceed with AJAX request to save the data
                $.ajax({
                    url: "/users/store",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Hide the loading toast after saving
                        loadingToast.hideToast();

                        // Show success toast with an icon
                        Toastify({
                            text: `<i class="fas fa-check-circle"></i> User profile saved successfully!`,
                            duration: 3000, // Duration for success toast
                            close: true, // Show close button
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#4CAF50", // Success color
                            escapeMarkup: false, // Allow HTML for the icon
                            stopOnFocus: true,
                        }).showToast();
                    },
                    error: function() {
                        // Hide the loading toast if there's an error
                        loadingToast.hideToast();

                        Swal.fire("Error", "There was an error saving the user.", "error");
                    }
                });
            }
        });
    }
</script>
