import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { PlusCircle, Edit3, Trash2, X, Inbox, Store, PhoneCall, MapPin, ExternalLink } from 'lucide-react';

export default function Umkm({ items }) {
    const [showAddModal, setShowAddModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingId, setEditingId] = useState(null);

    const addForm = useForm({
        nama: '',
        pemilik: '',
        kategori: 'makanan',
        kontak: '',
        alamat: '',
        link_maps: '',
        deskripsi: '',
        produk: '',
        gambar: null,
    });

    const editForm = useForm({
        nama: '',
        pemilik: '',
        kategori: 'makanan',
        kontak: '',
        alamat: '',
        link_maps: '',
        deskripsi: '',
        produk: '',
        gambar: null,
        oldGambar: '',
    });

    const handleAddSubmit = (e) => {
        e.preventDefault();
        addForm.post('/admin/umkm', {
            onSuccess: () => {
                setShowAddModal(false);
                addForm.reset();
            }
        });
    };

    const openEdit = (item) => {
        setEditingId(item.id);
        const produkStr = Array.isArray(item.produk) ? item.produk.join(', ') : (item.produk || '');
        editForm.setData({
            nama: item.nama || '',
            pemilik: item.pemilik || '',
            kategori: item.kategori || 'makanan',
            kontak: item.kontak || '',
            alamat: item.alamat || '',
            link_maps: item.link_maps || '',
            deskripsi: item.deskripsi || '',
            produk: produkStr,
            gambar: null,
            oldGambar: item.gambar || '',
        });
        setShowEditModal(true);
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        router.post(`/admin/umkm/${editingId}`, {
            _method: 'PUT',
            nama: editForm.data.nama,
            pemilik: editForm.data.pemilik,
            kategori: editForm.data.kategori,
            kontak: editForm.data.kontak,
            alamat: editForm.data.alamat,
            link_maps: editForm.data.link_maps,
            deskripsi: editForm.data.deskripsi,
            produk: editForm.data.produk,
            gambar: editForm.data.gambar,
        }, {
            onSuccess: () => {
                setShowEditModal(false);
                editForm.reset();
            }
        });
    };

    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus UMKM ini?')) {
            router.delete(`/admin/umkm/${id}`);
        }
    };

    return (
        <AdminLayout title="Kelola Direktori UMKM" subtitle="Kelola katalog usaha mikro, kuliner, dan produk unggulan Desa Banyuurip yang tampil di portal UMKM">
            <Head title="Admin - Direktori UMKM" />

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold shadow-xs">
                            <Store class="h-5 w-5" />
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Katalog Usaha UMKM Warga</h3>
                            <p class="text-xs text-slate-500">Total {items.length} Pelaku Usaha Terdaftar</p>
                        </div>
                    </div>

                    <button onClick={() => setShowAddModal(true)} class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold py-2.5 px-4 shadow-xs transition-all cursor-pointer">
                        <PlusCircle class="h-4 w-4" />
                        <span>Tambah UMKM Baru</span>
                    </button>
                </div>

                <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-500">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5">Nama Usaha UMKM</th>
                                    <th scope="col" class="px-6 py-3.5">Pemilik Usaha</th>
                                    <th scope="col" class="px-6 py-3.5">Kategori</th>
                                    <th scope="col" class="px-6 py-3.5">Kontak WhatsApp</th>
                                    <th scope="col" class="px-6 py-3.5">Alamat & Link Maps</th>
                                    <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                {items.length > 0 ? (
                                    items.map((item) => (
                                        <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-10 w-10 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                                        {item.gambar ? (
                                                            <img src={`/${item.gambar}`} class="h-full w-full object-cover" alt="" />
                                                        ) : (
                                                            <div class="h-full w-full bg-sky-50 flex items-center justify-center text-sky-700">
                                                                <Store class="h-5 w-5" />
                                                            </div>
                                                        )}
                                                    </div>
                                                    <div>
                                                        <span class="block font-extrabold">{item.nama}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 font-bold whitespace-nowrap">
                                                {item.pemilik}
                                            </td>
                                            <td class="px-6 py-4 text-slate-600 text-xs capitalize whitespace-nowrap">
                                                <span class="inline-flex items-center rounded-lg bg-sky-50 px-2.5 py-1 font-bold text-sky-800 border border-sky-200">
                                                    {item.kategori}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 text-xs font-bold whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1 text-sky-700">
                                                    <PhoneCall class="h-3.5 w-3.5" />
                                                    {item.kontak}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                                <span class="block font-medium text-slate-800">{item.alamat || 'Desa Banyuurip'}</span>
                                                {item.link_maps ? (
                                                    <a href={item.link_maps} target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-600 hover:text-sky-800 hover:underline mt-0.5">
                                                        <MapPin class="h-3 w-3" />
                                                        <span>Buka Google Maps</span>
                                                        <ExternalLink class="h-3 w-3" />
                                                    </a>
                                                ) : (
                                                    <span class="text-[11px] text-slate-400 italic">Belum ada link maps</span>
                                                )}
                                            </td>
                                            <td class="px-6 py-4 text-right font-medium">
                                                <div class="inline-flex gap-2">
                                                    <button onClick={() => openEdit(item)} class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-slate-800 transition-colors cursor-pointer" title="Edit UMKM">
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
                                            Belum ada data UMKM terdaftar
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
                                    <Store class="h-5 w-5 text-sky-600" />
                                    Tambah UMKM Baru
                                </h3>
                                <button onClick={() => setShowAddModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleAddSubmit} class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Usaha UMKM</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.nama}
                                            onChange={(e) => addForm.setData('nama', e.target.value)}
                                            required 
                                            placeholder="Contoh: Keripik Singkong Mbok Darmi" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Pemilik Usaha</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.pemilik}
                                            onChange={(e) => addForm.setData('pemilik', e.target.value)}
                                            required 
                                            placeholder="Contoh: Ibu Sudarmi" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Usaha</label>
                                        <select 
                                            value={addForm.data.kategori}
                                            onChange={(e) => addForm.setData('kategori', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600"
                                        >
                                            <option value="makanan">Makanan & Olahan Kuliner</option>
                                            <option value="minuman">Minuman Segar</option>
                                            <option value="kerajinan">Kerajinan Tangan</option>
                                            <option value="pertanian">Pertanian & Hasil Tani</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Kontak WhatsApp</label>
                                        <input 
                                            type="text" 
                                            value={addForm.data.kontak}
                                            onChange={(e) => addForm.setData('kontak', e.target.value)}
                                            required 
                                            placeholder="Contoh: 081234567890" 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Dusun / RT RW (Opsional)</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.alamat}
                                        onChange={(e) => addForm.setData('alamat', e.target.value)}
                                        placeholder="Contoh: Dukuh Banyuurip RT 02 / RW 01" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Link Google Maps (URL / Tautan Lokasi)</label>
                                    <input 
                                        type="text" 
                                        value={addForm.data.link_maps}
                                        onChange={(e) => addForm.setData('link_maps', e.target.value)}
                                        placeholder="Contoh: https://maps.app.goo.gl/xxx atau https://goo.gl/maps/..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Produk / Usaha</label>
                                    <input 
                                        type="file" 
                                        onChange={(e) => addForm.setData('gambar', e.target.files[0])}
                                        accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer" 
                                    />
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowAddModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button type="submit" disabled={addForm.processing} class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-sky-700 transition-colors">Simpan UMKM</button>
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
                                    Edit Data UMKM
                                </h3>
                                <button onClick={() => setShowEditModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleEditSubmit} class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Usaha UMKM</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.nama}
                                            onChange={(e) => editForm.setData('nama', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Pemilik Usaha</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.pemilik}
                                            onChange={(e) => editForm.setData('pemilik', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori Usaha</label>
                                        <select 
                                            value={editForm.data.kategori}
                                            onChange={(e) => editForm.setData('kategori', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600"
                                        >
                                            <option value="makanan">Makanan & Olahan Kuliner</option>
                                            <option value="minuman">Minuman Segar</option>
                                            <option value="kerajinan">Kerajinan Tangan</option>
                                            <option value="pertanian">Pertanian & Hasil Tani</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Kontak WhatsApp</label>
                                        <input 
                                            type="text" 
                                            value={editForm.data.kontak}
                                            onChange={(e) => editForm.setData('kontak', e.target.value)}
                                            required 
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Dusun / RT RW (Opsional)</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.alamat}
                                        onChange={(e) => editForm.setData('alamat', e.target.value)}
                                        placeholder="Contoh: Dukuh Banyuurip RT 02 / RW 01" 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Link Google Maps (URL / Tautan Lokasi)</label>
                                    <input 
                                        type="text" 
                                        value={editForm.data.link_maps}
                                        onChange={(e) => editForm.setData('link_maps', e.target.value)}
                                        placeholder="Contoh: https://maps.app.goo.gl/xxx atau https://goo.gl/maps/..." 
                                        class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600" 
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ganti Foto Produk (Opsional)</label>
                                    <input 
                                        type="file" 
                                        onChange={(e) => editForm.setData('gambar', e.target.files[0])}
                                        accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer" 
                                    />
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
