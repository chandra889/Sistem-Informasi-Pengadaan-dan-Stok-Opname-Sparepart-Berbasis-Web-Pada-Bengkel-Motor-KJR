<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\StokMasuk;
use App\Models\StokKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan dipanggil dengan ->get()
        $spareparts = Sparepart::orderBy('nama_sparepart', 'asc')->get();

        // Hitung statistik
        $totalSparepart = $spareparts->count();
        $totalStok      = $spareparts->sum('stok');
        $stokMenipis    = $spareparts->where('stok', '<=', 5)->count();

        // Mengambil riwayat transaksi stok masuk
        $stokMasuk = StokMasuk::with('sparepart')->get()->map(function ($item) {
            return [
                'tipe'        => 'MASUK',
                'waktu'       => $item->created_at,
                'kode'        => $item->sparepart->kode_sparepart ?? '-',
                'nama'        => $item->sparepart->nama_sparepart ?? 'Part Dihapus',
                'jumlah'      => '+' . $item->jumlah_masuk,
                'keterangan'  => $item->sumber_pemasokan . ($item->keterangan ? ' - ' . $item->keterangan : ''),
                'badge_class' => 'bg-success',
            ];
        });

        // Mengambil riwayat transaksi stok keluar
        $stokKeluar = StokKeluar::with('sparepart')->get()->map(function ($item) {
            return [
                'tipe'        => 'KELUAR',
                'waktu'       => $item->created_at,
                'kode'        => $item->sparepart->kode_sparepart ?? '-',
                'nama'        => $item->sparepart->nama_sparepart ?? 'Part Dihapus',
                'jumlah'      => '-' . $item->jumlah_keluar,
                'keterangan'  => $item->keterangan,
                'badge_class' => 'bg-danger',
            ];
        });

        // Gabungkan riwayat & ambil 10 transaksi terbaru
        $riwayatAktivitas = $stokMasuk->concat($stokKeluar)
            ->sortByDesc('waktu')
            ->take(10);

        return view('dashboard', compact(
            'spareparts',
            'totalSparepart',
            'totalStok',
            'stokMenipis',
            'riwayatAktivitas'
        ));
    }
}