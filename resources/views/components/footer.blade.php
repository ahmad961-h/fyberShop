<div>
    <footer
        class="relative mt-auto border-t border-slate-200/50
               bg-white/95 backdrop-blur-md shadow-inner overflow-hidden">

        {{-- Gradient glow background (same philosophy as navbar) --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-16 -left-16 w-72 h-72
                        bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 -right-16 w-80 h-80
                        bg-emerald-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Top row --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                {{-- Brand --}}
                <div class="flex flex-col gap-1">
                    <span
                        class="text-xl lg:text-2xl font-black tracking-tight
                               bg-gradient-to-r from-indigo-600 via-purple-600 to-emerald-600
                               bg-clip-text text-transparent">
                        {{ __('messages.FyberShop') }}
                    </span>
                    <span class="text-sm text-slate-600 font-medium">
                        {{ __('messages.Crafted with elegance') }}
                    </span>
                </div>

                {{-- Actions --}}
                <div class="flex flex-wrap items-center gap-3">

                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5
                              rounded-xl font-semibold text-sm
                              bg-gradient-to-br from-slate-50 to-slate-100
                              border-2 border-slate-200 text-slate-700
                              hover:from-indigo-50 hover:to-purple-50
                              hover:border-indigo-300 hover:shadow-lg
                              transition-all duration-300 hover:scale-105 no-underline">
                        {{ __('messages.Contact Us') }}
                    </a>

                    <a href="{{ route('home') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5
                              rounded-xl font-bold text-sm text-white
                              bg-gradient-to-r from-indigo-600 to-purple-600
                              hover:from-indigo-700 hover:to-purple-700
                              hover:shadow-lg transition-all duration-300
                              hover:scale-105 no-underline">
                        {{ __('messages.Home') }}
                    </a>

                </div>
            </div>

            {{-- Divider --}}
            <div class="my-8 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

            {{-- Bottom --}}
            <div class="flex flex-col items-center gap-3 text-center">

                <p class="text-xs text-slate-500">
                    &copy; {{ now()->year }}
                    <span class="font-semibold text-slate-700">
                        {{ __('messages.FyberShop') }}
                    </span>.
                    {{ __('messages.All rights reserved.') }}
                </p>

                {{-- Subtle animated indicators (same motion language) --}}
                <div class="flex gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse delay-150"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse delay-300"></span>
                </div>

            </div>
        </div>
    </footer>
</div>