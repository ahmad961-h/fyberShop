<div class="flex flex-col min-h-screen bg-slate-50">
    <div class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if($cartItems->count() > 0)

        <div class="bg-white/90 backdrop-blur-sm border border-slate-100 shadow-xl rounded-3xl p-4 sm:p-7">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                        {{ __('messages.Your cart') }}
                    </h1>
                    <p class="mt-1 text-sm text-slate-600">
                        {{ __('messages.Empty cart text') }}
                    </p>
                </div>

                <div class="text-xs text-slate-500">
                    {{ $cartItems->count() }} {{ __('messages.Items') }}
                </div>
            </div>

            {{-- DESKTOP TABLE --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm">
                    <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="p-4 text-left">{{ __('messages.Product') }}</th>
                            <th class="p-4 text-left">{{ __('messages.Price') }}</th>
                            <th class="p-4 text-center">{{ __('messages.Quantity') }}</th>
                            <th class="p-4 text-left">{{ __('messages.Subtotal') }}</th>
                            <th class="p-4 text-left">{{ __('messages.Actions') }}</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($cartItems as $item)
                        @continue(! $item->product)

                        @php
                        $qty = $quantities[$item->id] ?? $item->quantity;
                        $price = (float) $item->product->price;
                        $delivery = (float) ($item->product->delivery_fee ?? 0);
                        $mainImage = $item->product->images->first();
                        @endphp

                        <tr>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img
                                        src="{{ $mainImage && $mainImage->path ? asset('storage/' . $mainImage->path) : 'https://via.placeholder.com/60' }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-16 h-16 rounded-xl object-cover border">

                                    <div>
                                        <div class="font-semibold">
                                            {{ $item->product->name }}
                                        </div>

                                        @if($item->product->categories?->isNotEmpty())
                                        <div class="text-xs text-slate-500">
                                            {{ $item->product->categories->pluck('name')->join(', ') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="p-4">
                                <div class="font-semibold">
                                    €{{ number_format($price, 2) }}
                                </div>

                                @if($delivery > 0)
                                <div class="text-xs text-slate-500">
                                    + €{{ number_format($delivery, 2) }} {{ __('messages.Delivery') }}
                                </div>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                <div class="inline-flex items-center rounded-xl border-2 border-slate-200 overflow-hidden bg-white shadow-sm">
                                    <button
                                        type="button"
                                        wire:click="decrement({{ $item->id }})"
                                        class="px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                                        –
                                    </button>

                                    <span class="px-4 py-2 font-bold text-slate-900 min-w-[2.5rem] text-center bg-slate-50">
                                        {{ $qty }}
                                    </span>

                                    <button
                                        type="button"
                                        wire:click="increment({{ $item->id }})"
                                        class="px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                                        +
                                    </button>
                                </div>
                            </td>

                            <td class="p-4 font-semibold">
                                €{{ number_format(($price * $qty) + $delivery, 2) }}
                            </td>

                            <td class="p-4">
                                <button
                                    type="button"
                                    wire:click="remove({{ $item->id }})"
                                    wire:confirm="{{ __('messages.Remove') }}?"
                                    class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-rose-500 to-red-600 text-white px-4 py-2 text-xs font-bold shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105">
                                    {{ __('messages.Remove') }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MOBILE CARDS --}}
            <div class="md:hidden space-y-4">
                @foreach($cartItems as $item)
                @continue(! $item->product)

                @php
                $qty = $quantities[$item->id] ?? $item->quantity;
                $price = (float) $item->product->price;
                $delivery = (float) ($item->product->delivery_fee ?? 0);
                $mainImage = $item->product->images->first();
                @endphp

                <div class="border-2 border-slate-200/50 rounded-3xl p-4 bg-white/90 backdrop-blur-sm shadow-lg">
                    <div class="flex gap-3">
                        <img
                            src="{{ $mainImage && $mainImage->path ? asset('storage/' . $mainImage->path) : 'https://via.placeholder.com/60' }}"
                            alt="{{ $item->product->name }}"
                            class="w-16 h-16 rounded-xl object-cover border">

                        <div class="flex-1">
                            <div class="font-semibold">
                                {{ $item->product->name }}
                            </div>

                            <div class="text-xs text-slate-500">
                                €{{ number_format($price, 2) }}

                                @if($delivery > 0)
                                + €{{ number_format($delivery, 2) }} {{ __('messages.Delivery') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <div class="inline-flex items-center rounded-xl border-2 border-slate-200 overflow-hidden bg-white shadow-sm">
                            <button
                                type="button"
                                wire:click="decrement({{ $item->id }})"
                                class="px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                                –
                            </button>

                            <span class="px-4 py-2 font-bold text-slate-900 min-w-[2.5rem] text-center bg-slate-50">
                                {{ $qty }}
                            </span>

                            <button
                                type="button"
                                wire:click="increment({{ $item->id }})"
                                class="px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                                +
                            </button>
                        </div>

                        <div class="font-bold">
                            €{{ number_format(($price * $qty) + $delivery, 2) }}
                        </div>
                    </div>

                    <button
                        type="button"
                        wire:click="remove({{ $item->id }})"
                        wire:confirm="{{ __('messages.Remove') }}?"
                        class="mt-3 w-full rounded-2xl bg-gradient-to-r from-rose-500 to-red-600 text-white py-3 text-xs font-bold shadow-md hover:shadow-lg transition-all duration-300 hover:scale-[1.01]">
                        {{ __('messages.Remove') }}
                    </button>
                </div>
                @endforeach
            </div>

            {{-- SUMMARY --}}
            <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-xs text-slate-500">
                    {{ __('messages.Delivery rule') }}
                </div>

                <div class="text-right">
                    <div class="text-xs uppercase text-slate-500">
                        {{ __('messages.Total') }}
                    </div>

                    <div class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        €{{ number_format($clientSubtotal, 2) }}
                    </div>

                    <div class="mt-3 flex gap-2 justify-end">
                        <button
                            type="button"
                            wire:click="clearCart"
                            wire:confirm="{{ __('messages.Remove') }}?"
                            class="rounded-full border-2 border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-900 hover:bg-slate-50 hover:shadow-sm transition-all">
                            {{ __('messages.Remove') }}
                        </button>

                        <a
                            href="{{ route('checkout') }}"
                            class="rounded-full bg-slate-900 text-white px-5 py-2.5 text-xs font-bold shadow-md hover:bg-slate-800 hover:shadow-lg transition-all">
                            {{ __('messages.Checkout') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="flex items-center justify-center h-[60vh]">
            <div class="bg-white/90 backdrop-blur-sm border border-slate-100 shadow-xl rounded-3xl p-8 text-center">
                <h2 class="text-2xl font-extrabold mb-3">
                    {{ __('messages.Your cart is empty') }}
                </h2>

                <p class="text-sm text-slate-600 mb-6">
                    {{ __('messages.Empty cart text') }}
                </p>

                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                    {{ __('messages.Continue shopping') }}
                </a>
            </div>
        </div>
        @endif

    </div>
</div>