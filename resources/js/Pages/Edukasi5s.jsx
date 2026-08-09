import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    Filter, 
    Grid, 
    Sparkles, 
    ShieldCheck, 
    UserCheck, 
    HelpCircle, 
    CheckCircle, 
    RefreshCw 
} from 'lucide-react';

export default function Edukasi5s({ konsep5s }) {
    const [score, setScore] = useState(0);
    const [quizDone, setQuizDone] = useState(false);
    const [checks, setChecks] = useState({
        seiri: false,
        seiton: false,
        seiso: false,
        seiketsu: false,
        shitsuke: false,
    });

    const iconMap = [Filter, Grid, Sparkles, ShieldCheck, UserCheck];

    const toggleCheck = (key) => {
        setChecks(prev => ({ ...prev, [key]: !prev[key] }));
    };

    const evaluate5s = () => {
        let count = 0;
        Object.keys(checks).forEach(k => {
            if (checks[k]) count++;
        });
        setScore(count);
        setQuizDone(true);
    };

    const resetQuiz = () => {
        setScore(0);
        setQuizDone(false);
        setChecks({
            seiri: false,
            seiton: false,
            seiso: false,
            seiketsu: false,
            shitsuke: false,
        });
    };

    return (
        <MainLayout>
            <Head title="Budaya 5S Jepang" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.2),transparent_60%)] animate-pulse-glow"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Sparkles class="h-3.5 w-3.5" />
                        Program Kebudayaan & Kedisiplinan Kerja
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl">Digitalisasi Budaya 5S Jepang</h1>
                    <p class="mt-3 text-sky-100/90 max-w-2xl text-base leading-relaxed">
                        Penerapan prinsip Seiri, Seiton, Seiso, Seiketsu, dan Shitsuke untuk peningkatan kedisiplinan & kebersihan lingkungan kerja kantor desa.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 space-y-16">
                {/* Concepts Grid */}
                <div class="space-y-8">
                    <div class="text-center max-w-3xl mx-auto">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-emerald-700">Lima Pilar Utama</h2>
                        <p class="mt-2 text-3xl font-extrabold text-slate-900 leading-tight">Konsep Budaya 5S Jepang</p>
                        <p class="mt-4 text-slate-600 text-sm">
                            Adaptasi budaya kerja industri Jepang untuk memajukan pola kedisiplinan dan kebersihan hidup masyarakat Desa Banyuurip sehari-hari.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        {konsep5s.map((k, idx) => {
                            const IconComp = iconMap[idx] || Filter;
                            return (
                                <div key={idx} class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                                    <div>
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-700 mb-4 border border-slate-100">
                                            <IconComp class="h-5 w-5" />
                                        </div>
                                        
                                        <h3 class="font-extrabold text-slate-900 text-base leading-snug">{k.kunci}</h3>
                                        <span class="text-xs font-semibold text-slate-400 block mt-1 leading-tight">{k.arti}</span>
                                        
                                        <p class="text-xs text-slate-600 mt-4 leading-relaxed">
                                            {k.penjelasan}
                                        </p>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>

                {/* Self Assessment Quiz */}
                <div class="border-t border-slate-200 pt-16">
                    <div class="rounded-2xl bg-white shadow-sm border border-slate-100 overflow-hidden max-w-2xl mx-auto">
                        <div class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <HelpCircle class="h-5 w-5 text-indigo-500" />
                                <span class="font-bold text-sm">Uji Mandiri Kebersihan & Disiplin (5S)</span>
                            </div>
                            <span class="text-xs text-slate-400">Pola Hidup Bersih & Sehat</span>
                        </div>

                        <div class="p-8">
                            {!quizDone ? (
                                <div class="space-y-4">
                                    <h3 class="text-sm font-bold text-slate-900">Jawab sejujurnya perilaku harian Anda di bawah ini:</h3>
                                    
                                    {/* Q1 Seiri */}
                                    <label onClick={() => toggleCheck('seiri')} class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                                        <input type="checkbox" checked={checks.seiri} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                                        <div>
                                            <span class="text-sm font-bold text-slate-900 block">1. Seiri (Ringkas)</span>
                                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda memisahkan perkakas pertanian/rumah tangga yang sudah rusak dari yang masih berfungsi, lalu membuang barang yang tidak lagi terpakai?</span>
                                        </div>
                                    </label>

                                    {/* Q2 Seiton */}
                                    <label onClick={() => toggleCheck('seiton')} class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                                        <input type="checkbox" checked={checks.seiton} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                                        <div>
                                            <span class="text-sm font-bold text-slate-900 block">2. Seiton (Rapi)</span>
                                            <span class="text-xs text-slate-500 block mt-0.5">Apakah cangkul, pupuk, benih, atau berkas administrasi rumah tangga ditata rapi pada tempatnya dan diberi label agar mudah dicari?</span>
                                        </div>
                                    </label>

                                    {/* Q3 Seiso */}
                                    <label onClick={() => toggleCheck('seiso')} class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                                        <input type="checkbox" checked={checks.seiso} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                                        <div>
                                            <span class="text-sm font-bold text-slate-900 block">3. Seiso (Resik)</span>
                                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda menyapu rumah setiap hari, mencuci tangan dengan sabun, dan ikut serta menjaga kebersihan parit/jalan depan rumah?</span>
                                        </div>
                                    </label>

                                    {/* Q4 Seiketsu */}
                                    <label onClick={() => toggleCheck('seiketsu')} class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                                        <input type="checkbox" checked={checks.seiketsu} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                                        <div>
                                            <span class="text-sm font-bold text-slate-900 block">4. Seiketsu (Rawat)</span>
                                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda konsisten menjaga kebersihan di atas dan menjadikannya kebiasaan rutin yang terstandardisasi (misalnya jadwal pembersihan rutin)?</span>
                                        </div>
                                    </label>

                                    {/* Q5 Shitsuke */}
                                    <label onClick={() => toggleCheck('shitsuke')} class="flex items-start gap-3 rounded-xl border border-slate-100 p-3.5 hover:bg-slate-50 cursor-pointer">
                                        <input type="checkbox" checked={checks.shitsuke} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                                        <div>
                                            <span class="text-sm font-bold text-slate-900 block">5. Shitsuke (Rajin)</span>
                                            <span class="text-xs text-slate-500 block mt-0.5">Apakah Anda disiplin membuang sampah pada tempatnya, menaati peraturan desa, serta menghormati sesama tanpa harus diperingatkan?</span>
                                        </div>
                                    </label>

                                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                                        <button 
                                            onClick={evaluate5s}
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors"
                                        >
                                            <span>Selesai & Evaluasi</span>
                                            <CheckCircle class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>
                            ) : (
                                <div class="text-center max-w-md mx-auto py-6">
                                    <div class={`inline-flex h-20 w-20 items-center justify-center rounded-full mb-6 text-white font-extrabold text-2xl shadow-lg ${
                                        score === 5 ? 'bg-emerald-500 shadow-emerald-500/20' :
                                        score >= 3 ? 'bg-indigo-500 shadow-indigo-500/20' : 'bg-amber-500 shadow-amber-500/20'
                                    }`}>
                                        <span>{score * 20}%</span>
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-900">
                                        Evaluasi: {' '}
                                        {score === 5 && 'Sangat Disiplin (Master 5S! 🌟)'}
                                        {score >= 3 && score <= 4 && 'Cukup Bersih & Tertib (Bagus! 👍)'}
                                        {score <= 2 && 'Perlu Pembenahan Diri (Ayo Berubah! 💪)'}
                                    </h3>

                                    <div class="mt-4 rounded-xl bg-slate-50 p-4 text-xs text-slate-600 leading-relaxed border border-slate-100 text-left">
                                        {score === 5 && 'Hebat sekali! Anda telah konsisten mempraktikkan konsep Ringkas, Rapi, Resik, Rawat, dan Rajin dalam kehidupan sehari-hari. Anda adalah contoh teladan warga Desa Banyuurip!'}
                                        {score >= 3 && score <= 4 && 'Sangat baik. Kebiasaan menjaga kebersihan dan kerapian sudah berjalan, namun masih ada beberapa aspek seperti standardisasi (Rawat) atau pemeliharaan (Rajin) yang perlu ditingkatkan secara konsisten.'}
                                        {score <= 2 && 'Jangan berkecil hati. Mari jadikan hari ini sebagai awal pembiasaan hidup sehat. Cobalah untuk memulainya dengan membuang barang yang tidak diperlukan (Seiri) dan menaruh alat penunjang hidup/tani pada wadah yang tepat (Seiton).'}
                                    </div>

                                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                                        <button onClick={resetQuiz} class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition-colors">
                                            <RefreshCw class="h-3.5 w-3.5" />
                                            <span>Ulangi Evaluasi</span>
                                        </button>
                                        
                                        <Link href="/" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 px-5 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                            Kembali ke Beranda
                                        </Link>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
