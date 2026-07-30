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
        Schema::create('desa_antikorupsis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor'); // Kode / Nomor Indikator Regulasi (misal: PAK-01/2026, IND-1.1)
            $table->string('judul'); // Judul Dokumen / Indikator
            $table->string('kategori'); // 5 Pilar KPK: Tata Laksana, Pengawasan, Pelayanan Publik, Partisipasi Publik, Budaya Antikorupsi
            $table->text('deskripsi')->nullable(); // Penjelasan singkat indikator/regulasi
            $table->string('link_drive')->nullable(); // URL Tautan Google Drive Dokumen Bukti Dukung
            $table->string('status')->default('Terverifikasi'); // Status Verifikasi (Terverifikasi, Dalam Review, Draft)
            $table->string('tanggal'); // Tanggal Upload / Penetapan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa_antikorupsis');
    }
};
