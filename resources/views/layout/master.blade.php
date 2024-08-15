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

    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fancybox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!--end::Javascript-->
</head>
<!--end::Head-->

<!--begin::Body-->

<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    @include('partials/theme-mode/_init')

    @yield('content')

<!-- Notification Detail Modal -->
<div class="modal fade" id="notificationDetailModal" tabindex="-1" aria-labelledby="notificationDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationDetailModalLabel">Notification Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="notificationDetailMessage"></p>
            </div>
        </div>
    </div>
</div>
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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


    <!--end::Custom Javascript-->
    @stack('scripts')
    <!--end::Javascript-->


    <script>
        let chart;
        var calendar;
        let chartInstance = null;
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
            <li class="list-group-item" data-id="${notification.id}">
                <a href="${notification.data.link || '#'}" class="text-decoration-none">
                    ${notification.data.message}
                    ${notification.read_at ? '<span class="badge bg-success">Read</span>' : '<span class="badge bg-warning">Unread</span>'}
                </a>
            </li>
        `).join('');
    }

    // Function to mark notification as read
    function markAsRead(notificationId) {
        fetch(`{{ route('notifications.markAsRead', '') }}/${notificationId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notification marked as read');
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    // Fetch notifications and update the dropdown menu
    notificationIcon.addEventListener('click', function () {
        console.log('Notification icon clicked');

        fetch('{{ route('notifications.fetch') }}')
            .then(response => response.json())
            .then(data => {
                console.log('Notifications data:', data);
                dropdownMenu.innerHTML = generateNotificationsHTML(data);
                dropdownMenu.classList.toggle('show'); // Toggle visibility for example
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                dropdownMenu.innerHTML = '<p class="text-center">Error loading notifications</p>';
            });
    });

    // Show notification details and mark as read
    dropdownMenu.addEventListener('click', function (event) {
        const listItem = event.target.closest('.list-group-item');
        if (listItem) {
            const notificationId = listItem.getAttribute('data-id');
            const notification = JSON.parse(listItem.getAttribute('data-notification'));

            // Show notification details in modal
            document.getElementById('notificationDetailMessage').textContent = notification.data.message;
            new bootstrap.Modal(document.getElementById('notificationDetailModal')).show();

            // Mark as read
            markAsRead(notificationId);
        }
    });
});

    </script>

</body>
<!--end::Body-->

</html>
