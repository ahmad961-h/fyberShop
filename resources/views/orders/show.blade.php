@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
        <div class="text-center mb-2">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                {{ __('messages.Order') }} #{{ $order->id }}
            </p>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 mt-2">
                {{ __('messages.Order details') }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">
                {{ $order->created_at->format('d M Y H:i') }}
            </p>
        </div>

        <div class="rounded-3xl border border-slate-100 bg-white/90 backdrop-blur-sm shadow-xl px-6 py-6 sm:px-8 sm:py-8">
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                            {{ __('messages.Payment method') }}</p>
                        <p class="text-base font-bold text-slate-900">{{ strtoupper($order->payment_method) }}</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">
                            {{ __('messages.Order Status') }}</p>
                        <p class="text-base font-bold text-slate-900">{{ ucfirst($order->order_status) }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div
                        class="rounded-2xl border-2 border-indigo-100 bg-gradient-to-br from-indigo-50 via-purple-50 to-emerald-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">{{ __('messages.Total') }}
                        </p>
                        <p
                            class="text-3xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            €{{ number_format($order->total_eur, 2) }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">
                            {{ __('messages.Shipping address') }}</p>
                        @if ($order->address)
                            <p class="text-sm text-slate-700 leading-relaxed">
                                {{ $order->address->line1 }}<br>
                                @if ($order->address->line2)
                                    {{ $order->address->line2 }}<br>
                                @endif
                                {{ $order->address->city }}, {{ $order->address->zip }}<br>
                                {{ $order->address->country }}
                            </p>
                        @else
                            <p class="text-sm text-slate-500">
                                {{ __('messages.No address') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-bold text-white shadow-lg hover:bg-slate-800 hover:shadow-xl transition-all duration-300 no-underline">
                {{ __('messages.Back to orders') }}
            </a>
        </div>
    </div>
@endsection
