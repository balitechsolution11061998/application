<x-default-layout>
    @section('title')
        Data Orang Tua
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orang-tua') }}
    @endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid form-control-sm w-250px ps-13" placeholder="Search orang tua" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-primary btn-sm" onclick="createOrangTua()">
                        <i class="ki-duotone ki-plus fs-2"></i>Add Orang Tua
                    </button>
                </div>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="orang_tua_table">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Pekerjaan</th>
                        <th>Hubungan</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orangTua as $ot)
                        <tr>
                            <td>{{ $ot->nik }}</td>
                            <td>{{ $ot->nama }}</td>
                            <td>{{ $ot->alamat }}</td>
                            <td>{{ $ot->email }}</td>
                            <td>{{ $ot->telepon }}</td>
                            <td>{{ $ot->pekerjaan }}</td>
                            <td>{{ $ot->hubungan }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $ot->id }}">Edit</button>
                                @if($ot->trashed())
                                    <button class="btn btn-success btn-sm restore-btn" data-id="{{ $ot->id }}">Restore</button>
                                @else
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $ot->id }}">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

        <!-- Modal Form for Creating/Editing Data -->
        <div class="modal fade" id="orangTuaModal" tabindex="-1" aria-labelledby="orangTuaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="orangTuaForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orangTuaModalLabel">Orang Tua</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="orangTuaId">
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon">
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                            </div>
                            <div class="mb-3">
                                <label for="hubungan" class="form-label">Hubungan</label>
                                <input type="text" class="form-control" id="hubungan" name="hubungan" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            // Create/Edit Modal
            $('.edit-btn').click(function () {
                let id = $(this).data('id');
                $.get(`/orang-tua/${id}`, function (data) {
                    $('#orangTuaId').val(data.id);
                    $('#nik').val(data.nik);
                    $('#nama').val(data.nama);
                    $('#alamat').val(data.alamat);
                    $('#email').val(data.email);
                    $('#telepon').val(data.telepon);
                    $('#pekerjaan').val(data.pekerjaan);
                    $('#hubungan').val(data.hubungan);
                    $('#orangTuaModal').modal('show');
                });
            });

            $('#orangTuaForm').submit(function (e) {
                e.preventDefault();
                let id = $('#orangTuaId').val();
                let url = id ? `/orang-tua/${id}` : '/orang-tua';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Error! Please check the console for details.');
                    }
                });
            });

            // Delete Functionality
            $('.delete-btn').click(function () {
                if (!confirm('Are you sure you want to delete this record?')) return;

                let id = $(this).data('id');
                $.ajax({
                    url: `/orang-tua/${id}`,
                    method: 'DELETE',
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Error! Please check the console for details.');
                    }
                });
            });

            // Restore Functionality
            $('.restore-btn').click(function () {
                let id = $(this).data('id');
                $.post(`/orang-tua/restore/${id}`, function (response) {
                    alert(response.message);
                    location.reload();
                }).fail(function (error) {
                    console.log(error);
                    alert('Error! Please check the console for details.');
                });
            });
        });

        function createOrangTua() {
            $('#orangTuaForm')[0].reset(); // Reset form before showing modal
            $('#orangTuaId').val('');
            $('#orangTuaModal').modal('show');
        }
    </script>
    @endpush
</x-default-layout>
