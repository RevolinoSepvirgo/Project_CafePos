<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\RoleAdmin;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

// AUTH

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// PUBLIC

Route::get('/', function () {
    return view('public.landingPage');
})->name('landingPage');

Route::get('/menu', [MenuController::class, 'showPublicMenu'])->name('menus.public');
Route::get('/meja-publik', [TableController::class, 'publicIndex'])->name('tables.public');

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// daftar menu dapat diakses semua yang login
Route::get('/menus', [MenuController::class, 'index'])->middleware('auth')->name('menus.index');


// USERS (admin)
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {

    // CRUD menus
    Route::resource('menus', MenuController::class)->except(['index']);

    // CRUD Users
    Route::resource('users', UserController::class);

    // Riwayat Pesanan
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/orders/history/{order}', [OrderController::class, 'showHistory'])->name('orders.showHistory');
    Route::get('/orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');


});

// Halaman daftar meja dapat diakses semua yang login
Route::get('/tables', [TableController::class, 'index'])->middleware('auth')->name('tables.index');

// CRUD Meja hanya bisa diakses admin
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::resource('tables', TableController::class)->except(['index']);
});


// Orders CRUD (admin, pelayan, kasir)
Route::middleware(['auth'])->group(function () {
    // Resource route untuk Order (CRUD lengkap)
    Route::resource('orders', OrderController::class);

    // Ubah status meja
    Route::put('/tables/{table}/change-status', [TableController::class, 'changeStatus'])
        ->name('tables.changeStatus');
});


// Order pay (hanya kasir,admin)

Route::middleware(['auth', RoleMiddleware::class . ':kasir,admin'])->group(function () {
Route::get('/orders/{id}/payment', [PaymentController::class, 'showPaymentForm'])->name('orders.payment.form');
Route::post('/orders/{id}/pay', [PaymentController::class, 'pay'])->name('orders.pay');


});




