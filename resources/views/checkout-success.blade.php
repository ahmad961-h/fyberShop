<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Successful – FyberShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-green-50 via-white to-emerald-50 flex items-center justify-center min-h-screen">
    <div class="bg-white/70 backdrop-blur-lg p-10 rounded-3xl shadow-xl text-center border border-white/40 max-w-md">
        <h1 class="text-3xl font-extrabold text-green-600 mb-4">Order Confirmed</h1>
        <p class="text-gray-700 mb-6">Thank you for your purchase. Your order has been placed successfully.</p>
        <a href="{{ route('home') }}"
            class="bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold py-3 px-6 rounded-full shadow-md hover:scale-105 transition-all duration-300">
            Return to Home
        </a>
    </div>
</body>

</html>
