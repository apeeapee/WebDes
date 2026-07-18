<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('pemilik');
            $table->string('kategori');
            $table->string('kontak');
            $table->text('alamat');
            $table->text('deskripsi');
            
            // Financial fields
            $table->string('omzet_bulanan'); // e.g. "Rp 4.500.000"
            $table->string('biaya_produksi'); // e.g. "Rp 2.100.000"
            $table->string('laba_bersih');    // e.g. "Rp 2.400.000"
            $table->string('pencatatan');     // e.g. "Buku Kas Sederhana"
            
            $table->json('produk'); // array of products
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
