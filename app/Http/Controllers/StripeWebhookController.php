<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\Order;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Throwable;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.webhook_secret')
            );
        } catch (UnexpectedValueException | SignatureVerificationException $e) {
            Log::warning('Invalid Stripe webhook received.', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Invalid webhook signature.',
            ], 400);
        }

        $object = $event->data->object ?? null;
        $orderId = $this->extractOrderId($object);

        if (! $orderId) {
            Log::warning('Stripe webhook missing order ID.', [
                'event_type' => $event->type,
            ]);

            return response()->json([
                'message' => 'No order ID found.',
            ]);
        }

        $order = Order::find($orderId);

        if (! $order) {
            Log::warning('Stripe webhook order not found.', [
                'event_type' => $event->type,
                'order_id' => $orderId,
            ]);

            return response()->json([
                'message' => 'Order not found.',
            ]);
        }

        try {
            if (in_array($event->type, [
                'checkout.session.completed',
                'checkout.session.async_payment_succeeded',
            ], true)) {
                $paymentStatus = data_get($object, 'payment_status');

                if ($paymentStatus && $paymentStatus !== 'paid') {
                    return response()->json([
                        'message' => 'Checkout completed but payment is not paid yet.',
                    ]);
                }

                $this->markOrderAsPaid($order);
            }

            if (in_array($event->type, [
                'checkout.session.expired',
                'checkout.session.async_payment_failed',
                'payment_intent.payment_failed',
            ], true)) {
                InventoryService::rollback($order);

                $order->update([
                    'payment_status' => 'failed',
                ]);
            }
        } catch (Throwable $e) {
            Log::error('Stripe webhook processing failed.', [
                'order_id' => $order->id,
                'event_type' => $event->type,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Webhook processing failed.',
            ], 500);
        }

        return response()->json([
            'received' => true,
        ]);
    }

    private function extractOrderId($object): ?int
    {
        $orderId = data_get($object, 'metadata.order_id')
            ?? data_get($object, 'client_reference_id');

        return is_numeric($orderId) ? (int) $orderId : null;
    }

    private function markOrderAsPaid(Order $order): void
    {
        InventoryService::commit($order);

        $order->refresh();

        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        $cart = CartModel::where('user_id', $order->user_id)->first();

        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }
    }
}
