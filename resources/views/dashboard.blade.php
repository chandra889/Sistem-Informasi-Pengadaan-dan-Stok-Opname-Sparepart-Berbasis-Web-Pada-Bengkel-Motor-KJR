@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 font-weight-bold text-gray-800">Dashboard</h2>
        <span class="text-muted"><i class="bi bi-calendar-event me-1"></i> {{ date('d F Y') }}</span>
    </div>

    <!-- Ringkasan Statistik Kartu -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 rounded-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50">Total Jenis Sparepart</p>
                        <h3 class="fw-bold mb-0">{{ $totalSparepart ?? 0 }} Item</h3>
                    </div>
                    <div class="fs-1 opacity-50"><i class="bi bi-box-seam"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white p-3 rounded-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50">Total Keseluruhan Stok</p>
                        <h3 class="fw-bold mb-0">{{ $totalStok ?? 0 }} Unit</h3>
                    </div>
                    <div class="fs-1 opacity-50"><i class="bi bi-layers-fill"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning text-dark p-3 rounded-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-dark-50">Stok Menipis (<= 5)</p>
                        <h3 class="fw-bold mb-0">{{ $stokMenipis ?? 0 }} Item</h3>
                    </div>
                    <div class="fs-1 opacity-50"><i class="bi bi-exclamation-triangle-fill"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tabel Data Sparepart -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-tools me-2 text-primary"></i>Data Master Sparepart
                    </h5>
                    <a href="{{ route('stok_masuk.index') }}" class="btn btn-sm btn-outline-success">+ Restock</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Sparepart</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                           <tbody>
                             @forelse($spareparts as $item)
                            <tr>
                            <td><span class="badge bg-secondary">{{ $item->kode_sparepart }}</span></td>
                            <td><strong>{{ $item->nama_sparepart }}</strong></td>
                            <td>Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="fw-bold {{ $item->stok <= 5 ? 'text-danger' : 'text-dark' }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td>
                                @if($item->stok == 0)
                                    <span class="badge bg-danger">Habis</span>
                                @elseif($item->stok <= 5)
                                    <span class="badge bg-warning text-dark">Menipis</span>
                                @else
                                    <span class="badge bg-success">Tersedia</span>
                                @endif
                            </td>
                            </tr>
                                @empty
                            <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data sparepart.</td>
                            </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Aktivitas Terakhir -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Transaksi Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Tipe</th>
                                    <th>Sparepart</th>
                                    <th>Qty</th>
                                    <th>Waktu & Ket.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatAktivitas ?? [] as $riwayat)
                                    <tr>
                                        <td>
                                            <span class="badge {{ $riwayat['badge_class'] }}">
                                                {{ $riwayat['tipe'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="d-block text-muted">{{ $riwayat['kode'] }}</small>
                                            <strong>{{ $riwayat['nama'] }}</strong>
                                        </td>
                                        <td>
                                            <span class="fw-bold {{ $riwayat['tipe'] === 'MASUK' ? 'text-success' : 'text-danger' }}">
                                                {{ $riwayat['jumlah'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="d-block text-muted">{{ $riwayat['waktu']->format('d/m/Y H:i') }}</small>
                                            <small class="text-secondary d-inline-block text-truncate" style="max-width: 130px;">
                                                {{ $riwayat['keterangan'] }}
                                            </small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada aktivitas transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection