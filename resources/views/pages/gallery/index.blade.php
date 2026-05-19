@extends('layouts.app')
@section('title', 'Foto Kegiatan - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-900 pt-8 pb-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <h1 class="text-4xl font-bold text-white mb-10 font-serif-luxury">Galeri <span class="text-blue-400 italic">Foto Kegiatan</span></h1>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Item Foto -->
            @for ($i = 1; $i <= 6; $i++)
            <div class="group bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                <div class="h-60 overflow-hidden relative cursor-pointer">
                    <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Foto Kegiatan">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <div class="w-12 h-12 bg-blue-600/80 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-search-plus text-white text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-3">
                        <span><i class="fas fa-calendar-alt mr-1"></i> {{ date('d M Y') }}</span>
                    </div>
                    <h4 class="text-white font-bold text-lg leading-tight group-hover:text-blue-400 transition">Kegiatan Akademik & Mutu {{ $i }}</h4>
                    <p class="text-slate-400 text-sm mt-2 line-clamp-2">Dokumentasi kegiatan akademik yang diselenggarakan oleh LPM Politeknik Jambi.</p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

@endsection
