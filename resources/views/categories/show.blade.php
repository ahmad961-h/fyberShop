@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900">
            {{ $category->name }}
        </h1>

        @if($products->count())
        <p class="mt-2 text-sm text-slate-600">
            {{ $products->total() }}
            {{ __('messages.Product') }}{{ $products->total() !== 1 ? __('messages.s') : '' }}
            {{ __('messages.in this category') }}
        </p>
        @endif
    </div>

    @if ($products->count())
    {{-- Products grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="glass bg-white/90 shadow-xl rounded-3xl overflow-hidden flex flex-col hover:shadow-2xl transition-transform duration-200 hover:-translate-y-1">

            {{-- Image --}}
            @php
            $mainImage = $product->images->whereNotNull('path')->first();
            @endphp

            @if($mainImage)
            <img
                src="{{ asset('storage/' . $mainImage->path) }}"
                alt="{{ $product->name }}"
                class="h-48 w-full object-cover">
            @else
            <div class="h-48 w-full bg-slate-100 flex items-center justify-center text-xs font-medium text-slate-500">
                {{ __('messages.No image available') }}
            </div>
            @endif


            {{-- Info --}}
            <div class="p-4 flex flex-col flex-1">
                <h3 class="text-base sm:text-lg font-semibold text-slate-900 mb-1">
                    {{ $product->name }}
                </h3>

                <p class="text-xs text-slate-500 mb-3 flex-1 leading-relaxed">
                    {{ Str::limit($product->description, 70) }}
                </p>

                <div class="mb-4">
                    <p class="text-lg font-bold text-slate-900">
                        €{{ number_format($product->price, 2) }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="mt-auto flex flex-col gap-2">
                    <a
                        href="{{ route('products.show', $product->id) }}"
                        class="inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition no-underline">
                        {{ __('messages.View Details') }}
                    </a>

                    @auth
                    <div class="w-full">
                        @livewire('add-to-cart-button', [
                        'productId' => $product->id,
                        'productName' => $product->name,
                        'productPrice' => $product->price,
                        ], key(['cat', $product->id]))
                    </div>
                    @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-4 py-2 text-xs sm:text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50 transition no-underline">
                        {{ __('messages.Login to Add to Cart') }}
                    </a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $products->links('pagination::tailwind') }}
    </div>

    @else
    {{-- Empty state --}}
    <div class="max-w-md mx-auto glass bg-white/90 text-center px-8 py-10 rounded-3xl shadow-xl">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">
            {{ __('messages.No products available') }}
        </h2>
        <p class="text-sm text-slate-600">
            {{ __('messages.No products in category') }}
        </p>
    </div>
    @endif
</div>
@endsection