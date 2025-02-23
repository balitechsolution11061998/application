<x-default-layout>
    @section('title', 'Edit Member')

    <div class="container my-5">
        <div class="card shadow-sm border-light">
            <div class="card-header bg-light text-center border-bottom py-4">
                <h2 class="mb-0 text-primary">Edit Member</h2>
                <p class="text-muted">Update the member's information below</p>
            </div>
            <div class="card-body">
                <form id="editMemberForm" action="{{ route('members.update', $member) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" required>{{ $member->address }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $member->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $member->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="join_date" class="form-label">Join Date</label>
                        <input type="date" class="form-control" id="join_date" name="join_date" value="{{ \Carbon\Carbon::parse($member->join_date)->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm" id="submitButton">
                        <i class="fas fa-save"></i> Update Member
                    </button>
                    <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('editMemberForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Show SweetAlert confirmation
            Swal.fire({
                title: "Are you sure?",
                text: "Once updated, you will not be able to recover this member's data!",
                icon: "warning",
                showCancelButton: true, // Use showCancelButton instead of buttons
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) { // Check if the confirm button was clicked
                    // Show loading spinner
                    document.getElementById('loadingSpinner').style.display = 'inline-block';
                    // Disable the submit button to prevent multiple submissions
                    document.getElementById('submitButton').disabled = true;

                    // Submit the form
                    this.submit();
                } else {
                    Swal.fire("Your data is safe!"); // Use Swal.fire for the alert
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


    <style>
        /* Custom styles for the loading spinner */
        #loadingSpinner {
            margin-left: 10px; /* Add some space between the button and spinner */
            vertical-align: middle; /* Align spinner vertically with the button */
        }
    </style>
</x-default-layout>
