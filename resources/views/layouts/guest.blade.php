<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'fybershop') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans text-slate-900 antialiased bg-gradient-to-br from-indigo-50 to-white overflow-x-hidden">

    {{-- Page content --}}
    <main class="pt-20 min-h-screen flex items-center justify-center">
        <div class="w-full sm:max-w-md px-6">
            <div class="rounded-3xl bg-white/90 backdrop-blur-sm border border-slate-100 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.25)] overflow-hidden">
                <div class="px-6 py-6 text-center bg-gradient-to-b from-slate-900 to-slate-800">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-300">{{ config('app.name', 'FyberShop') }}</p>
                </div>
                <div class="px-6 py-6">
            {{ $slot }}
                </div>
            </div>
        </div>
    </main>

    @livewireScripts
</body>

</html>