<x-default-layout>
    @section('title', 'Category')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('category') }}
    @endsection

    @push('styles')
        <link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
    @endpush

        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h5 class="card-title mb-0">Edit Category</h5>
                <div class="card-header-actions">
                    <!-- You can add additional elements here if needed -->
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('category.update', $category->id) }}">
                    @csrf
                    @method('PATCH')

                    <!-- Title Input -->
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Title <span class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ $category->title }}" class="form-control">
                        @error('title')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Summary Input -->
                    <div class="mb-3">
                        <label for="summary" class="form-label">Summary</label>
                        <textarea class="form-control" id="summary" name="summary" rows="3">{{ $category->summary }}</textarea>
                        @error('summary')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Parent Checkbox -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_parent" id="is_parent" value="1" class="form-check-input" {{ $category->is_parent ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_parent">Is Parent</label>
                    </div>

                    <!-- Parent Category Select -->
                    <div class="mb-3 {{ $category->is_parent ? 'd-none' : '' }}" id="parent_cat_div">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">--Select a category--</option>
                            @foreach($parent_cats as $parent_cat)
                                <option value="{{ $parent_cat->id }}" {{ $parent_cat->id == $category->parent_id ? 'selected' : '' }}>{{ $parent_cat->title }}</option>
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
                            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $category->photo }}">
                        </div>
                        <div id="holder" class="mt-2">
                            @if($category->photo)
                                <img src="{{ $category->photo }}" class="img-fluid" alt="Photo preview">
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
                            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Button -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>




    @push('scripts')
        <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
        <script src="{{ asset('js/summernote.min.js') }}"></script>
        <script>
            $('#lfm').filemanager('image');

            $(document).ready(function() {
            $('#summary').summernote({
              placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
            });
        </script>
        <script>
          $('#is_parent').change(function(){
            var is_checked=$('#is_parent').prop('checked');
            // alert(is_checked);
            if(is_checked){
              $('#parent_cat_div').addClass('d-none');
              $('#parent_cat_div').val('');
            }
            else{
              $('#parent_cat_div').removeClass('d-none');
            }
          })
        </script>
    @endpush
</x-default-layout>
