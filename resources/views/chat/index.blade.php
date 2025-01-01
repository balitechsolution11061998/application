<style>
    /* Modal Styles */
    .modal-content {
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .people-list {
        max-height: 400px;
        /* Set a max height for the contact list */
        overflow-y: auto;
        /* Enable scrolling */
    }

    #chat-container {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        height: 400px;
        overflow-y: auto;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .text-end {
        text-align: right;
        margin-bottom: 10px;
    }

    .text-start {
        text-align: left;
        margin-bottom: 10px;
    }

    .input-group {
        position: relative;
    }

    .input-group input {
        border-radius: 20px;
        border: 1px solid #ccc;
        padding: 10px;
        transition: border-color 0.3s;
    }

    .input-group input:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }

    .input-group button {
        border-radius: 20px;
        margin-left: 10px;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .input-group button:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .message {
        padding: 10px 15px;
        border-radius: 20px;
        max-width: 70%;
        display: inline-block;
        margin-bottom: 5px;
        font-size: 14px;
        line-height: 1.5;
        position: relative;
        transition: background-color 0.3s;
    }

    .message.user {
        background-color: #28a745;
        color: white;
        margin-left: auto;
    }

    .message.bot {
        background-color: #218838;
        color: white;
        margin-right: auto;
    }

    /* Profile Image */
    .profile-img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
        vertical-align: middle;
    }

    /* Chat Button */
    .chat-button {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        bottom: 20px;
        right: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .chat-button:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .chat-button i {
        font-size: 24px;
    }

    /* Typing Indicator Styles */
    .typing-indicator {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .typing-indicator .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #28a745;
        margin: 0 2px;
        animation: bounce 0.6s infinite alternate;
    }

    @keyframes bounce {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-10px);
        }
    }

    /* Additional styles for better aesthetics */
    .modal-header {
        background-color: #28a745;
        color: white;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .modal-title {
        font-weight: bold;
    }

    /* Recipient Selection Styles */
    .recipient-select {
        display: none;
        /* Initially hidden */
        margin-top: 10px;
    }

    .badge {
        display: inline-block;
        padding: 10px 15px;
        /* Increased padding */
        margin: 5px;
        border-radius: 12px;
        background-color: #28a745;
        color: white;
        cursor: pointer;
        font-size: 14px;
        /* Font size for better visibility */
        transition: background-color 0.3s;
    }

    .badge.selected {
        background-color: #218838;
        /* Darker green for selected */
    }

    .badge:hover {
        background-color: #218838;
        /* Darker green on hover */
    }

    .people-list {
        max-height: 500px;
        overflow-y: auto;
    }

    .list-group-item {
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item:hover {
        background-color: #f0f0f0;
    }
</style>

<!-- Chat Button -->
<!-- Chat Button -->
<button type="button" class="chat-button" data-bs-toggle="modal" data-bs-target="#chatModal">
    <i class="fas fa-comments"></i>
</button>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
                <!-- Contact List -->
                <div class="people-list"
                    style="width: 30%; border-right: 1px solid black;color:black; padding-right: 10px;">
                    <div class="recipient-select">
                        <label for="recipient">Contacts:</label>
                        <div id="contacts-list" class="list-group">
                            <span class="list-group-item badge" data-id="1">IT <i class="fas fa-user"></i></span>
                            <span class="list-group-item badge" data-id="2">MD <i class="fas fa-user"></i></span>
                            <span class="list-group-item badge" data-id="3">DC <i class="fas fa-user"></i></span>
                        </div>
                    </div>
                </div>
                <!-- Chat Area -->
                <div id="chat-container" style="width: 70%; padding-left: 10px;">
                    <div class="chat-history">
                        <!-- Chat messages will be displayed here -->
                    </div>
                    <div class="typing-indicator" id="typing-indicator" style="display: none;">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                    <div class="input-group mt-3">
                        <input type="text" id="message-input" class="form-control" placeholder="Type a message..." />
                        <input type="file" id="file-upload" class="file-upload" accept="*/*" />
                        <label for="file-upload" class="file-upload-label">Upload File</label>
                        <button id="send-button" class="btn">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let selectedRecipient = null; // Variable to hold the selected recipient ID

    // Initialize Pusher
    const pusher = new Pusher('200a3ba86105ed6ce25f', {
        cluster: 'ap1',
        encrypted: true
    });

    // Subscribe to the channel for the selected recipient
    const channel = pusher.subscribe('chat.' + selectedRecipient);

    // Listen for the MessageSent event
    channel.bind('MessageSent', function(data) {
        // Display the message in the chat
        fetchMessages(); // Refresh messages when a new message is received

        // Show desktop notification
        if (Notification.permission === "granted") {
            new Notification("New message from " + data.message.sender_id, {
                body: data.message.message,
                icon: '/path/to/icon.png' // Optional: Add an icon
            });
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    new Notification("New message from " + data.message.sender_id, {
                        body: data.message.message,
                        icon: '/path/to/icon.png' // Optional: Add an icon
                    });
                }
            });
        }
    });

    // Fetch messages when the modal is opened
    document.getElementById('send-button').addEventListener('click', function() {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value;

        if (message && selectedRecipient) {
            // Show typing indicator
            const typingIndicator = document.getElementById('typing-indicator');
            typingIndicator.style.display = 'flex';

            // Send message to the selected recipient
            fetch('/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: selectedRecipient,
                        message: message
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    messageInput.value = ''; // Clear input field
                    fetchMessages(); // Refresh messages for the selected recipient
                    typingIndicator.style.display = 'none'; // Hide typing indicator
                })
                .catch(error => {
                    typingIndicator.style.display = 'none'; // Hide typing indicator
                    toastr.error(error.message, 'Error'); // Show error message using Toastr
                });
        } else {
            toastr.warning("Please select a recipient and enter a message.",
                'Warning'); // Show warning using Toastr
        }
    });

    // Fetch messages for the selected recipient when the modal is opened
    var chatModal = document.getElementById('chatModal');
    chatModal.addEventListener('show.bs.modal', function() {
        fetchMessages(); // Fetch messages for the selected recipient
        setInterval(fetchMessages, 10000); // Fetch messages every 10 seconds
    });

    function fetchMessages() {
        console.log("masuk sini");
        const recipientId = selectedRecipient || '1'; // Default to IT if none selected
        fetch(`/fetch-messages/${recipientId}`)
            .then(response => response.json())
            .then(messages => {
                const chatContainer = document.getElementById('chat-container');
                chatContainer.innerHTML = ''; // Clear previous messages
                messages.forEach(message => {
                    const messageDate = new Date(message.created_at).toLocaleString();
                    const messageClass = message.sender_id === {{ auth()->id() }} ? 'user' : 'bot';
                    chatContainer.innerHTML += `
                    <div class="text-${messageClass === 'user' ? 'end' : 'start'}">
                        <div class="message ${messageClass}">
                            <img src="/img/logo/m-mart.svg" alt="Profile" class="profile-img">
                            ${message.message} <br>
                            <small class="${messageClass === 'user' ? 'sender-name' : 'recipient-name'}">
                                ${messageClass === 'user' ? 'You' : 'Supplier'} - ${messageDate}
                            </small>
                        </div>
                    </div>`;
                });
                chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll to the bottom
            });
    }

    // Update selectedRecipient based on badge selection


</script>
