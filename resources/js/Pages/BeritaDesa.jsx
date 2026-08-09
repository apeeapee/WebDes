import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    Newspaper, 
    Calendar, 
    Tag, 
    Search, 
    X, 
    ArrowRight, 
    User, 
    Share2, 
    Check 
} from 'lucide-react';

export default function BeritaDesa({ berita }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedCategory, setSelectedCategory] = useState('Semua');
    const [activeNewsModal, setActiveNewsModal] = useState(null);

    const categories = ['Semua', 'Kegiatan Desa', 'Edukasi', 'Kesehatan'];

    const filteredBerita = (berita || []).filter(item => {
        const matchesCategory = selectedCategory === 'Semua' || item.kategori === selectedCategory;
        const matchesSearch = item.judul.toLowerCase().includes(searchTerm.toLowerCase()) || 
                              item.ringkasan.toLowerCase().includes(searchTerm.toLowerCase());
        return matchesCategory && matchesSearch;
    });

    return (
        <MainLayout>
            <Head title="Berita & Kegiatan Desa Banyuurip" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Newspaper class="h-3.5 w-3.5" />
                        Kabar & Publikasi Resmi Desa
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl">Portal Berita Desa Banyuurip</h1>
                    <p class="mt-3 text-sky-100/90 max-w-2xl text-base leading-relaxed">
                        Pusat informasi publik kegiatan pemerintah desa, program KKN Tematik Undip, penyuluhan kesehatan, serta edukasi masyarakat.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-12">
                
                {/* Search & Category Filter Section */}
                <div class="rounded-3xl bg-white p-6 border border-sky-100 shadow-xs space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        {/* Search Input */}
                        <div class="relative flex-grow max-w-lg">
                            <Search class="absolute left-4 top-3.5 h-4 w-4 text-slate-400" />
                            <input
                                type="text"
                                placeholder="Cari judul berita atau topik kegiatan..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                class="w-full pl-11 pr-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-sky-500 focus:bg-white transition-colors"
                            />
                        </div>

                        {/* Category Buttons */}
                        <div class="flex flex-wrap gap-2">
                            {categories.map((cat) => (
                                <button
                                    key={cat}
                                    onClick={() => setSelectedCategory(cat)}
                                    class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold cursor-pointer transition-colors ${
                                        selectedCategory === cat 
                                            ? 'bg-sky-600 text-white shadow-xs' 
                                            : 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                                    }`}
                                >
                                    {cat}
                                </button>
                            ))}
                        </div>
                    </div>
                </div>

                {/* News Grid Section */}
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-sky-100 pb-3">
                        <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                            <Newspaper class="h-5 w-5 text-sky-600" />
                            <span>Arsip Berita Terkini ({filteredBerita.length} Artikel)</span>
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {filteredBerita.map((item) => (
                            <div 
                                key={item.id} 
                                class="rounded-3xl bg-white border border-sky-100 shadow-xs overflow-hidden flex flex-col justify-between hover:border-sky-300 transition-colors group cursor-pointer"
                                onClick={() => setActiveNewsModal(item)}
                            >
                                <div>
                                    {/* News Card Image / Placeholder */}
                                    <div class="h-48 w-full bg-slate-100 relative overflow-hidden">
                                        {item.gambar && (item.gambar.startsWith('storage/') || item.gambar.startsWith('images/') || /\.(jpg|jpeg|png|webp|svg)$/i.test(item.gambar)) ? (
                                            <img src={`/${item.gambar}`} alt={item.judul} class="h-full w-full object-cover" />
                                        ) : (
                                            <div class="h-full w-full bg-gradient-to-br from-sky-900 via-blue-900 to-slate-900 flex items-center justify-center p-6 text-white text-center w-full">
                                                <Newspaper class="h-10 w-10 text-sky-400 opacity-60" />
                                            </div>
                                        )}
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-slate-950/20 to-transparent z-10"></div>
                                        
                                        <div class="absolute top-4 left-4 z-20">
                                            <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-sky-900 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">
                                                {item.kategori}
                                            </span>
                                        </div>

                                        <div class="absolute bottom-3 left-4 text-white text-xs font-semibold z-20 flex items-center gap-1.5">
                                            <Calendar class="h-3.5 w-3.5 text-sky-300" />
                                            <span>{item.tanggal}</span>
                                        </div>
                                    </div>

                                    <div class="p-6 space-y-3">
                                        <h3 class="font-extrabold text-slate-900 text-lg leading-snug group-hover:text-sky-700 transition-colors">
                                            {item.judul}
                                        </h3>
                                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                            {item.ringkasan}
                                        </p>
                                    </div>
                                </div>

                                <div class="px-6 pb-6 pt-2 flex items-center justify-between border-t border-sky-50">
                                    <span class="text-xs font-bold text-sky-700 flex items-center gap-1">
                                        <span>Baca Selengkapnya</span>
                                        <ArrowRight class="h-3.5 w-3.5" />
                                    </span>
                                    <span class="text-[11px] text-slate-400">Tim Redaksi Desa</span>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* News Detail Reader Modal */}
                {activeNewsModal && (
                    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
                        <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200 max-h-[90vh] flex flex-col">
                            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 text-white p-6 flex items-start justify-between">
                                <div>
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-sky-300 bg-sky-500/20 px-3 py-1 rounded-full border border-sky-400/30">
                                        {activeNewsModal.kategori}
                                    </span>
                                    <h3 class="text-xl font-extrabold text-white mt-3 leading-snug">{activeNewsModal.judul}</h3>
                                    <span class="text-xs text-sky-200 mt-2 block flex items-center gap-2">
                                        <Calendar class="h-3.5 w-3.5 text-sky-400" /> Dipublikasikan: {activeNewsModal.tanggal}
                                    </span>
                                </div>
                                <button 
                                    onClick={() => setActiveNewsModal(null)}
                                    class="p-2 text-sky-200 hover:text-white rounded-xl hover:bg-white/10 transition-colors cursor-pointer shrink-0"
                                >
                                    <X class="h-6 w-6" />
                                </button>
                            </div>

                            <div class="p-6 sm:p-8 space-y-6 overflow-y-auto text-slate-700 text-sm leading-relaxed">
                                <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 text-sky-900 font-medium text-xs leading-relaxed">
                                    <strong class="font-bold block text-sky-950 mb-1">Ringkasan Kegiatan:</strong>
                                    {activeNewsModal.ringkasan}
                                </div>

                                <div class="space-y-4 text-slate-700">
                                    <p>
                                        Pemerintah Desa Banyuurip, Kecamatan Klego, Kabupaten Boyolali terus berkomitmen meningkatkan kualitas pelayanan publik dan transparansi program kerja desa melalui digitalisasi.
                                    </p>
                                    <p>
                                        Dalam pelaksanaan program ini, seluruh jajaran perangkat desa bekerja sama dengan tokoh masyarakat, kelembagaan RT/RW, serta Tim KKN Tematik Universitas Diponegoro guna memastikan manfaat kegiatan dapat dirasakan langsung oleh masyarakat luas.
                                    </p>
                                    <p>
                                        Informasi lebih lanjut mengenai kegiatan ini dapat ditanyakan secara langsung di Sekretariat Balai Desa Banyuurip pada jam kerja operasional.
                                    </p>
                                </div>
                            </div>

                            <div class="bg-slate-50 p-4 px-6 border-t border-slate-200 flex justify-between items-center text-xs">
                                <span class="text-slate-500">Pemerintah Desa Banyuurip, Klego, Boyolali</span>
                                <button 
                                    onClick={() => setActiveNewsModal(null)}
                                    class="px-5 py-2 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition-colors cursor-pointer"
                                >
                                    Tutup Berita
                                </button>
                            </div>
                        </div>
                    </div>
                )}

            </div>
        </MainLayout>
    );
}
