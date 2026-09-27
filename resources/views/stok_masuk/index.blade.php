@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 font-weight-bold text-gray-800">Riwayat Stok Masuk (Restock)</h2>
        <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStokMasuk">
            + Restock / Tambah Stok
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Tanggal Masuk</th>
                            <th>Kode & Nama Sparepart</th>
                            <th>Jumlah Masuk</th>
                            <th>Sumber Pemasokan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stokMasuks as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-secondary me-1">{{ $item->sparepart->kode_sparepart }}</span>
                                    <strong>{{ $item->sparepart->nama_sparepart }}</strong>
                                </td>
                                <td><span class="badge bg-success fs-6">+{{ $item->jumlah_masuk }}</span></td>
                                <td>{{ $item->sumber_pemasokan }}</td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat penambahan stok masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Stok Masuk -->
<div class="modal fade" id="modalTambahStokMasuk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold">Tambah Stok Sparepart</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stok_masuk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Sparepart</label>
                        <select name="sparepart_id" class="form-select" required>
                            <option value="">-- Pilih Sparepart --</option>
                            @foreach($spareparts as $sparepart)
                                <option value="{{ $sparepart->id }}">
                                    [{{ $sparepart->kode_sparepart }}] {{ $sparepart->nama_sparepart }} - (Stok Saat Ini: {{ $sparepart->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Tambah Stok</label>
                        <input type="number" name="jumlah_masuk" class="form-control" placeholder="Contoh: 10" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sumber Pemasokan / Supplier</label>
                        <input type="text" name="sumber_pemasokan" class="form-control" placeholder="Contoh: PT Honda / Toko Grosir Jaya" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pembelian rutin bulanan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan & Tambah Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection