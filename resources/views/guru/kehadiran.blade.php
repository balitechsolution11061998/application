<x-default-layout>
    @section('title', 'Guru')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('guru') }}
    @endsection

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('guru.index') }}" class="btn btn-dark btn-sm"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absen as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('l, d F Y', strtotime($data->tanggal)) }}</td>
                        <td>{{ $data->kehadiran->ket }}</td>
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
