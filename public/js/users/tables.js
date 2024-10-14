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
            const imgSrc = data
                ? `/storage/${data}`
                : "/path/to/default/profile.png";
            return `
<a href="${imgSrc}" data-lightbox="profile-picture-${data}">
    <img src="${imgSrc}" alt="Profile Picture" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
</a>
`;
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
        render: function (data) {
            const roleIcons = {
                administrator: "fa-user-shield",
                superadministrator: "fa-user-crown",
                manager: "fa-users-cog",
                editor: "fa-edit",
                viewer: "fa-eye",
            };

            return data
                .split(", ")
                .map(
                    (role) => `
<span class="badge rounded-pill bg-dark text-white me-2" style="font-size: 0.9em; display: inline-flex; align-items: center; padding: 0.4em 0.7em; white-space: nowrap;">
    <i class="fas ${roleIcons[role] || "fa-user"} me-1"></i> ${role}
</span>
`
                )
                .join(" ");
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
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-sm btn-primary" onclick="editUser(${row.id})" title="Edit User">
            <i class="fas fa-edit"></i>
        </button>
        <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(${row.id})" title="Delete User">
            <i class="fas fa-trash"></i>
        </button>
        <button type="button" class="btn btn-sm btn-warning" onclick="changePassword(${row.id})" title="Change Password">
            <i class="fas fa-key"></i>
        </button>
        <button type="button" class="btn btn-sm btn-info" data-toggle="tooltip" title="<div class='tooltip-content'>${emailList}</div>" data-html="true">
            <i class="fas fa-envelope"></i>
        </button>
        <button type="button" class="btn btn-sm btn-secondary btn-add-email" title="Add Email" onclick="addEmail(${row.username})">
                <i class="fas fa-plus"></i>
            </button>
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
                    element: document.querySelector("#users_table th:nth-child(1)"),
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
                label: "Don't show again" // Set the "Don't show again" checkbox label to English
            }, // Add the "Don't show again" checkbox
        })
        .oncomplete(function () {
            // Add event listener to the "Click to view details" button
            $("#show-details-button").on("click", function () {
                // Show the details of the data
                // You can replace this with your own logic to show the details
                alert("Details of the data will be shown here");
            });
        })
        .start();
}
const tooltipStyles = `
<style>
    .tooltip-inner {
        background-color: #333; /* Darker background for the tooltip */
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
        border-bottom-color: #333; /* Match the arrow color with the tooltip background */
    }
</style>
`;

// Add the custom styles to the document
$("head").append(tooltipStyles);
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('[data-toggle="tooltip"]').tooltip();
    fetchRegions();
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

    // upload profile
    const dropzone = document.getElementById("profilePictureDropzone");
    const fileInput = document.getElementById("profilePicture");
    const preview = document.getElementById("profilePicturePreview");
    const progressWrapper = document.getElementById("uploadProgressWrapper");
    const progressBar = document.getElementById("uploadProgressBar");
    const removeButton = document.getElementById("removePictureButton");
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fileInput.addEventListener("change", handleFileSelect);
    dropzone.addEventListener("click", () => fileInput.click());
    dropzone.addEventListener("dragover", (event) => {
        event.preventDefault();
        dropzone.classList.add("bg-light");
    });
    dropzone.addEventListener("dragleave", () =>
        dropzone.classList.remove("bg-light")
    );
    dropzone.addEventListener("drop", (event) => {
        event.preventDefault();
        dropzone.classList.remove("bg-light");
        handleFileSelect({
            target: {
                files: event.dataTransfer.files,
            },
        });
    });

    removeButton.addEventListener("click", removeImage);

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            if (!file.type.startsWith("image/")) {
                alert("Please select an image file.");
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = "block";
                removeButton.style.display = "inline-block"; // Show the remove button
            };
            reader.readAsDataURL(file);

            progressWrapper.style.display = "block";
            uploadFile(file);
        }
    }

    function uploadFile(file) {
        const formData = new FormData();
        formData.append("profile_picture", file);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/upload-profile-picture", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);

        xhr.upload.onprogress = (event) => {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                progressBar.style.width = percentComplete + "%";
                progressBar.setAttribute("aria-valuenow", percentComplete);
            }
        };

        xhr.onload = () => {
            if (xhr.status === 200) {
                console.log("Image uploaded successfully!");
            } else {
                console.error("Image upload failed: " + xhr.statusText);
            }
            progressWrapper.style.display = "none";
        };

        xhr.onerror = () => {
            console.error("Image upload failed due to a network error.");
            progressWrapper.style.display = "none";
        };

        xhr.send(formData);
    }

    function removeImage() {
        preview.src = "";
        preview.style.display = "none";
        removeButton.style.display = "none";
        progressWrapper.style.display = "none";
        fileInput.value = ""; // Clear file input

        // Optionally, you can send a request to remove the image from the server
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/remove-profile-picture", true);
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
        xhr.onload = () => {
            if (xhr.status === 200) {
                console.log("Image removed successfully!");
            } else {
                console.error("Image removal failed: " + xhr.statusText);
            }
        };
        xhr.send();
    }

    $("#saveUser").click(function (e) {
        e.preventDefault();
        console.log("Saving user details...");

        // Create a FormData object to handle both user data and file upload
        let formData = new FormData();
        formData.append("id", $("#userId").val());
        formData.append("username", $("#username").val());
        formData.append("name", $("#name").val());
        formData.append("email", $("#email").val());
        formData.append("password", $("#password").val());
        formData.append("password_confirmation", $("#confirmPassword").val());
        formData.append("address", $("#address").val());
        formData.append("region_id", $("#region").val());

        // Get selected roles as an array
        let selectedRoles = $("#roles").val(); // Assuming #roles is a <select> with 'multiple' attribute
        if (selectedRoles) {
            selectedRoles.forEach((role) => {
                formData.append("roles[]", role); // Append each role to FormData as an array
            });
        }

        // Append the profile picture if it exists
        const fileInput = document.getElementById("profilePicture");
        if (fileInput.files.length > 0) {
            formData.append("profile_picture", fileInput.files[0]);
        }

        // Validate form data
        if (
            !formData.get("username") ||
            !formData.get("name") ||
            !formData.get("email") ||
            formData.get("password") !== formData.get("password_confirmation")
        ) {
            $("#userFormError").show();
            return;
        }

        $("#userFormError").hide();

        Swal.fire({
            title: "Are you sure?",
            text: "You are about to submit the user details.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, save it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/users/store", // Adjust this to your API route
                    type: "POST",
                    data: formData,
                    contentType: false, // Important for FormData
                    processData: false, // Important for FormData
                    success: function (response) {
                        Toastify({
                            text: "User saved successfully!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#28a745",
                        }).showToast();

                        $("#modalForm").modal("hide");
                        $("#userForm")[0].reset();
                        $("#users_table").DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        let errorMessage =
                            "Error saving user. Please try again.";

                        // Check if the response contains JSON data
                        try {
                            let responseJSON = JSON.parse(xhr.responseText);
                            if (responseJSON.message) {
                                errorMessage = responseJSON.message;
                            } else if (responseJSON.errors) {
                                // Collect all error messages if there are validation errors
                                errorMessage = Object.values(
                                    responseJSON.errors
                                )
                                    .flat()
                                    .join(", ");
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
                    },
                });
            }
        });
    });
});

function addEmail(username) {
    console.log(username, "username");
    // Open a modal to add an email for the given user ID
    $("#addEmailModal").modal("show");

    // You can load user data or just provide an input field to add an email
    $("#username").val(username); // Set userId to a hidden input in the modal
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

function tambahUser() {
    $("#modalForm").modal("show");
    $("#passwordFields").show();
    $("#checboxForm").hide();
}

function fetchRegions() {
    // Fetch regions from your API or server
    fetch("/regions/data") // Update the URL to your API endpoint
        .then((response) => response.json())
        .then((data) => {
            const regionSelect = document.getElementById("region");
            regionSelect.innerHTML = '<option value="">Select Region</option>'; // Reset options

            data.forEach((region) => {
                const option = document.createElement("option");
                option.value = region.id;
                option.textContent = region.name;
                regionSelect.appendChild(option);
            });
        })
        .catch((error) => console.error("Error fetching regions:", error));
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
function editUser(id) {
    $.ajax({
        url: "/users/" + id + "/edit", // Update the URL to match your route
        method: "GET",
        success: function (response) {
            console.log(response.roles, "response");
            // Populate the form fields
            $("#userId").val(response.id);
            $("#username").val(response.username);
            $("#name").val(response.name);
            $("#email").val(response.email);
            $("#roles").val(response.roles).trigger("change"); // Set selected values and trigger change event to update the select2 or similar plugins if used
            $("#address").val(response.address);
            $("#region").val(response.region).trigger("change");

            // Clear previous error messages
            $("#passwordError").hide();
            $("#userFormError").hide();

            // Clear password fields
            $("#password").val("");
            $("#confirmPassword").val("");

            // Show the modal
            $("#modalForm").modal("show");
        },
        error: function () {
            alert("Error fetching user data.");
        },
    });
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
