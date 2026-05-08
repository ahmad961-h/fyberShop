@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
            {{ __('messages.Order details') }} #{{ $order->id }}
        </h1>
        <p class="mt-1 text-sm text-slate-600">
            {{ __('messages.Order overview') }}
        </p>
    </div>

    <div class="bg-white/90 backdrop-blur-sm border border-slate-100 shadow-xl rounded-3xl p-6 sm:p-7 space-y-6">

        {{-- General Info --}}
        <section>
            <h2 class="text-lg sm:text-xl font-semibold text-slate-900 mb-3">
                {{ __('messages.General information') }}
            </h2>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-slate-700">
                <div>
                    <dt class="font-semibold text-slate-900">{{ __('messages.User') }}</dt>
                    <dd>{{ $order->user->name ?? __('messages.Guest') }}</dd>
                </div>

                <div>
                    <dt class="font-semibold text-slate-900">{{ __('messages.Email') }}</dt>
                    <dd>{{ $order->user->email ?? 'N/A' }}</dd>
                </div>

                <div>
                    <dt class="font-semibold text-slate-900">{{ __('messages.Order date') }}</dt>
                    <dd>{{ $order->created_at->format('d M Y, H:i') }}</dd>
                </div>

                <div>
                    <dt class="font-semibold text-slate-900">{{ __('messages.Payment method') }}</dt>
                    <dd>{{ ucfirst($order->payment_method) }}</dd>
                </div>

                <div>
                    <dt class="font-semibold text-slate-900">{{ __('messages.Payment status') }}</dt>
                    @php
                    $paymentStatus = $order->payment_status;

                    $paymentDotClass = match ($paymentStatus) {
                    'paid' => 'bg-emerald-500',
                    'failed' => 'bg-rose-500',
                    'pending' => 'bg-amber-400',
                    default => 'bg-slate-400',
                    };

                    $paymentLabel = match ($paymentStatus) {
                    'paid' => __('messages.Paid'),
                    'failed' => __('messages.Failed'),
                    'pending' => __('messages.Pending'),
                    default => ucfirst($paymentStatus),
                    };
                    @endphp

                    <dd class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full {{ $paymentDotClass }}"></span>
                        <span>{{ $paymentLabel }}</span>
                    </dd>
                </div>

                <div>
                    <dt class="font-semibold text-slate-900">
                        {{ __('messages.Order status') }}
                    </dt>

                    @php
                    $status = $order->order_status;

                    $statusClasses = match ($status) {
                    'pending' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
                    'processing' => 'bg-blue-50 text-blue-800 border-blue-200',
                    'shipped' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                    'delivered' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };

                    $statusLabel = match ($status) {
                    'pending' => __('messages.Pending'),
                    'processing' => __('messages.Processing'),
                    'shipped' => __('messages.Shipped'),
                    'delivered' => __('messages.Delivered'),
                    default => ucfirst($status),
                    };
                    @endphp

                    <dd>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClasses }}">
                            {{ $statusLabel }}
                        </span>
                    </dd>
                </div>

            </dl>
        </section>

        {{-- Address --}}
        @if($order->address)
        <section class="pt-4 border-t border-slate-100">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-900 mb-3">
                {{ __('messages.Shipping address') }}
            </h2>
            <div class="text-sm text-slate-700 space-y-0.5">
                <p>{{ $order->address->full_name }}</p>
                <p>{{ $order->address->street }}</p>
                <p>{{ $order->address->city }}, {{ $order->address->country }}</p>
                <p>{{ $order->address->phone }}</p>
            </div>
        </section>
        @endif

        {{-- Items --}}
        <section class="pt-4 border-t border-slate-100">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-900 mb-3">
                {{ __('messages.Ordered items') }}
            </h2>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-4 sm:px-5 py-2.5 text-left">{{ __('messages.Product') }}</th>
                            <th class="px-4 sm:px-5 py-2.5 text-center whitespace-nowrap">{{ __('messages.Quantity') }}</th>
                            <th class="px-4 sm:px-5 py-2.5 text-center whitespace-nowrap">{{ __('messages.Price') }} (€)</th>
                            <th class="px-4 sm:px-5 py-2.5 text-center whitespace-nowrap">{{ __('messages.Subtotal') }} (€)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 sm:px-5 py-2.5">
                                <span class="font-medium text-slate-900">
                                    {{ $item->product->name ?? __('messages.Deleted product') }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-5 py-2.5 text-center text-slate-700">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-4 sm:px-5 py-2.5 text-center text-slate-700">
                                {{ number_format($item->price, 2) }}
                            </td>
                            <td class="px-4 sm:px-5 py-2.5 text-center text-slate-900 font-medium">
                                {{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Total --}}
        <section class="pt-4 border-t border-slate-100">
            <div class="text-right text-sm sm:text-base">
                <p class="font-semibold text-slate-900">
                    {{ __('messages.Total') }}:
                    <span class="font-bold">
                        €{{ number_format($order->total_eur, 2) }}
                    </span>
                </p>
            </div>
        </section>

        {{-- Back button --}}
        <div class="pt-4 border-t border-slate-100 flex justify-center">
            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center rounded-full bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-slate-800 transition no-underline">
                ← {{ __('messages.Back to orders') }}
            </a>
        </div>

    </div>
</div>
@endsection