<x-default-layout>
    @section('title', 'Monitoring Presensi')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('monitoring-presensi') }}
    @endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search and Filters-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!-- Search -->
                    <div class="position-relative me-3">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" />
                    </div>

                    <!-- Cabang Filter -->
                    <div class="me-3">
                        <select id="cabang_filter" class="form-control form-control-solid">
                            <option value="">Select Cabang</option>
                            <!-- Populate options dynamically -->
                        </select>
                    </div>

                    <!-- Department Filter -->
                    <div class="me-3">
                        <select id="department_filter" class="form-control form-control-solid">
                            <option value="">Select Department</option>
                            <!-- Populate options dynamically -->
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="me-3">
                        <input type="date" id="start_date" class="form-control form-control-solid" placeholder="Start Date" />
                    </div>

                    <div class="me-3">
                        <input type="date" id="end_date" class="form-control form-control-solid" placeholder="End Date" />
                    </div>

                    <button id="filter_btn" class="btn btn-primary">Filter</button>
                </div>
                <!--end::Search and Filters-->
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="presence_table">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>No.</th>
                        <th>Nik</th>
                        <th>Nama Karyawan</th>
                        <th>Cabang</th>
                        <th>Dept</th>
                        <th>Jadwal</th>
                        <th>Jam Masuk</th>
                        <th>Foto Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Foto Pulang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    <!-- Data will be populated here -->
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    @include('modals.modal')
    <!--end::Row-->

    @push('scripts')
        <script src="{{ asset('js/presensi.js') }}"></script>
        <script src="{{ asset('js/formatRupiah.js') }}"></script>
    @endpush
</x-default-layout>
