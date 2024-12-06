<x-default-layout>
    @section('title')
        Supplier Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('supplier') }}
    @endsection

    @push('style')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <!-- Card Start -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Supplier Management</h5>
        </div>
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-4">
                <!--begin::Sync Supplier-->
                <div class="d-flex align-items-center position-relative my-1 me-3">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                            class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="sync"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Sync Supplier" />
                    <button class="btn btn-info btn-sm ms-2" title="Sync"
                        onclick="syncSupplier('{{ env('API_SYNC_URL') }}')">
                        <i class="fas fa-sync"></i>
                    </button>
                </div>
                <!--end::Sync Supplier-->

                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                            class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Supplier" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Datatable-->
            <table id="kt_datatable_example_1" class="table align-middle table-striped table-hover fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>No</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Contact Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    <!-- Data will be populated here by DataTables -->
                </tbody>
            </table>
            <!--end::Datatable-->
        </div>
    </div>
    <!-- Card End -->

    @push('scripts')
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            [0, 'asc'] // Change to your preferred order
                        ],
                        stateSave: true,
                        ajax: {
                            url: '{{ route('suppliers.data') }}', // Adjust the route to fetch supplier data
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            }, // For row numbering
                            {
                                data: 'supp_code'
                            },
                            {
                                data: 'supp_name'
                            },
                            {
                                data: 'contact_name'
                            },
                            {
                                data: 'contact_phone'
                            },
                            {
                                data: 'email'
                            },
                            {
                                data: 'address_1'
                            },
                            {
                                data: 'status',
                                render: function(data) {
                                    return data === 'Y' ?
                                        `<span class="badge bg-success" style="padding: 0.5em 0.75em;">
                                            <i class="fas fa-check-circle"></i> Active
                                        </span>` :
                                        `<span class="badge bg-danger" style="padding: 0.5em 0.75em;">
                                            <i class="fas fa-times-circle"></i> Inactive
                                        </span>`;
                                }
                            },
                            {
                                data: 'actions',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    const editUrl = `{{ route('suppliers.edit', ':id') }}`.replace(
                                        ':id', row.id);
                                    const deleteUrl = `{{ route('suppliers.destroy', ':id') }}`.replace(
                                        ':id', row.id);

                                    return `
                                        <div class="d-flex justify-content-center">
                                            <a href="${editUrl}" class="btn btn-warning btn-sm me-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="${deleteUrl}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    `;
                                }
                            }
                        ],
                    });
                };

                var handleSearchDatatable = function() {
                    const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function(e) {
                        dt.search(e.target.value).draw();
                    });

                    const filterSync = document.querySelector('[data-kt-docs-table-filter="sync"]');
                    filterSync.addEventListener('keyup', function(e) {
                        // Implement sync search logic if needed
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

            function syncSupplier() {
                var syncUrl = "https://publicconcerns.online/api/supplier/get"; // Ensure this URL is correct
                var saveUrl = "/suppliers/store"; // URL to your Laravel endpoint for saving suppliers

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to sync this supplier with the API?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, sync it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading spinner
                        Swal.fire({
                            title: 'Syncing...',
                            html: 'Please wait while we sync the supplier data.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading(); // Show loading spinner
                            }
                        });

                        // Fetch supplier data from the API
                        fetch(syncUrl, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok ' + response.statusText);
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data);
                                if (data.status) {
                                    // Send the supplier data to your Laravel backend to save it
                                    return fetch(saveUrl, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                                        },
                                        body: JSON.stringify({
                                            data: data.data
                                        }) // Assuming the API returns an array of suppliers in data.data
                                    });
                                } else {
                                    Swal.fire('Error!', data.message ||
                                        'There was an error fetching the supplier data.', 'error');
                                    throw new Error(data.message || 'Error fetching supplier data');
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok ' + response.statusText);
                                }
                                return response.json();
                            })
                            .then(saveData => {
                                // Close the loading spinner
                                Swal.close();
                                if (saveData.status) {
                                    Swal.fire('Synced!', 'The supplier has been synced successfully.', 'success');
                                    dt.ajax.reload(); // Refresh the DataTable
                                } else {
                                    Swal.fire('Error!', saveData.message ||
                                        'There was an error saving the supplier data.', 'error');
                                }
                            })
                            .catch(error => {
                                // Close the loading spinner
                                Swal.close();
                                Swal.fire('Error!', 'There was an error syncing the supplier: ' + error.message,
                                    'error');
                            });
                    }
                });
            }
        </script>
    @endpush
</x-default-layout>
