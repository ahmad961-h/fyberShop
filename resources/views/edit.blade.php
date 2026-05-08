@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
            {{ __('messages.Edit product') }}
        </h1>
        <p class="mt-2 text-sm text-slate-600">
            {{ __('messages.Update product information') }}
        </p>
    </div>

    <div class="bg-white/90 backdrop-blur-sm border border-slate-100 shadow-2xl rounded-3xl overflow-hidden">
        {{-- Header strip --}}
        <div class="px-6 py-6 bg-gradient-to-b from-slate-900 to-slate-800">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-300">
                {{ __('messages.Product') }} #{{ $product->id }}
            </p>
            <p class="text-sm text-slate-200 mt-1">
                {{ $product->name }}
            </p>
        </div>

        {{-- Form --}}
        <form method="POST"
            action="{{ route('products.update', $product->id) }}"
            enctype="multipart/form-data"
            class="px-6 sm:px-8 py-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">
                    {{ __('messages.Product name') }}
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    required
                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">
                    {{ __('messages.Description') }}
                </label>
                <textarea
                    name="description"
                    rows="4"
                    required
                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all resize-none">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Price / Stock --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-900 mb-2">
                        {{ __('messages.Price') }} (€)
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        value="{{ old('price', $product->price) }}"
                        required
                        class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-900 mb-2">
                        {{ __('messages.Stock quantity') }}
                    </label>
                    <input
                        type="number"
                        name="stock"
                        value="{{ old('stock', $product->stock) }}"
                        required
                        class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
                </div>
            </div>

            {{-- Delivery --}}
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">
                    {{ __('messages.Delivery fee') }}
                </label>
                <input
                    type="number"
                    step="0.01"
                    name="delivery_fee"
                    value="{{ old('delivery_fee', $product->delivery_fee) }}"
                    class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 transition-all">
            </div>

            {{-- Categories --}}
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-3">
                    {{ __('messages.Categories') }}
                </label>

                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $category)
                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 rounded-full border-2 border-slate-200 bg-white px-4 py-2 hover:bg-slate-50 transition">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            @checked($product->categories->contains($category->id))
                        class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        {{ $category->name }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-sm font-bold text-slate-900 mb-2">
                    {{ __('messages.Product image') }}
                </label>
                <input
                    type="file"
                    name="image"
                    class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-gradient-to-r file:from-indigo-600 file:to-purple-600 file:px-6 file:py-3 file:text-sm file:font-bold file:text-white hover:file:from-indigo-700 hover:file:to-purple-700 file:transition-all file:cursor-pointer cursor-pointer">
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap gap-3 pt-4">
                <button
                    type="submit"
                    class="rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                    {{ __('messages.Save changes') }}
                </button>

                <a
                    href="{{ route('products.show', $product->id) }}"
                    class="rounded-2xl border-2 border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-900 shadow-sm hover:bg-slate-50 hover:shadow-md transition-all duration-300 no-underline">
                    {{ __('messages.Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection