<x-default-layout>
    @section('title')
        Tahun Pelajaran Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('tahun-pelajaran') }}
    @endsection

    @push('style')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <!-- Card Start -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Tahun Pelajaran Management</h5>
        </div>
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-4">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                            class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Tahun Pelajaran" />
                </div>
                <!--end::Search-->

                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                    <!--begin::Add Tahun Pelajaran-->
                    <a href="{{ route('tahun-pelajaran.create') }}" class="btn btn-primary" data-bs-toggle="tooltip"
                        title="Add Tahun Pelajaran">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Add Tahun Pelajaran
                    </a>
                    <!--end::Add Tahun Pelajaran-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Datatable-->
            <table id="kt_datatable_example_1" class="table align-middle table-striped table-hover fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>...</th>
                        <th>Tahun Ajaran</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                </tbody>
            </table>
            <!--end::Datatable-->
        </div>
    </div>
    <!-- Card End -->
    @push('scripts')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <!-- DataTables Initialization Script -->
        <script>
            "use strict";

            var KTDatatablesServerSide = function() {
                var dt;
                var initDatatable = function() {
                    dt = $("#kt_datatable_example_1").DataTable({
                        searchDelay: 500,
                        processing: true,
                        serverSide: true,
                        order: [
                            [0, 'desc']
                        ], // Update this if necessary to match your data
                        stateSave: true,
                        select: {
                            style: 'multi',
                            selector: 'td:first-child input[type="checkbox"]',
                            className: 'row-selected'
                        },
                        ajax: {
                            url: '{{ route('tahun-pelajaran.getData') }}',
                        },
                        columns: [{
                                data: 'tahun_ajaran'
                            },
                            {
                                data: 'tahun_ajaran'
                            },
                            {
                                data: 'id',
                                orderable: false,
                                searchable: false,
                                render: function(data) {
                                    // Assuming hashId is a function that hashes the ID


                                    const editUrl = `{{ route('tahun-pelajaran.edit', ':hashedId') }}`
                                        .replace(':hashedId', data);
                                    const deleteUrl =
                                        `{{ route('tahun-pelajaran.destroy', ':hashedId') }}`.replace(
                                            ':hashedId', data);

                                    return `
                                    <a href="${editUrl}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="${deleteUrl}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                `;
                                }
                            }


                        ],
                        columnDefs: [{
                            targets: 0,
                            orderable: false,
                            render: function(data) {
                                return `<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input" type="checkbox" value="${data}" /></div>`;
                            }
                        }],
                        createdRow: function(row, data, dataIndex) {
                            $(row).find('td:eq(0)').attr('data-filter', data.tahun_ajaran);
                        }
                    });
                };

                var handleSearchDatatable = function() {
                    const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function(e) {
                        dt.search(e.target.value).draw();
                    });
                }

                return {
                    init: function() {
                        initDatatable();
                        handleSearchDatatable();
                    }
                }
            }();

            KTUtil.onDOMContentLoaded(function() {
                KTDatatablesServerSide.init();
            });


        </script>
    @endpush


</x-default-layout>
