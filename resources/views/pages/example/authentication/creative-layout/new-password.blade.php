<x-auth-layout>

    @section('title')
    New Password
    @endsection

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ asset('assets/media/auth/bg3.jpg') }}');
            }

            [data-bs-theme="dark"] body {
                background-image: url('{{ asset('assets/media/auth/bg3-dark.jpg') }}');
            }

        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - New password -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!--begin::Aside-->
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <!--begin::Aside-->
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <!--begin::Logo-->
                    <a href="index.html" class="mb-7">
                        <div class="d-flex align-items-center">
                            <img alt="Logo" src="{{ asset('image/logo.png') }}" class="h-70px" />
                            <h1 class="ms-4 page-heading text-white fw-medium" style="font-family: Rubik; margin-bottom: -6px; font-size: 40px">
                                M Mart
                            </h1>
                        </div>
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h2 class="text-white fw-normal m-0">Modern Retail Store</h2>
                    <!--end::Title-->
                </div>
                <!--begin::Aside-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <!--begin::Card-->
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_new_password_form" data-kt-redirect-url="authentication/layouts/creative/sign-in.html" action="#">
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">Setup New Password</h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                                    <a href="{{ route('example.authentication.creative-layout.sign-in') }}" class="link-primary fw-bold">Sign in</a></div>
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-2"></i>
                                            <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <!--end::Input wrapper-->
                                    <!--begin::Meter-->
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                    <!--end::Meter-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Hint-->
                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group=-->
                            <!--end::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Repeat Password-->
                                <input type="password" placeholder="Repeat Password" name="confirm-password" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Repeat Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                    <span class="form-check-label fw-semibold text-gray-700 fs-6 ms-1">I Agree &
                                        <a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
                                </label>
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Action-->
                            <div class="d-grid mb-10">
                                <button type="button" id="kt_new_password_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Submit</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Footer-->
                    <div class="d-flex flex-stack px-lg-10">
                        <!--begin::Languages-->
                        <div class="me-0">
                            <!--begin::Toggle-->
                            <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
                                <span data-kt-element="current-lang-name" class="me-1">English</span>
                                <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
                            </button>
                            <!--end::Toggle-->
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/media/flags/united-states.svg') }}" alt="" />
                                        </span>
                                        <span data-kt-element="lang-name">English</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/media/flags/spain.svg') }}" alt="" />
                                        </span>
                                        <span data-kt-element="lang-name">Spanish</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/media/flags/germany.svg') }}" alt="" />
                                        </span>
                                        <span data-kt-element="lang-name">German</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/media/flags/japan.svg') }}" alt="" />
                                        </span>
                                        <span data-kt-element="lang-name">Japanese</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                        <span class="symbol symbol-20px me-4">
                                            <img data-kt-element="lang-flag" class="rounded-1" src="{{ asset('assets/media/flags/france.svg') }}" alt="" />
                                        </span>
                                        <span data-kt-element="lang-name">French</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Languages-->
                        <!--begin::Links-->
                        <div class="d-flex fw-semibold text-primary fs-base gap-5">
                            <a href="pages/team.html" target="_blank">Terms</a>
                            <a href="pages/pricing/column.html" target="_blank">Plans</a>
                            <a href="pages/contact.html" target="_blank">Contact Us</a>
                        </div>
                        <!--end::Links-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - New password-->
    </div>
    <!--end::Root-->
</x-auth-layout>
