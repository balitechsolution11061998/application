<x-default-layout>
    @section('title')
        Purchase Order Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection

    @push('style')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f7fa;
                /* Light background color */
                margin: 0;
                padding: 20px;
            }

            .chart-container {
                background: white;
                border-radius: 15px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
                transition: transform 0.3s;
            }

            .chart-container:hover {
                transform: scale(1.02);
                /* Slightly scale up on hover */
            }

            h5 {
                margin-bottom: 15px;
                color: #343a40;
            }

            #dataPerDate {
                height: 400px;
                /* Set a height for the chart */
                margin-bottom: 20px;
                /* Space below the chart */
            }

            .button-container {
                display: flex;
                align-items: center;
                /* Center items vertically */
                margin-top: 15px;
            }

            .btn {
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 10px 15px;
                cursor: pointer;
                margin-right: 10px;
                transition: background-color 0.3s;
                font-size: 14px;
                /* Increase font size for better readability */
            }

            .btn:hover {
                background-color: #0056b3;
                /* Darker blue on hover */
            }

            .switch {
                display: inline-block;
                width: 60px;
                height: 34px;
                position: relative;
                margin-left: 10px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }

            input:checked+.slider {
                background-color: #007bff;
                /* Change switch color when checked */
            }

            input:checked+.slider:before {
                transform: translateX(26px);
                /* Move the slider */
            }

            .toggle-label {
                margin-left: 10px;
                /* Space between switch and label */
                font-size: 14px;
                /* Increase font size for better readability */
                color: #343a40;
                /* Dark color for the label */
            }


            .chart-container {
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
            }

            .chart-card {
                text-align: center;
            }

            .chart-card h5 {
                font-family: 'Montserrat', sans-serif;
                font-size: 1.25rem;
                margin-bottom: 20px;
                color: #333333;
            }

            .select-container {
                text-align: right;
                margin-bottom: 15px;
            }

            .checkbox-container {
                text-align: left;
                margin-top: 15px;
            }

            .custom-selects,
            .form-check-input {
                font-size: 0.9rem;
                margin: 5px 0;
            }

            #dataPerDate,
            #purchaseOrdersPieChart {
                height: 300px;
                /* Adjust height as needed */
            }

            .chart-container {
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
            }

            .form-check-label {
                margin-left: 10px;
                /* Space between switch and label */
            }

            .loading-spinner {
                margin-top: 10px;
                font-weight: bold;
                color: #007bff;
                /* Bootstrap primary color */
            }

            .container {
                background-color: #f8f9fa;
                /* Light background for the filter section */
                padding: 20px;
                /* Add padding for spacing */
                border-radius: 8px;
                /* Rounded corners */
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                /* Subtle shadow for depth */
            }

            .input-group .form-control {
                border-radius: 0.375rem 0 0 0.375rem;
                /* Rounded corners for the input */
            }

            .input-group .btn {
                border-radius: 0 0.375rem 0.375rem 0;
                /* Rounded corners for the button */
            }

            .form-label {
                font-weight: bold;
                /* Bold label for better visibility */
            }
        </style>
    @endpush

    <div class="container-fluid py-5">




        <!-- Dashboard Header -->
        <div class="dashboard-header text-center mb-5">
            <h1 class="display-4 fw-bold">Purchase Order Dashboard</h1>
            <p class="lead text-muted">Monitor and manage your purchase orders effectively</p>
        </div>

    <!-- Date Range Filter -->
        <div class="container mb-4">
            <h4 class="text-center mb-3">Filter Options</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="input-group">
                        <input type="text" id="dateRangePicker" class="form-control"
                            placeholder="Select Date Range" />
                        <button class="btn btn-primary" id="filterButton">
                            <i class="fas fa-calendar-alt"></i> Set Date Range
                        </button>
                        <button class="btn btn-secondary" id="syncButton">
                            <i class="fas fa-sync"></i> Sync
                        </button>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <select id="storeSelect" class="form-select" data-control="select2"
                        data-placeholder="Select an option">
                        <!-- Options will be populated here -->
                        <option value="" disabled selected>All Store</option> <!-- Default option -->

                    </select>
                </div>
            </div>
            <div id="spinner" class="text-center" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
        </div>




        <!-- Date Range Display -->
        <div class="text-center date-range">
            <span id="dateRange"> <i class="fas fa-calendar-alt" style="margin-right: 5px;"></i>
                Date Range: <strong>01 Jan 2025 - 31 Jan 2025</strong></span>
        </div>

        <!-- Summary Cards Carousel -->
        <div id="summaryCardsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row mb-5">
                        <div class="col-md-4 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Progress PO</h5>
                                <h2 class="text-primary display-4" id="progressPOValue">Loading...</h2>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-primary progress-bar-animated" role="progressbar"
                                        id="progressPOBar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;">0%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/workflow.png') }}" alt="Progress PO Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Confirmed</h5>
                                <h2 class="text-info display-4" id="confirmedCount">Loading...</h2>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-info progress-bar-animated" role="progressbar"
                                        id="confirmedProgressBar" style="width: 50%;" aria-valuenow="50"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="confirmedPercentage">50%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/order.png') }}" alt="Confirmed Icon" class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Printed</h5>
                                <h2 class="text-warning display-4" id="printedCount">Loading...</h2>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-warning progress-bar-animated" role="progressbar"
                                        id="printedProgressBar" style="width: 60%;" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="printedPercentage">60%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/receipt.png') }}" alt="Printed Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row mb-5">
                        <div class="col-md-3 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Completed</h5>
                                <h2 class="text-success display-4" id="completedCount">Loading...</h2>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-success progress-bar-animated" role="progressbar"
                                        id="completedProgressBar" style="width: 80%;" aria-valuenow="80"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="completedPercentage">80%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/completed-task.png') }}" alt="Completed Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Expired</h5>
                                <h2 class="text-danger display-4" id="expiredCount">Loading...</h2>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-danger progress-bar-animated" role="progressbar"
                                        id="expiredProgressBar" style="width: 20%;" aria-valuenow="20"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="expiredPercentage">20%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/expired.png') }}" alt="Expired Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Rejected</h5>
                                <h2 class="text-danger display-4" id="rejectedCount">Loading...</h2>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-danger progress-bar-animated" role="progressbar"
                                        id="rejectedProgressBar" style="width: 10%;" aria-valuenow="10"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="rejectedPercentage">10%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/rejected.png') }}" alt="Rejected Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Delivery</h5>
                                <h2 class="text-success display-4" id="deliveryCount">Loading...</h2>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-success progress-bar-animated" role="progressbar"
                                        id="deliveryProgressBar" style="width: 75%;" aria-valuenow="75"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="deliveryPercentage">75%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/delivery.png') }}" alt="Delivery Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#summaryCardsCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#summaryCardsCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            <!-- Loading Spinner -->
            <div class="spinner-container" id="loadingSpinner">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
        </div>




        <div class="row">
            <div class="col-md-6">
                <!-- Active Applications Chart -->
                <div class="chart-container chart-card">
                    <div class="mb-2">
                        <div class="select-container">
                            <label for="dataToggle" class="form-label me-2">Select Data Type:</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                    onchange="toggleDataType()">
                                <label class="form-check-label" for="flexSwitchCheckDefault"
                                    id="switchLabel">Count</label>
                            </div>
                        </div>
                    </div>

                    <h5 class="font-weight-bold">PO Per Date</h5>
                    <div id="dataPerDate"></div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Pie Chart for Purchase Orders per Date -->
                <div class="chart-container chart-card">
                    <h5 class="font-weight-bold">Purchase Orders per Status</h5>
                    <div class="select-container">

                        <div id="loading" class="loading-spinner" style="display: none;">
                            Loading...
                        </div>
                    </div>
                    <div id="purchaseOrdersPieChart"></div>
                </div>
            </div>

        </div>


    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

        <script>
            let startDate = ""; // Initialize start date
            let endDate = ""; // Initialize end date
            let selectedStores = ""; // Initialize selected stores
            let pieChart; // Variable for pie chart
            let barChart; // Variable for bar chart

            $(document).ready(function() {
                // Initialize the date range picker
                $('#dateRangePicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                        format: 'DD MMMM YYYY' // Format the date as needed
                    }
                });

                // Fetch stores and populate the select dropdown
                fetchSelectStore();

                // Show loading spinner while the carousel is loading
                showLoadingSpinner();
                console.log($('#storeSelect').val(), "$('#storeSelect').val()")
                // Initial data fetch with empty dates

                // Handle the button click to set the date range
                $('#filterButton').click(function() {
                    startDate = $('#dateRangePicker').data('daterangepicker').startDate;

                    if (startDate) {
                        endDate = moment(startDate).add(1, 'months'); // Calculate the end date

                        // Update the displayed date range
                        $('#dateRange').html(
                            `Date Range: <strong>${startDate.format('DD MMMM YYYY')} - ${endDate.format('DD MMMM YYYY')}</strong>`
                        );

                        // Pass formatted dates to the functions
                        fetchData($('#storeSelect').val(), startDate.format('YYYY-MM-DD'), endDate.format(
                            'YYYY-MM-DD'));
                    } else {
                        toastr.error('Please select a start date.'); // Use Toastr for error notification
                    }
                });

                // Handle store selection change
                $('#storeSelect').on('change', function() {
                    selectedStores = $('#storeSelect').val(); // Get selected store IDs
                    startDate = $('#dateRangePicker').data('daterangepicker').startDate;

                    // Check if any store is selected
                    if (!selectedStores || selectedStores.length === 0) {
                        toastr.warning(
                            'Please select at least one store.'); // Use Toastr for warning notification
                        return; // Exit the function
                    }

                    if (startDate) {
                        endDate = moment(startDate).add(1, 'months'); // Calculate the end date
                        fetchData(selectedStores, startDate.format('YYYY-MM-DD'), endDate.format('YYYY-MM-DD'));
                    } else {
                        toastr.error('Please select a start date.'); // Use Toastr for error notification
                    }
                });
            });

            function convertDateFormat(dateString) {
                // Create a new Date object from the input string
                const date = new Date(dateString);

                // Check if the date is valid
                if (isNaN(date.getTime())) {
                    throw new Error("Invalid date format");
                }

                // Extract year, month, and day
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
                const day = String(date.getDate()).padStart(2, '0');

                // Return the formatted date
                return `${year}-${month}-${day}`;
            }

            document.getElementById('syncButton').addEventListener('click', function() {
                const syncDate = document.getElementById('dateRangePicker').value;
                let formattedDate;

                try {
                    formattedDate = convertDateFormat(syncDate);
                } catch (error) {
                    Swal.fire({
                        title: 'Invalid Date',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

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
                        axios.get('https://supplier.m-mart.co.id/api/po/getData?filterDate=' + formattedDate, {
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
                                                        });

                                                    // Call receiveData function after sync is complete
                                                    receiveData(formattedDate);
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

            // Function to receive data (RCV)
            function receiveData(syncDate) {
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
            // Function to show loading spinner
            function showLoadingSpinner() {
                $('#loadingSpinner').show(); // Show spinner
                setTimeout(function() {
                    $('#loadingSpinner').hide(); // Hide spinner after 2 seconds
                }, 2000);
            }

            // Function to fetch store data
            function fetchSelectStore() {
                $.ajax({
                    url: '{{ route('stores.getStores') }}', // Replace with your API endpoint
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#loading').show(); // Show loading animation
                    },
                    success: function(data) {
                        $('#loading').hide(); // Hide loading animation
                        const storeSelect = $('#storeSelect');
                        storeSelect.empty(); // Clear existing options
                        data.forEach(store => {
                            storeSelect.append(
                                `<option value="${store.store}">${store.store_name}</option>`);
                        });
                        fetchData($('#storeSelect').val(), null, null); // Pass empty dates initially
                    },
                    error: function() {
                        $('#loading').hide();
                        toastr.error(
                            'Failed to fetch store data. Please try again later.'
                        ); // Use Toastr for error notification
                    }
                });
            }

            // Function to fetch data based on selected stores and date range
            function fetchData(selectedStores, startDate, endDate) {
                console.log(selectedStores, startDate, endDate, 'selectedStores, startDate, endDate')
                fetchDataPerStatus(selectedStores, startDate, endDate);
                fetchPODataPerStore(selectedStores, startDate, endDate);
                fetchPOData(selectedStores, startDate, endDate);
            }

            // Function to fetch purchase order data per status
            function fetchDataPerStatus(selectedStores, startDate, endDate) {
                console.log("masuk sini", selectedStores, 'selectedStores', startDate, endDate);
                $.ajax({
                    url: '/dashboard-po/purchase-orders/status', // Replace with your API endpoint
                    method: 'GET',
                    data: {
                        stores: selectedStores,
                        start_date: startDate,
                        end_date: endDate
                    },
                    beforeSend: function() {
                        $('#loadingSpinner').show(); // Show loading spinner
                    },
                    success: function(response) {
                        updateProgressUI(response); // Update the UI with the fetched data
                        $('#loadingSpinner').hide(); // Hide loading spinner
                    },
                    error: function() {
                        $('#loadingSpinner').hide();
                        toastr.error('Error loading data'); // Use Toastr for error notification
                    }
                });
            }

            // Function to update the UI with fetched progress data
            function updateProgressUI(response) {
                // Update the UI with the fetched data
                $('#progressPOValue').text(response.progress);
                $('#progressPODetails').html(response.details);
                updateProgressBar('#progressPOBar', response.progressPercentage);

                $('#confirmedCount').text(response.confirmed);
                $('#confirmedPercentage').text(response.confirmedPercentage + '%');
                updateProgressBar('#confirmedProgressBar', response.confirmedPercentage);

                $('#printedCount').text(response.printed);
                $('#printedPercentage').text(response.printedPercentage + '%');
                updateProgressBar('#printedProgressBar', response.printedPercentage);

                $('#completedCount').text(response.completed);
                $('#completedPercentage').text(response.completedPercentage + '%');
                updateProgressBar('#completedProgressBar', response.completedPercentage);

                $('#expiredCount').text(response.expired);
                $('#expiredPercentage').text(response.expiredPercentage + '%');
                updateProgressBar('#expiredProgressBar', response.expiredPercentage);

                $('#rejectedCount').text(response.rejected);
                $('#rejectedPercentage').text(response.rejectedPercentage + '%');
                updateProgressBar('#rejectedProgressBar', response.rejectedPercentage);

                $('#deliveryCount').text(response.delivery);
                $('#deliveryPercentage').text(response.deliveryPercentage + '%');
                updateProgressBar('#deliveryProgressBar', response.deliveryPercentage);
            }

            // Function to update a progress bar
            function updateProgressBar(selector, percentage) {
                $(selector).css('width', percentage + '%').attr('aria-valuenow', percentage);
                $(selector).text(percentage + '%');
            }

            // Function to fetch purchase order data per selected date range
            function fetchPOData(storeSelect, startDate, endDate) {
                $.ajax({
                    url: '/dashboard-po/purchase-orders/count-per-date', // Replace with your API endpoint
                    method: 'GET',
                    data: {
                        stores: storeSelect,
                        start_date: startDate,
                        end_date: endDate
                    },
                    beforeSend: function() {
                        $('#loadingSpinner').show(); // Show loading spinner
                    },
                    success: function(response) {
                        const categories = response.approval_date; // Array of dates
                        const counts = response.counts; // Array of counts for each date
                        renderPOChart(categories, counts); // Render the chart
                    },
                    error: function() {
                        console.error('Error fetching PO data'); // Log error if the request fails
                    },
                    complete: function() {
                        $('#loadingSpinner').hide(); // Hide the loading spinner after the request is complete
                    }
                });
            }

            // Function to render the chart
            function renderPOChart(categories, counts) {
                var element = document.getElementById('dataPerDate'); // Get the chart element

                if (!element) {
                    console.error("Chart element not found"); // Log if the element is not found
                    return; // Exit if the element is not found
                }

                // Destroy the existing chart instance if it exists
                if (barChart) {
                    barChart.destroy(); // Destroy the existing chart instance
                }

                var height = parseInt(window.getComputedStyle(element).height) || 400; // Default height if not found
                var labelColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-gray-500') || '#6c757d';
                var borderColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-gray-200') || '#e9ecef';
                var baseColors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0',
                    '#546E7A'
                ]; // Array of colors for the bars

                // Generate colors for each bar based on the counts
                var barColors = counts.map((_, index) => baseColors[index % baseColors.length]);

                // Chart options
                var barOptions = {
                    series: [{
                        name: 'Purchase Orders',
                        data: counts // Data for counts
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                            animateGradually: {
                                enabled: true,
                                delay: 150
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 350
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded',
                            borderRadius: 10
                        },
                    },
                    legend: {
                        show: true
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: categories, // Use the fetched categories (dates)
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        colors: barColors, // Use the generated colors for the bars
                        opacity: 1
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val; // Format the tooltip value as needed
                            }
                        }
                    },
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                // Create and render the bar chart
                barChart = new ApexCharts(element, barOptions); // Assign the new chart instance to the variable
                barChart.render().catch(error => {
                    console.error("Error rendering bar chart:", error); // Log any rendering errors
                });
            }

            // Function to fetch purchase order data per selected stores with date filtering
            function fetchPODataPerStore(selectedStores, startDate, endDate) {
                // Check if selectedStores is empty or null, and set it to '40' if true
                if (!selectedStores || selectedStores.length === 0) {
                    selectedStores = '40'; // Default to store ID 40
                }

                $('#loading').show(); // Show loading animation
                $.ajax({
                    url: '/dashboard-po/purchase-orders/per-store', // Replace with your actual API endpoint
                    method: 'GET',
                    data: {
                        stores: selectedStores,
                        start_date: startDate, // Include start date
                        end_date: endDate // Include end date
                    }, // Send selected store IDs and date range
                    beforeSend: function() {
                        console.log("Fetching data..."); // Optional: Show loading message
                    },
                    success: function(response) {
                        $('#loading').hide(); // Hide loading animation
                        const categories = response.categories; // Array of store names
                        const counts = response.counts; // Array of counts for each store
                        const percentages = response.percentages; // Array of percentages for each store

                        // Check if the response is valid
                        if (categories.length === 0 || counts.length === 0) {
                            toastr.warning(
                                "No data available for the selected stores."
                            ); // Use Toastr for warning notification
                            return;
                        }

                        // Call the function to render the pie chart with the fetched data
                        renderPieChart(categories, counts, percentages);
                    },
                    error: function(xhr, status, error) {
                        $('#loading').hide();
                        console.error("Error fetching data:", error); // Log error if the request fails
                        toastr.error(
                            "An error occurred while fetching data. Please try again."
                        ); // Use Toastr for error notification
                    }
                });
            }

            // Function to render the pie chart
            function renderPieChart(categories, counts, percentages) {
                var element = document.getElementById('purchaseOrdersPieChart'); // Get the pie chart element

                if (!element) {
                    console.error("Pie chart element not found"); // Log if the element is not found
                    return; // Exit if the element is not found
                }

                // Validate categories and counts
                if (!Array.isArray(categories) || !Array.isArray(counts) || !Array.isArray(percentages)) {
                    console.error("Categories, counts, or percentages are not arrays:", {
                        categories,
                        counts,
                        percentages
                    });
                    return; // Exit if they are not arrays
                }

                if (categories.length === 0 || counts.length === 0 || percentages.length === 0) {
                    console.error("Categories, counts, or percentages are empty:", {
                        categories,
                        counts,
                        percentages
                    });
                    return; // Exit if they are empty
                }

                // Destroy the existing chart instance if it exists
                if (pieChart) {
                    pieChart.destroy(); // Destroy the existing chart instance
                }

                var pieOptions = {
                    series: counts,
                    chart: {
                        type: 'pie',
                        height: 400,
                        toolbar: {
                            show: true // Show toolbar for chart interactions
                        }
                    },
                    labels: categories,
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val, {
                                seriesIndex
                            }) {
                                return `${val} (${percentages[seriesIndex].toFixed(2)}%)`; // Show count and percentage in tooltip
                            }
                        }
                    },
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0',
                    '#546E7A'], // Custom colors for the pie chart
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                // Create and render the pie chart
                pieChart = new ApexCharts(element, pieOptions); // Assign the new chart instance to the variable
                pieChart.render().catch(error => {
                    console.error("Error rendering pie chart:", error); // Log any rendering errors
                });
            }



            // Initialize progress bars on DOMContentLoaded
            document.addEventListener("DOMContentLoaded", function() {
                const progressBars = document.querySelectorAll('.progress-bar');
                progressBars[0].style.width = '75%'; // Total Orders
                progressBars[0].setAttribute('aria-valuenow', '75');

                progressBars[1].style.width = '60%'; // Pending Orders
                progressBars[1].setAttribute('aria-valuenow', '60');

                progressBars[2].style.width = '80%'; // Completed Orders
                progressBars[2].setAttribute('aria-valuenow', '80');
            });
        </script>
    @endpush
</x-default-layout>
