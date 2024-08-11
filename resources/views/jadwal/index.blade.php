<x-default-layout>
    @section('title', 'Jadwal')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('jadwal') }}
    @endsection

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target=".tambah-jadwal">
                        <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Jadwal
                    </button>
                    <a href="{{ route('jadwal.export_excel') }}" class="btn btn-success btn-sm ms-2" target="_blank">
                        <i class="nav-icon fas fa-file-export"></i> &nbsp; EXPORT EXCEL
                    </a>
                    <button type="button" class="btn btn-warning btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#importExcel">
                        <i class="nav-icon fas fa-file-import"></i> &nbsp; IMPORT EXCEL
                    </button>
                    <button type="button" class="btn btn-danger btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#dropTable">
                        <i class="nav-icon fas fa-minus-circle"></i> &nbsp; Drop
                    </button>
                </h3>
            </div>

            <!-- Import Excel Modal -->
            <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('jadwal.import_excel') }}" enctype="multipart/form-data">
                        <div class="modal-content" style="background-color: white; color: black;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importExcelLabel" style="color:black; font-weight:bold;">Import Excel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="card card-outline card-primary" style="background-color: white; color: black;">
                                    <div class="card-header">
                                        <h5 class="card-title" style="color:black;">Petunjuk :</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>rows 1 = nama hari</li>
                                            <li>rows 2 = nama kelas</li>
                                            <li>rows 3 = nama mapel</li>
                                            <li>rows 4 = nama guru</li>
                                            <li>rows 5 = jam mulai</li>
                                            <li>rows 6 = jam selesai</li>
                                            <li>rows 7 = nama ruang</li>
                                        </ul>
                                    </div>
                                </div>
                                <label for="excelFile">Pilih file excel</label>
                                <div class="form-group">
                                    <input type="file" id="excelFile" name="file" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Drop Table Modal -->
            <div class="modal fade" id="dropTable" tabindex="-1" aria-labelledby="dropTableLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('jadwal.deleteAll') }}">
                        @csrf
                        @method('delete')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="dropTableLabel">Sure you drop all data?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Drop</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card Body with Table -->
            <div class="card-body">
                <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kelas</th>
                            <th>Lihat Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->name }}</td>
                            <td>
                                <a href="{{ route('jadwal.show', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm">
                                    <i class="nav-icon fas fa-search-plus"></i> &nbsp; Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Large Modal for Adding Jadwal -->
    <div class="modal fade bd-example-modal-lg tambah-jadwal" tabindex="-1" aria-labelledby="addJadwalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addJadwalLabel">Tambah Data Jadwal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('jadwal.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="hari_id">Hari</label>
                                    <select id="hari_id" name="hari_id" class="form-control @error('hari_id') is-invalid @enderror select2bs4">
                                        <option value="">-- Pilih Hari --</option>
                                        @foreach ($hari as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama_hari }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="kelas_id">Kelas</label>
                                    <select id="kelas_id" name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror select2bs4">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="guru_id">Kode Mapel</label>
                                    <select id="guru_id" name="guru_id" class="form-control @error('guru_id') is-invalid @enderror select2bs4">
                                        <option value="">-- Pilih Kode Mapel --</option>
                                        @foreach ($guru as $data)
                                            <option value="{{ $data->id }}">{{ $data->kode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jam_mulai">Jam Mulai</label>
                                    <input type="time" id="jam_mulai" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" placeholder="HH:MM">
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jam_selesai">Jam Selesai</label>
                                    <input type="time" id="jam_selesai" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" placeholder="HH:MM">
                                    @error('jam_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="ruang_id">Ruang Kelas</label>
                                    <select id="ruang_id" name="ruang_id" class="form-control @error('ruang_id') is-invalid @enderror select2bs4">
                                        <option value="">-- Pilih Ruang Kelas --</option>
                                        @foreach ($ruang as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama_ruang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-default-layout>
