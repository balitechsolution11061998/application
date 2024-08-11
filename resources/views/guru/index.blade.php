<x-default-layout>
    @section('title', 'Guru')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('guru') }}
    @endsection

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <!-- Add Data Button -->
                    <button type="button" class="btn btn-dark btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                        <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Add Data
                    </button>

                    <!-- Export Excel Button -->
                    <a href="{{ route('guru.export_excel') }}" class="btn btn-success btn-sm rounded-pill shadow-sm mx-2" target="_blank">
                        <i class="nav-icon fas fa-file-export"></i> &nbsp; EXPORT EXCEL
                    </a>

                    <!-- Import Excel Button -->
                    <button type="button" class="btn btn-primary btn-sm rounded-pill shadow-sm mx-2" data-bs-toggle="modal" data-bs-target="#importExcel">
                        <i class="nav-icon fas fa-file-import"></i> &nbsp; IMPORT EXCEL
                    </button>

                    <!-- Drop Table Button -->
                    <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#dropTable">
                        <i class="nav-icon fas fa-minus-circle"></i> &nbsp; Drop
                    </button>
                </h3>

            </div>

            <!-- Modal for Import Excel -->
            <div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('guru.import_excel') }}" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importExcelLabel">Import Excel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="modal-title">Petunjuk :</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Baris 1 = Nama Guru</li>
                                            <li>Baris 2 = NIP Guru</li>
                                            <li>Baris 3 = Jenis Kelamin</li>
                                            <li>Baris 4 = Mata Pelajaran</li>
                                        </ul>
                                    </div>
                                </div>
                                <label for="file">Pilih File Excel</label>
                                <div class="form-group">
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal for Drop Table -->
            <div class="modal fade" id="dropTable" tabindex="-1" aria-labelledby="dropTableLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('guru.deleteAll') }}">
                        @csrf
                        @method('delete')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="dropTableLabel">Yakin ingin menghapus semua data?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Card Body -->
            <div class="card-body">
                <table id="example1" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Mapel</th>
                            <th>Lihat Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapel as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>
                                    <a href="{{ route('guru.mapel', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-search-plus"></i> &nbsp; Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Guru Data -->
    <div class="modal fade bd-example-modal-lg" id="addGuruModal" tabindex="-1" aria-labelledby="addGuruModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addGuruModalLabel">Tambah Data Guru</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_guru">Nama Guru</label>
                                    <input type="text" id="nama_guru" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="tmp_lahir">Tempat Lahir</label>
                                    <input type="text" id="tmp_lahir" name="tmp_lahir" class="form-control @error('tmp_lahir') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="telp">Nomor Telpon/HP</label>
                                    <input type="text" id="telp" name="telp" onkeypress="return inputAngka(event)" class="form-control @error('telp') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" id="nip" name="nip" onkeypress="return inputAngka(event)" class="form-control @error('nip') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="mapel_id">Mapel</label>
                                    <select id="mapel_id" name="mapel_id" class="select2bs4 form-control @error('mapel_id') is-invalid @enderror">
                                        <option value="">-- Pilih Mapel --</option>
                                        @foreach ($mapel as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @php
                                    $kode = $max+1;
                                    if (strlen($kode) == 1) {
                                        $id_card = "0000".$kode;
                                    } else if(strlen($kode) == 2) {
                                        $id_card = "000".$kode;
                                    } else if(strlen($kode) == 3) {
                                        $id_card = "00".$kode;
                                    } else if(strlen($kode) == 4) {
                                        $id_card = "0".$kode;
                                    } else {
                                        $id_card = $kode;
                                    }
                                @endphp
                                <div class="form-group">
                                    <label for="id_card">Nomor ID Card</label>
                                    <input type="text" id="id_card" name="id_card" maxlength="5" onkeypress="return inputAngka(event)" value="{{ $id_card }}" class="form-control @error('id_card') is-invalid @enderror" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="kode">Kode Jadwal</label>
                                    <input type="text" id="kode" name="kode" maxlength="3" onkeyup="this.value = this.value.toUpperCase()" class="form-control @error('kode') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="foto">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="foto" class="custom-file-input @error('foto') is-invalid @enderror" id="foto">
                                            <label class="custom-file-label" for="foto">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
                          <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
