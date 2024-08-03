$(document).ready(function() {

      // Fetch and populate cabang options
      $.ajax({
        url: '/kantor_cabang/getData',
        method: 'GET',
        success: function(data) {
            console.log(data);

            if (data.success) {
                var cabangOptions = '<option value="">Select Cabang</option>';
                $.each(data.data, function(index, cabang) {
                    cabangOptions += '<option value="' + cabang.id + '">' + cabang.name + '</option>';
                });
                $('#cabang_filter').html(cabangOptions);
            }
        }
    });

    // Fetch and populate department options
    $.ajax({
        url: '/departments/getDepartments',
        method: 'GET',
        success: function(data) {
            console.log(data);
            if (data.success) {
                var departmentOptions = '<option value="">Select Department</option>';
                $.each(data.data, function(index, department) {
                    departmentOptions += '<option value="' + department.id + '">' + department.name + '</option>';
                });
                $('#department_filter').html(departmentOptions);
            }
        }
    });
    var table = $('#presence_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/monitoring-presensi/data', // Adjust to your route
            data: function (d) {
                d.search = $('#search').val();
                d.cabang = $('#cabang_filter').val();
                d.department = $('#department_filter').val();
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nik', name: 'nik' },
            { data: 'user.name', name: 'user.name' },
            { data: 'user.cabang.name', name: 'user.cabang.name' }, // Adjust according to your relationship
            { data: 'user.department.name', name: 'user.department.name' }, // Adjust according to your relationship
            {
                data: 'tgl_presensi',
                name: 'tgl_presensi',
                render: function(data, type, row) {
                    var date = new Date(data);
                    var day = date.getDate();
                    var month = date.toLocaleString('id-ID', { month: 'long' });
                    var year = date.getFullYear();
                    return `${day} ${month} ${year}`;
                }
            },
            {
                data: 'jam_in',
                name: 'jam_in',
                render: function(data, type, row) {
                    var time = new Date('1970-01-01T' + data + 'Z');
                    var hours = String(time.getUTCHours()).padStart(2, '0');
                    var minutes = String(time.getUTCMinutes()).padStart(2, '0');
                    return `${hours}:${minutes}`;
                }
            },
            {
                data: 'foto_in',
                name: 'foto_in',
                render: function(data, type, row) {
                    return `<img src="{{ asset('storage/absensi/foto_in/') }}/${data}" alt="Foto In" style="width: 100px; height: auto;">`;
                }
            },
            {
                data: 'jam_out',
                name: 'jam_out',
                render: function(data, type, row) {
                    var time = new Date('1970-01-01T' + data + 'Z');
                    var hours = String(time.getUTCHours()).padStart(2, '0');
                    var minutes = String(time.getUTCMinutes()).padStart(2, '0');
                    return `${hours}:${minutes}`;
                }
            },
            {
                data: 'foto_out',
                name: 'foto_out',
                render: function(data, type, row) {
                    return `<img src="{{ asset('storage/absensi/foto_out/') }}/${data}" alt="Foto Out" style="width: 100px; height: auto;">`;
                }
            },
            { data: 'status', name: 'status' },
            { data: 'keterangan', name: 'keterangan' }
        ]
    });

    $('#filter_btn').on('click', function() {
        table.draw();
    });
});
