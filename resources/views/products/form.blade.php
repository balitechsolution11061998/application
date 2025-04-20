@extends('pos.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ isset($product) ? 'Edit' : 'Create' }} Product</h1>
            <p class="text-gray-600 dark:text-gray-400">Fill in the product details below</p>
        </div>
        <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to Products
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <form id="productForm" action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Product Name -->
                    <div class="form-group">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-box text-gray-400"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}"
                                   class="pl-10 w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror"
                                   required>
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 pt-3 pointer-events-none">
                                <i class="fas fa-align-left text-gray-400"></i>
                            </div>
                            <textarea id="description" name="description" rows="4"
                                      class="pl-10 w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('description') border-red-500 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKU and UPC -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- SKU -->
                        <div class="form-group">
                            <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-barcode text-gray-400"></i>
                                </div>
                                <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku ?? '') }}"
                                       class="pl-10 w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('sku') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- UPC -->
                        <div class="form-group">
                            <label for="upc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">UPC (Barcode)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-qrcode text-gray-400"></i>
                                </div>
                                <input type="text" id="upc" name="upc" value="{{ old('upc', $product->upc ?? '') }}"
                                       class="pl-10 w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('upc') border-red-500 @enderror">
                            </div>
                            @error('upc')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Price and Company -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Price -->
                        <div class="form-group">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Default Price *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                </div>
                                <input type="number" id="price" name="price" value="{{ old('price', $product->price ?? 0) }}" min="0"
                                       class="pl-10 w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('price') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company -->
                        <div class="form-group">
                            <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                                <select id="company_id" name="company_id"
                                        class="pl-10 w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('company_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $product->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('company_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Column - Image Upload -->
                <div>
                    <div class="space-y-6">
                        <!-- Image Upload -->
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Image</label>
                            <div id="dragDropArea" class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center transition-all duration-300 hover:border-blue-500 hover:bg-blue-50/30 dark:hover:bg-blue-900/10 cursor-pointer">
                                <input type="file" name="image" id="image" class="hidden" accept="image/*">
                                <div id="dropMessage" class="space-y-2">
                                    <div class="mx-auto h-12 w-12 text-gray-400">
                                        <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                    </div>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                        <p class="pl-1">Drag and drop your image here, or</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG, GIF up to 2MB
                                    </p>
                                    <button type="button" onclick="document.getElementById('image').click()" class="mt-2 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Select Image
                                    </button>
                                </div>
                                <div id="previewContainer" class="hidden">
                                    <div class="relative">
                                        <img id="imagePreview" src="{{ isset($product) && $product->image ? asset('storage/'.$product->image) : '' }}" class="mx-auto max-h-48 rounded-lg object-contain">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 rounded-lg flex items-center justify-center opacity-0 hover:opacity-100">
                                            <button type="button" id="changeImage" class="px-3 py-1.5 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-sync-alt mr-1"></i> Change
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" id="removeImage" class="mt-3 px-3 py-1.5 bg-red-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fas fa-trash mr-1"></i> Remove Image
                                    </button>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Toggle -->
                        <div class="pt-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', isset($product) ? $product->is_active : true) ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">Active Status</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paguyuban Prices -->
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Paguyuban Prices</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Paguyuban</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($paguyubans as $paguyuban)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                            <span class="text-xs font-medium">{{ substr($paguyuban->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            {{ $paguyuban->name }}
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $paguyuban->location }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm">
                                            Rp
                                        </span>
                                        <input type="number" 
                                               class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                               name="paguyubans[{{ $paguyuban->id }}][price]" 
                                               value="{{ old('paguyubans.'.$paguyuban->id.'.price', $currentPaguyubans[$paguyuban->id] ?? '') }}" 
                                               min="0">
                                        <input type="hidden" 
                                               name="paguyubans[{{ $paguyuban->id }}][id]" 
                                               value="{{ $paguyuban->id }}">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 copy-price" data-target="#paguyuban-{{ $paguyuban->id }}-price">
                                        <i class="fas fa-copy mr-1"></i> Copy from Default
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Cancel
                </a>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <i class="fas fa-save mr-2"></i> {{ isset($product) ? 'Update' : 'Save' }} Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styling for the drag and drop area */
    #dragDropArea.highlight {
        border-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    /* Dark mode styles */
    .dark #dragDropArea.highlight {
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    /* Transition for smoother hover effects */
    #dragDropArea, #dragDropArea * {
        transition: all 0.3s ease;
    }
    
    /* Style for the paguyuban prices table */
    .min-w-full.divide-y.divide-gray-200 {
        min-width: 100%;
        border-collapse: collapse;
    }
    
    /* Form group spacing */
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    /* Preview image container */
    #previewContainer {
        transition: all 0.3s ease;
    }
    
    /* Loading spinner */
    .spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Drag and drop functionality
        const dragDropArea = document.getElementById('dragDropArea');
        const fileInput = document.getElementById('image');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const dropMessage = document.getElementById('dropMessage');
        const removeImageBtn = document.getElementById('removeImage');
        const changeImageBtn = document.getElementById('changeImage');

        // Highlight drop area when item is dragged over it
        ['dragover', 'dragenter'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                dragDropArea.classList.add('border-blue-500', 'bg-blue-50/30', 'dark:bg-blue-900/10');
                dragDropArea.classList.remove('border-gray-300', 'dark:border-gray-600');
            });
        });

        ['dragleave', 'dragend', 'drop'].forEach(eventName => {
            dragDropArea.addEventListener(eventName, () => {
                dragDropArea.classList.remove('border-blue-500', 'bg-blue-50/30', 'dark:bg-blue-900/10');
                dragDropArea.classList.add('border-gray-300', 'dark:border-gray-600');
            });
        });

        // Handle dropped files
        dragDropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                handleFiles(e.dataTransfer.files);
            }
        });

        // Handle file selection
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleFiles(e.target.files);
            }
        });

        // Remove image
        removeImageBtn.addEventListener('click', removeImage);

        // Change image
        changeImageBtn.addEventListener('click', () => fileInput.click());

        function handleFiles(files) {
            const file = files[0];
            if (file && file.type.startsWith('image/')) {
                if (file.size > 2 * 1024 * 1024) {
                    toastr.error('File size should be less than 2MB');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    dropMessage.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                fileInput.files = files; // Set the files for form submission
            } else {
                toastr.error('Please select a valid image file');
            }
        }

        function removeImage() {
            fileInput.value = '';
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
            dropMessage.classList.remove('hidden');
        }

        // Initialize preview if editing with existing image
        @if(isset($product) && $product->image)
            dropMessage.classList.add('hidden');
            previewContainer.classList.remove('hidden');
        @endif

        // Copy default price to paguyuban price
        document.querySelectorAll('.copy-price').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const defaultPrice = document.getElementById('price').value;
                if (defaultPrice) {
                    document.querySelector(targetId).value = defaultPrice;
                    toastr.success('Price copied successfully');
                } else {
                    toastr.warning('Default price is empty');
                }
            });
        });

        // Form submission with AJAX
        const form = document.getElementById('productForm');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const url = form.getAttribute('action');
            const method = form.getAttribute('method');
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <i class="fas fa-spinner spinner mr-2"></i> 
                ${submitBtn.textContent.trim()}
            `;
            
            // AJAX request
            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('products.index') }}";
                    }, 1500);
                } else {
                    toastr.error(data.message);
                    // Handle validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            toastr.error(data.errors[field][0]);
                        });
                    }
                }
            })
            .catch(error => {
                toastr.error('An error occurred. Please try again.');
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                    <i class="fas fa-save mr-2"></i> 
                    ${submitBtn.textContent.replace('...', '').trim()}
                `;
            });
        });

        // Price formatting
        document.getElementById('price').addEventListener('blur', function() {
            if (this.value) {
                this.value = parseInt(this.value).toLocaleString('id-ID');
            }
        });

        document.getElementById('price').addEventListener('focus', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endpush