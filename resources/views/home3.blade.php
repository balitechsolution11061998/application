<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection
    <div class="row">


        <!-- Dashboard Cards -->
        <div class="container mt-4">
            <div class="row">
                @can('department-show')
                    <div class="col-md-4 mb-4">
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
                    </div>
                @endcan
                @can('kantorcabang-show')
                    <div class="col-md-4 mb-4">
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
                    </div>
                @endcan
                @can('cuti-show')
                    <div class="col-md-4 mb-4">
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
                    </div>
                @endcan
                @can('karyawan-show')
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <h2 class="section-title"><i class="fas fa-calendar-day"></i> Jumlah Karyawan</h2>
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
                    </div>
                @endcan
            </div>
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
                    <h2 class="section-title"><i class="fas fa-calendar-day"></i> List Cuti</h2>
                    <div id="spinner-leave" style="display: none;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
                    </div>
                    <div class="jam-kerja-content" id="listleave-content">
                        <!-- Content will be populated by AJAX -->
                    </div>
                </div>
            @endcan
        </div>

    </div>





    {{-- <div class="notification-button-container" style="margin: 20px;">
            <button id="notify-btn" class="btn btn-primary">
                <i class="fas fa-bell"></i> Show Notification
            </button>
        </div> --}}

    @include('modals.modal')
    @push('scripts')
        <script src="{{ asset('js/home3.js') }}"></script>
        <script src="{{ asset('js/formatRupiah.js') }}"></script>

    @endpush
</x-default-layout>
