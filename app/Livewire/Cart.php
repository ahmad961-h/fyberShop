<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Models\CartModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cart extends Component
{
    public Collection $cartItems;
    public array $quantities = [];
    public float $clientSubtotal = 0;

    protected $listeners = [
        'cartUpdated' => 'loadCart',
    ];

    public function mount(): void
    {
        $this->loadCart();
    }

    public function loadCart(): void
    {
        if (! Auth::check()) {
            $this->cartItems = collect();
            $this->quantities = [];
            $this->clientSubtotal = 0;

            return;
        }

        $cart = CartModel::where('user_id', Auth::id())->first();

        if (! $cart) {
            $this->cartItems = collect();
            $this->quantities = [];
            $this->clientSubtotal = 0;

            return;
        }

        $this->cartItems = $cart->items()
            ->with(['product.images'])
            ->get();

        $this->quantities = $this->cartItems
            ->pluck('quantity', 'id')
            ->map(fn($quantity) => (int) $quantity)
            ->toArray();

        $this->calculateSubtotal();
    }

    public function calculateSubtotal(): void
    {
        $this->clientSubtotal = $this->cartItems->sum(function ($item) {
            if (! $item->product) {
                return 0;
            }

            $quantity = max(1, (int) ($this->quantities[$item->id] ?? $item->quantity));

            return ((float) $item->product->price * $quantity)
                + (float) ($item->product->delivery_fee ?? 0);
        });
    }

    public function increment(int $itemId): void
    {
        $quantity = (int) ($this->quantities[$itemId] ?? 1) + 1;

        $this->updateQuantity($itemId, $quantity);
    }

    public function decrement(int $itemId): void
    {
        $quantity = max(1, (int) ($this->quantities[$itemId] ?? 1) - 1);

        $this->updateQuantity($itemId, $quantity);
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        if (! Auth::check()) {
            return;
        }

        $result = DB::transaction(function () use ($itemId, $quantity) {
            $cartItem = CartItem::with('product')
                ->where('id', $itemId)
                ->whereHas('cart', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->lockForUpdate()
                ->first();

            if (! $cartItem) {
                return [
                    'message' => 'Cart item not found.',
                ];
            }

            if (! $cartItem->product) {
                $cartItem->delete();

                return [
                    'message' => 'Product is no longer available.',
                ];
            }

            if ($cartItem->product->stock <= 0) {
                $cartItem->delete();

                return [
                    'message' => $cartItem->product->name . ' is out of stock.',
                ];
            }

            $newQuantity = max(1, (int) $quantity);
            $newQuantity = min($newQuantity, (int) $cartItem->product->stock);

            $cartItem->update([
                'quantity' => $newQuantity,
            ]);

            return [
                'message' => null,
            ];
        });

        $this->loadCart();

        $this->dispatch('cartUpdated');

        if (! empty($result['message'])) {
            $this->dispatch('notify', message: $result['message']);
        }
    }

    public function remove(int $itemId): void
    {
        if (! Auth::check()) {
            return;
        }

        CartItem::where('id', $itemId)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->delete();

        $this->loadCart();

        $this->dispatch('cartUpdated');
    }

    public function clearCart(): void
    {
        if (! Auth::check()) {
            return;
        }

        $cart = CartModel::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        $this->loadCart();

        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
