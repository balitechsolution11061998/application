<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('home') }}
    @endsection
    <div class="container">
        <h1 class="text-center mb-4">System RAM Usage Per Hour</h1>

        <div class="row">
            <!-- Card for Pie chart -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Total RAM Usage vs Remaining RAM</h4>
                    </div>
                    <div class="card-body">
                        <div id="ramUsagePieChart"></div>
                    </div>
                </div>
            </div>

            <!-- Card for Bar chart -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4>RAM Usage Over Time</h4>
                    </div>
                    <div class="card-body">
                        <div id="ramUsageBarChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for RAM usage details table -->
        <div class="card card-custom" id="kt_card_1">
            <!-- Card Header -->
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">RAM Usage Details Per Hour</h3>
                </div>
                <div class="card-toolbar">
                    <!-- Toggle Card Button -->
                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle"
                        data-toggle="tooltip" data-placement="top" title="Toggle Card">
                        <i class="ki ki-arrow-down icon-nm"></i>
                    </a>
                    <!-- Reload Card Button -->
                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="reload"
                        data-toggle="tooltip" data-placement="top" title="Reload Card">
                        <i class="ki ki-reload icon-nm"></i>
                    </a>
                    <!-- Remove Card Button -->
                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary" data-card-tool="remove"
                        data-toggle="tooltip" data-placement="top" title="Remove Card">
                        <i class="ki ki-close icon-nm"></i>
                    </a>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Your dynamic content like table or charts goes here -->
                <table class="table table-striped" id="ramUsageTable">
                    <thead>
                        <tr>
                            <th>Hour</th>
                            <th>Total Memory Used (MB)</th>
                            <th>Remaining RAM (MB)</th>
                            <th>Total RAM (MB)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be dynamically populated here -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Recent Activities Table -->
    <div class="container mt-5">
        <h3 class="text-center text-dark mb-4">Recent Activities</h3>
        <div class="table-responsive">
            <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead class="table-dark">
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>User</th>
                        <th>Action Type</th>
                        <th>Browser</th>
                        <th>Platform</th>
                        <th>Device</th>
                        <th>IP</th>
                        <th>Page</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Ensure the fetchRamUsageData function is defined before calling it
                fetchRamUsageData();

                // Ensure the fetchDataLogin function is defined before calling it
                fetchDataLogin();
            });


            function fetchDataLogin() {
                $('#kt_datatable_example_1').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('activities.data') }}",
                        type: 'GET'
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'user'
                        }, // Access the user's name
                        {
                            data: 'action_type'
                        },
                        {
                            data: 'browser_name',
                            render: function(data) {
                                let icon = '';
                                switch (data.toLowerCase()) {
                                    case 'chrome':
                                        icon = '<i class="fab fa-chrome"></i>';
                                        break;
                                    case 'firefox':
                                        icon = '<i class="fab fa-firefox"></i>';
                                        break;
                                    case 'safari':
                                        icon = '<i class="fab fa-safari"></i>';
                                        break;
                                    case 'edge':
                                        icon = '<i class="fab fa-edge"></i>';
                                        break;
                                    case 'opera':
                                        icon = '<i class="fab fa-opera"></i>';
                                        break;
                                    default:
                                        icon = '<i class="fas fa-globe"></i>'; // Default globe icon
                                }
                                return icon + ' ' + data; // Return icon and name
                            }
                        },
                        {
                            data: 'platform',
                            render: function(data) {
                                let icon = '';
                                switch (data.toLowerCase()) {
                                    case 'windows':
                                        icon = '<i class="fab fa-windows"></i>';
                                        break;
                                    case 'mac':
                                        icon = '<i class="fab fa-apple"></i>';
                                        break;
                                    case 'linux':
                                        icon = '<i class="fab fa-linux"></i>';
                                        break;
                                    case 'android':
                                        icon = '<i class="fab fa-android"></i>';
                                        break;
                                    case 'ios':
                                        icon =
                                            '<i class="fab fa-apple"></i>'; // iOS uses the Apple icon
                                        break;
                                    default:
                                        icon = '<i class="fas fa-desktop"></i>'; // Default desktop icon
                                }
                                return icon + ' ' + data; // Return icon and name
                            }
                        },
                        {
                            data: 'device',
                            render: function(data) {
                                let icon = '';
                                switch (data.toLowerCase()) {
                                    case 'windows':
                                        icon = '<i class="fab fa-windows"></i>';
                                        break;
                                    case 'mac':
                                        icon = '<i class="fab fa-apple"></i>';
                                        break;
                                    case 'linux':
                                        icon = '<i class="fab fa-linux"></i>';
                                        break;
                                    case 'android':
                                        icon = '<i class="fab fa-android"></i>';
                                        break;
                                    case 'ios':
                                        icon =
                                            '<i class="fab fa-apple"></i>'; // iOS uses the Apple icon
                                        break;
                                    default:
                                        icon = '<i class="fas fa-desktop"></i>'; // Default desktop icon
                                }
                                return icon + ' ' + data; // Return icon and name
                            }
                        },
                        {
                            data: 'ip'
                        },
                        {
                            data: 'page'
                        },
                        {
                            data: 'created_at'
                        }
                    ],
                    order: [
                        [8, 'desc'] // Adjust this index to match the correct column for ordering
                    ]
                });
            }






            let pieChart, lineChart; // To store the chart instances for later updates

            function fetchRamUsageData() {
                // Fetch RAM usage data from the server using AJAX
                fetch('/get-ram-usage') // Your endpoint here
                    .then(response => response.json())
                    .then(data => {
                        // Extract total RAM from the response
                        const totalRam = data.total_ram; // Total RAM sent from the server

                        // Populate the table with data
                        let tableBody = document.querySelector('#ramUsageTable tbody');
                        tableBody.innerHTML = ''; // Clear previous table rows

                        data.data.forEach(item => {
                            let row = document.createElement('tr');

                            // Format the memory usage with the "MB" suffix
                            row.innerHTML = `
        <td>${item.time}</td>
        <td>${parseFloat(item.total_memory_used).toFixed(2)} MB</td> <!-- Format total memory used -->
        <td>${parseFloat(item.remaining_ram).toFixed(2)} MB</td> <!-- Format remaining RAM -->
        <td>${totalRam} MB</td> <!-- Display total RAM -->
    `;
                            tableBody.appendChild(row);
                        });

                        $('#ramUsageTable').DataTable({
                            "paging": true, // Enable pagination
                            "searching": true, // Enable search functionality
                            "ordering": true, // Enable sorting by columns
                            "info": true // Show table info (like 'Showing 1 to 10 of 50 entries')
                        });

                        // Prepare data for the pie chart and line chart
                        const totalMemoryUsed = data.data.map(item => parseFloat(item.total_memory_used));
                        const remainingRam = data.data.map(item => parseFloat(item.remaining_ram));
                        const labels = data.data.map(item => item.time);


                        // Use the last entry's remaining_ram for the calculation of remaining RAM
                        const lastRemainingRam = remainingRam[remainingRam.length - 1];
                        const lastTotalUsedRam = totalMemoryUsed[totalMemoryUsed.length - 1];

                        // Pie Chart configuration (Total memory used vs Remaining RAM)
                        var pieOptions = {
                            series: [lastRemainingRam, lastTotalUsedRam],
                            chart: {
                                type: 'pie',
                                height: 350
                            },
                            labels: ['Remaining RAM', 'Total Memory Used'],
                            colors: ['#00E396', '#FF4560'], // Green for remaining, Red for used
                            title: {
                                text: 'Total RAM Usage vs Remaining RAM',
                                align: 'center',
                                style: {
                                    fontSize: '16px',
                                    fontWeight: 'bold',
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: (val) => `${val} MB`
                                }
                            },
                            legend: {
                                position: 'bottom'
                            }
                        };

                        // Line Chart configuration (RAM Usage over Time)
                        var lineOptions = {
                            series: [{
                                name: 'RAM Usage (MB)',
                                data: totalMemoryUsed
                            }],
                            chart: {
                                type: 'line',
                                height: 350
                            },
                            colors: ['#FF4560'], // Red for RAM usage
                            stroke: {
                                curve: 'smooth', // Makes the line smooth and rounded
                                width: 2 // Line width
                            },
                            xaxis: {
                                categories: labels,
                                title: {
                                    text: 'Time'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Memory Used (MB)'
                                },
                                min: 0
                            },
                            title: {
                                text: 'RAM Usage Over Time',
                                align: 'center',
                                style: {
                                    fontSize: '16px',
                                    fontWeight: 'bold',
                                }
                            }
                        };

                        // If pieChart exists, update its series
                        if (pieChart) {
                            pieChart.updateOptions({
                                series: [totalUsed, adjustedRemainingRam]
                            });
                        } else {
                            // If pieChart doesn't exist, create it
                            pieChart = new ApexCharts(document.querySelector("#ramUsagePieChart"), pieOptions);
                            pieChart.render();
                        }

                        // If lineChart exists, update its series
                        if (lineChart) {
                            lineChart.updateOptions({
                                series: [{
                                    name: 'RAM Usage (MB)',
                                    data: totalMemoryUsed
                                }]
                            });
                        } else {
                            // If lineChart doesn't exist, create it
                            lineChart = new ApexCharts(document.querySelector("#ramUsageBarChart"), lineOptions);
                            lineChart.render();
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
        </script>
    @endpush
</x-default-layout>
