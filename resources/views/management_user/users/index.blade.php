<x-default-layout>
    @section('title')
        Users Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox/lightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastify/toastify.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <style>
    .tooltip-inner {
        background-color: black; /* Set tooltip background to black */
        color: white; /* Text color */
        max-width: 250px; /* Limit tooltip width */
        font-weight: bold; /* Bold font */
        font-size: 0.9em; /* Slightly smaller text */
        padding: 8px; /* Increase padding for better readability */
        text-align: left; /* Align text to the left */
    }
    .tooltip-content {
        padding: 5px;
    }
    .tooltip-arrow {
        border-bottom-color: black; /* Match the arrow color with the tooltip background */
    }
    @media (max-width: 576px) { /* Targets mobile devices */
    .btn-group .btn {
        flex: 1 1 32%; /* Each button takes 32% of the width for 3 buttons per row */
    }
    .btn-group .btn-group {
        margin-bottom: 0.5rem; /* Adds space between rows */
    }
}


    </style>
    <!--begin::Card-->
    <div class="card shadow-sm">
        <!--begin::Card header-->
        <div class="container my-5">
            <div class="row">
                <!-- Search and Actions Panel -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header border-0 pt-4 bg-light mb-4">
                            <div class="card-title d-flex flex-wrap justify-content-between w-100">
                                <div class="d-flex align-items-center position-relative my-1 w-100">
                                    <i class="fas fa-search fs-4 position-absolute ms-3 text-muted"></i>
                                    <input type="text" id="search-box"
                                        class="form-control form-control-solid form-control-lg w-100 ps-5"
                                        placeholder="Search Users" />
                                </div>
                                <div class="w-100 d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                        data-bs-target="#importUsersModal">
                                        <i class="fas fa-file-import"></i> Import Users
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="tambahUser()">
                                        <i class="fas fa-plus"></i> Add User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <th class="min-w-150px">S3 Profile</th>
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


    <!-- Modal for Adding Supplier -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <input type="hidden" id="userId" name="userId" value=""> <!-- Hidden input for userId -->
                        <div class="mb-3">
                            <label for="supplierSelect" class="form-label">Select Suppliers</label>
                            <select class="form-select" id="supplierSelect" multiple required>
                                <option value="">Select suppliers</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Add Suppliers</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    @push('scripts')
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
        <script src="{{ asset('assets/js/toastify/toastify.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/lightbox/lightbox.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/zxcvbn/zxcvbn.js') }}" defer></script>
        <script src="{{ asset('js/users/index.js') }}" defer></script>
        <script src="{{ asset('assets/js/hashids/hashids.min.js') }}" defer></script>
    @endpush
</x-default-layout>
