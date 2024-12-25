@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
<style>
    /* Existing styles... */
    .calendar-container {
        margin-top: 20px;
    }
    .calendar-card {
        border: 1px solid #e0e0e0; /* Light border for the card */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        overflow: hidden; /* Prevent overflow */
        background-color: #ffffff; /* Set card background to white */
    }
    .calendar-header {
        background-color: #28a745; /* Green color for header */
        color: white; /* White text */
        padding: 15px; /* Padding for header */
        text-align: center; /* Centered text */
    }
    .calendar-footer {
        padding: 10px; /* Padding for footer */
        text-align: right; /* Right-aligned footer */
    }
    .fc-event {
        border-radius: 10px; /* Make events rounded */
        display: flex; /* Flexbox for alignment */
        align-items: center; /* Center items vertically */
        padding: 5px; /* Padding for events */
        color: white; /* White text for events */
        background-color: #28a745; /* Green background for events */
    }
    .fc-event i {
        margin-right: 5px; /* Space between icon and text */
    }
    .po-rcv-card {
        border: 1px solid #e0e0e0; /* Light border for PO/RCV card */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        background-color: #ffffff; /* Set card background to white */
        padding: 20px; /* Padding for card content */
        margin-bottom: 20px; /* Space below the card */
    }
    /* Modal styles */
    .modal-body {
        color: black; /* Set text color to black */
        font-family: 'Arial', sans-serif; /* Set font style */
    }
    .modal-title {
        font-weight: bold; /* Bold title */
    }
</style>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10"> <!-- Adjusted column width for more space -->
            <div class="card rounded shadow border-0">
                <div class="card-body text-center">
                    <div class="header">
                        <i class="fas fa-warehouse icon mb-3"></i> <!-- Font Awesome icon -->
                        <h1 class="card-title">Welcome to Portal Supplier</h1>
                        <p class="card-text">(Supplier Management System) PT. Global Retailindo Pratama</p>
                    </div>
                    <div class="welcome-image mb-4">
                        <img src="{{ asset('img/background/portalsupplier.png') }}" alt="Welcome Image" class="img-fluid rounded" />
                    </div>
                    <a href="#" class="btn btn-primary btn-lg"><i class="fas fa-arrow-right"></i> Get Started</a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="po-rcv-card">
                        <h5 class="text-center">Total Purchase Orders</h5>
                        <p class="text-center">10</p> <!-- Replace with dynamic data -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="po-rcv-card">
                        <h5 class="text-center">Total Receivings</h5>
                        <p class="text-center">5</p> <!-- Replace with dynamic data -->
                    </div>
                </div>
            </div>

            <!-- FullCalendar Section with Card Design -->
            <div class="calendar-container">
                <div class="calendar-card">
                    <div class="calendar-header">
                        <h3 class="mb-0"><i class="fas fa-calendar-alt"></i> Delivery Schedule</h3> <!-- Calendar icon -->
                    </div>
                    <div id="calendar"></div>
                    <div class="calendar-footer">
                        <button class="btn btn-secondary" onclick="alert('Add new event functionality here!')">Add Event</button>
                    </div>
                </div>
            </div>

            <div class="footer">
                <p>&copy; 2024 PT. Global Retailindo Pratama. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Event Details -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="loading-spinner" id="loadingSpinner" style="display: none;">
                    <i class="fas fa-spinner fa-spin fa-2x"></i> <!-- Loading spinner -->
                </div>
                <p id="eventDescription"></p>
                <p><strong>Store:</strong> <span id="eventStore"></span></p>
                <p><strong>Tanggal Kirim:</strong> <span id="eventDeliveryDate"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                // Sample events with Font Awesome icons and additional properties
                {
                    title: 'Delivery 1',
                    start: '2024-12-25',
                    description: 'Delivery of goods to client A',
                    store: 'Store A',
                    deliveryDate: '2024-12-25',
                    extendedProps: {
                        icon: '<i class="fas fa-truck"></i>',
                    }
                },
                {
                    title: 'Delivery 2',
                    start: '2024-12-28',
                    description: 'Delivery of goods to client B',
                    store: 'Store B',
                    deliveryDate: '2024-12-28',
                    extendedProps: {
                        icon: '<i class="fas fa-truck"></i>',
                    }
                },
                {
                    title: 'Delivery 3',
                    start: '2024-12-30',
                    description: 'Delivery of goods to client C',
                    store: 'Store C',
                    deliveryDate: '2024-12-30',
                    extendedProps: {
                        icon: '<i class="fas fa-truck"></i>',
                    }
                }
            ],
            eventContent: function(arg) {
                return { html: arg.event.extendedProps.icon + ' ' + arg.event.title };
            },
            eventClick: function(info) {
                // Show loading spinner
                document.getElementById('loadingSpinner').style.display = 'flex';

                // Simulate a delay for loading (you can replace this with an actual AJAX call if needed)
                setTimeout(() => {
                    // Populate modal with event details
                    document.getElementById('eventDescription').innerText = info.event.extendedProps.description;
                    document.getElementById('eventStore').innerText = info.event.store;
                    document.getElementById('eventDeliveryDate').innerText = info.event.deliveryDate;

                    // Hide the loading spinner
                    document.getElementById('loadingSpinner').style.display = 'none';

                    // Show the modal
                    var myModal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
                    myModal.show();
                }, 1000); // Simulated delay of 1 second
            }
        });

        calendar.render();
    });
</script>
@endsection

@endsection
