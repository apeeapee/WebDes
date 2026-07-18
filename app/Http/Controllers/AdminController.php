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

class AdminController extends Controller
{
    // 1. Dashboard Overview
    public function index()
    {
        $stats = [
            'total_warga' => 3420,
            'total_screening_ispa' => SkriningIspa::count(),
            'skrining_risiko_tinggi' => SkriningIspa::where('risiko', 'Tinggi')->count(),
            'umkm_aktif' => Umkm::count(),
            'dokumen_hukum' => Regulasi::count(),
            'total_berita' => Berita::count(),
            'total_perangkat' => PerangkatDesa::count(),
            'total_komoditas' => Komoditas::count(),
            'total_aset' => AsetTani::count(),
        ];

        $recent_screenings = SkriningIspa::orderBy('id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_screenings'));
    }

    // 2. Berita CRUD
    public function beritaIndex()
    {
        $items = Berita::orderBy('id', 'desc')->get();
        return view('admin.berita', compact('items'));
    }

    public function beritaStore(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'gambar' => 'nullable|string|max:255',
        ]);

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function beritaUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'gambar' => 'nullable|string|max:255',
        ]);

        $item = Berita::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function beritaDestroy($id)
    {
        $item = Berita::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    // 3. Sejarah CRUD
    public function sejarahIndex()
    {
        $items = Sejarah::orderBy('tahun', 'asc')->get();
        return view('admin.sejarah', compact('items'));
    }

    public function sejarahStore(Request $request)
    {
        $data = $request->validate([
            'tahun' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Sejarah::create($data);
        return redirect()->route('admin.sejarah.index')->with('success', 'Sejarah berhasil ditambahkan!');
    }

    public function sejarahUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'tahun' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $item = Sejarah::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.sejarah.index')->with('success', 'Sejarah berhasil diperbarui!');
    }

    public function sejarahDestroy($id)
    {
        $item = Sejarah::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.sejarah.index')->with('success', 'Sejarah berhasil dihapus!');
    }

    // 4. Perangkat Desa CRUD
    public function perangkatIndex()
    {
        $items = PerangkatDesa::orderBy('id', 'asc')->get();
        return view('admin.perangkat', compact('items'));
    }

    public function perangkatStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'foto' => 'nullable|string|max:255',
        ]);

        PerangkatDesa::create($data);
        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil ditambahkan!');
    }

    public function perangkatUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'foto' => 'nullable|string|max:255',
        ]);

        $item = PerangkatDesa::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil diperbarui!');
    }

    public function perangkatDestroy($id)
    {
        $item = PerangkatDesa::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil dihapus!');
    }

    // 5. Komoditas CRUD
    public function komoditasIndex()
    {
        $items = Komoditas::orderBy('id', 'asc')->get();
        return view('admin.komoditas', compact('items'));
    }

    public function komoditasStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'luas_atau_jumlah' => 'required|string|max:255',
            'hasil' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe' => 'required|string|max:255',
        ]);

        Komoditas::create($data);
        return redirect()->route('admin.komoditas.index')->with('success', 'Komoditas berhasil ditambahkan!');
    }

    public function komoditasUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'luas_atau_jumlah' => 'required|string|max:255',
            'hasil' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe' => 'required|string|max:255',
        ]);

        $item = Komoditas::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.komoditas.index')->with('success', 'Komoditas berhasil diperbarui!');
    }

    public function komoditasDestroy($id)
    {
        $item = Komoditas::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.komoditas.index')->with('success', 'Komoditas berhasil dihapus!');
    }

    // 6. Aset Tani CRUD
    public function asetTaniIndex()
    {
        $items = AsetTani::orderBy('id', 'asc')->get();
        return view('admin.asettani', compact('items'));
    }

    public function asetTaniStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'fungsi' => 'required|string|max:255',
            'kapasitas' => 'required|string|max:255',
            'pengelola' => 'required|string|max:255',
        ]);

        AsetTani::create($data);
        return redirect()->route('admin.asettani.index')->with('success', 'Aset tani berhasil ditambahkan!');
    }

    public function asetTaniUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'fungsi' => 'required|string|max:255',
            'kapasitas' => 'required|string|max:255',
            'pengelola' => 'required|string|max:255',
        ]);

        $item = AsetTani::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.asettani.index')->with('success', 'Aset tani berhasil diperbarui!');
    }

    public function asetTaniDestroy($id)
    {
        $item = AsetTani::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.asettani.index')->with('success', 'Aset tani berhasil dihapus!');
    }

    // 7. Regulasi CRUD
    public function regulasiIndex()
    {
        $items = Regulasi::orderBy('id', 'desc')->get();
        return view('admin.regulasi', compact('items'));
    }

    public function regulasiStore(Request $request)
    {
        $data = $request->validate([
            'nomor' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        $data['tanggal'] = now()->translatedFormat('d F Y');

        Regulasi::create($data);
        return redirect()->route('admin.regulasi.index')->with('success', 'Regulasi berhasil ditambahkan!');
    }

    public function regulasiUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'nomor' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        $item = Regulasi::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.regulasi.index')->with('success', 'Regulasi berhasil diperbarui!');
    }

    public function regulasiDestroy($id)
    {
        $item = Regulasi::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.regulasi.index')->with('success', 'Regulasi berhasil dihapus!');
    }

    // 8. UMKM CRUD
    public function umkmIndex()
    {
        $items = Umkm::orderBy('id', 'desc')->get();
        return view('admin.umkm', compact('items'));
    }

    public function umkmStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'omzet' => 'required|string|max:255',
        ]);

        $omzetVal = (int) filter_var($data['omzet'], FILTER_SANITIZE_NUMBER_INT);
        $biayaVal = (int) ($omzetVal * 0.55);
        $labaVal = $omzetVal - $biayaVal;

        $omzetFormatted = 'Rp ' . number_format($omzetVal, 0, ',', '.');
        $biayaFormatted = 'Rp ' . number_format($biayaVal, 0, ',', '.');
        $labaFormatted = 'Rp ' . number_format($labaVal, 0, ',', '.');

        Umkm::create([
            'nama' => $data['nama'],
            'pemilik' => $data['pemilik'],
            'kategori' => strtolower($data['kategori']),
            'kontak' => '0812-3456-7899',
            'alamat' => 'RT 01 / RW 01, Banyuurip',
            'deskripsi' => 'Pelaku usaha lokal binaan yang menyajikan produk unggulan berskala desa.',
            'omzet_bulanan' => $omzetFormatted,
            'biaya_produksi' => $biayaFormatted,
            'laba_bersih' => $labaFormatted,
            'pencatatan' => 'Buku Kas Sederhana (Dibantu Program KKN Akuntansi)',
            'produk' => ['Produk Utama', 'Produk Alternatif']
        ]);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil ditambahkan!');
    }

    public function umkmUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'omzet' => 'required|string|max:255',
        ]);

        $omzetVal = (int) filter_var($data['omzet'], FILTER_SANITIZE_NUMBER_INT);
        $biayaVal = (int) ($omzetVal * 0.55);
        $labaVal = $omzetVal - $biayaVal;

        $omzetFormatted = 'Rp ' . number_format($omzetVal, 0, ',', '.');
        $biayaFormatted = 'Rp ' . number_format($biayaVal, 0, ',', '.');
        $labaFormatted = 'Rp ' . number_format($labaVal, 0, ',', '.');

        $item = Umkm::findOrFail($id);
        $item->update([
            'nama' => $data['nama'],
            'pemilik' => $data['pemilik'],
            'kategori' => strtolower($data['kategori']),
            'omzet_bulanan' => $omzetFormatted,
            'biaya_produksi' => $biayaFormatted,
            'laba_bersih' => $labaFormatted,
        ]);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil diperbarui!');
    }

    public function umkmDestroy($id)
    {
        $item = Umkm::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil dihapus!');
    }

    // 9. Skrining ISPA CRUD
    public function skriningIndex()
    {
        $items = SkriningIspa::orderBy('id', 'desc')->get();
        return view('admin.skrining', compact('items'));
    }

    public function skriningDestroy($id)
    {
        $item = SkriningIspa::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.skrining.index')->with('success', 'Data skrining berhasil dihapus!');
    }

    // 10. APBDes (Transparansi Keuangan) CRUD
    public function apbdesIndex()
    {
        $items = Apbdes::orderBy('kategori', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.apbdes', compact('items'));
    }

    public function apbdesStore(Request $request)
    {
        $data = $request->validate([
            'kategori' => 'required|string|in:pendapatan,belanja',
            'rincian' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'persen' => 'required|integer|min:0|max:100',
        ]);

        Apbdes::create($data);
        return redirect()->route('admin.apbdes.index')->with('success', 'Anggaran APBDes berhasil ditambahkan!');
    }

    public function apbdesUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'kategori' => 'required|string|in:pendapatan,belanja',
            'rincian' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'persen' => 'required|integer|min:0|max:100',
        ]);

        $item = Apbdes::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.apbdes.index')->with('success', 'Anggaran APBDes berhasil diperbarui!');
    }

    public function apbdesDestroy($id)
    {
        $item = Apbdes::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.apbdes.index')->with('success', 'Anggaran APBDes berhasil dihapus!');
    }
}
