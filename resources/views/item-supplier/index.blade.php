<x-default-layout>
    @section('title')
        Item Supplier
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('item-suppliers') }}
    @endsection

    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <style>
            /* Your existing styles */
            .progress-bar-container {
                width: 100%;
                background-color: #f3f3f3;
                border-radius: 10px;
                overflow: hidden;
                margin-top: 10px;
            }

            .progress-inner {
                height: 20px;
                background-color: #4caf50;
                transition: width 0.3s ease;
            }
        </style>
    @endpush

    <!-- Card Start -->
    <div class="card rounded">
        <div class="card-header d-flex justify-content-between align-items-center bg-light border-bottom-0">
            <h5 class="card-title mb-0 text-primary">Item Supplier</h5>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-primary" id="syncDataBtn">
                    <i class="fas fa-sync-alt"></i> Sync Data
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- DataTable -->
            <table id="po_table" class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-100px">#</th>

                        <th class="min-w-100px">Supplier</th>
                        <th class="min-w-100px">Supplier Name</th>
                        <th class="min-w-100px">SKU</th>
                        <th class="min-w-100px">SKU Description</th>
                        <th class="min-w-100px">UPC</th>
                        <th class="min-w-100px">Unit Cost</th>
                        <th class="min-w-100px">Created At</th>
                        <th class="min-w-100px">Updated At</th>
                        <th class="min-w-100px">VAT IND</th>
                        <th class="min-w-100px">Action</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    <!-- Data will be populated here by DataTables -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- Card End -->

    @push('scripts')
        <script>
            $(document).ready(function() {
                const table = $('#po_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('item-suppliers.data') }}', // Adjust the route as necessary
                        type: 'GET',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
                        },
                        {
                            data: 'sup_name',
                            name: 'sup_name'
                        },
                        {
                            data: 'sku',
                            name: 'sku'
                        },
                        {
                            data: 'sku_desc',
                            name: 'sku_desc'
                        },
                        {
                            data: 'upc',
                            name: 'upc'
                        },
                        {
                            data: 'unit_cost',
                            name: 'unit_cost'
                        },
                        {
                            data: 'create_date',
                            name: 'create_date'
                        },
                        {
                            data: 'last_update_date',
                            name: 'last_update_date'
                        },
                        {
                            data: 'vat_ind',
                            name: 'vat_ind',
                            render: function(data, type, row) {
                                if (data === "Y") {
                                    return '<span class="badge bg-success">Yes</span>';
                                } else {
                                    return '<span class="badge bg-danger">No</span>';
                                }
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                // Check if the SKU is a duplicate
                                const isDuplicate = data.skuCount >
                                1; // This will be set in drawCallback
                                if (isDuplicate) {
                                    return '<i class="fas fa-trash text-danger btn-delete" data-id="' +
                                        row.id + '" style="cursor: pointer;"></i>';
                                } else {
                                    return ''; // No icon for non-duplicate entries
                                }
                            }
                        }
                    ],
                    drawCallback: function(settings) {
                        const data = this.api().rows().data();
                        const skuCount = {};

                        // Count occurrences of each SKU
                        data.each(function(item) {
                            if (skuCount[item.sku]) {
                                skuCount[item.sku]++;
                            } else {
                                skuCount[item.sku] = 1;
                            }
                        });

                        // Highlight duplicates and set skuCount for rendering
                        data.each(function(item, index) {
                            if (skuCount[item.sku] > 1) {
                                $(table.row(index).node()).addClass(
                                'table-danger'); // Add Bootstrap danger class
                                item.skuCount = skuCount[item.sku]; // Set skuCount for rendering
                            } else {
                                item.skuCount = 1; // Set to 1 for non-duplicates
                            }
                        });
                    }
                });

                // Handle delete button click
                $(document).on('click', '.btn-delete', function() {
                    const itemId = $(this).data('id');

                    // Confirm deletion
                    if (confirm('Are you sure you want to delete this item?')) {
                        $.ajax({
                            url: '/item-suppliers/' + itemId, // Adjust the URL to your delete route
                            type: 'DELETE',
                            success: function(response) {
                                // Refresh the DataTable
                                table.ajax.reload();
                                alert(response.message); // Show success message
                            },
                            error: function(xhr) {
                                alert('Error deleting item: ' + xhr
                                .responseText); // Show error message
                            }
                        });
                    }
                });

                // Sync Data Button Click Event
                $('#syncDataBtn').on('click', function() {
                    // Show initial loading message
                    Swal.fire({
                        title: 'Fetching Data...',
                        text: 'Please wait while we fetch data from the API.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Fetch data from the API
                    axios.get('https://publicconcerns.online/api/itemsupplier/getData')
                        .then(response => {
                            console.log('API Response:', response.data); // Log the response
                            const items = response.data.data; // Access the array correctly

                            // Check if items is an array
                            if (!Array.isArray(items)) {
                                throw new Error('Expected items to be an array');
                            }

                            // Show progress bar after data is fetched
                            Swal.fire({
                                title: 'Syncing Data...',
                                html: `
                <div class="progress-bar-container">
                    <div id="progress" class="progress-inner" style="width: 0%;"></div>
                </div>
                <p id="progressText" style="text-align: center;">Starting...</p>
            `,
                                allowOutsideClick: false,
                                showConfirmButton: false,
                            });

                            // Send the data to your backend in chunks
                            const chunkSize = 100; // Define your chunk size
                            const totalChunks = Math.ceil(items.length / chunkSize);
                            console.log('API Response:', items.length,totalChunks); // Log the response

                            let currentChunk = 0;

                            const sendChunk = () => {
                                const chunk = items.slice(currentChunk * chunkSize, (currentChunk + 1) *
                                    chunkSize);
                                axios.post('{{ route('item-suppliers.store') }}', chunk)
                                    .then(() => {
                                        currentChunk++;
                                        document.getElementById('progress').style.width =
                                            `${(currentChunk / totalChunks) * 100}%`;
                                        document.getElementById('progressText').innerText =
                                            `Processed ${currentChunk} of ${totalChunks} chunks...`;

                                        if (currentChunk < totalChunks) {
                                            sendChunk(); // Send the next chunk
                                        } else {
                                            // All chunks sent
                                            document.getElementById('progress').style.width =
                                                '100%';
                                            document.getElementById('progressText').innerText =
                                                'Data synced successfully!';
                                            table.ajax.reload();
                                            Swal.fire({
                                                title: 'Success!',
                                                text: 'Data synced successfully.',
                                                icon: 'success',
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error syncing data:', error);
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'There was an error syncing the data.',
                                            icon: 'error',
                                        });
                                    });
                            };

                            sendChunk(); // Start sending chunks
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error fetching the data.',
                                icon: 'error',
                            });
                        });
                });
            });
        </script>
    @endpush
</x-default-layout>
