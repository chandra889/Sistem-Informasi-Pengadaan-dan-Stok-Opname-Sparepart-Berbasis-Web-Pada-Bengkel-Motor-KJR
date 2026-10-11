<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokOpnamController;
use App\Http\Controllers\LaporanController;

// Route Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Route Terproteksi (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('spareparts', SparepartController::class);
    Route::get('/stok-masuk', [StokMasukController::class, 'index'])->name('stok_masuk.index');
    Route::post('/stok-masuk', [StokMasukController::class, 'store'])->name('stok_masuk.store');
    Route::get('/stok-keluar', [StokKeluarController::class, 'index'])->name('stok_keluar.index');
    Route::post('/stok-keluar', [StokKeluarController::class, 'store'])->name('stok_keluar.store');
    Route::get('/stok-opnam', [StokOpnamController::class, 'index'])->name('stok_opnam.index');
    Route::post('/stok-opnam', [StokOpnamController::class, 'store'])->name('stok_opnam.store');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.export');
});