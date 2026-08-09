import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { PlusCircle, Edit3, Trash2, X, Inbox, User, Users, AlertCircle, ArrowUp, ArrowDown } from 'lucide-react';

export default function Perangkat({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        nama: '',
        jabatan: '',
        kontak: '',
        urutan: (items.length + 1) || 1,
        foto: null,
    });

    const editForm = useForm({
        nama: '',
        jabatan: '',
        kontak: '',
        urutan: 1,
        foto: null,
        oldFoto: '',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/perangkat', {
            forceFormData: true,
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        editForm.clearErrors();
        editForm.setData({
            nama: item.nama || '',
            jabatan: item.jabatan || '',
            kontak: item.kontak || '',
            urutan: item.urutan || 1,
            foto: null,
            oldFoto: item.foto || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        router.post(`/admin/perangkat/${editingId}`, {
            _method: 'PUT',
            nama: editForm.data.nama,
            jabatan: editForm.data.jabatan,
            kontak: editForm.data.kontak,
            urutan: editForm.data.urutan,
            foto: editForm.data.foto,
        }, {
            forceFormData: true,
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleReorder = (id, direction) => {
        router.post(`/admin/perangkat/${id}/reorder`, { direction });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus perangkat desa ini?')) {
            router.delete(`/admin/perangkat/${id}`);
        }
    };

    const handleFileCheck = (e, setFormFile) => {
        const file = e.target.files[0];
        if (file && file.size > 2.5 * 1024 * 1024) {
            alert(`Ukuran foto terlalu besar (${(file.size / (1024 * 1024)).toFixed(1)} MB). Batas maksimum file foto adalah 2.5 MB. Silakan kompres foto Anda terlebih dahulu atau gunakan gambar bernilai lebih kecil.`);
            e.target.value = null;
            setFormFile(null);
        } else {
            setFormFile(file);
        }
    };

    return (
        <AdminLayout title="Kelola Perangkat Desa" subtitle="Kelola aparatur pemerintahan desa, foto resmi, serta urutan posisi tampil di profil desa">
            <Head title="Admin - Perangkat Desa" />

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold shadow-xs">
                            <Users class="h-5 w-5" />
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Struktur Perangkat Desa</h3>
                            <p class="text-xs text-slate-500">Total {items.length} Aparatur Desa Terdaftar • Posisi Teratas Tampil Paling Awal</p>
                        </div>
                    </div>

                    <button 
                        onClick={() => {
                            addForm.clearErrors();
                            addForm.setData('urutan', (items.length + 1) || 1);
                            setShowAddModal(true);
                        }} 
                        class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold py-2.5 px-4 shadow-xs transition-all cursor-pointer"
                    >
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Perangkat Desa</span>
                    </button>
                </div>

                <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-500">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                                <tr>
                                    <th scope="col" class="px-4 py-3.5 text-center">Urutan</th>
                                    <th scope="col" class="px-6 py-3.5">Foto & Nama Perangkat</th>
                                    <th scope="col" class="px-6 py-3.5">Jabatan Resmi</th>
                                    <th scope="col" class="px-6 py-3.5">Kontak WA</th>
                                    <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                {items.length > 0 ? (
                                    items.map((item, idx) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            {/* Column Urutan + Quick Arrow Reorder */}
                                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                                <div class="inline-flex items-center gap-1 bg-slate-100 px-2 py-1 rounded-lg border border-slate-200">
                                                    <span class="text-xs font-extrabold text-slate-900 w-5 text-center">{item.urutan || idx + 1}</span>
                                                    <div class="flex flex-col gap-0.5">
                                                        <button 
                                                            disabled={idx === 0}
                                                            onClick={() => handleReorder(item.id, 'up')}
                                                            class="p-0.5 rounded hover:bg-slate-200 text-slate-600 disabled:opacity-30 disabled:hover:bg-transparent cursor-pointer"
                                                            title="Naikkan Urutan Tampil"
                                                        >
                                                            <ArrowUp class="h-3 w-3" />
                                                        </button>
                                                        <button 
                                                            disabled={idx === items.length - 1}
                                                            onClick={() => handleReorder(item.id, 'down')}
                                                            class="p-0.5 rounded hover:bg-slate-200 text-slate-600 disabled:opacity-30 disabled:hover:bg-transparent cursor-pointer"
                                                            title="Turunkan Urutan Tampil"
                                                        >
                                                            <ArrowDown class="h-3 w-3" />
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-10 w-10 rounded-full overflow-hidden bg-slate-100 shrink-0 border border-slate-200 shadow-xs">
                                                        {item.foto ? (
                                                            <img src={`/${item.foto}`} class="h-full w-full object-cover" alt={item.nama} />
                                                        ) : (
                                                            <div class="h-full w-full bg-sky-50 flex items-center justify-center text-sky-700 font-bold">
                                                                <User class="h-5 w-5" />
                                                            </div>
                                                        )}
                                                    </div>
                                                    <span>{item.nama}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 font-bold text-xs whitespace-nowrap">
                                                <span class="inline-flex items-center rounded-lg bg-sky-50 px-2.5 py-1 text-sky-800 border border-sky-200">
                                                    {item.jabatan}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 text-xs font-semibold whitespace-nowrap">
                                                {item.kontak}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="inline-flex gap-2">
                                                    <button onClick={() => openEdit(item)} class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit Perangkat">
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
                                            Belum ada aparatur desa terdaftar
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
                                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                    <PlusCircle class="h-5 w-5 text-sky-600" />
                                    Tambah Perangkat Desa Baru
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap & Gelar</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.nama}
                                            onChange={(e) => addForm.setData('nama', e.target.value)}
                                            required 
                                            placeholder="Contoh: Sudarsono, S.IP" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                        {addForm.errors.nama && (
                                            <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                                <AlertCircle class="h-3.5 w-3.5" /> {addForm.errors.nama}
                                            </p>
                                        )}
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Urutan Posisi</label>
                                        <input 
                                            type="number" 
                                            min="1"
                                            value={addForm.data.urutan}
                                            onChange={(e) => addForm.setData('urutan', e.target.value)}
                                            required 
                                            placeholder="Urutan 1, 2..." 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600 text-center font-bold" 
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jabatan Resmi</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.jabatan}
                                            onChange={(e) => addForm.setData('jabatan', e.target.value)}
                                            required 
                                            placeholder="Contoh: Kepala Desa, Sekdes..." 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                        {addForm.errors.jabatan && (
                                            <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                                <AlertCircle class="h-3.5 w-3.5" /> {addForm.errors.jabatan}
                                            </p>
                                        )}
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Kontak WA</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.kontak}
                                            onChange={(e) => addForm.setData('kontak', e.target.value)}
                                            required 
                                            placeholder="Contoh: 0812-3456-7890" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                        {addForm.errors.kontak && (
                                            <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                                <AlertCircle class="h-3.5 w-3.5" /> {addForm.errors.kontak}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Foto Resmi Perangkat Desa (Maks 2.5 MB)</label>
                                    <p class="text-[11px] text-slate-400 mb-2">Gunakan foto berukuran di bawah 2.5MB agar dapat terunggah dengan sempurna.</p>
                                    <input 
                                        type="file" 
                                        onChange={(e) => handleFileCheck(e, (file) => addForm.setData('foto', file))}
                                        accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer" 
                                    />
                                    {addForm.errors.foto && (
                                        <p class="text-xs text-rose-600 font-semibold mt-1.5 flex items-center gap-1">
                                            <AlertCircle class="h-3.5 w-3.5 shrink-0" /> {addForm.errors.foto}
                                        </p>
                                    )}
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button 
                                        type="submit" 
                                        disabled={addForm.processing} 
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-sky-700 transition-colors disabled:opacity-50"
                                    >
                                        {addForm.processing ? 'Menyimpan...' : 'Simpan Perangkat'}
                                    </button>
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
                                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                    <Edit3 class="h-5 w-5 text-sky-600" />
                                    Edit Perangkat Desa
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap & Gelar</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.nama}
                                            onChange={(e) => editForm.setData('nama', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                        {editForm.errors.nama && (
                                            <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                                <AlertCircle class="h-3.5 w-3.5" /> {editForm.errors.nama}
                                            </p>
                                        )}
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Urutan Posisi</label>
                                        <input 
                                            type="number" 
                                            min="1"
                                            value={editForm.data.urutan}
                                            onChange={(e) => editForm.setData('urutan', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600 text-center font-bold" 
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jabatan Resmi</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.jabatan}
                                            onChange={(e) => editForm.setData('jabatan', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                        {editForm.errors.jabatan && (
                                            <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                                <AlertCircle class="h-3.5 w-3.5" /> {editForm.errors.jabatan}
                                            </p>
                                        )}
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Kontak WA</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.kontak}
                                            onChange={(e) => editForm.setData('kontak', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                        {editForm.errors.kontak && (
                                            <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                                <AlertCircle class="h-3.5 w-3.5" /> {editForm.errors.kontak}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Ganti Foto Resmi (Opsional, Maks 2.5 MB)</label>
                                    <p class="text-[11px] text-slate-400 mb-2">Gunakan foto berukuran di bawah 2.5MB agar dapat terunggah dengan sempurna.</p>
                                    <input 
                                        type="file" 
                                        onChange={(e) => handleFileCheck(e, (file) => editForm.setData('foto', file))}
                                        accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer" 
                                    />
                                    {editForm.errors.foto && (
                                        <p class="text-xs text-rose-600 font-semibold mt-1.5 flex items-center gap-1">
                                            <AlertCircle class="h-3.5 w-3.5 shrink-0" /> {editForm.errors.foto}
                                        </p>
                                    )}
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowEditModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button 
                                        type="submit" 
                                        disabled={editForm.processing} 
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-sky-700 transition-colors disabled:opacity-50"
                                    >
                                        {editForm.processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
