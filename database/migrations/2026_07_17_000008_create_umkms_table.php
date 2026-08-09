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
            $table->text('alamat')->nullable();
            $table->text('deskripsi')->nullable();
            
            // Financial fields
            $table->string('omzet_bulanan')->nullable();
            $table->string('biaya_produksi')->nullable();
            $table->string('laba_bersih')->nullable();
            $table->string('pencatatan')->nullable();
            
            $table->json('produk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
