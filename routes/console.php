<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

// Tambahkan di dalam method schedule (atau routes/console.php):
Schedule::call(function () {
    $hariIni = Carbon::today();
    
    // Cek apakah ada aktivitas transaksi hari ini
    $adaMasuk = StokMasuk::whereDate('created_at', $hariIni)->exists();
    $adaKeluar = StokKeluar::whereDate('created_at', $hariIni)->exists();

    if (!$adaMasuk && !$adaKeluar) {
        // Jika sampai jam 20:00 user belum melakukan input transaksi harian,
        // Sistem otomatis mencatat log pengingat atau generate status laporan harian kosong
        Log::info("Peringatan Otomatis 20:00: Belum ada input transaksi harian pada tanggal " . $hariIni->toDateString());
    } else {
        Log::info("Laporan harian otomatis tanggal " . $hariIni->toDateString() . " berhasil direkap oleh sistem.");
    }
})->dailyAt('20:00');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
