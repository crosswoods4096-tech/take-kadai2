<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);

// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
// Route::delete('/products/{product}', [ProductController::class, 'destroy'])
//     ->name('products.destroy');
// Route::resource('products', ProductController::class);
