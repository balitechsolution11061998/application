<x-default-layout>
    @section('title', 'Add Member')

    <div class="container my-5">
        <div class="card shadow-sm border-light">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Add New Member</h2>
                <i class="fas fa-user-plus fa-2x"></i> <!-- Icon for adding a member -->
            </div>
            <div class="card-body">
                <form id="addMemberForm" action="{{ route('members.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="join_date" class="form-label">Join Date</label>
                        <input type="date" class="form-control" id="join_date" name="join_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" id="submitButton">
                        <i class="fas fa-plus"></i> Add Member
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.css">

    <script>
        document.getElementById('addMemberForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Show SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to add a new member!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading spinner or disable button if needed
                    document.getElementById('submitButton').disabled = true;

                    // Submit the form
                    this.submit();
                }
            });
        });

        // Toastr notifications for success or error messages
        @if(session('success'))
            toastr.success("{{ session('success') }}", "Success", { timeOut: 5000 });
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", "Error", { timeOut: 5000 });
        @endif
    </script>
    @endpush
</x-default-layout>
