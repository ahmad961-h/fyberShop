<?php

namespace App\Http\Controllers;

use App\Models\AddProduct;
use App\Models\CartItem;
use App\Models\CartModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        abort_unless(Auth::check(), 403);

        $cart = CartModel::where('user_id', Auth::id())->first();

        $cartItems = $cart
            ? $cart->items()->with(['product.images'])->get()
            : collect();

        $cartTotal = $cartItems->sum(function ($item) {
            if (! $item->product) {
                return 0;
            }

            return ((float) $item->product->price * (int) $item->quantity)
                + (float) ($item->product->delivery_fee ?? 0);
        });

        return view('cart-page', compact('cartItems', 'cartTotal'));
    }

    public function add(Request $request)
    {
        abort_unless(Auth::check(), 403);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $quantityToAdd = (int) ($validated['quantity'] ?? 1);

        $result = DB::transaction(function () use ($validated, $quantityToAdd) {
            $product = AddProduct::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->stock <= 0) {
                return [
                    'success' => false,
                    'message' => 'Product is out of stock.',
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
                $newQuantity = $cartItem->quantity + $quantityToAdd;

                if ($newQuantity > $product->stock) {
                    return [
                        'success' => false,
                        'message' => 'Not enough stock available.',
                    ];
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                ]);
            } else {
                if ($quantityToAdd > $product->stock) {
                    return [
                        'success' => false,
                        'message' => 'Not enough stock available.',
                    ];
                }

                CartItem::create([
                    'cart_id'    => $cart->id,
                    'product_id' => $product->id,
                    'quantity'   => $quantityToAdd,
                ]);
            }

            return [
                'success' => true,
                'message' => 'Product added to cart.',
            ];
        });

        return response()->json($result);
    }

    public function update(Request $request, int $id)
    {
        abort_unless(Auth::check(), 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($id, $validated) {
            $cartItem = CartItem::with('product')
                ->where('id', $id)
                ->whereHas('cart', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->lockForUpdate()
                ->firstOrFail();

            if (! $cartItem->product) {
                $cartItem->delete();

                return;
            }

            $quantity = min(
                (int) $validated['quantity'],
                (int) $cartItem->product->stock
            );

            if ($quantity < 1) {
                $cartItem->delete();

                return;
            }

            $cartItem->update([
                'quantity' => $quantity,
            ]);
        });

        return redirect()->route('cart.index');
    }

    public function destroy(int $id)
    {
        abort_unless(Auth::check(), 403);

        CartItem::where('id', $id)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->delete();

        return redirect()->route('cart.index');
    }
}
