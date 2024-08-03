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
            { data: 'tgl_presensi', name: 'tgl_presensi' }, // Adjust according to your relationship
            { data: 'jam_in', name: 'jam_in' },
            { data: 'foto_in', name: 'foto_in' },
            { data: 'jam_out', name: 'jam_out' },
            { data: 'foto_out', name: 'foto_out' },
            { data: 'status', name: 'status' },
            { data: 'keterangan', name: 'keterangan' }
        ]
    });

    $('#filter_btn').on('click', function() {
        table.draw();
    });
});
