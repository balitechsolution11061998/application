<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('home') }}
    @endsection

    <!-- Recent Activities Table -->
    <div class="container mt-5">
        <h3 class="text-center text-dark mb-4">Recent Activities</h3>
        <div class="table-responsive">
            <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead class="table-dark">
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>User</th>
                        <th>Action Type</th>
                        <th>Browser</th>
                        <th>Platform</th>
                        <th>Device</th>
                        <th>IP</th>
                        <th>Page</th>
                        <th>Created At</th>
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
                $('#kt_datatable_example_1').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('activities.data') }}",
                        type: 'GET'
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'user'
                        }, // Access the user's name
                        {
                            data: 'action_type'
                        },
                        {
                            data: 'browser_name',
                            render: function(data) {
                                let icon = '';
                                switch (data.toLowerCase()) {
                                    case 'chrome':
                                        icon = '<i class="fab fa-chrome"></i>';
                                        break;
                                    case 'firefox':
                                        icon = '<i class="fab fa-firefox"></i>';
                                        break;
                                    case 'safari':
                                        icon = '<i class="fab fa-safari"></i>';
                                        break;
                                    case 'edge':
                                        icon = '<i class="fab fa-edge"></i>';
                                        break;
                                    case 'opera':
                                        icon = '<i class="fab fa-opera"></i>';
                                        break;
                                    default:
                                        icon = '<i class="fas fa-globe"></i>'; // Default globe icon
                                }
                                return icon + ' ' + data; // Return icon and name
                            }
                        },
                        {
                            data: 'platform',
                            render: function(data) {
                                let icon = '';
                                switch (data.toLowerCase()) {
                                    case 'windows':
                                        icon = '<i class="fab fa-windows"></i>';
                                        break;
                                    case 'mac':
                                        icon = '<i class="fab fa-apple"></i>';
                                        break;
                                    case 'linux':
                                        icon = '<i class="fab fa-linux"></i>';
                                        break;
                                    case 'android':
                                        icon = '<i class="fab fa-android"></i>';
                                        break;
                                    case 'ios':
                                        icon =
                                        '<i class="fab fa-apple"></i>'; // iOS uses the Apple icon
                                        break;
                                    default:
                                        icon = '<i class="fas fa-desktop"></i>'; // Default desktop icon
                                }
                                return icon + ' ' + data; // Return icon and name
                            }
                        },
                        {
                            data: 'device',
                            render: function(data) {
                                let icon = '';
                                switch (data.toLowerCase()) {
                                    case 'windows':
                                        icon = '<i class="fab fa-windows"></i>';
                                        break;
                                    case 'mac':
                                        icon = '<i class="fab fa-apple"></i>';
                                        break;
                                    case 'linux':
                                        icon = '<i class="fab fa-linux"></i>';
                                        break;
                                    case 'android':
                                        icon = '<i class="fab fa-android"></i>';
                                        break;
                                    case 'ios':
                                        icon =
                                        '<i class="fab fa-apple"></i>'; // iOS uses the Apple icon
                                        break;
                                    default:
                                        icon = '<i class="fas fa-desktop"></i>'; // Default desktop icon
                                }
                                return icon + ' ' + data; // Return icon and name
                            }
                        },
                        {
                            data: 'ip'
                        },
                        {
                            data: 'page'
                        },
                        {
                            data: 'created_at'
                        }
                    ],
                    order: [
                        [8, 'desc'] // Adjust this index to match the correct column for ordering
                    ]
                });
            });
        </script>
    @endpush
</x-default-layout>
