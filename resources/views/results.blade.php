@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
            {{ __('messages.Search results for') }}
        </h1>
        <p class="mt-2 text-sm text-slate-600">
            “{{ $query }}”
        </p>
    </div>

    @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product->id) }}"
                    class="group bg-white/90 backdrop-blur-sm rounded-3xl border-2 border-slate-200/50 shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-300 hover:scale-[1.02] no-underline">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                        @php
    $mainImage = $product->images->first();
@endphp

<img
    src="{{ $mainImage ? asset('storage/' . $mainImage->path) : 'https://via.placeholder.com/600x450' }}"
    alt="{{ $product->name }}"
    loading="lazy"
    decoding="async"
    class="w-full h-full object-cover
    group-hover:scale-110
    transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute bottom-4 left-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 text-sm font-black shadow-xl">
                            €{{ number_format($product->price, 2) }}
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 bg-gradient-to-b from-white to-slate-50/50">
                        <h3 class="font-bold text-slate-900 line-clamp-2 group-hover:text-indigo-700 transition-colors">
                            {{ $product->name }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($product->description ?? '', 90) }}
                        </p>
                        <div class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-slate-900">
                            {{ __('messages.View Details') }}
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links('pagination::tailwind') }}
        </div>
    @else
        <div class="rounded-3xl border border-slate-100 bg-white/90 backdrop-blur-sm shadow-xl px-6 py-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-slate-100 mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 10l-6 6m0 0l6 6m-6-6h18"></path>
                </svg>
            </div>
            <p class="text-lg font-bold text-slate-900">
                {{ __('messages.No products found') }}
            </p>
            <p class="text-sm text-slate-600 mt-2">
                {{ __('messages.Try a different search term') }}
            </p>
        </div>
    @endif
</div>
@endsection