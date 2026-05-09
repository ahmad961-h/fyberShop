@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
                {{ __('messages.Contact Us') }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">
                {{ __('messages.Choose how you want to reach us') }}
            </p>
        </div>

        <div class="space-y-6">
            {{-- Contact methods card --}}
            <div
                class="rounded-3xl border border-slate-100 bg-white/90 backdrop-blur-sm shadow-xl px-5 py-6 sm:px-7 sm:py-7">
                <div class="space-y-4">

                    {{-- Email --}}
                    <a href="mailto:thammoud2000@gmail.com?subject=Product%20Inquiry&body=Hello,%20I%20would%20like%20to%20ask%20about%20your%20products."
                        class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-900 px-4 py-3 text-sm sm:text-base font-semibold text-white shadow-md hover:bg-slate-800 transition no-underline">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 4h16v16H4V4zm0 0l8 7 8-7" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <p>{{ __('messages.Contact via Email') }}</p>
                                <p class="text-xs text-slate-200">thammoud2000@gmail.com</p>
                            </div>
                        </div>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/96170123456?text=Hello%20I%20am%20interested%20in%20your%20products"
                        target="_blank"
                        class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm sm:text-base font-semibold text-slate-900 shadow-sm hover:bg-slate-50 transition no-underline">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12.04 2C7.09 2 3.11 5.98 3.11 10.93c0 1.93.57 3.78 1.65 5.38L3 22l5.86-1.51a9.07 9.07 0 0 0 3.18.58h.01c4.95 0 8.93-3.98 8.93-8.93C20.98 5.98 17 2 12.04 2zm4.23 12.41c-.18.5-1.02.96-1.42 1-.37.03-.83.05-1.34-.08-.31-.08-.71-.23-1.23-.45-2.16-.94-3.56-3.13-3.67-3.28-.11-.15-.88-1.18-.88-2.25 0-1.07.56-1.59.76-1.81.2-.22.44-.27.59-.27h.43c.14 0 .33-.05.52.39.19.44.64 1.55.69 1.66.06.11.09.23.02.38-.07.15-.1.23-.21.35-.11.12-.22.27-.31.36-.1.1-.2.21-.08.41.11.2.51.84 1.09 1.37.76.68 1.4.89 1.6.99.2.1.32.08.44-.05.12-.13.51-.58.64-.78.13-.2.27-.17.46-.1.19.07 1.21.57 1.42.67.2.1.34.15.39.23.05.08.05.47-.13.97z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <p>{{ __('messages.Contact via Whatsapp') }}</p>
                                <p class="text-xs text-slate-500">+961 70 123 456</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
