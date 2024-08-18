<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatify Modal</title>
    <link rel="stylesheet" href= "{{ asset('css/font-awesome.css') }}">
    <style>
        /* Custom CSS for chat modal */
        #chatifyModal .modal-dialog {
            max-width: 90%;
            height: 90%;
            margin: 0;
        }

        #chatifyModal .modal-content {
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-title img {
            width: 40px;
            margin-left: 10px;
        }

        .modal-body {
            display: flex;
            height: calc(100% - 56px);
            /* Adjust for modal footer height */
            overflow: hidden;
            background: #f4f5f7;
        }

        #contacts-sidebar {
            width: 350px;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
        }

        #contacts-sidebar .search-input {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        #contacts-sidebar .search-input input {
            border-radius: 20px;
            padding: 10px 15px;
        }

        #contacts-sidebar .list-group-item {
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
            color: black;
            font-weight: bold;
        }

        #contacts-sidebar .list-group-item:hover {
            background-color: #f1f1f1;
            color: black;
            font-weight: bold;
        }

        #contacts-sidebar .list-group-item .contact-name {
            font-weight: 600;
        }

        #chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        #profile-section {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            background-color: #e9ecef;
        }

        #profile-section .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }

        #profile-section .profile-pic img {
            width: 100%;
            height: auto;
        }

        #profile-section .profile-info {
            flex: 1;
        }

        #profile-section .profile-info .name {
            font-weight: 600;
            color: #333;
        }

        #profile-section .profile-info .status {
            color: #6c757d;
        }

        #chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .message {
            margin-bottom: 10px;
            position: relative;
        }

        .message.sent {
            text-align: right;
        }

        .message.received {
            text-align: left;
        }

        .message .bg-primary {
            background-color: #007bff;
            color: #ffffff;
        }

        .message .bg-light {
            background-color: #e9ecef;
            color: #333;
        }

        .message-time {
            display: block;
            font-size: 0.75rem;
            color: #adb5bd;
            margin-top: 5px;
        }

        #message-input-container {
            padding: 15px;
            background-color: #ffffff;
            border-top: 1px solid #dee2e6;
            display: flex;
            align-items: center;
        }

        #message-input {
            flex: 1;
            border-radius: 20px;
            border: 1px solid #dee2e6;
            padding: 10px;
        }

        #send-message {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            margin-left: 10px;
            background-color: #007bff;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        #send-message:hover {
            background-color: #0056b3;
        }

        .welcome-message {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 50px;
            background: linear-gradient(135deg, #007bff 0%, #00d2d3 100%);
            color: #ffffff;
            border-radius: 10px;
            width: 100%;
            height: 100%;
        }

        .welcome-message h3 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .welcome-message p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .welcome-message .btn {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: #ffffff;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .welcome-message .btn:hover {
            background-color: #218838;
        }

        .modal-footer {
            border-top: none;
            padding: 10px 15px;
            background-color: #f8f9fa;
        }

        .btn-close {
            background-color: #ffffff;
            border: none;
        }

        .btn-close:hover {
            background-color: #f1f1f1;
        }

        #loading-spinner {
            margin: 20px 0;
            font-size: 1.5em;
            color: #007bff;
            /* You can change the color */
        }
    </style>
</head>

<body>
    <div class="modal fade" id="chatifyModal" tabindex="-1" aria-labelledby="chatifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatifyModalLabel">Chatify <img src="{{ asset('image/logo.png') }}"
                            alt="Logo"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contacts-sidebar">
                        <div class="search-input">
                            <input type="text" id="user-search-input" class="form-control"
                                placeholder="Search users...">
                        </div>
                        <div id="loading-spinner" class="d-none text-center">
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                        </div>
                        <div class="list-group" id="search-results">
                            <!-- Contact list items will be dynamically added here -->
                        </div>
                    </div>
                    <div id="chat-area" style="display: none;">
                        <div id="profile-section">
                            <div class="profile-pic">
                                <img src="path/to/default-pic.jpg" alt="Profile Picture">
                            </div>
                            <div class="profile-info">
                                <div class="name">John Doe</div>
                                <div class="status">Online</div>
                            </div>
                        </div>
                        <div id="chat-messages">
                            <!-- Messages will be dynamically added here -->
                        </div>
                        <div id="message-input-container" class="d-flex align-items-center">
                            <input type="text" id="message-input" class="form-control me-2"
                                placeholder="Type a message">
                            <button id="send-message" class="btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <div class="welcome-message">
                        <h3>Welcome to Chat Bayu System!</h3>
                        <p>Select a contact to start a conversation.</p>
                        <button class="btn">Start Chat</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script>
        let selectedUserId = null;
        const loggedInUserId = {{ auth()->user()->id }};
        let allUsers = [];

        $(document).ready(function() {
            function hideChatArea() {
                $('#chat-area').hide();
                $('.welcome-message').show();
            }

            function showChatArea() {
                $('#chat-area').fadeIn();
                $('.welcome-message').hide();
            }

            $('#chatifyModal').on('show.bs.modal', function() {
                hideChatArea();
                $('#chat-messages').empty();

                $.ajax({
                    url: '/get-existing-chats',
                    method: 'GET',
                    success: function(response) {
                        const contacts = response.data;
                        let contactsHtml = '';

                        contacts.forEach(contact => {
                            let profilePic = contact.photo ? `${contact.photo}` :
                                'path/to/default-pic.jpg';
                            let statusClass = contact.active_status ? 'badge-success' :
                                'badge-secondary'; // Define classes for online and offline
                            let statusText = contact.active_status ?
                                '<i class="fas fa-circle me-1 text-white"></i> Online' :
                                'Offline'; // Define text for online and offline

                            contactsHtml += `
                <a href="#" class="list-group-item list-group-item-action" data-user-id="${contact.id}">
                    <div class="d-flex w-100 justify-content-between">
                        <img src="${profilePic}" class="rounded-circle" width="40" height="40">
                        <div class="ms-3">
                           <div class="contact-name fw-bold">${contact.name}</div>
<span class="badge ${statusClass} text-white fw-bold">${statusText}</span>
                        </div>
                    </div>
                </a>
            `;
                        });

                        $('#search-results').html(contactsHtml);
                    }
                });

            });

            $('#search-results').on('click', '.list-group-item', function() {
                console.log($(this).data('user-id'));
                selectedUserId = $(this).data('user-id');
                const contactName = $(this).find('.contact-name').text();
                $('#profile-section .name').text(contactName);
                $('#profile-section .profile-pic img').attr('src', $(this).find('img').attr('src'));
                showChatArea();
                loadChatMessages();
            });



            $('#send-message').on('click', function() {
                const messageText = $('#message-input').val();
                if (!messageText.trim()) return;

                $.ajax({
                    url: '/send-message',
                    method: 'POST',
                    data: {
                        user_id: selectedUserId,
                        message: messageText,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#message-input').val('');
                        $('#chat-messages').append(`
                            <div class="message sent">
                                <div class="bg-primary text-white p-2 rounded d-flex align-items-center">
                                    ${response.message.text}
                                    <span class="message-time ms-2">${formatTime(response.message.sent_at)}</span>
                                    <span class="ms-2">
                                        ${getIconByStatus(response.message.status)}
                                    </span>
                                </div>
                            </div>
                        `).scrollTop($('#chat-messages')[0].scrollHeight);
                    }
                });
            });

            function formatTime(datetime) {
                const date = new Date(datetime);
                return date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            // Function to initialize or update the user list
            function initializeUserList(users) {
                allUsers = users;
                const resultsContainer = $('#search-results');
                resultsContainer.empty(); // Clear existing results
                users.forEach(user => {
                    resultsContainer.append(`
                <div class="list-group-item">
                    <span class="contact-name">${user.name}</span>
                </div>
            `);
                });
            }

            // Function to return the appropriate icon based on message status
            function getIconByStatus(status) {
                switch (status) {
                    case 'sent':
                        return '<i class="fas fa-check text-white"></i>'; // Single checkmark
                    case 'delivered':
                        return '<i class="fas fa-check-double text-white"></i>'; // Double checkmarks
                    case 'read':
                        return '<i class="fas fa-check-double text-info"></i>'; // Double checkmarks with color change for 'read'
                    default:
                        return ''; // No icon for undefined status
                }
            }

            // Initially load the user list via Ajax


            $('#user-search-input').on('input', function() {
                const query = $(this).val().toLowerCase();
                const resultsContainer = $('#search-results');
                const spinner = $('#loading-spinner');

                // Filter locally first
                const filteredUsers = allUsers.filter(user => user.name.toLowerCase().includes(query));

                if (query.length > 0) {
                    if (filteredUsers.length > 0) {
                        // Show local results
                        resultsContainer.empty();
                        filteredUsers.forEach(user => {
                            resultsContainer.append(`
                        <div class="list-group-item">
                            <span class="contact-name">${user.name}</span>
                        </div>
                    `);
                        });
                    } else {
                        // Show spinner and make Ajax request
                        spinner.removeClass('d-none');
                        $.ajax({
                            url: '/search-users',
                            type: 'GET',
                            data: {
                                query: query
                            },
                            success: function(data) {

                                resultsContainer.empty(); // Clear existing results

                                if (data.data.length > 0) {
                                    // Update with Ajax results
                                    data.data.forEach(user => {
                                        resultsContainer.append(`
                                            <div class="list-group-item d-flex align-items-center"data-user-id="${user.id}">
                                                <img src="${user.photo}" alt="${user.name}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                                <span class="contact-name">${user.name}</span>
                                            </div>
                                        `);
                                    });
                                } else {
                                    resultsContainer.append(
                                        '<div class="list-group-item">No users found</div>');
                                }
                            },
                            complete: function() {
                                spinner.addClass('d-none'); // Hide spinner
                            }
                        });
                    }
                } else {
                    // Clear results if query is empty
                    resultsContainer.empty();
                    spinner.addClass('d-none'); // Hide spinner
                }
            });

            function loadChatMessages() {
                console.log(selectedUserId);
                $.ajax({
                    url: '/chat/' + selectedUserId,
                    method: 'GET',

                    success: function(response) {
                        $('#chat-messages').empty();
                        response.messages.forEach(message => {
                            const messageClass = message.sender_id == loggedInUserId ? 'sent' :
                                'received';
                            const messageBg = message.sender_id == loggedInUserId ?
                                'bg-primary' : 'bg-light';
                            const statusIcon = message.status;

                            $('#chat-messages').append(`
                                <div class="message ${messageClass}">
                                    <div class="${messageBg} text-white p-2 rounded">
                                        ${message.text}
                                        <span class="message-time">${formatTime(message.sent_at)}</span>
                                        ${getIconByStatus(statusIcon)}
                                    </div>
                                </div>
                            `).scrollTop($('#chat-messages')[0].scrollHeight);
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
