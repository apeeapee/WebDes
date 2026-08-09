import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { ShieldCheck, PlusCircle, Edit3, Trash2, X, Inbox, ExternalLink, Link2Off, Link as LinkIcon } from 'lucide-react';

export default function Antikorupsi({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        nomor: '',
        judul: '',
        kategori: 'Penguatan Tata Laksana',
        deskripsi: '',
        link_drive: '',
        status: 'Terverifikasi',
    });

    const editForm = useForm({
        nomor: '',
        judul: '',
        kategori: 'Penguatan Tata Laksana',
        deskripsi: '',
        link_drive: '',
        status: 'Terverifikasi',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/antikorupsi', {
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
            kategori: item.kategori || 'Penguatan Tata Laksana',
            deskripsi: item.deskripsi || '',
            link_drive: item.link_drive || '',
            status: item.status || 'Terverifikasi',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        editForm.put(`/admin/antikorupsi/${editingId}`, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen indikator ini?')) {
            router.delete(`/admin/antikorupsi/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Desa Antikorupsi & Regulasi Drive" subtitle="Pusat pengelolaan dokumen indikator Desa Antikorupsi KPK dengan tautan berkas langsung ke Google Drive">
            <Head title="Admin - Desa Antikorupsi" />

            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shadow-xs">
                            <ShieldCheck class="h-5 w-5" />
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Program Desa Antikorupsi (KPK)</h3>
                            <p class="text-xs text-slate-500">Total {items.length} Dokumen Regulasi Terdaftar</p>
                        </div>
                    </div>
                    
                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold py-2.5 px-4 shadow-sm transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah Dokumen / Indikator Drive</span>
                    </button>
                </div>

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
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-mono text-slate-700 border border-slate-200">
                                                    {item.nomor}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <strong class="text-slate-900 font-bold block text-sm">{item.judul}</strong>
                                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 max-w-md">{item.deskripsi}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class={`inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold ${
                                                    item.kategori === 'Penguatan Tata Laksana' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/10' : 
                                                    item.kategori === 'Penguatan Pengawasan' ? 'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/10' : 
                                                    item.kategori === 'Penguatan Pelayanan Publik' ? 'bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-600/10' : 
                                                    item.kategori === 'Penguatan Partisipasi Publik' ? 'bg-purple-50 text-purple-700 ring-1 ring-inset ring-purple-600/10' : 
                                                    'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/10'
                                                }`}>
                                                    {item.kategori}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {item.link_drive ? (
                                                    <a href={item.link_drive} target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 hover:bg-emerald-100 transition-colors border border-emerald-200">
                                                        <span>Google Drive</span>
                                                        <ExternalLink class="h-3 w-3" />
                                                    </a>
                                                ) : (
                                                    <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-2.5 py-1 text-xs text-slate-400">
                                                        <Link2Off class="h-3.5 w-3.5" />
                                                        <span>Belum ada link</span>
                                                    </span>
                                                )}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class={`inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-bold ${
                                                    item.status === 'Terverifikasi' ? 'bg-emerald-100 text-emerald-800' : 
                                                    item.status === 'Dalam Review' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700'
                                                }`}>
                                                    <span class={`h-1.5 w-1.5 rounded-full ${item.status === 'Terverifikasi' ? 'bg-emerald-600' : 'bg-amber-600'}`}></span>
                                                    {item.status}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                                <div class="inline-flex gap-2">
                                                    <button onClick={() => openEdit(item)} class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit Dokumen">
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
                                            Belum ada dokumen indikator Desa Antikorupsi terdaftar
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
                                    <ShieldCheck class="h-5 w-5 text-emerald-600" />
                                    Tambah Dokumen Desa Antikorupsi
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode / Nomor Regulasi</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.nomor}
                                            onChange={(e) => addForm.setData('nomor', e.target.value)}
                                            required 
                                            placeholder="Contoh: PAK-TL-01/2026" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilar Indikator KPK</label>
                                        <select 
                                            value={addForm.data.kategori}
                                            onChange={(e) => addForm.setData('kategori', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                        >
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
                                    <input 
                                        type="text" 
                                        value={addForm.data.judul}
                                        onChange={(e) => addForm.setData('judul', e.target.value)}
                                        required 
                                        placeholder="Contoh: SOP Pengadaan Barang & Jasa Bebas Pungli" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penjelasan Uraian Dokumen</label>
                                    <textarea 
                                        value={addForm.data.deskripsi}
                                        onChange={(e) => addForm.setData('deskripsi', e.target.value)}
                                        required 
                                        rows={3} 
                                        placeholder="Jelaskan secara ringkas maksud dan cakupan dokumen bukti dukung ini..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center justify-between">
                                        <span>Tautan Link Google Drive Dokumen</span>
                                        <span class="text-[10px] text-emerald-600 font-normal">Direct Link Google Drive</span>
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <LinkIcon class="h-4 w-4 text-emerald-600" />
                                        </div>
                                        <input 
                                            type="url" 
                                            value={addForm.data.link_drive}
                                            onChange={(e) => addForm.setData('link_drive', e.target.value)}
                                            placeholder="https://drive.google.com/drive/folders/..." 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" 
                                        />
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-1">Masukkan URL bagikan folder atau file PDF dokumen bukti dukung dari Google Drive.</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Verifikasi</label>
                                    <select 
                                        value={addForm.data.status}
                                        onChange={(e) => addForm.setData('status', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                    >
                                        <option value="Terverifikasi">Terverifikasi / Lengkap</option>
                                        <option value="Dalam Review">Dalam Review</option>
                                        <option value="Draft">Draft Internal</option>
                                    </select>
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-800 transition-colors">Simpan Dokumen Drive</button>
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
                                    <Edit3 class="h-5 w-5 text-emerald-600" />
                                    Edit Dokumen Desa Antikorupsi
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kode / Nomor Regulasi</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.nomor}
                                            onChange={(e) => editForm.setData('nomor', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilar Indikator KPK</label>
                                        <select 
                                            value={editForm.data.kategori}
                                            onChange={(e) => editForm.setData('kategori', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                        >
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
                                    <input 
                                        type="text" 
                                        value={editForm.data.judul}
                                        onChange={(e) => editForm.setData('judul', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penjelasan Uraian Dokumen</label>
                                    <textarea 
                                        value={editForm.data.deskripsi}
                                        onChange={(e) => editForm.setData('deskripsi', e.target.value)}
                                        required 
                                        rows={3} 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center justify-between">
                                        <span>Tautan Link Google Drive Dokumen</span>
                                        {editForm.data.link_drive && (
                                            <a href={editForm.data.link_drive} target="_blank" rel="noopener noreferrer" class="text-[10px] text-emerald-600 font-bold hover:underline flex items-center gap-1">
                                                <span>Tes Buka Drive</span>
                                                <ExternalLink class="h-3 w-3" />
                                            </a>
                                        )}
                                    </label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <LinkIcon class="h-4 w-4 text-emerald-600" />
                                        </div>
                                        <input 
                                            type="url" 
                                            value={editForm.data.link_drive}
                                            onChange={(e) => editForm.setData('link_drive', e.target.value)}
                                            placeholder="https://drive.google.com/drive/folders/..." 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600" 
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Verifikasi</label>
                                    <select 
                                        value={editForm.data.status}
                                        onChange={(e) => editForm.setData('status', e.target.value)}
                                        required 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                    >
                                        <option value="Terverifikasi">Terverifikasi / Lengkap</option>
                                        <option value="Dalam Review">Dalam Review</option>
                                        <option value="Draft">Draft Internal</option>
                                    </select>
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowEditModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={editForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-800 transition-colors">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
