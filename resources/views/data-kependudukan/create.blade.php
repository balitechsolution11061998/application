<x-default-layout>
    @section('title', 'Form Data Kependudukan Management')
    @section('breadcrumbs')
        {{ Breadcrumbs::render('members') }}
    @endsection
    <div class="card shadow rounded-2xl">
        <div class="card-header rounded-top-2xl">
            <h5 class="card-title mb-0">Form Data Kependudukan</h5>
        </div>
        <div class="card-body">
            <form id="dataForm" class="needs-validation" novalidate>
                @csrf

                <div class="row">
                    <!-- Nama -->
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control form-control-sm"
                            value="{{ old('nama', $data->nama ?? '') }}" required>
                        <div class="invalid-feedback">Nama wajib diisi.</div>
                    </div>

                    <!-- NIK -->
                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" name="nik" id="nik" class="form-control form-control-sm"
                            value="{{ old('nik', $data->nik ?? '') }}" required>
                        <div class="invalid-feedback">NIK wajib diisi.</div>
                    </div>
                </div>

                <div class="row">
                    <!-- Jenis Kelamin -->
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select form-select-sm" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L"
                                {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                                Laki-Laki</option>
                            <option value="P"
                                {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        <div class="invalid-feedback">Pilih jenis kelamin.</div>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control form-control-sm"
                            value="{{ old('tempat_lahir', $data->tempat_lahir ?? '') }}" required>
                        <div class="invalid-feedback">Tempat lahir wajib diisi.</div>
                    </div>
                </div>

                <div class="row">
                    <!-- Tanggal Lahir -->
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            class="form-control form-control-sm"
                            value="{{ old('tanggal_lahir', $data->tanggal_lahir ?? '') }}" required>
                        <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                    </div>

                    <!-- Agama -->
                    <div class="col-md-6 mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <input type="text" name="agama" id="agama" class="form-control form-control-sm"
                            value="{{ old('agama', $data->agama ?? '') }}" required>
                        <div class="invalid-feedback">Agama wajib diisi.</div>
                    </div>
                </div>

                <div class="row">
                    <!-- No KK -->
                    <div class="col-md-6 mb-3">
                        <label for="no_kk" class="form-label">No KK</label>
                        <input type="text" name="no_kk" id="no_kk" class="form-control form-control-sm"
                            value="{{ old('no_kk', $data->no_kk ?? '') }}" required>
                        <div class="invalid-feedback">No KK wajib diisi.</div>
                    </div>

                    <!-- Pendidikan -->
                    <div class="col-md-6 mb-3">
                        <label for="pendidikan" class="form-label">Pendidikan</label>
                        <input type="text" name="pendidikan" id="pendidikan" class="form-control form-control-sm"
                            value="{{ old('pendidikan', $data->pendidikan ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <!-- Pekerjaan -->
                    <div class="col-md-6 mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control form-control-sm"
                            value="{{ old('pekerjaan', $data->pekerjaan ?? '') }}">
                    </div>

                    <!-- Golongan Darah -->
                    <div class="col-md-6 mb-3">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                        <input type="text" name="golongan_darah" id="golongan_darah"
                            class="form-control form-control-sm"
                            value="{{ old('golongan_darah', $data->golongan_darah ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <!-- Status Kawin -->
                    <div class="col-md-6 mb-3">
                        <label for="status_kawin" class="form-label">Status Kawin</label>
                        <select name="status_kawin" id="status_kawin" class="form-select form-select-sm" required>
                            <option value="">Pilih Status Kawin</option>
                            <option value="KAWIN"
                                {{ old('status_kawin', $data->status_kawin ?? '') == 'KAWIN' ? 'selected' : '' }}>KAWIN
                            </option>
                            <option value="BELUM KAWIN"
                                {{ old('status_kawin', $data->status_kawin ?? '') == 'BELUM KAWIN' ? 'selected' : '' }}>
                                BELUM KAWIN</option>
                            <option value="KAWIN TERCATAT"
                                {{ old('status_kawin', $data->status_kawin ?? '') == 'KAWIN TERCATAT' ? 'selected' : '' }}>
                                KAWIN TERCATAT</option>
                        </select>
                        <div class="invalid-feedback">Pilih status kawin.</div>
                    </div>

                    <!-- Nama Ibu -->
                    <div class="col-md-6 mb-3">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control-sm"
                            value="{{ old('nama_ibu', $data->nama_ibu ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <!-- Nama Bapak -->
                    <div class="col-md-6 mb-3">
                        <label for="nama_bapak" class="form-label">Nama Bapak</label>
                        <input type="text" name="nama_bapak" id="nama_bapak" class="form-control form-control-sm"
                            value="{{ old('nama_bapak', $data->nama_bapak ?? '') }}">
                    </div>

                    <!-- Alamat -->
                    <div class="col-md-12 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control form-control-sm">{{ old('alamat', $data->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <!-- KTP Elektronik -->
                    <div class="col-md-6 mb-3 form-check">
                        <input type="checkbox" name="ktp_elektronik" id="ktp_elektronik" class="form-check-input"
                            {{ old('ktp_elektronik', $data->ktp_elektronik ?? '') ? 'checked' : '' }}>
                        <label for="ktp_elektronik" class="form-check-label">KTP Elektronik</label>
                    </div>

                    <!-- Keterangan -->
                    <div class="col-md-12 mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control form-control-sm">{{ old('keterangan', $data->keterangan ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="button" id="submitButton" class="btn btn-sm btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>
        </div>
    </div>

    <!-- SweetAlert, Toastr, and Validation Scripts -->
    @push('scripts')
        <script>
            document.getElementById('submitButton').addEventListener('click', function() {
                if (document.getElementById('dataForm').checkValidity()) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data akan disimpan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, simpan!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let formData = new FormData(document.getElementById('dataForm'));
                            fetch("{{ route('data-kependudukan.store') }}", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log(data, 'data');
                                    if (data.success) {
                                        toastr.success(data.message, 'Berhasil');
                                        document.getElementById('dataForm').reset();
                                        // Redirect to /data-kependudukan
                                        window.location.href = '/data-kependudukan';
                                    } else {
                                        toastr.error(data.message, 'Gagal');
                                    }
                                })
                                .catch(error => {
                                    toastr.error('Terjadi kesalahan saat menyimpan data.', 'Error');
                                });
                        }
                    });
                } else {
                    document.getElementById('dataForm').classList.add('was-validated');
                }
            });
        </script>
    @endpush
</x-default-layout>
