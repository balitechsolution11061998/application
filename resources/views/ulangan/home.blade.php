<!-- resources/views/siswa/index.blade.php -->
<x-default-layout>
    @section('title', 'Siswa')
    @section('breadcrumbs')
        {{ Breadcrumbs::render('siswa') }}
    @endsection

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title" style="color:black;">Nilai Ulangan</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama Kelas</th>
                      <th>Aksi</th>
                  </thead>
                  <tbody>
                    @foreach ($kelas as $data)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->name }}</td>
                        <td><a href="{{ route('ulangan.ulangan-siswa', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Ditails</a></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    @push('scripts')

    @endpush
</x-default-layout>
