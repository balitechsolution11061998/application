<x-default-layout>
    @section('title')
        Purchase Orders Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection
    @push('styles')
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
        </style>
    @endpush
    <!-- Card Start -->
    <div class="card rounded">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Purchase Orders Management</h5>
            <div class="d-flex align-items-center">
                <!-- Date input field for selecting the data sync date -->
                <input type="date" id="syncDateInput" class="form-control form-control-sm mr-2" style="width: auto;">
                <button class="btn btn-outline-primary btn-sm sync-btn" id="syncDataBtn">
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

    @push('scripts')
        @foreach (getGlobalAssets() as $path)
            {!! sprintf('<script src="%s"></script>', asset($path)) !!}
        @endforeach
        @foreach (getVendors('js') as $path)
            {!! sprintf('<script src="%s"></script>', asset($path)) !!}
        @endforeach
        <script>
            document.getElementById('syncDataBtn').addEventListener('click', function() {
                const syncDate = document.getElementById('syncDateInput').value;

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
                            showConfirmButton: false,
                            willOpen: () => {
                                // Optional: Add a delay to start spinner animation smoothly
                                document.querySelector('.fa-spinner').style.animationDuration =
                                    '2s';
                            }
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
                                                            timeOut: 5000 // Duration in milliseconds
                                                        });

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
                    ajax: '{{ route('purchase-orders.data') }}',
                    columns: [{
                            data: null, // This will hold the buttons
                            orderable: false, // Disable sorting for this column
                            searchable: false, // Disable searching for this column
                            render: function(data, type, row) {
                                return '<button class="btn btn-sm btn-info detail-btn" data-id="' + row
                                    .id + '">' +
                                    '<i class="fas fa-info-circle"></i> Details</button>' +
                                    ' <button class="btn btn-sm btn-success confirm-btn" data-id="' +
                                    row.id + '">' +
                                    '<i class="fas fa-check"></i> Confirmed</button>';
                            }
                        },
                        {
                            data: 'order_no',
                            name: 'order_no'
                        },
                        {
                            data: 'store_name', // Assuming you have store_name in your data
                            name: 'store_name',
                            render: function(data, type, row) {
                                return data + ' (' + row.store +
                                    ')'; // Format as store_name(store_code)
                            }
                        },

                        {
                            data: 'supp_name', // Assuming you have supp_name in your data
                            name: 'supp_name',
                            render: function(data, type, row) {
                                // Check if supp_name exists; if not, return the custom message
                                if (!data) {
                                    return 'Tidak ada data supplier, silahkan untuk release supplier terlebih dahulu';
                                }
                                return data + ' (' + row.supp_code +
                                    ')'; // Format as supp_name(supp_code)
                            }
                        },
                        {
                            data: 'approval_date',
                            name: 'approval_date',
                            render: function(data, type, row) {
                                return moment(data).format('DD MMMM YYYY'); // e.g., "23 Desember 2023"
                            }
                        },
                        {
                            data: 'expired_date',
                            name: 'expired_date',
                            render: function(data, type, row) {
                                return moment(data).format('DD MMMM YYYY'); // e.g., "23 Desember 2023"
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                let statusClass = '';
                                let statusText = '';
                                let icon = '';

                                // Determine the status class, text, and icon
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
                                    default:
                                        statusClass = 'badge badge-light-secondary';
                                        statusText = 'Unknown';
                                        icon = '<i class="fas fa-question-circle"></i>';
                                        break;
                                }

                                // Return the status badge
                                return '<span class="' + statusClass + '">' + icon + ' ' + statusText +
                                    '</span>';
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
        </script>
    @endpush

</x-default-layout>
