<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Upgrade the first admin user to super_admin role.
     */
    public function up(): void
    {
        // Upgrade the first user with 'admin' role to 'super_admin'
        $firstAdmin = DB::table('users')->where('role', 'admin')->orderBy('id', 'asc')->first();

        if ($firstAdmin) {
            DB::table('users')->where('id', $firstAdmin->id)->update([
                'role' => 'super_admin',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert any super_admin back to admin
        DB::table('users')->where('role', 'super_admin')->update([
            'role' => 'admin',
        ]);
    }
};
