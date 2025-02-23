<div class="container mt-5 shadow-sm p-4 rounded bg-light">
    <h4 class="stepper-title text-primary mb-4">Manage Emails</h4>

    <div class="mb-4">
        <h5 class="text-secondary">Associated Emails:</h5>
        <ul class="list-group" id="email-list">
            @if (!$user || $user->userEmails->isEmpty())
                <li class="list-group-item text-danger text-center">No associated emails found.</li>
            @else
                @foreach ($user->userEmails as $email)
                    <li class="list-group-item d-flex justify-content-between align-items-center email-item">
                        <span>{{ $email->email }}</span>
                        <button class="btn btn-danger btn-sm" data-email-id="{{ $email->email }}"
                            onclick="removeEmail(event, this)">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </li>
                @endforeach
            @endif

        </ul>
    </div>

    <div class="mt-4">

        <label for="email" class="form-label text-dark">Add New Email</label>
        <div class="input-group">
            <input type="email" id="email" class="form-control" placeholder="Enter new email" required>
            <button type="button" class="btn btn-primary" id="addEmailBtn">
                <i class="fas fa-plus"></i> Add Email
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Email validation function
            function validateEmail(email) {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }

            // Add email function
            $("#addEmailBtn").click(function(e) {
                e.preventDefault();
                const email = $("#email").val();
                const username = $("#username").val();

                if (email === "" || !validateEmail(email)) {
                    Swal.fire({
                        icon: "warning",
                        title: "Invalid Email!",
                        text: "Please enter a valid email address.",
                    });
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: `Add this email: ${email} to the user?`,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, add it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/users/add-email",
                            method: "POST",
                            data: {
                                email: email,
                                username: username,
                                _token: $('meta[name="csrf-token"]').attr("content"),
                            },
                            success: function(response) {
                                if (response.success) {
                                    Toastify({
                                        text: "Email added successfully!",
                                        duration: 3000,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#28a745",
                                    }).showToast();

                                    $("#email-list").append(`
                                        <li class="list-group-item d-flex justify-content-between align-items-center email-item">
                                            <span>${email}</span>
                                            <button class="btn btn-danger btn-sm" data-email-id="${response.email_id}" onclick="removeEmail(event, this)">
                                                <i class="fas fa-trash-alt"></i> Remove
                                            </button>
                                        </li>
                                    `);

                                    $("#email").val(""); // Clear the input field
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.message,
                                        icon: "error",
                                    });
                                }
                            },
                            error: function() {
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

            // Remove email function with e.preventDefault()
            window.removeEmail = function(e, button) {
                e.preventDefault();

                const email = $(button).data("email-id"); // Get the email ID from data attribute

                const username = $("#username").val(); // Assuming there's an input with id="username"
                console.log(username, email, 'emailId'); // Log the email ID directly

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/users/delete-email`,
                            method: "POST",
                            data: {
                                username: username,
                                email: email, // Email ID to delete
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"), // CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    $(button).closest(".email-item")
                                        .remove(); // Remove the email item from the DOM
                                    Toastify({
                                        text: "Email removed successfully!",
                                        duration: 3000,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#dc3545",
                                    }).showToast();
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to remove email.",
                                    icon: "error",
                                });
                            },
                        });
                    }
                });
            };

        });
    </script>
@endpush

@push('styles')
    <style>
        /* Add margin between list items */
        .list-group-item {
            margin-bottom: 10px;
            /* Adjust this value for desired spacing */
        }

        /* Other styles remain the same */
        .list-group-item {
            padding: 10px;
            /* Set padding */
            border-radius: 10px;
            /* Rounded corners */
            border: 1px solid #dee2e6;
            background-color: #ffffff;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Hover animation */
        .list-group-item:hover {
            transform: translateY(-5px);
            /* Add a slight lift animation */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            /* Add shadow effect on hover */
            background-color: #f8f9fa;
        }

        /* Custom styles for email item */
        .email-item span {
            font-size: 1rem;
            font-weight: 500;
            color: #495057;
        }

        /* Button styling */
        .btn-danger {
            background-color: #dc3545;
            border-radius: 50px;
            transition: opacity 0.2s ease-in-out;
        }

        .btn-danger:hover {
            opacity: 0.85;
        }

        /* Input group styles */
        .input-group {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 0.25rem;
        }

        .input-group>input {
            border: none;
        }

        /* Stepper title */
        .stepper-title {
            font-weight: bold;
            font-size: 1.5rem;
            color: #007bff;
        }

        .email-list {
            font-family: 'Montserrat', sans-serif;
            /* or 'Roboto' if preferred */
        }

        .email-item span {
            font-weight: bold;
            font-size: 1rem;
            /* Adjust the size as needed */
        }

        .email-item {
            background-color: #f8f9fa;
            /* Light background for the items */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
            transition: box-shadow 0.3s ease;
        }

        .email-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            font-weight: bold;
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        h5.text-secondary {
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
            color: #6c757d;
            /* Secondary text color */
        }
    </style>
@endpush
