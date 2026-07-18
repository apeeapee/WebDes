@extends('layouts.admin')

@section('page_title', 'Ikhtisar Data Desa')
@section('page_subtitle', 'Statistik, berita, dan log skrining kesehatan warga')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Total Warga</span>
                <strong class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ number_format($stats['total_warga']) }}</strong>
            </div>
            <div class="h-10 w-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="users" class="h-5 w-5"></i>
            </div>
        </div>
        
        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Skrining ISPA</span>
                <strong class="text-2xl font-extrabold text-indigo-600 mt-1 block">{{ $stats['total_screening_ispa'] }}</strong>
            </div>
            <div class="h-10 w-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="activity" class="h-5 w-5"></i>
            </div>
        </div>

        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Risiko Tinggi</span>
                <strong class="text-2xl font-extrabold text-rose-600 mt-1 block">{{ $stats['skrining_risiko_tinggi'] }}</strong>
            </div>
            <div class="h-10 w-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="h-5 w-5"></i>
            </div>
        </div>

        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">UMKM Terdaftar</span>
                <strong class="text-2xl font-extrabold text-amber-600 mt-1 block">{{ $stats['umkm_aktif'] }}</strong>
            </div>
            <div class="h-10 w-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="shopping-bag" class="h-5 w-5"></i>
            </div>
        </div>
    </div>

    <!-- More Stats Details -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Dokumen Regulasi</span>
                <strong class="text-lg font-extrabold text-slate-800 mt-1 block">{{ $stats['dokumen_hukum'] }} File</strong>
            </div>
            <div class="h-9 w-9 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center">
                <i data-lucide="file-text" class="h-4.5 w-4.5"></i>
            </div>
        </div>

        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Warta Berita</span>
                <strong class="text-lg font-extrabold text-slate-800 mt-1 block">{{ $stats['total_berita'] }} Artikel</strong>
            </div>
            <div class="h-9 w-9 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center">
                <i data-lucide="newspaper" class="h-4.5 w-4.5"></i>
            </div>
        </div>

        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Perangkat Desa</span>
                <strong class="text-lg font-extrabold text-slate-800 mt-1 block">{{ $stats['total_perangkat'] }} Jiwa</strong>
            </div>
            <div class="h-9 w-9 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center">
                <i data-lucide="users" class="h-4.5 w-4.5"></i>
            </div>
        </div>

        <div class="rounded-xl bg-white p-5 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Komoditas Utama</span>
                <strong class="text-lg font-extrabold text-slate-800 mt-1 block">{{ $stats['total_komoditas'] }} Varian</strong>
            </div>
            <div class="h-9 w-9 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center">
                <i data-lucide="sprout" class="h-4.5 w-4.5"></i>
            </div>
        </div>
    </div>

    <!-- Log Skrining Terkini -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200/60 flex items-center justify-between">
            <span class="font-bold text-slate-850 text-sm flex items-center gap-1.5">
                <i data-lucide="clipboard-list" class="h-4.5 w-4.5 text-indigo-600"></i>
                Log Hasil Skrining Mandiri ISPA (Terbaru)
            </span>
            <span class="inline-flex items-center rounded bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700">Tindakan Rujukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50/50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Nama Warga</th>
                        <th scope="col" class="px-6 py-3.5">Usia</th>
                        <th scope="col" class="px-6 py-3.5">Risiko</th>
                        <th scope="col" class="px-6 py-3.5">Tanggal Input</th>
                        <th scope="col" class="px-6 py-3.5">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recent_screenings as $sc)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <th scope="row" class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                            {{ $sc->nama_warga }}
                        </th>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $sc->usia }} Tahun
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border {{ $sc->risiko === 'Tinggi' ? 'bg-rose-50 text-rose-700 border-rose-200' : ($sc->risiko === 'Sedang' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200') }}">
                                {{ $sc->risiko }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $sc->created_at->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-700 font-semibold flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full {{ $sc->risiko === 'Tinggi' ? 'bg-rose-500' : ($sc->risiko === 'Sedang' ? 'bg-amber-500' : 'bg-emerald-500') }}"></span>
                                {{ $sc->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-medium">
                            <i data-lucide="inbox" class="h-8 w-8 mx-auto mb-2 opacity-50"></i>
                            Belum ada log skrining masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
