$(document).ready(function() {
    // Initialize DataTable
    var table = $('#izin_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/izin/data', // Update this with your actual URL for fetching izin data
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
            { data: 'tanggal', name: 'tanggal' },
            { data: 'nik', name: 'nik' },
            { data: 'nama_karyawan', name: 'nama_karyawan' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'departemen', name: 'departemen' },
            { data: 'cabang', name: 'cabang' },
            { data: 'status', name: 'status' },
            { data: 'file', name: 'file', render: function(data, type, row) {
                return `<a href="${data}" target="_blank">View File</a>`;
            }},
            { data: 'keterangan', name: 'keterangan' },
            { data: 'status_approve', name: 'status_approve' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });

    // Apply filters
    $('#filter_btn').on('click', function() {
        table.draw();
    });
});
