@extends('layouts.admin')

@section('page_title', 'Kelola Komoditas Pertanian')
@section('page_subtitle', 'Kelola hasil tani dan peternakan Desa Banyuurip yang tampil di portal agribisnis')

@section('content')
<div class="space-y-6" x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editItem: { id: '', nama: '', jenis: '', luas_atau_jumlah: '', hasil: '', deskripsi: '', tipe: 'tanaman' },
    openEdit(item) {
        this.editItem = { ...item };
        this.showEditModal = true;
    }
}">
    <!-- Statistik Agribisnis Desa Form Card -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
        <div class="flex items-center gap-2 mb-4">
            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                <i data-lucide="line-chart" class="h-4 w-4"></i>
            </div>
            <h3 class="text-sm font-bold text-slate-900">Statistik Agribisnis Desa</h3>
        </div>
        <form action="{{ route('admin.agribisnis.stats.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="luas_lahan" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Luas Lahan</label>
                    <input type="text" name="luas_lahan" id="luas_lahan" value="{{ old('luas_lahan', $stats->luas_lahan ?? '') }}" required
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none" placeholder="e.g. 245 Hektar">
                </div>
                <div>
                    <label for="jumlah_produksi" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Produksi per Tahun</label>
                    <input type="text" name="jumlah_produksi" id="jumlah_produksi" value="{{ old('jumlah_produksi', $stats->jumlah_produksi ?? '') }}" required
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none" placeholder="e.g. 1.500 Ton">
                </div>
                <div>
                    <label for="jumlah_petani" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jumlah Petani</label>
                    <input type="text" name="jumlah_petani" id="jumlah_petani" value="{{ old('jumlah_petani', $stats->jumlah_petani ?? '') }}" required
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none" placeholder="e.g. 520 Orang">
                </div>
                <div>
                    <label for="jumlah_kelompok_tani" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jumlah Kelompok Tani</label>
                    <input type="text" name="jumlah_kelompok_tani" id="jumlah_kelompok_tani" value="{{ old('jumlah_kelompok_tani', $stats->jumlah_kelompok_tani ?? '') }}" required
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none" placeholder="e.g. 12 Kelompok">
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Simpan Perubahan Statistik</span>
                </button>
            </div>
        </form>
    </div>
    <!-- Action Bar -->
    <div class="flex justify-end">
        <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
            <i data-lucide="plus-circle" class="h-4 w-4"></i>
            <span>Tambah Komoditas Baru</span>
        </button>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Komoditas</th>
                        <th scope="col" class="px-6 py-3">Tipe</th>
                        <th scope="col" class="px-6 py-3">Varietas / Jenis</th>
                        <th scope="col" class="px-6 py-3">Luas / Populasi</th>
                        <th scope="col" class="px-6 py-3">Estimasi Hasil</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                            {{ $item->nama }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 capitalize">
                            <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold {{ $item->tipe === 'tanaman' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/20' }}">
                                {{ $item->tipe }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $item->jenis }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                            {{ $item->luas_atau_jumlah }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                            {{ $item->hasil }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex gap-2">
                                <button @click="openEdit({{ json_encode($item) }})" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit">
                                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                                </button>
                                <form action="{{ route('admin.komoditas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komoditas ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 hover:bg-rose-50 rounded-lg text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">
                            <i data-lucide="inbox" class="h-8 w-8 mx-auto mb-2 opacity-50"></i>
                            Belum ada komoditas terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Tambah Komoditas -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showAddModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showAddModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="plus-circle" class="h-5 w-5 text-emerald-600"></i>
                        Tambah Komoditas Baru
                    </h3>
                    <button @click="showAddModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form action="{{ route('admin.komoditas.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Komoditas</label>
                            <select name="tipe" required class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                                <option value="tanaman">Tanaman / Pertanian</option>
                                <option value="peternakan">Peternakan / Perikanan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Komoditas</label>
                            <input type="text" name="nama" required placeholder="Contoh: Padi IR64, Sapi Perah" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Varietas / Jenis</label>
                            <input type="text" name="jenis" required placeholder="Contoh: Pangan Utama, Friesian Holstein" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Luas Lahan / Populasi</label>
                            <input type="text" name="luas_atau_jumlah" required placeholder="Contoh: 120 Hektar, 450 Ekor" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Estimasi Hasil Panen</label>
                        <input type="text" name="hasil" required placeholder="Contoh: 6.8 Ton / Ha, 12 Liter / Ekor / Hari" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                        <textarea name="deskripsi" required rows="3" placeholder="Tulis deskripsi wilayah sebaran komoditas tani..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="showAddModal = false" class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors cursor-pointer">Simpan Komoditas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Komoditas -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showEditModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showEditModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="edit" class="h-5 w-5 text-emerald-600"></i>
                        Edit Komoditas
                    </h3>
                    <button @click="showEditModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form :action="'{{ route('admin.komoditas.index') }}/' + editItem.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Komoditas</label>
                            <select name="tipe" required x-model="editItem.tipe" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                                <option value="tanaman">Tanaman / Pertanian</option>
                                <option value="peternakan">Peternakan / Perikanan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Komoditas</label>
                            <input type="text" name="nama" required x-model="editItem.nama" placeholder="Contoh: Padi IR64, Sapi Perah" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Varietas / Jenis</label>
                            <input type="text" name="jenis" required x-model="editItem.jenis" placeholder="Contoh: Pangan Utama, Friesian Holstein" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Luas Lahan / Populasi</label>
                            <input type="text" name="luas_atau_jumlah" required x-model="editItem.luas_atau_jumlah" placeholder="Contoh: 120 Hektar, 450 Ekor" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Estimasi Hasil Panen</label>
                        <input type="text" name="hasil" required x-model="editItem.hasil" placeholder="Contoh: 6.8 Ton / Ha, 12 Liter / Ekor / Hari" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                        <textarea name="deskripsi" required x-model="editItem.deskripsi" rows="3" placeholder="Tulis deskripsi wilayah sebaran komoditas tani..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green"></textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="showEditModal = false" class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors cursor-pointer">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
