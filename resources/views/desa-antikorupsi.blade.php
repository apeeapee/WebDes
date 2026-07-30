@extends('layouts.app')

@section('title', 'Portal Desa Antikorupsi')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-emerald-800 via-teal-700 to-sky-800 py-16 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-dot-grid"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-bold text-emerald-200 border border-emerald-400/30 mb-3">
                    <i data-lucide="shield-check" class="h-4 w-4 text-emerald-300"></i>
                    <span>Program Percontohan KPK & Kementerian Desa</span>
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Pusat Integrasi Desa Antikorupsi</h1>
                <p class="mt-2 text-emerald-100 max-w-2xl text-sm sm:text-base leading-relaxed">
                    Wadah keterbukaan regulasi hukum, transparansi indikator penilaian antikorupsi, serta akses langsung bukti fisik/digital melalui penyimpanan terpadu Google Drive Desa Banyuurip.
                </p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/20 text-center min-w-[220px]">
                <span class="block text-3xl font-extrabold text-white">{{ count($antikorupsi) }}</span>
                <span class="text-xs font-semibold text-emerald-200 uppercase tracking-wider block mt-1">Dokumen & Indikator Drive</span>
                <div class="mt-3 inline-flex items-center gap-1 text-[11px] font-bold text-emerald-300">
                    <i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>
                    <span>Terverifikasi 100% Terbuka</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-16" x-data="{
    selectedCategory: 'semua',
    searchQuery: '',
    documents: {{ json_encode($antikorupsi) }},
    filteredDocs() {
        return this.documents.filter(doc => {
            const matchesCat = this.selectedCategory === 'semua' || doc.kategori === this.selectedCategory;
            const matchesSearch = !this.searchQuery || 
                doc.judul.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                doc.nomor.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                doc.deskripsi.toLowerCase().includes(this.searchQuery.toLowerCase());
            return matchesCat && matchesSearch;
        });
    }
}">

    <!-- 5 Pilar Indikator KPK Cards Grid -->
    <div>
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700">Kerangka Pemenuhan Indikator</h2>
            <p class="mt-1 text-2xl font-extrabold text-slate-900">5 Pilar Utama Desa Antikorupsi KPK</p>
            <p class="mt-2 text-xs text-slate-600">Standardisasi tata kelola bersih, transparan, akuntabel, dan berintegritas tinggi di Desa Banyuurip.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($pilarKpk as $pilar)
            <div 
                @click="selectedCategory = selectedCategory === '{{ $pilar['kunci'] }}' ? 'semua' : '{{ $pilar['kunci'] }}'"
                :class="selectedCategory === '{{ $pilar['kunci'] }}' ? 'border-emerald-600 bg-emerald-50/60 ring-2 ring-emerald-600/20' : 'border-slate-200/80 bg-white hover:border-emerald-300'"
                class="rounded-2xl p-5 shadow-xs border transition-all cursor-pointer card-hover-effect flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="h-9 w-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                            <i data-lucide="{{ $pilar['icon'] }}" class="h-5 w-5"></i>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400">Pilar {{ $loop->iteration }}</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm leading-tight">{{ $pilar['kunci'] }}</h3>
                    <p class="text-[11px] text-slate-600 mt-2 leading-relaxed">{{ $pilar['deskripsi'] }}</p>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="font-semibold text-emerald-700">
                        {{ count(array_filter($antikorupsi->toArray(), fn($i) => $i['kategori'] === $pilar['kunci'])) }} Dokumen
                    </span>
                    <i data-lucide="chevron-right" class="h-3.5 w-3.5 text-slate-400"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Search & Filter Document Repository -->
    <div class="border-t border-slate-200/80 pt-14">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">Arsip Regulasi & Dokumen Drive</h2>
                <p class="text-xs text-slate-500 mt-1">Gunakan kata kunci atau filter pilar untuk menemukan berkas bukti dukung Desa Antikorupsi.</p>
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative min-w-[240px]">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Cari regulasi antikorupsi..." 
                        class="block w-full rounded-xl border border-slate-200 bg-white py-2 pl-9 pr-3 text-xs text-slate-900 focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                </div>

                <button 
                    @click="selectedCategory = 'semua'" 
                    :class="selectedCategory === 'semua' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50'"
                    class="rounded-xl px-3.5 py-2 text-xs font-bold transition-colors cursor-pointer">
                    Semua Pilar
                </button>
            </div>
        </div>

        <!-- Document Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Empty State -->
            <div x-show="filteredDocs().length === 0" class="col-span-full text-center py-16 bg-white rounded-2xl border border-slate-200">
                <i data-lucide="file-x-2" class="h-10 w-10 text-slate-400 mx-auto mb-3"></i>
                <h3 class="font-bold text-slate-800 text-sm">Dokumen Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1">Tidak ada berkas regulasi yang cocok dengan kata kunci pencarian Anda.</p>
                <button @click="searchQuery = ''; selectedCategory = 'semua'" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:underline">
                    Reset Filter Pencarian
                </button>
            </div>

            <!-- Document Card Item -->
            <template x-for="doc in filteredDocs()" :key="doc.id">
                <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/70 hover:border-emerald-300 transition-all card-hover-effect flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-mono font-bold text-slate-700 border border-slate-200" x-text="doc.nomor"></span>
                            
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                                :class="doc.status === 'Terverifikasi' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200'">
                                <i data-lucide="shield-check" class="h-3 w-3"></i>
                                <span x-text="doc.status"></span>
                            </span>
                        </div>

                        <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider mb-2 text-emerald-700 bg-emerald-50 border border-emerald-100" x-text="doc.kategori"></span>

                        <h3 class="font-bold text-slate-900 text-base leading-snug mt-1" x-text="doc.judul"></h3>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed" x-text="doc.deskripsi"></p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400 font-semibold flex items-center gap-1">
                            <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                            <span x-text="doc.tanggal"></span>
                        </span>

                        <template x-if="doc.link_drive">
                            <a :href="doc.link_drive" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 px-4 py-2 text-xs font-bold text-white shadow-sm transition-colors cursor-pointer">
                                <svg class="h-4 w-4 fill-current text-white" viewBox="0 0 24 24">
                                    <path d="M12.01 1.485c-2.08 0-4.04.81-5.51 2.28L.685 9.585c-.91.91-.91 2.39 0 3.3l5.815 5.815c1.47 1.47 3.43 2.28 5.51 2.28h.03c2.08 0 4.04-.81 5.51-2.28l5.815-5.815c.91-.91.91-2.39 0-3.3L17.55 3.765c-1.47-1.47-3.43-2.28-5.51-2.28h-.03zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0z"/>
                                </svg>
                                <span>Buka Berkas Google Drive</span>
                                <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                            </a>
                        </template>

                        <template x-if="!doc.link_drive">
                            <span class="inline-flex items-center gap-1 rounded-xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-400 cursor-not-allowed">
                                <i data-lucide="link-2-off" class="h-3.5 w-3.5"></i>
                                <span>Berkas Belum Diunggah</span>
                            </span>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
