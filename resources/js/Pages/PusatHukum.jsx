import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '../Layouts/MainLayout';
import { 
    FileText, 
    Scale, 
    Download, 
    ExternalLink, 
    Search, 
    ShieldCheck, 
    BookOpen, 
    CheckCircle2, 
    Building2, 
    Calendar, 
    Folder, 
    Lock 
} from 'lucide-react';

export default function PusatHukum({ regulasi, antikorupsiDocs }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedCategory, setSelectedCategory] = useState('Semua');

    const categories = [
        'Semua', 
        'Peraturan Desa (Perdes)', 
        'Peraturan Kepala Desa (Perkades)', 
        'SOP & Maklumat Pelayanan'
    ];

    // Combine regulations and antikorupsi documents into legal catalog
    const allLegalDocs = [
        {
            id: 1,
            nomor: 'Perdes No. 01 Tahun 2026',
            judul: 'Peraturan Desa Banyuurip tentang Anggaran Pendapatan dan Belanja Desa (APBDes) T.A. 2026',
            kategori: 'Peraturan Desa (Perdes)',
            tanggal: '02 Januari 2026',
            deskripsi: 'Landasan hukum penetapan struktur pendapatan, belanja, dan pembiayaan Desa Banyuurip Tahun Anggaran 2026.',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_partisipasi_publik_banyuurip'
        },
        {
            id: 2,
            nomor: 'Perdes No. 03 Tahun 2025',
            judul: 'Peraturan Desa tentang Pengelolaan Sampah dan Kebersihan Lingkungan Desa Banyuurip',
            kategori: 'Peraturan Desa (Perdes)',
            tanggal: '12 April 2025',
            deskripsi: 'Regulasi pedoman kebersihan lingkungan, pemilahan sampah organik & anorganik, serta larangan pembuangan limbah di sungai.',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip'
        },
        {
            id: 3,
            nomor: 'Perdes No. 05 Tahun 2025',
            judul: 'Peraturan Desa tentang Rencana Kerja Pemerintah Desa (RKPDes) Tahun Anggaran 2026',
            kategori: 'Peraturan Desa (Perdes)',
            tanggal: '20 September 2025',
            deskripsi: 'Dokumen perencanaan pembangunan desa tahunan yang disepakati melalui Musyawarah Desa (Musdes).',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_partisipasi_publik_banyuurip'
        },
        {
            id: 4,
            nomor: 'Perkades No. 01 Tahun 2026',
            judul: 'Peraturan Kepala Desa tentang Maklumat Standar Pelayanan Publik Bebas Pungli (Rp 0)',
            kategori: 'Peraturan Kepala Desa (Perkades)',
            tanggal: '01 Maret 2026',
            deskripsi: 'Maklumat resmi Kepala Desa mengenai standar pelayanan administrasi kependudukan tanpa biaya tambahan.',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pelayanan_publik_banyuurip'
        },
        {
            id: 5,
            nomor: 'Perkades No. 02 Tahun 2026',
            judul: 'Peraturan Kepala Desa tentang Tata Cara Pemberian Insentif Kader Kesehatan Posyandu',
            kategori: 'Peraturan Kepala Desa (Perkades)',
            tanggal: '05 Februari 2026',
            deskripsi: 'Ketentuan dan besaran alokasi dana insentif bagi kader kesehatan aktif Posyandu Desa Banyuurip.',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pelayanan_publik_banyuurip'
        },
        {
            id: 6,
            nomor: 'SOP-PBJ-01/2026',
            judul: 'Standar Operasional Prosedur (SOP) Pengadaan Barang dan Jasa Desa Transparan',
            kategori: 'SOP & Maklumat Pelayanan',
            tanggal: '10 Januari 2026',
            deskripsi: 'SOP pelaksanaan pengadaan barang/jasa desa yang akuntabel guna mencegah konflik kepentingan & gratifikasi.',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_tata_laksana_banyuurip'
        },
        {
            id: 7,
            nomor: 'SOP-WAS-02/2026',
            judul: 'SOP Sistem Pengaduan Masyarakat (Whistleblowing) & Laporan BPD',
            kategori: 'SOP & Maklumat Pelayanan',
            tanggal: '15 Februari 2026',
            deskripsi: 'Tata cara penyampaian laporan pengaduan pelanggaran administrasi atau indikasi pungli warga desa.',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_pengawasan_banyuurip'
        },
        {
            id: 8,
            nomor: 'PAK-BUD-05/2026',
            judul: 'Pakta Integritas Perangkat Desa & Pernyataan Penolakan Gratifikasi',
            kategori: 'SOP & Maklumat Pelayanan',
            tanggal: '05 Mei 2026',
            deskripsi: 'Komitmen bersama seluruh Perangkat Desa Banyuurip dalam menjaga kejujuran dan budaya antikorupsi.',
            link: 'https://drive.google.com/drive/u/0/folders/1b3Y_sample_budaya_antikorupsi_banyuurip'
        }
    ];

    const filteredDocs = allLegalDocs.filter(doc => {
        const matchesCategory = selectedCategory === 'Semua' || doc.kategori === selectedCategory;
        const matchesSearch = doc.judul.toLowerCase().includes(searchTerm.toLowerCase()) || 
                              doc.nomor.toLowerCase().includes(searchTerm.toLowerCase()) ||
                              doc.deskripsi.toLowerCase().includes(searchTerm.toLowerCase());
        return matchesCategory && matchesSearch;
    });

    return (
        <MainLayout>
            <Head title="Pusat Hukum Desa (JDIH) - Desa Banyuurip" />

            {/* Ocean Blue Header */}
            <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 py-20 text-white relative overflow-hidden">
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/15 px-3.5 py-1 text-xs font-semibold text-sky-300 border border-sky-400/30 mb-4">
                        <Scale class="h-3.5 w-3.5" />
                        Jaringan Dokumentasi & Informasi Hukum (JDIH)
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight lg:text-5xl">Pusat Hukum Desa Banyuurip</h1>
                    <p class="mt-3 text-sky-100/90 max-w-3xl text-base leading-relaxed">
                        Database resmi Peraturan Desa (Perdes), Peraturan Kepala Desa (Perkades), serta Standar Operasional Prosedur (SOP) tata kelola pemerintahan Desa Banyuurip.
                    </p>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 space-y-16">
                
                {/* Search & Category Filter Section */}
                <div class="rounded-3xl bg-white p-8 border border-sky-100 shadow-xs space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        {/* Search Input */}
                        <div class="relative flex-grow max-w-xl">
                            <Search class="absolute left-4 top-3.5 h-4 w-4 text-slate-400" />
                            <input
                                type="text"
                                placeholder="Cari nomor peraturan, judul perdes, atau kata kunci..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                class="w-full pl-11 pr-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:border-sky-500 focus:bg-white transition-colors"
                            />
                        </div>

                        {/* Category Buttons */}
                        <div class="flex flex-wrap gap-2">
                            {categories.map((cat) => (
                                <button
                                    key={cat}
                                    onClick={() => setSelectedCategory(cat)}
                                    class={`px-4 py-2.5 rounded-2xl text-xs font-extrabold cursor-pointer transition-colors ${
                                        selectedCategory === cat 
                                            ? 'bg-sky-600 text-white shadow-xs' 
                                            : 'bg-slate-100 text-slate-700 hover:bg-slate-200'
                                    }`}
                                >
                                    {cat}
                                </button>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Legal Documents Catalog Grid */}
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-sky-100 pb-4">
                        <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                            <BookOpen class="h-5 w-5 text-sky-600" />
                            <span>Daftar Produk Hukum Desa ({filteredDocs.length} Dokumen)</span>
                        </h2>
                        <span class="text-xs text-slate-500">Tersedia dalam format digital publik</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {filteredDocs.map((doc) => (
                            <div key={doc.id} class="rounded-3xl bg-white p-7 border border-sky-100 shadow-xs flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-sky-800 bg-sky-50 px-3 py-1 rounded-full border border-sky-200">
                                            {doc.kategori}
                                        </span>
                                        <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                            <Calendar class="h-3.5 w-3.5" /> {doc.tanggal}
                                        </span>
                                    </div>

                                    <span class="text-xs font-black text-slate-400 block">{doc.nomor}</span>
                                    <h3 class="text-base font-extrabold text-slate-900 leading-snug">{doc.judul}</h3>
                                    <p class="text-xs text-slate-600 leading-relaxed">{doc.deskripsi}</p>
                                </div>

                                <div class="pt-4 border-t border-sky-50 flex items-center justify-between">
                                    <span class="text-[11px] text-emerald-700 font-extrabold flex items-center gap-1">
                                        <ShieldCheck class="h-4 w-4" /> Dokumen Sah & Diterbitkan
                                    </span>

                                    <a
                                        href={doc.link}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition-colors"
                                    >
                                        <span>Unduh / Lihat PDF</span>
                                        <ExternalLink class="h-3.5 w-3.5" />
                                    </a>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* SOP Peminjaman / Akses Informasi Hukum */}
                <div class="rounded-3xl bg-slate-900 text-white p-8 sm:p-10 space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-800 pb-4">
                        <Scale class="h-6 w-6 text-sky-400" />
                        <h3 class="text-xl font-extrabold text-white">Layanan Permohonan Informasi Produk Hukum Desa</h3>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed max-w-3xl">
                        Seluruh salinan fisik Peraturan Desa (Perdes) dan Peraturan Kepala Desa (Perkades) bersifat terbuka untuk seluruh warga Desa Banyuurip. Apabila memerlukan dokumen hukum bermeterai/legalisir untuk keperluan administratif, warga dapat mengajukan permohonan ke Sekretaris Desa di Kantor Balai Desa Banyuurip.
                    </p>
                </div>

            </div>
        </MainLayout>
    );
}
