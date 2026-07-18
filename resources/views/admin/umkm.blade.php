@extends('layouts.admin')

@section('page_title', 'Kelola Direktori UMKM')
@section('page_subtitle', 'Kelola direktori pelaku usaha mikro dan promosi UMKM Desa Banyuurip yang tampil di portal UMKM')

@section('content')
<div class="space-y-6" x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editItem: { id: '', nama: '', pemilik: '', kategori: 'Makanan Ringan', omzet_bulanan: '' },
    openEdit(item) {
        // Parse omzet integer from formatted Rp string (e.g. 'Rp 2.500.000' -> 2500000)
        let omzetInt = item.omzet_bulanan.replace(/[^0-9]/g, '');
        this.editItem = { 
            id: item.id,
            nama: item.nama,
            pemilik: item.pemilik,
            kategori: item.kategori,
            omzet: omzetInt
        };
        this.showEditModal = true;
    }
}">
    <!-- Action Bar -->
    <div class="flex justify-end">
        <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
            <i data-lucide="plus-circle" class="h-4 w-4"></i>
            <span>Onboard UMKM Baru</span>
        </button>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Usaha</th>
                        <th scope="col" class="px-6 py-3">Pemilik</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Omzet Bulanan</th>
                        <th scope="col" class="px-6 py-3">Laba Bersih</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                            {{ $item->nama }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium whitespace-nowrap">
                            {{ $item->pemilik }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-xs capitalize whitespace-nowrap">
                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 font-bold text-amber-800 ring-1 ring-inset ring-amber-600/10">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-650 text-xs font-bold whitespace-nowrap">
                            {{ $item->omzet_bulanan }}
                        </td>
                        <td class="px-6 py-4 text-emerald-600 text-xs font-bold whitespace-nowrap">
                            {{ $item->laba_bersih }}
                        </td>
                        <td class="px-6 py-4 text-right font-medium">
                            <div class="inline-flex gap-2">
                                <button @click="openEdit({{ json_encode($item) }})" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit">
                                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                                </button>
                                <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?')" class="inline">
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
                            Belum ada UMKM terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Tambah UMKM -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showAddModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showAddModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="plus-circle" class="h-5 w-5 text-emerald-600"></i>
                        Onboard Pelaku UMKM Baru
                    </h3>
                    <button @click="showAddModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form action="{{ route('admin.umkm.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Usaha</label>
                            <input type="text" name="nama" required placeholder="Contoh: Keripik Singkong" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Pemilik</label>
                            <input type="text" name="pemilik" required placeholder="Contoh: Ibu Minah" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Usaha</label>
                            <select name="kategori" required class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                                <option>Makanan Ringan</option>
                                <option>Minuman Kemasan</option>
                                <option>Kerajinan Tangan</option>
                                <option>Jasa / Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Omzet Bulanan (Angka)</label>
                            <input type="text" name="omzet" required placeholder="Contoh: 2500000" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="showAddModal = false" class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors cursor-pointer">Simpan UMKM</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Edit UMKM -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showEditModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showEditModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="edit" class="h-5 w-5 text-emerald-600"></i>
                        Edit Profil UMKM
                    </h3>
                    <button @click="showEditModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form :action="'{{ route('admin.umkm.index') }}/' + editItem.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Usaha</label>
                            <input type="text" name="nama" required x-model="editItem.nama" placeholder="Contoh: Keripik Singkong" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Pemilik</label>
                            <input type="text" name="pemilik" required x-model="editItem.pemilik" placeholder="Contoh: Ibu Minah" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Usaha</label>
                            <select name="kategori" required x-model="editItem.kategori" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                                <option value="makanan ringan">Makanan Ringan</option>
                                <option value="minuman kemasan">Minuman Kemasan</option>
                                <option value="kerajinan tangan">Kerajinan Tangan</option>
                                <option value="jasa / lainnya">Jasa / Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Omzet Bulanan (Angka)</label>
                            <input type="text" name="omzet" required x-model="editItem.omzet" placeholder="Contoh: 2500000" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
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
