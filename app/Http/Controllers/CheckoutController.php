<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CartModel;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        abort_unless(Auth::check(), 403);

        return view('checkout');
    }

    public function process(Request $request)
    {
        abort_unless(Auth::check(), 403);

        $data = $request->validate([
            'shipping_type'  => ['required', 'in:home,econt'],
            'home_address'   => ['required_if:shipping_type,home', 'nullable', 'string', 'max:500'],
            'econt_office'   => ['required_if:shipping_type,econt', 'nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:stripe,googlepay,cod'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $cart = CartModel::with(['items.product'])
                ->where('user_id', Auth::id())
                ->lockForUpdate()
                ->first();

            abort_if(! $cart || $cart->items->isEmpty(), 400, 'Cart is empty');

            foreach ($cart->items as $item) {
                abort_if(! $item->product, 400, 'Product not found');

                abort_if(
                    $item->product->stock < $item->quantity,
                    400,
                    'Insufficient stock for: ' . $item->product->name
                );
            }

            $address = Address::create([
                'user_id' => Auth::id(),
                'line1'   => $data['shipping_type'] === 'home'
                    ? $data['home_address']
                    : 'Econt office: ' . $data['econt_office'],
                'city'    => 'N/A',
                'zip'     => '0000',
                'country' => 'BG',
            ]);

            $total = $cart->items->sum(function ($item) {
                return ((float) $item->product->price * (int) $item->quantity)
                    + (float) ($item->product->delivery_fee ?? 0);
            });

            $order = Order::create([
                'user_id'        => Auth::id(),
                'address_id'     => $address->id,
                'total_eur'      => $total,
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_method'] === 'cod' ? 'unpaid' : 'pending',
                'order_status'   => 'pending',
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->product->price,
                    'quantity'   => $item->quantity,
                ]);
            }

            return $order;
        });

        if ($data['payment_method'] === 'cod') {
            $this->finalizeOrder($order, false);

            return redirect()->route('checkout.success', $order);
        }

        return match ($data['payment_method']) {
            'stripe', 'googlepay' => $this->stripe($order),
            default               => abort(400),
        };
    }

    private function stripe(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'mode' => 'payment',
            'client_reference_id' => (string) $order->id,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'FyberShop Order #' . $order->id,
                    ],
                    'unit_amount' => (int) round((float) $order->total_eur * 100),
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'order_id' => $order->id,
            ],
            'payment_intent_data' => [
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ],
            'success_url' => route('checkout.success', $order),
            'cancel_url'  => route('checkout.cancel'),
        ]);

        abort_unless($session->url, 500, 'Unable to create Stripe checkout session.');

        return redirect()->away($session->url);
    }

    

    private function finalizeOrder(Order $order, bool $markAsPaid = false): void
    {
        InventoryService::commit($order);

        $cart = CartModel::where('user_id', $order->user_id)->first();

        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        $order->refresh();

        $order->update([
            'payment_status' => $markAsPaid ? 'paid' : $order->payment_status,
            'order_status'   => 'processing',
        ]);
    }

    public function retry(Order $order)
    {
        abort_unless(Auth::check() && Auth::id() === $order->user_id, 403);
        abort_if($order->payment_status === 'paid', 400, 'This order is already paid.');

        return match ($order->payment_method) {
            'stripe', 'googlepay' => $this->stripe($order),
            default               => abort(400, 'This payment method cannot be retried.'),
        };
    }

    public function cancel()
    {
        return view('checkout-cancel');
    }
}
