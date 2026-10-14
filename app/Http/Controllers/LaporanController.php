<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\StokMasuk;
use App\Models\StokKeluar;
use App\Models\StokOpnam;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'jenis_laporan'   => 'required|in:sparepart,masuk,keluar,opnam',
            'periode'         => 'nullable|in:semua,bulan,6bulan,tahun,custom',
            'dari_tanggal'    => 'nullable|date',
            'sampai_tanggal'  => 'nullable|date|after_or_equal:dari_tanggal',
        ]);

        $jenis = $request->jenis_laporan;
        $periode = $request->periode ?? 'semua';
        
        $mulai = null;
        $selesai = Carbon::now()->endOfDay();
        $labelPeriode = 'Semua Waktu';

        // Logika Periode Otomatis
        if ($periode == 'bulan') {
            $mulai = Carbon::now()->startOfMonth();
            $labelPeriode = 'Bulan Ini (' . Carbon::now()->translatedFormat('F Y') . ')';
        } elseif ($periode == '6bulan') {
            $mulai = Carbon::now()->subMonths(6)->startOfDay();
            $labelPeriode = '6 Bulan Terakhir';
        } elseif ($periode == 'tahun') {
            $mulai = Carbon::now()->startOfYear();
            $labelPeriode = 'Tahun Ini (' . Carbon::now()->year . ')';
        } elseif ($periode == 'custom' && $request->dari_tanggal && $request->sampai_tanggal) {
            $mulai = Carbon::parse($request->dari_tanggal)->startOfDay();
            $selesai = Carbon::parse($request->sampai_tanggal)->endOfDay();
            $labelPeriode = $request->dari_tanggal . ' s/d ' . $request->sampai_tanggal;
        }

        $judul = '';
        if ($jenis == 'sparepart') $judul = 'Laporan Data Stok Sparepart';
        elseif ($jenis == 'masuk') $judul = 'Laporan Riwayat Stok Masuk';
        elseif ($jenis == 'keluar') $judul = 'Laporan Riwayat Stok Keluar';
        elseif ($jenis == 'opnam') $judul = 'Laporan Stok Opnam';

        // Query Data
        $queryModel = match($jenis) {
            'sparepart' => Sparepart::query(),
            'masuk'     => StokMasuk::with('sparepart'),
            'keluar'    => StokKeluar::with('sparepart'),
            'opnam'     => StokOpnam::with('sparepart'),
        };

        if ($mulai) {
            $queryModel->whereBetween('created_at', [$mulai, $selesai]);
        }

        $data = $queryModel->get();

        return response()->view('laporan.excel', [
            'judul' => $judul,
            'jenis' => $jenis,
            'data' => $data,
            'periodeLabel' => $labelPeriode,
        ])->header('Content-Type', 'application/vnd.ms-excel')
          ->header('Content-Disposition', 'attachment; filename="' . strtolower(str_replace(' ', '_', $judul)) . '_' . date('Y-m-d') . '.xls"');
    }
}