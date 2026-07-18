<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komoditas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis');
            $table->string('luas_atau_jumlah'); // e.g. "120 Hektar" or "450 Ekor"
            $table->string('hasil');            // e.g. "6.8 Ton / Ha" or "Susu Segar"
            $table->text('deskripsi');
            $table->string('tipe')->default('tanaman'); // e.g. 'tanaman', 'peternakan'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komoditas');
    }
};
