<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatify Modal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        /* Custom CSS for chat modal */
        #chatifyModal .modal-dialog {
            max-width: 100%;
            height: 100%;
            margin: 0;
        }

        #chatifyModal .modal-content {
            height: 100%;
            border-radius: 0;
        }

        .modal-body {
            display: flex;
            height: calc(100% - 56px);
            /* Adjust height for footer */
        }

        #contacts-sidebar {
            width: 300px;
            border-right: 1px solid #dee2e6;
            background-color: #f8f9fa;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        #contacts-sidebar .search-input {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        #contacts-sidebar .search-input input {
            width: 100%;
            border: 1px solid #dee2e6;
            border-radius: 20px;
            padding: 8px 15px;
        }

        #contacts-sidebar .list-group {
            flex-grow: 1;
            overflow-y: auto;
        }

        #contacts-sidebar .list-group-item {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #contacts-sidebar .list-group-item:hover {
            background-color: #e9ecef;
        }

        #contacts-sidebar .list-group-item .contact-name {
            color: black;
            font-weight: bold;
        }

        #chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            display: none;
            /* Initially hide the chat area */
        }

        #chat-messages {
            flex: 1;
            overflow-y: auto;
            background-color: #343a40;
            padding: 15px;
            border-left: 1px solid #dee2e6;
            position: relative;
        }

        .message {
            animation: fadeInMessage 0.5s ease-out;
            margin-bottom: 15px;
        }

        .message.sent {
            text-align: right;
        }

        .message.received {
            text-align: left;
        }

        .message.sent .bg-primary {
            background-color: #007bff;
            color: white;
        }

        .message.received .bg-light {
            background-color: #495057;
            color: white;
        }

        #message-input-container {
            display: flex;
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
        }

        #message-input {
            border-radius: 20px;
            border: 1px solid #dee2e6;
            transition: border-color 0.3s ease;
            flex: 1;
            padding: 10px;
        }

        #message-input:focus {
            border-color: #007bff;
            outline: none;
        }

        #send-message {
            border-radius: 20px;
            border: none;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        #send-message:hover {
            background-color: #0056b3;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
        }

        /* Profile section */
        #profile-section {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
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
            font-weight: bold;
            color: black;
        }

        #profile-section .profile-info .status {
            color: gray;
        }

        /* Animations */
        @keyframes fadeInMessage {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="modal fade" id="chatifyModal" tabindex="-1" aria-labelledby="chatifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatifyModalLabel">Chatify <i class="fab fa-whatsapp"></i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contacts-sidebar">
                        <div class="search-input">
                            <input type="text" id="user-search-input" class="form-control"
                                placeholder="Search users...">
                        </div>
                        <div class="list-group" id="search-results">
                            <!-- Contact list items will be dynamically added here -->
                        </div>
                    </div>
                    <div id="chat-area">
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
                            <!-- Chat messages will be dynamically added here -->
                        </div>
                        <div id="message-input-container">
                            <input type="text" id="message-input" class="form-control"
                                placeholder="Type a message">
                            <button id="send-message" class="btn btn-primary"><i
                                    class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
    let selectedUserId = null;
    const loggedInUserId = {{ auth()->user()->id }};

$(document).ready(function() {
    function hideChatArea() {
        $('#chat-area').hide();
    }

    function showChatArea() {
        $('#chat-area').fadeIn();
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
                    let profilePic = contact.photo ? `${contact.photo}` : '/image/default-pic.jpg';
                    contactsHtml += `
                        <a href="#" class="list-group-item list-group-item-action" data-user-id="${contact.id}">
                            <div class="d-flex align-items-center">
                                <div class="profile-pic">
                                    <img src="${profilePic}" alt="Profile Picture" class="rounded-circle" width="30">
                                </div>
                                <div class="ms-2 contact-name">${contact.name}</div>
                            </div>
                        </a>`;
                });

                $('#search-results').html(contactsHtml);
            }
        });
    });

    $('#send-message').on('click', function() {
        const message = $('#message-input').val().trim();
        console.log('Message to send:', message);  // Debugging line
        console.log('Message to send:', selectedUserId);  // Debugging line

        if (message && selectedUserId) {
            $.ajax({
                url: '/send-message',
                method: 'POST',
                data: {
                    user_id: selectedUserId,
                    message: message,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        const messageContent = `
                            <div class="message sent">
                                <div class="d-inline-block p-2 bg-primary rounded">
                                    ${response.message.text}
                                </div>
                            </div>`;
                        $('#chat-messages').append(messageContent);
                        $('#message-input').val('');
                        scrollToBottom();
                    } else {
                        alert('Failed to send message. Please try again.');
                    }
                },
                error: function(xhr) {
                    alert('Message could not be sent. Please try again.');
                    console.error('Send message error:', xhr.responseText);
                }
            });
        } else {
            alert('Please select a user and enter a message.');
        }
    });

    $('#user-search-input').on('input', function() {
        const query = $(this).val();

        if (query.length > 2) {
            $.ajax({
                url: '/search-users',
                method: 'GET',
                data: {
                    query: query
                },
                success: function(response) {
                    const results = response.data;
                    let resultsHtml = '';

                    results.forEach(user => {
                        let profilePic = user.photo ? `${user.photo}` : '/image/default-pic.jpg';

                        resultsHtml += `
                            <a href="#" class="list-group-item list-group-item-action" data-user-id="${user.id}">
                                <div class="d-flex align-items-center">
                                    <div class="profile-pic">
                                        <img src="${profilePic}" alt="Profile Picture" class="rounded-circle" width="30">
                                    </div>
                                    <div class="ms-2 contact-name">${user.name}</div>
                                </div>
                            </a>`;
                    });

                    $('#search-results').html(resultsHtml).slideDown();
                }
            });
        } else {
            $('#search-results').empty().slideUp();
        }
    });

    $('#search-results').on('click', '.list-group-item', function(event) {
        event.preventDefault();

        selectedUserId = $(this).data('user-id');
        console.log('Message to send:', selectedUserId);  // Debugging line

        // Make the AJAX request to get the chat messages
        $.ajax({
            url: `/chat/${selectedUserId}`,
            method: 'GET',
            success: function(response) {
                const messages = response.messages;
                let messagesHtml = '';

                messages.forEach(message => {
                    // Check if the sender is the logged-in user
                    const messageClass = message.sender_id === loggedInUserId ? 'sent' : 'received';
                    const messageContent = `
                        <div class="message ${messageClass}">
                            <div class="d-inline-block p-2 ${messageClass === 'sent' ? 'bg-primary' : 'bg-light'} rounded">
                                ${message.text}
                            </div>
                        </div>`;
                    messagesHtml += messageContent;
                });

                // Update the chat messages HTML
                $('#chat-messages').html(messagesHtml);
                scrollToBottom();  // Scroll to the bottom after loading messages
                // Show the chat area after messages are loaded
                showChatArea();
            }
        });

        // Update the profile section with the selected contact's information
        const selectedContact = $(this).find('.contact-name').text();
        const profilePic = $(this).find('img').attr('src');

        $('#profile-section .profile-info .name').text(selectedContact);
        $('#profile-section .profile-pic img').attr('src', profilePic);
    });

    function scrollToBottom() {
        $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
    }
});
    </script>
</body>

</html>
