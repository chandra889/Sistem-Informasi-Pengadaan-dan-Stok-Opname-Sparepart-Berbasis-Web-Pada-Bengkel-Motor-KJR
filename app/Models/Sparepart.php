<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stokKeluars()
    {
        return $this->hasMany(StokKeluar::class);
    }

    public function stokOpnams()
    {
        return $this->hasMany(StokOpnam::class);
    }
}