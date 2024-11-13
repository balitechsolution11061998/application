<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('home') }}
    @endsection

    @push('styles')
        <style>
            #browser-counts,
            #platform-counts {
                display: flex;
                justify-content: space-between;
                gap: 20px;
                margin-top: 20px;
                background-color: #1c1c1c;
                /* Dark background */
                padding: 20px;
                border-radius: 10px;
            }

            .browser-count,
            .platform-count {
                background-color: #333;
                /* Darker boxes for contrast */
                padding: 10px 20px;
                border-radius: 8px;
                width: 15%;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .browser-count:hover,
            .platform-count:hover {
                transform: scale(1.05);
                box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            }

            .browser-count i,
            .platform-count i {
                margin-bottom: 8px;
                color: #fff;
                /* White color for icons */
            }

            #browser-counts .browser-count i {
                font-size: 3rem;
            }

            #platform-counts .platform-count i {
                font-size: 3rem;
            }

            /* Adjust text size for counts */
            #browser-counts .browser-count div,
            #platform-counts .platform-count div {
                font-size: 1.2rem;
                font-weight: bold;
                margin-top: 5px;
                color: #fff;
                /* White color for text */
            }

            /* Background and shadow enhancements */
            #browser-counts,
            #platform-counts {
                background-color: #1c1c1c;
                /* Set to black */
                border-radius: 10px;
                padding: 20px;
            }

            /* Responsive design */
            @media (max-width: 768px) {

                #browser-counts,
                #platform-counts {
                    flex-direction: column;
                    align-items: center;
                }

                .browser-count,
                .platform-count {
                    width: 80%;
                    margin: 10px 0;
                }
            }

            .modal-content {
                background-color: #333;
                /* Dark modal background */
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            }

            .modal-header {
                border-bottom: none;
            }

            .modal-title {
                font-size: 1.75rem;
                font-weight: bold;
            }

            .feature-slides {
                text-align: center;
            }

            .feature-icon {
                font-size: 3rem;
                margin-bottom: 15px;
            }

            .feature-title {
                font-size: 1.5rem;
                margin-top: 10px;
                font-weight: bold;
            }

            .feature-description {
                font-size: 1rem;
                color: #ccc;
                /* Light text for description */
            }

            .modal-footer {
                background-color: #444;
                border-top: none;
                padding: 15px;
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
            }

            .btn-close {
                background: transparent;
                color: #ffffff;
                opacity: 0.8;
                transition: opacity 0.3s;
            }

            .btn-close:hover {
                opacity: 1;
            }

            .btn-outline-light {
                color: #ffffff;
                border-color: #ffffff;
            }

            .btn-outline-light:hover {
                color: #333;
                background-color: #ffffff;
                border-color: #ffffff;
            }

            @media (max-width: 768px) {
                .modal-dialog {
                    margin: 1rem;
                }

                .feature-title {
                    font-size: 1.2rem;
                }

                .feature-description {
                    font-size: 0.9rem;
                }
            }
        </style>
    @endpush
    <!-- Modal Structure with Custom Dark Theme -->
    <div class="modal fade" tabindex="-1" id="kt_modal_1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-light bg-dark border-0">
                <div class="modal-header border-0">
                    <h3 class="modal-title" id="modalLabel">What's New</h3>

                    <!-- Close Button with Updated Icon -->
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times fs-3 text-light"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="feature-slides">
                        <!-- Slide 1 Example -->
                        <div class="feature-slide active">
                            <i class="feature-icon fas fa-chart-line text-primary"></i>
                            <h4 class="feature-title">Improved Analytics Dashboard</h4>
                            <p class="feature-description">The new analytics dashboard offers customizable insights,
                                making data-driven decisions easier.</p>
                        </div>
                        <!-- Additional slides would go here -->
                    </div>
                </div>

                <div class="modal-footer border-0 d-flex justify-content-between">
                    <button id="nextBtn" class="btn btn-outline-light">Next</button>
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" id="dontShowAgain"> Don’t Show Again
                    </label>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <h1 class="text-center mb-4">System RAM Usage Per Hour</h1>

        <div class="row">
            <!-- Card for Pie chart -->
            <div class="col-md-6 mb-4">
                <div class="card card-custom" id="kt_card_2">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Total RAM Usage vs Remaining RAM</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1"
                                data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Toggle Card">
                                <i class="ki ki-arrow-down icon-nm"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1"
                                data-card-tool="reload" data-toggle="tooltip" data-placement="top" title="Reload Card">
                                <i class="ki ki-reload icon-nm"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary"
                                data-card-tool="remove" data-toggle="tooltip" data-placement="top" title="Remove Card">
                                <i class="ki ki-close icon-nm"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="ramUsagePieChart"></div>
                    </div>
                </div>

            </div>

            <!-- Card for Bar chart -->
            <div class="col-md-6 mb-4">
                <div class="card card-custom" id="kt_card_1">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">RAM Usage Over Time</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1"
                                data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Toggle Card">
                                <i class="ki ki-arrow-down icon-nm"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1"
                                data-card-tool="reload" data-toggle="tooltip" data-placement="top" title="Reload Card">
                                <i class="ki ki-reload icon-nm"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary"
                                data-card-tool="remove" data-toggle="tooltip" data-placement="top" title="Remove Card">
                                <i class="ki ki-close icon-nm"></i>
                            </a>
                        </div>
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
                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1"
                        data-card-tool="reload" data-toggle="tooltip" data-placement="top" title="Reload Card">
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
    <div class="container my-5">
        <div class="col-md-12">
            <!-- Browser Counts Section -->
            <div id="browser-counts" class="d-flex justify-content-around mb-4 p-3 bg-dark rounded shadow">
                <div class="browser-count text-center text-white">
                    <i class="fab fa-chrome fa-2x text-light"></i>
                    <div>Chrome: <span id="chrome-count">0</span></div>
                </div>
                <div class="browser-count text-center text-white">
                    <i class="fab fa-firefox fa-2x text-light"></i>
                    <div>Firefox: <span id="firefox-count">0</span></div>
                </div>
                <div class="browser-count text-center text-white">
                    <i class="fab fa-safari fa-2x text-light"></i>
                    <div>Safari: <span id="safari-count">0</span></div>
                </div>
                <div class="browser-count text-center text-white">
                    <i class="fab fa-edge fa-2x text-light"></i>
                    <div>Edge: <span id="edge-count">0</span></div>
                </div>
                <div class="browser-count text-center text-white">
                    <i class="fab fa-opera fa-2x text-light"></i>
                    <div>Opera: <span id="opera-count">0</span></div>
                </div>
                <div class="browser-count text-center text-white">
                    <i class="fas fa-globe fa-2x text-light"></i>
                    <div>Others: <span id="others-count">0</span></div>
                </div>
            </div>

            <div id="platform-counts" class="d-flex justify-content-around mt-4 p-3 bg-dark rounded shadow">
                <div class="platform-count text-center text-white">
                    <i class="fab fa-windows fa-2x text-light"></i>
                    <div>Windows: <span id="windows-count">0</span></div>
                </div>
                <div class="platform-count text-center text-white">
                    <i class="fab fa-apple fa-2x text-light"></i>
                    <div>Mac: <span id="mac-count">0</span></div>
                </div>
                <div class="platform-count text-center text-white">
                    <i class="fab fa-linux fa-2x text-light"></i>
                    <div>Linux: <span id="linux-count">0</span></div>
                </div>
                <div class="platform-count text-center text-white">
                    <i class="fab fa-android fa-2x text-light"></i>
                    <div>Android: <span id="android-count">0</span></div>
                </div>
                <div class="platform-count text-center text-white">
                    <i class="fab fa-apple fa-2x text-light"></i>
                    <div>iOS: <span id="ios-count">0</span></div>
                </div>
                <div class="platform-count text-center text-white">
                    <i class="fas fa-desktop fa-2x text-light"></i>
                    <div>Others: <span id="platform-others-count">0</span></div>
                </div>
            </div>



            <!-- Recent Activities Table -->
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-label">Recent Activities</h3>
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light-primary" title="Reload Card">
                            <i class="ki ki-reload icon-md"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-light-primary" title="Toggle Card">
                            <i class="ki ki-arrow-down icon-md"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-light-primary" title="Remove Card">
                            <i class="ki ki-close icon-md"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
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
                                <!-- Data populated by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {
                // Ensure the fetchRamUsageData function is defined before calling it
                fetchRamUsageData();

                // Ensure the fetchDataLogin function is defined before calling it
                fetchDataLogin();

                const modal = new bootstrap.Modal(document.getElementById('kt_modal_1'));
                const dontShowAgain = localStorage.getItem('dontShowFeatureModal') === 'true';

                if (!dontShowAgain) {
                    modal.show();
                }

                const slides = document.querySelectorAll('.feature-slide');
                let currentSlide = 0;

                function showSlide(index) {
                    slides.forEach((slide, i) => slide.classList.toggle('active', i === index));
                }

                document.getElementById('nextBtn').addEventListener('click', () => {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);

                    if (currentSlide === 0) {
                        modal.hide();
                        if (document.getElementById('dontShowAgain').checked) {
                            localStorage.setItem('dontShowFeatureModal', 'true');
                        }
                    }
                });

            });


            function fetchDataLogin() {
                let browserCounts = {
                    chrome: 0,
                    firefox: 0,
                    safari: 0,
                    edge: 0,
                    opera: 0,
                    others: 0
                };

                let platformCounts = {
                    windows: 0,
                    mac: 0,
                    linux: 0,
                    android: 0,
                    ios: 0,
                    others: 0
                };

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
                        },
                        {
                            data: 'action_type'
                        },
                        {
                            data: 'browser_name',
                            render: function(data) {
                                let icon = '';
                                const browser = (data || '').toLowerCase();

                                // Determine icon based on browser name and update counts
                                switch (browser) {
                                    case 'chrome':
                                        icon = '<i class="fab fa-chrome"></i>';
                                        browserCounts.chrome++;
                                        break;
                                    case 'firefox':
                                        icon = '<i class="fab fa-firefox"></i>';
                                        browserCounts.firefox++;
                                        break;
                                    case 'safari':
                                        icon = '<i class="fab fa-safari"></i>';
                                        browserCounts.safari++;
                                        break;
                                    case 'edge':
                                        icon = '<i class="fab fa-edge"></i>';
                                        browserCounts.edge++;
                                        break;
                                    case 'opera':
                                        icon = '<i class="fab fa-opera"></i>';
                                        browserCounts.opera++;
                                        break;
                                    default:
                                        icon = '<i class="fas fa-globe"></i>';
                                        browserCounts.others++;
                                }

                                return icon + ' ' + data;
                            }
                        },
                        {
                            data: 'platform',
                            render: function(data) {
                                let icon = '';
                                const platform = (data || '').toLowerCase();

                                // Determine platform icon and update counts
                                switch (platform) {
                                    case 'windows':
                                        icon = '<i class="fab fa-windows"></i>';
                                        platformCounts.windows++;
                                        break;
                                    case 'mac':
                                        icon = '<i class="fab fa-apple"></i>';
                                        platformCounts.mac++;
                                        break;
                                    case 'linux':
                                        icon = '<i class="fab fa-linux"></i>';
                                        platformCounts.linux++;
                                        break;
                                    case 'android':
                                        icon = '<i class="fab fa-android"></i>';
                                        platformCounts.android++;
                                        break;
                                    case 'ios':
                                        icon = '<i class="fab fa-apple"></i>';
                                        platformCounts.ios++;
                                        break;
                                    default:
                                        icon = '<i class="fas fa-desktop"></i>';
                                        platformCounts.others++;
                                }

                                return icon + ' ' + data;
                            }
                        },
                        {
                            data: 'device'
                        },
                        {
                            data: 'ip'
                        },
                        {
                            data: 'page'
                        },
                        {
                            data: 'created_at',
                            render: function(data, type) {
                                if (type === 'display' || type === 'filter') {
                                    const date = new Date(data);
                                    const formattedDate = date.toLocaleDateString('id-ID', {
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric'
                                    });
                                    return `<i class="fas fa-clock"></i> ${formattedDate}`;
                                }
                                return data;
                            }
                        }
                    ],
                    order: [
                        [8, 'desc']
                    ],
                    drawCallback: function(settings) {
                        // Reset counts
                        browserCounts = {
                            chrome: 0,
                            firefox: 0,
                            safari: 0,
                            edge: 0,
                            opera: 0,
                            others: 0
                        };

                        platformCounts = {
                            windows: 0,
                            mac: 0,
                            linux: 0,
                            android: 0,
                            ios: 0,
                            others: 0
                        };

                        // Loop through current page data to count browsers and platforms
                        this.api().data().each(function(row) {
                            const browser = (row.browser_name || '').toLowerCase();
                            if (browserCounts.hasOwnProperty(browser)) {
                                browserCounts[browser]++;
                            } else {
                                browserCounts.others++;
                            }

                            const platform = (row.platform || '').toLowerCase();

                            // Check if the platform is Windows (including Windows 7, Windows 10)
                            if (platform.includes('windows')) {
                                platformCounts.windows++;
                            } else if (platform === 'mac') {
                                platformCounts.mac++;
                            } else if (platform === 'linux') {
                                platformCounts.linux++;
                            } else if (platform === 'android') {
                                platformCounts.android++;
                            } else if (platform === 'ios') {
                                platformCounts.ios++;
                            } else {
                                platformCounts.others++;
                            }
                        });

                        // Update the displayed counts in the HTML
                        document.getElementById('chrome-count').innerText = browserCounts.chrome;
                        document.getElementById('firefox-count').innerText = browserCounts.firefox;
                        document.getElementById('safari-count').innerText = browserCounts.safari;
                        document.getElementById('edge-count').innerText = browserCounts.edge;
                        document.getElementById('opera-count').innerText = browserCounts.opera;
                        document.getElementById('others-count').innerText = browserCounts.others;

                        document.getElementById('windows-count').innerText = platformCounts.windows;
                        document.getElementById('mac-count').innerText = platformCounts.mac;
                        document.getElementById('linux-count').innerText = platformCounts.linux;
                        document.getElementById('android-count').innerText = platformCounts.android;
                        document.getElementById('ios-count').innerText = platformCounts.ios;
                        document.getElementById('platform-others-count').innerText = platformCounts.others;
                    }

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
