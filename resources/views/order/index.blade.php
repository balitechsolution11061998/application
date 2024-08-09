<x-default-layout>
    @section('title')
        Order
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('order') }}
    @endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid filter-input" placeholder="Search user" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <label for="date" class="form-label">Filter Date:</label>
                        <input type="date" id="date" class="form-control form-control-sm filter-input">
                    </div>

                    <div class="me-3">
                        <label for="statusFilter" class="form-label">Filter Status:</label>
                        <select id="statusFilter" class="form-select form-select-sm filter-input">
                            <option value="">All</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="me-3">
                        <label for="orderNoFilter" class="form-label">Filter Order No:</label>
                        <input type="text" id="orderNoFilter" class="form-control form-control-sm filter-input"
                            placeholder="Order No" onclick="searchOrderNo()">
                    </div>

                    <!-- Container for the buttons -->
                    <!-- Dropdown Button with Checkboxes -->
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sync fs-2"></i> Sync Data
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="syncPO">
                                    <label class="form-check-label" for="syncPO">Sync Data PO</label>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="syncRcv">
                                    <label class="form-check-label" for="syncRcv">Sync Data Receiving</label>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="syncStore">
                                    <label class="form-check-label" for="syncStore">Sync Store</label>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="syncSupplier">
                                    <label class="form-check-label" for="syncSupplier">Sync Supplier</label>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Sync Button -->
                    <button type="button" class="btn btn-primary mt-3" id="syncActionButton">
                        <i class="fas fa-sync fs-2"></i> Execute Sync
                    </button>


                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="po_table">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                    data-kt-check-target="#po_table .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-125px">ORDER NO</th>
                        <th class="min-w-125px">RECEIVE NO</th>
                        <th class="min-w-125px">SUPPLIER</th>
                        <th class="min-w-125px">STORE</th>
                        <th class="min-w-125px">STATUS</th>
                        <th class="min-w-125px">ORDER DATE</th>
                        <th class="min-w-125px">EXPIRED DATE</th>
                        <th class="min-w-125px">ESTIMATED DELIVERY DATE</th>
                        <th class="min-w-125px">RECEIVE DATE</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
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
        <script src="{{ asset('js/ordhead.js') }}"></script>
        <script src="{{ asset('js/formatRupiah.js') }}"></script>

        <!-- Add Animate.css for animation -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @endpush

    <!-- Custom Styles -->
    <style>
        .filter-input {
            background-color: #f8f9fa;
            /* Light gray background */
            color: #495057;
            /* Darker text color */
            border-radius: .375rem;
            /* Rounded corners */
            border: 1px solid #ced4da;
            /* Light border */
            transition: all 0.3s ease;
            /* Smooth transition */
        }

        .filter-input:focus {
            border-color: #007bff;
            /* Blue border on focus */
            box-shadow: 0 0 0 .2rem rgba(38, 143, 255, .25);
            /* Subtle blue shadow */
        }

        .filter-button {
            background-color: #007bff;
            /* Blue background */
            color: #ffffff;
            /* White text */
            border: none;
            border-radius: .375rem;
            /* Rounded corners */
            transition: all 0.3s ease;
            /* Smooth transition */
        }

        .filter-button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            color: #ffffff;
            /* White text on hover */
        }

        .filter-button:active {
            background-color: #004085;
            /* Even darker blue when active */
            color: #ffffff;
            /* White text when active */
        }

        .text-white {
            color: #ffffff !important;
        }
    </style>
</x-default-layout>
