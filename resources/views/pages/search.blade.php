@extends('layouts.app')
@section('title', 'Hasil Pencarian - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-white dark:bg-slate-950 relative overflow-hidden pt-12 pb-32 transition-colors duration-500">
    <!-- Decorative Background -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-50 rounded-full blur-[120px] opacity-50 -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-yellow-50 rounded-full blur-[100px] opacity-30 -ml-24 -mb-24"></div>

    <div class="relative z-10 w-full px-6 lg:px-16">
        <!-- Header Section -->
        <div class="max-w-4xl mx-auto text-center mb-20">
            <span class="text-[#0056b3] font-black tracking-[0.4em] text-[10px] uppercase block mb-4">Search Results</span>
            <h1 class="font-serif-luxury text-5xl text-slate-900 dark:text-white mb-6">Hasil untuk: <span class="text-[#0056b3] italic">"{{ $query }}"</span></h1>
            <p class="text-slate-500 text-sm font-medium">Ditemukan <span class="text-[#0056b3] font-bold">{{ $results->count() }}</span> informasi yang relevan dengan kata kunci Anda.</p>
        </div>

        <div class="max-w-5xl mx-auto">
            @if($results->count() > 0)
                <div class="grid gap-8">
                    @foreach($results as $item)
                        <div class="group bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-white/10 p-8 hover:border-[#0056b3] hover:shadow-2xl hover:shadow-blue-900/5 transition-all duration-500 flex flex-col md:flex-row gap-8 items-center cursor-pointer" onclick="window.location.href='{{ route('profil.show', $item->slug) }}'">
                            <div class="w-full md:w-48 h-32 bg-slate-50 dark:bg-slate-800 rounded-2xl overflow-hidden flex-shrink-0">
                                <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-80 group-hover:opacity-100" alt="{{ $item->judul }}">
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center gap-3 text-[9px] text-[#0056b3] font-black uppercase tracking-widest mb-3">
                                    <span class="px-2 py-1 bg-blue-50 rounded-md">{{ $item->kategori }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-slate-400 capitalize">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-[#0056b3] transition leading-tight">{{ $item->judul }}</h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 leading-relaxed">
                                    {!! strip_tags($item->isi_konten) !!}
                                </p>
                            </div>
                            <div class="flex-shrink-0 items-center justify-center hidden md:flex">
                                <div class="w-12 h-12 rounded-full border border-slate-100 dark:border-white/10 flex items-center justify-center text-slate-300 dark:text-slate-600 group-hover:bg-[#0056b3] group-hover:text-white group-hover:border-[#0056b3] transition-all">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Results State -->
                <div class="text-center py-20 bg-slate-50 dark:bg-slate-900 rounded-[40px] border border-dashed border-slate-200 dark:border-white/10">
                    <div class="w-20 h-20 bg-white dark:bg-slate-800 shadow-xl rounded-3xl flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-search-minus text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Tidak Ada Hasil</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto mb-10">Maaf, kami tidak dapat menemukan informasi dengan kata kunci tersebut. Coba gunakan kata kunci lain yang lebih umum.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[#0056b3] font-black text-[10px] uppercase tracking-widest hover:gap-4 transition-all">
                        Kembali ke Beranda <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
