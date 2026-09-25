<?php

use App\Http\Controllers\Central\AuthController;
use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\TenantController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tenant\Public\HomeController;
use App\Http\Controllers\Tenant\Public\PageController;

// Rute Publik Tenant
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sejarah', [PageController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [PageController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [PageController::class, 'struktur'])->name('struktur');
    Route::get('/fasilitas', [PageController::class, 'fasilitas'])->name('fasilitas');
    Route::get('/guru', [PageController::class, 'guru'])->name('guru');
});

Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('/jurusan', [PageController::class, 'jurusan'])->name('jurusan');
    Route::get('/kurikulum', [PageController::class, 'kurikulum'])->name('kurikulum');
    Route::get('/kalender', [PageController::class, 'kalender'])->name('kalender');
});

Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {
    Route::get('/osis', [PageController::class, 'osis'])->name('osis');
    Route::get('/ekstrakurikuler', [PageController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
    Route::get('/prestasi', [PageController::class, 'prestasi'])->name('prestasi');
});

Route::prefix('informasi')->name('informasi.')->group(function () {
    Route::get('/berita', [PageController::class, 'berita'])->name('berita');
    Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('pengumuman');
    Route::get('/agenda', [PageController::class, 'agenda'])->name('agenda');
    Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
});

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
