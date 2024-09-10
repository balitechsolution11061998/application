// public/js/dataTablesHelper.js
function dataTableHelper(tableId, ajaxUrl, columnsConfig, orderColumn = 4, searchBoxId = '#search-box') {
    var table = $(tableId).DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        ajax: ajaxUrl,
        columns: columnsConfig,
        pageLength: 10, // Default rows per page
        lengthMenu: [10, 25, 50, 100, 500, 1000, 10000], // Pagination options
        searching: true, // Enable global search
        order: [[orderColumn, 'desc']], // Default sorting
        initComplete: function () {
            // Link search box with DataTable's search function
            if (searchBoxId) {
                var searchBox = $(searchBoxId);
                searchBox.on('keyup', function () {
                    table.search(this.value).draw();
                });
            }
        },
        columnDefs: [
            {
                targets: orderColumn, // Default to 'created_at' column for ordering
                render: function (data, type, row) {
                    return moment(data).format('MMM D, YYYY'); // Format date
                }
            },
            {
                targets: columnsConfig.length - 1, // Disable sorting for the 'Actions' column
                orderable: false,
            }
        ]
    });

    return table; // Return the DataTable instance for further manipulation if needed
}
