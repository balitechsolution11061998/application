<x-default-layout>

<div class="container">
    <h2>Menu Profile CV</h2>
    <button class="btn btn-primary" id="createMenu">Tambah Menu</button>
    <table class="table table-bordered" id="menuTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>URL</th>
                <th>Dropdown</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="menuModal">
    <div class="modal-dialog">
        <form id="menuForm">
            @csrf
            <input type="hidden" name="id" id="menu_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Menu</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nama Menu</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <label>URL</label>
                    <input type="text" name="url" id="url" class="form-control">
                    <label>Dropdown?</label>
                    <select name="is_dropdown" id="is_dropdown" class="form-control">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#menuTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('menu.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'url', name: 'url' },
            { data: 'is_dropdown', name: 'is_dropdown', render: function(data) {
                return data ? 'Ya' : 'Tidak';
            }},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $('#createMenu').click(function() {
        $('#menuForm')[0].reset();
        $('#menu_id').val('');
        $('#menuModal').modal('show');
    });

    $('#menuForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('menu.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                $('#menuModal').modal('hide');
                table.ajax.reload();
            }
        });
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        $.get("{{ route('menu.index') }}/" + id + "/edit", function(data) {
            $('#menu_id').val(data.id);
            $('#name').val(data.name);
            $('#url').val(data.url);
            $('#is_dropdown').val(data.is_dropdown);
            $('#menuModal').modal('show');
        });
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        if (confirm("Yakin ingin menghapus?")) {
            $.ajax({
                url: "{{ route('menu.index') }}/" + id,
                type: "DELETE",
                data: { "_token": "{{ csrf_token() }}" },
                success: function(response) {
                    table.ajax.reload();
                }
            });
        }
    });
});
</script>
@endpush
</x-default-layout>