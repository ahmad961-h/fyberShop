<?php

namespace App\Services;

use App\Models\AddProduct;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class InventoryService
{
    public static function commit(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($order->inventory_committed) {
                return;
            }

            $order->load('items');

            foreach ($order->items as $item) {
                $product = AddProduct::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (! $product) {
                    throw new RuntimeException('Product not found for order item.');
                }

                if ($product->stock < $item->quantity) {
                    throw new RuntimeException('Insufficient stock for product: ' . $product->name);
                }

                $product->decrement('stock', $item->quantity);
            }

            $order->update([
                'inventory_committed' => true,
                'inventory_rolled_back' => false,
            ]);
        });
    }

    public static function rollback(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! $order->inventory_committed || $order->inventory_rolled_back) {
                return;
            }

            $order->load('items');

            foreach ($order->items as $item) {
                $product = AddProduct::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (! $product) {
                    continue;
                }

                $product->increment('stock', $item->quantity);
            }

            $order->update([
                'inventory_rolled_back' => true,
            ]);
        });
    }
}
