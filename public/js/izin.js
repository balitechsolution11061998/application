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
                    case 'Pending':
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
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, render: function() {
                return '<button class="btn btn-info btn-sm">View</button>';
            }}
        ]
    });

    // Apply filters
    $('#filter_btn').on('click', function() {
        table.draw();
    });
});
