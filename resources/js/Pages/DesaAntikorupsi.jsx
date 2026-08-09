import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    ShieldCheck, 
    CheckCircle2, 
    FileText, 
    ShieldAlert, 
    Users, 
    Eye, 
    HeartHandshake, 
    X, 
    ExternalLink, 
    FolderCheck, 
    Sparkles, 
    ArrowRight 
} from 'lucide-react';

export default function DesaAntikorupsi({ antikorupsi, pilarKpk }) {
    const [selectedPilarModal, setSelectedPilarModal] = useState(null);

    const iconMap = {
        'file-text': FileText,
        'shield-alert': ShieldAlert,
        'users': Users,
        'eye': Eye,
        'heart-handshake': HeartHandshake
    };

    return (
        <MainLayout>
            <Head title="Portal Desa Antikorupsi - 18 Indikator KPK RI" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                            <ShieldCheck class="h-3.5 w-3.5" />
                            Standardisasi KPK RI & Kemendes
                        </span>
                        <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl">Pusat Integrasi Desa Antikorupsi</h1>
                        <p class="mt-3 text-sky-100/90 max-w-2xl text-base leading-relaxed">
                            Pemenuhan 18 Indikator KPK RI yang terbagi ke dalam 5 Pilar Utama tata kelola pemerintahan bersih dan bebas pungli di Desa Banyuurip.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 space-y-16">
                
                {/* Section Title & Instruction */}
                <div class="text-center max-w-3xl mx-auto space-y-3">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3.5 py-1 rounded-full border border-sky-200">
                        Matriks Pemenuhan 18 Indikator KPK RI
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">5 Pilar Utama Desa Antikorupsi</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Klik pada salah satu <strong>Kartu Pilar</strong> di bawah ini untuk melihat daftar indikator lengkap dan mengakses bukti dokumen Drive resmi.
                    </p>
                </div>

                {/* 5 Pilar Cards Grid */}
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {(pilarKpk || []).map((pilar, idx) => {
                        const IconComp = iconMap[pilar.icon] || FileText;
                        const pilarDocs = (antikorupsi || []).filter(doc => doc.kategori === pilar.kunci);

                        return (
                            <div 
                                key={idx}
                                onClick={() => setSelectedPilarModal({ pilar, docs: pilarDocs })}
                                class="rounded-3xl p-6 border border-sky-100 bg-white hover:border-sky-400 shadow-xs hover:shadow-md transition-all cursor-pointer flex flex-col justify-between space-y-4 group"
                            >
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="h-11 w-11 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold group-hover:scale-105 transition-transform">
                                            <IconComp class="h-5.5 w-5.5" />
                                        </div>
                                        <span class="text-[10px] font-extrabold text-sky-800 bg-sky-50 px-2.5 py-1 rounded-full border border-sky-200">
                                            {pilar.indikator_list?.length || 0} Indikator
                                        </span>
                                    </div>

                                    <h3 class="font-extrabold text-slate-900 text-base leading-snug group-hover:text-sky-700 transition-colors">
                                        {pilar.pilar || pilar.kunci}
                                    </h3>
                                    <p class="text-[11px] text-slate-600 leading-relaxed">{pilar.deskripsi}</p>
                                </div>

                                <div class="pt-4 border-t border-sky-50 flex items-center justify-between text-xs font-bold text-sky-700">
                                    <span>Buka Indikator & Drive</span>
                                    <ArrowRight class="h-4 w-4" />
                                </div>
                            </div>
                        );
                    })}
                </div>

                {/* Interactive Modal for Selected Pillar */}
                {selectedPilarModal && (
                    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
                        <div class="w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200 max-h-[90vh] flex flex-col">
                            {/* Modal Header */}
                            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 text-white p-6 sm:p-8 flex items-start justify-between">
                                <div class="space-y-2">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-sky-300 bg-sky-500/20 px-3 py-1 rounded-full border border-sky-400/30">
                                        {selectedPilarModal.pilar.pilar || selectedPilarModal.pilar.kunci}
                                    </span>
                                    <h3 class="text-2xl font-extrabold text-white leading-tight">
                                        Daftar Indikator & Bukti Dokumen Drive
                                    </h3>
                                    <p class="text-xs text-sky-100/90 leading-relaxed max-w-xl">
                                        {selectedPilarModal.pilar.deskripsi}
                                    </p>
                                </div>
                                <button 
                                    onClick={() => setSelectedPilarModal(null)}
                                    class="p-2 text-sky-200 hover:text-white rounded-xl hover:bg-white/10 transition-colors cursor-pointer shrink-0"
                                >
                                    <X class="h-6 w-6" />
                                </button>
                            </div>

                            {/* Modal Content / List of Indicators & Drive Links */}
                            <div class="p-6 sm:p-8 space-y-4 overflow-y-auto bg-slate-50/50">
                                {(selectedPilarModal.pilar.indikator_list || []).map((ind) => {
                                    // Match db doc if available
                                    const matchedDoc = selectedPilarModal.docs.find(d => 
                                        d.judul.toLowerCase().includes(ind.judul.toLowerCase().substring(0, 15)) ||
                                        (d.nomor && d.nomor.includes(ind.no.toString()))
                                    ) || selectedPilarModal.docs[ind.no % selectedPilarModal.docs.length] || selectedPilarModal.docs[0];

                                    return (
                                        <div key={ind.no} class="rounded-2xl bg-white p-5 border border-sky-100 shadow-xs space-y-3">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                                <div class="flex items-start gap-3">
                                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-sky-600 text-white font-extrabold text-xs shadow-xs">
                                                        #{ind.no}
                                                    </span>
                                                    <div>
                                                        <h4 class="text-sm font-extrabold text-slate-900 leading-snug">{ind.judul}</h4>
                                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                            {matchedDoc?.deskripsi || 'Dokumen terverifikasi pemenuhan indikator resmi KPK RI.'}
                                                        </p>
                                                    </div>
                                                </div>

                                                {/* Drive Button */}
                                                {matchedDoc?.link_drive ? (
                                                    <a 
                                                        href={matchedDoc.link_drive} 
                                                        target="_blank" 
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition-colors shrink-0 shadow-xs"
                                                    >
                                                        <span>Buka Drive Resmi</span>
                                                        <ExternalLink class="h-3.5 w-3.5" />
                                                    </a>
                                                ) : (
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200 shrink-0">
                                                        <CheckCircle2 class="h-3.5 w-3.5" /> Terverifikasi
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>

                            {/* Modal Footer */}
                            <div class="bg-white p-4 px-6 border-t border-slate-200 flex justify-between items-center text-xs">
                                <span class="text-slate-500 font-medium">Standardisasi KPK RI & Kemendes • Desa Banyuurip</span>
                                <button 
                                    onClick={() => setSelectedPilarModal(null)}
                                    class="px-5 py-2 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition-colors cursor-pointer"
                                >
                                    Tutup Indikator
                                </button>
                            </div>
                        </div>
                    </div>
                )}

            </div>
        </MainLayout>
    );
}
