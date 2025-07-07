<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductCategoriesController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productdetail/{id}', [HomeController::class, 'show'])->name('detail');

Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('products');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('/', [ProductsController::class, 'store'])->name('products.store');
        Route::get('/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
        Route::get('/{id}', [ProductsController::class, 'show'])->name('products.show');
        Route::put('/{id}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [ProductCategoriesController::class, 'index'])->name('categories');
        Route::get('/create', [ProductCategoriesController::class, 'create'])->name('categories.create');
        Route::post('/', [ProductCategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{id}', [ProductCategoriesController::class, 'show'])->name('categories.show');
        Route::get('/{id}/edit', [ProductCategoriesController::class, 'edit'])->name('categories.edit');
        Route::put('/{id}', [ProductCategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/{id}', [ProductCategoriesController::class, 'destroy'])->name('categories.destroy');
    });
});

Route::get('carts', function () {
    return view('carts');
})->name('carts');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
