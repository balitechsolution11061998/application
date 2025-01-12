<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
<div class="menu-item pt-5">
    <!--begin:Menu content-->
    <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Apps</span></div>
    <!--end:Menu content-->
</div>
<!--end:Menu item-->

@foreach($menus as $menu)
    @if($menu->type === 'item')
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs($menu->route) ? 'here show' : '' }} menu-accordion">
            <!--begin:Menu link-->
            <span class="menu-link {{ request()->routeIs($menu->route) ? 'active' : '' }}">
                <span class="menu-icon">
                    <i class="{{ $menu->icon }} {{ $menu->iconName }} fs-2"></i>
                </span>
                <span class="menu-title">{{ $menu->label }}</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->

            @if($menu->children->isNotEmpty())
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    @foreach($menu->children as $child)
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs($child->route) ? 'active' : '' }}" href="{{ route($child->route) }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ $child->label }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endforeach
                </div>
                <!--end:Menu sub-->
            @endif
        </div>
        <!--end:Menu item-->
    @endif
@endforeach

            <!--end:Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
