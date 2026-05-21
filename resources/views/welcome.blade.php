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
        
        body { font-family: 'Outfit', sans-serif; background-color: #ffffff; color: #0f172a; scroll-behavior: smooth; }
        .font-serif-luxury { font-family: 'Playfair Display', serif; }
        
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
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="splash-logo mb-4">
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

    <!-- TOP BAR -->
<div class="bg-[#0056b3] py-3 border-b border-[#004494] w-full">
    <div class="w-full px-6 lg:px-16 flex justify-between items-center text-[10px] font-bold tracking-widest text-white uppercase">
        <div class="flex gap-8">
            <a href="mailto:info@politeknikjambi.ac.id" class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer relative z-50">
                <i class="fas fa-envelope text-yellow-400"></i> <span class="notranslate">info@politeknikjambi.ac.id</span>
            </a>
            <a href="tel:+62741123456" class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer relative z-50">
                <i class="fas fa-phone text-yellow-400"></i> <span class="notranslate">+62 741 123 456</span>
            </a>
        </div>
        <div class="flex gap-6 items-center">
            <div class="flex gap-3 border-r pr-6 border-white/20">
                <a href="https://www.instagram.com/politeknikjambi?igsh=MTJ0bmZzamZyaThz" target="_blank" class="text-white hover:text-yellow-400 transition cursor-pointer relative z-50"><i class="fab fa-instagram"></i></a>
                <a href="https://www.tiktok.com/@politeknikjambi?_r=1&_t=ZS-96VS6wE9FWq" target="_blank" class="text-white hover:text-yellow-400 transition cursor-pointer relative z-50"><i class="fab fa-tiktok"></i></a>
                <a href="https://youtube.com/@poltekjambi?si=vHzgQPg277MlnDlO" target="_blank" class="text-white hover:text-yellow-400 transition cursor-pointer relative z-50"><i class="fab fa-youtube"></i></a>
            </div>
            <div class="flex gap-3 text-white ml-2 relative z-50">
                <span class="cursor-pointer hover:text-yellow-400 transition flex items-center gap-1" onclick="changeLanguage('id')">
                    ID <img src="https://upload.wikimedia.org/wikipedia/commons/9/9f/Flag_of_Indonesia.svg" class="w-4 h-3 object-cover rounded-sm inline" alt="ID">
                </span>
                <span class="text-white/30">|</span>
                <span class="cursor-pointer hover:text-yellow-400 transition flex items-center gap-1" onclick="changeLanguage('en')">
                    EN <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom.svg" class="w-4 h-3 object-cover rounded-sm inline" alt="EN">
                </span>
            </div>
        </div>
    </div>
</div>

    <!-- NAVIGATION BAR -->
    @include('components.navbar')

<!-- BERITA & ARTIKEL SECTION -->
<section class="py-24 bg-[#f8f9fa] dark:bg-slate-950 relative overflow-hidden transition-colors duration-500">
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#0056b3] rounded-full blur-[150px] opacity-10"></div>
    <div class="relative z-10 w-full px-6 lg:px-16">
        <div class="max-w-7xl mx-auto space-y-12">
            <!-- NEWS SLIDER (TOP - FULL WIDTH) -->
            <div id="news-slider" class="relative bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 w-full group">
                <div id="slider-wrapper" class="relative h-72 md:h-[450px] w-full">
                    @foreach($sliderItems as $index => $item)
                        <a href="{{ route('profil.show', $item->slug) }}" class="slider-item absolute inset-0 opacity-0 transition-all duration-1000 z-0 {{ $index == 0 ? 'opacity-100 z-10' : '' }}" data-index="{{ $index }}">
                            <div class="relative h-full w-full overflow-hidden">
                                <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $item->judul }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-8 pb-14 md:p-12 md:pb-20">
                                    <span class="inline-block px-3 py-1 bg-yellow-400 text-[#0056b3] text-[9px] font-black uppercase tracking-widest rounded-full mb-4 shadow-md">Berita Utama</span>
                                    <h3 class="text-white text-3xl md:text-5xl font-bold leading-tight group-hover:text-yellow-400 transition max-w-4xl">{{ $item->judul }}</h3>
                                    <p class="text-slate-200 text-sm mt-4 line-clamp-2 max-w-3xl opacity-80">
                                        {!! strip_tags($item->isi_konten) !!}
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

            <div class="flex flex-col lg:flex-row gap-12">
                <!-- MAIN CONTENT (LEFT) -->
                <div class="lg:w-2/3 space-y-10">
                    <!-- 2 Column Grid Articles -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Article 1 -->
                        <a href="{{ route('artikel.kategori', 'berita') }}" class="group bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden hover:border-[#0056b3] transition-all duration-500 shadow-sm hover:shadow-lg">
                            <div class="h-52 overflow-hidden relative">
                                <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Berita">
                            </div>
                            <div class="p-6">
                                <h4 class="text-slate-800 dark:text-white font-bold mb-3 leading-tight group-hover:text-[#0056b3] transition">Lokakarya Audit Mutu Internal Politeknik Jambi</h4>
                                <div class="flex items-center gap-3 text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-3">
                                    <span>Admin</span> <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span>Berita</span> <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span>07 Feb 2023</span>
                                </div>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Pada Jumat 13 Maret 2020 dan Sabtu 14 Maret 2020, Lembaga Penjaminan Mutu Politeknik Jambi mengadakan Lokakarya AMI...</p>
                                <span class="inline-flex items-center gap-2 mt-4 text-[#0056b3] text-xs font-bold">Read more ... <i class="fas fa-arrow-right text-[9px]"></i></span>
                            </div>
                        </a>

                        <!-- Article 2 -->
                        <a href="{{ route('artikel.kategori', 'berita') }}" class="group bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden hover:border-[#0056b3] transition-all duration-500 shadow-sm hover:shadow-lg">
                            <div class="h-52 overflow-hidden relative">
                                <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Berita">
                            </div>
                            <div class="p-6">
                                <h4 class="text-slate-800 dark:text-white font-bold mb-3 leading-tight group-hover:text-[#0056b3] transition">Diskusi tentang SPMI Poljam dan STKIP Al Azhar Jambi</h4>
                                <div class="flex items-center gap-3 text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-3">
                                    <span>Admin</span> <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span>Berita</span> <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span>07 Feb 2023</span>
                                </div>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">STKIP Al Azhar Jambi melakukan Kegiatan Studi Banding ke Lembaga Perencanaan Pengembangan dan Penjaminan Mutu...</p>
                                <span class="inline-flex items-center gap-2 mt-4 text-[#0056b3] text-xs font-bold">Read more ... <i class="fas fa-arrow-right text-[9px]"></i></span>
                            </div>
                        </a>
                    </div>
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
                        <a href="{{ route('artikel.kategori', 'berita') }}" class="group block py-4">
                            <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between leading-relaxed">
                                PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding ke LP3M Politeknik Jambi
                                <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                            </span>
                        </a>
                        <a href="https://e-spmi.politeknikjambi.ac.id" target="_blank" class="group block py-4">
                            <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between">
                                e-spmiPoljam
                                <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                            </span>
                        </a>
                        <a href="{{ route('spmi.show', 'rtm') }}" class="group block py-4 last:pb-0">
                            <span class="text-slate-700 dark:text-slate-300 font-semibold group-hover:text-[#0056b3] transition flex items-center justify-between">
                                RTM
                                <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

<!-- KONTAK SECTION -->
<section class="py-24 bg-white dark:bg-slate-900 relative overflow-hidden border-t border-slate-100 dark:border-white/5 transition-colors duration-500">
    <div class="relative z-10 w-full px-6 lg:px-16">
        <div class="text-center mb-16">
            <span class="text-[#0056b3] font-black tracking-[0.4em] text-[10px] uppercase block mb-4">Get in Touch</span>
            <h2 class="font-serif-luxury text-5xl text-slate-900 dark:text-white">Hubungi <span class="text-[#0056b3] italic">Kami</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <a href="https://maps.google.com/?q=Politeknik+Jambi" target="_blank" class="group block p-8 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-200 dark:border-white/10 text-center shadow-sm hover:border-[#0056b3] transition-all cursor-pointer">
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[#0056b3] transition"><i class="fas fa-map-marker-alt text-[#0056b3] group-hover:text-white text-xl transition"></i></div>
                <h4 class="text-slate-800 dark:text-white font-bold mb-2 group-hover:text-[#0056b3] transition">Alamat</h4>
                <p class="text-slate-600 dark:text-slate-400 text-sm">Jalan Lingkar Barat II, Lorong Veteran, Kelurahan Kenali Asam Atas, Kecamatan Kotabaru, Kota Jambi</p>
            </a>
            <a href="mailto:info@politeknikjambi.ac.id" class="group block p-8 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-200 dark:border-white/10 text-center shadow-sm hover:border-[#0056b3] transition-all cursor-pointer">
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[#0056b3] transition"><i class="fas fa-envelope text-[#0056b3] group-hover:text-white text-xl transition"></i></div>
                <h4 class="text-slate-800 dark:text-white font-bold mb-2 group-hover:text-[#0056b3] transition">Email</h4>
                <p class="text-slate-600 dark:text-slate-400 text-sm">info@politeknikjambi.ac.id</p>
            </a>
            <a href="tel:+62741123456" class="group block p-8 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-200 dark:border-white/10 text-center shadow-sm hover:border-[#0056b3] transition-all cursor-pointer">
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[#0056b3] transition"><i class="fas fa-phone text-[#0056b3] group-hover:text-white text-xl transition"></i></div>
                <h4 class="text-slate-800 dark:text-white font-bold mb-2 group-hover:text-[#0056b3] transition">Telepon</h4>
                <p class="text-slate-600 dark:text-slate-400 text-sm">+62 741 123 456</p>
            </a>
        </div>
    </div>
</section>


    <footer class="bg-[#004494] pt-32 pb-12 border-t border-[#003377]">
        <div class="container mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-20 mb-24">
                <div class="max-w-xs">
                    <div class="bg-white p-2 rounded-xl inline-block mb-8">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 transition-all cursor-pointer">
                    </div>
                    <p class="text-blue-100 text-sm font-light leading-relaxed mb-8">
                        Lembaga Penjamin Mutu Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi nasional.
                    </p>
                    <div class="flex gap-4 relative z-50">
                        <a href="https://www.instagram.com/politeknikjambi?igsh=MTJ0bmZzamZyaThz" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@politeknikjambi?_r=1&_t=ZS-96VS6wE9FWq" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-tiktok"></i></a>
                        <a href="https://youtube.com/@poltekjambi?si=vHzgQPg277MlnDlO" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-20 uppercase font-black text-[10px] tracking-[0.2em] text-blue-200">
                    <div class="space-y-6">
                        <div class="text-yellow-400 mb-2">Tautan Utama</div>
                        <a href="#" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Dashboard</a>
                        <a href="{{ route('spmi.show', 'dokumen') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Dokumen SPMI</a>
                        <a href="#" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Laporan AMI</a>
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
