<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
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
    Route::get('/dashboard', [CategoryController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/cart', function () {
        return Inertia::render('CartView');
    })->name('cart');

    Route::get('/dashboard/payment', function () {
        return Inertia::render('PaymentView');
    })->name('payment');

    Route::get('/dashboard/category/add', function () {
        return Inertia::render('CategoryAdd');
    })->name('category.add');

    Route::post('/dashboard/category', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/dashboard/product/add', function () {
        return Inertia::render('ProductAdd');
    })->name('product.add');
});

require __DIR__ . '/auth.php';
