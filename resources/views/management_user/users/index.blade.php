<x-default-layout>
    @section('title')
        Users Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />

    <style>
        /* Hide default checkbox */
        input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }

        /* Custom checkbox styling */
        input[type="checkbox"]+label {
            position: relative;
            padding-left: 25px;
            cursor: pointer;
            font-size: 1rem;
        }

        input[type="checkbox"]+label:before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: white;
            transition: all 0.3s ease;
        }

        input[type="checkbox"]:checked+label:before {
            background-color: #4CAF50;
            border-color: #4CAF50;
            transform: translateY(-50%) scale(1.1);
        }

        input[type="checkbox"]:checked+label:after {
            content: "\2713";
            position: absolute;
            left: 4px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: white;
        }

        input[type="checkbox"]+label:hover:before {
            border-color: #aaa;
        }

        .progress-bar {
            transition: width 0.4s ease;
        }

        .toggle-password {
            font-size: 1.25rem;
            color: #007bff;
            right: 10px;
        }

        .toggle-password:hover {
            color: #0056b3;
        }

        .modal-content {
            border-radius: 0.5rem;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }

        .form-label {
            font-weight: bold;
        }

        .input-group-text {
            background-color: #fff;
            border-left: none;
        }

        .progress-bar {
            transition: width 0.5s ease;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .table-wrapper {
                display: none;
            }

            .list-view {
                display: block;
            }

            .list-item {
                border-bottom: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 10px;
            }

            .list-item:last-child {
                border-bottom: none;
            }

            .list-item .item-title {
                font-weight: bold;
            }

            .list-item .item-content {
                margin: 5px 0;
            }

            #strengthBar {
                transition: width 0.3s;
            }
        }

        /* Custom Badge Styles */
        .badge {
            font-size: 0.9rem;
            padding: 0.4em 0.6em;
            border-radius: 0.25rem;
            margin-right: 0.5em;
        }

        /* Add some space between buttons */
        .btn-group .btn {
            margin-right: 0.5em;
        }

        /* Style for the password mask icon */
        .toggle-password {
            font-size: 1rem;
        }

        /* Style for the checkbox label */
        .user-checkbox {
            margin-right: 0.5em;
        }

        #profilePictureDropzone {
            border: 2px dashed #007bff;
            border-radius: 4px;
            padding: 20px;
            cursor: pointer;
            text-align: center;
            position: relative;
            background-color: #f8f9fa;
        }

        #profilePictureDropzone.bg-light {
            background-color: #e9ecef;
        }

        #profilePicturePreview {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .progress {
            border-radius: 4px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.css">

    <!--begin::Card-->
    <div class="card shadow-sm">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6 bg-light">
            <div class="card-title d-flex justify-content-between w-100">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5 text-muted"></i>
                    <input type="text" id="search-box"
                        class="form-control form-control-solid form-control-lg w-250px ps-13"
                        placeholder="Search Users" />
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="tambahUser()">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>

        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <div class="table-wrapper">
                <table class="table table-striped table-bordered table-hover align-middle fs-6 gy-5" id="users_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0 bg-light">
                            <th class="min-w-50px">
                                <input type="checkbox" id="select-all"> <!-- Select all checkbox -->
                            </th>
                            <th class="min-w-150px">Profile</th>
                            <th class="min-w-150px">Username</th>
                            <th class="min-w-150px">Name</th>
                            <th class="min-w-150px">Email</th>
                            <th class="min-w-150px">Password</th>
                            <th class="min-w-150px">Roles</th>
                            <th class="min-w-150px">Regions</th>
                            <th class="min-w-100px">Created At</th>
                            <th class="min-w-100px text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 fw-semibold">
                        <!-- Table content dynamically populated by DataTables -->
                    </tbody>
                </table>
            </div>

            <!-- Mobile List View -->
            <!-- Mobile List View -->
            <div class="list-view" style="display: none;">
                <!-- Example List Item -->
                <div class="list-item">
                    <div class="item-header" style="cursor: pointer;">
                        <div class="item-title">Username:</div>
                        <div class="item-content">john_doe</div>
                        <i class="fas fa-chevron-down toggle-collapse" style="float: right;"></i>
                    </div>
                    <div class="item-details" style="display: none;">
                        <div class="item-title">Name:</div>
                        <div class="item-content">John Doe</div>
                        <div class="item-title">Email:</div>
                        <div class="item-content">john@example.com</div>
                        <div class="item-title">Password:</div>
                        <div class="item-content">****</div>
                        <i class="fas fa-eye toggle-password text-primary ms-2" style="cursor:pointer;"
                            data-password="password" data-id="1"></i>
                        <div class="item-title">Created At:</div>
                        <div class="item-content">2024-01-01</div>
                        <div class="item-actions text-end">
                            <button class="btn btn-primary btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </div>
                </div>
                <!-- End Example List Item -->
                <button id="load-more" class="btn btn-primary mt-3">Load More</button>
            </div>

        </div>
    </div>

    <!-- Modal for Superadministrator Password -->
    <div class="modal fade" id="superadminModal" tabindex="-1" aria-labelledby="superadminModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="superadminModalLabel">Superadministrator Authentication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="superadminForm">
                        <div class="mb-3">
                            <label for="superadmin_password" class="form-label">Enter Superadministrator
                                Password</label>
                            <input type="password" class="form-control" id="superadmin_password" placeholder="Password">
                            <div id="superadminError" class="text-danger mt-2" style="display: none;">Incorrect
                                password. Please try again.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="verifySuperadminPassword">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="userModalLabel">User Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userId" name="id">

                        <div class="mb-3">
                            <label for="profilePicture" class="form-label">Profile Picture</label>
                            <div id="profilePictureDropzone">
                                <input type="file" id="profilePicture" style="display: none;">
                                <img id="profilePicturePreview" style="display: none;" alt="Profile Picture Preview">
                                <div id="uploadProgressWrapper" style="display: none;">
                                    <div id="uploadProgressBar" class="progress-bar"></div>
                                </div>
                                <button id="removePictureButton" style="display: none;">Remove Image</button>
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Username" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <span class="input-group-text">
                                    <i class="fas fa-eye toggle-password" data-password="password"
                                        style="cursor: pointer;"></i>
                                </span>
                            </div>
                            <button type="button" id="generatePasswordBtn" class="btn btn-secondary mt-2">Generate
                                Password</button>
                            <div class="progress mt-2" style="height: 8px;">
                                <div id="passwordStrengthBar" class="progress-bar bg-success" role="progressbar"
                                    style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirmPassword"
                                    name="password_confirmation" placeholder="Confirm Password" required>
                                <span class="input-group-text">
                                    <i class="fas fa-eye toggle-password" data-password="confirmPassword"
                                        style="cursor: pointer;"></i>
                                </span>
                            </div>
                            <div id="passwordError" class="text-danger mt-2" style="display: none;">Passwords do not
                                match!</div>
                        </div>

                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <select class="form-select" id="roles" name="roles[]" multiple required>
                                <!-- Options will be dynamically inserted here -->
                            </select>
                        </div>

                        <div id="userFormError" class="text-danger mt-2" style="display: none;">Please fill out all
                            fields and ensure passwords match.</div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveUser">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Change Password Modal -->
    <!-- Change Password Modal -->
    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="password_change" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password_change" name="password"
                                required>
                            <div id="passwordStrength" class="mt-2">
                                <div class="progress">
                                    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%;"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div id="strengthMessage" class="mt-1"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password_change" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password_change"
                                name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

        <script src="{{ asset('js/helpers/datatables.js') }}"></script>
        <script src="{{ asset('js/users/tables.js') }}"></script>
        <script>
            $(document).ready(function() {


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var selectedRow = null;
                var page = 1;
                var loading = false;
                var itemsPerPage = 10;
                fetchRoles();


                $('#roles').select2({
                    placeholder: "Select roles", // Optional placeholder
                    width: '100%', // Ensures Select2 takes full width
                    allowClear: true // Adds the option to clear selections
                });


                $('#select-all').on('click', function() {
                    var isChecked = $(this).prop('checked');
                    $('.user-checkbox').prop('checked', isChecked);
                });


                // Add event listener for password toggle
                $('#users_table').on('click', '.toggle-password', function() {
                    const password = $(this).data('password');
                    $(this).prev('.password-mask').text(password);
                });
                const passwordInput = document.getElementById('password');
                const confirmPasswordInput = document.getElementById('confirmPassword');
                const passwordStrengthBar = document.getElementById('passwordStrengthBar');
                const passwordError = document.getElementById('passwordError');
                const togglePasswordIcons = document.querySelectorAll('.toggle-password');

                // Toggle Password Visibility
                togglePasswordIcons.forEach(icon => {
                    icon.addEventListener('click', function() {
                        const passwordField = document.getElementById(this.getAttribute(
                            'data-password'));
                        const type = passwordField.getAttribute('type') === 'password' ? 'text' :
                            'password';
                        passwordField.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    });
                });

                // Password Strength Calculation
                passwordInput.addEventListener('input', function() {
                    const strength = calculatePasswordStrength(this.value);
                    passwordStrengthBar.style.width = `${strength}%`;
                    passwordStrengthBar.setAttribute('aria-valuenow', strength);

                    if (strength < 50) {
                        passwordStrengthBar.classList.remove('bg-success');
                        passwordStrengthBar.classList.add('bg-danger');
                    } else {
                        passwordStrengthBar.classList.remove('bg-danger');
                        passwordStrengthBar.classList.add('bg-success');
                    }
                });

                // Password Matching Validation
                confirmPasswordInput.addEventListener('input', function() {
                    if (this.value !== passwordInput.value) {
                        passwordError.style.display = 'block';
                    } else {
                        passwordError.style.display = 'none';
                    }
                });




                // Password Strength Calculation Function
                function calculatePasswordStrength(password) {
                    let strength = 0;
                    if (password.length >= 8) strength += 25;
                    if (/[A-Z]/.test(password)) strength += 25;
                    if (/[a-z]/.test(password)) strength += 25;
                    if (/[0-9]/.test(password)) strength += 15;
                    if (/[\W_]/.test(password)) strength += 10;
                    return strength;
                }

                function generatePassword(wordCount = 2, symbolCount = 1, numberCount = 1) {
                    const words = ['apple', 'banana', 'orange', 'grape', 'mango', 'kiwi', 'peach', 'berry', 'melon',
                        'lemon'
                    ];
                    const symbols = ['!', '@', '#', '$', '%', '&', '*'];
                    const numbers = '0123456789';

                    let password = '';

                    // Tambahkan kata-kata secara acak
                    for (let i = 0; i < wordCount; i++) {
                        const word = words[Math.floor(Math.random() * words.length)];
                        password += word;
                    }

                    // Tambahkan simbol secara acak
                    for (let i = 0; i < symbolCount; i++) {
                        const symbol = symbols[Math.floor(Math.random() * symbols.length)];
                        password += symbol;
                    }

                    // Tambahkan angka secara acak
                    for (let i = 0; i < numberCount; i++) {
                        const number = numbers[Math.floor(Math.random() * numbers.length)];
                        password += number;
                    }

                    return password;
                }

                // Event listener untuk tombol generate password
                document.getElementById('generatePasswordBtn').addEventListener('click', function() {
                    const wordList = ['apple', 'banana', 'orange', 'grape', 'mango', 'kiwi', 'peach', 'berry',
                        'melon', 'lemon'
                    ];
                    const symbolList = ['!', '@', '#', '$', '%', '&', '*'];
                    const length = 2; // Atur jumlah kata yang digunakan

                    const generatedPassword = generateDynamicPassword(wordList, symbolList, length);
                    const passwordInput = document.getElementById('password');
                    const confirmPasswordInput = document.getElementById('confirmPassword');

                    passwordInput.value = generatedPassword;
                    confirmPasswordInput.value = generatedPassword;

                    checkPasswordStrength(generatedPassword);
                    validatePasswordsMatch();
                });

                // Toggle between table and list view based on screen size
                $(window).on('resize', function() {
                    if ($(window).width() <= 768) {
                        $('.table-wrapper').hide();
                        $('.list-view').show();
                        if (!$('.list-view').find('#load-more').length) {
                            loadData(page);
                        }
                    } else {
                        $('.table-wrapper').show();
                        $('.list-view').hide();
                    }
                }).trigger('resize');

                // Handle load more button click
                $(document).on('click', '#load-more', function() {
                    if (!loading) {
                        loading = true;
                        page++;
                        loadData(page);
                    }
                });

                // Toggle password visibility in list view
                $(document).on('click', '.toggle-password', function() {
                    const password = $(this).data('password');
                    $(this).prev('.password-mask').text(password);
                });

                // Handle collapse and expand of list item details
                $(document).on('click', '.toggle-collapse', function() {
                    $(this).closest('.list-item').find('.item-details').slideToggle();
                    $(this).toggleClass('fa-chevron-down fa-chevron-up');
                });

                $('#saveUser').click(function(e) {
                    e.preventDefault();
                    console.log("Saving user details...");

                    // Create a FormData object to handle both user data and file upload
                    let formData = new FormData();
                    formData.append('id', $('#userId').val());
                    formData.append('username', $('#username').val());
                    formData.append('name', $('#name').val());
                    formData.append('email', $('#email').val());
                    formData.append('password', $('#password').val());
                    formData.append('password_confirmation', $('#confirmPassword').val());

                    // Get selected roles as an array
                    let selectedRoles = $('#roles')
                .val(); // Assuming #roles is a <select> with 'multiple' attribute
                    if (selectedRoles) {
                        selectedRoles.forEach(role => {
                            formData.append('roles[]',
                            role); // Append each role to FormData as an array
                        });
                    }

                    // Append the profile picture if it exists
                    const fileInput = document.getElementById('profilePicture');
                    if (fileInput.files.length > 0) {
                        formData.append('profile_picture', fileInput.files[0]);
                    }

                    // Validate form data
                    if (!formData.get('username') || !formData.get('name') || !formData.get('email') || formData
                        .get('password') !== formData.get('password_confirmation')) {
                        $('#userFormError').show();
                        return;
                    }

                    $('#userFormError').hide();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to submit the user details.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, save it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/management/users/store', // Adjust this to your API route
                                type: 'POST',
                                data: formData,
                                contentType: false, // Important for FormData
                                processData: false, // Important for FormData
                                success: function(response) {
                                    Toastify({
                                        text: "User saved successfully!",
                                        duration: 3000,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#28a745",
                                    }).showToast();

                                    $('#modalForm').modal('hide');
                                    $('#userForm')[0].reset();
                                    $('#users_table').DataTable().ajax.reload();
                                },
                                error: function(xhr) {
                                    let errorMessage =
                                        "Error saving user. Please try again.";

                                    // Check if the response contains JSON data
                                    try {
                                        let responseJSON = JSON.parse(xhr.responseText);
                                        if (responseJSON.message) {
                                            errorMessage = responseJSON.message;
                                        } else if (responseJSON.errors) {
                                            // Collect all error messages if there are validation errors
                                            errorMessage = Object.values(responseJSON
                                                .errors).flat().join(', ');
                                        }
                                    } catch (e) {
                                        // Handle parsing error or non-JSON responses
                                        console.error("Error parsing response JSON:", e);
                                    }

                                    Toastify({
                                        text: errorMessage,
                                        duration: 3000,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#dc3545",
                                    }).showToast();
                                }
                            });
                        }
                    });
                });


                const dropzone = document.getElementById('profilePictureDropzone');
                const fileInput = document.getElementById('profilePicture');
                const preview = document.getElementById('profilePicturePreview');
                const progressWrapper = document.getElementById('uploadProgressWrapper');
                const progressBar = document.getElementById('uploadProgressBar');
                const removeButton = document.getElementById('removePictureButton');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fileInput.addEventListener('change', handleFileSelect);
                dropzone.addEventListener('click', () => fileInput.click());
                dropzone.addEventListener('dragover', (event) => {
                    event.preventDefault();
                    dropzone.classList.add('bg-light');
                });
                dropzone.addEventListener('dragleave', () => dropzone.classList.remove('bg-light'));
                dropzone.addEventListener('drop', (event) => {
                    event.preventDefault();
                    dropzone.classList.remove('bg-light');
                    handleFileSelect({
                        target: {
                            files: event.dataTransfer.files
                        }
                    });
                });

                removeButton.addEventListener('click', removeImage);

                function handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (!file.type.startsWith('image/')) {
                            alert('Please select an image file.');
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                            removeButton.style.display = 'inline-block'; // Show the remove button
                        };
                        reader.readAsDataURL(file);

                        progressWrapper.style.display = 'block';
                        uploadFile(file);
                    }
                }

                function uploadFile(file) {
                    const formData = new FormData();
                    formData.append('profile_picture', file);

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/upload-profile-picture', true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                    xhr.upload.onprogress = (event) => {
                        if (event.lengthComputable) {
                            const percentComplete = (event.loaded / event.total) * 100;
                            progressBar.style.width = percentComplete + '%';
                            progressBar.setAttribute('aria-valuenow', percentComplete);
                        }
                    };

                    xhr.onload = () => {
                        if (xhr.status === 200) {
                            console.log('Image uploaded successfully!');
                        } else {
                            console.error('Image upload failed: ' + xhr.statusText);
                        }
                        progressWrapper.style.display = 'none';
                    };

                    xhr.onerror = () => {
                        console.error('Image upload failed due to a network error.');
                        progressWrapper.style.display = 'none';
                    };

                    xhr.send(formData);
                }

                function removeImage() {
                    preview.src = '';
                    preview.style.display = 'none';
                    removeButton.style.display = 'none';
                    progressWrapper.style.display = 'none';
                    fileInput.value = ''; // Clear file input

                    // Optionally, you can send a request to remove the image from the server
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/remove-profile-picture', true);
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                    xhr.onload = () => {
                        if (xhr.status === 200) {
                            console.log('Image removed successfully!');
                        } else {
                            console.error('Image removal failed: ' + xhr.statusText);
                        }
                    };
                    xhr.send();
                }



            });

            function editUser(id) {
                $.ajax({
                    url: '/management/users/' + id, // Update the URL to match your route
                    method: 'GET',
                    success: function(response) {
                        console.log(response.roles, 'response');
                        // Populate the form fields
                        $('#userId').val(response.id);
                        $('#username').val(response.username);
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#roles').val(response.roles).trigger(
                            'change'
                        ); // Set selected values and trigger change event to update the select2 or similar plugins if used

                        // Clear previous error messages
                        $('#passwordError').hide();
                        $('#userFormError').hide();

                        // Clear password fields
                        $('#password').val('');
                        $('#confirmPassword').val('');

                        // Show the modal
                        $("#modalForm").modal('show');
                    },
                    error: function() {
                        alert('Error fetching user data.');
                    }
                });
            }

            function deleteUser(id) {
                // Use SweetAlert for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the AJAX request to delete the user
                        $.ajax({
                            url: '/management/users/' + id, // The delete URL
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}' // Include CSRF token for security
                            },
                            success: function(response) {
                                // Use Toastify to display a success message
                                Toastify({
                                    text: response.message,
                                    duration: 3000,
                                    close: true,
                                    gravity: "top", // Positioning
                                    position: "right",
                                    backgroundColor: "#4fbe87",
                                }).showToast();

                                // Reload the data table to reflect the deletion
                                $('#users_table').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                // Use Toastify to display an error message
                                Toastify({
                                    text: 'Failed to delete user: ' + xhr.responseText,
                                    duration: 3000,
                                    close: true,
                                    gravity: "top", // Positioning
                                    position: "right",
                                    backgroundColor: "#f3616d",
                                }).showToast();
                            }
                        });
                    }
                });
            }



            function fetchRoles() {
                $.ajax({
                    url: '/roles/getRoles', // Ensure this matches the route defined
                    method: 'GET',
                    success: function(response) {
                        // Clear existing options
                        $('#roles').empty();
                        // Populate dropdown with new options
                        response.forEach(function(role) {
                            console.log(role);

                            $('#roles').append(new Option(role.name, role.name));
                        });
                    },
                    error: function() {
                        alert('Error fetching roles.');
                    }
                });
            }


            function tambahUser() {
                $("#modalForm").modal('show');
            }

            function generateDynamicPassword(wordList, symbolList, length) {
                const numbers = '0123456789';

                // Pilih kata acak dari wordList
                const selectedWords = [];
                for (let i = 0; i < length; i++) {
                    selectedWords.push(wordList[Math.floor(Math.random() * wordList.length)]);
                }

                // Pilih simbol dan angka acak
                const symbol = symbolList[Math.floor(Math.random() * symbolList.length)];
                const number = numbers[Math.floor(Math.random() * numbers.length)];

                // Gabungkan kata-kata, simbol, dan angka
                const password = `${selectedWords.join('')}${symbol}${number}`;
                return password;
            }

            // Function to open the Change Password modal and set the user ID
            function changePassword(userId) {
                $('#user_id').val(userId); // Set the user ID in the hidden input field
                $('#changePasswordModal').modal('show'); // Show the modal
            }

            // Function to update password strength
            function updatePasswordStrength(password) {
                console.log(password);
                const result = zxcvbn(password);
                const strengthBar = $('#strengthBar');
                const strengthMessage = $('#strengthMessage');

                let strength = result.score * 25; // zxcvbn score ranges from 0 to 4
                let message = '';

                // Define strength levels
                switch (result.score) {
                    case 0:
                        message = 'Very Weak';
                        strengthBar.removeClass('bg-success bg-warning bg-danger').addClass('bg-danger');
                        break;
                    case 1:
                        message = 'Weak';
                        strengthBar.removeClass('bg-success bg-warning bg-danger').addClass('bg-warning');
                        break;
                    case 2:
                        message = 'Moderate';
                        strengthBar.removeClass('bg-success bg-warning bg-danger').addClass('bg-warning');
                        break;
                    case 3:
                        message = 'Strong';
                        strengthBar.removeClass('bg-success bg-warning bg-danger').addClass('bg-success');
                        break;
                    case 4:
                        message = 'Very Strong';
                        strengthBar.removeClass('bg-success bg-warning bg-danger').addClass('bg-success');
                        break;
                }

                strengthBar.css('width', strength + '%').attr('aria-valuenow', strength);
                strengthMessage.text(message);
            }

            // Handle the password input to update the strength
            $('#password').on('input', function() {
                updatePasswordStrength($(this).val());
            });

            // Handle the form submission
            $('#changePasswordForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var userId = $('#user_id').val();
                var password = $('#password_change').val();
                var confirmPassword = $('#confirm_password_change').val();
                var old_password = $('#old_password').val();

                if (password !== confirmPassword) {
                    // Show error message if passwords do not match
                    Toastify({
                        text: "Passwords do not match!",
                        duration: 3000,
                        close: true,
                        gravity: "top", // Positioning
                        position: "right",
                        backgroundColor: "#f3616d",
                    }).showToast();
                    return;
                }

                $.ajax({
                    url: '/management/users/change-password', // The URL to your endpoint
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token for security
                        user_id: userId,
                        old_password: old_password,
                        password: password,
                        confirmPassword: confirmPassword,
                    },
                    success: function(response) {
                        Toastify({
                            text: response.message,
                            duration: 3000,
                            close: true,
                            gravity: "top", // Positioning
                            position: "right",
                            backgroundColor: "#4fbe87",
                        }).showToast();

                        // Close the modal
                        $('#changePasswordModal').modal('hide');
                    },
                    error: function(xhr) {
                        Toastify({
                            text: 'Failed to change password: ' + xhr.responseText,
                            duration: 3000,
                            close: true,
                            gravity: "top", // Positioning
                            position: "right",
                            backgroundColor: "#f3616d",
                        }).showToast();
                    }
                });
            });



            function checkPasswordStrength(password) {
                const strengthBar = document.getElementById('passwordStrengthBar');
                let strength = 0;

                // Cek berbagai kriteria kekuatan password
                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25; // huruf kapital
                if (/[0-9]/.test(password)) strength += 25; // angka
                if (/[\W_]/.test(password)) strength += 25; // simbol

                // Update progress bar
                strengthBar.style.width = `${strength}%`;
                strengthBar.setAttribute('aria-valuenow', strength);
            }

            function validatePasswordsMatch() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const errorDiv = document.getElementById('passwordError');

                if (password !== confirmPassword) {
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.style.display = 'none';
                }
            }
        </script>
    @endpush
</x-default-layout>
