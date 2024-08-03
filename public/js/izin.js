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
            { data: 'doc_sid', name: 'doc_sid', render: function(data) {
                return data ? `<a href="${data}" target="_blank">View File</a>` : 'No File';
            }},
            { data: 'keterangan', name: 'keterangan' },
            { data: 'status_approved', name: 'status_approved', render: function(data) {
                var badgeClass;
                switch (data) {
                    case 'Approved':
                        badgeClass = 'badge bg-success';
                        break;
                    case 'Progress':
                        badgeClass = 'badge bg-warning';
                        break;
                    case 'Rejected':
                        badgeClass = 'badge bg-danger';
                        break;
                    default:
                        badgeClass = 'badge bg-secondary';
                        break;
                }
                return `<span class="${badgeClass}">${data}</span>`;
            }},
            { data: 'id', name: 'id', orderable: false, searchable: false, render: function(id) {
                return `<button class="btn btn-info btn-sm view-details" data-id="${id}"><i class="fas fa-eye"></i></button>`;
            }}
        ]
    });

    // Handle the click event for the view button
 // Add this JavaScript to handle the 'View' button click and modal population
$('#izin_table').on('click', '.view-details', function() {
    var id = $(this).data('id'); // Get the ID from the button's data attribute

    $.ajax({
        url: `/izin/${id}/show`,
        method: 'GET',
        success: function(data) {
            // Populate the modal with data
            $('#mdlFormTitle').text(`Detail for ${data.kode_izin}`); // Set the title dynamically

            $('#mdlFormContent').html(`
                <p><strong>Kode Izin:</strong> ${data.kode_izin}</p>
                <p><strong>Tanggal Izin Dari:</strong> ${data.tgl_izin_dari}</p>
                <p><strong>Tanggal Izin Sampai:</strong> ${data.tgl_izin_sampai}</p>
                <p><strong>NIK:</strong> ${data.nik}</p>
                <p><strong>Nama Karyawan:</strong> ${data.nama_karyawan}</p>
                <p><strong>Jabatan:</strong> ${data.jabatan}</p>
                <p><strong>Departemen:</strong> ${data.departemen}</p>
                <p><strong>Cabang:</strong> ${data.cabang}</p>
                <p><strong>Status:</strong> ${data.status}</p>
                <p><strong>Keterangan:</strong> ${data.keterangan}</p>
                <p><strong>Status Approved:</strong> ${data.status_approved}</p>
                ${data.doc_sid ? `<p><a href="${data.doc_sid}" target="_blank">View File</a></p>` : ''}
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
