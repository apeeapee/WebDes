<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Sejarah;
use App\Models\PerangkatDesa;
use App\Models\SkriningIspa;
use App\Models\Komoditas;
use App\Models\AsetTani;
use App\Models\Regulasi;
use App\Models\Umkm;
use App\Models\Apbdes;
use App\Models\AgribisnisStat;

class VillageController extends Controller
{
    // Beranda / Home
    public function home()
    {
        $stats = [
            'penduduk' => 3420,
            'kk' => 985,
            'luas_tani' => '245 Hektar',
            'umkm' => Umkm::count(),
            'posyandu' => 5
        ];

        // Fetch berita from database
        $berita = Berita::orderBy('id', 'asc')->get();

        return view('home', compact('stats', 'berita'));
    }

    // Profil Desa
    public function profil()
    {
        // Fetch sejarah & perangkat from database
        $sejarah = Sejarah::orderBy('tahun', 'asc')->get();
        $perangkat = PerangkatDesa::orderBy('id', 'asc')->get();

        return view('profil', compact('sejarah', 'perangkat'));
    }

    // Layanan Kesehatan (RESPIRA & Skrining ISPA)
    public function kesehatan()
    {
        $ebook_chapters = [
            [
                'id' => 'pengertian',
                'bab' => 'Bab I: Apa itu ISPA?',
                'judul' => 'Mengenal Infeksi Saluran Pernapasan Akut (ISPA)',
                'konten' => 'Infeksi Saluran Pernapasan Akut (ISPA) adalah infeksi di saluran pernapasan yang menimbulkan gejala batuk, pilek, disertai demam. ISPA sangat mudah menular melalui droplet (percikan air liur) saat penderita bersin atau batuk. ISPA dapat menyerang hidung, tenggorokan (saluran napas atas), hingga paru-paru (saluran napas bawah).'
            ],
            [
                'id' => 'penyebab',
                'bab' => 'Bab II: Penyebab & Faktor Risiko',
                'judul' => 'Mengapa ISPA Bisa Terjadi?',
                'konten' => 'Penyebab utama ISPA adalah virus (seperti Influenza, Rhinovirus, Adenovirus) dan bakteri (seperti Streptococcus pneumoniae). Faktor risiko yang mempercepat penyebaran di Desa Banyuurip meliputi: kurangnya ventilasi udara rumah, debu pertanian/pakan ternak, paparan asap rokok, perubahan cuaca pancaroba yang ekstrem, serta imunitas tubuh yang rendah (terutama pada balita dan lansia).'
            ],
            [
                'id' => 'pencegahan',
                'bab' => 'Bab III: Pencegahan Efektif',
                'judul' => 'Cara Melindungi Diri & Keluarga',
                'konten' => '1. **PHBS (Perilaku Hidup Bersih & Sehat)**: Cuci tangan dengan sabun secara rutin.<br>2. **Etika Batuk & Bersin**: Tutup mulut dengan tisu atau siku bagian dalam.<br>3. **Gunakan Masker**: Terutama jika sedang flu atau berada di area berdebu (kandang/sawah).<br>4. **Ventilasi Cukup**: Buka jendela setiap pagi agar sirkulasi udara lancar.<br>5. **Imunisasi**: Pastikan balita mendapatkan imunisasi dasar lengkap.'
            ],
            [
                'id' => 'kapan_ke_faskes',
                'bab' => 'Bab IV: Kapan Harus ke Puskesmas?',
                'judul' => 'Tanda Bahaya yang Harus Diwaspadai',
                'konten' => 'Segera bawa penderita ke Puskesmas Banyuurip atau fasilitas kesehatan terdekat jika menemui gejala bahaya berikut: napas menjadi sangat cepat (takipnea), tarikan dinding dada ke dalam saat bernapas, bibir atau kuku tampak kebiruan (sianosis), demam tinggi tidak turun lebih dari 3 hari, atau anak lemas dan tidak mau menyusu/minum.'
            ]
        ];

        return view('kesehatan', compact('ebook_chapters'));
    }

    // Skrining ISPA POST endpoint
    public function storeSkrining(Request $request)
    {
        $request->validate([
            'nama_warga' => 'required|string|max:255',
            'usia' => 'required|integer|min:0',
            'risiko' => 'required|string',
            'gejala' => 'required|array',
            'rekomendasi' => 'required|string',
        ]);

        SkriningIspa::create([
            'nama_warga' => $request->nama_warga,
            'usia' => $request->usia,
            'risiko' => $request->risiko,
            'gejala' => $request->gejala,
            'rekomendasi' => $request->rekomendasi,
            'status' => $request->risiko === 'Tinggi' ? 'Dirujuk ke Faskes' : ($request->risiko === 'Sedang' ? 'Pemantauan Kader' : 'Edukasi Selesai')
        ]);

        return response()->json(['success' => true, 'message' => 'Skrining berhasil disimpan!']);
    }

    // Agribisnis & Logistik
    public function agribisnis()
    {
        // Fetch komoditas & aset tani from database
        $komoditas = Komoditas::orderBy('id', 'asc')->get();
        $aset_logistik = AsetTani::orderBy('id', 'asc')->get();
        $stats = AgribisnisStat::first();

        $kalender_tanam = [
            ['musim' => 'Musim Hujan (Rendengan)', 'bulan' => 'November - Februari', 'kegiatan' => 'Penanaman Padi Utama', 'status' => 'Irigasi lancar, waspada hama wereng.'],
            ['musim' => 'Musim Pancaroba (Gadu I)', 'bulan' => 'Maret - Juni', 'kegiatan' => 'Penanaman Padi Varietas Genjah / Jagung', 'status' => 'Irigasi bergilir, pembagian air teratur.'],
            ['musim' => 'Musim Kemarau (Gadu II)', 'bulan' => 'Juli - Oktober', 'kegiatan' => 'Palawija (Jagung, Cabai, Kedelai)', 'status' => 'Hemat air, pemanfaatan sumur pantek pertanian.']
        ];

        $alur_distribusi = [
            ['langkah' => '1. Panen di Lahan', 'deskripsi' => 'Petani melakukan panen padi, jagung, atau cabai secara bersamaan (gotong royong) sesuai kalender tanam.'],
            ['langkah' => '2. Pengeringan & Sortasi', 'deskripsi' => 'Hasil panen dijemur di lantai jemur komunal desa dan disortir berdasarkan kualitas standar pasar.'],
            ['langkah' => '3. Penyimpanan Sementara', 'deskripsi' => 'Sebagian gabah disimpan di Gudang Lumbung Desa untuk ketahanan pangan, sisanya dikemas untuk didistribusikan.'],
            ['langkah' => '4. Pengangkutan Logistik', 'deskripsi' => 'BUMDes mengoordinasikan armada pikap desa untuk mengangkut komoditas secara terjadwal guna menjaga harga jual tetap stabil.'],
            ['langkah' => '5. Penjualan & Distribusi Pasar', 'deskripsi' => 'Komoditas dipasarkan ke Pasar Kabupaten Boyolali, Koperasi Susu Lokal, serta pengepul kemitraan desa.']
        ];

        return view('agribisnis', compact('komoditas', 'kalender_tanam', 'aset_logistik', 'alur_distribusi', 'stats'));
    }

    // Transparansi Keuangan (APBDes) & Regulasi Hukum
    public function keuangan()
    {
        // Fetch APBDes data dynamically from database and map it to structural arrays
        $pendapatan = Apbdes::where('kategori', 'pendapatan')->orderBy('id', 'asc')->get()->map(fn($item) => [
            'sumber' => $item->rincian,
            'jumlah' => $item->jumlah,
            'persen' => $item->persen
        ])->toArray();

        $belanja = Apbdes::where('kategori', 'belanja')->orderBy('id', 'asc')->get()->map(fn($item) => [
            'bidang' => $item->rincian,
            'jumlah' => $item->jumlah,
            'persen' => $item->persen
        ])->toArray();

        $apbdes = [
            'pendapatan' => $pendapatan,
            'belanja' => $belanja
        ];

        // Fetch regulasi from database
        $regulasi = Regulasi::orderBy('id', 'desc')->get();

        return view('keuangan', compact('apbdes', 'regulasi'));
    }

    // POST endpoint for new regulation
    public function storeRegulasi(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
        ]);

        Regulasi::create([
            'nomor' => $request->nomor,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal' => now()->translatedFormat('d F Y')
        ]);

        return redirect()->route('admin')->with('success_regulasi', 'Regulasi berhasil diupload!');
    }

    // Pemberdayaan UMKM
    public function umkm()
    {
        // Fetch UMKM from database
        $umkm = Umkm::orderBy('id', 'desc')->get();

        return view('umkm', compact('umkm'));
    }

    // POST endpoint for new UMKM
    public function storeUmkm(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|string',
            'omzet' => 'required|string',
        ]);

        // Simple calculations for mock financial records
        $omzetVal = (int) filter_var($request->omzet, FILTER_SANITIZE_NUMBER_INT);
        $biayaVal = (int) ($omzetVal * 0.55); // simulated production cost 55%
        $labaVal = $omzetVal - $biayaVal;

        $omzetFormatted = 'Rp ' . number_format($omzetVal, 0, ',', '.');
        $biayaFormatted = 'Rp ' . number_format($biayaVal, 0, ',', '.');
        $labaFormatted = 'Rp ' . number_format($labaVal, 0, ',', '.');

        Umkm::create([
            'nama' => $request->nama,
            'pemilik' => $request->pemilik,
            'kategori' => strtolower($request->kategori),
            'kontak' => '0812-3456-7899', // default phone for simulation
            'alamat' => 'RT 01 / RW 01, Banyuurip',
            'deskripsi' => 'Pelaku usaha lokal binaan yang menyajikan produk unggulan berskala desa.',
            'omzet_bulanan' => $omzetFormatted,
            'biaya_produksi' => $biayaFormatted,
            'laba_bersih' => $labaFormatted,
            'pencatatan' => 'Buku Kas Sederhana (Dibantu Program KKN Akuntansi)',
            'produk' => ['Produk Utama', 'Produk Alternatif']
        ]);

        return redirect()->route('admin')->with('success_umkm', 'UMKM berhasil didaftarkan!');
    }

    // Edukasi Budaya 5S Jepang
    public function edukasi5s()
    {
        $konsep5s = [
            [
                'kunci' => 'Seiri (Ringkas)',
                'arti' => 'Memilah & Menyingkirkan',
                'penjelasan' => 'Memisahkan barang yang diperlukan dengan yang tidak diperlukan, lalu membuang barang yang tidak terpakai lagi. Contoh di Desa: Memilah dokumen arsip desa yang sudah kedaluwarsa atau membersihkan tumpukan pupuk tak terpakai di gudang tani.'
            ],
            [
                'kunci' => 'Seiton (Rapi)',
                'arti' => 'Menata & Menyimpan pada Tempatnya',
                'penjelasan' => 'Mengatur tata letak barang secara teratur sehingga mudah ditemukan saat dibutuhkan dan ada penandaan yang jelas. Contoh di Desa: Memberikan label tempat penyimpanan traktor, cangkul, obat tanaman, atau menata berkas administrasi desa berdasarkan abjad.'
            ],
            [
                'kunci' => 'Seiso (Resik)',
                'arti' => 'Pembersihan & Inspeksi',
                'penjelasan' => 'Membersihkan tempat kerja, rumah, dan lingkungan sekitar secara berkala hingga tidak ada debu atau sampah berserakan. Contoh di Desa: Mengadakan kerja bakti rutin di parit pertanian, membersihkan posyandu sebelum kegiatan bulanan dimulai.'
            ],
            [
                'kunci' => 'Seiketsu (Rawat)',
                'arti' => 'Mempertahankan & Menstandardisasi',
                'penjelasan' => 'Menjaga kepatuhan terhadap 3S di atas secara terus-menerus dan menjadikannya sebuah standar operasional. Contoh di Desa: Membuat SOP piket kebersihan balai desa atau jadwal perawatan bersama mesin traktor kelompok tani.'
            ],
            [
                'kunci' => 'Shitsuke (Rajin)',
                'arti' => 'Pembiasaan Diri & Disiplin',
                'penjelasan' => 'Membiasakan diri mematuhi peraturan dan memelihara budaya bersih sebagai gaya hidup tanpa perlu diawasi. Contoh di Desa: Disiplin membuang sampah pada tempatnya, hadir posyandu tepat waktu, dan tertib berlalu lintas di jalan desa.'
            ]
        ];

        return view('edukasi-5s', compact('konsep5s'));
    }

    // Admin Dashboard Mockup (Arya & Dwi)
    public function admin()
    {
        $stats = [
            'total_warga' => 3420,
            'total_screening_ispa' => SkriningIspa::count(),
            'skrining_risiko_tinggi' => SkriningIspa::where('risiko', 'Tinggi')->count(),
            'umkm_aktif' => Umkm::count(),
            'dokumen_hukum' => Regulasi::count()
        ];

        // Fetch recent screenings from DB
        $recent_screenings = SkriningIspa::orderBy('id', 'desc')->take(5)->get();

        return view('admin', compact('stats', 'recent_screenings'));
    }
}
