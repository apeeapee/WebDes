import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { 
    Users, 
    Activity, 
    AlertTriangle, 
    ShoppingBag, 
    FileText, 
    Newspaper, 
    ShieldCheck, 
    ClipboardList, 
    Inbox,
    Edit3,
    Home as HomeIcon,
    Sprout,
    X,
    CheckCircle2
} from 'lucide-react';

export default function Dashboard({ stats, recent_screenings }) {
    const [showEditStatsModal, setShowEditStatsModal] = useState(false);

    const statsForm = useForm({
        total_warga: stats.total_warga || 3420,
        kepala_keluarga: stats.kepala_keluarga || 985,
        luas_wilayah: stats.luas_wilayah || '245 Hektar',
        posyandu_aktif: stats.posyandu_aktif || 5,
    });

    const handleStatsSubmit = (e) => {
        e.preventDefault();
        statsForm.put('/admin/stats', {
            onSuccess: () => {
                setShowEditStatsModal(false);
            }
        });
    };

    return (
        <AdminLayout title="Ikhtisar Data Desa" subtitle="Statistik utama beranda, data UMKM terhubung, dan log skrining kesehatan">
            <Head title="Admin Dashboard" />

            <div class="space-y-8">
                {/* Editable Homepage Stats Card Bar */}
                <div class="rounded-2xl bg-white p-6 border border-sky-100 shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-sky-100 pb-4">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-sky-700 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200">
                                Beranda Publik
                            </span>
                            <h2 class="text-base font-extrabold text-slate-900 mt-1">Statistik Utama Beranda Desa</h2>
                            <p class="text-xs text-slate-500">Angka statistik yang tampil pada floating card di beranda utama website publik</p>
                        </div>

                        <button 
                            onClick={() => setShowEditStatsModal(true)}
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold shadow-xs transition-all shrink-0 cursor-pointer"
                        >
                            <Edit3 class="h-3.5 w-3.5" />
                            <span>Edit Statistik Utama</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 pt-2">
                        {/* 1. Total Warga */}
                        <div class="p-4 rounded-xl bg-sky-50/60 border border-sky-100 text-center">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-100 text-sky-700 mx-auto mb-2">
                                <Users class="h-4.5 w-4.5" />
                            </div>
                            <span class="text-2xl font-extrabold text-slate-900 block">{stats.total_warga.toLocaleString('id-ID')}</span>
                            <span class="text-[11px] font-bold text-sky-800 uppercase block mt-0.5">Total Warga</span>
                        </div>

                        {/* 2. Kepala Keluarga */}
                        <div class="p-4 rounded-xl bg-blue-50/60 border border-blue-100 text-center">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-700 mx-auto mb-2">
                                <HomeIcon class="h-4.5 w-4.5" />
                            </div>
                            <span class="text-2xl font-extrabold text-slate-900 block">{stats.kepala_keluarga.toLocaleString('id-ID')}</span>
                            <span class="text-[11px] font-bold text-blue-800 uppercase block mt-0.5">Kepala Keluarga</span>
                        </div>

                        {/* 3. Luas Wilayah Lahan */}
                        <div class="p-4 rounded-xl bg-cyan-50/60 border border-cyan-100 text-center">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-100 text-cyan-700 mx-auto mb-2">
                                <Sprout class="h-4.5 w-4.5" />
                            </div>
                            <span class="text-xl font-extrabold text-slate-900 block">{stats.luas_wilayah}</span>
                            <span class="text-[11px] font-bold text-cyan-800 uppercase block mt-0.5">Luas Wilayah Lahan</span>
                        </div>

                        {/* 4. UMKM Binaan (Otomatis dari Fitur UMKM) */}
                        <div class="p-4 rounded-xl bg-amber-50/60 border border-amber-100 text-center relative group">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-100 text-amber-700 mx-auto mb-2">
                                <ShoppingBag class="h-4.5 w-4.5" />
                            </div>
                            <span class="text-2xl font-extrabold text-slate-900 block">{stats.umkm_aktif}</span>
                            <span class="text-[11px] font-bold text-amber-800 uppercase block mt-0.5">UMKM (Otomatis)</span>
                            <span class="text-[9px] text-amber-700 font-semibold block mt-0.5">Terhubung Fitur UMKM</span>
                        </div>

                        {/* 5. Posyandu Aktif */}
                        <div class="p-4 rounded-xl bg-rose-50/60 border border-rose-100 text-center">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-100 text-rose-700 mx-auto mb-2">
                                <Activity class="h-4.5 w-4.5" />
                            </div>
                            <span class="text-2xl font-extrabold text-slate-900 block">{stats.posyandu_aktif}</span>
                            <span class="text-[11px] font-bold text-rose-800 uppercase block mt-0.5">Posyandu Aktif</span>
                        </div>
                    </div>
                </div>

                {/* Additional Stats Overview Grid */}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Skrining ISPA</span>
                            <strong class="text-2xl font-extrabold text-indigo-600 mt-1 block">{stats.total_screening_ispa}</strong>
                        </div>
                        <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <Activity class="h-5 w-5" />
                        </div>
                    </div>

                    <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Risiko Tinggi</span>
                            <strong class="text-2xl font-extrabold text-rose-600 mt-1 block">{stats.skrining_risiko_tinggi}</strong>
                        </div>
                        <div class="h-10 w-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                            <AlertTriangle class="h-5 w-5" />
                        </div>
                    </div>

                    <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Warta Berita</span>
                            <strong class="text-lg font-extrabold text-slate-800 mt-1 block">{stats.total_berita} Artikel</strong>
                        </div>
                        <div class="h-9 w-9 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center">
                            <Newspaper class="h-4.5 w-4.5" />
                        </div>
                    </div>

                    <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Desa Antikorupsi</span>
                            <strong class="text-lg font-extrabold text-emerald-700 mt-1 block">{stats.total_antikorupsi || 0} Drive</strong>
                        </div>
                        <Link href="/admin/antikorupsi" class="h-9 w-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-100 transition-colors" title="Kelola Desa Antikorupsi">
                            <ShieldCheck class="h-4.5 w-4.5" />
                        </Link>
                    </div>
                </div>

                {/* Log Skrining Terkini */}
                <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200/60 flex items-center justify-between">
                        <span class="font-bold text-slate-850 text-sm flex items-center gap-1.5">
                            <ClipboardList class="h-4.5 w-4.5 text-indigo-600" />
                            Log Hasil Skrining Mandiri ISPA (Terbaru)
                        </span>
                        <span class="inline-flex items-center rounded bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700">Tindakan Rujukan</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-500">
                            <thead class="bg-slate-50/50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5">Nama Warga</th>
                                    <th scope="col" class="px-6 py-3.5">Usia</th>
                                    <th scope="col" class="px-6 py-3.5">Risiko</th>
                                    <th scope="col" class="px-6 py-3.5">Tindakan Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                {recent_screenings.length > 0 ? (
                                    recent_screenings.map((sc, idx) => (
                                        <tr key={sc.id || idx} class="hover:bg-slate-50/50 transition-colors">
                                            <th scope="row" class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                {sc.nama_warga}
                                            </th>
                                            <td class="px-6 py-4 text-slate-600">
                                                {sc.usia} Tahun
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border ${
                                                    sc.risiko === 'Tinggi' ? 'bg-rose-50 text-rose-700 border-rose-200' : (sc.risiko === 'Sedang' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200')
                                                }`}>
                                                    {sc.risiko}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-xs text-slate-700 font-semibold flex items-center gap-1.5">
                                                    <span class={`h-2 w-2 rounded-full ${
                                                        sc.risiko === 'Tinggi' ? 'bg-rose-500' : (sc.risiko === 'Sedang' ? 'bg-amber-500' : 'bg-emerald-500')
                                                    }`}></span>
                                                    {sc.status}
                                                </span>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="4" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            <Inbox class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                            Belum ada log skrining masuk
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* Modal Edit Stats */}
                {showEditStatsModal && (
                    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div class="relative w-full max-w-xl rounded-2xl bg-white p-8 text-left shadow-xl border border-slate-100">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                    <Edit3 class="h-5 w-5 text-sky-600" />
                                    Edit Statistik Utama Beranda
                                </h3>
                                <button onClick={() => setShowEditStatsModal(false)} class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600">
                                    <X class="h-5 w-5" />
                                </button>
                            </div>

                            <form onSubmit={handleStatsSubmit} class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Warga (Jiwa)</label>
                                        <input 
                                            type="number" 
                                            value={statsForm.data.total_warga}
                                            onChange={(e) => statsForm.setData('total_warga', e.target.value)}
                                            required 
                                            placeholder="Contoh: 3420"
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600"
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kepala Keluarga (KK)</label>
                                        <input 
                                            type="number" 
                                            value={statsForm.data.kepala_keluarga}
                                            onChange={(e) => statsForm.setData('kepala_keluarga', e.target.value)}
                                            required 
                                            placeholder="Contoh: 985"
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600"
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Luas Wilayah Lahan</label>
                                        <input 
                                            type="text" 
                                            value={statsForm.data.luas_wilayah}
                                            onChange={(e) => statsForm.setData('luas_wilayah', e.target.value)}
                                            required 
                                            placeholder="Contoh: 245 Hektar"
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600"
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Posyandu Aktif</label>
                                        <input 
                                            type="number" 
                                            value={statsForm.data.posyandu_aktif}
                                            onChange={(e) => statsForm.setData('posyandu_aktif', e.target.value)}
                                            required 
                                            placeholder="Contoh: 5"
                                            class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-sky-600 focus:outline-none focus:ring-1 focus:ring-sky-600"
                                        />
                                    </div>
                                </div>

                                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-start gap-2.5">
                                    <ShoppingBag class="h-4 w-4 text-amber-600 shrink-0 mt-0.5" />
                                    <div>
                                        <strong class="font-bold block">Jumlah UMKM Binaan: {stats.umkm_aktif} Usaha</strong>
                                        <span class="text-amber-800">Jumlah UMKM tidak perlu diisi manual, karena sudah otomatis terhitung secara real-time dari total data UMKM pada menu Direktori UMKM.</span>
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100">
                                    <button type="button" onClick={() => setShowEditStatsModal(false)} class="rounded-xl border border-slate-250 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Batal</button>
                                    <button 
                                        type="submit" 
                                        disabled={statsForm.processing} 
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-sky-700 transition-colors disabled:opacity-50"
                                    >
                                        {statsForm.processing ? 'Menyimpan...' : 'Simpan Perubahan'}
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
