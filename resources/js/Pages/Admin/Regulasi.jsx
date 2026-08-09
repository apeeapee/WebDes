import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { PlusCircle, Edit3, Trash2, X, Inbox, ExternalLink } from 'lucide-react';

export default function Regulasi({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        nomor: '',
        judul: '',
        kategori: 'Peraturan Desa',
        link_url: '',
    });

    const editForm = useForm({
        nomor: '',
        judul: '',
        kategori: 'Peraturan Desa',
        link_url: '',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/regulasi', {
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        editForm.setData({
            nomor: item.nomor || '',
            judul: item.judul || '',
            kategori: item.kategori || 'Peraturan Desa',
            link_url: item.link_url || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        editForm.put(`/admin/regulasi/${editingId}`, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen regulasi ini?')) {
            router.delete(`/admin/regulasi/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Regulasi Hukum" subtitle="Kelola peraturan desa dan surat keputusan resmi desa yang tampil di portal keuangan & regulasi">
            <Head title="Admin - Regulasi" />

            <div class="space-y-6">
                <div class="flex justify-end">
                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Dokumen Regulasi</span>
                    </button>
                </div>

                <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-500">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nomor / Tahun</th>
                                    <th scope="col" class="px-6 py-3">Judul Regulasi</th>
                                    <th scope="col" class="px-6 py-3">Jenis Kategori</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Unggah</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                {item.nomor}
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 font-medium">
                                                <div class="flex items-center gap-2">
                                                    <span>{item.judul}</span>
                                                    {item.link_url && (
                                                        <a href={item.link_url} target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-100 hover:bg-emerald-100 transition-colors">
                                                            <ExternalLink class="h-3 w-3" />
                                                            <span>Drive</span>
                                                        </a>
                                                    )}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 text-xs whitespace-nowrap">
                                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-0.5 font-bold text-slate-700">
                                                    {item.kategori}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                                {item.tanggal}
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
                                        <td colSpan="5" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            <Inbox class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                            Belum ada dokumen regulasi terbit
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
                                    Tambah Regulasi Baru
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Dokumen</label>
                                    <select 
                                        value={addForm.data.kategori}
                                        onChange={(e) => addForm.setData('kategori', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    >
                                        <option>Peraturan Desa</option>
                                        <option>Peraturan Kepala Desa</option>
                                        <option>Surat Keputusan Desa</option>
                                        <option>Dokumen Rencana Pembangunan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor & Tahun Dokumen</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.nomor}
                                        onChange={(e) => addForm.setData('nomor', e.target.value)}
                                        required 
                                        placeholder="Contoh: Perdes No. 04 Tahun 2026" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Dokumen</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.judul}
                                        onChange={(e) => addForm.setData('judul', e.target.value)}
                                        required 
                                        placeholder="Contoh: Tata Tertib Keamanan Dusun I" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Link Google Drive / Dokumen (Opsional)</label>
                                    <input 
                                        type="url" 
                                        value={addForm.data.link_url}
                                        onChange={(e) => addForm.setData('link_url', e.target.value)}
                                        placeholder="Contoh: https://drive.google.com/file/d/..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">Simpan Dokumen</button>
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
                                    Edit Regulasi Hukum
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Dokumen</label>
                                    <select 
                                        value={editForm.data.kategori}
                                        onChange={(e) => editForm.setData('kategori', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    >
                                        <option>Peraturan Desa</option>
                                        <option>Peraturan Kepala Desa</option>
                                        <option>Surat Keputusan Desa</option>
                                        <option>Dokumen Rencana Pembangunan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor & Tahun Dokumen</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.nomor}
                                        onChange={(e) => editForm.setData('nomor', e.target.value)}
                                        required 
                                        placeholder="Contoh: Perdes No. 04 Tahun 2026" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Dokumen</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.judul}
                                        onChange={(e) => editForm.setData('judul', e.target.value)}
                                        required 
                                        placeholder="Contoh: Tata Tertib Keamanan Dusun I" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Link Google Drive / Dokumen (Opsional)</label>
                                    <input 
                                        type="url" 
                                        value={editForm.data.link_url}
                                        onChange={(e) => editForm.setData('link_url', e.target.value)}
                                        placeholder="Contoh: https://drive.google.com/file/d/..." 
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
