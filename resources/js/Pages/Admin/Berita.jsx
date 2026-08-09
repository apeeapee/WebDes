import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { PlusCircle, Newspaper, Edit3, Trash2, X, Inbox } from 'lucide-react';

export default function Berita({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        judul: '',
        ringkasan: '',
        kategori: 'Kegiatan Desa',
        tanggal: '',
        gambar: null,
    });

    const editForm = useForm({
        judul: '',
        ringkasan: '',
        kategori: 'Kegiatan Desa',
        tanggal: '',
        gambar: null,
        oldGambar: '',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/berita', {
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        editForm.setData({
            judul: item.judul || '',
            ringkasan: item.ringkasan || '',
            kategori: item.kategori || 'Kegiatan Desa',
            tanggal: item.tanggal || '',
            gambar: null,
            oldGambar: item.gambar || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        // Send multipart form with _method: 'PUT'
        router.post(`/admin/berita/${editingId}`, {
            _method: 'PUT',
            judul: editForm.data.judul,
            ringkasan: editForm.data.ringkasan,
            kategori: editForm.data.kategori,
            tanggal: editForm.data.tanggal,
            gambar: editForm.data.gambar,
        }, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
            router.delete(`/admin/berita/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Berita & Publikasi" subtitle="Tulis, perbarui, atau hapus warta berita desa yang tampil di beranda user">
            <Head title="Admin - Kelola Berita" />

            <div class="space-y-6">
                <div class="flex justify-end">
                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Berita Baru</span>
                    </button>
                </div>

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
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-10 w-10 rounded-lg overflow-hidden bg-slate-100 shrink-0">
                                                        {item.gambar ? (
                                                            <img src={`/${item.gambar}`} class="h-full w-full object-cover" alt="" />
                                                        ) : (
                                                            <div class="h-full w-full bg-emerald-50 flex items-center justify-center text-emerald-700">
                                                                <Newspaper class="h-5 w-5" />
                                                            </div>
                                                        )}
                                                    </div>
                                                    <span class="line-clamp-1">{item.judul}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                                    {item.kategori}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs">
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
                                        <td colSpan="4" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            <Inbox class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                            Belum ada warta berita terbit
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
                                    Tambah Berita Baru
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Berita</label>
                                    <select 
                                        value={addForm.data.kategori}
                                        onChange={(e) => addForm.setData('kategori', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    >
                                        <option>Kegiatan Desa</option>
                                        <option>Kesehatan</option>
                                        <option>Edukasi</option>
                                        <option>Pengumuman</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Publikasi</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.tanggal}
                                        onChange={(e) => addForm.setData('tanggal', e.target.value)}
                                        required 
                                        placeholder="Contoh: 18 Juli 2026" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Warta</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.judul}
                                        onChange={(e) => addForm.setData('judul', e.target.value)}
                                        required 
                                        placeholder="Tulis judul berita utama..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ringkasan Warta</label>
                                    <textarea 
                                        value={addForm.data.ringkasan}
                                        onChange={(e) => addForm.setData('ringkasan', e.target.value)}
                                        required 
                                        rows={4} 
                                        placeholder="Tulis isi ringkasan berita secara detail..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Berita (Opsional)</label>
                                    <input 
                                        type="file" 
                                        accept="image/*"
                                        onChange={(e) => addForm.setData('gambar', e.target.files[0])}
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" 
                                    />
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">Simpan Warta</button>
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
                                    Edit Berita
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Berita</label>
                                    <select 
                                        value={editForm.data.kategori}
                                        onChange={(e) => editForm.setData('kategori', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    >
                                        <option>Kegiatan Desa</option>
                                        <option>Kesehatan</option>
                                        <option>Edukasi</option>
                                        <option>Pengumuman</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Publikasi</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.tanggal}
                                        onChange={(e) => editForm.setData('tanggal', e.target.value)}
                                        required 
                                        placeholder="Contoh: 18 Juli 2026" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Warta</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.judul}
                                        onChange={(e) => editForm.setData('judul', e.target.value)}
                                        required 
                                        placeholder="Tulis judul berita utama..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ringkasan Warta</label>
                                    <textarea 
                                        value={editForm.data.ringkasan}
                                        onChange={(e) => editForm.setData('ringkasan', e.target.value)}
                                        required 
                                        rows={4} 
                                        placeholder="Tulis isi ringkasan berita secara detail..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-700"
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ganti Foto Berita (Opsional)</label>
                                    <input 
                                        type="file" 
                                        accept="image/*"
                                        onChange={(e) => editForm.setData('gambar', e.target.files[0])}
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer" 
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
