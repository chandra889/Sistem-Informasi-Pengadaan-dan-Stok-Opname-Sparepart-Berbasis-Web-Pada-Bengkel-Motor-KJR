<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\StokMasuk;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index()
    {
        $stokMasuks = StokMasuk::with('sparepart')->latest()->get();
        $spareparts = Sparepart::all();

        return view('stok_masuk.index', compact('stokMasuks', 'spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sparepart_id'     => 'required|exists:spareparts,id',
            'jumlah_masuk'     => 'required|integer|min:1',
            'sumber_pemasokan' => 'required|string|max:255',
            'keterangan'       => 'nullable|string|max:255',
        ]);

        $sparepart = Sparepart::findOrFail($request->sparepart_id);

        DB::transaction(function () use ($request, $sparepart) {
            StokMasuk::create([
                'sparepart_id'     => $request->sparepart_id,
                'jumlah_masuk'     => $request->jumlah_masuk,
                'sumber_pemasokan' => $request->sumber_pemasokan,
                'keterangan'       => $request->keterangan ?? 'Restock Sparepart',
            ]);

            // Menambahkan jumlah stok ke master sparepart yang sudah ada
            $sparepart->increment('stok', $request->jumlah_masuk);
        });

        return redirect()->route('stok_masuk.index')->with('success', 'Stok sparepart berhasil ditambahkan.');
    }
}