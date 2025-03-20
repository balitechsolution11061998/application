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

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach (getGlobalAssets('css') as $path)
    {!! sprintf('
    <link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach (getVendors('css') as $path)
    {!! sprintf('
    <link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach (getCustomCss() as $path)
    {!! sprintf('
    <link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @stack('styles')
    <style>
        /* Custom styles for SweetAlert */
        .custom-swal {
            border-radius: 15px;
            /* Rounded corners */
            font-family: 'Arial', sans-serif;
            /* Change font if desired */
        }

        .custom-swal .swal2-popup {
            border-radius: 15px;
            /* Ensure the popup itself has rounded corners */
        }

        .swal2-title {
            font-size: 1.5em;
            /* Title font size */
            color: #333;
            /* Title color */
        }

        .swal2-html {
            font-size: 1em;
            /* Text font size */
            color: #555;
            /* Text color */
        }

        .swal2-confirm {
            background-color: #28a745;
            /* Green background for confirm button */
            color: white;
            /* White text for confirm button */
        }

        .swal2-cancel {
            background-color: #dc3545;
            /* Red background for cancel button */
            color: white;
            /* White text for cancel button */
        }

        .card-label {
            font-family: 'Arial', sans-serif;
            /* Ganti dengan font yang diinginkan */
            font-weight: bold;
            /* Ketebalan font */
            font-size: 1.5rem;
            /* Ukuran font */
            color: #ffffff;
            /* Warna teks (putih) */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            /* Efek bayangan teks */
            letter-spacing: 1px;
            /* Jarak antar huruf */
        }

        .custom-font-effect {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
        }

        .custom-large-text {
            font-size: 2.5rem;
            /* Sesuaikan ukuran sesuai kebutuhan */
        }

        .progress {
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            background-color: #e9ecef;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: width 0.5s ease-in-out;
        }
    </style>
</head>
<!--end::Head-->

<!--begin::Body-->

<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

    @include('partials/theme-mode/_init')

    @yield('content')

    {{-- @include('chat.index') --}}

    <!--begin::Javascript-->
    @foreach (getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach

    @foreach (getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach

    @foreach (getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach

    <script>
        var hostUrl = "{{ asset('/assets') }}/";
    </script>

    @stack('scripts')
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(error) {
                    console.log('ServiceWorker registration failed: ', error);
                });
            });
        }
    </script>
</body>
<!--end::Body-->

</html>