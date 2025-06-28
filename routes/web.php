<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\RoleAdmin;

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

// DASHBOARD (masuk setelah login)

Route::middleware('auth')->get('/dashboard', function () {
    return view('layouts.app'); // Bisa diarahkan ke halaman dashboard sebenarnya nanti
})->name('dashboard');


//Menu
Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create')->middleware('auth', RoleAdmin::class);
Route::post('/menus', [MenuController::class, 'store'])->name('menus.store')->middleware('auth', RoleAdmin::class);
Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit')->middleware('auth', RoleAdmin::class);
Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update')->middleware('auth', RoleAdmin::class);
Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy')->middleware('auth', RoleAdmin::class);



// MEJA (Tables)
Route::get('/tables', [TableController::class, 'index'])->name('tables.index')->middleware('auth', RoleAdmin::class);
Route::get('/tables/create', [TableController::class, 'create'])->name('tables.create')->middleware('auth', RoleAdmin::class);
Route::post('/tables', [TableController::class, 'store'])->name('tables.store')->middleware('auth', RoleAdmin::class);
Route::get('/tables/{table}/edit', [TableController::class, 'edit'])->name('tables.edit')->middleware('auth', RoleAdmin::class);
Route::put('/tables/{table}', [TableController::class, 'update'])->name('tables.update')->middleware('auth', RoleAdmin::class);
Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy')->middleware('auth', RoleAdmin::class);
Route::get('/tables/{table}', [TableController::class, 'show'])->name('tables.show')->middleware('auth', RoleAdmin::class);
Route::put('/tables/{table}/change-status', [TableController::class, 'changeStatus'])
    ->name('tables.changeStatus')
    ->middleware('auth', RoleAdmin::class);




//     Route::resource('tables', TableController::class);
// });



// KASIR dan ADMIN: Order & Pembayaran

Route::middleware(['auth', 'role:kasir,admin'])->group(function () {
    Route::resource('orders', OrderController::class)->except(['index', 'show']);
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
});


// PELAYAN dan ADMIN: Lihat Order Saja

Route::middleware(['auth', 'role:pelayan,admin'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
