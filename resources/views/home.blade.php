<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <div class="dashboard-container">
        <div class="card">
            <h2 class="section-title"><i class="fas fa-building"></i> Jumlah Department</h2>
            <div id="spinner-department" style="display: none;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
            </div>
            <div class="chart-container">
                <i class="fas fa-chart-pie icon-animate" style="font-size: 48px; color: #3498db;"></i>
                <span class="chart-number custom-font" id="department-content">0</span>
            </div>
        </div>
        <div class="card">
            <h2 class="section-title"><i class="fas fa-code-branch"></i> Jumlah Cabang</h2>
            <div id="spinner-cabang" style="display: none;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
            </div>
            <div class="chart-container">
                <i class="fas fa-chart-bar icon-animate" style="font-size: 48px; color: #e74c3c;"></i>
                <span class="chart-number custom-font" id="cabang-content">0</span>
            </div>
        </div>
        <div class="card">
            <h2 class="section-title"><i class="fas fa-calendar-day"></i> Jumlah Cuti</h2>
            <div id="spinner-leave" style="display: none;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
            </div>
            <div class="chart-container">
                <i class="fas fa-calendar-check icon-animate" style="font-size: 48px; color: #2ecc71;"></i>
                <span class="chart-number custom-font" id="leave-content">0</span>
            </div>
        </div>
        <div class="card">
            <h2 class="section-title"><i class="fas fa-file-alt"></i> Jumlah PO</h2>
            <div id="spinner-po" style="display: none;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
            </div>
            <div class="chart-container">
                <i class="fas fa-chart-line icon-animate" style="font-size: 48px; color: #9b59b6;"></i>
                <span class="chart-number custom-font" id="po-content">0</span>
            </div>
        </div>
    </div>


        <div class="grid-container">
            <div class="jam-kerja-container">
                <h2 class="section-title"><i class="fas fa-clock"></i> Jam Kerja</h2>
                <div id="spinner" style="display: none; text-align: center;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="jam-kerja-content" id="jam-kerja-content">
                    <!-- Content will be populated by AJAX -->
                </div>
            </div>
            <div class="jam-kerja-container">
                <h2 class="section-title"><i class="fas fa-calendar-day"></i> Jumlah Cuti</h2>
                <div id="spinner-leave" style="display: none;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                </div>
                <div class="jam-kerja-content" id="listleave-content">
                    <!-- Content will be populated by AJAX -->
                </div>
            </div>
        </div>
        <div class="notification-button-container" style="margin: 20px;">
            <button id="notify-btn" class="btn btn-primary">
                <i class="fas fa-bell"></i> Show Notification
            </button>
        </div>

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
