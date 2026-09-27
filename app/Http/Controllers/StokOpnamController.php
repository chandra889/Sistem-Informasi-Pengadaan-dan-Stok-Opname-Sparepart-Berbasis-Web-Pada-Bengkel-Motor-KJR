<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\StokOpnam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokOpnamController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::all();
        $stokOpnams = StokOpnam::with('sparepart')->latest()->get();

        return view('stok_opnam.index', compact('spareparts', 'stokOpnams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:spareparts,id',
            'stok_fisik'   => 'required|integer|min:0',
            'alasan_selisih' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $sparepart = Sparepart::findOrFail($request->sparepart_id);
            $stokSistem = $sparepart->stok;
            $selisih = $request->stok_fisik - $stokSistem;

            // 1. Catat Audit Stok Opnam
            StokOpnam::create([
                'kode_opnam'    => 'SO-' . date('YmdHis'),
                'sparepart_id'  => $request->sparepart_id,
                'stok_sistem'   => $stokSistem,
                'stok_fisik'    => $request->stok_fisik,
                'selisih'       => $selisih,
                'alasan_selisih'=> $request->alasan_selisih,
            ]);

            // 2. Penyesuaian/Adjusment Stok Sistem Sesuai Hasil Fisik
            $sparepart->update(['stok' => $request->stok_fisik]);
        });

        return redirect()->back()->with('success', 'Hasil stok opnam berhasil diproses!');
    }
}