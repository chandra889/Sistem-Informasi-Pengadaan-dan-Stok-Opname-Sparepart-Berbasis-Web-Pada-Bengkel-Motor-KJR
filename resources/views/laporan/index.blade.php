@extends('layouts.app')

@section('title', 'Laporan Sistem - Bengkel Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h4 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i>Export Laporan ke Excel</h4>
                <p class="text-muted small mb-0">Pilih laporan otomatis berdasarkan periode atau atur tanggal manual untuk atasan.</p>
            </div>
            <div class="card-body p-4">

                <form action="{{ route('laporan.export') }}" method="GET">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Kategori Laporan</label>
                        <select name="jenis_laporan" class="form-select" required>
                            <option value="sparepart">Laporan Data Stok Sparepart</option>
                            <option value="masuk">Laporan Riwayat Stok Masuk (Restock)</option>
                            <option value="keluar">Laporan Riwayat Stok Keluar (Penjualan/Servis)</option>
                            <option value="opnam">Laporan Stok Opnam (Pengecekan Fisik)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Periode Otomatis / Manual</label>
                        <select name="periode" id="periodeSelect" class="form-select" onchange="toggleCustomDate(this.value)">
                            <option value="semua">Semua Waktu (Keseluruhan)</option>
                            <option value="bulan">Bulan Ini (Otomatis)</option>
                            <option value="6bulan">6 Bulan Terakhir (Otomatis)</option>
                            <option value="tahun">Tahun Ini (Otomatis)</option>
                            <option value="custom">Rentang Tanggal Manual (Custom)</option>
                        </select>
                    </div>

                    <div id="customDateBox" class="row" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Dari Tanggal</label>
                            <input type="date" name="tanggal_mulai" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Sampai Tanggal</label>
                            <input type="date" name="tanggal_selesai" class="form-control">
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success py-2 fw-bold shadow-sm">
                            <i class="bi bi-file-earmark-spreadsheet me-2"></i> Download Laporan Excel (.xls)
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleCustomDate(val) {
    const box = document.getElementById('customDateBox');
    if (val === 'custom') {
        box.style.display = 'flex';
    } else {
        box.style.display = 'none';
    }
}
</script>
@endpush
@endsection