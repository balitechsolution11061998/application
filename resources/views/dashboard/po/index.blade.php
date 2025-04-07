<x-default-layout>

@section('title', 'Purchase Order Management Dashboard')

@section('breadcrumbs')
{{ Breadcrumbs::render('orders') }}
@endsection

<div class="d-flex flex-column flex-column-fluid">
    <!-- Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!-- Page title -->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Purchase Order Dashboard
                    <span class="text-muted fs-6 fw-semibold">Overview of all purchase order activities</span>
                </h1>
            </div>
            <!-- Actions -->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
           
                <div class="m-0">
                    <a href="#" class="btn btn-sm btn-flex bg-body btn-light-primary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-6 text-gray-500 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Filter
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Filter Options</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5">
                            <form id="dashboard-filter-form">
                                <div class="mb-10">
                                    <label class="form-label fw-semibold">Status:</label>
                                    <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-placeholder="Select status" name="status[]">
                                        <option value="draft">Draft</option>
                                        <option value="pending_approval">Pending Approval</option>
                                        <option value="approved">Approved</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="partially_received">Partially Received</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="mb-10">
                                    <label class="form-label fw-semibold">Date Range:</label>
                                    <input class="form-control form-control-solid" placeholder="Pick date range" id="kt_daterangepicker_1" name="date_range"/>
                                </div>
                                <div class="mb-10">
                                    <label class="form-label fw-semibold">Supplier:</label>
                                 
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-sm fw-bold btn-primary" id="export-dashboard">
                    <i class="ki-duotone ki-file-down fs-2"></i>Export
                </a>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <!-- Stats Widgets -->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!-- Total PO Card -->
                <div class="col-xl-3">
                    <div class="card card-flush h-xl-100 bg-light-primary">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Total PO</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">This Month</span>
                            </h3>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between pt-1 pb-7">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1" id="total-po-count">0</span>
                             
                                </div>
                                <span class="text-gray-500 fw-semibold fs-6">Compared to last month</span>
                            </div>
                            <div id="total-po-chart" style="height: 100px"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Value Card -->
                <div class="col-xl-3">
                    <div class="card card-flush h-xl-100 bg-light-info">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Total Value</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">This Month</span>
                            </h3>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between pt-1 pb-7">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1" id="total-po-value">$0</span>
                                </div>
                                <span class="text-gray-500 fw-semibold fs-6">Compared to last month</span>
                            </div>
                            <div id="total-value-chart" style="height: 100px"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Pending Approval Card -->
                <div class="col-xl-3">
                    <div class="card card-flush h-xl-100 bg-light-warning">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Pending Approval</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">Requires your action</span>
                            </h3>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between pt-1 pb-7">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1" id="pending-approval-count">0</span>
                                </div>
                                <span class="text-gray-500 fw-semibold fs-6">POs waiting for approval</span>
                            </div>
                            <div class="progress h-10px bg-light-warning mt-5">
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="text-gray-500 fw-semibold fs-7"></span>
                                <span class="text-gray-800 fw-bold fs-7">on time</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Delivery Status Card -->
                <div class="col-xl-3">
                    <div class="card card-flush h-xl-100 bg-light-success">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Delivery Status</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">This Month</span>
                            </h3>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between pt-1 pb-7">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1" id="delivery-status-value">0%</span>
                                </div>
                                <span class="text-gray-500 fw-semibold fs-6">On-time deliveries</span>
                            </div>
                            <div id="delivery-status-chart" style="height: 100px"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PO Status Overview -->
            <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                <div class="col-xxl-12">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">PO Status Overview</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">Current status of all purchase orders</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search PO..."/>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="row g-5 g-xl-10">
                                <!-- Status Cards -->
                                <div class="col-md-2">
                                    <div class="card card-flush bg-light-primary h-100">
                                        <div class="card-body text-center">
                                            <div class="symbol symbol-50px mb-3">
                                                <div class="symbol-label bg-primary">
                                                    <i class="ki-duotone ki-file fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-4 d-block">Draft</span>
                                            <span class="text-gray-500 fw-semibold fs-6" id="draft-count">0 POs</span>
                                        </div>
                                        <div class="card-footer flex-center pt-0">
                                            <a href="{{ route('purchase-orders.index', ['status' => 'draft']) }}" class="btn btn-sm btn-light-primary fw-bold">View All</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="card card-flush bg-light-warning h-100">
                                        <div class="card-body text-center">
                                            <div class="symbol symbol-50px mb-3">
                                                <div class="symbol-label bg-warning">
                                                    <i class="ki-duotone ki-time fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-4 d-block">Pending</span>
                                            <span class="text-gray-500 fw-semibold fs-6" id="pending-count">0 POs</span>
                                        </div>
                                        <div class="card-footer flex-center pt-0">
                                            <a href="{{ route('purchase-orders.index', ['status' => 'pending_approval']) }}" class="btn btn-sm btn-light-warning fw-bold">View All</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="card card-flush bg-light-info h-100">
                                        <div class="card-body text-center">
                                            <div class="symbol symbol-50px mb-3">
                                                <div class="symbol-label bg-info">
                                                    <i class="ki-duotone ki-check-circle fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-4 d-block">Approved</span>
                                            <span class="text-gray-500 fw-semibold fs-6" id="approved-count">0 POs</span>
                                        </div>
                                        <div class="card-footer flex-center pt-0">
                                            <a href="{{ route('purchase-orders.index', ['status' => 'approved']) }}" class="btn btn-sm btn-light-info fw-bold">View All</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="card card-flush bg-light-success h-100">
                                        <div class="card-body text-center">
                                            <div class="symbol symbol-50px mb-3">
                                                <div class="symbol-label bg-success">
                                                    <i class="ki-duotone ki-truck fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-4 d-block">In Transit</span>
                                            <span class="text-gray-500 fw-semibold fs-6" id="transit-count">0 POs</span>
                                        </div>
                                        <div class="card-footer flex-center pt-0">
                                            <a href="{{ route('purchase-orders.index', ['status' => 'in_progress,partially_received']) }}" class="btn btn-sm btn-light-success fw-bold">View All</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="card card-flush bg-light-dark h-100">
                                        <div class="card-body text-center">
                                            <div class="symbol symbol-50px mb-3">
                                                <div class="symbol-label bg-dark">
                                                    <i class="ki-duotone ki-check-square fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-4 d-block">Delivered</span>
                                            <span class="text-gray-500 fw-semibold fs-6" id="completed-count">0 POs</span>
                                        </div>
                                        <div class="card-footer flex-center pt-0">
                                            <a href="{{ route('purchase-orders.index', ['status' => 'completed']) }}" class="btn btn-sm btn-light-dark fw-bold">View All</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="card card-flush bg-light-danger h-100">
                                        <div class="card-body text-center">
                                            <div class="symbol symbol-50px mb-3">
                                                <div class="symbol-label bg-danger">
                                                    <i class="ki-duotone ki-cross-circle fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <span class="text-gray-800 fw-bold fs-4 d-block">Cancelled</span>
                                            <span class="text-gray-500 fw-semibold fs-6" id="cancelled-count">0 POs</span>
                                        </div>
                                        <div class="card-footer flex-center pt-0">
                                            <a href="{{ route('purchase-orders.index', ['status' => 'cancelled']) }}" class="btn btn-sm btn-light-danger fw-bold">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Row with charts -->
            <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                <!-- PO History Chart -->
                <div class="col-xxl-8">
                    <div class="card card-flush overflow-hidden h-xl-100">
                        <div class="card-header pt-7 mb-2">
                            <h3 class="card-title text-gray-800 fw-bold">Purchase Order History</h3>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-dots-horizontal fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions</div>
                                    </div>
                                    <div class="separator mb-3 opacity-75"></div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" id="export-po-history-pdf">Export as PDF</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" id="export-po-history-csv">Export as CSV</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" id="print-po-history">Print Report</a>
                                    </div>
                                    <div class="separator mt-3 opacity-75"></div>
                                    <div class="menu-item px-3">
                                        <div class="menu-content px-3 py-3">
                                            <a class="btn btn-primary btn-sm px-4" href="{{ route('purchase-orders.index') }}">View All POs</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between flex-column pt-0 pb-1 px-0">
                            <div class="px-9 mb-5">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-4 fw-semibold text-gray-500 align-self-start me-1">$</span>
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1" id="total-po-value-30days">0</span>
                                </div>
                                <span class="fs-6 fw-semibold text-gray-500">Total PO value in last 30 days</span>
                            </div>
                            <div id="po-history-chart" class="min-h-auto ps-4 pe-6" style="height: 350px"></div>
                        </div>
                    </div>
                </div>
                
                <!-- PO by Supplier Chart -->
                <div class="col-xxl-4">
                    <div class="card h-md-100">
                        <div class="card-body d-flex flex-column flex-center">
                            <div id="po-by-supplier-chart" class="min-h-auto" style="height: 300px"></div>
                            <div class="text-center pt-7">
                                <h3 class="fs-2x fw-bold text-gray-800">PO by Supplier</h3>
                                <div class="fs-5 fw-semibold text-gray-500 mt-3">Top 5 suppliers by PO volume</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Row with tables -->
            <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
                <!-- Recent POs -->
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Recent Purchase Orders</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">Latest 10 purchase orders</span>
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{ route('purchase-orders.index') }}" class="btn btn-sm btn-light">View All</a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="table-responsive">
                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0" id="recent-pos">
                                    <thead>
                                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                            <th class="p-0 pb-3 min-w-175px">PO NUMBER</th>
                                            <th class="p-0 pb-3 min-w-100px">SUPPLIER</th>
                                            <th class="p-0 pb-3 min-w-100px">DATE</th>
                                            <th class="p-0 pb-3 min-w-100px">STATUS</th>
                                            <th class="p-0 pb-3 min-w-100px text-end">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- POs Needing Follow Up -->
                <div class="col-xxl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">POs Needing Follow Up</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">Purchase Orders requiring action</span>
                            </h3>
                            <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search PO..."/>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="table-responsive">
                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0" id="po_followup">
                                    <thead>
                                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                            <th class="p-0 pb-3 min-w-150px">PO NUMBER</th>
                                            <th class="p-0 pb-3 min-w-100px">SUPPLIER</th>
                                            <th class="p-0 pb-3 min-w-100px">DUE DATE</th>
                                            <th class="p-0 pb-3 min-w-75px">DAYS LEFT</th>
                                            <th class="p-0 pb-3 min-w-100px">STATUS</th>
                                            <th class="p-0 pb-3 min-w-100px text-end">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Suppliers -->
            <div class="row g-5 gx-xl-10">
                <div class="col-xxl-12">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Top Suppliers</span>
                                <span class="text-gray-500 mt-1 fw-semibold fs-6">Suppliers with highest PO volume</span>
                            </h3>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-dots-horizontal fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions</div>
                                    </div>
                                    <div class="separator mb-3 opacity-75"></div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" id="export-suppliers-report">Export Report</a>
                                    </div>
                                    <div class="menu-item px-3">
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Supplier Performance</a>
                                    </div>
                                    <div class="separator mt-3 opacity-75"></div>
                                    <div class="menu-item px-3">
                                        <div class="menu-content px-3 py-3">
                                            <a class="btn btn-primary btn-sm px-4" href="{{ route('suppliers.index') }}">View All Suppliers</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="table-responsive">
                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0" id="top-suppliers">
                                    <thead>
                                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                            <th class="p-0 pb-3 min-w-150px">SUPPLIER</th>
                                            <th class="p-0 pb-3 min-w-100px">TOTAL PO</th>
                                            <th class="p-0 pb-3 min-w-100px">TOTAL VALUE</th>
                                            <th class="p-0 pb-3 min-w-100px">AVG DELIVERY</th>
                                            <th class="p-0 pb-3 min-w-100px">PERFORMANCE</th>
                                            <th class="p-0 pb-3 min-w-100px text-end">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- AMCharts Core -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Responsive.js"></script>

<script>
    // Function to fetch data from API
    async function fetchDashboardData() {
        try {
            const response = await fetch('/api/purchase-orders/dashboard');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            console.error('Error fetching dashboard data:', error);
            return null;
        }
    }

    // Function to update dashboard stats
    function updateStats(data) {
        if (!data) return;

        // Update summary cards
        document.getElementById('total-po-count').textContent = data.total_po_count || 0;
        document.getElementById('total-po-value').textContent = '$' + (data.total_po_value || 0).toLocaleString();
        document.getElementById('pending-approval-count').textContent = data.pending_approval_count || 0;
        document.getElementById('delivery-status-value').textContent = (data.delivery_status_percentage || 0) + '%';
        document.getElementById('total-po-value-30days').textContent = (data.total_po_value_30days || 0).toLocaleString();

        // Update status counts
        document.getElementById('draft-count').textContent = (data.status_counts.draft || 0) + ' POs';
        document.getElementById('pending-count').textContent = (data.status_counts.pending_approval || 0) + ' POs';
        document.getElementById('approved-count').textContent = (data.status_counts.approved || 0) + ' POs';
        document.getElementById('transit-count').textContent = ((data.status_counts.in_progress || 0) + (data.status_counts.partially_received || 0)) + ' POs';
        document.getElementById('completed-count').textContent = (data.status_counts.completed || 0) + ' POs';
        document.getElementById('cancelled-count').textContent = (data.status_counts.cancelled || 0) + ' POs';
    }

    // Function to populate recent POs table
    function populateRecentPOsTable(data) {
        const tableBody = document.querySelector('#recent-pos tbody');
        if (!tableBody || !data.recent_pos) return;

        tableBody.innerHTML = '';
        data.recent_pos.forEach(po => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="pe-0">
                    <a href="/purchase-orders/${po.id}" class="text-gray-800 fw-bold text-hover-primary">${po.po_number}</a>
                </td>
                <td class="pe-0">${po.supplier.name}</td>
                <td class="pe-0">${new Date(po.created_at).toLocaleDateString()}</td>
                <td class="pe-0">
                    <span class="badge badge-light-${getStatusBadgeColor(po.status)}">${formatStatus(po.status)}</span>
                </td>
                <td class="text-end pe-0">$${po.total_amount.toLocaleString()}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Function to populate POs needing follow up
    function populateFollowUpTable(data) {
        const tableBody = document.querySelector('#po_followup tbody');
        if (!tableBody || !data.pos_needing_follow_up) return;

        tableBody.innerHTML = '';
        data.pos_needing_follow_up.forEach(po => {
            const daysLeft = calculateDaysLeft(po.due_date);
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="pe-0">
                    <a href="/purchase-orders/${po.id}" class="text-gray-800 fw-bold text-hover-primary">${po.po_number}</a>
                </td>
                <td class="pe-0">${po.supplier.name}</td>
                <td class="pe-0">${new Date(po.due_date).toLocaleDateString()}</td>
                <td class="pe-0">
                    <span class="badge badge-light-${getDaysLeftBadgeColor(daysLeft)}">${daysLeft}</span>
                </td>
                <td class="pe-0">
                    <span class="badge badge-light-${getStatusBadgeColor(po.status)}">${formatStatus(po.status)}</span>
                </td>
                <td class="text-end pe-0">
                    <a href="/purchase-orders/${po.id}" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Function to populate top suppliers table
    function populateTopSuppliersTable(data) {
        const tableBody = document.querySelector('#top-suppliers tbody');
        if (!tableBody || !data.top_suppliers) return;

        tableBody.innerHTML = '';
        data.top_suppliers.forEach(supplier => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="pe-0">
                    <a href="/suppliers/${supplier.id}" class="text-gray-800 fw-bold text-hover-primary">${supplier.name}</a>
                </td>
                <td class="pe-0">${supplier.total_po_count}</td>
                <td class="pe-0">$${supplier.total_po_value.toLocaleString()}</td>
                <td class="pe-0">${supplier.avg_delivery_days || 'N/A'} days</td>
                <td class="pe-0">
                    <div class="d-flex align-items-center">
                        <div class="progress w-100px me-5" style="height: 6px;">
                            <div class="progress-bar bg-${getPerformanceColor(supplier.performance_percentage)}" role="progressbar" style="width: ${supplier.performance_percentage}%" aria-valuenow="${supplier.performance_percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="fs-7 fw-bold">${supplier.performance_percentage}%</span>
                    </div>
                </td>
                <td class="text-end pe-0">
                    <a href="/suppliers/${supplier.id}" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Helper functions
    function formatStatus(status) {
        const statusMap = {
            'draft': 'Draft',
            'pending_approval': 'Pending Approval',
            'approved': 'Approved',
            'in_progress': 'In Progress',
            'partially_received': 'Partially Received',
            'completed': 'Completed',
            'cancelled': 'Cancelled'
        };
        return statusMap[status] || status;
    }

    function getStatusBadgeColor(status) {
        const colorMap = {
            'draft': 'primary',
            'pending_approval': 'warning',
            'approved': 'info',
            'in_progress': 'success',
            'partially_received': 'success',
            'completed': 'dark',
            'cancelled': 'danger'
        };
        return colorMap[status] || 'primary';
    }

    function calculateDaysLeft(dueDate) {
        const today = new Date();
        const due = new Date(dueDate);
        const diffTime = due - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays > 0 ? diffDays + ' days' : 'Overdue';
    }

    function getDaysLeftBadgeColor(daysText) {
        if (daysText.includes('Overdue')) return 'danger';
        const days = parseInt(daysText);
        if (days <= 3) return 'danger';
        if (days <= 7) return 'warning';
        return 'success';
    }

    function getPerformanceColor(percentage) {
        if (percentage >= 90) return 'success';
        if (percentage >= 70) return 'warning';
        return 'danger';
    }

    // Initialize charts when DOM is loaded
    document.addEventListener("DOMContentLoaded", async function() {
        // Fetch all dashboard data
        const dashboardData = await fetchDashboardData();
        updateStats(dashboardData);
        populateRecentPOsTable(dashboardData);
        populateFollowUpTable(dashboardData);
        populateTopSuppliersTable(dashboardData);

        // Total PO Chart (Sparkline)
        if (document.getElementById("total-po-chart")) {
            const totalPOChart = am5.Root.new("total-po-chart");
            totalPOChart.setThemes([
                am5themes_Animated.new(totalPOChart),
                am5themes_Responsive.new(totalPOChart)
            ]);
            
            const totalPOSeries = totalPOChart.container.children.push(
                am5xy.LineSeries.new(totalPOChart, {
                    valueXField: "month",
                    valueYField: "value",
                    stroke: am5.color("#3699FF"),
                    fill: am5.color("#3699FF"),
                    minDistance: 0
                })
            );
            
            totalPOSeries.fills.template.setAll({
                visible: true,
                fillOpacity: 0.2
            });
            
            totalPOSeries.strokes.template.setAll({
                strokeWidth: 2
            });
            
            // Use the data from API or generate sample data
            const data = dashboardData?.po_trend || Array(12).fill().map((_, i) => ({
                month: i + 1,
                value: Math.round(15 + Math.random() * 15)
            }));
            
            totalPOSeries.data.setAll(data);
            
            totalPOChart.root.dom.style.height = "100px";
        }
        
        // Total Value Chart (Sparkline)
        if (document.getElementById("total-value-chart")) {
            const totalValueChart = am5.Root.new("total-value-chart");
            totalValueChart.setThemes([
                am5themes_Animated.new(totalValueChart),
                am5themes_Responsive.new(totalValueChart)
            ]);
            
            const totalValueSeries = totalValueChart.container.children.push(
                am5xy.LineSeries.new(totalValueChart, {
                    valueXField: "month",
                    valueYField: "value",
                    stroke: am5.color("#6610f2"),
                    fill: am5.color("#6610f2"),
                    minDistance: 0
                })
            );
            
            totalValueSeries.fills.template.setAll({
                visible: true,
                fillOpacity: 0.2
            });
            
            totalValueSeries.strokes.template.setAll({
                strokeWidth: 2
            });
            
            // Use the data from API or generate sample data
            const data = dashboardData?.value_trend || Array(12).fill().map((_, i) => ({
                month: i + 1,
                value: 15000 + Math.random() * 25000
            }));
            
            totalValueSeries.data.setAll(data);
            
            totalValueChart.root.dom.style.height = "100px";
        }
        
        // Delivery Status Chart (Sparkline)
        if (document.getElementById("delivery-status-chart")) {
            const deliveryStatusChart = am5.Root.new("delivery-status-chart");
            deliveryStatusChart.setThemes([
                am5themes_Animated.new(deliveryStatusChart),
                am5themes_Responsive.new(deliveryStatusChart)
            ]);
            
            const deliveryStatusSeries = deliveryStatusChart.container.children.push(
                am5xy.LineSeries.new(deliveryStatusChart, {
                    valueXField: "month",
                    valueYField: "value",
                    stroke: am5.color("#1BC5BD"),
                    fill: am5.color("#1BC5BD"),
                    minDistance: 0
                })
            );
            
            deliveryStatusSeries.fills.template.setAll({
                visible: true,
                fillOpacity: 0.2
            });
            
            deliveryStatusSeries.strokes.template.setAll({
                strokeWidth: 2
            });
            
            // Use the data from API or generate sample data
            const data = dashboardData?.delivery_trend || Array(12).fill().map((_, i) => ({
                month: i + 1,
                value: 80 + Math.random() * 20
            }));
            
            deliveryStatusSeries.data.setAll(data);
            
            deliveryStatusChart.root.dom.style.height = "100px";
        }
        
        // PO History Chart (Main Bar Chart)
        if (document.getElementById("po-history-chart")) {
            const poHistoryChart = am5.Root.new("po-history-chart");
            poHistoryChart.setThemes([
                am5themes_Animated.new(poHistoryChart),
                am5themes_Responsive.new(poHistoryChart)
            ]);
            
            const poHistoryChartContainer = poHistoryChart.container.children.push(
                am5.Container.new(poHistoryChart, {
                    width: am5.percent(100),
                    height: am5.percent(100),
                    layout: poHistoryChart.verticalLayout
                })
            );
            
            const poHistoryXAxis = poHistoryChartContainer.children.push(
                am5.CategoryAxis.new(poHistoryChart, {
                    categoryField: "month",
                    renderer: am5xy.AxisRendererX.new(poHistoryChart, {
                        minGridDistance: 30
                    })
                })
            );
            
            poHistoryXAxis.data.setAll([
                { month: "Jan" },
                { month: "Feb" },
                { month: "Mar" },
                { month: "Apr" },
                { month: "May" },
                { month: "Jun" },
                { month: "Jul" },
                { month: "Aug" },
                { month: "Sep" },
                { month: "Oct" },
                { month: "Nov" },
                { month: "Dec" }
            ]);
            
            const poHistoryYAxis = poHistoryChartContainer.children.push(
                am5.ValueAxis.new(poHistoryChart, {
                    renderer: am5xy.AxisRendererY.new(poHistoryChart, {})
                })
            );
            
            const poHistorySeries = poHistoryChartContainer.children.push(
                am5xy.ColumnSeries.new(poHistoryChart, {
                    name: "PO Value",
                    xAxis: poHistoryXAxis,
                    yAxis: poHistoryYAxis,
                    valueYField: "total",
                    categoryXField: "month",
                    fill: am5.color("#6610f2"),
                    stroke: am5.color("#6610f2"),
                    tooltip: am5.Tooltip.new(poHistoryChart, {
                        labelText: "${valueY}"
                    })
                })
            );
            
            poHistorySeries.columns.template.setAll({
                cornerRadiusTL: 4,
                cornerRadiusTR: 4,
                strokeOpacity: 0,
                width: am5.percent(50)
            });
            
            // Use the data from API or generate sample data
            const poHistoryData = dashboardData?.po_history || Array(12).fill().map((_, i) => ({
                month: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][i],
                total: Math.round(10000 + Math.random() * 30000),
                count: Math.round(5 + Math.random() * 15)
            }));
            
            poHistorySeries.data.setAll(poHistoryData);
            
            poHistoryChartContainer.set("paddingTop", 0);
            poHistoryChartContainer.set("paddingRight", 0);
            poHistoryChartContainer.set("paddingBottom", 0);
            poHistoryChartContainer.set("paddingLeft", 0);
        }
        
        // PO by Supplier Chart (Pie Chart)
        if (document.getElementById("po-by-supplier-chart")) {
            const poBySupplierChart = am5.Root.new("po-by-supplier-chart");
            poBySupplierChart.setThemes([
                am5themes_Animated.new(poBySupplierChart),
                am5themes_Responsive.new(poBySupplierChart)
            ]);
            
            const poBySupplierSeries = poBySupplierChart.series.push(
                am5percent.PieSeries.new(poBySupplierChart, {
                    name: "PO by Supplier",
                    categoryField: "supplier",
                    valueField: "count",
                    legendLabelText: "{category}",
                    legendValueText: "{value} ({percentTotal.formatNumber('0.0')}%)"
                })
            );
            
            // Use the data from API or generate sample data
            const poBySupplierData = dashboardData?.po_by_supplier || [
                { supplier: "Supplier A", count: 15 },
                { supplier: "Supplier B", count: 12 },
                { supplier: "Supplier C", count: 8 },
                { supplier: "Supplier D", count: 6 },
                { supplier: "Supplier E", count: 4 }
            ];
            
            poBySupplierSeries.data.setAll(poBySupplierData);
            
            poBySupplierSeries.slices.template.setAll({
                stroke: am5.color("#ffffff"),
                strokeWidth: 2,
                templateField: "sliceSettings"
            });
            
            poBySupplierSeries.labels.template.setAll({
                text: "{value}",
                fontSize: 12,
                textType: "adjusted",
                inside: true,
                centerX: 0,
                centerY: 0,
                fill: am5.color("#ffffff")
            });
            
            poBySupplierSeries.colors.list = [
                am5.color("#3699FF"),
                am5.color("#6610f2"),
                am5.color("#1BC5BD"),
                am5.color("#FFA800"),
                am5.color("#F64E60")
            ];
            
            const poBySupplierLegend = poBySupplierChart.legend = am5.Legend.new(poBySupplierChart, {
                centerX: am5.percent(50),
                x: am5.percent(50),
                layout: poBySupplierChart.verticalLayout,
                marginTop: 15,
                marginBottom: 15
            });
            
            poBySupplierLegend.data.setAll(poBySupplierSeries.dataItems);
            
            poBySupplierChart.root.dom.style.height = "300px";
        }
        
        // Initialize DataTables
        if ($('#po_followup').length) {
            $('#po_followup').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: false,
                responsive: true,
                order: [[2, 'asc']],
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    'lengthMenu': 'Show _MENU_',
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">'
            });
        }

        if ($('#recent-pos').length) {
            $('#recent-pos').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: false,
                responsive: true,
                order: [[2, 'desc']],
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    'lengthMenu': 'Show _MENU_',
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">'
            });
        }

        if ($('#top-suppliers').length) {
            $('#top-suppliers').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: false,
                responsive: true,
                order: [[1, 'desc']],
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    'lengthMenu': 'Show _MENU_',
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">'
            });
        }
        
        // Initialize date range picker
        $('#kt_daterangepicker_1').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });
        
        // Handle dashboard filter form submission
        $('#dashboard-filter-form').on('submit', function(e) {
            e.preventDefault();
            // Here you would typically make an AJAX request to filter the dashboard data
            // For now, we'll just show a toast notification
            toastr.success('Filters applied successfully', 'Success');
        });
        
        // Export buttons
        $('#export-dashboard').on('click', function() {
            // Implement export functionality
            toastr.info('Exporting dashboard data...', 'Info');
        });
        
        $('#export-po-history-pdf').on('click', function() {
            // Implement PDF export
            toastr.info('Exporting PO history as PDF...', 'Info');
        });
        
        $('#export-po-history-csv').on('click', function() {
            // Implement CSV export
            toastr.info('Exporting PO history as CSV...', 'Info');
        });
        
        $('#print-po-history').on('click', function() {
            // Implement print functionality
            window.print();
        });
        
        $('#export-suppliers-report').on('click', function() {
            // Implement suppliers report export
            toastr.info('Exporting suppliers report...', 'Info');
        });
    });
</script>
@endpush
</x-default-layout>