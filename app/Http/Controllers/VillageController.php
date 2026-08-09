<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
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
use App\Models\DesaAntikorupsi;
use App\Models\VillageSetting;

class VillageController extends Controller
{
    // Beranda / Home
    public function home()
    {
        $stats = [
            'penduduk' => (int) VillageSetting::getVal('total_warga', 3420),
            'kk' => (int) VillageSetting::getVal('kepala_keluarga', 985),
            'luas_tani' => VillageSetting::getVal('luas_wilayah', '245 Hektar'),
            'umkm' => Umkm::count(),
            'posyandu' => (int) VillageSetting::getVal('posyandu_aktif', 5)
        ];

        // Fetch berita from database
        $berita = Berita::orderBy('id', 'asc')->get();

        return Inertia::render('Home', compact('stats', 'berita'));
    }

    // Profil Desa
    public function profil()
    {
        // Fetch sejarah & perangkat from database
        $sejarah = Sejarah::orderBy('tahun', 'asc')->get();
        $perangkat = PerangkatDesa::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();

        return Inertia::render('Profil', compact('sejarah', 'perangkat'));
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

        return Inertia::render('Kesehatan', compact('ebook_chapters'));
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
        $komoditas = Komoditas::orderBy('id', 'desc')->get();

        $luas_lahan_breakdown = [
            ['jenis' => 'Lahan Sawah (Biasa)', 'luas' => '141,00 Ha'],
            ['jenis' => 'Sawah Irigasi Setengah Teknis', 'luas' => '309,01 Ha'],
            ['jenis' => 'Sawah Tadah Hujan', 'luas' => '65,00 Ha'],
            ['jenis' => 'Tegal / Kebun', 'luas' => '76,00 Ha'],
            ['jenis' => 'Pekarangan', 'luas' => '162,22 Ha'],
            ['jenis' => 'Lain-lain', 'luas' => '113,38 Ha'],
        ];

        $stats = [
            'luas_sawah' => '450,01 Ha',
            'produktivitas_padi' => '6,2 Ton/Ha',
            'produktivitas_jagung' => '4,5 Ton/Ha',
            'pola_tanam' => 'Padi → Padi → Jagung / Kacang Tanah',
            'gapoktan' => 'Subur Makmur (Ketua: Darji)',
            'sumber' => 'BPP Kecamatan Klego'
        ];

        $kelompok_tani = [
            ['nama' => 'Sidomukti I', 'ketua' => 'Sukardi', 'alamat' => 'Tlogosari RT22 RW06', 'anggota' => '85 Orang'],
            ['nama' => 'Sidomukti II', 'ketua' => 'Purwanto', 'alamat' => 'Banyuurip RT16 RW05', 'anggota' => '43 Orang'],
            ['nama' => 'Sidomuncul I', 'ketua' => 'Muadif', 'alamat' => 'Ngijo RT04 RW01', 'anggota' => 'Aktif'],
            ['nama' => 'Sidomuncul II', 'ketua' => 'Shodiq', 'alamat' => 'Ngijo RT03 RW01', 'anggota' => '60 Orang'],
            ['nama' => 'Harapan I', 'ketua' => 'Basuki', 'alamat' => 'Banyuurip RT14 RW01', 'anggota' => '47 Orang'],
            ['nama' => 'Harapan II', 'ketua' => 'Muh Thoha', 'alamat' => 'Palemrejo RT09 RW02', 'anggota' => '60 Orang'],
            ['nama' => 'Ngudi Rejeki I', 'ketua' => 'Supadi', 'alamat' => 'Ngeliyangan RT24 RW07', 'anggota' => '26 Orang'],
            ['nama' => 'Ngudi Rejeki II', 'ketua' => 'Juwadi', 'alamat' => 'Jlegong RT11 RW03', 'anggota' => '82 Orang'],
            ['nama' => 'Ngudi Rejeki III', 'ketua' => 'Jumanto', 'alamat' => 'Ngeliyangan RT27 RW07', 'anggota' => '54 Orang'],
        ];

        $inventaris_balai_desa = AsetTani::orderBy('id', 'asc')->get();

        $sop_peminjaman = [
            ['langkah' => '1', 'judul' => 'Ajukan Peminjaman', 'deskripsi' => 'Hubungi penjaga/pengelola aset desa (Kaur Umum: +62 813-7244-8450) untuk menyampaikan kebutuhan peminjaman.'],
            ['langkah' => '2', 'judul' => 'Verifikasi Ketersediaan', 'deskripsi' => 'Pengelola memastikan aset desa yang akan dipinjam dalam kondisi baik & tersedia pada jadwal yang diminta.'],
            ['langkah' => '3', 'judul' => 'Pengambilan Aset', 'deskripsi' => 'Aset diserahkan kepada peminjam dalam kondisi baik setelah dilakukan pemeriksaan awal.'],
            ['langkah' => '4', 'judul' => 'Penggunaan Responsible', 'deskripsi' => 'Gunakan aset dengan penuh tanggung jawab sesuai keperluan kegiatan masyarakat.'],
            ['langkah' => '5', 'judul' => 'Pengembalian & Cek Kondisi', 'deskripsi' => 'Aset dikembalikan kepada pengelola dalam kondisi baik seperti saat dipinjam (dilakukan pengecekan fisik aset).'],
        ];

        return Inertia::render('Agribisnis', compact(
            'komoditas',
            'stats', 
            'luas_lahan_breakdown', 
            'kelompok_tani', 
            'inventaris_balai_desa', 
            'sop_peminjaman'
        ));
    }

    // Pusat Hukum Desa (JDIH - Produk Hukum & Regulasi Desa)
    public function hukum()
    {
        $regulasi = Regulasi::orderBy('id', 'desc')->get();
        $antikorupsiDocs = DesaAntikorupsi::orderBy('id', 'asc')->get();

        return Inertia::render('PusatHukum', compact('regulasi', 'antikorupsiDocs'));
    }

    // Portal Berita & Informasi Desa Banyuurip
    public function berita()
    {
        $berita = Berita::orderBy('id', 'desc')->get();
        return Inertia::render('BeritaDesa', compact('berita'));
    }

    // Transparansi Keuangan (APBDes 2026) & Panduan Pembayaran PBB SiPAD
    public function keuangan()
    {
        $apbdes_pendapatan = [
            ['sumber' => 'Dana Desa (DD)', 'anggaran' => 373456000, 'realisasi' => 373456000, 'persen' => 100.0, 'status' => 'Terserap Sepenuhnya ✅', 'kategori' => 'Transfer Pusat'],
            ['sumber' => 'Alokasi Dana Desa (ADD)', 'anggaran' => 593245000, 'realisasi' => 350797136, 'persen' => 59.1, 'status' => 'Terserap Sebagian', 'kategori' => 'Transfer Kabupaten'],
            ['sumber' => 'Bagi Hasil Pajak & Retribusi (PBH)', 'anggaran' => 111055000, 'realisasi' => 70064000, 'persen' => 63.1, 'status' => 'Terserap Sebagian', 'kategori' => 'Transfer Kabupaten'],
            ['sumber' => 'BanKeu Kabupaten/Kota', 'anggaran' => 125000000, 'realisasi' => 50000000, 'persen' => 40.0, 'status' => 'Terserap Sebagian', 'kategori' => 'Transfer Kabupaten'],
            ['sumber' => 'Pendapatan Asli Desa (PADes)', 'anggaran' => 212000000, 'realisasi' => 10000000, 'persen' => 4.7, 'status' => 'Rendah (4.7%) ⚠️', 'kategori' => 'Pendapatan Asli'],
            ['sumber' => 'Bantuan Keuangan Provinsi', 'anggaran' => 175000000, 'realisasi' => 0, 'persen' => 0.0, 'status' => 'Belum Masuk (0%) ❌', 'kategori' => 'Transfer Provinsi'],
            ['sumber' => 'Pendapatan Lain-Lain', 'anggaran' => 3250000, 'realisasi' => 805235, 'persen' => 24.8, 'status' => 'Terserap Sebagian', 'kategori' => 'Lain-Lain'],
        ];

        $apbdes_belanja = [
            ['bidang' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'anggaran' => 893501180, 'realisasi' => 349732290, 'persen' => 39.1],
            ['bidang' => 'Bidang Pelaksanaan Pembangunan Desa', 'anggaran' => 587868000, 'realisasi' => 144538000, 'persen' => 24.6],
            ['bidang' => 'Bidang Pemberdayaan Masyarakat', 'anggaran' => 88315000, 'realisasi' => 64066000, 'persen' => 72.5],
            ['bidang' => 'Bidang Penanggulangan Bencana & Mendesak', 'anggaran' => 55400000, 'realisasi' => 25200000, 'persen' => 45.5],
            ['bidang' => 'Bidang Pembinaan Kemasyarakatan', 'anggaran' => 14486000, 'realisasi' => 0, 'persen' => 0.0],
        ];

        $pembiayaan = [
            'penerimaan_anggaran' => 49564180,
            'pengeluaran_anggaran' => 3000000,
            'netto_anggaran' => 46564180,
            'penerimaan_realisasi' => 49564180,
            'pengeluaran_realisasi' => 0,
            'netto_realisasi' => 49564180,
        ];

        $summary_stats = [
            'total_anggaran_pendapatan' => 1593006000,
            'total_realisasi_pendapatan' => 855122371,
            'total_anggaran_belanja' => 1639570180,
            'total_realisasi_belanja' => 583536290,
            'persen_transfer' => 86.5,
            'surplus_realisasi' => 271586081,
        ];

        $panduan_pbb = [
            [
                'id' => 1,
                'judul' => 'Layanan 1 — Cek NJOP PBB',
                'link' => 'https://sipad.id/publik/pbb_cek_njop',
                'deskripsi' => 'Gunakan layanan ini untuk mengetahui nilai NJOP tanah dan bangunan sawah/rumah Anda sebelum membayar.',
                'langkah' => [
                    'Buka sipad.id/publik/pbb_cek_njop',
                    'Pilih tahun SPPT (tersedia dari 2013 hingga 2026)',
                    'Masukkan NOP diawali kode 33-09 (Kode Kabupaten Boyolali)',
                    'Klik "Cari Data"',
                    'Data yang muncul: Nama Subyek, Letak Objek Pajak, Total NJOP Bumi, NJOP Bumi per m², Total NJOP Bangunan, dan NJOP Bangunan per m²'
                ]
            ],
            [
                'id' => 2,
                'judul' => 'Layanan 2 — Cek Tagihan PBB',
                'link' => 'https://sipad.id/publik/pbb_cek_tagihan',
                'deskripsi' => 'Gunakan layanan ini untuk tahu berapa nominal PBB yang harus dibayar dan apakah ada tunggakan.',
                'langkah' => [
                    'Buka sipad.id/publik/pbb_cek_tagihan',
                    'Masukkan NOP diawali kode 33-09',
                    'Klik "Cari Data"',
                    'Tabel hasil pencarian menampilkan: Tahun Pajak, Nama Wajib Pajak, Tanggal Jatuh Tempo, Denda (2% per bulan), dan Jumlah yang harus dibayar'
                ]
            ],
            [
                'id' => 3,
                'judul' => 'Layanan 3 — Bayar PBB Perorangan via QRIS',
                'link' => 'https://sipad.id/qrisgen/pbb',
                'deskripsi' => 'Cara bayar paling cepat, cukup scan kode QRIS dari HP menggunakan GoPay, OVO, Dana, ShopeePay, atau M-Banking!',
                'langkah' => [
                    'Buka sipad.id/qrisgen/pbb',
                    'Masukkan NOP atau Kode Bayar PBB-P2 Kolektif dan Tahun Pajak',
                    'Klik "Bayar QRIS"',
                    'Kode QRIS akan muncul di layar',
                    'Buka aplikasi e-wallet / mobile banking, pilih "Scan QR", lalu scan kode QRIS yang tampil',
                    'Konfirmasi pembayaran dengan PIN & simpan screenshot bukti bayar'
                ]
            ],
            [
                'id' => 4,
                'judul' => 'Layanan 4 — Bayar PBB Kolektif (Perangkat Desa / RT)',
                'link' => 'https://sipad.id/publik/pbb_bayar',
                'deskripsi' => 'Layanan khusus untuk Perangkat Desa atau RT yang ingin membantu warganya membayar PBB sekaligus dalam satu transaksi.',
                'langkah' => [
                    'Buka sipad.id/publik/pbb_bayar',
                    'Isi data: Nama, Email, Nomor Telepon, dan Tahun SPPT',
                    'Pilih Kecamatan Klego dan Desa Banyuurip',
                    'Klik "Cari Data" — daftar NOP di desa akan muncul',
                    'Pilih NOP warga yang ingin dibayarkan (bisa pilih semua atau per satu)',
                    'Pilih bank pembayaran: Bank Jateng (Virtual Account) atau Bank BNI (Virtual Account)',
                    'Klik "Bentuk Kode Bayar" & bayar via virtual akun'
                ]
            ],
            [
                'id' => 5,
                'judul' => 'Layanan 5 — Cetak Bukti Bayar (SSPD)',
                'link' => 'https://sipad.id/publik/pbb_cetak_sspd',
                'deskripsi' => 'Cetak Surat Setoran Pajak Daerah (SSPD) resmi yang sah secara hukum setelah pembayaran selesai.',
                'langkah' => [
                    'Buka sipad.id/publik/pbb_cetak_sspd',
                    'Pilih tahun SPPT & masukkan NOP (33-09)',
                    'Klik "Cari Data"',
                    'Klik "File SSPD" untuk mengunduh bukti bayar resmi dalam format PDF'
                ]
            ],
            [
                'id' => 6,
                'judul' => 'Layanan 6 — Cetak Salinan SPPT',
                'link' => 'https://sipad.id/salinansppt',
                'deskripsi' => 'Gunakan layanan ini apabila lembar SPPT fisik hilang atau rusak untuk mengunduh salinan digital resmi.',
                'langkah' => [
                    'Buka sipad.id/salinansppt',
                    'Masukkan NOP Anda',
                    'Klik "Download Salinan"',
                    'File SPPT format PDF akan otomatis terunduh untuk dicetak'
                ]
            ],
            [
                'id' => 7,
                'judul' => 'Layanan 7 — Cetak Kode Bayar Kolektif',
                'link' => 'https://sipad.id/publik/pbb_cetak_kode_bayar',
                'deskripsi' => 'Khusus untuk Perangkat Desa / RT yang sudah membuat kode bayar kolektif dan ingin mencetaknya kembali.',
                'langkah' => [
                    'Buka sipad.id/publik/pbb_cetak_kode_bayar',
                    'Masukkan kode bayar kolektif yang sudah dibuat',
                    'Kode bayar akan tampil dan siap dicetak'
                ]
            ]
        ];

        $kontak_bkd = [
            'alamat' => 'Jl. Merdeka Timur, Kemiri, Boyolali, Jawa Tengah',
            'email' => 'pajakdaerah@boyolali.go.id',
            'telepon' => '(0276) 321073',
            'fax' => '(0276) 322602'
        ];

        // Fetch regulasi and antikorupsi from database
        $regulasi = Regulasi::orderBy('id', 'desc')->get();
        $antikorupsiDocs = DesaAntikorupsi::orderBy('id', 'asc')->get();

        return Inertia::render('Keuangan', compact(
            'apbdes_pendapatan', 
            'apbdes_belanja', 
            'pembiayaan', 
            'summary_stats', 
            'panduan_pbb', 
            'kontak_bkd', 
            'regulasi', 
            'antikorupsiDocs'
        ));
    }

    // Portal Desa Antikorupsi (5 Pilar Indikator KPK & 18 Indikator Resmi)
    public function desaAntikorupsi()
    {
        $antikorupsi = DesaAntikorupsi::orderBy('id', 'asc')->get();

        $pilarKpk = [
            [
                'kunci' => 'Penguatan Tata Laksana',
                'pilar' => 'Pilar 1: Penguatan Tata Laksana',
                'deskripsi' => 'Pengelolaan administrasi desa yang tertib, SOP Pengadaan Barang/Jasa transparan, dan pencegahan gratifikasi/pungli.',
                'icon' => 'file-text',
                'indikator_list' => [
                    ['no' => 1, 'judul' => 'Kebijakan Desa tentang Perencanaan, Pelaksanaan, Penatausahaan dan Pertanggungjawaban APBDes'],
                    ['no' => 2, 'judul' => 'Kebijakan Desa mengenai mekanisme Pengawasan dan Evaluasi Kinerja Perangkat Desa'],
                    ['no' => 3, 'judul' => 'Kebijakan Desa tentang pengendalian gratifikasi, suap, dan konflik kepentingan'],
                    ['no' => 4, 'judul' => 'Keberadaan perjanjian kerjasama PBJ dan melalui proses pengadaan barang-jasa di Desa'],
                    ['no' => 5, 'judul' => 'Kebijakan Desa tentang pakta integritas dan sejenisnya']
                ]
            ],
            [
                'kunci' => 'Penguatan Pengawasan',
                'pilar' => 'Pilar 2: Penguatan Pengawasan',
                'deskripsi' => 'Pengawasan efektif BPD, evaluasi kinerja perangkat, dan rekam jejak bebas tindak pidana korupsi.',
                'icon' => 'shield-alert',
                'indikator_list' => [
                    ['no' => 6, 'judul' => 'Keberadaan kegiatan pengawasan dan evaluasi kinerja perangkat desa'],
                    ['no' => 7, 'judul' => 'Keberadaan tindak lanjut hasil pembinaan, petunjuk, pengawasan dan pemeriksaan dari pemerintah'],
                    ['no' => 8, 'judul' => 'Tidak ada aparatur desa dalam 3 tahun terakhir yang terjerat tindak pidana korupsi']
                ]
            ],
            [
                'kunci' => 'Penguatan Pelayanan Publik',
                'pilar' => 'Pilar 3: Penguatan Pelayanan Publik',
                'deskripsi' => 'Kemudahan akses pelayanan warga, keberadaan maklumat pelayanan, dan survei kepuasan masyarakat.',
                'icon' => 'users',
                'indikator_list' => [
                    ['no' => 9, 'judul' => 'Keberadaan layanan pengaduan bagi masyarakat'],
                    ['no' => 10, 'judul' => 'Keberadaan survei kepuasan masyarakat terhadap layanan pemerintah desa'],
                    ['no' => 13, 'judul' => 'Keberadaan Maklumat Pelayanan']
                ]
            ],
            [
                'kunci' => 'Penguatan Partisipasi Publik',
                'pilar' => 'Pilar 4: Penguatan Partisipasi Publik',
                'deskripsi' => 'Keterbukaan informasi APBDes di ruang publik, keterlibatan warga dalam penyusunan RKPDes & LKD.',
                'icon' => 'eye',
                'indikator_list' => [
                    ['no' => 11, 'judul' => 'Keterbukaan dan akses masyarakat desa terhadap informasi standar pelayanan minimal (SPM)'],
                    ['no' => 12, 'judul' => 'Keberadaan media informasi tentang APBDes di Balai Desa / tempat umum yang mudah diakses'],
                    ['no' => 14, 'judul' => 'Partisipasi dan keterlibatan masyarakat dalam penyusunan RKP Desa'],
                    ['no' => 16, 'judul' => 'Keterlibatan Lembaga Kemasyarakatan Desa (LKD) dan masyarakat dalam pembangunan']
                ]
            ],
            [
                'kunci' => 'Budaya Antikorupsi',
                'pilar' => 'Pilar 5: Kearifan Lokal & Budaya Antikorupsi',
                'deskripsi' => 'Penanaman nilai integritas kejujuran, norma hukum adat/lokal, dan peran aktif tokoh masyarakat.',
                'icon' => 'heart-handshake',
                'indikator_list' => [
                    ['no' => 15, 'judul' => 'Kesadaran masyarakat dalam mencegah terjadinya praktik gratifikasi, suap dan konflik kepentingan'],
                    ['no' => 17, 'judul' => 'Budaya lokal-hukum adat yang mendorong upaya pencegahan tindak pidana korupsi'],
                    ['no' => 18, 'judul' => 'Tokoh masyarakat, agama, adat, pemuda & perempuan yang mendorong pencegahan korupsi']
                ]
            ]
        ];

        return Inertia::render('DesaAntikorupsi', compact('antikorupsi', 'pilarKpk'));
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
        $kategoriLabels = [
            'makanan' => 'Makanan Ringan',
            'makanan ringan' => 'Makanan Ringan',
            'minuman' => 'Minuman Kemasan',
            'minuman kemasan' => 'Minuman Kemasan',
            'kerajinan' => 'Kerajinan Tangan',
            'kerajinan tangan' => 'Kerajinan Tangan',
            'jasa' => 'Jasa / Lainnya',
            'jasa / lainnya' => 'Jasa / Lainnya',
        ];

        $umkm = Umkm::orderBy('id', 'desc')->get()->map(fn($item) => [
            'id' => $item->id,
            'nama' => $item->nama,
            'pemilik' => $item->pemilik,
            'kategori' => strtolower($item->kategori),
            'kategoriLabel' => $kategoriLabels[strtolower($item->kategori)] ?? ucfirst($item->kategori),
            'kontak' => $item->kontak,
            'alamat' => $item->alamat,
            'link_maps' => $item->link_maps,
            'deskripsi' => $item->deskripsi,
            'omzet' => $item->omzet_bulanan,
            'biaya' => $item->biaya_produksi,
            'laba' => $item->laba_bersih,
            'pencatatan' => $item->pencatatan,
            'produk' => $item->produk ?? [],
            'gambar' => $item->gambar,
        ])->toArray();

        return Inertia::render('Umkm', compact('umkm'));
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

        return Inertia::render('Edukasi5s', compact('konsep5s'));
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

        return Inertia::render('Admin/Dashboard', compact('stats', 'recent_screenings'));
    }
}
