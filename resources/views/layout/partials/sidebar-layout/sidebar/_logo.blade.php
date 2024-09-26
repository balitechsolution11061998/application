<!--begin::Logo-->
<div class="app-sidebar-logo px-6 rounded" id="kt_app_sidebar_logo">
    <!--begin::Logo image-->
    <a href="{{ route('home') }}">
        <div class="app-sidebar-logo-default d-flex align-items-center theme-light-show">
            <img alt="Logo" src="{{ asset(config('settings.KT_APP_LOGO', 'img/logo/logo.png')) }}" class="h-40px app-sidebar-logo-default rounded" />
            <div class="ms-3 app-sidebar-logo-default">
                <h1 class="page-heading text-gray-900 fw-semibold fs-1" style="font-family: Rubik; margin-bottom: -6px">
                    {{ config('settings.KT_APP_NAME') }}
                </h1>
                <small class="text-gray-700 fw-light" style="font-family: Rubik;">
                    {{ config('settings.KT_APP_SLOGAN') }}
                </small>
            </div>
        </div>
        <div class="app-sidebar-logo-default d-flex align-items-center theme-dark-show">
            <img alt="Logo" src="{{ asset(config('settings.KT_APP_LOGO', 'img/logo/logo.png')) }}" class="h-40px app-sidebar-logo-default rounded" />
            <div class="ms-3 app-sidebar-logo-default">
                <h1 class="page-heading text-gray-900 fw-semibold fs-1" style="font-family: Rubik; margin-bottom: -6px">
                    {{ config('settings.KT_APP_NAME') }}
                </h1>
                <small class="text-gray-800 fw-light" style="font-family: Rubik;">
                    {{ config('settings.KT_APP_SLOGAN') }}
                </small>
            </div>
        </div>
        <img alt="Logo" src="{{ asset(config('settings.KT_APP_LOGO', 'img/logo/logo.png')) }}" class="h-30px app-sidebar-logo-minimize rounded" />
    </a>
    <!--end::Logo image-->

    <!--begin::Sidebar toggle-->
    <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate rounded-circle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
        {!! getIcon('black-left-line', 'fs-3 rotate-180 ms-1') !!}
    </div>
    <script type="text/javascript">
        var sidebar_toggle = document.getElementById("kt_app_sidebar_toggle");  // Get the sidebar toggle button element
        @if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on")
            document.body.setAttribute("data-kt-app-sidebar-minimize", "on");  // Set the 'data-kt-app-sidebar-minimize' attribute for the body tag
            sidebar_toggle.setAttribute("data-kt-toggle-state", "active");  // Set the 'data-kt-toggle-state' attribute for the sidebar toggle button
            sidebar_toggle.classList.add("active");  // Add the 'active' class to the sidebar toggle button
        @endif
    </script>
    <!--end::Sidebar toggle-->
</div>
<!--end::Logo-->
