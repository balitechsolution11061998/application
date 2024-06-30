function createUser() {
    $("#mdlForm").modal("show");
    $("#mdlFormTitle").html("Form User");
    $("#mdlFormContent").html("");
    var formContent = document.createElement("div");
    formContent.innerHTML = `
         <form id="formUser" class="form">
             <!--begin::Scroll-->
             <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                 <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fw-semibold fs-6 mb-2">Name</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0"
                        placeholder="Enter your name" />
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
                    <input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0"
                        placeholder="example@domain.com" />
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
                        <input type="password" name="password" id="password" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Enter your password" />
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
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Re-enter your password" />
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
                        <select id="departments" class="form-control form-control-solid mb-3 mb-lg-0">
                            <option value="">Select a department</option>
                        </select>
                    </div>
                    <!-- Error message placeholder -->
                    <div id="departments-error" class="text-danger"></div>
                    <!--end::Input-->
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
                         <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                 </button>
             </div>
             <!--end::Actions-->
         </form>
     `;

    // Append the form content to the element with the ID 'mdlFormContent'
    document.getElementById("mdlFormContent").appendChild(formContent);
    fetchDepartments();


    $("#formUser").validate({
        rules: {
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
        },
        messages: {
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
            }
            else {
                error.insertAfter(element); // Fallback to default placement
            }
        },
        submitHandler: function (form) {
            // Form is valid, display a success toast
            Toastify({
                text: "Form submitted successfully!",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                duration: 3000,
            }).showToast();

            // Submit the form
            form.submit();
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
