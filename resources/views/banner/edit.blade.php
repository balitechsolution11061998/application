<x-default-layout>
    @section('title')
        Banner
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('banner') }}
    @endsection
    @push('styles')
    <link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
    @endpush
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="card-title mb-0">Edit Banner</h5>
            <div class="card-header-actions">
                <!-- You can add additional elements here if needed -->
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('banner.update', $banner->id) }}">
                @csrf
                @method('PATCH')

                <!-- Title Input -->
                <div class="mb-3">
                    <label for="inputTitle" class="form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ $banner->title }}" class="form-control">
                    @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Textarea -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ $banner->description }}</textarea>
                    @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Photo Input -->
                <div class="mb-3">
                    <label for="inputPhoto" class="form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <button type="button" id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </button>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $banner->photo }}">
                    </div>
                    <div id="holder" class="mt-3">
                        @if($banner->photo)
                            <img src="{{ $banner->photo }}" class="img-fluid mt-2" alt="Banner Photo">
                        @else
                            <img src="{{ asset('images/default-image.png') }}" class="img-fluid mt-2" alt="Default Photo">
                        @endif
                    </div>
                    @error('photo')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Select -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select">
                        <option value="active" {{ $banner->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $banner->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('banner.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>




    <!--end::Row-->
    @push('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('js/summernote.min.js') }}"></script>
        <script>
            $('#lfm').filemanager('image');

            $(document).ready(function() {
                $('#description').summernote({
                    placeholder: "Write short description.....",
                    tabsize: 2,
                    height: 150
                });
            });
        </script>
    @endpush
</x-default-layout>
