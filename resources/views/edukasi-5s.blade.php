@extends('layouts.app')

@section('title', 'Budaya 5S Jepang')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-indigo-700 to-violet-600 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Digitalisasi Edukasi Budaya 5S Jepang</h1>
        <p class="mt-2 text-indigo-100 max-w-2xl">
            Membangun budaya hidup bersih, tertib, dan disiplin tinggi di rumah, sawah, dan lingkungan kerja melalui prinsip dasar 5S Jepang.
        </p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-16" x-data="{
    score: 0,
    quizDone: false,
    checks: {
        seiri: false,
        seiton: false,
        seiso: false,
        seiketsu: false,
        shitsuke: false
    },
    evaluate5s() {
        let count = 0;
        for (let key in this.checks) {
            if (this.checks[key]) count++;
        }
        this.score = count;
        this.quizDone = true;
    },
    resetQuiz() {
        this.score = 0;
        this.quizDone = false;
        for (let key in this.checks) {
            this.checks[key] = false;
        }
    }
}">

    <!-- Top: Concepts Grid -->
    <div class="space-y-8">
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-xs font-bold uppercase tracking-wider text-brand-green">Lima Pilar Utama</h2>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Konsep Budaya 5S Jepang</p>
            <p class="mt-4 text-slate-600 text-sm">
                Adaptasi budaya kerja industri Jepang untuk memajukan pola kedisiplinan dan kebersihan hidup masyarakat Desa Banyuurip sehari-hari.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach($konsep5s as $k)
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <!-- Icon placeholder depending on index -->
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-700 mb-4 border border-slate-100">
                        <i data-lucide="{{ $loop->first ? 'filter' : ($loop->iteration === 2 ? 'grid' : ($loop->iteration === 3 ? 'sparkles' : ($loop->iteration === 4 ? 'shield-check' : 'user-check'))) }}" class="h-5 w-5"></i>
                    </div>
                    
                    <h3 class="font-extrabold text-slate-900 text-base leading-snug">{{ $k['kunci'] }}</h3>
                    <span class="text-xs font-semibold text-slate-400 block mt-1 leading-tight">{{ $k['arti'] }}</span>
                    
                    <p class="text-xs text-slate-600 mt-4 leading-relaxed">
                        {{ $k['penjelasan'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bottom: Interactive self-assessment quiz -->
    <div class="border-t border-slate-200 pt-16">
        <div class="rounded-2xl bg-white shadow-sm border border-slate-100 overflow-hidden max-w-2xl mx-auto">
            <!-- Quiz Header -->
            <div class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="help-circle" class="h-5 w-5 text-indigo-500"></i>
                    <span class="font-bold text-sm">Uji Mandiri Kebersihan & Disiplin (5S)</span>
                </div>
                <span class="text-xs text-slate-400">Pola Hidup Bersih & Sehat</span>
            </div>

            <!-- Quiz Content -->
            <div class="p-8">
                <div x-show="!quizDone" class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-900">Jawab sejujurnya perilaku harian Anda di bawah ini:</h3>
                    
                    <!-- Q1 Seiri -->
                    <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" x-model="checks.seiri" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="text-sm font-bold text-slate-900 block">1. Seiri (Ringkas)</span>
                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda memisahkan perkakas pertanian/rumah tangga yang sudah rusak dari yang masih berfungsi, lalu membuang barang yang tidak lagi terpakai?</span>
                        </div>
                    </label>

                    <!-- Q2 Seiton -->
                    <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" x-model="checks.seiton" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="text-sm font-bold text-slate-900 block">2. Seiton (Rapi)</span>
                            <span class="text-xs text-slate-500 block mt-0.5">Apakah cangkul, pupuk, benih, atau berkas administrasi rumah tangga ditata rapi pada tempatnya dan diberi label agar mudah dicari?</span>
                        </div>
                    </label>

                    <!-- Q3 Seiso -->
                    <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" x-model="checks.seiso" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="text-sm font-bold text-slate-900 block">3. Seiso (Resik)</span>
                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda menyapu rumah setiap hari, mencuci tangan dengan sabun, dan ikut serta menjaga kebersihan parit/jalan depan rumah?</span>
                        </div>
                    </label>

                    <!-- Q4 Seiketsu -->
                    <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" x-model="checks.seiketsu" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="text-sm font-bold text-slate-900 block">4. Seiketsu (Rawat)</span>
                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda konsisten menjaga kebersihan di atas dan menjadikannya kebiasaan rutin yang terstandardisasi (misalnya jadwal pembersihan rutin)?</span>
                        </div>
                    </label>

                    <!-- Q5 Shitsuke -->
                    <label class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                        <input type="checkbox" x-model="checks.shitsuke" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="text-sm font-bold text-slate-900 block">5. Shitsuke (Rajin)</span>
                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda disiplin membuang sampah pada tempatnya, menaati peraturan desa, serta menghormati sesama tanpa harus diperingatkan?</span>
                        </div>
                    </label>

                    <!-- Submit -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                        <button 
                            @click="evaluate5s"
                            class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                            <span>Selesai & Evaluasi</span>
                            <i data-lucide="check-circle" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Score / Result Page -->
                <div x-show="quizDone" class="text-center max-w-md mx-auto py-6" x-transition x-cloak>
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-full mb-6 text-white font-extrabold text-2xl shadow-lg"
                        :class="{
                            'bg-emerald-500 shadow-emerald-500/20': score === 5,
                            'bg-indigo-500 shadow-indigo-500/20': score >= 3 && score <= 4,
                            'bg-amber-500 shadow-amber-500/20': score <= 2
                        }">
                        <span x-text="score * 20"></span>%
                    </div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Evaluasi: 
                        <span x-show="score === 5">Sangat Disiplin (Master 5S! 🌟)</span>
                        <span x-show="score >= 3 && score <= 4">Cukup Bersih & Tertib (Bagus! 👍)</span>
                        <span x-show="score <= 2">Perlu Pembenahan Diri (Ayo Berubah! 💪)</span>
                    </h3>

                    <div class="mt-4 rounded-xl bg-slate-50 p-4 text-xs text-slate-600 leading-relaxed border border-slate-100 text-left">
                        <span x-show="score === 5">
                            Hebat sekali! Anda telah konsisten mempraktikkan konsep Ringkas, Rapi, Resik, Rawat, dan Rajin dalam kehidupan sehari-hari. Anda adalah contoh teladan warga Desa Banyuurip!
                        </span>
                        <span x-show="score >= 3 && score <= 4">
                            Sangat baik. Kebiasaan menjaga kebersihan dan kerapian sudah berjalan, namun masih ada beberapa aspek seperti standardisasi (Rawat) atau pemeliharaan (Rajin) yang perlu ditingkatkan secara konsisten.
                        </span>
                        <span x-show="score <= 2">
                            Jangan berkecil hati. Mari jadikan hari ini sebagai awal pembiasaan hidup sehat. Cobalah untuk memulainya dengan membuang barang yang tidak diperlukan (Seiri) dan menaruh alat penunjang hidup/tani pada wadah yang tepat (Seiton).
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <button @click="resetQuiz" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                            <i data-lucide="refresh-cw" class="h-3.5 w-3.5"></i>
                            <span>Ulangi Evaluasi</span>
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
