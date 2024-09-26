<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('home') }}
    @endsection

    <style>
        /* Default Light Mode - No changes needed */
        #loggedInUsersCard {
            background-color: white;
            color: black;
        }

        .list-group-item {
            background-color: transparent;
            color: inherit;
            /* Keep text color the same as the parent container */
        }

        /* Dark Mode Styles */
        @media (prefers-color-scheme: dark) {
            #loggedInUsersCard {
                background-color: black;
                color: white;
            }

            .card-header {
                background-color: #333;
                /* Dark gray for the card header */
                color: white;
                /* White text for dark mode */
            }

            .list-group-item {
                background-color: transparent;
                /* Keep the list items transparent */
                color: white;
                /* Ensure text is visible in dark mode */
            }

            .badge {
                background-color: #28a745;
                /* Keep the badge green */
                color: white;
            }
        }
    </style>

    <!--begin::Dashboard-->
    <div class="row g-6 mb-6">
        <!--begin::Statistics Cards-->
        <div class="col-xl-3">
            <div class="card card-stretch">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column">
                    <span class="svg-icon svg-icon-3x text-primary">
                        <i class="fas fa-book fa-3x"></i>
                    </span>
                    <div class="d-flex align-items-center justify-content-between pt-6 mb-6">
                        <span class="fs-4 fw-semibold text-gray-400">Total Soal</span>
                        <span class="fs-2 fw-bold">45</span>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card card-stretch">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column">
                    <span class="svg-icon svg-icon-3x text-success">
                        <i class="fas fa-user-check fa-3x"></i>
                    </span>
                    <div class="d-flex align-items-center justify-content-between pt-6 mb-6">
                        <span class="fs-4 fw-semibold text-gray-400">Soal Dikerjakan</span>
                        <span class="fs-2 fw-bold">25</span>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card card-stretch">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column">
                    <span class="svg-icon svg-icon-3x text-danger">
                        <i class="fas fa-times-circle fa-3x"></i>
                    </span>
                    <div class="d-flex align-items-center justify-content-between pt-6 mb-6">
                        <span class="fs-4 fw-semibold text-gray-400">Soal Belum Dikerjakan</span>
                        <span class="fs-2 fw-bold">20</span>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card card-stretch">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column">
                    <span class="svg-icon svg-icon-3x text-info">
                        <i class="fas fa-chart-line fa-3x"></i>
                    </span>
                    <div class="d-flex align-items-center justify-content-between pt-6 mb-6">
                        <span class="fs-4 fw-semibold text-gray-400">Completion Rate</span>
                        <span class="fs-2 fw-bold">55%</span>
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>
        <!--end::Statistics Cards-->
    </div>

    <!--begin::Logged In Users-->
    <div class="row g-6 mb-6">
        <div class="col-xl-12">
            <!--begin::Logged In Users Card-->
            <div class="card card-stretch shadow-lg" id="loggedInUsersCard">
                <div class="card-header border-0 text-white">
                    <h3 class="card-title text-uppercase">Users Currently Logged In</h3>
                </div>
                <div class="card-body">
                    @if ($loggedInUsers->isEmpty())
                        <p class="text-muted">No users currently logged in.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($loggedInUsers as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">{{ $user->name }} ({{ $user->email }})</span>
                                    <span class="badge rounded-pill">Active</span>
                                </li>
                            @endforeach
                        </ul>

                    @endif
                </div>
            </div>
            <!--end::Logged In Users Card-->
        </div>
    </div>
    <!--end::Logged In Users-->


    <!--begin::Chart and Recent Activity-->
    <div class="row g-6 mb-6">
        <div class="col-xl-8">
            <!--begin::Chart-->
            <div class="card card-stretch">
                <div class="card-header border-0">
                    <h3 class="card-title">Progress Overview</h3>
                </div>
                <div class="card-body">
                    <!-- Placeholder for the chart -->
                    <div id="chartContainer" style="height: 300px;"></div>
                </div>
            </div>
            <!--end::Chart-->
        </div>

        <div class="col-xl-4">
            <!--begin::Recent Activity-->
            <div class="card card-stretch">
                <div class="card-header border-0">
                    <h3 class="card-title">Recent Activity</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-40px me-3">
                            <img src="https://via.placeholder.com/40" alt="user">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-900 fw-bold">John Doe completed Soal 1</span>
                            <span class="text-muted">5 mins ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-5">
                        <div class="symbol symbol-40px me-3">
                            <img src="https://via.placeholder.com/40" alt="user">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-900 fw-bold">Jane Smith started Soal 2</span>
                            <span class="text-muted">15 mins ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40px me-3">
                            <img src="https://via.placeholder.com/40" alt="user">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="text-gray-900 fw-bold">Alex Brown completed Soal 3</span>
                            <span class="text-muted">30 mins ago</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Recent Activity-->
        </div>
    </div>
    <!--end::Chart and Recent Activity-->

    @push('scripts')
        <!-- Include any charting library such as Chart.js or ApexCharts here -->
        <script>
            // Example: Using Chart.js to create a sample chart in the chart container
            var ctx = document.getElementById('chartContainer').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'Completed Soal',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
</x-default-layout>
