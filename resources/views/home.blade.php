<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <div class="jam-kerja-container">
        <h2 class="section-title"><i class="fas fa-clock"></i> Jam Kerja</h2>
        <div class="jam-kerja-content" id="jam-kerja-content">
            <!-- Content will be populated by AJAX -->
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    @endpush
</x-default-layout>
