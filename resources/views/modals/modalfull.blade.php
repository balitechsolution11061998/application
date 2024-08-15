<div class="modal fade" id="mdlForm" aria-hidden="true" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-fullscreen"> <!-- Added modal-lg class here -->
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header d-flex justify-content-between align-items-center">
                <!--begin::Modal title-->
                <h2 class="fw-bold" id="mdlFormTitle">Isikan Title</h2>
                <!--end::Modal title-->
                <!--begin::Print button-->
                <!--end::Print button-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" style="background-color: white; color: black;" data-bs-dismiss="modal" aria-label="Close" id="dismissModal">
                    <i class="fas fa-times"></i> <!-- Replace 'fa-times' with the appropriate icon class -->
                </div>

                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y" id="mdlFormContent">
                <!--begin::Form-->

                <div id="modalSpinner" class="d-flex justify-content-center" style="display: none;">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
</div>
