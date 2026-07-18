@extends('layouts.admin')

@section('page_title', 'Log Skrining Kesehatan Mandiri')
@section('page_subtitle', 'Pantau log hasil skrining mandiri ISPA (RESPIRA) yang disubmit oleh warga desa')

@section('content')
<div class="space-y-6">
    <!-- Table -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold text-slate-700 uppercase border-b border-slate-200/60">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Nama Warga</th>
                        <th scope="col" class="px-6 py-3.5">Usia</th>
                        <th scope="col" class="px-6 py-3.5">Risiko</th>
                        <th scope="col" class="px-6 py-3.5">Gejala Terdeteksi</th>
                        <th scope="col" class="px-6 py-3.5">Tanggal Input</th>
                        <th scope="col" class="px-6 py-3.5">Tindakan/Status</th>
                        <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                            {{ $item->nama_warga }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                            {{ $item->usia }} Tahun
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border {{ $item->risiko === 'Tinggi' ? 'bg-rose-50 text-rose-700 border-rose-200' : ($item->risiko === 'Sedang' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200') }}">
                                {{ $item->risiko }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600 max-w-xs">
                            <div class="flex flex-wrap gap-1">
                                @if(is_array($item->gejala))
                                    @foreach($item->gejala as $g)
                                    <span class="bg-slate-100 text-slate-700 rounded px-1.5 py-0.5 text-[10px]">{{ $g }}</span>
                                    @endforeach
                                @else
                                    <span class="text-slate-400">Tidak ada gejala</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                            {{ $item->created_at->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs text-slate-700 font-semibold flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full {{ $item->risiko === 'Tinggi' ? 'bg-rose-500' : ($item->risiko === 'Sedang' ? 'bg-amber-500' : 'bg-emerald-500') }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <form action="{{ route('admin.skrining.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data skrining ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-rose-50 rounded-lg text-slate-500 hover:text-rose-600 transition-colors cursor-pointer" title="Hapus">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400 font-medium">
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
