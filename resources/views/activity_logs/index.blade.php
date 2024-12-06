<x-default-layout>
    @section('title')
        Purchase Orders Management
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection

    @push('styles')
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

        <style>
            .filter-container {
                margin-bottom: 20px;
            }
        </style>
    @endpush

    @if (session('message'))
        <div class="alert alert-danger">
            <strong>{{ session('message') }}</strong>
            @if (session('error'))
                <p>{{ session('error') }}</p>
            @endif
        </div>
    @endif

    <!-- Activity Logs Section -->
    <div class="card rounded activity-log-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Activity Logs</h5>
        </div>
        <div class="card-body">
            <div class="filter-container">
                <input type="text" id="searchInput" class="form-control" placeholder="Search..." />
            </div>
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="activityLogTable">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th><i class="fas fa-file-alt"></i> Log Name</th>
                        <th><i class="fas fa-info-circle"></i> Description</th>
                        <th><i class="fas fa-tag"></i> Subject Type</th>
                        <th><i class="fas fa-bell"></i> Event</th>
                        <th><i class="fas fa-id-badge"></i> Subject ID</th>
                        <th><i class="fas fa-user"></i> Causer Type</th>
                        <th><i class="fas fa-user-tag"></i> Causer ID</th>
                        <th><i class="fas fa-cogs"></i> Properties</th>
                        <th><i class="fas fa-cube"></i> Batch UUID</th>
                        <th><i class="fas fa-calendar-alt"></i> Created At</th>
                        <th><i class="fas fa-calendar-check"></i> Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
$(document).ready(function() {
    // Initialize DataTable for activity logs with server-side processing
    var table = $('#activityLogTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '{{ route('activity-logs.data') }}', // Adjust this route as necessary
            type: 'GET',
            dataSrc: function(json) {
                console.log(json); // Log the entire data object to the console
                return json.data; // Return the data array for DataTables
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'log_name', name: 'log_name' },
            { data: 'description', name: 'description' },
            { data: 'subject_type', name: 'subject_type' },
            { data: 'event', name: 'event' },
            { data: 'subject.order_no', name: 'subject.order_no' }, // Accessing order_no from subject
            { data: 'causer_type', name: 'causer_type' },
            { data: 'causer.name', name: 'causer.name' }, // Accessing name from causer
            { data: 'properties', name: 'properties' },
            { data: 'batch_uuid', name: 'batch_uuid' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' }
        ],
        columnDefs: [
            {
                targets: 1, // Log Name
                render: function(data, type, row) {
                    return `<span class="badge badge-success"><i class="fas fa-check-circle"></i> ${data}</span>`;
                }
            },
            {
                targets: 4, // Event
                render: function(data, type, row) {
                    return data ?
                        `<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> ${data}</span>` :
                        'N/A';
                }
            },
            {
                targets: 8, // Properties
                render: function(data, type, row) {
                    return `<pre>${JSON.stringify(data, null, 2)}</pre>`;
                }
            },
            {
                targets: 10, // Created At
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                targets: 11, // Updated At
                render: function(data, type, row) {
                    return formatDate(data);
                }
            }
        ]
    });

    // Function to format date to "23 Desember 2023"
    function formatDate(dateString) {
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            locale: 'id-ID'
        };
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', options);
    }

    // Search functionality
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });
});


        </script>
    @endpush
</x-default-layout>
