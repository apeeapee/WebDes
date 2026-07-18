@extends('layouts.app')

@section('title', 'Direktori UMKM')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-amber-500 to-orange-500 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Direktori & Pembukuan UMKM Desa</h1>
        <p class="mt-2 text-amber-100 max-w-2xl">
            Katalog produk usaha lokal Desa Banyuurip terintegrasi pendampingan penyusunan pelaporan keuangan sederhana.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-12" x-data="{ 
    selectedCategory: 'all',
    selectedUmkm: null,
    umkms: [
        {
            nama: 'Kripik Tempe Rasa Gurih',
            pemilik: 'Ibu Sumarsih',
            kategori: 'makanan',
            kategoriLabel: 'Makanan Ringan',
            kontak: '0857-1234-5678',
            alamat: 'RT 02 / RW 01, Dusun I',
            deskripsi: 'Kripik tempe renyah dengan resep tradisional bumbu ketumbar alami tanpa bahan pengawet.',
            omzet: 'Rp 4.500.000',
            biaya: 'Rp 2.100.000',
            laba: 'Rp 2.400.000',
            pencatatan: 'Buku Kas Sederhana',
            produk: ['Kripik Tempe Ori', 'Kripik Tempe Pedas Daun Jeruk']
        },
        {
            nama: 'Kelompok Susu Segar Murni Jaya',
            pemilik: 'Pak Harjono',
            kategori: 'minuman',
            kategoriLabel: 'Peternakan / Minuman',
            kontak: '0813-9876-5432',
            alamat: 'RT 04 / RW 02, Dusun II',
            deskripsi: 'Penyedia susu segar langsung dari peternak sapi perah Banyuurip yang higienis dan berkualitas tinggi.',
            omzet: 'Rp 18.200.000',
            biaya: 'Rp 9.800.000',
            laba: 'Rp 8.400.000',
            pencatatan: 'Buku Arus Kas & Laba Rugi',
            produk: ['Susu Segar Murni 1 Liter', 'Susu Pasteurisasi Stroberi / Cokelat']
        },
        {
            nama: 'Kerajinan Anyaman Bambu Lestari',
            pemilik: 'Mbah Sugeng',
            kategori: 'kerajinan',
            kategoriLabel: 'Kerajinan Tangan',
            kontak: '0899-4567-8901',
            alamat: 'RT 01 / RW 01, Dusun I',
            deskripsi: 'Membuat aneka perabotan rumah tangga berbahan bambu lokal seperti besek, tampah, dan kap lampu hias.',
            omzet: 'Rp 3.000.000',
            biaya: 'Rp 900.000',
            laba: 'Rp 2.100.000',
            pencatatan: 'Buku Penjualan Harian',
            produk: ['Tampah Hias', 'Besek Makanan (Grosir)', 'Kap Lampu Gantung']
        },
        {
            nama: 'Kopi Robusta Banyuurip',
            pemilik: 'Mas Danang',
            kategori: 'minuman',
            kategoriLabel: 'Minuman Kemasan',
            kontak: '0821-3344-5566',
            alamat: 'RT 03 / RW 02, Dusun II',
            deskripsi: 'Kopi bubuk robusta premium yang dipanen langsung dari perkebunan lereng bukit Banyuurip dengan pemanggangan medium-dark.',
            omzet: 'Rp 6.000.000',
            biaya: 'Rp 3.200.000',
            laba: 'Rp 2.800.000',
            pencatatan: 'Aplikasi Pembukuan Digital',
            produk: ['Kopi Bubuk 250gr', 'Green Bean Robusta']
        }
    ],
    filteredUmkms() {
        if (this.selectedCategory === 'all') return this.umkms;
        return this.umkms.filter(u => u.kategori === this.selectedCategory);
    }
}">

    <!-- Filter Buttons -->
    <div class="flex flex-wrap items-center justify-center gap-2">
        <button 
            @click="selectedCategory = 'all'" 
            :class="selectedCategory === 'all' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-100 hover:bg-slate-50'"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
            Semua Kategori
        </button>
        <button 
            @click="selectedCategory = 'makanan'" 
            :class="selectedCategory === 'makanan' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-100 hover:bg-slate-50'"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
            Makanan
        </button>
        <button 
            @click="selectedCategory = 'minuman'" 
            :class="selectedCategory === 'minuman' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-100 hover:bg-slate-50'"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
            Minuman
        </button>
        <button 
            @click="selectedCategory = 'kerajinan'" 
            :class="selectedCategory === 'kerajinan' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-700 border border-slate-100 hover:bg-slate-50'"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all">
            Kerajinan
        </button>
    </div>

    <!-- UMKM Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <template x-for="u in filteredUmkms()" :key="u.nama">
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:border-amber-200 transition-colors">
                <div>
                    <!-- Image Card placeholder with specific color depending on category -->
                    <div :class="{
                        'from-amber-500 to-orange-400': u.kategori === 'makanan',
                        'from-sky-500 to-indigo-400': u.kategori === 'minuman',
                        'from-emerald-500 to-teal-400': u.kategori === 'kerajinan'
                    }" class="h-36 w-full rounded-xl bg-gradient-to-tr flex items-center justify-center text-white mb-5 shadow-inner">
                        <i data-lucide="store" class="h-10 w-10 opacity-75"></i>
                    </div>

                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span x-text="u.kategoriLabel" class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-[10px] font-bold text-amber-800 border border-amber-200"></span>
                            <h3 x-text="u.nama" class="font-extrabold text-slate-900 text-lg mt-2 leading-tight"></h3>
                            <span class="text-xs text-slate-500 mt-1 block">Pemilik: <strong x-text="u.pemilik"></strong></span>
                        </div>
                    </div>

                    <p x-text="u.deskripsi" class="mt-4 text-xs text-slate-600 leading-relaxed"></p>

                    <!-- Products Grid -->
                    <div class="mt-4">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1.5">Produk Unggulan:</span>
                        <div class="flex flex-wrap gap-1.5">
                            <template x-for="p in u.produk">
                                <span x-text="p" class="bg-slate-50 text-slate-600 rounded-lg px-2.5 py-1 text-[10px] font-semibold border border-slate-100"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-slate-50 flex items-center justify-between gap-2">
                    <!-- WhatsApp Contact Link -->
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-emerald-600 font-semibold transition-colors">
                        <i data-lucide="phone-call" class="h-3.5 w-3.5 text-emerald-500"></i>
                        <span x-text="u.kontak"></span>
                    </a>
                    
                    <!-- Financial Modal Trigger -->
                    <button 
                        @click="selectedUmkm = u"
                        class="inline-flex items-center gap-1 rounded-xl bg-amber-50 px-3.5 py-2 text-xs font-bold text-amber-900 hover:bg-amber-100 transition-colors">
                        <i data-lucide="calculator" class="h-3.5 w-3.5"></i>
                        <span>Lihat Pembukuan</span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Interactive Accounting Modal -->
    <div 
        x-show="selectedUmkm !== null" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-transition
        x-cloak>
        
        <div 
            @click.away="selectedUmkm = null"
            class="w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            
            <!-- Modal Header -->
            <div class="bg-amber-600 text-white px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="calculator" class="h-5 w-5"></i>
                    <span class="font-bold text-sm">Laporan Pembukuan Kas Bulanan</span>
                </div>
                <button @click="selectedUmkm = null" class="text-white/80 hover:text-white">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-6">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-lg leading-tight" x-text="selectedUmkm ? selectedUmkm.nama : ''"></h3>
                    <span class="text-xs text-slate-500" x-text="selectedUmkm ? 'Pemilik: ' + selectedUmkm.pemilik : ''"></span>
                </div>

                <!-- Financial Statement Grid -->
                <div class="grid grid-cols-3 gap-4 border-y border-slate-100 py-4">
                    <div class="text-center">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Omzet Rata-rata</span>
                        <strong class="text-slate-900 font-extrabold text-sm block mt-1" x-text="selectedUmkm ? selectedUmkm.omzet : ''"></strong>
                    </div>
                    <div class="text-center border-x border-slate-100">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Biaya Produksi</span>
                        <strong class="text-rose-600 font-extrabold text-sm block mt-1" x-text="selectedUmkm ? selectedUmkm.biaya : ''"></strong>
                    </div>
                    <div class="text-center">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Laba Bersih</span>
                        <strong class="text-emerald-600 font-extrabold text-sm block mt-1" x-text="selectedUmkm ? selectedUmkm.laba : ''"></strong>
                    </div>
                </div>

                <!-- Accounting Standard info -->
                <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 flex items-start gap-3">
                    <i data-lucide="check-square" class="h-5 w-5 text-emerald-600 mt-0.5 shrink-0"></i>
                    <div>
                        <span class="text-xs font-bold text-slate-900 block">Metode Pencatatan</span>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                            Pencatatan keuangan di atas disusun menggunakan standar <strong x-text="selectedUmkm ? selectedUmkm.pencatatan : ''"></strong>, disesuaikan dengan kapasitas operasional pelaku usaha binaan agar mudah dijalankan secara mandiri.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-100">
                <button @click="selectedUmkm = null" class="rounded-xl bg-slate-900 px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                    Tutup Laporan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
