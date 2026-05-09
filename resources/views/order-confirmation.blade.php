<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f9fafb; padding:20px">

    <div style="max-width:600px;margin:auto;background:#ffffff;border-radius:8px;padding:20px">
        <h2 style="margin-bottom:10px">Thank you for your order</h2>

        <p><strong>Order ID:</strong> #{{ $order->id }}</p>
        <p><strong>Total:</strong> €{{ number_format($order->total_eur, 2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>

        <hr style="margin:20px 0">

        <p>We will notify you when your order status changes.</p>

        <p style="margin-top:30px;font-size:12px;color:#6b7280">
            FyberShop – Modern E-commerce Experience
        </p>
    </div>

</body>

</html>
