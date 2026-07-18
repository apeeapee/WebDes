@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-dot-grid relative">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(15,118,110,0.08),transparent_70%)]"></div>
    
    <div class="w-full max-w-md space-y-8 glass-panel p-8 rounded-2xl shadow-xl border border-slate-200/50 relative z-10">
        <div>
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-tr from-brand-green to-brand-green-light text-white shadow-md">
                <i data-lucide="lock" class="h-6 w-6"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold tracking-tight text-slate-900">
                Login Admin
            </h2>
            <p class="mt-2 text-center text-xs text-slate-500">
                Pintu gerbang tata kelola digital Desa Banyuurip
            </p>
        </div>

        @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 text-xs flex items-center gap-2">
            <i data-lucide="alert-circle" class="h-5 w-5 text-rose-600"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-circle" class="h-4 w-4 text-rose-600 shrink-0"></i>
                    <span>{{ $error }}</span>
                </div>
            @endforeach
        </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="h-4 w-4"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white/70 text-sm placeholder-slate-400 focus:border-brand-green focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-green transition-all"
                            placeholder="admin@banyuurip.desa.id">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="key-round" class="h-4 w-4"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white/70 text-sm placeholder-slate-400 focus:border-brand-green focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-green transition-all"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-950 transition-all shadow-md cursor-pointer">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i data-lucide="log-in" class="h-4 w-4 text-slate-400 group-hover:text-slate-300 transition-colors"></i>
                    </span>
                    Masuk ke Dashboard
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
