<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\Sejarah;
use App\Models\PerangkatDesa;
use App\Models\Komoditas;
use App\Models\AsetTani;
use App\Models\Regulasi;
use App\Models\Umkm;
use App\Models\SkriningIspa;
use App\Models\AgribisnisStat;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Berita
        Berita::create([
            'judul' => 'Digitalisasi Desa Banyuurip Melalui Program KKN Tematik Undip',
            'ringkasan' => 'Tim II KKN Universitas Diponegoro meluncurkan program Banyuurip Digital Gateway guna mempermudah akses informasi profil, potensi ekonomi, dan kesehatan satu pintu.',
            'kategori' => 'Kegiatan Desa',
            'tanggal' => '15 Juli 2026',
            'gambar' => null
        ]);
        Berita::create([
            'judul' => 'Penerapan Sistem Budaya 5S Jepang di Lingkungan Kantor Desa',
            'ringkasan' => 'Perangkat desa Banyuurip mulai mengimplementasikan prinsip Seiri, Seiton, Seiso, Seiketsu, dan Shitsuke untuk meningkatkan efisiensi administrasi.',
            'kategori' => 'Edukasi',
            'tanggal' => '10 Juli 2026',
            'gambar' => null
        ]);
        Berita::create([
            'judul' => 'Peningkatan Kesadaran Kesehatan Paru-Paru dengan E-Book RESPIRA',
            'ringkasan' => 'Kader Posyandu Desa Banyuurip bekerja sama dengan mahasiswa keperawatan KKN Undip mengadakan penyuluhan pencegahan Infeksi Saluran Pernapasan Akut (ISPA).',
            'kategori' => 'Kesehatan',
            'tanggal' => '05 Juli 2026',
            'gambar' => null
        ]);

        // 2. Sejarah & Asal Usul Desa Banyuurip
        Sejarah::truncate();
        Sejarah::create([
            'tahun' => 'Era Mataram (Abad 18)',
            'judul' => 'Perjuangan Eyang Ijo & Para Sesepuh',
            'deskripsi' => 'Pangeran Kajoran dari Mataram (dikenal sebagai Mbah Ijo) bersama prajurit dan tokoh sakti seperti Eyang Liyang (Ngliyangan) & Eyang Jegrek (Banyuurip) bersatu di wilayah Dukuh Ngijo untuk mengintai dan mengusir penjajah Belanda.'
        ]);
        Sejarah::create([
            'tahun' => 'Peristiwa Mur Genthong',
            'judul' => 'Kisah Eyang Sumendhi Amijaya & Mata Air Mur Genthong',
            'deskripsi' => 'Eyang Sumendhi Amijaya, punggawa Mataram asal Jatinom Klaten, dikejar Belanda hingga ke Gua Kedhung Banteng. Saat kehabisan bekal, beliau menancapkan tongkatnya ke batu padas di utara Dukuh Jlegong hingga memancarkan air murni yang tidak pernah habis meskipun musim kemarau, yang kini disebut Mur Genthong.'
        ]);
        Sejarah::create([
            'tahun' => 'Tradisi Adat',
            'judul' => 'Tradisi Nyadran Safar Makam Eyang Sumendhi',
            'deskripsi' => 'Sesuai pesan Eyang Sumendhi Amijaya sebelum kembali ke Mataram, masyarakat Dukuh Banyuurip & Jlegong rutin menggelar acara Nyadran di bulan Safar pada hari Jumat Wage (atau Rebo Wage) dengan olahan khas tempe bongkrek dan tumpeng panggang.'
        ]);
        Sejarah::create([
            'tahun' => '1914 - 1954',
            'judul' => 'Masa Kademangan Pangrembe (Demang Admo Wirono)',
            'deskripsi' => 'Banyuurip merupakan bumi perdikan (tanah bebas pajak) dengan nama Kademangan Pangrembe Banyuurip, dipimpin oleh Eyang Demang Admo Wirono sebagai pemimpin pertama.'
        ]);
        Sejarah::create([
            'tahun' => '1954 - 1971',
            'judul' => 'Kepemimpinan Lurah Citro Pawiro',
            'deskripsi' => 'Pemilihan lurah pertama secara demokratis yang dimenangkan oleh Lurah Citro Pawiro untuk memimpin pembangunan awal pasca-kemerdekaan.'
        ]);
        Sejarah::create([
            'tahun' => '1971 - 1989',
            'judul' => 'Kepemimpinan Lurah Samsul Bahri',
            'deskripsi' => 'Lurah Samsul Bahri menjabat selama dua periode berturut-turut (1971-1980 dan 1980-1989) mengonsolidasi pertanian dan kelembagaan desa.'
        ]);
        Sejarah::create([
            'tahun' => '1991 - 2007',
            'judul' => 'Kepemimpinan Kades Mashuri',
            'deskripsi' => 'Kades Mashuri memimpin selama dua periode (1991-1999 dan 1999-2007) meletakkan dasar penguatan infrastruktur dan perdesaan.'
        ]);
        Sejarah::create([
            'tahun' => '2007 - 2019',
            'judul' => 'Kepemimpinan Kades Mukorobin',
            'deskripsi' => 'Kades Mukorobin menjabat selama dua periode (2007-2013 dan 2013-2019) mengarahkan pembangunan desa di era modern.'
        ]);
        Sejarah::create([
            'tahun' => '2019 - Sekarang',
            'judul' => 'Kepemimpinan Kades Haryanto',
            'deskripsi' => 'Kades Haryanto (buyut dari Demang Atmo Wirono) memimpin Desa Banyuurip menuju era digitalisasi, transparansi APBDes, dan pemberdayaan ekonomi agribisnis.'
        ]);

        // 3. PerangkatDesa
        PerangkatDesa::create([
            'nama' => 'Joko Sutopo, S.E.',
            'jabatan' => 'Kepala Desa',
            'foto' => 'kades',
            'kontak' => '0812-3456-7890'
        ]);
        PerangkatDesa::create([
            'nama' => 'Siti Aminah',
            'jabatan' => 'Sekretaris Desa',
            'foto' => 'sekdes',
            'kontak' => '0812-3456-7891'
        ]);
        PerangkatDesa::create([
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kaur Keuangan',
            'foto' => 'kaur_keu',
            'kontak' => '0812-3456-7892'
        ]);
        PerangkatDesa::create([
            'nama' => 'Sri Wahyuni',
            'jabatan' => 'Kaur Kesra & Pelayanan',
            'foto' => 'kaur_kesra',
            'kontak' => '0812-3456-7893'
        ]);
        PerangkatDesa::create([
            'nama' => 'Agus Wibowo',
            'jabatan' => 'Kepala Dusun I',
            'foto' => 'kadus_1',
            'kontak' => '0812-3456-7894'
        ]);
        PerangkatDesa::create([
            'nama' => 'Lilik Mulyadi',
            'jabatan' => 'Kepala Dusun II',
            'foto' => 'kadus_2',
            'kontak' => '0812-3456-7895'
        ]);

        // 4. Komoditas
        Komoditas::create([
            'nama' => 'Padi (Oryza sativa)',
            'jenis' => 'Ciherang & IR64',
            'luas_atau_jumlah' => '120 Hektar',
            'hasil' => '6.8 Ton / Ha',
            'deskripsi' => 'Padi merupakan komoditas pangan utama di Banyuurip dengan sistem irigasi teknis bersumber dari mata air pegunungan setempat.',
            'tipe' => 'tanaman'
        ]);
        Komoditas::create([
            'nama' => 'Jagung (Zea mays)',
            'jenis' => 'Hibrida Pioneer & Bisi 18',
            'luas_atau_jumlah' => '85 Hektar',
            'hasil' => '7.2 Ton / Ha',
            'deskripsi' => 'Ditanam sebagai tanaman alternatif di lahan kering (tegalan) saat memasuki musim kemarau.',
            'tipe' => 'tanaman'
        ]);
        Komoditas::create([
            'nama' => 'Cabai Merah Keriting',
            'jenis' => 'Lokal Boyolali',
            'luas_atau_jumlah' => '40 Hektar',
            'hasil' => '10-12 Ton / Ha',
            'deskripsi' => 'Menjadi komoditas bernilai ekonomi tinggi yang dikelola oleh Kelompok Wanita Tani (KWT).',
            'tipe' => 'tanaman'
        ]);
        Komoditas::create([
            'nama' => 'Sapi Potong & Perah',
            'jenis' => 'Limosin & FH (Friesian Holstein)',
            'luas_atau_jumlah' => '450 Ekor',
            'hasil' => 'Susu Segar & Daging',
            'deskripsi' => 'Peternakan sapi terintegrasi dengan pemanfaatan limbah kotoran menjadi biogas di beberapa RT.',
            'tipe' => 'peternakan'
        ]);

        // 5. AsetTani
        AsetTani::create([
            'nama' => 'Gudang Lumbung Pangan Desa',
            'fungsi' => 'Penyimpanan cadangan gabah pasca-panen',
            'kapasitas' => '50 Ton',
            'pengelola' => 'Gapoktan "Maju Makmur"'
        ]);
        AsetTani::create([
            'nama' => 'Traktor Roda Dua',
            'fungsi' => 'Pengolahan lahan sawah anggota kelompok tani',
            'kapasitas' => '8 Unit',
            'pengelola' => 'Kelompok Tani Tunas Mulya'
        ]);
        AsetTani::create([
            'nama' => 'Mesin Perontok Padi (Power Thresher)',
            'fungsi' => 'Membantu proses perontokan padi saat panen',
            'kapasitas' => '4 Unit',
            'pengelola' => 'Kelompok Tani Rejeki Agung'
        ]);
        AsetTani::create([
            'nama' => 'Kendaraan Pick-up Distribusi',
            'fungsi' => 'Pengangkutan hasil panen menuju pasar kecamatan',
            'kapasitas' => '2 Unit',
            'pengelola' => 'BUMDes Banyuurip'
        ]);

        // 6. Regulasi
        Regulasi::create([
            'nomor' => 'Perdes No. 03 Tahun 2025',
            'judul' => 'Pengelolaan Sampah dan Kebersihan Lingkungan Desa Banyuurip',
            'kategori' => 'Peraturan Desa',
            'tanggal' => '12 April 2025'
        ]);
        Regulasi::create([
            'nomor' => 'Perdes No. 05 Tahun 2025',
            'judul' => 'Rencana Kerja Pemerintah Desa (RKPDes) Tahun Anggaran 2026',
            'kategori' => 'Peraturan Desa',
            'tanggal' => '20 September 2025'
        ]);
        Regulasi::create([
            'nomor' => 'Perkades No. 02 Tahun 2026',
            'judul' => 'Tata Cara Pemberian Insentif Kader Kesehatan Posyandu',
            'kategori' => 'Peraturan Kepala Desa',
            'tanggal' => '05 Februari 2026'
        ]);
        Regulasi::create([
            'nomor' => 'Perdes No. 01 Tahun 2026',
            'judul' => 'Anggaran Pendapatan dan Belanja Desa (APBDes) Tahun Anggaran 2026',
            'kategori' => 'Peraturan Desa',
            'tanggal' => '02 Januari 2026'
        ]);

        // 7. Umkm
        Umkm::create([
            'nama' => 'Kripik Tempe "Rasa Gurih"',
            'pemilik' => 'Ibu Sumarsih',
            'kategori' => 'makanan',
            'kontak' => '0857-1234-5678',
            'alamat' => 'RT 02 / RW 01, Dusun I',
            'deskripsi' => 'Kripik tempe renyah dengan resep tradisional bumbu ketumbar alami tanpa bahan pengawet.',
            'omzet_bulanan' => 'Rp 4.500.000',
            'biaya_produksi' => 'Rp 2.100.000',
            'laba_bersih' => 'Rp 2.400.000',
            'pencatatan' => 'Buku Kas Sederhana',
            'produk' => ['Kripik Tempe Ori', 'Kripik Tempe Pedas Daun Jeruk']
        ]);
        Umkm::create([
            'nama' => 'Kelompok Susu Segar "Murni Jaya"',
            'pemilik' => 'Pak Harjono',
            'kategori' => 'minuman',
            'kontak' => '0813-9876-5432',
            'alamat' => 'RT 04 / RW 02, Dusun II',
            'deskripsi' => 'Penyedia susu segar langsung dari peternak sapi perah Banyuurip yang higienis dan berkualitas tinggi.',
            'omzet_bulanan' => 'Rp 18.200.000',
            'biaya_produksi' => 'Rp 9.800.000',
            'laba_bersih' => 'Rp 8.400.000',
            'pencatatan' => 'Buku Arus Kas & Laba Rugi',
            'produk' => ['Susu Segar Murni 1 Liter', 'Susu Pasteurisasi Stroberi / Cokelat']
        ]);
        Umkm::create([
            'nama' => 'Kerajinan Anyaman Bambu "Lestari"',
            'pemilik' => 'Mbah Sugeng',
            'kategori' => 'kerajinan',
            'kontak' => '0899-4567-8901',
            'alamat' => 'RT 01 / RW 01, Dusun I',
            'deskripsi' => 'Membuat aneka perabotan rumah tangga berbahan bambu lokal seperti besek, tampah, dan kap lampu hias.',
            'omzet_bulanan' => 'Rp 3.000.000',
            'biaya_produksi' => 'Rp 900.000',
            'laba_bersih' => 'Rp 2.100.000',
            'pencatatan' => 'Buku Penjualan Harian',
            'produk' => ['Tampah Hias', 'Besek Makanan (Grosir)', 'Kap Lampu Gantung']
        ]);
        Umkm::create([
            'nama' => 'Kopi Robusta Banyuurip',
            'pemilik' => 'Mas Danang',
            'kategori' => 'minuman',
            'kontak' => '0821-3344-5566',
            'alamat' => 'RT 03 / RW 02, Dusun II',
            'deskripsi' => 'Kopi bubuk robusta premium yang dipanen langsung dari perkebunan lereng bukit Banyuurip dengan pemanggangan medium-dark.',
            'omzet_bulanan' => 'Rp 6.000.000',
            'biaya_produksi' => 'Rp 3.200.000',
            'laba_bersih' => 'Rp 2.800.000',
            'pencatatan' => 'Aplikasi Pembukuan Digital',
            'produk' => ['Kopi Bubuk 250gr', 'Green Bean Robusta']
        ]);

        // 8. SkriningIspa
        SkriningIspa::create([
            'nama_warga' => 'Slamet Rahardjo',
            'usia' => 54,
            'risiko' => 'Tinggi',
            'gejala' => ['batuk' => true, 'demam' => true, 'sesak_napas' => true],
            'rekomendasi' => '⚠️ Tanda Bahaya Terdeteksi! Segera bawa penderita ke Puskesmas Klego atau rumah sakit terdekat.',
            'status' => 'Dirujuk ke Faskes'
        ]);
        SkriningIspa::create([
            'nama_warga' => 'Dewi Sartika',
            'usia' => 3,
            'risiko' => 'Sedang',
            'gejala' => ['batuk' => true, 'pilek' => true, 'demam' => true],
            'rekomendasi' => '⚠️ Gejala Sedang. Terdeteksi infeksi aktif dengan demam. Disarankan istirahat total, pantau gejala.',
            'status' => 'Pemantauan Kader'
        ]);
        SkriningIspa::create([
            'nama_warga' => 'Agus Priyanto',
            'usia' => 28,
            'risiko' => 'Rendah',
            'gejala' => ['batuk' => true, 'pilek' => true],
            'rekomendasi' => '✅ Gejala Ringan. Istirahat yang cukup, jaga kebersihan tangan.',
            'status' => 'Edukasi Selesai'
        ]);

        // 9. AgribisnisStat
        AgribisnisStat::create([
            'luas_lahan' => '245 Hektar',
            'jumlah_produksi' => '1.500 Ton',
            'jumlah_petani' => '520 Orang',
            'jumlah_kelompok_tani' => '12 Kelompok'
        ]);
    }
}
