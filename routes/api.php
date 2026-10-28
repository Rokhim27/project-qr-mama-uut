
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\AuthController;

// GET daftar menu
Route::get('/menus', [MenuController::class, 'index'])
    ->name('api.menus.index');

// GET detail menu
Route::get('/menus/{menu}', [MenuController::class, 'show'])
    ->whereNumber('menu')
    ->name('api.menus.show');

// POST tambah menu
Route::post('/menus', [MenuController::class, 'store'])
    ->middleware(['auth:sanctum', 'admin'])
    ->name('api.menus.store');

// PUT ubah menu
Route::put('/menus/{menu}', [MenuController::class, 'update'])
    ->whereNumber('menu')
    ->middleware(['auth:sanctum', 'admin'])
    ->name('api.menus.update');

// DELETE menu
Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])
    ->whereNumber('menu')
    ->middleware(['auth:sanctum', 'admin'])
    ->name('api.menus.destroy');

// Login
Route::post('/login', [AuthController::class, 'login'])
    ->name('api.login');

// Pesanan melalui QR
Route::post('/qr/{token}/orders', [OrderController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('api.qr.orders.store');
