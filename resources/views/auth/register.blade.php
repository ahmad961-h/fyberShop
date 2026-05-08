@extends('layouts.app')

@section('content')
<div class="pt-20 flex justify-center px-4 sm:px-6">
    <div
        class="w-full max-w-md sm:max-w-lg
               rounded-3xl
               bg-white/95 backdrop-blur-md
               border-2 border-slate-200
               shadow-2xl shadow-slate-900/30
               overflow-hidden relative">

        {{-- Soft glow background --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-16 -left-16 w-72 h-72
                        bg-indigo-500/15 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 -right-16 w-80 h-80
                        bg-emerald-500/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Header --}}
        <div
            class="relative px-6 sm:px-8 py-7 text-center
                   bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">

            <h1
                class="text-xl sm:text-2xl font-black tracking-tight
                       bg-gradient-to-r from-indigo-400 via-purple-400 to-emerald-400
                       bg-clip-text text-transparent">
                {{ __('messages.Register') }}
            </h1>

            <p class="mt-1 text-xs sm:text-sm text-slate-300 font-medium">
                {{ __('messages.welcome') }}
            </p>
        </div>

        {{-- Body --}}
        <div class="relative px-6 sm:px-8 py-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        {{ __('messages.Name') }}
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full rounded-xl
                               border-2 border-slate-200
                               bg-white/80 backdrop-blur-sm
                               px-4 py-2.5
                               text-sm sm:text-base
                               focus:border-indigo-500
                               focus:ring-2 focus:ring-indigo-500/20
                               transition">
                    @error('name')
                    <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        {{ __('messages.Email') }}
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl
                               border-2 border-slate-200
                               bg-white/80 backdrop-blur-sm
                               px-4 py-2.5
                               text-sm sm:text-base
                               focus:border-indigo-500
                               focus:ring-2 focus:ring-indigo-500/20
                               transition">
                    @error('email')
                    <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        {{ __('messages.Password') }}
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-xl
                               border-2 border-slate-200
                               bg-white/80 backdrop-blur-sm
                               px-4 py-2.5
                               text-sm sm:text-base
                               focus:border-indigo-500
                               focus:ring-2 focus:ring-indigo-500/20
                               transition">
                    @error('password')
                    <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        {{ __('messages.Confirm Password') }}
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full rounded-xl
                               border-2 border-slate-200
                               bg-white/80 backdrop-blur-sm
                               px-4 py-2.5
                               text-sm sm:text-base
                               focus:border-indigo-500
                               focus:ring-2 focus:ring-indigo-500/20
                               transition">
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center
                           rounded-xl py-3
                           text-sm sm:text-base font-bold text-white
                           bg-gradient-to-r from-indigo-600 to-purple-600
                           hover:from-indigo-700 hover:to-purple-700
                           hover:shadow-lg hover:scale-[1.02]
                           transition-all duration-300">
                    {{ __('messages.Register') }}
                </button>
            </form>

            {{-- Divider --}}
            <div class="my-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
                <span class="text-xs text-slate-400 uppercase tracking-wider">or</span>
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
            </div>

            {{-- Login --}}
            <p class="text-center text-sm text-slate-600">
                {{ __('messages.Already registered') }}?
                <a href="{{ route('login') }}"
                    class="font-bold
                          bg-gradient-to-r from-indigo-600 to-purple-600
                          bg-clip-text text-transparent
                          hover:underline">
                    {{ __('messages.Login') }}
                </a>
            </p>
        </div>
    </div>
</div>
@endsection