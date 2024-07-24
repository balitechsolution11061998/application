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
            <div id="spinner-department" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
            </div>
            <div class="department-content" id="department-content">
                <!-- Content will be populated by AJAX -->
            </div>
        </div>
        <div class="card">
            <h2 class="section-title"><i class="fas fa-code-branch"></i> Jumlah Cabang</h2>
            <div id="spinner-cabang" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
            </div>
            <div class="cabang-content" id="cabang-content">
                <!-- Content will be populated by AJAX -->
            </div>
        </div>
    </div>
    <div class="jam-kerja-container">
        <h2 class="section-title"><i class="fas fa-clock"></i> Jam Kerja</h2>
        <div id="spinner" style="display: none; text-align: center;">
            <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
        </div>
        <div class="jam-kerja-content" id="jam-kerja-content">
            <!-- Content will be populated by AJAX -->
        </div>
    </div>


    @push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    @endpush
</x-default-layout>
