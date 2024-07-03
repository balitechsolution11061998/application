$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formContent = document.createElement("div");
    formContent.innerHTML = `
    <form id="formUser" class="form">
        <!--begin::Scroll-->
        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

            <div class="row">
                <!-- Column 1 -->
                <div class="col-md-6">
                      <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Username</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="username" id="username" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Username" />
                        <!-- Error message placeholder -->
                        <div id="username-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter your name" />
                        <!-- Error message placeholder -->
                        <div id="name-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" />
                        <!-- Error message placeholder -->
                        <div id="email-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group for password-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter your password" />
                            <button type="button" id="generatePassword" class="btn btn-primary btn-sm">
                                <i class="fas fa-random"></i>
                            </button>
                            <button type="button" id="togglePassword" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <!-- Error message placeholder -->
                        <div id="password-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Confirm Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Re-enter your password" />
                        </div>
                        <!-- Error message placeholder -->
                        <div id="confirm-password-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Departments</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <select id="departments" name="departments" class="form-control form-control-solid mb-3 mb-lg-0">
                                <option value="">Select a department</option>
                            </select>
                        </div>
                        <!-- Error message placeholder -->
                        <div id="departments-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Jabatan</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group">
                            <select id="jabatan" name="jabatan" class="form-control form-control-solid mb-3 mb-lg-0">
                                <option value="">Select a jabatan</option>
                            </select>
                        </div>
                        <!-- Error message placeholder -->
                        <div id="jabatan-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">No Handphone</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="no_handphone" id="no_handphone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="0812345678" />
                        <!-- Error message placeholder -->
                        <div id="no_handphone_error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">NIK</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="nik" id="nik" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="1111222233334444" />
                        <!-- Error message placeholder -->
                        <div id="nik-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Join Date</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" name="join_date" id="join_date" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Please Input Join Date" />
                        <!-- Error message placeholder -->
                        <div id="join_date_error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Address</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea name="address" id="address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter your address"></textarea>
                        <!-- Error message placeholder -->
                        <div id="address-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">About Us</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea name="about_us" id="about_us" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Tell us about yourself"></textarea>
                        <!-- Error message placeholder -->
                        <div id="about_us-error" class="text-danger"></div>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Provinsi</label>
                        <select id="provinsi" name="provinsi" class="form-control form-control-solid mb-3 mb-lg-0 provinsiSelect"></select>
                        <div id="provinsi-error" class="text-danger"></div>
                    </div>

                    <div class="fv-row mb-7">
                        <!-- Kabupaten -->
                        <label class="required fw-semibold fs-6 mb-2">Kabupaten</label>
                        <div class="input-group">
                            <select id="kabupaten" name="kabupaten" class="form-control form-control-solid mb-3 mb-lg-0"></select>
                        </div>
                        <div id="kabupaten-error" class="text-danger"></div>
                    </div>

                    <div class="fv-row mb-7">
                        <!-- Kecamatan -->
                        <label class="required fw-semibold fs-6 mb-2">Kecamatan</label>
                        <div class="input-group">
                            <select id="kecamatan" name="kecamatan" class="form-control form-control-solid mb-3 mb-lg-0"></select>
                        </div>
                        <div id="kecamatan-error" class="text-danger"></div>
                    </div>

                    <div class="fv-row mb-7">
                        <!-- Kelurahan -->
                        <label class="required fw-semibold fs-6 mb-2">Kelurahan</label>
                        <div class="input-group">
                            <select id="kelurahan" name="kelurahan" class="form-control form-control-solid mb-3 mb-lg-0"></select>
                        </div>
                        <div id="kelurahan-error" class="text-danger"></div>
                    </div>
                </div>
            </div>

            <!--begin::Input group-->
            <div class="mb-5">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-5">Role</label>
                <!--end::Label-->
                <!--begin::Roles-->
                <!--begin::Input row-->
                <div class="d-flex fv-row">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" name="user_role" type="radio" value="0" id="kt_modal_update_role_option_0" checked='checked' />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="form-check-label" for="kt_modal_update_role_option_0">
                            <div class="fw-bold text-gray-800">Administrator</div>
                            <div class="text-gray-600">Best for business owners and company administrators</div>
                        </label>
                        <!--end::Label-->
                    </div>
                    <!--end::Radio-->
                </div>
                <!--end::Input row-->
                <div class='separator separator-dashed my-5'></div>
                <!--begin::Input row-->
                <div class="d-flex fv-row">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" name="user_role" type="radio" value="1" id="kt_modal_update_role_option_1" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="form-check-label" for="kt_modal_update_role_option_1">
                            <div class="fw-bold text-gray-800">Developer</div>
                            <div class="text-gray-600">Best for developers or people primarily using the API</div>
                        </label>
                        <!--end::Label-->
                    </div>
                    <!--end::Radio-->
                </div>
                <!--end::Input row-->
                <div class='separator separator-dashed my-5'></div>
                <!--begin::Input row-->
                <div class="d-flex fv-row">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" name="user_role" type="radio" value="2" id="kt_modal_update_role_option_2" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="form-check-label" for="kt_modal_update_role_option_2">
                            <div class="fw-bold text-gray-800">Analyst</div>
                            <div class="text-gray-600">Best for people who need full access to analytics data, but don't need to update business settings</div>
                        </label>
                        <!--end::Label-->
                    </div>
                    <!--end::Radio-->
                </div>
                <!--end::Input row-->
                <div class='separator separator-dashed my-5'></div>
                <!--begin::Input row-->
                <div class="d-flex fv-row">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" name="user_role" type="radio" value="3" id="kt_modal_update_role_option_3" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="form-check-label" for="kt_modal_update_role_option_3">
                            <div class="fw-bold text-gray-800">Support</div>
                            <div class="text-gray-600">Best for employees who regularly refund payments and respond to disputes</div>
                        </label>
                        <!--end::Label-->
                    </div>
                    <!--end::Radio-->
                </div>
                <!--end::Input row-->
                <div class='separator separator-dashed my-5'></div>
                <!--begin::Input row-->
                <div class="d-flex fv-row">
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" name="user_role" type="radio" value="4" id="kt_modal_update_role_option_4" />
                        <!--end::Input-->
                        <!--begin::Label-->
                        <label class="form-check-label" for="kt_modal_update_role_option_4">
                            <div class="fw-bold text-gray-800">Trial</div>
                            <div class="text-gray-600">Best for people who need to preview content data, but don't need to make any updates</div>
                        </label>
                        <!--end::Label-->
                    </div>
                    <!--end::Radio-->
                </div>
                <!--end::Input row-->
                <!--end::Roles-->
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Scroll-->
        <!--begin::Actions-->
        <div class="text-center pt-10">
            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
        <!--end::Actions-->
    </form>
`;




    // Append the form content to the element with the ID 'mdlFormContent'
    document.getElementById("formUsers").appendChild(formContent);
    fetchDepartments();
    fetchJabatan();

           // Initialize select2 on the provinsi field with multiple selection enabled
           $('#provinsi').select2({
            placeholder: 'Select a provinsi',
            allowClear: true,
            ajax: {
                url: '/provinsi/data', // Replace with your actual API endpoint
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.items, function (item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            console.log('Select2 event triggered'); // Debug log
            var provinsiId = e.params.data.id; // Get the selected option's ID
            fetchDataKabupaten(provinsiId);

            // Example of other actions based on selection
            console.log('Selected provinsi ID:', provinsiId);
        });


    $("#formUser").validate({
        rules: {
            username: {
                required: true,
                minlength: 7,
                maxlength: 10,
            },
            name: {
                required: true,
                minlength: 8,
            },
            email: {
                required: true,
                email: true,
            },
            user_role: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8,
                strongPassword: true, // Custom rule for strong password
            },
            confirm_password: {
                required: true,
                equalTo: "#password", // Validation to match password and confirm password
            },
            departments:{
                required: true,
            },
            provinsi:{
                required: true,
            },
            kabupaten:{
                required: true,
            },
            kecamatan:{
                required: true,
            },
            kelurahan:{
                required: true,
            },
            jabatan:{
                required: true,
            },
            no_handphone: {
                required: true,
                minlength: 12,
                maxlength:14,
                digits: true
            },
            nik: {
                required: true,
                minlength: 16,
                maxlength: 16,
                digits: true
            },
            join_date: {
                required: true,
                date: true
            }
        },
        messages: {
            username: {
                required: "Please enter a username name",
                minlength: "username must be at least 7 characters long",
                maxlength: "username must be exactly 10 digits long",
            },
            name: {
                required: "Please enter a full name",
                minlength: "Full name must be at least 8 characters long",
            },
            email: {
                required: "Please enter an email address",
                email: "Please enter a valid email address",
            },
            user_role: {
                required: "Please select a role",
            },
            password: {
                required: "Please enter a password",
                minlength: "Password must be at least 8 characters long",
                strongPassword: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one of the following characters: @",
            },
            confirm_password: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match",
            },
            departments: {
                required: "Please select departments",
            },
            jabatan: {
                required: "Please select jabatan",
            },
            provinsi: {
                required: "Please select provinsi",
            },
            kabupaten: {
                required: "Please select kabupaten",
            },
            kecamatan: {
                required: "Please select kecamatan",
            },
            kelurahan: {
                required: "Please select kelurahan",
            },
            no_handphone: {
                required: "Please enter your phone number",
                minlength: "Phone number must be at least 14 digits long",
                digits: "Phone number must contain only digits"
            },
            nik: {
                required: "Please enter your NIK",
                minlength: "NIK must be exactly 16 digits long",
                maxlength: "NIK must be exactly 16 digits long",
                digits: "NIK must contain only digits"
            },
            join_date: {
                required: "Please enter your join date",
                date: "Please enter a valid date"
            }
        },
        errorPlacement: function (error, element) {
            // Custom error placement below the input group
            if (element.attr("name") === "name") {
                error.appendTo("#name-error");
            } else if (element.attr("name") === "email") {
                error.appendTo("#email-error");
            } else if (element.attr("name") === "user_role") {
                error.appendTo("#user_role-error");
            } else if (element.attr("name") === "password") {
                error.appendTo("#password-error");
            }else if (element.attr("name") === "confirm_password") {
                error.appendTo("#confirm-password-error");
            }else if (element.attr("name") === "departments") {
                error.appendTo("#departments-error");
            }else if (element.attr("name") === "jabatan") {
                error.appendTo("#jabatan-error");
            }else if (element.attr("name") === "provinsi") {
                error.appendTo("#provinsi-error");
            }else if (element.attr("name") === "kabupaten") {
                error.appendTo("#kabupaten-error");
            }else if (element.attr("name") === "kecamatan") {
                error.appendTo("#kecamatan-error");
            }else if (element.attr("name") === "kelurahan") {
                error.appendTo("#kelurahan-error");
            }else if (element.attr("name") === "no_handphone") {
                error.appendTo("#no_handphone_error");
            }else if (element.attr("name") === "nik") {
                error.appendTo("#nik_error");
            }else if (element.attr("name") === "join_date") {
                error.appendTo("#join_date_error");
            }else if (element.attr("name") === "username") {
                error.appendTo("#username-error");
            }

            else {
                error.insertAfter(element); // Fallback to default placement
            }

            var name = element.attr("name");
            error.appendTo($("#" + name + "-error"));
        },
        submitHandler: function (form) {
            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit the form?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Form is valid, display a success toast
                    Toastify({
                        text: "Form submitted successfully!",
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        duration: 3000,
                    }).showToast();

                    // Prepare form data
                    var formData = $(form).serialize();

                    // Perform AJAX POST request
                    $.ajax({
                        type: 'POST',
                        url: '/users/store', // Update with your Laravel route
                        data: formData,
                        success: function (response) {
                            // Handle success response
                            console.log('Success:', response);
                            // Optionally, display another success toast or redirect
                        },
                        error: function (error) {
                            // Handle error response
                            // Optionally, display an error toast
                            Toastify({
                                text: "An error occurred while submitting the form.",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                duration: 3000,
                            }).showToast();
                        }
                    });
                }
            });
        },
        invalidHandler: function (event, validator) {
            console.log(event, validator);

            // Iterate over the invalid fields to find empty inputs
            let emptyFields = [];
            $.each(validator.errorList, function (index, error) {
                if (!$(error.element).val()) {
                    emptyFields.push(error.element);
                }
            });

            if (emptyFields.length > 0) {
                // Display a specific error message for empty inputs
                Toastify({
                    text: "Please fill out all required fields.",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    duration: 3000,
                }).showToast();
            } else {
                // Display a generic error message
                Toastify({
                    text: "Please correct the errors in the form.",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    duration: 3000,
                }).showToast();
            }
        },
    });

    // Add custom method for strong password validation
    $.validator.addMethod("strongPassword", function (value, element) {
        return this.optional(element) ||
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@])[A-Za-z\d@]{8,}$/.test(value);
    }, "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one of the following characters: @");

    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const passwordIcon = this.querySelector('i');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = "password";
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    });

    // Generate password
    document.getElementById('generatePassword').addEventListener('click', function () {
        const password = generatePassword();
        document.getElementById('password').value = password;

        // Display a toast notification for the generated password
        Toastify({
            text: "Password generated successfully!",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            duration: 3000,
        }).showToast();
    });

});



function showError(message) {
    const errorElement = document.getElementById('departments-error');
    errorElement.textContent = message;
}

// Function to generate a random password
function generatePassword() {
    const length = 12;
    const charset =
        "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
    let password = "";
    for (let i = 0, n = charset.length; i < length; ++i) {
        password += charset.charAt(Math.floor(Math.random() * n));
    }
    return password;
}

function fetchJabatan() {
    fetch('/jabatan/data')  // Replace with your actual API endpoint
        .then(response => response.json())
        .then(data => {
            if (data.items) {
                populateJabatan(data.items);
            } else {
                showError('No jabatan found.');
            }
        })
        .catch(error => {
            showError('Error fetching jabatan.');
        });
}

function fetchDepartments() {
    fetch('/departments/data')  // Replace with your actual API endpoint
        .then(response => response.json())
        .then(data => {
            if (data && Array.isArray(data)) {
                populateDepartments(data);
            } else {
                showError('No departments found.');
            }
        })
        .catch(error => {
            console.error('Error fetching departments:', error);
            showError('Error fetching departments.');
        });
}

function populateJabatan(jabatan) {
    const jabatanDropdown = document.getElementById('jabatan');
    jabatan.forEach(jabatan => {
        const option = document.createElement('option');
        option.value = jabatan.kode_jabatan;  // Assuming each department has an 'id' field
        option.textContent = jabatan.name;  // Assuming each department has a 'name' field
        jabatanDropdown.appendChild(option);
    });
}

// Function to populate departments dropdown
function populateDepartments(departments) {
    const departmentsDropdown = document.getElementById('departments');
    departments.forEach(department => {
        const option = document.createElement('option');
        option.value = department.id;  // Assuming each department has an 'id' field
        option.textContent = department.name;  // Assuming each department has a 'name' field
        departmentsDropdown.appendChild(option);
    });
}

function fetchDataKabupaten(provinsiId) {
    $('#kabupaten').select2({
        placeholder: 'Select a kabupaten',
        allowClear: true,
        ajax: {
            url: '/kabupaten/data', // Replace with your actual API endpoint
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    provinsi_id: provinsiId,
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.items, function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    }),
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        }
    }).on('select2:select', function (e) {
        var kabupatenId = $(this).val();
        fetchDataKecamatan(kabupatenId);
    });
}

function fetchDataKecamatan(kabupatenId) {
    $('#kecamatan').select2({
        placeholder: 'Select a kecamatan',
        allowClear: true,
        ajax: {
            url: '/kecamatan/data', // Replace with your actual API endpoint
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    kabupaten_id: kabupatenId,
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.items, function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    }),
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        }
    }).on('select2:select', function (e) {
        var kecamatanId = $(this).val();
        fetchDataKelurahan(kecamatanId);
    });
}

function fetchDataKelurahan(kecamatanId) {
    $('#kelurahan').select2({
        placeholder: 'Select a kelurahan',
        allowClear: true,
        ajax: {
            url: '/kelurahan/data', // Replace with your actual API endpoint
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    kecamatan_id: kecamatanId,
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data.items, function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    }),
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        }
    });
}

