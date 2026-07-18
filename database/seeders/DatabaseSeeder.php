<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Desa
        User::factory()->create([
            'name' => 'Admin Desa',
            'email' => 'admin@banyuurip.desa.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Test User (Non-admin)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Seed APBDes
        \App\Models\Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Dana Desa (APBN)',
            'jumlah' => 845000000,
            'persen' => 52,
        ]);
        \App\Models\Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Alokasi Dana Desa (ADD)',
            'jumlah' => 450000000,
            'persen' => 28,
        ]);
        \App\Models\Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Bantuan Keuangan Provinsi/Kabupaten',
            'jumlah' => 210000000,
            'persen' => 13,
        ]);
        \App\Models\Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Pendapatan Asli Desa (PADes)',
            'jumlah' => 110000000,
            'persen' => 7,
        ]);

        \App\Models\Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Penyelenggaraan Pemerintahan Desa',
            'jumlah' => 480000000,
            'persen' => 30,
        ]);
        \App\Models\Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Pembangunan Infrastruktur & Fasilitas',
            'jumlah' => 560000000,
            'persen' => 35,
        ]);
        \App\Models\Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Pembinaan Kemasyarakatan (Kader, Posyandu)',
            'jumlah' => 190000000,
            'persen' => 12,
        ]);
        \App\Models\Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Pemberdayaan Masyarakat (Pertanian, UMKM)',
            'jumlah' => 240000000,
            'persen' => 15,
        ]);
        \App\Models\Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Penanggulangan Bencana & Darurat',
            'jumlah' => 135000000,
            'persen' => 8,
        ]);

        $this->call(VillageSeeder::class);
    }
}
