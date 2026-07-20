@extends('layouts.app')

@section('title', 'Agribisnis & Logistik')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-emerald-700 to-teal-600 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Sektor Agribisnis & Logistik Desa</h1>
        <p class="mt-2 text-emerald-100 max-w-2xl">
            Sistem pendataan komoditas pertanian unggulan, penentuan kalender musim tanam, inventarisasi aset kelompok tani, serta pemetaan alur logistik pasca-panen.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-12" x-data="{ activeSection: 'komoditas' }">
    
    <!-- Agribusiness Stats KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Luas Lahan -->
        <div class="rounded-2xl bg-white p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 shadow-xs">
                <i data-lucide="map" class="h-6 w-6"></i>
            </div>
            <div>
                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest leading-none mb-1">Luas Lahan Tani</span>
                <span class="text-lg font-black text-slate-900 leading-tight block">{{ $stats->luas_lahan ?? '245 Hektar' }}</span>
            </div>
        </div>

        <!-- Card 2: Produksi per Tahun -->
        <div class="rounded-2xl bg-white p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 shadow-xs">
                <i data-lucide="trending-up" class="h-6 w-6"></i>
            </div>
            <div>
                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest leading-none mb-1">Produksi Per Tahun</span>
                <span class="text-lg font-black text-slate-900 leading-tight block">{{ $stats->jumlah_produksi ?? '1.500 Ton' }}</span>
            </div>
        </div>

        <!-- Card 3: Jumlah Petani -->
        <div class="rounded-2xl bg-white p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 shadow-xs">
                <i data-lucide="users" class="h-6 w-6"></i>
            </div>
            <div>
                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest leading-none mb-1">Jumlah Petani</span>
                <span class="text-lg font-black text-slate-900 leading-tight block">{{ $stats->jumlah_petani ?? '520 Orang' }}</span>
            </div>
        </div>

        <!-- Card 4: Jumlah Kelompok Tani -->
        <div class="rounded-2xl bg-white p-5 border border-slate-100 shadow-xs flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 shadow-xs">
                <i data-lucide="sprout" class="h-6 w-6"></i>
            </div>
            <div>
                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest leading-none mb-1">Kelompok Tani</span>
                <span class="text-lg font-black text-slate-900 leading-tight block">{{ $stats->jumlah_kelompok_tani ?? '12 Kelompok' }}</span>
            </div>
        </div>
    </div>
    
    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button 
                @click="activeSection = 'komoditas'" 
                :class="activeSection === 'komoditas' ? 'border-brand-green text-brand-green' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition-all">
                Komoditas Unggulan
            </button>
            <button 
                @click="activeSection = 'kalender'" 
                :class="activeSection === 'kalender' ? 'border-brand-green text-brand-green' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition-all">
                Kalender Musim Tanam
            </button>
            <button 
                @click="activeSection = 'logistik'" 
                :class="activeSection === 'logistik' ? 'border-brand-green text-brand-green' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition-all">
                Alur Distribusi Logistik
            </button>
            <button 
                @click="activeSection = 'aset'" 
                :class="activeSection === 'aset' ? 'border-brand-green text-brand-green' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition-all">
                Aset Pertanian
            </button>
        </nav>
    </div>

    <!-- Section 1: Komoditas Unggulan -->
    <div x-show="activeSection === 'komoditas'" x-transition class="space-y-8">
        <div class="max-w-3xl">
            <h2 class="text-2xl font-extrabold text-slate-900">Komoditas Utama Banyuurip</h2>
            <p class="mt-2 text-sm text-slate-600">
                Data potensi pertanian dan peternakan yang dihimpun berdasarkan survei lapangan bersama kelompok tani dan peternak desa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($komoditas as $item)
            <div class="group rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
                <div class="flex items-center justify-between pb-4 border-b border-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-brand-green">
                            <i data-lucide="{{ str_contains($item['nama'], 'Sapi') ? 'cow' : 'sprout' }}" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg leading-tight">{{ $item['nama'] }}</h3>
                            <span class="text-xs font-semibold text-slate-400 block mt-0.5">{{ $item['jenis'] }}</span>
                        </div>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-brand-green border border-emerald-200">
                        {{ $item['jumlah'] ?? $item['luas'] }}
                    </span>
                </div>

                <p class="mt-4 text-sm text-slate-600 leading-relaxed">
                    {{ $item['deskripsi'] }}
                </p>

                <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between text-xs text-slate-500">
                    <span>Hasil Rata-rata:</span>
                    <strong class="text-slate-900 font-bold">{{ $item['hasil'] }}</strong>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section 2: Kalender Musim Tanam -->
    <div x-show="activeSection === 'kalender'" x-transition class="space-y-8" x-cloak>
        <div class="max-w-3xl">
            <h2 class="text-2xl font-extrabold text-slate-900">Kalender Tanam Tahunan</h2>
            <p class="mt-2 text-sm text-slate-600">
                Panduan waktu tanam dan panen komoditas palawija serta padi utama guna menyesuaikan curah hujan dan debit mata air lokal.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @foreach($kalender_tanam as $sch)
            <div class="relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <!-- Badge Bulan -->
                    <span class="inline-flex items-center rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 border border-sky-200 mb-4">
                        <i data-lucide="calendar" class="h-3 w-3 mr-1"></i>
                        {{ $sch['bulan'] }}
                    </span>
                    
                    <h3 class="text-lg font-bold text-slate-900 leading-snug">{{ $sch['musim'] }}</h3>
                    <div class="mt-4 space-y-2 text-sm">
                        <div>
                            <span class="text-xs text-slate-400 block font-semibold">Kegiatan Utama:</span>
                            <span class="text-slate-800 font-medium">{{ $sch['kegiatan'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-50">
                    <span class="text-xs text-brand-green block font-bold uppercase tracking-wider">Rekomendasi Kader Tani:</span>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                        {{ $sch['status'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section 3: Alur Distribusi Logistik -->
    <div x-show="activeSection === 'logistik'" x-transition class="space-y-8" x-cloak>
        <div class="max-w-3xl">
            <h2 class="text-2xl font-extrabold text-slate-900">Alur Distribusi Logistik Pasca-Panen</h2>
            <p class="mt-2 text-sm text-slate-600">
                Skema sistematis perpindahan komoditas panen dari lahan tani menuju pasar guna menjaga kestabilan harga dan mutu produk.
            </p>
        </div>

        <!-- SVG Logistics Map / Visual Flowchart -->
        <div class="rounded-2xl bg-slate-900 p-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(15,118,110,0.15),transparent_50%)]"></div>
            
            <!-- Grid Timeline Flow -->
            <div class="relative grid grid-cols-1 md:grid-cols-5 gap-6 items-start">
                @foreach($alur_distribusi as $step)
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <!-- Step circle -->
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-brand-green to-brand-green-light text-white font-bold shadow-md shadow-emerald-500/10 mb-4">
                        {{ $loop->iteration }}
                    </div>
                    
                    <h3 class="font-bold text-sm text-slate-100">{{ str_replace($loop->iteration . '. ', '', $step['langkah']) }}</h3>
                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                        {{ $step['deskripsi'] }}
                    </p>
                    
                    <!-- Arrow for desktop (pointing to next card) -->
                    @if(!$loop->last)
                    <div class="hidden md:block absolute right-0 top-5 translate-x-1/2 text-emerald-500 opacity-60">
                        <i data-lucide="chevron-right" class="h-6 w-6"></i>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section 4: Aset Pertanian -->
    <div x-show="activeSection === 'aset'" x-transition class="space-y-8" x-cloak>
        <div class="max-w-3xl">
            <h2 class="text-2xl font-extrabold text-slate-900">Aset & Inventaris Pertanian Desa</h2>
            <p class="mt-2 text-sm text-slate-600">
                Pusat data aset milik kelompok tani dan BUMDes Banyuurip yang dikelola secara komunal guna menunjang produktivitas petani.
            </p>
        </div>

        <div class="rounded-2xl bg-white shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-500">
                    <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-100">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama Aset</th>
                            <th scope="col" class="px-6 py-4">Fungsi / Kegunaan</th>
                            <th scope="col" class="px-6 py-4">Kapasitas / Jumlah</th>
                            <th scope="col" class="px-6 py-4">Kelompok Pengelola</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($aset_logistik as $asset)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <th scope="row" class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                {{ $asset['nama'] }}
                            </th>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $asset['fungsi'] }}
                            </td>
                            <td class="px-6 py-4 text-slate-900 font-semibold">
                                {{ $asset['kapasitas'] ?? $asset['jumlah'] }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2 py-1 text-xs font-semibold text-brand-green border border-emerald-100">
                                    {{ $asset['pengelola'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
