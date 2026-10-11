<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\StokMasuk;
use App\Models\StokKeluar;
use App\Models\StokOpnam;

class LaporanController extends Controller
{
    // Menampilkan halaman menu laporan
    public function index()
    {
        return view('laporan.index');
    }

    // Proses Export Excel Otomatis & Manual (Berdasarkan Filter Tanggal & Kategori)
    public function exportExcel(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:sparepart,masuk,keluar,opnam',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $jenis = $request->jenis_laporan;
        $mulai = $request->tanggal_mulai;
        $selesai = $request->tanggal_selesai;

        $data = [];
        $judul = '';

        // Query berdasarkan jenis laporan yang dipilih (Otomatis / Manual dengan Filter)
        if ($jenis == 'sparepart') {
            $judul = 'Laporan Data Stok Sparepart';
            $query = Sparepart::query();
            if ($mulai && $selesai) {
                $query->whereBetween('created_at', [$mulai . ' 00:00:00', $selesai . ' 23:59:59']);
            }
            $data = $query->get();
        } elseif ($jenis == 'masuk') {
            $judul = 'Laporan Transaksi Stok Masuk (Restock)';
            $query = StokMasuk::with('sparepart');
            if ($mulai && $selesai) {
                $query->whereBetween('created_at', [$mulai . ' 00:00:00', $selesai . ' 23:59:59']);
            }
            $data = $query->get();
        } elseif ($jenis == 'keluar') {
            $judul = 'Laporan Transaksi Stok Keluar';
            $query = StokKeluar::with('sparepart');
            if ($mulai && $selesai) {
                $query->whereBetween('created_at', [$mulai . ' 00:00:00', $selesai . ' 23:59:59']);
            }
            $data = $query->get();
        } elseif ($jenis == 'opnam') {
            $judul = 'Laporan Stok Opnam (Pengecekan Fisik)';
            $query = StokOpnam::with('sparepart');
            if ($mulai && $selesai) {
                $query->whereBetween('created_at', [$mulai . ' 00:00:00', $selesai . ' 23:59:59']);
            }
            $data = $query->get();
        }

        // Return view export ke excel via header HTTP
        return response()->view('laporan.excel', [
            'judul' => $judul,
            'jenis' => $jenis,
            'data' => $data,
            'mulai' => $mulai ?? 'Semua Waktu',
            'selesai' => $selesai ?? 'Sekarang',
        ])->header('Content-Type', 'application/vnd.ms-excel')
          ->header('Content-Disposition', 'attachment; filename="' . strtolower(str_replace(' ', '_', $judul)) . '_' . date('Y-m-d') . '.xls"');
    }
}
