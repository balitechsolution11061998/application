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
            url:"/users/data",
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
                    return '<i class="fas fa-envelope"></i> ' + data;
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
                data:'department',
                name: "department",
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
                    return (
                        `
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit" onclick="editUser(${row.id})">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Trash" onclick="deleteUser(${row.id})">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Reset Password" onclick="resetPassword(${row.id})">
                            <i class="fas fa-key"></i>
                        </a>
                        `
                    );
                },
            },

        ],
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

        // Swal confirmation and link opening for Edit button

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
