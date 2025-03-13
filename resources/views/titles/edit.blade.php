<x-default-layout>
    @section('title', 'Edit Title')

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-edit"></i> Edit Title</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('titles.update', $title->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="url" class="form-label"><i class="fas fa-link"></i> URL</label>
                        <input type="text" id="url" name="url" class="form-control" value="{{ $title->url }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label"><i class="fas fa-heading"></i> Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ $title->title }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('titles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-default-layout>
