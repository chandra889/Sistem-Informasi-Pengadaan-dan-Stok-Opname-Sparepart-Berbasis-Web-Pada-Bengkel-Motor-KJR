<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->get();
        return view('spareparts.index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sparepart' => 'required|unique:spareparts',
            'nama_sparepart' => 'required',
            'kategori'       => 'required',
            'harga_beli'     => 'required|numeric',
            'harga_jual'     => 'required|numeric',
            'stok'           => 'required|integer',
            'min_stok'       => 'required|integer',
        ]);

        Sparepart::create($request->all());

        return redirect()->back()->with('success', 'Sparepart berhasil ditambahkan!');
    }
}