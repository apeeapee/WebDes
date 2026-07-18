@extends('layouts.app')

@section('title', 'Admin Panel (Prototype)')

@section('content')
<!-- Page Header -->
<div class="bg-slate-900 py-12 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <div>
            <span class="inline-flex items-center gap-1 rounded-full bg-slate-800 px-2.5 py-1 text-xs font-semibold text-emerald-400 border border-slate-700">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Terkoneksi (Prototype Demo)
            </span>
            <h1 class="text-2xl font-extrabold tracking-tight mt-2">Dashboard Pengelola Desa</h1>
        </div>
        <span class="text-xs text-slate-400">Selamat datang, **Admin Desa**</span>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 space-y-10" x-data="{
    activeTab: '{{ session('success_regulasi') ? 'regulasi' : (session('success_umkm') ? 'umkm' : 'dashboard') }}',
    newDoc: { nomor: '', judul: '', kategori: 'Peraturan Desa' },
    newUmkm: { nama: '', pemilik: '', kategori: 'Makanan Ringan', omzet: '' }
}">

    <!-- Inner navigation tabs -->
    <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-3">
        <button 
            @click="activeTab = 'dashboard'" 
            :class="activeTab === 'dashboard' ? 'bg-slate-800 text-white' : 'bg-white text-slate-700 border border-slate-100 hover:bg-slate-50'"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
            <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
            Ikhtisar Data
        </button>
        
        <button 
            @click="activeTab = 'regulasi'" 
            :class="activeTab === 'regulasi' ? 'bg-slate-800 text-white' : 'bg-white text-slate-700 border border-slate-100 hover:bg-slate-50'"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
            <i data-lucide="file-plus-2" class="h-4 w-4"></i>
            Input Regulasi Baru
        </button>
        
        <button 
            @click="activeTab = 'umkm'" 
            :class="activeTab === 'umkm' ? 'bg-slate-800 text-white' : 'bg-white text-slate-700 border border-slate-100 hover:bg-slate-50'"
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
            <i data-lucide="plus-circle" class="h-4 w-4"></i>
            Onboard UMKM Baru
        </button>
    </div>

    <!-- Tab 1: Dashboard Overview -->
    <div x-show="activeTab === 'dashboard'" x-transition class="space-y-10">
        <!-- Stats Widgets -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm">
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Total Warga Terdata</span>
                <strong class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ number_format($stats['total_warga']) }} Warga</strong>
            </div>
            
            <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm">
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Skrining ISPA Masuk</span>
                <strong class="text-2xl font-extrabold text-indigo-600 mt-1 block">{{ $stats['total_screening_ispa'] }} Formulir</strong>
            </div>

            <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm">
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Kasus Risiko Tinggi</span>
                <strong class="text-2xl font-extrabold text-rose-600 mt-1 block">{{ $stats['skrining_risiko_tinggi'] }} Kasus</strong>
            </div>

            <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm">
                <span class="text-[10px] text-slate-400 font-bold uppercase block">UMKM Teronboard</span>
                <strong class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $stats['umkm_aktif'] }} Unit</strong>
            </div>

            <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm">
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Dokumen Regulasi</span>
                <strong class="text-2xl font-extrabold text-slate-700 mt-1 block">{{ $stats['dokumen_hukum'] }} File</strong>
            </div>
        </div>

        <!-- Recent Health Submissions (ISPA Screening results) -->
        <div class="rounded-2xl bg-white shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <span class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                    <i data-lucide="clipboard-list" class="h-4.5 w-4.5 text-indigo-600"></i>
                    Log Hasil Skrining Mandiri ISPA (Warga)
                </span>
                <span class="inline-flex items-center rounded bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700">Tindakan Cepat Rujukan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-500">
                    <thead class="bg-slate-50/50 text-xs font-bold text-slate-700 uppercase border-b border-slate-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Warga</th>
                            <th scope="col" class="px-6 py-3">Usia</th>
                            <th scope="col" class="px-6 py-3">Risiko</th>
                            <th scope="col" class="px-6 py-3">Tanggal Input</th>
                            <th scope="col" class="px-6 py-3">Tindakan Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recent_screenings as $sc)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <th scope="row" class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                {{ $sc->nama_warga }}
                            </th>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $sc->usia }} Tahun
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border {{ $sc->risiko === 'Tinggi' ? 'bg-rose-50 text-rose-700 border-rose-200' : ($sc->risiko === 'Sedang' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200') }}">
                                    {{ $sc->risiko }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $sc->created_at->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-700 font-semibold flex items-center gap-1.5">
                                    <span class="h-2 w-2 rounded-full {{ $sc->risiko === 'Tinggi' ? 'bg-rose-500' : ($sc->risiko === 'Sedang' ? 'bg-amber-500' : 'bg-emerald-500') }}"></span>
                                    {{ $sc->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab 2: Input Regulasi Baru -->
    <div x-show="activeTab === 'regulasi'" x-transition x-cloak class="max-w-2xl mx-auto">
        <div class="rounded-2xl bg-white p-8 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                <i data-lucide="file-plus" class="h-5 w-5 text-indigo-600"></i>
                Input Peraturan / Dokumen Desa Baru
            </h2>
            <p class="text-xs text-slate-500 mt-1">Menginventarisasi dokumen hukum desa untuk diunggah otomatis ke Pusat Regulasi Publik.</p>

            <!-- Success Alert -->
            @if(session('success_regulasi'))
            <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2">
                <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
                <span>{{ session('success_regulasi') }}</span>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.storeRegulasi') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Jenis Dokumen</label>
                    <select name="kategori" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                        <option>Peraturan Desa</option>
                        <option>Peraturan Kepala Desa</option>
                        <option>Surat Keputusan Desa</option>
                        <option>Dokumen Rencana Pembangunan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nomor & Tahun Dokumen</label>
                    <input type="text" name="nomor" required placeholder="Contoh: Perdes No. 04 Tahun 2026" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Judul Dokumen</label>
                    <input type="text" name="judul" required placeholder="Contoh: Tata Tertib Keamanan Dusun I" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                        <i data-lucide="upload" class="h-4 w-4"></i>
                        <span>Upload Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab 3: Onboard UMKM Baru -->
    <div x-show="activeTab === 'umkm'" x-transition x-cloak class="max-w-2xl mx-auto">
        <div class="rounded-2xl bg-white p-8 shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="h-5 w-5 text-amber-500"></i>
                Onboard Pelaku UMKM Baru
            </h2>
            <p class="text-xs text-slate-500 mt-1">Mendaftarkan profil usaha warga Banyuurip ke direktori promosi lokal.</p>

            <!-- Success Alert -->
            @if(session('success_umkm'))
            <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2">
                <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
                <span>{{ session('success_umkm') }}</span>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.storeUmkm') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Usaha</label>
                        <input type="text" name="nama" required placeholder="Contoh: Keripik Singkong" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Pemilik</label>
                        <input type="text" name="pemilik" required placeholder="Contoh: Ibu Minah" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Kategori</label>
                        <select name="kategori" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                            <option>Makanan Ringan</option>
                            <option>Minuman Kemasan</option>
                            <option>Kerajinan Tangan</option>
                            <option>Jasa / Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Omzet Bulanan (Angka)</label>
                        <input type="text" name="omzet" required placeholder="Contoh: 2500000" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-brand-green focus:outline-none focus:ring-1 focus:ring-brand-green">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        <span>Simpan Profil Usaha</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
