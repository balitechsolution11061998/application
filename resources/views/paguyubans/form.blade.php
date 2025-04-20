@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <h1>{{ isset($paguyuban) ? 'Edit' : 'Create' }} Paguyuban</h1>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ isset($paguyuban) ? route('paguyubans.update', $paguyuban->id) : route('paguyubans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($paguyuban))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $paguyuban->name ?? '') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $paguyuban->description ?? '') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', isset($paguyuban) ? $paguyuban->is_active : true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <div class="drag-drop-area" id="dragDropArea">
                                <input type="file" name="logo" id="logo" class="d-none" accept="image/*">
                                <div class="drop-message">
                                    <i class="fas fa-cloud-upload-alt fa-3x"></i>
                                    <p>Drag & drop your logo here or click to browse</p>
                                </div>
                                <div class="preview-container d-none">
                                    <img id="logoPreview" src="{{ isset($paguyuban) && $paguyuban->logo ? $paguyuban->logo_url : '' }}" class="img-thumbnail">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" id="removeLogo">
                                        <i class="fas fa-trash"></i> Remove Logo
                                    </button>
                                </div>
                            </div>
                            @error('logo')
                                <span class="text-danger" role="alert">
                                    <small><strong>{{ $message }}</strong></small>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($paguyuban) ? 'Update' : 'Save' }} Paguyuban
                    </button>
                    <a href="{{ route('paguyubans.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Drag and drop functionality
        const dragDropArea = document.getElementById('dragDropArea');
        const fileInput = document.getElementById('logo');
        const previewContainer = dragDropArea.querySelector('.preview-container');
        const logoPreview = document.getElementById('logoPreview');
        const dropMessage = dragDropArea.querySelector('.drop-message');
        const removeLogoBtn = document.getElementById('removeLogo');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dragDropArea.addEventListener('drop', handleDrop, false);

        // Click to select files
        dragDropArea.addEventListener('click', () => fileInput.click());

        // Handle file selection
        fileInput.addEventListener('change', handleFiles);

        // Remove logo
        removeLogoBtn.addEventListener('click', removeLogo);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight() {
            dragDropArea.classList.add('highlight');
        }

        function unhighlight() {
            dragDropArea.classList.remove('highlight');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles({ target: { files } });
        }

        function handleFiles(e) {
            const files = e.target.files;
            if (files.length) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        logoPreview.src = event.target.result;
                        dropMessage.classList.add('d-none');
                        previewContainer.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function removeLogo() {
            fileInput.value = '';
            logoPreview.src = '';
            previewContainer.classList.add('d-none');
            dropMessage.classList.remove('d-none');
        }

        // Initialize preview if editing with existing logo
        @if(isset($paguyuban) && $paguyuban->logo)
            dropMessage.classList.add('d-none');
            previewContainer.classList.remove('d-none');
        @endif
    });
</script>
@endpush

@push('styles')
<style>
    .drag-drop-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .drag-drop-area.highlight {
        border-color: #4e73df;
        background-color: rgba(78, 115, 223, 0.05);
    }

    .drag-drop-area .drop-message i {
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .drag-drop-area .drop-message p {
        margin-bottom: 0;
        color: #6c757d;
    }

    #logoPreview {
        max-width: 100%;
        max-height: 200px;
        display: block;
        margin: 0 auto;
    }
</style>
@endpush