@extends('layouts.app')

@section('content')
<div class="pt-20 flex justify-center px-4">
    <div
        class="w-full max-w-md rounded-3xl
               bg-white/95 backdrop-blur-md
               border-2 border-slate-200
               shadow-2xl shadow-slate-900/30
               overflow-hidden relative">

        {{-- Soft glow background --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-16 -left-16 w-72 h-72
                        bg-indigo-500/15 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 -right-16 w-80 h-80
                        bg-purple-500/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Header --}}
        <div
            class="relative px-6 py-7 text-center
                   bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">

            <h1
                class="text-2xl font-black tracking-tight
                       bg-gradient-to-r from-indigo-400 via-purple-400 to-emerald-400
                       bg-clip-text text-transparent">
                {{ __('messages.Login') }}
            </h1>

            <p class="mt-1 text-sm text-slate-300 font-medium">
                {{ __('messages.welcome') }}
            </p>
        </div>

        {{-- Body --}}
        <div class="relative px-6 py-6">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('messages.Email')" />
                    <x-text-input
                        id="email"
                        class="mt-1 w-full rounded-xl
                               border-2 border-slate-200
                               bg-white/80 backdrop-blur-sm
                               focus:border-indigo-500
                               focus:ring-2 focus:ring-indigo-500/20
                               transition"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('messages.Password')" />
                    <x-text-input
                        id="password"
                        class="mt-1 w-full rounded-xl
                               border-2 border-slate-200
                               bg-white/80 backdrop-blur-sm
                               focus:border-indigo-500
                               focus:ring-2 focus:ring-indigo-500/20
                               transition"
                        type="password"
                        name="password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between text-sm gap-3">
                    <label class="flex items-center gap-2 text-slate-700 font-medium">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300 text-indigo-600
                                   focus:ring-indigo-500">
                        {{ __('messages.Remember Me') }}
                    </label>

                    <a href="{{ route('password.request') }}"
                        class="font-semibold text-slate-600
                              hover:text-indigo-600 transition no-underline">
                        {{ __('messages.Forgot Your Password?') }}
                    </a>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center
                           rounded-xl py-2.5 text-sm font-bold text-white
                           bg-gradient-to-r from-indigo-600 to-purple-600
                           hover:from-indigo-700 hover:to-purple-700
                           hover:shadow-lg hover:scale-[1.02]
                           transition-all duration-300">
                    {{ __('messages.Login') }}
                </button>
            </form>

            {{-- Divider --}}
            <div class="my-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
                <span class="text-xs text-slate-400 uppercase tracking-wider">or</span>
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
            </div>

            {{-- Register --}}
            <p class="text-center text-sm text-slate-600">
                {{ __('messages.Not registered') }}?
                <a href="{{ route('register') }}"
                    class="font-bold
                          bg-gradient-to-r from-indigo-600 to-purple-600
                          bg-clip-text text-transparent
                          hover:underline">
                    {{ __('messages.Sign up') }}
                </a>
            </p>
        </div>
    </div>
</div>
@endsection