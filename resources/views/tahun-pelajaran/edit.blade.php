<x-default-layout>
    @section('title')
        Edit Tahun Pelajaran
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('tahun-pelajaran.edit', $tahunPelajaran) }}
    @endsection

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Tahun Pelajaran</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tahun-pelajaran.update', $tahunPelajaran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{ $tahunPelajaran->tahun_ajaran }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</x-default-layout>
