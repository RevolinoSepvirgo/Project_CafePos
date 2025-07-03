<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\RoleAdmin;
use App\Http\Middleware\RoleMiddleware;

// AUTH

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// PUBLIC

Route::get('/', function () {
    return view('public.landingPage');
})->name('landingPage');

Route::get('/menu', [MenuController::class, 'showPublicMenu'])->name('menus.public');
Route::get('/meja-publik', [TableController::class, 'publicIndex'])->name('tables.public');

// DASHBOARD
Route::middleware('auth')->get('/dashboard', function () {
    $menuCount = \App\Models\Menu::count();
    $tableCount = \App\Models\Table::count();
    $orderCount = \App\Models\Order::count();
    return view('dashboard', compact('menuCount', 'tableCount', 'orderCount'));
})->name('dashboard');



Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
});

// MEJA (Tables)
Route::get('/tables', [TableController::class, 'index'])->name('tables.index');

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/tables/create', [TableController::class, 'create'])->name('tables.create');
    Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
    Route::get('/tables/{table}/edit', [TableController::class, 'edit'])->name('tables.edit');
    Route::put('/tables/{table}', [TableController::class, 'update'])->name('tables.update');
    Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');
    Route::get('/tables/{table}', [TableController::class, 'show'])->name('tables.show');
    Route::put('/tables/{table}/change-status', [TableController::class, 'changeStatus'])->name('tables.changeStatus');
});


// Orders CRUD (admin, pelayan, kasir)

Route::middleware(['auth', RoleMiddleware::class . ':admin,pelayan,kasir'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});


// Order pay (hanya kasir)

Route::middleware(['auth', RoleMiddleware::class . ':kasir'])->group(function () {
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
});



    // // ADMIN: CRUD Menu dan Meja


// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('menus', MenuController::class);
//     Route::resource('tables', TableController::class);
// });




