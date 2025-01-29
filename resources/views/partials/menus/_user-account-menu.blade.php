<!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                <a href="{{ Auth::user()->profile_picture ?? asset('/img/logo/logo.png') }}" data-lightbox="user-image" data-title="User Profile Picture">
                    <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-' . substr(Auth::user()->email, 0, 1) . ' text-' . substr(Auth::user()->email, 0, 1)) }} rounded-circle overflow-hidden d-flex justify-content-center align-items-center">
                        <img src="{{ Auth::user()->profile_picture ?? asset('/img/logo/logo.png') }}" alt="User Profile Picture" class="img-fluid" style="width: 100%; height: auto; object-fit: cover;">
                    </div>
                </a>
            </div>

            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}
                </div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                    {{ Auth::user()->email }}
                </a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>

    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
			<span class="menu-title position-relative">Mode
			<span class="ms-5 position-absolute translate-middle-y top-50 end-0">{!! getIcon('night-day', 'theme-light-show fs-2') !!} {!! getIcon('moon', 'theme-dark-show fs-2') !!}</span></span>
		</a>
		@include('partials/theme-mode/__menu')
	</div>
    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sign Out
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <!--end::Menu item-->
</div>
<!--end::User account menu-->
