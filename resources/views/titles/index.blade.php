<x-default-layout>
    @section('title')
        Manage Titles
    @endsection



    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Manage Titles</h3>
                <a href="{{ route('titles.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Title
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="titlesTable" class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>URL</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($titles as $title)
                                <tr>
                                    <td>{{ $title->id }}</td>
                                    <td>{{ $title->url }}</td>
                                    <td>{{ $title->title }}</td>
                                    <td>
                                        <a href="{{ route('titles.edit', $title->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('titles.destroy', $title->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</x-default-layout>
