<x-default-layout>
    @section('title')
        Receiving
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('receiving') }}
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
            }

            /* General button styling for smooth transitions */
            .btn {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            /* Hover effect for scaling and shadow */
            .btn:hover {
                transform: scale(1.05);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

            .progress {
                background-color: #e9ecef;
                /* Light gray background */
                border-radius: 10px;
                /* Rounded corners */
                height: 20px;
                /* Height of the progress bar */
                overflow: hidden;
                /* Ensure the inner bar doesn't overflow */
            }

            .progress-bar {
                transition: width 0.6s ease;
                /* Smooth transition for the width */
                border-radius: 10px;
                /* Rounded corners for the inner bar */
                display: flex;
                /* Use flexbox for centering text */
                align-items: center;
                /* Center text vertically */
                justify-content: center;
                /* Center text horizontally */
                color: white;
                /* Text color */
                font-weight: bold;
                /* Bold text */
            }

            .progress-text {
                position: absolute;
                /* Position text absolutely */
                width: 100%;
                /* Full width */
                text-align: center;
                /* Center text */
                color: white;
                /* Text color */
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
            <h5 class="card-title mb-0 text-primary">Receiving Management</h5>
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
            <!-- DataTable -->
            <table id="rcvtable" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-100px">Actions</th>
                        <th class="min-w-100px">Receive No</th>
                        <th class="text-end min-w-150px">Receive Date</th>
                        <th class="text-end min-w-100px">Order No</th>
                        <th class="text-end min-w-100px">Store</th>
                        <th class="text-end min-w-100px">Supplier</th>
                        <th class="text-end min-w-50px">Status</th>
                        <th class="text-end min-w-100px">Sub Total</th>
                        <th class="text-end min-w-100px">Service Level</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <!-- Data will be populated here -->
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
                                <div class="progress-bar-container" style="width: 100%; background-color: #f3f3f3; border-radius: 10px; overflow: hidden; margin-bottom: 20px;">
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
                        axios.get('https://supplier.m-mart.co.id/api/rcv/getData?filterDate=' + syncDate, {
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
                                        axios.post('/receiving/store', {
                                                rcv: chunk
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
                                                    Swal
                                                        .close(); // Close the SweetAlert progress modal
                                                    toastr.success(
                                                        'Data synchronized and saved successfully to the database.',
                                                        'Sync Complete!', {
                                                            closeButton: true,
                                                            progressBar: true,
                                                            timeOut: 5000
                                                        });
                                                    fetchData(); // Refresh the data
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
                    maxDate: moment().add(1, 'month'), // Limit to one month from today
                }, function(start, end) {
                    $('#filterDateRange').data('daterangepicker').setEndDate(moment(start).add(1, 'month'));
                });

                // Event Listener for the Filter Button
                $('#filterDataBtn').on('click', function() {
                    fetchData();
                });
            });

            function fetchData() {
                // Check if DataTable is already initialized
                if ($.fn.dataTable.isDataTable('#rcvtable')) {
                    // Destroy the existing DataTable instance
                    $('#rcvtable').DataTable().clear().destroy();
                }
                var table = $('#rcvtable').DataTable({
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    responsive: true,
                    ajax: {
                        url: '{{ route('receiving.data') }}', // Adjust the route name
                        type: 'GET',
                        data: function(d) {
                            d.order_no = $('#filterOrderNo').val(); // Pass order number filter
                            d.filterDate = $("#filterDateRange").val();
                        }
                    },
                    columns: [{
                            data: null, // This will hold the buttons
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                let buttons = `
                        <button class="btn btn-sm btn-info detail-btn" data-id="${row.order_no}">
                            <i class="fas fa-info-circle"></i> Details
                        </button>
                    `;
                                if (row.status === 'Progress') {
                                    buttons += `
                            <button class="btn btn-sm btn-success confirm-btn" data-id="${row.order_no}">
                                <i class="fas fa-check"></i> Confirmed
                            </button>
                        `;
                                }
                                return buttons;
                            }
                        },
                        {
                            data: 'receive_no',
                            name: 'receive_no'
                        },
                        {
                            data: 'receive_date',
                            name: 'receive_date',
                            render: function(data) {
                                return moment(data).format('DD MMMM YYYY'); // Format date
                            }
                        },
                        {
                            data: 'order_no',
                            name: 'order_no'
                        },
                        {
                            data: 'store', // Assuming store contains both name and code
                            render: function(data, type, row) {
                                return `${row.store_name} (${row.store})`; // Adjust based on your data structure
                            }
                        },
                        {
                            data: 'supplier', // Assuming supplier contains both name and code
                            render: function(data, type, row) {
                                return `${row.sup_name} (${row.supplier})`; // Adjust based on your data structure
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data) {
                                let icon = data === 'Y' ? 'fas fa-check-circle' :
                                'fas fa-exclamation-circle'; // Choose icon based on status
                                let colorClass = data === 'Y' ? 'success' :
                                'warning'; // Set color class based on status
                                let statusText = data === 'Y' ? 'Tanda Terima' :
                                'Belum Tanda Terima'; // Set text based on status

                                return `
                        <span class="badge bg-${colorClass} d-flex align-items-center" style="padding: 5px 10px;">
                            <i class="${icon}" style="margin-right: 5px;"></i> ${statusText}
                        </span>
                    `;
                            }
                        },
                        {
                            data: 'sub_total',
                            name: 'sub_total',
                            render: function(data) {
                                return `Rp ${parseFloat(data).toLocaleString('id-ID')}`; // Format as Rupiah
                            }
                        },
                        {
                            data: 'average_service_level',
                            name: 'average_service_level',
                            render: function(data) {
                                const percentage = parseFloat(data);

                                // Check if the percentage is available
                                if (isNaN(percentage)) {
                                    // Show loading progress bar for 5 seconds
                                    return `
                            <div class="progress" style="height: 20px; border-radius: 10px; overflow: hidden;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%; background-color: #007bff;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    <i class="fas fa-spinner fa-spin" style="margin-right: 5px;"></i> Loading...
                                </div>
                            </div>
                        `;
                                }

                                // Format the percentage to two decimal places
                                const formattedPercentage = percentage.toFixed(2);

                                return `
                        <div class="progress" style="height: 20px; border-radius: 10px; overflow: hidden;">
                            <div class="progress-bar" role="progressbar" style="width: ${formattedPercentage}%; background-color: ${formattedPercentage === '100.00' ? '#28a745' : '#ffc107'};" aria-valuenow="${formattedPercentage}" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-text">${formattedPercentage}%</span>
                            </div>
                        </div>
                    `;
                            }
                        }
                    ]
                });
            }
        </script>
    @endpush
</x-default-layout>