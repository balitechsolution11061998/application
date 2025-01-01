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
                background-color: #f4f7fa;
                font-family: 'Arial', sans-serif;
                /* Change font family */
            }

            .card {
                border-radius: 15px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
                padding: 20px;
                text-align: center;
                background-color: #ffffff;
            }

            .card:hover {
                transform: scale(1.05);
            }

            .progress {
                height: 20px;
                border-radius: 10px;
            }

            .dashboard-header {
                background: linear-gradient(90deg, rgba(111, 66, 193, 1) 0%, rgba(255, 255, 255, 1) 100%);
                padding: 30px;
                border-radius: 15px;
                color: white;
                font-family: 'Helvetica Neue', sans-serif;
                /* Change font family */
            }

            .summary-card {
                margin-bottom: 20px;
                padding: 30px;
                border-radius: 15px;
                background-color: #f8f9fa;
                /* Light background for summary cards */
                transition: background-color 0.3s;
            }

            .summary-card:hover {
                background-color: #e2e6ea;
                /* Darker background on hover */
            }

            .icon {
                font-size: 2rem;
                margin-bottom: 10px;
            }

            .bg-primary {
                background-color: #007bff !important;
            }

            .bg-warning {
                background-color: #ffc107 !important;
            }

            .bg-danger {
                background-color: #dc3545 !important;
            }

            .bg-info {
                background-color: #17a2b8 !important;
            }

            .bg-success {
                background-color: #28a745 !important;
            }

            .bg-purple {
                background-color: #6f42c1 !important;
            }

            .chart-container {
                background-color: #fff;
                border-radius: 15px;
                padding: 20px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            .progress-bar {
                transition: width 1s ease;
                border-radius: 10px;
                /* Rounded corners for progress bar */
            }

            /* Grid layout for charts */
            .chart-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
                /* Space between grid items */
            }

            /* Card styling for charts */
            .chart-card {
                border-radius: 15px;
                padding: 20px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                background-color: #ffffff;
            }

            /* Custom tooltip styling */
            .apexcharts-tooltip {
                background: #343a40;
                /* Dark background for tooltip */
                color: #ffffff;
                /* White text for tooltip */
                border-radius: 5px;
                padding: 10px;
                font-size: 12px;
            }

            .spinner-container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                display: none;
                /* Hidden by default */
            }

            .date-range {
                margin-top: 20px;
                font-size: 1.2rem;
                color: #6c757d;
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
                        <div class="col-md-4 mt-2">
                            <div class="summary-card card p-4 text-center position-relative" style="padding-top: 40px;">
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
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">

                            </div>
                        </div>


                        <div class="col-md-4 mt-2">
                            <div class="summary-card card p-4 text-center position-relative" style="padding-top: 40px;">
                                <h5 class="font-weight-bold">Confirmed</h5>
                                <h2 class="text-info display-4" id="confirmedCount">Loading...</h2> <!-- Updated ID -->
                                <p class="text-muted">+5% <span class="text-success">(+1% Inc)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-info progress-bar-animated" role="progressbar"
                                        id="confirmedProgressBar" style="width: 50%;" aria-valuenow="50"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="confirmedPercentage">50%</span> <!-- Updated ID -->
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/order.png') }}" alt="Confirmed Icon" class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>


                        <div class="col-md-4 mt-2">
                            <div class="summary-card card p-4 text-center position-relative" style="padding-top: 40px;">
                                <h5 class="font-weight-bold">Printed</h5>
                                <h2 class="text-warning display-4" id="printedCount">Loading...</h2> <!-- Updated ID -->
                                <p class="text-muted">+15% <span class="text-success">(+3% Inc)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-warning progress-bar-animated" role="progressbar"
                                        id="printedProgressBar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="printedPercentage">60%</span> <!-- Updated ID -->
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
                        <div class="col-md-4 mt-2">
                            <div class="summary-card card p-4 text-center position-relative"
                                style="padding-top: 40px;">
                                <h5 class="font-weight-bold">Completed</h5>
                                <h2 class="text-success display-4" id="completedCount">Loading...</h2>
                                <!-- Updated ID -->
                                <p class="text-muted">+20% <span class="text-danger">(-5% Dec)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-success progress-bar-animated" role="progressbar"
                                        id="completedProgressBar" style="width: 80%;" aria-valuenow="80"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="completedPercentage">80%</span> <!-- Updated ID -->
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/completed-task.png') }}" alt="Completed Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>


                        <div class="col-md-4 mt-2">
                            <div class="summary-card card p-4 text-center position-relative"
                                style="padding-top: 40px;">
                                <h5 class="font-weight-bold">Expired</h5>
                                <h2 class="text-danger display-4" id="expiredCount">Loading...</h2>
                                <!-- Updated ID -->
                                <p class="text-muted">-10% <span class="text-danger">(-5% Dec)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-danger progress-bar-animated" role="progressbar"
                                        id="expiredProgressBar" style="width: 20%;" aria-valuenow="20"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="expiredPercentage">20%</span> <!-- Updated ID -->
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/expired.png') }}" alt="Expired Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>


                        <div class="col-md-4 mt-2">
                            <div class="summary-card card p-4 text-center position-relative"
                                style="padding-top: 40px;">
                                <h5 class="font-weight-bold">Rejected</h5>
                                <h2 class="text-danger display-4" id="rejectedCount">Loading...</h2>
                                <!-- Updated ID -->
                                <p class="text-muted">-5% <span class="text-danger">(-2% Dec)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-danger progress-bar-animated" role="progressbar"
                                        id="rejectedProgressBar" style="width: 10%;" aria-valuenow="10"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="rejectedPercentage">10%</span> <!-- Updated ID -->
                                    </div>
                                </div>
                                <img src="{{ asset('img/background/rejected.png') }}" alt="Rejected Icon"
                                    class="icon"
                                    style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row mb-5">
                        <div class="col-md-4 mt-2">
                            <div class="summary-card card p-4 text-center position-relative"
                                style="padding-top: 40px;">
                                <h5 class="font-weight-bold">Delivery</h5>
                                <h2 class="text-success display-4" id="deliveryCount">Loading...</h2>
                                <!-- Updated ID -->
                                <p class="text-muted">+15% <span class="text-success">(+5% Inc)</span></p>
                                <div class="progress mb-3" style="height: 25px; border-radius: 15px;">
                                    <div class="progress-bar bg-success progress-bar-animated" role="progressbar"
                                        id="deliveryProgressBar" style="width: 75%;" aria-valuenow="75"
                                        aria-valuemin="0" aria-valuemax="100">
                                        <span class="text-white" style="font-weight: bold;"
                                            id="deliveryPercentage">75%</span> <!-- Updated ID -->
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





        <!-- Grid for Charts -->
        <div class="chart-grid">
            <!-- Active Applications Chart -->
            <div class="chart-container chart-card">
                <h5 class="font-weight-bold">Active Applications</h5>
                <div id="activeApplicationsChart"></div>
            </div>

            <!-- Pie Chart for Purchase Orders per Date -->
            <div class="chart-container chart-card">
                <h5 class="font-weight-bold">Purchase Orders per Date</h5>
                <div id="purchaseOrdersPieChart"></div>
            </div>
        </div>

        <!-- Bar Chart for Net Profit and Revenue -->
        <div class="chart-container chart-card">
            <h5 class="font-weight-bold">Net Profit and Revenue</h5>
            <div id="kt_apexcharts_1"></div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

        <script>
            let startDate = ""; // Change from const to let
            let endDate = ""; // Change from const to let

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

                        fetchDataProgress(startDate.format('YYYY-MM-DD'), endDate.format(
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

                // Initialize the active applications chart
                const options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                    },
                    series: [{
                        name: 'Applications',
                        data: [80, 55, 47, 35, 24]
                    }],
                    xaxis: {
                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    },
                    colors: ['#6f42c1'],
                };

                const activeApplicationsChart = new ApexCharts(document.querySelector("#activeApplicationsChart"),
                    options);
                activeApplicationsChart.render().catch(error => {
                    console.error("Error rendering active applications chart:", error);
                });

                // Initialize the pie chart for purchase orders per date
                const pieOptions = {
                    chart: {
                        type: 'pie',
                        height: 350,
                    },
                    series: [44, 55, 13, 43, 22], // Dummy data for the pie chart
                    labels: ['Order 1', 'Order 2', 'Order 3', 'Order 4', 'Order 5'], // Labels for the pie chart
                    colors: ['#007bff', '#ffc107', '#28a745', '#dc3545',
                        '#17a2b8'
                    ], // Custom colors for the pie slices
                };

                const purchaseOrdersPieChart = new ApexCharts(document.querySelector("#purchaseOrdersPieChart"),
                    pieOptions);
                purchaseOrdersPieChart.render().catch(error => {
                    console.error("Error rendering purchase orders pie chart:", error);
                });

                // Initialize the bar chart for Net Profit and Revenue
                var element = document.getElementById('kt_apexcharts_1');
                var height = parseInt(window.getComputedStyle(element).height);
                var labelColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-gray-500');
                var borderColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-gray-200');
                var baseColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-primary');
                var secondaryColor = getComputedStyle(document.documentElement).getPropertyValue('--kt-gray-300');

                if (!element) {
                    return;
                }

                var barOptions = {
                    series: [{
                        name: 'Net Profit',
                        data: [44, 55, 57, 56, 61, 58]
                    }, {
                        name: 'Revenue',
                        data: [76, 85, 101, 98, 87, 105]
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true, // Enable animations
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
                            endingShape: 'rounded', // Rounded corners for bars
                            borderRadius: 10 // Adjust this value for more or less rounding
                        },
                    },
                    legend: {
                        show: false
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
                        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
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
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return '$' + val + ' thousands'
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
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

                var barChart = new ApexCharts(element, barOptions);
                barChart.render().catch(error => {
                    console.error("Error rendering bar chart:", error);
                });

                fetchDataPerStatus();
            });

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
