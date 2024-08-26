<x-default-layout>
    @section('title', 'Category')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('category') }}
    @endsection

    @push('styles')
    <link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
    @endpush

    <!-- DataTales Example -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Add Category</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('category.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Title Input -->
                <div class="mb-3">
                    <label for="inputTitle" class="form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ old('title') }}" class="form-control">
                    @error('title')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Summary Input -->
                <div class="mb-3">
                    <label for="summary" class="form-label">Summary</label>
                    <textarea class="form-control" id="summary" name="summary" rows="3">{{ old('summary') }}</textarea>
                    @error('summary')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Is Parent Checkbox -->
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_parent" id="is_parent" value="1" class="form-check-input" {{ old('is_parent', 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_parent">Is Parent</label>
                </div>

                <!-- Parent Category Select -->
                <div class="mb-3 d-none" id="parent_cat_div">
                    <label for="parent_id" class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-select">
                        <option value="">--Select a category--</option>
                        @foreach($parent_cats as $parent_cat)
                            <option value="{{ $parent_cat->id }}">{{ $parent_cat->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Photo Input -->
                <div class="mb-3">
                    <label for="inputPhoto" class="form-label">Photo</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ old('photo') }}">
                    </div>
                    <div id="holder" class="mt-2" style="max-height: 100px;">
                        @if(old('photo'))
                            <img src="{{ old('photo') }}" class="img-fluid" alt="Photo preview">
                        @endif
                    </div>
                    @error('photo')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Select -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Buttons -->
                <div class="mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
        <script src="{{ asset('js/summernote.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#lfm').filemanager('image');
                $('#summary').summernote({
                    placeholder: "Write a short description...",
                    tabsize: 2,
                    height: 150
                });

                $('#is_parent').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#parent_cat_div').addClass('d-none');
                    } else {
                        $('#parent_cat_div').removeClass('d-none');
                    }
                });
            });
        </script>
    @endpush
</x-default-layout>
