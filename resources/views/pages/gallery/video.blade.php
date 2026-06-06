@extends('layouts.app')
@section('title', 'Video - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-900 pt-8 pb-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <h1 class="text-4xl font-bold text-white mb-10 font-serif-luxury">Galeri <span class="text-blue-400 italic">Video</span></h1>
        
        <div class="grid md:grid-cols-2 gap-10">
            @forelse($videos as $video)
            @php
                $src = $video->link_youtube ?? '';
                $youtubeId = null;
                $isLocal = false;

                if ($src) {
                    // Try to extract YouTube ID
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/', $src, $matches);
                    if (!empty($matches[1])) {
                        $youtubeId = $matches[1];
                    } elseif (!str_starts_with($src, 'http')) {
                        $isLocal = true;
                    }
                }
            @endphp

            <div class="group bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                <div class="aspect-video overflow-hidden relative bg-slate-900">

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

                    @elseif($isLocal)
                        {{-- Local video file --}}
                        <video controls controlsList="nodownload" class="w-full h-full object-cover">
                            <source src="{{ asset('storage/gallery/videos/' . $src) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video HTML5.
                        </video>

                    @else
                        {{-- External URL (not YouTube, not local) --}}
                        <video controls controlsList="nodownload" class="w-full h-full object-cover">
                            <source src="{{ $src }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video HTML5.
                        </video>
                    @endif

                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-3">
                        @if($youtubeId)
                            <span><i class="fab fa-youtube mr-1 text-red-400"></i> YouTube</span>
                        @elseif($isLocal)
                            <span><i class="fas fa-film mr-1 text-blue-400"></i> Video Lokal</span>
                        @endif
                        <span><i class="fas fa-calendar-alt mr-1"></i> {{ $video->created_at->format('d M Y') }}</span>
                    </div>
                    <h4 class="text-white font-bold text-xl leading-tight group-hover:text-blue-400 transition">{{ $video->judul }}</h4>
                    @if($video->deskripsi)
                    <p class="text-slate-400 text-sm mt-3 line-clamp-2">{{ $video->deskripsi }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center text-slate-400">
                <i class="fas fa-video-slash text-4xl mb-4 opacity-50 block"></i>
                <p>Belum ada video di dalam galeri.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
