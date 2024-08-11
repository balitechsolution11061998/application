<x-default-layout>
    @section('title', 'Guru')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('guru') }}
    @endsection

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('guru.index') }}" class="btn btn-dark btn-sm rounded-pill mt-2"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
            </div>


            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Id Card</th>
                            <th>NIP</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guru as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_guru }}</td>
                            <td>{{ $data->id_card }}</td>
                            <td>{{ $data->nip }}</td>
                            <td>
                                <a href="{{ asset($data->foto) }}" data-toggle="lightbox" data-title="Foto {{ $data->nama_guru }}" data-gallery="gallery" data-footer='<a href="{{ route('guru.ubah-foto', Crypt::encrypt($data->id)) }}" id="linkFotoGuru" class="btn btn-link btn-block btn-light rounded-pill"><i class="nav-icon fas fa-file-upload"></i> &nbsp; Ubah Foto</a>'>
                                    <img src="{{ asset($data->foto) }}" width="130px" class="img-fluid mb-2 rounded">
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('guru.destroy', $data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <a href="{{ route('guru.show', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm rounded-pill mt-2"><i class="nav-icon fas fa-id-card"></i> &nbsp; Detail</a>
                                    <a href="{{ route('guru.edit', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm rounded-pill mt-2"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                    <button class="btn btn-danger btn-sm rounded-pill mt-2"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
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
