import React, { useEffect, useRef, useState } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    Coins, 
    FileText, 
    Download, 
    ExternalLink, 
    PieChart as PieIcon, 
    BarChart3, 
    TrendingUp, 
    ShieldCheck, 
    CheckCircle2, 
    AlertTriangle, 
    XCircle, 
    CreditCard, 
    HelpCircle, 
    Phone, 
    ChevronDown, 
    ChevronUp, 
    QrCode, 
    Search 
} from 'lucide-react';

export default function Keuangan({ 
    apbdes_pendapatan, 
    apbdes_belanja, 
    pembiayaan, 
    summary_stats, 
    panduan_pbb, 
    kontak_bkd, 
    regulasi, 
    antikorupsiDocs 
}) {
    const barChartRef = useRef(null);
    const pieChartRef = useRef(null);
    const barChartInstance = useRef(null);
    const pieChartInstance = useRef(null);
    const [openPbbTab, setOpenPbbTab] = useState(1);

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number || 0);
    };

    useEffect(() => {
        if (typeof window === 'undefined' || !window.Chart) return;

        // Destroy existing instances if any
        if (barChartInstance.current) barChartInstance.current.destroy();
        if (pieChartInstance.current) pieChartInstance.current.destroy();

        // 1. Chart 1 — Bar Chart: Anggaran vs Realisasi Pendapatan
        if (barChartRef.current && apbdes_pendapatan) {
            const labels = apbdes_pendapatan.map(i => i.sumber);
            const anggaranData = apbdes_pendapatan.map(i => i.anggaran);
            const realisasiData = apbdes_pendapatan.map(i => i.realisasi);

            barChartInstance.current = new window.Chart(barChartRef.current, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Anggaran 2026 (Rp)',
                            data: anggaranData,
                            backgroundColor: '#10b981', // Emerald Hijau
                            borderRadius: 8,
                        },
                        {
                            label: 'Realisasi 2026 (Rp)',
                            data: realisasiData,
                            backgroundColor: '#0284c7', // Sky/Blue Biru
                            borderRadius: 8,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => `${ctx.dataset.label}: ${formatRupiah(ctx.raw)}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: (val) => 'Rp ' + (val / 1000000).toLocaleString('id-ID') + ' Jt'
                            }
                        }
                    }
                }
            });
        }

        // 2. Chart 2 — Pie Chart: Komposisi Anggaran Pendapatan
        if (pieChartRef.current && apbdes_pendapatan) {
            const labels = apbdes_pendapatan.map(i => i.sumber);
            const data = apbdes_pendapatan.map(i => i.anggaran);
            const colors = ['#0284c7', '#06b6d4', '#10b981', '#6366f1', '#8b5cf6', '#f59e0b', '#64748b'];

            pieChartInstance.current = new window.Chart(pieChartRef.current, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => `${ctx.label}: ${formatRupiah(ctx.raw)} (${((ctx.raw / 1593006000) * 100).toFixed(1)}%)`
                            }
                        }
                    }
                }
            });
        }

        return () => {
            if (barChartInstance.current) barChartInstance.current.destroy();
            if (pieChartInstance.current) pieChartInstance.current.destroy();
        };
    }, [apbdes_pendapatan]);

    return (
        <MainLayout>
            <Head title="Transparansi Keuangan APBDes & Panduan PBB - Desa Banyuurip" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.2),transparent_60%)] animate-pulse-glow"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Coins class="h-3.5 w-3.5" />
                        Transparansi Publik & Pajak Daerah
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight lg:text-5xl">Transparansi APBDes & Panduan PBB SiPAD</h1>
                    <p class="mt-3 text-sky-100/90 max-w-3xl text-base leading-relaxed">
                        Laporan realisasi Anggaran Pendapatan dan Belanja Desa (APBDes) 2026 serta panduan resmi pembayaran Pajak Bumi dan Bangunan (PBB-P2) via SiPAD Kabupaten Boyolali.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 space-y-24">
                
                {/* 1. Executive Summary Cards */}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card">
                        <span class="text-xs font-bold text-sky-600 uppercase tracking-wider block">Total Anggaran Pendapatan</span>
                        <span class="text-base sm:text-xl font-extrabold text-slate-900 block mt-1">{formatRupiah(summary_stats?.total_anggaran_pendapatan || 1593006000)}</span>
                        <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 mt-2 inline-block">
                            Realisasi: {formatRupiah(summary_stats?.total_realisasi_pendapatan || 855122371)}
                        </span>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">Total Anggaran Belanja</span>
                        <span class="text-base sm:text-xl font-extrabold text-slate-900 block mt-1">{formatRupiah(summary_stats?.total_anggaran_belanja || 1639570180)}</span>
                        <span class="text-[11px] font-semibold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-200 mt-2 inline-block">
                            Realisasi: {formatRupiah(summary_stats?.total_realisasi_belanja || 583536290)}
                        </span>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card">
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider block">Ketergantungan Transfer</span>
                        <span class="text-2xl font-black text-indigo-900 block mt-1">86.5%</span>
                        <span class="text-[11px] text-slate-500 block mt-1">Dana Pusat & Kabupaten</span>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card">
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block">Surplus Realisasi Saat Ini</span>
                        <span class="text-base sm:text-xl font-extrabold text-emerald-900 block mt-1">{formatRupiah(summary_stats?.surplus_realisasi || 271586081)}</span>
                        <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 mt-2 inline-block">
                            Surplus Berjalan
                        </span>
                    </div>
                </div>

                {/* 2. Visual Charts Section (Bar Chart & Pie Chart) */}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    {/* Chart 1: Bar Chart Anggaran vs Realisasi */}
                    <div class="lg:col-span-7 rounded-3xl bg-white p-8 border border-sky-100 shadow-sm banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between border-b border-sky-100 pb-4 mb-6">
                                <div>
                                    <span class="text-xs font-extrabold text-sky-700 uppercase tracking-widest">Chart 1 — Perbandingan Pendapatan</span>
                                    <h3 class="text-xl font-extrabold text-slate-900">Anggaran vs Realisasi 2026</h3>
                                </div>
                                <BarChart3 class="h-6 w-6 text-sky-600" />
                            </div>
                            <div class="h-72 relative">
                                <canvas ref={barChartRef}></canvas>
                            </div>
                        </div>

                        {/* Visual Callout Key Insights */}
                        <div class="mt-6 p-4 rounded-2xl bg-sky-50/70 border border-sky-100 space-y-2 text-xs">
                            <div class="flex items-center gap-2 font-bold text-emerald-800">
                                <CheckCircle2 class="h-4 w-4 text-emerald-600 shrink-0" />
                                <span>Dana Desa (DD) sudah 100% terserap sepenuhnya (Rp 373,45 Jt) ✅</span>
                            </div>
                            <div class="flex items-center gap-2 font-bold text-amber-800">
                                <AlertTriangle class="h-4 w-4 text-amber-600 shrink-0" />
                                <span>Pendapatan Asli Desa (PADes) baru 4,7% terserap (Rp 10 Jt dari Rp 212 Jt) ⚠️</span>
                            </div>
                            <div class="flex items-center gap-2 font-bold text-rose-800">
                                <XCircle class="h-4 w-4 text-rose-600 shrink-0" />
                                <span>Bantuan Keuangan Provinsi belum masuk sama sekali (Rp 0 dari Rp 175 Jt) ❌</span>
                            </div>
                        </div>
                    </div>

                    {/* Chart 2: Pie Chart Komposisi Anggaran */}
                    <div class="lg:col-span-5 rounded-3xl bg-white p-8 border border-sky-100 shadow-sm banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between border-b border-sky-100 pb-4 mb-6">
                                <div>
                                    <span class="text-xs font-extrabold text-sky-700 uppercase tracking-widest">Chart 2 — Struktur Anggaran</span>
                                    <h3 class="text-xl font-extrabold text-slate-900">Komposisi Pendapatan</h3>
                                </div>
                                <PieIcon class="h-6 w-6 text-sky-600" />
                            </div>
                            <div class="h-64 relative">
                                <canvas ref={pieChartRef}></canvas>
                            </div>
                        </div>

                        <div class="mt-6 p-4 rounded-2xl bg-gradient-to-br from-sky-900 to-blue-900 text-white text-xs space-y-1.5 shadow-md">
                            <strong class="text-sky-300 font-extrabold block">Fakta Kunci Transparansi:</strong>
                            <p class="text-sky-100/90 leading-relaxed">
                                Pendapatan Transfer menyumbang <strong class="text-white">86,5%</strong> dari total pendapatan (Rp 1,37 Miliar), menandakan bahwa Desa Banyuurip sangat bergantung pada alokasi dana dari Pemerintah Pusat & Daerah.
                            </p>
                        </div>
                    </div>
                </div>

                {/* 3. Chart 3 — Progress Bar Realisasi per Sumber Pendapatan */}
                <div class="rounded-3xl bg-white p-8 sm:p-10 border border-sky-100 shadow-sm banyu-hover-card space-y-8">
                    <div class="border-b border-sky-100 pb-4">
                        <span class="text-xs font-extrabold text-sky-700 uppercase tracking-widest">Chart 3 — Loading Bar Persentase Penyerapan</span>
                        <h2 class="text-2xl font-extrabold text-slate-900 mt-1">Progress Bar Realisasi Pendapatan per Sumber</h2>
                        <p class="text-xs text-slate-500 mt-1">Visualisasi indikator seberapa persen tiap sumber anggaran telah terealisasi dan masuk ke kas desa.</p>
                    </div>

                    <div class="space-y-6">
                        {(apbdes_pendapatan || []).map((item, idx) => {
                            const pct = item.persen;
                            let barColor = 'bg-sky-600';
                            if (pct >= 99) barColor = 'bg-emerald-500';
                            else if (pct >= 40) barColor = 'bg-sky-500';
                            else if (pct > 0) barColor = 'bg-amber-500';
                            else barColor = 'bg-rose-500';

                            return (
                                <div key={idx} class="space-y-2">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs font-extrabold gap-1">
                                        <span class="text-slate-800 flex items-center gap-2">
                                            {item.sumber}
                                            <span class="text-[10px] font-semibold text-slate-400">({item.kategori})</span>
                                        </span>
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <span class="text-slate-500 text-[10px] sm:text-xs truncate">{formatRupiah(item.realisasi)} / {formatRupiah(item.anggaran)}</span>
                                            <span class={`px-2 sm:px-2.5 py-0.5 rounded-full text-[10px] font-black text-white ${barColor} shrink-0`}>
                                                {pct}%
                                            </span>
                                        </div>
                                    </div>

                                    {/* Progress Bar Track */}
                                    <div class="h-3.5 w-full bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200">
                                        <div 
                                            class={`h-full rounded-full transition-all duration-1000 ${barColor}`} 
                                            style={{ width: `${Math.min(pct, 100)}%` }}
                                        ></div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>

                {/* 4. Tabel Detail Rincian APBDes 2026 (Anggaran vs Realisasi) */}
                <div class="rounded-3xl bg-white p-8 sm:p-10 border border-sky-100 shadow-sm banyu-hover-card space-y-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-sky-100 pb-4">
                        <div>
                            <span class="text-xs font-extrabold text-sky-700 uppercase tracking-widest">Rincian Lengkap</span>
                            <h2 class="text-2xl font-extrabold text-slate-900 mt-1">Laporan Realisasi APBDes 2026</h2>
                        </div>
                        <span class="text-xs font-bold text-sky-800 bg-sky-50 px-3 py-1.5 rounded-full border border-sky-200">
                            Status: Tahun Anggaran 2026
                        </span>
                    </div>

                    <div class="overflow-x-auto -mx-4 sm:mx-0">
                        <table class="w-full text-left text-xs min-w-[600px]">
                            <thead>
                                <tr class="bg-sky-900 text-white font-extrabold uppercase tracking-wider">
                                    <th class="py-3.5 px-4 rounded-l-xl">Rincian Anggaran & Belanja</th>
                                    <th class="py-3.5 px-4 text-right">Anggaran (Rp)</th>
                                    <th class="py-3.5 px-4 text-right">Realisasi (Rp)</th>
                                    <th class="py-3.5 px-4 text-right rounded-r-xl">Persen (%)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-sky-100 font-medium text-slate-700">
                                {/* Header Pendapatan */}
                                <tr class="bg-sky-50/80 font-black text-sky-900">
                                    <td colSpan="4" class="py-2.5 px-4 uppercase tracking-wider">I. PENDAPATAN DESA</td>
                                </tr>
                                {(apbdes_pendapatan || []).map((item, idx) => (
                                    <tr key={idx} class="hover:bg-sky-50/40">
                                        <td class="py-3 px-4 pl-8">{item.sumber}</td>
                                        <td class="py-3 px-4 text-right font-bold text-slate-900">{formatRupiah(item.anggaran)}</td>
                                        <td class="py-3 px-4 text-right font-bold text-sky-700">{formatRupiah(item.realisasi)}</td>
                                        <td class="py-3 px-4 text-right font-extrabold">{item.persen}%</td>
                                    </tr>
                                ))}
                                <tr class="bg-sky-100/70 font-extrabold text-slate-900">
                                    <td class="py-3 px-4">JUMLAH PENDAPATAN</td>
                                    <td class="py-3 px-4 text-right">{formatRupiah(summary_stats?.total_anggaran_pendapatan)}</td>
                                    <td class="py-3 px-4 text-right text-sky-800">{formatRupiah(summary_stats?.total_realisasi_pendapatan)}</td>
                                    <td class="py-3 px-4 text-right">53.7%</td>
                                </tr>

                                {/* Header Belanja */}
                                <tr class="bg-sky-50/80 font-black text-sky-900">
                                    <td colSpan="4" class="py-2.5 px-4 uppercase tracking-wider pt-6">II. BELANJA DESA</td>
                                </tr>
                                {(apbdes_belanja || []).map((item, idx) => (
                                    <tr key={idx} class="hover:bg-sky-50/40">
                                        <td class="py-3 px-4 pl-8">{item.bidang}</td>
                                        <td class="py-3 px-4 text-right font-bold text-slate-900">{formatRupiah(item.anggaran)}</td>
                                        <td class="py-3 px-4 text-right font-bold text-blue-700">{formatRupiah(item.realisasi)}</td>
                                        <td class="py-3 px-4 text-right font-extrabold">{item.persen}%</td>
                                    </tr>
                                ))}
                                <tr class="bg-sky-100/70 font-extrabold text-slate-900">
                                    <td class="py-3 px-4">JUMLAH BELANJA</td>
                                    <td class="py-3 px-4 text-right">{formatRupiah(summary_stats?.total_anggaran_belanja)}</td>
                                    <td class="py-3 px-4 text-right text-blue-800">{formatRupiah(summary_stats?.total_realisasi_belanja)}</td>
                                    <td class="py-3 px-4 text-right">35.6%</td>
                                </tr>

                                {/* Header Pembiayaan */}
                                <tr class="bg-sky-50/80 font-black text-sky-900">
                                    <td colSpan="4" class="py-2.5 px-4 uppercase tracking-wider pt-6">III. PEMBIAYAAN DESA</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 pl-8">Penerimaan Pembiayaan (SiLPA)</td>
                                    <td class="py-3 px-4 text-right font-bold">{formatRupiah(pembiayaan?.penerimaan_anggaran)}</td>
                                    <td class="py-3 px-4 text-right font-bold">{formatRupiah(pembiayaan?.penerimaan_realisasi)}</td>
                                    <td class="py-3 px-4 text-right font-extrabold">100%</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 pl-8">Pengeluaran Pembiayaan</td>
                                    <td class="py-3 px-4 text-right font-bold">{formatRupiah(pembiayaan?.pengeluaran_anggaran)}</td>
                                    <td class="py-3 px-4 text-right font-bold">{formatRupiah(pembiayaan?.pengeluaran_realisasi)}</td>
                                    <td class="py-3 px-4 text-right font-extrabold">0%</td>
                                </tr>
                                <tr class="bg-slate-900 text-white font-extrabold">
                                    <td class="py-3.5 px-4 rounded-l-xl">PEMBIAYAAN NETTO</td>
                                    <td class="py-3.5 px-4 text-right">{formatRupiah(pembiayaan?.netto_anggaran)}</td>
                                    <td class="py-3.5 px-4 text-right text-sky-300">{formatRupiah(pembiayaan?.netto_realisasi)}</td>
                                    <td class="py-3.5 px-4 text-right rounded-r-xl">100%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* 5. Panduan Pembayaran PBB Melalui SiPAD Kabupaten Boyolali */}
                <div class="border-t border-sky-100 pt-20">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-800 bg-emerald-100 px-3.5 py-1 rounded-full border border-emerald-200 inline-block mb-3">
                            SiPAD KABUPATEN BOYOLALI
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 lg:text-4xl leading-tight">Panduan Pembayaran PBB Online</h2>
                        <p class="mt-4 text-slate-600 text-sm">
                            Kemudahan cek NJOP, cek tagihan, dan bayar PBB-P2 secara online tanpa harus datang ke kantor melalui portal <strong class="text-sky-700">sipad.id</strong>.
                        </p>
                    </div>

                    {/* Important Callouts Before Start */}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        <div class="rounded-3xl bg-white p-7 border border-sky-200 shadow-sm banyu-hover-card space-y-3">
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold text-sky-700 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">
                                <CreditCard class="h-3.5 w-3.5" /> Warga Biasa (Bayar Mandiri)
                            </span>
                            <h4 class="text-base font-extrabold text-slate-900">Cukup NOP & Tahun Pajak (Tanpa Kode Bayar)</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Untuk bayar PBB perorangan, warga cukup menyiapkan <strong class="text-slate-900">Nomor Objek Pajak (NOP)</strong> yang diawali kode kabupaten <strong class="text-sky-700">33-09-xxx</strong> dan pilih Tahun Pajak di portal `sipad.id`.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-white p-7 border border-emerald-200 shadow-sm banyu-hover-card space-y-3">
                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                                <QrCode class="h-3.5 w-3.5" /> Perangkat Desa / RT (Kolektif)
                            </span>
                            <h4 class="text-base font-extrabold text-slate-900">Memerlukan Kode Bayar Kolektif</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Bagi Ketua RT / Perangkat Desa yang membayar PBB banyak warga sekaligus, terlebih dahulu buat <strong class="text-emerald-800">Kode Bayar Kolektif</strong> pada menu `sipad.id/publik/pbb_bayar`.
                            </p>
                        </div>
                    </div>

                    {/* 7 Services Accordion/Tab Display */}
                    <div class="space-y-4">
                        {(panduan_pbb || []).map((srv) => (
                            <div key={srv.id} class="rounded-3xl bg-white border border-sky-100 shadow-sm overflow-hidden banyu-hover-card">
                                <button
                                    onClick={() => setOpenPbbTab(openPbbTab === srv.id ? null : srv.id)}
                                    class="w-full p-6 text-left flex items-center justify-between bg-sky-50/40 hover:bg-sky-50 transition-colors cursor-pointer"
                                >
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-sky-600 text-white font-extrabold text-xs shadow-xs">
                                            {srv.id}
                                        </span>
                                        <div>
                                            <h3 class="text-base font-extrabold text-slate-900">{srv.judul}</h3>
                                            <p class="text-xs text-slate-500">{srv.deskripsi}</p>
                                        </div>
                                    </div>
                                    {openPbbTab === srv.id ? <ChevronUp class="h-5 w-5 text-sky-600" /> : <ChevronDown class="h-5 w-5 text-slate-400" />}
                                </button>

                                {openPbbTab === srv.id && (
                                    <div class="p-6 sm:p-8 border-t border-sky-100 space-y-6 bg-white">
                                        <div class="flex items-center justify-between bg-sky-50 p-4 rounded-2xl border border-sky-200 text-xs">
                                            <span class="text-slate-600 font-medium">Link Portal Resmi SiPAD:</span>
                                            <a 
                                                href={srv.link} 
                                                target="_blank" 
                                                rel="noopener noreferrer" 
                                                class="font-extrabold text-sky-700 hover:text-sky-900 flex items-center gap-1 bg-white px-3 py-1.5 rounded-xl border border-sky-200 shadow-xs"
                                            >
                                                <span>{srv.link.replace('https://', '')}</span>
                                                <ExternalLink class="h-3.5 w-3.5" />
                                            </a>
                                        </div>

                                        <div class="space-y-3">
                                            <span class="text-xs font-extrabold text-slate-900 uppercase tracking-wider block">Langkah-Langkah Penggunaan:</span>
                                            <ol class="space-y-2 text-xs text-slate-700">
                                                {srv.langkah.map((step, sIdx) => (
                                                    <li key={sIdx} class="flex items-start gap-3">
                                                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-800 text-[10px] font-extrabold mt-0.5">
                                                            {sIdx + 1}
                                                        </span>
                                                        <span class="leading-relaxed">{step}</span>
                                                    </li>
                                                ))}
                                            </ol>
                                        </div>
                                    </div>
                                )}
                            </div>
                        ))}
                    </div>

                    {/* Kontak Resmi BKD Boyolali Box */}
                    <div class="mt-12 p-5 sm:p-8 rounded-3xl bg-slate-900 text-white flex flex-col md:flex-row items-center justify-between gap-4 sm:gap-6 shadow-xl">
                        <div>
                            <span class="text-[11px] font-extrabold text-sky-400 uppercase tracking-widest block mb-1">BANTUAN & INFORMASI PAJAK</span>
                            <h4 class="text-xl font-extrabold text-white">Kontak Resmi BKD Kabupaten Boyolali</h4>
                            <p class="text-xs text-slate-300 mt-1 max-w-xl leading-relaxed">
                                {kontak_bkd?.alamat} • Email: <strong class="text-sky-300">{kontak_bkd?.email}</strong> • Telepon: <strong class="text-sky-300">{kontak_bkd?.telepon}</strong>
                            </p>
                        </div>

                        <a 
                            href="https://sipad.id" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="px-6 py-3 rounded-2xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-extrabold shadow-lg transition-all shrink-0 hover:scale-105 flex items-center gap-2"
                        >
                            <ExternalLink class="h-4 w-4" />
                            <span>Buka Portal SiPAD.id</span>
                        </a>
                    </div>
                </div>

            </div>
        </MainLayout>
    );
}
