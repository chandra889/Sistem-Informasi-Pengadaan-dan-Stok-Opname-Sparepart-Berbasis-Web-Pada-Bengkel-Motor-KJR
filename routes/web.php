<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokOpnamController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\DashboardController;
use App\Models\Sparepart;

Route::get('/', function () {
    // Ambil sparepart yang stoknya <= min_stok (ROP)
    $low_stocks = Sparepart::whereColumn('stok', '<=', 'min_stok')->get();
    return view('dashboard', compact('low_stocks'));
})->name('dashboard');

// Master Sparepart
Route::get('/spareparts', [SparepartController::class, 'index'])->name('spareparts.index');
Route::post('/spareparts', [SparepartController::class, 'store'])->name('spareparts.store');

// Stok Keluar
Route::get('/stok-keluar', [StokKeluarController::class, 'index'])->name('stok_keluar.index');
Route::post('/stok-keluar', [StokKeluarController::class, 'store'])->name('stok_keluar.store');

// Stok Opnam
Route::get('/stok-opnam', [StokOpnamController::class, 'index'])->name('stok_opnam.index');
Route::post('/stok-opnam', [StokOpnamController::class, 'store'])->name('stok_opnam.store');

// Stok Masuk
Route::get('/stok-masuk', [StokMasukController::class, 'index'])->name('stok_masuk.index');
Route::post('/stok-masuk', [StokMasukController::class, 'store'])->name('stok_masuk.store');


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');