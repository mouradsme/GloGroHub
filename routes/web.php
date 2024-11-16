<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Marketplace;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HolidayController;

 

Route::middleware('auth')->group(function () {
    // Holidays
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');

    Route::get('/holidays/create', [HolidayController::class, 'create'])->name('holidays.create');

    Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');
    
    // Home + Dashboard

    Route::get('/', [Marketplace::class, 'index'])->middleware(['verified'])->name('marketplace');

    Route::get('/recommendations', [Marketplace::class, 'recommended'])->middleware(['verified'])->name('recommended');

    Route::get('/dashboard', [Dashboard::class, 'index'])->middleware(['verified'])->name('dashboard');

    // Users
    Route::get('/users', [Dashboard::class, 'users_index'])->middleware(['verified'])->name('users');

    Route::get('/add-user', [Dashboard::class, 'add_user'])->middleware(['verified'])->name('add_user');

    Route::post('/add-user', [RegisteredUserController::class, 'store'])->middleware(['verified'])->name('add_user.post');

    Route::delete('/users/{id}', [Dashboard::class, 'users_destroy'])->name('users.destroy');


    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

    Route::get('/category/{id}', [Marketplace::class, 'getCategory'])->name('category');

    Route::get('/add-category', [Dashboard::class, 'add_category'])->middleware(['verified'])->name('add_category');

    Route::post('/add-category', [CategoryController::class, 'store'])->middleware(['verified'])->name('category.post');
    
    //Products

    Route::get('/add-product', [Dashboard::class, 'add_product'])->middleware(['verified'])->name('add_product');

    Route::post('/add-product', [ProductController::class, 'store'])->middleware(['verified'])->name('product.store');
    
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

    // Orders

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/analytics', [OrderController::class, 'analytics'])->name('orders.analytics');

    // Cart

    
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'addToCart'])->name('add');
        Route::post('/remove/{orderId}', [CartController::class, 'removeFromCart'])->name('remove');
        Route::post('/complete', [CartController::class, 'completeOrder'])->name('complete');
    });


    // Profile 
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
