@extends('layouts.master')
@section('title', 'Purchase Order')
@section('content')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/responsive.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <style>
        .form-control {
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            /* Change to your desired focus color */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Optional shadow effect */
        }

        .input-group .btn {
            transition: background-color 0.3s ease;
        }

        .input-group .btn:hover {
            background-color: #0056b3;
            /* Darker shade on hover */
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title">Purchase Orders</h3>

                    </div>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="orderNo" class="form-label">Filter by Order No:</label>
                                <div class="input-group">
                                    <input type="text" id="orderNo"
                                        class="form-control form-control-sm rounded-pill border-primary"
                                        placeholder="Enter Order No" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="filterDate" class="form-label">Filter by Approval Date:</label>
                                <div class="input-group">
                                    <input type="text" id="filterDate"
                                        class="form-control form-control-sm rounded-pill border-primary"
                                        placeholder="Select date range" />
                                    <button id="filterButton" class="btn btn-primary btn-sm rounded-pill">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="po_tbl" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#po_tbl .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th>Order No</th>
                                    <th>Store</th>
                                    <th>Supplier</th>
                                    <th>Approval Date (PO Date)</th>
                                    <th>Expired Date</th>
                                    <th>Status</th>
                                    <th>Action</th> <!-- New column for Detail button -->
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold" id="purchase-order-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Date Picker Modal -->
    <div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="datePickerModalLabel" style="color:white;">Select Confirmation Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="confirmation-date" class="form-control" placeholder="YYYY-MM-DD" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDateButton" class="btn btn-primary">Confirm Date</button>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize the date range picker
            $('#filterDate').daterangepicker({
                startDate: moment().subtract(29, "days"),
                endDate: moment(),
                ranges: {
                    "Today": [moment(), moment()],
                    "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1,
                        "month").endOf("month")]
                }
            });



            $('#datePickerModal').on('shown.bs.modal', function() {
                $('#confirmation-date').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minYear: 1901,
                    maxYear: parseInt(moment().format("YYYY"), 10),
                    locale: {
                        format: 'YYYY-MM-DD' // Set the format
                    }
                }, function(start, end, label) {
                    // Removed the alert
                    console.log("Selected date:", start.format('YYYY-MM-DD'));
                });
            });

            // Initialize DataTable with server-side processing and responsive feature
            var table = $('#po_tbl').DataTable({
                processing: true,
                serverSide: true,
                responsive: true, // Enable responsive feature
                deferRender: true,
                ajax: {
                    url: '/purchase-orders/data', // Adjust the URL as necessary
                    type: 'GET',
                    data: function(d) {
                        // Add the date range and order number to the request data
                        var dateRange = $('#filterDate').val();
                        if (dateRange) {
                            var dates = dateRange.split(' - ');
                            d.startDate = dates[0];
                            d.endDate = dates[1];
                        }
                        d.orderNo = $('#orderNo').val(); // Add order number filter
                    }
                },
                columns: [{
                        data: 'id',
                        render: function(data) {
                            return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" value="${data}"/>
                            </div>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order_no', // Ensure this matches the data returned from the server
                        render: function(data) {
                            return `
                            <div class="d-flex align-items-center">
                                <span class="badge bg-info" style="padding: 5px 10px; color: #fff;">
                                    <i class="fas fa-file-invoice me-1"></i>
                                    ${data}
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'store_name',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-store me-1" style="color: #000;"></i>
                                <span class="badge bg-primary" style="padding: 5px 10px; color: #fff;">
                                    ${data} (${row.store})
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'supp_code',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-truck me-1" style="color: #000;"></i>
                                <span class="badge bg-primary" style="padding: 5px 10px; color: #fff;">
                                    ${row.supp_name} (${data})
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'approval_date',
                        render: function(data) {
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                locale: 'id-ID'
                            };
                            const date = new Date(data);
                            const formattedDate = date.toLocaleDateString('id-ID', options);

                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-1" style="color: black;"></i>
                                <span class="badge bg-success" style="padding: 5px 10px; color: black;">
                                    ${formattedDate}
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'not_after_date',
                        render: function(data) {
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                locale: 'id-ID'
                            };
                            const date = new Date(data);
                            const formattedDate = date.toLocaleDateString('id-ID', options);

                            return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-times me-1" style="color: black;"></i>
                                <span class="badge bg-danger" style="padding: 5px 10px; color: black;">
                                    ${formattedDate}
                                </span>
                            </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'status',
                        render: function(data, row) {
                            let iconClass, badgeClass, iconColor, noReceivingText = '';

                            // Determine the icon and classes based on the status
                            if (data === 'Completed') {
                                iconClass = 'fas fa-check-circle';
                                badgeClass = 'bg-success';
                                iconColor = 'green';
                                noReceivingText =
                                    ` - No Receiving: ${row.no_receiving}`; // Only show No Receiving for Completed
                            } else if (data === 'Printed') {
                                iconClass = 'fas fa-print';
                                badgeClass = 'bg-success';
                                iconColor = 'green';
                            } else if (data === 'Expired') {
                                iconClass =
                                    'fas fa-exclamation-circle'; // Use a different icon for expired
                                badgeClass = 'bg-danger'; // Use a danger badge for expired
                                iconColor = 'red'; // Set the icon color to red
                            } else if (data === 'Progress') { // New condition for Progress
                                iconClass = 'fas fa-spinner fa-spin'; // Spinner icon for progress
                                badgeClass = 'bg-warning'; // Set badge to warning for progress
                                iconColor = 'orange'; // Set the icon color to orange
                            } else if (data === 'Confirmed') { // New condition for Confirmed
                                iconClass = 'fas fa-check'; // Check icon for confirmed
                                badgeClass = 'bg-info'; // Info badge for confirmed
                                iconColor = 'blue'; // Set the icon color to blue
                            } else {
                                iconClass = 'fas fa-clock';
                                badgeClass = 'bg-warning';
                                iconColor = 'orange';
                            }

                            return `
        <div class="d-flex align-items-center">
            <i class="${iconClass} me-1" style="color: ${iconColor};"></i>
            <span class="badge ${badgeClass}" style="padding: 5px 10px; color: #fff;">
                ${data}${noReceivingText} <!-- Display No Receiving only if Completed -->
            </span>
        </div>`;
                        },
                        orderable: false,
                        searchable: true
                    },

                    {
                        data: null, // Use null to create a custom action column
                        render: function(data, type, row) {
                            let buttonClass, buttonTitle, iconClass;

                            // Check the status of the row
                            if (row.status === 'Progress') {
                                buttonClass = 'btn-success confirm-button';
                                buttonTitle = 'Confirm Order';
                                iconClass = 'fas fa-check-circle';
                            } else {
                                buttonClass = 'btn-info detail-button';
                                buttonTitle = 'View Details';
                                iconClass = 'fas fa-info-circle';
                            }

                            return `
                                <button class="btn ${buttonClass} btn-sm" data-id="${row.order_no}" data-toggle="tooltip" title="${buttonTitle}">
                                    <i class="${iconClass}"></i>
                                </button>`;
                        },
                        orderable: false,
                        searchable: false
                    }


                ],
                order: [
                    [1, 'asc']
                ], // Default order by Order No
            });

            // Print functionality
            $('#printButton').on('click', function() {
                window.print();
            });

            // Filter button functionality
            $('#filterButton').on('click', function() {
                table.ajax.reload(); // Reload the DataTable with the new date range and order number
                toastr.success('Filters applied successfully!'); // Show success notification
            });

            // Detail button functionality
            $('#po_tbl').on('click', '.detail-button', function() {
                var orderNo = $(this).data('id');
                const orderNoString = orderNo.toString();
                const encodedOrderNo = btoa(orderNoString); // Base64 encode

                // Show SweetAlert with a loading spinner and no buttons
                Swal.fire({
                    title: "Redirecting...",
                    text: "Please wait while we load the order details.",
                    icon: "info",
                    showConfirmButton: false, // Hide the OK button
                    allowOutsideClick: false, // Prevent closing the modal
                    onBeforeOpen: () => {
                        Swal.showLoading(); // Show loading spinner
                    }
                });

                // Redirect to the detail page with encoded orderNo after a short delay
                setTimeout(function() {
                    window.location.href = `/purchase-orders/supplier/show/${encodedOrderNo}`;
                }, 1000); // 1 second delay before redirecting
            });


            $('#po_tbl').on('click', '.confirm-button', function() {
                var orderNo = $(this).data('id'); // Assuming this is an integer

                // Show SweetAlert with auto-close alert
                Swal.fire({
                    title: "Silahkan Konfirmasi Tanggal Terlebih Dahulu", // Updated title
                    timer: 1000,
                    timerProgressBar: true,
                    allowOutsideClick: false, // Prevent closing by clicking outside
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                        $('#datePickerModal').modal('show');

                        // Handle the date confirmation
                        $('#confirmDateButton').off('click').on('click', function() {
                            const date = $('#confirmation-date')
                        .val(); // Get the value from the input
                            if (!date) {
                                toastr.error('Please enter a confirmation date');
                            } else {
                                // Convert orderNo to string and encode it
                                const orderNoString = orderNo.toString();
                                const encodedOrderNo = btoa(orderNoString); // Base64 encode

                                // Show another SweetAlert for final confirmation
                                Swal.fire({
                                    title: 'Final Confirmation',
                                    text: "Are you sure you want to confirm this order with the selected date?",
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonColor: '#28a745',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, confirm it!',
                                    cancelButtonText: 'No, cancel!'
                                }).then((finalResult) => {
                                    if (finalResult.isConfirmed) {
                                        // Send the confirmation request to the server
                                        $.ajax({
                                            url: `/purchase-orders/supplier/confirm`, // Adjust the URL as necessary
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}', // Include CSRF token for security
                                                confirmation_date: date, // Send the confirmation date
                                                order_no: encodedOrderNo // Send the encoded order number
                                            },
                                            success: function(response) {
                                                toastr.success(
                                                    'Order confirmed successfully!'
                                                    );
                                                table.ajax
                                            .reload(); // Reload the DataTable to reflect changes
                                                $('#datePickerModal')
                                                    .modal(
                                                    'hide'); // Hide the modal
                                            },
                                            error: function(xhr) {
                                                // Check if the error is due to a network issue
                                                if (xhr.status === 0) {
                                                    toastr.error(
                                                        'Connection unstable. Please check your internet connection.'
                                                        );
                                                } else {
                                                    toastr.error(
                                                        'Error confirming order: ' +
                                                        xhr
                                                        .responseJSON
                                                        .message);
                                                }
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });




        });
    </script>
@endsection
@endsection
