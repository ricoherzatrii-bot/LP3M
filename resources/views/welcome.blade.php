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
                <i class="fas fa-envelope text-white/80"></i> info@politeknikjambi.ac.id
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
    @include('components.navbar')

<!-- BERITA & ARTIKEL SECTION -->
<section class="py-24 bg-slate-900 relative overflow-hidden">
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full blur-[150px] opacity-10"></div>
    <div class="relative z-10 w-full px-6 lg:px-16">


        <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-10">
            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2 space-y-10">

                <!-- Featured Article (Full Width) -->
                <a href="{{ route('artikel.kategori', 'berita') }}" class="group block bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                    <div class="relative h-72 md:h-96 overflow-hidden">
                        <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Berita">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <span class="inline-block px-3 py-1 bg-blue-600 text-white text-[9px] font-bold uppercase tracking-widest rounded-full mb-3">Berita Utama</span>
                            <h3 class="text-white text-2xl font-bold leading-tight group-hover:text-blue-400 transition">PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding ke LP3M Politeknik Jambi</h3>
                            <p class="text-slate-400 text-sm mt-3 line-clamp-2">Pada Hari Selasa (14/12/2021) Pusat Penjaminan Mutu (PJM) STIKes Baiturrahim Jambi melakukan Kegiatan Studi Banding ke Lembaga Perencanaan Pengembangan dan Penjaminan Mutu Politeknik Jambi.</p>
                        </div>
                    </div>
                    <div class="px-8 py-4 border-t border-white/5 flex items-center gap-4 text-[10px] text-slate-500 font-bold uppercase tracking-widest">
                        <span>Admin</span> <span class="text-white/20">•</span>
                        <span>Berita</span> <span class="text-white/20">•</span>
                        <span>07 February 2023</span>
                    </div>
                </a>

                <!-- 2 Column Grid Articles -->
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Article 1 -->
                    <a href="{{ route('artikel.kategori', 'berita') }}" class="group bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                        <div class="h-52 overflow-hidden">
                            <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Berita">
                        </div>
                        <div class="p-6">
                            <h4 class="text-white font-bold mb-3 leading-tight group-hover:text-blue-400 transition">Lokakarya Audit Mutu Internal Politeknik Jambi</h4>
                            <div class="flex items-center gap-3 text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-3">
                                <span>Admin</span> <span class="text-white/20">•</span>
                                <span>Berita</span> <span class="text-white/20">•</span>
                                <span>07 Feb 2023</span>
                            </div>
                            <p class="text-slate-500 text-sm leading-relaxed">Pada Jumat 13 Maret 2020 dan Sabtu 14 Maret 2020, Lembaga Penjaminan Mutu Politeknik Jambi mengadakan Lokakarya AMI...</p>
                            <span class="inline-flex items-center gap-2 mt-4 text-blue-400 text-xs font-bold">Read more ... <i class="fas fa-arrow-right text-[9px]"></i></span>
                        </div>
                    </a>

                    <!-- Article 2 -->
                    <a href="{{ route('artikel.kategori', 'berita') }}" class="group bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                        <div class="h-52 overflow-hidden">
                            <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Berita">
                        </div>
                        <div class="p-6">
                            <h4 class="text-white font-bold mb-3 leading-tight group-hover:text-blue-400 transition">Diskusi tentang SPMI Poljam dan STKIP Al Azhar Jambi</h4>
                            <div class="flex items-center gap-3 text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-3">
                                <span>Admin</span> <span class="text-white/20">•</span>
                                <span>Berita</span> <span class="text-white/20">•</span>
                                <span>07 Feb 2023</span>
                            </div>
                            <p class="text-slate-500 text-sm leading-relaxed">STKIP Al Azhar Jambi melakukan Kegiatan Studi Banding ke Lembaga Perencanaan Pengembangan dan Penjaminan Mutu...</p>
                            <span class="inline-flex items-center gap-2 mt-4 text-blue-400 text-xs font-bold">Read more ... <i class="fas fa-arrow-right text-[9px]"></i></span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- SIDEBAR (1/3) -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 p-6">
                    <form action="{{ route('artikel.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ..." class="w-full bg-slate-700/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Sering Dibaca -->
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 p-6">
                    <h4 class="text-white font-bold text-lg mb-6 pb-4 border-b border-white/10">Sering Dibaca</h4>
                    <div class="space-y-4">
                        <a href="{{ route('kuesioner.dosen') }}" class="block text-slate-400 hover:text-blue-400 transition text-sm pb-4 border-b border-white/5">Kuesioner Mahasiswa</a>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-slate-400 hover:text-blue-400 transition text-sm pb-4 border-b border-white/5">Visi Dan Misi</a>
                        <a href="{{ route('artikel.kategori', 'berita') }}" class="block text-slate-400 hover:text-blue-400 transition text-sm pb-4 border-b border-white/5">PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding ke LP3M Politeknik Jambi</a>
                        <a href="https://e-spmi.politeknikjambi.ac.id" target="_blank" class="block text-slate-400 hover:text-blue-400 transition text-sm pb-4 border-b border-white/5">e-spmiPoljam</a>
                        <a href="{{ route('spmi.show', 'rtm') }}" class="block text-slate-400 hover:text-blue-400 transition text-sm">RTM</a>
                    </div>
                </div>

                <!-- Login Pengguna -->
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 p-6">
                    <h4 class="text-white font-bold text-lg mb-6 pb-4 border-b border-white/10">Login Pengguna</h4>
                    <div class="space-y-4">
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="text" placeholder="Username" class="w-full bg-slate-700/50 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="password" placeholder="Password" class="w-full bg-slate-700/50 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <label class="flex items-center gap-2 text-slate-500 text-xs">
                            <input type="checkbox" class="rounded border-white/20 bg-slate-700/50"> Remember Me
                        </label>
                        <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white text-center py-3 rounded-xl font-bold text-sm hover:bg-blue-700 transition">Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KONTAK SECTION -->
<section class="py-24 bg-slate-950 relative overflow-hidden">
    <div class="relative z-10 w-full px-6 lg:px-16">
        <div class="text-center mb-16">
            <span class="text-blue-400 font-black tracking-[0.4em] text-[10px] uppercase block mb-4">Get in Touch</span>
            <h2 class="font-serif-luxury text-5xl text-white">Hubungi <span class="text-blue-400 italic">Kami</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="p-8 bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 text-center">
                <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6"><i class="fas fa-map-marker-alt text-blue-400 text-xl"></i></div>
                <h4 class="text-white font-bold mb-2">Alamat</h4>
                <p class="text-slate-500 text-sm">Jalan Lingkar Barat II, Lorong Veteran, Kelurahan Kenali Asam Atas, Kecamatan Kotabaru, Kota Jambi</p>
            </div>
            <div class="p-8 bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 text-center">
                <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6"><i class="fas fa-envelope text-blue-400 text-xl"></i></div>
                <h4 class="text-white font-bold mb-2">Email</h4>
                <p class="text-slate-500 text-sm">info@politeknikjambi.ac.id</p>
            </div>
            <div class="p-8 bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 text-center">
                <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6"><i class="fas fa-phone text-blue-400 text-xl"></i></div>
                <h4 class="text-white font-bold mb-2">Telepon</h4>
                <p class="text-slate-500 text-sm">+62 741 123 456</p>
            </div>
        </div>
    </div>
</section>


    <footer class="bg-slate-950 pt-32 pb-12 border-t border-white/5">
        <div class="container mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-20 mb-24">
                <div class="max-w-xs">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 mb-8 brightness-200 hover:brightness-100 transition-all cursor-pointer">
                    <p class="text-slate-500 text-sm font-light leading-relaxed mb-8">
                        Lembaga Penjamin Mutu Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi nasional.
                    </p>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-slate-500 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all cursor-pointer"><i class="fab fa-instagram"></i></div>
                        <div class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-slate-500 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all cursor-pointer"><i class="fab fa-facebook-f"></i></div>
                        <div class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-slate-500 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all cursor-pointer"><i class="fab fa-youtube"></i></div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-20 uppercase font-black text-[10px] tracking-[0.2em] text-slate-300">
                    <div class="space-y-6">
                        <div class="text-blue-400 mb-2">Tautan Utama</div>
                        <a href="#" class="block text-slate-500 hover:text-blue-400 hover:translate-x-2 transition">Dashboard</a>
                        <a href="{{ route('spmi.show', 'dokumen') }}" class="block text-slate-500 hover:text-blue-400 hover:translate-x-2 transition">Dokumen SPMI</a>
                        <a href="#" class="block text-slate-500 hover:text-blue-400 hover:translate-x-2 transition">Laporan AMI</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-blue-400 mb-2">Informasi</div>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-slate-500 hover:text-blue-400 hover:translate-x-2 transition">Visi & Misi</a>
                        <a href="{{ route('akreditasi.index') }}" class="block text-slate-500 hover:text-blue-400 hover:translate-x-2 transition">Akreditasi</a>
                        <a href="{{ route('gallery.index') }}" class="block text-slate-500 hover:text-blue-400 hover:translate-x-2 transition">Galeri</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-blue-400 mb-2">Kontak</div>
                        <span class="block lowercase font-medium text-slate-500">Jalan Lingkar Barat II, Lorong Veteran</span>
                        <span class="block lowercase font-medium text-slate-500">Kenali Asam Atas, Kotabaru</span>
                        <span class="block lowercase font-medium text-slate-500">Kota Jambi, Indonesia</span>
                    </div>
                </div>
            </div>
            <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between gap-8 items-center">
                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.3em]">© 2026 LPM Politeknik Jambi. All Rights Reserved.</span>
                <div class="flex gap-10 text-[9px] font-black uppercase tracking-widest text-slate-600">
                    <a href="#" class="hover:text-blue-400">Privacy Policy</a>
                    <a href="#" class="hover:text-blue-400">Terms of Service</a>
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
    </script>
</body>
</html>