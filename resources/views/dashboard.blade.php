<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPMI Executive Dashboard - Politeknik Jambi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            /* Ultra-Premium Light Mesh Background */
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(224, 242, 254, 0.6) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(209, 250, 229, 0.4) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(238, 242, 255, 0.6) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(254, 226, 226, 0.3) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .font-display { font-family: 'Space Grotesk', sans-serif; }
        
        /* Hidden Scrollbar but functional */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.2); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.4); }

        /* Floating Content Area */
        .app-container {
            height: 100vh;
            padding: 1rem;
            display: flex;
            gap: 1.5rem;
            box-sizing: border-box;
        }

        @media (min-width: 1024px) {
            .app-container { padding: 1.5rem; gap: 2rem; }
        }

        /* Glassmorphism Classes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.03), inset 0 1px 0 rgba(255, 255, 255, 1);
        }

        .dark-glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
        }

        /* Fluid Animations */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stagger-1 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards; opacity: 0; }
        .stagger-2 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards; opacity: 0; }
        .stagger-3 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards; opacity: 0; }
        .stagger-4 { animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.4s forwards; opacity: 0; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        .animate-float { animation: float 8s ease-in-out infinite; }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }
        .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }

        /* Sidebar Item Hover Effect */
        .sidebar-item { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; z-index: 1; }
        .sidebar-item::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: all 0.4s ease; z-index: -1;
        }
        .sidebar-item:hover::before { left: 100%; transition: all 0.6s ease; }
        .sidebar-item:hover { transform: translateX(4px); }

        .submenu-item { transition: all 0.3s ease; border-radius: 8px; color: #ffffff; font-weight: 500; }
        .submenu-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff !important;
            padding-left: 1rem;
        }

        /* Card Hover Effects */
        .stat-card { transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1); }
        .stat-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 30px 60px -15px rgba(59, 130, 246, 0.15); }
        .stat-card:hover .icon-wrapper { transform: scale(1.1) rotate(-5deg); }

    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <div class="app-container">
        
        <!-- SIDEBAR (FLOATING) -->
        <aside class="w-[280px] lg:w-[320px] bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 rounded-3xl flex-shrink-0 flex flex-col shadow-2xl relative z-40 hidden md:flex overflow-hidden border border-white/10">
            
            <!-- Abstract Sidebar Background Glows -->
            <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-blue-600/20 to-transparent pointer-events-none"></div>
            <div class="absolute -left-20 top-20 w-40 h-40 bg-blue-500/20 rounded-full blur-[50px] pointer-events-none"></div>

            <!-- Brand -->
            <div class="px-8 py-8 flex items-center space-x-4 border-b border-white/5 relative z-10">
                <div class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.3)] border border-blue-400/30 p-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 backdrop-blur-sm pointer-events-none"></div>
                    <img src="images/logo.png" alt="LPM" class="h-full w-full object-contain relative z-10 drop-shadow-md" onerror="this.src='https://ui-avatars.com/api/?name=PJ&background=transparent&color=fff&bold=true'">
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-tighter text-white leading-none font-display">SPMI POLJAM</h1>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </div>
                        <p class="text-[9px] font-bold text-blue-300 uppercase tracking-[0.2em]">Sistem Online</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-5 py-6 space-y-1 relative z-10">
                
                <!-- Main Dashboard Btn -->
                <a href="javascript:void(0)" onclick="showHome()" class="flex items-center justify-between py-4 px-5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-[0_10px_20px_rgba(59,130,246,0.2)] hover:shadow-[0_15px_30px_rgba(59,130,246,0.4)] transition-all duration-300 mb-8 border border-white/10 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-border-all text-lg opacity-90 group-hover:rotate-12 transition-transform"></i>
                        <span class="text-[13px] font-bold uppercase tracking-widest">Dashboard</span>
                    </div>
                    <div class="w-2 h-2 bg-white rounded-full opacity-50 group-hover:opacity-100 group-hover:scale-150 transition-all"></div>
                </a>

                <div class="text-[10px] font-black text-white uppercase tracking-[0.2em] px-4 mb-4 mt-4 opacity-90">Menu Utama</div>

                <!-- Modul Profil -->
                <div class="mb-1">
                    <button onclick="toggleMenu('menuProfil')" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-university text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Profil Kampus</span>
                        </div>
                        <i id="icon-menuProfil" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuProfil" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <a onclick="loadPage('Visi Dan Misi')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-bullseye opacity-40 text-[10px] w-3"></i> <span>Visi Dan Misi</span></a>
                        <a onclick="loadPage('Moto Dan Janji Layanan')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-handshake opacity-40 text-[10px] w-3"></i> <span>Moto Dan Janji Layanan</span></a>
                        <a onclick="loadPage('Kebijakan Mutu POLJAM')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-shield-alt opacity-40 text-[10px] w-3"></i> <span>Kebijakan Mutu POLJAM</span></a>
                        <a onclick="loadPage('Sasaran Mutu POLJAM')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-check-circle opacity-40 text-[10px] w-3"></i> <span>Sasaran Mutu POLJAM</span></a>
                        <a onclick="loadPage('Standar Mutu POLJAM')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-list-check opacity-40 text-[10px] w-3"></i> <span>Standar Mutu POLJAM</span></a>
                        <a onclick="loadPage('Sasaran Mutu LPM')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-tasks opacity-40 text-[10px] w-3"></i> <span>Sasaran Mutu LPM</span></a>
                        <a onclick="loadPage('Struktur Organisasi')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-sitemap opacity-40 text-[10px] w-3"></i> <span>Struktur Organisasi</span></a>
                        <a onclick="loadPage('Job Deskripsi')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-user-tag opacity-40 text-[10px] w-3"></i> <span>Job Deskripsi</span></a>
                        <a onclick="loadPage('Standar Waktu Pelayanan')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-clock opacity-40 text-[10px] w-3"></i> <span>Standar Waktu Pelayanan</span></a>
                    </div>
                </div>



                <!-- Modul Akreditasi -->
                <div class="mb-1">
                    <button onclick="toggleMenu('menuAkreditasi')" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-award text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Akreditasi</span>
                        </div>
                        <i id="icon-menuAkreditasi" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuAkreditasi" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <a onclick="loadPage('Akreditasi')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-graduation-cap opacity-40 text-[10px] w-3 text-center"></i> <span>Akreditasi</span></a>
                        <a onclick="loadPage('Dokumen Akreditasi')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-file-pdf opacity-40 text-[10px] w-3 text-center"></i> <span>Dokumen Akreditasi</span></a>
                    </div>
                </div>

                <!-- Modul Capaian -->
                <div class="mb-1">
                    <button onclick="toggleMenu('menuCapaian')" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-chart-line text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Capaian Kinerja</span>
                        </div>
                        <i id="icon-menuCapaian" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuCapaian" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <a onclick="loadPage('Dokumen SPMI')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-folder opacity-40 text-[10px] w-3 text-center"></i> <span>Dokumen SPMI</span></a>
                        <a onclick="loadPage('Renop')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-file-alt opacity-40 text-[10px] w-3"></i> <span>Renop</span></a>
                        <a onclick="loadRenstraPanel()" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-chart-bar opacity-40 text-[10px] w-3"></i> <span>Capaian Renstra</span></a>
                        <div class="mt-2 mb-2">
                            <button onclick="toggleMenu('subMenuKepuasan')" class="w-full flex items-center justify-between py-2.5 px-3 hover:text-white transition group/sub rounded-xl border border-transparent hover:border-white/20 bg-white/10 hover:bg-white/20 text-white">
                                <div class="flex items-center space-x-2.5">
                                    <i class="fas fa-user-graduate opacity-40 text-[10px]"></i>
                                    <span class="font-medium tracking-wide">Kepuasan Mahasiswa</span>
                                </div>
                                <i id="icon-subMenuKepuasan" class="fas fa-chevron-right text-[10px] transition-transform duration-300 opacity-40"></i>
                            </button>
                            <div id="subMenuKepuasan" class="hidden pl-4 mt-1 space-y-1 border-l border-blue-500/30 ml-2 py-1">
                                <a onclick="loadPage('Kepuasan Mahasiswa Poljam')" class="submenu-item block py-2 px-3 flex items-center space-x-2 cursor-pointer"><i class="fas fa-calendar-alt opacity-40 text-[9px] w-3"></i> <span>T.A 2020/2021 (Poljam)</span></a>
                                <a onclick="loadPage('Kepuasan Mahasiswa Prodi')" class="submenu-item block py-2 px-3 flex items-center space-x-2 cursor-pointer"><i class="fas fa-calendar-check opacity-40 text-[9px] w-3"></i> <span>T.A 2020/2021 (Prodi)</span></a>
                            </div>
                        </div>
                        <a onclick="loadPage('Kepuasan Dosen & Tendik')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-chalkboard-teacher opacity-40 text-[10px] w-3"></i> <span>Kepuasan Dosen & Tendik</span></a>
                    </div>
                </div>

                <div class="text-[10px] font-black text-white uppercase tracking-[0.2em] px-4 mb-4 mt-6 opacity-90">Publikasi & Survei</div>

                <!-- Modul Kuesioner -->
                <div class="mb-1">
                    <button onclick="toggleMenu('menuKuesioner')" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-clipboard-question text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Kuesioner</span>
                        </div>
                        <i id="icon-menuKuesioner" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuKuesioner" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <a onclick="loadPage('Kuesioner Dosen & Karyawan')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-user-tie opacity-40 text-[10px] w-3 text-center"></i> <span>Kuesioner Dosen & Karyawan</span></a>
                        <a onclick="loadPage('Kuisioner Mahasiswa')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-user-edit opacity-40 text-[10px] w-3 text-center"></i> <span>Kuisioner Mahasiswa</span></a>
                    </div>
                </div>

                <!-- Modul Portal Berita -->
                <div class="mb-1">
                    <button onclick="toggleMenu('menuBerita')" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-bullhorn text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Portal Berita</span>
                        </div>
                        <i id="icon-menuBerita" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuBerita" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <a onclick="loadPage('Daftar Berita')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-list opacity-40 text-[10px] w-3"></i> <span>Daftar Berita</span></a>
                        <a onclick="loadPage('Tambah Berita')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-plus-circle opacity-40 text-[10px] w-3"></i> <span>Tulis Berita Baru</span></a>
                        <a onclick="loadPage('Kategori Berita')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-tags opacity-40 text-[10px] w-3"></i> <span>Kategori Berita</span></a>
                    </div>
                </div>

                <!-- Modul Galeri -->
                <div class="mb-1">
                    <button onclick="toggleMenu('menuGaleri')" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-images text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Galeri Kampus</span>
                        </div>
                        <i id="icon-menuGaleri" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuGaleri" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <a onclick="loadGaleriFotoPanel()" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-image opacity-40 text-[10px] w-3"></i> <span>Dokumentasi Foto</span></a>
                        <a onclick="loadGaleriVideoPanel()" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-video opacity-40 text-[10px] w-3"></i> <span>Galeri Video</span></a>
                    </div>
                </div>

                <!-- Artikel Ilmiah -->
                <a onclick="loadPage('Artikel Ilmiah')" class="sidebar-item flex items-center space-x-4 py-3.5 px-4 rounded-2xl text-white font-bold group mt-1 hover:bg-white/10 cursor-pointer">
                    <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                        <i class="fas fa-newspaper text-sm"></i>
                    </div>
                    <span class="text-[13px] font-semibold tracking-wide">Artikel Ilmiah</span>
                </a>

            </nav>

            <!-- User Profile Bottom -->
            <div id="userProfileArea" class="p-6 mt-auto border-t border-white/5 bg-slate-900/50 backdrop-blur-md relative z-20">
                <div onclick="toggleProfileDropdown()" class="flex items-center gap-4 bg-white/5 p-3 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors cursor-pointer group">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff&bold=true" class="w-10 h-10 rounded-xl shadow-lg" alt="Admin">
                    <div class="flex-1">
                        <h2 class="text-sm font-bold text-white leading-tight">Super Admin</h2>
                        <p class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">Politeknik Jambi</p>
                    </div>
                    <i class="fas fa-ellipsis-v text-slate-500 group-hover:text-white transition-colors p-2"></i>
                </div>
                
                <!-- Profile Dropdown -->
                <div id="profileDropdown" class="hidden absolute bottom-[90px] left-6 right-6 bg-slate-800 border border-white/10 rounded-2xl p-2 shadow-2xl animate-fade-in origin-bottom">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                        <i class="fas fa-user-circle w-4"></i> Profil Saya
                    </a>
                    <a href="#" onclick="loadPage('Pengaturan Sistem'); document.getElementById('profileDropdown').classList.add('hidden'); event.preventDefault();" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                        <i class="fas fa-cog w-4"></i> Pengaturan
                    </a>
                    <div class="h-px bg-white/10 my-1 mx-2"></div>
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-xl transition-colors">
                        <i class="fas fa-sign-out-alt w-4"></i> Logout
                    </a>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 glass-panel rounded-3xl flex flex-col overflow-hidden relative shadow-[0_0_50px_rgba(0,0,0,0.05)] border border-white/60">
            
            <!-- HEADER FLOATING -->
            <header class="px-8 py-6 flex justify-between items-center border-b border-blue-500/30 bg-blue-600 shadow-md z-30 sticky top-0 relative overflow-hidden">
                <!-- Header Background Glow -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-blue-600 pointer-events-none"></div>
                <div class="absolute top-0 right-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="flex items-center gap-4 relative z-10">
                    <!-- Mobile Menu Toggle -->
                    <button class="md:hidden w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white shadow-sm hover:bg-white/20 transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tight font-display drop-shadow-sm">Overview</h2>
                        <p class="text-xs font-bold text-blue-200 uppercase tracking-widest mt-0.5">Control Panel Mutu</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 relative z-10">
                    <!-- Notification -->
                    <button class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-blue-200 hover:text-white border border-white/20 transition-all shadow-sm relative group backdrop-blur-md">
                        <i class="fas fa-bell group-hover:animate-swing"></i>
                        <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-blue-700"></span>
                    </button>

                    <!-- Date/Clock Panel -->
                    <div class="hidden lg:flex items-center bg-white/10 text-white rounded-2xl px-5 py-2.5 shadow-sm border border-white/20 backdrop-blur-md">
                        <i class="far fa-clock text-blue-200 mr-3 text-lg"></i>
                        <div class="flex flex-col">
                            <span id="date-display" class="text-[10px] uppercase font-bold text-blue-200 tracking-widest leading-none mb-1">Senin, 18 Mei 2026</span>
                            <span id="clock" class="text-sm font-black tracking-widest leading-none font-display text-white">00:00:00</span>
                        </div>
                    </div>

                    <!-- Sync Excel Button -->
                    <button onclick="showToast('Fitur Sinkronisasi Excel sedang dikembangkan.', 'info')" class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-2xl font-bold text-sm shadow-lg shadow-emerald-500/20 transition-all hover:-translate-y-0.5 backdrop-blur-md">
                        <i class="fas fa-file-excel"></i>
                        <span>Import Excel</span>
                    </button>
                </div>
            </header>

            <!-- DYNAMIC CONTENT SCROLL AREA -->
            <div id="dynamic-content" class="flex-1 overflow-y-auto p-6 lg:p-10 relative scroll-smooth">
                
                <div class="max-w-7xl mx-auto">
                    
                    <!-- HERO SECTION - ULTRA PREMIUM -->
                    <div class="stagger-1 relative overflow-hidden rounded-[2.5rem] bg-[#0A0F1C] text-white shadow-[0_20px_60px_rgba(10,15,28,0.4)] mb-12 border border-slate-700/50 flex flex-col md:flex-row items-center justify-between group">
                        
                        <!-- Hero Background Effects -->
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-50"></div>
                        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/30 rounded-full blur-[80px] animate-pulse-glow"></div>
                        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-[80px] animate-pulse-glow" style="animation-delay: 2s;"></div>
                        
                        <div class="relative z-10 p-12 lg:p-16 max-w-3xl">
                            <div class="inline-flex items-center gap-2.5 bg-white/5 border border-white/10 px-4 py-2 rounded-xl text-blue-200 text-[11px] font-bold uppercase tracking-[0.2em] mb-8 backdrop-blur-md">
                                <i class="fas fa-shield-check text-emerald-400"></i> Sistem Penjaminan Mutu Internal
                            </div>
                            <h2 class="text-5xl lg:text-6xl font-black text-white leading-[1.1] tracking-tighter font-display mb-6">
                                Standardisasi Mutu <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-emerald-300">Pendidikan Tinggi.</span>
                            </h2>
                            <p class="text-slate-400 text-lg leading-relaxed font-medium mb-10 max-w-2xl">
                                Platform terintegrasi untuk mengelola dokumen akreditasi, memonitor capaian renstra, dan memastikan kualitas pendidikan di <span class="text-white font-bold">Politeknik Jambi</span> secara real-time.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <button class="bg-white text-slate-900 px-8 py-4 rounded-2xl font-black text-sm tracking-wide shadow-[0_0_30px_rgba(255,255,255,0.2)] hover:shadow-[0_0_40px_rgba(255,255,255,0.4)] transition-all hover:-translate-y-1 group/btn">
                                    Lihat Laporan Mutu <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                                </button>
                                <button class="bg-white/5 hover:bg-white/10 text-white border border-white/10 px-8 py-4 rounded-2xl font-bold text-sm tracking-wide backdrop-blur-md transition-all">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Dokumen
                                </button>
                            </div>
                        </div>

                        <!-- Hero Graphic Illustration (Pure CSS) -->
                        <div class="hidden lg:flex relative items-center justify-center w-[400px] h-[400px] mr-10 relative z-10">
                            <!-- Abstract glowing rings -->
                            <div class="absolute w-[300px] h-[300px] border border-blue-500/30 rounded-full animate-[spin_20s_linear_infinite]"></div>
                            <div class="absolute w-[220px] h-[220px] border border-emerald-500/30 rounded-full animate-[spin_15s_linear_infinite_reverse]"></div>
                            
                            <!-- Floating Data Cards -->
                            <div class="absolute -left-10 top-20 bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl animate-float shadow-2xl" style="animation-delay: 0s;">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400"><i class="fas fa-check"></i></div>
                                    <div>
                                        <div class="text-xs text-slate-300 font-bold uppercase tracking-wider mb-1">Akreditasi</div>
                                        <div class="text-white font-black font-display">Unggul (A)</div>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute -right-5 bottom-32 bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl animate-float shadow-2xl" style="animation-delay: 1.5s;">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400"><i class="fas fa-chart-bar"></i></div>
                                    <div>
                                        <div class="text-xs text-slate-300 font-bold uppercase tracking-wider mb-1">Capaian IKU</div>
                                        <div class="text-white font-black font-display">94.8%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Core Globe/Center -->
                            <div class="w-32 h-32 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-[0_0_50px_rgba(59,130,246,0.5)] flex items-center justify-center border border-white/20 relative overflow-hidden">
                                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC41KSIvPjwvc3ZnPg==')] opacity-30"></div>
                                <i class="fas fa-fingerprint text-5xl text-white drop-shadow-md"></i>
                            </div>
                        </div>

                    </div>

                    <!-- HOLO STATS CARDS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-12">
                        
                        <!-- STAT 1 -->
                        <div class="stagger-2 stat-card bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white shadow-[0_10px_40px_rgba(0,0,0,0.03)] relative overflow-hidden flex flex-col justify-between h-48">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-400/10 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="flex justify-between items-start relative z-10">
                                <div class="icon-wrapper w-14 h-14 rounded-[1.2rem] bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-inner border border-blue-100 transition-transform duration-300">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <div class="bg-emerald-50 text-emerald-600 text-[10px] font-black tracking-widest px-3 py-1.5 rounded-xl border border-emerald-100 shadow-sm">
                                    +12% BULAN INI
                                </div>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-4xl font-black text-slate-800 tracking-tighter font-display">{{ number_format($totalMutuDocs ?? 1248) }}</h3>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Total Dokumen Mutu</p>
                            </div>
                        </div>

                        <!-- STAT 2 -->
                        <div class="stagger-3 stat-card bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white shadow-[0_10px_40px_rgba(0,0,0,0.03)] relative overflow-hidden flex flex-col justify-between h-48">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-400/10 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="flex justify-between items-start relative z-10">
                                <div class="icon-wrapper w-14 h-14 rounded-[1.2rem] bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shadow-inner border border-indigo-100 transition-transform duration-300">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="bg-blue-50 text-blue-600 text-[10px] font-black tracking-widest px-3 py-1.5 rounded-xl border border-blue-100 shadow-sm">
                                    TERCAPAI
                                </div>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-4xl font-black text-slate-800 tracking-tighter font-display">{{ $avgIku ?? 94.5 }}<span class="text-2xl text-slate-400">%</span></h3>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Capaian IKU Institusi</p>
                            </div>
                        </div>

                        <!-- STAT 3 -->
                        <div class="stagger-4 stat-card bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 border border-white shadow-[0_10px_40px_rgba(0,0,0,0.03)] relative overflow-hidden flex flex-col justify-between h-48">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="flex justify-between items-start relative z-10">
                                <div class="icon-wrapper w-14 h-14 rounded-[1.2rem] bg-amber-50 text-amber-500 flex items-center justify-center text-2xl shadow-inner border border-amber-100 transition-transform duration-300">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-4xl font-black text-slate-800 tracking-tighter font-display">{{ $totalProdi ?? 8 }} Prodi</h3>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Status Akreditasi</p>
                            </div>
                        </div>

                        <!-- STAT 4 -->
                        <div class="stagger-4 stat-card bg-[#0f172a] text-white rounded-[2rem] p-8 border border-slate-700 shadow-[0_20px_40px_rgba(15,23,42,0.3)] relative overflow-hidden flex flex-col justify-between h-48 group/dark">
                            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/30 rounded-full blur-3xl pointer-events-none group-hover/dark:bg-blue-400/40 transition-colors"></div>
                            <div class="flex justify-between items-start relative z-10">
                                <div class="icon-wrapper w-14 h-14 rounded-[1.2rem] bg-white/10 text-white flex items-center justify-center text-2xl shadow-inner border border-white/10 transition-transform duration-300 backdrop-blur-md">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span></span>
                                    <span class="text-[9px] font-bold tracking-widest uppercase text-slate-300">Online</span>
                                </div>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-4xl font-black text-white tracking-tighter font-display">{{ number_format($totalResponden ?? 3673) }}</h3>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Responden Kuesioner</p>
                            </div>
                        </div>

                    </div>

                    <!-- DATA TABLE SECTION -->
                    <div class="stagger-4 bg-white/80 backdrop-blur-2xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_50px_rgba(0,0,0,0.04)]">
                        <div class="px-10 py-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-transparent to-slate-50/50">
                            <div>
                                <h2 class="text-2xl font-black text-slate-800 tracking-tight font-display">Log Aktivitas Mutu</h2>
                                <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-widest">Tracking perubahan dokumen secara real-time</p>
                            </div>
                            <div class="flex gap-3">
                                <button class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 border border-slate-200 flex items-center justify-center hover:bg-slate-100 transition-colors"><i class="fas fa-filter"></i></button>
                                <button class="bg-slate-900 text-white px-6 py-3 rounded-xl text-xs font-bold shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition-all flex items-center gap-2 hover:-translate-y-0.5">
                                    <span>Lihat Semua</span> <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 w-24">ID</th>
                                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Keterangan Aktivitas</th>
                                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 w-48">Status</th>
                                        <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 w-48 text-right">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-10 py-6 font-black text-blue-600 font-display">#1042</td>
                                        <td class="px-10 py-6">
                                            <p class="font-bold text-slate-800">Upload Dokumen Borang Akreditasi Prodi TI</p>
                                            <p class="text-[11px] font-semibold text-slate-400 mt-1 uppercase tracking-wider">Oleh: Dr. Administrator</p>
                                        </td>
                                        <td class="px-10 py-6">
                                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                                <i class="fas fa-check-circle text-emerald-500"></i> Terverifikasi
                                            </span>
                                        </td>
                                        <td class="px-10 py-6 text-[12px] font-bold text-slate-400 text-right uppercase tracking-widest">
                                            10 Menit Lalu
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-10 py-6 font-black text-blue-600 font-display">#1041</td>
                                        <td class="px-10 py-6">
                                            <p class="font-bold text-slate-800">Pembaruan Nilai IKU Tahun 2026</p>
                                            <p class="text-[11px] font-semibold text-slate-400 mt-1 uppercase tracking-wider">Oleh: Sistem Otomatis</p>
                                        </td>
                                        <td class="px-10 py-6">
                                            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-100">
                                                <i class="fas fa-sync-alt text-blue-500"></i> Diperbarui
                                            </span>
                                        </td>
                                        <td class="px-10 py-6 text-[12px] font-bold text-slate-400 text-right uppercase tracking-widest">
                                            1 Jam Lalu
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="mt-8 bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 lg:p-10 border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] relative overflow-hidden group">
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-colors duration-1000"></div>
                        <div class="flex justify-between items-end mb-8 relative z-10">
                            <div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 border-b border-slate-100 pb-2 inline-block">Analitik SPMI</h3>
                                <h4 class="text-2xl font-black text-slate-800 font-display">Tren Capaian Mutu Tahunan</h4>
                            </div>
                            <div class="flex gap-2">
                                <span class="flex items-center gap-2 text-xs font-bold text-slate-500"><div class="w-3 h-3 rounded-full bg-blue-500"></div> Target (IKU)</span>
                                <span class="flex items-center gap-2 text-xs font-bold text-slate-500 ml-4"><div class="w-3 h-3 rounded-full bg-emerald-500"></div> Realisasi</span>
                            </div>
                        </div>
                        <div class="relative w-full h-[350px] z-10">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>
            
        </main>
    </div>

    <!-- UNIVERSAL MODALS FOR CRUD -->
    <div id="modalOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-all opacity-0 pointer-events-none" style="transition: opacity 0.3s ease;">
        
        <!-- EDIT MODAL -->
        <div id="modalEdit" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-transform duration-300 hidden flex-col">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-2xl font-display tracking-tight mb-1">Edit Konfigurasi</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Modifikasi Parameter Sistem</p>
                </div>
                <button onclick="closeModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-10">
                <div id="edit-fields-container" class="space-y-4"></div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                    <button onclick="saveData()" class="px-8 py-4 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(59,130,246,0.3)] hover:bg-blue-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Simpan Perubahan</button>
                </div>
            </div>
        </div>

        <!-- TAMBAH MODAL -->
        <div id="modalTambah" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-transform duration-300 hidden flex-col">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-2xl font-display tracking-tight mb-1">Tambah Data Baru</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Registrasi Parameter Sistem</p>
                </div>
                <button onclick="closeModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-10">
                <div id="add-fields-container" class="space-y-4"></div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                    <button onclick="addNewData()" class="px-8 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.3)] hover:bg-emerald-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Tambahkan Data</button>
                </div>
            </div>
        </div>

    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none"></div>



    <!-- SCRIPTS -->
    <script>
        let currentTitle = ""; 
        let defaultDashboardContent = "";

        document.addEventListener('DOMContentLoaded', () => {
            defaultDashboardContent = document.getElementById('dynamic-content').innerHTML;
            renderChart();
        });

        // Chart.js Logic
        let myChart = null;
        function renderChart() {
            const ctx = document.getElementById('mainChart');
            if(!ctx) return;
            
            if(myChart) myChart.destroy();

            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [
                        {
                            label: 'Realisasi Capaian',
                            data: [65, 70, 75, 72, 80, 85, 82, 88, 92, 90, 95, 98],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Target IKU',
                            data: [60, 65, 70, 75, 80, 85, 85, 90, 90, 95, 95, 100],
                            borderColor: '#3b82f6',
                            borderDash: [5, 5],
                            borderWidth: 3,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { family: 'Inter', size: 13 },
                            bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                            padding: 12,
                            cornerRadius: 12,
                            displayColors: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                            ticks: { font: { family: 'Inter', size: 11, weight: 'bold' }, color: '#94a3b8' }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: 'Inter', size: 11, weight: 'bold' }, color: '#94a3b8' }
                        }
                    },
                    interaction: { mode: 'index', intersect: false },
                    animation: { duration: 2000, easing: 'easeOutQuart' }
                }
            });
        }



        // Toast Notification Logic
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            toast.className = 'flex items-center gap-4 px-6 py-4 rounded-2xl shadow-[0_15px_40px_rgba(0,0,0,0.1)] border bg-white/90 backdrop-blur-xl transform transition-all duration-500 translate-y-10 opacity-0 pointer-events-auto';
            
            const icon = type === 'success' ? '<div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg"><i class="fas fa-check"></i></div>' : 
                                              '<div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-lg"><i class="fas fa-exclamation"></i></div>';
            
            toast.classList.add(type === 'success' ? 'border-emerald-100' : 'border-rose-100');

            toast.innerHTML = `
                ${icon}
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-slate-800">${type === 'success' ? 'Berhasil' : 'Peringatan'}</h4>
                    <p class="text-xs font-medium text-slate-500">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-2 w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button>
            `;

            container.appendChild(toast);

            // Animate In
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            });

            // Auto Remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // Profile Dropdown Logic
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileArea = document.getElementById('userProfileArea');
            const dropdown = document.getElementById('profileDropdown');
            if (profileArea && !profileArea.contains(event.target) && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });

        // Clock & Date Logic
        function updateClock() {
            const now = new Date();
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', timeOptions);
            document.getElementById('date-display').innerText = now.toLocaleDateString('id-ID', dateOptions);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Menu Toggle
        function toggleMenu(id) {
            const menu = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (menu.classList.contains('hidden')) {
                // Hanya tutup menu lain jika yang diklik adalah menu utama (berawalan 'menu')
                if (id.startsWith('menu')) {
                    document.querySelectorAll('[id^="menu"]').forEach(m => {
                        if(m.id !== id && !m.classList.contains('hidden') && m.id !== 'modalOverlay' && m.id !== 'modalEdit' && m.id !== 'modalTambah') {
                            m.classList.add('hidden');
                            const otherIcon = document.getElementById('icon-' + m.id);
                            if(otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                        }
                    });
                }

                menu.classList.remove('hidden');
                menu.classList.add('animate-fade-in');
                if (icon) icon.style.transform = 'rotate(90deg)';
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('animate-fade-in');
                if (icon) icon.style.transform = 'rotate(0deg)';
            }
        }

        function showHome() {
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;
            setTimeout(() => {
                content.innerHTML = defaultDashboardContent;
                content.style.opacity = 1;
                setTimeout(() => renderChart(), 50); // Small delay to ensure DOM is ready
            }, 300);
        }

        // Module Pages & Live AJAX Client
        let loadedFields = [];
        let currentEditId = null;
        let retrievedData = [];

        function loadPage(title) {
            // Modul Galeri khusus
            if (title === 'Dokumentasi Foto') {
                loadGaleriFotoPanel();
                return;
            }
            if (title === 'Galeri Video') {
                loadGaleriVideoPanel();
                return;
            }

            currentTitle = title;
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;
            
            setTimeout(() => {

                // ============================================================
                // DOKUMEN SPMI — Panel Upload Khusus
                // ============================================================
                if (title === 'Dokumen SPMI') {
                    loadDokumenSpmiPanel();
                    content.style.opacity = 1;
                    return;
                }

                if (title === 'Pengaturan Sistem') {
                    content.innerHTML = `
                    <div class="max-w-5xl mx-auto pb-12">
                        <!-- Header -->
                        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 relative overflow-hidden flex justify-between items-center">
                            <div class="relative z-10">
                                <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display mb-2">Pengaturan Sistem</h2>
                                <p class="text-slate-500 font-medium">Konfigurasi profil admin, identitas kampus, dan keamanan akun.</p>
                            </div>
                            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-2xl shadow-inner border border-blue-100 relative z-10">
                                <i class="fas fa-cog animate-[spin_10s_linear_infinite]"></i>
                            </div>
                            <div class="absolute -right-10 -top-10 text-[200px] text-slate-100 opacity-50 pointer-events-none transform -rotate-12">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Card 1: Profil Admin -->
                            <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] flex flex-col items-center text-center">
                                <h3 class="w-full text-left text-[11px] font-black text-slate-400 mb-6 uppercase tracking-[0.2em] border-b border-slate-100 pb-4">Profil Administrator</h3>
                                <div class="relative mb-6 group cursor-pointer">
                                    <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff&bold=true&size=150" class="w-32 h-32 rounded-full shadow-xl border-4 border-white transition-transform group-hover:scale-105" alt="Admin">
                                    <div class="absolute inset-0 bg-slate-900/50 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <i class="fas fa-camera text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="w-full space-y-4 text-left">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Nama Lengkap</label>
                                        <input type="text" value="Super Admin" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Email Utama</label>
                                        <input type="email" value="admin@politeknikjambi.ac.id" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-2 space-y-8">
                                <!-- Card 2: Identitas Kampus -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)]">
                                    <h3 class="text-[11px] font-black text-slate-400 mb-6 uppercase tracking-[0.2em] border-b border-slate-100 pb-4">Identitas & Kontak Lembaga</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Nama Lembaga / Sistem</label>
                                            <input type="text" value="LP3M Politeknik Jambi" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Nomor Telepon Resmi</label>
                                            <input type="text" value="0852-7351-8763" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Email Resmi</label>
                                            <input type="email" value="info@politeknikjambi.ac.id" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-8 flex justify-end gap-4">
                            <button onclick="showHome()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase shadow-sm">Kembali</button>
                        </div>
                    </div>
                    `;
                    content.style.opacity = 1;
                    return;
                }

                // Ambil data real-time via API
                fetch(`/admin/page-data?title=${encodeURIComponent(title)}`)
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) {
                            showToast(res.message, 'warning');
                            showHome();
                            return;
                        }

                        loadedFields = res.fields;

                        if (res.type === 'single') {
                            content.innerHTML = `
                            <div class="max-w-5xl mx-auto pb-12">
                                <!-- Page Header -->
                                <div class="bg-white/80 backdrop-blur-xl p-10 lg:p-12 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 relative overflow-hidden">
                                    <div class="absolute -right-10 -top-10 text-[200px] text-slate-100 opacity-50 pointer-events-none transform -rotate-12">
                                        <i class="fas fa-pen-nib"></i>
                                    </div>
                                    <div class="relative z-10">
                                        <div class="flex items-center gap-3 mb-4">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Konten Tunggal</p>
                                        </div>
                                        <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none mb-4">${title}</h2>
                                        <p class="text-slate-500 font-medium">Perbarui deskripsi ${title} secara langsung. Perubahan akan langsung disimpan secara permanen di database dan tayang di front-end.</p>
                                    </div>
                                </div>

                                <!-- Form Area -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10">
                                    <label class="block text-[11px] font-black text-slate-400 mb-4 uppercase tracking-[0.2em]">Editor ${title}</label>
                                    
                                    <!-- Editor Toolbar Mockup -->
                                    <div class="flex flex-wrap gap-2 mb-4 p-2 bg-slate-50 border border-slate-100 rounded-2xl w-fit">
                                        <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Bold"><i class="fas fa-bold"></i></button>
                                        <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Italic"><i class="fas fa-italic"></i></button>
                                        <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Underline"><i class="fas fa-underline"></i></button>
                                        <div class="w-px h-6 bg-slate-200 my-auto mx-2"></div>
                                        <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                        <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Number List"><i class="fas fa-list-ol"></i></button>
                                    </div>

                                    <textarea id="single-editor-textarea" rows="12" class="w-full p-6 border border-slate-200 rounded-3xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-medium text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all resize-y shadow-inner leading-relaxed" placeholder="Ketik konten ${title} di sini...">${res.data.isi_konten || ''}</textarea>
                                    
                                    <div class="mt-10 flex justify-end gap-4 border-t border-slate-100 pt-8">
                                        <button onclick="showHome()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase shadow-sm">Batal</button>
                                        <button onclick="saveSingleContent()" class="px-8 py-4 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.3)] hover:bg-blue-700 transition-all hover:-translate-y-1 tracking-widest uppercase flex items-center gap-3">
                                            <i class="fas fa-save text-sm"></i>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            `;
                        } else {
                            // Tipe Tabel / List
                            retrievedData = res.data;

                            // Bangun headers
                            let headersHtml = `<th class="px-10 py-6 border-b border-slate-100 w-24 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">UID</th>`;
                            res.fields.forEach(field => {
                                const label = field.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                                headersHtml += `<th class="px-10 py-6 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">${label}</th>`;
                            });
                            headersHtml += `<th class="px-10 py-6 border-b border-slate-100 text-right w-48 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Manajemen</th>`;

                            // Bangun rows
                            let rowsHtml = "";
                            if (res.data.length === 0) {
                                rowsHtml = `<tr><td colspan="${res.fields.length + 2}" class="px-10 py-12 text-center font-bold text-slate-400">Belum ada data entri di database untuk modul ini.</td></tr>`;
                            } else {
                                res.data.forEach((item, index) => {
                                    const paddedIndex = String(index + 1).padStart(3, '0');
                                    let cellsHtml = `<td class="px-10 py-8 font-black text-slate-400 text-center font-display">${paddedIndex}</td>`;
                                    
                                    res.fields.forEach(field => {
                                        let displayVal = item[field] || "";
                                        // strip HTML tags just in case
                                        if (typeof displayVal === 'string' && displayVal.includes('<')) {
                                            const temp = document.createElement("div");
                                            temp.innerHTML = displayVal;
                                            displayVal = temp.textContent || temp.innerText || "";
                                        }
                                        // truncate if too long
                                        if (displayVal.length > 80) {
                                            displayVal = displayVal.slice(0, 80) + '...';
                                        }
                                        cellsHtml += `<td class="px-10 py-8 leading-relaxed font-semibold text-slate-700 text-sm">${displayVal}</td>`;
                                    });

                                    cellsHtml += `
                                    <td class="px-10 py-8">
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="openModalEdit(${item.id})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Edit"><i class="fas fa-pen text-sm"></i></button>
                                            <button onclick="confirmDelete(${item.id}, this)" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Hapus"><i class="fas fa-trash text-sm"></i></button>
                                        </div>
                                    </td>
                                    `;
                                    rowsHtml += `<tr class="hover:bg-slate-50/50 transition-colors group">${cellsHtml}</tr>`;
                                });
                            }

                            content.innerHTML = `
                            <div class="max-w-7xl mx-auto pb-12">
                                <!-- Page Header -->
                                <div class="bg-white/80 backdrop-blur-xl p-10 lg:p-12 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
                                    <div class="absolute -right-20 -top-20 text-[200px] text-slate-100 opacity-50 pointer-events-none transform -rotate-12">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div class="relative z-10">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Modul Aktif</p>
                                        </div>
                                        <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">${title}</h2>
                                    </div>
                                    <button onclick="openTambah()" class="relative z-10 bg-slate-900 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(15,23,42,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.3)] hover:bg-slate-800">
                                        <i class="fas fa-plus"></i>
                                        <span class="tracking-widest uppercase">Tambah Entri</span>
                                    </button>
                                </div>

                                <!-- Table Area -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)]">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead class="bg-slate-50/50">
                                                <tr>
                                                    ${headersHtml}
                                                </tr>
                                            </thead>
                                            <tbody id="table-body" class="divide-y divide-slate-50">
                                                ${rowsHtml}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            `;
                        }
                        content.style.opacity = 1;
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Gagal memuat data dari server.', 'warning');
                        showHome();
                    });
            }, 300);
        }

        // Simpan Halaman Editor Tunggal (Visi Misi, dll)
        function saveSingleContent() {
            const val = document.getElementById('single-editor-textarea').value;
            fetch('/admin/save-page-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    title: currentTitle,
                    isi_konten: val
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    loadPage(currentTitle);
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                showToast('Gagal memproses pembaruan data.', 'warning');
            });
        }

        // Modal Logic
        function showOverlay() {
            const overlay = document.getElementById('modalOverlay');
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
            }, 10);
        }

        function hideOverlay() {
            const overlay = document.getElementById('modalOverlay');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                overlay.classList.add('hidden');
                document.getElementById('modalEdit').classList.add('hidden');
                document.getElementById('modalTambah').classList.add('hidden');
            }, 300);
        }

        function closeModal() {
            document.getElementById('modalEdit').classList.add('scale-95');
            document.getElementById('modalTambah').classList.add('scale-95');
            hideOverlay();
        }

        function openModalEdit(id) {
            currentEditId = id;
            const record = retrievedData.find(item => item.id == id);
            if (!record) return;

            // Generate form fields dynamically
            generateFormFields('edit-fields-container', loadedFields, record);

            showOverlay();
            const modal = document.getElementById('modalEdit');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
        }

        function openTambah() {
            // Generate form fields dynamically (empty)
            generateFormFields('add-fields-container', loadedFields, {});

            showOverlay();
            const modal = document.getElementById('modalTambah');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
        }

        function generateFormFields(containerId, fields, values = {}) {
            const container = document.getElementById(containerId);
            container.innerHTML = "";
            fields.forEach(field => {
                const labelText = field.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                const val = values[field] || "";
                const isTextArea = ['isi_konten', 'deskripsi', 'konten'].includes(field);
                
                let inputHtml = "";
                if (isTextArea) {
                    inputHtml = `<textarea id="field-${containerId}-${field}" rows="5" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner leading-relaxed">${val}</textarea>`;
                } else {
                    inputHtml = `<input type="text" id="field-${containerId}-${field}" value="${val}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">`;
                }
                
                container.innerHTML += `
                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-slate-400 mb-2 uppercase tracking-[0.2em]">${labelText}</label>
                        ${inputHtml}
                    </div>
                `;
            });
        }

        function saveData() {
            const payload = {
                title: currentTitle,
                id: currentEditId
            };

            loadedFields.forEach(field => {
                payload[field] = document.getElementById(`field-edit-fields-container-${field}`).value;
            });

            fetch('/admin/save-page-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    closeModal();
                    loadPage(currentTitle);
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                showToast('Gagal memperbarui data.', 'warning');
            });
        }

        function addNewData() {
            const payload = {
                title: currentTitle
            };

            let hasEmpty = false;
            loadedFields.forEach(field => {
                const el = document.getElementById(`field-add-fields-container-${field}`);
                if (el.value.trim() === "") {
                    hasEmpty = true;
                }
                payload[field] = el.value;
            });

            if (hasEmpty) {
                alert("Validasi Gagal: Semua kolom isian harus diisi.");
                return;
            }

            fetch('/admin/add-row', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    closeModal();
                    loadPage(currentTitle);
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                showToast('Gagal menambahkan data baru.', 'warning');
            });
        }

        function confirmDelete(id, btn) {
            if (confirm("Tindakan destruktif: Anda yakin ingin menghapus record ini dari basis data secara permanen?")) {
                fetch('/admin/delete-row', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        title: currentTitle,
                        id: id
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showToast(res.message, 'success');
                        const row = btn.closest('tr');
                        row.style.opacity = 0;
                        row.style.transform = 'translateX(20px)';
                        row.style.transition = 'all 0.3s ease';
                        setTimeout(() => row.remove(), 300);
                    } else {
                        showToast(res.message, 'warning');
                    }
                })
                .catch(err => {
                    showToast('Gagal menghapus data.', 'warning');
                });
            }
        }
        // ================================================================
        // DOKUMEN SPMI — Fungsi Panel Upload
        // ================================================================
        function toggleUploadForm() {
            const formContainer = document.getElementById('uploadFormContainer');
            if (formContainer) {
                if (formContainer.classList.contains('hidden')) {
                    formContainer.classList.remove('hidden');
                    // Add slight delay for animation
                    setTimeout(() => {
                        formContainer.classList.remove('opacity-0', 'translate-y-4');
                    }, 10);
                } else {
                    formContainer.classList.add('opacity-0', 'translate-y-4');
                    setTimeout(() => {
                        formContainer.classList.add('hidden');
                    }, 300);
                }
            }
        }

        function loadRenstraPanel() {
            const content = document.getElementById('dynamic-content');
            content.innerHTML = `
            <div class="max-w-7xl mx-auto pb-12">
                <!-- Header -->
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-chart-bar"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.6)]"></span>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Capaian Kinerja</p>
                        </div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Capaian Renstra</h2>
                        <p class="text-slate-500 text-sm mt-2">Impor data Renstra dari Excel untuk visualisasi grafik di halaman publik.</p>
                    </div>
                </div>

                <!-- Import Form -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <div class="lg:col-span-1 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 pb-4 border-b border-slate-100">Impor Excel</h3>
                        <form id="importRenstraForm" onsubmit="event.preventDefault(); submitImportRenstra();" class="space-y-6">
                            <div class="p-6 rounded-2xl bg-blue-50/50 border border-blue-100/50">
                                <label class="block text-[11px] font-bold text-blue-400 uppercase tracking-widest mb-3">File Excel (.xlsx)</label>
                                <input type="file" id="renstra_file" accept=".xlsx,.xls" required
                                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                            </div>
                            <button type="submit" id="renstraImportBtn" class="w-full bg-slate-900 text-white font-black uppercase tracking-widest text-[10px] py-4 rounded-2xl shadow-lg hover:bg-slate-800 transition-all flex items-center justify-center gap-3">
                                <i class="fas fa-file-import"></i> Mulai Impor
                            </button>
                            <button type="button" onclick="truncateRenstra()" class="w-full bg-rose-50 text-rose-600 border border-rose-100 font-black uppercase tracking-widest text-[10px] py-4 rounded-2xl hover:bg-rose-100 transition-all flex items-center justify-center gap-3">
                                <i class="fas fa-trash-alt"></i> Kosongkan Data
                            </button>
                        </form>
                        <div class="mt-8 p-6 rounded-2xl bg-amber-50 border border-amber-100">
                            <h4 class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-2"><i class="fas fa-info-circle mr-1"></i> Format Excel (6 Kolom)</h4>
                            <p class="text-[10px] text-amber-600 leading-relaxed font-semibold">
                                Kolom A: Program (Bisa dikosongkan jika sama)<br>
                                Kolom B: Indikator Kinerja<br>
                                Kolom C: PIC (Contoh: WD 1)<br>
                                Kolom D: Target<br>
                                Kolom E: Realisasi<br>
                                Kolom F: Tahun (YYYY)
                            </p>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
                        <div class="px-10 py-7 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <h3 class="text-xl font-black text-slate-800 font-display">Data Terdaftar</h3>
                             <button onclick="fetchRenstraList()" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 flex items-center justify-center transition-all">
                                <i class="fas fa-sync-alt text-sm"></i>
                            </button>
                        </div>
                        <div class="overflow-x-auto max-h-[500px]">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Program</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Indikator</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">PIC</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Tahun</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Target</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Realisasi</th>
                                    </tr>
                                </thead>
                                <tbody id="renstra-tbody" class="divide-y divide-slate-50">
                                    <tr><td colspan="6" class="px-8 py-10 text-center text-slate-400 font-medium font-display">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            `;
            fetchRenstraList();
        }

        function fetchRenstraList() {
            const tbody = document.getElementById('renstra-tbody');
            if(!tbody) return;
            tbody.innerHTML = '<tr><td colspan="6" class="px-8 py-10 text-center"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...</td></tr>';
            
            fetch('/admin/renstra')
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.data.length > 0) {
                        tbody.innerHTML = res.data.map(item => `
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-4 text-[10px] font-bold text-blue-600 uppercase tracking-wider">${item.program || '-'}</td>
                                <td class="px-8 py-4 text-xs font-semibold text-slate-700">${item.indikator}</td>
                                <td class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase">${item.pic || '-'}</td>
                                <td class="px-8 py-4 text-xs font-black text-slate-800 text-center">${item.tahun}</td>
                                <td class="px-8 py-4 text-xs font-bold text-slate-500 text-center">${item.target}%</td>
                                <td class="px-8 py-4 text-xs font-bold text-emerald-600 text-center">${item.realisasi}%</td>
                            </tr>
                        `).join('');
                    } else {
                        tbody.innerHTML = '<tr><td colspan="6" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Data Renstra masih kosong.</td></tr>';
                    }
                });
        }

        function submitImportRenstra() {
            const file = document.getElementById('renstra_file').files[0];
            if (!file) return;

            const btn = document.getElementById('renstraImportBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';

            const fd = new FormData();
            fd.append('file', file);
            fd.append('_token', '{{ csrf_token() }}');

            fetch('/admin/renstra/import', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                if (res.success) {
                    showToast(res.message, 'success');
                    document.getElementById('renstra_file').value = '';
                    fetchRenstraList();
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                showToast('Terjadi kesalahan saat mengimpor data.', 'warning');
            });
        }

        function truncateRenstra() {
            if (!confirm('Peringatan: Semua data Renstra akan dihapus secara permanen. Lanjutkan?')) return;
            fetch('/admin/renstra/truncate', {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    fetchRenstraList();
                }
            });
        }

        function loadDokumenSpmiPanel() {
            const content = document.getElementById('dynamic-content');
            content.innerHTML = `
            <div class="max-w-7xl mx-auto pb-12">
                <!-- Header -->
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-file-alt"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Dokumen</p>
                        </div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Dokumen SPMI</h2>
                        <p class="text-slate-500 text-sm mt-2">Upload, kelola, dan hapus dokumen SPMI. Perubahan langsung tampil di halaman publik.</p>
                    </div>
                    <a href="/spmi/dokumen-spmi" target="_blank" class="relative z-10 inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-5 py-3 rounded-xl transition-all">
                        <i class="fas fa-external-link-alt text-xs"></i> Lihat Halaman Publik
                    </a>
                </div>

                <!-- Upload Form -->
                <div id="uploadFormContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Upload Dokumen Baru</h3>
                        <button onclick="toggleUploadForm()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest"><i class="fas fa-times mr-1"></i> Tutup</button>
                    </div>
                    <form id="uploadDokumenForm" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Dokumen <span class="text-rose-500">*</span></label>
                                <input type="text" id="ud_judul" placeholder="Contoh: Standar Mutu Penelitian" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun <span class="text-rose-500">*</span></label>
                                <input type="number" id="ud_tahun" min="2000" max="2099" placeholder="${new Date().getFullYear()}" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                                <input type="text" id="ud_kategori" placeholder="Ketik kategori baru atau pilih..." list="kategori_list"
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                                <datalist id="kategori_list">
                                    <option value="Dokumen SPMI">
                                    <option value="Standar Mutu">
                                    <option value="Kebijakan Mutu">
                                    <option value="Prosedur Mutu">
                                    <option value="Formulir Mutu">
                                    <option value="Dokumen Pendukung">
                                </datalist>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                                <input type="text" id="ud_deskripsi" placeholder="Opsional — keterangan singkat dokumen"
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                            </div>
                        </div>

                        <!-- Drag & Drop Zone -->
                        <div id="dropzone" onclick="document.getElementById('ud_file').click()"
                            class="border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-3xl p-12 flex flex-col items-center justify-center cursor-pointer transition-all bg-slate-50 hover:bg-blue-50/30 group">
                            <div id="dropzone-icon" class="w-16 h-16 rounded-2xl bg-white border border-slate-200 group-hover:border-blue-200 shadow-sm flex items-center justify-center mb-4 transition-all">
                                <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>
                            </div>
                            <p id="dropzone-text" class="text-sm font-bold text-slate-500 group-hover:text-blue-600 transition-colors">Klik atau seret file ke sini</p>
                            <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP — Maks. 20MB</p>
                            <input type="file" id="ud_file" name="file" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar">
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" id="uploadBtn" onclick="submitUploadDokumen()"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-widest px-10 py-4 rounded-2xl shadow-[0_10px_25px_rgba(37,99,235,0.3)] hover:-translate-y-1 transition-all flex items-center gap-3">
                                <i class="fas fa-upload"></i> Upload Dokumen
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Dokumen Table -->
                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="px-10 py-7 border-b border-slate-100 flex flex-wrap items-center justify-between bg-slate-50/50 gap-4">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 font-display">Daftar Dokumen</h3>
                            <p id="dok-count" class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Memuat...</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="toggleUploadForm()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-sm flex items-center gap-2">
                                <i class="fas fa-plus"></i> Tambah Dokumen
                            </button>
                            <button onclick="fetchDokumenList()" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 flex items-center justify-center transition-all" title="Refresh">
                                <i class="fas fa-sync-alt text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div id="dokumen-table-wrap" class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-12">#</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Judul Dokumen</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-24">Tahun</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-36">Kategori</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-28">File</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-20">↓</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dokumen-tbody" class="divide-y divide-slate-50">
                                <tr><td colspan="7" class="px-8 py-10 text-center text-slate-400 font-medium">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...
                                </td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div id="editDokumenModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] flex items-center justify-center p-4">
                <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden">
                    <div class="px-10 py-7 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-black text-slate-800 text-xl font-display">Edit Dokumen</h3>
                        <button onclick="closeEditDokModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-10 space-y-4">
                        <input type="hidden" id="edit_dok_id">
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Dokumen</label>
                            <input type="text" id="edit_judul" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun</label>
                                <input type="number" id="edit_tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                                <input type="text" id="edit_kategori" list="kategori_list" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                            <input type="text" id="edit_deskripsi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti File (opsional)</label>
                            <input type="file" id="edit_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                                class="w-full p-3 border border-slate-200 rounded-2xl text-sm text-slate-600 bg-slate-50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                            <p id="edit_current_file" class="text-xs text-slate-400 mt-2"></p>
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button onclick="closeEditDokModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs rounded-2xl hover:bg-slate-50 transition tracking-widest uppercase">Batal</button>
                            <button onclick="submitEditDokumen()" class="px-8 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase flex items-center gap-2">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            `;

            // Drag-drop events
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('ud_file');
            if (dropzone && fileInput) {
                dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('border-blue-400', 'bg-blue-50/50'); });
                dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-blue-400', 'bg-blue-50/50'));
                dropzone.addEventListener('drop', e => {
                    e.preventDefault();
                    dropzone.classList.remove('border-blue-400', 'bg-blue-50/50');
                    if (e.dataTransfer.files.length > 0) {
                        fileInput.files = e.dataTransfer.files;
                        updateDropzoneUI(e.dataTransfer.files[0]);
                    }
                });
                fileInput.addEventListener('change', () => {
                    if (fileInput.files.length > 0) updateDropzoneUI(fileInput.files[0]);
                });
            }

            fetchDokumenList();
        }

        function updateDropzoneUI(file) {
            const ext = file.name.split('.').pop().toLowerCase();
            const icons = { pdf: 'fa-file-pdf text-red-500', doc: 'fa-file-word text-blue-500', docx: 'fa-file-word text-blue-500', xls: 'fa-file-excel text-green-500', xlsx: 'fa-file-excel text-green-500' };
            const iconClass = icons[ext] || 'fa-file-alt text-slate-500';
            const size = (file.size / (1024*1024)).toFixed(2) + ' MB';
            document.getElementById('dropzone-icon').innerHTML = `<i class="fas ${iconClass} text-3xl"></i>`;
            document.getElementById('dropzone-text').textContent = `✓ ${file.name} (${size})`;
            document.getElementById('dropzone-text').classList.add('text-blue-600');
        }

        function fetchDokumenList() {
            fetch('/admin/dokumen-spmi')
                .then(r => r.json())
                .then(res => {
                    if (!res.success) return;
                    const tbody = document.getElementById('dokumen-tbody');
                    const countEl = document.getElementById('dok-count');
                    if (!tbody) return;

                    countEl.textContent = res.data.length + ' dokumen tersimpan di database';

                    if (res.data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="7" class="px-8 py-12 text-center text-slate-400 font-medium"><i class="fas fa-folder-open text-3xl block mb-3 opacity-30"></i>Belum ada dokumen. Upload dokumen pertama Anda di atas.</td></tr>`;
                        return;
                    }

                    tbody.innerHTML = res.data.map((d, i) => `
                        <tr class="hover:bg-blue-50/20 transition-colors group">
                            <td class="px-8 py-6 text-center">
                                <span class="text-[11px] font-black text-slate-400">${String(i+1).padStart(2,'0')}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <i class="${d.icon_class || 'fas fa-file-alt text-slate-400'} text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm leading-snug">${d.judul}</p>
                                        ${d.deskripsi ? `<p class="text-xs text-slate-400 mt-0.5 line-clamp-1">${d.deskripsi}</p>` : ''}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-black px-3 py-1.5 rounded-xl">${d.tahun}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-semibold text-slate-500">${d.kategori}</span>
                            </td>
                            <td class="px-8 py-6">
                                ${d.nama_file ? `
                                <div>
                                    <span class="inline-block bg-slate-100 text-slate-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">${d.tipe_file || 'file'}</span>
                                    <p class="text-[10px] text-slate-400 mt-1">${d.ukuran_file || ''}</p>
                                </div>` : '<span class="text-slate-300 text-xs">—</span>'}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-sm font-bold text-slate-500">${d.downloads}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <button onclick="openEditDokModal(${JSON.stringify(d).replace(/"/g,'&quot;')})"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <button onclick="deleteDokumen(${d.id}, this)"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join('');
                })
                .catch(() => showToast('Gagal memuat daftar dokumen.', 'warning'));
        }

        function submitUploadDokumen() {
            const judul = document.getElementById('ud_judul')?.value?.trim();
            const tahun = document.getElementById('ud_tahun')?.value?.trim();
            const file  = document.getElementById('ud_file')?.files[0];

            if (!judul) { showToast('Judul dokumen wajib diisi!', 'warning'); return; }
            if (!tahun) { showToast('Tahun wajib diisi!', 'warning'); return; }
            if (!file)  { showToast('Pilih file untuk diupload!', 'warning'); return; }

            const formData = new FormData();
            formData.append('judul',    judul);
            formData.append('tahun',    tahun);
            formData.append('deskripsi', document.getElementById('ud_deskripsi')?.value || '');
            formData.append('kategori', document.getElementById('ud_kategori')?.value || 'Dokumen SPMI');
            formData.append('file',     file);
            formData.append('_token',   '{{ csrf_token() }}');

            const btn = document.getElementById('uploadBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';

            fetch('/admin/dokumen-spmi/upload', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(res => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-upload"></i> Upload Dokumen';
                    if (res.success) {
                        showToast(res.message, 'success');
                        document.getElementById('ud_judul').value = '';
                        document.getElementById('ud_tahun').value = '';
                        document.getElementById('ud_deskripsi').value = '';
                        document.getElementById('ud_file').value = '';
                        document.getElementById('dropzone-text').textContent = 'Klik atau seret file ke sini';
                        document.getElementById('dropzone-text').classList.remove('text-blue-600');
                        document.getElementById('dropzone-icon').innerHTML = '<i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>';
                        fetchDokumenList();
                    } else {
                        showToast(res.message || 'Upload gagal.', 'warning');
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-upload"></i> Upload Dokumen';
                    showToast('Terjadi kesalahan saat upload.', 'warning');
                });
        }

        function openEditDokModal(d) {
            document.getElementById('edit_dok_id').value   = d.id;
            document.getElementById('edit_judul').value    = d.judul;
            document.getElementById('edit_tahun').value    = d.tahun;
            document.getElementById('edit_deskripsi').value= d.deskripsi || '';
            document.getElementById('edit_current_file').textContent = d.nama_file ? 'File saat ini: ' + d.nama_file + ' (' + (d.ukuran_file||'') + ')' : 'Belum ada file';
            document.getElementById('edit_kategori').value = d.kategori;
            document.getElementById('editDokumenModal').classList.remove('hidden');
        }

        function closeEditDokModal() {
            document.getElementById('editDokumenModal').classList.add('hidden');
            document.getElementById('edit_file').value = '';
        }

        function submitEditDokumen() {
            const id = document.getElementById('edit_dok_id').value;
            const formData = new FormData();
            formData.append('judul',    document.getElementById('edit_judul').value);
            formData.append('tahun',    document.getElementById('edit_tahun').value);
            formData.append('deskripsi',document.getElementById('edit_deskripsi').value);
            formData.append('kategori', document.getElementById('edit_kategori').value);
            formData.append('_token',   '{{ csrf_token() }}');
            formData.append('_method',  'POST');
            const fileEl = document.getElementById('edit_file');
            if (fileEl.files.length > 0) formData.append('file', fileEl.files[0]);

            fetch(`/admin/dokumen-spmi/${id}/update`, { method: 'POST', body: formData })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showToast(res.message, 'success');
                        closeEditDokModal();
                        fetchDokumenList();
                    } else {
                        showToast(res.message || 'Gagal menyimpan.', 'warning');
                    }
                })
                .catch(() => showToast('Terjadi kesalahan.', 'warning'));
        }

        function deleteDokumen(id, btn) {
            if (!confirm('Hapus dokumen ini beserta file-nya secara permanen?')) return;
            fetch(`/admin/dokumen-spmi/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    const row = btn.closest('tr');
                    row.style.opacity = 0; row.style.transform = 'translateX(20px)'; row.style.transition = 'all 0.3s';
                    setTimeout(() => { row.remove(); fetchDokumenList(); }, 300);
                } else {
                    showToast(res.message || 'Gagal menghapus.', 'warning');
                }
            })
            .catch(() => showToast('Terjadi kesalahan.', 'warning'));
        }

        // ================================================================
        // GALERI FOTO & VIDEO — Fungsi Panel Upload Khusus
        // ================================================================
        function loadGaleriFotoPanel() {
            const content = document.getElementById('dynamic-content');
            content.innerHTML = `
            <div class="max-w-7xl mx-auto pb-12">
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-images"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.6)]"></span>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Media</p>
                        </div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Galeri Foto</h2>
                        <p class="text-slate-500 text-sm mt-2">Daftar album dan foto kegiatan kampus.</p>
                    </div>
                    <button onclick="toggleUploadForm()" class="relative z-10 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-[0_8px_20px_rgba(37,99,235,0.2)] transition-all hover:-translate-y-1">
                        <i class="fas fa-plus mr-2 text-[10px]"></i> Tambah Album
                    </button>
                </div>

                <div id="uploadFormContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Tambah Album Baru</h3>
                        <button onclick="toggleUploadForm()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest"><i class="fas fa-times mr-1"></i> Batal</button>
                    </div>
                    <form id="uploadGaleriFotoForm" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Album <span class="text-rose-500">*</span></label>
                                <input type="text" id="ga_nama" placeholder="Contoh: Wisuda Ke-15 Politeknik Jambi" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link Sampul (Opsional)</label>
                                <input type="text" id="ga_link" placeholder="Pasang link gambar jika tidak upload file"
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Sampul Foto (Lokal)</label>
                            <input type="file" id="ga_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                        </div>
                        <button type="button" onclick="submitUploadAlbum()" id="uploadAlbumBtn" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all">
                            <i class="fas fa-save mr-2"></i> Simpan Album
                        </button>
                    </form>
                </div>

                <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.02)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-20 text-center">No</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Album</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="galeri-foto-tbody"></tbody>
                    </table>
                </div>
            </div>
            `;
            fetchAlbums();
        }

        function loadGaleriVideoPanel() {
            const content = document.getElementById('dynamic-content');
            content.innerHTML = `
            <div class="max-w-7xl mx-auto pb-12">
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-video"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-2 h-2 rounded-full bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.6)]"></span>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Video</p>
                        </div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Galeri Video</h2>
                        <p class="text-slate-500 text-sm mt-2">Upload file video atau pasang link YouTube.</p>
                    </div>
                    <button onclick="toggleUploadForm()" class="relative z-10 bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-[0_8px_20px_rgba(0,0,0,0.1)] transition-all hover:-translate-y-1">
                        <i class="fas fa-plus mr-2 text-[10px]"></i> Tambah Video
                    </button>
                </div>

                <div id="uploadFormContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Tambah Video Baru</h3>
                        <button onclick="toggleUploadForm()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest"><i class="fas fa-times mr-1"></i> Batal</button>
                    </div>
                    <form id="uploadGaleriVideoForm" enctype="multipart/form-data">
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Video <span class="text-rose-500">*</span></label>
                            <input type="text" id="gv_judul" placeholder="Contoh: Profil LPM Poljam 2024" required
                                class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                        </div>
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                            <input type="text" id="gv_deskripsi" placeholder="Keterangan singkat tentang video ini"
                                class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                        </div>
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Upload Video (Lokal - Max 40MB)</label>
                            <input type="file" id="gv_file" accept="video/mp4,video/x-matroska,video/x-ms-wmv" required class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 transition-all">
                            <p class="text-[9px] text-slate-400 mt-2 italic font-bold">Limit server: 40MB.</p>
                        </div>
                        <button type="button" onclick="submitUploadVideo()" id="uploadVideoBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all">
                            <i class="fas fa-save mr-2"></i> Simpan Video
                        </button>
                    </form>
                </div>

                <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.02)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-20 text-center">No</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Judul Video</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="galeri-video-tbody"></tbody>
                    </table>
                </div>
            </div>
            `;
            fetchVideos();
        }

        // Logic Fetching & Uploading
        function fetchAlbums() {
            fetch('/admin/galeri-album').then(r => r.json()).then(res => {
                const tbody = document.getElementById('galeri-foto-tbody');
                if (!tbody || !res.success) return;
                tbody.innerHTML = res.data.map((d, i) => {
                    let coverUrl = '/images/gedung-poljam.png';
                    if (d.sampul_foto) {
                        coverUrl = d.sampul_foto.startsWith('http') ? d.sampul_foto : '/storage/gallery/' + d.sampul_foto;
                    } else if (d.first_foto) {
                        coverUrl = '/storage/gallery/' + d.first_foto.file_path;
                    }
                    
                    return `
                    <tr class="hover:bg-blue-50/10 border-b border-slate-50 transition-colors">
                        <td class="px-8 py-4 text-center text-[11px] font-black text-slate-400 uppercase">${String(i+1).padStart(2,'0')}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <img src="${coverUrl}" 
                                     class="w-12 h-8 rounded-lg object-cover shadow-sm bg-slate-100" onerror="this.src='/images/gedung-poljam.png'">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">${d.nama_album}</p>
                                    <p class="text-[10px] text-slate-400">${d.created_at ? d.created_at.substring(0,10) : ''}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-end gap-2">
                                <button onclick="openManagePhotos(${d.id}, '${d.nama_album.replace(/'/g,"\\'")}')"
                                    class="text-emerald-500 hover:text-emerald-700 py-2 px-3 bg-emerald-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-images mr-1"></i> Foto
                                </button>
                                <button onclick="openEditAlbum(${d.id}, '${d.nama_album.replace(/'/g,"\\'")}')"
                                    class="text-blue-500 hover:text-blue-700 py-2 px-3 bg-blue-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-pen mr-1"></i>
                                </button>
                                <button onclick="deleteAlbum(${d.id})" class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                }).join('') || '<tr><td colspan="3" class="px-8 py-10 text-center text-slate-300">Belum ada album.</td></tr>';
            });
        }

        function fetchVideos() {
            fetch('/admin/galeri-video').then(r => r.json()).then(res => {
                const tbody = document.getElementById('galeri-video-tbody');
                if (!tbody || !res.success) return;
                tbody.innerHTML = res.data.map((d, i) => {
                    let youtubeId = null;
                    if (d.link_youtube) {
                        const m = d.link_youtube.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/);
                        if (m) youtubeId = m[1];
                    }
                    const thumb = youtubeId ? `https://img.youtube.com/vi/${youtubeId}/default.jpg` : '/images/gedung-poljam.png';

                    return `
                    <tr class="hover:bg-blue-50/10 border-b border-slate-50 transition-colors">
                        <td class="px-8 py-4 text-center text-[11px] font-black text-slate-400 uppercase">${String(i+1).padStart(2,'0')}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative w-12 h-8 rounded-lg overflow-hidden group/thumb cursor-pointer" 
                                     onclick="playDashboardVideo('${d.link_youtube || ''}', '${d.judul.replace(/'/g,"\\'")}')">
                                    <img src="${thumb}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-white opacity-0 group-hover/thumb:opacity-100 transition-opacity">
                                        <i class="fas fa-play text-[10px]"></i>
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate">${d.judul}</p>
                                    <p class="text-[10px] text-slate-400 max-w-xs truncate">${d.link_youtube || '-'}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-end gap-2">
                                <button onclick="playDashboardVideo('${d.link_youtube || ''}', '${d.judul.replace(/'/g,"\\'")}')"
                                    class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button onclick="openEditVideo(${d.id}, '${d.judul.replace(/'/g,"\\'")}', '${(d.link_youtube||'').replace(/'/g,"\\'")}', '${(d.deskripsi||'').replace(/'/g,"\\'")}')"
                                    class="text-blue-500 hover:text-blue-700 py-2 px-3 bg-blue-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-pen mr-1"></i>
                                </button>
                                <button onclick="deleteVideo(${d.id})" class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                }).join('') || '<tr><td colspan="3" class="px-8 py-10 text-center text-slate-300">Belum ada video.</td></tr>';
            });
        }

        function submitUploadAlbum() {
            const nama = document.getElementById('ga_nama').value;
            const file = document.getElementById('ga_file').files[0];
            const link = document.getElementById('ga_link').value;
            if(!nama) return showToast('Nama album wajib diisi', 'warning');

            const fd = new FormData();
            fd.append('nama_album', nama);
            if(file) fd.append('sampul_foto', file);
            if(link) fd.append('link_extern', link);
            fd.append('_token', '{{ csrf_token() }}');

            const btn = document.getElementById('uploadAlbumBtn');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';

            fetch('/admin/galeri-album/upload', {
                method: 'POST', 
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => {
                if (!r.ok) return r.json().then(err => { throw err; });
                return r.json();
            })
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                if(res.success) { 
                    showToast(res.message, 'success'); 
                    toggleUploadForm(); 
                    fetchAlbums(); 
                    document.getElementById('uploadGaleriFotoForm').reset();
                } else {
                    showToast(res.message || 'Gagal menyimpan.', 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                console.error(err);
                let msg = 'Terjadi kesalahan sistem.';
                if (err.errors) {
                    msg = Object.values(err.errors).flat().join(' ');
                } else if (err.message) {
                    msg = err.message;
                }
                showToast(msg, 'warning');
            });
        }

        function submitUploadVideo() {
            const judul = document.getElementById('gv_judul').value;
            const file = document.getElementById('gv_file').files[0];
            const desc = document.getElementById('gv_deskripsi').value;
            if(!judul) return showToast('Judul video wajib diisi', 'warning');
            if(!file) return showToast('File video wajib diunggah', 'warning');

            const fd = new FormData();
            fd.append('judul', judul);
            fd.append('deskripsi', desc);
            if(file) fd.append('video_file', file);
            fd.append('_token', '{{ csrf_token() }}');

            const btn = document.getElementById('uploadVideoBtn');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';

            fetch('/admin/galeri-video/upload', {
                method: 'POST', 
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => {
                if (!r.ok) return r.json().then(err => { throw err; });
                return r.json();
            })
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                if(res.success) { 
                    showToast(res.message, 'success'); 
                    toggleUploadForm(); 
                    fetchVideos(); 
                    document.getElementById('uploadGaleriVideoForm').reset();
                } else {
                    showToast(res.message || 'Gagal menyimpan.', 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                console.error(err);
                let msg = 'Terjadi kesalahan sistem.';
                if (err.errors) {
                    msg = Object.values(err.errors).flat().join(' ');
                } else if (err.message) {
                    msg = err.message;
                }
                showToast(msg, 'warning');
            });
        }

        function deleteAlbum(id) {
            if(!confirm('Hapus album ini secara permanen?')) return;
            fetch('/admin/galeri-album/' + id, {method: 'DELETE', body: new FormData(), headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})
                .then(r => r.json()).then(res => { if(res.success) { showToast(res.message, 'success'); fetchAlbums(); } });
        }

        function deleteVideo(id) {
            if(!confirm('Hapus video ini secara permanen?')) return;
            fetch('/admin/galeri-video/' + id, {method: 'DELETE', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}})
                .then(r => r.json()).then(res => { if(res.success) { showToast(res.message, 'success'); fetchVideos(); } });
        }

        function toggleUploadForm() {
            const container = document.getElementById('uploadFormContainer');
            if(!container) return;
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                setTimeout(() => { container.classList.remove('opacity-0', 'translate-y-4'); }, 10);
            } else {
                container.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => { container.classList.add('hidden'); }, 300);
            }
        }

        // ================================================================
        // EDIT ALBUM
        // ================================================================
        let currentEditAlbumId = null;
        function openEditAlbum(id, namaAlbum) {
            currentEditAlbumId = id;
            document.getElementById('ea_nama').value = namaAlbum;
            document.getElementById('ea_link').value = '';
            document.getElementById('editAlbumModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editAlbumModal').classList.remove('opacity-0');
                document.getElementById('editAlbumModalBox').classList.remove('scale-95');
            }, 10);
        }
        function closeEditAlbumModal() {
            document.getElementById('editAlbumModal').classList.add('opacity-0');
            document.getElementById('editAlbumModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('editAlbumModal').classList.add('hidden'), 200);
        }
        function saveEditAlbum() {
            const nama = document.getElementById('ea_nama').value;
            const file = document.getElementById('ea_file').files[0];
            const link = document.getElementById('ea_link').value;
            if(!nama) return showToast('Nama album wajib diisi', 'warning');
            const fd = new FormData();
            fd.append('nama_album', nama);
            if(file) fd.append('sampul_foto', file);
            if(link) fd.append('link_extern', link);
            fd.append('_token', '{{ csrf_token() }}');
            fetch('/admin/galeri-album/' + currentEditAlbumId + '/update', {
                method:'POST', 
                body: fd, 
                headers: { 'Accept': 'application/json' }
            })
                .then(r => {
                    if (!r.ok) return r.json().then(err => { throw err; });
                    return r.json();
                })
                .then(res => {
                    if(res.success) { showToast(res.message, 'success'); closeEditAlbumModal(); fetchAlbums(); }
                    else showToast(res.message || 'Gagal menyimpan.', 'warning');
                })
                .catch(err => {
                    console.error(err);
                    let msg = 'Gagal memperbarui album.';
                    if (err.errors) msg = Object.values(err.errors).flat().join(' ');
                    showToast(msg, 'warning');
                });
        }

        // ================================================================
        // EDIT VIDEO
        // ================================================================
        let currentEditVideoId = null;
        function openEditVideo(id, judul, link, deskripsi) {
            currentEditVideoId = id;
            document.getElementById('ev_judul').value = judul.trim();
            document.getElementById('ev_deskripsi').value = deskripsi.trim();
            document.getElementById('editVideoModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editVideoModal').classList.remove('opacity-0');
                document.getElementById('editVideoModalBox').classList.remove('scale-95');
            }, 10);
        }
        function closeEditVideoModal() {
            document.getElementById('editVideoModal').classList.add('opacity-0');
            document.getElementById('editVideoModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('editVideoModal').classList.add('hidden'), 200);
        }
        function saveEditVideo() {
            const judul = document.getElementById('ev_judul').value;
            const desc = document.getElementById('ev_deskripsi').value;
            const file = document.getElementById('ev_file').files[0];
            if(!judul) return showToast('Judul video wajib diisi', 'warning');
            const fd = new FormData();
            fd.append('judul', judul);
            if(desc) fd.append('deskripsi', desc);
            if(file) fd.append('video_file', file);
            fd.append('_token', '{{ csrf_token() }}');
            fetch('/admin/galeri-video/' + currentEditVideoId + '/update', {
                method:'POST', 
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
                .then(r => {
                    if (!r.ok) return r.json().then(err => { throw err; });
                    return r.json();
                })
                .then(res => {
                    if(res.success) { showToast(res.message, 'success'); closeEditVideoModal(); fetchVideos(); }
                    else showToast(res.message || 'Gagal menyimpan.', 'warning');
                })
                .catch(err => {
                    console.error(err);
                    let msg = 'Gagal memperbarui video.';
                    if (err.errors) msg = Object.values(err.errors).flat().join(' ');
                    showToast(msg, 'warning');
                });
        }

        // ================================================================
        // MANAGE PHOTOS IN ALBUM
        // ================================================================
        let currentManageAlbumId = null;

        function openManagePhotos(id, namaAlbum) {
            currentManageAlbumId = id;
            document.getElementById('mp_album_name').innerText = namaAlbum;
            document.getElementById('managePhotosModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('managePhotosModal').classList.remove('opacity-0');
                document.getElementById('managePhotosModalBox').classList.remove('scale-95');
            }, 10);
            fetchAlbumPhotos();
        }

        function closeManagePhotosModal() {
            document.getElementById('managePhotosModal').classList.add('opacity-0');
            document.getElementById('managePhotosModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('managePhotosModal').classList.add('hidden'), 200);
        }

        function fetchAlbumPhotos() {
            const container = document.getElementById('mp_photos_grid');
            container.innerHTML = '<div class="col-span-full py-10 text-center"><i class="fas fa-spinner fa-spin text-slate-300 text-2xl"></i></div>';
            
            fetch(`/admin/galeri-album/${currentManageAlbumId}/photos`)
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        container.innerHTML = res.data.map(p => `
                            <div class="relative group rounded-2xl overflow-hidden aspect-square border border-slate-100 bg-slate-50">
                                <img src="/storage/gallery/${p.file_path}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button onclick="deletePhoto(${p.id})" class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center hover:bg-rose-600 transition-colors">
                                        <i class="fas fa-trash text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        `).join('') || '<div class="col-span-full py-10 text-center text-slate-300 font-semibold uppercase tracking-widest text-[10px]">Belum ada foto di album ini.</div>';
                    }
                });
        }

        function submitAddPhotos() {
            const files = document.getElementById('mp_files').files;
            if (files.length === 0) return showToast('Pilih foto terlebih dahulu', 'warning');

            const btn = document.getElementById('mp_upload_btn');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';

            const fd = new FormData();
            for (let i = 0; i < files.length; i++) {
                fd.append('photos[]', files[i]);
            }
            fd.append('_token', '{{ csrf_token() }}');

            fetch(`/admin/galeri-album/${currentManageAlbumId}/photos/upload`, {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json' }
            })
            .then(r => {
                if (!r.ok) return r.json().then(err => { throw err; });
                return r.json();
            })
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                if (res.success) {
                    showToast(res.message, 'success');
                    document.getElementById('mp_files').value = '';
                    fetchAlbumPhotos();
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                let msg = 'Gagal mengunggah foto.';
                if (err.errors) msg = Object.values(err.errors).flat().join(' ');
                showToast(msg, 'warning');
            });
        }

        function deletePhoto(id) {
            if (!confirm('Hapus foto ini?')) return;
            fetch(`/admin/galeri-foto/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    fetchAlbumPhotos();
                }
            });
        }

        function playDashboardVideo(url, title) {
            let youtubeId = null;
            let isLocal = false;
            if (url) {
                const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/;
                const matches = url.match(regex);
                if (matches && matches[1]) {
                    youtubeId = matches[1];
                } else if (!url.startsWith('http')) {
                    isLocal = true;
                }
            }

            if (youtubeId) {
                Swal.fire({
                    title: `<span class="text-slate-800 font-bold text-lg">${title}</span>`,
                    html: `
                        <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl border border-slate-100 mt-4">
                            <iframe width="100%" height="100%" 
                                src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0&modestbranding=1&playsinline=1&enablejsapi=1" 
                                title="${title}" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen></iframe>
                        </div>
                    `,
                    background: '#fff',
                    width: '800px',
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'rounded-[2.5rem] border border-white shadow-2xl',
                        closeButton: 'text-slate-400 hover:text-rose-500'
                    }
                });
            } else if (isLocal) {
                const videoUrl = '/storage/gallery/videos/' + url;
                Swal.fire({
                    title: `<span class="text-slate-800 font-bold text-lg">${title}</span>`,
                    html: `
                        <div class="rounded-2xl overflow-hidden shadow-2xl border border-slate-100 mt-4">
                            <video width="100%" height="auto" controls autoplay playsinline style="max-height: 70vh;">
                                <source src="${videoUrl}" type="video/mp4">
                                Browser Anda tidak mendukung tag pemutar video HTML5.
                            </video>
                        </div>
                    `,
                    background: '#fff',
                    width: '800px',
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'rounded-[2.5rem] border border-white shadow-2xl',
                        closeButton: 'text-slate-400 hover:text-rose-500'
                    }
                });
            } else {
                showToast('Url video tidak valid atau video tidak ditemukan.', 'warning');
            }
        }
    </script>

    <!-- EDIT ALBUM MODAL -->
    <div id="editAlbumModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="editAlbumModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden scale-95 transition-transform duration-200">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Edit Album Foto</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Perbarui nama & sampul album</p>
                </div>
                <button onclick="closeEditAlbumModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-10 space-y-5">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Album <span class="text-rose-500">*</span></label>
                    <input type="text" id="ea_nama" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti Sampul (Upload - Max 5MB)</label>
                    <input type="file" id="ea_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Atau Link Gambar</label>
                    <input type="text" id="ea_link" placeholder="https://..." class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button onclick="closeEditAlbumModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors uppercase tracking-widest">Batal</button>
                    <button onclick="saveEditAlbum()" class="px-6 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all uppercase tracking-widest"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT VIDEO MODAL -->
    <div id="editVideoModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="editVideoModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden scale-95 transition-transform duration-200">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Edit Video</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Perbarui data video</p>
                </div>
                <button onclick="closeEditVideoModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-10 space-y-5">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Video <span class="text-rose-500">*</span></label>
                    <input type="text" id="ev_judul" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                    <input type="text" id="ev_deskripsi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti File Video (Lokal - Max 40MB)</label>
                    <input type="file" id="ev_file" accept="video/mp4,video/x-matroska,video/x-ms-wmv" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button onclick="closeEditVideoModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors uppercase tracking-widest">Batal</button>
                    <button onclick="saveEditVideo()" class="px-6 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all uppercase tracking-widest"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MANAGE PHOTOS MODAL -->
    <div id="managePhotosModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="managePhotosModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-4xl overflow-hidden scale-95 transition-transform duration-200 flex flex-col max-h-[90vh]">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Kelola Foto Album</h3>
                    <p id="mp_album_name" class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">Nama Album</p>
                </div>
                <button onclick="closeManagePhotosModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-10 overflow-y-auto custom-scrollbar flex-grow">
                <!-- Upload Area -->
                <div class="mb-10 p-8 rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50/50">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="flex-grow w-full">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Tambah Foto Baru (Pilih banyak foto sekaligus)</label>
                            <input type="file" id="mp_files" multiple accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all cursor-pointer">
                        </div>
                        <button id="mp_upload_btn" onclick="submitAddPhotos()" class="shrink-0 bg-emerald-500 hover:bg-emerald-600 text-white font-black uppercase tracking-widest text-[10px] px-8 py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-95">
                            <i class="fas fa-upload mr-2"></i> Unggah Foto
                        </button>
                    </div>
                    <p class="text-[9px] text-slate-400 mt-4 leading-relaxed font-semibold uppercase tracking-wider italic">* Ukuran file disarankan di bawah 10MB per foto. Anda dapat memilih beberapa file sekaligus.</p>
                </div>

                <div class="mb-4 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Foto dalam Album</h4>
                </div>
                
                <div id="mp_photos_grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <!-- Photos will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>