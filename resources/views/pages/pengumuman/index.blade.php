@extends('layouts.app')
@section('title', 'Pengumuman - LPM Politeknik Jambi')
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
                    Pengumuman
                </h1>
                
                <!-- META TAGS -->
                <div class="flex items-center gap-3 text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-8 border-b border-slate-100 dark:border-white/10 pb-4">
                    <span>Total</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>{{ $pengumumans->total() }} Pengumuman</span>
                </div>

                <!-- PENGUMUMAN LIST -->
                <div class="space-y-6">
                    @forelse($pengumumans as $item)
                        <div class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 rounded-xl p-6 hover:border-blue-500/30 transition">
                            <div class="flex gap-4">
                                @if($item->gambar)
                                    <div class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden">
                                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <a href="{{ route('pengumuman.show', $item->slug) }}" class="block">
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 hover:text-blue-500 dark:hover:text-blue-400 transition line-clamp-2">
                                            {{ $item->judul }}
                                        </h3>
                                    </a>
                                    
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 line-clamp-2">
                                        {{ strip_tags($item->isi_konten) }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">
                                            <span class="text-slate-500 dark:text-slate-500">{{ $item->created_at->format('d F Y') }}</span>
                                            <span class="text-slate-300 dark:text-white/20 mx-2">•</span>
                                            <span>{{ $item->hits ?? 0 }} views</span>
                                        </div>
                                        <a href="{{ route('pengumuman.show', $item->slug) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">
                                            Baca Selengkapnya →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-slate-500 dark:text-slate-400 text-lg">Belum ada pengumuman</p>
                        </div>
                    @endforelse
                </div>

                <!-- PAGINATION -->
                <div class="mt-12 pt-8 border-t border-slate-100 dark:border-white/10">
                    {{ $pengumumans->links() }}
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
                        @forelse($pengumumans->take(5) as $recent)
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

                <!-- Categories -->
                <div class="bg-slate-50 dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest mb-4">Kategori</h3>
                    <div class="space-y-2">
                        <a href="{{ route('pengumuman.index') }}" class="block text-xs text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                            Semua Pengumuman
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
