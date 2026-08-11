import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    BookOpen, 
    ChevronRight, 
    Info, 
    Stethoscope, 
    ArrowRight, 
    ArrowLeft, 
    CheckCircle, 
    ShieldAlert, 
    AlertTriangle, 
    Heart, 
    RefreshCw, 
    Activity 
} from 'lucide-react';

export default function Kesehatan({ ebook_chapters }) {
    const [selectedTab, setSelectedTab] = useState('pengertian');
    const [screeningStep, setScreeningStep] = useState(1);
    const [wargaName, setWargaName] = useState('');
    const [wargaUsia, setWargaUsia] = useState('');
    const [ageGroup, setAgeGroup] = useState('dewasa');
    
    const [symptoms, setSymptoms] = useState({
        batuk: false,
        pilek: false,
        demam: false,
        sakit_tenggorokan: false,
        sesak_napas: false,
        napas_cepat: false,
        tarikan_dinding_dada: false,
        kebiruan: false,
    });

    const [riskLevel, setRiskLevel] = useState('');
    const [recommendation, setRecommendation] = useState('');

    const toggleSymptom = (key) => {
        setSymptoms(prev => ({ ...prev, [key]: !prev[key] }));
    };

    const resetScreening = () => {
        setScreeningStep(1);
        setWargaName('');
        setWargaUsia('');
        setAgeGroup('dewasa');
        setSymptoms({
            batuk: false,
            pilek: false,
            demam: false,
            sakit_tenggorokan: false,
            sesak_napas: false,
            napas_cepat: false,
            tarikan_dinding_dada: false,
            kebiruan: false,
        });
        setRiskLevel('');
        setRecommendation('');
    };

    const calculateRisk = () => {
        const ageNum = parseInt(wargaUsia) || 0;
        const currentAgeGroup = ageNum <= 5 ? 'balita' : 'dewasa';
        setAgeGroup(currentAgeGroup);

        const hasCriticalSign = symptoms.sesak_napas || symptoms.napas_cepat || symptoms.tarikan_dinding_dada || symptoms.kebiruan;
        const hasModerateSign = symptoms.demam && (symptoms.batuk || symptoms.pilek || symptoms.sakit_tenggorokan);
        const hasMildSign = symptoms.batuk || symptoms.pilek || symptoms.sakit_tenggorokan;

        let level = '';
        let rec = '';

        if (hasCriticalSign) {
            level = 'Tinggi';
            rec = '⚠️ Tanda Bahaya Terdeteksi! Penderita menunjukkan gejala sesak napas atau tarikan dinding dada. Segera bawa penderita ke Puskesmas Klego atau rumah sakit terdekat untuk pemeriksaan medis intensif. Jangan menunda penanganan!';
        } else if (hasModerateSign) {
            level = 'Sedang';
            rec = '⚠️ Gejala Sedang. Terdeteksi infeksi aktif dengan demam. Disarankan untuk beristirahat total, minum banyak air hangat, mengonsumsi makanan bergizi, dan minum obat penurun demam sesuai dosis. Jika demam berlanjut lebih dari 3 hari, hubungi dokter/bidan desa terdekat.';
        } else if (hasMildSign) {
            level = 'Rendah';
            rec = '✅ Gejala Ringan. Kondisi saat ini mengarah pada infeksi saluran pernapasan ringan (selesma/flu biasa). Disarankan istirahat yang cukup, jaga kebersihan tangan, konsumsi vitamin C, serta hindari paparan asap rokok dan debu pertanian.';
        } else {
            level = 'Bebas Gejala';
            rec = '✅ Kondisi Sehat. Tidak ada gejala ISPA yang terdeteksi saat ini. Tetap pertahankan pola hidup bersih dan sehat (PHBS) serta gunakan masker saat berada di luar rumah atau di area peternakan yang berdebu.';
        }

        setRiskLevel(level);
        setRecommendation(rec);

        // POST to Laravel backend
        fetch('/kesehatan/skrining', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({
                nama_warga: wargaName || 'Anonim',
                usia: ageNum,
                risiko: level,
                gejala: symptoms,
                rekomendasi: rec
            })
        }).catch(err => console.log('Store screening:', err));

        setScreeningStep(3);
    };

    const chapters = ebook_chapters || [];
    const activeChapter = chapters.find(c => c.id === selectedTab) || chapters[0] || {
        bab: 'Bab 1',
        judul: 'Pengertian ISPA',
        konten: 'Infeksi Saluran Pernapasan Akut (ISPA) adalah infeksi yang menyerang salah satu bagian atau lebih dari saluran napas.'
    };

    return (
        <MainLayout>
            <Head title="Pusat Kesehatan & Skrining ISPA (RESPIRA)" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.2),transparent_60%)] animate-pulse-glow"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Activity class="h-3.5 w-3.5" />
                        Program Kesehatan Keperawatan
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight lg:text-5xl">Pusat Layanan Kesehatan RESPIRA</h1>
                    <p class="mt-3 text-sky-100/90 max-w-2xl text-base leading-relaxed">
                        Modul edukasi terintegrasi <strong>E-Book RESPIRA</strong> dan aplikasi <strong>Skrining Mandiri ISPA</strong> untuk pencegahan infeksi saluran pernapasan akut Warga Banyuurip.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 space-y-20">
                {/* Top Grid: Interactive E-Book */}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    {/* Left: E-Book Nav */}
                    <div class="lg:col-span-4 space-y-4">
                        <div class="rounded-3xl bg-white p-6 shadow-sm border border-sky-100 banyu-hover-card">
                            <div class="flex items-center gap-3 text-sky-700 font-extrabold text-lg mb-6">
                                <BookOpen class="h-6 w-6" />
                                <span>E-Book RESPIRA</span>
                            </div>
                            <div class="flex flex-col gap-2">
                                {chapters.map(ch => (
                                    <button
                                        key={ch.id}
                                        onClick={() => setSelectedTab(ch.id)}
                                        class={`w-full text-left px-4 py-3 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between cursor-pointer ${
                                            selectedTab === ch.id ? 'bg-sky-600 text-white border-sky-600 shadow-md shadow-sky-600/20' : 'text-slate-600 hover:bg-sky-50 border-transparent'
                                        }`}
                                    >
                                        <span>{ch.bab}</span>
                                        <ChevronRight class="h-4 w-4 opacity-70" />
                                    </button>
                                ))}
                            </div>
                        </div>
                        
                        <div class="rounded-3xl bg-sky-50 p-6 border border-sky-200">
                            <h3 class="font-extrabold text-sky-900 flex items-center gap-2 text-xs uppercase tracking-wider">
                                <Info class="h-4 w-4 text-sky-600" />
                                Fakta Kesehatan ISPA
                            </h3>
                            <p class="text-xs text-sky-800 mt-2 leading-relaxed">
                                ISPA menyumbang angka kunjungan tertinggi pada fasilitas kesehatan dasar. Edukasi dini mengenai faktor risiko kandang ternak & debu pertanian sangat krusial bagi warga Desa Banyuurip.
                            </p>
                        </div>
                    </div>

                    {/* Right: Chapter Content */}
                    <div class="lg:col-span-8">
                        <div class="rounded-3xl bg-white p-8 sm:p-10 shadow-sm border border-sky-100 min-h-[360px] flex flex-col justify-between banyu-hover-card">
                            <div>
                                <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full">{activeChapter.bab}</span>
                                <h2 class="mt-4 text-2xl font-extrabold text-slate-900 leading-tight border-b border-sky-100 pb-4">{activeChapter.judul}</h2>
                                <div 
                                    class="mt-6 text-slate-700 text-sm leading-relaxed space-y-4"
                                    dangerouslySetInnerHTML={{ __html: activeChapter.konten }}
                                />
                            </div>

                            <div class="mt-8 border-t border-sky-100 pt-4 flex items-center justify-between text-xs font-bold text-slate-400">
                                <span>Sumber: Pedoman Kementerian Kesehatan RI</span>
                                <span>Layanan Kesehatan Desa Banyuurip</span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Bottom: Interactive Screening Tool */}
                <div class="border-t border-sky-100 pt-16">
                    <div class="rounded-3xl bg-white shadow-xl border border-sky-100 overflow-hidden max-w-3xl mx-auto banyu-hover-card">
                        <div class="bg-gradient-to-r from-slate-950 to-sky-950 text-white px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <Stethoscope class="h-5 w-5 text-sky-400" />
                                <span class="font-extrabold text-sm">Aplikasi Skrining Mandiri ISPA</span>
                            </div>
                            <span class="text-xs font-extrabold text-sky-300 bg-sky-900/60 px-3 py-1 rounded-full border border-sky-700">Langkah {screeningStep} dari 3</span>
                        </div>

                        <div class="p-8">
                            {/* Step 1 */}
                            {screeningStep === 1 && (
                                <div class="max-w-md mx-auto space-y-5">
                                    <h3 class="text-xl font-extrabold text-slate-900 text-center">Masukkan Informasi Warga</h3>
                                    <p class="text-xs text-slate-500 text-center">Data ini digunakan untuk mendeteksi dini kategori risiko ISPA secara akurat.</p>
                                    
                                    <div class="space-y-4 mt-6">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">Nama Lengkap Warga</label>
                                            <input 
                                                type="text" 
                                                value={wargaName}
                                                onChange={(e) => setWargaName(e.target.value)}
                                                placeholder="Contoh: Budi Santoso" 
                                                class="block w-full rounded-xl border border-sky-200 bg-white py-3 px-4 text-sm focus:border-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500/20" 
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">Usia (Tahun)</label>
                                            <input 
                                                type="number" 
                                                value={wargaUsia}
                                                onChange={(e) => setWargaUsia(e.target.value)}
                                                placeholder="Contoh: 28 atau 3" 
                                                class="block w-full rounded-xl border border-sky-200 bg-white py-3 px-4 text-sm focus:border-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500/20" 
                                            />
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 flex justify-center">
                                        <button 
                                            onClick={() => {
                                                if (wargaName && wargaUsia) {
                                                    setScreeningStep(2);
                                                    setAgeGroup(parseInt(wargaUsia) <= 5 ? 'balita' : 'dewasa');
                                                }
                                            }}
                                            disabled={!wargaName || !wargaUsia}
                                            class={`inline-flex items-center gap-2 rounded-xl px-6 py-3.5 text-xs font-bold shadow-md transition-all cursor-pointer ${
                                                wargaName && wargaUsia ? 'bg-gradient-to-r from-sky-600 to-blue-600 text-white hover:scale-105' : 'bg-slate-100 text-slate-400 cursor-not-allowed'
                                            }`}
                                        >
                                            <span>Lanjutkan ke Checklist Gejala</span>
                                            <ArrowRight class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>
                            )}

                            {/* Step 2 */}
                            {screeningStep === 2 && (
                                <div>
                                    <h3 class="text-lg font-extrabold text-slate-900">Centang gejala yang dirasakan saat ini:</h3>
                                    <p class="text-xs text-slate-500 mt-1">Silakan centang satu atau lebih gejala yang dialami.</p>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                                        <div class="space-y-3">
                                            <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Gejala Ringan/Umum</h4>
                                            <label onClick={() => toggleSymptom('batuk')} class="flex items-start gap-3 rounded-2xl border border-sky-100 p-3.5 hover:bg-sky-50 cursor-pointer transition-colors">
                                                <input type="checkbox" checked={symptoms.batuk} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Batuk</span>
                                                    <span class="text-xs text-slate-500">Gatal di tenggorokan, kering/berdahak</span>
                                                </div>
                                            </label>
                                            <label onClick={() => toggleSymptom('pilek')} class="flex items-start gap-3 rounded-2xl border border-sky-100 p-3.5 hover:bg-sky-50 cursor-pointer transition-colors">
                                                <input type="checkbox" checked={symptoms.pilek} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Pilek / Hidung Tersumbat</span>
                                                    <span class="text-xs text-slate-500">Keluar lendir jernih/kuning kehijauan</span>
                                                </div>
                                            </label>
                                            <label onClick={() => toggleSymptom('sakit_tenggorokan')} class="flex items-start gap-3 rounded-2xl border border-sky-100 p-3.5 hover:bg-sky-50 cursor-pointer transition-colors">
                                                <input type="checkbox" checked={symptoms.sakit_tenggorokan} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Nyeri Tenggorokan</span>
                                                    <span class="text-xs text-slate-500">Sakit saat menelan makanan/minuman</span>
                                                </div>
                                            </label>
                                            <label onClick={() => toggleSymptom('demam')} class="flex items-start gap-3 rounded-2xl border border-sky-100 p-3.5 hover:bg-sky-50 cursor-pointer transition-colors">
                                                <input type="checkbox" checked={symptoms.demam} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Demam (Suhu {'>'} 38°C)</span>
                                                    <span class="text-xs text-slate-500">Badan terasa hangat/menggigil</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="space-y-3">
                                            <h4 class="text-xs font-extrabold text-rose-600 uppercase tracking-widest">⚠️ Tanda Bahaya Utama</h4>
                                            <label onClick={() => toggleSymptom('sesak_napas')} class="flex items-start gap-3 rounded-2xl border border-rose-100 bg-rose-50/40 p-3.5 hover:bg-rose-50 cursor-pointer transition-colors">
                                                <input type="checkbox" checked={symptoms.sesak_napas} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500" />
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Sesak Napas / Mengap-mengap</span>
                                                    <span class="text-xs text-slate-500">Sulit menarik napas dalam</span>
                                                </div>
                                            </label>
                                            <label onClick={() => toggleSymptom('napas_cepat')} class="flex items-start gap-3 rounded-2xl border border-rose-100 bg-rose-50/40 p-3.5 hover:bg-rose-50 cursor-pointer transition-colors">
                                                <input type="checkbox" checked={symptoms.napas_cepat} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500" />
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Napas Cepat (Takipnea)</span>
                                                    <span class="text-xs text-slate-500">
                                                        {ageGroup === 'balita' ? 'Anak napas > 40x per menit' : 'Napas > 20x per menit'}
                                                    </span>
                                                </div>
                                            </label>
                                            {ageGroup === 'balita' && (
                                                <label onClick={() => toggleSymptom('tarikan_dinding_dada')} class="flex items-start gap-3 rounded-2xl border border-rose-100 bg-rose-50/40 p-3.5 hover:bg-rose-50 cursor-pointer transition-colors">
                                                    <input type="checkbox" checked={symptoms.tarikan_dinding_dada} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500" />
                                                    <div>
                                                        <span class="text-sm font-bold text-slate-900 block">Tarikan Dinding Dada</span>
                                                        <span class="text-xs text-slate-500">Dada tampak cekung ke dalam saat bernapas</span>
                                                    </div>
                                                </label>
                                            )}
                                            <label onClick={() => toggleSymptom('kebiruan')} class="flex items-start gap-3 rounded-2xl border border-rose-100 bg-rose-50/40 p-3.5 hover:bg-rose-50 cursor-pointer transition-colors">
                                                <input type="checkbox" checked={symptoms.kebiruan} readOnly class="mt-1 h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500" />
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Bibir atau Kuku Kebiruan</span>
                                                    <span class="text-xs text-slate-500">Kurangnya suplai oksigen dalam darah</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mt-8 pt-6 border-t border-sky-100 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                                        <button onClick={() => setScreeningStep(1)} class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1 cursor-pointer">
                                            <ArrowLeft class="h-4 w-4" /> Kembali
                                        </button>
                                        
                                        <button 
                                            onClick={calculateRisk} 
                                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 px-6 py-2.5 text-xs font-bold text-white shadow-md hover:scale-105 transition-all cursor-pointer"
                                        >
                                            <span>Selesai & Analisis Risiko</span>
                                            <CheckCircle class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>
                            )}

                            {/* Step 3 */}
                            {screeningStep === 3 && (
                                <div class="text-center max-w-xl mx-auto py-4">
                                    <div class={`inline-flex h-16 w-16 items-center justify-center rounded-full mb-4 shadow-lg ${
                                        riskLevel === 'Tinggi' ? 'bg-rose-100 text-rose-600' :
                                        riskLevel === 'Sedang' ? 'bg-amber-100 text-amber-600' : 'bg-sky-100 text-sky-700'
                                    }`}>
                                        {riskLevel === 'Tinggi' && <ShieldAlert class="h-8 w-8" />}
                                        {riskLevel === 'Sedang' && <AlertTriangle class="h-8 w-8" />}
                                        {(riskLevel === 'Rendah' || riskLevel === 'Bebas Gejala') && <Heart class="h-8 w-8" />}
                                    </div>

                                    <h3 class="text-xl font-extrabold text-slate-900">
                                        Hasil Analisis: Risiko <span class={riskLevel === 'Tinggi' ? 'text-rose-600' : 'text-sky-700'}>{riskLevel}</span>
                                    </h3>
                                    
                                    <div class="mt-6 rounded-2xl bg-sky-50/60 border border-sky-100 p-6 text-sm text-left text-slate-700 leading-relaxed shadow-inner">
                                        <span>{recommendation}</span>
                                    </div>

                                    <div class="mt-8 flex flex-wrap justify-center gap-3">
                                        <button onClick={resetScreening} class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 px-5 py-2.5 text-xs font-bold text-white shadow-md hover:scale-105 transition-all cursor-pointer">
                                            <RefreshCw class="h-3.5 w-3.5" />
                                            <span>Ulangi Skrining Mandiri</span>
                                        </button>
                                        
                                        <Link href="/" class="inline-flex items-center gap-1.5 rounded-xl border border-sky-200 px-5 py-2.5 text-xs font-bold text-sky-800 hover:bg-sky-50 transition-colors">
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
