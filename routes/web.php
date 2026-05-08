<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\{
    AddProductController,
    ProfileController,
    WelcomeController,
    CategoryController,
    LanguageController,
    CheckoutController,
    OrderController,
    ProductSearchController,
    CartController
};

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index'])
    ->name('home');

Route::get('/product/{product}', [AddProductController::class, 'show'])
    ->name('products.show');

Route::get('/category/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('/search', [ProductSearchController::class, 'index'])
    ->name('search');

Route::view('/contact', 'contact')
    ->name('contact');

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])
    ->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add', [CartController::class, 'add'])
        ->name('cart.add');

    Route::patch('/cart/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{id}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout');

    Route::post('/checkout/process', [CheckoutController::class, 'process'])
        ->name('checkout.process');

    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
        ->name('checkout.success');

    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])
        ->name('checkout.cancel');

    Route::get('/checkout/retry/{order}', [CheckoutController::class, 'retry'])
        ->name('checkout.retry');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/orders', [OrderController::class, 'userIndex'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'userShow'])
        ->name('orders.show');

    Route::middleware(IsAdmin::class)->group(function () {

        Route::get('/addProducts', [CategoryController::class, 'index'])
            ->name('products.create');

        Route::post('/addProducts', [AddProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [AddProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [AddProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [AddProductController::class, 'destroy'])
            ->name('products.destroy');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        Route::get('/admin/orders', [OrderController::class, 'index'])
            ->name('admin.orders.index');

        Route::get('/admin/orders/{order}', [OrderController::class, 'show'])
            ->name('admin.orders.show');

        Route::patch('/admin/orders/{order}', [OrderController::class, 'update'])
            ->name('admin.orders.update');

        Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])
            ->name('admin.orders.destroy');
    });
});

require __DIR__ . '/auth.php';
