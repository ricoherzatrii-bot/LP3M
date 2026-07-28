@extends('layouts.app')
@section('title', 'Video - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-10 font-serif-luxury">Galeri <span class="text-blue-600 dark:text-blue-400 italic">Video</span></h1>
        
        <div class="grid md:grid-cols-2 gap-10">
            @forelse($videos as $video)
            @php
                $src = $video->link_youtube ?? '';
                $youtubeId = null;
                $tiktokId = null;
                $isLocal = false;
                $isTiktok = false;

                if ($src) {
                    // Try to extract YouTube ID
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/', $src, $matches);
                    if (!empty($matches[1])) {
                        $youtubeId = $matches[1];
                    } elseif (!str_starts_with($src, 'http')) {
                        $isLocal = true;
                    }
                    preg_match('/tiktok\.com\/(?:@[^\/]+\/video\/|embed\/v2\/)(\d+)/i', $src, $tiktokMatches);
                    $tiktokId = $tiktokMatches[1] ?? null;
                    $isTiktok = preg_match('/(?:^|\.)?(?:vt|vm|www)?\.?tiktok\.com/i', $src) === 1;
                }
            @endphp

            <div class="group bg-white/80 dark:bg-slate-900/70 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                <div class="aspect-video overflow-hidden relative bg-slate-100 dark:bg-slate-900">

                    @if($youtubeId)
                        {{-- YouTube embed --}}
                        <iframe 
                            src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0&modestbranding=1&playsinline=1"
                            title="{{ $video->judul }}"
                            class="w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>

                    @elseif($tiktokId)
                        {{-- TikTok embed --}}
                        <iframe
                            src="https://www.tiktok.com/player/v1/{{ $tiktokId }}?description=1&music_info=1"
                            title="{{ $video->judul }}"
                            class="w-full h-full"
                            frameborder="0"
                            allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                            allowfullscreen>
                        </iframe>

                    @elseif($isTiktok)
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 via-slate-200 to-slate-300 dark:from-slate-900 dark:via-slate-800 dark:to-black text-slate-800 dark:text-white p-6 text-center">
                            <i class="fab fa-tiktok text-5xl mb-4 text-cyan-500"></i>
                            <h3 class="text-xl font-semibold mb-2">Video TikTok</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Link ini tidak bisa diputar langsung di halaman ini. Buka langsung lewat TikTok.</p>
                            <a href="{{ $src }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-slate-900 dark:bg-white px-5 py-3 text-sm font-semibold text-white dark:text-slate-900 hover:bg-slate-700 dark:hover:bg-slate-100">
                                <i class="fab fa-tiktok"></i> Buka di TikTok
                            </a>
                        </div>

                    @elseif($isLocal)
                        {{-- Local video file --}}
                        <video controls controlsList="nodownload" class="w-full h-full object-cover">
                            <source src="{{ asset('storage/gallery/videos/' . $src) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video HTML5.
                        </video>

                    @else
                        {{-- Any external video URL --}}
                        <video controls controlsList="nodownload" class="w-full h-full object-cover">
                            <source src="{{ $src }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video HTML5.
                        </video>
                    @endif

                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-3">
                        @if($youtubeId)
                            <span><i class="fab fa-youtube mr-1 text-red-400"></i> YouTube</span>
                        @elseif($tiktokId)
                            <span><i class="fab fa-tiktok mr-1 text-white"></i> TikTok</span>
                        @elseif($isTiktok)
                            <span><i class="fab fa-tiktok mr-1 text-cyan-400"></i> TikTok</span>
                        @elseif($isLocal)
                            <span><i class="fas fa-film mr-1 text-blue-400"></i> Video Lokal</span>
                        @endif
                        <span><i class="fas fa-calendar-alt mr-1"></i> {{ $video->created_at->format('d M Y') }}</span>
                    </div>
                    <h4 class="text-slate-900 dark:text-white font-bold text-xl leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $video->judul }}</h4>
                    @if($video->deskripsi)
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-3 line-clamp-2">{{ $video->deskripsi }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center text-slate-500 dark:text-slate-400">
                <i class="fas fa-video-slash text-4xl mb-4 opacity-50 block"></i>
                <p>Belum ada video di dalam galeri.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
