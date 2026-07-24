@extends('layouts.admin')

@section('page_title', 'Kelola Berita & Publikasi')
@section('page_subtitle', 'Tulis, perbarui, atau hapus warta berita desa yang tampil di beranda user')

@section('content')
<div class="space-y-6" x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editItem: { id: '', judul: '', ringkasan: '', kategori: 'Kegiatan Desa', tanggal: '', gambar: '' },
    openEdit(item) {
        this.editItem = { ...item };
        this.showEditModal = true;
    }
}">
    <!-- Action Bar -->
    <div class="flex justify-end">
        <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
            <i data-lucide="plus-circle" class="h-4 w-4"></i>
            <span>Tambah Berita Baru</span>
        </button>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Tanggal Terbit</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                                    @if($item->gambar && (str_starts_with($item->gambar, 'storage/') || file_exists(public_path($item->gambar))))
                                        <img src="{{ asset($item->gambar) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-emerald-50 flex items-center justify-center text-emerald-750">
                                            <i data-lucide="newspaper" class="h-5 w-5"></i>
                                        </div>
                                    @endif
                                </div>
                                <span class="line-clamp-1">{{ $item->judul }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            {{ $item->tanggal }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex gap-2">
                                <button @click="openEdit({{ json_encode($item) }})" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit">
                                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                                </button>
                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" class="inline">
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
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-medium">
                            <i data-lucide="inbox" class="h-8 w-8 mx-auto mb-2 opacity-50"></i>
                            Belum ada warta berita terbit
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Tambah Berita -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showAddModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showAddModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="plus-circle" class="h-5 w-5 text-emerald-600"></i>
                        Tambah Berita Baru
                    </h3>
                    <button @click="showAddModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                 <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Berita</label>
                        <select name="kategori" required class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                            <option>Kegiatan Desa</option>
                            <option>Kesehatan</option>
                            <option>Edukasi</option>
                            <option>Pengumuman</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Publikasi</label>
                        <input type="text" name="tanggal" required placeholder="Contoh: 18 Juli 2026" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Warta</label>
                        <input type="text" name="judul" required placeholder="Tulis judul berita utama..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ringkasan Warta</label>
                        <textarea name="ringkasan" required rows="4" placeholder="Tulis isi ringkasan berita secara detail..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Berita (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="showAddModal = false" class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors cursor-pointer">Simpan Warta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Berita -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showEditModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showEditModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="edit" class="h-5 w-5 text-emerald-600"></i>
                        Edit Berita
                    </h3>
                    <button @click="showEditModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form :action="'{{ route('admin.berita.index') }}/' + editItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Berita</label>
                        <select name="kategori" required x-model="editItem.kategori" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                            <option>Kegiatan Desa</option>
                            <option>Kesehatan</option>
                            <option>Edukasi</option>
                            <option>Pengumuman</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Publikasi</label>
                        <input type="text" name="tanggal" required x-model="editItem.tanggal" placeholder="Contoh: 18 Juli 2026" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Warta</label>
                        <input type="text" name="judul" required x-model="editItem.judul" placeholder="Tulis judul berita utama..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ringkasan Warta</label>
                        <textarea name="ringkasan" required x-model="editItem.ringkasan" rows="4" placeholder="Tulis isi ringkasan berita secara detail..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ganti Foto Berita (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        <template x-if="editItem.gambar && editItem.gambar.startsWith('storage/')">
                            <div class="mt-2 text-xs text-slate-500 flex items-center gap-1.5">
                                <i data-lucide="image" class="h-3.5 w-3.5 text-emerald-600"></i>
                                <span>Foto aktif: <a :href="'/' + editItem.gambar" target="_blank" class="text-emerald-600 hover:underline font-bold" x-text="editItem.gambar.split('/').pop()"></a></span>
                            </div>
                        </template>
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
