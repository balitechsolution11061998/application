<x-default-layout>
    @section('title', 'Guru')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('guru') }}
    @endsection

    <div class="col-md-12">
        <div class="card card-white rounded-card">
            <div class="card-header text-left">
                <a href="{{ route('guru.mapel', Crypt::encrypt($guru->mapel_id)) }}" class="btn btn-black rounded-btn btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i> &nbsp; Back
                </a>
            </div>
            <div class="card-body text-left">
                <div class="row no-gutters ml-2 mb-2 mr-2">
                    <div class="col-md-4">
                        <img src="{{ asset($guru->foto) }}" class="card-img img-details rounded-img" alt="Guru Photo">
                    </div>
                    <div class="col-md-1 mb-4"></div>
                    <div class="col-md-7">
                        <h5 class="card-title card-text mb-2">Name: {{ $guru->nama_guru }}</h5>
                        <h5 class="card-title card-text mb-2">NIP: {{ $guru->nip }}</h5>
                        <h5 class="card-title card-text mb-2">ID Card: {{ $guru->id_card }}</h5>
                        <h5 class="card-title card-text mb-2">Subject: {{ $guru->mapel->nama_mapel }}</h5>
                        <h5 class="card-title card-text mb-2">Schedule Code: {{ $guru->kode }}</h5>
                        <h5 class="card-title card-text mb-2">Gender: {{ $guru->jk == 'L' ? 'Male' : 'Female' }}</h5>
                        <h5 class="card-title card-text mb-2">Birthplace: {{ $guru->tmp_lahir }}</h5>
                        <h5 class="card-title card-text mb-2">Date of Birth: {{ date('l, d F Y', strtotime($guru->tgl_lahir)) }}</h5>
                        <h5 class="card-title card-text mb-2">Phone: {{ $guru->telp }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
