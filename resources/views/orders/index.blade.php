@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
            {{ __('messages.My Orders') }}
        </h1>
        <p class="mt-2 text-sm text-slate-600">
            {{ __('messages.Track and review your recent orders') }}
        </p>
    </div>

    {{-- Empty state --}}
    @if($orders->isEmpty())
    <div class="rounded-3xl border border-slate-100 bg-white/90 backdrop-blur-sm shadow-xl px-6 py-12 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-slate-100 mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3V3zm0 6h18v12H3V9zm6 3h6"></path>
            </svg>
        </div>
        <p class="text-slate-900 text-lg font-bold mb-2">
            {{ __('messages.No orders yet') }}
        </p>
        <p class="text-slate-600 mb-6">
            {{ __('messages.Start shopping to place your first order') }}
        </p>
        <a href="{{ route('home') }}"
            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] no-underline">
            {{ __('messages.Browse products') }}
        </a>
    </div>
    @else

    {{-- Orders list --}}
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="group rounded-3xl border-2 border-slate-200/50 bg-white/90 backdrop-blur-sm p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-[1.01]">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                {{-- Left --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        {{ __('messages.Order') }} #{{ $order->id }}
                    </p>
                    <p class="text-sm text-slate-600 mt-1">
                        {{ $order->created_at->format('d M Y') }}
                    </p>
                </div>

                {{-- Right --}}
                <div class="flex flex-wrap items-center gap-3 sm:gap-4">

                    <p class="text-lg font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        €{{ number_format($order->total_eur, 2) }}
                    </p>

                    {{-- Order status --}}
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                @class([
                    'bg-yellow-100 text-yellow-800' => $order->order_status === 'pending',
                    'bg-blue-100 text-blue-800' => $order->order_status === 'processing',
                    'bg-indigo-100 text-indigo-800' => $order->order_status === 'shipped',
                    'bg-emerald-100 text-emerald-800' => $order->order_status === 'delivered',
                ])">
                        {{ __(ucfirst($order->order_status)) }}
                    </span>

                    {{-- Payment status --}}
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                @class([
                    'bg-emerald-100 text-emerald-800' => $order->payment_status === 'paid',
                    'bg-yellow-100 text-yellow-800'   => $order->payment_status === 'pending',
                    'bg-rose-100 text-rose-800'       => $order->payment_status === 'failed',
                    'bg-slate-100 text-slate-700'     => $order->payment_status === 'unpaid',
                ])">
                        {{ __('messages.Payment') }}: {{ ucfirst($order->payment_status) }}
                    </span>

                    {{-- Retry payment --}}
                    @if(
                    in_array($order->payment_status, ['pending', 'failed']) &&
                    $order->payment_method !== 'cod'
                    )
                    <a href="{{ route('checkout.retry', $order) }}"
                        class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-700 transition">
                        {{ __('messages.Pay now') }}
                    </a>
                    @endif

                    {{-- View order --}}
                    <a href="{{ route('orders.show', $order) }}"
                        class="text-sm font-semibold text-indigo-600 hover:underline">
                        {{ __('messages.View order') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection