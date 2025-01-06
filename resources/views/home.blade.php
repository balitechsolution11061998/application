<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .card-header {
            font-weight: 700;
        }
        .lead {
            font-weight: 500;
        }
        .card-footer {
            font-size: 0.9rem;
        }
    </style>

    <div class="content flex-grow-1 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
            <div class="card-header bg-primary text-white text-center">
                <h1 class="h4">Welcome to the Supplier Management System</h1>
            </div>
            <div class="card-body">
                <p class="lead text-center">This is your dashboard where you can manage suppliers, view orders, and generate reports.</p>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-success btn-lg mx-2">Manage Suppliers</a>
                    <a href="#" class="btn btn-info btn-lg mx-2">View Orders</a>
                    <a href="#" class="btn btn-warning btn-lg mx-2">Generate Reports</a>
                </div>
            </div>
            <div class="card-footer text-center">
                <small class="text-muted">© 2025 Supplier Management System</small>
            </div>
        </div>
    </div>
</x-default-layout>
