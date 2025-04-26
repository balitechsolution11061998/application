@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Notification Toast -->
    @if($errors->any())
        <div class="notification-toast fixed top-5 right-5 z-50">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-lg rounded-lg flex items-start animate-slide-in">
                <div class="mr-3 text-red-500">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold">Form Errors</h4>
                    <p class="text-sm">Please correct the highlighted fields</p>
                </div>
                <button class="ml-6 text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-white rounded-xl p-6 mb-6 shadow-md border border-gray-200">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                    @isset($paguyuban)
                        <span class="inline-flex items-center gap-3">
                            <span class="p-2 bg-indigo-100 rounded-full text-indigo-600">
                                <i class="fas fa-users-cog"></i>
                            </span>
                            <span>Edit Community</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-3">
                            <span class="p-2 bg-indigo-100 rounded-full text-indigo-600">
                                <i class="fas fa-users-medical"></i>
                            </span>
                            <span>Create New Community</span>
                        </span>
                    @endisset
                </h1>
                <p class="text-gray-600 text-sm sm:text-base max-w-2xl">
                    @isset($paguyuban)
                        Update your community details and member benefits
                    @else
                        Start a new community with shared discounts and special offers
                    @endisset
                </p>
            </div>
            <a href="{{ route('pos.community.index') }}" 
               class="flex items-center justify-center px-5 py-2.5 bg-white text-indigo-600 rounded-lg shadow-sm transition-all duration-300 group border border-indigo-100 hover:border-indigo-200 hover:bg-indigo-50">
                <i class="fas fa-chevron-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <form action="@isset($paguyuban) {{ route('pos.community.update', $paguyuban) }} @else {{ route('pos.community.store') }} @endisset" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @isset($paguyuban) @method('PUT') @endisset

            <div class="p-6 space-y-8">
                <!-- Logo Upload -->
                <div class="flex flex-col items-center space-y-4">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-xl border-2 border-gray-200 shadow-sm overflow-hidden bg-gray-50 flex items-center justify-center transition-all duration-300 group-hover:shadow-md">
                            @isset($paguyuban->logo)
                                <img id="logoPreview" src="{{ asset('storage/'.$paguyuban->logo) }}" alt="Community Logo" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div id="logoPlaceholder" class="text-gray-400 text-5xl transition-all duration-300 group-hover:text-indigo-500">
                                    <i class="fas fa-users"></i>
                                </div>
                            @endisset
                        </div>
                        <label for="logo" class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-md cursor-pointer hover:bg-indigo-50 transition-all duration-300 group-hover:scale-110 border border-gray-200">
                            <i class="fas fa-camera text-indigo-600"></i>
                            <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                        </label>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-black/20 rounded-xl">
                            <span class="bg-white text-indigo-600 text-xs font-medium px-3 py-1 rounded-full shadow">Change Logo</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">PNG or JPG • 300×300px • Max 2MB</p>
                </div>

                <!-- Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Field -->
                    <div class="relative col-span-2">
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name', $paguyuban->name ?? '') }}" required
                                class="peer block w-full px-4 py-3 border border-gray-300 text-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-transparent transition-all duration-200"
                                placeholder=" ">
                            <label for="name" 
                                   class="absolute left-3 -top-2.5 bg-white px-1 text-sm font-medium text-gray-700 transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:left-4 peer-focus:-top-2.5 peer-focus:left-3 peer-focus:text-sm peer-focus:text-indigo-600">
                                Community Name <span class="text-red-500">*</span>
                            </label>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="relative col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <div class="relative">
                            <textarea id="description" name="description" rows="4"
                                class="block w-full px-4 py-3 border border-gray-300 text-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none"
                                data-maxlength="255">{{ old('description', $paguyuban->description ?? '') }}</textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-gray-500 bg-white px-2 py-1 rounded">
                                <span id="charCount">0</span>/255
                            </div>
                        </div>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1.5"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                <!-- Enhanced Colored Toggle Switch -->
<div class="col-span-2">
    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="font-medium text-gray-800">Community Status</h4>
                <p class="text-xs text-gray-500 mt-1">Active communities are visible to members</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" 
                    @checked(old('is_active', isset($paguyuban) ? $paguyuban->is_active : true))>
                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-focus:ring-4 peer-focus:ring-indigo-100 peer-checked:bg-green-500 transition-colors duration-300 ease-in-out">
                    <div class="absolute left-[2px] top-[2px] bg-white border-2 border-gray-300 rounded-full h-5 w-5 transition-all duration-300 ease-in-out shadow-sm transform peer-checked:translate-x-5 peer-checked:border-green-600"></div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-700 min-w-[60px]">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-gray-400 peer-checked:bg-green-500 transition-colors duration-300"></span>
                        <span x-text="document.querySelector('input[name=\'is_active\']').checked ? 'Active' : 'Inactive'" 
                              :class="{'text-green-600': document.querySelector('input[name=\'is_active\']').checked, 'text-gray-500': !document.querySelector('input[name=\'is_active\']').checked}">
                        </span>
                    </span>
                </span>
            </label>
        </div>
    </div>
</div>
                </div>

                <!-- Advanced Settings Accordion -->
                <div x-data="{ expanded: @json(old('discount_percentage') || isset($paguyuban)) }" class="border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="expanded = !expanded" type="button" 
                            class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-indigo-600 flex items-center gap-2">
                            <i class="fas fa-sliders-h"></i>
                            Advanced Settings
                        </span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" 
                           :class="{ 'transform rotate-180': expanded }"></i>
                    </button>
                    <div x-show="expanded" x-collapse class="p-4 space-y-6 bg-white border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Discount Percentage -->
                            <div>
                                <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Member Discount</label>
                                <div class="relative">
                                    <input type="range" id="discount_range" min="0" max="50" 
                                           value="{{ old('discount_percentage', $paguyuban->discount_percentage ?? 0) }}"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                                    <div class="flex justify-between text-xs text-gray-500 mt-1 px-1">
                                        <span>0%</span>
                                        <span>50%</span>
                                    </div>
                                    <input type="number" id="discount_percentage" name="discount_percentage" 
                                           value="{{ old('discount_percentage', $paguyuban->discount_percentage ?? 0) }}" min="0" max="50"
                                           class="absolute -bottom-8 right-0 w-20 px-3 py-1.5 border border-gray-300 text-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-center font-medium">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                                @error('discount_percentage')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1.5"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Brand Color Picker -->
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Brand Color</label>
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <input type="color" id="color" name="color" value="{{ old('color', $paguyuban->color ?? '#6366f1') }}"
                                               class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer appearance-none bg-transparent">
                                        <div class="absolute inset-0 rounded-lg pointer-events-none shadow-inner border border-black/10"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="h-10 rounded-lg flex overflow-hidden shadow-sm">
                                            <div class="h-full w-1/3" style="background-color: var(--color-primary)"></div>
                                            <div class="h-full w-1/3" style="background-color: var(--color-primary-light)"></div>
                                            <div class="h-full w-1/3" style="background-color: var(--color-primary-dark)"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1.5">This color will be used for community branding</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-right">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                    <i class="fas fa-save mr-2"></i>
                    @isset($paguyuban)
                        Update Community
                    @else
                        Create Community
                    @endisset
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Notification toast
    @if($errors->any())
    const toast = document.querySelector('.notification-toast');
    if (toast) {
        // Auto-hide after 5 seconds
        setTimeout(() => {
            toast.classList.add('animate-slide-out');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
        
        // Manual close
        toast.querySelector('button').addEventListener('click', () => {
            toast.classList.add('animate-slide-out');
            setTimeout(() => toast.remove(), 300);
        });
    }
    @endif

    // Logo preview
    document.getElementById('logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size
            if (file.size > 2 * 1024 * 1024) {
                alert('File size exceeds 2MB limit');
                this.value = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Only JPG, PNG or GIF files are allowed');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('logoPreview');
                const placeholder = document.getElementById('logoPlaceholder');
                
                if (preview) {
                    preview.src = event.target.result;
                } else if (placeholder) {
                    placeholder.innerHTML = `<img src="${event.target.result}" class="h-full w-full object-cover">`;
                    placeholder.id = 'logoPreview';
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    if (description && charCount) {
        // Set initial count
        charCount.textContent = description.value.length;
        
        // Update on input
        description.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = currentLength;
            
            // Change color when approaching limit
            if (currentLength > 200) {
                charCount.classList.add('text-yellow-600');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.remove('text-yellow-600');
                charCount.classList.add('text-gray-500');
            }
            
            if (currentLength > 250) {
                charCount.classList.add('text-red-500');
                charCount.classList.remove('text-yellow-600');
            } else if (currentLength <= 200) {
                charCount.classList.remove('text-red-500');
            }
        });
    }

    // Discount range slider sync with input
    const discountRange = document.getElementById('discount_range');
    const discountInput = document.getElementById('discount_percentage');
    
    if (discountRange && discountInput) {
        discountRange.addEventListener('input', function() {
            discountInput.value = this.value;
        });
        
        discountInput.addEventListener('input', function() {
            if (this.value > 50) this.value = 50;
            if (this.value < 0) this.value = 0;
            discountRange.value = this.value;
        });
    }

    // Color picker changes
    const colorPicker = document.getElementById('color');
    if (colorPicker) {
        colorPicker.addEventListener('input', function() {
            document.documentElement.style.setProperty('--color-primary', this.value);
            document.documentElement.style.setProperty('--color-primary-light', lightenColor(this.value, 20));
            document.documentElement.style.setProperty('--color-primary-dark', darkenColor(this.value, 20));
        });
        
        // Set initial colors
        document.documentElement.style.setProperty('--color-primary', colorPicker.value);
        document.documentElement.style.setProperty('--color-primary-light', lightenColor(colorPicker.value, 20));
        document.documentElement.style.setProperty('--color-primary-dark', darkenColor(colorPicker.value, 20));
    }

    // Helper functions for color manipulation
    function lightenColor(color, percent) {
        const num = parseInt(color.replace('#', ''), 16);
        const amt = Math.round(2.55 * percent);
        const R = (num >> 16) + amt;
        const G = (num >> 8 & 0x00FF) + amt;
        const B = (num & 0x0000FF) + amt;
        return `#${(
            0x1000000 +
            (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 +
            (G < 255 ? G < 1 ? 0 : G : 255) * 0x100 +
            (B < 255 ? B < 1 ? 0 : B : 255)
        ).toString(16).slice(1)}`;
    }

    function darkenColor(color, percent) {
        const num = parseInt(color.replace('#', ''), 16);
        const amt = Math.round(2.55 * percent);
        const R = (num >> 16) - amt;
        const G = (num >> 8 & 0x00FF) - amt;
        const B = (num & 0x0000FF) - amt;
        return `#${(
            0x1000000 +
            (R > 0 ? R < 255 ? R : 255 : 0) * 0x10000 +
            (G > 0 ? G < 255 ? G : 255 : 0) * 0x100 +
            (B > 0 ? B < 255 ? B : 255 : 0)
        ).toString(16).slice(1)}`;
    }
</script>
@endpush

<style>
    /* Animations */
    .animate-slide-in {
        animation: slideIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    
    .animate-slide-out {
        animation: slideOut 0.3s ease-in forwards;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(20px);
        }
    }

    /* Custom range slider */
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        background: #6366f1;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    input[type="range"]::-moz-range-thumb {
        width: 18px;
        height: 18px;
        background: #6366f1;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Hide color picker's default background */
    input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
    }
    
    input[type="color"]::-webkit-color-swatch {
        border: none;
        border-radius: 6px;
    }

    /* Alpine.js transitions */
    [x-cloak] { display: none !important; }
</style>
@endsection