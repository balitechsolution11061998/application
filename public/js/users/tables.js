dataTableHelper("#users_table", "/users/data", [
    {
        data: "id",
        name: function () {
            if ($(window).width() < 768) {
                // adjust the width value to your liking
                return "Select"; // or any other name you prefer
            } else {
                return "id";
            }
        },
        render: function (data, type, row) {
            if ($(window).width() < 768) {
                // On mobile mode, hide the checkbox and show only the name
                return `<span>${row.name}</span>`;
            } else {
                // On desktop mode, show the checkbox and label text
                return `
                <input type="checkbox" class="user-checkbox" id="user-${data}" value="${data}">
                <label for="user-${data}" data-intro="Click here to view user details" data-step="1"></label>
                `;
            }
        },
        orderable: false,
        searchable: false,
    },
    {
        data: "profile_picture",
        name: "profile_picture",
        render: function (data) {
            return data;
        },
        orderable: false,
        searchable: false,
    },
    {
        data: "profile_picture",
        name: "profile_picture",
        render: function (data) {
            console.log(data,'data');
            return data;
        },
        orderable: false,
        searchable: false,
    },
    {
        data: "username",
        name: "username",
    },
    {
        data: "name",
        name: "name",
        render: function (data, type, row) {
            return row.name;
        }
    },
    {
        data: "email",
        name: "email",
        render: function (data, type, row) {
            console.log(data, type, row.user_emails); // Debugging statement

            // Check if user_emails exists and has items
            const emailList =
                row.user_emails && row.user_emails.length > 0
                    ? row.user_emails
                          .map(
                              (emailObj) => `
                    <span class="badge bg-secondary text-white me-1 mb-1 d-inline-flex align-items-center justify-content-between"
                        style="font-size: 0.85em; padding: 6px 12px; border-radius: 20px; font-weight: bold;">
                        <i class="fas fa-envelope me-2" style="color: white;"></i>${emailObj.email}
                        <i class="fas fa-times ms-2" style="cursor: pointer; color: white;" onclick="deleteEmail(${row.username}, '${emailObj.email}')"></i>
                    </span>
                `
                          )
                          .join("") // Join badges for additional emails
                    : `<span class="text-muted" style="font-size: 0.85em;">No active emails</span>`; // Default message

            // Render the primary email with an icon and include additional emails as badges
            return `
                <div class="email-container" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <div class="primary-email" style="margin-bottom: 8px;">
                        <span class="badge bg-info text-white email-badge d-inline-flex align-items-center"
                            style="font-size: 0.95em; padding: 6px 12px; border-radius: 20px; font-weight: bold;">
                            <i class="fas fa-envelope me-2" style="color: white;"></i>${data}
                        </span>
                    </div>
                    <div class="additional-emails" style="display: flex; flex-wrap: wrap; gap: 6px;">
                        ${emailList}
                    </div>
                </div>
            `;
        },
    },
    {
        data: "password_show",
        name: "password_show",
        render: function (data, type, row) {
            return `
<span class="password-mask" style="font-family: monospace;">****</span>
<i class="fas fa-eye toggle-password text-primary ms-2" style="cursor:pointer;" data-password="${data}" data-id="${row.id}"></i>
`;
        },
    },
    {
        data: "roles",
        name: "roles",
        render: function (data, type, row) {
            console.log(row.roles, "row");
            const roleIcons = {
                administrator: "fa-user-shield",
                superadministrator: "fa-user-crown",
                manager: "fa-users-cog",
                editor: "fa-edit",
                viewer: "fa-eye",
                supplier: "fa-user-tag", // Add icon for supplier
            };

            // Check if the user has the supplier role
            const hasSupplierRole = data.some(
                (role) => role.name === "supplier"
            );

            // Fetch supplier names from the row (assuming supplier_names is an array in the row)
            let supplierNames = row.supplier_names || []; // Default to an empty array

            // Ensure supplierNames is an array
            if (!Array.isArray(supplierNames)) {
                supplierNames = [supplierNames]; // Convert to array if it's not
            }

            console.log(supplierNames, "supplier_names");

            // Create a string for supplier names with icons
            const supplierNamesString =
                supplierNames.length > 0
                    ? supplierNames
                          .map(
                              (name) => `
                    <span class="badge bg-info text-dark me-1" style="display: inline-flex; align-items: center;">
                        <i class="fas fa-user-tag me-1"></i> ${name}
                    </span>
                `
                          )
                          .join(" ")
                    : '<span class="badge bg-secondary">No Suppliers</span>';

            return `
                <div class="d-inline-flex flex-wrap align-items-center">
                    ${data
                        .map(
                            (role) => `
                        <span class="badge rounded-pill bg-dark text-white me-2" style="font-size: 0.9em; display: inline-flex; align-items: center; padding: 0.4em 0.7em;">
                            <i class="fas ${
                                roleIcons[role.name] || "fa-user"
                            } me-1"></i> ${role.name}
                            <button class="btn btn-sm btn-danger ms-2" style="border-radius: 50%; padding: 0.2em 0.5em; line-height: 1;" role="button" aria-label="Delete ${
                                role.name
                            }" onclick="deleteRole('${role.id}', ${row.id})">
                                <i class="fas fa-times"></i>
                            </button>
                        </span>
                    `
                        )
                        .join(" ")}

                    ${
                        hasSupplierRole
                            ? `
                        <div class="d-inline-flex align-items-center me-2">
                            <button class="btn btn-sm btn-success" onclick="addSupplier(${row.id})" title="Add Supplier">
                                <i class="fas fa-plus"></i> Tambah Supplier
                            </button>
                        </div>
                    `
                            : ""
                    }

                    <div class="d-inline-flex align-items-center mt-2">
                        <span class="fw-bold me-1">Supplier:</span>
                        ${supplierNamesString}
                    </div>
                </div>
            `;
        },
    },

    {
        data: "region",
        name: "region",
        render: function (data) {
            return data ? data : "N/A";
        },
    },
    {
        data: "created_at",
        name: "created_at",
        render: function (data) {
            return new Date(data).toLocaleDateString("en-US", {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric",
            });
        },
    },
    {
        data: "user_emails",
        name: "user_emails",
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
            const emailList =
                data.length > 0
                    ? data.map((emailObj) => emailObj.email).join(", ")
                    : "No active emails";

            return `
            <div class="btn-group d-flex flex-wrap" role="group">
                <div class="d-flex w-100 justify-content-between mb-1">
                    <button type="button" class="btn btn-sm btn-primary w-32" onclick="editUser('${row.username}')" title="Edit User">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger w-32" onclick="deleteUser(${row.id})" title="Delete User">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning w-32" onclick="changePassword(${row.id})" title="Change Password">
                        <i class="fas fa-key"></i>
                    </button>
                </div>
                <div class="d-flex w-100 justify-content-between">
                    <button type="button" class="btn btn-sm btn-info w-32" data-toggle="tooltip" title="<div class='tooltip-content'>${emailList}</div>" data-html="true" onclick="sendEmail('${row.username}')">
                        <i class="fas fa-envelope"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary w-32 btn-add-email" title="Add Email" onclick="addEmail('${row.username}')">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-success w-32" title="Store" onclick="addStore('${row.username}')">
                        <i class="fas fa-store"></i>
                    </button>
                </div>
            </div>
            `;
        },
    },
]);

if ($(window).width() < 768) {
    introJs()
        .setOptions({
            steps: [
                {
                    intro: "Click + to view details", // Set the intro text to English
                    element: document.querySelector(
                        "#users_table th:nth-child(1)"
                    ),
                    position: "bottom", // Position the step at the bottom of the element
                    highlightClass: "introjs-helperClass", // Add a custom class for styling
                    title: "Welcome", // Add a title to the step
                },
            ],
            overlayOpacity: 0.8, // Set the overlay opacity
            showStepNumbers: false, // Hide the step numbers
            showBullets: false, // Hide the bullets
            exitOnOverlayClick: true, // Exit the intro on overlay click
            nextLabel: "Click to view details", // Set the next button label to English
            prevLabel: "Previous", // Set the previous button label
            skipLabel: "Skip", // Set the skip button label
            doneLabel: "Done", // Set the done button label
            buttons: {
                prev: '<button class="introjs-button prev-button">Previous</button>',
                next: '<button class="introjs-button next-button" id="show-details-button">Click to view details</button>',
                skip: '<button class="introjs-button skip-button">Skip</button>',
                done: '<button class="introjs-button done-button">Done</button>',
            },
            dontShowAgain: {
                label: "Don't show again", // Set the "Don't show again" checkbox label to English
            }, // Add the "Don't show again" checkbox
        })
        .oncomplete(function () {
            // Add event listener to the "Click to view details" button
            $("#show-details-button").on("click", function () {
                // Show the details of the data
                alert("Details of the data will be shown here");
            });
        })
        .start();

    // Add CSS to set all text to black within Intro.js tooltips with high specificity
    const tooltipStyles = `
    <style>
        .introjs-tooltip, .introjs-tooltip * {
            color: black !important;
        }
        .introjs-tooltip-title, .introjs-tooltiptext, .introjs-helperLayer, .introjs-overlay, .introjs-tooltipbuttons {
            color: black !important;
            background-color: #fff !important; /* Optional: Set background color for visibility */
        }
    </style>
    `;

    // Append the custom styles to the document head
    $("head").append(tooltipStyles);
}

function sendEmail(username) {
    Swal.fire({
        title: 'Send Email',
        text: `Are you sure you want to send an email to ${username}?`, // Confirmation message
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, send it!',
        cancelButtonText: 'Cancel',
        customClass: {
            confirmButton: 'btn btn-success me-2', // Bootstrap success button
            cancelButton: 'btn btn-danger' // Bootstrap danger button
        },
        buttonsStyling: false // Disable default button styling
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state with ellipsis animation
            let loadingText = 'Please wait while we send the email';
            let ellipsis = '';
            const loadingInterval = setInterval(() => {
                ellipsis = ellipsis.length < 3 ? ellipsis + '.' : '';
                Swal.getContent().querySelector('p').textContent = loadingText + ellipsis;
            }, 500); // Update every 500ms

            Swal.fire({
                title: 'Sending...',
                html: '<p>' + loadingText + '</p>', // Use HTML to allow dynamic content
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
                customClass: {
                    title: 'text-primary', // Custom title color
                    content: 'text-dark', // Custom content color
                }
            });

            // Send email via AJAX
            $.ajax({
                url: '/users/send-account', // Your route to send email
                method: 'POST',
                data: {
                    username: username,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                },
                success: function(response) {
                    // Clear the loading interval
                    clearInterval(loadingInterval);
                    // Close the loading state
                    Swal.close();
                    Swal.fire({
                        title: 'Success!',
                        text: `Email sent to: ${username}@example.com`, // Adjust as needed
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary' // Bootstrap primary button
                        },
                        buttonsStyling: false // Disable default button styling
                    });
                },
                error: function(xhr) {
                    // Clear the loading interval
                    clearInterval(loadingInterval);
                    // Close the loading state
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to send email. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary' // Bootstrap primary button
                        },
                        buttonsStyling: false // Disable default button styling
                    });
                }
            });
        }
    });
}


function addSupplier(userId) {
    document.getElementById("userId").value = userId; // Set the user ID in the hidden input field
    const modal = new bootstrap.Modal(
        document.getElementById("addSupplierModal")
    );
    modal.show();

    // Fetch suppliers and populate the select dropdown
    fetch("/suppliers/selectData") // Adjust the URL to your API endpoint
        .then((response) => {
            if (!response.ok) {
                throw new Error("Failed to fetch suppliers");
            }
            return response.json();
        })
        .then((data) => {
            const supplierSelect = $("#supplierSelect");
            supplierSelect.empty(); // Clear previous options
            supplierSelect.append('<option value="">Select suppliers</option>'); // Add default option
            // Check if suppliers data is available
            if (data.suppliers && data.suppliers.length > 0) {
                data.suppliers.forEach((supplier) => {
                    // Format the option text as "supp_code (supp_name)"
                    const optionText = `${supplier.supp_code} (${supplier.supp_name})`;
                    const option = new Option(
                        optionText,
                        supplier.supp_code,
                        false,
                        false
                    );
                    supplierSelect.append(option);
                });

                // Initialize Select2
                supplierSelect.select2({
                    placeholder: "Select suppliers",
                    allowClear: true,
                });
            } else {
                // Show toastr notification if no suppliers are available
                toastr.warning("Please sync suppliers first to add a supplier."); // Adjust the message as needed
            }
        })
        .catch((error) => {
            console.error("Error fetching suppliers:", error);
            toastr.error("An error occurred while fetching suppliers."); // Show error message
        });
}

// Handle form submission
document
    .getElementById("addSupplierForm")
    .addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission

        const selectedSuppliers = Array.from(
            document.getElementById("supplierSelect").selectedOptions
        ).map((option) => option.value);
        const userId = document.getElementById("userId").value;
        // Use SweetAlert to confirm the action
        Swal.fire({
            title: "Are you sure?",
            text: "You are about to add the selected suppliers.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add them!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to add the selected suppliers
                fetch("/users/add-suppliers", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        userId: userId,
                        suppliers: selectedSuppliers, // Send the array of selected supplier codes
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Close the modal
                            const modal = bootstrap.Modal.getInstance(
                                document.getElementById("addSupplierModal")
                            );
                            modal.hide();

                            // Show success message with Toastr
                            toastr.success(
                                "Suppliers added successfully!",
                                "Success"
                            );
                            dataTableHelper();
                        } else {
                            // Show error message with Toastr
                            toastr.error(
                                "Error adding suppliers: " + data.message,
                                "Error"
                            );
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        toastr.error(
                            "An error occurred while adding the suppliers.",
                            "Error"
                        );
                    });
            }
        });
    });

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('[data-toggle="tooltip"]').tooltip();
    fetchRoles();

    // Add event listener for password toggle
    $("#users_table").on("click", ".toggle-password", function () {
        const password = $(this).data("password");
        $(this).prev(".password-mask").text(password);
    });

    const togglePasswordIcons = document.querySelectorAll(".toggle-password");
    // Toggle Password Visibility
    togglePasswordIcons.forEach((icon) => {
        icon.addEventListener("click", function () {
            const passwordField = document.getElementById(
                this.getAttribute("data-password")
            );
            const type =
                passwordField.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            passwordField.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });

    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirmPassword");
    const passwordStrengthBar = document.getElementById("passwordStrengthBar");
    const passwordError = document.getElementById("passwordError");

    // Password Strength Calculation
    passwordInput.addEventListener("input", function () {
        const strength = calculatePasswordStrength(this.value);
        passwordStrengthBar.style.width = `${strength}%`;
        passwordStrengthBar.setAttribute("aria-valuenow", strength);

        if (strength < 50) {
            passwordStrengthBar.classList.remove("bg-success");
            passwordStrengthBar.classList.add("bg-danger");
        } else {
            passwordStrengthBar.classList.remove("bg-danger");
            passwordStrengthBar.classList.add("bg-success");
        }
    });

    // Password Matching Validation
    confirmPasswordInput.addEventListener("input", function () {
        if (this.value !== passwordInput.value) {
            passwordError.style.display = "block";
        } else {
            passwordError.style.display = "none";
        }
    });

    $("#roles").select2({
        placeholder: "Select roles", // Optional placeholder
        width: "100%", // Ensures Select2 takes full width
        allowClear: true, // Adds the option to clear selections
    });

    $("#select-all").on("click", function () {
        var isChecked = $(this).prop("checked");
        $(".user-checkbox").prop("checked", isChecked);
    });

    $("#changePasswordForm").on("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        var userId = $("#user_id").val();
        var password = $("#password_change").val();
        var confirmPassword = $("#confirm_password_change").val();
        var old_password = $("#old_password").val();
        var csrfToken = $('input[name="_token"]').val(); // Retrieve the CSRF token value

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
            url: "/users/change-password", // The URL to your endpoint
            type: "POST",
            data: {
                _token: csrfToken, // Include the CSRF token value
                user_id: userId,
                current_password: old_password,
                new_password: password,
                confirmPassword: confirmPassword,
            },
            success: function (response) {
                Toastify({
                    text: response.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // Positioning
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast();

                // Close the modal
                $("#changePasswordModal").modal("hide");
            },
            error: function (xhr) {
                Toastify({
                    text: "Failed to change password: " + xhr.responseText,
                    duration: 3000,
                    close: true,
                    gravity: "top", // Positioning
                    position: "right",
                    backgroundColor: "#f3616d",
                }).showToast();
            },
        });
    });
});

// function addEmail(username) {
//     console.log(username, "username");
//     // Open a modal to add an email for the given user ID
//     $("#addEmailModal").modal("show");

//     // You can load user data or just provide an input field to add an email
//     $("#username").val(username); // Set userId to a hidden input in the modal
// }

async function addEmail(username) {
    // Show the spinner while the request is being processed
    showSpinner();

    try {
        // Make a GET request to the specified URL with the user ID as a parameter
        const response = await fetch(`/users/${username}/addemail`, {
            method: "GET", // Use GET as you're retrieving data
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content, // Include CSRF token if needed
            },
        });

        // Check if the response is OK (status code 200)
        if (!response.ok) {
            throw new Error("Network response was not ok"); // Handle network errors
        }

        // Parse the response as text (since it's an HTML view)
        const htmlContent = await response.text();

        // Inject the HTML content into the page
        document.body.innerHTML = htmlContent;

        // Optionally, remove the spinner once the content is loaded
        removeSpinner();
    } catch (error) {
        // Handle unexpected errors
        alert("An unexpected error occurred. Please try again later.");
        console.error("Error:", error); // Log error for debugging

        // Optionally, remove the spinner if an error occurs
        removeSpinner();
    } finally {
        // Optionally redirect to a different URL after loading the content
        // Change this to the appropriate URL you want to navigate to
        window.location.href = `/users/${username}/addemail`; // Change this if needed
    }
}

// Handle form submission
$("#addEmailForm").on("submit", function (e) {
    e.preventDefault();

    const email = $("#newEmailInput").val();
    const username = $("#username").val();

    // SweetAlert confirmation
    Swal.fire({
        title: "Are you sure?",
        text: `Add this email: ${email} to the user?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, add it!",
        cancelButtonText: "Cancel",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form via AJAX
            $.ajax({
                url: "/users/add-email", // Correctly pass the route
                method: "POST",
                data: {
                    email: email,
                    username: username,
                    _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
                },
                success: function (response) {
                    // Handle success response
                    if (response.success) {
                        // Close the modal
                        $("#addEmailModal").modal("hide");

                        // Show Toastify success message
                        Toastify({
                            text: "Email added successfully!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#4fbe87",
                            stopOnFocus: true,
                        }).showToast();
                        $("#users_table").DataTable().ajax.reload();

                        // Optionally refresh the table or perform other actions
                    } else {
                        // Show error alert
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                        });
                    }
                },
                error: function (xhr) {
                    // Handle error response
                    Swal.fire({
                        title: "Error!",
                        text: "An error occurred while adding the email.",
                        icon: "error",
                    });
                },
            });
        }
    });
});

async function tambahUser(username) {
    showSpinner();

    try {
        // Make a GET request to the specified URL with the user ID as a parameter
        const response = await fetch(`/users/${username}/formUser`, {
            method: "GET", // Use GET as you're retrieving data
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content, // Include CSRF token if needed
            },
        });

        // Check if the response is OK (status code 200)
        if (!response.ok) {
            throw new Error("Network response was not ok"); // Handle network errors
        }

        // Parse the response as text (since it's an HTML view)
        const htmlContent = await response.text();

        // Inject the HTML content into the page
        document.body.innerHTML = htmlContent;

        // Optionally, remove the spinner once the content is loaded
        removeSpinner();
    } catch (error) {
        // Handle unexpected errors
        alert("An unexpected error occurred. Please try again later.");
        console.error("Error:", error); // Log error for debugging

        // Optionally, remove the spinner if an error occurs
        removeSpinner();
    } finally {
        // Optionally redirect to a different URL after loading the content
        // Change this to the appropriate URL you want to navigate to
        window.location.href = `/users/${username}/formUser`; // Change this if needed
    }
}


function fetchRoles() {
    $.ajax({
        url: "/roles/getRoles", // Ensure this matches the route defined
        method: "GET",
        success: function (response) {
            // Clear existing options
            $("#roles").empty();
            // Populate dropdown with new options
            response.forEach(function (role) {
                console.log(role);

                $("#roles").append(new Option(role.name, role.name));
            });
        },
        error: function () {
            alert("Error fetching roles.");
        },
    });
}

// generate password
document
    .getElementById("generatePasswordBtn")
    .addEventListener("click", function () {
        const wordList = [
            "apple",
            "banana",
            "orange",
            "grape",
            "mango",
            "kiwi",
            "peach",
            "berry",
            "melon",
            "lemon",
        ];
        const symbolList = ["!", "@", "#", "$", "%", "&", "*"];
        const length = 2; // Atur jumlah kata yang digunakan

        const generatedPassword = generateDynamicPassword(
            wordList,
            symbolList,
            length
        );
        const passwordInput = document.getElementById("password");
        const confirmPasswordInput = document.getElementById("confirmPassword");

        passwordInput.value = generatedPassword;
        confirmPasswordInput.value = generatedPassword;

        checkPasswordStrength(generatedPassword);
        validatePasswordsMatch();
    });
function generatePassword(wordCount = 2, symbolCount = 1, numberCount = 1) {
    const words = [
        "apple",
        "banana",
        "orange",
        "grape",
        "mango",
        "kiwi",
        "peach",
        "berry",
        "melon",
        "lemon",
    ];
    const symbols = ["!", "@", "#", "$", "%", "&", "*"];
    const numbers = "0123456789";

    let password = "";

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
function generateDynamicPassword(wordList, symbolList, length) {
    const numbers = "0123456789";

    // Pilih kata acak dari wordList
    const selectedWords = [];
    for (let i = 0; i < length; i++) {
        selectedWords.push(
            wordList[Math.floor(Math.random() * wordList.length)]
        );
    }

    // Pilih simbol dan angka acak
    const symbol = symbolList[Math.floor(Math.random() * symbolList.length)];
    const number = numbers[Math.floor(Math.random() * numbers.length)];

    // Gabungkan kata-kata, simbol, dan angka
    const password = `${selectedWords.join("")}${symbol}${number}`;
    return password;
}
function checkPasswordStrength(password) {
    const strengthBar = document.getElementById("passwordStrengthBar");
    let strength = 0;

    // Cek berbagai kriteria kekuatan password
    if (password.length >= 8) strength += 25;
    if (/[A-Z]/.test(password)) strength += 25; // huruf kapital
    if (/[0-9]/.test(password)) strength += 25; // angka
    if (/[\W_]/.test(password)) strength += 25; // simbol

    // Update progress bar
    strengthBar.style.width = `${strength}%`;
    strengthBar.setAttribute("aria-valuenow", strength);
}

function validatePasswordsMatch() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const errorDiv = document.getElementById("passwordError");

    if (password !== confirmPassword) {
        errorDiv.style.display = "block";
    } else {
        errorDiv.style.display = "none";
    }
}

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
// function editUser(id) {
//     $.ajax({
//         url: "/users/" + id + "/edit", // Update the URL to match your route
//         method: "GET",
//         success: function (response) {
//             console.log(response.roles, "response");
//             // Populate the form fields
//             $("#userId").val(response.id);
//             $("#username").val(response.username);
//             $("#name").val(response.name);
//             $("#email").val(response.email);
//             $("#roles").val(response.roles).trigger("change"); // Set selected values and trigger change event to update the select2 or similar plugins if used
//             $("#address").val(response.address);
//             $("#region").val(response.region).trigger("change");

//             // Clear previous error messages
//             $("#passwordError").hide();
//             $("#userFormError").hide();

//             // Clear password fields
//             $("#password").val("");
//             $("#confirmPassword").val("");

//             // Show the modal
//             $("#modalForm").modal("show");
//         },
//         error: function () {
//             alert("Error fetching user data.");
//         },
//     });
// }

async function editUser(username) {
    showSpinner();

    try {
        // Make a GET request to the specified URL with the user ID as a parameter
        const response = await fetch(`/users/${username}/formUser`, {
            method: "GET", // Use GET as you're retrieving data
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content, // Include CSRF token if needed
            },
        });

        // Check if the response is OK (status code 200)
        if (!response.ok) {
            throw new Error("Network response was not ok"); // Handle network errors
        }

        // Parse the response as text (since it's an HTML view)
        const htmlContent = await response.text();

        // Inject the HTML content into the page
        document.body.innerHTML = htmlContent;

        // Optionally, remove the spinner once the content is loaded
        removeSpinner();
    } catch (error) {
        // Handle unexpected errors
        alert("An unexpected error occurred. Please try again later.");
        console.error("Error:", error); // Log error for debugging

        // Optionally, remove the spinner if an error occurs
        removeSpinner();
    } finally {
        // Optionally redirect to a different URL after loading the content
        // Change this to the appropriate URL you want to navigate to
        window.location.href = `/users/${username}/formUser`; // Change this if needed
    }
}

// Function to open the Change Password modal and set the user ID
function changePassword(userId) {
    $("#user_id").val(userId); // Set the user ID in the hidden input field
    $("#changePasswordModal").modal("show"); // Show the modal
}

function deleteEmail(username, email) {
    // SweetAlert confirmation
    Swal.fire({
        title: "Are you sure?",
        text: `You won't be able to revert this! Delete email: ${email}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the email deletion using an AJAX request
            $.ajax({
                url: `/users/delete-email`,
                type: "POST",
                data: {
                    username: username,
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
                },
                success: function (response) {
                    // Show success notification using Toastify
                    Toastify({
                        text: "Email deleted successfully",
                        duration: 3000,
                        gravity: "top", // top or bottom
                        position: "right", // left, center, or right
                        backgroundColor: "#28a745", // success color
                        close: true,
                    }).showToast();

                    // Reload or update the DataTable to reflect the changes
                    $("#myDataTable").DataTable().ajax.reload();
                },
                error: function (xhr) {
                    // Show error notification using Toastify
                    Toastify({
                        text: "Failed to delete email",
                        duration: 3000,
                        gravity: "top", // top or bottom
                        position: "right", // left, center, or right
                        backgroundColor: "#dc3545", // error color
                        close: true,
                    }).showToast();
                },
            });
        }
    });
}

function deleteUser(id) {
    // Use SweetAlert for confirmation
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with the AJAX request to delete the user
            const token = $('input[name="_token"]').val();

            $.ajax({
                url: "/users/" + id, // The delete URL
                type: "DELETE",
                data: {
                    _token: token,
                    _method: "DELETE",
                },
                success: function (response) {
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
                    $("#users_table").DataTable().ajax.reload();
                },
                error: function (xhr) {
                    // Use Toastify to display an error message
                    Toastify({
                        text: "Failed to delete user: " + xhr.responseText,
                        duration: 3000,
                        close: true,
                        gravity: "top", // Positioning
                        position: "right",
                        backgroundColor: "#f3616d",
                    }).showToast();
                },
            });
        }
    });
}

function deleteRole(role, user_id) {
    console.log(role, user_id);
    Swal.fire({
        title: "Are you sure?",
        text: `You want to delete the ${role} role from this user.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Send request to Laravel route to delete the role
            $.ajax({
                type: "POST",
                url: "/users/rolesdelete",
                data: {
                    role: role,
                    user_id: user_id,
                },
                success: function (response) {
                    $("#users_table").DataTable().ajax.reload();
                    Swal.fire(
                        "Deleted!",
                        `The ${role} role has been deleted from this user.`,
                        "success"
                    );
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        "Error!",
                        `Failed to delete the ${role} role from this user.`,
                        "error"
                    );
                },
            });
        }
    });
}

async function addStore(user_id) {
    // Show the spinner while the request is being processed
    showSpinner();

    try {
        // Make a GET request to the specified URL with the user ID as a parameter
        const response = await fetch(`/users/${user_id}/addstore`, {
            method: "GET", // Use GET as you're retrieving data
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content, // Include CSRF token if needed
            },
        });

        // Check if the response is OK (status code 200)
        if (!response.ok) {
            throw new Error("Network response was not ok"); // Handle network errors
        }

        // Parse the response as text (since it's an HTML view)
        const htmlContent = await response.text();

        // Inject the HTML content into the page
        document.body.innerHTML = htmlContent;

        // Optionally, remove the spinner once the content is loaded
        removeSpinner();
    } catch (error) {
        // Handle unexpected errors
        alert("An unexpected error occurred. Please try again later.");
        console.error("Error:", error); // Log error for debugging

        // Optionally, remove the spinner if an error occurs
        removeSpinner();
    } finally {
        // Optionally redirect to a different URL after loading the content
        // Change this to the appropriate URL you want to navigate to
        window.location.href = `/users/${user_id}/addstore`; // Change this if needed
    }
}

function showSpinner() {
    const card = document.createElement("div");
    card.className = "card loading";

    const spinner = document.createElement("div");
    spinner.className = "spinner-container";
    spinner.innerHTML = `
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
        <p>Loading, please wait...</p>
    `;

    card.appendChild(spinner);
    document.body.appendChild(card);

    card.style.position = "fixed";
    card.style.top = "50%";
    card.style.left = "50%";
    card.style.transform = "translate(-50%, -50%)";
    card.style.zIndex = "9999";
}

function removeSpinner() {
    const spinnerCard = document.querySelector(".card.loading");
    if (spinnerCard) {
        spinnerCard.remove();
    }
}
