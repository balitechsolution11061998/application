<x-default-layout>
    @section('title', 'Form Data Kependudukan Management')
    <div class="card shadow rounded-2xl">
        <div class="card-header rounded-top-2xl">
            <h5 class="card-title mb-0">Form Data Kependudukan</h5>
        </div>
        <div class="card-body">
            <form id="dataForm" class="needs-validation" novalidate>
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm" required>
                    <div class="invalid-feedback">Nama wajib diisi.</div>
                </div>

                <!-- NIK -->
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control form-control-sm" required>
                    <div class="invalid-feedback">NIK wajib diisi.</div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select form-select-sm" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <div class="invalid-feedback">Pilih jenis kelamin.</div>
                </div>

                <!-- Tempat Lahir -->
                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control form-control-sm" required>
                    <div class="invalid-feedback">Tempat lahir wajib diisi.</div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control form-control-sm" required>
                    <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                </div>

                <!-- Agama -->
                <div class="mb-3">
                    <label for="agama" class="form-label">Agama</label>
                    <input type="text" name="agama" id="agama" class="form-control form-control-sm" required>
                    <div class="invalid-feedback">Agama wajib diisi.</div>
                </div>

                <!-- No KK -->
                <div class="mb-3">
                    <label for="no_kk" class="form-label">No KK</label>
                    <input type="text" name="no_kk" id="no_kk" class="form-control form-control-sm" required>
                    <div class="invalid-feedback">No KK wajib diisi.</div>
                </div>

                <!-- Pendidikan -->
                <div class="mb-3">
                    <label for="pendidikan" class="form-label">Pendidikan</label>
                    <input type="text" name="pendidikan" id="pendidikan" class="form-control form-control-sm">
                </div>

                <!-- Pekerjaan -->
                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control form-control-sm">
                </div>

                <!-- Golongan Darah -->
                <div class="mb-3">
                    <label for="golongan_darah" class="form-label">Golongan Darah</label>
                    <input type="text" name="golongan_darah" id="golongan_darah" class="form-control form-control-sm">
                </div>

                <!-- Status Kawin -->
                <div class="mb-3">
                    <label for="status_kawin" class="form-label">Status Kawin</label>
                    <select name="status_kawin" id="status_kawin" class="form-select form-select-sm" required>
                        <option value="">Pilih Status Kawin</option>
                        <option value="KAWIN">KAWIN</option>
                        <option value="BELUM KAWIN">BELUM KAWIN</option>
                        <option value="KAWIN TERCATAT">KAWIN TERCATAT</option>
                    </select>
                    <div class="invalid-feedback">Pilih status kawin.</div>
                </div>

                <!-- Nama Ibu -->
                <div class="mb-3">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control-sm">
                </div>

                <!-- Nama Bapak -->
                <div class="mb-3">
                    <label for="nama_bapak" class="form-label">Nama Bapak</label>
                    <input type="text" name="nama_bapak" id="nama_bapak" class="form-control form-control-sm">
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control form-control-sm"></textarea>
                </div>

                <!-- KTP Elektronik -->
                <div class="mb-3 form-check">
                    <input type="checkbox" name="ktp_elektronik" id="ktp_elektronik" class="form-check-input">
                    <label for="ktp_elektronik" class="form-check-label">KTP Elektronik</label>
                </div>

                <!-- Keterangan -->
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control form-control-sm"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="button" id="submitButton" class="btn btn-sm btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
            </form>
        </div>
    </div>


</x-default-layout>

<!-- SweetAlert, Toastr, and Validation Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<script>
    document.getElementById('submitButton').addEventListener('click', function () {
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
                        if (data.success) {
                            toastr.success(data.message, 'Berhasil');
                            document.getElementById('dataForm').reset();
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
