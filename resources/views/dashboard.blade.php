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

                <!-- Modul SPMI -->
                <div class="mb-1">
                    <button onclick="toggleMenu('menuSPMI')" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-file-signature text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">SPMI</span>
                        </div>
                        <i id="icon-menuSPMI" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuSPMI" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <a onclick="loadPage('Dokumen SPMI')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-folder opacity-40 text-[10px] w-3 text-center"></i> <span>Dokumen SPMI</span></a>
                        <a onclick="loadPage('Unit')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-users-cog opacity-40 text-[10px] w-3 text-center"></i> <span>Unit</span></a>
                        <a onclick="loadPage('RTM')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-sync opacity-40 text-[10px] w-3 text-center"></i> <span>RTM</span></a>
                        <a onclick="loadPage('Dokumen Mutu SPMI')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-file-contract opacity-40 text-[10px] w-3 text-center"></i> <span>Dokumen Mutu SPMI</span></a>
                        <a onclick="loadPage('e-spmiPoljam')" class="submenu-item py-2.5 px-3 flex items-center justify-between cursor-pointer w-full group/link">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-globe opacity-40 text-[10px] w-3 text-center"></i>
                                <span>e-spmiPoljam</span>
                            </div>
                            <i class="fas fa-external-link-alt opacity-50 text-[9px] group-hover/link:text-blue-400 transition-colors"></i>
                        </a>
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
                        <a onclick="loadPage('Renop')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-file-alt opacity-40 text-[10px] w-3"></i> <span>Renop</span></a>
                        <a onclick="loadPage('Capaian Renstra')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-chart-bar opacity-40 text-[10px] w-3"></i> <span>Capaian Renstra</span></a>
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
                        <a onclick="loadPage('Dokumentasi Foto')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-image opacity-40 text-[10px] w-3"></i> <span>Dokumentasi Foto</span></a>
                        <a onclick="loadPage('Album Kegiatan')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-photo-video opacity-40 text-[10px] w-3"></i> <span>Album Kegiatan</span></a>
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
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-xl transition-colors">
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
                    <!-- Universal Search -->
                    <!-- Universal Search (CMD+K) -->
                    <div id="search-trigger" onclick="openSearchModal()" class="hidden xl:flex items-center bg-white/10 rounded-2xl px-5 py-3 shadow-sm border border-white/20 w-80 cursor-pointer hover:bg-white/20 transition-all group backdrop-blur-md">
                        <i class="fas fa-search text-blue-200 mr-3 group-hover:text-white transition-colors"></i>
                        <div class="text-sm font-semibold w-full text-blue-200 group-hover:text-white transition-colors">Cari modul atau dokumen...</div>
                        <kbd class="hidden lg:inline-block bg-black/20 text-blue-100 text-[10px] font-bold px-2 py-1 rounded-lg ml-2 border border-white/10">⌘K</kbd>
                    </div>

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
                                <h3 class="text-4xl font-black text-slate-800 tracking-tighter font-display">1,248</h3>
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
                                <h3 class="text-4xl font-black text-slate-800 tracking-tighter font-display">94.5<span class="text-2xl text-slate-400">%</span></h3>
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
                                <h3 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Unggul</h3>
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
                                <h3 class="text-4xl font-black text-white tracking-tighter font-display">24</h3>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Auditor Aktif</p>
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
                <label class="block text-[11px] font-black text-slate-400 mb-3 uppercase tracking-[0.2em]">Nilai / Konten Parameter</label>
                <textarea id="editValue" rows="6" class="w-full p-5 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-medium text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all resize-none shadow-inner leading-relaxed"></textarea>
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
                <label class="block text-[11px] font-black text-slate-400 mb-3 uppercase tracking-[0.2em]">Deskripsi Konten</label>
                <textarea id="addValue" rows="6" class="w-full p-5 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm font-medium text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all resize-none shadow-inner leading-relaxed" placeholder="Masukkan detail konten di sini..."></textarea>
                <div class="mt-8 flex justify-end space-x-4">
                    <button onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                    <button onclick="addNewData()" class="px-8 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.3)] hover:bg-emerald-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Tambahkan Data</button>
                </div>
            </div>
        </div>

    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <!-- COMMAND PALETTE (SEARCH MODAL) -->
    <div id="searchModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-[200] hidden flex-col items-center pt-[15vh] transition-all opacity-0 pointer-events-none" style="transition: opacity 0.2s ease;">
        <div class="bg-white/90 backdrop-blur-xl w-full max-w-2xl rounded-3xl shadow-[0_30px_100px_rgba(0,0,0,0.3)] border border-white overflow-hidden transform scale-95 transition-transform duration-200" id="searchModalContent">
            <div class="flex items-center px-6 py-4 border-b border-slate-100 bg-white">
                <i class="fas fa-search text-slate-400 text-lg mr-4"></i>
                <input type="text" id="searchInput" class="w-full bg-transparent border-none outline-none text-xl font-bold text-slate-700 placeholder-slate-300" placeholder="Cari Visi Misi, Akreditasi, Kuesioner..." autocomplete="off">
                <kbd class="bg-slate-100 text-slate-400 text-[10px] font-bold px-2 py-1 rounded-lg ml-2 border border-slate-200">ESC</kbd>
            </div>
            <div class="p-4 max-h-[60vh] overflow-y-auto" id="searchResults">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 px-4">Pintasan Cepat</div>
                <a href="#" onclick="executeSearch('Visi Dan Misi')" class="flex items-center gap-4 px-4 py-3 hover:bg-blue-50 rounded-2xl group transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-blue-100 text-slate-500 group-hover:text-blue-600 flex items-center justify-center transition-colors"><i class="fas fa-bullseye"></i></div>
                    <div><div class="text-sm font-bold text-slate-700 group-hover:text-blue-700">Visi Dan Misi</div><div class="text-[10px] font-medium text-slate-400">Profil Kampus</div></div>
                </a>
                <a href="#" onclick="executeSearch('Dokumen Akreditasi')" class="flex items-center gap-4 px-4 py-3 hover:bg-emerald-50 rounded-2xl group transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-emerald-100 text-slate-500 group-hover:text-emerald-600 flex items-center justify-center transition-colors"><i class="fas fa-certificate"></i></div>
                    <div><div class="text-sm font-bold text-slate-700 group-hover:text-emerald-700">Dokumen Akreditasi</div><div class="text-[10px] font-medium text-slate-400">Akreditasi</div></div>
                </a>
                <a href="#" onclick="executeSearch('Kuesioner')" class="flex items-center gap-4 px-4 py-3 hover:bg-rose-50 rounded-2xl group transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-rose-100 text-slate-500 group-hover:text-rose-600 flex items-center justify-center transition-colors"><i class="fas fa-clipboard-list"></i></div>
                    <div><div class="text-sm font-bold text-slate-700 group-hover:text-rose-700">Manajemen Kuesioner</div><div class="text-[10px] font-medium text-slate-400">Publikasi & Survei</div></div>
                </a>
            </div>
        </div>
    </div>

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

        // Search Modal Logic
        const searchModal = document.getElementById('searchModal');
        const searchModalContent = document.getElementById('searchModalContent');
        const searchInput = document.getElementById('searchInput');

        function openSearchModal() {
            searchModal.classList.remove('hidden');
            setTimeout(() => {
                searchModal.classList.remove('opacity-0', 'pointer-events-none');
                searchModalContent.classList.remove('scale-95');
                searchInput.focus();
            }, 10);
        }

        function closeSearchModal() {
            searchModal.classList.add('opacity-0', 'pointer-events-none');
            searchModalContent.classList.add('scale-95');
            setTimeout(() => {
                searchModal.classList.add('hidden');
            }, 200);
        }

        function executeSearch(title) {
            closeSearchModal();
            loadPage(title);
        }

        document.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                openSearchModal();
            }
            if (e.key === 'Escape' && !searchModal.classList.contains('hidden')) {
                closeSearchModal();
            }
        });

        searchModal.addEventListener('click', (e) => {
            if(e.target === searchModal) closeSearchModal();
        });

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

        // Module Pages
        function loadPage(title) {
            currentTitle = title;
            const contentData = `Informasi detail mengenai modul ${title}. Sistem ini memungkinkan Anda untuk memanipulasi data sesuai dengan standar penjaminan mutu yang berlaku.`;
            
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;
            
            setTimeout(() => {
                const singleDataPages = [
                    'Visi Dan Misi', 'Moto Dan Janji Layanan', 'Kebijakan Mutu POLJAM', 'Sasaran Mutu POLJAM', 'Standar Mutu POLJAM', 'Sasaran Mutu LPM', 'Struktur Organisasi', 'Job Deskripsi', 'Standar Waktu Pelayanan',
                    'Dokumen SPMI', 'Unit', 'RTM', 'Dokumen Mutu SPMI', 'e-spmiPoljam',
                    'Akreditasi', 'Dokumen Akreditasi',
                    'Renop', 'Capaian Renstra', 'Kepuasan Mahasiswa Poljam', 'Kepuasan Mahasiswa Prodi', 'Kepuasan Dosen & Tendik'
                ];
                
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
                                        <input type="text" value="Super Admin" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Email Utama</label>
                                        <input type="email" value="admin@poljam.ac.id" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
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
                                            <input type="text" value="LP3M Politeknik Jambi" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Nomor Telepon Resmi</label>
                                            <input type="text" value="(0741) 123456" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Email Resmi</label>
                                            <input type="email" value="info@poljam.ac.id" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Keamanan -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 border border-rose-100 shadow-[0_15px_40px_rgba(225,29,72,0.03)] relative overflow-hidden group">
                                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-rose-500/5 rounded-full blur-2xl group-hover:bg-rose-500/10 transition-colors"></div>
                                    <h3 class="text-[11px] font-black text-rose-400 mb-6 uppercase tracking-[0.2em] border-b border-rose-100/50 pb-4 relative z-10">Keamanan Akun</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Password Saat Ini</label>
                                            <input type="password" placeholder="Masukkan password saat ini" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Password Baru</label>
                                            <input type="password" placeholder="Password baru" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Konfirmasi Password Baru</label>
                                            <input type="password" placeholder="Ulangi password baru" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-8 flex justify-end gap-4">
                            <button onclick="showHome()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase shadow-sm">Batal</button>
                            <button onclick="showToast('Semua pengaturan sistem berhasil disimpan!'); setTimeout(() => showHome(), 800);" class="px-8 py-4 bg-slate-900 text-white font-bold text-xs rounded-2xl shadow-[0_15px_30px_rgba(15,23,42,0.2)] hover:bg-slate-800 transition-all hover:-translate-y-1 tracking-widest uppercase flex items-center gap-3">
                                <i class="fas fa-save text-sm"></i>
                                Simpan Semua Pengaturan
                            </button>
                        </div>
                    </div>
                    `;
                    content.style.opacity = 1;
                    return;
                }
                
                if (singleDataPages.includes(title)) {
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
                                <p class="text-slate-500 font-medium">Perbarui deskripsi ${title} secara langsung tanpa menggunakan tabel atau *pop-up* tambahan.</p>
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
                                <div class="w-px h-6 bg-slate-200 my-auto mx-2"></div>
                                <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Align Left"><i class="fas fa-align-left"></i></button>
                                <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Align Center"><i class="fas fa-align-center"></i></button>
                                <div class="w-px h-6 bg-slate-200 my-auto mx-2"></div>
                                <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Add Link"><i class="fas fa-link"></i></button>
                                <button class="w-10 h-10 rounded-xl hover:bg-white hover:shadow-sm text-slate-500 transition-all flex items-center justify-center" title="Add Image"><i class="fas fa-image"></i></button>
                            </div>

                            <textarea rows="12" class="w-full p-6 border border-slate-200 rounded-3xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-medium text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all resize-y shadow-inner leading-relaxed" placeholder="Ketik konten ${title} di sini...">Data simulasi ${title} yang saat ini aktif di sistem. 
 
Anda dapat langsung mengedit teks ini seperti mengetik di Microsoft Word. Setelah selesai, silakan klik tombol "Simpan Perubahan" di bagian bawah layar.</textarea>
                            
                            <div class="mt-10 flex justify-end gap-4 border-t border-slate-100 pt-8">
                                <button onclick="showHome()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase shadow-sm">Batal</button>
                                <button onclick="showToast('Pembaruan data ${title} berhasil disimpan secara permanen!')" class="px-8 py-4 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.3)] hover:bg-blue-700 transition-all hover:-translate-y-1 tracking-widest uppercase flex items-center gap-3">
                                    <i class="fas fa-save text-sm"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                    `;
                    content.style.opacity = 1;
                    return;
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
                                            <th class="px-10 py-6 border-b border-slate-100 w-24 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">UID</th>
                                            <th class="px-10 py-6 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Data Konten</th>
                                            <th class="px-10 py-6 border-b border-slate-100 text-right w-48 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Manajemen</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body" class="divide-y divide-slate-50">
                                        <tr class="hover:bg-slate-50/50 transition-colors group">
                                            <td class="px-10 py-8 font-black text-slate-400 text-center font-display">001</td>
                                            <td id="desc-content" class="px-10 py-8 leading-relaxed font-semibold text-slate-700 text-sm max-w-2xl">${contentData}</td>
                                            <td class="px-10 py-8">
                                                <div class="flex justify-end space-x-2">
                                                    <button onclick="openModalEdit('${contentData}')" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Edit"><i class="fas fa-pen text-sm"></i></button>
                                                    <button onclick="confirmDelete(this)" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Hapus"><i class="fas fa-trash text-sm"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;
                content.style.opacity = 1;
            }, 300);
        }
        
        // Modal Logic
        function showOverlay() {
            const overlay = document.getElementById('modalOverlay');
            overlay.classList.remove('hidden');
            // Small delay to allow display:block to apply before animating opacity
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

        function openModalEdit(val) {
            document.getElementById('editValue').value = val;
            showOverlay();
            const modal = document.getElementById('modalEdit');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
        }

        function openTambah() {
            document.getElementById('addValue').value = "";
            showOverlay();
            const modal = document.getElementById('modalTambah');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
        }

        function closeModal() {
            document.getElementById('modalEdit').classList.add('scale-95');
            document.getElementById('modalTambah').classList.add('scale-95');
            hideOverlay();
        }

        function saveData() {
            const newValue = document.getElementById('editValue').value;
            const desc = document.getElementById('desc-content');
            if(desc) desc.innerText = newValue;
            closeModal();
            
            setTimeout(() => showToast("Konfigurasi Sistem Berhasil Diperbarui"), 300);
        }

        function addNewData() {
            const val = document.getElementById('addValue').value;
            if(val.trim() === "") {
                alert("Validasi Gagal: Parameter tidak boleh kosong.");
                return;
            }
            
            const tableBody = document.getElementById("table-body");
            if(!tableBody) return;

            const rowCount = tableBody.rows.length + 1;
            const newRow = `
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-10 py-8 font-black text-slate-400 text-center font-display">00${rowCount}</td>
                    <td class="px-10 py-8 leading-relaxed font-semibold text-slate-700 text-sm max-w-2xl animate-fade-in">${val}</td>
                    <td class="px-10 py-8">
                        <div class="flex justify-end space-x-2">
                            <button onclick="openModalEdit('${val}')" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1"><i class="fas fa-pen text-sm"></i></button>
                            <button onclick="confirmDelete(this)" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1"><i class="fas fa-trash text-sm"></i></button>
                        </div>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            closeModal();
        }

        function confirmDelete(btn) {
            if(confirm("Tindakan destruktif: Anda yakin ingin menghapus record ini dari basis data?")) {
                const row = btn.closest('tr');
                row.style.opacity = 0;
                row.style.transform = 'translateX(20px)';
                row.style.transition = 'all 0.3s ease';
                setTimeout(() => row.remove(), 300);
            }
        }
    </script>
</body>
</html>