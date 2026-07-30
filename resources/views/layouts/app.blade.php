<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Banyuurip Digital Gateway') - Desa Banyuurip, Boyolali</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Website Resmi Desa Banyuurip, Kecamatan Klego, Kabupaten Boyolali. Portal Digital Informasi Profil, Potensi Ekonomi, UMKM, dan Layanan Kesehatan Satu Pintu.">
    <meta name="keywords" content="Banyuurip, Boyolali, Desa Banyuurip, KKN Undip, RESPIRA, UMKM Banyuurip, APBDes Banyuurip">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS v4 Browser Compiler CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <!-- Custom CSS Styles -->
    <style type="tailwindcss">
        @theme {
            --color-brand-green: #0f766e; /* Emerald 700 */
            --color-brand-green-light: #14b8a6; /* Teal 500 */
            --color-brand-blue: #0369a1; /* Sky 700 */
            --color-brand-blue-light: #38bdf8; /* Sky 400 */
            --color-brand-dark: #0f172a; /* Slate 900 */
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .text-gradient-green-blue {
            background: linear-gradient(135deg, #0d9488 0%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .bg-gradient-premium {
            background: linear-gradient(135deg, #f0fdf4 0%, #f0f9ff 100%);
        }
        
        .bg-dot-grid {
            background-image: radial-gradient(rgba(15, 118, 110, 0.1) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        
        .card-hover-effect {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover-effect:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(15, 118, 110, 0.25);
        }
        
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    
    <!-- Alpine.js & Chart.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full flex flex-col bg-slate-50 text-slate-900 font-sans antialiased bg-dot-grid" x-data="{ mobileMenuOpen: false }">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="mx-auto max-w-[92rem] px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-2">
                <!-- Logo / Brand -->
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white p-1 shadow-xs border border-slate-200/80">
                            <img src="{{ asset('images/logo-boyolali.jpg') }}" alt="Logo Kabupaten Boyolali" class="h-8 w-auto object-contain">
                        </div>
                        <div>
                            <span class="text-base font-extrabold tracking-tight text-slate-900 block leading-tight">Desa Banyuurip</span>
                            <span class="block text-[9px] font-bold tracking-widest text-emerald-700 uppercase mt-0.5 leading-none">Digital Gateway</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden lg:flex items-center gap-3 xl:gap-5 whitespace-nowrap">
                    <a href="{{ route('home') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('home') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">Beranda</a>
                    <a href="{{ route('profil') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('profil') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">Profil & Sejarah</a>
                    <a href="{{ route('kesehatan') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('kesehatan') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">Kesehatan (RESPIRA)</a>
                    <a href="{{ route('agribisnis') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('agribisnis') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">Agribisnis</a>
                    <a href="{{ route('keuangan') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('keuangan') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">Keuangan & APBDes</a>
                    <a href="{{ route('desa-antikorupsi') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('desa-antikorupsi') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">Desa Antikorupsi</a>
                    <a href="{{ route('umkm') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('umkm') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">UMKM Desa</a>
                    <a href="{{ route('edukasi5s') }}" class="whitespace-nowrap text-[13px] font-semibold transition-colors {{ Route::is('edukasi5s') ? 'text-brand-green font-bold' : 'text-slate-600 hover:text-brand-green' }}">Budaya 5S</a>
                </nav>

                <!-- Admin Button / Actions -->
                <div class="hidden lg:flex items-center gap-2 shrink-0">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('admin') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-3 py-2 text-xs font-bold text-white shadow-xs hover:bg-slate-800 transition-colors whitespace-nowrap">
                            <i data-lucide="layout-dashboard" class="h-3.5 w-3.5"></i>
                            <span>Dashboard Admin</span>
                        </a>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 rounded-xl bg-rose-600 hover:bg-rose-500 px-2.5 py-2 text-xs font-bold text-white shadow-xs transition-colors cursor-pointer whitespace-nowrap" title="Keluar">
                                <i data-lucide="log-out" class="h-3.5 w-3.5"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('admin') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-900 px-3.5 py-2 text-xs font-bold text-white shadow-xs hover:bg-slate-800 transition-colors whitespace-nowrap">
                            <i data-lucide="user-cog" class="h-3.5 w-3.5"></i>
                            <span>Admin Panel</span>
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-700 hover:bg-slate-100 hover:text-slate-900 focus:outline-none">
                        <span class="sr-only">Buka Menu</span>
                        <i data-lucide="menu" class="h-6 w-6" x-show="!mobileMenuOpen"></i>
                        <i data-lucide="x" class="h-6 w-6" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="lg:hidden glass-panel border-t border-slate-200" x-show="mobileMenuOpen" x-transition x-cloak>
            <div class="space-y-1 px-4 py-3">
                <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('home') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">Beranda</a>
                <a href="{{ route('profil') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('profil') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">Profil & Sejarah</a>
                <a href="{{ route('kesehatan') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('kesehatan') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">Kesehatan (RESPIRA)</a>
                <a href="{{ route('agribisnis') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('agribisnis') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">Agribisnis</a>
                <a href="{{ route('keuangan') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('keuangan') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">Keuangan & APBDes</a>
                <a href="{{ route('desa-antikorupsi') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('desa-antikorupsi') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">Desa Antikorupsi</a>
                <a href="{{ route('umkm') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('umkm') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">UMKM Desa</a>
                <a href="{{ route('edukasi5s') }}" class="block rounded-lg px-3 py-2 text-base font-semibold {{ Route::is('edukasi5s') ? 'bg-emerald-50 text-brand-green' : 'text-slate-700 hover:bg-slate-50' }}">Budaya 5S</a>
                <div class="border-t border-slate-200 my-2 pt-2 space-y-2">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('admin') }}" class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-slate-900 py-2.5 text-sm font-semibold text-white">
                            <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                            <span>Dashboard Admin</span>
                        </a>
                        <form action="{{ route('admin.logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-rose-600 py-2.5 text-sm font-semibold text-white cursor-pointer">
                                <i data-lucide="log-out" class="h-4 w-4"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('admin') }}" class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-slate-900 py-2.5 text-sm font-semibold text-white">
                            <i data-lucide="user-cog" class="h-4 w-4"></i>
                            <span>Admin Panel</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Area -->
    <footer class="mt-auto bg-slate-900 text-slate-400 border-t border-slate-800">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Info Desa -->
                <div>
                    <div class="flex items-center gap-2 text-white font-bold text-lg mb-4">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-600">
                            <i data-lucide="shield-check" class="h-5 w-5"></i>
                        </div>
                        <span>Pemerintah Desa Banyuurip</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-4">
                        Kecamatan Klego, Kabupaten Boyolali, Provinsi Jawa Tengah. Wadah transparansi pembangunan, ketahanan ekonomi, dan peningkatan kualitas kesehatan masyarakat.
                    </p>
                    <div class="flex gap-3 text-slate-300">
                        <i data-lucide="map-pin" class="h-5 w-5 text-emerald-500"></i>
                        <span class="text-sm">Kantor Kepala Desa Banyuurip, Klego, Boyolali</span>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div class="md:ml-auto">
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Navigasi Portal</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('profil') }}" class="hover:text-white transition-colors">Profil & Sejarah</a></li>
                        <li><a href="{{ route('kesehatan') }}" class="hover:text-white transition-colors">Kesehatan ISPA (RESPIRA)</a></li>
                        <li><a href="{{ route('agribisnis') }}" class="hover:text-white transition-colors">Agribisnis & Tanam</a></li>
                        <li><a href="{{ route('keuangan') }}" class="hover:text-white transition-colors">APBDes & Keuangan</a></li>
                        <li><a href="{{ route('desa-antikorupsi') }}" class="hover:text-white transition-colors font-semibold text-emerald-400">Desa Antikorupsi KPK</a></li>
                        <li><a href="{{ route('umkm') }}" class="hover:text-white transition-colors">Direktori UMKM Desa</a></li>
                    </ul>
                </div>

                <!-- KKN Credit -->
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Tim KKN Pembina</h3>
                    <p class="text-sm leading-relaxed mb-4">
                        Dikembangkan oleh <strong>Tim II KKN Universitas Diponegoro 2026</strong> sebagai bentuk sumbangsih pengabdian multidisiplin untuk kemajuan tata kelola digital Desa Banyuurip.
                    </p>
                    <div class="rounded-xl bg-slate-800 p-4 border border-slate-700/50">
                        <span class="block text-xs text-emerald-400 font-semibold tracking-wider uppercase">Fakultas / Prodi Terlibat:</span>
                        <p class="text-xs mt-1 leading-relaxed text-slate-300">
                            Informatika, Keperawatan, Sejarah, Agribisnis, Teknik Mesin, Ilmu Hukum, Akuntansi Perpajakan, Sastra Jepang, Ilmu Komunikasi, Manajemen Logistik, Akuntansi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="mt-8 border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs">
                <p>&copy; 2026 Pemerintah Desa Banyuurip & Tim KKN Undip. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4 mt-4 sm:mt-0">
                    <a href="{{ route('admin') }}" class="hover:text-white transition-colors flex items-center gap-1">
                        <i data-lucide="lock" class="h-3 w-3"></i> Admin Login (Demo)
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
