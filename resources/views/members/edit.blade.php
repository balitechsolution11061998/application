<x-default-layout>
    @section('title', 'Edit Member')

    <div class="container my-5">
        <h2>Edit Member</h2>
        <form action="{{ route('members.update', $member) }}" method="POST">
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
                <input type="date" class="form-control" id="join_date" name="join_date" value="{{ $member->join_date->format('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update Member</button>
        </form>
    </div>
</x-default-layout>
