<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection


    <!-- Dashboard Cards -->
    <div class="container mt-4">
        <!-- Toggle for Quantity or Cost -->
        <div class="d-flex justify-content-end mb-3">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-sm btn-outline-primary" id="toggle-quantity">
                    <input type="radio" name="options" id="option1" autocomplete="off"> Quantity
                </label>
                <label class="btn btn-sm btn-outline-primary active" id="toggle-cost">
                    <input type="radio" name="options" id="option2" autocomplete="off" checked> Cost
                </label>
            </div>
            <button id="help-btn" class="btn btn-info ms-auto"
                    data-intro="Click here for help with using this section.">
                <i class="fas fa-info-circle me-1"></i> Help
            </button>
        </div>

        <div class="row gy-5 gx-xl-10">
            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="fas fa-compass fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->

                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="po-content">0</span>
                            <!--end::Number-->

                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-500" id="po-title">
                                    Projects
                                </span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Spinner-->
                        <div id="po-spinner" class="text-center" style="display: none;">
                            <i class="fa fa-spinner fa-spin fs-3x text-gray-600"></i>
                        </div>
                        <!--end::Spinner-->

                        <!--begin::No Data Message-->
                        <div id="po-no-data-message" style="display: none;">
                            <p>No data available</p>
                        </div>
                        <!--end::No Data Message-->

                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="fas fa-compass fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->

                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="receiving-content">0</span>
                            <!--end::Number-->

                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-500" id="receiving-title">
                                </span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Spinner-->
                        <div id="receiving-spinner" class="text-center" style="display: none;">
                            <i class="fa fa-spinner fa-spin fs-3x text-gray-600"></i>
                        </div>
                        <!--end::Spinner-->

                        <!--begin::No Data Message-->
                        <div id="receiving-no-data-message" style="display: none;">
                            <p>No data available</p>
                        </div>
                        <!--end::No Data Message-->

                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->


            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="fas fa-compass fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->

                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="tandaterima-content">0</span>
                            <!--end::Number-->

                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-500" id="tandaterima-title">Tanda Terima
                                </span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Spinner-->
                        <div id="tandaterima-spinner" class="text-center" style="display: none;">
                            <i class="fa fa-spinner fa-spin fs-3x text-gray-600"></i>
                        </div>
                        <!--end::Spinner-->

                        <!--begin::No Data Message-->
                        <div id="tandaterima-no-data-message" style="display: none;">
                            <p>No data available</p>
                        </div>
                        <!--end::No Data Message-->

                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-sm-6 col-xl-3 mb-xl-10">
                <!--begin::Card widget 2-->
                <div class="card h-lg-100">
                    <!--begin::Body-->
                    <div class="card-body d-flex justify-content-between align-items-start flex-column">
                        <!--begin::Icon-->
                        <div class="m-0">
                            <i class="fas fa-compass fs-2hx text-gray-600"></i>
                        </div>
                        <!--end::Icon-->

                        <!--begin::Section-->
                        <div class="d-flex flex-column my-7">
                            <!--begin::Number-->
                            <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="rtv-content">0</span>
                            <!--end::Number-->

                            <!--begin::Follower-->
                            <div class="m-0">
                                <span class="fw-semibold fs-6 text-gray-500" id="rtv-title">RTV
                                </span>
                            </div>
                            <!--end::Follower-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Spinner-->
                        <div id="rtv-spinner" class="text-center" style="display: none;">
                            <i class="fa fa-spinner fa-spin fs-3x text-gray-600"></i>
                        </div>
                        <!--end::Spinner-->

                        <!--begin::No Data Message-->
                        <div id="rtv-no-data-message" style="display: none;">
                            <p>No data available</p>
                        </div>
                        <!--end::No Data Message-->

                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 2-->
            </div>
            <!--end::Col-->




        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <!-- Table for Item Details and Price Difference -->
                <div class="card shadow-sm h-90">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4" style="color: black;">
                            <i class="fas fa-boxes text-success"></i> Item Details & Price Difference
                        </h5>
                        <table id="item-details-table" class="table align-middle table-row-dashed fs-6 gy-5 mb-0"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>SKU</th>
                                    <th>Cost PO</th>
                                    <th>Cost Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="item-details-list">
                                <!-- Dynamic rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Total Suppliers and Total Stores Card -->
                <div class="card shadow-sm h-90">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-4" style="color: black;">
                            <i class="fas fa-store text-primary"></i> Supplier & Store Totals
                        </h5>
                        <div class="total-info">
                            <p class="mb-3" style="font-size: 1.25rem; color: #333;">
                                Total Suppliers: <strong id="total-suppliers" style="font-size: 1.5rem;">0</strong>
                            </p>
                            <p style="font-size: 1.25rem; color: #333;">
                                Total Stores: <strong id="total-stores" style="font-size: 1.5rem;">0</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm h-90">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-4" style="color: black;">
                            <i class="fas fa-receipt text-primary"></i> Tanda Terima List
                        </h5>

                        <hr>
                        <div id="receipt-list" class="list-group" style="max-height: 200px; overflow-y: auto;">
                            <!-- Receipt items will be injected here dynamically -->
                        </div>
                        <div id="pagination" class="mt-3">
                            <!-- Pagination buttons will be injected here dynamically -->
                        </div>
                        <div id="loading-spinner" class="spinner-border text-primary d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>




            </div>

            <div class="col-md-4">
                <!-- Supplier Service Level Card -->
                <div class="card shadow-sm h-90">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4" style="color: black;">
                            <i class="fas fa-trophy text-warning"></i> Top 5 Suppliers by Service Level
                        </h5>
                        <ul id="supplier-list" class="list-group">
                            <!-- Supplier list items will be appended here by JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">

                <!--begin::List widget 16-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800" id="delivery-tracking-title">Delivery
                                Tracking</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6" id="deliveries-in-progress">56
                                deliveries in progress</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body pt-4 px-0">
                        <!--begin::Nav-->
                        <ul class="nav nav-pills nav-pills-custom item position-relative mx-9 mb-9" role="tablist">
                            <!--begin::Item-->
                            <li class="nav-item col-6 mx-0 p-0" role="presentation">
                                <!--begin::Link-->
                                <a class="nav-link active d-flex justify-content-center w-100 border-0 h-100"
                                    data-bs-toggle="pill" href="#kt_list_widget_16_tab_1" aria-selected="true"
                                    role="tab">
                                    <!--begin::Subtitle-->
                                    <span id="confirmed-count" class="nav-text text-gray-800 fw-bold fs-6 mb-3">
                                        Confirmed
                                    </span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="nav-item col-6 mx-0 px-0" role="presentation">
                                <!--begin::Link-->
                                <a class="nav-link d-flex justify-content-center w-100 border-0 h-100"
                                    data-bs-toggle="pill" href="#kt_list_widget_16_tab_4" aria-selected="false"
                                    tabindex="-1" role="tab">
                                    <!--begin::Subtitle-->
                                    <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">
                                        Receiving
                                    </span>
                                    <!--end::Subtitle-->
                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute z-index-2 bottom-0 w-100 h-4px bg-primary rounded"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->

                            <!--begin::Bullet Wrapper-->
                            <div
                                class="bullet-wrapper position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded">
                                <span class="bullet-section bg-primary"></span>
                                <span class="bullet-section bg-secondary"></span>
                            </div>
                            <!--end::Bullet Wrapper-->
                        </ul>
                        <!--end::Nav-->

                        <!--begin::Tab Content-->
                        <div class="tab-content px-9 hover-scroll-overlay-y pe-7 me-3 mb-2" style="height: 454px">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-sm" id="deliveryModalBtn">
                                    <i class="fas fa-calendar-days"></i> Show Delivery Dates
                                </button>

                                <!-- Alert message container below the button -->
                                <div class="mt-2">
                                    <span id="deliveryAlert" class="text-danger d-none"></span>
                                    <!-- Alert message container -->
                                </div>
                            </div>

                            <!--begin::Tab pane 1 (Confirmed - Delivery)-->
                            <div class="tab-pane fade show active slide-in" id="kt_list_widget_16_tab_1"
                                role="tabpanel">
                                <!-- Content for Confirmed deliveries -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="timeline-container">
                                            <!-- Display delivery data here -->
                                            <p>No deliveries at the moment.</p> <!-- Placeholder text -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Tab pane 1-->

                            <!--begin::Tab pane 4 (Receiving)-->
                            <div class="tab-pane fade slide-in" id="kt_list_widget_16_tab_4" role="tabpanel">
                                <!-- Content for Receiving -->
                                <div class="timeline-container">
                                    <!-- Display receiving data here -->
                                    <p>No items being received at the moment.</p> <!-- Placeholder text -->
                                </div>
                            </div>
                            <!--end::Tab pane 4-->
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end::List widget 16-->
            </div>


            <div class="col-md-8">
                <div class="card card-bordered"
                    data-intro="This section displays Purchase Order data filtered by month and year.">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title"
                                data-intro="This is the title indicating the data type being displayed.">PO Data by
                                Month and Year</h5>

                        </div>
                        <div id="filter-container" class="mb-3"
                            data-intro="Use these filters to adjust the data displayed.">
                            <div class="form-container mb-3">
                                <label for="filter-date" class="filter-label"
                                    data-intro="Select a month to filter the Purchase Order data.">Date:</label>
                                <div class="input-wrapper mb-3">
                                    <input type="month" id="filter-date" class="form-control">
                                </div>

                                <label for="filter-select" class="filter-label"
                                    data-intro="Choose to view data by Quantity or Total Cost.">Filter:</label>
                                <select id="filter-select" class="form-select">
                                    <option value="qty">Quantity</option>
                                    <option value="cost">Total Cost</option>
                                </select>
                            </div>

                            <div id="dropdown-container" class="dropdown mb-3"
                                data-intro="Select the status of the Purchase Orders you wish to display."
                                style="width:100%;">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Status
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                    <li class="dropdown-item"
                                        data-intro="Expired: Purchase Orders that have passed their valid date.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show-reject" checked>
                                            <label class="form-check-label" for="show-reject">Reject</label>
                                        </div>
                                    </li>
                                    <li class="dropdown-item"
                                        data-intro="Expired: Purchase Orders that have passed their valid date.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show-expired"
                                                checked>
                                            <label class="form-check-label" for="show-expired">Expired</label>
                                        </div>
                                    </li>
                                    <li class="dropdown-item"
                                        data-intro="Completed: Purchase Orders that have been fulfilled.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show-completed"
                                                checked>
                                            <label class="form-check-label" for="show-completed">Completed</label>
                                        </div>
                                    </li>
                                    <li class="dropdown-item"
                                        data-intro="Confirmed: Purchase Orders that have been confirmed.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show-confirmed"
                                                checked>
                                            <label class="form-check-label" for="show-confirmed">Confirmed</label>
                                        </div>
                                    </li>
                                    <li class="dropdown-item"
                                        data-intro="In Progress: Purchase Orders currently being processed.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show-in-progress"
                                                checked>
                                            <label class="form-check-label" for="show-in-progress">In
                                                Progress</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="chart-container" class="position-relative">
                            <div id="kt_apexcharts_1"
                                data-intro="This chart visualizes the filtered Purchase Order data."></div>
                            <div id="spinner-po" class="spinner position-absolute top-50 start-50 translate-middle"
                                data-intro="This spinner shows while data is being loaded.">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>


    <button type="button" class="btn btn-primary chat-button" data-bs-toggle="modal"
        data-bs-target="#chatifyModal">
        <i class="fas fa-comments"></i> <!-- Font Awesome chat icon -->
    </button>
    <!-- Modal Structure -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be dynamically injected here -->
                    <p id="modalBody">Loading content...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('modals.chat')

    <!-- FAQ Search Modal -->





    {{-- <div class="notification-button-container" style="margin: 20px;">
            <button id="notify-btn" class="btn btn-primary">
                <i class="fas fa-bell"></i> Show Notification
            </button>
        </div> --}}

    @include('modals.modal')


    @push('scripts')
        <script src="{{ asset('js/home.js') }}"></script>
        <script src="{{ asset('js/formatRupiah.js') }}"></script>
    @endpush
</x-default-layout>
