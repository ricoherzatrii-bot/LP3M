@extends('layouts.app')
@section('title', $pengumuman->judul . ' - LPM Politeknik Jambi')
@section('content')

<div class="relative min-h-screen bg-white dark:bg-slate-950 pt-8 pb-24 font-sans overflow-hidden transition-colors duration-500">
    
    <!-- BACKGROUND LAYER -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gedung-poljam.png') }}" 
             class="w-full h-full object-cover opacity-10 dark:opacity-40" 
             alt="Background Politeknik Jambi">
        
        <!-- Overlay Gradien -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/95 dark:from-slate-950/95 via-white/70 dark:via-slate-900/70 to-white/95 dark:to-slate-950/95 transition-colors duration-500"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16">
        
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <!-- HEADER -->
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4 font-serif-luxury leading-tight">
                    {{ $pengumuman->judul }}
                </h1>
                
                <!-- META TAGS -->
                <div class="flex items-center gap-3 text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-8 border-b border-slate-100 dark:border-white/10 pb-4">
                    <span>Pengumuman</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>{{ $pengumuman->created_at->format('d F Y') }}</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>Hits: {{ $pengumuman->hits }}</span>
                    
                    <!-- Social Icons -->
                    <div class="ml-auto flex gap-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-400 hover:text-white transition"><i class="fab fa-twitter text-xs"></i></a>
                    </div>
                </div>

                <!-- FEATURED IMAGE -->
                @if($pengumuman->gambar)
                    <div class="mb-8 rounded-xl overflow-hidden">
                        <img src="{{ asset($pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" class="w-full h-auto object-cover">
                    </div>
                @endif

                <!-- ARTICLE CONTENT -->
                <article class="custom-prose text-slate-700 dark:text-slate-300 leading-relaxed mb-12">
                    @if(isset($pengumuman->isi_konten) && !empty($pengumuman->isi_konten))
                        {!! $pengumuman->isi_konten !!}
                    @else
                        <p class="italic text-slate-500">Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>
                    @endif
                </article>

                <!-- PREV / NEXT BUTTONS -->
                <div class="flex gap-2 mb-12 border-b border-white/10 pb-12">
                    <button class="bg-slate-700 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded transition flex items-center gap-2">
                        <i class="fas fa-chevron-left text-[10px]"></i> Prev
                    </button>
                    <button class="bg-slate-700 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded transition flex items-center gap-2">
                        Next <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </div>

                <!-- PENGUMUMAN LAINNYA -->
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Pengumuman Lainnya</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        @forelse($recentPengumumans as $recent)
                            <div class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 rounded-xl p-6 hover:border-blue-500/30 transition">
                                @if($recent->gambar)
                                    <div class="mb-4 rounded-lg overflow-hidden h-32">
                                        <img src="{{ asset($recent->gambar) }}" alt="{{ $recent->judul }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <a href="{{ route('pengumuman.show', $recent->slug) }}">
                                    <h4 class="text-slate-900 dark:text-white font-bold mb-4 line-clamp-2 hover:text-blue-500 dark:hover:text-blue-400 cursor-pointer transition">
                                        {{ $recent->judul }}
                                    </h4>
                                </a>
                                <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">
                                    {{ $recent->created_at->format('d F Y') }} <span class="text-slate-300 dark:text-white/20 mx-1">•</span> {{ $recent->hits }} views
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 dark:text-slate-400 col-span-3">Belum ada pengumuman lainnya</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- SIDEBAR (1/3) -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-slate-50 dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Search ..." class="w-full bg-white dark:bg-slate-700/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Recent Pengumuman -->
                <div class="bg-slate-50 dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest mb-4">Pengumuman Terbaru</h3>
                    <div class="space-y-4">
                        @forelse($recentPengumumans->take(5) as $recent)
                            <a href="{{ route('pengumuman.show', $recent->slug) }}" class="block group">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition line-clamp-2">
                                    {{ $recent->judul }}
                                </h4>
                                <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1">
                                    {{ $recent->created_at->format('d M Y') }}
                                </p>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>

                <!-- Pengumuman Info -->
                <div class="bg-slate-50 dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest mb-4">Informasi</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-[9px] font-bold uppercase text-slate-500 dark:text-slate-400">Tanggal</p>
                            <p class="text-slate-900 dark:text-white">{{ $pengumuman->created_at->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase text-slate-500 dark:text-slate-400">Kategori</p>
                            <p class="text-slate-900 dark:text-white">{{ $pengumuman->kategori }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase text-slate-500 dark:text-slate-400">Status</p>
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-[9px] font-bold @if($pengumuman->status === 'aktif') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                                {{ ucfirst($pengumuman->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
