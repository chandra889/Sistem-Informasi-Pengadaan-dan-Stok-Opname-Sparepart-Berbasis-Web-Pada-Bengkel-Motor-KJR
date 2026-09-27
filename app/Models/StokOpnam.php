<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpnam extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_opnam',
        'sparepart_id',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'alasan_selisih',
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }
}