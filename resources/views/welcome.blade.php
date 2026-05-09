<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Discover premium products at FyberShop – your go-to for modern essentials." />
    <title>{{ config('app.name', 'FyberShop') }} – Modern E-commerce Experience</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @livewireStyles

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp .6s ease-out forwards;
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 2000px 100%;
            animation: shimmer 2s infinite;
        }

        .gradient-mesh {
            background:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, .15), transparent 50%),
                radial-gradient(at 100% 0%, rgba(139, 92, 246, .15), transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, .15), transparent 50%),
                radial-gradient(at 0% 100%, rgba(59, 130, 246, .15), transparent 50%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, .7);
            backdrop-filter: blur(10px);
        }

        .product-card {
            transition: all .4s cubic-bezier(.4, 0, .2, 1);
        }

        .product-card:hover {
            transform: translateY(-8px) scale(1.02);
        }

        .hero-image {
            transition: transform .8s cubic-bezier(.4, 0, .2, 1);
        }

        .hero-image:hover {
            transform: scale(1.05) rotate(1deg);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-900 antialiased overflow-x-hidden">

    <div class="fixed inset-x-0 top-0 z-50 glass-effect shadow-lg border-b border-slate-200/50">
        <livewire:navbar />
    </div>

    <main class="pt-[80px] relative">

        <section class="relative border-b border-slate-200/50 overflow-hidden">
            <div class="absolute inset-0 gradient-mesh opacity-60"></div>

            <div class="hidden lg:block absolute top-20 left-10 w-72 h-72 bg-indigo-400/20 rounded-full blur-3xl animate-float"></div>
            <div class="hidden lg:block absolute bottom-20 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float" style="animation-delay:2s"></div>
            <div class="hidden lg:block absolute top-1/2 left-1/2 w-64 h-64 bg-purple-400/20 rounded-full blur-3xl animate-float" style="animation-delay:4s"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">

                {{-- Left --}}
                <div class="space-y-6 animate-fade-in-up">

                    <p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider
                      text-indigo-600 bg-white/80 backdrop-blur-sm px-4 py-2
                      rounded-full shadow-sm border border-indigo-100">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative h-2 w-2 rounded-full bg-indigo-500"></span>
                        </span>
                        {{ __('messages.FyberShop') }}
                        <span class="w-1 h-1 rounded-full bg-indigo-500"></span>
                        {{ __('messages.Online Store') }}
                    </p>

                    <h1 class="text-3xl sm:text-4xl lg:text-6xl xl:text-7xl
                       font-black tracking-tight text-slate-900 leading-[1.1]">
                        <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-emerald-600
                             bg-clip-text text-transparent">
                            {{ __('messages.welcome') }}
                        </span>
                    </h1>

                    <p class="text-slate-600 text-base sm:text-lg max-w-xl leading-relaxed">
                        {{ __('messages.Hero description') }}
                    </p>

                    <div class="flex flex-wrap gap-3 text-sm text-slate-700">
                        <span class="flex items-center gap-2 px-4 py-2 rounded-full
                             bg-emerald-50/80 backdrop-blur-sm border border-emerald-100 shadow-sm">
                            <span class="h-7 w-7 flex items-center justify-center rounded-full
                                 bg-emerald-500 text-white font-bold text-xs shadow-md">✓</span>
                            <span class="font-medium">{{ __('messages.Verified products') }}</span>
                        </span>

                        <span class="flex items-center gap-2 px-4 py-2 rounded-full
                             bg-indigo-50/80 backdrop-blur-sm border border-indigo-100 shadow-sm">
                            <span class="h-7 w-7 flex items-center justify-center rounded-full
                                 bg-indigo-500 text-white font-bold text-xs shadow-md">€</span>
                            <span class="font-medium">{{ __('messages.Pricing in EUR') }}</span>
                        </span>

                        <span class="flex items-center gap-2 px-4 py-2 rounded-full
                             bg-amber-50/80 backdrop-blur-sm border border-amber-100 shadow-sm">
                            <span class="h-7 w-7 flex items-center justify-center rounded-full
                                 bg-amber-500 text-white font-bold text-xs shadow-md">★</span>
                            <span class="font-medium">{{ __('messages.Quality-focused') }}</span>
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4">
                        <a href="#featured-products"
                            class="group relative inline-flex items-center justify-center
                          rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-emerald-600
                          px-8 py-4 text-sm font-bold text-white
                          shadow-xl hover:shadow-2xl hover:scale-105
                          transition-all duration-300 overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r
                                 from-indigo-700 via-purple-700 to-emerald-700
                                 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <span class="relative flex items-center gap-2">
                                {{ __('messages.Featured Products') }}
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </a>

                        <a href="#all-products"
                            class="inline-flex items-center justify-center rounded-2xl
                          border-2 border-slate-300 bg-white/80 backdrop-blur-sm
                          px-7 py-4 text-sm font-semibold text-slate-800
                          hover:bg-white hover:border-slate-400 hover:shadow-lg
                          transition-all duration-300">
                            {{ __('messages.Browse all products') }}
                        </a>
                    </div>
                </div>

                {{-- Right: HERO PRODUCT --}}
                <div class="relative animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="absolute -inset-6 rounded-3xl bg-gradient-to-tr from-indigo-500/20 via-purple-500/15 to-emerald-500/20 blur-3xl animate-pulse"></div>
                    <div class="absolute -inset-4 rounded-3xl bg-gradient-to-br from-indigo-400/10 via-emerald-400/10 to-purple-400/10"></div>

                    @if($heroProduct)
                    @php
                    $heroImage = $heroProduct->images->first();
                    @endphp

                    <div class="relative bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-slate-200/50 overflow-hidden group">

                        {{-- IMAGE (ONCE ONLY) --}}
                        <div class="relative aspect-[4/3] w-full bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
                            @if($heroImage && $heroImage->path)
                            <img
                                src="{{ asset('fyberShop/public/storage/' . $heroImage->path) }}"
                                alt="{{ $heroProduct->name }}"
                                loading="eager"
                                decoding="async"
                                class="hero-image w-full h-full object-cover group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                {{ __('messages.No image available') }}
                            </div>
                            @endif
                            {{-- Badge overlay --}}
                            <div class="absolute top-4 right-4 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm shadow-lg border border-slate-200">
                                <span class="text-xs font-bold text-indigo-600">
                                    {{ __('messages.Featured') }}
                                </span>
                            </div>
                        </div>

                        {{-- INFO --}}
                        <div class="p-4 sm:p-6 lg:p-8 space-y-4 bg-gradient-to-b from-white to-slate-50/50">
                            <div class="flex justify-between items-start gap-3">
                                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 leading-tight">
                                    {{ $heroProduct->name }}
                                </h3>

                                <div class="flex flex-col items-end">
                                    <span class="text-2xl sm:text-3xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        €{{ number_format($heroProduct->price, 2) }}
                                    </span>
                                </div>
                            </div>

                            <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($heroProduct->description, 110) }}
                            </p>

                            <div class="flex flex-wrap gap-3 pt-2">
                                <a href="{{ route('products.show', $heroProduct) }}"
                                    class="group flex-1 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                    {{ __('messages.Explore Product') }}
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                @auth
                                <div class="flex-1">
                                    @livewire('add-to-cart-button', [
                                    'productId' => $heroProduct->id,
                                    'productName' => $heroProduct->name,
                                    'productPrice' => $heroProduct->price,
                                    ], 'hero-'.$heroProduct->id)
                                </div>
                                @else
                                <a href="{{ route('login') }}"
                                    class="flex-1 inline-flex items-center justify-center rounded-xl border-2 border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-800 hover:border-slate-400 hover:bg-slate-50 transition-all duration-300">
                                    {{ __('messages.Login to Add to Cart') }}
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="relative bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <p class="text-slate-600 font-medium">
                            {{ __('messages.No products available') }}
                        </p>
                    </div>
                    @endif
                </div>

            </div>
        </section>



        {{-- CATEGORY STRIP (simple, based on product categories) --}}

        @if($allCategories->count() > 0)
        <section
            class="relative border-b border-slate-200/50
           bg-gradient-to-r from-white via-slate-50 to-white
           overflow-hidden">

            <div class="absolute inset-0
                bg-gradient-to-r from-indigo-50/30 via-transparent to-emerald-50/30"></div>

            <div
                class="relative max-w-7xl mx-auto
               px-5 sm:px-8 lg:px-12
               py-8 sm:py-10 lg:py-12
               flex flex-col gap-5
               md:flex-row md:items-center md:justify-between">

                {{-- Title --}}
                <div class="flex items-center gap-3 sm:gap-4">
                    <div
                        class="h-8 sm:h-10 w-1
                       rounded-full
                       bg-gradient-to-b from-indigo-500 to-purple-500">
                    </div>

                    <h2
                        class="text-sm sm:text-base
                       font-bold text-slate-900
                       tracking-tight">
                        {{ app()->getLocale() === 'bg'
                    ? 'Пазарувай по категории'
                    : 'Shop by category' }}
                    </h2>
                </div>

                {{-- Categories --}}
                <div
                    class="flex flex-wrap
                    sm:gap-2.5 lg:gap-3">

                    @foreach($allCategories as $cat)
                    <a href="{{ url('/category/'.$cat->slug) }}"
                        class="group inline-flex items-center gap-1.5 sm:gap-2
      rounded-full
      border-2 border-slate-200
      bg-white/80 backdrop-blur-sm
      px-3 sm:px-4
      py-1.5 sm:py-2
      text-xs sm:text-sm
      font-semibold text-slate-700
      hover:bg-gradient-to-r
      hover:from-indigo-50 hover:to-purple-50
      hover:border-indigo-300 hover:text-indigo-700
      hover:shadow-md hover:scale-105
      transition-all duration-300">

                        <span class="whitespace-nowrap">
                            {{ $cat->name }}
                        </span>

                        <svg
                            class="w-3 h-3
           opacity-0
           group-hover:opacity-100
           group-hover:translate-x-1
           transition-all"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    @endforeach

                </div>
            </div>
        </section>

        @endif

        {{-- FEATURED PRODUCTS --}}
        <section id="featured-products"
            class="relative bg-gradient-to-b from-white via-slate-50 to-white
           py-14 sm:py-18 lg:py-28 overflow-hidden">

            <div class="absolute top-0 left-0 w-full h-px
                bg-gradient-to-r from-transparent via-indigo-300 to-transparent"></div>

            <div class="max-w-7xl mx-auto
                px-5 sm:px-8 lg:px-12">

                {{-- Header --}}
                <div class="flex flex-col gap-3 sm:gap-4
                    mb-12 sm:mb-16 lg:mb-20">

                    <div class="inline-flex items-center gap-2
                        px-3 sm:px-4 py-1 sm:py-1.5
                        rounded-full bg-indigo-100 text-indigo-700
                        text-[11px] sm:text-xs
                        font-bold uppercase tracking-wider w-fit">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        {{ __('messages.Featured Products') }}
                    </div>

                    <h2 class="text-2xl sm:text-3xl lg:text-5xl
                       font-black text-slate-900 leading-tight">
                        {{ __('messages.Featured Products') }}
                    </h2>

                    <p class="text-sm sm:text-base text-slate-600 max-w-2xl">
                        {{ app()->getLocale() === 'bg'
                    ? 'Най-популярните и внимателно подбрани продукти.'
                    : 'Most popular and carefully curated picks.' }}
                    </p>
                </div>

                {{-- Products --}}
                @if($products->count() > 0)
                <div id="all-products"
                    class="grid grid-cols-2
                    md:grid-cols-3
                    lg:grid-cols-4
                    gap-4 sm:gap-6 lg:gap-10">

                    @foreach($products as $product)
                    <div
                        class="product-card group bg-white
                       rounded-3xl
                       border-2 border-slate-200/50
                       shadow-lg hover:shadow-2xl
                       overflow-hidden
                       flex flex-col h-full
                       backdrop-blur-sm">

                        {{-- Image --}}
                        <div
                            class="relative aspect-[4/3]
                           overflow-hidden
                           bg-gradient-to-br from-slate-100 to-slate-200
                           group-hover:from-slate-200 group-hover:to-slate-300
                           transition-colors duration-300">

                            @php
                            $mainImage = $product->images->whereNotNull('path')->first();
                            @endphp

                            @if($mainImage)
                            <img
                                src="{{ asset('fyberShop/public/storage/' . $mainImage->path) }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover
                                group-hover:scale-110
                                transition-transform duration-500">

                            <div
                                class="absolute inset-0
                                   bg-gradient-to-t from-black/40 via-transparent to-transparent
                                   opacity-0 group-hover:opacity-100
                                   transition-opacity duration-500"></div>
                            @else
                            <div class="w-full h-full flex items-center justify-center
                                    text-slate-400 text-xs">
                                {{ __('messages.No image available') }}
                            </div>
                            @endif

                            {{-- Price --}}
                            <div
                                class="absolute bottom-4 sm:bottom-5 left-4 sm:left-5
                               rounded-xl
                               bg-gradient-to-r from-indigo-600 to-purple-600
                               text-white px-3 sm:px-4 py-1.5 sm:py-2
                               text-xs sm:text-sm font-black
                               shadow-xl backdrop-blur-sm
                               border border-white/20">
                                €{{ number_format($product->price, 2) }}
                            </div>
                        </div>

                        {{-- Content --}}
                        <div
                            class="p-4 sm:p-6 lg:p-7
                           flex flex-col flex-1
                           bg-gradient-to-b from-white to-slate-50/50">

                            {{-- Title --}}
                            <h3
                                class="text-sm sm:text-base lg:text-lg
                               font-bold text-slate-900
                               leading-snug
                               line-clamp-2
                               mb-3 sm:mb-4
                               group-hover:text-indigo-700
                               transition-colors">
                                {{ $product->name }}
                            </h3>

                            {{-- Categories --}}
                            <div
                                class="mb-4 sm:mb-5
                               flex flex-wrap gap-1.5 sm:gap-2
                               min-h-[1.75rem] sm:min-h-[2rem]">
                                @forelse($product->categories as $cat)
                                <a href="{{ route('categories.show', $cat) }}"
                                    class="inline-flex items-center
                                      rounded-full
                                      bg-gradient-to-r from-indigo-50 to-purple-50
                                      px-2.5 sm:px-3 py-1
                                      text-[11px] sm:text-xs
                                      font-semibold text-indigo-700
                                      border border-indigo-100
                                      hover:scale-105
                                      transition-all">
                                    {{ $cat->name }}
                                </a>
                                @empty
                                <span class="text-xs text-slate-400">
                                    {{ app()->getLocale() === 'bg' ? 'Без категория' : 'Uncategorized' }}
                                </span>
                                @endforelse
                            </div>

                            {{-- Description --}}
                            <p
                                class="text-xs sm:text-sm text-slate-600
                               leading-relaxed
                               line-clamp-3
                               mb-5 sm:mb-6">
                                {{ \Illuminate\Support\Str::limit($product->description, 120) }}
                            </p>

                            {{-- Actions --}}
                            <div class="mt-auto flex flex-col gap-3 sm:gap-4 pt-1 sm:pt-2">

                                <a href="{{ route('products.show', $product) }}"
                                    class="group w-full inline-flex items-center justify-center
                                  rounded-xl
                                  bg-gradient-to-r from-slate-900 to-slate-800
                                  text-white
                                  text-xs sm:text-sm font-bold
                                  py-3 sm:py-3.5
                                  hover:shadow-xl hover:scale-[1.02]
                                  transition-all duration-300">
                                    {{ __('messages.View Details') }}
                                    <svg
                                        class="w-4 h-4 ml-2
                                       group-hover:translate-x-1
                                       transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                @auth
                                <div class="w-full">
                                    @livewire('add-to-cart-button', [
                                    'productId' => $product->id,
                                    'productName' => $product->name,
                                    'productPrice' => $product->price,
                                    ], 'product-'.$product->id)
                                </div>
                                @else
                                <a href="{{ route('login') }}"
                                    class="w-full inline-flex items-center justify-center
                                      rounded-xl
                                      border-2 border-emerald-500
                                      bg-emerald-50
                                      text-emerald-700
                                      text-xs sm:text-sm font-bold
                                      py-3 sm:py-3.5
                                      hover:shadow-lg hover:scale-[1.02]
                                      transition-all duration-300">
                                    {{ __('messages.Login to Add to Cart') }}
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
        {{-- Pagination --}}
        @if ($products->hasPages())
        <div class="mt-14 sm:mt-18 flex items-center justify-center gap-3">

            {{-- Previous --}}
            @if ($products->onFirstPage())
            <span
                class="inline-flex items-center justify-center
                   w-11 h-11 rounded-full
                   border border-slate-200
                   bg-slate-100 text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>
            </span>
            @else
            <a href="{{ $products->previousPageUrl() }}"
                class="inline-flex items-center justify-center
                  w-11 h-11 rounded-full
                  border border-slate-300
                  bg-white text-slate-700
                  shadow-sm
                  hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600
                  hover:text-white hover:border-transparent
                  transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            @endif

            {{-- Page Indicator --}}
            <div
                class="px-4 py-2 rounded-full
               bg-gradient-to-r from-indigo-50 to-purple-50
               text-xs sm:text-sm font-bold text-slate-700
               border border-indigo-100">
                {{ $products->currentPage() }} / {{ $products->lastPage() }}
            </div>

            {{-- Next --}}
            @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}"
                class="inline-flex items-center justify-center
                  w-11 h-11 rounded-full
                  border border-slate-300
                  bg-white text-slate-700
                  shadow-sm
                  hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600
                  hover:text-white hover:border-transparent
                  transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </a>
            @else
            <span
                class="inline-flex items-center justify-center
                   w-11 h-11 rounded-full
                   border border-slate-200
                   bg-slate-100 text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </span>
            @endif

        </div>
        @endif


        {{-- BENEFITS SECTION --}}
        <section class="relative border-t border-slate-200/50 bg-gradient-to-b from-white to-slate-50 py-16 lg:py-20 overflow-hidden">
            <div class="absolute inset-0 gradient-mesh opacity-30"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mb-3">
                        {{ app()->getLocale() === 'bg' ? 'Защо да изберете нас?' : 'Why Choose Us?' }}
                    </h2>
                    <p class="text-slate-600 max-w-2xl mx-auto">
                        {{ app()->getLocale() === 'bg'
                            ? 'Осигуряваме най-доброто изживяване за нашите клиенти.'
                            : 'We ensure the best experience for our customers.' }}
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl border-2 border-slate-200/50 p-6 hover:border-indigo-300 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="absolute -top-4 left-6">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xl font-black shadow-lg group-hover:scale-110 transition-transform">
                                ✓
                            </div>
                        </div>
                        <div class="pt-4">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">
                                {{ app()->getLocale() === 'bg' ? 'Надеждно изживяване' : 'Reliable experience' }}
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ app()->getLocale() === 'bg'
                                    ? 'Модерен интерфейс, ясен процес на поръчка и фокус върху удобството.'
                                    : 'Modern interface, clear checkout flow, and focus on convenience.' }}
                            </p>
                        </div>
                    </div>

                    <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl border-2 border-slate-200/50 p-6 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="absolute -top-4 left-6">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xl font-black shadow-lg group-hover:scale-110 transition-transform">
                                €
                            </div>
                        </div>
                        <div class="pt-4">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">
                                {{ app()->getLocale() === 'bg' ? 'Прозрачни цени' : 'Transparent pricing' }}
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ app()->getLocale() === 'bg'
                                    ? 'Цени в евро и левове, без скрити такси.'
                                    : 'Prices in EUR, with no hidden fees.' }}
                            </p>
                        </div>
                    </div>

                    <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl border-2 border-slate-200/50 p-6 hover:border-amber-300 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="absolute -top-4 left-6">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xl font-black shadow-lg group-hover:scale-110 transition-transform">
                                ⚡
                            </div>
                        </div>
                        <div class="pt-4">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">
                                {{ app()->getLocale() === 'bg' ? 'Бързо пазаруване' : 'Fast shopping' }}
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ app()->getLocale() === 'bg'
                                    ? 'Добавете в количката за секунди и завършете поръчката без излишни стъпки.'
                                    : 'Add to cart in seconds and complete your order with minimal friction.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <x-footer />

    @livewireScripts

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const productCards = document.querySelectorAll('.product-card');

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, observerInstance) => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;

                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observerInstance.unobserve(entry.target);
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            productCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition =
                    `opacity 0.6s ease-out ${index * 0.06}s, transform 0.6s ease-out ${index * 0.06}s`;

                observer.observe(card);
            });
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', event => {
                const href = anchor.getAttribute('href');

                if (!href || href === '#') return;

                const target = document.querySelector(href);

                if (!target) return;

                event.preventDefault();

                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    });
</script>
</body>

</html>