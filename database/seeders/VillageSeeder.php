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
        // 1. Berita (Dikelola penuh oleh Admin)
        // No dummy berita seeds.

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

        // 3. PerangkatDesa (Dikelola penuh oleh Admin)
        // No dummy perangkat seeds.

        // 4. Komoditas (Dikelola penuh oleh Admin)
        // No dummy komoditas seeds.

        // 5. AsetTani (Inventaris Aset Balai Desa Resmi)
        AsetTani::create(['nama' => 'Aula Balai Desa', 'fungsi' => 'Fasilitas Gedung Serbaguna & Pertemuan Warga', 'kapasitas' => '1 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Bangku Plastik', 'fungsi' => 'Peralatan Tempat Duduk Acara / Hajatan Warga', 'kapasitas' => '100 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Bangku Merah', 'fungsi' => 'Peralatan Tempat Duduk Acara / Hajatan Warga', 'kapasitas' => '50 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Mesin Pemotong Rumput', 'fungsi' => 'Peralatan Kerja Bakti & Pemeliharaan Lingkungan', 'kapasitas' => '2 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Sound System', 'fungsi' => 'Peralatan Audio Acara & Rapat Desa', 'kapasitas' => '1 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Genset', 'fungsi' => 'Pembangkit Listrik Darurat Acara & Balai Desa', 'kapasitas' => '1 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Mobil Siaga Suzuki APV', 'fungsi' => 'Layanan Kesehatan Darurat & Transportasi Warga', 'kapasitas' => '1 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Dram Preal Set', 'fungsi' => 'Peralatan Musik & Kesenian Desa', 'kapasitas' => '1 Set', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Gitar Ibanez', 'fungsi' => 'Peralatan Musik & Kesenian Desa', 'kapasitas' => '1 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Gitar Yamaha', 'fungsi' => 'Peralatan Musik & Kesenian Desa', 'kapasitas' => '1 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Seruling', 'fungsi' => 'Peralatan Musik & Kesenian Desa', 'kapasitas' => '1 Set', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Ecrek-Ecrek', 'fungsi' => 'Peralatan Musik & Kesenian Desa', 'kapasitas' => '1 Buah', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);
        AsetTani::create(['nama' => 'Handy Talkie (HT)', 'fungsi' => 'Peralatan Komunikasi Kesiapsiagaan & Acara', 'kapasitas' => '2 Unit', 'pengelola' => 'Kaur Umum (+62 813-7244-8450)']);

        // 6. Regulasi (Dikelola penuh oleh Admin)
        // No dummy regulasi seeds.

        // 7. Umkm (Dikelola penuh oleh Admin)
        // No dummy umkm seeds.

        // 8. SkriningIspa (Dikelola penuh dari input warga & admin)
        // No dummy screening seeds.

        // 9. AgribisnisStat
        AgribisnisStat::create([
            'luas_lahan' => '245 Hektar',
            'jumlah_produksi' => '1.500 Ton',
            'jumlah_petani' => '520 Orang',
            'jumlah_kelompok_tani' => '12 Kelompok'
        ]);
    }
}
