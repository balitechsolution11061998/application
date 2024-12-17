<style>
    /* Modal Styles */
    .modal-content {
        border-radius: 20px; /* Make the modal more rounded */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
        border-color: #28a745; /* Change focus border color to green */
        outline: none;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }

    .input-group button {
        border-radius: 20px;
        margin-left: 10px;
        background-color: #28a745; /* Change button background color to green */
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .input-group button:hover {
        background-color: #218838; /* Darker green on hover */
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
        background-color: #28a745; /* Change user message background to green */
        color: white;
        margin-left: auto;
    }

    .message.bot {
        background-color: #218838; /* Change bot message background to a darker green */
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
        background-color: #28a745; /* Change chat button background to green */
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
        background-color: #218838; /* Darker green on hover */
        transform: scale(1.05);
    }

    .chat-button i {
        font-size: 24px;
    }

    /* New styles for sender and recipient names */
    .message .sender-name {
        color: white;
        font-weight: bold;
    }

    .message .recipient-name {
        color: white;
        font-weight: bold;
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

    .typing-indicator .dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator .dot:nth-child(3) {
        animation-delay: 0.4s;
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
        background-color: #28a745; /* Change modal header background to green */
        color: white;
    }

    .modal-title {
        font-weight: bold;
    }

    .input-group {
        margin-top: 10px;
    }

    .input-group input {
        border-radius: 20px;
        padding: 10px 15px;
    }

    .input-group button {
        border-radius: 20px;
        padding: 10px 15px;
    }

    /* Recipient Selection Styles */
    .recipient-select {
        display: none; /* Initially hidden */
        margin-top: 10px;
    }

    .badge {
        display: inline-block;
        padding: 10px 15px; /* Increased padding */
        margin: 5px;
        border-radius: 12px;
        background-color: #28a745;
        color: white;
        cursor: pointer;
        font-size: 14px; /* Font size for better visibility */
    }

    .badge.selected {
        background-color: #218838; /* Darker green for selected */
    }
</style>

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
            <div class="modal-body">
                <div id="chat-container">
                    <!-- Chat messages will be displayed here -->
                </div>
                <div class="typing-indicator" id="typing-indicator" style="display: none;">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <div class="input-group mt-3">
                    <input type="text" id="message-input" class="form-control" placeholder="Type a message..." />
                    <button id="send-button" class="btn">Send</button>
                </div>
                <div class="recipient-select mt-3" id="recipient-select">
                    <label for="recipient">Send to:</label>
                    <div>
                        <span class="badge" data-id="1">IT <i class="fas fa-user"></i></span>
                        <span class="badge" data-id="2">MD <i class="fas fa-user"></i></span>
                        <span class="badge" data-id="3">DC <i class="fas fa-user"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let selectedRecipient = null; // Variable to hold the selected recipient ID

    // Fetch messages when the modal is opened
    var chatModal = document.getElementById('chatModal');
    chatModal.addEventListener('show.bs.modal', function() {
        fetchMessages();
        setInterval(fetchMessages, 10000); // Fetch messages every 10 seconds
    });

    function fetchMessages() {
        // Fetch messages for the selected recipient
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
                    receiver_id: selectedRecipient, // Send the selected recipient ID
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                messageInput.value = ''; // Clear input field
                fetchMessages(); // Refresh messages
                typingIndicator.style.display = 'none'; // Hide typing indicator
            });
        } else {
            alert("Please select a recipient and enter a message.");
        }
    });

    // Update selectedRecipient based on badge selection
    document.querySelectorAll('.recipient-select .badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const recipientId = this.getAttribute('data-id');
            if (selectedRecipient === recipientId) {
                selectedRecipient = null; // Deselect if already selected
                this.classList.remove('selected'); // Remove selected class
            } else {
                selectedRecipient = recipientId; // Set selected recipient ID
                document.querySelectorAll('.recipient-select .badge').forEach(b => b.classList.remove('selected')); // Remove selected class from all
                this.classList.add('selected'); // Add selected class to the clicked badge
            }
        });
    });

    // Show recipient selection when the send button is clicked
    document.getElementById('send-button').addEventListener('click', function() {
        const recipientSelect = document.getElementById('recipient-select');
        recipientSelect.style.display = 'block'; // Show recipient selection
    });
</script>