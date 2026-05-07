@extends('layouts.app')

@section('content')
<!-- Section Utama -->
<div class="relative min-h-screen py-20 overflow-hidden font-sans bg-slate-900">
    
    <!-- BACKGROUND LAYER (DIOPTIMASI) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gedung-poljam.png') }}" 
             class="w-full h-full object-cover opacity-40" 
             alt="Background Politeknik Jambi">
        
        <!-- Overlay Gradien Lebih Pekat untuk Kontras -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/95 via-slate-900/70 to-slate-900/95"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-6">
        
        <!-- HEADER SECTION -->
        <div class="text-center mb-16 animate-fade-in">
            <span class="text-blue-400 font-black tracking-[0.4em] text-[10px] uppercase block mb-4">
                Official Statement
            </span>
            <h1 class="text-5xl md:text-7xl font-serif-luxury text-white tracking-tight leading-none drop-shadow-2xl">
                {{ $profil->judul }}
            </h1>
            <div class="mt-8 flex justify-center">
                <div class="w-24 h-1 bg-blue-500 shadow-[0_0_20px_rgba(59,130,246,0.6)]"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- SIDEBAR INFO -->
            <div class="lg:col-span-3 space-y-8 sticky top-24 bg-slate-800/60 p-8 rounded-3xl border border-white/10 backdrop-blur-md shadow-2xl">
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-widest mb-4">Lembaga</h4>
                    <p class="text-blue-100 text-sm leading-relaxed opacity-90">
                        Pusat Penjaminan Mutu Internal (LP3M) Politeknik Jambi.
                    </p>
                </div>
                <div class="h-[1px] w-full bg-white/10"></div>
                <div class="flex flex-col gap-2">
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-tighter">Verified Content</span>
                    <span class="text-white/60 text-xs italic">Tahun Akademik 2025/2026</span>
                </div>
            </div>

            <!-- MAIN CONTENT CARD (GLASS DARK MODE) -->
            <div class="lg:col-span-9 relative">
                <!-- bg-slate-900/80 untuk memastikan teks sangat jelas -->
                <div class="bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.8)] p-12 md:p-24 relative overflow-hidden border border-white/20">
                    
                    <!-- Decorative Light Effect -->
                    <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>

                    <article class="custom-prose relative z-10">
                        @if(isset($profil->isi_konten) && !empty($profil->isi_konten))
                            {!! $profil->isi_konten !!}
                        @else
                            <div class="text-center py-10">
                                <p class="text-slate-500 italic">Konten belum tersedia.</p>
                            </div>
                        @endif
                    </article>

                </div>

                <div class="mt-8 text-center lg:text-right">
                    <p class="text-white/30 text-[10px] uppercase tracking-[0.3em] font-medium">
                        LPM Politeknik Jambi &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS UNTUK MEMASTIKAN TULISAN JELAS */
    .custom-prose {
        @apply leading-[2.2] text-lg font-normal;
        color: #f1f5f9 !important; /* Warna Slate-100 */
        text-shadow: 0 1px 2px rgba(0,0,0,0.5); /* Bayangan halus agar teks 'keluar' */
    }

    /* Paksa semua elemen teks di dalam konten agar berwarna terang */
    .custom-prose p, 
    .custom-prose span, 
    .custom-prose div,
    .custom-prose li {
        color: #f1f5f9 !important;
        @apply mb-6;
    }

    /* Styling Judul Sub-Konten (MISI, VISI, dll) */
    .custom-prose strong, 
    .custom-prose b {
        @apply block text-blue-400 font-black tracking-widest text-sm uppercase mt-12 mb-4 first:mt-0;
        text-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
    }

    /* Judul Utama di dalam Konten */
    .custom-prose h3 {
        @apply text-3xl font-serif-luxury text-white mb-8 border-l-8 border-blue-500 pl-8 font-bold;
    }

    /* Styling List Bullets */
    .custom-prose ul {
        @apply space-y-4 my-8 list-none;
    }
    
    .custom-prose li {
        @apply pl-8 relative text-slate-200;
    }

    .custom-prose li::before {
        content: "→";
        @apply absolute left-0 text-blue-400 font-bold;
    }

    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 1s ease-out forwards;
    }

    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap');
    .font-serif-luxury {
        font-family: 'Playfair Display', serif;
    }
</style>
@endsection