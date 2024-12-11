<x-default-layout>
    @section('title')
        Price Change
    @endsection

    @push('styles')
        <!-- Preload Critical CSS -->
        @foreach (getGlobalAssets('css') as $path)
            <link rel="stylesheet" href="{{ asset($path) }}">
        @endforeach
        @foreach (getVendors('css') as $path)
            <link rel="stylesheet" href="{{ asset($path) }}">
        @endforeach
        <style>
            /* Custom styles for button hover effects */
            .btn-custom {
                transition: background-color 0.3s, color 0.3s;
            }

            .btn-custom:hover {
                background-color: #0056b3; /* Change to your desired hover color */
                color: white; /* Change text color on hover */
            }
        </style>

    @endpush

    @section('breadcrumbs')
        {{ Breadcrumbs::render('price-change') }}
    @endsection

    <!--begin::Card-->
    <div class="card shadow-sm border-0">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title fw-bold">Price Change Management</h3>
                <div class="d-flex">
                    <button type="button" class="btn btn-success btn-sm btn-custom me-2" onclick="uploadPriceChange()">
                        <i class="fas fa-upload me-2"></i>Upload Price Change
                    </button>
                    <button type="button" class="btn btn-primary btn-sm btn-custom" onclick="tambahPriceList()">
                        <i class="ki-duotone ki-plus fs-2"></i>Add Cost Change
                    </button>
                </div>
            </div>
            <select id="selectSupplier" class="form-select mt-3" name="state">
                <option selected disabled>Select Supplier</option>
            </select>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="tablePriceChange">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>Price List No</th>
                            <th>Display Name</th>
                            <th>Active Date</th>
                            <th>Supplier</th>
                            <th>Supplier Name</th>
                            <th>Last Approval</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <!-- Dynamic content will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Card body-->

        <div class="card-footer bg-light p-4 rounded">
            <h5 class="text-dark fw-bold">Note Pricelist:</h5>
            <ul class="list-unstyled mb-0">
                <li class="text-dark fw-bold">1. Harga pricelist adalah harga di luar PPN.</li>
                <li class="text-dark fw-bold">2. Harga pricelist adalah harga per pcs.</li>
                <li class="text-dark fw-bold">
                    3. Download format import dari excel atau csv,
                    <a href="#" class="text-primary fw-bold" onclick="showDownloadModal()">klik disini</a>.
                </li>
            </ul>
        </div>
    </div>
    <!--end::Card-->

    <!-- Modal for Price Change -->
    <div class="modal modal-lg fade" tabindex="-1" id="modalStorePriceChange">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-tag me-2"></i> Price Change
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formStorePriceChange">
                        <div class="mb-3">
                            <label for="pricelistName" class="form-label">Pricelist Name</label>
                            <input type="text" class="form-control" id="pricelistName" placeholder="Enter a Pricelist name" required />
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="activeDate" class="form-label">Active Date</label>
                                <input type="date" class="form-control" id="activeDate" required />
                            </div>
                            <div class="col">
                                <label for="newSelectSupplier" class="form-label">Supplier</label>
                                <select class="form-select" id="newSelectSupplier" required>
                                    <option selected disabled>Select an option</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <button class="btn btn-sm btn-primary" type="button" id="btnAddItem">
                                <i class="fas fa-plus me-1"></i> Add Item
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th class="text-center">BARCODE</th>
                                    <th class="text-center">OLD COST</th>
                                    <th class="text-center">NEW COST</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyPricelist">
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <span class="badge bg-danger text-white p-3">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            Click "Add Item" to add items for price change.
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" form="formStorePriceChange">Submit</button>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        @foreach (getGlobalAssets() as $path)
            <script src="{{ asset($path) }}"></script>
        @endforeach
        @foreach (getVendors('js') as $path)
            <script src="{{ asset($path) }}"></script>
        @endforeach
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

        <script>

            // Delay script loading by 1 second (1000 milliseconds)
            setTimeout(function() {
                loadScripts();
            }, 1000);

            function loadScripts() {
                const scripts = [
                    "{{ asset('js/price-change/price-change.js') }}",
                ];

                scripts.forEach(function(src) {
                    const script = document.createElement('script');
                    script.src = src;
                    script.defer = true;
                    document.body.appendChild(script);
                });
            }
        </script>
    @endpush
</x-default-layout>
