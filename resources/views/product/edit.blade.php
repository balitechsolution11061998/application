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
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Edit Product</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('product.update', $product->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="inputTitle" class="form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ $product->title }}" class="form-control">
                    @error('title')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="summary" class="form-label">Summary <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ $product->summary }}</textarea>
                    @error('summary')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" class="form-check-input" {{ $product->is_featured ? 'checked' : '' }}>
                    <label for="is_featured" class="form-check-label">Is Featured</label>
                </div>

                <div class="mb-3">
                    <label for="cat_id" class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-select">
                        <option value="">--Select any category--</option>
                        @foreach($categories as $cat_data)
                            <option value="{{ $cat_data->id }}" {{ $product->cat_id == $cat_data->id ? 'selected' : '' }}>{{ $cat_data->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 {{ !$product->child_cat_id ? 'd-none' : '' }}" id="child_cat_div">
                    <label for="child_cat_id" class="form-label">Sub Category</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-select">
                        <option value="">--Select any sub category--</option>
                        <!-- Options will be dynamically populated -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (NRS) <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Enter price" value="{{ $product->price }}" class="form-control">
                    @error('price')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount" class="form-label">Discount (%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount" value="{{ $product->discount }}" class="form-control">
                    @error('discount')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="size" class="form-label">Size</label>
                    <select name="size[]" class="form-select" multiple>
                        <option value="S" {{ in_array("S", explode(',', $product->size)) ? 'selected' : '' }}>Small</option>
                        <option value="M" {{ in_array("M", explode(',', $product->size)) ? 'selected' : '' }}>Medium</option>
                        <option value="L" {{ in_array("L", explode(',', $product->size)) ? 'selected' : '' }}>Large</option>
                        <option value="XL" {{ in_array("XL", explode(',', $product->size)) ? 'selected' : '' }}>Extra Large</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="brand_id" class="form-label">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-select">
                        <option value="">--Select Brand--</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="condition" class="form-label">Condition</label>
                    <select name="condition" id="condition" class="form-select">
                        <option value="">--Select Condition--</option>
                        <option value="default" {{ $product->condition == 'default' ? 'selected' : '' }}>Default</option>
                        <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>New</option>
                        <option value="hot" {{ $product->condition == 'hot' ? 'selected' : '' }}>Hot</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input id="stock" type="number" name="stock" min="0" placeholder="Enter quantity" value="{{ $product->stock }}" class="form-control">
                    @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputPhoto" class="form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-image"></i> Choose
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $product->photo }}">
                        <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fas fa-image"></i> Choose
                        </button>
                    </div>
                    <div id="holder" class="mt-2" style="max-height: 100px;"></div>
                    @error('photo')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select">
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
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
