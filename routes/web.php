<?php

use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\ProductController as PublicProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityQuestionController;
use App\Http\Controllers\Customer\LoginAttemptController;

// Public customer-facing routes
Route::get('/', [HomeController::class, 'index'])->name('customers.home');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'verified', 'role:customer'])->group(function() {
    Route::get('/cart', [CartController::class, 'index'])->name('customers.cart');
    Route::post('/cart', [CartController::class, 'store'])->name('customers.cart.store');
    Route::post('/cart/update', [CartController::class, 'update'])->name('customers.cart.update');
    Route::delete('/cart', [CartController::class, 'destroy'])->name('customers.cart.destroy');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('customers.checkout');

    Route::get('/order-status', [CustomerOrderController::class, 'checkStatus'])->name('customers.order-status');

    // Customer Settings Routes
    Route::prefix('customers/settings')->name('customers.settings.')->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('password', [PasswordController::class, 'edit'])->name('password');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::get('security-questions', [SecurityQuestionController::class, 'edit'])->name('security-questions');
        Route::patch('security-questions', [SecurityQuestionController::class, 'update'])->name('security-questions.update');

        Route::get('login-attempts', [LoginAttemptController::class, 'index'])->name('login-attempts');
    });

    Route::get('/customers/orders', [CustomerOrderController::class, 'index'])->name('customers.orders');
});

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
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
