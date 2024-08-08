<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection
    <div class="row">


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
            </div>



            <!-- Row with PO, Receiving, Tanda Terima, RTV, and Cost Cards -->
            <div class="row">

                <!-- Total POs Card -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card h-100 shadow-sm rounded border-0">
                        <div class="card-body text-center">
                            <h3 class="section-title">
                                <i class="fas fa-file-invoice"></i> <!-- Updated Icon -->
                                <span id="po-title">Total POs</span>
                                <span class="badge badge-info ml-2" id="po-month-year">Aug 2024</span>
                            </h3>
                            <div id="spinner-po" style="display: none;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 20px;"></i>
                            </div>
                            <div class="chart-container my-2">
                                <i class="fas fa-chart-bar icon-animate" style="font-size: 40px; color: #9b59b6;"></i>
                                <span class="chart-number custom-font d-block" id="po-content">0</span>
                            </div>
                            <a href="/po" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-file-invoice"></i> View POs
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Receivings Card -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card h-100 shadow-sm rounded border-0">
                        <div class="card-body text-center">
                            <h3 class="section-title">
                                <i class="fas fa-box"></i> <!-- Updated Icon -->
                                <span id="receiving-title">Total Receivings</span>
                                <span class="badge badge-info ml-2" id="receiving-month-year">Aug 2024</span>
                            </h3>
                            <div id="spinner-receiving" style="display: none;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 20px;"></i>
                            </div>
                            <div class="chart-container my-2">
                                <i class="fas fa-cube icon-animate" style="font-size: 40px; color: #3498db;"></i>
                                <span class="chart-number custom-font d-block" id="receiving-content">0</span>
                            </div>
                            <a href="/receivings" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-box"></i> View Receivings
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Tanda Terima Card -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card h-100 shadow-sm rounded border-0">
                        <div class="card-body text-center">
                            <h3 class="section-title">
                                <i class="fas fa-handshake"></i> <!-- Updated Icon -->
                                Total Tanda Terima
                                <span class="badge badge-info ml-2" id="tanda-terima-month-year">Aug 2024</span>
                                <!-- Badge for month and year -->
                            </h3>
                            <div id="spinner-tanda-terima" style="display: none;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 20px;"></i>
                            </div>
                            <div class="chart-container my-2">
                                <i class="fas fa-handshake-alt icon-animate"
                                    style="font-size: 40px; color: #3498db;"></i> <!-- Updated Icon -->
                                <span class="chart-number custom-font d-block" id="tanda-terima-content">0</span>
                            </div>
                            <a href="/tanda-terima" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-handshake"></i> View Tanda Terima
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total RTV Card -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card h-100 shadow-sm rounded border-0">
                        <div class="card-body text-center">
                            <h3 class="section-title">
                                <i class="fas fa-box-open"></i> <!-- Updated Icon -->
                                Total RTV
                                <span class="badge badge-info ml-2" id="rtv-month-year">Aug 2024</span>
                                <!-- Badge for month and year -->
                            </h3>
                            <div id="spinner-rtv" style="display: none;">
                                <i class="fas fa-spinner fa-spin" style="font-size: 20px;"></i>
                            </div>
                            <div class="chart-container my-2">
                                <i class="fas fa-box-open icon-animate" style="font-size: 40px; color: #3498db;"></i>
                                <!-- Updated Icon -->
                                <span class="chart-number custom-font d-block" id="rtv-content">0</span>
                            </div>
                            <a href="/rtv" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-box-open"></i> View RTV
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Cost Card -->

            </div>
        </div>



        <!-- Rombel and Kelas Detail Card -->

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm border-light">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="section-title mb-0"><i class="fas fa-info-circle"></i> Query Performance Logs</h2>
                        <div class="d-flex align-items-center">
                            <!-- Toggle Switch with Custom Styling -->
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="toggleView">
                                <label class="form-check-label" for="toggleView">Show Table</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Dropdown Button -->
                        <div class="dropdown mb-4">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Show Data Series
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-average-query" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <div class="dropdown-item form-check">
                                        <input class="form-check-input" type="checkbox" id="showExecutionTime">
                                        <label class="form-check-label" for="showExecutionTime">Average Execution Time</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item form-check">
                                        <input class="form-check-input" type="checkbox" id="showPing">
                                        <label class="form-check-label" for="showPing">Average Ping</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item form-check">
                                        <input class="form-check-input" type="checkbox" id="showMemoryUsage">
                                        <label class="form-check-label" for="showMemoryUsage">Memory Usage</label>
                                    </div>
                                </li>
                            </ul>
                        </div>



                        <!-- Chart Container -->
                        <div class="chart-container mb-4" id="chartContainer">
                            <div id="chartCanvas"></div>
                        </div>
                        <!-- Table Container (Initially Hidden) -->
                        <div class="table-responsive" id="tableQueryPerformanceLog" style="display: none;">
                            <table id="queryPerformance-table" class="table align-middle table-row-dashed fs-6 gy-5">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Function Name</th>
                                        <th>Average Execution Time</th>
                                        <th>Average Ping</th>
                                        <th>Average Download Speed</th>
                                        <th>Average Upload Speed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated here by DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Grid Container -->

        @can('po-show')
            <div class="row">
                <div class="col-xl-4">

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

                            <!--begin::Toolbar-->
                            {{-- <div class="card-toolbar">
                                <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" data-bs-custom-class="tooltip-inverse"
                                    data-bs-original-title="Delivery App is coming soon" data-kt-initialized="1">View
                                    All</a>
                            </div> --}}
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-4 px-0">
                            <!--begin::Nav-->
                            <ul class="nav nav-pills nav-pills-custom item position-relative mx-9 mb-9" role="tablist">
                                <!--begin::Item-->
                                <li class="nav-item col-3 mx-0 p-0" role="presentation">
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
                                <li class="nav-item col-3 mx-0 px-0" role="presentation">
                                    <!--begin::Link-->
                                    <a class="nav-link d-flex justify-content-center w-100 border-0 h-100"
                                        data-bs-toggle="pill" href="#kt_list_widget_16_tab_2" aria-selected="false"
                                        tabindex="-1" role="tab">
                                        <!--begin::Subtitle-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">
                                            Preparing
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
                                <li class="nav-item col-3 mx-0 px-0" role="presentation">
                                    <!--begin::Link-->
                                    <a class="nav-link d-flex justify-content-center w-100 border-0 h-100"
                                        data-bs-toggle="pill" href="#kt_list_widget_16_tab_3" aria-selected="false"
                                        tabindex="-1" role="tab">
                                        <!--begin::Subtitle-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 mb-3">
                                            Delivering
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
                                <li class="nav-item col-3 mx-0 px-0" role="presentation">
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

                                <!--begin::Bullet-->
                                <span class="position-absolute z-index-1 bottom-0 w-100 h-4px bg-light rounded"></span>
                                <!--end::Bullet-->
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
                                <!--begin::Tab pane 1 (Confirmed)-->
                                <div class="tab-pane fade show active" id="kt_list_widget_16_tab_1" role="tabpanel">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="timeline-container"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Tab pane 1-->

                                <!--begin::Tab pane 2 (Preparing)-->
                                <div class="tab-pane fade" id="kt_list_widget_16_tab_2" role="tabpanel">
                                    <!--begin::Item container-->
                                    <div class="timeline-container"></div>
                                    <!--end::Item container-->
                                </div>
                                <!--end::Tab pane 2-->

                                <!--begin::Tab pane 3 (Delivery)-->
                                <div class="tab-pane fade" id="kt_list_widget_16_tab_3" role="tabpanel">
                                    <!--begin::Item container-->
                                    <div class="timeline-container"></div>
                                    <!--end::Item container-->
                                </div>
                                <!--end::Tab pane 3-->

                                <!--begin::Tab pane 4 (Receiving)-->
                                <div class="tab-pane fade" id="kt_list_widget_16_tab_4" role="tabpanel">
                                    <!--begin::Item container-->
                                    <div class="timeline-container"></div>
                                    <!--end::Item container-->
                                </div>
                                <!--end::Tab pane 4-->
                            </div>

                            <!--end::Tab Content-->
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end::List widget 16-->
                </div>

                <div class="col-xl-8">
                    <div class="card card-bordered"
                        data-intro="This section displays Purchase Order data filtered by month and year.">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"
                                    data-intro="This is the title indicating the data type being displayed.">PO Data by
                                    Month and Year</h5>
                                <button id="help-btn" class="btn btn-info ms-auto"
                                    data-intro="Click here for help with using this section.">
                                    <i class="fas fa-info-circle me-1"></i> Help
                                </button>
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
                                    data-intro="Select the status of the Purchase Orders you wish to display.">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Status
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
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
                                                <label class="form-check-label" for="show-in-progress">In Progress</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="kt_apexcharts_1"
                                data-intro="This chart visualizes the filtered Purchase Order data."></div>
                            <div id="spinner-po" class="spinner"
                                data-intro="This spinner shows while data is being loaded.">Loading...</div>
                        </div>
                    </div>
                </div>



            </div>

            <!-- Modal HTML -->

            <!-- PO Data Card -->
        @endcan


    </div>
    <button type="button" class="btn btn-primary chat-button" data-bs-toggle="modal" data-bs-target="#chatifyModal">
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
