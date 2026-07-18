<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skrining_ispas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_warga');
            $table->integer('usia');
            $table->string('risiko');
            $table->json('gejala');
            $table->text('rekomendasi');
            $table->string('status')->default('Edukasi Selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skrining_ispas');
    }
};
