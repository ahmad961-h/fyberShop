@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                {{ __('messages.Manage Orders') }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ __('messages.Manage Orders subtitle') }}
            </p>
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap gap-2 text-xs font-medium">
            <span class="px-2.5 py-1 rounded-md bg-yellow-50 text-yellow-700 border border-yellow-200">
                {{ __('messages.Pending') }}
            </span>
            <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 border border-blue-200">
                {{ __('messages.Processing') }}
            </span>
            <span class="px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200">
                {{ __('messages.Shipped') }}
            </span>
            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">
                {{ __('messages.Delivered') }}
            </span>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        {{ session('success') }}
    </div>
    @endif

    {{-- Orders --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">#</th>
                        <th class="px-4 py-3 text-left font-semibold">{{ __('messages.User') }}</th>
                        <th class="px-4 py-3 text-left font-semibold">{{ __('messages.Total') }}</th>
                        <th class="px-4 py-3 text-left font-semibold">{{ __('messages.Payment') }}</th>
                        <th class="px-4 py-3 text-left font-semibold">{{ __('messages.Order Status') }}</th>
                        <th class="px-4 py-3 text-left font-semibold">{{ __('messages.Date') }}</th>
                        <th class="px-4 py-3 text-right font-semibold">{{ __('messages.Actions') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($orders as $order)
                    @php
                    $orderStatus = [
                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                    'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    ][$order->order_status] ?? 'bg-slate-50 text-slate-700 border-slate-200';

                    $paymentStatus = [
                    'pending' => 'bg-slate-50 text-slate-700 border-slate-200',
                    'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'failed' => 'bg-rose-50 text-rose-700 border-rose-200',
                    ][$order->payment_status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                    @endphp

                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-4 font-medium text-slate-900">
                            #{{ $order->id }}
                        </td>

                        <td class="px-4 py-4">
                            <div class="font-medium text-slate-900">
                                {{ $order->user?->name ?? '—' }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $order->user?->email }}
                            </div>
                        </td>

                        <td class="px-4 py-4 font-semibold text-slate-900">
                            €{{ number_format($order->total_eur, 2) }}
                        </td>

                        <td class="px-4 py-4 space-y-1">
                            <div class="text-xs text-slate-500">
                                {{ ucfirst($order->payment_method) }}
                            </div>
                            <span class="inline-block px-2 py-0.5 rounded-md border text-xs {{ $paymentStatus }}">
                                {{ __('messages.' . ucfirst($order->payment_status)) }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            <span class="inline-block px-2 py-0.5 rounded-md border text-xs {{ $orderStatus }}">
                                {{ __('messages.' . ucfirst($order->order_status)) }}
                            </span>
                        </td>

                        <td class="px-4 py-4 text-slate-500 whitespace-nowrap">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>

                        <td class="px-4 py-4 text-right">
                            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-2">
                                @csrf
                                @method('PATCH')

                                <div class="flex justify-end gap-2">
                                    <select name="order_status"
                                        class="rounded-md border-slate-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(['pending','processing','shipped','delivered'] as $st)
                                        <option value="{{ $st }}" @selected($order->order_status === $st)>
                                            {{ __('messages.' . ucfirst($st)) }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <select name="payment_status"
                                        class="rounded-md border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500">
                                        @foreach(['pending','paid','failed'] as $ps)
                                        <option value="{{ $ps }}" @selected($order->payment_status === $ps)>
                                            {{ __('messages.' . ucfirst($ps)) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex justify-end gap-2 pt-1">
                                    <button
                                        class="px-3 py-1.5 text-xs rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                        {{ __('messages.Save') }}
                                    </button>

                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="px-3 py-1.5 text-xs rounded-md bg-slate-200 text-slate-800 hover:bg-slate-300 no-underline">
                                        {{ __('messages.View') }}
                                    </a>

                                    <button
                                        formmethod="POST"
                                        formaction="{{ route('admin.orders.destroy', $order) }}"
                                        onclick="return confirm('{{ __('messages.Delete this order?') }}')"
                                        class="px-3 py-1.5 text-xs rounded-md bg-rose-600 text-white hover:bg-rose-700">
                                        {{ __('messages.Delete') }}
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-slate-500">
                            {{ __('messages.No orders available yet.') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $orders->links('pagination::tailwind') }}
    </div>

</div>
@endsection