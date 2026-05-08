<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Models\CartModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public Collection $cartItems;
    public array $quantities = [];

    public float $itemsTotal = 0;
    public float $deliveryTotal = 0;
    public float $total = 0;

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
            $this->resetTotals();

            return;
        }

        $cart = CartModel::where('user_id', Auth::id())->first();

        if (! $cart) {
            $this->cartItems = collect();
            $this->quantities = [];
            $this->resetTotals();

            return;
        }

        $this->cartItems = $cart->items()
            ->with(['product.images'])
            ->get();

        $this->quantities = $this->cartItems
            ->pluck('quantity', 'id')
            ->map(fn($quantity) => (int) $quantity)
            ->toArray();

        $this->calculateTotals();
    }

    public function calculateTotals(): void
    {
        $this->resetTotals();

        foreach ($this->cartItems as $item) {
            if (! $item->product) {
                continue;
            }

            $quantity = max(1, (int) ($this->quantities[$item->id] ?? $item->quantity));

            $this->itemsTotal += (float) $item->product->price * $quantity;
            $this->deliveryTotal += (float) ($item->product->delivery_fee ?? 0);
        }

        $this->total = $this->itemsTotal + $this->deliveryTotal;
    }

    public function increment(int $id): void
    {
        $quantity = (int) ($this->quantities[$id] ?? 1) + 1;

        $this->updateQuantity($id, $quantity);
    }

    public function decrement(int $id): void
    {
        $quantity = max(1, (int) ($this->quantities[$id] ?? 1) - 1);

        $this->updateQuantity($id, $quantity);
    }

    private function updateQuantity(int $itemId, int $quantity): void
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

            $newQuantity = max(1, $quantity);
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

    public function removeItem(int $id): void
    {
        if (! Auth::check()) {
            return;
        }

        CartItem::where('id', $id)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->delete();

        $this->loadCart();

        $this->dispatch('cartUpdated');
    }

    private function resetTotals(): void
    {
        $this->itemsTotal = 0;
        $this->deliveryTotal = 0;
        $this->total = 0;
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
