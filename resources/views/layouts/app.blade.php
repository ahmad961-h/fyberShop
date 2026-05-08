<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FyberShop – Modern E-commerce')</title>

    <meta name="description"
        content="@yield('meta_description', 'Discover modern products with transparent pricing and fast checkout.')">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">


    <title>{{ config('app.name', 'FyberShop') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Your compiled assets (keep them too) --}}
    @livewireStyles

    <style>
        .page-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            opacity: 0.12;
            pointer-events: none;
        }

        .page-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .page-bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom right,
                    rgba(238, 242, 255, 0.85),
                    rgba(255, 255, 255, 0.95),
                    rgba(226, 252, 236, 0.9));
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-50 to-white text-slate-900 antialiased flex flex-col min-h-screen pt-[74px] overflow-x-hidden relative">
    <div class="page-bg">
        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
            alt="Background">
        <div class="page-bg-overlay"></div>
    </div>

    <livewire:navbar />

    <main class="flex-grow relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <x-footer />

    @livewireScripts
</body>

</html>