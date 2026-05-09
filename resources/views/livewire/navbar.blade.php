<div>
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 lg:h-18 flex items-center justify-between">

                {{-- Brand --}}
                <a href="{{ route('home') }}"
                    class="group flex items-center gap-2 text-xl lg:text-2xl font-black tracking-tight text-slate-900 no-underline hover:text-indigo-600 transition-colors duration-300">
                    <div class="relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                        </div>
                        <span
                            class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-emerald-600 bg-clip-text text-transparent">
                            {{ __('messages.FyberShop') }}
                        </span>
                    </div>
                </a>

                {{-- Desktop Search --}}
                @unless (request()->routeIs('login', 'register', 'contact', 'password.*'))
                    <form action="{{ route('search') }}" method="GET"
                        class="hidden md:block w-full max-w-md mx-6 relative group">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-emerald-500/10 rounded-full blur opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div class="relative flex items-center">
                            <svg class="absolute left-4 w-5 h-5 text-slate-400 pointer-events-none" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="search" name="q" placeholder="{{ __('messages.Search products') }}"
                                class="w-full rounded-full border-2 border-slate-200 bg-white/80 backdrop-blur-sm pl-12 pr-4 py-2.5 text-sm font-medium text-slate-900 placeholder:text-slate-400
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none focus:bg-white transition-all duration-300"
                                required>
                        </div>
                    </form>
                @endunless

                {{-- Right Actions --}}
                <div class="flex items-center gap-3">

                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}"
                        class="group relative inline-flex items-center justify-center w-10 h-10
                          rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-200
                          hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 hover:shadow-lg transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5 text-slate-700 group-hover:text-indigo-600 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6H19" />
                        </svg>

                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-gradient-to-r from-rose-500 to-pink-600 text-white
                                     text-[10px] font-black px-2 py-0.5 rounded-full shadow-lg
                                     animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- AUTHENTICATED USER --}}
                    @auth
                        <div class="relative hidden md:block" style="z-index: 1000;">
                            <button id="user-menu-button"
                                class="group inline-flex items-center justify-center w-10 h-10 rounded-xl
                                       bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-200 
                                       hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 hover:shadow-lg transition-all duration-300 hover:scale-110
                                       user-menu-button">
                                <svg class="w-5 h-5 text-slate-700 group-hover:text-indigo-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0" />
                                </svg>
                            </button>

                            {{-- Desktop Dropdown --}}
                            <div id="user-menu"
                                class="user-menu-dropdown hidden absolute right-0 mt-2 w-56 rounded-2xl
                                    bg-white
                                    border-2 border-slate-200
                                    shadow-2xl shadow-slate-900/30
                                    ring-1 ring-black/5 overflow-hidden
                                    opacity-0 transform scale-95 translate-y-[-10px] transition-all duration-200 ease-out"
                                style="z-index: 10000; pointer-events: none; background: white;">

                                <div
                                    class="px-4 py-3 border-b border-slate-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">
                                        {{ __('messages.Account') }}</p>
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ auth()->user()->name ?? auth()->user()->email }}</p>
                                </div>

                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700
                                          hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200 group
                                          rounded-lg mx-2 hover:shadow-sm">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-all duration-200 group-hover:scale-110"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span
                                            class="group-hover:translate-x-1 transition-transform duration-200">{{ __('messages.Profile') }}</span>
                                    </a>

                                    <a href="{{ route('orders.index') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700
                                          hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200 group
                                          rounded-lg mx-2 hover:shadow-sm">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-all duration-200 group-hover:scale-110"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        <span
                                            class="group-hover:translate-x-1 transition-transform duration-200">{{ __('messages.Manage Orders') }}</span>
                                    </a>
                                    <a href="{{ route('checkout') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700
          hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 transition-all duration-200 group
          rounded-lg mx-2 hover:shadow-sm">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 transition-all duration-200 group-hover:scale-110"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6H19M7 13l4 0m-4 0L5.4 5M17 13l1.5 6M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                                        </svg>
                                        <span class="group-hover:translate-x-1 transition-transform duration-200">
                                            {{ __('messages.Checkout') }}
                                        </span>
                                    </a>

                                </div>

                                @if (auth()->user()->is_admin)
                                    <div class="border-t border-slate-200 my-2"></div>
                                    <div class="px-4 py-2 bg-gradient-to-r from-amber-50 to-orange-50">
                                        <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-2">
                                            {{ __('messages.Admin') }}</p>
                                        <a href="{{ route('products.create') }}"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold
                                          text-amber-700 hover:bg-amber-100 rounded-lg transition-all duration-200 group
                                          hover:shadow-sm">
                                            <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-200"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            <span
                                                class="group-hover:translate-x-1 transition-transform duration-200">{{ __('messages.Add Product') }}</span>
                                        </a>

                                        <a href="{{ route('admin.orders.index') }}"
                                            class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700
                                          hover:bg-amber-100 rounded-lg transition-all duration-200 group mt-1
                                          hover:shadow-sm">
                                            <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-700 transition-all duration-200 group-hover:scale-110"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <span
                                                class="group-hover:translate-x-1 transition-transform duration-200">{{ __('messages.Admin Orders') }}</span>
                                        </a>
                                    </div>
                                @endif

                                <div class="border-t border-slate-200 mt-2"></div>

                                {{-- Proper logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold
                                               text-rose-600 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 transition-all duration-200 group
                                               rounded-lg mx-2 hover:shadow-sm">
                                        <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        <span
                                            class="group-hover:translate-x-1 transition-transform duration-200">{{ __('messages.Logout') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    {{-- GUEST --}}
                    @guest
                        <div class="hidden md:flex items-center gap-3">
                            <a href="{{ route('login') }}"
                                class="px-5 py-2.5 text-sm font-semibold rounded-xl
                                  bg-white border-2 border-slate-200 text-slate-700
                                  hover:bg-slate-50 hover:border-slate-300 hover:shadow-md transition-all duration-300">
                                {{ __('messages.Login') }}
                            </a>

                            <a href="{{ route('register') }}"
                                class="px-5 py-2.5 text-sm font-bold rounded-xl
                                  bg-gradient-to-r from-indigo-600 to-purple-600 text-white
                                  hover:from-indigo-700 hover:to-purple-700 hover:shadow-lg transition-all duration-300 hover:scale-105">
                                {{ __('messages.Sign up') }}
                            </a>
                        </div>
                    @endguest

                    {{-- Language --}}
                    <div
                        class="hidden md:flex items-center gap-1.5 bg-slate-100 rounded-xl p-1 border border-slate-200">

                        <a href="{{ route('lang.switch', ['locale' => 'en']) }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-300
                            {{ app()->getLocale() === 'en'
                                ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md'
                                : 'text-slate-600 hover:bg-white hover:text-slate-900' }}">
                            EN
                        </a>

                        <a href="{{ route('lang.switch', ['locale' => 'bg']) }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-300
                            {{ app()->getLocale() === 'bg'
                                ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md'
                                : 'text-slate-600 hover:bg-white hover:text-slate-900' }}">
                            BG
                        </a>

                    </div>

                    {{-- Mobile toggle --}}
                    <button id="mobile-menu-button"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10
                               rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-200
                               hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 hover:shadow-lg transition-all duration-300">
                        <svg id="mobile-menu-icon" class="w-6 h-6 text-slate-700 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="mobile-menu-close" class="w-6 h-6 text-slate-700 hidden transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                </div>
            </div>
        </div>

        {{-- MOBILE MENU --}}
        <div id="mobile-menu"
            class="hidden md:hidden border-t border-slate-200/50
                bg-white/98 backdrop-blur-md
                shadow-2xl shadow-slate-900/20
                animate-slideDown">

            <div class="px-4 py-6 space-y-4">

                <div class="space-y-3">
                    <a href="{{ route('cart.index') }}"
                        class="group flex items-center justify-center gap-2 w-full py-3.5 rounded-xl
                          bg-gradient-to-r from-slate-50 to-slate-100 border-2 border-slate-200
                          hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 hover:shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5 text-slate-700 group-hover:text-indigo-600 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6H19" />
                        </svg>
                        <span
                            class="font-semibold text-slate-700 group-hover:text-indigo-600 transition-colors">{{ __('messages.Cart') }}</span>
                        @if ($cartCount > 0)
                            <span
                                class="bg-gradient-to-r from-rose-500 to-pink-600 text-white text-xs font-black px-2 py-0.5 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('checkout') }}"
                        class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl
                          bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold
                          hover:from-emerald-700 hover:to-teal-700 hover:shadow-xl transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('messages.Checkout') }}
                    </a>
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

                @auth
                    <div class="space-y-2">
                        <a href="{{ route('orders.index') }}"
                            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl
                              bg-gradient-to-r from-slate-50 to-slate-100 border-2 border-slate-200
                              hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 hover:shadow-md transition-all duration-300">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <span class="font-semibold text-slate-700">{{ __('messages.Manage Orders') }}</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl
                              bg-gradient-to-r from-slate-50 to-slate-100 border-2 border-slate-200
                              hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 hover:shadow-md transition-all duration-300">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="font-semibold text-slate-700">{{ __('messages.Profile') }}</span>
                        </a>

                        @if (auth()->user()->is_admin)
                            <a href="{{ route('products.create') }}"
                                class="flex items-center justify-center gap-2 w-full py-3 rounded-xl
                              bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200
                              hover:from-amber-100 hover:to-orange-100 hover:border-amber-300 hover:shadow-md transition-all duration-300">
                                <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="font-bold text-amber-700">{{ __('messages.Add Product') }}</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center gap-2 w-full py-3 rounded-xl
                                       bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold
                                       hover:from-rose-600 hover:to-pink-700 hover:shadow-xl transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                {{ __('messages.Logout') }}
                            </button>
                        </form>
                    </div>
                @else
                    <div class="space-y-2">
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl
                              bg-white border-2 border-slate-200 text-slate-700 font-semibold
                              hover:bg-slate-50 hover:border-slate-300 hover:shadow-md transition-all duration-300">
                            {{ __('messages.Login') }}
                        </a>

                        <a href="{{ route('register') }}"
                            class="flex items-center justify-center gap-2 w-full py-3 rounded-xl
                              bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold
                              hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl transition-all duration-300">
                            {{ __('messages.Sign up') }}
                        </a>
                    </div>

                @endauth
                <div class="px-4 py-6 space-y-4">{{-- Mobile Language Switcher --}}
                    <div class="pt-2">
                        <div
                            class="flex items-center justify-center gap-2 bg-slate-100 rounded-xl p-1 border border-slate-200">
                            <a href="{{ route('lang.switch', ['locale' => 'en']) }}"
                                class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300
            {{ app()->getLocale() === 'en'
                ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md'
                : 'text-slate-600 hover:bg-white hover:text-slate-900' }}">
                                EN
                            </a>

                            <a href="{{ route('lang.switch', ['locale' => 'bg']) }}"
                                class="flex-1 text-center px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300
            {{ app()->getLocale() === 'bg'
                ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md'
                : 'text-slate-600 hover:bg-white hover:text-slate-900' }}">
                                BG
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        const userBtn = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const mobileBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileIcon = document.getElementById('mobile-menu-icon');
        const mobileClose = document.getElementById('mobile-menu-close');

        if (userBtn && userMenu) {
            let isOpen = false;

            function openMenu() {
                isOpen = true;
                userMenu.classList.remove('hidden');
                // Force reflow to ensure transition works
                userMenu.offsetHeight;
                setTimeout(() => {
                    userMenu.classList.remove('opacity-0', 'scale-95', 'translate-y-[-10px]');
                    userMenu.classList.add('opacity-100', 'scale-100', 'translate-y-0');
                    userMenu.style.pointerEvents = 'auto';
                }, 10);
            }

            function closeMenu() {
                isOpen = false;
                userMenu.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
                userMenu.classList.add('opacity-0', 'scale-95', 'translate-y-[-10px]');
                userMenu.style.pointerEvents = 'none';
                setTimeout(() => {
                    if (!isOpen) {
                        userMenu.classList.add('hidden');
                    }
                }, 200);
            }

            userBtn.addEventListener('click', e => {
                e.stopPropagation();
                if (isOpen) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            document.addEventListener('click', (e) => {
                if (!userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                    if (isOpen) {
                        closeMenu();
                    }
                }
            });

            // Close on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && isOpen) {
                    closeMenu();
                }
            });
        }

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', e => {
                e.stopPropagation();
                const isHidden = mobileMenu.classList.contains('hidden');

                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    mobileIcon.classList.add('hidden');
                    mobileClose.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                    mobileIcon.classList.remove('hidden');
                    mobileClose.classList.add('hidden');
                }
            });

            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileBtn.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                    if (mobileIcon) mobileIcon.classList.remove('hidden');
                    if (mobileClose) mobileClose.classList.add('hidden');
                }
            });
        }
    </script>

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

        /* User menu dropdown animations */
        .user-menu-dropdown {
            transform-origin: top right;
        }

        .user-menu-dropdown.opacity-100 {
            pointer-events: auto;
        }

        .user-menu-button:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .user-menu-button:focus-visible {
            outline: 2px solid rgb(99, 102, 241);
            outline-offset: 2px;
        }

        /* Ensure dropdown appears above everything */
        #user-menu {
            position: absolute !important;
            z-index: 10000 !important;
        }
    </style>
</div>
