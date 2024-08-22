<x-default-layout>
    @section('title')
        Purchase Order
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('po') }}
    @endsection
    @push('styles')
        <!-- Preload Critical CSS -->
        <link rel="preload" href="{{ asset('css/style.css') }}" as="style" onload="this.rel='stylesheet'">
        <link rel="preload" href="{{ asset('css/animate.min.css') }}" as="style"
            onload="this.onload=null;this.rel='stylesheet'">
        <noscript>
            <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
        </noscript>
    @endpush
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1 me-5">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-permissions-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" id="frmSearchPO"
                        placeholder="Search Store" />
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- Sync RCV Button and Date Input -->
                @if (env('APP_DEBUG') == true)
                    @if (auth()->user()->hasPermission('po-syncront'))
                        <div class="col-md-4 mt-2 mb-2">
                            <label for="">Sync PO</label>
                            <div class="input-group">
                                <input type="date" id="filterDate" class="form-control form-control-sm" />
                                <button type="button" class="btn btn-success btn-sm" onclick="syncPO()">
                                    <i class="fa fa-download" aria-hidden="true"></i> Sync PO
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-auto col mt-2 mb-2">
                        <label for="">Filter Date</label>
                        <input type="text" name="filterDateRange" id="filterDateRange"
                            placeholder="choose date range" class="form-control form-control-sm" />
                    </div>
                    <div class="col-md-auto col mt-2 mb-2">
                        <label for="">Order No</label>
                        <input type="text" name="order_no" id="order_no" class="form-control form-control-sm" />
                    </div>
                    <div class="col-md-auto col mt-2 mb-2">
                        <label for="">Store</label>
                        <select name="store" id="store" class="form-select form-select-sm filterStore">
                            <option value=""> == Search Store == </option>
                            <!-- Add your options here -->
                        </select>
                    </div>
                    @if (Auth::user()->hasPermission('supplier-show'))
                        <div class="col-md-auto col mt-2 mb-2">
                            <label for="">Supplier</label>
                            <select name="supplierFilter" id="supplierFilter"
                                class="form-select form-select-sm filterSupplier">
                                <option value=""> == Search Supplier == </option>
                                <!-- Add your options here -->
                            </select>
                        </div>
                    @endif

                    <div class="col-md-auto col mt-2 mb-2">
                        <label for="">Filter Status</label>
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value=""> == Choose Filter == </option>
                            <option value="Progress"> Progress </option>
                            <option value="Expired"> Expired </option>
                            <option value="Confirmed"> Confirmed </option>
                            <option value="Completed"> Completed </option>
                            <!-- Add your options here -->
                        </select>
                    </div>
                    <div class="col-md-auto col mt-2 mb-2 d-flex align-items-end">
                        <button class="rounded btn btn-primary btn-sm" onclick="filterPo()">Filter</button>
                    </div>
                @else
                    <div class="col-md-auto col mt-2 mb-2">
                        <label for="">Order No</label>
                        <input type="text" name="order_no" id="order_no" class="form-select form-select-sm" />
                    </div>
                    <div class="col-md-auto col mt-2 mb-2">
                        <label for="">Store</label>
                        <select name="store" id="store" class="form-select form-select-sm filterStore"
                            onchange="filterStore()">
                            <option value=""> == Search Store == </option>
                            <!-- Add your options here -->
                        </select>
                    </div>
                    <div class="col-md-auto col mt-2 mb-2">
                        <label for="">Supplier</label>
                        <select name="supplierFilter" id="supplierFilter"
                            class="form-select form-select-sm filterSupplier">
                            <option value=""> == Search Supplier == </option>
                            <!-- Add your options here -->
                        </select>
                    </div>
                @endif


            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="table-responsive">
                <!-- Your table goes here -->
                <table id="tablePo" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>...</th>
                            <th>Order No</th>
                            <th>Store</th>
                            <th>Supplier Name</th>
                            <th>Approval Date</th>
                            <th>Expired Date</th>
                            <th>Status</th>
                            {{-- <th>Approval Id</th>
                                <th>Total Cost</th>
                                <th>Total Retail</th>
                                <th>Comment Desc</th>
                                <th>Print Count</th>
                                <th>Status</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!--end::Card body-->
    </div>
    <!--end::Card-->
    @include('modals.modal')
    <!--end::Row-->
    @push('scripts')
        <script src="{{ asset('js/formatRupiah.js') }}" defer></script>
        <script src="{{ asset('js/po.js') }}?v=2"></script>

    @endpush
</x-default-layout>
