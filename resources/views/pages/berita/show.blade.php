@extends('layouts.app')
@section('title', 'LPM Politeknik Jambi')
@section('content')

 <!-- BREADCRUMB -->
  
<div class="bg-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-50"></div>

    <div class="relative z-10 w-full px-6 lg:px-16 max-w-7xl mx-auto">
        <div class="flex items-center gap-2 text-[10px] font-bold tracking-widest text-gray-500 uppercase mb-4">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition">
                Beranda
            </a>

            <i class="fas fa-chevron-right text-[8px] opacity-50 text-gray-400"></i>

            <span class="text-blue-600">
                Berita
            </span>
        </div>

        <h1 class="text-black text-3xl md:text-4xl font-bold leading-tight max-w-4xl">
            {{ $berita->judul }}
        </h1>

        <div class="flex items-center gap-6 mt-4">
            <span class="text-gray-600 text-xs flex items-center gap-2">
                <i class="far fa-calendar-alt"></i>
                {{ $berita->created_at ? $berita->created_at->translatedFormat('d F Y, H:i') : '-' }}
            </span>
        </div>
    </div>
</div>


    <!-- CONTENT -->
    <section class="py-16 bg-[#f8f9fa] dark:bg-slate-950 transition-colors duration-500">
        <div class="w-full px-6 lg:px-16 max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- MAIN ARTICLE -->
                <div class="lg:w-2/3">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden shadow-sm">
                        @php
                            $beritaImage = $berita->gambar_fitur_url ?? $berita->gambar_fitur;
                            if ($beritaImage && !str_starts_with($beritaImage, 'http://') && !str_starts_with($beritaImage, 'https://')) {
                                if (!str_starts_with($beritaImage, '/storage/')) {
                                    $beritaImage = asset('storage/' . ltrim($beritaImage, '/'));
                                } else {
                                    $beritaImage = asset($beritaImage);
                                }
                            }
                        @endphp
                        @if(!empty($beritaImage))
                        <div class="h-72 md:h-96 overflow-hidden">
                            <img src="{{ $beritaImage }}" class="w-full h-full object-cover" alt="{{ $berita->judul }}">
                        </div>
                        @endif

                        <div class="p-8 md:p-12">
                            <div class="article-content prose max-w-none">
                                {!! $berita->isi_konten !!}
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 px-6 py-3 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 font-bold text-sm hover:border-[#0056b3] hover:text-[#0056b3] transition-all shadow-sm">
                            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>

                <!-- SIDEBAR -->
                <div class="lg:w-1/3">
                    <div class="space-y-8 sticky top-24 max-h-[calc(100vh-8rem)] overflow-y-auto pr-1 custom-scrollbar">
                        <!-- Berita Terbaru -->
                        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-white/10 p-8 shadow-sm">
                            <h4 class="text-slate-900 dark:text-white font-bold text-xl mb-8 relative inline-block">
                            Berita Terbaru
                            <span class="absolute -bottom-2 left-0 w-12 h-1 bg-yellow-400 rounded-full"></span>
                        </h4>
                        
                        <div class="space-y-0 divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($recentBerita as $recent)
                            <a href="{{ route('berita.show', $recent->slug) }}" class="group block py-4 first:pt-0 last:pb-0">
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                        @php
                                            $recentImage = $recent->gambar_fitur_url ?? $recent->gambar_fitur;
                                            if ($recentImage && !str_starts_with($recentImage, 'http://') && !str_starts_with($recentImage, 'https://')) {
                                                if (!str_starts_with($recentImage, '/storage/')) {
                                                    $recentImage = asset('storage/' . ltrim($recentImage, '/'));
                                                } else {
                                                    $recentImage = asset($recentImage);
                                                }
                                            }
                                        @endphp
                                        @if(!empty($recentImage))
                                            <img src="{{ $recentImage }}" class="w-full h-full object-cover" alt="">
                                        @else
                                            <img src="/images/gedung-poljam.png" class="w-full h-full object-cover" alt="">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="text-slate-700 dark:text-slate-300 font-semibold text-sm group-hover:text-[#0056b3] transition leading-snug line-clamp-2">{{ $recent->judul }}</h5>
                                        <span class="text-[10px] text-slate-400 mt-1 block">{{ $recent->created_at ? $recent->created_at->translatedFormat('d M Y') : '' }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-white/10 p-8 shadow-sm">
                        <h4 class="text-slate-900 dark:text-white font-bold text-xl mb-6 relative inline-block">
                            Kategori
                            <span class="absolute -bottom-2 left-0 w-12 h-1 bg-[#0056b3] rounded-full"></span>
                        </h4>
                        <div class="space-y-3">
                            <a href="{{ route('artikel.kategori', 'berita') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all group">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center"><i class="fas fa-newspaper text-[#0056b3] text-xs"></i></span>
                                    Berita
                                </span>
                            </a>
                            <a href="{{ route('artikel.kategori', 'kegiatan') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all group">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center"><i class="fas fa-calendar-check text-emerald-600 text-xs"></i></span>
                                    Kegiatan
                                </span>
                            </a>
                            <a href="{{ route('artikel.kategori', 'profil') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all group">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center"><i class="fas fa-building text-purple-600 text-xs"></i></span>
                                    Profil
                                </span>
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection