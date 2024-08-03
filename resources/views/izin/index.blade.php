<x-default-layout>
    @section('title', 'Izin')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('izin') }}
    @endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search and Filters-->
                <div class="d-flex align-items-center position-relative my-1 flex-wrap">
                    <!-- Search -->
                    <div class="position-relative me-3 mb-2">
                        <i class="fas fa-search fs-3 position-absolute ms-3 top-50 start-0 translate-middle-y"></i>
                        <input type="text" id="search" class="form-control form-control-solid w-100 ps-5" placeholder="Search user" />
                    </div>

                    <!-- Cabang Filter -->
                    <div class="me-3 mb-2 flex-grow-1">
                        <select id="cabang_filter" class="form-control form-control-solid w-100">
                            <option value="">Select Cabang</option>
                            <!-- Populate options dynamically -->
                        </select>
                    </div>

                    <!-- Department Filter -->
                    <div class="me-3 mb-2 flex-grow-1">
                        <select id="department_filter" class="form-control form-control-solid w-100">
                            <option value="">Select Department</option>
                            <!-- Populate options dynamically -->
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="me-3 mb-2 flex-grow-1">
                        <input type="date" id="start_date" class="form-control form-control-solid w-100" placeholder="Start Date" />
                    </div>

                    <div class="me-3 mb-2 flex-grow-1">
                        <input type="date" id="end_date" class="form-control form-control-solid w-100" placeholder="End Date" />
                    </div>

                    <button id="filter_btn" class="btn btn-primary mb-2">    <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>

                <!--end::Search and Filters-->
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="izin_table">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>No.</th>
                        <th>Kode Izin</th>
                        <th>Tanggal Mulai</th> <!-- Changed from 'Tanggal' to 'Tanggal Mulai' -->
                        <th>Tanggal Selesai</th> <!-- Added 'Tanggal Selesai' -->
                        <th>Nik</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>Cabang</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Keterangan</th>
                        <th>Status Approve</th>
                        <th>Aksi</th>
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
        <script src="{{ asset('js/izin.js') }}"></script>
        <script src="{{ asset('js/formatRupiah.js') }}"></script>
    @endpush
</x-default-layout>
