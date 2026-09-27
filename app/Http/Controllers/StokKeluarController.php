<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\StokKeluar;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index()
    {
        $stokKeluars = StokKeluar::with('sparepart')->latest()->get();
        $spareparts = Sparepart::all();

        return view('stok_keluar.index', compact('stokKeluars', 'spareparts'));
    }

    public function store(Request $request)
    {
        $jenisInput = $request->input('jenis_input', 'manual');

        if ($jenisInput === 'manual') {
            // ==========================================
            // 1. MODUS INPUT MANUAL
            // ==========================================
            $request->validate([
                'sparepart_id'  => 'required|exists:spareparts,id',
                'jumlah_keluar' => 'required|integer|min:1',
                'keterangan'    => 'required|string|max:255',
            ]);

            $sparepart = Sparepart::findOrFail($request->sparepart_id);

            if ($sparepart->stok < $request->jumlah_keluar) {
                return redirect()->back()->with('error', 'Stok ' . $sparepart->nama_sparepart . ' tidak mencukupi! Stok saat ini: ' . $sparepart->stok);
            }

            DB::transaction(function () use ($request, $sparepart) {
                StokKeluar::create([
                    'sparepart_id'  => $request->sparepart_id,
                    'jumlah_keluar' => $request->jumlah_keluar,
                    'keterangan'    => '[Manual] ' . $request->keterangan,
                ]);

                $sparepart->decrement('stok', $request->jumlah_keluar);
            });

            return redirect()->route('stok_keluar.index')->with('success', 'Pencatatan stok keluar manual berhasil disimpan.');

        } else {
            // ==========================================
            // 2. MODUS INPUT OTOMATIS (PAKET SERVIS)
            // ==========================================
            $request->validate([
                'paket_servis' => 'required|string',
                'no_plat'      => 'required|string|max:20',
            ]);

            // Dapatkan item paket berdasarkan pilihan pengguna
            $items = $this->getPaketItems($request->paket_servis);

            if (empty($items)) {
                return redirect()->back()->with('error', 'Paket servis tidak valid!');
            }

            // Cek ketersediaan stok seluruh item dalam paket terlebih dahulu
            foreach ($items as $item) {
                $sparepart = Sparepart::where('kode_sparepart', $item['kode'])->first();
                if (!$sparepart) {
                    return redirect()->back()->with('error', 'Sparepart dengan kode ' . $item['kode'] . ' tidak ditemukan!');
                }
                if ($sparepart->stok < $item['qty']) {
                    return redirect()->back()->with('error', 'Stok paket gagal! Stok ' . $sparepart->nama_sparepart . ' kurang dari ' . $item['qty']);
                }
            }

            // Eksekusi pemotongan stok otomatis secara kolektif
            DB::transaction(function () use ($items, $request) {
                foreach ($items as $item) {
                    $sparepart = Sparepart::where('kode_sparepart', $item['kode'])->first();

                    StokKeluar::create([
                        'sparepart_id'  => $sparepart->id,
                        'jumlah_keluar' => $item['qty'],
                        'keterangan'    => '[Otomatis Paket: ' . $request->paket_servis . '] Kendaraan: ' . strtoupper($request->no_plat),
                    ]);

                    $sparepart->decrement('stok', $item['qty']);
                }
            });

            return redirect()->route('stok_keluar.index')->with('success', 'Transaksi paket servis otomatis berhasil dicatat dan stok dipotong.');
        }
    }

    /**
     * Helper kustom daftar paket servis beserta sparepart terkait
     */
    private function getPaketItems($namaPaket)
    {
        $presetPaket = [
            'Servis Rutin Matic' => [
                ['kode' => 'sbr-079', 'qty' => 1], // Oli Shell
                ['kode' => 'SPR-002', 'qty' => 1], // Busi
            ],
            'Ganti Rem & Oli' => [
                ['kode' => 'sbr-079', 'qty' => 1], // Oli Shell
                ['kode' => 'SDR-065', 'qty' => 1], // Kampas Rem
            ],
            'Servis Tune-Up Lengkap' => [
                ['kode' => 'sbr-079', 'qty' => 1],
                ['kode' => 'SPR-002', 'qty' => 1],
                ['kode' => 'SDR-065', 'qty' => 1],
            ],
        ];

        return $presetPaket[$namaPaket] ?? [];
    }
}