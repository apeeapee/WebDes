<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Desa Banyuurip, Boyolali</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#0f766e',
                        'brand-green-light': '#14b8a6',
                        'brand-dark': '#0f172a',
                    }
                }
            }
        }
    </script>
    
    <!-- AlpineJS via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-900 bg-slate-100/50">

    <div class="flex h-screen overflow-hidden" x-data="{ 
        mobileSidebarOpen: false,
        activeGroup: '{{ request()->routeIs('admin.komoditas.*') || request()->routeIs('admin.asettani.*') ? 'agribisnis' : (request()->routeIs('admin.sejarah.*') || request()->routeIs('admin.perangkat.*') ? 'profil' : (request()->routeIs('admin.regulasi.*') || request()->routeIs('admin.apbdes.*') ? 'keuangan' : '')) }}',
        toggleGroup(group) {
            this.activeGroup = this.activeGroup === group ? '' : group;
        }
    }">
        <!-- Sidebar for Desktop -->
        <aside class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 left-0 bg-[#F8F9FA] text-slate-800 border-r border-slate-200/80 z-20">
            <!-- Sidebar Header with Sparkles -->
            <div class="flex h-16 items-center px-6 justify-between border-b border-slate-200/60">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-white p-0.5 shadow-sm border border-slate-200">
                        <img src="{{ asset('images/logo-boyolali.jpg') }}" alt="Logo Boyolali" class="h-6 w-auto object-contain">
                    </div>
                    <div>
                        <span class="text-sm font-extrabold tracking-tight block leading-tight text-slate-900">Banyuurip</span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider block">Panel Pengelola</span>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 space-y-1.5 px-4 py-6 overflow-y-auto">
                <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider px-3 mb-2">Utama</div>
                
                <a href="{{ route('admin') }}"
                    class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 {{ request()->routeIs('admin') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-900' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    <span>Ikhtisar Data</span>
                </a>

                <div class="pt-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider px-3 mb-2">Kelola Portal</div>

                <!-- 1. Berita -->
                <a href="{{ route('admin.berita.index') }}"
                    class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 {{ request()->routeIs('admin.berita.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-900' }}">
                    <i data-lucide="newspaper" class="h-4 w-4"></i>
                    <span>Kelola Berita</span>
                </a>

                <!-- 2. Profile Dropdown Group -->
                <div>
                    <button @click="toggleGroup('profil')"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-xs font-bold text-slate-600 hover:bg-slate-200/50 hover:text-slate-900 transition-all duration-200 cursor-pointer">
                        <span class="flex items-center gap-3">
                            <i data-lucide="user-square-2" class="h-4 w-4"></i>
                            <span>Portal Profil Desa</span>
                        </span>
                        <i data-lucide="chevron-down" class="h-3 w-3 transition-transform duration-200" :class="activeGroup === 'profil' ? 'rotate-180' : ''"></i>
                    </button>
                    <!-- Sub-menu Items -->
                    <div x-show="activeGroup === 'profil'" x-transition class="mt-1 border-l-1.5 border-slate-200/80 ml-5.5 pl-3.5 space-y-1 py-1" x-cloak>
                        <a href="{{ route('admin.sejarah.index') }}"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.sejarah.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200/40 hover:text-slate-900' }}">
                            <i data-lucide="history" class="h-3.5 w-3.5"></i>
                            <span>Kelola Sejarah</span>
                        </a>
                        <a href="{{ route('admin.perangkat.index') }}"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.perangkat.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200/40 hover:text-slate-900' }}">
                            <i data-lucide="users-2" class="h-3.5 w-3.5"></i>
                            <span>Perangkat Desa</span>
                        </a>
                    </div>
                </div>

                <!-- 3. Agribisnis Dropdown Group -->
                <div>
                    <button @click="toggleGroup('agribisnis')"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-xs font-bold text-slate-600 hover:bg-slate-200/50 hover:text-slate-900 transition-all duration-200 cursor-pointer">
                        <span class="flex items-center gap-3">
                            <i data-lucide="sprout" class="h-4 w-4"></i>
                            <span>Portal Agribisnis</span>
                        </span>
                        <i data-lucide="chevron-down" class="h-3 w-3 transition-transform duration-200" :class="activeGroup === 'agribisnis' ? 'rotate-180' : ''"></i>
                    </button>
                    <!-- Sub-menu Items -->
                    <div x-show="activeGroup === 'agribisnis'" x-transition class="mt-1 border-l-1.5 border-slate-200/80 ml-5.5 pl-3.5 space-y-1 py-1" x-cloak>
                        <a href="{{ route('admin.komoditas.index') }}"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.komoditas.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200/40 hover:text-slate-900' }}">
                            <i data-lucide="wheat" class="h-3.5 w-3.5"></i>
                            <span>Komoditas Tani</span>
                        </a>
                        <a href="{{ route('admin.asettani.index') }}"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.asettani.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200/40 hover:text-slate-900' }}">
                            <i data-lucide="wrench" class="h-3.5 w-3.5"></i>
                            <span>Aset Mesin Tani</span>
                        </a>
                    </div>
                </div>

                <!-- 4. Keuangan Dropdown Group -->
                <div>
                    <button @click="toggleGroup('keuangan')"
                        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-2xl text-xs font-bold text-slate-600 hover:bg-slate-200/50 hover:text-slate-900 transition-all duration-200 cursor-pointer">
                        <span class="flex items-center gap-3">
                            <i data-lucide="wallet" class="h-4 w-4"></i>
                            <span>Portal Transparansi</span>
                        </span>
                        <i data-lucide="chevron-down" class="h-3 w-3 transition-transform duration-200" :class="activeGroup === 'keuangan' ? 'rotate-180' : ''"></i>
                    </button>
                    <!-- Sub-menu Items -->
                    <div x-show="activeGroup === 'keuangan'" x-transition class="mt-1 border-l-1.5 border-slate-200/80 ml-5.5 pl-3.5 space-y-1 py-1" x-cloak>
                        <a href="{{ route('admin.regulasi.index') }}"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.regulasi.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200/40 hover:text-slate-900' }}">
                            <i data-lucide="file-check" class="h-3.5 w-3.5"></i>
                            <span>Regulasi Hukum</span>
                        </a>
                        <a href="{{ route('admin.apbdes.index') }}"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.apbdes.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-200/40 hover:text-slate-900' }}">
                            <i data-lucide="pie-chart" class="h-3.5 w-3.5"></i>
                            <span>Anggaran APBDes</span>
                        </a>
                    </div>
                </div>

                <!-- 5. UMKM -->
                <a href="{{ route('admin.umkm.index') }}"
                    class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 {{ request()->routeIs('admin.umkm.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-900' }}">
                    <i data-lucide="shopping-bag" class="h-4 w-4"></i>
                    <span>Direktori UMKM</span>
                </a>

                <!-- 6. Kesehatan -->
                <a href="{{ route('admin.skrining.index') }}"
                    class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 {{ request()->routeIs('admin.skrining.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-900' }}">
                    <i data-lucide="heart-pulse" class="h-4 w-4"></i>
                    <span>Log Skrining ISPA</span>
                </a>
            </nav>
            
            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-slate-200/60">
                <div class="flex items-center gap-3 px-2 py-2 mb-3 bg-slate-200/30 rounded-2xl border border-slate-200">
                    <div class="h-8 w-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-slate-900 truncate leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-500 truncate leading-tight">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm cursor-pointer">
                        <i data-lucide="log-out" class="h-3.5 w-3.5"></i>
                        <span>Keluar Admin</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar / Drawer -->
        <div class="md:hidden" x-show="mobileSidebarOpen" x-transition x-cloak>
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 z-30" @click="mobileSidebarOpen = false"></div>
            <!-- Drawer Content -->
            <aside class="fixed inset-y-0 left-0 w-64 bg-[#F8F9FA] text-slate-855 z-40 flex flex-col border-r border-slate-200">
                <div class="flex h-16 items-center px-6 border-b border-slate-200/60 gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-white p-0.5 shadow-sm border border-slate-200">
                        <img src="{{ asset('images/logo-boyolali.jpg') }}" alt="Logo Boyolali" class="h-6 w-auto object-contain">
                    </div>
                    <div>
                        <span class="text-sm font-extrabold tracking-tight block text-slate-900">Banyuurip</span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider block">Panel Pengelola</span>
                    </div>
                </div>
                <nav class="flex-1 space-y-1.5 px-4 py-6 overflow-y-auto">
                    <a href="{{ route('admin') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 {{ request()->routeIs('admin') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-900' }}">
                        <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                        <span>Ikhtisar Data</span>
                    </a>

                    <a href="{{ route('admin.berita.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all duration-200 {{ request()->routeIs('admin.berita.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="newspaper" class="h-4 w-4"></i>
                        <span>Kelola Berita</span>
                    </a>

                    <!-- Sub-menus rendered flat for Mobile for ease of touch target -->
                    <div class="h-px bg-slate-200 my-2"></div>
                    <a href="{{ route('admin.sejarah.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.sejarah.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="history" class="h-4 w-4"></i>
                        <span>Kelola Sejarah</span>
                    </a>
                    <a href="{{ route('admin.perangkat.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.perangkat.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="users-2" class="h-4 w-4"></i>
                        <span>Perangkat Desa</span>
                    </a>
                    <div class="h-px bg-slate-200 my-2"></div>
                    <a href="{{ route('admin.komoditas.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.komoditas.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="wheat" class="h-4 w-4"></i>
                        <span>Komoditas Tani</span>
                    </a>
                    <a href="{{ route('admin.asettani.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.asettani.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="wrench" class="h-4 w-4"></i>
                        <span>Aset Mesin Tani</span>
                    </a>
                    <div class="h-px bg-slate-200 my-2"></div>
                    <a href="{{ route('admin.regulasi.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.regulasi.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="file-check" class="h-4 w-4"></i>
                        <span>Regulasi Hukum</span>
                    </a>
                    <a href="{{ route('admin.apbdes.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.apbdes.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="pie-chart" class="h-4 w-4"></i>
                        <span>Anggaran APBDes</span>
                    </a>
                    <div class="h-px bg-slate-200 my-2"></div>
                    <a href="{{ route('admin.umkm.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.umkm.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="shopping-bag" class="h-4 w-4"></i>
                        <span>Direktori UMKM</span>
                    </a>
                    <a href="{{ route('admin.skrining.index') }}" @click="mobileSidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.skrining.*') ? 'bg-slate-950 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-200/50' }}">
                        <i data-lucide="heart-pulse" class="h-4 w-4"></i>
                        <span>Log Skrining ISPA</span>
                    </a>
                </nav>
                <div class="p-4 border-t border-slate-200">
                    <div class="flex items-center gap-3 px-2 py-2 mb-3 bg-slate-200/30 rounded-2xl border border-slate-200">
                        <div class="h-8 w-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-slate-900 truncate leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500 truncate leading-tight">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="block w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm cursor-pointer">
                            <i data-lucide="log-out" class="h-3.5 w-3.5"></i>
                            <span>Keluar Admin</span>
                        </button>
                    </form>
                </div>
            </aside>
        </div>

        <!-- Main Content Area Wrapper -->
        <div class="flex flex-1 flex-col md:pl-64 font-sans">
            <!-- Topbar Header -->
            <header class="sticky top-0 z-10 flex h-16 shrink-0 bg-[#F8F9FA] shadow-sm border-b border-slate-200/60 px-4 sm:px-6 lg:px-8 items-center justify-between">
                <div class="flex items-center gap-3">
                    <button @click="mobileSidebarOpen = true" class="md:hidden inline-flex items-center justify-center rounded-lg p-2 text-slate-700 hover:bg-slate-200/50 focus:outline-none">
                        <i data-lucide="menu" class="h-5 w-5"></i>
                    </button>
                    
                    <div>
                        <h1 class="text-xs sm:text-sm font-bold tracking-tight text-slate-900">
                            @yield('page_title', 'Dashboard Admin')
                        </h1>
                        <p class="text-[9px] text-slate-500 font-medium">
                            @yield('page_subtitle', 'Kelola data dan layanan portal desa')
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1 rounded-full bg-slate-900 px-2 py-0.5 text-[9px] font-bold text-slate-100 border border-slate-950">
                        <span class="h-1 w-1 rounded-full bg-amber-400 animate-pulse"></span>
                        Admin Mode
                    </span>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 px-3.5 py-2 text-xs font-bold text-slate-800 shadow-xs transition-colors">
                        <i data-lucide="external-link" class="h-3.5 w-3.5 text-slate-600"></i>
                        <span>Portal Publik</span>
                    </a>
                </div>
            </header>

            <!-- Main Content Grid -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Status Alerts -->
                @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs flex items-center gap-2 shadow-xs animate-fade-in">
                    <i data-lucide="check-circle" class="h-5 w-5 text-emerald-600"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-800 text-xs space-y-1.5 shadow-xs">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <i data-lucide="alert-circle" class="h-4.5 w-4.5 text-rose-600 shrink-0"></i>
                            <span class="font-bold">{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

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
