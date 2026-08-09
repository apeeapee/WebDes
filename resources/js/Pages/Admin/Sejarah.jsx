import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { PlusCircle, Edit3, Trash2, X, Inbox } from 'lucide-react';

export default function Sejarah({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        tahun: '',
        judul: '',
        deskripsi: '',
    });

    const editForm = useForm({
        tahun: '',
        judul: '',
        deskripsi: '',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/sejarah', {
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        editForm.setData({
            tahun: item.tahun || '',
            judul: item.judul || '',
            deskripsi: item.deskripsi || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        editForm.put(`/admin/sejarah/${editingId}`, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus catatan sejarah ini?')) {
            router.delete(`/admin/sejarah/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Sejarah Desa" subtitle="Kelola rentang masa sejarah pembangunan Desa Banyuurip yang tampil di profil desa">
            <Head title="Admin - Kelola Sejarah" />

            <div class="space-y-6">
                <div class="flex justify-end">
                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Sejarah Baru</span>
                    </button>
                </div>

                <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-500">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tahun</th>
                                    <th scope="col" class="px-6 py-3">Judul Peristiwa</th>
                                    <th scope="col" class="px-6 py-3">Deskripsi Peristiwa</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                {item.tahun}
                                            </td>
                                            <td class="px-6 py-4 font-bold text-slate-800 whitespace-nowrap">
                                                {item.judul}
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs">
                                                <span class="line-clamp-2 max-w-md">{item.deskripsi}</span>
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
                                        <td colSpan="4" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            <Inbox class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                            Belum ada catatan sejarah terdaftar
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
                                    Tambah Sejarah Baru
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Peristiwa</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.tahun}
                                        onChange={(e) => addForm.setData('tahun', e.target.value)}
                                        required 
                                        placeholder="Contoh: 1830 atau 1945" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Peristiwa</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.judul}
                                        onChange={(e) => addForm.setData('judul', e.target.value)}
                                        required 
                                        placeholder="Contoh: Asal Usul Nama Desa" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Peristiwa</label>
                                    <textarea 
                                        value={addForm.data.deskripsi}
                                        onChange={(e) => addForm.setData('deskripsi', e.target.value)}
                                        required 
                                        rows={5} 
                                        placeholder="Tulis cerita sejarah lengkap peristiwa tersebut..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    />
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">Simpan Peristiwa</button>
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
                                    Edit Catatan Sejarah
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tahun Peristiwa</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.tahun}
                                        onChange={(e) => editForm.setData('tahun', e.target.value)}
                                        required 
                                        placeholder="Contoh: 1830 atau 1945" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Peristiwa</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.judul}
                                        onChange={(e) => editForm.setData('judul', e.target.value)}
                                        required 
                                        placeholder="Contoh: Asal Usul Nama Desa" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Peristiwa</label>
                                    <textarea 
                                        value={editForm.data.deskripsi}
                                        onChange={(e) => editForm.setData('deskripsi', e.target.value)}
                                        required 
                                        rows={5} 
                                        placeholder="Tulis cerita sejarah lengkap peristiwa tersebut..." 
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
