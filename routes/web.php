<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LoginView', );
});

Route::get('/dashboard', function () {
    return Inertia::render('DashboardView');
});

Route::get('/cart', function () {
    return Inertia::render('CartView');
});

Route::get('/payment', function () {
    return Inertia::render('PaymentView');
});

Route::get('/category/add', function () {
    return Inertia::render('CategoryAdd');
});

Route::get('/product/add', function () {
    return Inertia::render('ProductAdd');
});

require __DIR__ . '/auth.php';
