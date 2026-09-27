@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header bg-primary text-white">Form Audit Stok Opnam</div>
    <div class="card-body">
        <form action="{{ route('stok_opnam.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Pilih Sparepart</label>
                    <select name="sparepart_id" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($spareparts as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_sparepart }} (Stok Sistem: {{ $item->stok }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Jumlah Hitung Fisik</label>
                    <input type="number" name="stok_fisik" class="form-control" required>
                </div>
                <div class="col-md-5 mb-3">
                    <label>Alasan Selisih</label>
                    <input type="text" name="alasan_selisih" class="form-control" placeholder="Misal: Hilang, Rusak, Salah Catat">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Proses Stok Opnam</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-dark text-white">Riwayat Stok Opnam</div>
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Kode Audit</th>
                    <th>Tanggal</th>
                    <th>Nama Sparepart</th>
                    <th>Stok Sistem</th>
                    <th>Stok Fisik</th>
                    <th>Selisih</th>
                    <th>Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stokOpnams as $row)
                <tr>
                    <td>{{ $row->kode_opnam }}</td>
                    <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $row->sparepart->nama_sparepart }}</td>
                    <td>{{ $row->stok_sistem }}</td>
                    <td>{{ $row->stok_fisik }}</td>
                    <td>
                        <span class="badge {{ $row->selisih < 0 ? 'bg-danger' : ($row->selisih > 0 ? 'bg-warning' : 'bg-success') }}">
                            {{ $row->selisih }}
                        </span>
                    </td>
                    <td>{{ $row->alasan_selisih ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection