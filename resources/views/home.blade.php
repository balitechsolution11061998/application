<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection
    <div class="row">


        <!-- Dashboard Cards -->
        <div class="dashboard-container">
            @can('department-show')
            <div class="card">
                <h2 class="section-title"><i class="fas fa-building"></i> Jumlah Department</h2>
                <div id="spinner-department" style="display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="chart-container">
                    <i class="fas fa-chart-pie icon-animate" style="font-size: 48px; color: #3498db;"></i>
                    <span class="chart-number custom-font" id="department-content">0</span>
                </div>
                <a href="/departments" class="btn btn-sm btn-primary">
                    <i class="fas fa-building"></i> View Departments
                </a>
            </div>
            @endcan
            @can('kantorcabang-show')
            <div class="card">
                <h2 class="section-title"><i class="fas fa-code-branch"></i> Jumlah Cabang</h2>
                <div id="spinner-cabang" style="display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="chart-container">
                    <i class="fas fa-chart-bar icon-animate" style="font-size: 48px; color: #e74c3c;"></i>
                    <span class="chart-number custom-font" id="cabang-content">0</span>
                </div>
                <a href="/branches" class="btn btn-sm btn-primary">
                    <i class="fas fa-code-branch"></i> View Branches
                </a>
            </div>
            @endcan
            @can('cuti-show')
            <div class="card">
                <h2 class="section-title"><i class="fas fa-calendar-day"></i> Jumlah Cuti</h2>
                <div id="spinner-leave" style="display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="chart-container">
                    <i class="fas fa-calendar-check icon-animate" style="font-size: 48px; color: #2ecc71;"></i>
                    <span class="chart-number custom-font" id="leave-content">0</span>
                </div>
                <a href="/leaves" class="btn btn-sm btn-primary">
                    <i class="fas fa-calendar-check"></i> View Leaves
                </a>
            </div>
            @endcan
            @can('po-show')
            <div class="card">
                <h2 class="section-title"><i class="fas fa-file-alt"></i> Jumlah PO</h2>
                <div id="spinner-po" style="display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="chart-container">
                    <i class="fas fa-chart-line icon-animate" style="font-size: 48px; color: #9b59b6;"></i>
                    <span class="chart-number custom-font" id="po-content">0</span>
                </div>
                <a href="/pos" class="btn btn-sm btn-primary">
                    <i class="fas fa-file-alt"></i> View POs
                </a>
            </div>
            @endcan
        </div>

        <!-- Grid Container -->
        <div class="grid-container">
            @can('jamkerja-show')
            <div class="jam-kerja-container">
                <h2 class="section-title"><i class="fas fa-clock"></i> Jam Kerja</h2>
                <div id="spinner" style="display: none; text-align: center;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="jam-kerja-content" id="jam-kerja-content">
                    <!-- Content will be populated by AJAX -->
                </div>
            </div>
            @endcan
            @can('cuti-show')
            <div class="jam-kerja-container">
                <h2 class="section-title"><i class="fas fa-calendar-day"></i> Jumlah Cuti</h2>
                <div id="spinner-leave" style="display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="jam-kerja-content" id="listleave-content">
                    <!-- Content will be populated by AJAX -->
                </div>
            </div>
            @endcan
        </div>
        @can('po-show')

        <!-- PO Data Card -->
        <div class="card card-bordered">
            <div class="card-body">
                <h5 class="card-title">PO Data by Month and Year</h5>
                <div id="filter-container" class="mb-3">
                    <div class="form-container mb-3">
                        <label for="filter-date" class="filter-label">Date:</label>
                        <div class="input-wrapper mb-3">
                            <input type="month" id="filter-date" class="form-control">
                        </div>

                        <label for="filter-select" class="filter-label">Filter:</label>
                        <select id="filter-select" class="form-select">
                            <option value="qty">Quantity</option>
                            <option value="cost">Total Cost</option>
                        </select>
                    </div>

                    <div id="dropdown-container" class="dropdown mb-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Status
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show-expired" checked>
                                    <label class="form-check-label" for="show-expired">Expired</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show-completed" checked>
                                    <label class="form-check-label" for="show-completed">Completed</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show-confirmed" checked>
                                    <label class="form-check-label" for="show-confirmed">Confirmed</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show-in-progress" checked>
                                    <label class="form-check-label" for="show-in-progress">In Progress</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="kt_apexcharts_1"></div>
                <div id="spinner-po" class="spinner">Loading...</div>
            </div>
        </div>
        @endcan
    </div>



        <!-- Include Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>





        {{-- <div class="notification-button-container" style="margin: 20px;">
            <button id="notify-btn" class="btn btn-primary">
                <i class="fas fa-bell"></i> Show Notification
            </button>
        </div> --}}


        @push('scripts')
            <script src="{{ asset('js/home.js') }}"></script>
            <script src="{{ asset('js/formatRupiah.js') }}"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (Notification.permission === 'default' || Notification.permission === 'denied') {
                        Notification.requestPermission().then(function (permission) {
                            if (permission === 'granted') {
                                showNotification();
                            }
                        });
                    } else if (Notification.permission === 'granted') {
                        showNotification();
                    }

                    document.getElementById('notify-btn').addEventListener('click', function () {
                        if (Notification.permission === 'granted') {
                            showNotification();
                        } else {
                            Notification.requestPermission().then(function (permission) {
                                if (permission === 'granted') {
                                    showNotification();
                                }
                            });
                        }
                    });
                });

                function showNotification() {
                    const notification = new Notification('Test Notification', {
                        body: 'This is a test notification',
                        icon: '/image/logo.png' // Replace with your icon URL
                    });

                    notification.onclick = function () {
                        window.focus();
                        notification.close();
                    };
                }
            </script>
        @endpush
</x-default-layout>
