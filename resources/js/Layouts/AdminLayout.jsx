import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { 
    LayoutDashboard, 
    Newspaper, 
    History, 
    Users, 
    Sprout, 
    Building2, 
    Truck, 
    Scale, 
    ShoppingBag, 
    Activity, 
    PieChart, 
    ShieldCheck, 
    LogOut, 
    Globe, 
    Menu, 
    X, 
    ChevronRight, 
    Droplets 
} from 'lucide-react';

export default function AdminLayout({ children, title, subtitle }) {
    const { url, props } = usePage();
    const { flash } = props;
    const [sidebarOpen, setSidebarOpen] = useState(false);

    const adminNav = [
        { name: 'Dashboard Overview', href: '/admin', icon: LayoutDashboard },
        { name: 'Warta Berita Desa', href: '/admin/berita', icon: Newspaper },
        { name: 'Sejarah & Linimasa', href: '/admin/sejarah', icon: History },
        { name: 'Perangkat Desa', href: '/admin/perangkat', icon: Users },
        { name: 'Komoditas Pertanian', href: '/admin/komoditas', icon: Sprout },
        { name: 'Aset Balai Desa', href: '/admin/asettani', icon: Building2 },
        { name: 'Pusat Hukum Desa (JDIH)', href: '/admin/regulasi', icon: Scale },
        { name: 'Direktori UMKM', href: '/admin/umkm', icon: ShoppingBag },
        { name: 'Log Skrining ISPA', href: '/admin/skrining', icon: Activity },
        { name: 'Transparansi APBDes', href: '/admin/apbdes', icon: PieChart },
        { name: 'Desa Antikorupsi KPK', href: '/admin/antikorupsi', icon: ShieldCheck },
    ];

    const isActive = (href) => {
        if (href === '/admin' && url === '/admin') return true;
        if (href !== '/admin' && url.startsWith(href)) return true;
        return false;
    };

    return (
        <div class="min-h-screen bg-sky-50/50 flex font-sans antialiased text-slate-900 bg-banyu-grid">
            {/* Desktop Sidebar (Sticky Fixed) */}
            <aside class="hidden lg:flex flex-col w-64 h-screen sticky top-0 bg-slate-950 text-slate-300 border-r border-sky-900/40 shrink-0 z-40">
                <div class="p-5 border-b border-sky-900/40 flex items-center justify-between">
                    <Link href="/admin" class="flex items-center gap-3 group">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white p-1 shadow-md border border-sky-400/30 group-hover:scale-105 transition-transform">
                            <img src="/images/logo-boyolali.jpg" alt="Logo Kabupaten Boyolali" class="h-8 w-auto object-contain" />
                        </div>
                        <div>
                            <span class="text-sm font-extrabold text-white block leading-tight">Admin Panel</span>
                            <span class="text-[9px] font-bold text-sky-400 uppercase tracking-widest block mt-0.5">Desa Banyuurip</span>
                        </div>
                    </Link>
                </div>

                <div class="p-3">
                    <div class="px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-sky-400/70 flex items-center gap-1.5">
                        <Droplets class="h-3 w-3 text-sky-400" />
                        <span>Kelola Portal Digital</span>
                    </div>
                </div>

                <nav class="flex-grow px-3 space-y-1 overflow-y-auto">
                    {adminNav.map((item) => {
                        const active = isActive(item.href);
                        const Icon = item.icon;
                        return (
                            <Link
                                key={item.href}
                                href={item.href}
                                class={`flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all ${
                                    active
                                        ? 'bg-gradient-to-r from-sky-600 to-blue-600 text-white font-bold shadow-md shadow-sky-600/30'
                                        : 'text-slate-400 hover:text-white hover:bg-sky-950/60'
                                }`}
                            >
                                <div class="flex items-center gap-3">
                                    <Icon class={`h-4 w-4 ${active ? 'text-white' : 'text-sky-400/70'}`} />
                                    <span>{item.name}</span>
                                </div>
                                {active && <ChevronRight class="h-3.5 w-3.5 text-white" />}
                            </Link>
                        );
                    })}
                </nav>

                <div class="p-4 border-t border-sky-900/40">
                    <Link
                        href="/admin/logout"
                        method="post"
                        as="button"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-rose-300 bg-rose-950/40 border border-rose-900/40 hover:bg-rose-900/60 hover:text-white transition-colors cursor-pointer"
                    >
                        <LogOut class="h-4 w-4" />
                        <span>Keluar Sistem</span>
                    </Link>
                </div>
            </aside>

            {/* Main Area */}
            <div class="flex-grow flex flex-col min-w-0">
                {/* Header Top Bar */}
                <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-sky-100 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <button
                            onClick={() => setSidebarOpen(!sidebarOpen)}
                            class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-sky-50 transition-colors"
                        >
                            {sidebarOpen ? <X class="h-6 w-6" /> : <Menu class="h-6 w-6" />}
                        </button>

                        <div>
                            <h1 class="text-lg font-extrabold text-slate-900 tracking-tight leading-tight">{title || 'Dashboard'}</h1>
                            {subtitle && <p class="text-xs text-sky-700 font-semibold">{subtitle}</p>}
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <Link
                            href="/"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 text-sky-700 text-xs font-bold border border-sky-200 hover:bg-sky-100 transition-colors"
                        >
                            <Globe class="h-3.5 w-3.5" />
                            <span class="hidden sm:inline">Lihat Web Publik</span>
                        </Link>
                    </div>
                </header>

                {/* Mobile Drawer */}
                {sidebarOpen && (
                    <div class="lg:hidden bg-slate-950 text-slate-300 p-4 border-b border-sky-900/40 space-y-1">
                        <div class="flex items-center gap-3 pb-3 mb-2 border-b border-sky-900/40">
                            <img src="/images/logo-boyolali.jpg" alt="Logo Boyolali" class="h-7 w-auto bg-white rounded-md p-0.5" />
                            <span class="text-xs font-bold text-white uppercase">Admin Panel Banyuurip</span>
                        </div>
                        {adminNav.map((item) => {
                            const active = isActive(item.href);
                            const Icon = item.icon;
                            return (
                                <Link
                                    key={item.href}
                                    href={item.href}
                                    onClick={() => setSidebarOpen(false)}
                                    class={`flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold ${
                                        active ? 'bg-sky-600 text-white font-bold' : 'text-slate-400 hover:bg-sky-900/40'
                                    }`}
                                >
                                    <div class="flex items-center gap-3">
                                        <Icon class="h-4 w-4" />
                                        <span>{item.name}</span>
                                    </div>
                                    <ChevronRight class="h-3.5 w-3.5" />
                                </Link>
                            );
                        })}
                    </div>
                )}

                {/* Flash Messages */}
                {flash?.success && (
                    <div class="bg-sky-600 text-white px-6 py-2.5 text-xs font-bold shadow-xs">
                        <span>{flash.success}</span>
                    </div>
                )}

                {/* Page Content */}
                <main class="flex-grow p-4 sm:p-6 lg:p-8 overflow-y-auto">
                    {children}
                </main>
            </div>
        </div>
    );
}
