<x-default-layout>
    @section('title')
        Store Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('store') }}
    @endsection

    @push('style')
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
        <style>
            progress {
                -webkit-appearance: none;
                appearance: none;
                border-radius: 10px;
                /* Rounded corners for the progress bar */
            }

            progress::-webkit-progress-bar {
                background-color: #f3f3f3;
                border-radius: 10px;
                /* Rounded corners for the progress bar */
            }

            progress::-webkit-progress-value {
                background-color: #3085d6;
                border-radius: 10px;
                /* Rounded corners for the progress bar */
            }

            progress::-moz-progress-bar {
                background-color: #3085d6;
                border-radius: 10px;
                /* Rounded corners for the progress bar */
            }

            /* SweetAlert custom styles */
            .swal2-popup {
                border-radius: 10px;
                /* Rounded corners for SweetAlert */
            }
        </style>
    @endpush

    <!-- Card Start -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Store Management</h5>
        </div>
        <div class="card-body">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-4">
                <!--begin::Sync Supplier-->
                <div class="d-flex align-items-center position-relative my-1 me-3">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                            class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="sync"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Sync Store" />
                    <button class="btn btn-info btn-sm ms-2" title="Sync" onclick="syncStore()">
                        <i class="fas fa-sync"></i>
                    </button>
                </div>
                <!--end::Sync Supplier-->

                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                            class="path2"></span></i>
                    <input type="text" data-kt-docs-table-filter="search"
                        class="form-control form-control-solid w-250px ps-15" placeholder="Search Store" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Datatable-->
            <table id="kt_datatable_example_1" class="table align-middle table-striped table-hover fs-6 gy-5">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>No</th>
                        <th>Store</th>
                        <th>Store Address</th>
                        <th>Store City</th>
                        <th>Region</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
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
                            url: '{{ route('stores.data') }}', // Adjust the route to fetch store data
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            }, // For row numbering
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-store me-2"></i>
                                <span>${row.store} (${row.store_name})</span>
                            </div>
                        `; // Combine Store and Store Name with icon
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, row) {
                                    return `
                            <div>
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <span>${row.address_1}</span><br>
                                <span>${row.address_2 ? row.address_2 : ''}</span>
                            </div>
                        `; // Format Store Address with icon
                                }
                            },
                            {
                                data: 'store_city',
                                render: function(data) {
                                    return `
                            <span class="badge bg-primary" style="padding: 0.5em 1em;">
                                <i class="fas fa-city me-1"></i> ${data}
                            </span>
                        `; // Format Store City with badge
                                }
                            },
                            {
                                data: 'region_name',
                                render: function(data) {
                                    return `
                            <span class="badge bg-secondary" style="padding: 0.5em 1em;">
                                <i class="fas fa-map-marker-alt me-1"></i> ${data}
                            </span>
                        `; // Format Region Name with badge
                                }
                            },
                            {
                                data: 'latitude'
                            },
                            {
                                data: 'longitude'
                            },
                            {
                                data: 'actions',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    const editUrl = `{{ route('stores.edit', ':id') }}`.replace(':id',
                                        row.id);
                                    const deleteUrl = `{{ route('stores.destroy', ':id') }}`.replace(
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
                        language: {
                            emptyTable: "Tidak ada data yang tersedia", // Message when no data is available
                            zeroRecords: "Tidak ada hasil yang ditemukan" // Message when no records match the search
                        }
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

            function syncStore() {
                var syncUrl = "https://publicconcerns.online/api/stores/get"; // Ensure this URL is correct
                var saveUrl = "/stores/store"; // URL to your Laravel endpoint for saving stores
                var batchSize = 50; // Define the size of each batch

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to sync this store with the API?",
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
                        <p>Please wait while we sync the store data.</p>
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

                        // Fetch store data from the API
                        fetch(syncUrl, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok: ' + response.statusText);
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data);
                                if (data.success) { // Check for success in the response
                                    const stores = data
                                    .data; // Assuming the API returns an array of stores in data.data
                                    let batches = [];
                                    for (let i = 0; i < stores.length; i += batchSize) {
                                        batches.push(stores.slice(i, i + batchSize));
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
                                                        throw new Error('Network response was not ok: ' +
                                                            response.statusText);
                                                    }
                                                    return response.json();
                                                })
                                                .then(saveData => {
                                                    console.log(saveData);
                                                    if (!saveData
                                                        .success) { // Check for success in the save response
                                                        throw new Error('Error saving store data: ' +
                                                            saveData.message);
                                                    }
                                                    // Update progress bar
                                                    const progress = Math.round(((batchIndex + 1) / batches
                                                        .length) * 100);
                                                    document.getElementById('progressBar').value = progress;
                                                    document.getElementById('progressText').innerText =
                                                        progress + '%';

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
                                            toastr.success('All stores have been synced successfully.');
                                            dt.ajax.reload(); // Refresh the DataTable
                                        })
                                        .catch(error => {
                                            console.error(error);
                                            // Close the loading spinner
                                            Swal.close();
                                            Swal.fire('Error!', 'There was an error syncing the store: ' + error
                                                .message, 'error');
                                        });
                                } else {
                                    Swal.fire('Error!', data.message ||
                                        'There was an error fetching the store data.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error(error);
                                // Close the loading spinner
                                Swal.close();
                                Swal.fire('Error!', 'There was an error syncing the store: ' + error.message,
                                    'error');
                            });
                    }
                });
            }
        </script>
    @endpush
</x-default-layout>
