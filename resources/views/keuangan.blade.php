@extends('layouts.app')

@section('title', 'Keuangan & Regulasi')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-sky-700 to-indigo-600 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Transparansi Keuangan & Pusat Regulasi</h1>
        <p class="mt-2 text-sky-100 max-w-2xl">
            Visualisasi realisasi anggaran APBDes, panduan praktis pembayaran pajak PBB-P2 online, serta pusat berkas dokumen peraturan resmi desa.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-20" x-data="{
    payStep: 1,
    searchDoc: '',
    documents: [
        { nomor: 'Perdes No. 03 Tahun 2025', judul: 'Pengelolaan Sampah dan Kebersihan Lingkungan Desa Banyuurip', kategori: 'Peraturan Desa', tanggal: '12 April 2025' },
        { nomor: 'Perdes No. 05 Tahun 2025', judul: 'Rencana Kerja Pemerintah Desa (RKPDes) Tahun Anggaran 2026', kategori: 'Peraturan Desa', tanggal: '20 September 2025' },
        { nomor: 'Perkades No. 02 Tahun 2026', judul: 'Tata Cara Pemberian Insentif Kader Kesehatan Posyandu', kategori: 'Peraturan Kepala Desa', tanggal: '05 Februari 2026' },
        { nomor: 'Perdes No. 01 Tahun 2026', judul: 'Anggaran Pendapatan dan Belanja Desa (APBDes) Tahun Anggaran 2026', kategori: 'Peraturan Desa', tanggal: '02 Januari 2026' }
    ],
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
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-2 text-emerald-600 font-bold mb-6">
                <i data-lucide="trending-up" class="h-5 w-5"></i>
                <span>Estimasi Pendapatan Desa 2026 (Total: Rp {{ number_format(array_sum(array_column($apbdes['pendapatan'], 'jumlah')), 0, ',', '.') }})</span>
            </div>
            
            <div class="h-64 relative flex items-center justify-center">
                <canvas id="revenueChart"></canvas>
            </div>
            
            <!-- Revenue List -->
            <div class="mt-6 space-y-2.5">
                @foreach($apbdes['pendapatan'] as $inc)
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-600 flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full {{ $loop->first ? 'bg-emerald-600' : ($loop->iteration === 2 ? 'bg-teal-500' : ($loop->iteration === 3 ? 'bg-sky-500' : 'bg-amber-500')) }}"></span>
                        {{ $inc['sumber'] }}
                    </span>
                    <strong class="text-slate-900 font-semibold">Rp {{ number_format($inc['jumlah']) }} ({{ $inc['persen'] }}%)</strong>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Expense Chart Box -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-2 text-indigo-600 font-bold mb-6">
                <i data-lucide="pie-chart" class="h-5 w-5"></i>
                <span>Rencana Belanja Desa 2026 (Total: Rp {{ number_format(array_sum(array_column($apbdes['belanja'], 'jumlah')), 0, ',', '.') }})</span>
            </div>
            
            <div class="h-64 relative flex items-center justify-center">
                <canvas id="expenseChart"></canvas>
            </div>
            
            <!-- Expense List -->
            <div class="mt-6 space-y-2.5">
                @foreach($apbdes['belanja'] as $exp)
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-600 flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full {{ $loop->first ? 'bg-indigo-600' : ($loop->iteration === 2 ? 'bg-purple-500' : ($loop->iteration === 3 ? 'bg-pink-500' : ($loop->iteration === 4 ? 'bg-amber-500' : 'bg-slate-400'))) }}"></span>
                        {{ $exp['bidang'] }}
                    </span>
                    <strong class="text-slate-900 font-semibold">Rp {{ number_format($exp['jumlah']) }} ({{ $exp['persen'] }}%)</strong>
                </div>
                @endforeach
            </div>
        </div>
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
                            Akses Portal Resmi: <a href="#" class="text-sky-600 font-bold hover:underline">bppkad.boyolali.go.id/pajakonline</a> (Gunakan 18 digit NOP Anda)
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
                <p class="mt-4 text-slate-600 leading-relaxed">
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
                            <button class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600 transition-colors">
                                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                                <span>Unduh</span>
                            </button>
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
                backgroundColor: ['#047857', '#14b8a6', '#0284c7', '#f59e0b', '#ec4899', '#64748b'],
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
                backgroundColor: ['#4f46e5', '#a855f7', '#ec4899', '#f59e0b', '#64748b', '#0d9488', '#0284c7'],
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
