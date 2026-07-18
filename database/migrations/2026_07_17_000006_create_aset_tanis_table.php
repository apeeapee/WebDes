<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_tanis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('fungsi');
            $table->string('kapasitas'); // e.g. "50 Ton" or "8 Unit"
            $table->string('pengelola'); // e.g. "Gapoktan Maju Makmur"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_tanis');
    }
};
