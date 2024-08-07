$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var table = $('#ujian_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/ujian/data",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'paket_soal.nama_paket_soal', name: 'paket_soal.nama_paket_soal'},
                {data: 'rombel.nama_rombel', name: 'rombel.nama_rombel'},
                {data: 'nama', name: 'nama'},
                {data: 'waktu_mulai', name: 'waktu_mulai'},
                {data: 'durasi', name: 'durasi'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            drawCallback: function(settings) {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });

        $('#ujian_table').on('click', '.editUjian', function() {
            var id = $(this).data('id');
            $.get('/ujian/' + id + '/edit', function(data) {
                // Assuming the response contains the data for the Ujian
                createUjian(data);
            });
        });

        $('#ujian_table').on('click', '.deleteUjian', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/ujian/delete/' + id,
                        type: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The ujian has been deleted.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was a problem deleting the ujian.',
                                    'error'
                                );
                            }
                        },
                        error: function (response) {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the ujian.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    // Function to create or edit Ujian
    window.createUjian = function(data = null) {
        $('#mdlFormTitle').text(data ? 'Edit Ujian' : 'Create New Ujian');
        $('#mdlFormContent').html(getUjianForm(data));
        $('#mdlForm').modal('show');

        // Initialize form validation
        $('#ujianForm').validate({
            submitHandler: function(form) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to save the changes?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Saving...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            data: $(form).serialize(),
                            url: "/ujian/store",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $(form).trigger("reset");
                                $('#mdlForm').modal('hide');
                                $('#ujian_table').DataTable().draw();
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Your data has been saved.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            },
                            error: function (data) {
                                console.log('Error:', data);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'There was an error saving your data.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                if (data.responseJSON && data.responseJSON.errors) {
                                    $.each(data.responseJSON.errors, function(key, value) {
                                        var input = $('[name=' + key + ']');
                                        input.addClass('is-invalid');
                                        input.after('<div class="invalid-feedback">' + value + '</div>');
                                    });
                                }
                            }
                        });
                    }
                });
            },
            rules: {
                nama: {
                    required: true,
                    maxlength: 255
                },
                paket_soal_id: {
                    required: true
                },
                rombel_id: {
                    required: true
                },
                waktu_mulai: {
                    required: true,
                },
                durasi: {
                    required: true,
                    digits: true
                },
                poin_benar: {
                    required: true,
                    digits: true
                },
                poin_salah: {
                    required: true,
                    digits: true
                },
                poin_tidak_jawab: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                nama: {
                    required: "Please enter a name",
                    maxlength: "Name cannot be more than 255 characters"
                },
                paket_soal_id: {
                    required: "Please select a Paket Soal"
                },
                rombel_id: {
                    required: "Please select a Rombel"
                },
                waktu_mulai: {
                    required: "Please enter a start time",
                },
                durasi: {
                    required: "Please enter a duration",
                    digits: "Duration must be an integer"
                },
                poin_benar: {
                    required: "Please enter points for correct answers",
                    digits: "Points must be an integer"
                },
                poin_salah: {
                    required: "Please enter points for incorrect answers",
                    digits: "Points must be an integer"
                },
                poin_tidak_jawab: {
                    required: "Please enter points for unanswered questions",
                    digits: "Points must be an integer"
                }
            },
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            }
        });

        // Populate Paket Soal options dynamically
        $.get('/paket-soal/options', function(options) {
            var select = $('#paket_soal_id');
            select.empty(); // Clear existing options
            options.forEach(function(option) {
                select.append(new Option(option.nama_paket_soal, option.id));
            });
            if (data) {
                select.val(data.paket_soal_id);
            }
        });

        // Populate Rombel options dynamically
        $.get('/rombel/options', function(options) {
            var select = $('#rombel_id');
            select.empty(); // Clear existing options
            options.forEach(function(option) {
                select.append(new Option(option.nama_rombel, option.id));
            });
            if (data) {
                select.val(data.rombel_id);
            }
        });

        // Populate Mata Pelajaran options dynamically
        $.get('/mata-pelajaran/options', function(options) {
            var select = $('#mata_pelajaran_id');
            select.empty(); // Clear existing options
            options.forEach(function(option) {
                select.append(new Option(option.nama, option.id));
            });
            if (data) {
                select.val(data.mata_pelajaran_id); // Correct value for mata_pelajaran_id
            }
        });

        // Populate Kelas options dynamically
        $.get('/kelas/options', function(options) {
            var select = $('#kelas');
            select.empty(); // Clear existing options
            options.forEach(function(option) {
                select.append(new Option(option.name, option.id));
            });
            if (data) {
                select.val(data.kelas.id); // Correct value for kelas
            }
        });
    }

    // Function to get Ujian form HTML
    function getUjianForm(data) {
        return `
            <form id="ujianForm" name="ujianForm" class="form-horizontal">
                <input type="hidden" name="id" id="id" value="${data ? data.id : ''}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama" class="col-sm-12 control-label form-label">Nama Ujian</label>
                            <div class="col-sm-12">
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Enter Nama Ujian" value="${data ? data.nama : ''}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="paket_soal_id" class="col-sm-12 control-label form-label">Paket Soal</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="paket_soal_id" name="paket_soal_id" required>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="waktu_mulai" class="col-sm-12 control-label form-label">Waktu Mulai</label>
                            <div class="col-sm-12">
                                <input type="datetime-local" class="form-control" id="waktu_mulai" name="waktu_mulai" placeholder="Enter Waktu Mulai" value="${data ? data.waktu_mulai : ''}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mata_pelajaran_id" class="col-sm-12 control-label form-label">Mata Pelajaran</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="durasi" class="col-sm-12 control-label form-label">Durasi</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="durasi" name="durasi" placeholder="Enter Durasi" value="${data ? data.durasi : ''}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rombel_id" class="col-sm-12 control-label form-label">Rombel</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="rombel_id" name="rombel_id" required>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poin_benar" class="col-sm-12 control-label form-label">Poin Benar</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="poin_benar" name="poin_benar" placeholder="Enter Poin Benar" value="${data ? data.poin_benar : ''}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poin_salah" class="col-sm-12 control-label form-label">Poin Salah</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="poin_salah" name="poin_salah" placeholder="Enter Poin Salah" value="${data ? data.poin_salah : ''}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="poin_tidak_jawab" class="col-sm-12 control-label form-label">Poin Tidak Jawab</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="poin_tidak_jawab" name="poin_tidak_jawab" placeholder="Enter Poin Tidak Jawab" value="${data ? data.poin_tidak_jawab : ''}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelas" class="col-sm-12 control-label form-label">Kelas</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="kelas" name="kelas" required>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </div>

            </form>
        `;
    }

});
