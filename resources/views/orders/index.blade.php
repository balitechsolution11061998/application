<x-default-layout>
    @section('title')
        Purchase Orders Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


        <style>
            /* Button styling with smooth transition */
            .sync-btn {
                display: flex;
                align-items: center;
                gap: 5px;
                transition: background-color 0.3s, transform 0.2s;
            }

            .sync-btn:hover {
                background-color: #0056b3;
                color: #fff;
                transform: scale(1.05);
            }

            /* Rotate animation for icon */
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .sync-btn.loading i {
                animation: spin 1s linear infinite;
                color: #ffdd57;
                /* Optional: Change color during loading */
            }

            /* General button styling for smooth transitions */
            .btn {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            /* Hover effect for scaling and shadow */
            .btn:hover {
                transform: scale(1.05);
                /* Slightly enlarges the button */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                /* Adds a shadow */
            }

            /* Optional: add different hover color effects based on button classes */
            .btn-info:hover {
                background-color: #17a2b8;
                /* Darker info color on hover */
                color: white;
            }

            .btn-success:hover {
                background-color: #28a745;
                /* Darker success color on hover */
                color: white;
            }

            .modal-content {
                border-radius: 10px;
                padding: 20px;
            }

            .modal-header {
                border-bottom: none;
                border-radius: 10px 10px 0 0;
            }

            .modal-footer {
                border-top: none;
            }

            .spinner-border {
                display: block;
                margin: auto;
            }

            /* Customize Leaflet Map appearance */
            #map {
                height: 500px;
                width: 100%;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }
        </style>
    @endpush
    @if (session('message'))
        <div class="alert alert-danger">
            <strong>{{ session('message') }}</strong>
            @if (session('error'))
                <p>{{ session('error') }}</p>
            @endif
        </div>
    @endif

    <!-- Card Start -->
    <div class="card rounded">
        <div class="card-header d-flex justify-content-between align-items-center bg-light border-bottom-0">
            <h5 class="card-title mb-0 text-primary">Purchase Orders Management</h5>
            <div class="d-flex align-items-center gap-2">
                <!-- Date Range Picker for Filtering -->
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-secondary">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" id="filterDateRange" class="form-control border-secondary"
                        placeholder="Select Date Range">
                </div>

                <!-- Input field for filtering by order_no -->
                <div class="input-group input-group-sm">
                    <input type="text" id="filterOrderNo" class="form-control form-control-sm border-secondary"
                        placeholder="Search by Order No.">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="filterDataBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Date Picker for Syncing -->
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-secondary">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="date" id="syncDatePicker" class="form-control border-secondary"
                        placeholder="Sync Date">
                </div>

                <!-- Sync data button -->
                <button class="btn btn-outline-primary btn-sm" id="syncDataBtn">
                    <i class="fas fa-sync-alt"></i> Sync Data
                </button>
            </div>
        </div>





        <div class="card-body">
            <!-- Search and Toolbar -->
            <div class="d-flex flex-stack mb-4">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"></i>
                    <input type="text" data-kt-docs-table-filter="search"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Orders" />
                </div>

            </div>

            <!-- DataTable -->
            <table id="po_table" class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-100px">...</th>
                        <th class="min-w-100px">ORDER NO</th>
                        <th class="text-end min-w-150px">STORE</th>
                        <th class="text-end min-w-100px">SUPPLIER</th>
                        <th class="text-end min-w-100px">APPROVAL DATE</th>
                        <th class="text-end min-w-100px">EXPIRED DATE</th>
                        <th class="text-end min-w-50px">Status</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <!-- SubTable Template -->

                </tbody>
            </table>
        </div>
    </div>
    <!-- Card End -->
    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Dynamic content will be injected here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')

        {{-- <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcWbh2Eng7P6-842kxBOUFiKGZt9x3WTA&v=beta&libraries=marker"
            async defer></script> --}}

        {{-- <script src="https://maps.googleapis.com/maps/api/js?key==beta&libraries=marker" async defer></script> --}}

        @foreach (getGlobalAssets() as $path)
            {!! sprintf('<script src="%s"></script>', asset($path)) !!}
        @endforeach
        @foreach (getVendors('js') as $path)
            {!! sprintf('<script src="%s"></script>', asset($path)) !!}
        @endforeach
        <script>
            document.getElementById('syncDataBtn').addEventListener('click', function() {
                const syncDate = document.getElementById('syncDatePicker').value;

                // Show confirmation dialog with SweetAlert2
                Swal.fire({
                    title: 'Sync Data?',
                    text: "Do you want to proceed with syncing data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, sync it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading modal with custom progress bar and spinner
                        Swal.fire({
                            title: 'Syncing and Saving Data...',
                            html: `
                    <div class="spinner" style="display: flex; justify-content: center; margin-bottom: 20px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #4caf50;"></i>
                    </div>
                    <div class="progress-bar-container" style="width: 100%; background-color: #f3f3f3; border-radius: 10px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <div id="progress" class="progress-inner" style="width: 0%; background-color: #4caf50; height: 20px; transition: width 0.3s ease;"></div>
                    </div>
                    <p id="progressText" style="font-size: 16px; font-weight: 500; color: #666; text-align: center;">Starting...</p>
                `,
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        const progressElem = document.getElementById('progress');
                        const progressText = document.getElementById('progressText');

                        // Step 1: Sync data from API with progress tracking
                        axios.get('https://supplier.m-mart.co.id/api/po/getData?filterDate=' + syncDate, {
                                onDownloadProgress: function(progressEvent) {
                                    if (progressEvent.lengthComputable) {
                                        const percentCompleted = Math.round((progressEvent.loaded *
                                            50) / progressEvent.total);
                                        progressElem.style.width = percentCompleted + '%';
                                        progressText.innerText = `Syncing data... ${percentCompleted}%`;
                                    }
                                }
                            })
                            .then(response => {
                                const responseData = response.data
                                    .data; // Adjust based on actual response structure

                                // Check if data is empty
                                if (!responseData || responseData.length === 0) {
                                    Swal.close(); // Close the progress modal
                                    toastr.warning('No data available to sync.', 'Sync Warning!', {
                                        closeButton: true,
                                        progressBar: true,
                                        timeOut: 5000
                                    });
                                    return; // Stop further execution
                                }

                                // Split data into chunks of 25 items
                                const chunkSize = 25;
                                const totalChunks = Math.ceil(responseData.length / chunkSize);
                                let currentChunk = 0;

                                // Step 2: Insert data chunks into the database with progress tracking
                                const interval = setInterval(() => {
                                    if (currentChunk < totalChunks) {
                                        const chunk = responseData.slice(currentChunk * chunkSize, (
                                            currentChunk + 1) * chunkSize);

                                        // Perform POST request for each chunk
                                        axios.post('/purchase-orders/store', {
                                                orders: chunk
                                            })
                                            .then(() => {
                                                currentChunk++;
                                                const percentCompleted = Math.round(50 + (
                                                    currentChunk / totalChunks * 50));
                                                progressElem.style.width = percentCompleted +
                                                    '%';
                                                progressText.innerText =
                                                    `Storing data... ${percentCompleted}%`;

                                                if (currentChunk >= totalChunks) {
                                                    clearInterval(
                                                        interval
                                                    ); // Stop interval when all chunks are processed

                                                    // Close the SweetAlert progress modal
                                                    Swal.close();

                                                    // Display a success toast notification
                                                    toastr.success(
                                                        'Data synchronized and saved successfully to the database.',
                                                        'Sync Complete!', {
                                                            closeButton: true,
                                                            progressBar: true,
                                                            timeOut: 5000
                                                        }
                                                    );

                                                    fetchData();
                                                }
                                            })
                                            .catch(postError => {
                                                clearInterval(
                                                    interval); // Stop interval on error
                                                Swal.fire({
                                                    title: 'Sync Failed',
                                                    text: 'An error occurred while storing the data in the database.',
                                                    icon: 'error',
                                                    confirmButtonText: 'Retry'
                                                });
                                            });
                                    }
                                }, 1000); // Insert 25 items per second
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Sync Failed',
                                    text: 'An error occurred while syncing data.',
                                    icon: 'error',
                                    confirmButtonText: 'Retry'
                                });
                            });
                    }
                });
            });



            $(document).ready(function() {
                fetchData();

                $('#filterDateRange').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    opens: 'left',
                    maxDate: moment().add(1,
                    'month'), // Membatasi hanya sampai satu bulan dari tanggal hari ini
                }, function(start, end) {
                    // Ketika pengguna memilih tanggal, update `maxDate` untuk membatasi hingga satu bulan dari `start`
                    $('#filterDateRange').data('daterangepicker').setEndDate(moment(start).add(1, 'month'));
                });

            });

            // Event Listener for the Filter Button
            $('#filterDataBtn').on('click', function() {
                fetchData();
            });

            function fetchData() {
                // Check if DataTable is already initialized
                if ($.fn.dataTable.isDataTable('#po_table')) {
                    // Destroy the existing DataTable instance
                    $('#po_table').DataTable().clear().destroy();
                }
                var table = $('#po_table').DataTable({
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    responsive: true,
                    ajax: {
                        url: '{{ route('purchase-orders.data') }}',
                        type: 'GET',
                        data: function(d) {
                            d.order_no = $('#filterOrderNo').val(); // Pass order number filter
                            d.filterDate = $("#filterDateRange").val();
                        }
                    },
                    columns: [{
                            data: null, // This will hold the buttons
                            orderable: false, // Disable sorting for this column
                            searchable: false, // Disable searching for this column
                            render: function(data, type, row) {
                                // HTML for the "Details" button
                                let buttons = `
                                    <button class="btn btn-sm btn-info detail-btn" data-id="${row.order_no}" onclick="showLoadingSpinner(this)">
                                        <i class="fas fa-info-circle"></i> Details
                                    </button>
                                `;

                                // Conditionally add the "Confirmed" button if status is "Progress"
                                if (row.status === 'Progress') {
                                    buttons += `
                                        <button class="btn btn-sm btn-success confirm-btn" data-id="${row.order_no}" onclick="showLoadingSpinner(this)">
                                            <i class="fas fa-check"></i> Confirmed
                                        </button>
                                    `;
                                }

                                // Conditionally add the "History Printed" button if status is "Printed"
                                if (row.status === 'Printed') {
                                    buttons += `
                                        <button class="btn btn-sm btn-primary history-btn" data-id="${row.id}" onclick="showLoadingSpinner(this)">
                                            <i class="fas fa-history"></i> History Printed
                                        </button>
                                    `;
                                }

                                return buttons;
                            }
                        }

                        ,


                        {
                            data: 'order_no',
                            name: 'order_no',
                            render: function(data, type, row) {
                                // If order_no exists, display it with styling; otherwise, show a default message
                                let displayText = '';

                                if (!data) {
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #ffebee; color: #d32f2f;">
                                            <i class="fas fa-exclamation-circle" style="font-size: 16px; color: #d32f2f;"></i>
                                            Order number not available
                                        </span>
                                    `;
                                } else {
                                    // Display order number with a clipboard icon
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #e0f7fa; color: #00796b;">
                                            <i class="fas fa-clipboard-list" style="font-size: 16px; color: #00796b;"></i>
                                            ${data}
                                        </span>
                                    `;
                                }

                                return displayText;
                            }
                        },
                        {
                            data: 'store_name', // Assuming you have store_name in your data
                            name: 'store_name',
                            render: function(data, type, row) {
                                // Check if store_name exists; if not, provide a default message
                                let displayText = '';

                                if (!data) {
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #f3e5f5; color: #8e24aa;">
                                            <i class="fas fa-store-slash" style="font-size: 16px; color: #8e24aa;"></i>
                                            Store not available
                                        </span>
                                    `;
                                } else {
                                    // Format as store_name (store_code)
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #e3f2fd; color: #1565c0;">
                                            <i class="fas fa-store" style="font-size: 16px; color: #1565c0;"></i>
                                            ${data} (${row.store})
                                        </span>
                                    `;
                                }

                                return displayText;
                            }
                        },

                        {
                            data: 'supp_name', // Assuming you have supp_name in your data
                            name: 'supp_name',
                            render: function(data, type, row) {
                                let displayText = '';

                                // Check if supp_name exists; if not, return the custom message
                                if (!data) {
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #ffebee; color: #d32f2f;">
                                            <i class="fas fa-exclamation-circle" style="font-size: 16px; color: #d32f2f;"></i>
                                            Tidak ada data supplier, silahkan untuk release supplier terlebih dahulu
                                        </span>
                                    `;
                                } else {
                                    // Format as supp_name(supp_code)
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #e8f5e9; color: #388e3c;">
                                            <i class="fas fa-warehouse" style="font-size: 16px; color: #388e3c;"></i>
                                            ${data} (${row.supp_code})
                                        </span>
                                    `;
                                }

                                return displayText;
                            }
                        },
                        {
                            data: 'approval_date',
                            name: 'approval_date',
                            render: function(data, type, row) {
                                let formattedDate = moment(data).format(
                                    'DD MMMM YYYY'); // e.g., "23 December 2023"
                                return `
                                    <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 5px 10px; border-radius: 15px; background-color: #f5f5f5; color: #4a4a4a;">
                                        <i class="fas fa-calendar-alt" style="font-size: 16px; color: #ff7f50;"></i>
                                        ${formattedDate}
                                    </span>
                                `;
                            }
                        },
                        {
                            data: 'expired_date',
                            name: 'expired_date',
                            render: function(data, type, row) {
                                let formattedDate = moment(data).format(
                                    'DD MMMM YYYY'); // e.g., "23 December 2023"
                                return `
                                    <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 5px 10px; border-radius: 15px; background-color: #e0f7fa; color: #00796b;">
                                        <i class="fas fa-calendar-times" style="font-size: 16px; color: #00796b;"></i>
                                        ${formattedDate}
                                    </span>
                                `;
                            }
                        },

                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusText = '';
                                let icon = '';
                                let badgeStyle = `
                                    padding: 7px 15px;
                                    font-size: 15px;
                                    border-radius: 25px;
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 8px;
                                    font-weight: 600;
                                `;

                                // Determine the status class, text, and icon based on the 'data' value
                                switch (data) {
                                    case 'Confirmed':
                                        statusClass = 'badge badge-light-primary';
                                        statusText = 'Confirmed';
                                        icon = '<i class="fas fa-check-circle"></i>';
                                        break;
                                    case 'Progress':
                                        statusClass = 'badge badge-light-warning';
                                        statusText = 'Progress';
                                        icon = '<i class="fas fa-clock"></i>';
                                        break;
                                    case 'Cancelled':
                                        statusClass = 'badge badge-light-danger';
                                        statusText = 'Cancelled';
                                        icon = '<i class="fas fa-times-circle"></i>';
                                        break;
                                    case 'Rejected':
                                        statusClass = 'badge badge-light-danger';
                                        statusText = 'Rejected';
                                        icon = '<i class="fas fa-times-circle"></i>';
                                        break;
                                    case 'Printed':
                                        statusClass = 'badge badge-light-info';
                                        statusText = 'Printed';
                                        icon = '<i class="fas fa-print"></i>';
                                        break;
                                    case 'Expired':
                                        statusClass = 'badge badge-light-secondary';
                                        statusText = 'Expired';
                                        icon = '<i class="fas fa-calendar-times"></i>';
                                        break;
                                    case 'Completed':
                                        statusClass = 'badge badge-light-success';
                                        statusText = 'Completed';
                                        icon = '<i class="fas fa-check-circle"></i>';
                                        break;
                                    case 'Incompleted':
                                        statusClass = 'badge badge-light-danger';
                                        statusText = 'Incompleted';
                                        icon = '<i class="fas fa-times-circle"></i>';
                                        break;
                                    default:
                                        statusClass = 'badge badge-light-secondary';
                                        statusText = 'Unknown';
                                        icon = '<i class="fas fa-question-circle"></i>';
                                        break;
                                }

                                // Return the status badge with icon, text, and improved styling
                                return `<span class="${statusClass}" style="${badgeStyle}">${icon} ${statusText}</span>`;
                            }
                        }



                    ]
                });

                // Event listener for detail button
                $('#po_table tbody').on('click', '.detail-btn', function() {
                    var orderId = $(this).data('id');
                    // Handle the detail action here, e.g., open a modal with order details
                    console.log('View details for order ID:', orderId);
                });

                // Event listener for confirm button
                $('#po_table tbody').on('click', '.confirm-btn', function() {
                    var orderId = $(this).data('id');
                    // Handle the confirm action here, e.g., send an AJAX request to confirm the order
                    console.log('Confirm order ID:', orderId);
                });
            }

            function formatRupiah(amount) {
                if (amount === null || amount === undefined) return 'N/A';
                return 'Rp' + amount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }


            function showLoadingSpinner(button) {
                if (!button || !button.hasAttribute("data-id")) {
                    console.error("Button is missing the 'data-id' attribute.");
                    return;
                }

                const id = button.getAttribute("data-id");

                // Base64 encode the ID
                const encodedId = btoa(id); // Use btoa() to encode to Base64

                // Show SweetAlert loading indicator
                Swal.fire({
                    title: 'Loading...',
                    html: '<div class="progress" style="border-radius: 10px; overflow: hidden; margin-top: 20px;">' +
                        '  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" ' +
                        '       style="width: 100%; background-color: #007bff;"></div>' +
                        '</div>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    customClass: {
                        popup: 'rounded-swal' // Apply custom rounded class
                    }
                });

                // Redirect to the new page after a short delay with the encoded ID as hash
                setTimeout(() => {
                    window.location.href =
                        `/purchase-orders/show/${encodedId}`; // Adding the encoded ID as hash
                }, 1500); // Adjust delay if needed
            }
        </script>
    @endpush

</x-default-layout>
