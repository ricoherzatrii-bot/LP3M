@extends('layouts.app')
@section('title', $data['title'] . ' - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm mb-8">
                    <a href="{{ route('artikel.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 transition">Artikel</a>
                    <i class="fas fa-chevron-right text-slate-400 dark:text-slate-600 text-[9px]"></i>
                    <span class="text-slate-500 dark:text-slate-400">{{ $data['title'] }}</span>
                </div>

                <!-- Article List -->
                <div class="space-y-10">
                    @forelse($data['items'] as $item)
                    <article class="group bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500 shadow-sm">
                        <!-- Article Image -->
                        <div class="h-64 overflow-hidden bg-slate-200 dark:bg-slate-700">
                            @php
                                $articleImage = $item->gambar;
                                if ($articleImage && !str_starts_with($articleImage, 'http://') && !str_starts_with($articleImage, 'https://')) {
                                    if (!str_starts_with($articleImage, '/storage/')) {
                                        $articleImage = asset('storage/' . ltrim($articleImage, '/'));
                                    } else {
                                        $articleImage = asset($articleImage);
                                    }
                                }
                            @endphp
                            @if(!empty($articleImage))
                                <img src="{{ $articleImage }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $item->judul }}" 
                                     onerror="this.onerror=null; this.src='{{ asset('images/gedung-poljam.png') }}';">
                            @else
                                <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $item->judul }}">
                            @endif
                        </div>
                        <!-- Article Content -->
                        <div class="p-8">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 group-hover:text-blue-400 transition leading-tight">{{ $item->judul }}</h2>
                            <div class="flex flex-wrap items-center gap-3 text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4">
                                <span>Admin</span> 
                                <span class="text-white/20">/</span>
                                <span>{{ $data['title'] }}</span> 
                                <span class="text-white/20">/</span>
                                <span>{{ $item->tanggal }}</span>
                                <span class="text-white/20">/</span>
                                <span>Hits: {{ number_format($item->hits) }}</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-5">{{ $item->deskripsi }}</p>
                            @php
                                $route = $kategori === 'profil' ? route('profil.show', $item->slug) : route('berita.show', $item->slug);
                            @endphp
                            <a href="{{ $route }}" class="text-blue-400 text-sm font-semibold hover:text-blue-300 transition">
                                Read more ... {{ \Illuminate\Support\Str::limit($item->judul, 40) }}
                            </a>
                        </div>
                    </article>
                    @empty
                    <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-12 text-center">
                        <i class="fas fa-newspaper text-5xl text-slate-300 dark:text-slate-600 mb-4 block"></i>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum Ada Artikel</h3>
                        <p class="text-slate-500 dark:text-slate-400">Maaf, saat ini belum ada artikel untuk kategori {{ $data['title'] }}.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12 pagination-container">
                    {{ $data['items']->links() }}
                </div>
            </div>

            <!-- SIDEBAR (1/3) -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <div class="relative">
                        <input type="text" placeholder="Search ..." class="w-full bg-slate-100 dark:bg-slate-700/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 transition">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Sering Dibaca -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <h4 class="text-slate-900 dark:text-white font-bold text-lg mb-6 pb-4 border-b border-slate-100 dark:border-white/10">Sering Dibaca</h4>
                    <div class="space-y-4">
                        <a href="{{ route('kuesioner.dosen') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Kuesioner Mahasiswa</a>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Visi Dan Misi</a>
                        <a href="{{ route('artikel.kategori', 'berita') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding ke LP3M Politeknik Jambi</a>
                        <a href="{{ route('capaian.rtm') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm">RTM</a>
                    </div>
                </div>



                <!-- Pengunjung -->
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 p-6">
                    <h4 class="text-white font-bold text-lg mb-4 pb-4 border-b border-white/10">Pengunjung</h4>
                    <p class="text-slate-500 text-sm">We have <span class="text-blue-400 font-bold">6</span> guests and <span class="text-blue-400 font-bold">no</span> members online</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
