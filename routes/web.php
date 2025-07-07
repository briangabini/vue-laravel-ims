<?php

use App\Http\Controllers\Admin\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\ProductController as PublicProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

// Public customer-facing routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function() {
    // Customer viewing their own orders
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('my-orders.index');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('my-orders.show');
});


// Admin panel routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    require __DIR__.'/admin.php';
});

// Auth and Settings routes
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

