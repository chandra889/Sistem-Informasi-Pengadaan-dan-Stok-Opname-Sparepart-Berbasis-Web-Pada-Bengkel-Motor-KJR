<table>
    <tr>
        <th colspan="6" style="font-size: 16px; font-weight: bold; text-align: center;">BENGKEL ADMIN SYSTEM</th>
    </tr>
    <tr>
        <th colspan="6" style="font-size: 14px; font-weight: bold; text-align: center;">{{ $judul }}</th>
    </tr>
    <tr>
        <th colspan="6" style="font-style: italic; text-align: center;">Periode: {{ $mulai }} s/d {{ $selesai }}</th>
    </tr>
    <tr><th colspan="6"></th></tr>
</table>

<table border="1">
    <thead>
        <tr style="background-color: #d9d9d9; font-weight: bold;">
            <th>No</th>
            @if($jenis == 'sparepart')
                <th>Kode Sparepart</th>
                <th>Nama Sparepart</th>
                <th>Harga (Rp)</th>
                <th>Stok Tersedia</th>
                <th>Min Stok</th>
            @elseif($jenis == 'masuk')
                <th>Tanggal</th>
                <th>Kode Sparepart</th>
                <th>Nama Sparepart</th>
                <th>Jumlah Masuk</th>
                <th>Sumber Pemasok</th>
                <th>Keterangan</th>
            @elseif($jenis == 'keluar')
                <th>Tanggal</th>
                <th>Kode Sparepart</th>
                <th>Nama Sparepart</th>
                <th>Jumlah Keluar</th>
                <th>Keterangan</th>
            @elseif($jenis == 'opnam')
                <th>Tanggal</th>
                <th>Kode Sparepart</th>
                <th>Nama Sparepart</th>
                <th>Stok Sistem</th>
                <th>Stok Fisik Real</th>
                <th>Selisih & Keterangan</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            @if($jenis == 'sparepart')
                <td>{{ $item->kode_sparepart }}</td>
                <td>{{ $item->nama_sparepart }}</td>
                <td>{{ $item->harga }}</td>
                <td>{{ $item->stok }}</td>
                <td>{{ $item->min_stok ?? 5 }}</td>
            @elseif($jenis == 'masuk')
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $item->sparepart->kode_sparepart ?? '-' }}</td>
                <td>{{ $item->sparepart->nama_sparepart ?? 'Data Dihapus' }}</td>
                <td>{{ $item->jumlah_masuk }}</td>
                <td>{{ $item->sumber_pemasokan }}</td>
                <td>{{ $item->keterangan }}</td>
            @elseif($jenis == 'keluar')
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $item->sparepart->kode_sparepart ?? '-' }}</td>
                <td>{{ $item->sparepart->nama_sparepart ?? 'Data Dihapus' }}</td>
                <td>{{ $item->jumlah_keluar }}</td>
                <td>{{ $item->keterangan }}</td>
            @elseif($jenis == 'opnam')
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $item->sparepart->kode_sparepart ?? '-' }}</td>
                <td>{{ $item->sparepart->nama_sparepart ?? 'Data Dihapus' }}</td>
                <td>{{ $item->stok_sistem }}</td>
                <td>{{ $item->stok_fisik }}</td>
                <td>{{ $item->selisih }} ({{ $item->keterangan }})</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>