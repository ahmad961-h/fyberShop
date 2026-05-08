<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $orders = Order::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $order->load(['user', 'address', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        $validated = $request->validate([
            'order_status' => ['required', 'string', 'in:pending,processing,shipped,delivered,cancelled'],
        ]);

        if (! $order->canTransition($validated['order_status'])) {
            abort(400, 'Invalid order status transition');
        }

        if ($validated['order_status'] === 'cancelled') {
            InventoryService::rollback($order);
        }

        $order->update([
            'order_status' => $validated['order_status'],
        ]);

        return back()->with('success', __('messages.Order updated successfully'));
    }

    public function destroy(Order $order)
    {
        abort_unless(Auth::check() && Auth::user()->is_admin, 403);

        if ($order->inventory_committed && ! $order->inventory_rolled_back) {
            InventoryService::rollback($order);
        }

        $order->delete();

        return back()->with('success', __('messages.Order deleted successfully'));
    }

    public function userIndex()
    {
        abort_unless(Auth::check(), 403);

        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function userShow(Order $order)
    {
        abort_unless(Auth::check() && $order->user_id === Auth::id(), 403);

        $order->load(['address', 'items.product']);

        return view('orders.show', compact('order'));
    }
}
