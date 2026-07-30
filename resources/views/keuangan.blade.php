@extends('layouts.app')

@section('title', 'Keuangan & Regulasi')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-sky-800 via-indigo-700 to-emerald-700 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Transparansi Keuangan & Pusat Regulasi</h1>
                <p class="mt-2 text-sky-100 max-w-2xl text-sm sm:text-base leading-relaxed">
                    Visualisasi rincian sumber pendapatan desa (ADD, Dana Desa, Pajak Bagi Hasil, Bankeu, & PADes), panduan pembayaran pajak PBB-P2 online, serta integrasi dokumen Desa Antikorupsi.
                </p>
            </div>

            <!-- Quick Link to Desa Antikorupsi Portal -->
            <a href="{{ route('desa-antikorupsi') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md px-5 py-3 text-xs font-bold text-white border border-white/20 shadow-xs transition-all shrink-0">
                <i data-lucide="shield-check" class="h-5 w-5 text-emerald-300"></i>
                <span>Portal Desa Antikorupsi</span>
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-20" x-data="{
    payStep: 1,
    searchDoc: '',
    documents: {{ json_encode($regulasi) }},
    filteredDocs() {
        if (!this.searchDoc) return this.documents;
        return this.documents.filter(doc => 
            doc.judul.toLowerCase().includes(this.searchDoc.toLowerCase()) || 
            doc.nomor.toLowerCase().includes(this.searchDoc.toLowerCase()) ||
            doc.kategori.toLowerCase().includes(this.searchDoc.toLowerCase())
        );
    }
}">

    <!-- Top: APBDes Interactive Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Revenue Chart Box -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2 text-emerald-600 font-bold">
                        <i data-lucide="trending-up" class="h-5 w-5"></i>
                        <span class="text-sm">Estimasi Pendapatan Desa 2026</span>
                    </div>
                    <span class="text-xs font-extrabold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">
                        Total: Rp {{ number_format(array_sum(array_column($apbdes['pendapatan'], 'jumlah')), 0, ',', '.') }}
                    </span>
                </div>
                
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="revenueChart"></canvas>
                </div>
                
                <!-- Revenue List -->
                <div class="mt-6 space-y-2.5">
                    @foreach($apbdes['pendapatan'] as $inc)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-600 flex items-center gap-1.5 font-medium">
                            <span class="h-2.5 w-2.5 rounded-full 
                                {{ $loop->first ? 'bg-emerald-600' : 
                                  ($loop->iteration === 2 ? 'bg-teal-500' : 
                                  ($loop->iteration === 3 ? 'bg-sky-500' : 
                                  ($loop->iteration === 4 ? 'bg-indigo-500' : 'bg-amber-500'))) }}"></span>
                            {{ $inc['sumber'] }}
                        </span>
                        <strong class="text-slate-900 font-bold">Rp {{ number_format($inc['jumlah']) }} ({{ $inc['persen'] }}%)</strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Expense Chart Box -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2 text-indigo-600 font-bold">
                        <i data-lucide="pie-chart" class="h-5 w-5"></i>
                        <span class="text-sm">Rencana Belanja Desa 2026</span>
                    </div>
                    <span class="text-xs font-extrabold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                        Total: Rp {{ number_format(array_sum(array_column($apbdes['belanja'], 'jumlah')), 0, ',', '.') }}
                    </span>
                </div>
                
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="expenseChart"></canvas>
                </div>
                
                <!-- Expense List -->
                <div class="mt-6 space-y-2.5">
                    @foreach($apbdes['belanja'] as $exp)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-600 flex items-center gap-1.5 font-medium">
                            <span class="h-2.5 w-2.5 rounded-full {{ $loop->first ? 'bg-indigo-600' : ($loop->iteration === 2 ? 'bg-purple-500' : ($loop->iteration === 3 ? 'bg-pink-500' : ($loop->iteration === 4 ? 'bg-amber-500' : 'bg-slate-400'))) }}"></span>
                            {{ $exp['bidang'] }}
                        </span>
                        <strong class="text-slate-900 font-bold">Rp {{ number_format($exp['jumlah']) }} ({{ $exp['persen'] }}%)</strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Revenue Breakdown Cards (5 Specific Categories) -->
    <div class="border-t border-slate-200/80 pt-16">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700">Rincian Sumber Anggaran APBDes</h2>
            <p class="mt-1 text-2xl font-extrabold text-slate-900">Penjabaran Komponen Pendapatan Desa</p>
            <p class="mt-2 text-xs text-slate-600">Struktur penerimaan keuangan Desa Banyuurip berdasarkan 5 kategori klasifikasi transfer dan pendapatan daerah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- 1. Dana Desa (DD) -->
            <div class="rounded-2xl bg-white p-5 shadow-xs border border-emerald-100 hover:border-emerald-300 transition-all card-hover-effect flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold mb-3">
                        <i data-lucide="landmark" class="h-5 w-5"></i>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Transfer APBN</span>
                    <h3 class="font-bold text-slate-900 text-sm mt-1">Dana Desa (DD)</h3>
                    <p class="text-[11px] text-slate-600 mt-2 leading-relaxed">
                        Dana transfer dari APBN Pemerintah Pusat khusus untuk pembangunan sarana/prasarana desa, penanganan stunting, ketahanan pangan, dan BLT.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <span class="text-xs font-extrabold text-emerald-700 block">Rp 845.000.000</span>
                    <span class="text-[10px] text-slate-500">Porsi: 47% dari APBDes</span>
                </div>
            </div>

            <!-- 2. Alokasi Dana Desa (ADD) -->
            <div class="rounded-2xl bg-white p-5 shadow-xs border border-teal-100 hover:border-teal-300 transition-all card-hover-effect flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold mb-3">
                        <i data-lucide="building-2" class="h-5 w-5"></i>
                    </div>
                    <span class="text-[10px] font-bold text-teal-700 uppercase tracking-wider block">Transfer APBD Kab</span>
                    <h3 class="font-bold text-slate-900 text-sm mt-1">Alokasi Dana Desa (ADD)</h3>
                    <p class="text-[11px] text-slate-600 mt-2 leading-relaxed">
                        Dana alokasi dari APBD Kabupaten Boyolali untuk penghasilan tetap (Siltap) Kades & Perangkat, tunjukkan BPD, serta operasional Pemdes.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <span class="text-xs font-extrabold text-teal-700 block">Rp 450.000.000</span>
                    <span class="text-[10px] text-slate-500">Porsi: 25% dari APBDes</span>
                </div>
            </div>

            <!-- 3. Bagi Hasil Pajak & Retribusi (PBH) -->
            <div class="rounded-2xl bg-white p-5 shadow-xs border border-sky-100 hover:border-sky-300 transition-all card-hover-effect flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold mb-3">
                        <i data-lucide="receipt-text" class="h-5 w-5"></i>
                    </div>
                    <span class="text-[10px] font-bold text-sky-700 uppercase tracking-wider block">Bagi Hasil Daerah</span>
                    <h3 class="font-bold text-slate-900 text-sm mt-1">Pajak & Retribusi (PBH)</h3>
                    <p class="text-[11px] text-slate-600 mt-2 leading-relaxed">
                        Bagian dari hasil penerimaan Pajak Daerah (PBB-P2) & Retribusi Kabupaten Boyolali yang dibagikan secara adil ke Desa Banyuurip.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <span class="text-xs font-extrabold text-sky-700 block">Rp 180.000.000</span>
                    <span class="text-[10px] text-slate-500">Porsi: 10% dari APBDes</span>
                </div>
            </div>

            <!-- 4. Bantuan Keuangan (Bankeu) -->
            <div class="rounded-2xl bg-white p-5 shadow-xs border border-indigo-100 hover:border-indigo-300 transition-all card-hover-effect flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mb-3">
                        <i data-lucide="coins" class="h-5 w-5"></i>
                    </div>
                    <span class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider block">Bantuan Khusus</span>
                    <h3 class="font-bold text-slate-900 text-sm mt-1">Bantuan Keuangan (Bankeu)</h3>
                    <p class="text-[11px] text-slate-600 mt-2 leading-relaxed">
                        Bantuan keuangan khusus dari Pemerintah Provinsi Jawa Tengah dan Pemkab Boyolali untuk proyek fasilitas spesifik desa.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <span class="text-xs font-extrabold text-indigo-700 block">Rp 210.000.000</span>
                    <span class="text-[10px] text-slate-500">Porsi: 12% dari APBDes</span>
                </div>
            </div>

            <!-- 5. Pendapatan Asli Desa (PADes) -->
            <div class="rounded-2xl bg-white p-5 shadow-xs border border-amber-100 hover:border-amber-300 transition-all card-hover-effect flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold mb-3">
                        <i data-lucide="wallet-cards" class="h-5 w-5"></i>
                    </div>
                    <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider block">Pendapatan Mandiri</span>
                    <h3 class="font-bold text-slate-900 text-sm mt-1">Pendapatan Asli Desa (PADes)</h3>
                    <p class="text-[11px] text-slate-600 mt-2 leading-relaxed">
                        Hasil penerimaan mandiri desa dari sewa tanah kas desa, bagi hasil deviden BUMDes Banyuurip, dan swadaya partisipasi warga.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100">
                    <span class="text-xs font-extrabold text-amber-700 block">Rp 115.000.000</span>
                    <span class="text-[10px] text-slate-500">Porsi: 6% dari APBDes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Highlight: Desa Antikorupsi Drive -->
    <div class="rounded-3xl bg-gradient-to-r from-emerald-900 to-teal-800 p-8 text-white shadow-lg border border-emerald-700/50 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-start gap-4">
            <div class="h-12 w-12 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center shrink-0">
                <i data-lucide="shield-check" class="h-6 w-6 text-emerald-300"></i>
            </div>
            <div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-300 uppercase tracking-wider">Fitur Terbaru</span>
                <h3 class="text-xl font-extrabold text-white mt-0.5">Desa Antikorupsi & Pengawasan Terbuka KPK</h3>
                <p class="text-xs text-emerald-100 max-w-xl mt-1 leading-relaxed">
                    Setiap bukti dokumen pengelolaan keuangan, SOP pengadaan barang/jasa, serta hasil pengawasan BPD disimpan transparan di Google Drive yang dapat diakses publik secara realtime.
                </p>
            </div>
        </div>

        <a href="{{ route('desa-antikorupsi') }}" class="inline-flex items-center gap-2 rounded-xl bg-white text-emerald-950 hover:bg-emerald-50 px-5 py-3 text-xs font-extrabold shadow-md transition-colors shrink-0">
            <span>Buka Portal Desa Antikorupsi</span>
            <i data-lucide="arrow-right" class="h-4 w-4"></i>
        </a>
    </div>

    <!-- Middle: PBB-P2 Online Tax Payment Guide (Lintang) -->
    <div class="border-t border-slate-200 pt-16">
        <div class="rounded-2xl bg-white shadow-sm border border-slate-100 overflow-hidden max-w-4xl mx-auto">
            <!-- Tax Header -->
            <div class="bg-indigo-950 text-white p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500 text-white">
                        <i data-lucide="wallet" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">Panduan Bayar Pajak PBB-P2 Online</h3>
                        <span class="text-xs text-sky-300 block mt-0.5">Membantu warga membayar Pajak Bumi dan Bangunan secara mandiri</span>
                    </div>
                </div>
                <!-- Wizard Navigation Indicators -->
                <div class="flex items-center gap-2 text-xs">
                    <span :class="payStep === 1 ? 'bg-sky-500 text-white' : 'bg-slate-800 text-slate-400'" class="h-6 w-6 rounded-full flex items-center justify-center font-bold">1</span>
                    <span class="h-px w-4 bg-slate-800"></span>
                    <span :class="payStep === 2 ? 'bg-sky-500 text-white' : 'bg-slate-800 text-slate-400'" class="h-6 w-6 rounded-full flex items-center justify-center font-bold">2</span>
                    <span class="h-px w-4 bg-slate-800"></span>
                    <span :class="payStep === 3 ? 'bg-sky-500 text-white' : 'bg-slate-800 text-slate-400'" class="h-6 w-6 rounded-full flex items-center justify-center font-bold">3</span>
                </div>
            </div>

            <!-- Tax Wizard Body -->
            <div class="p-8">
                <!-- Step 1 -->
                <div x-show="payStep === 1" x-transition>
                    <h4 class="text-base font-bold text-slate-900">Langkah 1: Cek Tagihan SPPT PBB Anda</h4>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                        Sebelum melakukan pembayaran, pastikan Anda mengetahui Nomor Objek Pajak (NOP) yang tertera pada lembar SPPT PBB Anda tahun lalu. Anda dapat mengecek jumlah tagihan terbaru melalui portal Pajak Daerah Kabupaten Boyolali.
                    </p>
                    <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                        <i data-lucide="link" class="h-5 w-5 text-sky-600"></i>
                        <span class="text-xs text-slate-600">
                            Akses Portal Resmi: <a href="https://bppkad.boyolali.go.id" target="_blank" class="text-sky-600 font-bold hover:underline">bppkad.boyolali.go.id/pajakonline</a> (Gunakan 18 digit NOP Anda)
                        </span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div x-show="payStep === 2" x-transition x-cloak>
                    <h4 class="text-base font-bold text-slate-900">Langkah 2: Pilih Channel Pembayaran Digital</h4>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                        Kabupaten Boyolali mendukung pembayaran PBB-P2 melalui berbagai kanal online demi kenyamanan Anda tanpa perlu antre di bank:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                        <div class="rounded-xl border border-slate-100 p-4 text-center">
                            <i data-lucide="smartphone" class="h-8 w-8 text-indigo-600 mx-auto mb-2"></i>
                            <span class="text-xs font-bold text-slate-900 block">Mobile Banking / QRIS</span>
                            <span class="text-[10px] text-slate-500 mt-1 block">Bayar via e-Samsat / aplikasi Bank Jateng & bank lainnya.</span>
                        </div>
                        <div class="rounded-xl border border-slate-100 p-4 text-center">
                            <i data-lucide="store" class="h-8 w-8 text-emerald-600 mx-auto mb-2"></i>
                            <span class="text-xs font-bold text-slate-900 block">Indomaret / Alfamart</span>
                            <span class="text-[10px] text-slate-500 mt-1 block">Cukup tunjukkan NOP 18 digit Anda ke kasir minimarket terdekat.</span>
                        </div>
                        <div class="rounded-xl border border-slate-100 p-4 text-center">
                            <i data-lucide="credit-card" class="h-8 w-8 text-sky-600 mx-auto mb-2"></i>
                            <span class="text-xs font-bold text-slate-900 block">Tokopedia / Shopee</span>
                            <span class="text-[10px] text-slate-500 mt-1 block">Pilih menu Pajak PBB -> Jateng -> Boyolali dan bayar instan.</span>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div x-show="payStep === 3" x-transition x-cloak>
                    <h4 class="text-base font-bold text-slate-900">Langkah 3: Simpan Bukti Transaksi Sah</h4>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                        Setelah pembayaran berhasil dilakukan melalui kanal digital pilihan Anda, **simpan struk atau screenshot bukti pembayaran digital Anda**. Bukti transfer/bayar digital tersebut berstatus sah di mata hukum dan dapat divalidasi kapan saja di kantor desa jika diperlukan pencetakan tanda lunas PBB.
                    </p>
                    <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2">
                        <i data-lucide="shield-check" class="h-5 w-5 text-emerald-600"></i>
                        <span>Terima kasih telah berkontribusi membayar pajak tepat waktu demi kemandirian pembangunan Desa Banyuurip!</span>
                    </div>
                </div>

                <!-- Wizard Actions -->
                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                    <button 
                        @click="payStep > 1 ? payStep-- : null" 
                        :disabled="payStep === 1"
                        :class="payStep === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:text-slate-800'"
                        class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                        <i data-lucide="arrow-left" class="h-4 w-4"></i> Sebelumnya
                    </button>
                    
                    <button 
                        @click="payStep < 3 ? payStep++ : payStep = 1" 
                        class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                        <span x-text="payStep === 3 ? 'Ulangi Panduan' : 'Langkah Berikutnya'"></span>
                        <i data-lucide="arrow-right" class="h-4 w-4" x-show="payStep < 3"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom: Searchable Document Center (Hazel) -->
    <div id="dokumen" class="border-t border-slate-200 pt-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-1">
                <h2 class="text-xs font-bold uppercase tracking-wider text-brand-green">Pusat Informasi Hukum</h2>
                <p class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Dokumen & Regulasi Resmi</p>
                <p class="mt-4 text-slate-600 leading-relaxed text-sm">
                    Akses keterbukaan dokumen publik meliputi Peraturan Desa (Perdes) dan Peraturan Kepala Desa (Perkades) yang berlaku di Banyuurip.
                </p>
                
                <!-- Search Box -->
                <div class="mt-6 relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        x-model="searchDoc"
                        placeholder="Cari regulasi..."
                        class="block w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm text-slate-900 focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                </div>
            </div>

            <!-- Documents Grid -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Search Result Summary -->
                <div x-show="filteredDocs().length === 0" class="text-center py-12 bg-white rounded-2xl border border-slate-100">
                    <i data-lucide="file-warning" class="h-10 w-10 text-slate-400 mx-auto mb-2"></i>
                    <span class="font-bold text-slate-800 text-sm block">Dokumen Tidak Ditemukan</span>
                    <span class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</span>
                </div>

                <template x-for="doc in filteredDocs()" :key="doc.nomor">
                    <div class="rounded-xl bg-white p-5 shadow-sm border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-sky-200 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                <i data-lucide="file-text" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-[10px] font-bold text-slate-600 border border-slate-200" x-text="doc.kategori"></span>
                                <h3 class="font-bold text-slate-900 text-sm mt-1" x-text="doc.nomor"></h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed" x-text="doc.judul"></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-50">
                            <span class="text-[10px] text-slate-400 font-semibold" x-text="doc.tanggal"></span>
                            <template x-if="doc.link_url">
                                <a :href="doc.link_url" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition-colors border border-emerald-100 cursor-pointer">
                                    <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                                    <span>Lihat Dokumen</span>
                                </a>
                            </template>
                            <template x-if="!doc.link_url">
                                <span class="inline-flex items-center gap-1 rounded-lg bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-400 border border-slate-100 cursor-not-allowed" title="Tautan dokumen belum tersedia">
                                    <i data-lucide="file-x" class="h-3.5 w-3.5"></i>
                                    <span>Tidak Ada Link</span>
                                </span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<!-- Chart JS Setup Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Revenue Chart
    const revCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_column($apbdes['pendapatan'], 'sumber')) !!},
            datasets: [{
                data: {!! json_encode(array_column($apbdes['pendapatan'], 'persen')) !!},
                backgroundColor: ['#047857', '#0d9488', '#0284c7', '#6366f1', '#f59e0b'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '65%'
        }
    });

    // 2. Expense Chart
    const expCtx = document.getElementById('expenseChart').getContext('2d');
    new Chart(expCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_column($apbdes['belanja'], 'bidang')) !!},
            datasets: [{
                data: {!! json_encode(array_column($apbdes['belanja'], 'persen')) !!},
                backgroundColor: ['#4f46e5', '#a855f7', '#ec4899', '#f59e0b', '#64748b'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection
