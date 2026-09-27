<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('stok_masuks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sparepart_id')->constrained('spareparts')->onDelete('cascade');
        $table->integer('jumlah_masuk');
        $table->string('sumber_pemasokan'); // Contoh: PT Honda, Toko Grosir, Retur
        $table->string('keterangan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_masuks');
    }
};
