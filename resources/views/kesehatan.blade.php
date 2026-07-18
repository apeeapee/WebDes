@extends('layouts.app')

@section('title', 'Kesehatan (RESPIRA)')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-rose-600 to-pink-500 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Pusat Layanan Kesehatan & Edukasi ISPA</h1>
        <p class="mt-2 text-rose-100 max-w-2xl">
            Modul edukasi terintegrasi **E-Book RESPIRA** dan aplikasi **Skrining Mandiri ISPA** untuk deteksi dini pencegahan infeksi saluran pernapasan akut.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-16" x-data="{ 
    selectedTab: 'pengertian', 
    screeningStep: 1, 
    wargaName: '',
    wargaUsia: '',
    ageGroup: '', 
    symptoms: {
        batuk: false,
        pilek: false,
        demam: false,
        sakit_tenggorokan: false,
        sesak_napas: false,
        napas_cepat: false,
        tarikan_dinding_dada: false,
        kebiruan: false
    },
    riskLevel: '',
    recommendation: '',
    resetScreening() {
        this.screeningStep = 1;
        this.ageGroup = '';
        this.wargaName = '';
        this.wargaUsia = '';
        for(let key in this.symptoms) {
            this.symptoms[key] = false;
        }
        this.riskLevel = '';
        this.recommendation = '';
    },
    calculateRisk() {
        // Automatically determine age group
        let ageNum = parseInt(this.wargaUsia) || 0;
        this.ageGroup = ageNum <= 5 ? 'balita' : 'dewasa';

        // Bahaya Utama (Critical signs)
        let hasCriticalSign = this.symptoms.sesak_napas || this.symptoms.napas_cepat || this.symptoms.tarikan_dinding_dada || this.symptoms.kebiruan;
        let hasModerateSign = this.symptoms.demam && (this.symptoms.batuk || this.symptoms.pilek || this.symptoms.sakit_tenggorokan);
        let hasMildSign = this.symptoms.batuk || this.symptoms.pilek || this.symptoms.sakit_tenggorokan;
        
        if (hasCriticalSign) {
            this.riskLevel = 'Tinggi';
            this.recommendation = '⚠️ **Tanda Bahaya Terdeteksi!** Penderita menunjukkan gejala sesak napas atau tarikan dinding dada. **Segera bawa penderita ke Puskesmas Klego atau rumah sakit terdekat** untuk pemeriksaan medis intensif. Jangan menunda penanganan!';
        } else if (hasModerateSign) {
            this.riskLevel = 'Sedang';
            this.recommendation = '⚠️ **Gejala Sedang.** Terdeteksi infeksi aktif dengan demam. Disarankan untuk beristirahat total, minum banyak air hangat, mengonsumsi makanan bergizi, dan minum obat penurun demam sesuai dosis. Jika demam berlanjut lebih dari 3 hari, hubungi dokter/bidan desa terdekat.';
        } else if (hasMildSign) {
            this.riskLevel = 'Rendah';
            this.recommendation = '✅ **Gejala Ringan.** Kondisi saat ini mengarah pada infeksi saluran pernapasan ringan (selesma/flu biasa). Disarankan istirahat yang cukup, jaga kebersihan tangan, konsumsi vitamin C, serta hindari paparan asap rokok dan debu pertanian.';
        } else {
            this.riskLevel = 'Bebas Gejala';
            this.recommendation = '✅ **Kondisi Sehat.** Tidak ada gejala ISPA yang terdeteksi saat ini. Tetap pertahankan pola hidup bersih dan sehat (PHBS) serta gunakan masker saat berada di luar rumah atau di area peternakan yang berdebu.';
        }

        // Post result to database via AJAX
        fetch('{{ route("kesehatan.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nama_warga: this.wargaName || 'Anonim',
                usia: ageNum,
                risiko: this.riskLevel,
                gejala: this.symptoms,
                rekomendasi: this.recommendation
            })
        });

        this.screeningStep = 3;
    }
}">

    <!-- Top Grid: Interactive E-Book and Info -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: E-Book RESPIRA Chapters Navigation -->
        <div class="lg:col-span-4 space-y-3">
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 text-rose-600 font-bold text-lg mb-6">
                    <i data-lucide="book-open" class="h-6 w-6"></i>
                    <span>E-Book RESPIRA</span>
                </div>
                <div class="flex flex-col gap-2">
                    @foreach($ebook_chapters as $chapter)
                    <button 
                        @click="selectedTab = '{{ $chapter['id'] }}'"
                        :class="selectedTab === '{{ $chapter['id'] }}' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'text-slate-600 hover:bg-slate-50 border-transparent'"
                        class="w-full text-left px-4 py-3 rounded-xl border text-sm font-semibold transition-all flex items-center justify-between">
                        <span>{{ $chapter['bab'] }}</span>
                        <i data-lucide="chevron-right" class="h-4 w-4 opacity-60"></i>
                    </button>
                    @endforeach
                </div>
            </div>
            
            <!-- Quick Prevention Tips -->
            <div class="rounded-2xl bg-gradient-to-br from-rose-50 to-pink-50 p-6 border border-rose-100">
                <h3 class="font-bold text-rose-900 flex items-center gap-1.5 text-sm">
                    <i data-lucide="info" class="h-4 w-4"></i>
                    Fakta Kesehatan ISPA
                </h3>
                <p class="text-xs text-rose-700 mt-2 leading-relaxed">
                    ISPA menyumbang angka kunjungan tertinggi pada fasilitas kesehatan dasar. Edukasi dini mengenai faktor risiko kandang ternak & debu pertanian sangat krusial bagi warga Banyuurip.
                </p>
            </div>
        </div>

        <!-- Right: Interactive Chapter Content Viewer -->
        <div class="lg:col-span-8">
            <div class="rounded-2xl bg-white p-8 shadow-sm border border-slate-100 min-h-[350px] flex flex-col justify-between">
                @foreach($ebook_chapters as $chapter)
                <div x-show="selectedTab === '{{ $chapter['id'] }}'" x-transition x-cloak>
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-500">{{ $chapter['bab'] }}</span>
                    <h2 class="mt-2 text-2xl font-extrabold text-slate-900 leading-tight border-b border-slate-100 pb-4">{{ $chapter['judul'] }}</h2>
                    <div class="mt-6 text-slate-700 text-sm leading-relaxed space-y-4">
                        {!! $chapter['konten'] !!}
                    </div>
                </div>
                @endforeach

                <!-- Chapter Footer Credit -->
                <div class="mt-8 border-t border-slate-100 pt-4 flex items-center justify-between text-xs text-slate-400">
                    <span>Sumber: Pedoman Kementerian Kesehatan RI</span>
                    <span>Disusun oleh Keperawatan Tim KKN</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom: Interactive Screening Tool -->
    <div class="border-t border-slate-200 pt-16">
        <div class="rounded-2xl bg-white shadow-md border border-slate-100 overflow-hidden max-w-3xl mx-auto">
            <!-- Header wizard -->
            <div class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="stethoscope" class="h-5 w-5 text-rose-500"></i>
                    <span class="font-bold text-sm">Aplikasi Skrining Mandiri ISPA</span>
                </div>
                <span class="text-xs font-medium text-slate-400">Step <span x-text="screeningStep"></span> of 3</span>
            </div>

            <!-- Quiz Body -->
            <div class="p-8">
                <!-- Step 1: Informasi Warga -->
                <div x-show="screeningStep === 1" x-transition class="max-w-md mx-auto space-y-4">
                    <h3 class="text-lg font-bold text-slate-900 text-center">Masukkan Informasi Warga</h3>
                    <p class="text-xs text-slate-500 text-center">Data ini digunakan untuk mendeteksi dini kategori risiko ISPA secara akurat.</p>
                    
                    <div class="space-y-3 mt-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                            <input type="text" x-model="wargaName" required placeholder="Contoh: Budi Santoso" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Usia (Tahun)</label>
                            <input type="number" x-model="wargaUsia" required placeholder="Contoh: 28 atau 3" class="block w-full rounded-xl border border-slate-200 bg-white py-2.5 px-3.5 text-sm focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500">
                        </div>
                    </div>
                    
                    <div class="pt-4 flex justify-center">
                        <button 
                            @click="if(wargaName && wargaUsia) { screeningStep = 2; ageGroup = parseInt(wargaUsia) <= 5 ? 'balita' : 'dewasa'; }"
                            :disabled="!wargaName || !wargaUsia"
                            :class="wargaName && wargaUsia ? 'bg-slate-900 text-white hover:bg-slate-800' : 'bg-slate-100 text-slate-400 cursor-not-allowed'"
                            class="inline-flex items-center gap-1.5 rounded-xl px-6 py-3 text-xs font-bold shadow-sm transition-colors">
                            <span>Lanjutkan ke Checklist Gejala</span>
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Checklist Gejala -->
                <div x-show="screeningStep === 2" x-transition x-cloak>
                    <h3 class="text-lg font-bold text-slate-900">Centang gejala yang dirasakan saat ini:</h3>
                    <p class="text-sm text-slate-500 mt-1">Silakan centang satu atau lebih kotak di bawah ini.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        <!-- Gejala Ringan -->
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Gejala Ringan/Umum</h4>
                            <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.batuk" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Batuk</span>
                                    <span class="text-xs text-slate-500">Gatal di tenggorokan, kering/berdahak</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.pilek" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Pilek / Hidung Tersumbat</span>
                                    <span class="text-xs text-slate-500">Keluar lendir jernih/kuning kehijauan</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.sakit_tenggorokan" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Nyeri Tenggorokan</span>
                                    <span class="text-xs text-slate-500">Sakit saat menelan makanan/minuman</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.demam" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Demam (Suhu > 38°C)</span>
                                    <span class="text-xs text-slate-500">Badan terasa hangat/menggigil</span>
                                </div>
                            </label>
                        </div>

                        <!-- Gejala Bahaya Utama -->
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold text-rose-500 uppercase tracking-widest">⚠️ Tanda Bahaya Utama</h4>
                            <label class="flex items-start gap-3 rounded-xl border border-rose-100 bg-rose-50/20 p-3 hover:bg-rose-50/50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.sesak_napas" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Sesak Napas / Mengap-mengap</span>
                                    <span class="text-xs text-slate-500">Sulit menarik napas dalam</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 rounded-xl border border-rose-100 bg-rose-50/20 p-3 hover:bg-rose-50/50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.napas_cepat" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Napas Cepat (Takipnea)</span>
                                    <span class="text-xs text-slate-500">
                                        <span x-show="ageGroup === 'balita'">Anak napas > 40x per menit</span>
                                        <span x-show="ageGroup === 'dewasa'">Napas > 20x per menit</span>
                                    </span>
                                </div>
                            </label>
                            <label x-show="ageGroup === 'balita'" class="flex items-start gap-3 rounded-xl border border-rose-100 bg-rose-50/20 p-3 hover:bg-rose-50/50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.tarikan_dinding_dada" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Tarikan Dinding Dada</span>
                                    <span class="text-xs text-slate-500">Dada tampak cekung ke dalam saat menarik napas</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 rounded-xl border border-rose-100 bg-rose-50/20 p-3 hover:bg-rose-50/50 cursor-pointer">
                                <input type="checkbox" x-model="symptoms.kebiruan" class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 block">Bibir atau Kuku Kebiruan</span>
                                    <span class="text-xs text-slate-500">Kurangnya suplai oksigen dalam darah</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Action -->
                    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                        <button @click="screeningStep = 1" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1">
                            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
                        </button>
                        
                        <button 
                            @click="calculateRisk" 
                            class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                            <span>Selesai & Analisis</span>
                            <i data-lucide="check-circle" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Hasil & Rekomendasi -->
                <div x-show="screeningStep === 3" x-transition x-cloak class="text-center max-w-xl mx-auto py-4">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-full mb-4 shadow-md"
                        :class="{
                            'bg-rose-100 text-rose-600': riskLevel === 'Tinggi',
                            'bg-amber-100 text-amber-600': riskLevel === 'Sedang',
                            'bg-emerald-100 text-emerald-600': riskLevel === 'Rendah' || riskLevel === 'Bebas Gejala'
                        }">
                        <i data-lucide="shield-alert" class="h-8 w-8" x-show="riskLevel === 'Tinggi'"></i>
                        <i data-lucide="alert-triangle" class="h-8 w-8" x-show="riskLevel === 'Sedang'"></i>
                        <i data-lucide="heart" class="h-8 w-8" x-show="riskLevel === 'Rendah' || riskLevel === 'Bebas Gejala'"></i>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900">
                        Hasil Analisis: Risiko <span x-text="riskLevel"></span>
                    </h3>
                    
                    <div class="mt-6 rounded-2xl bg-slate-50 border border-slate-100 p-6 text-sm text-left text-slate-700 leading-relaxed shadow-inner">
                        <span x-text="recommendation"></span>
                    </div>

                    <!-- Options after quiz -->
                    <div class="mt-8 flex flex-wrap justify-center gap-3">
                        <button @click="resetScreening" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                            <i data-lucide="refresh-cw" class="h-3.5 w-3.5"></i>
                            <span>Ulangi Skrining</span>
                        </button>
                        
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
