<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPM Politeknik Jambi | Premium Quality Assurance Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'serif-luxury': ['Arial', 'Helvetica Neue', 'Helvetica', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --poljam-blue: #1d4ed8; 
            --poljam-dark: #1e3a8a;
            --poljam-light: #3b82f6;
            --accent-gold: #fbbf24;
        }
        
        body { font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif; background-color: #ffffff; color: #0f172a; scroll-behavior: smooth; }
        .font-serif-luxury { font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif; }
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--poljam-blue); border-radius: 10px; }

        #splash-screen {
            position: fixed; inset: 0; background: #ffffff; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .splash-logo { width: 280px; transform: scale(0.8); opacity: 0; transition: 0.8s; }
        .active .splash-logo { transform: scale(1); opacity: 1; }

        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
        .dark .glass-nav { background: rgba(15, 23, 42, 0.85); }
        .glass-card { background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 5s ease-in-out infinite; }

        .hero-slide { display: none; opacity: 0; transition: opacity 0.8s ease-in-out; }
        .hero-slide.active { display: flex; opacity: 1; }

        .nav-indicator { height: 3px; background: var(--poljam-blue); transition: width 0.3s; width: 0; }
        .nav-link:hover .nav-indicator { width: 100%; }

        .gradient-text {
            background: linear-gradient(135deg, var(--poljam-dark), var(--poljam-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-hover { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .card-hover:hover { transform: translateY(-12px) scale(1.02); }

        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        body { top: 0 !important; }
        .goog-te-banner-frame { display: none !important; }
        .skiptranslate iframe { display: none !important; }
        #goog-gt-tt, .goog-te-balloon-frame { display: none !important; }
    </style>
</head>
<body class="antialiased bg-white dark:bg-slate-950 transition-colors duration-500">

    <!-- SPLASH SCREEN -->
    <div id="splash-screen" class="active bg-white dark:bg-slate-950 transition-colors duration-500">
        <div class="text-center">
            <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="Logo" class="splash-logo mb-4">
            <div class="w-48 h-1 bg-slate-100 dark:bg-slate-800 mx-auto rounded-full overflow-hidden">
                <div class="h-full bg-blue-700 animate-[loading_2s_ease-in-out_infinite]"></div>
            </div>
        </div>
    </div>

    <!-- NEWS TICKER -->
    <div class="bg-[#004494] py-2 overflow-hidden border-b border-[#003377]">
        <div class="container mx-auto px-8 flex items-center">
            <div class="text-[10px] text-yellow-400 font-bold uppercase tracking-[0.2em] whitespace-nowrap animate-[marquee_30s_linear_infinite]">
                Akreditasi Institusi "BAIK SEKALI" • Pendaftaran Audit Mutu Internal Semester Genap 2026 Telah Dibuka • Standar Mutu ISO 9001:2015 Terintegrasi
            </div>
        </div>
    </div>

    <!-- NAVIGATION BAR -->
    @include('components.navbar')

<!-- BERITA & ARTIKEL SECTION -->
<section class="py-24 bg-[#f8f9fa] dark:bg-slate-950 relative overflow-hidden transition-colors duration-500">
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#0056b3] rounded-full blur-[150px] opacity-10"></div>
    <div class="absolute top-20 right-0 w-64 h-64 bg-yellow-400 rounded-full blur-[120px] opacity-5"></div>
    <div class="relative z-10 w-full px-6 lg:px-16">
        <div class="max-w-7xl mx-auto space-y-12">

            <!-- FEATURED NEWS SLIDER (TOP - FULL WIDTH) -->
            @if($sliderItems->count() > 0)
            <div id="news-slider" class="relative bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 w-full group">
                <div id="slider-wrapper" class="relative h-72 md:h-[450px] w-full">
                    @foreach($sliderItems as $index => $item)
                        <a href="{{ $item->url }}" class="slider-item absolute inset-0 opacity-0 transition-all duration-1000 z-0 {{ $index == 0 ? 'opacity-100 z-10' : '' }}" data-index="{{ $index }}">
                            <div class="relative h-full w-full overflow-hidden">
                                @if($item->gambar)
                                    <img src="/storage/{{ $item->gambar }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $item->judul }}" onerror="this.src='/images/gedung-poljam.png'">
                                @else
                                    <img src="/images/gedung-poljam.png" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $item->judul }}">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-8 pb-14 md:p-12 md:pb-20">
                                    <span class="inline-block px-3 py-1 bg-yellow-400 text-[#0056b3] text-[9px] font-black uppercase tracking-widest rounded-full mb-4 shadow-md">
                                        {{ isset($item->is_external) && $item->is_external ? 'Slide Utama' : 'Berita Utama' }}
                                    </span>
                                    <h3 class="text-white text-3xl md:text-5xl font-bold leading-tight group-hover:text-yellow-400 transition max-w-4xl">{{ $item->judul }}</h3>
                                    @if(isset($item->created_at))
                                    <div class="flex items-center gap-4 mt-4">
                                        <span class="text-slate-300 text-xs flex items-center gap-2"><i class="far fa-calendar-alt"></i> {{ $item->created_at->translatedFormat('d F Y') }}</span>
                                    </div>
                                    @endif
                                    <p class="text-slate-200 text-sm mt-3 line-clamp-2 max-w-3xl opacity-80">
                                        {!! $item->subjudul !!}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <!-- Navigation Dots -->
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-3 z-30">
                    @foreach($sliderItems as $index => $item)
                        <button class="slider-dot w-2 h-2 rounded-full transition-all duration-500 border border-white/20 {{ $index == 0 ? 'bg-yellow-400 w-10 border-yellow-400' : 'bg-white/40' }}" data-index="{{ $index }}"></button>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button id="prev-slide" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md text-white border border-white/10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-30 hover:bg-yellow-400 hover:text-[#0056b3] hover:border-yellow-400 active:scale-90">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="next-slide" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 backdrop-blur-md text-white border border-white/10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-30 hover:bg-yellow-400 hover:text-[#0056b3] hover:border-yellow-400 active:scale-90">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-12">
                <!-- MAIN CONTENT: ALL BERITA LIST (LEFT) -->
                <div class="lg:w-2/3 space-y-8">
                    <h3 class="text-slate-900 dark:text-white font-bold text-2xl relative inline-block">
                        Berita Lainnya
                        <span class="absolute -bottom-2 left-0 w-16 h-1 bg-yellow-400 rounded-full"></span>
                    </h3>

                    @forelse($beritaList as $index => $berita)
                        @if($index == 0 && $beritaList->currentPage() == 1)
                        {{-- FEATURED FIRST ARTICLE (Large Card) --}}
                        <a href="{{ route('berita.show', $berita->slug) }}" class="group block bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden hover:border-[#0056b3] transition-all duration-500 shadow-sm hover:shadow-xl">
                            <div class="md:flex">
                                <div class="md:w-1/2 h-64 md:h-auto overflow-hidden relative">
                                    @if($berita->gambar_fitur)
                                        <img src="/storage/{{ $berita->gambar_fitur }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 min-h-[280px]" alt="{{ $berita->judul }}" onerror="this.src='/images/gedung-poljam.png'">
                                    @else
                                        <img src="/images/gedung-poljam.png" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 min-h-[280px]" alt="{{ $berita->judul }}">
                                    @endif
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-block px-3 py-1 bg-[#0056b3] text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg">Terbaru</span>
                                    </div>
                                </div>
                                <div class="md:w-1/2 p-8 flex flex-col justify-center">
                                    <div class="flex items-center gap-3 text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-4">
                                        <span class="flex items-center gap-1"><i class="far fa-calendar-alt"></i> {{ $berita->created_at ? $berita->created_at->translatedFormat('d F Y, H:i') : '-' }}</span>
                                    </div>
                                    <h4 class="text-slate-800 dark:text-white font-bold text-xl mb-4 leading-tight group-hover:text-[#0056b3] transition">{{ $berita->judul }}</h4>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-4">{!! Str::limit(strip_tags($berita->isi_konten), 250) !!}</p>
                                    <span class="inline-flex items-center gap-2 mt-6 text-[#0056b3] text-xs font-bold group-hover:gap-3 transition-all">
                                        Selengkapnya <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                        @else
                        {{-- REGULAR ARTICLE CARDS --}}
                        <a href="{{ route('berita.show', $berita->slug) }}" class="group flex gap-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-white/10 overflow-hidden hover:border-[#0056b3] transition-all duration-500 shadow-sm hover:shadow-lg p-4">
                            <div class="w-40 h-32 md:w-48 md:h-36 flex-shrink-0 rounded-xl overflow-hidden relative">
                                @if($berita->gambar_fitur)
                                    <img src="/storage/{{ $berita->gambar_fitur }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $berita->judul }}" onerror="this.src='/images/gedung-poljam.png'">
                                @else
                                    <img src="/images/gedung-poljam.png" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $berita->judul }}">
                                @endif
                            </div>
                            <div class="flex-1 flex flex-col justify-center py-1">
                                <div class="flex items-center gap-3 text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-2">
                                    <span class="flex items-center gap-1"><i class="far fa-calendar-alt"></i> {{ $berita->created_at ? $berita->created_at->translatedFormat('d F Y, H:i') : '-' }}</span>
                                </div>
                                <h4 class="text-slate-800 dark:text-white font-bold mb-2 leading-snug group-hover:text-[#0056b3] transition line-clamp-2">{{ $berita->judul }}</h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-2 hidden md:block">{!! Str::limit(strip_tags($berita->isi_konten), 150) !!}</p>
                                <span class="inline-flex items-center gap-2 mt-3 text-[#0056b3] text-xs font-bold group-hover:gap-3 transition-all">
                                    Selengkapnya <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </div>
                        </a>
                        @endif
                    @empty
                        <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10">
                            <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-newspaper text-3xl text-slate-400"></i>
                            </div>
                            <h4 class="text-slate-600 dark:text-slate-300 font-bold text-lg mb-2">Belum Ada Berita</h4>
                            <p class="text-slate-400 text-sm">Berita dan artikel akan ditampilkan di sini</p>
                        </div>
                    @endforelse

                    <!-- PAGINATION -->
                    @if($beritaList->hasPages())
                    <div class="flex items-center justify-center gap-2 pt-8">
                        {{-- Previous --}}
                        @if($beritaList->onFirstPage())
                            <span class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 cursor-not-allowed">
                                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                            </span>
                        @else
                            <a href="{{ $beritaList->previousPageUrl() }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-[#0056b3] bg-blue-50 dark:bg-blue-900/20 hover:bg-[#0056b3] hover:text-white transition-all duration-300 border border-blue-100 dark:border-blue-800/30">
                                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach($beritaList->getUrlRange(1, $beritaList->lastPage()) as $page => $url)
                            @if($page == $beritaList->currentPage())
                                <span class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-black bg-[#0056b3] text-white shadow-lg shadow-blue-500/30">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 hover:border-[#0056b3] hover:text-[#0056b3] transition-all duration-300">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($beritaList->hasMorePages())
                            <a href="{{ $beritaList->nextPageUrl() }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-[#0056b3] bg-blue-50 dark:bg-blue-900/20 hover:bg-[#0056b3] hover:text-white transition-all duration-300 border border-blue-100 dark:border-blue-800/30">
                                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        @else
                            <span class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 cursor-not-allowed">
                                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                            </span>
                        @endif

                        {{-- Page info --}}
                        <span class="ml-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $beritaList->currentPage() }} / {{ $beritaList->lastPage() }}</span>
                    </div>
                    @endif
                </div>

                <!-- SIDEBAR (RIGHT) -->
                <div class="lg:w-1/3 space-y-8">
                    <!-- Sering Dibaca Section -->
                    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-white/10 p-8 shadow-sm hover:shadow-xl transition-all duration-500 sticky top-24">
                        <h4 class="text-slate-900 dark:text-white font-bold text-xl mb-8 relative inline-block">
                            Sering Dibaca
                            <span class="absolute -bottom-2 left-0 w-12 h-1 bg-yellow-400 rounded-full"></span>
                        </h4>
                        
                        <div class="space-y-0 divide-y divide-slate-100 dark:divide-white/5">
                            <a href="{{ route('kuesioner.mahasiswa') }}" class="group block py-4 first:pt-0 last:pb-0">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between">
                                    Kuisioner Mahasiswa
                                    <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                </span>
                            </a>
                            <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="group block py-4">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between">
                                    Visi Dan Misi
                                    <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                </span>
                            </a>
                            @foreach($beritaList->take(3) as $sideBerita)
                            <a href="{{ route('berita.show', $sideBerita->slug) }}" class="group block py-4">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between leading-relaxed">
                                    {{ Str::limit($sideBerita->judul, 60) }}
                                    <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all flex-shrink-0 ml-2"></i>
                                </span>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ $sideBerita->created_at ? $sideBerita->created_at->translatedFormat('d M Y') : '' }}</span>
                            </a>
                            @endforeach
                            <a href="{{ route('capaian.rtm') }}" class="group block py-4 last:pb-0">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between">
                                    RTM
                                    <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- PENGUMUMAN TERBARU (Sidebar) -->
                    @if(isset($pengumumanAktif) && $pengumumanAktif->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-white/10 p-8 shadow-sm hover:shadow-xl transition-all duration-500">
                        <h4 class="text-slate-900 dark:text-white font-bold text-xl mb-8 relative inline-block">
                            📢 Pengumuman
                            <span class="absolute -bottom-2 left-0 w-12 h-1 bg-yellow-400 rounded-full"></span>
                        </h4>

                        <div class="space-y-0 divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($pengumumanAktif as $pItem)
                            <a href="{{ route('pengumuman.show', $pItem->slug) }}" class="group block py-4 first:pt-0 last:pb-0">
                                <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between leading-relaxed">
                                    {{ Str::limit($pItem->judul, 60) }}
                                    <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all flex-shrink-0 ml-2"></i>
                                </span>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ $pItem->created_at ? $pItem->created_at->translatedFormat('d F Y') : '' }}</span>
                            </a>
                            @endforeach
                        </div>

                        <a href="{{ route('pengumuman.index') }}" class="mt-6 inline-flex items-center gap-2 text-xs font-bold text-[#0056b3] hover:text-blue-800 transition">
                            Lihat Semua Pengumuman <i class="fas fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>



    <footer class="bg-[#004494] pt-32 pb-12 border-t border-[#003377]">
        <div class="container mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-20 mb-24">
                <div class="max-w-xs">
                    <div class="bg-white p-2 rounded-xl inline-block mb-8">
                        <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="Logo" class="h-10 transition-all cursor-pointer">
                    </div>
                    <p class="text-blue-100 text-sm font-light leading-relaxed mb-8">
                        Lembaga Penjamin Mutu Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi nasional.
                    </p>
                    <div class="flex gap-4 relative z-50">
                        <a href="{{ optional($socialLinks->get('instagram'))->url ?? 'https://www.instagram.com/politeknikjambi?igsh=MW1scnJubzYxbXI1OA==' }}" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-instagram"></i></a>
                        <a href="{{ optional($socialLinks->get('tiktok'))->url ?? 'https://www.tiktok.com/@politeknikjambi?_r=1&_t=ZS-97xqcpSv8SK' }}" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-tiktok"></i></a>
                        <a href="{{ optional($socialLinks->get('youtube'))->url ?? 'https://youtube.com/@poltekjambi?si=gP6jTcGudVbPtwB1' }}" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-20 uppercase font-black text-[10px] tracking-[0.2em] text-blue-200">
                    <div class="space-y-6">
                        <div class="text-yellow-400 mb-2">Tautan Utama</div>
                        <a href="{{ route('login') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Login Dashboard</a>
                        <a href="{{ url('/spmi/dokumen-spmi') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Dokumen SPMI</a>
                        <a href="{{ route('capaian.laporan_ami') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Laporan AMI</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-yellow-400 mb-2">Informasi</div>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Visi & Misi</a>
                        <a href="{{ route('akreditasi.index') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Akreditasi</a>
                        <a href="{{ route('gallery.index') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Galeri</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-yellow-400 mb-2">Kontak</div>
                        <span class="block lowercase font-medium text-white">Jalan Lingkar Barat II, Lorong Veteran</span>
                        <span class="block lowercase font-medium text-white">Kenali Asam Atas, Kotabaru</span>
                        <span class="block lowercase font-medium text-white">Kota Jambi, Indonesia</span>
                    </div>
                </div>
            </div>
            <div class="pt-12 border-t border-white/10 flex flex-col md:flex-row justify-between gap-8 items-center">
                <span class="text-[10px] font-bold text-blue-200 uppercase tracking-[0.3em]">© 2026 LPM Politeknik Jambi. All Rights Reserved.</span>
                <div class="flex gap-10 text-[9px] font-black uppercase tracking-widest text-blue-200">
                    <a href="#" class="hover:text-yellow-400">Privacy Policy</a>
                    <a href="#" class="hover:text-yellow-400">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'id', includedLanguages: 'en,id', autoDisplay: false}, 'google_translate_element');
        }
        function changeLanguage(lang) {
            var selectField = document.querySelector(".goog-te-combo");
            if(selectField) {
                selectField.value = lang;
                selectField.dispatchEvent(new Event('change'));
            }
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <div id="google_translate_element" style="display:none;"></div>
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const splash = document.getElementById('splash-screen');
                splash.style.opacity = '0';
                setTimeout(() => splash.remove(), 600);
            }, 2000);
        });

        // NEWS SLIDER LOGIC
        document.addEventListener('DOMContentLoaded', function() {
            const sliderItems = document.querySelectorAll('.slider-item');
            const dots = document.querySelectorAll('.slider-dot');
            const prevBtn = document.getElementById('prev-slide');
            const nextBtn = document.getElementById('next-slide');
            const slider = document.getElementById('news-slider');
            
            if (!slider || sliderItems.length === 0) return;

            let currentIndex = 0;
            let slideInterval;

            function showSlide(index) {
                sliderItems.forEach((item, i) => {
                    item.classList.remove('opacity-100', 'z-10');
                    item.classList.add('opacity-0', 'z-0');
                    
                    if (dots[i]) {
                        dots[i].classList.remove('bg-yellow-400', 'w-10', 'border-yellow-400');
                        dots[i].classList.add('bg-white/40');
                    }
                });

                sliderItems[index].classList.remove('opacity-0', 'z-0');
                sliderItems[index].classList.add('opacity-100', 'z-10');
                
                if (dots[index]) {
                    dots[index].classList.remove('bg-white/40');
                    dots[index].classList.add('bg-yellow-400', 'w-10', 'border-yellow-400');
                }
                
                currentIndex = index;
            }

            function nextSlide() {
                let next = (currentIndex + 1) % sliderItems.length;
                showSlide(next);
            }

            function prevSlide() {
                let prev = (currentIndex - 1 + sliderItems.length) % sliderItems.length;
                showSlide(prev);
            }

            function startAutoSlide() {
                stopAutoSlide();
                slideInterval = setInterval(nextSlide, 5000);
            }

            function stopAutoSlide() {
                clearInterval(slideInterval);
            }

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    showSlide(index);
                    startAutoSlide();
                });
            });

            if (nextBtn) nextBtn.addEventListener('click', () => {
                nextSlide();
                startAutoSlide();
            });

            if (prevBtn) prevBtn.addEventListener('click', () => {
                prevSlide();
                startAutoSlide();
            });

            slider.addEventListener('mouseenter', stopAutoSlide);
            slider.addEventListener('mouseleave', startAutoSlide);

            startAutoSlide();
        });
    </script>
</body>
</html>
