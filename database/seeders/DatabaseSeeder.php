<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Apbdes;
use App\Models\DesaAntikorupsi;
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
        // 1. Admin Desa
        User::firstOrCreate(
            ['email' => 'admin@banyuurip.desa.id'],
            [
                'name' => 'Admin Desa',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // 2. Test User (Non-admin)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        // 3. Clear existing APBDes to avoid duplicate percentages and seed the 5 specific revenue sources requested
        Apbdes::truncate();

        // Pendapatan Desa (Total: Rp 1.800.000.000)
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Dana Desa (DD - Transfer APBN Pusat)',
            'jumlah' => 845000000,
            'persen' => 47,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Alokasi Dana Desa (ADD - Transfer APBD Kabupaten)',
            'jumlah' => 450000000,
            'persen' => 25,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Bagi Hasil Pajak & Retribusi Daerah (PBH)',
            'jumlah' => 180000000,
            'persen' => 10,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Bantuan Keuangan (Bankeu Provinsi & Kabupaten)',
            'jumlah' => 210000000,
            'persen' => 12,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Pendapatan Asli Desa (PADes - BUMDes & Tanah Kas)',
            'jumlah' => 115000000,
            'persen' => 6,
        ]);

        // Belanja Desa
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Penyelenggaraan Pemerintahan Desa',
            'jumlah' => 480000000,
            'persen' => 27,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Pembangunan Infrastruktur & Fasilitas',
            'jumlah' => 630000000,
            'persen' => 35,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Pembinaan Kemasyarakatan (Kader & Lembaga)',
            'jumlah' => 216000000,
            'persen' => 12,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Pemberdayaan Masyarakat (Pertanian & UMKM)',
            'jumlah' => 324000000,
            'persen' => 18,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Penanggulangan Bencana & Emergency',
            'jumlah' => 150000000,
            'persen' => 8,
        ]);

        // 4. Seed Desa Antikorupsi Documents (Google Drive Linked)
        DesaAntikorupsi::truncate();

        DesaAntikorupsi::create([
            'nomor' => 'PAK-TL-01/2026',
            'judul' => 'Perdes & SOP Pengadaan Barang dan Jasa Desa Bebas Pungli',
            'kategori' => 'Penguatan Tata Laksana',
            'deskripsi' => 'Peraturan Desa dan Standar Operasional Prosedur pelaksanaan pengadaan barang/jasa desa yang transparan, akuntabel, dan mencegah konflik kepentingan.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '10 Januari 2026'
        ]);

        DesaAntikorupsi::create([
            'nomor' => 'PAK-WAS-02/2026',
            'judul' => 'Sistem Pengaduan Warga (Whistleblowing) & Laporan Pengawasan BPD',
            'kategori' => 'Penguatan Pengawasan',
            'deskripsi' => 'SOP kanal pengaduan tindak pidana korupsi/pungli serta laporan berkala pengawasan Badan Permusyawaratan Desa (BPD) atas kinerja APBDes.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pengawasan_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '15 Februari 2026'
        ]);

        DesaAntikorupsi::create([
            'nomor' => 'PAK-YAN-03/2026',
            'judul' => 'Maklumat Standar Pelayanan Publik & Bebas Pungutan Liar (Rp 0)',
            'kategori' => 'Penguatan Pelayanan Publik',
            'deskripsi' => 'Maklumat resmi Kepala Desa mengenai standar pelayanan administrasi kependudukan tanpa pungutan biaya liar (Rp 0) serta penanganan keluhan warga.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pelayanan_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '01 Maret 2026'
        ]);

        DesaAntikorupsi::create([
            'nomor' => 'PAK-PAR-04/2026',
            'judul' => 'Dokumen Transparansi Musdes & Publikasi Infografis APBDes',
            'kategori' => 'Penguatan Partisipasi Publik',
            'deskripsi' => 'Notulensi Musyawaratan Desa (Musdes), dokumen RKPDes, serta publikasi baliho digital transparansi realisasi anggaran untuk seluruh warga.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_partisipasi_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '10 April 2026'
        ]);

        DesaAntikorupsi::create([
            'nomor' => 'PAK-BUD-05/2026',
            'judul' => 'Pakta Integritas Perangkat Desa & Edukasi Budaya Anti-Gratifikasi',
            'kategori' => 'Budaya Antikorupsi',
            'deskripsi' => 'Surat Pernyataan Pakta Integritas Penolakan Gratifikasi seluruh Perangkat Desa serta dokumentasi kegiatan penyuluhan nilai-nilai kejujuran bagi masyarakat.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_budaya_antikorupsi_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '05 Mei 2026'
        ]);

        $this->call(VillageSeeder::class);
    }
}
