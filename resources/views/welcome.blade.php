<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPM Politeknik Jambi | Premium Quality Assurance Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
</head>
<body class="antialiased">

    <!-- SPLASH SCREEN -->
    <div id="splash-screen" class="active">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="splash-logo mb-4">
            <div class="w-48 h-1 bg-slate-100 mx-auto rounded-full overflow-hidden">
                <div class="h-full bg-blue-700 animate-[loading_2s_ease-in-out_infinite]"></div>
            </div>
        </div>
    </div>

    <!-- NEWS TICKER -->
    <div class="bg-slate-900 py-2 overflow-hidden border-b border-white/5">
        <div class="container mx-auto px-8 flex items-center">
            <div class="text-[10px] text-slate-400 font-medium uppercase tracking-[0.2em] whitespace-nowrap animate-[marquee_30s_linear_infinite]">
                Akreditasi Institusi "BAIK SEKALI" • Pendaftaran Audit Mutu Internal Semester Genap 2026 Telah Dibuka • Standar Mutu ISO 9001:2015 Terintegrasi
            </div>
        </div>
    </div>

    <!-- TOP BAR -->
<div class="bg-blue-700 py-3 border-b border-blue-800 w-full">
    <div class="w-full px-6 lg:px-16 flex justify-between items-center text-[10px] font-bold tracking-widest text-white uppercase">
        <div class="flex gap-8">
            <span class="flex items-center gap-2">
                <i class="fas fa-envelope text-white/80"></i> lpm@politeknikjambi.ac.id
            </span>
            <span class="flex items-center gap-2">
                <i class="fas fa-phone text-white/80"></i> +62 741 123 456
            </span>
        </div>
        <div class="flex gap-6 items-center">
            <div class="flex gap-3 border-r pr-6 border-white/20">
                <i class="fab fa-facebook-f hover:text-blue-200 transition cursor-pointer"></i>
                <i class="fab fa-instagram hover:text-blue-200 transition cursor-pointer"></i>
                <i class="fab fa-youtube hover:text-blue-200 transition cursor-pointer"></i>
            </div>
            <span class="text-white cursor-pointer hover:text-blue-200 transition">
                English Version <i class="fas fa-globe ml-1"></i>
            </span>
        </div>
    </div>
</div>

    <!-- NAVIGATION BAR -->
<nav class="glass-nav sticky top-0 z-50 border-b border-slate-100">
    <div class="container mx-auto px-8 py-5 flex justify-between items-center">
        <!-- Logo Section -->
        <a href="{{ url('/') }}" class="flex items-center gap-4 group cursor-pointer">
            <div class="relative overflow-hidden rounded-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto group-hover:scale-110 transition-transform duration-500">
            </div>
            <div>
                <span class="block text-lg font-black tracking-tighter text-slate-900 leading-none uppercase">LPM POLJAM</span>
                <span class="text-[9px] font-bold text-blue-700 uppercase tracking-widest leading-none">Internal Quality Assurance</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden xl:flex items-center gap-8 text-[11px] font-bold uppercase tracking-widest text-slate-600">
            <a href="{{ url('/') }}" class="text-blue-700 nav-link">Home <div class="nav-indicator w-full"></div></a>
            
            <!-- Menu Profil -->
            <div class="relative group py-4 cursor-pointer">
                <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase font-bold text-[11px] tracking-widest">
                    Profil <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                
                <div class="absolute top-full left-0 w-72 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden z-50">
                    <div class="p-2 flex flex-col">
                        @php
                            $profilMenus = [
                                ['slug' => 'visi-dan-misi', 'label' => 'Visi Dan Misi'],
                                ['slug' => 'moto-dan-janji-layanan', 'label' => 'Moto & Janji Layanan'],
                                ['slug' => 'kebijakan-mutu-poljam', 'label' => 'Kebijakan Mutu Poljam'],
                                ['slug' => 'sasaran-mutu-poljam', 'label' => 'Sasaran Mutu Poljam'],
                                ['slug' => 'standar-mutu-poljam', 'label' => 'Standar Mutu Poljam'],
                                ['slug' => 'sasaran-mutu-lpm', 'label' => 'Sasaran Mutu LPM'],
                                ['slug' => 'struktur-organisasi', 'label' => 'Struktur Organisasi'],
                                ['slug' => 'job-deskripsi', 'label' => 'Job Deskripsi'],
                                ['slug' => 'standar-waktu-pelayanan', 'label' => 'Standar Waktu Pelayanan'],
                                ['slug' => 'artikel', 'label' => 'Artikel & Berita'],
                            ];
                        @endphp

                        @foreach($profilMenus as $m)
                            <a href="{{ route('profil.show', $m['slug']) }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold text-xs flex justify-between items-center transition normal-case">
                                {{ $m['label'] }}
                                <i class="fas fa-chevron-right text-[8px] opacity-20"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Menu SPMI -->
            <div class="relative group py-4 cursor-pointer">
                <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase font-bold text-[11px] tracking-widest">SPMI <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden z-50">
                    <div class="p-2 flex flex-col">
                        <a href="{{ route('spmi.show', 'dokumen') }}" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold text-xs transition normal-case">Dokumen SPMI</a>
                        <a href="{{ route('spmi.show', 'rtm') }}" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold text-xs transition normal-case">RTM</a>
                        <a href="https://e-spmi.politeknikjambi.ac.id" target="_blank" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-blue-600 font-bold text-xs flex items-center justify-between transition normal-case">
                            E-SPMI POLJAM <i class="fas fa-external-link-alt text-[9px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Menu Akreditasi -->
            <div class="relative group py-4 cursor-pointer">
                <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase font-bold text-[11px] tracking-widest">Akreditasi <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden z-50">
                    <div class="p-2 flex flex-col">
                        <a href="{{ route('akreditasi.index') }}" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold text-xs flex justify-between items-center transition normal-case">Data Akreditasi <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                        <a href="{{ route('akreditasi.dokumen') }}" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold text-xs flex justify-between items-center transition normal-case">Dokumen Pendukung <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                    </div>
                </div>
            </div>

            <!-- Menu Kuesioner -->
            <div class="relative group py-4 cursor-pointer">
                <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase font-bold text-[11px] tracking-widest">Kuesioner <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden z-50">
                    <div class="p-2 flex flex-col">
                        <a href="{{ route('kuesioner.dosen') }}" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold text-xs flex justify-between items-center transition normal-case">Dosen & Karyawan <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                        <a href="{{ route('kuesioner.mahasiswa') }}" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold text-xs flex justify-between items-center transition normal-case">Mahasiswa <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                    </div>
                </div>
            </div>

            <!-- Galeri -->
            <a href="{{ route('gallery.index') }}" class="hover:text-blue-700 transition uppercase font-bold text-[11px] tracking-widest px-4">Galeri</a>

            <div class="h-8 w-[1px] bg-slate-100 mx-2"></div>

            <!-- Button Login -->
            <a href="{{ route('login') }}" class="group relative px-8 py-3 overflow-hidden rounded-full bg-blue-700 text-white shadow-xl shadow-blue-200 transition-all">
                <span class="relative z-10 text-[10px] font-black uppercase tracking-widest">Login Portal</span>
                <div class="absolute inset-0 bg-blue-800 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
            </a>
        </div>
    </div>
</nav>

    <!-- HERO SECTION -->
<section class="relative pt-10 pb-20 overflow-hidden w-full">
    <!-- Background Decor - Diperlebar agar menutupi area luar -->
    <div class="absolute top-0 right-0 w-full lg:w-1/2 h-full bg-blue-50/50 -z-10 rounded-l-[100px] hidden lg:block"></div>
    <div class="absolute top-40 left-10 w-96 h-96 bg-blue-100 rounded-full blur-[120px] opacity-30 animate-pulse"></div>

    <!-- Gunakan 'container-fluid' atau hapus max-width pada container -->
    <div class="w-full px-6 lg:px-16 grid lg:grid-cols-2 gap-10 items-center">
        
        <!-- SISI KIRI: TEXT CONTENT (Diberi padding left agar tidak terlalu mepet layar) -->
        <div class="relative z-10 py-10 lg:pl-10">
            <div class="inline-flex items-center gap-3 py-2 px-5 bg-white border border-slate-100 shadow-sm rounded-full mb-8">
                <span class="w-2 h-2 bg-blue-600 rounded-full animate-ping"></span>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em]">Penjaminan Mutu Internal v.2.6</span>
            </div>
            
            <!-- Font size disesuaikan agar proporsional di layar lebar -->
            <h1 class="font-serif-luxury text-6xl xl:text-8xl text-slate-900 leading-[0.95] mb-8">
                Kualitas <br>
                Tanpa <span class="gradient-text italic">Kompromi</span>.
            </h1>
            
            <p class="text-slate-500 text-lg leading-relaxed mb-10 font-light max-w-xl">
                Menjaga integritas akademik dan profesionalisme pendidikan vokasi melalui sistem monitoring mutu yang presisi, transparan, dan akuntabel.
            </p>

            <div class="flex items-center gap-8 mb-12">
                <div class="flex -space-x-4">
                    <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-200 overflow-hidden flex items-center justify-center"><i class="fas fa-user text-slate-400"></i></div>
                    <div class="w-12 h-12 rounded-full border-4 border-white bg-blue-700 flex items-center justify-center text-white text-[10px] font-bold">LPM</div>
                    <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-900 flex items-center justify-center text-white"><i class="fas fa-plus text-[10px]"></i></div>
                </div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    Dipercaya oleh <span class="text-slate-900">12+ Program Studi</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-md">
                <div class="p-6 bg-slate-50/80 backdrop-blur-sm rounded-2xl border border-slate-100">
                    <div class="text-3xl font-black text-blue-700 mb-1 leading-none">2026</div>
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Target Unggul</div>
                </div>
                <div class="p-6 bg-slate-50/80 backdrop-blur-sm rounded-2xl border border-slate-100">
                    <div class="text-3xl font-black text-blue-700 mb-1 leading-none">ISO</div>
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">9001:2015</div>
                </div>
            </div>
        </div>

        <!-- SISI KANAN: VISUAL SLIDER (Dibuat Full Width ke arah kanan) -->
        <div class="relative w-full h-full lg:h-[110%] flex items-center">
            <!-- Navigasi Slider -->
            <div class="absolute -top-10 lg:top-10 right-4 lg:right-10 flex gap-3 z-30">
                <button onclick="changeSlide(-1)" class="w-12 h-12 rounded-xl bg-white/90 backdrop-blur shadow-lg flex items-center justify-center text-slate-400 hover:text-blue-700 transition-all active:scale-90">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button onclick="changeSlide(1)" class="w-12 h-12 rounded-xl bg-blue-700 shadow-lg flex items-center justify-center text-white hover:bg-blue-800 transition-all active:scale-90">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            <div class="relative w-full animate-float pl-4">
                
                <!-- Decorative Layer -->
                <div class="absolute -inset-4 bg-blue-600/10 rounded-[60px] rotate-2"></div>
                
                <!-- Main Slider Card -->
                <div class="relative bg-white rounded-[50px] shadow-2xl p-4 border border-slate-50 overflow-hidden">
                    <div class="bg-slate-950 rounded-[40px] aspect-video lg:aspect-[16/10] relative overflow-hidden flex items-center justify-center">
                        
                        <!-- SLIDE 1 -->
                        <div class="hero-slide active absolute inset-0 flex flex-col items-center justify-center text-center p-8 lg:p-16">
                            <div class="mb-6 w-20 h-20 bg-blue-700/20 rounded-3xl flex items-center justify-center border border-blue-600/30">
                                <i class="fas fa-shield-halved text-blue-600 text-3xl"></i>
                            </div>
                            <h3 class="text-white text-xl lg:text-3xl font-bold mb-4">Sistem Mutu Terpadu</h3>
                            <p class="text-slate-400 text-sm lg:text-base leading-relaxed max-w-sm">Integrasi data SPMI yang memudahkan monitoring dan evaluasi standar akademik secara otomatis.</p>
                        </div>

                        <!-- SLIDE 2 (Sama seperti Slide 1, sesuaikan konten) -->
                        <div class="hero-slide absolute inset-0 flex flex-col items-center justify-center text-center p-8 lg:p-16">
                            <div class="mb-6 w-20 h-20 bg-blue-800/20 rounded-3xl flex items-center justify-center border border-blue-700/30">
                                <i class="fas fa-microchip text-blue-500 text-3xl"></i>
                            </div>
                            <h3 class="text-white text-xl lg:text-3xl font-bold mb-4">Inovasi Digital Vokasi</h3>
                            <p class="text-slate-400 text-sm lg:text-base leading-relaxed max-w-sm">Penerapan teknologi terkini untuk efisiensi pengelolaan dokumen akreditasi.</p>
                        </div>

                        <!-- Dots -->
                        <div class="absolute bottom-8 flex gap-2">
                            <div class="dot w-8 h-1.5 rounded-full bg-blue-700 cursor-pointer" onclick="currentSlide(0)"></div>
                            <div class="dot w-2 h-1.5 rounded-full bg-white/20 cursor-pointer" onclick="currentSlide(1)"></div>
                            <div class="dot w-2 h-1.5 rounded-full bg-white/20 cursor-pointer" onclick="currentSlide(2)"></div>
                        </div>
                    </div>
                </div>

                <!-- Floating Badge -->
                <div class="absolute -bottom-8 -left-4 bg-white p-6 rounded-[30px] shadow-2xl border border-slate-50 hidden md:block">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-700 text-xl font-black">
                            100%
                        </div>
                        <div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Status Operasional</div>
                            <div class="text-base font-bold text-slate-900">Terdigitalisasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ... (Selesai Hero Section) ... -->
</section>

<!-- VISI & MISI SECTION -->
<section class="py-24 bg-white relative overflow-hidden">
    <!-- Dekorasi Latar Belakang agar Senada dengan Hero -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-50 rounded-full blur-[120px] opacity-50 -z-10"></div>
    
    <div class="w-full px-6 lg:px-16">
        <div class="flex flex-col lg:flex-row gap-16 items-start">
            
            <!-- SISI KIRI: Judul & Visi -->
            <div class="lg:w-1/3 sticky top-32">
                <div class="inline-flex items-center gap-3 py-2 px-5 bg-blue-50 rounded-full mb-6">
                    <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Core Purpose</span>
                </div>
                <h2 class="font-serif-luxury text-5xl text-slate-900 leading-tight mb-8">
                    Komitmen <br> <span class="gradient-text italic">Masa Depan</span>
                </h2>
                
                <!-- Card Visi (Mewah dengan Dark Theme) -->
                <div class="group p-8 bg-slate-950 rounded-[40px] shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <div class="text-blue-500 mb-6">
                        <i class="fas fa-quote-left text-4xl opacity-50"></i>
                    </div>
                    <p class="text-white text-xl leading-relaxed font-light italic">
                        "Menjadi lembaga penjaminan mutu yang kredibel dan inovatif dalam mewujudkan pendidikan vokasi yang unggul dan berdaya saing global."
                    </p>
                    <div class="mt-8 pt-6 border-t border-white/10 flex items-center gap-4">
                        <div class="w-10 h-1 bg-blue-600"></div>
                        <span class="text-white/40 uppercase tracking-widest text-[10px] font-bold">Visi Institusi</span>
                    </div>
                </div>
            </div>

            <!-- SISI KANAN: Misi (Grid Cards) -->
            <div class="lg:w-2/3">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Misi 1 -->
                    <div class="p-10 bg-slate-50 rounded-[40px] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-white shadow-lg rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-700 transition-colors duration-500">
                            <i class="fas fa-check-double text-blue-700 group-hover:text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 tracking-tight">Standarisasi Mutu</h4>
                        <p class="text-slate-500 leading-relaxed font-light text-sm">
                            Mengembangkan dan mengimplementasikan sistem penjaminan mutu internal secara berkelanjutan sesuai standar nasional pendidikan tinggi.
                        </p>
                    </div>

                    <!-- Misi 2 -->
                    <div class="p-10 bg-slate-50 rounded-[40px] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-white shadow-lg rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-700 transition-colors duration-500">
                            <i class="fas fa-chart-line text-blue-700 group-hover:text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 tracking-tight">Audit & Evaluasi</h4>
                        <p class="text-slate-500 leading-relaxed font-light text-sm">
                            Melaksanakan audit mutu internal secara periodik dan transparan untuk memastikan kepatuhan serta peningkatan standar akademik.
                        </p>
                    </div>

                    <!-- Misi 3 -->
                    <div class="p-10 bg-slate-50 rounded-[40px] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-white shadow-lg rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-700 transition-colors duration-500">
                            <i class="fas fa-lightbulb text-blue-700 group-hover:text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 tracking-tight">Budaya Inovasi</h4>
                        <p class="text-slate-500 leading-relaxed font-light text-sm">
                            Mendorong terciptanya budaya mutu dan inovasi di seluruh civitas akademika Politeknik Jambi guna mencapai akreditasi unggul.
                        </p>
                    </div>

                    <!-- Misi 4 -->
                    <div class="p-10 bg-slate-50 rounded-[40px] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-white shadow-lg rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-700 transition-colors duration-500">
                            <i class="fas fa-handshake text-blue-700 group-hover:text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 tracking-tight">Kemitraan Strategis</h4>
                        <p class="text-slate-500 leading-relaxed font-light text-sm">
                            Membangun kerjasama strategis dengan lembaga penjaminan mutu eksternal dan industri baik skala nasional maupun internasional.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FOOTER CTA (Bagian yang sudah ada di kodemu) -->
<section class="py-24 bg-blue-700 relative overflow-hidden">
    <!-- ... isi footer cta kamu ... -->
    <!-- FOOTER CTA -->
    <section class="py-24 bg-blue-700 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48 blur-[100px]"></div>
        <div class="container mx-auto px-8 relative z-10">
            <div class="bg-white/10 backdrop-blur-md rounded-[50px] p-16 border border-white/20 text-center max-w-4xl mx-auto">
                <h2 class="font-serif-luxury text-5xl text-white mb-8 italic">Siap Melangkah Bersama Menuju Akreditasi Unggul?</h2>
                <div class="flex flex-wrap justify-center gap-6">
                    <button class="bg-white text-blue-700 px-12 py-5 rounded-full font-black text-[12px] uppercase shadow-2xl hover:scale-105 transition-all active:scale-95">Akses Sistem SPMI</button>
                    <button class="bg-transparent border border-white/50 text-white px-12 py-5 rounded-full font-black text-[12px] uppercase hover:bg-white/10 transition-all active:scale-95">Unduh Panduan Mutu</button>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white pt-32 pb-12 border-t border-slate-50">
        <div class="container mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-20 mb-24">
                <div class="max-w-xs">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 mb-8 grayscale hover:grayscale-0 transition-all cursor-pointer">
                    <p class="text-slate-400 text-sm font-light leading-relaxed mb-8">
                        Lembaga Penjamin Mutu Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi nasional.
                    </p>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-700 hover:text-white transition-all cursor-pointer"><i class="fab fa-instagram"></i></div>
                        <div class="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-700 hover:text-white transition-all cursor-pointer"><i class="fab fa-facebook-f"></i></div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-20 uppercase font-black text-[10px] tracking-[0.2em] text-slate-900">
                    <div class="space-y-6">
                        <div class="text-blue-700 mb-2">Tautan Utama</div>
                        <a href="#" class="block hover:translate-x-2 transition">Dashboard</a>
                        <a href="#" class="block hover:translate-x-2 transition">Dokumen SPMI</a>
                        <a href="#" class="block hover:translate-x-2 transition">Laporan AMI</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-blue-700 mb-2">Informasi</div>
                        <a href="#" class="block hover:translate-x-2 transition">Renop & Renstra</a>
                        <a href="#" class="block hover:translate-x-2 transition">Sertifikasi ISO</a>
                        <a href="#" class="block hover:translate-x-2 transition">Alumni & Karir</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-blue-700 mb-2">Kontak</div>
                        <span class="block lowercase font-medium text-slate-400">Gedung Utama Lt. 2</span>
                        <span class="block lowercase font-medium text-slate-400">Politeknik Jambi</span>
                        <span class="block lowercase font-medium text-slate-400">Kota Jambi, Indonesia</span>
                    </div>
                </div>
            </div>
            <div class="pt-12 border-t border-slate-50 flex flex-col md:flex-row justify-between gap-8 items-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em]">© 2026 LPM Politeknik Jambi. All Rights Reserved.</span>
                <div class="flex gap-10 text-[9px] font-black uppercase tracking-widest text-slate-400">
                    <a href="#" class="hover:text-blue-700">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-700">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const splash = document.getElementById('splash-screen');
                splash.style.opacity = '0';
                setTimeout(() => splash.remove(), 600);
            }, 2000);
        });

        let currentSlideIdx = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.dot');

        function showSlide(n) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => {
                d.classList.remove('bg-blue-700', 'w-8');
                d.classList.add('bg-white/20', 'w-2');
            });
            
            currentSlideIdx = (n + slides.length) % slides.length;
            slides[currentSlideIdx].classList.add('active');
            dots[currentSlideIdx].classList.remove('bg-white/20', 'w-2');
            dots[currentSlideIdx].classList.add('bg-blue-700', 'w-8');
        }

        function changeSlide(n) { showSlide(currentSlideIdx + n); }
        function currentSlide(n) { showSlide(n); }

        setInterval(() => changeSlide(1), 5000);
    </script>
</body>
</html>