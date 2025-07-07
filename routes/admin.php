<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Admin Dashboard
Route::get('dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->name('dashboard')->middleware('role:admin,manager');

// Routes accessible by BOTH 'admin' and 'manager'
Route::middleware('role:admin,manager')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
});

// Routes accessible ONLY by 'admin'
Route::middleware('role:admin')->group(function () {
    Route::resource('users', UserController::class);
    // We will add routes for managing roles and viewing logs here later.
});
