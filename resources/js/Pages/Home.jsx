import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    Sparkles, 
    HeartPulse, 
    Users, 
    Home as HomeIcon, 
    Sprout, 
    ShoppingBag, 
    Activity, 
    ShieldAlert, 
    ChevronRight, 
    Calendar, 
    PieChart, 
    Scale, 
    BadgeCheck, 
    Newspaper, 
    ArrowRight, 
    CheckCircle2, 
    MapPin, 
    ExternalLink, 
    Droplets, 
    Compass 
} from 'lucide-react';

export default function Home({ stats, berita }) {
    const heroImages = [
        '/images/hero/hero1.jpg',
        '/images/hero/hero2.jpg',
        '/images/hero/hero3.jpg',
    ];

    const [currentHeroIdx, setCurrentHeroIdx] = useState(0);

    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentHeroIdx((prev) => (prev + 1) % heroImages.length);
        }, 6000);
        return () => clearInterval(interval);
    }, []);

    return (
        <MainLayout>
            <Head title="Beranda Utama - Desa Banyuurip" />

            {/* Dynamic Hero Section with Ultra-Smooth Background Carousel */}
            <div class="relative overflow-hidden bg-slate-950 text-white min-h-[540px] flex flex-col justify-center">
                
                {/* Background Carousel Images with Ultra-Smooth Crossfade & Ken Burns Slow Zoom */}
                {heroImages.map((img, idx) => {
                    const isActive = idx === currentHeroIdx;
                    return (
                        <div
                            key={img}
                            class={`absolute inset-0 transform-gpu transition-all duration-[2200ms] ease-in-out ${
                                isActive ? 'opacity-100 z-1 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none'
                            }`}
                        >
                            <img 
                                src={img} 
                                alt={`Desa Banyuurip ${idx + 1}`} 
                                class={`h-full w-full object-cover object-center transform-gpu transition-transform duration-[7000ms] ease-out ${
                                    isActive ? 'scale-100' : 'scale-110'
                                }`} 
                            />
                        </div>
                    );
                })}

                {/* Balanced Tint & Gradient Overlay for optimal photo brightness + text contrast */}
                <div class="absolute inset-0 bg-slate-950/35 z-10"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/50 via-slate-950/20 to-slate-950/70 z-10"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.15),transparent_60%)] z-10"></div>

                <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 flex flex-col items-center text-center z-20">
                    <div class="animate-float">
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-950/70 px-4 py-1.5 text-xs font-bold text-sky-300 border border-sky-400/50 backdrop-blur-md mb-6 shadow-xl shadow-black/50">
                            <Droplets class="h-4 w-4 text-sky-400" />
                            <span>Portal Digital Desa Banyuurip</span>
                        </span>
                    </div>
                    
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl max-w-4xl leading-tight text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)]">
                        Banyuurip <span class="text-sky-400 font-extrabold drop-shadow-[0_4px_16px_rgba(0,0,0,0.95)]">Digital Gateway</span>
                    </h1>
                    
                    <p class="mt-6 text-lg text-white font-medium max-w-3xl leading-relaxed drop-shadow-[0_2px_10px_rgba(0,0,0,0.95)]">
                        Pusat digitalisasi profil desa, transparansi tata kelola pemerintahan, potensi pertanian agribisnis, direktori UMKM, serta pelayanan kesehatan masyarakat satu pintu.
                    </p>
                    
                    <div class="mt-10 flex flex-wrap justify-center gap-4">
                        <Link 
                            href="/profil" 
                            class="inline-flex items-center gap-2 rounded-xl bg-sky-600 hover:bg-sky-500 px-6 py-3.5 text-sm font-bold text-white shadow-xl shadow-sky-600/30 border border-sky-400/30 backdrop-blur-md hover:scale-[1.03] transition-all cursor-pointer"
                        >
                            <Compass class="h-4.5 w-4.5 text-sky-200" />
                            <span>Jelajahi Profil Desa</span>
                        </Link>
                    </div>

                    {/* Carousel Navigation Indicators */}
                    <div class="mt-12 flex items-center justify-center gap-2.5 z-20">
                        {heroImages.map((_, idx) => (
                            <button
                                key={idx}
                                onClick={() => setCurrentHeroIdx(idx)}
                                class={`h-2.5 rounded-full transition-all cursor-pointer ${
                                    idx === currentHeroIdx 
                                        ? 'w-8 bg-sky-400 shadow-md shadow-sky-400/50' 
                                        : 'w-2.5 bg-white/30 hover:bg-white/60'
                                }`}
                                title={`Slide ${idx + 1}`}
                            />
                        ))}
                    </div>
                </div>
            </div>

            {/* Quick Statistics Floating Bar */}
            <div class="relative z-10 -mt-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 rounded-2xl bg-white p-6 shadow-2xl border border-sky-100/80 backdrop-blur-lg">
                    <div class="flex flex-col items-center justify-center p-4 text-center border-r border-sky-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-50 text-sky-600 mb-3 shadow-xs">
                            <Users class="h-6 w-6" />
                        </div>
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{(stats?.penduduk ?? 3420).toLocaleString('id-ID')}</span>
                        <span class="text-xs font-bold text-sky-700 uppercase mt-1 tracking-wider">Total Warga</span>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center p-4 text-center border-r border-sky-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 mb-3 shadow-xs">
                            <HomeIcon class="h-6 w-6" />
                        </div>
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{(stats?.kk ?? 985).toLocaleString('id-ID')}</span>
                        <span class="text-xs font-bold text-blue-700 uppercase mt-1 tracking-wider">Kepala Keluarga</span>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center p-4 text-center border-r border-sky-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600 mb-3 shadow-xs">
                            <Sprout class="h-6 w-6" />
                        </div>
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{stats?.luas_tani || '245 Hektar'}</span>
                        <span class="text-xs font-bold text-cyan-700 uppercase mt-1 tracking-wider">Luas Wilayah Lahan</span>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center p-4 text-center border-r border-sky-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 mb-3 shadow-xs">
                            <ShoppingBag class="h-6 w-6" />
                        </div>
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{stats?.umkm || 8}</span>
                        <span class="text-xs font-bold text-indigo-700 uppercase mt-1 tracking-wider">UMKM Binaan</span>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center p-4 text-center last:border-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 mb-3 shadow-xs">
                            <Activity class="h-6 w-6" />
                        </div>
                        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{stats?.posyandu || 5}</span>
                        <span class="text-xs font-bold text-rose-700 uppercase mt-1 tracking-wider">Posyandu Aktif</span>
                    </div>
                </div>
            </div>

            {/* Multidisciplinary Services Portal */}
            <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-sky-600 bg-sky-100/80 px-3 py-1 rounded-full border border-sky-200">Sinergi KKN Undip</span>
                    <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl leading-tight">Portal Integrasi Layanan Desa</h2>
                    <p class="mt-4 text-slate-600 leading-relaxed">
                        Sistem informasi terpadu yang dirancang untuk mendigitalkan tata kelola administrasi desa, memetakan potensi alam & UMKM, serta mempermudah akses edukasi kesehatan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {/* Service Card: Kesehatan */}
                    <div class="group relative rounded-2xl bg-white p-7 shadow-sm border border-sky-100 banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-500 text-white shadow-lg shadow-rose-500/20 group-hover:scale-110 transition-transform">
                                <ShieldAlert class="h-6 w-6" />
                            </div>
                            <h3 class="mt-5 text-xl font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Kesehatan Paru & Skrining ISPA</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                E-Book RESPIRA (edukasi pencegahan ISPA) & alat skrining risiko pernapasan mandiri secara interaktif.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center justify-end border-t border-sky-50 pt-4">
                            <Link href="/kesehatan" class="text-xs font-bold text-sky-700 group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                                Buka Fitur <ChevronRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>

                    {/* Service Card: Agribisnis */}
                    <div class="group relative rounded-2xl bg-white p-7 shadow-sm border border-sky-100 banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-600 text-white shadow-lg shadow-sky-600/20 group-hover:scale-110 transition-transform">
                                <Calendar class="h-6 w-6" />
                            </div>
                            <h3 class="mt-5 text-xl font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Agribisnis & Kalender Tanam</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Jadwal tanam & panen komoditas unggulan pertanian/peternakan serta database inventaris aset penunjang.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center justify-end border-t border-sky-50 pt-4">
                            <Link href="/agribisnis" class="text-xs font-bold text-sky-700 group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                                Buka Fitur <ChevronRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>

                    {/* Service Card: Keuangan */}
                    <div class="group relative rounded-2xl bg-white p-7 shadow-sm border border-sky-100 banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/20 group-hover:scale-110 transition-transform">
                                <PieChart class="h-6 w-6" />
                            </div>
                            <h3 class="mt-5 text-xl font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Transparansi Keuangan APBDes</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Visualisasi grafis anggaran pendapatan dan belanja desa (APBDes) serta panduan alur PBB-P2 online.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center justify-end border-t border-sky-50 pt-4">
                            <Link href="/keuangan" class="text-xs font-bold text-sky-700 group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                                Buka Fitur <ChevronRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>

                    {/* Service Card: UMKM */}
                    <div class="group relative rounded-2xl bg-white p-7 shadow-sm border border-sky-100 banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">
                                <ShoppingBag class="h-6 w-6" />
                            </div>
                            <h3 class="mt-5 text-xl font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Direktori UMKM & Pembukuan</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Daftar usaha mikro komoditas desa yang terdata dengan pencatatan pembukuan keuangan kas terstruktur.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center justify-end border-t border-sky-50 pt-4">
                            <Link href="/umkm" class="text-xs font-bold text-sky-700 group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                                Buka Fitur <ChevronRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>

                    {/* Service Card: Regulasi */}
                    <div class="group relative rounded-2xl bg-white p-7 shadow-sm border border-sky-100 banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-800 text-white shadow-lg shadow-slate-800/20 group-hover:scale-110 transition-transform">
                                <Scale class="h-6 w-6" />
                            </div>
                            <h3 class="mt-5 text-xl font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Pusat Hukum & Regulasi Desa</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Pusat data dokumen Peraturan Desa (Perdes), Surat Keputusan (SK), dan Dokumen Pembangunan Resmi.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center justify-end border-t border-sky-50 pt-4">
                            <Link href="/keuangan#dokumen" class="text-xs font-bold text-sky-700 group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                                Buka Fitur <ChevronRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>

                    {/* Service Card: 5S Jepang */}
                    <div class="group relative rounded-2xl bg-white p-7 shadow-sm border border-sky-100 banyu-hover-card flex flex-col justify-between">
                        <div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-600 text-white shadow-lg shadow-cyan-600/20 group-hover:scale-110 transition-transform">
                                <BadgeCheck class="h-6 w-6" />
                            </div>
                            <h3 class="mt-5 text-xl font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Edukasi Budaya 5S Jepang</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Materi interaktif 5S (Seiri, Seiton, Seiso, Seiketsu, Shitsuke) untuk pembiasaan hidup bersih & disiplin.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center justify-end border-t border-sky-50 pt-4">
                            <Link href="/edukasi-5s" class="text-xs font-bold text-sky-700 group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                                Buka Fitur <ChevronRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            {/* Warta Berita Section */}
            <div class="bg-gradient-to-b from-sky-50/60 via-blue-50/40 to-slate-100/80 py-24 border-y border-sky-100">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                        <div>
                            <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Kabar & Publikasi</span>
                            <h2 class="mt-3 text-3xl font-extrabold text-slate-900 leading-tight sm:text-4xl">Warta Kegiatan Banyuurip</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {(berita || []).map((item, idx) => (
                            <div key={item.id || idx} class="flex flex-col overflow-hidden rounded-2xl bg-white border border-sky-100 shadow-sm banyu-hover-card">
                                <div class="h-48 w-full overflow-hidden flex items-center justify-center bg-slate-100 shrink-0 relative">
                                    {item.gambar && (item.gambar.startsWith('storage/') || item.gambar.startsWith('images/') || /\.(jpg|jpeg|png|webp|svg)$/i.test(item.gambar)) ? (
                                        <img src={`/${item.gambar}`} alt={item.judul} class="h-full w-full object-cover" />
                                    ) : (
                                        <div class={`h-full w-full bg-gradient-to-br ${
                                            idx === 0 ? 'from-sky-600 to-blue-700' : (idx === 1 ? 'from-blue-700 to-cyan-600' : 'from-indigo-600 to-sky-600')
                                        } flex items-center justify-center p-6 text-white text-center w-full`}>
                                            <div>
                                                <Newspaper class="h-10 w-10 mx-auto opacity-80 mb-2 animate-float" />
                                                <span class="text-xs font-extrabold uppercase tracking-widest">{item.kategori}</span>
                                            </div>
                                        </div>
                                    )}
                                </div>
                                
                                <div class="flex flex-grow flex-col justify-between p-6">
                                    <div>
                                        <span class="text-xs text-sky-700 font-extrabold block mb-1">{item.tanggal}</span>
                                        <h3 class="text-base font-extrabold text-slate-900 leading-snug hover:text-sky-700 transition-colors">{item.judul}</h3>
                                        <p class="mt-3 text-xs text-slate-600 leading-relaxed line-clamp-3">
                                            {item.ringkasan}
                                        </p>
                                    </div>
                                    <div class="mt-6 border-t border-sky-50 pt-4 flex items-center justify-between">
                                        <span class="text-xs font-bold text-sky-700 flex items-center gap-1 hover:underline cursor-pointer">
                                            Baca Selengkapnya <ArrowRight class="h-3.5 w-3.5" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* Geografis & Map Section */}
            <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Lokasi Geografis</span>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 leading-tight sm:text-4xl">Desa Banyuurip, Klego</h2>
                        <p class="mt-4 text-slate-600 leading-relaxed">
                            Terletak di Kecamatan Klego, Kabupaten Boyolali. Nama <span class="font-bold text-sky-700">Banyuurip</span> melambangkan <span class="font-bold text-sky-700">"Air yang Menghidupi"</span>, mewakili keasrian alam dan ketersediaan mata air yang melimpah untuk mendukung kehidupan agribisnis masyarakat desa.
                        </p>
                    </div>
                    
                    <div class="relative rounded-2xl bg-gradient-to-br from-sky-900 to-blue-900 p-6 shadow-2xl border border-sky-400/30 overflow-hidden h-[360px] flex items-center justify-center text-white">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(56,189,248,0.2),transparent_70%)] animate-pulse-glow"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center text-center p-6">
                            <div class="relative flex h-16 w-16 items-center justify-center rounded-full bg-sky-500 text-white shadow-xl shadow-sky-500/40 animate-float">
                                <MapPin class="h-8 w-8" />
                            </div>
                            <span class="mt-4 block font-extrabold text-white text-xl">Desa Banyuurip</span>
                            <span class="text-xs text-sky-200 mt-1">Kecamatan Klego, Kabupaten Boyolali, Jawa Tengah</span>
                            
                            <a 
                                href="https://maps.google.com" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white text-slate-900 px-5 py-2.5 text-xs font-bold shadow-lg hover:bg-sky-50 transition-all hover:scale-105"
                            >
                                <ExternalLink class="h-3.5 w-3.5 text-sky-700" />
                                <span>Buka Google Maps</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
