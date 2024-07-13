function createUser() {
    // Show a loading indicator using SweetAlert2
    Swal.fire({
        title: "Loading...",
        text: "Please wait while we redirect you.",
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
    });
    console.log("masuk sini nggak aaaa");
    // Simulate the process of opening the link to create a user
    setTimeout(function () {
        // Redirect to the create user link
        window.location.href = "/users/create";
    }, 2000); // Simulated delay for demonstration
}

$(document).ready(function () {
    fetchDataUser();
});

function fetchDataUser() {
    if ($.fn.DataTable.isDataTable("#users_table")) {
        $("#users_table").DataTable().destroy();
    }

    $("#users_table").DataTable({
        responsive: true, // Enable responsive extension
        processing: true,
        serverSide: true,
        ajax: {
            url: "/users/data",
            data: {
                name: $("#name").val(),
                department: $("#department").val(),
                cabang: $("#cabang").val(),
            },
            beforeSend: function() {
                $('.spinner').show();
            },
            complete: function() {
                $('.spinner').hide();
            }
        },
        columns: [
            { data: "id", name: "id" },
            {
                data: "username",
                name: "username",
                render: function (data, type, row) {
                    return '<i class="fas fa-user"></i> ' + data;
                },
            },
            {
                data: "name",
                name: "name",
                render: function (data, type, row) {
                    return '<i class="fas fa-user"></i> ' + data;
                },
            },
            {
                data: "email",
                name: "email",
                render: function (data, type, row) {
                    return '<i class="fas fa-envelope"></i> ' + data +
                           ' <button class="btn btn-primary btn-sm kirim-email" onclick="sendAccountDetails(\'' + data + '\', \'email\')"><i class="fas fa-paper-plane"></i> Kirim Email</button>';
                },
            },
            {
                data: "password_show",
                name: "password_show",
                render: function (data, type, row) {
                    return `
                        <div class="password-container">
                            <input type="password" class="form-control form-control-sm" value="${data}" readonly />
                            <i class="fas fa-eye toggle-password"></i>
                        </div>
                    `;
                },
            },
            {
                data: "kode_jabatan",
                name: "kode_jabatan",
                render: function (data, type, row) {
                    if (row.jabatan === null || row.jabatan === undefined) {
                        return "Belum memiliki jabatan";
                    } else {
                        return row.jabatan.kode_jabatan;
                    }
                },
            },
            {
                data: "phone_number",
                name: "phone_number",
                render: function (data, type, row) {
                    if (data === null || data === undefined) {
                        return "Belum memiliki No Handphone";
                    } else {
                        return row.phone_number;
                    }
                },
            },
            {
                data: "photo",
                name: "photo",
                render: function (data, type, row) {
                    if (data === null || data === undefined || data.trim() === '') {
                        return '<a href="/image/logo.png" data-fancybox="gallery"><img src="/image/logo.png" alt="Default Image" class="img-fluid" style="height: 100px;"></a>';
                    } else {
                        return '<a href="' + data + '" data-fancybox="gallery"><img src="' + data + '" alt="User Photo" class="img-fluid" style="height: 100px;"></a>';
                    }
                },
            },
            {
                data: "department",
                name: "department",
                render: function (data, type, row) {
                    if (row.department === null || row.department === undefined) {
                        return "Belum memiliki department";
                    } else {
                        return row.department.kode_department;
                    }
                },
            },
            {
                data:'cabang',
                name: "cabang",
                render: function (data, type, row) {
                    if (row.cabang === null || row.cabang === undefined) {
                        return "Belum memiliki cabang";
                    } else {
                        return row.cabang.name;
                    }
                },
            },
            {
                data: "status",
                name: "status",
                render: function (data, type, row) {
                    if (data === "y") {
                        return '<span class="badge badge-success badge-sm" style="color: white;"><i class="fas fa-check" style="color: white;"></i> Active</span>';
                    } else {
                        return '<span class="badge badge-secondary badge-sm" style="color: white;"><i class="fas fa-times" style="color: white;"></i> Non-active</span>';
                    }
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="editUser(${row.id})"><i class="fas fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#" onclick="deleteUser(${row.id})"><i class="fas fa-trash"></i> Delete</a></li>
                                <li><a class="dropdown-item" href="#" onclick="resetPassword(${row.id})"><i class="fas fa-key"></i> Reset Password</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setRolesToUser(${row.id})"><i class="fas fa-plus-circle"></i> Tambah Roles</a></li>
                            </ul>
                        </div>
                    `;
                },
            },

        ],
        drawCallback: function() {
            var table = this.api();
            var body = $(table.table().body());

            // Create a new instance of mark.js
            var instance = new Mark(body[0]);


            if($("#name").val() != undefined || $("#department").val() != undefined || $("#cabang").val() != undefined) {
                // Remove previous highlights
                instance.unmark({
                    done: function() {
                        // Highlight the search terms
                        instance.mark($("#name").val());
                        instance.mark($("#department").val());
                        instance.mark($("#cabang").val());
                    }
                });
            }
        },
        initComplete: function () {
            var rows = this.api().rows({ page: 'current' }).nodes();
            $(rows).css('opacity', '0').slideDown('slow').animate(
                { opacity: 1 },
                { duration: 'slow' }
            );
        }
    });

    $('[data-fancybox="gallery"]').fancybox({
        // Options if needed
    });

    // Re-initialize Fancybox after DataTable redraw (if using AJAX or other redraw methods)
    $('#users_table').on('draw.dt', function() {
        $('[data-fancybox="gallery"]').fancybox({
            // Options if needed
        });
    });

    // Toggle password visibility
    $(document).on("click", ".toggle-password", function () {
        const input = $(this).siblings("input");
        const type = input.attr("type") === "password" ? "text" : "password";
        input.attr("type", type);
        $(this).toggleClass("fa-eye fa-eye-slash");
    });
}

function sendAccountDetails(receiver, contactMethod) {
    // Show confirmation dialog using SweetAlert
    Swal.fire({
        title: 'Send Account Details?',
        text: `Are you sure you want to send account details to ${receiver}?`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes, send it!',
        cancelButtonText: 'No, cancel',
        showLoaderOnConfirm: true, // Display a loading spinner during confirm
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                // AJAX request to send account details
                $.ajax({
                    url: '/users/send-account-details',
                    method: 'POST',
                    data: {
                        receiver: receiver,
                        contact_method: contactMethod,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });

            });
        },
        allowOutsideClick: () => !Swal.isLoading() // Prevent closing modal while sending
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sent!',
                text: 'Account details have been sent successfully.',
                icon: 'success'
            });
            // Optionally update UI or show success message to user
        }
    }).catch((error) => {
        Swal.fire({
            title: 'Error!',
            text: 'Failed to send account details.',
            icon: 'error'
        });
        console.error(error); // Log the error for debugging
        // Optionally handle specific errors or show error message to user
    });
}

async function fetchOptions(url) {
    const response = await fetch(url);
    return response.json();
}

async function filterUser() {
    $("#mdlForm").modal('show');
    $("#mdlFormTitle").html("Filter User");
    $('#mdlFormContent').html("");

    const departments = await fetchOptions('/departments/data');

    const departmentOptions = departments.map(dept => `<option value="${dept.id}">${dept.name}</option>`).join('');

    $('#mdlFormContent').append(`
        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control"  name="name" id="name" placeholder="Nama Karyawan">
                </div>
                <div class="col">
                    <select class="form-control" name="department" id="department">
                        <option value="">Departemen</option>
                        ${departmentOptions}
                    </select>
                </div>
                <div class="col">
                    <select class="form-control" name="cabang" id="cabang">
                        <option value="">Semua Cabang</option>
                        <option value="bali">Bali</option>
                    </select>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary" onclick="searchUser()">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </div>
    `);
}

function searchUser(){
    fetchDataUser();
    $("#mdlForm").modal('hide');
}

function setRolesToUser(user_id) {
    $("#mdlForm").modal('show');

    // Clear the modal content
    $('#mdlFormContent').html("");

    // Append the form HTML to the modal content
    $('#mdlFormContent').append(`
        <form id="chooseRoles" class="form" action="#">
            <!-- Note for the user -->
            <div class="alert alert-info" role="alert">
                Please add roles first before proceeding.
            </div>
            <div class="fv-row mb-7">
                <label class="fs-6 fw-semibold form-label mb-2">
                    <span class="required">Roles</span>
                    <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Descriptions is required to be unique.">
                        <i class="ki-duotone ki-information fs-7">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                </label>
                <div id="checkboxContainer"></div> <!-- Container to hold checkboxes -->
            </div>
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-permissions-modal-action="cancel">Discard</button>
                <button type="submit" class="btn btn-primary" data-kt-permissions-modal-action="submit">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress d-none">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    `);

    // Set the modal title
    $("#mdlFormTitle").html("Form Add roles");

    // Fetch permissions via AJAX
    $.ajax({
        url: "/roles/getAllRoles",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Populate checkboxes with fetched permissions
            if (response.data) {
                var checkboxContainer = $('#checkboxContainer');
                var groupedRoles = {}; // Object to store permissions grouped by common part of name

                // Group permissions by common part of name
                response.data.forEach(function(roles) {
                    var commonName = roles.name.split('-')[0]; // Extract common part of name
                    if (!groupedRoles[commonName]) {
                        groupedRoles[commonName] = []; // Initialize array for the group if not exists
                    }
                    groupedRoles[commonName].push(roles); // Add roles to the group
                });

                // Iterate through grouped roless
                Object.keys(groupedRoles).forEach(function(name) {
                    var groupName = capitalizeFirstLetter(name); // Capitalize the first letter of each word in the group name

                    // Append group label
                    checkboxContainer.append(`
                        <div class="mb-3">
                            <h5>${groupName}</h5>
                        </div>
                    `);

                    // Append checkboxes for each roles in the group
                    groupedRoles[name].forEach(function(roles) {
                        checkboxContainer.append(`
                            <div class="form-check mb-2"> <!-- Add margin bottom -->
                                <input class="form-check-input" type="checkbox" value="${roles.id}" id="checkbox${roles.id}">
                                <label class="form-check-label ms-2" for="checkbox${roles.id}"> <!-- Add margin left -->
                                    ${roles.display_name}
                                </label>
                            </div>
                        `);
                    });
                });
            }
        },
        error: function(xhr, status, error) {
            // Optionally handle error here
            Swal.fire({
                title: xhr.responseJSON.message,
                text: xhr.responseJSON.message,
                icon: status,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

    $.ajax({
        url: "/roles/getRolesByUser", // Replace with your actual endpoint
        type: "GET",
        dataType: "json",
        data: { user_id: user_id },
        success: function(response) {
            // Populate checkboxes with fetched permissions
            if (response.data) {
                response.data.forEach(function(roles) {
                    $("#checkbox" + roles.id).prop("checked", true);
                })
            }
        },
        error: function(xhr, status, error) {
            // Optionally handle error here
            Swal.fire({
                title: xhr.responseJSON.message,
                text: xhr.responseJSON.message,
                icon: status,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });


    $('#chooseRoles').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Check if at least one checkbox is checked
        var atLeastOneChecked = $('#checkboxContainer').find('input[type="checkbox"]:checked').length > 0;

        // If no checkbox is checked, show an alert
        if (!atLeastOneChecked) {
            Swal.fire({
                title: 'Validation Error',
                text: 'Please select at least one roles.',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            });
            return; // Exit the function
        }

        // Display SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to submit roles to this user ? ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Get selected permission IDs
                var selectedPermissions = $('#checkboxContainer').find('input[type="checkbox"]:checked').map(function() {
                    return $(this).val();
                }).get();

                // Submit permissions via AJAX
                $.ajax({
                    url: '/roles/submitRolesToUser', // Replace with your actual endpoint
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token in the request headers
                    },
                    data: {
                        user_id: user_id, // Provide the role ID if needed
                        roles: selectedPermissions
                    },
                    success: function(response) {
                        // Handle success response
                        Swal.fire({
                            title: 'Submitted!',
                            text: 'Your roles have been submitted to the user.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#mdlForm").modal('hide');
                        tableUser();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error submitting roles:", error);
                        // Optionally handle error here
                        Swal.fire({
                            title: 'Error',
                            text: xhr.responseJSON.message,
                            icon: status,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableUser();
                    }
                })
            }

        });
    });
}

function capitalizeFirstLetter(string) {
    return string.replace(/\b\w/g, function(match) {
        return match.toUpperCase();
    });
}

function deleteUser(userId) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an AJAX request to delete the user
            $.ajax({
                url: '/users/delete/' + userId,
                type: 'DELETE',
                success: function(result) {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    );
                    // Refresh the DataTable
                    fetchDataUser();
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the user.',
                        'error'
                    );
                }
            });
        }
    });
}

function editUser(value){
    Swal.fire({
        title: "Edit User",
        text: "Are you sure you want to edit this user?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, edit it!",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve) => {
                // Simulate API call or any asynchronous operation
                setTimeout(() => {
                    resolve();
                }, 1000); // Adjust delay as needed
            });
        },
    }).then((result) => {
        if (result.isConfirmed) {
            // Open edit link using jQuery
            window.location.href = "/users/" + value + "/edit";
        }
    });
}

function resetPassword(value) {
    Swal.fire({
        title: "Are you sure?",
        text: "This action will reset the user's password.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, reset it!",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/users/reset-password/${value}`,
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (response) {
                        resolve(response);
                    },
                    error: function (xhr, status, error) {
                        reject("Error resetting password: " + error);
                    },
                });
            });
        },
    })
        .then((result) => {
            if (result.isConfirmed) {
                // Display Swal (SweetAlert) success message
                Swal.fire({
                    title: "Password Reset!",
                    text: "Password reset email sent successfully.",
                    icon: "success",
                    timer: 3000, // Set duration in milliseconds (e.g., 3000 for 3 seconds)
                    showConfirmButton: false, // Hide the "OK" button
                });

                // Display Toastify message
                Toastify({
                    text: "Password reset email sent successfully.",
                    duration: 3000, // Display duration in milliseconds
                    close: true,
                    gravity: "bottom", // Display position: 'top' or 'bottom'
                    position: "right", // Display position: 'left', 'center', or 'right'
                    backgroundColor:
                        "linear-gradient(to right, #00b09b, #96c93d)", // Custom background color
                }).showToast();

                // Reload the page after a delay
                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
        })
        .catch((error) => {
            Swal.fire("Error!", error, "error");
        });
}
