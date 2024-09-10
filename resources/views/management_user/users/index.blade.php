<x-default-layout>
    @section('title')
        Users Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection

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
        }
    </style>

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
                            <th class="min-w-150px">Username</th>
                            <th class="min-w-150px">Name</th>
                            <th class="min-w-150px">Email</th>
                            <th class="min-w-150px">Password</th>
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
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Username"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password"
                                required>
                            <i class="fas fa-eye toggle-password" style="cursor: pointer;"
                                data-password="password"></i>
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <select class="form-select" id="roles" multiple required>
                                <option value="admin">Administrator</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <div id="userFormError" class="text-danger mt-2" style="display: none;">Please fill out all
                            fields.</div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveUser">Save</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/helpers/datatables.js') }}"></script>
        <script>
            $(document).ready(function() {
                var selectedRow = null;
                var page = 1;
                var loading = false;
                var itemsPerPage = 10;

                function loadData(page) {
                    $.ajax({
                        url: '{{ route('management.users.data') }}',
                        method: 'GET',
                        data: {
                            page: page,
                            per_page: itemsPerPage
                        },
                        success: function(response) {
                            if (response.data.length) {
                                let listViewHtml = '';
                                response.data.forEach(function(item) {
                                    listViewHtml += `
                        <div class="list-item" data-id="${item.id}">
                            <div class="item-header" style="cursor: pointer;">
                                <div class="item-title">Username:</div>
                                <div class="item-content">${item.username}</div>
                                <i class="fas fa-chevron-down toggle-collapse" style="float: right;"></i>
                            </div>
                            <div class="item-details" style="display: none;">
                                <div class="item-title">Name:</div>
                                <div class="item-content">${item.name}</div>
                                <div class="item-title">Email:</div>
                                <div class="item-content">${item.email}</div>
                                <div class="item-title">Password:</div>
                                <div class="item-content">****</div>
                                <i class="fas fa-eye toggle-password text-primary ms-2" style="cursor:pointer;" data-password="${item.password_show}" data-id="${item.id}"></i>
                                <div class="item-title">Created At:</div>
                                <div class="item-content">${item.created_at}</div>
                                <!-- Add actions if needed -->
                            </div>
                        </div>
                        `;
                                });
                                $('.list-view').append(listViewHtml);
                                if (response.hasMore) {
                                    $('.list-view').append(
                                        '<button id="load-more" class="btn btn-primary mt-3">Load More</button>'
                                        );
                                } else {
                                    $('#load-more').remove();
                                }
                                loading = false;
                            }
                        }
                    });
                }

                dataTableHelper('#users_table', '{{ route('management.users.data') }}', [{
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `
                <input type="checkbox" class="user-checkbox" id="user-${data}" value="${data}">
                <label for="user-${data}"></label>
                `;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'password_show',
                        name: 'password_show',
                        render: function(data, type, row) {
                            return `
                <span class="password-mask" style="font-family: monospace;">****</span>
                <i class="fas fa-eye toggle-password text-primary ms-2" style="cursor:pointer;" data-password="${data}" data-id="${row.id}"></i>
                `;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]);

                $('#select-all').on('click', function() {
                    var isChecked = $(this).prop('checked');
                    $('.user-checkbox').prop('checked', isChecked);
                });


                // Add event listener for password toggle
                $('#users_table').on('click', '.toggle-password', function() {
                    const password = $(this).data('password');
                    $(this).prev('.password-mask').text(password);
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
            });

            function tambahUser() {
                $("#modalForm").modal('show');
            }
        </script>
    @endpush
</x-default-layout>
