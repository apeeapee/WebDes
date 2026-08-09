import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { LineChart, Save, PlusCircle, Edit3, Trash2, X, Inbox } from 'lucide-react';

export default function Komoditas({ items, stats }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const statsForm = useForm({
        luas_lahan: stats?.luas_lahan || '',
        jumlah_produksi: stats?.jumlah_produksi || '',
        jumlah_petani: stats?.jumlah_petani || '',
        jumlah_kelompok_tani: stats?.jumlah_kelompok_tani || '',
    });

    const addForm = useForm({
        tipe: 'tanaman',
        nama: '',
        jenis: '',
        luas_atau_jumlah: '',
        hasil: '',
        deskripsi: '',
    });

    const editForm = useForm({
        tipe: 'tanaman',
        nama: '',
        jenis: '',
        luas_atau_jumlah: '',
        hasil: '',
        deskripsi: '',
    });

    const handleStatsSubmit = (e) => {
        e.preventDefault();
        statsForm.put('/admin/agribisnis/stats');
    };

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/komoditas', {
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        editForm.setData({
            tipe: item.tipe || 'tanaman',
            nama: item.nama || '',
            jenis: item.jenis || '',
            luas_atau_jumlah: item.luas_atau_jumlah || '',
            hasil: item.hasil || '',
            deskripsi: item.deskripsi || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        editForm.put(`/admin/komoditas/${editingId}`, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus komoditas ini?')) {
            router.delete(`/admin/komoditas/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Komoditas Pertanian" subtitle="Kelola hasil tani dan peternakan Desa Banyuurip yang tampil di portal agribisnis">
            <Head title="Admin - Komoditas" />

            <div class="space-y-6">
                {/* Stats Form Card */}
                <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                            <LineChart class="h-4 w-4" />
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">Statistik Agribisnis Desa</h3>
                    </div>
                    <form onSubmit={handleStatsSubmit}>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Luas Lahan</label>
                                <input 
                                    type="text" 
                                    value={statsForm.data.luas_lahan}
                                    onChange={(e) => statsForm.setData('luas_lahan', e.target.value)}
                                    required
                                    placeholder="e.g. 245 Hektar"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Produksi per Tahun</label>
                                <input 
                                    type="text" 
                                    value={statsForm.data.jumlah_produksi}
                                    onChange={(e) => statsForm.setData('jumlah_produksi', e.target.value)}
                                    required
                                    placeholder="e.g. 1.500 Ton"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jumlah Petani</label>
                                <input 
                                    type="text" 
                                    value={statsForm.data.jumlah_petani}
                                    onChange={(e) => statsForm.setData('jumlah_petani', e.target.value)}
                                    required
                                    placeholder="e.g. 520 Orang"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jumlah Kelompok Tani</label>
                                <input 
                                    type="text" 
                                    value={statsForm.data.jumlah_kelompok_tani}
                                    onChange={(e) => statsForm.setData('jumlah_kelompok_tani', e.target.value)}
                                    required
                                    placeholder="e.g. 12 Kelompok"
                                    class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none"
                                />
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" disabled={statsForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                                <Save class="h-4 w-4" />
                                <span>Simpan Perubahan Statistik</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex justify-end">
                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Komoditas Baru</span>
                    </button>
                </div>

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
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                {item.nama}
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 capitalize">
                                                <span class={`inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold ${
                                                    item.tipe === 'tanaman' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20' : 'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/20'
                                                }`}>
                                                    {item.tipe}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                {item.jenis}
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                                {item.luas_atau_jumlah}
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                                {item.hasil}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="inline-flex gap-2">
                                                    <button onClick={() => openEdit(item)} class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit">
                                                        <Edit3 class="h-4 w-4" />
                                                    </button>
                                                    <button onClick={() => handleDelete(item.id)} class="p-1.5 hover:bg-rose-50 rounded-lg text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus">
                                                        <Trash2 class="h-4 w-4" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="6" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            <Inbox class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                            Belum ada komoditas terdaftar
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* Modal Add */}
                {showAddModal && (
                    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                                    <PlusCircle class="h-5 w-5 text-emerald-600" />
                                    Tambah Komoditas Baru
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Komoditas</label>
                                        <select 
                                            value={addForm.data.tipe}
                                            onChange={(e) => addForm.setData('tipe', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                        >
                                            <option value="tanaman">Tanaman / Pertanian</option>
                                            <option value="peternakan">Peternakan / Perikanan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Komoditas</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.nama}
                                            onChange={(e) => addForm.setData('nama', e.target.value)}
                                            required 
                                            placeholder="Contoh: Padi IR64, Sapi Perah" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Varietas / Jenis</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.jenis}
                                            onChange={(e) => addForm.setData('jenis', e.target.value)}
                                            required 
                                            placeholder="Contoh: Pangan Utama, Friesian Holstein" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Luas Lahan / Populasi</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.luas_atau_jumlah}
                                            onChange={(e) => addForm.setData('luas_atau_jumlah', e.target.value)}
                                            required 
                                            placeholder="Contoh: 120 Hektar, 450 Ekor" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Estimasi Hasil Panen</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.hasil}
                                        onChange={(e) => addForm.setData('hasil', e.target.value)}
                                        required 
                                        placeholder="Contoh: 6.8 Ton / Ha, 12 Liter / Ekor / Hari" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                                    <textarea 
                                        value={addForm.data.deskripsi}
                                        onChange={(e) => addForm.setData('deskripsi', e.target.value)}
                                        required 
                                        rows={3} 
                                        placeholder="Tulis deskripsi wilayah sebaran komoditas tani..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    />
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">Simpan Komoditas</button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {/* Modal Edit */}
                {showEditModal && (
                    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                                    <Edit3 class="h-5 w-5 text-emerald-600" />
                                    Edit Komoditas
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Komoditas</label>
                                        <select 
                                            value={editForm.data.tipe}
                                            onChange={(e) => editForm.setData('tipe', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                        >
                                            <option value="tanaman">Tanaman / Pertanian</option>
                                            <option value="peternakan">Peternakan / Perikanan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Komoditas</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.nama}
                                            onChange={(e) => editForm.setData('nama', e.target.value)}
                                            required 
                                            placeholder="Contoh: Padi IR64, Sapi Perah" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Varietas / Jenis</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.jenis}
                                            onChange={(e) => editForm.setData('jenis', e.target.value)}
                                            required 
                                            placeholder="Contoh: Pangan Utama, Friesian Holstein" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Luas Lahan / Populasi</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.luas_atau_jumlah}
                                            onChange={(e) => editForm.setData('luas_atau_jumlah', e.target.value)}
                                            required 
                                            placeholder="Contoh: 120 Hektar, 450 Ekor" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Estimasi Hasil Panen</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.hasil}
                                        onChange={(e) => editForm.setData('hasil', e.target.value)}
                                        required 
                                        placeholder="Contoh: 6.8 Ton / Ha, 12 Liter / Ekor / Hari" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat</label>
                                    <textarea 
                                        value={editForm.data.deskripsi}
                                        onChange={(e) => editForm.setData('deskripsi', e.target.value)}
                                        required 
                                        rows={3} 
                                        placeholder="Tulis deskripsi wilayah sebaran komoditas tani..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    />
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowEditModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={editForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
