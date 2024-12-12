@extends('layouts.master')
@section('content')
<div class="d-flex flex-row-fluid">
    <!--begin::Container-->
    <div class="d-flex flex-column flex-row-fluid align-items-center">
        <!--begin::Menu-->
        <div class="d-flex flex-column flex-column-fluid mb-5 mb-lg-10">
            <!--begin::Brand-->
            <div class="d-flex flex-center pt-10 pt-lg-0 mb-10 mb-lg-0 h-lg-225px">
                <!--begin::Sidebar toggle-->
                <div class="btn btn-icon btn-active-color-primary w-30px h-30px d-lg-none me-4 ms-n15" id="kt_sidebar_toggle">
                    <i class="ki-duotone ki-abstract-14 fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Sidebar toggle-->
                <!--begin::Logo-->
                <a href="/">
                    <img alt="Logo" src="{{ asset('img/logo/m-mart.svg') }}" class="h-150px rounded" />
                </a>
                <!--end::Logo-->
            </div>
            <!--end::Brand-->
            <!--begin::Row-->
            <div class="row g-7 w-xxl-850px">
                <!--begin::Col-->
                <div class="col-md-7">
                    <!--begin::Card-->
                    <div class="card" style="background-color: #A838FF; border-radius: 20px;">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column flex-center pb-0 pt-15">
                            <div class="px-10 mb-10">
                                <h3 class="text-white mb-2 fw-bolder text-center text-uppercase mb-4" style="font-family: 'Montserrat', sans-serif; font-size: 24px;">Portal Supplier Management System</h3>
                                <div class="text-white text-center mb-4" style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 1.5;">
                                    <img class="mw-200 h-100px mx-auto mb-lg-n18" src="assets/media/illustrations/sigma-1/12.png" />
                                    <div>Welcome to Supplier Management System (PT. Retailindo Pratama)</div>
                                </div>
                                <div class="mb-7">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                        <span class="text-white opacity-75" style="font-family: 'Open Sans', sans-serif; font-size: 16px;">Pembuatan Purchase Order (PO)</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                        <span class="text-white opacity-75" style="font-family: 'Open Sans', sans-serif; font-size: 16px;">Pengelolaan Receive (RCV) Barang</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                        <span class="text-white opacity-75" style="font-family: 'Open Sans', sans-serif; font-size: 16px;">Pengelolaan Return (RTV) Barang</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                        <span class="text-white opacity-75" style="font-family: 'Open Sans', sans-serif; font-size: 16px;">Pengelolaan Tanda Terima Barang</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ki-duotone ki-black-right fs-4 text-white opacity-75 me-3"></i>
                                        <span class="text-white opacity-75" style="font-family: 'Open Sans', sans-serif; font-size: 16px;">Pengelolaan Profile Supplier</span>
                                    </div>
                                </div>
                                <a href="dashboard.html" class="btn btn-hover-rise text-white bg-white bg-opacity-10 text-uppercase fs-7 fw-bold" style="border-radius: 20px; font-family: 'Montserrat', sans-serif;">Go To Dashboard</a>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-5">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <!--begin::Card-->
                            <a href="/login/form" class="card border-0 shadow-none mb-7 d-flex flex-column flex-center" style="background-color: #F9666E; border-radius: 20px;">
                                <!--begin::Card body-->
                                <div class="card-body d-flex flex-column flex-center text-center" style="flex-grow: 1;">
                                    <img class="mw-100 h-100px mb-7 mx-auto" src="assets/media/illustrations/sigma-1/4.png" />
                                    <h4 class="text-white fw-bold text-uppercase" style="font-family: 'Montserrat', sans-serif;">Login</h4>
                                </div>
                                <!--end::Card body-->
                            </a>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6">
                            <!--begin::Card-->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_create_account" class="card border-0 shadow-none mb-7 d-flex flex-column flex-center" style="background-color: #35D29A; border-radius: 20px;">
                                <!--begin::Card body-->
                                <div class="card-body d-flex flex-column flex-center text-center" style="flex-grow: 1;">
                                    <img class="mw-100 h-100px mb-7 mx-auto" src="assets/media/illustrations/sigma-1/5.png" />
                                    <h4 class="text-white fw-bold text-uppercase" style="font-family: 'Montserrat', sans-serif;">Create Account</h4>
                                </div>
                                <!--end::Card body-->
                            </a>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Menu-->
    </div>
    <!--begin::Content-->
</div>
@endsection
