<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 15px;
        }
        .lead {
            font-weight: 500;
            margin-bottom: 20px;
        }
        .btn-lg {
            width: 100%;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-lg:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .progress {
            height: 20px;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar {
            border-radius: 5px;
        }
        #message {
            margin-top: 20px;
        }
    </style>

    <div class="content flex-grow-1 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
            <div class="card-header text-center">
                <h1 class="h4 card-title">Welcome to the Supplier Management System</h1>
            </div>
            <div class="card-body">
                <p class="lead text-center">Use the buttons below to manage your database.</p>
                <form id="importForm" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg">Import Database</button>
                </form>
                <form id="refreshLaratrustForm" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">Refresh Laratrust Seeder</button>
                </form>
                <div id="message" class="mt-3"></div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#importForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                Swal.fire({
                    title: 'Importing Database',
                    html: `
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" id="progressBar"></div>
                        </div>
                    `,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                    showCloseButton: false,
                    showCancelButton: false,
                });

                $.ajax({
                    url: "{{ route('import.database') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#progressBar').css('width', '100%');
                        Swal.close(); // Close the SweetAlert modal
                        toastr.success(response.message); // Show Toastr success message
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Error importing database: " + xhr.responseJSON.message, "error");
                    }
                });
            });

            $('#refreshLaratrustForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission
                console.log("masuk sini");
                Swal.fire({
                    title: 'Refreshing Laratrust Seeder',
                    html: `
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" id="laratrustProgressBar"></div>
                        </div>
                    `,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                    showCloseButton: false,
                    showCancelButton: false,
                });

                $.ajax({
                    url: "{{ route('refresh.laratrust') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#laratrustProgressBar').css('width', '100%');
                        Swal.close(); // Close the SweetAlert modal
                        toastr.success(response.message); // Show Toastr success message
                    },
                    error: function(xhr) {
                        Swal.fire("Error!", "Error refreshing Laratrust seeder: " + xhr.responseJSON.message, "error");
                    }
                });
            });
        });
    </script>
    @endpush
</x-default-layout>
