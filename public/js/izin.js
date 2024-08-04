$(document).ready(function() {
    // Initialize DataTable
    var table = $('#izin_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/izin/data',
            data: function(d) {
                d.search = $('#search').val();
                d.cabang = $('#cabang_filter').val();
                d.department = $('#department_filter').val();
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'kode_izin', name: 'kode_izin' },
            { data: 'tgl_izin_dari', name: 'tgl_izin_dari' },
            { data: 'tgl_izin_sampai', name: 'tgl_izin_sampai' },
            { data: 'nik', name: 'nik' },
            { data: 'nama_karyawan', name: 'nama_karyawan' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'departemen', name: 'departemen' },
            { data: 'cabang', name: 'cabang' },
            { data: 'status', name: 'status' },
            {
                data: 'doc_sid',
                name: 'doc_sid',
                render: function(data) {
                    if (data) {
                        return `<a href="/storage/izin_files/${data}" class="fancybox" data-fancybox="gallery">View File</a>`;
                    }
                    return 'No File';
                }
            },
            { data: 'keterangan', name: 'keterangan' },
            {
                data: 'status_approved',
                name: 'status_approved',
                render: function(data) {
                    var badgeClass;
                    var iconClass;

                    switch (data) {
                        case 'Approved':
                            badgeClass = 'badge bg-success';
                            iconClass = 'fas fa-check';
                            break;
                        case 'Progress':
                            badgeClass = 'badge bg-warning';
                            iconClass = 'fas fa-hourglass-half';
                            break;
                        case 'Rejected':
                            badgeClass = 'badge bg-danger';
                            iconClass = 'fas fa-times';
                            break;
                        default:
                            badgeClass = 'badge bg-secondary';
                            iconClass = 'fas fa-question';
                            break;
                    }

                    return `<span class="${badgeClass}"><i class="${iconClass}"></i> ${data}</span>`;
                }
            },
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function(id) {
                    return `<button class="btn btn-info btn-sm view-details" data-id="${id}"><i class="fas fa-eye"></i></button>`;
                }
            }
        ],
        drawCallback: function() {
            Fancybox.bind('.fancybox', {
                groupAll: true, // Group all items
            });
        }
    });



    // Handle the click event for the view button
    $('#izin_table').on('click', '.view-details', function() {
        var id = $(this).data('id'); // Get the ID from the button's data attribute

        $.ajax({
            url: `/izin/${id}/show`,
            method: 'GET',
            success: function(data) {
                // Populate the modal with data
                $('#mdlFormTitle').text(`Detail for ${data.kode_izin}`); // Set the title dynamically

                let actionButtons = '';
                if (data.status_approved !== 'Rejected') {
                    actionButtons = `
                        <button type="button" class="btn btn-success btn-lg" id="approveBtn" data-id="${data.id}">Approve</button>
                        <button type="button" class="btn btn-danger btn-lg" id="rejectBtn" data-id="${data.id}">Reject</button>
                    `;
                }
                $('#mdlFormContent').html('');
                $('#mdlFormContent').html(`
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>Kode Izin:</strong></p>
                                <p class="text-muted">${data.kode_izin}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Tanggal Izin Dari:</strong></p>
                                <p class="text-muted">${data.tgl_izin_dari}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Tanggal Izin Sampai:</strong></p>
                                <p class="text-muted">${data.tgl_izin_sampai}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>NIK:</strong></p>
                                <p class="text-muted">${data.nik}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Nama Karyawan:</strong></p>
                                <p class="text-muted">${data.user.name}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Jabatan:</strong></p>
                                <p class="text-muted">${data.user.jabatan}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p><strong>Departemen:</strong></p>
                                <p class="text-muted">${data.user.department}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Cabang:</strong></p>
                                <p class="text-muted">${data.user.cabang}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Status:</strong></p>
                                <p class="text-muted">${data.status}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <p><strong>Keterangan:</strong></p>
                                <p class="text-muted">${data.keterangan}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Status Approved:</strong></p>
                                <p class="text-muted">${data.status_approved}</p>
                            </div>
                            <div class="col-md-6">
                                ${data.doc_sid ? `<p><a href="${data.doc_sid}" class="btn btn-primary" target="_blank">View File</a></p>` : ''}
                            </div>
                        </div>
                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            ${actionButtons}
                        </div>
                    </div>
                `);

                // Show the modal
                $('#mdlForm').modal('show');
            },

            error: function() {
                // Handle errors if needed
                alert('Failed to fetch data.');
            }
        });
    });

    // Apply filters
    $('#filter_btn').on('click', function() {
        table.draw();
    });
});

// Handle approve and reject actions
$(document).on('click', '#approveBtn', function() {
    const id = $(this).data('id'); // Get the ID from the button's data attribute

    $.ajax({
        url: `/izin/${id}/approve`,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            // Any additional data if needed
        },
        success: function(response) {
            $('#mdlForm').modal('hide');
            table.ajax.reload(); // Reload DataTable
        },
        error: function() {
            alert('Failed to approve');
        }
    });
});

$(document).on('click', '#rejectBtn', function() {
    const id = $(this).data('id'); // Get the ID from the button's data attribute

    $.ajax({
        url: `/izin/${id}/reject`,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            // Any additional data if needed
        },
        success: function(response) {
            $('#mdlForm').modal('hide');
            table.ajax.reload(); // Reload DataTable
        },
        error: function() {
            alert('Failed to reject');
        }
    });
});
