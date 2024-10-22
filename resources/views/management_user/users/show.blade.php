<x-default-layout>
    @section('title')
        Users Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.css">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>

    <!--begin::Stepper-->
    <div class="container-fluid">
        <div class="card border-0 rounded-lg shadow-sm p-4 w-100">
            <div class="card-body">
                <div class="stepper stepper-pills" id="kt_stepper_example_basic">
                    <!--begin::Nav-->
                    <div class="stepper-nav flex-center flex-wrap mb-12">
                        @for ($i = 1; $i <= 3; $i++)
                            <!--begin::Step {{ $i }}-->
                            <div class="stepper-item mx-4 my-2 {{ $i === 1 ? 'current' : '' }}" data-kt-stepper-element="nav" data-step="{{ $i }}">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px d-flex justify-content-center align-items-center bg-primary text-white rounded-circle">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">{{ $i }}</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label ms-3">
                                        <h4 class="stepper-title text-primary">Step {{ $i }}</h4>
                                        <div class="stepper-desc text-muted">
                                            {{ $i === 1 ? 'User Profile' : ($i === 2 ? 'Store Details' : 'Set Email') }}
                                        </div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step {{ $i }}-->
                        @endfor
                    </div>
                    <!--end::Nav-->
                    <input type="hidden" id="username" value="{{ $user ? $user->username : '' }}">

                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_stepper_example_basic_form">
                        <!--begin::Group-->
                        <div class="container-fluid w-100">
                            @for ($j = 1; $j <= 3; $j++)
                                <div data-kt-stepper-element="content" class="{{ $j === 1 ? 'current' : '' }} w-100">
                                    @if ($j === 1)
                                        @include('management_user.users.showProfile')
                                    @elseif ($j === 2)
                                        @include('management_user.users.store')
                                    @elseif ($j === 3)
                                        @include('management_user.users.email')
                                    @endif
                                </div>
                            @endfor
                        </div>
                        <!--end::Group-->

                        <!--begin::Actions-->
                        <div class="d-flex flex-stack mt-4">
                            <div class="me-2">
                                <button type="button" class="btn btn-light btn-active-light-primary rounded-pill" data-kt-stepper-action="previous">
                                    Back
                                </button>
                            </div>

                            <div>
                                <button type="button" class="btn btn-success me-2 rounded-pill" data-kt-stepper-action="submit" id="submit-button">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress" style="display: none;">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>

                                <button type="button" class="btn btn-primary rounded-pill" data-kt-stepper-action="next">
                                    Continue
                                </button>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>

    <!--end::Stepper-->

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.js"></script>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stepper = document.getElementById('kt_stepper_example_basic');
                const form = document.getElementById('kt_stepper_example_basic_form');
                const steps = stepper.querySelectorAll('[data-kt-stepper-element="nav"]');
                const contents = form.querySelectorAll('[data-kt-stepper-element="content"]');
                let currentStep = 0;

                // Check the URL to determine if we should start at step 2
                const currentUrl = window.location.pathname;
                if (window.location.href.includes('/addstore')) {
                    currentStep = 1; // Open step 2 on load
                }else if(window.location.href.includes('/addemail')){
                    currentStep = 2;
                }

                updateStep(currentStep);

                document.querySelectorAll('[data-kt-stepper-action]').forEach(button => {
                    button.addEventListener('click', function() {
                        const submitButton = document.getElementById('submit-button');
                        const indicatorProgress = submitButton.querySelector('.indicator-progress');

                        if (this.getAttribute('data-kt-stepper-action') === 'next') {
                            if (currentStep < steps.length - 1) {
                                currentStep++;
                                updateStep(currentStep);
                            }
                        } else if (this.getAttribute('data-kt-stepper-action') === 'previous') {
                            if (currentStep > 0) {
                                currentStep--;
                                updateStep(currentStep);
                            }
                        } else if (this.getAttribute('data-kt-stepper-action') === 'submit') {
                            // Show loading spinner
                            submitButton.setAttribute('disabled', 'disabled');
                            submitButton.classList.add('disabled');
                            indicatorProgress.style.display = 'block';
                        }
                    });
                });

                // Allow clicking on steps
                steps.forEach((step, index) => {
                    step.addEventListener('click', function() {
                        if (index !== currentStep) {
                            currentStep = index;
                            updateStep(currentStep);
                        }
                    });
                });

                function updateStep(stepIndex) {
                    // Hide all step contents
                    contents.forEach((content, index) => {
                        content.classList.remove('current');
                        steps[index].classList.remove('current');
                    });

                    // Show the current step content
                    contents[stepIndex].classList.add('current');
                    steps[stepIndex].classList.add('current');
                }
            });
        </script>
    @endpush
</x-default-layout>
