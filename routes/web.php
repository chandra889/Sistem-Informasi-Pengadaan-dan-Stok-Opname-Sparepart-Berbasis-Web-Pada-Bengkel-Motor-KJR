<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokOpnamController;

// Route Tamu (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Route Terproteksi (Wajib LOGIN)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Route Spareparts
    Route::resource('spareparts', SparepartController::class);

    // Route Stok Masuk
    Route::get('/stok-masuk', [StokMasukController::class, 'index'])->name('stok_masuk.index');
    Route::post('/stok-masuk', [StokMasukController::class, 'store'])->name('stok_masuk.store');

    // Route Stok Keluar
    Route::get('/stok-keluar', [StokKeluarController::class, 'index'])->name('stok_keluar.index');
    Route::post('/stok-keluar', [StokKeluarController::class, 'store'])->name('stok_keluar.store');

    // Route Stok Opnam
    Route::get('/stok-opnam', [StokOpnamController::class, 'index'])->name('stok_opnam.index');
    Route::post('/stok-opnam', [StokOpnamController::class, 'store'])->name('stok_opnam.store');
});