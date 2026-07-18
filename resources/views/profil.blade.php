@extends('layouts.app')

@section('title', 'Profil & Sejarah')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-emerald-700 to-teal-600 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Profil & Sejarah Desa</h1>
        <p class="mt-2 text-emerald-100 max-w-2xl">
            Mengenal lebih dekat asal-usul, visi-misi, serta jajaran aparatur pemerintah yang melayani masyarakat Desa Banyuurip.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-20">
    <!-- Visi & Misi Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-1">
            <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700">Landasan Kebijakan</h2>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Visi & Misi Desa</p>
            <p class="mt-4 text-slate-600 leading-relaxed">
                Arah kebijakan pembangunan Desa Banyuurip didasarkan pada komitmen untuk menciptakan masyarakat yang sejahtera, mandiri, dan berbudaya luhur berbasis potensi pertanian lokal.
            </p>
        </div>
        
        <div class="lg:col-span-2 space-y-6">
            <!-- Visi -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                <span class="block text-xs font-semibold text-emerald-600 uppercase tracking-widest">Visi Desa</span>
                <p class="mt-2 text-xl font-bold text-slate-900 leading-relaxed italic">
                    "Terwujudnya Desa Banyuurip yang Sejahtera, Mandiri, Berdaya Saing Tinggi melalui Pemanfaatan Sumber Daya Alam dan Tata Kelola Digital yang Akuntabel."
                </p>
            </div>
            
            <!-- Misi -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 space-y-4">
                <span class="block text-xs font-semibold text-sky-600 uppercase tracking-widest">Misi Desa</span>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sky-50 text-sky-600 text-xs font-bold">1</span>
                        <p class="text-sm text-slate-700 leading-relaxed">Meningkatkan tata kelola pemerintahan desa yang bersih, transparan, dan responsif melalui digitalisasi pelayanan publik.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sky-50 text-sky-600 text-xs font-bold">2</span>
                        <p class="text-sm text-slate-700 leading-relaxed">Mengoptimalkan potensi pertanian dan peternakan sebagai basis utama kemandirian ekonomi desa.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sky-50 text-sky-600 text-xs font-bold">3</span>
                        <p class="text-sm text-slate-700 leading-relaxed">Meningkatkan sarana prasarana kesehatan dan lingkungan hidup guna mewujudkan masyarakat bebas ISPA dan penyakit menular lainnya.</p>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sky-50 text-sky-600 text-xs font-bold">4</span>
                        <p class="text-sm text-slate-700 leading-relaxed">Mendorong produktivitas UMKM lokal melalui pelatihan manajemen keuangan terstruktur dan pemasaran digital.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Sejarah (Timeline) Section -->
    <div class="border-t border-slate-200 pt-16">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700">Alur Linimasa</h2>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Sejarah Perkembangan Desa</p>
            <p class="mt-4 text-slate-600">
                Studi dokumen sejarah menyingkap bagaimana mata air kehidupan di Banyuurip telah menghidupi masyarakat lintas generasi hingga bertransformasi menjadi desa digital saat ini.
            </p>
        </div>

        <div class="relative border-l border-slate-200 max-w-3xl mx-auto pl-6 sm:pl-8 space-y-12">
            @foreach($sejarah as $event)
            <div class="relative">
                <!-- Dot icon -->
                <span class="absolute -left-[37px] sm:-left-[45px] top-1.5 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 ring-8 ring-white">
                    <i data-lucide="check" class="h-4 w-4"></i>
                </span>
                
                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 border border-emerald-200">{{ $event['tahun'] }}</span>
                <h3 class="mt-3 text-lg font-bold text-slate-900">{{ $event['judul'] }}</h3>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                    {{ $event['deskripsi'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Perangkat Desa Section -->
    <div class="border-t border-slate-200 pt-16">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700">Struktur Organisasi</h2>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Aparatur Pemerintah Desa</p>
            <p class="mt-4 text-slate-600">
                Perangkat desa Banyuurip berkomitmen memberikan pelayanan terbaik yang transparan dan akuntabel kepada seluruh warga.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($perangkat as $org)
            <div class="group relative rounded-2xl bg-white p-6 shadow-sm border border-slate-100 card-hover-effect">
                <div class="flex items-center gap-4">
                    <!-- Placeholder Avatar -->
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-emerald-700/20 to-sky-700/20 text-emerald-700">
                        <i data-lucide="user" class="h-7 w-7"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">{{ $org['nama'] }}</h3>
                        <span class="text-xs font-semibold text-teal-600 block mt-0.5">{{ $org['jabatan'] }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                        <i data-lucide="phone" class="h-3 w-3"></i>
                        {{ $org['kontak'] }}
                    </span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="mail" class="h-3 w-3"></i>
                        Hubungi
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
