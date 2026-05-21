<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} | LPM Politeknik Jambi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'serif-luxury': ['Playfair Display', 'serif'],
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --poljam-blue: #1d4ed8; 
            --poljam-dark: #1e3a8a;
            --poljam-light: #3b82f6;
            --accent-gold: #fbbf24;
        }
        body { font-family: 'Outfit', sans-serif; scroll-behavior: smooth; }
        .font-serif-luxury { font-family: 'Playfair Display', serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--poljam-blue); border-radius: 10px; }
        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
        .dark .glass-nav { background: rgba(15, 23, 42, 0.85); }
        body { top: 0 !important; }
        .goog-te-banner-frame { display: none !important; }
        .skiptranslate iframe { display: none !important; }
        #goog-gt-tt, .goog-te-balloon-frame { display: none !important; }

        .article-content h1 { font-size: 2rem; font-weight: 700; margin: 1.5rem 0 1rem; color: #0f172a; }
        .article-content h2 { font-size: 1.5rem; font-weight: 700; margin: 1.25rem 0 0.75rem; color: #1e293b; }
        .article-content h3 { font-size: 1.25rem; font-weight: 600; margin: 1rem 0 0.5rem; color: #334155; }
        .article-content p { margin: 0.75rem 0; line-height: 1.8; color: #475569; }
        .article-content ul, .article-content ol { margin: 0.75rem 0; padding-left: 1.5rem; }
        .article-content li { margin: 0.25rem 0; color: #475569; }
        .article-content img { max-width: 100%; height: auto; border-radius: 1rem; margin: 1.5rem 0; }
        .article-content a { color: #0056b3; text-decoration: underline; }
        .article-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .article-content th, .article-content td { border: 1px solid #e2e8f0; padding: 0.75rem; text-align: left; }
        .article-content th { background: #f1f5f9; font-weight: 600; }
        .article-content blockquote { border-left: 4px solid #0056b3; padding: 1rem 1.5rem; background: #f0f9ff; margin: 1rem 0; border-radius: 0 1rem 1rem 0; }
        
        .dark .article-content h1, .dark .article-content h2, .dark .article-content h3 { color: #e2e8f0; }
        .dark .article-content p, .dark .article-content li { color: #94a3b8; }
        .dark .article-content blockquote { background: rgba(15, 23, 42, 0.5); border-left-color: #3b82f6; }
        .dark .article-content th { background: #1e293b; color: #e2e8f0; }
        .dark .article-content th, .dark .article-content td { border-color: #334155; }
    </style>
</head>
<body class="antialiased bg-white dark:bg-slate-950 transition-colors duration-500">

    <!-- TOP BAR -->
    <div class="bg-[#0056b3] py-3 border-b border-[#004494] w-full">
        <div class="w-full px-6 lg:px-16 flex justify-between items-center text-[10px] font-bold tracking-widest text-white uppercase">
            <div class="flex gap-8">
                <a href="mailto:info@politeknikjambi.ac.id" class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer relative z-50">
                    <i class="fas fa-envelope text-yellow-400"></i> <span class="notranslate">info@politeknikjambi.ac.id</span>
                </a>
            </div>
            <div class="flex gap-6 items-center">
                <div class="flex gap-3">
                    <a href="https://www.instagram.com/politeknikjambi" target="_blank" class="text-white hover:text-yellow-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@politeknikjambi" target="_blank" class="text-white hover:text-yellow-400 transition"><i class="fab fa-tiktok"></i></a>
                    <a href="https://youtube.com/@poltekjambi" target="_blank" class="text-white hover:text-yellow-400 transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- NAVIGATION BAR -->
    @include('components.navbar')

    <!-- BREADCRUMB -->
    <div class="bg-gradient-to-r from-[#004494] to-[#0056b3] py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-50"></div>
        <div class="relative z-10 w-full px-6 lg:px-16 max-w-7xl mx-auto">
            <div class="flex items-center gap-2 text-[10px] font-bold tracking-widest text-blue-200 uppercase mb-4">
                <a href="{{ route('home') }}" class="hover:text-yellow-400 transition">Beranda</a>
                <i class="fas fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-yellow-400">Berita</span>
            </div>
            <h1 class="text-white text-3xl md:text-4xl font-bold leading-tight max-w-4xl">{{ $berita->judul }}</h1>
            <div class="flex items-center gap-6 mt-4">
                <span class="text-blue-200 text-xs flex items-center gap-2"><i class="far fa-calendar-alt"></i> {{ $berita->created_at ? $berita->created_at->translatedFormat('d F Y, H:i') : '-' }}</span>
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
                        @if($berita->gambar_fitur)
                        <div class="h-72 md:h-96 overflow-hidden">
                            <img src="{{ asset('storage/' . $berita->gambar_fitur) }}" class="w-full h-full object-cover" alt="{{ $berita->judul }}" onerror="this.src='{{ asset('images/gedung-poljam.png') }}'">
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
                <div class="lg:w-1/3 space-y-8">
                    <!-- Berita Terbaru -->
                    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-white/10 p-8 shadow-sm sticky top-24">
                        <h4 class="text-slate-900 dark:text-white font-bold text-xl mb-8 relative inline-block">
                            Berita Terbaru
                            <span class="absolute -bottom-2 left-0 w-12 h-1 bg-yellow-400 rounded-full"></span>
                        </h4>
                        
                        <div class="space-y-0 divide-y divide-slate-100 dark:divide-white/5">
                            @foreach($recentBerita as $recent)
                            <a href="{{ route('berita.show', $recent->slug) }}" class="group block py-4 first:pt-0 last:pb-0">
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                        @if($recent->gambar_fitur)
                                            <img src="{{ asset('storage/' . $recent->gambar_fitur) }}" class="w-full h-full object-cover" alt="" onerror="this.src='{{ asset('images/gedung-poljam.png') }}'">
                                        @else
                                            <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover" alt="">
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
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#004494] pt-20 pb-12 border-t border-[#003377]">
        <div class="container mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-16 mb-16">
                <div class="max-w-xs">
                    <div class="bg-white p-2 rounded-xl inline-block mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
                    </div>
                    <p class="text-blue-100 text-sm font-light leading-relaxed">
                        Lembaga Penjamin Mutu Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi nasional.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-16 uppercase font-black text-[10px] tracking-[0.2em] text-blue-200">
                    <div class="space-y-4">
                        <div class="text-yellow-400 mb-2">Tautan Utama</div>
                        <a href="{{ route('home') }}" class="block text-white hover:text-yellow-400 transition">Beranda</a>
                        <a href="{{ route('spmi.show', 'dokumen') }}" class="block text-white hover:text-yellow-400 transition">Dokumen SPMI</a>
                        <a href="{{ route('akreditasi.index') }}" class="block text-white hover:text-yellow-400 transition">Akreditasi</a>
                    </div>
                    <div class="space-y-4">
                        <div class="text-yellow-400 mb-2">Kontak</div>
                        <span class="block lowercase font-medium text-white">Jalan Lingkar Barat II</span>
                        <span class="block lowercase font-medium text-white">Kota Jambi, Indonesia</span>
                    </div>
                </div>
            </div>
            <div class="pt-8 border-t border-white/10 text-center">
                <span class="text-[10px] font-bold text-blue-200 uppercase tracking-[0.3em]">© 2026 LPM Politeknik Jambi. All Rights Reserved.</span>
            </div>
        </div>
    </footer>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'id', includedLanguages: 'en,id', autoDisplay: false}, 'google_translate_element');
        }
        function changeLanguage(lang) {
            var selectField = document.querySelector(".goog-te-combo");
            if(selectField) { selectField.value = lang; selectField.dispatchEvent(new Event('change')); }
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <div id="google_translate_element" style="display:none;"></div>
</body>
</html>
