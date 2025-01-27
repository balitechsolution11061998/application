<x-default-layout>
    @section('title', 'Import Data Kependudukan')

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Import Data Kependudukan</h5>
        </div>
        <div class="card-body">
            <form id="importForm" action="{{ route('data-kependudukan.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Upload Excel File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                </div>
                <button type="button" id="submitButton" class="btn btn-primary">
                    <i class="fa fa-upload"></i> Import
                </button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script>
        // SweetAlert Confirmation
        document.getElementById('submitButton').addEventListener('click', function () {
            const form = document.getElementById('importForm');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to import this file?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, import it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form
                }
            });
        });

        // Toastr Notifications
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
    @endpush
</x-default-layout>
