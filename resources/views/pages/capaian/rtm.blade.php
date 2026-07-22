@extends('layouts.app')
@section('title', 'RTM - LPM Politeknik Jambi')
@section('content')

<div class="relative min-h-screen bg-white dark:bg-slate-950 pb-24 font-sans overflow-hidden transition-colors duration-500">

    {{-- ===== BACKGROUND ===== --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gedung-poljam.png') }}"
             class="w-full h-full object-cover opacity-10 dark:opacity-40" alt="Politeknik Jambi">
        <div class="absolute inset-0 bg-gradient-to-b from-white/95 dark:from-slate-950/95 via-white/70 dark:via-slate-900/70 to-white/95 dark:to-slate-950/95 transition-colors duration-500"></div>
    </div>

    {{-- ===== HERO HEADER ===== --}}
    <div class="relative z-10 border-b border-slate-200 dark:border-white/10 bg-gradient-to-r from-blue-50/50 dark:from-blue-900/40 via-slate-100/50 dark:via-slate-900/60 to-indigo-50/50 dark:to-indigo-900/40 py-16 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-6 lg:px-16">
            <div class="flex items-center gap-3 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-widest mb-4">
                <a href="{{ route('home') }}" class="hover:text-slate-900 dark:hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right text-[8px] text-slate-400 dark:text-slate-600"></i>
                <span class="text-slate-500 dark:text-slate-400">Capaian</span>
                <i class="fas fa-chevron-right text-[8px] text-slate-400 dark:text-slate-600"></i>
                <span class="text-slate-950 dark:text-white">RTM</span>
            </div>
            <div class="flex flex-col md:flex-row items-start md:items-end gap-6 justify-between">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white leading-tight mb-3" style="font-family: 'Arial', sans-serif;">
                        RTM
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400 text-base max-w-2xl leading-relaxed transition-colors duration-500">
                        Kumpulan dokumen Rapat Tinjauan Manajemen (RTM) Politeknik Jambi.
                        Unduh dokumen yang tersedia untuk keperluan audit, evaluasi, dan referensi mutu.
                    </p>
                </div>
                <div class="flex items-center gap-3 bg-white/60 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl px-5 py-3 backdrop-blur-md transition-colors duration-500">
                    <i class="fas fa-handshake text-blue-600 dark:text-blue-400 text-2xl"></i>
                    <div>
                        <div class="text-2xl font-black text-slate-900 dark:text-white transition-colors">{{ $dokumen->count() }}</div>
                        <div class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Dokumen RTM</div>
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
                <div class="bg-white/80 dark:bg-slate-800/60 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 sticky top-6 shadow-sm transition-colors duration-500">
                    <h3 class="text-slate-900 dark:text-white font-bold text-lg mb-5 flex items-center gap-2 transition-colors">
                        <i class="fas fa-filter text-blue-600 dark:text-blue-400 text-sm"></i> Filter Laporan
                    </h3>

                    <form method="GET" action="{{ route('capaian.rtm') }}" id="filterForm">
                        {{-- Filter Tahun --}}
                        <div class="mb-5">
                            <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 block">Tahun</label>
                            <select name="tahun" onchange="document.getElementById('filterForm').submit()"
                                class="w-full bg-slate-100 dark:bg-slate-700/60 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-500 transition appearance-none">
                                <option value="" class="text-slate-800 dark:text-white bg-white dark:bg-slate-800">Semua Tahun</option>
                                @foreach($tahunList as $th)
                                    <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }} class="text-slate-800 dark:text-white bg-white dark:bg-slate-800">{{ $th }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Kategori --}}
                        @if($kategoriList->count() > 1)
                        <div class="mb-5">
                            <label class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 block">Kategori</label>
                            <select name="kategori" onchange="document.getElementById('filterForm').submit()"
                                class="w-full bg-slate-100 dark:bg-slate-700/60 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-white focus:outline-none focus:border-blue-500 transition appearance-none">
                                <option value="" class="text-slate-800 dark:text-white bg-white dark:bg-slate-800">Semua Kategori</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }} class="text-slate-800 dark:text-white bg-white dark:bg-slate-800">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(request('tahun') || request('kategori'))
                        <a href="{{ route('capaian.rtm') }}" 
                           class="flex items-center gap-2 text-xs font-bold text-rose-600 dark:text-rose-400 hover:text-rose-500 dark:hover:text-rose-300 transition mt-3">
                            <i class="fas fa-times-circle"></i> Reset Filter
                        </a>
                        @endif
                    </form>

                    {{-- Stats per tahun --}}
                    @if($tahunList->count() > 0)
                    <div class="mt-6 pt-5 border-t border-slate-200 dark:border-white/10 transition-colors duration-500">
                        <div class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Laporan Per Tahun</div>
                        <div class="space-y-2">
                            @foreach($tahunList->take(6) as $th)
                            @php $countTh = \App\Models\Rtm::where('tahun', $th)->count(); @endphp
                            <div class="flex items-center justify-between text-sm">
                                <a href="{{ route('capaian.rtm', ['tahun' => $th]) }}"
                                   class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition font-medium">{{ $th }}</a>
                                <span class="bg-blue-500/10 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 text-[10px] font-bold px-2 py-0.5 rounded-lg transition-colors">{{ $countTh }}</span>
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
                    <span class="text-slate-600 dark:text-slate-400 text-sm transition-colors">Filter aktif:</span>
                    @if(request('tahun'))
                    <span class="inline-flex items-center gap-2 bg-blue-500/10 dark:bg-blue-500/20 border border-blue-500/20 dark:border-blue-500/30 text-blue-700 dark:text-blue-300 text-xs font-bold px-3 py-1.5 rounded-xl transition-all">
                        <i class="fas fa-calendar text-[10px]"></i> Tahun {{ request('tahun') }}
                    </span>
                    @endif
                    @if(request('kategori'))
                    <span class="inline-flex items-center gap-2 bg-indigo-500/10 dark:bg-indigo-500/20 border border-indigo-500/20 dark:border-indigo-500/30 text-indigo-700 dark:text-indigo-300 text-xs font-bold px-3 py-1.5 rounded-xl transition-all">
                        <i class="fas fa-tag text-[10px]"></i> {{ request('kategori') }}
                    </span>
                    @endif
                    <span class="text-slate-500 text-xs transition-colors">{{ $dokumen->count() }} dokumen ditemukan</span>
                </div>
                @endif

                @if($dokumen->count() > 0)

                {{-- Group by Tahun --}}
                @php
                    $groupedDocs = $dokumen->groupBy('tahun')->sortKeysDesc();
                @endphp
                @foreach($groupedDocs as $tahun => $docs)
                <div class="mb-10">
                    {{-- Year Header --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <i class="fas fa-calendar-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xl font-black text-slate-900 dark:text-white transition-colors">{{ $tahun }}</div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $docs->count() }} dokumen</div>
                            </div>
                        </div>
                        <div class="flex-1 h-px bg-gradient-to-r from-slate-200 dark:from-white/10 to-transparent transition-colors duration-500"></div>
                    </div>

                    {{-- Documents Table --}}
                    <div class="bg-white/80 dark:bg-slate-800/40 backdrop-blur-md border border-slate-200 dark:border-white/10 rounded-3xl overflow-hidden shadow-lg dark:shadow-2xl transition-colors duration-500">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 transition-colors duration-500">
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] transition-colors">Dokumen</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] w-32 transition-colors">Format</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] w-32 text-center transition-colors">Hits</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] w-40 text-right transition-colors">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-white/5 transition-colors duration-500">
                                    @foreach($docs as $dok)
                                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700/50 border border-slate-200 dark:border-white/10 flex items-center justify-center group-hover:border-blue-500/30 transition-all">
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
                                                    <div class="text-slate-900 dark:text-white font-bold text-sm truncate group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors" title="{{ $dok->judul }}">
                                                        {{ $dok->judul }}
                                                    </div>
                                                    @if($dok->kategori && $dok->kategori !== 'RTM')
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest transition-colors">{{ $dok->kategori }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider transition-colors">{{ $dok->tipe_file ?? 'FILE' }}</span>
                                                <span class="text-[10px] text-slate-500 dark:text-slate-400 transition-colors">{{ $dok->ukuran_file ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400 transition-colors">{{ number_format($dok->downloads) }} <i class="fas fa-download text-[10px] ml-1 opacity-50"></i></span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            @if($dok->path_file)
                                            <a href="{{ route('rtm.download', $dok->id) }}"
                                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all hover:shadow-lg hover:shadow-blue-500/30 active:scale-95 group/btn">
                                                <i class="fas fa-download group-hover:translate-y-0.5 transition-transform"></i> Unduh
                                            </a>
                                            @else
                                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-600 italic transition-colors">Not Available</span>
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
                    <div class="w-24 h-24 rounded-3xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-white/10 flex items-center justify-center mb-6 transition-colors duration-500">
                        <i class="fas fa-folder-open text-4xl text-slate-400 dark:text-slate-600 transition-colors"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 transition-colors">Belum Ada Dokumen</h3>
                    <p class="text-slate-600 dark:text-slate-500 text-sm max-w-sm leading-relaxed transition-colors">
                        @if(request('tahun') || request('kategori'))
                            Tidak ada dokumen yang sesuai dengan filter yang dipilih. Coba ubah filter atau
                            <a href="{{ route('capaian.rtm') }}" class="text-blue-600 dark:text-blue-400 hover:underline">tampilkan semua dokumen</a>.
                        @else
                            Dokumen RTM akan segera tersedia. Silakan kunjungi kembali beberapa saat lagi.
                        @endif
                    </p>
                </div>
                @endif

            </div>{{-- end main --}}
        </div>{{-- end grid --}}
    </div>{{-- end container --}}
</div>

<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.dark select option { background: #1e293b; color: #fff; }
</style>

@endsection
