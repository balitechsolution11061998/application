<x-default-layout>
    @section('title')
        Tanda Terima
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('tanda-terima') }}
    @endsection
    @push('styles')
        @foreach (getGlobalAssets('css') as $path)
            {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
        @endforeach
        @foreach (getVendors('css') as $path)
            {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
        @endforeach
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

    @endpush
        <!--begin::Card-->
        <div class="card row">
            <!--begin::Card header-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1 me-5">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-permissions-table-filter="search" class="form-control form-control-solid w-250px ps-13" id="frmSearchTandaTerima" placeholder="Search Tanda Terima" />
                </div>
                <!--end::Search-->
            </div>
            <!-- @php $tandaTerimaCreate = Auth::user()->can('tandaterima-create'); @endphp -->
            <!-- @if($tandaTerimaCreate) -->
            <div class="col-md-6">
                <a href="{{ route('tanda-terima.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tanda Terima
                </a>

            </div>
            <!-- @endif -->
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table id="tandaterimaTable" class="table table-striped table-hover rounded">
                    <thead>
                        <tr>
                            <th>...</th>
                            <th>Receipt No</th>
                            <th>Queue No</th>
                            <th>Supplier</th>
                            <th>Supplier Name</th>
                            <th>TOP</th>
                            <th>Date</th>
                            <th>Due Date</th>
                            <th>Total</th>
                            <th>Received By</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

                <!--end::Table-->
            </div>

            <!--end::Card body-->
        </div>
        <!--end::Card-->
    <!--end::Row-->
    @push('scripts')
    @foreach (getGlobalAssets() as $path)
        {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    @foreach (getVendors('js') as $path)
            {!! sprintf('<script src="%s"></script>', asset($path)) !!}
    @endforeach
    <script src="{{asset('js/jquery.fancybox.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.0.0/dist/jsQR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xml2js/0.4.23/xml2js.min.js"></script>
    <script src="{{asset('js/tandaterima.js')}}"></script>
    <script src="{{asset('js/formatRupiah.js')}}"></script>
    <script src="{{asset('js/formatDate.js')}}"></script>
    <script src="{{asset('js/formatDate.js')}}"></script>

    @endpush
</x-default-layout>
