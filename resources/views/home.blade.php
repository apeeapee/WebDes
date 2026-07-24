@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-900 text-white">
    <!-- Background Gradients & Blurs -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(15,118,110,0.2),transparent_50%)]"></div>
    <div class="absolute inset-y-0 right-0 w-1/2 bg-gradient-to-l from-emerald-950/20 to-transparent"></div>
    
    <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 flex flex-col items-center text-center">
        <!-- Badge KKN -->
        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold text-emerald-400 border border-emerald-500/20 backdrop-blur-md mb-6">
            <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>
            KKN Banyuurip Universitas Diponegoro 2026
        </span>
        
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl max-w-3xl leading-tight">
            Banyuurip <span class="text-gradient-green-blue bg-gradient-to-r from-emerald-400 to-sky-400">Digital Gateway</span>
        </h1>
        
        <p class="mt-6 text-lg text-slate-300 max-w-2xl leading-relaxed">
            Portal digital satu pintu untuk tata kelola administrasi hukum, potensi ekonomi agribisnis, pemetaan logistik UMKM, serta pelayanan skrining kesehatan mandiri Desa Banyuurip, Boyolali.
        </p>
        
        <!-- Call to Action Buttons -->
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('kesehatan') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-3.5 text-sm font-semibold text-white shadow-lg hover:from-emerald-500 hover:to-teal-400 hover:shadow-emerald-500/25 transition-all">
                <i data-lucide="heart-pulse" class="h-4 w-4"></i>
                Skrining Kesehatan ISPA
            </a>
            <a href="{{ route('profil') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 px-6 py-3.5 text-sm font-semibold text-slate-200 border border-slate-700 hover:bg-slate-700/80 transition-colors">
                Selidiki Sejarah & Profil Desa
            </a>
        </div>
    </div>
</div>

<!-- Quick Statistics Grid -->
<div class="relative z-10 -mt-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 rounded-2xl bg-white p-6 shadow-xl border border-slate-100">
        <!-- Stat Item -->
        <div class="flex flex-col items-center justify-center p-4 text-center border-r border-slate-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0 max-lg:pb-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-brand-green mb-3">
                <i data-lucide="users" class="h-6 w-6"></i>
            </div>
            <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($stats['penduduk']) }}</span>
            <span class="text-xs font-semibold text-slate-500 uppercase mt-1">Total Penduduk</span>
        </div>
        
        <!-- Stat Item -->
        <div class="flex flex-col items-center justify-center p-4 text-center border-r border-slate-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0 max-lg:pb-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600 mb-3">
                <i data-lucide="home" class="h-6 w-6"></i>
            </div>
            <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ number_format($stats['kk']) }}</span>
            <span class="text-xs font-semibold text-slate-500 uppercase mt-1">Kepala Keluarga</span>
        </div>
        
        <!-- Stat Item -->
        <div class="flex flex-col items-center justify-center p-4 text-center border-r border-slate-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0 max-lg:pb-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 text-sky-600 mb-3">
                <i data-lucide="sprout" class="h-6 w-6"></i>
            </div>
            <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stats['luas_tani'] }}</span>
            <span class="text-xs font-semibold text-slate-500 uppercase mt-1">Lahan Tani</span>
        </div>
        
        <!-- Stat Item -->
        <div class="flex flex-col items-center justify-center p-4 text-center border-r border-slate-100 last:border-0 max-lg:border-r-0 max-lg:even:border-r-0 max-lg:pb-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 mb-3">
                <i data-lucide="shopping-bag" class="h-6 w-6"></i>
            </div>
            <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stats['umkm'] }}</span>
            <span class="text-xs font-semibold text-slate-500 uppercase mt-1">UMKM Binaan</span>
        </div>
        
        <!-- Stat Item -->
        <div class="flex flex-col items-center justify-center p-4 text-center last:border-0">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600 mb-3">
                <i data-lucide="activity" class="h-6 w-6"></i>
            </div>
            <span class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stats['posyandu'] }}</span>
            <span class="text-xs font-semibold text-slate-500 uppercase mt-1">Posyandu Aktif</span>
        </div>
    </div>
</div>

<!-- Multidisciplinary Services Portal -->
<div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-xs font-bold uppercase tracking-wider text-brand-green">Sinergi Keilmuan KKN</h2>
        <p class="mt-2 text-3xl font-extrabold text-slate-900 sm:text-4xl leading-tight">Portal Integrasi Layanan Desa</p>
        <p class="mt-4 text-slate-600">
            Sistem informasi terpadu yang dirancang bersama untuk mendigitalkan tata kelola administrasi desa, memetakan potensi alam & UMKM, serta mempermudah akses edukasi kesehatan.
        </p>
    </div>

    <!-- Quick Actions Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Service Card: Kesehatan -->
        <div class="group relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-500 text-white shadow-md shadow-rose-500/10 group-hover:scale-110 transition-transform">
                <i data-lucide="shield-alert" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Kesehatan Paru & Skrining ISPA</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Akses bacaan E-Book RESPIRA (edukasi pencegahan ISPA) dan lakukan deteksi dini risiko pernapasan secara mandiri di rumah.
            </p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Keperawatan</span>
                <a href="{{ route('kesehatan') }}" class="text-sm font-semibold text-brand-green group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                    Buka Fitur <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Service Card: Agribisnis -->
        <div class="group relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/10 group-hover:scale-110 transition-transform">
                <i data-lucide="calendar" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Agribisnis & Kalender Musim Tanam</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Informasi jadwal tanam & panen komoditas unggulan pertanian/peternakan serta database inventaris aset penunjang pertanian desa.
            </p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Agribisnis & Logistik</span>
                <a href="{{ route('agribisnis') }}" class="text-sm font-semibold text-brand-green group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                    Buka Fitur <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Service Card: Keuangan -->
        <div class="group relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-600 text-white shadow-md shadow-sky-600/10 group-hover:scale-110 transition-transform">
                <i data-lucide="pie-chart" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Transparansi Keuangan APBDes</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Visualisasi grafis anggaran pendapatan dan belanja desa (APBDes) serta panduan praktis alur pembayaran pajak PBB-P2 online.
            </p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Akuntansi Perpajakan</span>
                <a href="{{ route('keuangan') }}" class="text-sm font-semibold text-brand-green group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                    Buka Fitur <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Service Card: UMKM -->
        <div class="group relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500 text-white shadow-md shadow-amber-500/10 group-hover:scale-110 transition-transform">
                <i data-lucide="shopping-bag" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Direktori UMKM & Pembukuan</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Daftar usaha mikro komoditas desa yang terdata dengan pencatatan pembukuan keuangan kas terstruktur serta katalog produk.
            </p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Akuntansi</span>
                <a href="{{ route('umkm') }}" class="text-sm font-semibold text-brand-green group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                    Buka Fitur <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Service Card: Regulasi -->
        <div class="group relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-700 text-white shadow-md shadow-slate-700/10 group-hover:scale-110 transition-transform">
                <i data-lucide="scale" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Pusat Hukum & Regulasi Desa</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Pusat data dokumen administrasi, peraturan desa (Perdes), peraturan kepala desa (Perkades), hingga Rencana Pembangunan Desa.
            </p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Ilmu Hukum</span>
                <a href="{{ route('keuangan') }}#dokumen" class="text-sm font-semibold text-brand-green group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                    Buka Fitur <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>

        <!-- Service Card: 5S Jepang -->
        <div class="group relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-600/10 group-hover:scale-110 transition-transform">
                <i data-lucide="badge-check" class="h-6 w-6"></i>
            </div>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Edukasi Budaya 5S Jepang</h3>
            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                Materi interaktif konsep 5S Jepang (Seiri, Seiton, Seiso, Seiketsu, Shitsuke) untuk pembiasaan hidup bersih dan disiplin.
            </p>
            <div class="mt-6 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Budaya Jepang</span>
                <a href="{{ route('edukasi5s') }}" class="text-sm font-semibold text-brand-green group-hover:translate-x-1.5 transition-transform flex items-center gap-1">
                    Buka Fitur <i data-lucide="chevron-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- News & Announcements -->
<div class="bg-slate-100/60 py-20 border-y border-slate-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <h2 class="text-xs font-bold uppercase tracking-wider text-brand-green">Kabar & Publikasi</h2>
                <p class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Warta Kegiatan Banyuurip</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $item)
            <div class="flex flex-col overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-sm transition-transform hover:-translate-y-1 duration-300">
                <!-- Image Holder (Actual Uploaded Image or Aesthetic Gradient Placeholder) -->
                <div class="h-48 w-full overflow-hidden flex items-center justify-center bg-slate-100 flex-shrink-0">
                    @if($item['gambar'] && (str_starts_with($item['gambar'], 'storage/') || file_exists(public_path($item['gambar']))))
                        <img src="{{ asset($item['gambar']) }}" alt="{{ $item['judul'] }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full bg-gradient-to-br {{ $loop->first ? 'from-emerald-600 to-teal-500' : ($loop->iteration === 2 ? 'from-indigo-600 to-purple-500' : 'from-sky-600 to-teal-500') }} flex items-center justify-center p-6 text-white text-center w-full">
                            <div>
                                <i data-lucide="newspaper" class="h-10 w-10 mx-auto opacity-75 mb-2"></i>
                                <span class="text-xs font-bold uppercase tracking-widest opacity-90">{{ $item['kategori'] }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="flex flex-grow flex-col justify-between p-6">
                    <div>
                        <span class="text-xs text-slate-400 font-semibold">{{ $item['tanggal'] }}</span>
                        <h3 class="mt-2 text-base font-bold text-slate-900 leading-snug hover:text-brand-green cursor-pointer">{{ $item['judul'] }}</h3>
                        <p class="mt-3 text-sm text-slate-500 leading-relaxed line-clamp-3">
                            {{ $item['ringkasan'] }}
                        </p>
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-4 flex items-center">
                        <button class="text-xs font-bold text-brand-green flex items-center gap-1 hover:underline">
                            Baca Selengkapnya <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Location Maps & Details -->
<div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Description -->
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-brand-green">Lokasi Geografis</span>
            <h2 class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Desa Banyuurip, Klego</h2>
            <p class="mt-4 text-slate-600 leading-relaxed">
                Secara administrasi, Desa Banyuurip terletak di Kecamatan Klego, Kabupaten Boyolali, Jawa Tengah. Dikelilingi area persawahan yang subur dan bukit-bukit hijau, desa ini diberkahi dengan ketersediaan air yang melimpah (mata air murni) yang menjadi tulang punggung perekonomian agribisnis lokal.
            </p>
            <div class="mt-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-brand-green">
                        <i data-lucide="check-circle-2" class="h-4.5 w-4.5"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Dua Dusun Utama (Dusun I dan Dusun II)</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-brand-green">
                        <i data-lucide="check-circle-2" class="h-4.5 w-4.5"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Lahan pertanian subur dengan komoditas padi & jagung</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-brand-green">
                        <i data-lucide="check-circle-2" class="h-4.5 w-4.5"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Dekat dengan Waduk Cengklik & Sentra Sapi Perah Boyolali</span>
                </div>
            </div>
        </div>
        
        <!-- Map Embed / Card Mockup -->
        <div class="relative rounded-2xl bg-white p-4 shadow-lg border border-slate-100 overflow-hidden h-[350px] flex items-center justify-center">
            <!-- Simulating Map Embed (with clean style and pin) -->
            <div class="absolute inset-0 bg-slate-200/50 flex flex-col items-center justify-center p-6 text-center">
                <div class="relative flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500 text-white shadow-xl shadow-emerald-500/30 animate-pulse">
                    <i data-lucide="map-pin" class="h-8 w-8"></i>
                </div>
                <span class="mt-4 block font-bold text-slate-800 text-lg">Desa Banyuurip, Klego, Boyolali</span>
                <span class="text-xs text-slate-500 mt-1">Koordinat Kecamatan Klego, Jawa Tengah</span>
                
                <a href="https://maps.google.com" target="_blank" class="mt-6 inline-flex items-center gap-1.5 rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-slate-800 transition-colors">
                    <i data-lucide="external-link" class="h-3 w-3"></i>
                    Buka Google Maps
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
