<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('LoginView');
})->middleware('guest')->name('home');


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');


Route::get('/login', function () {
    return redirect('/');
})->middleware('guest');


Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [CategoryController::class, 'index'])->name('dashboard');

    // Cart Routes
    Route::get('/dashboard/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/dashboard/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/dashboard/cart/{cart}/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::delete('/dashboard/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/dashboard/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Payment Routes
    Route::get('/dashboard/payment', [CartController::class, 'payment'])->name('payment');

    // Category Routes
    Route::get('/dashboard/category/add', function () {
        return Inertia::render('CategoryAdd');
    })->name('category.add');
    Route::post('/dashboard/category', [CategoryController::class, 'store'])->name('categories.store');

    // Product Routes
    Route::get('/dashboard/product/add', [ProductController::class, 'create'])->name('product.add');
    Route::post('/dashboard/product', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/dashboard/product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__ . '/auth.php';
