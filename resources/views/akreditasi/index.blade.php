@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-32 pb-20 transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-blue-600 block mb-2">Internal Quality Assurance</span>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">
                    Status Akreditasi Program Studi
                </h1>
                <p class="text-slate-500 mt-2">
                    Daftar peringkat akreditasi resmi untuk seluruh program studi di Politeknik Jambi.
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-900 px-5 py-3 rounded-2xl border border-slate-100 dark:border-white/10 shadow-sm self-start">
                <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Terintegrasi Sistem BAN-PT</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-white/10 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 dark:bg-slate-800 text-white text-[11px] font-bold uppercase tracking-wider border-b border-slate-800 dark:border-white/5">
                            <th class="py-5 px-8">No</th>
                            <th class="py-5 px-6">Nama Program Studi</th>
                            <th class="py-5 px-6">Peringkat Akreditasi</th>
                            <th class="py-5 px-6">Masa Berlaku (Kedaluwarsa)</th>
                            <th class="py-5 px-8 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-sm">
                        @forelse($data as $key => $item)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-white/5 transition-colors">
                            <td class="py-5 px-8 font-bold text-slate-400">{{ $key + 1 }}</td>
                            <td class="py-5 px-6">
                                <div class="font-extrabold text-slate-900 dark:text-slate-100">{{ $item->judul }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">Politeknik Jambi</div>
                            </td>
                            <td class="py-5 px-6">
                                @if(strtolower($item->peringkat) === 'unggul')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/30">
                                        <i class="fas fa-crown text-[10px]"></i> Unggul
                                    </span>
                                @elseif(str_contains(strtolower($item->peringkat), 'sekali'))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800/30">
                                        <i class="fas fa-star text-[10px]"></i> Baik Sekali
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/30">
                                        <i class="fas fa-check-circle text-[10px]"></i> {{ $item->peringkat ?? 'Terakreditasi' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 px-6 text-slate-500 font-medium">
                                {{ $item->tanggal_kedaluwarsa ? \Carbon\Carbon::parse($item->tanggal_kedaluwarsa)->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="py-5 px-8 text-right">
                                <a href="https://banpt.or.id" target="_blank" class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-xs font-bold text-blue-600 hover:bg-blue-50 transition">
                                    Cek BAN-PT <i class="fas fa-external-link-alt text-[9px]"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <i class="fas fa-folder-open text-3xl opacity-30"></i>
                                    <span>Belum ada data akreditasi yang tersimpan.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection