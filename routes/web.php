<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return view('public.landingPage');
})->name('landingPage');


Route::get('/menu', function () {
    return view('public.daftar_menu');
})->name('menu');


// Route::middleware(['role:admin'])->group(function () {
//     Route::resource('/menus', MenuController::class);
// });

Route::middleware('auth')->get('/dashboard', function () {
    return view('layouts.app'); // Ganti dengan view dashboard kamu
});

Route::resource('menus', MenuController::class);
Route::resource('orders', OrderController::class);

Route::get('/menu', [MenuController::class, 'showPublicMenu'])->name('menus.public');


Route::resource('tables', TableController::class);
Route::patch('/tables/{id}/change-status', [TableController::class, 'changeStatus'])->name('tables.changeStatus');
Route::get('/meja-publik', [App\Http\Controllers\TableController::class, 'publicIndex'])->name('tables.public');

Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');











// Route::middleware(['role:admin'])->group(function () {
//     Route::resource('/menu', MenuController::class);
// });
