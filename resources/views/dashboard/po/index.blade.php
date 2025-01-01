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
            }

            .summary-card {
                margin-bottom: 20px;
                padding: 30px;
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
            }
        </style>
    @endpush

    <div class="container-fluid py-5">
        <!-- Dashboard Header -->
        <div class="dashboard-header text-center mb-5">
            <h1 class="display-4 fw-bold">Purchase Order Dashboard</h1>
            <p class="lead text-muted">Monitor and manage your purchase orders effectively</p>
        </div>

        <!-- Summary Cards Section -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="summary-card card p-4 text-center position-relative">
                    <h5 class="font-weight-bold">Total Orders</h5>
                    <h2 class="text-primary display-4">1,250</h2>
                    <p class="text-muted">+15% <span class="text-success">(+5% Inc)</span></p>
                    <div class="progress mb-3" style="height: 25px; padding: 0 5px; border-radius: 15px; overflow: hidden;">
                        <div class="progress-bar bg-primary progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                            <span class="text-white" style="font-weight: bold;">75%</span>
                        </div>
                    </div>
                    <img src="{{ asset('img/background/order-now.png') }}" alt="Total Orders Icon" class="icon" style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-card card p-4 text-center position-relative">
                    <h5 class="font-weight-bold">Pending Orders</h5>
                    <h2 class="text-warning display-4">300</h2>
                    <p class="text-muted">+10% <span class="text-success">(+2% Inc)</span></p>
                    <div class="progress mb-3" style="height: 25px; padding: 0 5px; border-radius: 15px; overflow: hidden;">
                        <div class="progress-bar bg-warning progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                            <span class="text-white" style="font-weight: bold;">60%</span>
                        </div>
                    </div>
                    <img src="{{ asset('img/background/follow-up.png') }}" alt="Pending Orders Icon" class="icon" style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-card card p-4 text-center position-relative">
                    <h5 class="font-weight-bold">Completed Orders</h5>
                    <h2 class="text-success display-4">950</h2>
                    <p class="text-muted">+20% <span class="text-danger">(-5% Dec)</span></p>
                    <div class="progress mb-3" style="height: 25px; padding: 0 5px; border-radius: 15px; overflow: hidden;">
                        <div class="progress-bar bg-success progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                            <span class="text-white" style="font-weight: bold;">80%</span>
                        </div>
                    </div>
                    <img src="{{ asset('img/background/completed-task.png') }}" alt="Completed Orders Icon" class="icon" style="position: absolute; top: 10px; right: 10px; width: 70px; height: 70px;">
                </div>
            </div>
        </div>

        <!-- Statistics of Active Applications -->
        <div class="chart-container">
            <h5 class="font-weight-bold">Active Applications</h5>
            <div id="activeApplicationsChart"></div>
        </div>

        <!-- Pie Chart for Purchase Orders per Date -->
        <div class="chart-container">
            <h5 class="font-weight-bold">Purchase Orders per Date</h5>
            <div id="purchaseOrdersPieChart"></div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            $(document).ready(function() {
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

                const activeApplicationsChart = new ApexCharts(document.querySelector("#activeApplicationsChart"), options);
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
                    colors: ['#007bff', '#ffc107', '#28a745', '#dc3545', '#17a2b8'], // Custom colors for the pie slices
                };

                const purchaseOrdersPieChart = new ApexCharts(document.querySelector("#purchaseOrdersPieChart"), pieOptions);
                purchaseOrdersPieChart.render().catch(error => {
                    console.error("Error rendering purchase orders pie chart:", error);
                });
            });

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
