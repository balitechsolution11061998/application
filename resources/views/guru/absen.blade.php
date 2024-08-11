<x-default-layout>
    @section('title', 'Guru')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('guru') }}
    @endsection
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
              <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Guru</th>
                        <th>Cek Absensi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guru as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_guru }}</td>
                            <td>
                                <a href="{{ route('guru.kehadiran', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Ditails</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</x-default-layout>
