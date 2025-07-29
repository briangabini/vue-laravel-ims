<?php

use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\ProductController as PublicProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Customer\CartController;

// Public customer-facing routes
Route::get('/', [HomeController::class, 'index'])->name('customers.home');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'verified', 'role:customer'])->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('customers.cart');
    Route::post('/cart', [CartController::class, 'store'])->name('customers.cart.store');
    Route::post('/cart/update', [CartController::class, 'update'])->name('customers.cart.update');
    Route::delete('/cart', [CartController::class, 'destroy'])->name('customers.cart.destroy');

    Route::get('/order-status', function() {
        return Inertia::render('customers/OrderStatus');
    })->name('customers.order-status');

    Route::get('/customers/settings', function() {
        return Inertia::render('customers/Settings');
    })->name('customers.settings');

    Route::get('/customers/orders', function() {
        return Inertia::render('customers/Orders');
    })->name('customers.orders');
});

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Customer viewing their own orders
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('my-orders.index');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('my-orders.show');
    Route::get('/my-orders/create', function () {
        return Inertia::render('customers/PlaceOrder');
    })->name('customer.orders.create');
    Route::post('/my-orders', [CustomerOrderController::class, 'store'])->name('customer.orders.store');
});


// Admin panel routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    require __DIR__.'/admin.php';
});

// Auth and Settings routes
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

