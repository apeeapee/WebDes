@extends('layouts.admin')

@section('page_title', 'Kelola Desa Antikorupsi & Regulasi Drive')
@section('page_subtitle', 'Pusat pengelolaan dokumen indikator Desa Antikorupsi KPK dengan tautan berkas langsung ke Google Drive')

@section('content')
<div class="space-y-6" x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editItem: { id: '', nomor: '', judul: '', kategori: 'Penguatan Tata Laksana', deskripsi: '', link_drive: '', status: 'Terverifikasi' },
    openEdit(item) {
        this.editItem = { ...item };
        this.showEditModal = true;
    }
}">
    <!-- Action & Summary Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shadow-xs">
                <i data-lucide="shield-check" class="h-5 w-5"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Program Desa Antikorupsi (KPK)</h3>
                <p class="text-xs text-slate-500">Total {{ count($items) }} Dokumen Regulasi Terdaftar</p>
            </div>
        </div>
        
        <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
            <i data-lucide="plus-circle" class="h-4 w-4"></i>
            <span>Tambah Dokumen / Indikator Drive</span>
        </button>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Kode / Nomor</th>
                        <th scope="col" class="px-6 py-3.5">Judul Dokumen / Indikator</th>
                        <th scope="col" class="px-6 py-3.5">Pilar Indikator KPK</th>
                        <th scope="col" class="px-6 py-3.5">Akses Google Drive</th>
                        <th scope="col" class="px-6 py-3.5">Status</th>
                        <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-mono text-slate-700 border border-slate-200">
                                {{ $item->nomor }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <strong class="text-slate-900 font-bold block text-sm">{{ $item->judul }}</strong>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 max-w-md">{{ $item->deskripsi }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold 
                                {{ $item->kategori === 'Penguatan Tata Laksana' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/10' : 
                                  ($item->kategori === 'Penguatan Pengawasan' ? 'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/10' : 
                                  ($item->kategori === 'Penguatan Pelayanan Publik' ? 'bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-600/10' : 
                                  ($item->kategori === 'Penguatan Partisipasi Publik' ? 'bg-purple-50 text-purple-700 ring-1 ring-inset ring-purple-600/10' : 
                                  'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/10'))) }}">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->link_drive)
                                <a href="{{ $item->link_drive }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 hover:bg-emerald-100 transition-colors border border-emerald-200">
                                    <svg class="h-4 w-4 text-emerald-600 fill-current" viewBox="0 0 24 24">
                                        <path d="M12.01 1.485c-2.08 0-4.04.81-5.51 2.28L.685 9.585c-.91.91-.91 2.39 0 3.3l5.815 5.815c1.47 1.47 3.43 2.28 5.51 2.28h.03c2.08 0 4.04-.81 5.51-2.28l5.815-5.815c.91-.91.91-2.39 0-3.3L17.55 3.765c-1.47-1.47-3.43-2.28-5.51-2.28h-.03zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0z"/>
                                    </svg>
                                    <span>Google Drive</span>
                                    <i data-lucide="external-link" class="h-3 w-3"></i>
                                </a>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-2.5 py-1 text-xs text-slate-400">
                                    <i data-lucide="link-2-off" class="h-3.5 w-3.5"></i>
                                    <span>Belum ada link</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-bold
                                {{ $item->status === 'Terverifikasi' ? 'bg-emerald-100 text-emerald-800' : 
                                  ($item->status === 'Dalam Review' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $item->status === 'Terverifikasi' ? 'bg-emerald-600' : 'bg-amber-600' }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="inline-flex gap-2">
                                <button @click="openEdit({{ json_encode($item) }})" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit Dokumen">
                                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                                </button>
                                <form action="{{ route('admin.antikorupsi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen indikator ini?')" class="inline">
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
                            Belum ada dokumen indikator Desa Antikorupsi terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Tambah Dokumen Antikorupsi -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showAddModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showAddModal = false"></div>

            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="shield-plus" class="h-5 w-5 text-emerald-600"></i>
                        Tambah Dokumen Desa Antikorupsi
                    </h3>
                    <button @click="showAddModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form action="{{ route('admin.antikorupsi.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode / Nomor Regulasi</label>
                            <input type="text" name="nomor" required placeholder="Contoh: PAK-TL-01/2026" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilar Indikator KPK</label>
                            <select name="kategori" required class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                                <option value="Penguatan Tata Laksana">Penguatan Tata Laksana</option>
                                <option value="Penguatan Pengawasan">Penguatan Pengawasan</option>
                                <option value="Penguatan Pelayanan Publik">Penguatan Pelayanan Publik</option>
                                <option value="Penguatan Partisipasi Publik">Penguatan Partisipasi Publik</option>
                                <option value="Budaya Antikorupsi">Budaya Antikorupsi</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Dokumen / Indikator</label>
                        <input type="text" name="judul" required placeholder="Contoh: SOP Pengadaan Barang & Jasa Bebas Pungli" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penjelasan Uraian Dokumen</label>
                        <textarea name="deskripsi" required rows="3" placeholder="Jelaskan secara ringkas maksud dan cakupan dokumen bukti dukung ini..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center justify-between">
                            <span>Tautan Link Google Drive Dokumen</span>
                            <span class="text-[10px] text-emerald-600 font-normal">Direct Link Google Drive</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-lucide="link" class="h-4 w-4 text-emerald-600"></i>
                            </div>
                            <input type="url" name="link_drive" placeholder="https://drive.google.com/drive/folders/..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">Masukkan URL bagikan folder atau file PDF dokumen bukti dukung dari Google Drive.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Verifikasi</label>
                        <select name="status" required class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                            <option value="Terverifikasi">Terverifikasi / Lengkap</option>
                            <option value="Dalam Review">Dalam Review</option>
                            <option value="Draft">Draft Internal</option>
                        </select>
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="showAddModal = false" class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-800 transition-colors cursor-pointer">Simpan Dokumen Drive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Dokumen Antikorupsi -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showEditModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showEditModal = false"></div>

            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="edit" class="h-5 w-5 text-emerald-600"></i>
                        Edit Dokumen Desa Antikorupsi
                    </h3>
                    <button @click="showEditModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form :action="'{{ route('admin.antikorupsi.index') }}/' + editItem.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode / Nomor Regulasi</label>
                            <input type="text" name="nomor" required x-model="editItem.nomor" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilar Indikator KPK</label>
                            <select name="kategori" required x-model="editItem.kategori" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                                <option value="Penguatan Tata Laksana">Penguatan Tata Laksana</option>
                                <option value="Penguatan Pengawasan">Penguatan Pengawasan</option>
                                <option value="Penguatan Pelayanan Publik">Penguatan Pelayanan Publik</option>
                                <option value="Penguatan Partisipasi Publik">Penguatan Partisipasi Publik</option>
                                <option value="Budaya Antikorupsi">Budaya Antikorupsi</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Dokumen / Indikator</label>
                        <input type="text" name="judul" required x-model="editItem.judul" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penjelasan Uraian Dokumen</label>
                        <textarea name="deskripsi" required rows="3" x-model="editItem.deskripsi" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center justify-between">
                            <span>Tautan Link Google Drive Dokumen</span>
                            <template x-if="editItem.link_drive">
                                <a :href="editItem.link_drive" target="_blank" class="text-[10px] text-emerald-600 font-bold hover:underline flex items-center gap-1">
                                    <span>Tes Buka Drive</span>
                                    <i data-lucide="external-link" class="h-3 w-3"></i>
                                </a>
                            </template>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-lucide="link" class="h-4 w-4 text-emerald-600"></i>
                            </div>
                            <input type="url" name="link_drive" x-model="editItem.link_drive" placeholder="https://drive.google.com/drive/folders/..." class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Verifikasi</label>
                        <select name="status" required x-model="editItem.status" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                            <option value="Terverifikasi">Terverifikasi / Lengkap</option>
                            <option value="Dalam Review">Dalam Review</option>
                            <option value="Draft">Draft Internal</option>
                        </select>
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="showEditModal = false" class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-800 transition-colors cursor-pointer">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
