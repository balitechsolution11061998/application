<x-default-layout>
    @section('title')
        Product
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('product') }}
    @endsection

    @push('styles')
        <link href="{{ asset('css/summernote.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    @endpush

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h5 class="card-title mb-0">Add Product</h5>
            <div class="card-header-actions">
                <!-- You can add additional elements here if needed -->
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('product.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="inputTitle" class="form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ old('title') }}" class="form-control">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Summary <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ old('summary') }}</textarea>
                    @error('summary')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="is_featured" class="form-check-label">Is Featured</label><br>
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" checked> Yes
                </div>

                <div class="mb-3">
                    <label for="cat_id" class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-select">
                        <option value="">--Select any category--</option>
                        @foreach ($categories as $key => $cat_data)
                            <option value="{{ $cat_data->id }}">{{ $cat_data->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 d-none" id="child_cat_div">
                    <label for="child_cat_id" class="form-label">Sub Category</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-select">
                        <option value="">--Select any sub category--</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (NRS) <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Enter price"
                        value="{{ old('price') }}" class="form-control">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount" class="form-label">Discount (%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100"
                        placeholder="Enter discount" value="{{ old('discount') }}" class="form-control">
                    @error('discount')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="size" class="form-label">Size</label>
                    <select name="size[]" class="form-select" multiple>
                        <option value="">--Select any size--</option>
                        <option value="S">Small (S)</option>
                        <option value="M">Medium (M)</option>
                        <option value="L">Large (L)</option>
                        <option value="XL">Extra Large (XL)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="brand_id" class="form-label">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="">--Select Brand--</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="condition" class="form-label">Condition</label>
                    <select name="condition" class="form-select">
                        <option value="">--Select Condition--</option>
                        <option value="default">Default</option>
                        <option value="new">New</option>
                        <option value="hot">Hot</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input id="stock" type="number" name="stock" min="0" placeholder="Enter quantity"
                        value="{{ old('stock') }}" class="form-control">
                    @error('stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputPhoto" class="form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ old('photo') }}">
                    </div>
                    <div id="holder" style="margin-top:15px; max-height:100px;"></div>
                    @error('photo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 100
            });
            $('#description').summernote({
                placeholder: "Write detailed description.....",
                tabsize: 2,
                height: 150
            });

            // Initialize select2 on your select elements
            $('#cat_id').select2({
                placeholder: "--Select any category--"
            });
            $('#child_cat_id').select2({
                placeholder: "--Select any sub category--"
            });
            $('select[name="size[]"]').select2({
                placeholder: "--Select any size--"
            });
            $('select[name="brand_id"]').select2({
                placeholder: "--Select Brand--"
            });
            $('select[name="condition"]').select2({
                placeholder: "--Select Condition--"
            });
            $('select[name="status"]').select2({
                placeholder: "--Select Status--"
            });
        });

        $('#cat_id').change(function() {
                var cat_id = $(this).val();
                if (cat_id != null) {
                    $.ajax({
                        url: "/admin/category/" + cat_id + "/child",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: cat_id
                        },
                        type: "POST",
                        success: function(response) {
                            var html_option = "<option value=''>----Select sub category----</option>";
                            if (response.status) {
                                var data = response.data;
                                if (data && data.length > 0) {
                                    $('#child_cat_div').removeClass('d-none');
                                    $.each(data, function(id, title) {
                                        html_option += "<option value='" + id + "'>" + title + "</option>";
                                    });
                                } else {
                                    $('#child_cat_div').addClass('d-none');
                                }
                            } else {
                                $('#child_cat_div').addClass('d-none');
                            }
                            $('#child_cat_id').html(html_option);
                        }
                    });
                } else {
                    $('#child_cat_div').addClass('d-none');
                }
            });
    </script>
@endpush


</x-default-layout>
