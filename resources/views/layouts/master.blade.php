<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords"
        content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="http://preview.keenthemes.comindex.html" />
    <link rel="shortcut icon" href="{{ asset('img/logo/m-mart.svg') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables1/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global1/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css1/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /* Dark theme styles */
        body.dark-theme {
            background-color: #121212;
            /* Dark background */
            color: #ffffff;
            /* Light text */
        }

        .menu-gray-800 {
            background-color: #1e1e1e;
            /* Dark menu background */
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
            /* Light muted text */
        }

        .text-danger {
            color: #ff4d4d !important;
            /* Danger color for sign out */
        }

        .dropdown-menu {
            background-color: #343a40;
            /* Dark background */
        }

        .dropdown-menu .menu-link {
            color: #ffffff;
            /* White text for links */
        }

        .dropdown-menu .menu-link:hover {
            background-color: #495057;
            /* Darker background on hover */
            color: #ffffff;
            /* Keep text white on hover */
        }

        .separator {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            /* Light separator line */
        }
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">

    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header align-items-stretch mb-5 mb-lg-10" data-kt-sticky="true"
                    data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->
                    <div class="container-xxl d-flex align-items-center">
                        <!--begin::Heaeder menu toggle-->
                        <div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
                            <div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px"
                                id="kt_header_menu_mobile_toggle">
                                <i class="ki-duotone ki-abstract-14 fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <!--end::Heaeder menu toggle-->
                        <!--begin::Header Logo-->
                        <div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
                            <a href="index.html">
                                <img class="h-30px w-30px rounded" src="{{ asset('img/logo/m-mart.svg') }}"
                                    alt="" />
                            </a>
                        </div>
                        <!--end::Header Logo-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <!--begin::Navbar-->
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <!--begin::Menu wrapper-->
                                <div class="header-menu align-items-stretch" data-kt-drawer="true"
                                    data-kt-drawer-name="header-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                                    data-kt-drawer-direction="start"
                                    data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                                    data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                    <!--begin::Menu-->
                                    <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0"
                                        id="#kt_header_menu" data-kt-menu="true">
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start"
                                            class="menu-item menu-lg-down-accordion me-0 me-lg-2">
                                            <!--begin:Menu link-->
                                            <a href="{{ route('home.supplier') }}" class="menu-link py-3">
                                                <span class="menu-title">Dashboards</span>
                                                <span class="menu-arrow d-lg-none"></span>
                                            </a>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start"
                                            class="menu-item menu-lg-down-accordion me-0 me-lg-2">
                                            <!--begin:Menu link-->
                                            <a href="{{ route('purchase-orders.supplier.getOrders') }}"
                                                class="menu-link py-3">
                                                <span class="menu-title">Purchase Order</span>
                                                <span class="menu-arrow d-lg-none"></span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start"
                                            class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                            <!--begin:Menu link-->
                                            <span class="menu-link py-3">
                                                <span class="menu-title">Receiving</span>
                                                <span class="menu-arrow d-lg-none"></span>
                                            </span>
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start"
                                            class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                            <!--begin:Menu link-->
                                            <span class="menu-link py-3">
                                                <span class="menu-title">RTV</span>
                                                <span class="menu-arrow d-lg-none"></span>
                                            </span>
                                        </div>
                                        <!--end:Menu item-->
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start"
                                            class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                            <!--begin:Menu link-->
                                            <span class="menu-link py-3">
                                                <span class="menu-title">Tanda Terima</span>
                                                <span class="menu-arrow d-lg-none"></span>
                                            </span>
                                        </div>
                                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="bottom-start"
                                            class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                            <!--begin:Menu link-->
                                            <a href="{{ route('users.supplier.profile', ['supplier' => urlencode(Auth::user()->username)]) }}"
                                                class="menu-link py-3">
                                                <i class="fas fa-user me-2"></i> <!-- Font Awesome icon -->
                                                <span class="menu-title">Profile</span>
                                                <span class="menu-arrow d-lg-none"></span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>


                                        <!--end:Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Navbar-->
                            <!--begin::Toolbar wrapper-->
                            <div class="topbar d-flex align-items-stretch flex-shrink-0">
                                <!--begin::User-->
                                <div class="d-flex align-items-center me-lg-n2 ms-1 ms-lg-3">
                                    <!--begin::Menu wrapper-->
                                    <div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px dropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img class="h-30px w-30px rounded-circle"
                                            src="{{ asset('img/logo/m-mart.svg') }}" alt="Profile Picture" />
                                    </div>
                                    <!--begin::User account menu-->
                                    <div
                                        class="dropdown-menu dropdown-menu-end menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px rounded-3 shadow">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content d-flex align-items-center px-3">
                                                <div class="symbol symbol-50px me-5">
                                                    <img alt="Profile Picture"
                                                        src="{{ asset('img/logo/m-mart.svg') }}"
                                                        class="rounded-circle" />
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-5 text-white">
                                                        {{ Auth::user()->username }}
                                                    </div>
                                                    <a href="#"
                                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <div class="separator my-2"></div>
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5">
                                            <a href="{{ route('users.profile') }}"
                                                class="menu-link px-5 text-white">My Profile</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <div class="menu-item px-5">
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                            <a href="#" class="menu-link px-5 text-danger"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                                Out</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <div class="separator my-2"></div>
                                        <!--begin::Theme Toggle-->
                                        <div class="menu-item px-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="themeToggle" />
                                                <label class="form-check-label text-white" for="themeToggle">Toggle
                                                    Light/Dark</label>
                                            </div>
                                        </div>
                                        <!--end::Theme Toggle-->
                                    </div>
                                    <!--end::User account menu-->
                                </div>
                                <!--end::User -->
                            </div>

                            <!--end::Toolbar wrapper-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Toolbar-->
                <div class="container">
                    @include('chat.index')
                    @yield('content')
                </div>

                <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div
                        class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-gray-900 order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">2024&copy;</span>
                            <a href="https://keenthemes.com" target="_blank"
                                class="text-gray-800 text-hover-primary">IT M M-Mart</a>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Menu-->
                        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                            <li class="menu-item">
                                <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                            </li>
                            <li class="menu-item">
                                <a href="https://devs.keenthemes.com" target="_blank"
                                    class="menu-link px-2">Support</a>
                            </li>
                            <li class="menu-item">
                                <a href="https://1.envato.market/Vm7VRE" target="_blank"
                                    class="menu-link px-2">Purchase</a>
                            </li>
                        </ul>
                        <!--end::Menu-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>


    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global1/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-campaign.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    @yield('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const themeToggle = document.getElementById("themeToggle");
            const currentTheme = localStorage.getItem("theme") || "light";
            document.body.classList.toggle("dark-theme", currentTheme === "dark");
            themeToggle.checked = currentTheme === "dark";

            themeToggle.addEventListener("change", function() {
                if (this.checked) {
                    document.body.classList.add("dark-theme");
                    localStorage.setItem("theme", "dark");
                } else {
                    document.body.classList.remove("dark-theme");
                    localStorage.setItem("theme", "light");
                }
            });
        });
    </script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
