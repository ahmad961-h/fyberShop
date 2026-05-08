<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

class OrderObserver
{
    public function updated(Order $order)
    {
        if (! $order->wasChanged('order_status')) {
            return;
        }

        if ($order->order_status === 'processing') {
            Mail::to($order->user->email)
                ->queue(new OrderConfirmationMail($order));
        }
    }
}
