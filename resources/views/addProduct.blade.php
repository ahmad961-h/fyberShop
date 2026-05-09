@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

        {{-- Header --}}
        <div class="mb-10 text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                {{ __('messages.Admin Panel') }}
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 mb-3">
                {{ __('messages.Product & Category Management') }}
            </h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">
                {{ __('messages.Product & Category subtitle') }}
            </p>
        </div>

        {{-- Category section --}}
        <div
            class="mb-10 rounded-3xl border-2 border-slate-200/50 bg-white/95 backdrop-blur-sm shadow-2xl px-6 py-8 sm:px-8 sm:py-10 overflow-hidden relative">
            {{-- Decorative background --}}
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-indigo-100/30 via-purple-100/20 to-emerald-100/30 rounded-full blur-3xl -z-0">
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div
                        class="h-10 w-10 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900">
                        {{ __('messages.Manage categories') }}
                    </h2>
                </div>

                {{-- Add category --}}
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                    class="flex flex-col sm:flex-row gap-3 mb-6">
                    @csrf

                    <input type="text" name="name" placeholder="{{ __('messages.New category name') }}"
                        value="{{ old('name') }}"
                        class="flex-1 rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 text-sm font-bold text-white shadow-lg hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('messages.Add Category') }}
                    </button>
                </form>

                {{-- Delete category --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <select id="delete_select"
                        class="flex-1 rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500/60 transition-all">
                        <option value="">
                            {{ __('messages.Select category to delete') }}
                        </option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <form id="delete_form" method="POST" action=""
                        data-confirm-message="{{ __('messages.Delete selected category?') }}" class="inline-block">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-rose-500 to-red-600 px-6 py-3 text-sm font-bold text-white shadow-lg hover:from-rose-600 hover:to-red-700 hover:shadow-xl transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            {{ __('messages.Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Product form --}}
        <div
            class="relative rounded-3xl border-2 border-slate-200/50 bg-white/95 backdrop-blur-sm shadow-2xl px-6 py-8 sm:px-10 sm:py-10">
            {{-- Decorative backgrounds --}}
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-100/30 via-purple-100/20 to-emerald-100/30 rounded-full blur-3xl -z-0 overflow-hidden">
            </div>
            <div
                class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-emerald-100/20 via-indigo-100/20 to-purple-100/20 rounded-full blur-3xl -z-0 overflow-hidden">
            </div>

            <div class="relative z-10">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        {{ __('messages.New Product') }}
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mb-3">
                        {{ __('messages.Add new product') }}
                    </h2>
                    <p class="text-slate-600">
                        {{ app()->getLocale() === 'bg'
                            ? 'Попълнете формата по-долу, за да добавите нов продукт'
                            : 'Fill out the form below to add a new product' }}
                    </p>
                </div>

                @if (session('success'))
                    <div
                        class="mb-6 rounded-2xl border-2 border-emerald-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-4 text-sm font-semibold text-emerald-800 text-center shadow-lg animate-fadeInUp flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6 relative" id="product-form" style="overflow: visible;">
                    @csrf

                    {{-- Product name --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-900 mb-2">
                            {{ __('messages.Product name') }}
                            <span class="text-rose-500">*</span>
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('messages.Enter product name') }}" required
                            class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
                        @error('name')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-900 mb-2">
                            {{ __('messages.Description') }}
                        </label>
                        <textarea id="description" name="description" rows="5" placeholder="{{ __('messages.Describe the product') }}"
                            class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Categories multiselect (Alpine) --}}
                    <div x-data="{
                        open: false,
                        selected: [],
                        selectedText: '{{ __('messages.selected') }}',
                        chooseText: '{{ __('messages.Choose categories') }}'
                    }" x-init="selected = Array.from(
                        document.querySelectorAll('input[name=\'categories[]\']:checked')
                    ).map(e => e.value)" class="relative z-50" style="z-index: 50;">
                        <label class="block text-sm font-bold text-slate-900 mb-2">
                            {{ __('messages.Categories') }}
                            <span class="text-rose-500">*</span>
                        </label>

                        <button type="button" @click="open = !open"
                            class="flex w-full items-center justify-between rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all hover:border-indigo-300">
                            <span
                                x-text="selected.length > 0
                ? `${selected.length} ${selectedText}`
                : chooseText"
                                :class="selected.length > 0 ? 'text-indigo-700 font-semibold' : 'text-slate-500'"></span>

                            <svg class="h-5 w-5 text-slate-500 transition-transform" :class="open ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1" x-cloak
                            class="categories-dropdown absolute z-[100] mt-2 w-full rounded-xl border-2 border-slate-200 bg-white p-4 shadow-2xl max-h-64 overflow-y-auto space-y-2"
                            style="z-index: 10000 !important;">
                            @foreach ($categories as $cat)
                                <label
                                    class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-indigo-50 transition-colors">
                                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                        @checked(collect(old('categories'))->contains($cat->id))
                                        @change="
                        selected = Array.from(
                        document.querySelectorAll('input[name=\'categories[]\']:checked')
                        ).map(e => e.value)
                        "
                                        class="h-5 w-5 rounded border-2 border-slate-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 cursor-pointer">
                                    <span class="text-sm font-medium text-slate-800">{{ $cat->name }}</span>
                                </label>
                            @endforeach
                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            {{ __('messages.Category hint') }}
                        </p>

                        @error('categories')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Price & stock --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-bold text-slate-900 mb-2">
                                {{ __('messages.Price') }}
                                <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-semibold">€</span>
                                <input id="price" type="number" step="0.01" name="price"
                                    value="{{ old('price') }}" placeholder="19.99" required
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white pl-8 pr-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
                            </div>
                            @error('price')
                                <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-bold text-slate-900 mb-2">
                                {{ __('messages.Stock quantity') }}
                            </label>
                            <input id="stock" type="number" name="stock" value="{{ old('stock') }}"
                                placeholder="50"
                                class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
                            @error('stock')
                                <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Delivery fee --}}
                    <div>
                        <label for="delivery_fee" class="block text-sm font-bold text-slate-900 mb-2">
                            {{ __('messages.Delivery fee') }}
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-semibold">€</span>
                            <input id="delivery_fee" type="number" step="0.01" min="0" name="delivery_fee"
                                value="{{ old('delivery_fee') }}" placeholder="3.50"
                                class="w-full rounded-xl border-2 border-slate-200 bg-white pl-8 pr-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
                        </div>
                        <p class="mt-2 text-xs text-slate-500">
                            {{ app()->getLocale() === 'bg' ? 'Оставете празно за безплатна доставка' : 'Leave empty for free delivery' }}
                        </p>
                        @error('delivery_fee')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Image upload --}}
                    <div>
                        <label for="images" class="block text-sm font-bold text-slate-900 mb-2">
                            {{ __('messages.Product image') }}
                        </label>
                        <div class="space-y-4">
                            <div class="relative">
                                <input type="file" name="images[]" id="images" multiple accept="image/*"
                                    onchange="previewImages(this)"
                                    class="block w-full text-sm text-slate-600
                                   file:mr-4 file:rounded-xl file:border-0 file:bg-gradient-to-r file:from-indigo-600 file:to-purple-600 file:px-6 file:py-3 file:text-sm file:font-bold file:text-white
                                   hover:file:from-indigo-700 hover:file:to-purple-700 file:transition-all file:cursor-pointer
                                   cursor-pointer">
                            </div>

                            {{-- Image preview --}}
                            <div id="image-preview" class="hidden mt-4">
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    <!-- Preview images will be inserted here -->
                                </div>
                            </div>

                            <p class="text-xs text-slate-500">
                                {{ __('messages.Image formats') }}
                            </p>
                        </div>
                        @error('images')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        @error('images.*')
                            <p class="mt-2 text-xs font-semibold text-rose-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-6 border-t-2 border-slate-200 flex justify-center">
                        <button type="submit"
                            class="group w-full sm:w-3/4 md:w-2/3 flex items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-indigo-600 via-purple-600 to-emerald-600 px-8 py-4 text-base font-bold text-white shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            {{ __('messages.Add product') }}
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Category delete form handler
        const deleteSelect = document.getElementById('delete_select');
        const deleteForm = document.getElementById('delete_form');

        if (deleteSelect && deleteForm) {
            deleteSelect.addEventListener('change', () => {
                deleteForm.action = deleteSelect.value ? `/categories/${deleteSelect.value}` : '#';
            });

            // Add confirmation dialog
            deleteForm.addEventListener('submit', function(e) {
                const confirmMessage = this.getAttribute('data-confirm-message') || 'Are you sure?';
                if (!confirm(confirmMessage)) {
                    e.preventDefault();
                    return false;
                }
            });
        }

        // Image preview function
        function previewImages(input) {
            const previewContainer = document.getElementById('image-preview');
            const gridContainer = previewContainer.querySelector('.grid') || document.createElement('div');

            if (!previewContainer.querySelector('.grid')) {
                gridContainer.className = 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4';
                previewContainer.appendChild(gridContainer);
            } else {
                gridContainer.innerHTML = '';
            }

            if (input.files && input.files.length > 0) {
                previewContainer.classList.remove('hidden');

                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview ${index + 1}" 
                             class="w-full h-32 object-cover rounded-xl border-2 border-slate-200 shadow-sm">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                            <span class="text-white text-xs font-semibold truncate px-2">${file.name}</span>
                        </div>
                    `;
                        gridContainer.appendChild(div);
                    };

                    reader.readAsDataURL(file);
                });
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        // Form validation feedback
        const productForm = document.getElementById('product-form');
        if (productForm) {
            productForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;
                    const originalHTML = submitBtn.innerHTML;
                    const loadingText = '{{ app()->getLocale() === 'bg' ? 'Добавяне...' : 'Adding...' }}';
                    submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${loadingText}
                `;

                    // Re-enable button after 5 seconds in case of error
                    setTimeout(() => {
                        if (submitBtn.disabled) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalHTML;
                        }
                    }, 5000);
                }
            });
        }

        // Animate form elements on load
        document.addEventListener('DOMContentLoaded', () => {
            const formElements = document.querySelectorAll('#product-form > div');
            formElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>

    <style>
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

        .animate-fadeInUp {
            animation: fadeInUp 0.4s ease-out;
        }

        /* Custom file input styling */
        input[type="file"]::file-selector-button {
            cursor: pointer;
        }

        /* Smooth transitions */
        #product-form>div {
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }

        /* Alpine.js x-cloak */
        [x-cloak] {
            display: none !important;
        }

        /* Ensure dropdown appears above everything */
        .categories-dropdown {
            position: absolute !important;
            z-index: 10000 !important;
        }
    </style>
@endsection
