<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

class AdminController extends Controller
{
    // 1. Dashboard Overview
    public function index()
    {
        $stats = [
            'total_warga' => (int) VillageSetting::getVal('total_warga', 3420),
            'kepala_keluarga' => (int) VillageSetting::getVal('kepala_keluarga', 985),
            'luas_wilayah' => VillageSetting::getVal('luas_wilayah', '245 Hektar'),
            'posyandu_aktif' => (int) VillageSetting::getVal('posyandu_aktif', 5),
            'total_screening_ispa' => SkriningIspa::count(),
            'skrining_risiko_tinggi' => SkriningIspa::where('risiko', 'Tinggi')->count(),
            'umkm_aktif' => Umkm::count(),
            'dokumen_hukum' => Regulasi::count(),
            'total_berita' => Berita::count(),
            'total_perangkat' => PerangkatDesa::count(),
            'total_komoditas' => Komoditas::count(),
            'total_aset' => AsetTani::count(),
            'total_antikorupsi' => DesaAntikorupsi::count(),
        ];

        $recent_screenings = SkriningIspa::orderBy('id', 'desc')->take(5)->get();

        return Inertia::render('Admin/Dashboard', compact('stats', 'recent_screenings'));
    }

    public function updateStats(Request $request)
    {
        $data = $request->validate([
            'total_warga' => 'required|numeric|min:0',
            'kepala_keluarga' => 'required|numeric|min:0',
            'luas_wilayah' => 'required|string|max:255',
            'posyandu_aktif' => 'required|numeric|min:0',
        ]);

        VillageSetting::setVal('total_warga', $data['total_warga']);
        VillageSetting::setVal('kepala_keluarga', $data['kepala_keluarga']);
        VillageSetting::setVal('luas_wilayah', $data['luas_wilayah']);
        VillageSetting::setVal('posyandu_aktif', $data['posyandu_aktif']);

        return redirect()->route('admin')->with('success', 'Statistik utama desa berhasil diperbarui!');
    }

    // 2. Berita CRUD
    public function beritaIndex()
    {
        $items = Berita::orderBy('id', 'desc')->get();
        return Inertia::render('Admin/Berita', compact('items'));
    }

    public function beritaStore(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('berita', $fileName, 'public');
            $data['gambar'] = 'storage/' . $filePath;
        }

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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $item = Berita::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($item->gambar) {
                $oldPath = str_replace('storage/', '', $item->gambar);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('gambar');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('berita', $fileName, 'public');
            $data['gambar'] = 'storage/' . $filePath;
        }

        $item->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function beritaDestroy($id)
    {
        $item = Berita::findOrFail($id);
        if ($item->gambar) {
            $oldPath = str_replace('storage/', '', $item->gambar);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        $item->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    // 3. Sejarah CRUD
    public function sejarahIndex()
    {
        $items = Sejarah::orderBy('tahun', 'asc')->get();
        return Inertia::render('Admin/Sejarah', compact('items'));
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
        $items = PerangkatDesa::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        return Inertia::render('Admin/Perangkat', compact('items'));
    }

    public function perangkatStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:1',
            'foto' => 'nullable',
        ]);

        $maxUrutan = PerangkatDesa::max('urutan') ?? 0;

        $perangkatData = [
            'nama' => $data['nama'],
            'jabatan' => $data['jabatan'],
            'kontak' => $data['kontak'],
            'urutan' => $data['urutan'] ?? ($maxUrutan + 1),
            'foto' => null,
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if (!$file->isValid()) {
                return back()->withErrors(['foto' => 'Gagal mengunggah foto. Ukuran file foto terlalu besar melebihi batas PHP server (max 2MB-8MB). Silakan kompres gambar terlebih dahulu.']);
            }
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('perangkat', $fileName, 'public');
            $perangkatData['foto'] = 'storage/' . $filePath;
        }

        PerangkatDesa::create($perangkatData);
        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil ditambahkan!');
    }

    public function perangkatUpdate(Request $request, $id)
    {
        $item = PerangkatDesa::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
            'foto' => 'nullable',
        ]);

        $perangkatData = [
            'nama' => $data['nama'],
            'jabatan' => $data['jabatan'],
            'kontak' => $data['kontak'],
            'urutan' => $data['urutan'],
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if (!$file->isValid()) {
                return back()->withErrors(['foto' => 'Gagal mengunggah foto. Ukuran file foto terlalu besar melebihi batas PHP server (max 2MB-8MB). Silakan kompres gambar terlebih dahulu.']);
            }

            // Delete old photo if exists
            if ($item->foto) {
                $oldPath = str_replace('storage/', '', $item->foto);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('perangkat', $fileName, 'public');
            $perangkatData['foto'] = 'storage/' . $filePath;
        }

        $item->update($perangkatData);
        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil diperbarui!');
    }

    public function perangkatReorder(Request $request, $id)
    {
        $direction = $request->input('direction');
        $item = PerangkatDesa::findOrFail($id);

        if ($direction === 'up') {
            $prev = PerangkatDesa::where('urutan', '<', $item->urutan)
                ->orderBy('urutan', 'desc')
                ->first();
            if ($prev) {
                $temp = $item->urutan;
                $item->urutan = $prev->urutan;
                $prev->urutan = $temp;
                $item->save();
                $prev->save();
            }
        } elseif ($direction === 'down') {
            $next = PerangkatDesa::where('urutan', '>', $item->urutan)
                ->orderBy('urutan', 'asc')
                ->first();
            if ($next) {
                $temp = $item->urutan;
                $item->urutan = $next->urutan;
                $next->urutan = $temp;
                $item->save();
                $next->save();
            }
        }

        return redirect()->route('admin.perangkat.index')->with('success', 'Urutan perangkat desa berhasil diubah!');
    }

    public function perangkatDestroy($id)
    {
        $item = PerangkatDesa::findOrFail($id);
        if ($item->foto) {
            $oldPath = str_replace('storage/', '', $item->foto);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        $item->delete();
        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil dihapus!');
    }

    // 5. Komoditas CRUD
    public function komoditasIndex()
    {
        $items = Komoditas::orderBy('id', 'asc')->get();
        $stats = AgribisnisStat::first();
        return Inertia::render('Admin/Komoditas', compact('items', 'stats'));
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

    public function updateAgribisnisStats(Request $request)
    {
        $data = $request->validate([
            'luas_lahan' => 'required|string|max:255',
            'jumlah_produksi' => 'required|string|max:255',
            'jumlah_petani' => 'required|string|max:255',
            'jumlah_kelompok_tani' => 'required|string|max:255',
        ]);

        $stats = AgribisnisStat::first();
        if (!$stats) {
            $stats = new AgribisnisStat();
        }
        $stats->fill($data)->save();

        return redirect()->route('admin.komoditas.index')->with('success', 'Statistik agribisnis berhasil diperbarui!');
    }

    // 6. Aset Tani CRUD
    public function asetTaniIndex()
    {
        $items = AsetTani::orderBy('id', 'asc')->get();
        return Inertia::render('Admin/AsetTani', compact('items'));
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
        return Inertia::render('Admin/Regulasi', compact('items'));
    }

    public function regulasiStore(Request $request)
    {
        $data = $request->validate([
            'nomor' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'link_url' => 'nullable|url|max:2048',
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
            'link_url' => 'nullable|url|max:2048',
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
        return Inertia::render('Admin/Umkm', compact('items'));
    }

    public function umkmStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'produk' => 'required|string',
            'omzet' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $produkArray = array_map('trim', explode(',', $data['produk']));

        $umkmData = [
            'nama' => $data['nama'],
            'pemilik' => $data['pemilik'],
            'kategori' => strtolower($data['kategori']),
            'kontak' => $data['kontak'],
            'alamat' => $data['alamat'],
            'deskripsi' => $data['deskripsi'],
            'omzet_bulanan' => '',
            'biaya_produksi' => '',
            'laba_bersih' => '',
            'pencatatan_keuangan' => 'Laporan Mandiri',
            'produk' => $produkArray,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('umkm', $fileName, 'public');
            $umkmData['gambar'] = 'storage/' . $filePath;
        }

        Umkm::create($umkmData);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil ditambahkan!');
    }

    public function umkmUpdate(Request $request, $id)
    {
        $item = Umkm::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'produk' => 'required|string',
            'omzet' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $produkArray = array_map('trim', explode(',', $data['produk']));

        $umkmData = [
            'nama' => $data['nama'],
            'pemilik' => $data['pemilik'],
            'kategori' => strtolower($data['kategori']),
            'kontak' => $data['kontak'],
            'alamat' => $data['alamat'],
            'deskripsi' => $data['deskripsi'],
            'produk' => $produkArray,
        ];

        if ($request->hasFile('gambar')) {
            if ($item->gambar) {
                $oldPath = str_replace('storage/', '', $item->gambar);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $file = $request->file('gambar');
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('umkm', $fileName, 'public');
            $umkmData['gambar'] = 'storage/' . $filePath;
        }

        $item->update($umkmData);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil diperbarui!');
    }

    public function umkmDestroy($id)
    {
        $item = Umkm::findOrFail($id);
        if ($item->gambar) {
            $oldPath = str_replace('storage/', '', $item->gambar);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        $item->delete();
        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil dihapus!');
    }

    // 9. Skrining ISPA CRUD
    public function skriningIndex()
    {
        $items = SkriningIspa::orderBy('id', 'desc')->get();
        return Inertia::render('Admin/Skrining', compact('items'));
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
        return Inertia::render('Admin/Apbdes', compact('items'));
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

    // 11. Desa Antikorupsi CRUD
    public function antikorupsiIndex()
    {
        $items = DesaAntikorupsi::orderBy('id', 'desc')->get();
        return Inertia::render('Admin/Antikorupsi', compact('items'));
    }

    public function antikorupsiStore(Request $request)
    {
        $data = $request->validate([
            'nomor' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link_drive' => 'nullable|url|max:2048',
            'status' => 'required|string|max:255',
        ]);

        $data['tanggal'] = now()->translatedFormat('d F Y');

        DesaAntikorupsi::create($data);
        return redirect()->route('admin.antikorupsi.index')->with('success', 'Dokumen Desa Antikorupsi berhasil ditambahkan!');
    }

    public function antikorupsiUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'nomor' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link_drive' => 'nullable|url|max:2048',
            'status' => 'required|string|max:255',
        ]);

        $item = DesaAntikorupsi::findOrFail($id);
        $item->update($data);
        return redirect()->route('admin.antikorupsi.index')->with('success', 'Dokumen Desa Antikorupsi berhasil diperbarui!');
    }

    public function antikorupsiDestroy($id)
    {
        $item = DesaAntikorupsi::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.antikorupsi.index')->with('success', 'Dokumen Desa Antikorupsi berhasil dihapus!');
    }
}
