<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled – FyberShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-2xl p-8 text-center max-w-md">
        <h1 class="text-2xl font-bold text-red-600 mb-3">Payment Cancelled</h1>
        <p class="text-gray-600 mb-6">Your payment was cancelled or did not complete. You can return to your cart and try again.</p>
        <a href="{{ url('/cart') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Return to Cart</a>
    </div>
</body>

</html>