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
    ArrowRight,
    Link2Off,
    Inbox 
} from 'lucide-react';

const romanToNum = {
    xviii: 18, xvii: 17, xvi: 16, xv: 15, xiv: 14, xiii: 13, xii: 12, xi: 11,
    x: 10, ix: 9, viii: 8, vii: 7, vi: 6, v: 5, iv: 4, iii: 3, ii: 2, i: 1
};

function extractIndicatorNo(str) {
    if (!str) return null;
    const s = String(str).trim().toLowerCase();
    
    // Pattern 1: explicit indicator number e.g. "indikator 11", "ind 12", "indikator #15"
    const indMatch = s.match(/(?:indikator|ind|indicator)\s*#?\s*(\d+)/i);
    if (indMatch) return parseInt(indMatch[1], 10);
    
    // Pattern 2: "#11", "# 12"
    const hashMatch = s.match(/#\s*(\d+)/);
    if (hashMatch) return parseInt(hashMatch[1], 10);
    
    // Pattern 3: Roman numerals e.g. "indikator xi", "xi", "indikator xv"
    const romanMatch = s.match(/\b(xviii|xvii|xvi|xv|xiv|xiii|xii|xi|x|ix|viii|vii|vi|v|iv|iii|ii|i)\b/i);
    if (romanMatch && romanToNum[romanMatch[1].toLowerCase()]) {
        return romanToNum[romanMatch[1].toLowerCase()];
    }
    
    // Pattern 4: Pure number e.g. "11"
    if (/^\d+$/.test(s)) return parseInt(s, 10);
    
    // Pattern 5: Look for numbers 1..18 in the string
    const numbers = s.match(/\b\d+\b/g);
    if (numbers) {
        for (const numStr of numbers) {
            const n = parseInt(numStr, 10);
            if (n >= 1 && n <= 18) return n;
        }
    }
    
    return null;
}

const indicatorKeywords = {
    1: ['perencanaan', 'penatausahaan', 'apbdes', 'pertanggungjawaban'],
    2: ['mekanisme pengawasan', 'evaluasi kinerja', 'kinerja perangkat'],
    3: ['pengendalian gratifikasi', 'konflik kepentingan', 'pungli'],
    4: ['pbj', 'pengadaan barang', 'perjanjian kerjasama'],
    5: ['pakta integritas', 'integritas'],
    6: ['kegiatan pengawasan', 'bpd'],
    7: ['tindak lanjut', 'hasil pembinaan', 'pemeriksaan'],
    8: ['bebas tindak pidana', 'bebas pidana', 'pidana korupsi', 'skck', 'polsek'],
    9: ['layanan pengaduan', 'pengaduan masyarakat', 'posko pengaduan'],
    10: ['survei kepuasan', 'kepuasan masyarakat', 'skm'],
    11: ['spm', 'standar pelayanan minimal', 'pelayanan minimal', 'akses masyarakat'],
    12: ['media informasi', 'baliho', 'papan informasi', 'infografis apbdes', 'tempat umum'],
    13: ['maklumat pelayanan', 'maklumat'],
    14: ['rkp', 'rkpdes', 'musdes', 'musyawarah desa', 'penyusunan rkp'],
    15: ['kesadaran masyarakat', 'pencegahan gratifikasi', 'suap', 'praktik gratifikasi'],
    16: ['lkd', 'karang taruna', 'swakelola', 'lembaga kemasyarakatan'],
    17: ['budaya lokal', 'kearifan lokal', 'hukum adat', 'rembug'],
    18: ['tokoh masyarakat', 'tokoh agama', 'pemuda', 'perempuan', 'tokoh adat']
};

const pilarIndicatorsMap = {
    1: [1, 2, 3, 4, 5],
    2: [6, 7, 8],
    3: [9, 10, 13],
    4: [11, 12, 14, 16],
    5: [15, 17, 18]
};

function getPilarIndexFromDoc(doc) {
    if (!doc) return 0;
    const no = extractIndicatorNo(doc.nomor) || extractIndicatorNo(doc.judul);
    if (no !== null) {
        for (const [pilarIdx, list] of Object.entries(pilarIndicatorsMap)) {
            if (list.includes(no)) return parseInt(pilarIdx, 10);
        }
    }
    const kat = (doc.kategori || '').toLowerCase();
    if (kat.includes('tata laksana') || kat.includes('pilar 1') || kat.includes('pilar i')) return 1;
    if (kat.includes('pengawasan') || kat.includes('pilar 2') || kat.includes('pilar ii')) return 2;
    if (kat.includes('pelayanan') || kat.includes('pilar 3') || kat.includes('pilar iii')) return 3;
    if (kat.includes('partisipasi') || kat.includes('pilar 4') || kat.includes('pilar iv')) return 4;
    if (kat.includes('budaya') || kat.includes('kearifan') || kat.includes('pilar 5') || kat.includes('pilar v')) return 5;
    return 0;
}

function isDocInPilar(doc, pilar, pilarIndex) {
    if (!doc) return false;
    const docPilarIdx = getPilarIndexFromDoc(doc);
    if (docPilarIdx !== 0 && docPilarIdx === pilarIndex) return true;
    const kat = (doc.kategori || '').trim().toLowerCase();
    const kunci = (pilar.kunci || '').trim().toLowerCase();
    const pilarName = (pilar.pilar || '').trim().toLowerCase();
    if (kat && (kat === kunci || kat.includes(kunci) || kunci.includes(kat) || kat.includes(pilarName))) return true;
    return false;
}

function scoreDocMatch(d, ind, pilar) {
    let score = 0;
    const docNo = extractIndicatorNo(d.nomor);
    if (docNo !== null) {
        if (docNo === ind.no) score += 120;
        else score -= 150;
    }
    const titleDocNo = extractIndicatorNo(d.judul);
    if (titleDocNo !== null) {
        if (titleDocNo === ind.no) score += 90;
        else score -= 80;
    }
    const normDoc = (d.judul || '').trim().toLowerCase();
    const normInd = (ind.judul || '').trim().toLowerCase();
    if (normDoc && normInd) {
        if (normDoc === normInd) score += 100;
        else if (normDoc.includes(normInd) || normInd.includes(normDoc)) score += 60;
    }
    const kw = indicatorKeywords[ind.no] || [];
    if (kw.some(k => normDoc.includes(k))) score += 40;
    const normKat = (d.kategori || '').trim().toLowerCase();
    const normKunci = (pilar.kunci || '').trim().toLowerCase();
    if (normKat && normKunci && (normKat.includes(normKunci) || normKunci.includes(normKat))) {
        score += 20;
    }
    const hasLink = Boolean(d.link_drive && d.link_drive.trim().length > 3);
    if (hasLink) score += 30;
    return score;
}

function sanitizeDriveUrl(url) {
    if (!url) return null;
    let trimmed = String(url).trim();
    if (!trimmed) return null;
    if (!/^https?:\/\//i.test(trimmed)) {
        trimmed = 'https://' + trimmed;
    }
    return trimmed;
}

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
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight lg:text-5xl">Pusat Integrasi Desa Antikorupsi</h1>
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
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 lg:text-4xl">5 Pilar Utama Desa Antikorupsi</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Klik pada salah satu <strong>Kartu Pilar</strong> di bawah ini untuk melihat daftar indikator lengkap dan mengakses bukti dokumen Drive resmi.
                    </p>
                </div>

                {/* 5 Pilar Cards Grid */}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    {(pilarKpk || []).map((pilar, idx) => {
                        const IconComp = iconMap[pilar.icon] || FileText;
                        const pilarIndex = idx + 1;
                        const pilarDocs = (antikorupsi || []).filter(doc => isDocInPilar(doc, pilar, pilarIndex));
                        const totalCount = Math.max(pilarDocs.length, pilar.indikator_list?.length || 0);

                        return (
                            <div 
                                key={idx}
                                onClick={() => setSelectedPilarModal({ pilar, pilarIndex })}
                                class="rounded-3xl p-6 border border-sky-100 bg-white hover:border-sky-400 shadow-xs hover:shadow-md transition-all cursor-pointer flex flex-col justify-between space-y-4 group"
                            >
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="h-11 w-11 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold group-hover:scale-105 transition-transform shrink-0">
                                            <IconComp class="h-5.5 w-5.5" />
                                        </div>
                                        <span class="text-[11px] font-extrabold text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200 whitespace-nowrap shrink-0">
                                            {totalCount} Indikator
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
                    <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-slate-950/60 backdrop-blur-xs">
                        <div class="w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200 max-h-[90vh] flex flex-col">
                            {/* Modal Header */}
                            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 text-white p-4 sm:p-6 md:p-8 flex items-start justify-between">
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
                            <div class="p-4 sm:p-6 md:p-8 space-y-4 overflow-y-auto bg-slate-50/50">
                                {(() => {
                                    const { pilar, pilarIndex } = selectedPilarModal;
                                    const stdList = pilar.indikator_list || [];
                                    const allDocs = antikorupsi || [];
                                    const usedDocIds = new Set();

                                    // 1. Map each standard KPK indicator to best matching document
                                    const stdItems = stdList.map((ind) => {
                                        let bestDoc = null;
                                        let highestScore = 30;

                                        for (const d of allDocs) {
                                            if (usedDocIds.has(d.id)) continue;
                                            const score = scoreDocMatch(d, ind, pilar);
                                            if (score > highestScore) {
                                                highestScore = score;
                                                bestDoc = d;
                                            }
                                        }

                                        if (bestDoc) {
                                            usedDocIds.add(bestDoc.id);
                                        }

                                        return {
                                            id: bestDoc?.id ? `doc-${bestDoc.id}` : `std-${ind.no}`,
                                            badgeNo: `#${ind.no}`,
                                            judul: bestDoc?.judul || ind.judul,
                                            deskripsi: bestDoc?.deskripsi || 'Dokumen terverifikasi pemenuhan indikator resmi KPK RI.',
                                            link_drive: sanitizeDriveUrl(bestDoc?.link_drive),
                                            status: bestDoc?.status || (bestDoc?.link_drive ? 'Terverifikasi' : 'Dalam Proses')
                                        };
                                    });

                                    // 2. Extra / custom documents added through Admin CRUD for this pilar
                                    const extraItems = allDocs
                                        .filter(d => !usedDocIds.has(d.id) && isDocInPilar(d, pilar, pilarIndex))
                                        .map((d, idx) => ({
                                            id: `extra-${d.id}`,
                                            badgeNo: d.nomor ? (d.nomor.length <= 16 ? d.nomor : `#${idx + 1}`) : `+${idx + 1}`,
                                            judul: d.judul,
                                            deskripsi: d.deskripsi || 'Dokumen pendukung tata kelola dan integritas Desa Antikorupsi.',
                                            link_drive: sanitizeDriveUrl(d.link_drive),
                                            status: d.status || 'Terverifikasi'
                                        }));

                                    const displayItems = [...stdItems, ...extraItems];

                                    if (displayItems.length === 0) {
                                        return (
                                            <div class="p-8 text-center text-slate-400">
                                                <Inbox class="h-10 w-10 mx-auto mb-2 opacity-40 text-sky-400" />
                                                <p class="text-sm font-bold text-slate-600">Belum ada dokumen indikator terdaftar di pilar ini.</p>
                                                <p class="text-xs text-slate-400 mt-1">Dokumen dapat ditambahkan melalui panel Admin.</p>
                                            </div>
                                        );
                                    }

                                    return displayItems.map((item) => (
                                        <div key={item.id} class="rounded-2xl bg-white p-5 border border-sky-100 shadow-xs space-y-3">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                                <div class="flex items-start gap-3">
                                                    <span class="flex h-7 px-2.5 shrink-0 items-center justify-center rounded-xl bg-sky-600 text-white font-extrabold text-xs shadow-xs">
                                                        {item.badgeNo}
                                                    </span>
                                                    <div>
                                                        <h4 class="text-sm font-extrabold text-slate-900 leading-snug">{item.judul}</h4>
                                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                            {item.deskripsi}
                                                        </p>
                                                    </div>
                                                </div>

                                                {/* Drive Button */}
                                                {item.link_drive ? (
                                                    <a 
                                                        href={item.link_drive} 
                                                        target="_blank" 
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition-colors shrink-0 shadow-xs"
                                                    >
                                                        <span>Buka Drive Resmi</span>
                                                        <ExternalLink class="h-3.5 w-3.5" />
                                                    </a>
                                                ) : (
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200 shrink-0">
                                                        <Link2Off class="h-3.5 w-3.5" /> Belum ada link
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    ));
                                })()}
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
