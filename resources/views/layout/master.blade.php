<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->

<head>
    <base href="" />
    <title>{{ config('settings.KT_APP_NAME') }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <link rel="canonical" href="" />

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach (getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach (getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach (getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    <!--end::Custom Javascript-->
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/introjs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Evergreen+Memories&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" rel="stylesheet">

    <!--end::Javascript-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    @include('partials/theme-mode/_init')

    @yield('content')

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    @foreach (getGlobalAssets() as $path)
        {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used by this page)-->
    @foreach (getVendors('js') as $path)
        {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(optional)-->
    @foreach (getCustomJs() as $path)
        {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach

    <script>
        var hostUrl = "{{ asset('/assets') }}/";
    </script>

    {{-- custome js --}}
    <script src="{{ asset('js/intro.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/leaflet.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    {{-- <script src="{{ asset('js/tourguide.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>


    <!--end::Custom Javascript-->
    @stack('scripts')
    <!--end::Javascript-->


    <script>
        let chart;
        var calendar;
        // Enable Pusher logging to console for debugging
           // Enable Pusher logging to console for debugging
           Pusher.logToConsole = true;


        document.addEventListener('livewire:load', () => {
            Livewire.on('success', (message) => {
                toastr.success(message);
            });
            Livewire.on('error', (message) => {
                toastr.error(message);
            });

            Livewire.on('swal', (message, icon, confirmButtonText) => {
                if (typeof icon === 'undefined') {
                    icon = 'success';
                }
                if (typeof confirmButtonText === 'undefined') {
                    confirmButtonText = 'Ok, got it!';
                }
                Swal.fire({
                    text: message,
                    icon: icon,
                    buttonsStyling: false,
                    confirmButtonText: confirmButtonText,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
    const notificationIcon = document.querySelector('#kt_menu_item_wow');
    const dropdownMenu = document.querySelector('#kt_menu_notifications');

    // Function to generate notifications HTML
    function generateNotificationsHTML(notifications) {
        if (notifications.length === 0) {
            return '<p class="text-center">No notifications</p>';
        }

        return notifications.map(notification => `
            <li class="list-group-item">
                <a href="${notification.data.link || '#'}" class="text-decoration-none">
                    ${notification.data.message}
                    ${notification.read_at ? '<span class="badge bg-success">Read</span>' : '<span class="badge bg-warning">Unread</span>'}
                </a>
            </li>
        `).join('');
    }

    // Fetch notifications when clicking the notification icon
    notificationIcon.addEventListener('click', function () {
        console.log('Notification icon clicked');

        fetch('{{ route('notifications.fetch') }}')
            .then(response => response.json())
            .then(data => {
                console.log('Notifications data:', data); // Debugging line to ensure data is fetched
                dropdownMenu.innerHTML = generateNotificationsHTML(data);
                // Optionally, you could also handle visibility here
                dropdownMenu.classList.toggle('show'); // Toggle visibility for example
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                dropdownMenu.innerHTML = '<p class="text-center">Error loading notifications</p>';
            });
    });
});
    </script>

</body>
<!--end::Body-->

</html>
