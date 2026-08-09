import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { PlusCircle, Edit3, Trash2, X, Inbox } from 'lucide-react';

export default function Apbdes({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        kategori: 'pendapatan',
        rincian: '',
        jumlah: '',
        persen: '',
    });

    const editForm = useForm({
        kategori: 'pendapatan',
        rincian: '',
        jumlah: '',
        persen: '',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/apbdes', {
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        editForm.setData({
            kategori: item.kategori || 'pendapatan',
            rincian: item.rincian || '',
            jumlah: item.jumlah || '',
            persen: item.persen || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        editForm.put(`/admin/apbdes/${editingId}`, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus item anggaran ini?')) {
            router.delete(`/admin/apbdes/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Transparansi Anggaran APBDes" subtitle="Kelola data pos estimasi pendapatan dan belanja desa yang muncul di diagram interaktif portal keuangan">
            <Head title="Admin - APBDes" />

            <div class="space-y-6">
                <div class="flex justify-end">
                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Item Anggaran</span>
                    </button>
                </div>

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
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class={`inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold capitalize ${
                                                    item.kategori === 'pendapatan' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/10' : 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10'
                                                }`}>
                                                    {item.kategori}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-slate-900">
                                                {item.rincian}
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 font-bold whitespace-nowrap">
                                                Rp {Number(item.jumlah).toLocaleString('id-ID')}
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 text-xs font-bold whitespace-nowrap">
                                                {item.persen}%
                                            </td>
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
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
                                        <td colSpan="5" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            <Inbox class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                            Belum ada anggaran terdaftar
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
                                    Tambah Anggaran APBDes
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Anggaran</label>
                                    <select 
                                        value={addForm.data.kategori}
                                        onChange={(e) => addForm.setData('kategori', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    >
                                        <option value="pendapatan">Pendapatan Desa</option>
                                        <option value="belanja">Belanja Desa</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rincian Anggaran (Sumber / Bidang)</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.rincian}
                                        onChange={(e) => addForm.setData('rincian', e.target.value)}
                                        required 
                                        placeholder="Contoh: Alokasi Dana Desa (ADD), Dana Desa (DD)" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jumlah Nominal (Rp)</label>
                                        <input 
                                            type="number" 
                                            value={addForm.data.jumlah}
                                            onChange={(e) => addForm.setData('jumlah', e.target.value)}
                                            required 
                                            placeholder="Contoh: 845000000" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Persentase (0-100)</label>
                                        <input 
                                            type="number" 
                                            value={addForm.data.persen}
                                            onChange={(e) => addForm.setData('persen', e.target.value)}
                                            required 
                                            placeholder="Contoh: 52" 
                                            min="0" 
                                            max="100" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">Simpan Anggaran</button>
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
                                    Edit Anggaran APBDes
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Anggaran</label>
                                    <select 
                                        value={editForm.data.kategori}
                                        onChange={(e) => editForm.setData('kategori', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    >
                                        <option value="pendapatan">Pendapatan Desa</option>
                                        <option value="belanja">Belanja Desa</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rincian Anggaran (Sumber / Bidang)</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.rincian}
                                        onChange={(e) => editForm.setData('rincian', e.target.value)}
                                        required 
                                        placeholder="Contoh: Dana Desa (APBN) atau Bidang Pembangunan" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jumlah Nominal (Rp)</label>
                                        <input 
                                            type="number" 
                                            value={editForm.data.jumlah}
                                            onChange={(e) => editForm.setData('jumlah', e.target.value)}
                                            required 
                                            placeholder="Contoh: 845000000" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Persentase (0-100)</label>
                                        <input 
                                            type="number" 
                                            value={editForm.data.persen}
                                            onChange={(e) => editForm.setData('persen', e.target.value)}
                                            required 
                                            placeholder="Contoh: 52" 
                                            min="0" 
                                            max="100" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                        />
                                    </div>
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
