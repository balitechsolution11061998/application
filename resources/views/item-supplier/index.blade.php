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
                // Initialize DataTable
                const table = $('#po_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('item-suppliers.data') }}', // Adjust the route as necessary
                        type: 'GET',
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'supplier', name: 'supplier' },
                        { data: 'sup_name', name: 'sup_name' },
                        { data: 'sku', name: 'sku' },
                        { data: 'sku_desc', name: 'sku_desc' },
                        { data: 'upc', name: 'upc' },
                        { data: 'unit_cost', name: 'unit_cost' },
                        { data: 'create_date', name: 'create_date' },
                        { data: 'last_update_date', name: 'last_update_date' },
                    ],
                });

                // Sync Data Button Click Event
                $('#syncDataBtn').on('click', function() {
                    // Show loading spinner or message
                    Swal.fire({
                        title: 'Syncing Data...',
                        text: 'Please wait while we sync data from the API.',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Fetch data from the API
                    axios.get('https://publicconcerns.online/api/item-suppliers/getData') // Replace with your API endpoint
                        .then(response => {
                            // Assuming response.data contains the array of items
                            const items = response.data;

                            // Send the data to your backend for insertion
                            return axios.post('{{ route('item-suppliers.store') }}', items);
                        })
                        .then(() => {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Data synced successfully.',
                                icon: 'success',
                            });

                            // Refresh the DataTable
                            table.ajax.reload();
                        })
                        .catch(error => {
                            console.error('Error syncing data:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'There was an error syncing the data.',
                                icon: 'error',
                            });
                        });
                });
            });
        </script>
    @endpush
</x-default-layout>
