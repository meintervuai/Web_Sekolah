<?php

use App\Http\Controllers\Central\AuthController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\TenantController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tenant\Public\HomeController;

// Rute Publik Tenant Sementara (untuk demo tampilan)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Grup Rute Super Admin (Central)
Route::prefix('superadmin')->name('superadmin.')->group(function () {

    // Rute Publik Super Admin (Guest)
    Route::middleware('guest:superadmin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Rute Terproteksi Super Admin (Auth)
    Route::middleware('auth:superadmin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Tenant / Sekolah
        Route::prefix('tenants')->name('tenants.')->group(function () {
            Route::get('/', [TenantController::class, 'index'])->name('index');
            Route::get('/create', [TenantController::class, 'create'])->name('create');
            Route::post('/', [TenantController::class, 'store'])->name('store');
            Route::get('/{tenant}', [TenantController::class, 'show'])->name('show');
            Route::get('/{tenant}/edit', [TenantController::class, 'edit'])->name('edit');
            Route::put('/{tenant}', [TenantController::class, 'update'])->name('update');
            Route::patch('/{tenant}/toggle-status', [TenantController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{tenant}', [TenantController::class, 'destroy'])->name('destroy');
        });
    });
});
