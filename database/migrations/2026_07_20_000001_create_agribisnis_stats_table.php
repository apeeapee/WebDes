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
        Schema::create('agribisnis_stats', function (Blueprint $table) {
            $table->id();
            $table->string('luas_lahan');
            $table->string('jumlah_produksi');
            $table->string('jumlah_petani');
            $table->string('jumlah_kelompok_tani');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agribisnis_stats');
    }
};
