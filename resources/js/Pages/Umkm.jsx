import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    Store, 
    PhoneCall, 
    MapPin, 
    ShoppingBag, 
    MessageSquare,
    ExternalLink 
} from 'lucide-react';

export default function Umkm({ umkm }) {
    const [selectedCategory, setSelectedCategory] = useState('all');

    const filteredUmkms = (umkm || []).filter(u => {
        if (selectedCategory === 'all') return true;
        return (u.kategori || '').includes(selectedCategory);
    });

    return (
        <MainLayout>
            <Head title="Direktori UMKM Desa Banyuurip" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Store class="h-3.5 w-3.5" />
                        Pemberdayaan Ekonomi Lokal
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl">Direktori UMKM Desa Banyuurip</h1>
                    <p class="mt-3 text-sky-100/90 max-w-2xl text-base leading-relaxed">
                        Katalog resmi usaha mikro, olahan kuliner, minuman segar, dan kerajinan lokal buatan warga Desa Banyuurip.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-12">
                {/* Filter Buttons */}
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <button 
                        onClick={() => setSelectedCategory('all')}
                        class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold transition-colors cursor-pointer ${
                            selectedCategory === 'all' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-sky-50'
                        }`}
                    >
                        Semua Kategori ({umkm?.length || 0})
                    </button>
                    <button 
                        onClick={() => setSelectedCategory('makanan')}
                        class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold transition-colors cursor-pointer ${
                            selectedCategory === 'makanan' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-sky-50'
                        }`}
                    >
                        Makanan & Olahan
                    </button>
                    <button 
                        onClick={() => setSelectedCategory('minuman')}
                        class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold transition-colors cursor-pointer ${
                            selectedCategory === 'minuman' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-sky-50'
                        }`}
                    >
                        Minuman Segar
                    </button>
                    <button 
                        onClick={() => setSelectedCategory('kerajinan')}
                        class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold transition-colors cursor-pointer ${
                            selectedCategory === 'kerajinan' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-sky-50'
                        }`}
                    >
                        Kerajinan Tangan
                    </button>
                    <button 
                        onClick={() => setSelectedCategory('pertanian')}
                        class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold transition-colors cursor-pointer ${
                            selectedCategory === 'pertanian' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-sky-50'
                        }`}
                    >
                        Pertanian & Hasil Tani
                    </button>
                </div>

                {/* UMKM Cards Grid */}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {filteredUmkms.map((u, idx) => (
                        <div key={u.id || idx} class="rounded-3xl bg-white p-6 border border-sky-100 shadow-xs flex flex-col justify-between hover:border-sky-300 transition-colors">
                            <div>
                                <div class="h-44 w-full rounded-2xl overflow-hidden mb-5 border border-slate-100 flex items-center justify-center bg-slate-50 shrink-0">
                                    {u.gambar ? (
                                        <img src={`/${u.gambar}`} class="h-full w-full object-cover" alt={u.nama} />
                                    ) : (
                                        <div class={`h-full w-full bg-gradient-to-tr flex items-center justify-center text-white ${
                                            u.kategori?.includes('makanan') ? 'from-amber-500 to-orange-400' :
                                            u.kategori?.includes('minuman') ? 'from-sky-500 to-indigo-400' :
                                            u.kategori?.includes('kerajinan') ? 'from-emerald-500 to-teal-400' :
                                            u.kategori?.includes('pertanian') ? 'from-emerald-600 to-green-500' : 'from-slate-500 to-slate-400'
                                        }`}>
                                            <Store class="h-12 w-12 opacity-80" />
                                        </div>
                                    )}
                                </div>

                                <div class="space-y-2">
                                    <span class="inline-block text-[10px] font-extrabold text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">
                                        {u.kategoriLabel || u.kategori}
                                    </span>
                                    <h3 class="font-extrabold text-slate-900 text-lg leading-snug">{u.nama}</h3>
                                    <span class="text-xs text-slate-500 block">Pemilik: <strong class="text-slate-800">{u.pemilik}</strong></span>
                                </div>

                                {(u.alamat || u.link_maps) && (
                                    <div class="mt-3.5 flex items-center justify-between gap-2 bg-sky-50/60 p-2.5 rounded-xl border border-sky-100/80">
                                        <div class="flex items-center gap-1.5 min-w-0 text-xs text-slate-700">
                                            <MapPin class="h-4 w-4 text-sky-600 shrink-0" />
                                            <span class="truncate font-semibold">{u.alamat || 'Desa Banyuurip'}</span>
                                        </div>
                                        {u.link_maps ? (
                                            <a 
                                                href={u.link_maps}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-700 hover:text-sky-800 shrink-0 bg-white px-2.5 py-1.5 rounded-lg border border-sky-200 shadow-2xs hover:bg-sky-50 transition-colors"
                                                title="Buka Lokasi di Google Maps"
                                            >
                                                <span>Google Maps</span>
                                                <ExternalLink class="h-3 w-3" />
                                            </a>
                                        ) : (
                                            <a 
                                                href={`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(u.nama + ' ' + (u.alamat || '') + ' Banyuurip Boyolali')}`}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-700 hover:text-sky-800 shrink-0 bg-white px-2.5 py-1.5 rounded-lg border border-sky-200 shadow-2xs hover:bg-sky-50 transition-colors"
                                                title="Cari Lokasi di Google Maps"
                                            >
                                                <span>Cari Maps</span>
                                                <ExternalLink class="h-3 w-3" />
                                            </a>
                                        )}
                                    </div>
                                )}
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                                    <PhoneCall class="h-3.5 w-3.5 text-sky-600" />
                                    <span>{u.kontak}</span>
                                </span>

                                <a 
                                    href={`https://wa.me/${u.kontak?.replace(/[^0-9]/g, '').startsWith('0') ? '62' + u.kontak?.replace(/[^0-9]/g, '').slice(1) : u.kontak?.replace(/[^0-9]/g, '')}?text=Halo%20${encodeURIComponent(u.pemilik)},%20saya%20tertarik%20dengan%20produk%20${encodeURIComponent(u.nama)}`} 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 px-4 py-2 text-xs font-extrabold text-white shadow-xs transition-colors"
                                >
                                    <MessageSquare class="h-3.5 w-3.5" />
                                    <span>Hubungi Penjual</span>
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </MainLayout>
    );
}
