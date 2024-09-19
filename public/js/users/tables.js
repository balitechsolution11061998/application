dataTableHelper("#users_table", "/management/users/data", [
    {
        data: "id",
        name: "id",
        render: function (data) {
            return `
<input type="checkbox" class="user-checkbox" id="user-${data}" value="${data}">
<label for="user-${data}"></label>
`;
        },
        orderable: false,
        searchable: false,
    },
    {
        data: "profile_picture",
        name: "profile_picture",
        render: function (data) {
            if (data) {
                return `
<a href="/storage/${data}" data-lightbox="profile-picture-${data}">
    <img src="/storage/${data}" alt="Profile Picture" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
</a>
`;
            } else {
                return `
<a href="/path/to/default/profile.png" data-lightbox="default-profile">
    <img src="/path/to/default/profile.png" alt="Default Profile" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
</a>
`;
            }
        },
        orderable: false,
        searchable: false,
    },
    {
        data: "username",
        name: "username",
    },
    {
        data: "name",
        name: "name",
    },
    {
        data: "email",
        name: "email",
        render: function (data) {
            if (typeof data === 'string' && data.includes('@')) {
                return `<a href="mailto:${data}">${data}</a>`;
            } else {
                return '<span class="text-danger">Invalid Email</span>';
            }
        },
    },
    {
        data: "password_show",
        name: "password_show",
        render: function (data, type, row) {
            return `
<span class="password-mask" style="font-family: monospace;">****</span>
<i class="fas fa-eye toggle-password text-primary ms-2" style="cursor:pointer;" data-password="${data}" data-id="${row.id}"></i>
`;
        },
    },
    {
        data: "roles",
        name: "roles",
        render: function (data) {
            const roleIcons = {
                "administrator": "fa-user-shield",
                "superadministrator": "fa-user-crown",
                "manager": "fa-users-cog",
                "editor": "fa-edit",
                "viewer": "fa-eye",
            };

            return data
                .split(", ")
                .map((role) => `
<span class="badge rounded-pill bg-dark text-white me-2" style="font-size: 0.9em; display: inline-flex; align-items: center; padding: 0.4em 0.7em; white-space: nowrap;">
    <i class="fas ${roleIcons[role] || 'fa-user'} me-1"></i> ${role}
</span>
`)
                .join(" ");
        },
    },
    {
        data: "region",
        name: "region",
        render: function (data) {
            return data ? data : 'N/A';
        },
    },
    {
        data: "created_at",
        name: "created_at",
        render: function (data) {
            return new Date(data).toLocaleDateString("en-US", {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric",
            });
        },
    },
    {
        data: "actions",
        name: "actions",
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
            return `
<div class="btn-group" role="group">
    <button type="button" class="btn btn-sm btn-primary" onclick="editUser(${row.id})">
        <i class="fas fa-edit"></i> Edit
    </button>
    <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(${row.id})">
        <i class="fas fa-trash"></i> Delete
    </button>
    <button type="button" class="btn btn-sm btn-warning" onclick="changePassword(${row.id})">
        <i class="fas fa-key"></i> Change Password
    </button>
</div>
`;
        },
    },
]);
