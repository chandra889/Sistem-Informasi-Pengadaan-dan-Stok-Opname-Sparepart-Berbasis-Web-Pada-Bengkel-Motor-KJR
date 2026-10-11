@extends('layouts.app')

@section('title', 'Laporan Sistem - Bengkel Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h4 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i>Export Laporan ke Excel</h4>
                <p class="text-muted small mb-0">Pilih jenis laporan otomatis atau sesuaikan filter tanggal secara manual untuk atasan.</p>
            </div>
            <div class="card-body p-4">
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('laporan.export') }}" method="GET">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Kategori Laporan</label>
                        <select name="jenis_laporan" class="form-select" required>
                            <option value="sparepart">Laporan Data Master Sparepart (Stok Keseluruhan)</option>
                            <option value="masuk">Laporan Riwayat Stok Masuk (Restock)</option>
                            <option value="keluar">Laporan Riwayat Stok Keluar (Penjualan/Servis)</option>
                            <option value="opnam">Laporan Stok Opnam (Selisih Fisik)</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Dari Tanggal (Opsional)</label>
                            <input type="date" name="tanggal_mulai" class="form-control">
                            <div class="form-text small">Kosongkan jika ingin mengambil laporan otomatis dari awal.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Sampai Tanggal (Opsional)</label>
                            <input type="date" name="tanggal_selesai" class="form-control">
                            <div class="form-text small">Kosongkan jika ingin mengambil laporan sampai hari ini.</div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success py-2 fw-bold shadow-sm">
                            <i class="bi bi-file-earmark-spreadsheet me-2"></i> Download File Excel (.xls)
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection