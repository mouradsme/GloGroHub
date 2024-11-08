<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Marketplace;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::middleware('auth')->group(function () {


    Route::get('/dashboard', [Dashboard::class, 'index'])->middleware(['verified'])->name('dashboard');

    Route::get('/add-user', [Dashboard::class, 'add_user'])->middleware(['verified'])->name('add_user');

    Route::post('/add-user', [RegisteredUserController::class, 'store'])->middleware(['verified'])->name('add_user.post');

    Route::get('/add-category', [Dashboard::class, 'add_category'])->middleware(['verified'])->name('add_category');

    Route::post('/add-category', [CategoryController::class, 'store'])->middleware(['verified'])->name('category.post');
    
    Route::get('/add-product', [Dashboard::class, 'add_product'])->middleware(['verified'])->name('add_product');

    Route::post('/add-product', [ProductController::class, 'store'])->middleware(['verified'])->name('product.store');
    

    Route::get('/', [Marketplace::class, 'index'])->middleware(['verified'])->name('marketplace');

    Route::get('/category/{id}', [Marketplace::class, 'getCategory'])->name('category');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
