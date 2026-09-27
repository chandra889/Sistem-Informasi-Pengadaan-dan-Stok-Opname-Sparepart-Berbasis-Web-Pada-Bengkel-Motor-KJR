@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h2>Master Data Sparepart</h2>
    </div>
</div>

<div class="card mb-4 shadow-sm border-0">
    <div class="card-header bg-primary text-white font-weight-bold">
        Tambah Sparepart Baru
    </div>
    <div class="card-body">
        <form action="{{ route('spareparts.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Kode Sparepart</label>
                    <input type="text" name="kode_sparepart" class="form-control" placeholder="Misal: SPR-001" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nama Sparepart</label>
                    <input type="text" name="nama_sparepart" class="form-control" placeholder="Misal: Oli Shell Advance 0.8L" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" placeholder="Misal: Oli & Pelumas" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Harga Beli (Rp)</label>
                    <input type="number" name="harga_beli" class="form-control" placeholder="45000" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" class="form-control" placeholder="55000" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stok" class="form-control" placeholder="20" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Batas Min Stok (ROP)</label>
                    <input type="number" name="min_stok" class="form-control" value="5" required>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Simpan Sparepart</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white font-weight-bold">
        Daftar Sparepart Tersedia
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama Sparepart</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Min Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spareparts as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->kode_sparepart }}</td>
                    <td>{{ $item->nama_sparepart }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $item->stok <= $item->min_stok ? 'bg-danger' : 'bg-success' }} fs-6">
                            {{ $item->stok }}
                        </span>
                    </td>
                    <td>{{ $item->min_stok }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data sparepart.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection