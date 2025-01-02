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
        </style>
    @endpush

    <div class="container-fluid py-5">




        <!-- Dashboard Header -->
        <div class="dashboard-header text-center mb-5">
            <h1 class="display-4 fw-bold">Purchase Order Dashboard</h1>
            <p class="lead text-muted">Monitor and manage your purchase orders effectively</p>
        </div>

        <!-- Date Range Filter -->
        <div class="text-center mb-4">
            <input type="text" id="dateRangePicker" class="form-control d-inline-block"
                style="width: auto; display: inline-block;" placeholder="Select Date Range" />
            <button class="btn btn-primary" id="filterButton">Set Date Range</button>
        </div>

        <!-- Date Range Display -->
        <div class="text-center date-range">
            <span id="dateRange">Date Range: <strong>01 Jan 2025 - 31 Jan 2025</strong></span>
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
                                <p class="text-muted" id="progressPODetails">Loading...</p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-primary progress-bar-animated" role="progressbar"
                                        id="progressPOBar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;">0%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/workflow.png') }}" alt="Progress PO Icon"
                                    class="icon" style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Confirmed</h5>
                                <h2 class="text-info display-4" id="confirmedCount">Loading...</h2>
                                <p class="text-muted">+5% <span class="text-success">(+1% Inc)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-info progress-bar-animated" role="progressbar"
                                        id="confirmedProgressBar" style="width: 50%;" aria-valuenow="50"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;" id="confirmedPercentage">50%</span>
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
                                <p class="text-muted">+15% <span class="text-success">(+3% Inc)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-warning progress-bar-animated" role="progressbar"
                                        id="printedProgressBar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;" id="printedPercentage">60%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/receipt.png') }}" alt="Printed Icon" class="icon"
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
                                <p class="text-muted">+20% <span class="text-danger">(-5% Dec)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-success progress-bar-animated" role="progressbar"
                                        id="completedProgressBar" style="width: 80%;" aria-valuenow="80"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;" id="completedPercentage">80%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/completed-task.png') }}" alt="Completed Icon"
                                    class="icon" style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Expired</h5>
                                <h2 class="text-danger display-4" id="expiredCount">Loading...</h2>
                                <p class="text-muted">-10% <span class="text-danger">(-5% Dec)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-danger progress-bar-animated" role="progressbar"
                                        id="expiredProgressBar" style="width: 20%;" aria-valuenow="20"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;" id="expiredPercentage">20%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/expired.png') }}" alt="Expired Icon" class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Rejected</h5>
                                <h2 class="text-danger display-4" id="rejectedCount">Loading...</h2>
                                <p class="text-muted">-5% <span class="text-danger">(-2% Dec)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-danger progress-bar-animated" role="progressbar"
                                        id="rejectedProgressBar" style="width: 10%;" aria-valuenow="10"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;" id="rejectedPercentage">10%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/rejected.png') }}" alt="Rejected Icon" class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mt-2">
                            <div class="summary-card card p-4 text-center position-relative shadow-sm">
                                <h5 class="font-weight-bold">Delivery</h5>
                                <h2 class="text-success display-4" id="deliveryCount">Loading...</h2>
                                <p class="text-muted">+15% <span class="text-success">(+5% Inc)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-success progress-bar-animated" role="progressbar"
                                        id="deliveryProgressBar" style="width: 75%;" aria-valuenow="75"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;" id="deliveryPercentage">75%</span>
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/delivery.png') }}" alt="Delivery Icon" class="icon"
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
                    <h5 class="font-weight-bold">Purchase Orders per Date</h5>
                    <div class="select-container">
                        <label class="form-label">Select Stores:</label>
                        <select id="storeSelect" class="form-select" data-control="select2"
                            data-placeholder="Select an option">
                            <!-- Options will be populated here -->
                        </select>
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
            let startDate = ""; // Change from const to let
            let endDate = ""; // Change from const to let
            let selectedStores = "";
            let pieChart;
            let barChart;
            $(document).ready(function() {
                // Initialize the date range picker
                $('#dateRangePicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                        format: 'DD MMMM YYYY' // Format the date as needed
                    }
                });

                // Handle the button click to set the date range
                $('#filterButton').click(function() {
                    startDate = $('#dateRangePicker').data('daterangepicker').startDate;

                    if (startDate) {
                        // Calculate the end date as one month from the start date
                        endDate = moment(startDate).add(1, 'months');

                        // Update the displayed date range
                        $('#dateRange').html(
                            `Date Range: <strong>${startDate.format('DD MMMM YYYY')} - ${endDate.format('DD MMMM YYYY')}</strong>`
                        );

                        fetchDataPerStatus(startDate.format('YYYY-MM-DD'), endDate.format(
                            'YYYY-MM-DD')); // Pass formatted dates
                        fetchPODataPerStore(selectedStores, startDate.format('YYYY-MM-DD'), endDate.format(
                            'YYYY-MM-DD')); // Pass formatted dates
                        fetchPOData(startDate.format('YYYY-MM-DD'), endDate.format(
                            'YYYY-MM-DD')); // Pass formatted dates

                    } else {
                        alert('Please select a start date.');
                    }
                });

                // Show loading spinner while the carousel is loading
                $('#loadingSpinner').show(); // Show spinner

                // Hide spinner after a short delay to simulate loading
                setTimeout(function() {
                    $('#loadingSpinner').hide(); // Hide spinner after 2 seconds
                }, 2000);

                // Update date range based on user input


                // Initialize the pie chart for purchase orders per date

                // Initialize the bar chart for Net Profit and Revenue
                fetchPOData();


                fetchDataPerStatus();
                fetchPODataPerStore();
                fetchSelectStore();

                $('#storeSelect').on('change', function() {
                    selectedStores = $(this).val(); // Get selected store IDs
                    fetchPODataPerStore(selectedStores); // Fetch data for selected stores
                });
            });

            function fetchSelectStore() {
                $.ajax({
                    url: '{{ route('stores.getStores') }}', // Replace with your API endpoint
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Hide loading animation
                        $('#loading').hide();

                        // Populate the select options
                        const storeSelect = $('#storeSelect');
                        storeSelect.empty(); // Clear existing options
                        data.forEach(store => {
                            storeSelect.append(
                                `<option value="${store.store}">${store.store_name}</option>`
                            );
                        });
                    },
                    error: function() {
                        $('#loading').hide();
                        alert('Failed to fetch store data. Please try again later.');
                    }
                });
            }

            function fetchDataPerStatus(startDate, endDate) {
                $.ajax({
                    url: '/dashboard-po/purchase-orders/status', // Replace with your API endpoint
                    method: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    beforeSend: function() {
                        // Show the loading spinner before the request is sent
                        $('#loadingSpinner').show();
                    },
                    success: function(response) {
                        // Assuming response contains the data you need
                        const progressValue = response.progress; // e.g., 1000
                        const progressPercentage = response.percentage; // e.g., 70%
                        const progressDetails = response.details; // e.g., "+10% (+5% Inc)"
                        const confirmedCount = response.confirmed; // e.g., 500
                        const confirmedPercentage = response.confirmedPercentage; // e.g., 50%
                        const printedCount = response.printed; // e.g., 300
                        const printedPercentage = response.printedPercentage; // e.g., 60%
                        const completedCount = response.completed; // e.g., 950
                        const completedPercentage = response.completedPercentage; // e.g., 80%
                        const expiredCount = response.expired; // e.g., 50
                        const expiredPercentage = response.expiredPercentage; // e.g., 20%
                        const rejectedCount = response.rejected; // e.g., 20
                        const rejectedPercentage = response.rejectedPercentage; // e.g., 10%
                        const deliveryCount = response.delivery; // e.g., 400
                        const deliveryPercentage = response.deliveryPercentage; // e.g., 75%

                        // Update the UI with the fetched data for Progress PO
                        $('#progressPOValue').text(progressValue);
                        $('#progressPODetails').html(progressDetails);
                        $('#progressPOBar').css('width', progressPercentage + '%').attr('aria-valuenow',
                            progressPercentage);
                        $('#progressPOBar').text(progressPercentage + '%');

                        // Update the UI with the fetched data for Confirmed
                        $('#confirmedCount').text(confirmedCount);
                        $('#confirmedPercentage').text(confirmedPercentage + '%');
                        $('#confirmedProgressBar').css('width', confirmedPercentage + '%').attr('aria-valuenow',
                            confirmedPercentage);
                        $('#confirmedProgressBar').text(confirmedPercentage + '%');

                        // Update the UI with the fetched data for Printed
                        $('#printedCount').text(printedCount);
                        $('#printedPercentage').text(printedPercentage + '%');
                        $('#printedProgressBar').css('width', printedPercentage + '%').attr('aria-valuenow',
                            printedPercentage);
                        $('#printedProgressBar').text(printedPercentage + '%');

                        // Update the UI with the fetched data for Completed
                        $('#completedCount').text(completedCount);
                        $('#completedPercentage').text(completedPercentage + '%');
                        $('#completedProgressBar').css('width', completedPercentage + '%').attr('aria-valuenow',
                            completedPercentage);
                        $('#completedProgressBar').text(completedPercentage + '%');

                        // Update the UI with the fetched data for Expired
                        $('#expiredCount').text(expiredCount);
                        $('#expiredPercentage').text(expiredPercentage + '%');
                        $('#expiredProgressBar').css('width', expiredPercentage + '%').attr('aria-valuenow',
                            expiredPercentage);
                        $('#expiredProgressBar').text(expiredPercentage + '%');

                        // Update the UI with the fetched data for Rejected
                        $('#rejectedCount').text(rejectedCount);
                        $('#rejectedPercentage').text(rejectedPercentage + '%');
                        $('#rejectedProgressBar').css('width', rejectedPercentage + '%').attr('aria-valuenow',
                            rejectedPercentage);
                        $('#rejectedProgressBar').text(rejectedPercentage + '%');

                        // Update the UI with the fetched data for Delivery
                        $('#deliveryCount').text(deliveryCount);
                        $('#deliveryPercentage').text(deliveryPercentage + '%');
                        $('#deliveryProgressBar').css('width', deliveryPercentage + '%').attr('aria-valuenow',
                            deliveryPercentage);
                        $('#deliveryProgressBar').text(deliveryPercentage + '%');

                        // Hide the loading spinner
                        $('#loadingSpinner').hide();
                    },
                    error: function() {
                        // Handle error
                        $('#progressPOValue').text('Error loading data');
                        $('#progressPODetails').text('');
                        $('#loadingSpinner').hide();
                    }
                });
            }

            function toggleDataType() {
                const switchLabel = document.getElementById('switchLabel');
                const checkbox = document.getElementById('flexSwitchCheckDefault');
                if (checkbox.checked) {
                    switchLabel.textContent = 'Value'; // Change label to Value
                } else {
                    switchLabel.textContent = 'Count'; // Change label back to Count
                }
            }

            // Function to fetch purchase order data per selected date range
            function fetchPOData(startDate, endDate) {
                $.ajax({
                    url: '/dashboard-po/purchase-orders/count-per-date', // Replace with your API endpoint
                    method: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    beforeSend: function() {
                        // Show a loading spinner before the request is sent
                        $('#loadingSpinner').show();
                    },
                    success: function(response) {
                        console.log(response, 'approval_date'); // Log the response for debugging
                        // Extract categories (dates) and counts from the response
                        const categories = response.approval_date; // Array of dates
                        const counts = response.counts; // Array of counts for each date

                        // Call the function to render the chart with the fetched data
                        renderPOChart(categories, counts);
                    },
                    error: function() {
                        console.error('Error fetching PO data'); // Log error if the request fails
                    },
                    complete: function() {
                        // Hide the loading spinner after the request is complete
                        $('#loadingSpinner').hide();
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
                '#546E7A']; // Array of colors for the bars

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

                        // Check if the response is valid
                        if (categories.length === 0 || counts.length === 0) {
                            alert("No data available for the selected stores.");
                            return;
                        }

                        // Call the function to render the pie chart with the fetched data
                        renderPieChart(categories, counts);
                    },
                    error: function(xhr, status, error) {
                        $('#loading').hide();
                        console.error("Error fetching data:", error); // Log error if the request fails
                        alert("An error occurred while fetching data. Please try again.");
                    }
                });
            }

            // Function to render the pie chart
            function renderPieChart(categories, counts) {
                var element = document.getElementById('purchaseOrdersPieChart'); // Get the pie chart element

                if (!element) {
                    console.error("Pie chart element not found"); // Log if the element is not found
                    return; // Exit if the element is not found
                }

                // Validate categories and counts
                if (!Array.isArray(categories) || !Array.isArray(counts)) {
                    console.error("Categories or counts are not arrays:", {
                        categories,
                        counts
                    });
                    return; // Exit if they are not arrays
                }

                if (categories.length === 0 || counts.length === 0) {
                    console.error("Categories or counts are empty:", {
                        categories,
                        counts
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
                            formatter: function(val) {
                                return val; // Format the tooltip value as needed
                            }
                        }
                    },
                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0',
                        '#546E7A'
                    ], // Custom colors for the pie chart
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
