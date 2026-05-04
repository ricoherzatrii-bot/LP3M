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
    <div class="bg-blue-700 py-3 border-b border-blue-800">
        <div class="container mx-auto px-8 flex justify-between items-center text-[10px] font-bold tracking-widest text-white uppercase">
            <div class="flex gap-8">
                <span class="flex items-center gap-2"><i class="fas fa-envelope text-white/80"></i> lpm@politeknikjambi.ac.id</span>
                <span class="flex items-center gap-2"><i class="fas fa-phone text-white/80"></i> +62 741 123 456</span>
            </div>
            <div class="flex gap-6 items-center">
                <div class="flex gap-3 border-r pr-6 border-white/20">
                    <i class="fab fa-facebook-f hover:text-blue-200 transition cursor-pointer"></i>
                    <i class="fab fa-instagram hover:text-blue-200 transition cursor-pointer"></i>
                    <i class="fab fa-youtube hover:text-blue-200 transition cursor-pointer"></i>
                </div>
                <span class="text-white cursor-pointer">English Version <i class="fas fa-globe ml-1"></i></span>
            </div>
        </div>
    </div>

    <!-- NAVIGATION BAR -->
    <nav class="glass-nav sticky top-0 z-50 border-b border-slate-100">
        <div class="container mx-auto px-8 py-5 flex justify-between items-center">
            <div class="flex items-center gap-4 group cursor-pointer">
                <div class="relative overflow-hidden rounded-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto group-hover:scale-110 transition-transform duration-500">
                </div>
                <div>
                    <span class="block text-lg font-black tracking-tighter text-slate-900 leading-none uppercase">LPM POLJAM</span>
                    <span class="text-[9px] font-bold text-blue-700 uppercase tracking-widest leading-none">Internal Quality Assurance</span>
                </div>
            </div>

            <div class="hidden xl:flex items-center gap-8 text-[11px] font-bold uppercase tracking-widest text-slate-600">
                <a href="#" class="text-blue-700 nav-link">Home <div class="nav-indicator w-full"></div></a>
                
                <!-- Menu Profil (Updated from Images) -->
                <div class="relative group py-4 cursor-pointer">
                    <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase">Profil <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                    <div class="absolute top-full left-0 w-72 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden">
                        <div class="p-2 flex flex-col">
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Visi Dan Misi <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Moto Dan Janji Layanan <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Kebijakan Mutu POLJAM <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Sasaran Mutu POLJAM <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Standar Mutu POLJAM <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Sasaran Mutu LPM <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Struktur Organisasi <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Job Deskripsi <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Standar Waktu Pelayanan <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Artikel <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Menu SPMI (Updated from Images) -->
                <div class="relative group py-4 cursor-pointer">
                    <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase">SPMI <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                    <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden">
                        <div class="p-2 flex flex-col">
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Dokumen SPMI <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Unit <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">RTM <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Dokumen Mutu SPMI <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">e-spmiPoljam <i class="fas fa-external-link-alt text-[8px] opacity-20"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Menu Akreditasi (Updated from Images) -->
                <div class="relative group py-4 cursor-pointer">
                    <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase">Akreditasi <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                    <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden">
                        <div class="p-2 flex flex-col">
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Akreditasi <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Dokumen Akreditasi <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Menu Capaian (Updated from Images) -->
                <div class="relative group py-4 cursor-pointer">
                    <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase">Capaian <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                    <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden">
                        <div class="p-2 flex flex-col">
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Renop <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Capaian Renstra <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Menu Kuesioner (Updated from Images) -->
                <div class="relative group py-4 cursor-pointer">
                    <span class="flex items-center gap-1 hover:text-blue-700 transition uppercase">Kuesioner <i class="fas fa-chevron-down text-[8px] opacity-40"></i></span>
                    <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 overflow-hidden">
                        <div class="p-2 flex flex-col">
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Kuesioner Dosen & Karyawan <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                            <a href="#" class="px-4 py-3 hover:bg-blue-50 rounded-xl text-slate-700 normal-case font-semibold text-xs flex justify-between items-center transition">Kuisioner Mahasiswa <i class="fas fa-chevron-right text-[8px] opacity-20"></i></a>
                        </div>
                    </div>
                </div>

                <a href="#" class="nav-link uppercase">Galeri <div class="nav-indicator"></div></a>
                <div class="h-8 w-[1px] bg-slate-100 mx-2"></div>
                <a href="{{ route('login') }}" class="group relative px-8 py-3 overflow-hidden rounded-full bg-blue-700 text-white shadow-xl shadow-blue-200 transition-all">
                    <span class="relative z-10 text-[10px] font-black uppercase">Login Portal</span>
                    <div class="absolute inset-0 bg-blue-800 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="relative pt-20 pb-32 overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-blue-50/50 -z-10 rounded-l-[100px]"></div>
        <div class="absolute top-40 left-10 w-64 h-64 bg-blue-100 rounded-full blur-[100px] opacity-40 animate-pulse"></div>

        <div class="container mx-auto px-8 grid lg:grid-cols-2 gap-20 items-center">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-3 py-2 px-5 bg-white border border-slate-100 shadow-sm rounded-full mb-10">
                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-ping"></span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em]">Penjaminan Mutu Internal v.2.6</span>
                </div>
                
                <h1 class="font-serif-luxury text-7xl xl:text-8xl text-slate-900 leading-[0.9] mb-10">
                    Kualitas <br>
                    Tanpa <span class="gradient-text italic">Kompromi</span>.
                </h1>
                
                <p class="text-slate-500 text-lg leading-relaxed mb-12 font-light max-w-lg">
                    Menjaga integritas akademik dan profesionalisme pendidikan vokasi melalui sistem monitoring mutu yang presisi, transparan, dan akuntabel.
                </p>

                <div class="flex items-center gap-8 mb-16">
                    <div class="flex -space-x-4">
                        <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-200 overflow-hidden"><i class="fas fa-user text-slate-400 p-3"></i></div>
                        <div class="w-12 h-12 rounded-full border-4 border-white bg-blue-700 flex items-center justify-center text-white text-[10px] font-bold">LPM</div>
                        <div class="w-12 h-12 rounded-full border-4 border-white bg-slate-900 flex items-center justify-center text-white"><i class="fas fa-plus text-[10px]"></i></div>
                    </div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                        Dipercaya oleh <span class="text-slate-900">12+ Program Studi</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 max-w-md">
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-3xl font-black text-blue-700 mb-1 leading-none">2026</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Target Unggul</div>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="text-3xl font-black text-blue-700 mb-1 leading-none">ISO</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">9001:2015</div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="flex justify-end gap-3 mb-6 pr-4">
                    <button onclick="changeSlide(-1)" class="w-14 h-14 rounded-2xl bg-white border border-slate-100 shadow-xl shadow-slate-200/50 flex items-center justify-center text-slate-400 hover:text-blue-700 hover:border-blue-200 transition-all group active:scale-95">
                        <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
                    </button>
                    <button onclick="changeSlide(1)" class="w-14 h-14 rounded-2xl bg-blue-700 shadow-xl shadow-blue-200 flex items-center justify-center text-white hover:bg-blue-800 transition-all group active:scale-95">
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>

                <div class="relative animate-float">
                    <div class="absolute -inset-6 bg-blue-700/5 rounded-[60px] -rotate-3"></div>
                    <div class="absolute -inset-6 bg-blue-700/5 rounded-[60px] rotate-2"></div>
                    
                    <div class="relative bg-white rounded-[50px] shadow-[0_60px_100px_-20px_rgba(29,78,216,0.15)] p-5 border border-slate-100">
                        <div class="bg-slate-950 rounded-[40px] aspect-[4/3] relative overflow-hidden flex items-center justify-center group">
                            
                            <!-- SLIDE 1 -->
                            <div class="hero-slide active absolute inset-0 flex flex-col items-center justify-center text-center p-12">
                                <div class="mb-8 w-24 h-24 bg-blue-700/20 rounded-3xl flex items-center justify-center border border-blue-600/30">
                                    <i class="fas fa-shield-halved text-blue-600 text-4xl"></i>
                                </div>
                                <h3 class="text-white text-2xl font-bold mb-4">Sistem Mutu Terpadu</h3>
                                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">Integrasi data SPMI yang memudahkan monitoring dan evaluasi standar akademik secara otomatis.</p>
                            </div>

                            <!-- SLIDE 2 -->
                            <div class="hero-slide absolute inset-0 flex flex-col items-center justify-center text-center p-12">
                                <div class="mb-8 w-24 h-24 bg-blue-800/20 rounded-3xl flex items-center justify-center border border-blue-700/30">
                                    <i class="fas fa-microchip text-blue-500 text-4xl"></i>
                                </div>
                                <h3 class="text-white text-2xl font-bold mb-4">Inovasi Digital Vokasi</h3>
                                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">Penerapan teknologi terkini untuk memastikan efisiensi dalam pengelolaan dokumen akreditasi.</p>
                            </div>

                            <!-- SLIDE 3 -->
                            <div class="hero-slide absolute inset-0 flex flex-col items-center justify-center text-center p-12">
                                <div class="mb-8 w-24 h-24 bg-blue-900/20 rounded-3xl flex items-center justify-center border border-blue-800/30">
                                    <i class="fas fa-chart-pie text-blue-400 text-4xl"></i>
                                </div>
                                <h3 class="text-white text-2xl font-bold mb-4">Analisis Data Akurat</h3>
                                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">Visualisasi capaian indikator kinerja utama (IKU) dan kinerja tambahan secara real-time.</p>
                            </div>

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent pointer-events-none"></div>

                            <div class="absolute bottom-10 flex gap-2">
                                <div class="dot w-8 h-1.5 rounded-full bg-blue-700 transition-all cursor-pointer" onclick="currentSlide(0)"></div>
                                <div class="dot w-2 h-1.5 rounded-full bg-white/20 transition-all cursor-pointer" onclick="currentSlide(1)"></div>
                                <div class="dot w-2 h-1.5 rounded-full bg-white/20 transition-all cursor-pointer" onclick="currentSlide(2)"></div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-12 -left-12 bg-white p-8 rounded-[32px] shadow-2xl border border-slate-50 group hover:-translate-y-2 transition-transform duration-500">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-700 text-2xl font-black">
                                100<span class="text-sm">%</span>
                            </div>
                            <div>
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Operasional</div>
                                <div class="text-lg font-bold text-slate-900 leading-none">Terdigitalisasi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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