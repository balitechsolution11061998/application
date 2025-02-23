@push('styles')
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
<div class="container mt-5 shadow-sm p-4 rounded bg-light">
    <h4 class="stepper-title text-primary mb-4">Manage Store Information</h4>

    <div class="row">
        <label class="form-label">Select Store</label>

        <select class="form-select" data-control="select2" data-placeholder="Select an option" id="storeSelect"
            name="store_id">
            <option value="" disabled selected>Select a store</option>
            @foreach ($stores as $store)
                <option value="{{ $store->store }}">
                    <i class="fas fa-store"></i> {{ $store->store_name }} ({{ $store->store }})
                </option>
                </option>
            @endforeach
        </select>
    </div>

    <div class="mt-4">
        <button type="button" class="btn btn-primary btn-sm" id="saveStoreBtn">
            <i class="fas fa-save"></i> Save Store Information
        </button>
    </div>

    <hr class="my-4">

    <h5 class="text-secondary">Your Stores</h5>
    <div id="userStoresList" class="mt-3">
        @if (!$user || $user->userStore == null)
            <div class="alert alert-warning text-center">
                <strong>No Stores Found!</strong> You haven't saved any stores yet. Please select a store from the
                dropdown and save it.
            </div>
        @else
            @foreach ($user->userStore as $userStore)
                <div class="alert alert-info d-flex justify-content-between align-items-center"
                    data-id="{{ $userStore->id }}">
                    <span>{{ $userStore->stores->store_name }} - {{ $userStore->stores->store_add1 }},
                        {{ $userStore->stores->store_city }} (Region: {{ $userStore->stores->region }})</span>
                    <button class="btn btn-danger btn-sm" data-id="{{ $userStore->id }}"
                        onclick="deleteStore(event, this)">
                        <i class="fas fa-trash-alt"></i> Remove
                    </button>
                </div>
            @endforeach
        @endif

    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2


            // Save store information function
            $("#saveStoreBtn").click(function(e) {
                e.preventDefault();
                const storeId = $("#storeSelect").val();
                const username = $("#username").val();

                if (!storeId) {
                    Swal.fire({
                        icon: "warning",
                        title: "No Store Selected!",
                        text: "Please select a store.",
                    });
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: `Save the selected store with ID: ${storeId}`,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, save it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/stores/storeUser",
                            method: "POST",
                            data: {
                                username: username,
                                store_id: storeId,
                                _token: $('meta[name="csrf-token"]').attr("content"),
                            },
                            success: function(response) {
                                console.log(response, 'response');
                                if (response.success) {
                                    toastr.success(
                                        "Store information saved successfully!",
                                        "Success");

                                    // Clear the selection after saving
                                    $("#storeSelect").val(null).trigger('change');

                                    // Check if the store was newly created or updated
                                    if (response.message.includes("created")) {
                                        // Append new store to the list
                                        $("#userStoresList").append(`
                                <div class="alert alert-info d-flex justify-content-between align-items-center" data-id="${response.userStoreId}">
                                    <span>${response.store_name} (${response.store})</span>
                                    <button class="btn btn-danger btn-sm deleteStoreBtn" data-id="${response.userStoreId}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            `);
                                    }
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
                                    text: "An error occurred while saving the store information.",
                                    icon: "error",
                                });
                            },
                        });
                    }
                });
            });


            // Delete store function
            window.deleteStore = function(e, button) {
                e.preventDefault(); // Prevent the default action of the button

                const store_id = $(button).data('id'); // Get the store ID from the data attribute
                const username = $("#username").val(); // Get the username

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will delete the store information permanently.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/stores/deleteStoreUser", // Corrected URL
                            method: "POST",
                            data: {
                                store_id: store_id,
                                username: username,
                                _token: $('meta[name="csrf-token"]').attr("content"),
                            },
                            success: function(response) {
                                if (response.success) {
                                    Toastify({
                                        text: " Store information deleted successfully!",
                                        duration: 3000,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "#28a745",
                                        callback: function() {
                                            location
                                                .reload(); // Reload the page after the toast disappears
                                        }
                                    }).showToast();

                                    // Remove the deleted store from the list
                                    $(`#userStoresList .alert[data-id="${userStoreId}"]`)
                                        .remove();
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
                                    text: "An error occurred while deleting the store information.",
                                    icon: "error",
                                });
                            },
                        });
                    }
                });
            };

            // Attach the deleteStore function to the delete button click event
            $(document).on('click', '.deleteStoreBtn', function(e) {
                deleteStore(e, this); // Call the deleteStore function with the event and button reference
            });


        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Additional styles can be added here if needed */
        .form-control-solid {
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }

        .form-control {
            border-radius: 0.5rem;
            /* Rounded corners */
            border: 1px solid #ced4da;
            /* Border color */
            transition: border-color 0.2s;
            /* Smooth transition */
        }

        .form-control:focus {
            border-color: #80bdff;
            /* Focus border color */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
            /* Focus shadow */
        }

        .form-label {
            font-weight: bold;
            /* Bold label */
            margin-bottom: 0.5rem;
            /* Spacing below label */
        }

        /* Optional: Style for the dropdown options */
        select option {
            padding: 0;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
    </style>
@endpush
