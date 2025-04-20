@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1>Paguyuban Management</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('paguyubans.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Paguyuban
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paguyubans as $paguyuban)
                        <tr>
                            <td>
                                <img src="{{ $paguyuban->logo_url }}" alt="{{ $paguyuban->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>{{ $paguyuban->name }}</td>
                            <td>{{ Str::limit($paguyuban->description, 50) }}</td>
                            <td>
                                <span class="badge badge-{{ $paguyuban->is_active ? 'success' : 'danger' }}">
                                    {{ $paguyuban->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('paguyubans.show', $paguyuban->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('paguyubans.edit', $paguyuban->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('paguyubans.destroy', $paguyuban->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('paguyubans.toggle-status', $paguyuban->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-{{ $paguyuban->is_active ? 'warning' : 'success' }}">
                                            <i class="fas fa-{{ $paguyuban->is_active ? 'times' : 'check' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No paguyubans found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $paguyubans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection