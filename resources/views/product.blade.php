@extends('layouts.app')
@section('title', $product->name . ' | FyberShop')
@section('meta_description', \Illuminate\Support\Str::limit($product->description, 155))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">{{ __('messages.Home') }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            @if ($product->categories->isNotEmpty())
                <a href="{{ route('categories.show', $product->categories->first()) }}"
                    class="hover:text-indigo-600 transition-colors">
                    {{ $product->categories->first()->name }}
                </a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            @endif
            <span class="text-slate-900 font-medium">{{ $product->name }}</span>
        </nav>

        {{-- Main product card --}}
        <section
            class="relative bg-white/95 backdrop-blur-sm border-2 border-slate-200/50 shadow-2xl rounded-3xl px-6 py-8 sm:px-10 sm:py-10 overflow-hidden">
            {{-- Decorative background --}}
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-100/30 via-purple-100/20 to-emerald-100/30 rounded-full blur-3xl -z-0">
            </div>

            <div class="relative flex flex-col lg:flex-row gap-10 lg:gap-12 z-10">

                {{-- IMAGE GALLERY --}}
                <div class="lg:w-1/2 space-y-4">
                    @php
                        $images = $product->images;
                        $mainImage = $images->first();
                    @endphp

                    {{-- MAIN IMAGE --}}
                    <div
                        class="relative group aspect-[4/3] w-full overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl shadow-xl border-2 border-slate-200/50">
                        @if ($mainImage && $mainImage->path)
                            <img id="main-product-image" src="{{ asset('fyberShop/public/storage/' . $mainImage->path) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            {{-- Zoom indicator --}}
                            <div
                                class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        @else
                            <div class="h-full w-full flex items-center justify-center text-slate-500 text-sm">
                                {{ __('messages.No image available') }}
                            </div>
                        @endif
                    </div>

                    {{-- THUMBNAILS --}}
                    @if ($images->count() > 1)
                        <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                            @foreach ($images as $index => $img)
                                <button type="button"
                                    onclick="changeMainImage('{{ asset('storage/' . $img->path) }}', this)"
                                    class="thumbnail-btn aspect-square rounded-xl overflow-hidden border-2 border-slate-200
                           hover:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                           transition-all duration-300 hover:scale-105 hover:shadow-lg {{ $index === 0 ? 'border-indigo-500 ring-2 ring-indigo-200' : '' }}">
                                    <img src="{{ asset('fyberShop/public/storage/' . $mainImage->path) }}"
                                        alt="{{ $product->name }}" class="h-full w-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>


                {{-- INFO --}}
                <div class="lg:w-1/2 flex flex-col justify-between gap-8">
                    <div class="space-y-6">
                        {{-- Badge --}}
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                            {{ __('messages.Product') }}
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-tight">
                            {{ $product->name }}
                        </h1>

                        {{-- Categories --}}
                        <div class="flex flex-wrap gap-2">
                            @forelse($product->categories as $cat)
                                <a href="{{ route('categories.show', $cat) }}"
                                    class="inline-flex items-center gap-1.5 rounded-full border-2 border-indigo-200 bg-gradient-to-r from-indigo-50 to-purple-50 px-4 py-1.5 text-xs font-bold text-indigo-700 hover:from-indigo-100 hover:to-purple-100 hover:border-indigo-300 hover:scale-105 transition-all duration-300">
                                    @if ($cat->icon_svg)
                                        <span class="w-3 h-3">{!! $cat->icon_svg !!}</span>
                                    @endif
                                    {{ $cat->name }}
                                </a>
                            @empty
                                <span class="text-xs text-slate-500 px-3 py-1.5">
                                    {{ __('messages.Uncategorized') }}
                                </span>
                            @endforelse
                        </div>

                        {{-- Price --}}
                        <div
                            class="p-6 rounded-2xl bg-gradient-to-br from-indigo-50 via-purple-50 to-emerald-50 border-2 border-indigo-100">
                            <div class="flex items-baseline gap-3 mb-2">
                                <p
                                    class="text-4xl sm:text-5xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    €{{ number_format($product->price, 2) }}
                                </p>
                            </div>

                            @if (($product->delivery_fee ?? 0) > 0)
                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>+ €{{ number_format($product->delivery_fee, 2) }}
                                        {{ __('messages.Delivery') }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-sm font-semibold text-emerald-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Description --}}
                        <div class="prose prose-slate max-w-none">
                            <p class="text-base sm:text-lg leading-relaxed text-slate-700">
                                {{ $product->description }}
                            </p>
                        </div>

                        @if ($isAdmin)
                            <div class="p-4 rounded-xl bg-amber-50 border-2 border-amber-200">
                                <p class="text-sm font-semibold text-amber-900">
                                    <span class="font-bold">{{ __('messages.Stock') }}:</span>
                                    <span class="text-lg">{{ $product->stock }}</span>
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- ACTIONS --}}
                    <div class="space-y-4 pt-6 border-t-2 border-slate-200">
                        <div class="flex flex-col sm:flex-row gap-3">
                            @auth
                                <div class="flex-1">
                                    @livewire(
                                        'add-to-cart-button',
                                        [
                                            'productId' => $product->id,
                                            'productName' => $product->name,
                                            'productPrice' => $product->price,
                                            'deliveryFee' => $product->delivery_fee ?? 0,
                                        ],
                                        'product-' . $product->id
                                    )
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="group flex-1 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-slate-900 to-slate-800 px-6 py-4 text-sm font-bold text-white hover:from-slate-800 hover:to-slate-700 hover:shadow-xl transition-all duration-300 hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    {{ __('messages.Login to Add to Cart') }}
                                </a>
                            @endauth

                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center rounded-xl border-2 border-slate-300 bg-white px-6 py-4 text-sm font-semibold text-slate-900 hover:bg-slate-50 hover:border-slate-400 hover:shadow-lg transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('messages.Back to shop') }}
                            </a>
                        </div>

                        @if ($isAdmin)
                            <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-200">
                                <a href="{{ route('products.edit', $product) }}"
                                    class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3 text-sm font-bold text-white hover:from-indigo-700 hover:to-purple-700 hover:shadow-lg transition-all duration-300 hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    {{ __('messages.Edit product') }}
                                </a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('{{ __('messages.Delete this product?') }}')"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-rose-500 to-red-600 px-5 py-3 text-sm font-bold text-white hover:from-rose-600 hover:to-red-700 hover:shadow-lg transition-all duration-300 hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        {{ __('messages.Delete product') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- RELATED PRODUCTS --}}
        @if ($relatedProducts->isNotEmpty())
            <section class="mt-16 lg:mt-20">
                <div class="text-center mb-10">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        {{ __('messages.Related Products') }}
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mb-3">
                        {{ __('messages.You Might Also Like') }}
                    </h2>
                    <p class="text-slate-600 max-w-2xl mx-auto">
                        {{ app()->getLocale() === 'bg'
                            ? 'Открийте подобни продукти, които може да ви заинтересуват.'
                            : 'Discover similar products you might be interested in.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
                    @foreach ($relatedProducts as $rel)
                        @php
                            $relImage = $rel->images->first();
                        @endphp

                        <div
                            class="group product-card bg-white rounded-3xl border-2 border-slate-200/50 shadow-lg hover:shadow-2xl overflow-hidden flex flex-col backdrop-blur-sm transition-all duration-300 hover:scale-105">
                            <div
                                class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                                @if ($relImage && $relImage->path)
                                    <img src="{{ asset('fyberShop/public/storage/' . $relImage->path) }}"
                                        alt="{{ $rel->name }}"
                                        class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    </div>
                                @else
                                    <div class="h-full flex items-center justify-center text-xs text-slate-400">
                                        {{ __('messages.No image available') }}
                                    </div>
                                @endif

                                {{-- Price badge --}}
                                <div
                                    class="absolute bottom-3 left-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-1.5 text-sm font-black shadow-xl">
                                    €{{ number_format($rel->price, 2) }}
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-1 bg-gradient-to-b from-white to-slate-50/50">
                                <h3
                                    class="text-base font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-indigo-700 transition-colors">
                                    {{ $rel->name }}
                                </h3>

                                <a href="{{ route('products.show', $rel) }}"
                                    class="mt-auto group/btn inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-slate-900 to-slate-800 px-4 py-2.5 text-sm font-bold text-white hover:from-slate-800 hover:to-slate-700 hover:shadow-xl transition-all duration-300">
                                    {{ __('messages.View Details') }}
                                    <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <script>
        function changeMainImage(src, element) {
            // Update main image
            const mainImage = document.getElementById('main-product-image');
            if (mainImage) {
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = src;
                    mainImage.style.opacity = '1';
                }, 150);
            }

            // Update active thumbnail
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-200');
                btn.classList.add('border-slate-200');
            });
            element.classList.remove('border-slate-200');
            element.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-200');
        }

        // Image zoom on click
        document.addEventListener('DOMContentLoaded', () => {
            const mainImage = document.getElementById('main-product-image');
            if (mainImage) {
                mainImage.addEventListener('click', function() {
                    const modal = document.createElement('div');
                    modal.className =
                        'fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm';
                    modal.innerHTML = `
                    <div class="relative max-w-5xl max-h-[90vh] p-4">
                        <img src="${this.src}" alt="${this.alt}" class="max-w-full max-h-[90vh] object-contain rounded-lg">
                        <button onclick="this.closest('.fixed').remove()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-slate-900 hover:bg-white transition-colors shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                    document.body.appendChild(modal);
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            modal.remove();
                        }
                    });
                });
                mainImage.style.cursor = 'zoom-in';
            }

            // Animate product cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.product-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(card);
            });
        });
    </script>

    <style>
        #main-product-image {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
@endsection
