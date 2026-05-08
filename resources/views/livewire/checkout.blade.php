<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Cart summary --}}
            <section class="lg:col-span-8 bg-white border border-slate-200 shadow-xl rounded-3xl overflow-hidden">
                <div class="px-6 sm:px-8 py-6 border-b border-slate-100">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
                        {{ __('messages.Your cart') }}
                    </h1>
                </div>

                @if($cartItems->count())
                <div class="p-5 sm:p-8 space-y-4">
                    @foreach($cartItems as $item)
                    @continue(! $item->product)

                    @php
                    $img = $item->product->images->first();
                    $qty = $quantities[$item->id] ?? $item->quantity;
                    @endphp

                    <article class="flex flex-col sm:flex-row gap-5 p-4 rounded-3xl border border-slate-200 bg-slate-50">
                        <img
                            src="{{ $img && $img->path ? asset('storage/' . $img->path) : 'https://via.placeholder.com/80' }}"
                            alt="{{ $item->product->name }}"
                            class="w-20 h-20 rounded-2xl object-cover border border-slate-200 bg-white">

                        <div class="flex-1 min-w-0">
                            <p class="font-black text-slate-900 leading-tight">
                                {{ $item->product->name }}
                            </p>

                            <p class="text-sm text-slate-600 mt-1">
                                €{{ number_format($item->product->price, 2) }}
                            </p>

                            @if($item->product->delivery_fee)
                            <p class="text-xs text-slate-500">
                                + €{{ number_format($item->product->delivery_fee, 2) }} {{ __('messages.Delivery') }}
                            </p>
                            @endif
                        </div>

                        <div class="flex sm:flex-col items-center justify-center gap-3">
                            <div class="inline-flex items-center rounded-2xl border border-slate-200 overflow-hidden bg-white">
                                <button
                                    type="button"
                                    wire:click="decrement({{ $item->id }})"
                                    class="px-4 py-2 text-sm font-black text-slate-700 hover:bg-slate-100">
                                    –
                                </button>

                                <span class="px-4 py-2 text-sm font-black text-slate-900 min-w-[3rem] text-center bg-slate-50">
                                    {{ $qty }}
                                </span>

                                <button
                                    type="button"
                                    wire:click="increment({{ $item->id }})"
                                    class="px-4 py-2 text-sm font-black text-slate-700 hover:bg-slate-100">
                                    +
                                </button>
                            </div>

                            <button
                                type="button"
                                wire:click="removeItem({{ $item->id }})"
                                class="text-xs font-black text-rose-600 hover:underline">
                                {{ __('messages.Remove') }}
                            </button>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="px-6 sm:px-8 py-6 bg-slate-50 border-t border-slate-100">
                    <div class="max-w-sm ml-auto space-y-2">
                        <div class="flex justify-between text-sm text-slate-600">
                            <span>{{ __('messages.Items') }}</span>
                            <span>€{{ number_format($itemsTotal, 2) }}</span>
                        </div>

                        <div class="flex justify-between text-sm text-slate-600">
                            <span>{{ __('messages.Delivery') }}</span>
                            <span>€{{ number_format($deliveryTotal, 2) }}</span>
                        </div>

                        <div class="pt-3 border-t border-slate-200 flex justify-between items-center">
                            <span class="text-sm font-black uppercase tracking-wide text-slate-500">
                                {{ __('messages.Total') }}
                            </span>

                            <span class="text-3xl font-black text-slate-900">
                                €{{ number_format($total, 2) }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 text-right">
                            {{ __('messages.Delivery rule') }}
                        </p>
                    </div>
                </div>
                @else
                <div class="py-24 text-center">
                    <p class="text-2xl font-black text-slate-900">
                        {{ __('messages.Your cart is empty') }}
                    </p>

                    <p class="text-sm text-slate-500 mt-2">
                        {{ __('messages.Empty cart text') }}
                    </p>
                </div>
                @endif
            </section>

            {{-- Checkout form --}}
            <aside class="lg:col-span-4">
                <div class="bg-white border border-slate-200 shadow-xl rounded-3xl p-6 sm:p-8 sticky top-6">
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 mb-6">
                        {{ __('messages.Shipping & payment') }}
                    </h2>

                    <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <p class="text-sm font-black text-slate-800 mb-3">
                                {{ __('messages.Shipping address') }}
                            </p>

                            <div class="space-y-4">
                                <label class="block rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center gap-2 text-sm font-bold text-slate-800">
                                        <input type="radio" name="shipping_type" value="home" checked>
                                        {{ __('messages.Home address') }}
                                    </div>

                                    <textarea
                                        name="home_address"
                                        rows="3"
                                        class="mt-3 w-full rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200 resize-none"
                                        placeholder="{{ __('messages.Enter home address') }}"></textarea>
                                </label>

                                <label class="block rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center gap-2 text-sm font-bold text-slate-800">
                                        <input type="radio" name="shipping_type" value="econt">
                                        {{ __('messages.Econt office') }}
                                    </div>

                                    <input
                                        type="text"
                                        name="econt_office"
                                        class="mt-3 w-full rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
                                        placeholder="{{ __('messages.Econt office') }}">
                                </label>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-black text-slate-800 mb-2">
                                {{ __('messages.Payment method') }}
                            </p>

                            <select
                                name="payment_method"
                                required
                                class="w-full rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                                <option value="">{{ __('messages.Select payment method') }}</option>
                                <option value="stripe">Stripe</option>
                                <option value="googlepay">Google Pay</option>
                                <option value="cod">{{ __('messages.Cash on delivery') }}</option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-full bg-slate-900 py-3 text-sm font-black text-white shadow-md hover:bg-slate-800 transition disabled:cursor-not-allowed disabled:opacity-60"
                            @if(!$cartItems->count()) disabled @endif>
                            {{ __('messages.Place order') }}
                        </button>

                        @if(!$cartItems->count())
                        <p class="text-xs text-slate-500 text-center">
                            {{ __('messages.Empty cart text') }}
                        </p>
                        @endif
                    </form>
                </div>
            </aside>

        </div>
    </div>
</div>