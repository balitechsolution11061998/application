<x-default-layout>
    @section('title', 'Add New Title')

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><i class="fas fa-plus-circle"></i> Add New Title</h3>
                <a href="{{ route('titles.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('titles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-link"></i> URL</label>
                        <input type="text" name="url" class="form-control" placeholder="Enter URL" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-heading"></i> Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ route('titles.index') }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-default-layout>
