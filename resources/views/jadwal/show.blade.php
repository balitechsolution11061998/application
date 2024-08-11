<x-default-layout>
    @section('title', 'Jadwal')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('jadwal') }}
    @endsection
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('jadwal.index') }}" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Hari</th>
                        <th>Jadwal</th>
                        <th>Jam Pelajaran</th>
                        <th>Ruang Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->hari->nama_hari }}</td>
                        <td>
                            <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
                            <p class="card-text"><small class="text-muted">{{ $data->guru->nama_guru }}</small></p>
                        </td>
                        <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
                        <td>{{ $data->ruang->nama_ruang }}</td>
                        <td>
                          <form action="{{ route('jadwal.destroy', $data->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <a href="{{ route('jadwal.edit',Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                            <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                          </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</x-default-layout>
