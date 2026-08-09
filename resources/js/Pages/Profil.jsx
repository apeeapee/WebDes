import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    Check, 
    User, 
    Phone, 
    Compass, 
    Sparkles, 
    BookOpen, 
    Scroll, 
    Landmark, 
    CheckCircle2, 
    History, 
    Users, 
    ChevronDown, 
    ChevronUp 
} from 'lucide-react';

export default function Profil({ sejarah, perangkat }) {
    const [openFaq, setOpenFaq] = useState(null);

    const toggleFaq = (idx) => {
        setOpenFaq(openFaq === idx ? null : idx);
    };

    const fungsiDesaList = [
        { title: 'Pemasok Kebutuhan (Hinterland)', desc: 'Desa berfungsi sebagai hinterland yang memasok kebutuhan pangan dan bahan baku bagi kota.' },
        { title: 'Mitra Pembangunan Kota', desc: 'Desa adalah mitra yang saling mendukung dalam proses pertumbuhan dan pembangunan kawasan kota.' },
        { title: 'Pemerintahan Terkecil NKRI', desc: 'Desa merupakan bentuk tata kelola pemerintahan terkecil yang berdaulat di wilayah NKRI.' },
        { title: 'Sumber Tenaga Kerja', desc: 'Desa menyediakan sumber daya manusia dan tenaga kerja potensial bagi pembangunan perkotaan.' },
    ];

    const ciriMasyarakatList = [
        'Pembagian waktu yang lebih teliti dan sangat penting, untuk bisa mengejar kebutuhan individu.',
        'Penduduk di desa cenderung saling tolong menolong karena adanya rasa kebersamaan yang tinggi.',
        'Pembagian kerja antar penduduk desa cenderung membaur dan tidak memiliki batasan yang jelas.',
        'Penduduk desa cenderung mengerjakan pekerjaan yang sama seperti anggota keluarganya terdahulu.',
        'Kehidupan keagamaan di desa lebih kuat jika dibandingkan dengan perkotaan.',
        'Perubahan-perubahan sosial cenderung terjadi lebih lambat, tergantung pada keterbukaan masyarakat desa dalam menerima pengaruh dari adat istiadat setempat.',
        'Kreatifitas dan inovasi cenderung belum diimplementasikan jika penduduk desa tidak mencaritahu informasi terkini tentang perkembangan zaman dan teknologi.',
        'Interaksi banyak terjadi berdasarkan pada faktor kepentingan bersama daripada faktor kepentingan pribadi.'
    ];

    const ahliList = [
        { nama: 'R. Bintarto', definisi: 'Desa yaitu perwujudan atau kesatuan sosial, ekonomi, geografi, politik, serta kultural yang ada di suatu daerah dalam hubungan dan pengaruhnya secara timbal balik dengan daerah lain.' },
        { nama: 'Rifhi Siddiq', definisi: 'Desa adalah suatu wilayah yang memiliki tingkat kepadatan rendah yang dihuni oleh penduduk dengan interaksi sosial yang bersifat homogen, bermatapencaharian di bidang agraris dan juga mampu berinteraksi dengan wilayah lain di sekitarnya.' },
        { nama: 'Sutardjo Kartohadikusumo', definisi: 'Desa adalah suatu kesatuan hukum yang di dalamnya bertempat tinggal sekelompok masyarakat yang berkuasa mengadakan pemerintahan sendiri.' },
        { nama: 'Paul H. Landis', definisi: 'Desa adalah daerah dimana hubungan pergaulannya ditandai dengan intensitas tinggi dengan jumlah penduduk yang kurang dari 2.500 orang.' }
    ];

    return (
        <MainLayout>
            <Head title="Profil, Sejarah & Keilmuan Perdesaan - Desa Banyuurip" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(56,189,248,0.2),transparent_60%)] animate-pulse-glow"></div>
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Compass class="h-3.5 w-3.5" />
                        Monografi & Historiografi Desa
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl">Profil, Sejarah & Visi Misi Desa</h1>
                    <p class="mt-3 text-sky-100/90 max-w-3xl text-base leading-relaxed">
                        Dokumentasi historiografi asal-usul nama *Banyuurip*, kisah perjuangan Eyang Sumendhi Amijaya & peristiwa *Mur Genthong*, visi-misi tata kelola desa, serta kajian keilmuan perdesaan.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 space-y-24">
                
                {/* 1. Visi & Misi Resmi Section */}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
                    <div class="lg:col-span-1">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Landasan Kebijakan</span>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 leading-tight">Visi & Misi Desa</h2>
                        <p class="mt-4 text-slate-600 leading-relaxed text-sm">
                            Penyusunan Visi Desa Banyuurip dilakukan melalui pendekatan partisipatif dengan melibatkan Pemerintah Desa, BPD, Tokoh Masyarakat, Tokoh Agama, serta kelembagaan warga Banyuurip secara menyeluruh.
                        </p>
                    </div>
                    
                    <div class="lg:col-span-2 space-y-6">
                        {/* Visi Card */}
                        <div class="rounded-3xl bg-gradient-to-br from-sky-900 via-blue-900 to-slate-900 p-8 text-white shadow-xl border border-sky-400/30 relative overflow-hidden banyu-hover-card">
                            <span class="block text-xs font-extrabold text-sky-300 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <Sparkles class="h-4 w-4 text-sky-400" /> VISI DESA BANYUURIP
                            </span>
                            <p class="text-2xl font-black text-white leading-snug tracking-tight">
                                “MENUJU BANYUURIP YANG TRANSPARAN, AKUNTABEL, DAN SEPENUH HATI DALAM PELAYANAN”
                            </p>
                        </div>
                        
                        {/* Misi Card */}
                        <div class="rounded-3xl bg-white p-8 shadow-sm border border-sky-100 space-y-6 banyu-hover-card">
                            <span class="block text-xs font-extrabold text-sky-700 uppercase tracking-widest">LIMA MISI UTAMA DESA BANYUURIP</span>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700 text-xs font-extrabold shadow-xs">1</span>
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        <strong class="text-slate-900">Pelayanan Kejujuran & Musyawarah:</strong> Mengedepankan Pelayanan dengan Kejujuran dan Musyawarah Mufakat dalam setiap kegiatan, baik dengan Aparatur Desa maupun Masyarakat Desa Banyuurip.
                                    </p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700 text-xs font-extrabold shadow-xs">2</span>
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        <strong class="text-slate-900">Profesionalitas Aparatur:</strong> Meningkatkan profesionalitas dan melakukan renovasi sistem kerja aparatur Desa guna meningkatkan kualitas pelayanan kepada masyarakat.
                                    </p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700 text-xs font-extrabold shadow-xs">3</span>
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        <strong class="text-slate-900">Pemerintahan Bersih & Bebas Penyelewengan:</strong> Mendengar, Menampung, Menerima, dan Melaksanakan aspirasi Masyarakat untuk mewujudkan pemerintahan yang bersih, jujur, adil, dan terhindar dari segala bentuk penyelewengan.
                                    </p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700 text-xs font-extrabold shadow-xs">4</span>
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        <strong class="text-slate-900">Paradigma Pembangunan Multisektoral:</strong> Melaksanakan Pembangunan dengan paradigma baru, yaitu pembangunan tidak hanya di bidang sarana prasarana tetapi juga pembangunan dibidang Ekonomi, Sosial, Budaya, serta Kesehatan.
                                    </p>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700 text-xs font-extrabold shadow-xs">5</span>
                                    <p class="text-sm text-slate-700 leading-relaxed">
                                        <strong class="text-slate-900">Pemberdayaan Kepemudaan & Ekonomi Kreatif:</strong> Mendukung penuh segala bentuk kegiatan kepemudaan baik olahraga maupun kegiatan ekonomi kreatif.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {/* 2. Sejarah Lengkap & Asal Usul Nama Desa Banyuurip */}
                <div class="border-t border-sky-100 pt-20">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Historiografi Lengkap</span>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl leading-tight">Sejarah & Asal-Usul Desa Banyuurip</h2>
                        <p class="mt-4 text-slate-600 leading-relaxed text-sm">
                            Dokumentasi tutur sejarah tentang perjuangan Eyang Ijo, peristiwa mata air Mur Genthong oleh Eyang Sumendhi Amijaya, serta silsilah kepemimpinan Desa Banyuurip.
                        </p>
                    </div>

                    {/* Detailed Narration Box */}
                    <div class="space-y-8 max-w-4xl mx-auto">
                        <div class="rounded-3xl bg-white p-8 sm:p-10 shadow-sm border border-sky-100 space-y-6 leading-relaxed text-slate-700 text-sm banyu-hover-card">
                            <h3 class="text-xl font-extrabold text-slate-900 flex items-center gap-2 border-b border-sky-100 pb-4">
                                <Scroll class="h-6 w-6 text-sky-600" />
                                Kisah Perjuangan Eyang Ijo & Eyang Sumendhi Amijaya
                            </h3>
                            
                            <p>
                                Pada zaman dahulu, Desa Banyuurip merupakan kawasan hutan belantara. kedatangan pertama dipelopori oleh <strong class="text-slate-900">Pangeran Kajoran dari Kerajaan Mataram</strong> yang menunggangi kuda bersama prajuritnya untuk mengintai pergerakan penjajah Belanda. Agar tidak dikenali musuh, beliau mengubah namanya menjadi <strong class="text-slate-900">Mbah Ijo (Eyang Ijo)</strong> dan menetap di wilayah Banyuurip bagian utara yang kini dinamakan <strong class="text-sky-700 font-bold">Dukuh Ngijo</strong>. Beliau bersatu dengan tokoh sakti setempat seperti Eyang Liyang (penguasa padukuhan Ngliyangan) dan Eyang Jegrek (penguasa padukuhan Banyuurip) demi mengusir kompeni Belanda.
                            </p>

                            <p>
                                Sepeninggal Eyang Ijo, datanglah pemuda gagah berani punggawa Mataram bernama <strong class="text-slate-900">Sumendhi Amijaya (Eyang Sumendhi)</strong> asal Jatinom, Klaten. Beliau mengemban tugas mencari harimau pengganti hewan kesayangan Raja Mataram yang mati. Dalam pelariannya dari kejaran serdadu Belanda, beliau bersembunyi di Gua Kedhung Banteng (Dukuh Gandhu) dan beristirahat di wilayah Banyuurip.
                            </p>

                            <div class="p-6 rounded-2xl bg-sky-50 border border-sky-200 space-y-3">
                                <h4 class="font-extrabold text-sky-900 text-sm flex items-center gap-2">
                                    <Sparkles class="h-4 w-4 text-sky-600" />
                                    Peristiwa Karomah "Mur Genthong" & Tradisi Nyadran Safar
                                </h4>
                                <p class="text-xs text-sky-800 leading-relaxed">
                                    Saat prajurit kehabisan bekal di utara Dukuh Jlegong, Eyang Sumendhi berujar sambil menancapkan tongkatnya (*teken*) ke batu padas: <em>"Nggejruake tekenne ono padas"</em>. Seketika dari batu padas mengalir mata air murni yang tidak pernah habis meskipun di musim kemarau panjang, yang hingga kini dinamakan <strong class="text-sky-900 font-bold">Mur Genthong</strong>.
                                </p>
                                <p class="text-xs text-sky-800 leading-relaxed">
                                    Sebelum kembali ke Mataram membawa 8 ekor harimau, Eyang Sumendhi menguburkan tongkatnya di Makam Jlegong dan berpesan agar warga menggelar <strong class="text-sky-900 font-bold">Nyadran di Bulan Safar pada hari Jumat Wage (atau Rebo Wage)</strong> dengan hidangan khas tempe bongkrek & tumpeng panggang.
                                </p>
                            </div>

                            <p>
                                Makna nama <strong class="text-sky-700 font-extrabold">Banyuurip</strong> ("Air yang Menghidupi") melambangkan masyarakat yang baik serta pengharapan agar Desa Banyuurip selalu *ayem tentrem, subur makmur, gemah ripah lohjinawi*.
                            </p>
                        </div>

                        {/* Silsilah Kepemimpinan Timeline */}
                        <div class="rounded-3xl bg-white p-8 sm:p-10 shadow-sm border border-sky-100 space-y-6 banyu-hover-card">
                            <h3 class="text-xl font-extrabold text-slate-900 flex items-center gap-2 border-b border-sky-100 pb-4">
                                <History class="h-6 w-6 text-sky-600" />
                                Silsilah Kepemimpinan Desa Banyuurip (1914 - Sekarang)
                            </h3>

                            <div class="relative border-l-2 border-sky-200 pl-6 sm:pl-8 space-y-8">
                                {(sejarah || []).map((ev, idx) => (
                                    <div key={ev.id || idx} class="relative group">
                                        <span class="absolute -left-[31px] sm:-left-[39px] top-1 flex h-7 w-7 items-center justify-center rounded-full bg-sky-600 text-white text-xs font-bold ring-4 ring-sky-50">
                                            {idx + 1}
                                        </span>
                                        <span class="inline-block text-xs font-extrabold text-sky-700 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">{ev.tahun}</span>
                                        <h4 class="mt-2 text-lg font-bold text-slate-900 group-hover:text-sky-700 transition-colors">{ev.judul}</h4>
                                        <p class="mt-1 text-xs text-slate-600 leading-relaxed">{ev.deskripsi}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>

                {/* 3. Kajian Keilmuan Perdesaan (Tentang Kami & Teori Desa) */}
                <div class="border-t border-sky-100 pt-20">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Kajian Ilmu Perdesaan</span>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl leading-tight">Pengertian, Fungsi & Ciri Masyarakat Desa</h2>
                        <p class="mt-4 text-slate-600 leading-relaxed text-sm">
                            Pemahaman teori keilmuan kependudukan perdesaan berdasarkan regulasi UU No. 6 Tahun 2014 & para ahli kependudukan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        {/* Pengertian Menurut Ahli */}
                        <div class="rounded-3xl bg-white p-8 border border-sky-100 shadow-sm space-y-6 banyu-hover-card">
                            <div class="flex items-center gap-3 text-sky-700 font-extrabold text-lg border-b border-sky-100 pb-4">
                                <BookOpen class="h-6 w-6" />
                                <span>Pengertian Desa Menurut Para Ahli</span>
                            </div>

                            <div class="space-y-4">
                                {ahliList.map((ahli, idx) => (
                                    <div key={idx} class="p-4 rounded-2xl bg-sky-50/60 border border-sky-100">
                                        <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">{idx + 1}. {ahli.nama}</h4>
                                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed italic">"{ahli.definisi}"</p>
                                    </div>
                                ))}
                            </div>

                            <div class="p-5 rounded-2xl bg-slate-900 text-white text-xs space-y-2">
                                <span class="font-extrabold text-sky-300 block uppercase">UU Desa No. 6 Tahun 2014</span>
                                <p class="text-slate-300 leading-relaxed">
                                    Desa adalah kesatuan masyarakat hukum yang mempunyai batas wilayah yang berwenang untuk mengatur dan mengurus urusan pemerintahan & kepentingan masyarakat setempat berdasarkan hak asal usul dan hak tradisional yang diakui NKRI.
                                </p>
                            </div>
                        </div>

                        {/* Fungsi Desa & Ciri-Ciri */}
                        <div class="space-y-8">
                            {/* Fungsi Desa */}
                            <div class="rounded-3xl bg-white p-8 border border-sky-100 shadow-sm space-y-6 banyu-hover-card">
                                <div class="flex items-center gap-3 text-sky-700 font-extrabold text-lg border-b border-sky-100 pb-4">
                                    <Landmark class="h-6 w-6" />
                                    <span>Empat Fungsi Utama Desa</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    {fungsiDesaList.map((f, idx) => (
                                        <div key={idx} class="p-4 rounded-2xl bg-sky-50/60 border border-sky-100">
                                            <span class="text-xs font-extrabold text-sky-700 block">{idx + 1}. {f.title}</span>
                                            <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">{f.desc}</p>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Ciri Masyarakat Desa */}
                            <div class="rounded-3xl bg-white p-8 border border-sky-100 shadow-sm space-y-6 banyu-hover-card">
                                <div class="flex items-center gap-3 text-sky-700 font-extrabold text-lg border-b border-sky-100 pb-4">
                                    <Users class="h-6 w-6" />
                                    <span>Ciri Karakteristik Masyarakat Desa</span>
                                </div>
                                <ul class="space-y-2.5">
                                    {ciriMasyarakatList.map((ciri, idx) => (
                                        <li key={idx} class="flex items-start gap-2.5 text-xs text-slate-700 leading-relaxed">
                                            <CheckCircle2 class="h-4 w-4 text-sky-600 shrink-0 mt-0.5" />
                                            <span>{ciri}</span>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {/* 4. Perangkat Desa Section */}
                <div class="border-t border-sky-100 pt-20">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="text-xs font-extrabold uppercase tracking-widest text-sky-700 bg-sky-100 px-3 py-1 rounded-full border border-sky-200">Struktur Aparatur</span>
                        <h2 class="mt-3 text-3xl font-extrabold text-slate-900 sm:text-4xl leading-tight">Pemerintah Desa Banyuurip</h2>
                        <p class="mt-4 text-slate-600">
                            Jajaran Perangkat Desa yang siap melayani masyarakat dengan penuh integritas dan sepenuh hati.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        {(perangkat || []).map((p, idx) => (
                            <div key={p.id || idx} class="rounded-3xl bg-white p-7 border border-sky-100 shadow-sm banyu-hover-card flex flex-col items-center text-center">
                                <div class="h-24 w-24 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 shadow-md border-2 border-sky-200 overflow-hidden mb-4 shrink-0">
                                    {p.foto ? (
                                        <img src={`/${p.foto}`} alt={p.nama} class="h-full w-full object-cover" />
                                    ) : (
                                        <User class="h-12 w-12" />
                                    )}
                                </div>
                                <h3 class="text-lg font-extrabold text-slate-900">{p.nama}</h3>
                                <span class="mt-1 inline-block text-xs font-extrabold text-sky-700 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">{p.jabatan}</span>
                                {p.kontak && (
                                    <span class="mt-4 text-xs text-slate-500 flex items-center gap-1.5">
                                        <Phone class="h-3.5 w-3.5 text-sky-600" /> {p.kontak}
                                    </span>
                                )}
                            </div>
                        ))}
                    </div>
                </div>

            </div>
        </MainLayout>
    );
}
