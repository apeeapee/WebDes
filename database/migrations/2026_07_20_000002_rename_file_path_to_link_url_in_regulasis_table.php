<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regulasis', function (Blueprint $table) {
            $table->renameColumn('file_path', 'link_url');
        });
    }

    public function down(): void
    {
        Schema::table('regulasis', function (Blueprint $table) {
            $table->renameColumn('link_url', 'file_path');
        });
    }
};
