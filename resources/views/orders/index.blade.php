<x-default-layout>
    @section('title')
        Purchase Orders Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection
    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/order/index.css') }}">
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

            <div class="row mb-4">
                <!-- Date Range Picker for Filtering -->
                <div class="col-md-3 mb-2">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light border-secondary">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" id="filterDateRange" class="form-control border-secondary"
                            placeholder="Select Date Range">
                    </div>
                </div>

                <!-- Input field for filtering by order_no -->
                <div class="col-md-3 mb-2">
                    <div class="input-group input-group-sm">
                        <input type="text" id="orderNo"
                            class="form-control form-control-sm rounded-pill border-primary"
                            placeholder="Enter Order No" />
                    </div>
                </div>

                <!-- Store Filter with Select2 -->
                <div class="col-md-3 mb-2">
                    <div class="input-group input-group-sm">
                        <select id="filterStore" class="form-control border-secondary" multiple="multiple">
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </div>

                <!-- Supplier Filter with Select2 -->
                <div class="col-md-3 mb-2">
                    <div class="input-group input-group-sm">
                        <select id="filterSupplier" class="form-control border-secondary" multiple="multiple">
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </div>

                <!-- Region Filter with Select2 -->
                <div class="col-md-3 mb-2">
                    <div class="input-group input-group-sm">
                        <select id="filterRegion" class="form-control border-secondary" multiple="multiple">
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </div>

                <!-- Status Filter with Select2 -->
                <div class="col-md-3 mb-2">
                    <div class="input-group input-group-sm">
                        <select id="filterStatus" class="form-control border-secondary" multiple="multiple">
                            <option value="Progress">Progress</option>
                            <option value="Rejected">Reject</option>
                            <option value="Printed">Print</option>
                            <option value="Expired">Expired</option>
                            <option value="Confirmed">Konfirmasi</option>
                            <option value="Completed">Receiving</option>
                            <option value="Incompleted">Receiving Incompleted</option>
                            <!-- Add more status options as needed -->
                        </select>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" id="filterDataBtn">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>


            <!-- DataTable -->
            <table id="po_table" class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-100px">...</th>
                        <th class="min-w-100px">ORDER NO</th>
                        <th class="min-w-100px">RECEIVE NO</th>
                        <th class="text-end min-w-150px">STORE</th>
                        <th class="text-end min-w-100px">SUPPLIER</th>
                        <th class="text-end min-w-100px">APPROVAL DATE</th>
                        <th class="min-w-100px">RECEIVE DATE</th>
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
            var isAdmin = <?php echo json_encode(Auth::user()->hasRole('superadministrator')); ?>;

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
                        axios.get('https://supplier1.m-mart.co.id/api/po/getData?filterDate=' + syncDate, {
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

                $('#filterStatus').select2({
                    placeholder: "Select Statuses",
                    allowClear: true
                });

                $('#filterDateRange').daterangepicker({
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

                $('#filterStore').select2({
                    placeholder: "Select Stores",
                    allowClear: true,
                    ajax: {
                        url: '{{ route('stores.getStores') }}', // The route to fetch stores
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term // Send the search term to the server
                            };
                        },
                        processResults: function(data) {
                            // Map the data to the format expected by Select2
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.store, // The value of the option
                                        text: item.store_name // The text to be displayed
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1 // Require at least 1 character to start searching
                });

                // Initialize Select2 for Supplier
                $('#filterSupplier').select2({
                    placeholder: "Select Suppliers",
                    allowClear: true,
                    ajax: {
                        url: '{{ route('suppliers.selectData') }}', // Adjust the route accordingly
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term // Send the search term to the server
                            };
                        },
                        processResults: function(data) {
                            // Check if suppliers are returned and map them to Select2 format
                            return {
                                results: $.map(data.suppliers, function(item) {
                                    return {
                                        id: item.supp_code, // The value of the option
                                        text: item.supp_name // The text to be displayed
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1 // Require at least 1 character to start searching
                });

                $('#filterRegion').select2({
                    placeholder: "Select Regions",
                    allowClear: true,
                    ajax: {
                        url: '{{ route('regions.getRegions') }}', // Adjust the route accordingly
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term // Send the search term to the server
                            };
                        },
                        processResults: function(data) {
                            // Check if regions are returned and map them to Select2 format
                            return {
                                results: $.map(data.regions, function(item) {
                                    return {
                                        id: item.id, // The value of the option
                                        text: item.name // The text to be displayed
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1 // Require at least 1 character to start searching
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
                            d.orderNo = $('#orderNo').val(); // Add order number filter
                            d.store = $('#filterStore').val(); // Add store filter
                            d.supplier = $('#filterSupplier').val(); // Add supplier filter
                            d.region = $('#filterRegion').val(); // Add region filter
                            d.status = $('#filterStatus').val(); // Add region filter

                            // Split the date range into start and end dates
                            var dateRange = $("#filterDateRange").val().split(' - ');
                            if (dateRange.length === 2) {
                                d.startDate = dateRange[0]; // Start date
                                d.endDate = dateRange[1]; // End date
                            }
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
                            data: 'receive_no',
                            name: 'receive_no',
                            render: function(data, type, row) {
                                // Initialize displayText variable
                                let displayText = '';

                                // Check if receive_no data exists
                                if (!data) {
                                    // If data is not available, show a warning message
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #ffebee; color: #d32f2f;">
                                            <i class="fas fa-exclamation-circle" style="font-size: 16px; color: #d32f2f;"></i>
                                            Receive number not available
                                        </span>
                                    `;
                                } else {
                                    // If data exists, display it with a clipboard icon
                                    displayText = `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 20px; background-color: #e0f7fa; color: #00796b;">
                                            <i class="fas fa-clipboard-list" style="font-size: 16px; color: #00796b;"></i>
                                            ${data}
                                        </span>
                                    `;
                                }

                                // Return the constructed display text
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
                            data: 'receive_date',
                            name: 'receive_date',
                            render: function(data, type, row) {
                                // Check if data is null or undefined
                                if (!data) {
                                    return `
                                        <span style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; padding: 5px 10px; border-radius: 15px; background-color: #f5f5f5; color: #4a4a4a;">
                                            <i class="fas fa-exclamation-circle" style="font-size: 16px; color: #d32f2f;"></i>
                                            Not found data
                                        </span>
                                    `;
                                }

                                // Format the date if it exists
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

                                // Check if the user is an administrator and the status is not 'Progress'
                                let actionButton = '';
                                if (data !== 'Progress' && data !== 'Rejected' && isAdmin) { // Use the isAdmin variable
                                    actionButton =
                                        `<button class="btn btn-danger btn-sm" onclick="changeStatusToReject(${row.order_no})">                    <i class="fas fa-times"></i> Reject
                                        </button>`;
                                }

                                // Return the status badge with icon, text, and improved styling
                                return `
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span class="${statusClass}" style="${badgeStyle}">${icon} ${statusText}</span>
                                        ${actionButton}
                                    </div>
                                `;
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

            // Function to change status to 'Rejected'
            function changeStatusToReject(order_no) {
                // Prompt for a reason for rejection
                Swal.fire({
                    title: 'Reason for Rejection',
                    input: 'textarea',
                    inputPlaceholder: 'Enter the reason for rejecting this order...',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        popup: 'custom-swal' // Apply the custom class to the popup
                    },
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('You need to provide a reason for rejection!');
                        }
                        return reason;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const reason = result.value;

                        // Show a SweetAlert progress bar
                        Swal.fire({
                            title: 'Processing...',
                            html: 'Please wait while we process your request.',
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            customClass: {
                                popup: 'custom-swal' // Apply the custom class to the progress popup
                            }
                        });

                        // Make the AJAX call to update the status in the backend
                        $.ajax({
                            url: '/purchase-orders/reject-order/' + order_no, // Adjust the URL as needed
                            type: 'POST',
                            data: {
                                reason: reason, // Include the reason for rejection
                                _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                            },
                            success: function(response) {
                                // Close the loading dialog
                                Swal.close();

                                // Handle success
                                Swal.fire({
                                    title: 'Rejected!',
                                    text: response.message, // Use the message from the response
                                    icon: 'success',
                                    customClass: {
                                        popup: 'custom-swal' // Apply the custom class to the success popup
                                    },
                                    timer: 1000, // Set timer to close the dialog after 3 seconds
                                    showConfirmButton: false,
                                    timerProgressBar: true, // Show progress bar for the timer
                                    willClose: () => {
                                        // Show confirmation dialog after rejection
                                        Swal.fire({
                                            title: 'Confirmation',
                                            text: 'The order has been successfully rejected.',
                                            icon: 'info',
                                            showConfirmButton: false,
                                            timer: 1000, // Set timer to close the dialog after 3 seconds
                                            customClass: {
                                                popup: 'custom-swal' // Apply the custom class to the confirmation popup
                                            }
                                        });
                                    }
                                });
                                fetchData();
                                toastr.success(
                                'The order has been successfully rejected.'); // Toastr success notification
                                // Optionally, refresh the data table or update the UI
                            },
                            error: function(xhr) {
                                // Close the loading dialog
                                Swal.close();

                                // Handle error
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON.message ||
                                        'There was an error rejecting the order.',
                                    icon: 'error',
                                    customClass: {
                                        popup: 'custom-swal' // Apply the custom class to the error popup
                                    }
                                });
                                toastr.error(
                                'There was an error rejecting the order.'); // Toastr error notification
                            }
                        });
                    }
                });
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
                const swalInstance = Swal.fire({
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

                // Simulate an asynchronous operation (e.g., an AJAX request)
                // Replace this with your actual success condition
                setTimeout(() => {
                    // Here you can check for success or failure
                    const success = true; // Simulate success condition

                    if (success) {
                        // Hide the SweetAlert loading spinner
                        Swal.close();

                        // Redirect to the new page with the encoded ID as hash
                        window.location.href = `/purchase-orders/show/${encodedId}`; // Adding the encoded ID as hash
                    } else {
                        // Handle failure case (optional)
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while processing your request.',
                            confirmButtonText: 'OK'
                        });
                    }
                }, 1500); // Adjust delay if needed
            }
        </script>
    @endpush

</x-default-layout>
