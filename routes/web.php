
<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QrMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

// ========================================
// HALAMAN MENU PUBLIK
// ========================================

Route::get('/', [MenuController::class, 'index'])
    ->name('menus.index');

Route::get('/menu/{menu}', [MenuController::class, 'show'])
    ->name('menus.show');

Route::get('/qr/{token}', [QrMenuController::class, 'show'])
    ->name('qr.menu');

Route::post('/qr/{token}/orders', [OrderController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('qr.orders.store');


// ========================================
// AUTENTIKASI ADMIN
// ========================================

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Login admin
        Route::middleware('guest')->group(function () {
            Route::get('/login', [AuthController::class, 'showLogin'])
                ->name('login');

            Route::post('/login', [AuthController::class, 'login'])
                ->name('login.submit');
        });

        // Halaman yang hanya dapat diakses admin
        Route::middleware(['auth', 'admin'])->group(function () {

            // Dashboard admin
            Route::get('/dashboard', [AdminOrderController::class, 'dashboard'])
                ->name('dashboard');

            // Daftar pesanan
            Route::get('/orders', [AdminOrderController::class, 'index'])
                ->name('orders.index');

            // Mengubah status pesanan
            Route::patch('/orders/{order}/status', [
                AdminOrderController::class,
                'updateStatus',
            ])->name('orders.update-status');

            // Logout admin
            Route::post('/logout', [AuthController::class, 'logout'])
                ->name('logout');
        });
    });
