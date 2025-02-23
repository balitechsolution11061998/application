<x-default-layout>
    @section('title', 'Data Kependudukan Management')
    @section('breadcrumbs')
        {{ Breadcrumbs::render('members') }}
    @endsection
    @push('styles')
        <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jspreadsheet.css" type="text/css" />
        <link rel="stylesheet" href="https://jsuites.net/v5/jsuites.css" type="text/css" />
        <style>
            .badge {
                padding: 8px 12px;
                /* Adjust padding */
                border-radius: 5px;
                /* Rounded corners */
                font-size: 0.9em;
                /* Font size */
                display: inline-flex;
                /* Flexbox for alignment */
                align-items: center;
                /* Center items vertically */
            }

            .badge i {
                color: white;
                /* Set icon color to white */
                margin-right: 5px;
                /* Space between icon and text */
            }

            .badge.bg-warning {
                background-color: #ffc107;
                /* Bootstrap warning color */
            }

            .badge.bg-success {
                background-color: #28a745;
                /* Bootstrap success color */
            }

            .badge.bg-danger {
                background-color: #dc3545;
                /* Bootstrap danger color */
            }
        </style>
    @endpush

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Kependudukan Management</h5>
            <div>
                <a href="{{ route('data-kependudukan.import') }}" class="btn btn-secondary btn-sm me-2">
                    <i class="fa fa-file-excel"></i> Import Data (Excel)
                </a>
                <a href="#" id="bulkInputButton" class="btn btn-success btn-sm me-2">
                    <i class="fa fa-edit"></i> Bulk Input
                </a>
                <a href="{{ route('data-kependudukan.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Add Data
                </a>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-5">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                            class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Penduduk" />
                </div>
                <!--end::Search-->

                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="tooltip"
                        title="Coming Soon">
                        <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span
                                class="path2"></span></i>
                        Filter
                    </button>
                    <!--end::Filter-->

                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" title="Coming Soon">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Add Penduduk
                    </button>
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                    </div>

                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" title="Coming Soon">
                        Selection Action
                    </button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Wrapper-->
            <table id="dataKependudukanTable" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>No KK</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Golongan Darah</th>
                        <th>Status Kawin</th>
                        <th>Nama Ibu</th>
                        <th>Nama Bapak</th>
                        <th>Alamat</th>
                        <th>KTP Elektronik</th>
                        <th>Keterangan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal for Bulk Input -->
    <div class="modal fade modal-lg" id="bulkInputModal" tabindex="-1" aria-labelledby="bulkInputModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkInputModalLabel">Bulk Input Data Kependudukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="bulkInputTable" style="overflow: auto;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveBulkInput" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://jsuites.net/v5/jsuites.js"></script>
        <script src="https://bossanova.uk/jspreadsheet/v4/jspreadsheet.js"></script>

        <script>
            $(function() {
                // Initialize DataTable
                const dataTable = $('#dataKependudukanTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searchable: true,
                    deferRender: true,
                    ajax: "{{ route('data-kependudukan.getData') }}",
                    columns: [{
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin'
                        },
                        {
                            data: 'tempat_lahir',
                            name: 'tempat_lahir',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-map-marker-alt"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'tanggal_lahir',
                            name: 'tanggal_lahir',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-calendar-times"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'agama',
                            name: 'agama'
                        },
                        {
                            data: 'no_kk',
                            name: 'no_kk'
                        },
                        {
                            data: 'pendidikan',
                            name: 'pendidikan',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'golongan_darah',
                            name: 'golongan_darah',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'status_kawin',
                            name: 'status_kawin',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'nama_ibu',
                            name: 'nama_ibu',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'nama_bapak',
                            name: 'nama_bapak',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'alamat',
                            name: 'alamat',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'ktp_elektronik',
                            name: 'ktp_elektronik',
                            render: function(data) {
                                return data === 1 ?
                                    '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Yes</span>' :
                                    '<span class="badge bg-warning"><i class="fas fa-times-circle"></i> No</span>';
                            }
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan',
                            render: function(data) {
                                return data ? data :
                                    '<span class="badge bg-warning"><i class="fas fa-exclamation-circle"></i> No Data</span>';
                            }
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    responsive: true,
                    lengthMenu: [10, 25, 50, 100],
                });

                // Real-time search functionality
                $('input[data-kt-docs-table-filter="search"]').on('keyup', function() {
                    dataTable.search(this.value).draw();
                });

                // Initialize JSpreadsheet for Bulk Input
                let bulkInputTable;
                $('#bulkInputButton').click(function() {
                    $('#bulkInputModal').modal('show');

                    // Clear previous jExcel instance
                    if (bulkInputTable) {
                        bulkInputTable.destroy();
                    }

                    bulkInputTable = jspreadsheet(document.getElementById('bulkInputTable'), {
                        data: [
                            []
                        ], // Start with an empty grid
                        columns: [{
                                title: 'Nama',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'NIK',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'Jenis Kelamin',
                                type: 'dropdown',
                                source: ['L', 'P'],
                                width: 100
                            },
                            {
                                title: 'Tempat Lahir',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'Tanggal Lahir',
                                type: 'calendar',
                                options: {
                                    format: 'YYYY-MM-DD'
                                },
                                width: 150
                            },
                            {
                                title: 'Agama',
                                type: 'text',
                                width: 100
                            },
                            {
                                title: 'No KK',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'Pendidikan',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'Pekerjaan',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'Golongan Darah',
                                type: 'dropdown',
                                source: ['A', 'B', 'AB', 'O'],
                                width: 100
                            },
                            {
                                title: 'Status Kawin',
                                type: 'dropdown',
                                source: ['KAWIN', 'BELUM KAWIN', 'KAWIN TERCATAT'],
                                width: 150
                            },
                            {
                                title: 'Nama Ibu',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'Nama Bapak',
                                type: 'text',
                                width: 150
                            },
                            {
                                title: 'Alamat',
                                type: 'text',
                                width: 200
                            },
                            {
                                title: 'KTP Elektronik',
                                type: 'checkbox',
                                width: 100
                            },
                            {
                                title: 'Keterangan',
                                type: 'text',
                                width: 200
                            },
                        ],
                        minDimensions: [5, 10], // Minimum 5 columns and 10 rows
                        allowInsertColumn: false,
                        allowDeleteColumn: false,
                        responsive: true, // Make the spreadsheet responsive
                    });
                });

                // Save Bulk Input
                $('#saveBulkInput').click(function() {
                    const data = bulkInputTable.getData();

                    // Filter out empty rows
                    const filteredData = data.filter(row => row.some(cell => cell !== null && cell !== ''));

                    if (filteredData.length === 0) {
                        alert('No data to save!');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('data-kependudukan.bulkStore') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            data: filteredData,
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                dataTable.ajax.reload();
                                $('#bulkInputModal').modal('hide');
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert('Failed to save data. Please try again.');
                        },
                    });
                });
            });
        </script>
    @endpush


</x-default-layout>
