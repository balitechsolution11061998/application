<x-default-layout>
    @section('title')
    Purchase Order Management
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('orders') }}
    @endsection

    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">My Balance: 37,045$</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Dashboards</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Secondary button-->
                    <a href="apps/subscriptions/list.html" class="btn btn-sm fw-bold btn-secondary">My Subscriptions</a>
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_top_up_wallet">Top Up</a>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xxl-8">
                        <!--begin::Row-->
                        <div class="row g-5 gx-xl-10">

                            <div class="col-12">
                                <!-- Carousel -->
                                <div id="statusCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <!-- Indicators -->
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#statusCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#statusCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#statusCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>

                                    <!-- Slides -->
                                    <div class="carousel-inner">
                                        <!-- Slide 1: Progress, Confirmed, Print -->
                                        <div class="carousel-item active">
                                            <div class="row g-5 gx-xl-10">
                                                <!-- Kartu Progress -->
                                                <div class="col-md-4">
                                                    <div class="card card-flush h-xl-100" style="background-color:rgb(203, 246, 202)">
                                                        <div class="card-header flex-nowrap pt-5">
                                                            <h3 class="card-title align-items-start flex-column">
                                                                <span class="card-label fw-bold fs-2 text-gray-100 custom-font-effect">Progress</span>
                                                                <span class="mt-1 fw-semibold fs-5" style="color:black;" id="progressCount">0</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body text-center pt-5">
                                                            <img src="assets/media/svg/shapes/high-performance.png" class="h-125px mb-5" alt="" />
                                                            <div class="text-start">
                                                                <span class="d-block fw-bold fs-2 text-gray-800" id="progressPercentage">0%</span>
                                                                <!-- Progress Bar -->
                                                                <div class="progress mt-2">
                                                                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #4CAF50;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="mt-1 fw-semibold fs-4" style="color:black;" id="progressText">Progress (0 tasks)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kartu Confirmed -->
                                                <div class="col-md-4">
                                                    <div class="card card-flush h-xl-100" style="background-color:rgb(203, 246, 202)">
                                                        <div class="card-header flex-nowrap pt-5">
                                                            <h3 class="card-title align-items-start flex-column">
                                                                <span class="card-label fw-bold fs-2 text-gray-100 custom-font-effect">Confirmed</span>
                                                                <span class="mt-1 fw-semibold fs-5" style="color:black;" id="confirmedCount">0</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body text-center pt-5">
                                                            <img src="assets/media/svg/shapes/checklist.png" class="h-125px mb-5" alt="" />
                                                            <div class="text-start">
                                                                <span class="d-block fw-bold fs-2 text-gray-800" id="confirmedPercentage">0%</span>
                                                                <!-- Progress Bar -->
                                                                <div class="progress mt-2">
                                                                    <div id="confirmedBar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #2196F3;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="mt-1 fw-semibold fs-4" style="color:black;" id="confirmedText">Confirmed (0 tasks)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kartu Print -->
                                                <div class="col-md-4">
                                                    <div class="card card-flush h-xl-100" style="background-color:rgb(255, 243, 205)">
                                                        <div class="card-header flex-nowrap pt-5">
                                                            <h3 class="card-title align-items-start flex-column">
                                                                <span class="card-label fw-bold fs-2 text-gray-100 custom-font-effect">Print</span>
                                                                <span class="mt-1 fw-semibold fs-5" style="color:black;" id="printCount">0</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body text-center pt-5">
                                                            <img src="assets/media/svg/shapes/check.png" class="h-125px mb-5" alt="" />
                                                            <div class="text-start">
                                                                <span class="d-block fw-bold fs-2 text-gray-800" id="printPercentage">0%</span>
                                                                <!-- Progress Bar -->
                                                                <div class="progress mt-2">
                                                                    <div id="printBar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #FFC107;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="mt-1 fw-semibold fs-4" style="color:black;" id="printText">Print (0 tasks)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Slide 2: Expired, Reject, Complete -->
                                        <div class="carousel-item">
                                            <div class="row g-5 gx-xl-10">
                                                <!-- Kartu Expired -->
                                                <div class="col-md-4">
                                                    <div class="card card-flush h-xl-100" style="background-color:rgb(255, 205, 205)">
                                                        <div class="card-header flex-nowrap pt-5">
                                                            <h3 class="card-title align-items-start flex-column">
                                                                <span class="card-label fw-bold fs-2 text-gray-100 custom-font-effect">Expired</span>
                                                                <span class="mt-1 fw-semibold fs-5" style="color:black;" id="expiredCount">0</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body text-center pt-5">
                                                            <img src="assets/media/svg/shapes/expiration-date.png" class="h-125px mb-5" alt="" />
                                                            <div class="text-start">
                                                                <span class="d-block fw-bold fs-2 text-gray-800" id="expiredPercentage">0%</span>
                                                                <!-- Progress Bar -->
                                                                <div class="progress mt-2">
                                                                    <div id="expiredBar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #F44336;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="mt-1 fw-semibold fs-4" style="color:black;" id="expiredText">Expired (0 tasks)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kartu Reject -->
                                                <div class="col-md-4">
                                                    <div class="card card-flush h-xl-100" style="background-color:rgb(255, 205, 205)">
                                                        <div class="card-header flex-nowrap pt-5">
                                                            <h3 class="card-title align-items-start flex-column">
                                                                <span class="card-label fw-bold fs-2 text-gray-100 custom-font-effect">Reject</span>
                                                                <span class="mt-1 fw-semibold fs-5" style="color:black;" id="rejectCount">0</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body text-center pt-5">
                                                            <img src="assets/media/svg/shapes/cancel-order.png" class="h-125px mb-5" alt="" />
                                                            <div class="text-start">
                                                                <span class="d-block fw-bold fs-2 text-gray-800" id="rejectPercentage">0%</span>
                                                                <!-- Progress Bar -->
                                                                <div class="progress mt-2">
                                                                    <div id="rejectBar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #FF5722;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="mt-1 fw-semibold fs-4" style="color:black;" id="rejectText">Reject (0 tasks)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kartu Complete -->
                                                <div class="col-md-4">
                                                    <div class="card card-flush h-xl-100" style="background-color:rgb(203, 246, 202)">
                                                        <div class="card-header flex-nowrap pt-5">
                                                            <h3 class="card-title align-items-start flex-column">
                                                                <span class="card-label fw-bold fs-2 text-gray-100 custom-font-effect">Complete</span>
                                                                <span class="mt-1 fw-semibold fs-5" style="color:black;" id="completeCount">0</span>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body text-center pt-5">
                                                            <img src="assets/media/svg/shapes/submit.png" class="h-125px mb-5" alt="" />
                                                            <div class="text-start">
                                                                <span class="d-block fw-bold fs-2 text-gray-800" id="completePercentage">0%</span>
                                                                <!-- Progress Bar -->
                                                                <div class="progress mt-2">
                                                                    <div id="completeBar" class="progress-bar" role="progressbar" style="width: 0%; background-color: #8BC34A;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <span class="mt-1 fw-semibold fs-4" style="color:black;" id="completeText">Complete (0 tasks)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Controls -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#statusCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#statusCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xxl-4">
                        <!--begin::Forms widget 1-->
                        <div class="card h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header position-relative min-h-50px p-0 border-bottom-2">
                                <!--begin::Nav-->
                                <ul class="nav nav-pills nav-pills-custom d-flex position-relative w-100">
                                    <!--begin::Item-->
                                    <li class="nav-item mx-0 p-0 w-50">
                                        <!--begin::Link-->
                                        <a class="nav-link btn btn-color-muted active border-0 h-100 px-0" data-bs-toggle="pill" id="kt_forms_widget_1_tab_1" href="#kt_forms_widget_1_tab_content_1">
                                            <!--begin::Subtitle-->
                                            <span class="nav-text fw-bold fs-4 mb-3">Purchase Order</span>
                                            <!--end::Subtitle-->
                                            <!--begin::Bullet-->
                                            <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                            <!--end::Bullet-->
                                        </a>
                                        <!--end::Link-->
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mx-0 px-0 w-50">
                                        <!--begin::Link-->
                                        <a class="nav-link btn btn-color-muted border-0 h-100 px-0" data-bs-toggle="pill" id="kt_forms_widget_1_tab_2" href="#kt_forms_widget_1_tab_content_2">
                                            <!--begin::Subtitle-->
                                            <span class="nav-text fw-bold fs-4 mb-3">Receiving</span>
                                            <!--end::Subtitle-->
                                            <!--begin::Bullet-->
                                            <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                            <!--end::Bullet-->
                                        </a>
                                        <!--end::Link-->
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="nav-item mx-0 px-0 w-50">
                                        <!--begin::Link-->
                                        <a class="nav-link btn btn-color-muted border-0 h-100 px-0" data-bs-toggle="pill" id="kt_forms_widget_1_tab_2" href="#kt_forms_widget_1_tab_content_2">
                                            <!--begin::Subtitle-->
                                            <span class="nav-text fw-bold fs-4 mb-3">Tanda Terima</span>
                                            <!--end::Subtitle-->
                                            <!--begin::Bullet-->
                                            <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                            <!--end::Bullet-->
                                        </a>
                                        <!--end::Link-->
                                    </li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Tab Content-->
                                <div class="tab-content">
                                    <!--begin::Tap pane-->
                                    <div class="tab-pane fade active show" id="kt_forms_widget_1_tab_content_1">
                                        <!--begin::Input group-->
                                        <div class="form-floating border border-gray-300 rounded mb-7">
                                            <select class="form-select form-select-transparent" id="kt_forms_widget_1_select_1">
                                                <option></option>
                                                <option value="0" data-kt-select2-icon="assets/media/svg/coins/bitcoin.svg" selected="selected">Bitcoin/BTC</option>
                                                <option value="1" data-kt-select2-icon="assets/media/svg/coins/ethereum.svg">Ethereum/ETH</option>
                                                <option value="2" data-kt-select2-icon="assets/media/svg/coins/filecoin.svg">Filecoin/FLE</option>
                                                <option value="3" data-kt-select2-icon="assets/media/svg/coins/chainlink.svg">Chainlink/CIN</option>
                                                <option value="4" data-kt-select2-icon="assets/media/svg/coins/binance.svg">Binance/BCN</option>
                                            </select>
                                            <label for="floatingInputValue">Coin Name</label>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Row-->
                                        <div class="row mb-7">
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Input group-->
                                                <div class="form-floating">
                                                    <input type="email" class="form-control text-gray-800 fw-bold" placeholder="00.0" id="floatingInputValue" value="$230.00" />
                                                    <label for="floatingInputValue">Amount(USD)</label>
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Input group-->
                                                <div class="form-floating">
                                                    <input type="email" class="form-control text-gray-800 fw-bold" placeholder="00.0" id="floatingInputValue" value="$0,00000032" />
                                                    <label for="floatingInputValue">Amount(BTC)</label>
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Action-->
                                        <div class="d-flex align-items-end">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_top_up_wallet" class="btn btn-primary fs-3 w-100">Make Payment</a>
                                        </div>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Tap pane-->
                                    <!--begin::Tap pane-->
                                    <div class="tab-pane fade" id="kt_forms_widget_1_tab_content_2">
                                        <!--begin::Input group-->
                                        <div class="form-floating border rounded mb-7">
                                            <select class="form-select form-select-transparent" id="kt_forms_widget_1_select_2">
                                                <option></option>
                                                <option value="0" data-kt-select2-icon="assets/media/svg/coins/bitcoin.svg" selected="selected">Bitcoin/BTC</option>
                                                <option value="1" data-kt-select2-icon="assets/media/svg/coins/ethereum.svg">Ethereum/ETH</option>
                                                <option value="2" data-kt-select2-icon="assets/media/svg/coins/filecoin.svg">Filecoin/FLE</option>
                                                <option value="3" data-kt-select2-icon="assets/media/svg/coins/chainlink.svg">Chainlink/CIN</option>
                                                <option value="4" data-kt-select2-icon="assets/media/svg/coins/binance.svg">Binance/BCN</option>
                                            </select>
                                            <label for="floatingInputValue">Coin Name</label>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Row-->
                                        <div class="row mb-7">
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Input group-->
                                                <div class="form-floating">
                                                    <input type="email" class="form-control text-gray-800 fw-bold" placeholder="00.0" id="floatingInputValue" value="$0,0000005" />
                                                    <label for="floatingInputValue">Amount(BTC)</label>
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Input group-->
                                                <div class="form-floating">
                                                    <input type="email" class="form-control text-gray-800 fw-bold" placeholder="00.0" id="floatingInputValue" value="$1230.00" />
                                                    <label for="floatingInputValue">Amount(USD)</label>
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Action-->
                                        <div class="d-flex align-items-end">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_top_up_wallet" class="btn btn-primary fs-3 w-100">Place Offer</a>
                                        </div>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Tap pane-->
                                </div>
                                <!--end::Tab Content-->
                            </div>
                            <!--end: Card Body-->
                        </div>
                        <!--end::Forms widget 1-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-xxl-8">
                        <!--begin::Chart widget 26-->
                        <div class="card card-flush overflow-hidden h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header pt-7 mb-2">
                                <!--begin::Title-->
                                <h3 class="card-title text-gray-800 fw-bold">Purchase Order History</h3>
                                <!--end::Title-->
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                    <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light d-flex align-items-center px-4">
                                        <!--begin::Display range-->
                                        <div class="text-gray-600 fw-bold">Loading date range...</div>
                                        <!--end::Display range-->
                                        <i class="ki-duotone ki-calendar-8 text-gray-500 lh-0 fs-2 ms-2 me-0">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                            <span class="path6"></span>
                                        </i>
                                    </div>
                                    <!--end::Daterangepicker-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-between flex-column pt-0 pb-1 px-0">
                                <!--begin::Info-->
                                <div class="px-9 mb-5">
                                    <!--begin::Statistics-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Currency-->
                                        <span class="fs-4 fw-semibold text-gray-500 align-self-start me-1">$</span>
                                        <!--end::Currency-->
                                        <!--begin::Value-->
                                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">12,706</span>
                                        <!--end::Value-->
                                        <!--begin::Label-->
                                        <span class="badge badge-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-white ms-n1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>4.5%</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Statistics-->
                                    <!--begin::Description-->
                                    <span class="fs-6 fw-semibold text-gray-500">Transactions in April</span>
                                    <!--end::Description-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Chart-->
                                <div id="history_po" class="min-h-auto ps-4 pe-6" data-kt-chart-info="Transactions" style="height: 400px"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Chart widget 26-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xxl-4">

                        <!--begin::Engage widget 1-->
                        <div class="card h-md-100" dir="ltr">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column flex-center">
                            <div id="kt_amcharts_3" style="width: 100%; height: 400px;"></div>

                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Engage widget 1-->

                        <!--begin::Chart Container-->
                        <!--end::Chart Container-->
                    </div>

                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-5 g-xl-10">
                    <div class="col-xxl-8">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header pt-7">
                                <h4 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">PO yang Perlu Di-Follow Up</span>
                                    <span class="text-gray-500 mt-1 fw-semibold fs-7">Daftar Purchase Order yang memerlukan tindakan</span>
                                </h4>
                                <!-- Search Input -->
                                <input type="text" class="form-control form-control-solid w-250px" placeholder="Cari..." data-kt-docs-table-filter="search">
                            </div>
                            <div class="card-body py-3">
                                <div class="table-responsive">
                                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0" id="po_followup">
                                        <thead>
                                            <tr>
                                                <th>Nomor PO</th>
                                                <th>Approval Date</th>
                                                <th>xpired Date</th>
                                                <th>Days</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diisi oleh DataTables -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->



</x-default-layout>