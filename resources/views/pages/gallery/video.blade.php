@extends('layouts.app')
@section('title', 'Video - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-900 pt-8 pb-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <h1 class="text-4xl font-bold text-white mb-10 font-serif-luxury">Galeri <span class="text-blue-400 italic">Video</span></h1>
        
        <div class="grid md:grid-cols-2 gap-10">
            @forelse($videos as $video)
            <div class="group bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                <div class="aspect-video overflow-hidden relative">
                    <video controls controlsList="nodownload" class="w-full h-full object-cover">
                        <source src="{{ asset('storage/gallery/videos/' . $video->link_youtube) }}" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-3">
                        <span><i class="fas fa-calendar-alt mr-1"></i> {{ $video->created_at->format('d M Y') }}</span>
                    </div>
                    <h4 class="text-white font-bold text-xl leading-tight group-hover:text-blue-400 transition">{{ $video->judul }}</h4>
                    <p class="text-slate-400 text-sm mt-3 line-clamp-2">{{ $video->deskripsi }}</p>
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
