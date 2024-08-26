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
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Banner</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('banner.store') }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="inputTitle" class="form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputDesc" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputPhoto" class="form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <button class="btn btn-primary" id="lfm" data-input="thumbnail" data-preview="holder">
                            <i class="fa fa-picture-o"></i> Choose
                        </button>
                        <input id="thumbnail" class="form-control @error('photo') is-invalid @enderror" type="text"
                            name="photo" value="{{ old('photo') }}">
                    </div>
                    <div id="holder" class="mt-2" style="max-height:100px;"></div>
                    @error('photo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="reset" class="btn btn-outline-warning me-2">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
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
