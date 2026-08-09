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
        DB::statement('ALTER TABLE umkms ALTER COLUMN alamat DROP NOT NULL;');
        DB::statement('ALTER TABLE umkms ALTER COLUMN pencatatan DROP NOT NULL;');
        DB::statement('ALTER TABLE umkms ALTER COLUMN omzet_bulanan DROP NOT NULL;');
        DB::statement('ALTER TABLE umkms ALTER COLUMN biaya_produksi DROP NOT NULL;');
        DB::statement('ALTER TABLE umkms ALTER COLUMN laba_bersih DROP NOT NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE umkms ALTER COLUMN alamat SET NOT NULL;');
    }
};
