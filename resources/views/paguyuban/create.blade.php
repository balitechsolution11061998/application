@extends('pos.index')

@section('content')
<div class="w-full px-4 py-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-xl p-6 mb-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white">
                    @isset($paguyuban) Edit Paguyuban @else Create New Paguyuban @endisset
                </h1>
                <p class="text-indigo-100 mt-1 sm:mt-2 text-sm sm:text-base">
                    @isset($paguyuban) Update community details @else Add a new community group @endisset
                </p>
            </div>
            <a href="{{ route('pos.community.index') }}" class="flex items-center justify-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg shadow-md transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
        <form action="@isset($paguyuban) {{ route('pos.community.update', $paguyuban) }} @else {{ route('pos.community.store') }} @endisset" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($paguyuban) @method('PUT') @endisset

            <div class="p-6 space-y-6">
                <!-- Logo Upload -->
                <div class="flex flex-col items-center space-y-4">
                    <div class="relative">
                        <div class="h-32 w-32 rounded-full border-4 border-white dark:border-gray-700 shadow-md overflow-hidden bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                            @isset($paguyuban->logo)
                                <img id="logoPreview" src="{{ asset('storage/'.$paguyuban->logo) }}" alt="Paguyuban Logo" class="h-full w-full object-cover">
                            @else
                                <div id="logoPlaceholder" class="text-indigo-500 dark:text-indigo-300 text-5xl">
                                    <i class="fas fa-users"></i>
                                </div>
                            @endisset
                        </div>
                        <label for="logo" class="absolute bottom-0 right-0 bg-white dark:bg-gray-700 rounded-full p-2 shadow-md cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            <i class="fas fa-camera text-indigo-600 dark:text-indigo-300"></i>
                            <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Upload a logo (max 2MB)</p>
                </div>

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $paguyuban->name ?? '') }}" required
                        class="block w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="block w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg bg-white/70 dark:bg-gray-700/50 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all duration-200">{{ old('description', $paguyuban->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Field -->
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            @checked(old('is_active', isset($paguyuban) ? $paguyuban->is_active : true))>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50/70 dark:bg-gray-700/30 border-t border-gray-200/50 dark:border-gray-700/50 text-right">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>
                    @isset($paguyuban) Update Paguyuban @else Create Paguyuban @endisset
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview logo when selected
    document.getElementById('logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('logoPreview');
                const placeholder = document.getElementById('logoPlaceholder');
                
                if (preview) {
                    preview.src = event.target.result;
                } else if (placeholder) {
                    placeholder.innerHTML = `<img src="${event.target.result}" class="h-full w-full object-cover">`;
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection