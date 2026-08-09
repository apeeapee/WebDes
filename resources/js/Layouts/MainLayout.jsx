import React, { useState, useRef, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { 
    Menu, 
    X, 
    Globe, 
    ShieldCheck, 
    ChevronDown, 
    ChevronRight, 
    Clock, 
    Home, 
    FileText, 
    Newspaper, 
    Store, 
    HeartPulse, 
    Sprout, 
    Coins, 
    Sparkles, 
    Building2, 
    Mail, 
    MessageSquare 
} from 'lucide-react';

export default function MainLayout({ children }) {
    const { url, props } = usePage();
    const { isAdmin, flash } = props;
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const dropdownRef = useRef(null);

    // Close dropdown on click outside
    useEffect(() => {
        function handleClickOutside(event) {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setDropdownOpen(false);
            }
        }
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    const isActive = (href) => {
        if (href === '/' && url === '/') return true;
        if (href !== '/' && href !== '/#berita' && url.startsWith(href)) return true;
        return false;
    };

    const dropdownItems = [
        {
            title: 'E-Book & Skrining ISPA (RESPIRA)',
            subtitle: 'Edukasi & Cek Mandiri Kesehatan',
            href: '/kesehatan',
            icon: HeartPulse,
            color: 'bg-sky-100 text-sky-700'
        },
        {
            title: 'Pertanian & Peminjaman Aset Balai Desa',
            subtitle: 'Komoditas Tani, Peminjaman Aset & SOP Balai Desa',
            href: '/agribisnis',
            icon: Sprout,
            color: 'bg-sky-100 text-sky-700'
        },
        {
            title: 'Pusat Hukum Desa (JDIH)',
            subtitle: 'Perdes, Perkades & Dokumen Resmi',
            href: '/hukum',
            icon: FileText,
            color: 'bg-sky-100 text-sky-700'
        },
        {
            title: 'Transparansi APBDes & PBB-P2',
            subtitle: 'Grafik APBDes & Bayar Pajak Online',
            href: '/keuangan',
            icon: Coins,
            color: 'bg-sky-100 text-sky-700'
        },
        {
            title: 'Edukasi Budaya 5S Jepang',
            subtitle: 'Panduan Hidup Bersih & Disiplin',
            href: '/edukasi-5s',
            icon: Sparkles,
            color: 'bg-sky-100 text-sky-700'
        },
    ];

    return (
        <div class="h-full flex flex-col bg-sky-50/40 text-slate-900 font-sans antialiased bg-banyu-grid min-h-screen">
            
            {/* Sticky Fixed Container for Top Bar & Navbar Header Together */}
            <div class="sticky top-0 z-50 w-full shadow-xs">
                {/* Top Announcement Ribbon */}
                <div class="bg-gradient-to-r from-slate-950 via-sky-950 to-blue-950 text-white text-xs font-medium py-2 px-4 border-b border-sky-900/40">
                    <div class="mx-auto max-w-[94rem] px-2 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                        {/* Far Left Positioned Title */}
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center bg-sky-500/20 text-sky-200 border border-sky-400/30 rounded-full px-3 py-0.5 text-[10px] font-extrabold uppercase tracking-wider">
                                Banyuurip Digital Gateway
                            </span>
                            <span class="hidden md:inline text-sky-100/90 text-[11px] font-medium">
                                Portal Digital Resmi Desa Banyuurip, Kecamatan Klego, Kabupaten Boyolali
                            </span>
                        </div>

                        {/* Right Side: Jam Pelayanan & Login Perangkat */}
                        <div class="flex items-center gap-3 sm:gap-4 text-[11px] text-sky-200 shrink-0">
                            <span class="inline-flex items-center gap-1.5 text-sky-300 font-bold border-r border-sky-800/80 pr-3 sm:pr-4">
                                <Clock class="h-3.5 w-3.5 text-sky-400 shrink-0" />
                                <span>Jam Pelayanan: 08.00 - 14.00 WIB</span>
                            </span>

                            {isAdmin ? (
                                <Link href="/admin" class="hover:text-white font-bold transition-colors flex items-center gap-1">
                                    <ShieldCheck class="h-3.5 w-3.5 text-sky-300" />
                                    <span>Panel Admin</span>
                                </Link>
                            ) : (
                                <Link href="/admin/login" class="hover:text-white font-bold transition-colors flex items-center gap-1">
                                    <Globe class="h-3.5 w-3.5 text-sky-300" />
                                    <span>Login Perangkat</span>
                                </Link>
                            )}
                        </div>
                    </div>
                </div>

                {/* Header Navigation */}
                <header class="w-full bg-white border-b border-slate-200">
                    <div class="mx-auto max-w-[94rem] px-4 sm:px-6 lg:px-8">
                        <div class="flex h-20 items-center justify-between gap-4">
                            
                            {/* Brand Logo & Title */}
                            <div class="flex items-center gap-3 shrink-0">
                                <Link href="/" class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white p-1 border border-slate-200 shadow-xs">
                                        <img src="/images/logo-boyolali.jpg" alt="Logo Kabupaten Boyolali" class="h-9 w-auto object-contain" />
                                    </div>
                                    <div>
                                        <span class="text-lg font-black tracking-tight text-slate-900 block leading-none hover:text-sky-700 transition-colors uppercase">
                                            DESA BANYUURIP
                                        </span>
                                        <span class="block text-[11px] font-semibold text-slate-500 mt-1 leading-none">
                                            Digitalisasi Profil, Ekonomi & Kesehatan Satu Pintu
                                        </span>
                                    </div>
                                </Link>
                            </div>

                            {/* Desktop Navigation Links */}
                            <nav class="hidden lg:flex items-center gap-1.5 xl:gap-2">
                                {/* 1. Beranda */}
                                <Link
                                    href="/"
                                    class={`px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 ${
                                        isActive('/') 
                                            ? 'bg-sky-600 text-white shadow-xs' 
                                            : 'text-slate-700 hover:text-sky-700 hover:bg-sky-50'
                                    }`}
                                >
                                    <Home class="h-3.5 w-3.5" />
                                    <span>Beranda</span>
                                </Link>

                                {/* 2. Profil & Sejarah */}
                                <Link
                                    href="/profil"
                                    class={`px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 ${
                                        isActive('/profil') 
                                            ? 'bg-sky-600 text-white shadow-xs' 
                                            : 'text-slate-700 hover:text-sky-700 hover:bg-sky-50'
                                    }`}
                                >
                                    <Building2 class="h-3.5 w-3.5" />
                                    <span>Profil & Sejarah</span>
                                </Link>

                                {/* 3. Layanan & Program Dropdown */}
                                <div class="relative" ref={dropdownRef}>
                                    <button
                                        onClick={() => setDropdownOpen(!dropdownOpen)}
                                        class={`px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer ${
                                            dropdownOpen || url.startsWith('/kesehatan') || url.startsWith('/agribisnis') || url.startsWith('/keuangan') || url.startsWith('/edukasi-5s')
                                                ? 'bg-sky-50 text-sky-700 border border-sky-200' 
                                                : 'text-slate-700 hover:text-sky-700 hover:bg-sky-50 border border-slate-200'
                                        }`}
                                    >
                                        <span>Layanan & Program</span>
                                        <ChevronDown class={`h-3.5 w-3.5 transition-transform ${dropdownOpen ? 'rotate-180 text-sky-700' : 'text-slate-500'}`} />
                                    </button>

                                    {/* Dropdown Menu Panel */}
                                    {dropdownOpen && (
                                        <div class="absolute left-0 mt-2 w-80 rounded-2xl bg-white p-2.5 shadow-xl border border-slate-200 z-50">
                                            <div class="space-y-1">
                                                {dropdownItems.map((item, idx) => {
                                                    const ItemIcon = item.icon;
                                                    return (
                                                        <Link
                                                            key={idx}
                                                            href={item.href}
                                                            onClick={() => setDropdownOpen(false)}
                                                            class="flex items-start gap-3 p-2 rounded-xl hover:bg-sky-50 transition-colors"
                                                        >
                                                            <div class={`flex h-8 w-8 shrink-0 items-center justify-center rounded-lg ${item.color} mt-0.5`}>
                                                                <ItemIcon class="h-4 w-4" />
                                                            </div>
                                                            <div>
                                                                <span class="text-xs font-bold text-slate-900 block leading-snug">
                                                                    {item.title}
                                                                </span>
                                                                <span class="text-[10px] text-slate-500 block leading-tight mt-0.5">
                                                                    {item.subtitle}
                                                                </span>
                                                            </div>
                                                        </Link>
                                                    );
                                                })}
                                            </div>
                                        </div>
                                    )}
                                </div>

                                {/* 4. Desa Anti Korupsi */}
                                <Link
                                    href="/desa-antikorupsi"
                                    class={`px-3.5 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 ${
                                        isActive('/desa-antikorupsi') 
                                            ? 'bg-sky-600 text-white shadow-xs' 
                                            : 'text-slate-700 hover:text-sky-700 hover:bg-sky-50'
                                    }`}
                                >
                                    <ShieldCheck class="h-3.5 w-3.5" />
                                    <span>Desa Anti Korupsi</span>
                                </Link>

                                {/* 5. Berita Desa */}
                                <Link
                                    href="/berita"
                                    class={`px-3.5 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 ${
                                        isActive('/berita') 
                                            ? 'bg-sky-600 text-white shadow-xs' 
                                            : 'text-slate-700 hover:text-sky-700 hover:bg-sky-50'
                                    }`}
                                >
                                    <Newspaper class="h-3.5 w-3.5" />
                                    <span>Berita Desa</span>
                                </Link>

                                {/* 6. UMKM Desa */}
                                <Link
                                    href="/umkm"
                                    class={`px-3.5 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 ${
                                        isActive('/umkm') 
                                            ? 'bg-sky-600 text-white shadow-xs' 
                                            : 'text-slate-700 hover:text-sky-700 hover:bg-sky-50'
                                    }`}
                                >
                                    <Store class="h-3.5 w-3.5" />
                                    <span>UMKM Desa</span>
                                </Link>
                            </nav>

                            {/* Right Action CTA Button (Skrining ISPA) & Mobile Trigger */}
                            <div class="flex items-center gap-3">
                                <Link 
                                    href="/kesehatan" 
                                    class="inline-flex items-center gap-2 rounded-full bg-sky-600 hover:bg-sky-700 px-5 py-2.5 text-xs font-extrabold text-white shadow-xs"
                                >
                                    <HeartPulse class="h-4 w-4" />
                                    <span>Skrining ISPA</span>
                                </Link>

                                <button 
                                    onClick={() => setMobileMenuOpen(!mobileMenuOpen)} 
                                    class="lg:hidden p-2.5 rounded-2xl text-slate-700 hover:bg-sky-50 hover:text-sky-700 transition-colors border border-slate-200"
                                >
                                    {mobileMenuOpen ? <X class="h-6 w-6" /> : <Menu class="h-6 w-6" />}
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Mobile Drawer Navigation */}
                    {mobileMenuOpen && (
                        <div class="lg:hidden bg-white border-b border-slate-200 px-4 pt-4 pb-6 space-y-2 shadow-lg">
                            <Link
                                href="/"
                                onClick={() => setMobileMenuOpen(false)}
                                class={`flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-extrabold ${isActive('/') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50'}`}
                            >
                                <span class="flex items-center gap-2"><Home class="h-4 w-4" /> Beranda</span>
                                <ChevronRight class="h-4 w-4 opacity-60" />
                            </Link>

                            <Link
                                href="/profil"
                                onClick={() => setMobileMenuOpen(false)}
                                class={`flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-extrabold ${isActive('/profil') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50'}`}
                            >
                                <span class="flex items-center gap-2"><Building2 class="h-4 w-4" /> Profil & Sejarah</span>
                                <ChevronRight class="h-4 w-4 opacity-60" />
                            </Link>

                            {/* Mobile Layanan List */}
                            <div class="p-3 rounded-2xl bg-sky-50/70 border border-sky-100 space-y-2">
                                <span class="text-[10px] font-extrabold text-sky-800 uppercase tracking-widest block px-2">Layanan & Program Utama</span>
                                {dropdownItems.map((item, idx) => {
                                    const ItemIcon = item.icon;
                                    return (
                                        <Link
                                            key={idx}
                                            href={item.href}
                                            onClick={() => setMobileMenuOpen(false)}
                                            class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold text-slate-800 hover:bg-white transition-colors"
                                        >
                                            <span class="flex items-center gap-2">
                                                <ItemIcon class="h-3.5 w-3.5 text-sky-600" />
                                                {item.title}
                                            </span>
                                            <ChevronRight class="h-3.5 w-3.5 opacity-50" />
                                        </Link>
                                    );
                                })}
                            </div>

                            <Link
                                href="/desa-antikorupsi"
                                onClick={() => setMobileMenuOpen(false)}
                                class={`flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-extrabold ${isActive('/desa-antikorupsi') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50'}`}
                            >
                                <span class="flex items-center gap-2"><ShieldCheck class="h-4 w-4" /> Desa Anti Korupsi</span>
                                <ChevronRight class="h-4 w-4 opacity-60" />
                            </Link>

                            <Link
                                href="/berita"
                                onClick={() => setMobileMenuOpen(false)}
                                class={`flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-extrabold ${isActive('/berita') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50'}`}
                            >
                                <span class="flex items-center gap-2"><Newspaper class="h-4 w-4" /> Berita Desa</span>
                            </Link>

                            <Link
                                href="/umkm"
                                onClick={() => setMobileMenuOpen(false)}
                                class={`flex items-center justify-between px-4 py-3 rounded-2xl text-xs font-extrabold ${isActive('/umkm') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-sky-50'}`}
                            >
                                <span class="flex items-center gap-2"><Store class="h-4 w-4" /> UMKM Desa</span>
                                <ChevronRight class="h-4 w-4 opacity-60" />
                            </Link>
                        </div>
                    )}
                </header>
            </div>

            {/* Flash Banner Messages */}
            {flash?.success && (
                <div class="bg-sky-600 text-white px-4 py-3 text-center text-xs font-bold shadow-xs">
                    <span>{flash.success}</span>
                </div>
            )}

            {/* Main Content Body */}
            <main class="flex-grow">
                {children}
            </main>

            {/* Premium Blue Water Footer */}
            <footer class="bg-gradient-to-br from-slate-950 via-sky-950 to-blue-950 text-slate-300 pt-16 pb-12 border-t border-sky-900/50 relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(14,165,233,0.15),transparent_50%)]"></div>
                
                <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-sky-900/40">
                        {/* Brand Column */}
                        <div class="space-y-4 md:col-span-1">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white p-1 shadow-md">
                                    <img src="/images/logo-boyolali.jpg" alt="Logo Kabupaten Boyolali" class="h-8 w-auto object-contain" />
                                </div>
                                <div>
                                    <span class="text-base font-extrabold text-white block">Desa Banyuurip</span>
                                    <span class="text-[9px] font-bold text-sky-400 uppercase tracking-widest block">Klego, Boyolali</span>
                                </div>
                            </div>
                            <p class="text-xs text-sky-200/70 leading-relaxed">
                                Banyuurip Digital Gateway — Portal terpadu layanan publik, transparansi keuangan APBDes, potensi agribisnis, serta edukasi kesehatan warga.
                            </p>
                        </div>

                        {/* Navigation Links */}
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold text-white uppercase tracking-wider">Navigasi Utama</h4>
                            <ul class="space-y-2 text-xs text-sky-200/70">
                                <li><Link href="/" class="hover:text-sky-300 transition-colors">Beranda Utama</Link></li>
                                <li><Link href="/profil" class="hover:text-sky-300 transition-colors">Profil & Sejarah Desa</Link></li>
                                <li><Link href="/kesehatan" class="hover:text-sky-300 transition-colors">Skrining Kesehatan ISPA</Link></li>
                                <li><Link href="/agribisnis" class="hover:text-sky-300 transition-colors">Potensi Agribisnis</Link></li>
                            </ul>
                        </div>

                        {/* Kontak Resmi & Layanan Direct Links */}
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold text-white uppercase tracking-wider">Hubungi Pemerintah Desa</h4>
                            <ul class="space-y-3 text-xs text-sky-200/80">
                                <li>
                                    <a 
                                        href="https://wa.me/6281327349963?text=Halo%20Admin%20Pemerintah%20Desa%20Banyuurip,%20saya%20ingin%20bertanya" 
                                        target="_blank" 
                                        rel="noopener noreferrer" 
                                        class="inline-flex items-center gap-2.5 px-3 py-2 rounded-xl bg-sky-500/10 border border-sky-400/30 text-sky-300 font-bold hover:bg-sky-500/20 hover:text-sky-100 transition-colors"
                                    >
                                        <MessageSquare class="h-4 w-4 text-sky-400 shrink-0" />
                                        <span>WhatsApp: 0813-2734-9963</span>
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        href="mailto:banyuuripboyolali@gmail.com?subject=Pertanyaan%20Layanan%20Desa%20Banyuurip" 
                                        class="inline-flex items-center gap-2.5 px-3 py-2 rounded-xl bg-sky-500/10 border border-sky-400/30 text-sky-300 font-bold hover:bg-sky-500/20 hover:text-sky-100 transition-colors"
                                    >
                                        <Mail class="h-4 w-4 text-sky-400 shrink-0" />
                                        <span>banyuuripboyolali@gmail.com</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        {/* Digital Badge */}
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold text-white uppercase tracking-wider">Pengembangan Digital</h4>
                            <div class="rounded-2xl bg-sky-900/40 p-4 border border-sky-700/40 backdrop-blur-md">
                                <span class="text-xs font-bold text-sky-300 block">Pemerintah Desa Banyuurip</span>
                                <p class="text-[11px] text-sky-200/70 mt-1">
                                    Portal resmi terpadu guna mendorong kemandirian digital dan transparansi publik Desa Banyuurip.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-sky-300/60 gap-4">
                        <p>© 2026 Pemerintah Desa Banyuurip, Kecamatan Klego, Kabupaten Boyolali.</p>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                            <span class="text-sky-200">Sistem Berjalan Stabil</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}
