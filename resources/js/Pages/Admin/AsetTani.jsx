import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { PlusCircle, Edit3, Trash2, X, Inbox, Building2 } from 'lucide-react';

export default function AsetTani({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        nama: '',
        fungsi: '',
        kapasitas: '',
        pengelola: '',
    });

    const editForm = useForm({
        nama: '',
        fungsi: '',
        kapasitas: '',
        pengelola: '',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/asettani', {
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        editForm.setData({
            nama: item.nama || '',
            fungsi: item.fungsi || '',
            kapasitas: item.kapasitas || '',
            pengelola: item.pengelola || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        editForm.put(`/admin/asettani/${editingId}`, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus aset balai desa ini?')) {
            router.delete(`/admin/asettani/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Inventaris Aset Balai Desa" subtitle="Kelola fasilitas publik, aula pendopo, barang, dan inventaris aset Balai Desa Banyuurip yang dapat dipinjam warga">
            <Head title="Admin - Aset Balai Desa" />

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold shadow-xs">
                            <Building2 class="h-5 w-5" />
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Daftar Inventaris Aset Balai Desa</h3>
                            <p class="text-xs text-slate-500">Total {items.length} Aset & Fasilitas Terdaftar</p>
                        </div>
                    </div>

                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold py-2.5 px-4 shadow-xs transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Aset Balai Desa</span>
                    </button>
                </div>

                <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-500">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5">Nama Aset / Fasilitas</th>
                                    <th scope="col" class="px-6 py-3.5">Peruntukan / Kondisi</th>
                                    <th scope="col" class="px-6 py-3.5">Kapasitas / Ketersediaan</th>
                                    <th scope="col" class="px-6 py-3.5">Penanggung Jawab / Pengelola</th>
                                    <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                {item.nama}
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                {item.fungsi}
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 text-xs font-semibold whitespace-nowrap">
                                                {item.kapasitas}
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                                {item.pengelola}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="inline-flex gap-2">
                                                    <button onClick={() => openEdit(item)} class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit Aset">
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
                                            Belum ada aset balai desa terdaftar
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
                                    <Building2 class="h-5 w-5 text-sky-600" />
                                    Tambah Aset Balai Desa Baru
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Aset / Fasilitas</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.nama}
                                        onChange={(e) => addForm.setData('nama', e.target.value)}
                                        required 
                                        placeholder="Contoh: Pendopo Balai Desa, Sound System Portable, 100 Kursi Lipat" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Peruntukan / Kondisi Aset</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.fungsi}
                                        onChange={(e) => addForm.setData('fungsi', e.target.value)}
                                        required 
                                        placeholder="Contoh: Acara Pernikahan / Rapat Warga, Kondisi Layak Pakai 100%" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas / Jumlah Tersedia</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.kapasitas}
                                            onChange={(e) => addForm.setData('kapasitas', e.target.value)}
                                            required 
                                            placeholder="Contoh: 300 Orang, 2 Set Unit, 100 Buah" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penanggung Jawab / Pengelola</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.pengelola}
                                            onChange={(e) => addForm.setData('pengelola', e.target.value)}
                                            required 
                                            placeholder="Contoh: Perangkat Balai Desa, Pengelola Aset" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-sky-700 transition-colors">Simpan Aset</button>
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
                                    <Edit3 class="h-5 w-5 text-sky-600" />
                                    Edit Aset Balai Desa
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Aset / Fasilitas</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.nama}
                                        onChange={(e) => editForm.setData('nama', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Peruntukan / Kondisi Aset</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.fungsi}
                                        onChange={(e) => editForm.setData('fungsi', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas / Jumlah Tersedia</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.kapasitas}
                                            onChange={(e) => editForm.setData('kapasitas', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penanggung Jawab / Pengelola</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.pengelola}
                                            onChange={(e) => editForm.setData('pengelola', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowEditModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={editForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-sky-700 transition-colors">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
