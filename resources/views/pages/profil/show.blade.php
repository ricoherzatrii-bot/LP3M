@extends('layouts.app')
@section('title', $profil->judul . ' - LPM Politeknik Jambi')
@section('content')

<div class="relative min-h-screen bg-white dark:bg-slate-950 pt-8 pb-24 font-sans overflow-hidden transition-colors duration-500">
    
    <!-- BACKGROUND LAYER -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gedung-poljam.png') }}" 
             class="w-full h-full object-cover opacity-10 dark:opacity-40" 
             alt="Background Politeknik Jambi">
        
        <!-- Overlay Gradien Lebih Pekat untuk Kontras -->
        <div class="absolute inset-0 bg-gradient-to-b from-white/95 dark:from-slate-950/95 via-white/70 dark:via-slate-900/70 to-white/95 dark:to-slate-950/95 transition-colors duration-500"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16">
        
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <!-- HEADER -->
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4 font-serif-luxury leading-tight">
                    {{ $profil->judul }}
                </h1>
                
                <!-- META TAGS -->
                <div class="flex items-center gap-3 text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-8 border-b border-slate-100 dark:border-white/10 pb-4">
                    <span>Admin</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>Profil</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>{{ $profil->created_at ? $profil->created_at->format('d F Y') : '04 February 2023' }}</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>Hits: {{ $profil->hits ?? 1469 }}</span>
                    
                    <!-- Social Icons (Align Right in Meta row) -->
                    <div class="ml-auto flex gap-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-400 hover:text-white transition"><i class="fab fa-twitter text-xs"></i></a>
                    </div>
                </div>

                <!-- ARTICLE CONTENT -->
                <article class="custom-prose text-slate-700 dark:text-slate-300 leading-relaxed mb-12">
                    @if(isset($profil->isi_konten) && !empty($profil->isi_konten))
                        {!! $profil->isi_konten !!}
                        
                        {{-- Render additional items in the same category if any --}}
                        @if(isset($profilList) && $profilList->count() > 0)
                            @foreach($profilList as $item)
                                <div class="mt-12 pt-12 border-t border-slate-100 dark:border-white/10">
                                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6 uppercase">{{ $item->judul }}</h2>
                                    {!! $item->isi_konten !!}
                                </div>
                            @endforeach
                        @endif
                    @else
                        <p class="italic text-slate-500">Content sedang diproses, silahkan kunjungi beberapa saat lagi...</p>
                    @endif
                </article>

                {{-- LINK FILE / TAUTAN (dari admin Renop) --}}
                @if(!empty($profil->link_file))
                    @php
                        $rawLink = trim($profil->link_file);
                        if (\Illuminate\Support\Str::startsWith($rawLink, ['http://', 'https://'])) {
                            $href = $rawLink;
                        } elseif (\Illuminate\Support\Str::startsWith($rawLink, 'www.')) {
                            $href = 'https://' . $rawLink;
                        } else {
                            $href = asset('storage/' . ltrim($rawLink, '/'));
                        }
                    @endphp

                    <div class="mt-6">
                        <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-3 rounded-lg shadow transition">
                            <i class="fas fa-external-link-alt mr-2"></i> Buka Tautan / Dokumen
                        </a>
                    </div>
                @endif

                <!-- PREV / NEXT BUTTONS -->
                <div class="flex gap-2 mb-12 border-b border-white/10 pb-12">
                    <button class="bg-slate-700 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded transition flex items-center gap-2">
                        <i class="fas fa-chevron-left text-[10px]"></i> Prev
                    </button>
                    <button class="bg-slate-700 hover:bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded transition flex items-center gap-2">
                        Next <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </div>

                <!-- ARTIKEL LAINNYA -->
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Artikel Lainnya</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <!-- Card 3 -->
                        <div class="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-white/10 rounded-xl p-6 hover:border-blue-500/30 transition">
                            <h4 class="text-slate-900 dark:text-white font-bold mb-4 line-clamp-2 hover:text-blue-500 dark:hover:text-blue-400 cursor-pointer transition">Moto Dan Janji Layanan</h4>
                            <div class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">
                                Admin <span class="text-slate-300 dark:text-white/20 mx-1">•</span> 03 February 2023
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- SIDEBAR (1/3) -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-slate-50 dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Search ..." class="w-full bg-white dark:bg-slate-700/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-blue-500 transition" required>
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Sering Dibaca -->
                <div class="bg-slate-50 dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <h4 class="text-slate-900 dark:text-white font-bold text-lg mb-6 pb-4 border-b border-slate-200 dark:border-white/10">Sering Dibaca</h4>
                    <div class="space-y-4">
                        <a href="{{ route('kuesioner.mahasiswa') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Kuisioner Mahasiswa</a>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Visi Dan Misi</a>
                        <a href="#" class="block text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding</a>
                        <a href="{{ route('capaian.rtm') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm">RTM</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS UNTUK MEMASTIKAN TULISAN JELAS */
    .custom-prose {
        @apply font-normal text-base md:text-lg;
    }
    
    .custom-prose p {
        @apply mb-4;
    }

    .custom-prose strong, 
    .custom-prose b {
        @apply font-bold text-slate-900 dark:text-white;
    }

    /* Styling List Bullets */
    .custom-prose ul {
        list-style-type: disc !important;
        padding-left: 2rem !important;
        margin-top: 1rem !important;
        margin-bottom: 1rem !important;
    }
    
    .custom-prose ol {
        list-style-type: decimal !important;
        padding-left: 2rem !important;
        margin-top: 1rem !important;
        margin-bottom: 1rem !important;
    }

    .custom-prose ul li,
    .custom-prose ol li {
        margin-bottom: 0.5rem;
    }

</style>
@endsection