@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Toastr Notifications -->
    @if($errors->any())
        <div class="toastr-notification fixed top-5 right-5 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center animate-fade-in-up">
                <i class="fas fa-exclamation-triangle mr-3"></i>
                <span>Please fix the errors in the form</span>
            </div>
        </div>
    @endif

    <!-- Header Section with Animated Gradient -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-purple-700 rounded-xl p-6 mb-6 shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-white/5 animate-pulse"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="transform transition-all duration-300 hover:scale-[1.01]">
                <h1 class="text-2xl sm:text-3xl font-bold text-white drop-shadow-md">
                    @isset($paguyuban) 
                        <i class="fas fa-edit mr-2"></i> Edit Paguyuban 
                    @else 
                        <i class="fas fa-plus-circle mr-2"></i> Create New Paguyuban 
                    @endisset
                </h1>
                <p class="text-indigo-100 mt-1 sm:mt-2 text-sm sm:text-base opacity-90">
                    @isset($paguyuban) 
                        Update community details and settings 
                    @else 
                        Add a new community group with special pricing 
                    @endisset
                </p>
            </div>
            <a href="{{ route('pos.community.index') }}" 
               class="flex items-center justify-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg shadow-md transition-all duration-300 group hover:shadow-lg hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-0.5 transition-transform"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Form Card with Floating Animation -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50 transform transition-all duration-500 hover:shadow-xl">
        <form action="@isset($paguyuban) {{ route('pos.community.update', $paguyuban) }} @else {{ route('pos.community.store') }} @endisset" 
              method="POST" 
              enctype="multipart/form-data"
              class="hover:shadow-inner transition-shadow duration-300">
            @csrf
            @isset($paguyuban) @method('PUT') @endisset

            <div class="p-6 space-y-8">
                <!-- Logo Upload with Pulse Animation -->
                <div class="flex flex-col items-center space-y-4">
                    <div class="relative group">
                        <div class="h-32 w-32 rounded-full border-4 border-white dark:border-gray-700 shadow-lg overflow-hidden bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center transition-all duration-300 group-hover:ring-4 group-hover:ring-indigo-200/50 dark:group-hover:ring-indigo-800/50">
                            @isset($paguyuban->logo)
                                <img id="logoPreview" src="{{ asset('storage/'.$paguyuban->logo) }}" alt="Paguyuban Logo" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div id="logoPlaceholder" class="text-indigo-500 dark:text-indigo-300 text-5xl transition-all duration-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-200">
                                    <i class="fas fa-users"></i>
                                </div>
                            @endisset
                        </div>
                        <label for="logo" class="absolute -bottom-2 -right-2 bg-white dark:bg-gray-700 rounded-full p-2 shadow-lg cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-800 transition-all duration-300 group-hover:scale-110">
                            <i class="fas fa-camera text-indigo-600 dark:text-indigo-300"></i>
                            <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                        </label>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="bg-black/50 text-white text-xs px-2 py-1 rounded">Change Logo</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 animate-pulse">Recommended: 300×300px PNG (max 2MB)</p>
                </div>

                <!-- Name Field with Floating Label Effect -->
                <div class="relative">
                    <input type="text" id="name" name="name" value="{{ old('name', $paguyuban->name ?? '') }}" required
                        class="peer block w-full px-4 py-3 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200"
                        placeholder=" ">
                    <label for="name" 
                           class="absolute left-3 -top-2.5 bg-white dark:bg-gray-800 px-1 text-sm font-medium text-gray-700 dark:text-gray-300 transition-all duration-200 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:left-4 peer-placeholder-shown:bg-transparent peer-focus:-top-2.5 peer-focus:left-3 peer-focus:text-sm peer-focus:text-indigo-600 dark:peer-focus:text-indigo-300 peer-focus:bg-white dark:peer-focus:bg-gray-800">
                        Community Name *
                    </label>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 animate-pulse flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description Field with Character Counter -->
                <div class="relative">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="block w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200"
                        data-maxlength="255">{{ old('description', $paguyuban->description ?? '') }}</textarea>
                    <div class="text-xs text-gray-500 dark:text-gray-400 text-right mt-1">
                        <span id="charCount">0</span>/255 characters
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 animate-pulse flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status Toggle Switch -->
                <div class="flex items-center justify-between p-3 bg-gray-100/50 dark:bg-gray-700/50 rounded-lg transition-colors duration-200 hover:bg-gray-200/50 dark:hover:bg-gray-600/50">
                    <div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Status</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Active communities are visible to members</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" 
                            @checked(old('is_active', isset($paguyuban) ? $paguyuban->is_active : true))>
                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-200 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-500 peer-checked:bg-indigo-600"></div>
                    </label>
                </div>

                <!-- Additional Fields Section (Collapsible) -->
                <div x-data="{ expanded: false }" class="border border-gray-200/50 dark:border-gray-700/50 rounded-lg overflow-hidden transition-all duration-300">
                    <button @click="expanded = !expanded" type="button" 
                            class="w-full flex items-center justify-between p-4 bg-gray-50/70 dark:bg-gray-700/30 hover:bg-gray-100/50 dark:hover:bg-gray-600/30 transition-colors">
                        <span class="font-medium text-indigo-600 dark:text-indigo-300">
                            <i class="fas fa-cog mr-2"></i> Advanced Settings
                        </span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300" 
                           :class="{ 'transform rotate-180': expanded }"></i>
                    </button>
                    <div x-show="expanded" x-collapse class="p-4 space-y-6 bg-white/50 dark:bg-gray-800/30">
                        <!-- Discount Percentage -->
                        <div>
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Member Discount (%)</label>
                            <div class="relative">
                                <input type="number" id="discount_percentage" name="discount_percentage" 
                                       value="{{ old('discount_percentage', $paguyuban->discount_percentage ?? 0) }}" min="0" max="100"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <i class="fas fa-percentage"></i>
                                </div>
                            </div>
                            @error('discount_percentage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Custom Color -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Brand Color</label>
                            <div class="flex items-center space-x-3">
                                <input type="color" id="color" name="color" value="{{ old('color', $paguyuban->color ?? '#6366f1') }}"
                                       class="w-12 h-12 rounded-lg border border-gray-300/50 dark:border-gray-600/50 cursor-pointer">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Select a color for this community</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer with Animated Submit Button -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50/70 to-gray-100/50 dark:from-gray-700/30 dark:to-gray-800/30 border-t border-gray-200/50 dark:border-gray-700/50 text-right">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0">
                    <i class="fas fa-save mr-2 transition-transform duration-300 group-hover:scale-110"></i>
                    @isset($paguyuban) 
                        Update Community 
                    @else 
                        <span class="relative">
                            <span class="block group-hover:opacity-0 transition-opacity duration-300">Create Community</span>
                            <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-sparkles mr-2"></i> Launch Community
                            </span>
                        </span>
                    @endisset
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Toastr auto-hide
    @if($errors->any())
    setTimeout(() => {
        const toast = document.querySelector('.toastr-notification');
        if (toast) {
            toast.classList.add('animate-fade-out');
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
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
            charCount.textContent = this.value.length;
            
            // Change color when approaching limit
            if (this.value.length > 200) {
                charCount.classList.add('text-yellow-600');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.remove('text-yellow-600');
                charCount.classList.add('text-gray-500');
            }
            
            if (this.value.length > 250) {
                charCount.classList.add('text-red-600');
                charCount.classList.remove('text-yellow-600');
            } else if (this.value.length <= 200) {
                charCount.classList.remove('text-red-600');
            }
        });
    }

    // Alpine.js initialization for collapsible section
    document.addEventListener('alpine:init', () => {
        Alpine.data('expanded', () => ({
            expanded: false
        }));
    });
</script>
@endpush

<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    
    .animate-fade-out {
        animation: fadeOut 0.3s ease-in forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(20px);
        }
    }

    /* Custom checkbox styling */
    input[type="checkbox"]:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
    }

    /* Smooth transitions for collapsible content */
    [x-cloak] { display: none !important; }
</style>
@endsection