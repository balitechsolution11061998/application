$(document).ready(function() {
    dataTableHelper("#usersTable", "/users/data", [
        { data: "id", name: "id" },
        { data: "name", name: "name" },
        { data: "email", name: "email" },
        {
            data: "created_at",
            name: "created_at",
            render: function(data) {
                return data ? new Date(data).toLocaleDateString() : '<i class="fas fa-spinner"></i> No data available';
            }
        },
        {
            data: "actions",
            name: "actions",
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                return `
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-primary" onclick="editUser(${row.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(${row.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                `;
            }
        }
    ]);
});
