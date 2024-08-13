<x-default-layout>
    @section('title')
        User
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('users') }}
    @endsection

    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
              <h3 class="card-title">
                  <a href="{{ route('users.cbt') }}" class="btn btn-dark btn-sm"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
              </h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
              <thead>
                  <tr>
                      <th>No.</th>
                      <th>Username</th>
                      <th>Email</th>
                      @foreach ($role as $d => $data)
                        @if ($d == 'Guru')
                          <th>No Id Card</th>
                        @elseif ($d == 'Siswa')
                          <th>No Induk Siswa</th>
                        @else

                        @endif
                      @endforeach
                      {{-- <th>Tanggal Register</th> --}}
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @if ($user->count() > 0)
                  @foreach ($user as $data)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td class="text-capitalize">{{ $data->username }}</td>
                      <td>{{ $data->email }}</td>
                      @if ($data->role == 'Siswa')
                        <td>{{ $data->no_induk }}</td>
                      @elseif ($data->role == 'Guru')
                        <td>{{ $data->id_card }}</td>
                      @else
                      @endif
                      {{-- <td>{{ $data->created_at->format('l, d F Y') }}</td> --}}
                      <td>
                        <form action="{{ route('users.cbt.destroy', $data->id) }}" method="post">
                          @csrf
                          @method('delete')
                          <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Silahkan Buat Akun Terlebih Dahulu!</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>


    @push('scripts')
        <script>



        </script>

    @endpush
</x-default-layout>
