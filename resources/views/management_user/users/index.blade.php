<x-default-layout>
    @section('title')
        Users Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/introjs.css"
        integrity="sha512-n/6qsbBjjZik70avxNu5SS3tXMbWby7M7xiN/43zHKB2iPTcPaB98Y7+QN0pHWIDa2EDRCW5/d7fSB5XgBdTnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        .drop-zone {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .drop-zone.dragover {
            background-color: #f0f0f0;
        }

        .file-input {
            display: none;
        }

        .email-container {
            padding: 5px;
        }

        .email-badge {
            font-size: 0.9em;
            padding: 5px 10px;
        }

        .additional-emails {
            font-size: 0.8em;
            padding-top: 5px;
            display: inline-block;
            color: #6c757d;
            /* Bootstrap text-muted color */
        }

        .introjs-tooltip {
            box-sizing: content-box;
            position: absolute;
            visibility: visible;
            padding: 10px;
            background-color: #333;
            /* Set the background color to black */
            color: #fff;
            /* Set the text color to white */
            min-width: 200px;
            max-width: 300px;
            border-radius: 3px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, .4);
            -webkit-transition: opacity 0.1s ease-out;
            -moz-transition: opacity 0.1s ease-out;
            -ms-transition: opacity 0.1s ease-out;
            -o-transition: opacity 0.1s ease-out;
            transition: opacity 0.1s ease-out;
        }

        .introjs-helperClass {
            border-radius: 10px;
            /* Add rounded corners */
            background-color: #333;
            /* Set the background color to black */
            color: #fff;
            /* Set the text color to white */
            padding: 10px;
            /* Add some padding */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            /* Add a box shadow */
            font-family: 'Open Sans', sans-serif;
            /* Set a pretty font family */
            font-size: 18px;
            /* Set a larger font size */
        }

        .introjs-tooltip {
            font-family: 'Open Sans', sans-serif;
            /* Set a pretty font family */
            font-size: 16px;
            /* Set a larger font size */
        }

        .introjs-button {
            background-color: black;
            /* Set the background color to black */
            color: #fff;
            /* Set the text color to white */
            border: none;
            /* Remove the border */
            padding: 10px 20px;
            /* Add some padding */
            border-radius: 3px;
            /* Add rounded corners */
            cursor: pointer;
            /* Change the cursor to a pointer */
        }



        .prev-button,
        .next-button,
        .skip-button,
        .done-button {
            margin: 10px;
            /* Add some margin between buttons */
        }

        .introjs-checkbox {
            margin: 10px;
            /* Add some margin to the checkbox */
            font-family: 'Open Sans', sans-serif;
            /* Set a pretty font family */
            font-size: 16px;
            /* Set a larger font size */
        }

        .introjs-checkbox input[type="checkbox"] {
            margin: 0 10px;
            /* Add some margin to the checkbox input */
            vertical-align: middle;
            /* Vertically align the checkbox input */
        }

        .introjs-checkbox label {
            cursor: pointer;
            /* Change the cursor to a pointer */
        }

        @media (max-width: 768px) {
            #users_table {
                font-size: 12px;
            }

            #users_table th,
            #users_table td {
                padding: 5px;
            }

            #users_table th:nth-child(2),
            #users_table td:nth-child(2) {
                display: none;
            }
        }

        /* Style for the card */
        .card.loading {
            background-color: rgba(255, 255, 255, 0.9);
            /* Slight transparency */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            /* Soft shadow */
            text-align: center;
            width: 200px;
            height: 150px;
        }

        /* Spinner container */
        .spinner-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Spinner animation */
        .spinner {
            width: 40px;
            height: 40px;
            position: relative;
            margin-bottom: 15px;
        }

        .double-bounce1,
        .double-bounce2 {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #007bff;
            /* Bootstrap primary color */
            opacity: 0.6;
            position: absolute;
            top: 0;
            left: 0;
            animation: bounce 2s infinite ease-in-out;
        }

        .double-bounce2 {
            animation-delay: -1s;
        }

        /* Bounce animation */
        @keyframes bounce {

            0%,
            100% {
                transform: scale(0);
            }

            50% {
                transform: scale(1);
            }
        }

        /* Loading text */
        .spinner-container p {
            color: #333;
            font-size: 14px;
            margin: 0;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.css">



    <!--begin::Card-->
    <div class="card shadow-sm">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6 bg-light">
            <div class="card-title d-flex flex-wrap justify-content-between w-100">
                <div class="d-flex align-items-center position-relative my-1 w-100">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5 text-muted"></i>
                    <input type="text" id="search-box"
                        class="form-control form-control-solid form-control-lg w-100 ps-13"
                        placeholder="Search Users" />
                </div>
                <div class="w-100 d-flex justify-content-end">
                    <button type="button" class="btn btn-success btn-sm d-sm-block" data-bs-toggle="modal"
                        data-bs-target="#importUsersModal">
                        Import Users
                    </button>
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
                            <input type="password" class="form-control" id="superadmin_password"
                                placeholder="Password">
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
                        <div class="mb-3 form-check" id="checboxForm">
                            <input type="checkbox" class="form-check-input" id="changePasswordCheckbox">
                            <label class="form-check-label" for="changePasswordCheckbox">Change Password</label>
                        </div>

                        <div id="passwordFields" style="display: none;">
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    <span class="input-group-text">
                                        <i class="fas fa-eye toggle-password" data-password="password"
                                            style="cursor: pointer;"></i>
                                    </span>
                                </div>
                                <button type="button" id="generatePasswordBtn"
                                    class="btn btn-secondary mt-2">Generate Password</button>
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
                                <div id="passwordError" class="text-danger mt-2" style="display: none;">Passwords do
                                    not
                                    match!</div>
                            </div>
                        </div>



                        <!-- Address field -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Address" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-select" id="region" name="region" required>
                                <option value="">Select Region</option>
                                <!-- Options will be dynamically loaded here -->
                            </select>
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

    <!-- Modal -->
    <div class="modal fade" id="importUsersModal" tabindex="-1" aria-labelledby="importUsersLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importUsersLabel">Import Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Drop Zone -->
                    <div id="dropZoneCsv" class="drop-zone">
                        <p>Drag & drop your CSV file here or click to upload</p>
                        <input type="file" id="fileInputCsv" class="file-input" accept=".csv" hidden />
                    </div>
                    <!-- Display selected file name -->
                    <div id="fileNameDisplayCsv" class="mt-3"></div>
                    <!-- Progress Bar -->
                    <div class="progress mt-3" style="height: 20px; display: none;" id="uploadProgressBar">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" id="uploadProgress"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="uploadBtnCsv">Upload</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Email Modal -->
    <div class="modal fade" id="addEmailModal" tabindex="-1" aria-labelledby="addEmailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmailModalLabel">Add Email for User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmailForm">
                        <div class="mb-3">
                            <label for="newEmailInput" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="newEmailInput" name="email"
                                placeholder="Enter email" required>
                        </div>
                        <!-- Hidden field to store the user ID -->
                        <input type="hidden" id="username" name="username">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addEmailForm" class="btn btn-primary">Add Email</button>
                </div>
            </div>
        </div>
    </div>




    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.min.js"
            integrity="sha512-VTd65gL0pCLNPv5Bsf5LNfKbL8/odPq0bLQ4u226UNmT7SzE4xk+5ckLNMuksNTux/pDLMtxYuf0Copz8zMsSA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('js/helpers/datatables.js') }}"></script>
        <script src="{{ asset('js/users/tables.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/hashids@2.2.10/dist/hashids.min.js"></script>

        <script>
            $(document).ready(function() {



                var selectedRow = null;
                var page = 1;
                var loading = false;
                var itemsPerPage = 10;










                // Event listener untuk tombol generate password


                // Toggle between table and list view based on screen size


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



                // upload file csv/xlsx supplier
                const dropZoneCsv = document.getElementById('dropZoneCsv');
                const fileInputCsv = document.getElementById('fileInputCsv');
                const fileNameDisplayCsv = document.getElementById('fileNameDisplayCsv');
                const uploadBtnCsv = document.getElementById('uploadBtnCsv');
                const uploadProgressBar = document.getElementById('uploadProgressBar');
                const uploadProgress = document.getElementById('uploadProgress');

                // Handle drag & drop events
                dropZoneCsv.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropZoneCsv.classList.add('dragover');
                });

                dropZoneCsv.addEventListener('dragleave', () => {
                    dropZoneCsv.classList.remove('dragover');
                });

                dropZoneCsv.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropZoneCsv.classList.remove('dragover');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        handleFile(files[0]);
                    }
                });

                // Handle file input click
                dropZoneCsv.addEventListener('click', () => {
                    fileInputCsv.click();
                });

                fileInputCsv.addEventListener('change', () => {
                    if (fileInputCsv.files.length > 0) {
                        handleFile(fileInputCsv.files[0]);
                    }
                });

                // Function to handle the file
                function handleFile(file) {
                    const validTypes = ['text/csv',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ];
                    const validExtensions = ['.csv', '.xlsx'];
                    const fileExtension = file.name.slice((file.name.lastIndexOf(".") - 1 >>> 0) + 2);

                    if (validTypes.includes(file.type) && validExtensions.includes(`.${fileExtension}`)) {
                        fileNameDisplayCsv.textContent = `File selected: ${file.name}`;
                    } else {
                        fileNameDisplayCsv.textContent = 'Please select a valid CSV or XLSX file.';
                    }
                }

                // Handle file upload
                uploadBtnCsv.addEventListener('click', () => {
                    if (fileInputCsv.files.length > 0) {
                        const formData = new FormData();
                        formData.append('file', fileInputCsv.files[0]);

                        // Show progress bar
                        uploadProgressBar.style.display = 'block';
                        uploadProgress.style.width = '0%';
                        uploadProgress.setAttribute('aria-valuenow', 0);

                        // Create a new XMLHttpRequest to handle progress
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/suppliers/import', true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'));

                        // Track upload progress
                        xhr.upload.addEventListener('progress', (progressEvent) => {
                            const percentCompleted = Math.round((progressEvent.loaded * 100) /
                                progressEvent.total);
                            uploadProgress.style.width = `${percentCompleted}%`;
                            uploadProgress.setAttribute('aria-valuenow', percentCompleted);
                        });

                        // Handle response
                        xhr.onload = () => {
                            uploadProgressBar.style.display = 'none'; // Hide progress bar
                            const data = JSON.parse(xhr.responseText);
                            if (data.success) {
                                alert('File uploaded successfully');
                                location.reload(); // Reload to show the updated data
                            } else {
                                alert('Error uploading file');
                            }
                        };

                        xhr.onerror = () => {
                            uploadProgressBar.style.display = 'none'; // Hide progress bar
                            alert('Error during upload');
                        };

                        // Send the request
                        xhr.send(formData);
                    } else {
                        alert('Please select a file first.');
                    }
                });






                $('#modalForm').on('hidden.bs.modal', function() {
                    $(this).find('form')[0].reset(); // Reset all form inputs
                    $('#profilePicturePreview').hide(); // Hide profile picture preview
                    $('#uploadProgressWrapper').hide(); // Hide upload progress bar
                    $('#removePictureButton').hide(); // Hide remove button
                    $('#passwordFields').hide(); // Hide password fields
                    $('#passwordStrengthBar').css('width', '0%'); // Reset password strength bar
                    $('#passwordError').hide(); // Hide password mismatch error
                    $('#userFormError').hide(); // Hide general form error
                });


            });




            $('#changePasswordCheckbox').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#passwordFields').slideDown(); // Show the password fields
                } else {
                    $('#passwordFields').slideUp(); // Hide the password fields
                    // Clear the password fields when hidden
                    $('#password').val('');
                    $('#confirmPassword').val('');
                }
            });












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
        </script>
    @endpush
</x-default-layout>
