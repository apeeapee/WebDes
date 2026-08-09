import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    Sprout, 
    Calendar, 
    Truck, 
    TrendingUp, 
    CheckCircle2, 
    ArrowRight, 
    Users, 
    MapPin, 
    Box, 
    FileText, 
    Send, 
    ShieldCheck, 
    Info, 
    Phone 
} from 'lucide-react';

export default function Agribisnis({ stats, luas_lahan_breakdown, kelompok_tani, inventaris_balai_desa, sop_peminjaman }) {
    const [selectedCat, setSelectedCat] = useState('Semua');

    const categories = ['Semua', 'Peralatan Acara & Hajatan', 'Alat Pertanian Komunal', 'Mesin & Konstruksi'];

    const filteredInventaris = (inventaris_balai_desa || []).filter(item => {
        if (selectedCat === 'Semua') return true;
        return item.kategori === selectedCat;
    });

    return (
        <MainLayout>
            <Head title="Agribisnis & Inventaris Balai Desa Banyuurip" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.2),transparent_60%)] animate-pulse-glow"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Sprout class="h-3.5 w-3.5" />
                        Data BPP Klego & Logistik Balai Desa
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl">Potensi Agribisnis & Katalog Inventaris</h1>
                    <p class="mt-3 text-sky-100/90 max-w-3xl text-base leading-relaxed">
                        Data resmi potensi pertanian BPP Kecamatan Klego, daftar 9 Kelompok Tani (Gapoktan Subur Makmur), serta katalog peminjaman barang & aset Balai Desa Banyuurip.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 space-y-24">
                
                {/* 1. Overview Stat Bar (BPP Kecamatan Klego) */}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-100 text-sky-700 shrink-0">
                            <Sprout class="h-7 w-7" />
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold text-slate-900 block">{stats?.luas_sawah || '450,01 Ha'}</span>
                            <span class="text-xs font-bold text-sky-700 uppercase tracking-wider block mt-0.5">Total Wilayah Tani</span>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 shrink-0">
                            <TrendingUp class="h-7 w-7" />
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold text-slate-900 block">{stats?.produktivitas_padi || '6,2 Ton/Ha'}</span>
                            <span class="text-xs font-bold text-blue-700 uppercase tracking-wider block mt-0.5">Produktivitas Padi</span>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-700 shrink-0">
                            <Calendar class="h-7 w-7" />
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold text-slate-900 block">{stats?.produktivitas_jagung || '4,5 Ton/Ha'}</span>
                            <span class="text-xs font-bold text-cyan-700 uppercase tracking-wider block mt-0.5">Produktivitas Jagung</span>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700 shrink-0">
                            <Users class="h-7 w-7" />
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold text-slate-900 block">9 Poktan</span>
                            <span class="text-xs font-bold text-indigo-700 uppercase tracking-wider block mt-0.5">Gapoktan Subur Makmur</span>
                        </div>
                    </div>
                </div>

                {/* 2. Rincian Luas Lahan & Pola Tanam (BPP Klego) */}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    {/* Left: Table Breakdown */}
                    <div class="lg:col-span-7 rounded-3xl bg-white p-8 border border-sky-100 shadow-sm banyu-hover-card">
                        <div class="flex items-center justify-between border-b border-sky-100 pb-4 mb-6">
                            <div>
                                <span class="text-xs font-extrabold text-sky-700 uppercase tracking-widest">Data Resmi Pertanian</span>
                                <h3 class="text-xl font-extrabold text-slate-900">Rincian Luas Wilayah Pertanian</h3>
                            </div>
                            <span class="text-[11px] font-extrabold text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">
                                Sumber: BPP Klego
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="bg-sky-50/80 text-sky-900 uppercase font-extrabold border-b border-sky-100">
                                        <th class="py-3 px-4">Jenis Lahan Pertanian</th>
                                        <th class="py-3 px-4 text-right">Luas (Hektar)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-sky-50 font-medium text-slate-700">
                                    {(luas_lahan_breakdown || []).map((row, idx) => (
                                        <tr key={idx} class="hover:bg-sky-50/40 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-800">{row.jenis}</td>
                                            <td class="py-3 px-4 text-right font-extrabold text-sky-800">{row.luas}</td>
                                        </tr>
                                    ))}
                                    <tr class="bg-gradient-to-r from-sky-900 to-blue-900 text-white font-extrabold">
                                        <td class="py-3.5 px-4 rounded-l-xl">Total Luas Wilayah Pertanian</td>
                                        <td class="py-3.5 px-4 text-right rounded-r-xl text-sky-200">450,01 Ha</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {/* Right: Pola Tanam & Gapoktan Info */}
                    <div class="lg:col-span-5 space-y-6">
                        <div class="rounded-3xl bg-gradient-to-br from-sky-900 to-blue-900 p-8 text-white shadow-xl border border-sky-400/30 banyu-hover-card">
                            <span class="text-xs font-extrabold uppercase tracking-widest text-sky-300 block mb-2">Sistem Pola Tanam</span>
                            <h4 class="text-xl font-extrabold text-white">Pola Rotasi Tanam Tahunan</h4>
                            <p class="text-xs text-sky-100/90 mt-2 leading-relaxed">
                                Pola tanam yang diterapkan secara berkelanjutan di Desa Banyuurip berdasarkan kondisi tanah dan musim:
                            </p>

                            <div class="mt-6 flex items-center justify-between bg-sky-950/60 p-4 rounded-2xl border border-sky-700/50 text-xs font-extrabold">
                                <span class="text-sky-300">Musim 1: Padi</span>
                                <ArrowRight class="h-4 w-4 text-sky-400" />
                                <span class="text-sky-300">Musim 2: Padi</span>
                                <ArrowRight class="h-4 w-4 text-sky-400" />
                                <span class="text-sky-300">Musim 3: Jagung / Kacang Tanah</span>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-white p-8 border border-sky-100 shadow-sm banyu-hover-card">
                            <h4 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                                <ShieldCheck class="h-5 w-5 text-sky-600" />
                                Kelembagaan Gapoktan
                            </h4>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                Seluruh kelompok tani di Desa Banyuurip terwadahi dalam <strong class="text-slate-900">Gabungan Kelompok Tani (Gapoktan) Subur Makmur</strong> yang diketuai oleh <strong class="text-sky-700">Bapak Darji</strong> untuk mengordinasikan alokasi pupuk bersubsidi, Alsintan, dan irigasi air.
                            </p>
                        </div>
                    </div>
                </div>

                {/* 3. Daftar 9 Kelompok Tani Desa Banyuurip */}
                <div class="border-t border-sky-100 pt-20">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Struktur Kelembagaan Petani</span>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl leading-tight">Daftar 9 Kelompok Tani (Poktan)</h2>
                        <p class="mt-4 text-slate-600 text-sm">
                            Sembilan kelompok tani aktif yang tersebar di wilayah Dukuh Tlogosari, Banyuurip, Ngijo, Palemrejo, Ngeliyangan, dan Jlegong.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {(kelompok_tani || []).map((poktan, idx) => (
                            <div key={idx} class="rounded-3xl bg-white p-6 border border-sky-100 shadow-sm banyu-hover-card flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-extrabold text-sky-700 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">Poktan #{idx + 1}</span>
                                        <span class="text-xs font-bold text-slate-400">{poktan.anggota}</span>
                                    </div>
                                    <h3 class="text-lg font-extrabold text-slate-900">{poktan.nama}</h3>
                                    <p class="text-xs text-slate-600 mt-2 flex items-center gap-1.5">
                                        <Users class="h-3.5 w-3.5 text-sky-600 shrink-0" />
                                        <span>Ketua: <strong class="text-slate-800">{poktan.ketua}</strong></span>
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                        <MapPin class="h-3.5 w-3.5 text-sky-600 shrink-0" />
                                        <span>{poktan.alamat}</span>
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* 4. Katalog Inventaris & Aset Balai Desa Banyuurip (Matching User Design) */}
                <div class="border-t border-sky-100 pt-20">
                    <div class="rounded-3xl bg-white p-8 sm:p-10 shadow-sm border border-sky-100 mb-12 banyu-hover-card">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <span class="text-xs font-extrabold text-emerald-800 bg-emerald-100 px-3.5 py-1 rounded-full border border-emerald-200 inline-block mb-3">
                                    KATALOG INVENTARIS DESA
                                </span>
                                <h2 class="text-3xl font-extrabold text-slate-900 leading-tight">Daftar Barang & Aset Balai Desa Banyuurip</h2>
                                <p class="text-xs text-slate-500 mt-2">
                                    Pilih barang inventaris desa yang tersedia untuk acara hajatan, kerja bakti, atau pengairan pertanian.
                                </p>
                            </div>

                            {/* Category Filter Buttons */}
                            <div class="flex flex-wrap gap-2">
                                {categories.map((cat) => (
                                    <button
                                        key={cat}
                                        onClick={() => setSelectedCat(cat)}
                                        class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold transition-all cursor-pointer ${
                                            selectedCat === cat 
                                                ? 'bg-slate-900 text-white shadow-md' 
                                                : 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                                        }`}
                                    >
                                        {cat}
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* Inventory Items Cards */}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {filteredInventaris.map((item) => (
                            <div key={item.id} class="rounded-3xl bg-white p-7 border border-sky-100 shadow-sm banyu-hover-card flex flex-col justify-between">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                                            {item.kategori}
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            {item.status}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-extrabold text-slate-900 leading-snug">{item.nama}</h3>

                                    <div class="space-y-3 pt-2">
                                        <div class="p-3.5 rounded-2xl bg-sky-50/70 border border-sky-100 space-y-2 text-xs">
                                            <div class="flex items-start gap-2">
                                                <Box class="h-4 w-4 text-sky-600 shrink-0 mt-0.5" />
                                                <div>
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase block">KAPASITAS / JUMLAH UNIT:</span>
                                                    <strong class="text-slate-900 font-bold block mt-0.5">{item.kapasitas}</strong>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-2 pt-2 border-t border-sky-100">
                                                <MapPin class="h-4 w-4 text-sky-600 shrink-0 mt-0.5" />
                                                <div>
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase block">LOKASI PENYIMPANAN:</span>
                                                    <span class="text-slate-700 font-semibold block mt-0.5">{item.lokasi}</span>
                                                </div>
                                            </div>

                                            <div class="flex items-start gap-2 pt-2 border-t border-sky-100">
                                                <FileText class="h-4 w-4 text-sky-600 shrink-0 mt-0.5" />
                                                <div>
                                                    <span class="text-[10px] font-bold text-slate-400 uppercase block">SYARAT PEMINJAMAN:</span>
                                                    <span class="text-slate-700 font-semibold block mt-0.5">{item.syarat}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 border-t border-sky-100 pt-4 flex items-center justify-between">
                                    <span class="text-[11px] font-semibold text-slate-500 truncate max-w-[170px]" title={item.pj}>
                                        {item.pj}
                                    </span>

                                    <a
                                        href={`https://wa.me/6281327349963?text=Halo%20Admin%20Balai%20Desa%20Banyuurip,%20saya%20ingin%20mengajukan%20peminjaman%20aset:%20${encodeURIComponent(item.nama)}`}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-extrabold shadow-md hover:scale-105 transition-all"
                                    >
                                        <Send class="h-3.5 w-3.5" />
                                        <span>Ajukan Pinjam</span>
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* 5. SOP Peminjaman Balai Desa & Aset Inventaris */}
                <div class="border-t border-sky-100 pt-20">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Standar Operasional Prosedur</span>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl leading-tight">SOP Peminjaman Aset & Balai Desa</h2>
                        <p class="mt-4 text-slate-600 text-sm">
                            Tata cara resmi peminjaman gedung Balai Desa, fasilitas panggung hajatan, sound system, serta Alsintan pertanian.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        {(sop_peminjaman || []).map((sop) => (
                            <div key={sop.langkah} class="rounded-3xl bg-white p-6 border border-sky-100 shadow-sm banyu-hover-card flex flex-col justify-between relative">
                                <div>
                                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-600 text-white font-black text-base shadow-md shadow-sky-600/20 mb-4">
                                        {sop.langkah}
                                    </span>
                                    <h3 class="text-sm font-extrabold text-slate-900 leading-snug">{sop.judul}</h3>
                                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">{sop.deskripsi}</p>
                                </div>
                            </div>
                        ))}
                    </div>

                    <div class="mt-12 p-6 rounded-3xl bg-gradient-to-r from-sky-900 to-blue-900 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-500/20 text-sky-300 border border-sky-400/30 shrink-0">
                                <Info class="h-6 w-6" />
                            </div>
                            <div>
                                <h4 class="font-extrabold text-base text-white">Butuh bantuan pengajuan peminjaman gedung/barang?</h4>
                                <p class="text-xs text-sky-200 mt-0.5">Hubungi Kaur Umum Balai Desa (Pak Bambang) melalui WhatsApp resmi desa.</p>
                            </div>
                        </div>

                        <a 
                            href="https://wa.me/6281327349963?text=Halo%20Kaur%20Umum%20Balai%20Desa%20Banyuurip,%20saya%20ingin%20konsultasi%20peminjaman%20gedung/inventaris" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="px-6 py-3 rounded-2xl bg-white text-slate-900 text-xs font-extrabold hover:bg-sky-50 transition-all shadow-md shrink-0 hover:scale-105 flex items-center gap-2"
                        >
                            <Phone class="h-4 w-4 text-emerald-600" />
                            <span>Hubungi Kaur Umum</span>
                        </a>
                    </div>
                </div>

            </div>
        </MainLayout>
    );
}
