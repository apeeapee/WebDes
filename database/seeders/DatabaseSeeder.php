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

        // 3. Clear existing APBDes and seed official PDF APBDes Data (Anggaran vs Realisasi 2026)
        Apbdes::truncate();

        // Pendapatan Desa (Anggaran 2026 Total: Rp 1.593.006.000)
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Alokasi Dana Desa (ADD - Transfer Kabupaten)',
            'jumlah' => 593245000,
            'persen' => 37,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Dana Desa (DD - Transfer APBN)',
            'jumlah' => 373456000,
            'persen' => 23,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Pendapatan Asli Desa (PADes)',
            'jumlah' => 212000000,
            'persen' => 13,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Bantuan Keuangan Provinsi',
            'jumlah' => 175000000,
            'persen' => 11,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Bantuan Keuangan Kabupaten/Kota',
            'jumlah' => 125000000,
            'persen' => 8,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Bagi Hasil Pajak dan Retribusi (PBH)',
            'jumlah' => 111055000,
            'persen' => 7,
        ]);
        Apbdes::create([
            'kategori' => 'pendapatan',
            'rincian' => 'Pendapatan Lain-Lain',
            'jumlah' => 3250000,
            'persen' => 1,
        ]);

        // Belanja Desa (Anggaran 2026 Total: Rp 1.639.570.180)
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Bidang Penyelenggaraan Pemerintahan Desa',
            'jumlah' => 893501180,
            'persen' => 55,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Bidang Pelaksanaan Pembangunan Desa',
            'jumlah' => 587868000,
            'persen' => 36,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Bidang Pemberdayaan Masyarakat',
            'jumlah' => 88315000,
            'persen' => 5,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Bidang Penanggulangan Bencana & Mendesak',
            'jumlah' => 55400000,
            'persen' => 3,
        ]);
        Apbdes::create([
            'kategori' => 'belanja',
            'rincian' => 'Bidang Pembinaan Kemasyarakatan',
            'jumlah' => 14486000,
            'persen' => 1,
        ]);

        // 4. Seed all 18 Official KPK Indicators into DesaAntikorupsi
        DesaAntikorupsi::truncate();

        // Pilar 1: Penguatan Tata Laksana
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 1',
            'judul' => 'Kebijakan Desa tentang Perencanaan, Pelaksanaan, Penatausahaan dan Pertanggungjawaban APBDes',
            'kategori' => 'Penguatan Tata Laksana',
            'deskripsi' => 'Perdes & Peraturan Kepala Desa tata kelola keuangan APBDes yang sah dan terverifikasi.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '10 Januari 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 2',
            'judul' => 'Kebijakan Desa mengenai mekanisme Pengawasan dan Evaluasi Kinerja Perangkat Desa',
            'kategori' => 'Penguatan Tata Laksana',
            'deskripsi' => 'SOP penilaian kinerja dan evaluasi berkala aparatur pemerintah desa.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '15 Januari 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 3',
            'judul' => 'Kebijakan Desa tentang pengendalian gratifikasi, suap, dan konflik kepentingan',
            'kategori' => 'Penguatan Tata Laksana',
            'deskripsi' => 'Perkades larangan penerimaan gratifikasi & konflik kepentingan perangkat desa.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '20 Januari 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 4',
            'judul' => 'Keberadaan perjanjian kerjasama PBJ dan melalui proses pengadaan barang-jasa di Desa',
            'kategori' => 'Penguatan Tata Laksana',
            'deskripsi' => 'Dokumen transaksi PBJ transparan dengan penyedia barang/jasa sesuai SOP.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '25 Januari 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 5',
            'judul' => 'Kebijakan Desa tentang pakta integritas dan sejenisnya',
            'kategori' => 'Penguatan Tata Laksana',
            'deskripsi' => 'Pakta integritas penolakan korupsi dan pungli yang ditandatangani seluruh perangkat.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '01 Februari 2026'
        ]);

        // Pilar 2: Penguatan Pengawasan
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 6',
            'judul' => 'Keberadaan kegiatan pengawasan dan evaluasi kinerja perangkat desa',
            'kategori' => 'Penguatan Pengawasan',
            'deskripsi' => 'Laporan berkala pengawasan kinerja oleh Badan Permusyawaratan Desa (BPD).',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pengawasan_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '10 Februari 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 7',
            'judul' => 'Keberadaan tindak lanjut hasil pembinaan, petunjuk, pengawasan dan pemeriksaan dari pemerintah',
            'kategori' => 'Penguatan Pengawasan',
            'deskripsi' => 'Dokumen tindak lanjut rekomendasi inspektorat daerah dan pemkab Boyolali.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pengawasan_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '15 Februari 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 8',
            'judul' => 'Tidak ada aparatur desa dalam 3 tahun terakhir yang terjerat tindak pidana korupsi',
            'kategori' => 'Penguatan Pengawasan',
            'deskripsi' => 'Surat keterangan bebas catatan hukum dan kasus korupsi seluruh perangkat desa.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pengawasan_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '20 Februari 2026'
        ]);

        // Pilar 3: Penguatan Pelayanan Publik
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 9',
            'judul' => 'Keberadaan layanan pengaduan bagi masyarakat',
            'kategori' => 'Penguatan Pelayanan Publik',
            'deskripsi' => 'Kanal resmi pengaduan warga (WhatsApp / Kotak Saran / Website) terbebas dari pungli.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pelayanan_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '01 Maret 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 10',
            'judul' => 'Keberadaan survei kepuasan masyarakat terhadap layanan pemerintah desa',
            'kategori' => 'Penguatan Pelayanan Publik',
            'deskripsi' => 'Hasil rekapitulasi Survei Kepuasan Masyarakat (SKM) terhadap pelayanan kantor desa.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pelayanan_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '10 Maret 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 13',
            'judul' => 'Keberadaan Maklumat Pelayanan',
            'kategori' => 'Penguatan Pelayanan Publik',
            'deskripsi' => 'Papan Maklumat Standar Pelayanan Publik tanpa pungutan liar (Rp 0) di Balai Desa.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pelayanan_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '15 Maret 2026'
        ]);

        // Pilar 4: Penguatan Partisipasi Publik
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 11',
            'judul' => 'Keterbukaan dan akses masyarakat desa terhadap informasi standar pelayanan minimal (SPM)',
            'kategori' => 'Penguatan Partisipasi Publik',
            'deskripsi' => 'Publikasi informasi SPM bidang kesehatan, pendidikan, sosial, dan ketertiban.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_partisipasi_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '01 April 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 12',
            'judul' => 'Keberadaan media informasi tentang APBDes di Balai Desa / tempat umum yang mudah diakses',
            'kategori' => 'Penguatan Partisipasi Publik',
            'deskripsi' => 'Baliho transparansi APBDes & infografis digital di portal resmi desa.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_partisipasi_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '10 April 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 14',
            'judul' => 'Partisipasi dan keterlibatan masyarakat dalam penyusunan RKP Desa',
            'kategori' => 'Penguatan Partisipasi Publik',
            'deskripsi' => 'Notulensi & presensi kehadiran warga dalam Musyawaratan Desa (Musdes RKPDes).',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_partisipasi_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '15 April 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 16',
            'judul' => 'Keterlibatan Lembaga Kemasyarakatan Desa (LKD) dan masyarakat dalam pembangunan',
            'kategori' => 'Penguatan Partisipasi Publik',
            'deskripsi' => 'Laporan kerja sama Karang Taruna, PKK, RT/RW dalam swakelola pembangunan desa.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_partisipasi_publik_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '20 April 2026'
        ]);

        // Pilar 5: Budaya Antikorupsi
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 15',
            'judul' => 'Kesadaran masyarakat dalam mencegah terjadinya praktik gratifikasi, suap dan konflik kepentingan',
            'kategori' => 'Budaya Antikorupsi',
            'deskripsi' => 'Dokumentasi kegiatan sosialisasi penolakan suap dan gratifikasi warga.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_budaya_antikorupsi_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '01 Mei 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 17',
            'judul' => 'Budaya lokal-hukum adat yang mendorong upaya pencegahan tindak pidana korupsi',
            'kategori' => 'Budaya Antikorupsi',
            'deskripsi' => 'Penerapan kearifan lokal kejujuran (gotong royong & rembug desa) pencegah korupsi.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_budaya_antikorupsi_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '05 Mei 2026'
        ]);
        DesaAntikorupsi::create([
            'nomor' => 'Indikator 18',
            'judul' => 'Tokoh masyarakat, agama, adat, pemuda & perempuan yang mendorong pencegahan korupsi',
            'kategori' => 'Budaya Antikorupsi',
            'deskripsi' => 'Surat dukungan & pernyataan tokoh lintas agama/masyarakat penegak integritas.',
            'link_drive' => 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_budaya_antikorupsi_banyuurip',
            'status' => 'Terverifikasi',
            'tanggal' => '10 Mei 2026'
        ]);

        $this->call(VillageSeeder::class);
    }
}
