@extends('layouts.admin')

@section('page_title', 'Kelola Transparansi Anggaran APBDes')
@section('page_subtitle', 'Kelola data pos estimasi pendapatan dan belanja desa yang muncul di diagram interaktif portal keuangan')

@section('content')
<div class="space-y-6" x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editItem: { id: '', kategori: 'pendapatan', rincian: '', jumlah: '', persen: '' },
    openEdit(item) {
        this.editItem = { ...item };
        this.showEditModal = true;
    }
}">
    <!-- Action Bar -->
    <div class="flex justify-end">
        <button @click="showAddModal = true" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
            <i data-lucide="plus-circle" class="h-4 w-4"></i>
            <span>Tambah Item Anggaran</span>
        </button>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Kategori</th>
                        <th scope="col" class="px-6 py-3.5">Rincian Anggaran / Sumber / Bidang</th>
                        <th scope="col" class="px-6 py-3.5">Jumlah (Rp)</th>
                        <th scope="col" class="px-6 py-3.5">Persentase (%)</th>
                        <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold {{ $item->kategori === 'pendapatan' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/10' : 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10' }}">
                                {{ ucfirst($item->kategori) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">
                            {{ $item->rincian }}
                        </td>
                        <td class="px-6 py-4 text-slate-750 font-bold whitespace-nowrap">
                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-slate-650 text-xs font-bold whitespace-nowrap">
                            {{ $item->persen }}%
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="inline-flex gap-2">
                                <button @click="openEdit({{ json_encode($item) }})" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit">
                                    <i data-lucide="edit-3" class="h-4 w-4"></i>
                                </button>
                                <form action="{{ route('admin.apbdes.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item anggaran ini?')" class="inline">
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
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-medium">
                            <i data-lucide="inbox" class="h-8 w-8 mx-auto mb-2 opacity-50"></i>
                            Belum ada anggaran terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Tambah Anggaran -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showAddModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showAddModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="plus-circle" class="h-5 w-5 text-emerald-600"></i>
                        Tambah Anggaran APBDes
                    </h3>
                    <button @click="showAddModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form action="{{ route('admin.apbdes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Anggaran</label>
                        <select name="kategori" required class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                            <option value="pendapatan">Pendapatan Desa</option>
                            <option value="belanja">Belanja Desa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rincian Anggaran (Sumber / Bidang)</label>
                        <input type="text" name="rincian" required placeholder="Contoh: Alokasi Dana Desa (ADD), Dana Desa (DD), Pajak Bagi Hasil (PBH), Bankeu, atau PADes" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jumlah Nominal (Rp)</label>
                            <input type="number" name="jumlah" required placeholder="Contoh: 845000000" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Persentase (0-100)</label>
                            <input type="number" name="persen" required placeholder="Contoh: 52" min="0" max="100" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="showAddModal = false" class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors cursor-pointer">Simpan Anggaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Anggaran -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showEditModal" x-cloak>
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="showEditModal = false"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100 transform transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="edit" class="h-5 w-5 text-emerald-600"></i>
                        Edit Anggaran APBDes
                    </h3>
                    <button @click="showEditModal = false" class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form :action="'{{ route('admin.apbdes.index') }}/' + editItem.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Anggaran</label>
                        <select name="kategori" required x-model="editItem.kategori" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                            <option value="pendapatan">Pendapatan Desa</option>
                            <option value="belanja">Belanja Desa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rincian Anggaran (Sumber / Bidang)</label>
                        <input type="text" name="rincian" required x-model="editItem.rincian" placeholder="Contoh: Dana Desa (APBN) atau Bidang Pembangunan" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jumlah Nominal (Rp)</label>
                            <input type="number" name="jumlah" required x-model="editItem.jumlah" placeholder="Contoh: 845000000" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Persentase (0-100)</label>
                            <input type="number" name="persen" required x-model="editItem.persen" placeholder="Contoh: 52" min="0" max="100" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
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
