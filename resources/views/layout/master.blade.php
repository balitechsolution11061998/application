<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('settings.KT_APP_NAME') }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href=""/>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach(getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach(getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @stack('styles')
    <style>
        /* Add your existing styles here */
    </style>
</head>
<!--end::Head-->

<!--begin::Body-->
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

@include('partials/theme-mode/_init')

@yield('content')

<!-- Button to Open Chat Modal -->
<button id="openChatModal" class="btn btn-primary" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
    <i class="fas fa-comments" style="color: black;"></i> Chat
</button>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Chat with Us</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
                <!-- Contacts List -->
                <div class="contacts-list" style="width: 30%;">
                    <h6>Contacts</h6>
                    <ul class="list-group">
                        <li class="list-group-item" data-user="User 1">
                            <i class="fas fa-user-circle me-2" style="color: black;"></i>
                            User 1
                        </li>
                        <li class="list-group-item" data-user="User 2">
                            <i class="fas fa-user-circle me-2" style="color: black;"></i>
                            User 2
                        </li>
                        <li class="list-group-item" data-user="User 3">
                            <i class="fas fa-user-circle me-2" style="color: black;"></i>
                            User 3
                        </li>
                        <li class="list-group-item" data-user="User 4">
                            <i class="fas fa-user-circle me-2" style="color: black;"></i>
                            User 4
                        </li>
                    </ul>
                </div>

                <!-- Chat Area -->
                <div class="chat-area" style="width: 70%; padding-left: 10px;">
                    <div class="chat-container" id="chatContainer">
                        <div class="chat-message">
                            <div class="message sender">
                                <strong>Support:</strong> Welcome to our chat! How can we assist you today?
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" id="userMessage" placeholder="Type your message..." aria-label="User's message">
                        <button class="btn btn-primary" id="sendMessage" type="button">
                            <i class="fas fa-paper-plane" style="color: white;"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Javascript-->
@foreach(getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach

@foreach(getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach

@foreach(getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach

<script> var hostUrl = "{{ asset('/assets') }}/"; </script>

@stack('scripts')

<script>
    // Open chat modal with animation
    document.getElementById('openChatModal').addEventListener('click', function() {
        $('#chatModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#chatModal').modal('show');
    });

    // Send message to OpenAI
    document.getElementById('sendMessage').addEventListener('click', function() {
        const message = document.getElementById('userMessage').value;
        if (message.trim() === '') return;

        // Display user message
        const userMessageDiv = document.createElement('div');
        userMessageDiv.className = 'chat-message';
        userMessageDiv.innerHTML = `<div class="message receiver"><strong>You:</strong> ${message}</div>`;
        document.getElementById('chatContainer').appendChild(userMessageDiv);

        // Clear input
        document.getElementById('userMessage').value = '';

        // Send message to server
        fetch('/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ prompt: message }) // Change 'message' to 'prompt'
        })
        .then(response => response.json())
        .then(data => {
            // Display OpenAI response
            const responseMessageDiv = document.createElement('div');
            responseMessageDiv.className = 'chat-message';
            responseMessageDiv.innerHTML = `<div class="message sender"><strong>Support:</strong> ${data.choices[0].text}</div>`;
            document.getElementById('chatContainer').appendChild(responseMessageDiv);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
</body>
<!--end::Body-->

</html>
