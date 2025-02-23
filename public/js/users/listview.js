function loadData(page) {
    $.ajax({
        url: '{{ route('management.users.data') }}',
        method: 'GET',
        data: {
            page: page,
            per_page: itemsPerPage
        },
        success: function(response) {
            if (response.data.length) {
                let listViewHtml = '';
                response.data.forEach(function(item) {
                    listViewHtml += `
        <div class="list-item" data-id="${item.id}">
            <div class="item-header" style="cursor: pointer;">
                <div class="item-title">Username:</div>
                <div class="item-content">${item.username}</div>
                <i class="fas fa-chevron-down toggle-collapse" style="float: right;"></i>
            </div>
            <div class="item-details" style="display: none;">
                <div class="item-title">Name:</div>
                <div class="item-content">${item.name}</div>
                <div class="item-title">Email:</div>
                <div class="item-content">${item.email}</div>
                <div class="item-title">Password:</div>
                <div class="item-content">****</div>
                <i class="fas fa-eye toggle-password text-primary ms-2" style="cursor:pointer;" data-password="${item.password_show}" data-id="${item.id}"></i>
                <div class="item-title">Created At:</div>
                <div class="item-content">${item.created_at}</div>
                <!-- Add actions if needed -->
            </div>
        </div>
        `;
                });
                $('.list-view').append(listViewHtml);
                if (response.hasMore) {
                    $('.list-view').append(
                        '<button id="load-more" class="btn btn-primary mt-3">Load More</button>'
                    );
                } else {
                    $('#load-more').remove();
                }
                loading = false;
            }
        }
    });
}
