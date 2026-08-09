import React from 'react';
import { Head, router } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { Trash2, Inbox } from 'lucide-react';

export default function Skrining({ items }) {
    const handleDelete = (id) => {
        if (confirm('Apakah Anda yakin ingin menghapus data skrining ini?')) {
            router.delete(`/admin/skrining/${id}`);
        }
    };

    return (
        <AdminLayout title="Log Skrining Kesehatan Mandiri" subtitle="Pantau log hasil skrining mandiri ISPA (RESPIRA) yang disubmit oleh warga desa">
            <Head title="Admin - Log Skrining" />

            <div class="space-y-6">
                <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-500">
                            <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5">Nama Warga</th>
                                    <th scope="col" class="px-6 py-3.5">Usia</th>
                                    <th scope="col" class="px-6 py-3.5">Risiko</th>
                                    <th scope="col" class="px-6 py-3.5">Gejala Terdeteksi</th>
                                    <th scope="col" class="px-6 py-3.5">Tindakan/Status</th>
                                    <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                {items.length > 0 ? (
                                    items.map((item) => {
                                        const gejalaList = Array.isArray(item.gejala) 
                                            ? item.gejala 
                                            : (typeof item.gejala === 'object' && item.gejala !== null
                                                ? Object.keys(item.gejala).filter(k => item.gejala[k]) 
                                                : []);

                                        return (
                                            <tr key={item.id} class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                                    {item.nama_warga}
                                                </td>
                                                <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                                    {item.usia} Tahun
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border ${
                                                        item.risiko === 'Tinggi' ? 'bg-rose-50 text-rose-700 border-rose-200' :
                                                        item.risiko === 'Sedang' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                                    }`}>
                                                        {item.risiko}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-xs text-slate-600 max-w-xs">
                                                    <div class="flex flex-wrap gap-1">
                                                        {gejalaList.length > 0 ? (
                                                            gejalaList.map((g, gIdx) => (
                                                                <span key={gIdx} class="bg-slate-100 text-slate-700 rounded px-1.5 py-0.5 text-[10px]">{g}</span>
                                                            ))
                                                        ) : (
                                                            <span class="text-slate-400">Tidak ada gejala</span>
                                                        )}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-xs text-slate-700 font-semibold flex items-center gap-1.5">
                                                        <span class={`h-2 w-2 rounded-full ${
                                                            item.risiko === 'Tinggi' ? 'bg-rose-500' : (item.risiko === 'Sedang' ? 'bg-amber-500' : 'bg-emerald-500')
                                                        }`}></span>
                                                        {item.status}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                                    <button onClick={() => handleDelete(item.id)} class="p-1.5 hover:bg-rose-50 rounded-lg text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus">
                                                        <Trash2 class="h-4 w-4" />
                                                    </button>
                                                </td>
                                            </tr>
                                        );
                                    })
                                ) : (
                                    <tr>
                                        <td colSpan="6" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            <Inbox class="h-8 w-8 mx-auto mb-2 opacity-50" />
                                            Belum ada log skrining masuk
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
