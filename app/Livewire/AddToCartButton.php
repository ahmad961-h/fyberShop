<?php

namespace App\Livewire;

use App\Models\AddProduct;
use App\Models\CartItem;
use App\Models\CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddToCartButton extends Component
{
    public int $productId;
    public string $productName;
    public float $productPrice;
    public string $currency = 'EUR';

    protected $listeners = [
        'currencyChanged' => 'updateCurrency',
    ];

    public function mount(): void
    {
        $this->currency = 'EUR';
    }

    public function updateCurrency(array $payload): void
    {
        $this->currency = 'EUR';
    }

    public function getDisplayPriceEurProperty(): float
    {
        return $this->productPrice;
    }

    public function addToCart(): void
    {
        if (! Auth::check()) {
            $this->dispatch('notify', message: 'Please log in to add products to your cart.');
            return;
        }

        $result = DB::transaction(function () {
            $product = AddProduct::whereKey($this->productId)
                ->lockForUpdate()
                ->first();

            if (! $product) {
                return [
                    'success' => false,
                    'message' => 'Product not found.',
                ];
            }

            if ($product->stock <= 0) {
                return [
                    'success' => false,
                    'message' => "{$product->name} is out of stock.",
                ];
            }

            $cart = CartModel::firstOrCreate([
                'user_id' => Auth::id(),
            ]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($cartItem) {
                if ($cartItem->quantity >= $product->stock) {
                    return [
                        'success' => false,
                        'message' => 'You already added the maximum available stock.',
                    ];
                }

                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }

            return [
                'success' => true,
                'message' => "{$product->name} added to cart!",
            ];
        });

        if ($result['success']) {
            $this->dispatch('cartUpdated');
        }

        $this->dispatch('notify', message: $result['message']);
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
