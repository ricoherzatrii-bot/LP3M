@extends('layouts.app')
@section('title', 'Dokumen SPMI - LPM Politeknik Jambi')
@section('content')

<div class="relative min-h-screen bg-slate-900 pb-24 font-sans overflow-hidden">

    {{-- ===== BACKGROUND ===== --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gedung-poljam.png') }}"
             class="w-full h-full object-cover opacity-30" alt="Politeknik Jambi">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/95 via-slate-900/80 to-slate-900"></div>
    </div>

    {{-- ===== HERO HEADER ===== --}}
    <div class="relative z-10 border-b border-white/10 bg-gradient-to-r from-blue-900/40 via-slate-900/60 to-indigo-900/40 py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-16">
            <div class="flex items-center gap-3 text-blue-400 text-xs font-bold uppercase tracking-widest mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right text-[8px]"></i>
                <span>SPMI</span>
                <i class="fas fa-chevron-right text-[8px]"></i>
                <span class="text-white">Dokumen SPMI</span>
            </div>
            <div class="flex flex-col md:flex-row items-start md:items-end gap-6 justify-between">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-3" style="font-family: 'Playfair Display', serif;">
                        Dokumen SPMI
                    </h1>
                    <p class="text-slate-400 text-base max-w-2xl leading-relaxed">
                        Kumpulan dokumen Sistem Penjaminan Mutu Internal (SPMI) Politeknik Jambi.
                        Unduh dokumen yang tersedia untuk keperluan audit, evaluasi, dan referensi mutu.
                    </p>
                </div>
                <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-2xl px-5 py-3 backdrop-blur-md">
                    <i class="fas fa-file-alt text-blue-400 text-2xl"></i>
                    <div>
                        <div class="text-2xl font-black text-white">{{ $dokumen->count() }}</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Dokumen</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16 py-12">

        <div class="grid lg:grid-cols-4 gap-10">

            {{-- SIDEBAR FILTER --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Filter Card --}}
                <div class="bg-slate-800/60 backdrop-blur-md rounded-3xl border border-white/10 p-6 sticky top-6">
                    <h3 class="text-white font-bold text-lg mb-5 flex items-center gap-2">
                        <i class="fas fa-filter text-blue-400 text-sm"></i> Filter Dokumen
                    </h3>

                    <form method="GET" action="{{ route('spmi.dokumen') }}" id="filterForm">
                        {{-- Filter Tahun --}}
                        <div class="mb-5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Tahun</label>
                            <select name="tahun" onchange="document.getElementById('filterForm').submit()"
                                class="w-full bg-slate-700/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition appearance-none">
                                <option value="">Semua Tahun</option>
                                @foreach($tahunList as $th)
                                    <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Kategori --}}
                        @if($kategoriList->count() > 1)
                        <div class="mb-5">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Kategori</label>
                            <select name="kategori" onchange="document.getElementById('filterForm').submit()"
                                class="w-full bg-slate-700/60 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition appearance-none">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(request('tahun') || request('kategori'))
                        <a href="{{ route('spmi.dokumen') }}" 
                           class="flex items-center gap-2 text-xs font-bold text-rose-400 hover:text-rose-300 transition mt-3">
                            <i class="fas fa-times-circle"></i> Reset Filter
                        </a>
                        @endif
                    </form>

                    {{-- Stats per tahun --}}
                    @if($tahunList->count() > 0)
                    <div class="mt-6 pt-5 border-t border-white/10">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Dokumen Per Tahun</div>
                        <div class="space-y-2">
                            @foreach($tahunList->take(6) as $th)
                            @php $countTh = \App\Models\DokumenSpmi::where('tahun', $th)->count(); @endphp
                            <div class="flex items-center justify-between text-sm">
                                <a href="{{ route('spmi.dokumen', ['tahun' => $th]) }}"
                                   class="text-slate-400 hover:text-blue-400 transition font-medium">{{ $th }}</a>
                                <span class="bg-blue-500/20 text-blue-300 text-[10px] font-bold px-2 py-0.5 rounded-lg">{{ $countTh }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>



            </div>

            {{-- MAIN DOKUMEN LIST --}}
            <div class="lg:col-span-3">

                {{-- Active Filter Badge --}}
                @if(request('tahun') || request('kategori'))
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span class="text-slate-400 text-sm">Filter aktif:</span>
                    @if(request('tahun'))
                    <span class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-500/30 text-blue-300 text-xs font-bold px-3 py-1.5 rounded-xl">
                        <i class="fas fa-calendar text-[10px]"></i> Tahun {{ request('tahun') }}
                    </span>
                    @endif
                    @if(request('kategori'))
                    <span class="inline-flex items-center gap-2 bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-xs font-bold px-3 py-1.5 rounded-xl">
                        <i class="fas fa-tag text-[10px]"></i> {{ request('kategori') }}
                    </span>
                    @endif
                    <span class="text-slate-500 text-xs">{{ $dokumen->count() }} dokumen ditemukan</span>
                </div>
                @endif

                @if($dokumen->count() > 0)

                {{-- Group by Tahun --}}
                @foreach($dokumen->groupBy('tahun') as $tahun => $docs)
                <div class="mb-10">
                    {{-- Year Header --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <i class="fas fa-calendar-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xl font-black text-white">{{ $tahun }}</div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $docs->count() }} dokumen</div>
                            </div>
                        </div>
                        <div class="flex-1 h-px bg-gradient-to-r from-white/10 to-transparent"></div>
                    </div>

                    {{-- Documents Table --}}
                    <div class="bg-slate-800/40 backdrop-blur-md border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white/5 border-b border-white/10">
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Dokumen</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-32">Format</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-32 text-center">Hits</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-40 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($docs as $dok)
                                    <tr class="group hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-slate-700/50 border border-white/10 flex items-center justify-center group-hover:border-blue-500/30 transition-all">
                                                    @php
                                                        $iconClass = match($dok->tipe_file) {
                                                            'pdf'  => 'fas fa-file-pdf text-red-400',
                                                            'doc', 'docx' => 'fas fa-file-word text-blue-400',
                                                            'xls', 'xlsx' => 'fas fa-file-excel text-green-400',
                                                            'ppt', 'pptx' => 'fas fa-file-powerpoint text-orange-400',
                                                            'zip', 'rar'  => 'fas fa-file-archive text-yellow-400',
                                                            default        => 'fas fa-file-alt text-slate-400',
                                                        };
                                                    @endphp
                                                    <i class="{{ $iconClass }} text-lg"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-white font-bold text-sm truncate group-hover:text-blue-300 transition-colors" title="{{ $dok->judul }}">
                                                        {{ $dok->judul }}
                                                    </div>
                                                    @if($dok->kategori && $dok->kategori !== 'Dokumen SPMI')
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">{{ $dok->kategori }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">{{ $dok->tipe_file ?? 'FILE' }}</span>
                                                <span class="text-[10px] text-slate-500">{{ $dok->ukuran_file ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="text-xs font-medium text-slate-400">{{ number_format($dok->downloads) }} <i class="fas fa-download text-[10px] ml-1 opacity-50"></i></span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            @if($dok->path_file)
                                            <a href="{{ route('dokumen_spmi.download', $dok->id) }}"
                                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all hover:shadow-lg hover:shadow-blue-500/30 active:scale-95 group/btn">
                                                <i class="fas fa-download group-hover:translate-y-0.5 transition-transform"></i> Unduh
                                            </a>
                                            @else
                                            <span class="text-[10px] font-bold text-slate-600 italic">Not Available</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach

                @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-24 h-24 rounded-3xl bg-slate-800/60 border border-white/10 flex items-center justify-center mb-6">
                        <i class="fas fa-folder-open text-4xl text-slate-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Belum Ada Dokumen</h3>
                    <p class="text-slate-500 text-sm max-w-sm leading-relaxed">
                        @if(request('tahun') || request('kategori'))
                            Tidak ada dokumen yang sesuai dengan filter yang dipilih. Coba ubah filter atau
                            <a href="{{ route('spmi.dokumen') }}" class="text-blue-400 hover:underline">tampilkan semua dokumen</a>.
                        @else
                            Dokumen SPMI akan segera tersedia. Silakan kunjungi kembali beberapa saat lagi.
                        @endif
                    </p>
                </div>
                @endif

            </div>{{-- end main --}}
        </div>{{-- end grid --}}
    </div>{{-- end container --}}
</div>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
select option { background: #1e293b; color: #fff; }
</style>

@endsection
