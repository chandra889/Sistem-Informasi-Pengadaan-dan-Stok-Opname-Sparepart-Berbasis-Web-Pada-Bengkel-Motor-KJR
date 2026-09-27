@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 font-weight-bold text-gray-800">Transaksi Stok Keluar</h2>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStokKeluar">
            + Catat Stok Keluar
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
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
                            <th>Tanggal & Waktu</th>
                            <th>Kode & Nama Sparepart</th>
                            <th>Jumlah Keluar</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stokKeluars as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-secondary me-1">{{ $item->sparepart->kode_sparepart }}</span>
                                    <strong>{{ $item->sparepart->nama_sparepart }}</strong>
                                </td>
                                <td><span class="badge bg-danger fs-6">-{{ $item->jumlah_keluar }}</span></td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat stok keluar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Catat Stok Keluar (Manual & Otomatis) -->
<div class="modal fade" id="modalTambahStokKeluar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">Form Transaksi Stok Keluar</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav Tabs Pilihan Mode Input -->
                <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="pills-manual-tab" data-bs-toggle="pill" data-bs-target="#pills-manual" type="button" role="tab">
                            📝 Input Manual
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="pills-otomatis-tab" data-bs-toggle="pill" data-bs-target="#pills-otomatis" type="button" role="tab">
                            ⚡ Input Otomatis (Paket Servis)
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <!-- Tab 1: Form Manual -->
                    <div class="tab-pane fade show active" id="pills-manual" role="tabpanel">
                        <form action="{{ route('stok_keluar.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="jenis_input" value="manual">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Sparepart</label>
                                <select name="sparepart_id" class="form-select" required>
                                    <option value="">-- Pilih Sparepart --</option>
                                    @foreach($spareparts as $sparepart)
                                        <option value="{{ $sparepart->id }}">
                                            [{{ $sparepart->kode_sparepart }}] {{ $sparepart->nama_sparepart }} - (Stok: {{ $sparepart->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Keluar</label>
                                <input type="number" name="jumlah_keluar" class="form-control" placeholder="Contoh: 1" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Keterangan / Keperluan</label>
                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Pembelian langsung / Ganti sparepart motor B 1234 CD" required></textarea>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Manual</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: Form Otomatis Paket Servis -->
                    <div class="tab-pane fade" id="pills-otomatis" role="tabpanel">
                        <form action="{{ route('stok_keluar.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="jenis_input" value="otomatis">

                            <div class="alert alert-info py-2" role="alert">
                                <small>Pilih paket servis untuk otomatis mengeluarkan semua item/sparepart yang terkait sekaligus.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Paket Servis</label>
                                <select name="paket_servis" class="form-select" required>
                                    <option value="">-- Pilih Paket --</option>
                                    <option value="Servis Rutin Matic">Servis Rutin Matic (Oli Shell + Busi)</option>
                                    <option value="Ganti Rem & Oli">Ganti Rem & Oli (Oli Shell + Kampas Rem)</option>
                                    <option value="Servis Tune-Up Lengkap">Servis Tune-Up Lengkap (Oli + Busi + Kampas Rem)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Polisi Kendaraan</label>
                                <input type="text" name="no_plat" class="form-control" placeholder="Contoh: B 4567 TKR" required>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Proses Paket Otomatis</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection