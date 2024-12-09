<x-default-layout>
    @section('title')
        Supplier Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('supplier') }}
    @endsection

    @push('style')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
        <style>
            progress {
                -webkit-appearance: none;
                appearance: none;
                border-radius: 10px; /* Rounded corners for the progress bar */
            }

            progress::-webkit-progress-bar {
                background-color: #f3f3f3;
                border-radius: 10px; /* Rounded corners for the progress bar */
            }

            progress::-webkit-progress-value {
                background-color: #3085d6;
                border-radius: 10px; /* Rounded corners for the progress bar */
            }

            progress::-moz-progress-bar {
                background-color: #3085d6;
                border-radius: 10px; /* Rounded corners for the progress bar */
            }

            /* SweetAlert custom styles */
            .swal2-popup {
                border-radius: 10px; /* Rounded corners for SweetAlert */
            }
        </style>
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
                        onclick="syncSupplier()">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- DataTables Initialization Script -->
        <script>
            "use strict";

            var dt; // Declare dt in a broader scope

            var KTDatatablesServerSide = function() {
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
                var batchSize = 50; // Define the size of each batch

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
                        // Show loading spinner with progress bar
                        Swal.fire({
                            title: 'Syncing...',
                            html: `
                    <div style="text-align: center;">
                        <p>Please wait while we sync the supplier data.</p>
                        <progress id="progressBar" value="0" max="100" style="width: 100%; height: 20px; border-radius: 10px; appearance: none;"></progress>
                        <br>
                        <span id="progressText" style="font-weight: bold;">0%</span>
                    </div>
                `,
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
                                    // Split the data into batches
                                    const suppliers = data.data; // Assuming the API returns an array of suppliers in data.data
                                    let batches = [];
                                    for (let i = 0; i < suppliers.length; i += batchSize) {
                                        batches.push(suppliers.slice(i, i + batchSize));
                                    }

                                    // Function to send each batch
                                    const sendBatch = (batchIndex) => {
                                        if (batchIndex < batches.length) {
                                            return fetch(saveUrl, {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                                                    },
                                                    body: JSON.stringify({
                                                        data: batches[batchIndex]
                                                    })
                                                })
                                                .then(response => {
                                                    if (!response.ok) {
                                                        throw new Error('Network response was not ok ' +
                                                            response.statusText);
                                                    }
                                                    return response.json();
                                                })
                                                .then(saveData => {
                                                    console.log(saveData);
                                                    if (!saveData.status) {
                                                        throw new Error('Error saving supplier data.');
                                                    }
                                                    // Update progress bar
                                                    const progress = Math.round(((batchIndex + 1) / batches.length) * 100);
                                                    document.getElementById('progressBar').value = progress;
                                                    document.getElementById('progressText').innerText = progress + '%';

                                                    // Proceed to the next batch
                                                    return sendBatch(batchIndex + 1);
                                                });
                                        }
                                    };

                                    // Start sending batches
                                    sendBatch(0)
                                        .then(() => {
                                            // Close the loading spinner
                                            Swal.close();
                                            // Show success message with Toastr
                                            toastr.success('All suppliers have been synced successfully.');
                                            dt.ajax.reload(); // Refresh the DataTable
                                        })
                                        .catch(error => {
                                            console.log(error);
                                            // Close the loading spinner
                                            Swal.close();
                                            Swal.fire('Error!',
                                                'There was an error syncing the suppliers: Error saving supplier data.',
                                                'error');
                                        });
                                } else {
                                    Swal.fire('Error!', data.message ||
                                        'There was an error fetching the supplier data.', 'error');
                                }
                            })
                            .catch(error => {
                                console.log(error);
                                // Close the loading spinner
                                Swal.close();
                                Swal.fire('Error!',
                                    'There was an error syncing the supplier: Error saving supplier data.',
                                    'error');
                            });
                    }
                });
            }
        </script>
    @endpush
</x-default-layout>
