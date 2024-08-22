<x-default-layout>
    @section('title')
        Product
    @endsection

    @push('styles')
        <!-- Preload Critical CSS -->
        <link rel="preload" href="{{ asset('css/style.css') }}" as="style" onload="this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        </noscript>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <style>
            /* Progress Bar Styles */
            .swal2-progress {
                width: 100%;
                height: 5px;
                background-color: #f3f3f3;
                border-radius: 5px;
                overflow: hidden;
                margin-top: 10px;
            }
            .swal2-progress-bar {
                height: 100%;
                background-color: #4caf50;
                transition: width 0.4s ease;
                border-radius: 5px;
                width: 0;
            }
            .btn-sync {
                display: flex;
                align-items: center;
                gap: 5px;
            }
        </style>
    @endpush

    @section('breadcrumbs')
        {{ Breadcrumbs::render('product') }}
    @endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <!-- Page Title -->
                <h3>Product List</h3>
            </div>
            <div class="card-toolbar">
                <!-- Sync Data Button -->
                <button type="button" class="btn btn-primary btn-sm btn-sync" onclick="syncData()">
                    <i class="fas fa-sync-alt"></i> Sync Data
                </button>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="productTable">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Type</th>
                        <th>Seller Name</th>
                        <th>Price</th>
                        <th>Buyer SKU Code</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                // Initialize DataTable
                const table = $('#productTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("product.data") }}', // Route to fetch data from controller
                    columns: [
                        { data: 'product_name', name: 'product_name' },
                        { data: 'category', name: 'category' },
                        { data: 'brand', name: 'brand' },
                        { data: 'type', name: 'type' },
                        { data: 'seller_name', name: 'seller_name' },
                        { data: 'price', name: 'price', render: $.fn.dataTable.render.number(',', '.', 0, 'IDR ') },
                        { data: 'buyer_sku_code', name: 'buyer_sku_code' },
                        { data: 'stock', name: 'stock' },
                        { data: 'status', name: 'status', render: function (data) {
                            return data ? 'Active' : 'Inactive';
                        }},
                    ]
                });

                // Sync Data with progress bar
                function syncData() {
                    Swal.fire({
                        title: 'Syncing Data',
                        html: `
                            <div class="swal2-progress">
                                <div id="progressBar" class="swal2-progress-bar"></div>
                            </div>
                            <p>Please wait while we sync the data.</p>
                        `,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    const xhr = new XMLHttpRequest();
                    const progressBar = document.getElementById('progressBar');

                    xhr.open('GET', '{{ route("product.syncData") }}', true);

                    xhr.onprogress = function (event) {
                        if (event.lengthComputable) {
                            const percentComplete = (event.loaded / event.total) * 100;
                            progressBar.style.width = percentComplete + '%';
                        }
                    };

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data synced successfully!',
                                icon: 'success',
                                timer: 1500
                            }).then(() => {
                                table.ajax.reload(); // Reload the DataTable to reflect updated data
                                progressBar.style.width = '100%';

                                setTimeout(() => {
                                    Swal.close(); // Close SweetAlert2 modal
                                }, 1000); // Close after 1 second
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Error syncing data: ' + xhr.statusText,
                                icon: 'error'
                            });
                        }
                    };

                    xhr.onerror = function () {
                        Swal.fire({
                            title: 'Request Failed',
                            text: 'The request to sync data failed.',
                            icon: 'error'
                        });
                    };

                    xhr.send();
                }

                window.syncData = syncData; // Expose the syncData function globally
            });

            // Delay script loading
            setTimeout(function () {
                loadScripts();
            }, 10000); // 10 seconds

            function loadScripts() {
                const scripts = [
                    "{{ asset('js/toastify-js.js') }}",
                    "{{ asset('js/formatRupiah.js') }}"
                ];

                scripts.forEach(function (src) {
                    const script = document.createElement('script');
                    script.src = src;
                    script.defer = true;
                    document.body.appendChild(script);
                });
            }
        </script>
    @endpush
</x-default-layout>
