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
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
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
        
        /* CKEditor Height & Scroll Fix */
        .ck-editor__editable_inline {
            min-height: 200px;
            max-height: 400px;
            overflow-y: auto !important;
        }
        
        .modal-body-scroll {
            max-height: calc(90vh - 200px);
            overflow-y: auto;
            padding-right: 10px;
        }

        .modal-body-scroll::-webkit-scrollbar { width: 4px; }
        .modal-body-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }


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
                        <a onclick="loadPage('Artikel Ilmiah')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-newspaper opacity-40 text-[10px] w-3"></i> <span>Artikel / Berita</span></a>
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

                <!-- Modul Slider -->
                <div class="mb-1">
                    <button onclick="loadSliderPanel()" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-images text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Slider Homepage</span>
                        </div>
                        <div class="w-1.5 h-1.5 rounded-full bg-yellow-400 opacity-0 group-hover:opacity-100 shadow-[0_0_8px_rgba(250,204,21,0.6)]"></div>
                    </button>
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
                        <a onclick="loadPage('Kuesioner Mahasiswa')" class="submenu-item block py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-user-graduate opacity-40 text-[10px] w-3 text-center"></i> <span>Kuesioner Mahasiswa</span></a>
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
                <div class="modal-body-scroll">
                    <div id="edit-fields-container" class="space-y-4"></div>
                </div>
                <div class="mt-8 flex justify-end space-x-4 border-t border-slate-100 pt-6">
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
                <div class="modal-body-scroll">
                    <div id="add-fields-container" class="space-y-4"></div>
                </div>
                <div class="mt-8 flex justify-end space-x-4 border-t border-slate-100 pt-6">
                    <button onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                    <button onclick="addNewData()" class="px-8 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.3)] hover:bg-emerald-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Tambahkan Data</button>
                </div>
            </div>
        </div>

        <!-- IMPORT KUESIONER MODAL -->
        <div id="modalImportKuesioner" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 transition-transform duration-300 hidden flex-col">
            <div class="px-10 py-8 border-b border-slate-100 bg-emerald-50/50 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-slate-800 text-2xl font-display tracking-tight mb-1">Impor Data Kuesioner</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Excel Synchronizer</p>
                </div>
                <button onclick="closeModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="p-10">
                <form id="formImportKuesioner" onsubmit="event.preventDefault(); submitImportKuesioner();" class="space-y-6">
                    <div class="p-6 rounded-2xl bg-blue-50/50 border border-blue-100/30 space-y-4">
                        <div>
                            <label class="block text-[11px] font-black text-blue-600 uppercase tracking-widest mb-3">Tahun Akademik <span class="text-rose-500">*</span></label>
                            <input type="text" id="ik_tahun" placeholder="Contoh: 2024/2025 Genap" required class="w-full p-4 border border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 outline-none text-sm font-semibold text-slate-700 bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-blue-600 uppercase tracking-widest mb-3">File Excel (.xlsx / .xls) <span class="text-rose-500">*</span></label>
                            <input type="file" id="ik_file" accept=".xlsx,.xls" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4 border-t border-slate-100 pt-6">
                        <button type="button" onclick="closeModal()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                        <button type="submit" id="ik_submit_btn" class="px-8 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.3)] hover:bg-emerald-700 transition-all hover:-translate-y-1 tracking-widest uppercase">Mulai Impor</button>
                    </div>
                </form>
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
        let loadedDefaults = {};
        let currentEditId = null;
        let retrievedData = [];

        // Editor Logic (CKEditor 5)
        let activeEditors = {};

        async function initRichEditor(selector) {
            const elements = document.querySelectorAll(selector);
            for (const el of elements) {
                // Skip if already initialized
                if (el.dataset.editorId) continue;

                try {
                    const editor = await ClassicEditor.create(el, {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo'],
                    });
                    
                    const editorId = 'editor-' + Math.random().toString(36).substr(2, 9);
                    el.dataset.editorId = editorId;
                    activeEditors[editorId] = editor;

                    // Sync content on change
                    editor.model.document.on('change:data', () => {
                        el.value = editor.getData();
                    });
                } catch (error) {
                    console.error('CKEditor initialization failed:', error);
                }
            }
        }

        function destroyEditors() {
            Object.values(activeEditors).forEach(editor => {
                editor.destroy().catch(err => console.error('Destroy failed:', err));
            });
            activeEditors = {};
            document.querySelectorAll('[data-editor-id]').forEach(el => delete el.dataset.editorId);
        }

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
            if (title === 'Kepuasan Dosen & Tendik' || title === 'Kuesioner Dosen & Karyawan') {
                loadKuesionerDosenPanel();
                return;
            }
            if (title === 'Kuesioner Mahasiswa') {
                loadKuesionerMahasiswaPanel();
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
                        loadedDefaults = res.defaults || {};

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
                                            ${(currentTitle.includes('Kuesioner') || currentTitle.includes('Kuisioner')) ? 
                                                `<button onclick="openManageQuestions(${item.id}, '${item.judul}')" class="text-slate-400 hover:text-emerald-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Kelola Pertanyaan"><i class="fas fa-question text-sm"></i></button>` : ''}
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
                                    <div class="flex gap-4 items-center relative z-10">
                                        ${(title === 'Kuesioner Dosen & Karyawan') ? `
                                            <button onclick="openImportKuesioner()" class="bg-emerald-600 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(16,185,129,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(16,185,129,0.3)] hover:bg-emerald-700">
                                                <i class="fas fa-file-excel"></i>
                                                <span class="tracking-widest uppercase text-[10px]">Impor Excel</span>
                                            </button>
                                        ` : ''}
                                        <button onclick="openTambah()" class="bg-slate-900 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(15,23,42,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.3)] hover:bg-slate-800">
                                            <i class="fas fa-plus"></i>
                                            <span class="tracking-widest uppercase text-[10px]">Tambah Entri</span>
                                        </button>
                                    </div>
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
                        // Initialize Rich Editor for single editor
                        if (res.type === 'single') {
                            setTimeout(() => initRichEditor('#single-editor-textarea'), 200);
                        }
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
            const textarea = document.getElementById('single-editor-textarea');
            const editorId = textarea.dataset.editorId;
            const val = activeEditors[editorId] ? activeEditors[editorId].getData() : textarea.value;
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
            destroyEditors();
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
            
            // Re-init Editor for any textareas in the newly opened modal
            setTimeout(() => initRichEditor('textarea[id^="field-"]'), 300);
        }

        function openTambah() {
            // Generate form fields dynamically (with defaults for certain modules)
            generateFormFields('add-fields-container', loadedFields, loadedDefaults);

            showOverlay();
            const modal = document.getElementById('modalTambah');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
            
            // Re-init Editor for any textareas in the newly opened modal
            setTimeout(() => initRichEditor('textarea[id^="field-"]'), 300);
        }



        const isImageField = (f) => f.toLowerCase().includes('gambar') || f.toLowerCase().includes('foto') || f.toLowerCase().includes('file');
        
        function generateFormFields(containerId, fields, values = {}) {
            const container = document.getElementById(containerId);
            container.innerHTML = "";
            fields.forEach(field => {
                const labelText = field.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                const val = values[field] || "";
                const isTextArea = ['isi_konten', 'deskripsi', 'konten'].includes(field);
                const isDateField = field.toLowerCase().includes('tanggal') || 
                                    field.toLowerCase().includes('date');
                
                let inputHtml = "";
                if (isImageField(field)) {
                    // Show current image preview if exists
                    const isURL = val && (val.startsWith('http://') || val.startsWith('https://'));
                    let previewHtml = '';
                    if (val && !isURL) {
                        previewHtml = `<div class="mb-3"><img src="/storage/${val}" class="h-24 w-auto rounded-xl border border-slate-200 shadow-sm object-cover" onerror="this.style.display='none'"><p class="text-[10px] text-slate-400 mt-1 font-semibold">File/Gambar saat ini: ${val}</p></div>`;
                    }
                    
                    const isDocField = field.toLowerCase().includes('file') || field.toLowerCase().includes('dokumen');
                    let urlInputHtml = "";
                    let acceptAttr = "image/*";
                    let formatText = "Format: JPG, PNG, WEBP. Max: 2MB";
                    
                    if (isDocField) {
                        acceptAttr = ".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,image/*";
                        formatText = "Format: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR, Gambar. Max: 10MB";
                        urlInputHtml = `
                            <div class="mt-2">
                                <label class="block text-[9px] font-black text-slate-400 mb-1 uppercase tracking-[0.2em]">Atau Hubungkan ke URL Website (misal: https://example.com)</label>
                                <input type="text" id="field-${containerId}-${field}-url" value="${isURL ? val : ''}" placeholder="https://example.com" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">
                            </div>
                        `;
                    }
                    
                    inputHtml = `
                        ${previewHtml}
                        <input type="file" id="field-${containerId}-${field}" accept="${acceptAttr}" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:tracking-widest file:shadow-lg transition-all cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">${formatText}</p>
                        ${urlInputHtml}
                    `;
                } else if (isTextArea) {
                    inputHtml = `<textarea id="field-${containerId}-${field}" rows="5" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner leading-relaxed">${val}</textarea>`;
                } else if (isDateField) {
                    // Try to format value to YYYY-MM-DD for input type="date"
                    let dateVal = val;
                    if (val && !val.includes('-')) {
                        // If it's something like "4 April 2026", Carbon on backend will handle it, 
                        // but for input type="date" we might need a clean value.
                        // However, if we are editing, it's safer to leave empty or try to parse.
                        // For now, let's just make it a date input.
                    }
                    inputHtml = `<input type="date" id="field-${containerId}-${field}" value="${val}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">`;
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
            // Check if we are in Renstra context (renstra_id element exists)
            if (document.getElementById('renstra_id')) {
                submitRenstra(true);
                return;
            }

            const fd = new FormData();
            fd.append('title', currentTitle);
            fd.append('id', currentEditId);

            // isImageField is now defined globally

            loadedFields.forEach(field => {
                const elId = `field-edit-fields-container-${field}`;
                const el = document.getElementById(elId);
                if (isImageField(field)) {
                    const urlEl = document.getElementById(`${elId}-url`);
                    if (el.files && el.files[0]) {
                        fd.append(field, el.files[0]);
                    } else if (urlEl && urlEl.value.trim() !== "") {
                        fd.append(field, urlEl.value.trim());
                    }
                } else {
                    // Check if Editor is active for this field
                    const editorId = el.dataset.editorId;
                    const val = (editorId && activeEditors[editorId]) ? activeEditors[editorId].getData() : el.value;
                    fd.append(field, val);
                }
            });

            fetch('/admin/save-page-data', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: fd
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
            // Check if we are in Renstra context
            if (document.getElementById('renstra_id')) {
                submitRenstra(false);
                return;
            }

            const fd = new FormData();
            fd.append('title', currentTitle);

            let hasEmpty = false;
            // isImageField is now defined globally

            loadedFields.forEach(field => {
                const elId = `field-add-fields-container-${field}`;
                const el = document.getElementById(elId);
                if (isImageField(field)) {
                    const urlEl = document.getElementById(`${elId}-url`);
                    if (el.files && el.files[0]) {
                        fd.append(field, el.files[0]);
                    } else if (urlEl && urlEl.value.trim() !== "") {
                        fd.append(field, urlEl.value.trim());
                    }
                    // Image fields are optional — don't flag as empty
                } else {
                    // Check if Editor is active for this field
                    const editorId = el.dataset.editorId;
                    const val = (editorId && activeEditors[editorId]) ? activeEditors[editorId].getData() : el.value;
                    
                    // Relax validation: allow empty if we have a default for it on the backend
                    // Or if it's meant to be managed by the system
                    if (val.trim() === "" || val.trim() === "<p></p>") {
                        if (!loadedDefaults[field]) {
                            hasEmpty = true;
                        }
                    }
                    fd.append(field, val);
                }
            });

            if (hasEmpty) {
                alert("Validasi Gagal: Semua kolom isian harus diisi.");
                return;
            }

            fetch('/admin/add-row', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: fd
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

        // Kuesioner Import Logic
        function openImportKuesioner() {
            showOverlay();
            const modal = document.getElementById('modalImportKuesioner');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('scale-95'), 10);
        }

        function submitImportKuesioner() {
            const tahun = document.getElementById('ik_tahun').value;
            const file = document.getElementById('ik_file').files[0];
            const btn = document.getElementById('ik_submit_btn');
            
            if (!tahun || !file) {
                showToast('Tahun dan File wajib diisi.', 'warning');
                return;
            }

            const fd = new FormData();
            fd.append('tahun_akademik', tahun);
            fd.append('file', file);
            fd.append('_token', '{{ csrf_token() }}');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengimpor...';

            fetch('/admin/kuesioner-dosen/import', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = 'Mulai Impor';
                if (res.success) {
                    showToast(res.message, 'success');
                    closeModal();
                    loadPage(currentTitle);
                } else {
                    showToast(res.message || 'Gagal mengimpor data.', 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = 'Mulai Impor';
                console.error(err);
                showToast('Terjadi kesalahan saat mengimpor.', 'warning');
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
                        <div class="flex items-center gap-3 mt-2">
                             <p class="text-slate-500 text-sm">Kelola data Renstra secara mendetail melalui tabel di bawah atau melalui Impor Excel.</p>
                             <button onclick="openRenstraModal()" class="ml-4 bg-blue-600 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all flex items-center gap-2">
                                <i class="fas fa-plus"></i> Tambah Data
                             </button>
                        </div>
                    </div>
                </div>

                <!-- Import Form -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <div class="lg:col-span-1 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 pb-4 border-b border-slate-100">Sync Matriks Renstra</h3>
                        <form id="importRenstraForm" onsubmit="event.preventDefault(); submitImportRenstra();" class="space-y-6">
                            <div class="p-6 rounded-2xl bg-blue-50/50 border border-blue-100/50 space-y-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-blue-400 uppercase tracking-widest mb-3">File Matriks (.xlsx)</label>
                                    <input type="file" id="renstra_file" accept=".xlsx,.xls" required
                                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-blue-400 uppercase tracking-widest mb-3">Tahun (Opsional - Timpa Tahun di Excel)</label>
                                    <select id="renstra_import_year" class="w-full bg-white border border-blue-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-4 focus:ring-blue-500/10 transition-all">
                                        <option value="">Gunakan Tahun dari Excel</option>
                                        @foreach(range(date('Y')-5, date('Y')+5) as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" id="renstraImportBtn" class="w-full bg-slate-900 text-white font-black uppercase tracking-widest text-[10px] py-4 rounded-2xl shadow-lg hover:bg-slate-800 transition-all flex items-center justify-center gap-3">
                                <i class="fas fa-sync-alt"></i> Process & Sync Matrix
                            </button>
                            <button type="button" onclick="truncateRenstra()" class="w-full bg-rose-50 text-rose-600 border border-rose-100 font-black uppercase tracking-widest text-[10px] py-4 rounded-2xl hover:bg-rose-100 transition-all flex items-center justify-center gap-3">
                                <i class="fas fa-trash-alt"></i> Kosongkan Data
                            </button>
                        </form>
                        <div class="mt-8 p-6 rounded-2xl bg-amber-50 border border-amber-100">
                            <h4 class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-2"><i class="fas fa-info-circle mr-1"></i> Format Matriks (Column A-I)</h4>
                            <p class="text-[10px] text-amber-600 leading-relaxed font-semibold">
                                Kolom A: Tahun<br>
                                Kolom B-I: Pillar Strategic (I - VIII)<br>
                                Baris 1: Judul/Header Pillar
                            </p>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
                        <div class="px-10 py-7 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-6">
                                <h3 class="text-xl font-black text-slate-800 font-display">Data Terdaftar</h3>
                                <select id="filter-tahun-renstra" onchange="fetchRenstraList()" class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest outline-none focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                    <option value="">Semua Tahun</option>
                                    @foreach(range(date('Y')-5, date('Y')+5) as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <button onclick="fetchRenstraList()" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 flex items-center justify-center transition-all">
                                <i class="fas fa-sync-alt text-sm"></i>
                            </button>
                        </div>
                        <div class="overflow-x-auto max-h-[500px]">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Tahun</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Program</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Persentase (Capaian)</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="renstra-tbody" class="divide-y divide-slate-50">
                                    <tr><td colspan="4" class="px-8 py-10 text-center text-slate-400 font-medium font-display">Memuat data...</td></tr>
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
            const filterTahun = document.getElementById('filter-tahun-renstra')?.value || '';
            tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-10 text-center"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...</td></tr>';
            
            fetch('/admin/renstra')
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.data.length > 0) {
                        let filteredData = res.data;
                        if(filterTahun) {
                            filteredData = res.data.filter(item => item.tahun == filterTahun);
                        }

                        tbody.innerHTML = filteredData.map(item => `
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-4 text-xs font-black text-slate-800 text-center tracking-tighter">${item.tahun}</td>
                                <td class="px-8 py-4">
                                    <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">${item.program || '-'}</div>
                                    <div class="text-[9px] font-medium text-slate-400 uppercase tracking-widest italic">${item.indikator}</div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <div class="w-12 h-1.5 bg-slate-100 rounded-full overflow-hidden shadow-inner flex-shrink-0">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: ${item.realisasi}%"></div>
                                        </div>
                                        <span class="text-xs font-black text-slate-700">${item.realisasi}%</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick='openRenstraModal(${JSON.stringify(item)})' class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all border border-blue-100"><i class="fas fa-edit text-[10px]"></i></button>
                                        <button onclick="deleteRenstra(${item.id})" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all border border-rose-100"><i class="fas fa-trash text-[10px]"></i></button>
                                    </div>
                                </td>
                            </tr>
                        `).join('');

                        if(filteredData.length === 0 && filterTahun) {
                             tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Data untuk tahun ' + filterTahun + ' tidak ditemukan.</td></tr>';
                        }
                    } else {
                        tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Data Renstra masih kosong.</td></tr>';
                    }
                });
        }

        function submitImportRenstra() {
            const fileInput = document.getElementById('renstra_file');
            const yearOverride = document.getElementById('renstra_import_year')?.value;
            const file = fileInput.files[0];
            if (!file) return;

            const btn = document.getElementById('renstraImportBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Syncing Matrix...';

            const fd = new FormData();
            fd.append('file', file);
            if (yearOverride) fd.append('tahun_override', yearOverride);
            fd.append('_token', '{{ csrf_token() }}');

            fetch('/admin/renstra/import', {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json' }
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
                    showToast(res.message || 'Gagal mengimpor data.', 'warning');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                console.error(err);
                showToast('Terjadi kesalahan koneksi atau server saat mengimpor.', 'warning');
            });
        }

        function openRenstraModal(item = null) {
            const overlay = document.getElementById('modalOverlay');
            const modal   = item ? document.getElementById('modalEdit') : document.getElementById('modalTambah');
            const container = item ? document.getElementById('edit-fields-container') : document.getElementById('add-fields-container');
            
            // Sembunyikan modal yang tidak relevan
            document.getElementById('modalEdit').classList.add('hidden');
            document.getElementById('modalTambah').classList.add('hidden');
            
            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');
            overlay.style.opacity = '1';
            overlay.style.pointerEvents = 'auto';
            setTimeout(() => modal.classList.remove('scale-95'), 10);

            let fieldsHtml = `
                <input type="hidden" id="renstra_id" value="${item ? item.id : ''}">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Program / Kelompok</label>
                    <input type="text" id="renstra_program" value="${item ? item.program || '' : ''}" placeholder="Contoh: R 1: Kesiapan Kerja Lulusan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Indikator Kinerja</label>
                    <textarea id="renstra_indikator" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">${item ? item.indikator : ''}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">PIC</label>
                        <input type="text" id="renstra_pic" value="${item ? item.pic || '' : ''}" placeholder="WD 1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun (YYYY)</label>
                        <input type="number" id="renstra_tahun" value="${item ? item.tahun : new Date().getFullYear()}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Target (%)</label>
                        <input type="number" step="0.01" id="renstra_target" value="${item ? item.target : 0}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Realisasi (%)</label>
                        <input type="number" step="0.01" id="renstra_realisasi" value="${item ? item.realisasi : 0}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            `;
            container.innerHTML = fieldsHtml;
        }

        // Renstra-specific overrides removed — saveData/addNewData now detect
        // Renstra context automatically via the renstra_id element check.

        function submitRenstra(isEdit = false) {
            const id = document.getElementById('renstra_id').value;
            const data = {
                program:   document.getElementById('renstra_program').value,
                indikator: document.getElementById('renstra_indikator').value,
                pic:       document.getElementById('renstra_pic').value,
                tahun:     document.getElementById('renstra_tahun').value,
                target:    document.getElementById('renstra_target').value,
                realisasi: document.getElementById('renstra_realisasi').value,
                _token:    '{{ csrf_token() }}'
            };

            const url = isEdit ? `/admin/renstra/${id}/update` : '/admin/renstra/store';
            
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    closeModal();
                    fetchRenstraList();
                } else {
                    showToast(res.message || 'Gagal menyimpan data.', 'warning');
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Terjadi kesalahan sistem.', 'warning');
            });
        }

        function deleteRenstra(id) {
            if (!confirm('Hapus data Renstra ini?')) return;
            fetch(`/admin/renstra/delete/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    fetchRenstraList();
                } else {
                    showToast(res.message || 'Gagal menghapus data.', 'warning');
                }
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

            fetch('/admin/dokumen-spmi/upload', { 
                method: 'POST', 
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(async r => {
                    const data = await r.json();
                    if (!r.ok) {
                        throw new Error(data.message || 'Terjadi kesalahan sistem.');
                    }
                    return data;
                })
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
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-upload"></i> Upload Dokumen';
                    showToast(err.message || 'Terjadi kesalahan saat upload.', 'warning');
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
        // SLIDER HOMEPAGE MANAGEMENT
        // ================================================================
        function loadSliderPanel() {
            currentTitle = 'Slider Homepage';
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;

            setTimeout(() => {
                content.innerHTML = `
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-images"></i></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Visual</p>
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Slider Homepage</h2>
                            <p class="text-slate-500 text-sm mt-2">Kelola gambar slide utama yang tampil di halaman depan website.</p>
                        </div>
                        <button onclick="openSliderModal()" class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3 relative z-10">
                            <i class="fas fa-plus"></i> Tambah Slide
                        </button>
                    </div>

                    <!-- Slider Cards Grid -->
                    <div id="slider-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Loading State -->
                        <div class="col-span-full py-20 text-center">
                            <i class="fas fa-spinner fa-spin text-4xl text-slate-300"></i>
                            <p class="mt-4 text-slate-400 font-bold uppercase tracking-widest text-[10px]">Memuat Slide...</p>
                        </div>
                    </div>
                </div>

                <!-- SLIDER MODAL -->
                <div id="sliderModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="sliderModalInner">
                        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <div>
                                <h3 class="font-black text-slate-800 text-xl font-display tracking-tight mb-1" id="sliderModalTitle">Tambah Slide</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Slider Homepage</p>
                            </div>
                            <button onclick="closeSliderModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
                        </div>
                        <form id="sliderForm" onsubmit="event.preventDefault(); submitSlider();" class="p-10 space-y-5">
                            <input type="hidden" id="slider_id">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Judul Utama</label>
                                <input type="text" id="sl_judul" placeholder="Contoh: Implementasi Standar Mutu" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Sub Judul / Deskripsi Singkat</label>
                                <textarea id="sl_sub_judul" rows="2" placeholder="Deskripsi singkat yang tampil di bawah judul..." class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Urutan Tampil</label>
                                    <input type="number" id="sl_urutan" value="0" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Link URL (Opsional)</label>
                                    <input type="text" id="sl_link" placeholder="#" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Gambar Slide (Rekomendasi: 1920x800)</label>
                                <div id="slider-drop-area" class="relative border-2 border-dashed border-slate-200 hover:border-blue-400 bg-slate-50/50 rounded-2xl p-6 text-center transition-all group cursor-pointer">
                                    <input type="file" id="sl_gambar" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewSliderImage(this)">
                                    <div id="sl_preview_container" class="hidden mb-4">
                                        <img id="sl_preview_img" class="max-h-32 mx-auto rounded-xl shadow-sm border-2 border-white">
                                    </div>
                                    <div id="sl_placeholder">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-slate-300 group-hover:text-blue-500 transition-colors mb-2"></i>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Klik atau seret gambar ke sini</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                                <button type="button" onclick="closeSliderModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-[10px] uppercase tracking-widest hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                                <button type="submit" id="sliderSubmitBtn" class="px-6 py-3 bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all hover:-translate-y-0.5">Simpan Slide</button>
                            </div>
                        </form>
                    </div>
                </div>
                `;
                content.style.opacity = 1;
                fetchSliderList();
            }, 300);
        }

        function fetchSliderList() {
            const grid = document.getElementById('slider-grid');
            if(!grid) return;

            fetch('/admin/slider')
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        if (res.data.length === 0) {
                            grid.innerHTML = `<div class="col-span-full py-20 text-center bg-white/40 rounded-[2rem] border border-dashed border-slate-200">
                                <i class="fas fa-images text-4xl text-slate-200 mb-4 block"></i>
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-[11px]">Belum ada slide. Klik "Tambah Slide" di atas.</p>
                            </div>`;
                            return;
                        }

                        grid.innerHTML = res.data.map(m => `
                            <div class="group relative bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_10px_30px_rgba(0,0,0,0.02)] overflow-hidden hover:shadow-[0_20px_50px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-500">
                                <div class="aspect-[16/9] w-full overflow-hidden relative">
                                    <img src="/storage/${m.gambar}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='/images/gedung-poljam.png'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
                                    <div class="absolute top-4 right-4 flex gap-2">
                                        <button onclick='openSliderModal(${JSON.stringify(m).replace(/'/g, "&apos;")})' class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-md text-blue-600 shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><i class="fas fa-pen text-[10px]"></i></button>
                                        <button onclick="deleteSlider(${m.id})" class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-md text-rose-600 shadow-lg flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all"><i class="fas fa-trash text-[10px]"></i></button>
                                    </div>
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg shadow-lg">Urutan: ${m.urutan}</span>
                                    </div>
                                </div>
                                <div class="p-8">
                                    <h4 class="text-slate-800 font-black text-lg line-clamp-1 mb-2 font-display tracking-tight">${m.judul || 'Tanpa Judul'}</h4>
                                    <p class="text-slate-500 text-xs line-clamp-2 font-medium leading-relaxed mb-4">${m.sub_judul || '-'}</p>
                                    <div class="flex items-center gap-2 text-[9px] font-black text-blue-500 uppercase tracking-widest">
                                        <i class="fas fa-link"></i>
                                        <span class="truncate">${m.link_url || '#'}</span>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    }
                })
                .catch(() => showToast('Gagal memuat slider.', 'warning'));
        }

        function openSliderModal(data = null) {
            const modal = document.getElementById('sliderModal');
            const inner = document.getElementById('sliderModalInner');
            const form  = document.getElementById('sliderForm');
            const title = document.getElementById('sliderModalTitle');
            
            form.reset();
            document.getElementById('slider_id').value = '';
            document.getElementById('sl_preview_container').classList.add('hidden');
            document.getElementById('sl_placeholder').classList.remove('hidden');

            if (data) {
                title.textContent = 'Edit Slide';
                document.getElementById('slider_id').value = data.id;
                document.getElementById('sl_judul').value = data.judul || '';
                document.getElementById('sl_sub_judul').value = data.sub_judul || '';
                document.getElementById('sl_urutan').value = data.urutan || 0;
                document.getElementById('sl_link').value = data.link_url || '';
                
                if (data.gambar) {
                    document.getElementById('sl_preview_img').src = '/storage/' + data.gambar;
                    document.getElementById('sl_preview_container').classList.remove('hidden');
                    document.getElementById('sl_placeholder').classList.add('hidden');
                }
            } else {
                title.textContent = 'Tambah Slide';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                inner.classList.remove('scale-95', 'opacity-0');
            }, 50);
        }

        function closeSliderModal() {
            const modal = document.getElementById('sliderModal');
            const inner = document.getElementById('sliderModalInner');
            inner.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function previewSliderImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('sl_preview_img').src = e.target.result;
                    document.getElementById('sl_preview_container').classList.remove('hidden');
                    document.getElementById('sl_placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function submitSlider() {
            const id = document.getElementById('slider_id').value;
            const btn = document.getElementById('sliderSubmitBtn');
            const originalText = btn.innerHTML;
            
            const fd = new FormData();
            fd.append('judul', document.getElementById('sl_judul').value);
            fd.append('sub_judul', document.getElementById('sl_sub_judul').value);
            fd.append('urutan', document.getElementById('sl_urutan').value);
            fd.append('link_url', document.getElementById('sl_link').value);
            fd.append('_token', '{{ csrf_token() }}');
            
            const fileInput = document.getElementById('sl_gambar');
            if (fileInput.files.length > 0) {
                fd.append('gambar', fileInput.files[0]);
            } else if (!id) {
                showToast('Gambar slide wajib diupload!', 'warning');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';

            const url = id ? `/admin/slider/${id}/update` : '/admin/slider';
            
            fetch(url, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(res => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    if (res.success) {
                        showToast(res.message, 'success');
                        closeSliderModal();
                        fetchSliderList();
                    } else {
                        showToast(res.message || 'Gagal menyimpan.', 'warning');
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    showToast('Terjadi kesalahan server.', 'warning');
                });
        }

        function deleteSlider(id) {
            if (!confirm('Hapus slide ini?')) return;
            fetch(`/admin/slider/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    fetchSliderList();
                } else {
                    showToast(res.message || 'Gagal menghapus.', 'warning');
                }
            })
            .catch(() => showToast('Terjadi kesalahan koneksi.', 'warning'));
        }

        // ================================================================
        // KUESIONER MODULES — Shared State
        // ================================================================
        let kuesionerData = [];
        let kuesionerChart = null;
        let kuesionerEditId = null;

        let kuesionerDataStudent = [];
        let kuesionerChartStudent = null;
        let kuesionerEditIdStudent = null;

        // ================================================================
        // KUESIONER DOSEN & KARYAWAN — Full CRUD + Excel Import + Chart
        // ================================================================
        function loadKuesionerDosenPanel() {
            currentTitle = 'Kuesioner Dosen & Karyawan';
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;

            setTimeout(() => {
                content.innerHTML = `
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header Area -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col lg:flex-row justify-between items-center gap-8 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
                            <div class="flex items-center justify-center lg:justify-start gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Survei Kepuasan Internal</p>
                            </div>
                            <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">Kuesioner Dosen & Karyawan</h2>
                            <p class="text-slate-500 text-sm mt-4 font-medium">Kelola data persentase kepuasan melalui excel, tambah/edit/hapus, dan pantau visualisasinya.</p>
                        </div>
                        
                        <div class="flex flex-wrap justify-center gap-3 relative z-10">
                            <button onclick="toggleImportKuesioner()" class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-file-excel"></i> Import Excel
                            </button>
                            <button onclick="openKuesionerAddModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-plus"></i> Tambah Data
                            </button>
                            <button onclick="truncateKuesionerDosen()" class="bg-white border border-rose-100 text-rose-500 hover:bg-rose-50 text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-sm transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-trash-alt"></i> Kosongkan
                            </button>
                        </div>
                    </div>

                    <!-- Import Form (Hidden by default) -->
                    <div id="importKuesionerContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
                            <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Import Data via Excel</h3>
                            <button onclick="toggleImportKuesioner()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest flex items-center gap-2"><i class="fas fa-times"></i> Batal</button>
                        </div>
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 mb-8">
                            <h4 class="text-xs font-black text-blue-700 mb-3 flex items-center gap-2"><i class="fas fa-info-circle"></i> Format Kolom Excel yang Terdeteksi Otomatis</h4>
                            <div class="grid grid-cols-6 gap-2 text-center">
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom A</p><p class="text-[10px] font-bold text-blue-700">Program</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom B</p><p class="text-[10px] font-bold text-emerald-600">Sangat Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom C</p><p class="text-[10px] font-bold text-blue-600">Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom D</p><p class="text-[10px] font-bold text-yellow-600">Cukup Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom E</p><p class="text-[10px] font-bold text-orange-600">Tidak Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom F</p><p class="text-[10px] font-bold text-rose-600">Sangat Tidak</p></div>
                            </div>
                            <p class="text-[10px] text-blue-600 mt-3 font-medium"><i class="fas fa-magic mr-1"></i> Baris pertama (header) akan dilewati otomatis. Data langsung terverifikasi dan masuk ke database.</p>
                        </div>
                        <form id="importKuesionerForm" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Pilih Tahun Akademik</label>
                                <input type="text" id="kuesioner_tahun" placeholder="Contoh: 2023/2024" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div class="flex-grow">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">File Excel (.xlsx / .xls)</label>
                                <input type="file" id="kuesioner_file" accept=".xlsx, .xls" required
                                    class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                            </div>
                            <div class="md:col-span-2">
                                <button type="button" onclick="submitImportKuesioner()" id="importKuesionerBtn" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all hover:shadow-2xl hover:-translate-y-0.5">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Upload & Verifikasi Data Otomatis
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Filter Bar -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white shadow-sm p-4 mb-6 flex flex-wrap items-center gap-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Filter Tahun:</span>
                        <select onchange="loadKuesionerTable(this.value)" id="kdFilterTahun" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 outline-none focus:border-blue-500 min-w-[160px]">
                            <option value="">Semua Tahun</option>
                        </select>
                        <span class="ml-auto text-[10px] font-bold text-slate-400 uppercase tracking-widest" id="kdTotalCount">0 Data</span>
                    </div>

                    <!-- Data Table -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-5 border-b border-slate-100 w-16 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">No</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Tahun Akademik</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Program</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-emerald-500 tracking-[0.15em]">SS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-blue-500 tracking-[0.15em]">S</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-yellow-500 tracking-[0.15em]">CS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-orange-500 tracking-[0.15em]">TS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-rose-500 tracking-[0.15em]">STS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-right w-36 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kdTableBody" class="divide-y divide-slate-50">
                                    <tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-10 border border-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] min-h-[450px] flex flex-col">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Visualisasi Data</h3>
                                <p class="text-slate-800 font-bold text-lg" id="chartTitle">Grafik Kepuasan Dosen & Karyawan</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shadow-inner border border-blue-100"><i class="fas fa-chart-bar"></i></div>
                        </div>
                        <div class="flex-grow flex items-center justify-center relative" style="min-height:350px">
                            <canvas id="kuesionerLiveChart"></canvas>
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100 flex flex-wrap gap-4 justify-center">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(34,197,94,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(59,130,246,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(234,179,8,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Cukup Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(249,115,22,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tidak Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(239,68,68,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Tidak Setuju</span></div>
                        </div>
                    </div>
                </div>

                <!-- KUESIONER ADD/EDIT MODAL -->
                <div id="kdModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4" style="transition: opacity .3s ease;">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-transform duration-300" id="kdModalInner">
                        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <div>
                                <h3 class="font-black text-slate-800 text-xl font-display tracking-tight mb-1" id="kdModalTitle">Tambah Data</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kuesioner Dosen & Karyawan</p>
                            </div>
                            <button onclick="closeKdModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
                        </div>
                        <div class="p-10 space-y-5">
                            <input type="hidden" id="kd_edit_id">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Tahun Akademik</label>
                                <input type="text" id="kd_tahun" placeholder="Contoh: 2023/2024" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Program Studi</label>
                                <input type="text" id="kd_program" placeholder="Contoh: D3 Teknik Informatika" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div class="grid grid-cols-5 gap-3">
                                <div>
                                    <label class="block text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-2 text-center">SS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_ss" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-blue-500 uppercase tracking-widest mb-2 text-center">S (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_s" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-yellow-500 uppercase tracking-widest mb-2 text-center">CS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_cs" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-orange-500 uppercase tracking-widest mb-2 text-center">TS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_ts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-rose-500 uppercase tracking-widest mb-2 text-center">STS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_sts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all">
                                </div>
                            </div>
                            <div class="flex justify-end gap-4 pt-4 border-t border-slate-100">
                                <button onclick="closeKdModal()" class="px-6 py-3.5 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                                <button onclick="submitKdForm()" id="kdSubmitBtn" class="px-6 py-3.5 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.25)] hover:bg-blue-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                content.style.opacity = 1;
                initKuesionerPanel();
            }, 300);
        }

        async function initKuesionerPanel() {
            try {
                const r = await fetch('/admin/kuesioner-dosen/data');
                const res = await r.json();
                if (!res.success) return;
                
                kuesionerData = res.data;
                const years = res.years;
                const selector = document.getElementById('kdFilterTahun');
                if (selector) {
                    selector.innerHTML = '<option value="">Semua Tahun</option>';
                    years.forEach(y => {
                        const opt = document.createElement('option');
                        opt.value = y; opt.textContent = y;
                        selector.appendChild(opt);
                    });
                }
                renderKuesionerTable(kuesionerData);
                renderKuesionerChart(kuesionerData);
            } catch(e) {
                console.error(e);
                showToast('Gagal memuat data kuesioner.', 'warning');
            }
        }

        async function loadKuesionerTable(tahun = '') {
            try {
                const url = tahun ? `/admin/kuesioner-dosen/data?tahun_akademik=${encodeURIComponent(tahun)}` : '/admin/kuesioner-dosen/data';
                const r = await fetch(url);
                const res = await r.json();
                if (!res.success) return;
                kuesionerData = res.data;
                renderKuesionerTable(kuesionerData);
                renderKuesionerChart(kuesionerData);
            } catch(e) {
                showToast('Gagal memuat data.', 'warning');
            }
        }

        function renderKuesionerTable(data) {
            const tbody = document.getElementById('kdTableBody');
            const countEl = document.getElementById('kdTotalCount');
            if (countEl) countEl.textContent = data.length + ' Data';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Belum ada data. Silakan import Excel atau tambah data manual.</td></tr>';
                return;
            }

            tbody.innerHTML = data.map((item, idx) => `
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-6 py-5 text-center font-black text-slate-400 text-xs">${idx + 1}</td>
                    <td class="px-6 py-5 text-xs font-bold text-slate-600">
                        <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg border border-indigo-100">
                            <i class="fas fa-calendar-alt text-[9px]"></i> ${item.tahun_akademik}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-sm font-bold text-slate-800">${item.program}</td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-black px-2.5 py-1 rounded-lg border border-emerald-100">${item.sangat_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-blue-50 text-blue-700 text-xs font-black px-2.5 py-1 rounded-lg border border-blue-100">${item.setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-yellow-50 text-yellow-700 text-xs font-black px-2.5 py-1 rounded-lg border border-yellow-100">${item.cukup_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-orange-50 text-orange-700 text-xs font-black px-2.5 py-1 rounded-lg border border-orange-100">${item.tidak_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-rose-50 text-rose-700 text-xs font-black px-2.5 py-1 rounded-lg border border-rose-100">${item.sangat_tidak_setuju}%</span></td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <button onclick="openKuesionerEditModal(${item.id})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Edit"><i class="fas fa-pen text-xs"></i></button>
                            <button onclick="deleteKuesionerRow(${item.id})" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderKuesionerChart(data) {
            const chartTitle = document.getElementById('chartTitle');
            if (data.length === 0) {
                if (kuesionerChart) kuesionerChart.destroy();
                kuesionerChart = null;
                if (chartTitle) chartTitle.textContent = 'Belum Ada Data';
                return;
            }

            const activeTahun = data[0].tahun_akademik;
            if (chartTitle) chartTitle.textContent = `Kepuasan Dosen & Karyawan — T.A ${activeTahun}`;

            const labels = data.map(i => {
                let t = i.program;
                return t.length > 18 ? t.substring(0, 18) + '…' : t;
            });

            const datasets = [
                { label: 'Sangat Setuju', data: data.map(i => i.sangat_setuju), backgroundColor: 'rgba(34, 197, 94, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Setuju', data: data.map(i => i.setuju), backgroundColor: 'rgba(59, 130, 246, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Cukup Setuju', data: data.map(i => i.cukup_setuju), backgroundColor: 'rgba(234, 179, 8, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Tidak Setuju', data: data.map(i => i.tidak_setuju), backgroundColor: 'rgba(249, 115, 22, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Sangat Tidak Setuju', data: data.map(i => i.sangat_tidak_setuju), backgroundColor: 'rgba(239, 68, 68, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 }
            ];

            const ctx = document.getElementById('kuesionerLiveChart');
            if (!ctx) return;
            if (kuesionerChart) kuesionerChart.destroy();
            kuesionerChart = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index', intersect: false,
                            backgroundColor: 'rgba(15,23,42,0.9)', titleFont: { family: 'Inter', size: 12, weight: 'bold' }, bodyFont: { family: 'Inter', size: 11 },
                            padding: 14, cornerRadius: 12, displayColors: true, boxPadding: 4,
                            callbacks: {
                                title: ctx => { const i = ctx[0].dataIndex; return data[i] ? data[i].program : ctx[0].label; },
                                label: ctx => ' ' + ctx.dataset.label + ': ' + ctx.parsed.y + '%'
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, max: 100, grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false }, ticks: { font: { family: 'Inter', size: 10, weight: 'bold' }, color: '#94a3b8', callback: v => v + '%' } },
                        x: { grid: { display: false, drawBorder: false }, ticks: { font: { family: 'Inter', size: 9, weight: 'bold' }, color: '#64748b', maxRotation: 45 } }
                    },
                    animation: { duration: 1200, easing: 'easeOutQuart' }
                }
            });
        }

        function openKuesionerAddModal() {
            kuesionerEditId = null;
            document.getElementById('kdModalTitle').textContent = 'Tambah Data Baru';
            document.getElementById('kd_edit_id').value = '';
            document.getElementById('kd_tahun').value = '';
            document.getElementById('kd_program').value = '';
            document.getElementById('kd_ss').value = '';
            document.getElementById('kd_s').value = '';
            document.getElementById('kd_cs').value = '';
            document.getElementById('kd_ts').value = '';
            document.getElementById('kd_sts').value = '';
            document.getElementById('kdModal').classList.remove('hidden');
        }

        function openKuesionerEditModal(id) {
            const item = kuesionerData.find(d => d.id === id);
            if (!item) return;
            kuesionerEditId = id;
            document.getElementById('kdModalTitle').textContent = 'Edit Data';
            document.getElementById('kd_edit_id').value = id;
            document.getElementById('kd_tahun').value = item.tahun_akademik;
            document.getElementById('kd_program').value = item.program;
            document.getElementById('kd_ss').value = item.sangat_setuju;
            document.getElementById('kd_s').value = item.setuju;
            document.getElementById('kd_cs').value = item.cukup_setuju;
            document.getElementById('kd_ts').value = item.tidak_setuju;
            document.getElementById('kd_sts').value = item.sangat_tidak_setuju;
            document.getElementById('kdModal').classList.remove('hidden');
        }

        function closeKdModal() {
            document.getElementById('kdModal').classList.add('hidden');
            kuesionerEditId = null;
        }

        async function submitKdForm() {
            const payload = {
                tahun_akademik: document.getElementById('kd_tahun').value,
                program: document.getElementById('kd_program').value,
                sangat_setuju: parseFloat(document.getElementById('kd_ss').value) || 0,
                setuju: parseFloat(document.getElementById('kd_s').value) || 0,
                cukup_setuju: parseFloat(document.getElementById('kd_cs').value) || 0,
                tidak_setuju: parseFloat(document.getElementById('kd_ts').value) || 0,
                sangat_tidak_setuju: parseFloat(document.getElementById('kd_sts').value) || 0,
            };
            if (!payload.tahun_akademik || !payload.program) return showToast('Tahun akademik dan program wajib diisi.', 'warning');

            const isEdit = !!kuesionerEditId;
            const url = isEdit ? `/admin/kuesioner-dosen/${kuesionerEditId}/update` : '/admin/kuesioner-dosen/store';

            try {
                const r = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    closeKdModal();
                    const filterTahun = document.getElementById('kdFilterTahun').value;
                    loadKuesionerTable(filterTahun);
                } else {
                    showToast(res.message || 'Gagal menyimpan.', 'warning');
                }
            } catch (e) {
                showToast('Terjadi kesalahan.', 'warning');
            }
        }

        async function deleteKuesionerRow(id) {
            if (!confirm('Yakin ingin menghapus data ini?')) return;
            try {
                const r = await fetch(`/admin/kuesioner-dosen/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    const filterTahun = document.getElementById('kdFilterTahun').value;
                    loadKuesionerTable(filterTahun);
                }
            } catch (e) {
                showToast('Gagal menghapus data.', 'warning');
            }
        }

        function toggleImportKuesioner() {
            const container = document.getElementById('importKuesionerContainer');
            if (!container) return;
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                setTimeout(() => container.classList.remove('opacity-0', 'translate-y-4'), 10);
            } else {
                container.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => container.classList.add('hidden'), 300);
            }
        }

        async function submitImportKuesioner() {
            const tahun = document.getElementById('kuesioner_tahun').value;
            const file = document.getElementById('kuesioner_file').files[0];
            if (!tahun || !file) return showToast('Tahun akademik dan file excel wajib diisi', 'warning');

            const btn = document.getElementById('importKuesionerBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sedang Memproses & Memverifikasi...';

            const fd = new FormData();
            fd.append('tahun_akademik', tahun);
            fd.append('file', file);
            fd.append('_token', '{{ csrf_token() }}');

            try {
                const r = await fetch('/admin/kuesioner-dosen/import', {
                    method: 'POST', body: fd, headers: { 'Accept': 'application/json' }
                });
                const res = await r.json();
                btn.disabled = false;
                btn.innerHTML = originalText;

                if (res.success) {
                    showToast(res.message, 'success');
                    toggleImportKuesioner();
                    document.getElementById('importKuesionerForm').reset();
                    // Refresh table and re-populate year filter
                    const selector = document.getElementById('kdFilterTahun');
                    if (selector) selector.innerHTML = '<option value="">Semua Tahun</option>';
                    loadKuesionerTable('');
                } else {
                    showToast(res.message || 'Gagal mengimpor.', 'warning');
                }
            } catch (e) {
                btn.disabled = false;
                btn.innerHTML = originalText;
                showToast('Terjadi kesalahan pada sistem.', 'warning');
            }
        }

        async function truncateKuesionerDosen() {
            const tahun = document.getElementById('kdFilterTahun')?.value || '';
            const msg = tahun ? `Hapus semua data kuesioner untuk tahun ${tahun}?` : "Hapus SEMUA data kuesioner dosen & karyawan?";
            if (!confirm(msg)) return;

            try {
                const queryParams = new URLSearchParams({
                    kategori: 'Dosen & Karyawan'
                });
                if (tahun) queryParams.append('tahun_akademik', tahun);

                const r = await fetch(`/admin/kuesioner-dosen/truncate?${queryParams.toString()}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    const selector = document.getElementById('kdFilterTahun');
                    if (selector) selector.value = '';
                    loadKuesionerTable('');
                } else {
                    showToast(res.message || 'Gagal menghapus data.', 'warning');
                }
            } catch (e) {
                console.error(e);
                showToast('Gagal mengosongkan data (Terjadi kesalahan sistem).', 'warning');
            }
        }

        // ================================================================
        // KUESIONER MAHASISWA — Panel Import + Table + Chart
        // ================================================================
        function loadKuesionerMahasiswaPanel() {
            currentTitle = 'Kuesioner Mahasiswa';
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;

            setTimeout(() => {
                content.innerHTML = `
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header Area -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col lg:flex-row justify-between items-center gap-8 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-user-graduate"></i></div>
                        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
                            <div class="flex items-center justify-center lg:justify-start gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Survei Kepuasan Mahasiswa</p>
                            </div>
                            <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">Kuesioner Mahasiswa</h2>
                            <p class="text-slate-500 text-sm mt-4 font-medium">Kelola data kepuasan mahasiswa melalui upload excel dan pantau visualisasi grafiknya.</p>
                        </div>
                        
                        <div class="flex flex-wrap justify-center gap-3 relative z-10">
                            <button onclick="toggleImportKM()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(79,70,229,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-file-excel"></i> Import Excel
                            </button>
                            <button onclick="openKMAddModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-plus"></i> Tambah Data
                            </button>
                            <button onclick="truncateKM()" class="bg-white border border-rose-100 text-rose-500 hover:bg-rose-50 text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-sm transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-trash-alt"></i> Kosongkan
                            </button>
                        </div>
                    </div>

                    <!-- Import Form -->
                    <div id="importKMContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
                            <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Import Data Mahasiswa via Excel</h3>
                            <button onclick="toggleImportKM()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest flex items-center gap-2"><i class="fas fa-times"></i> Batal</button>
                        </div>
                        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 mb-8">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-xs font-black text-indigo-700 mb-1 flex items-center gap-2"><i class="fas fa-info-circle"></i> Format Baru: Excel Pivoted (Horizontal)</h4>
                                    <p class="text-[10px] text-indigo-500 font-medium leading-relaxed">Aspek Penilaian berada di Baris Header (Kolom C ke kanan). Kriteria (SB, B, K, SK) berada di Baris 2 - 5.</p>
                                </div>
                                <span class="bg-indigo-100 text-indigo-700 text-[9px] font-black px-2 py-1 rounded">REKOMENDASI</span>
                            </div>
                            <div class="grid grid-cols-5 gap-2 text-center mb-3">
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100"><p class="text-[8px] font-black text-slate-500">Kolom A</p><p class="text-[9px] font-bold text-slate-400">Tahun</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100"><p class="text-[8px] font-black text-slate-500">Kolom B</p><p class="text-[9px] font-bold text-slate-800">Kriteria</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100 shadow-sm"><p class="text-[8px] font-black text-indigo-500">Kolom C</p><p class="text-[9px] font-bold text-indigo-700 italic">Aspek 1</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100 shadow-sm"><p class="text-[8px] font-black text-indigo-500">Kolom D</p><p class="text-[9px] font-bold text-indigo-700 italic">Aspek 2</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100 shadow-sm"><p class="text-[8px] font-black text-indigo-500">Kolom E</p><p class="text-[9px] font-bold text-indigo-700 italic">dst...</p></div>
                            </div>
                            <div class="flex items-center gap-4 text-[9px] text-slate-500 font-bold bg-white/50 p-2 rounded-xl border border-slate-100">
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-emerald-500"></i> Sangat Baik</span>
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-blue-500"></i> Baik</span>
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-orange-500"></i> Kurang</span>
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-rose-500"></i> Sangat Kurang</span>
                            </div>
                        </div>
                        <form id="importKMForm" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Tahun Akademik</label>
                                <input type="text" id="km_import_tahun" placeholder="Contoh: 2023/2024 (Otomatis jika dari Excel)"
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Program Studi</label>
                                <input type="text" id="km_import_prodi" placeholder="Contoh: D3 Mesin" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div class="flex-grow">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">File Excel (.xlsx / .xls)</label>
                                <input type="file" id="km_import_file" accept=".xlsx, .xls" required
                                    class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                            </div>
                            <div class="md:col-span-3">
                                <button type="button" onclick="submitImportKM()" id="importKMBtn" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all hover:shadow-2xl hover:-translate-y-0.5">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Jalankan Import Data Mahasiswa
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Filter Bar -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white shadow-sm p-4 mb-6 flex flex-wrap items-center gap-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Filter Tahun:</span>
                        <select onchange="loadKMTable(this.value)" id="kmFilterTahun" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 outline-none focus:border-indigo-500 min-w-[160px]">
                            <option value="">Semua Tahun</option>
                        </select>
                        <span class="ml-auto text-[10px] font-bold text-slate-400 uppercase tracking-widest" id="kmTotalCount">0 Data</span>
                    </div>

                    <!-- Data Table -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-5 border-b border-slate-100 w-16 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">No</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Tahun & Prodi</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Aspek Penilaian</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-emerald-500 tracking-[0.15em]">SB</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-blue-500 tracking-[0.15em]">B</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-orange-500 tracking-[0.15em]">K</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-rose-500 tracking-[0.15em]">SK</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-right w-36 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kmTableBody" class="divide-y divide-slate-50">
                                    <tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-10 border border-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] min-h-[450px] flex flex-col">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Visualisasi Data Mahasiswa</h3>
                                <p class="text-slate-800 font-bold text-lg" id="chartTitleStudent">Grafik Kepuasan Mahasiswa</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-inner border border-indigo-100"><i class="fas fa-graduation-cap"></i></div>
                        </div>
                        <div class="flex-grow flex items-center justify-center relative" style="min-height:350px">
                            <canvas id="kmLiveChart"></canvas>
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100 flex flex-wrap gap-4 justify-center">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(34,197,94,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Baik</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(59,130,246,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Baik</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(249,115,22,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kurang</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(239,68,68,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Kurang</span></div>
                        </div>
                    </div>
                </div>

                <!-- KM ADD/EDIT MODAL -->
                <div id="kmModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4" style="transition: opacity .3s ease;">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-transform duration-300" id="kmModalInner">
                        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <div>
                                <h3 class="font-black text-slate-800 text-xl font-display tracking-tight mb-1" id="kmModalTitle">Tambah Data</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kuesioner Mahasiswa</p>
                            </div>
                            <button onclick="closeKMModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
                        </div>
                        <div class="p-10 space-y-5">
                            <input type="hidden" id="km_edit_id">
                             <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Tahun Akademik</label>
                                    <input type="text" id="km_tahun" placeholder="2023/2024" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Program Studi</label>
                                    <input type="text" id="km_prodi" placeholder="Contoh: Teknik Informatika" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Aspek Penilaian</label>
                                <input type="text" id="km_program" placeholder="Contoh: Reliability" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <div>
                                    <label class="block text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-2 text-center">SB (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_ss" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-blue-500 uppercase tracking-widest mb-2 text-center">B (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_s" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-orange-500 uppercase tracking-widest mb-2 text-center">K (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_ts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-rose-500 uppercase tracking-widest mb-2 text-center">SK (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_sts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all">
                                </div>
                            </div>
                            <div class="flex justify-end gap-4 pt-4 border-t border-slate-100">
                                <button onclick="closeKMModal()" class="px-6 py-3.5 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                                <button onclick="submitKMForm()" id="kmSubmitBtn" class="px-6 py-3.5 bg-indigo-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(79,70,229,0.25)] hover:bg-indigo-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                content.style.opacity = 1;
                initKuesionerMahasiswaPanel();
            }, 300);
        }

        async function initKuesionerMahasiswaPanel() {
            try {
                const r = await fetch('/admin/kuesioner-dosen/data?kategori=Mahasiswa');
                const res = await r.json();
                if (!res.success) return;
                
                kuesionerDataStudent = res.data;
                const years = res.years;
                const selector = document.getElementById('kmFilterTahun');
                if (selector) {
                    selector.innerHTML = '<option value="">Semua Tahun</option>';
                    years.forEach(y => {
                        const opt = document.createElement('option');
                        opt.value = y; opt.textContent = y;
                        selector.appendChild(opt);
                    });
                }
                renderKMTable(kuesionerDataStudent);
                renderKMChart(kuesionerDataStudent);
            } catch(e) {
                showToast('Gagal memuat data kuesioner mahasiswa.', 'warning');
            }
        }

        async function loadKMTable(tahun = '') {
            try {
                const url = `/admin/kuesioner-dosen/data?kategori=Mahasiswa${tahun ? '&tahun_akademik='+encodeURIComponent(tahun) : ''}`;
                const r = await fetch(url);
                const res = await r.json();
                if (!res.success) return;
                kuesionerDataStudent = res.data;
                renderKMTable(kuesionerDataStudent);
                renderKMChart(kuesionerDataStudent);
            } catch(e) {
                showToast('Gagal memuat data.', 'warning');
            }
        }

        function renderKMTable(data) {
            const tbody = document.getElementById('kmTableBody');
            const countEl = document.getElementById('kmTotalCount');
            if (countEl) countEl.textContent = data.length + ' Data';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Belum ada data mahasiswa. Silakan import Excel atau tambah manual.</td></tr>';
                return;
            }

            tbody.innerHTML = data.map((item, idx) => `
                <tr class="hover:bg-indigo-50/30 transition-colors group">
                    <td class="px-6 py-5 text-center font-black text-slate-400 text-xs">${idx + 1}</td>
                    <td class="px-6 py-5 text-xs font-bold text-slate-600">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg border border-indigo-100 w-fit">
                                <i class="fas fa-calendar-alt text-[9px]"></i> ${item.tahun_akademik}
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-600 px-3 py-1 rounded-lg border border-slate-100 w-fit text-[9px]">
                                <i class="fas fa-university text-[8px]"></i> ${item.prodi || '-'}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm font-bold text-slate-800">${item.program}</td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-black px-2.5 py-1 rounded-lg border border-emerald-100">${item.sangat_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-blue-50 text-blue-700 text-xs font-black px-2.5 py-1 rounded-lg border border-blue-100">${item.setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-orange-50 text-orange-700 text-xs font-black px-2.5 py-1 rounded-lg border border-orange-100">${item.tidak_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-rose-50 text-rose-700 text-xs font-black px-2.5 py-1 rounded-lg border border-rose-100">${item.sangat_tidak_setuju}%</span></td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <button onclick="openKMEditModal(${item.id})" class="text-slate-400 hover:text-indigo-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Edit"><i class="fas fa-pen text-xs"></i></button>
                            <button onclick="deleteKMRow(${item.id})" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderKMChart(data) {
            const chartTitle = document.getElementById('chartTitleStudent');
            if (data.length === 0) {
                if (kuesionerChartStudent) kuesionerChartStudent.destroy();
                kuesionerChartStudent = null;
                if (chartTitle) chartTitle.textContent = 'Belum Ada Data';
                return;
            }

            const activeTahun = data[0].tahun_akademik;
            if (chartTitle) chartTitle.textContent = `Kepuasan Mahasiswa — T.A ${activeTahun}`;

            const labels = data.map(i => i.program.length > 20 ? i.program.substring(0, 20) + '...' : i.program);
            const datasets = [
                { label: 'Sangat Baik', data: data.map(i => i.sangat_setuju), backgroundColor: 'rgba(34, 197, 94, 0.85)', borderRadius: 6 },
                { label: 'Baik', data: data.map(i => i.setuju), backgroundColor: 'rgba(59, 130, 246, 0.85)', borderRadius: 6 },
                { label: 'Kurang', data: data.map(i => i.tidak_setuju), backgroundColor: 'rgba(249, 115, 22, 0.85)', borderRadius: 6 },
                { label: 'Sangat Kurang', data: data.map(i => i.sangat_tidak_setuju), backgroundColor: 'rgba(239, 68, 68, 0.85)', borderRadius: 6 }
            ];

            const ctx = document.getElementById('kmLiveChart');
            if (!ctx) return;
            if (kuesionerChartStudent) kuesionerChartStudent.destroy();
            kuesionerChartStudent = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, max: 100, ticks: { callback: v => v + '%' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        function openKMAddModal() {
            kuesionerEditIdStudent = null;
            if (document.getElementById('kmModalTitle')) document.getElementById('kmModalTitle').textContent = 'Tambah Data Kuesioner Mahasiswa';
            document.getElementById('km_edit_id').value = '';
            document.getElementById('km_tahun').value = '';
            document.getElementById('km_prodi').value = '';
            document.getElementById('km_program').value = '';
            document.getElementById('km_ss').value = '';
            document.getElementById('km_s').value = '';
            document.getElementById('km_ts').value = '';
            document.getElementById('km_sts').value = '';
            document.getElementById('kmModal').classList.remove('hidden');
        }

        function openKMEditModal(id) {
            const item = kuesionerDataStudent.find(d => d.id === id);
            if (!item) return;
            kuesionerEditIdStudent = id;
            document.getElementById('kmModalTitle').textContent = 'Edit Data Kuesioner Mahasiswa';
            document.getElementById('km_edit_id').value = id;
            document.getElementById('km_tahun').value = item.tahun_akademik;
            document.getElementById('km_prodi').value = item.prodi || '';
            document.getElementById('km_program').value = item.program;
            document.getElementById('km_ss').value = item.sangat_setuju;
            document.getElementById('km_s').value = item.setuju;
            document.getElementById('km_ts').value = item.tidak_setuju;
            document.getElementById('km_sts').value = item.sangat_tidak_setuju;
            document.getElementById('kmModal').classList.remove('hidden');
        }

        function closeKMModal() {
            document.getElementById('kmModal').classList.add('hidden');
            kuesionerEditIdStudent = null;
        }

        async function submitKMForm() {
            const payload = {
                tahun_akademik: document.getElementById('km_tahun').value,
                prodi: document.getElementById('km_prodi').value,
                program: document.getElementById('km_program').value,
                kategori: 'Mahasiswa',
                sangat_setuju: parseFloat(document.getElementById('km_ss').value) || 0,
                setuju: parseFloat(document.getElementById('km_s').value) || 0,
                tidak_setuju: parseFloat(document.getElementById('km_ts').value) || 0,
                sangat_tidak_setuju: parseFloat(document.getElementById('km_sts').value) || 0,
                cukup_setuju: 0
            };
            if (!payload.tahun_akademik || !payload.program) return showToast('Harap isi semua field utama.', 'warning');

            const isEdit = !!kuesionerEditIdStudent;
            const url = isEdit ? `/admin/kuesioner-dosen/${kuesionerEditIdStudent}/update` : '/admin/kuesioner-dosen/store';

            try {
                const r = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    closeKMModal();
                    loadKMTable(document.getElementById('kmFilterTahun').value);
                }
            } catch (e) { showToast('Gagal menyimpan data.', 'warning'); }
        }

        async function deleteKMRow(id) {
            if (!confirm('Hapus data ini?')) return;
            try {
                const r = await fetch(`/admin/kuesioner-dosen/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    loadKMTable(document.getElementById('kmFilterTahun').value);
                }
            } catch (e) { showToast('Gagal menghapus.', 'warning'); }
        }

        function toggleImportKM() {
            const container = document.getElementById('importKMContainer');
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                setTimeout(() => container.classList.remove('opacity-0', 'translate-y-4'), 10);
            } else {
                container.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => container.classList.add('hidden'), 300);
            }
        }

        async function submitImportKM() {
            const tahun = document.getElementById('km_import_tahun').value;
            const prodi = document.getElementById('km_import_prodi').value;
            const file = document.getElementById('km_import_file').files[0];
            if (!prodi || !file) return showToast('Lengkapi form import (Prodi, File).', 'warning');

            const btn = document.getElementById('importKMBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengimpor...';

            const fd = new FormData();
            fd.append('tahun_akademik', tahun);
            fd.append('prodi', prodi);
            fd.append('file', file);
            fd.append('kategori', 'Mahasiswa');
            fd.append('_token', '{{ csrf_token() }}');

            try {
                const r = await fetch('/admin/kuesioner-dosen/import', { method: 'POST', body: fd });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    toggleImportKM();
                    loadKMTable('');
                } else showToast(res.message, 'warning');
            } catch (e) { showToast('Terjadi kesalahan import.', 'warning'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-cloud-upload-alt mr-2"></i> Jalankan Import Data Mahasiswa';
            }
        }

        async function truncateKM() {
            const currentData = (typeof kuesionerDataStudent !== 'undefined') ? kuesionerDataStudent : [];
            const uniqueProdis = [...new Set(currentData.map(item => item.prodi).filter(Boolean))].sort();
            const uniqueYears = [...new Set(currentData.map(item => item.tahun_akademik).filter(Boolean))].sort();

            let prodiOptionsHtml = '<option value="all">Semua Program Studi</option>';
            uniqueProdis.forEach(p => {
                prodiOptionsHtml += `<option value="${p}">${p}</option>`;
            });

            let tahunOptionsHtml = '<option value="">Semua Tahun</option>';
            uniqueYears.forEach(y => {
                const isSelected = document.getElementById('kmFilterTahun')?.value === y ? 'selected' : '';
                tahunOptionsHtml += `<option value="${y}" ${isSelected}>${y}</option>`;
            });

            const { value: formValues } = await Swal.fire({
                title: 'Kosongkan Data Mahasiswa',
                html: `
                    <div class="mb-4">
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Program Studi:</label>
                        <select id="swal-prodi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            ${prodiOptionsHtml}
                        </select>
                    </div>
                    <div>
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Tahun Akademik:</label>
                        <select id="swal-tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            ${tahunOptionsHtml}
                        </select>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'KOSONGKAN',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-[2.5rem] p-10',
                    confirmButton: 'rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4 mr-2',
                    cancelButton: 'rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4'
                },
                preConfirm: () => {
                    return {
                        prodi: document.getElementById('swal-prodi').value,
                        tahun: document.getElementById('swal-tahun').value
                    }
                }
            });

            if (!formValues) return;

            const { prodi, tahun } = formValues;
            const prodiText = prodi !== 'all' ? `prodi "${prodi}"` : 'SEMUA prodi';
            const tahunText = tahun ? `tahun akademik "${tahun}"` : 'SEMUA tahun akademik';
            const msgConfirm = `Apakah Anda yakin ingin menghapus data kuesioner Mahasiswa untuk ${prodiText} di ${tahunText}?`;

            if (!confirm(msgConfirm)) return;

            try {
                const queryParams = new URLSearchParams({
                    kategori: 'Mahasiswa'
                });
                if (tahun) queryParams.append('tahun_akademik', tahun);
                if (prodi && prodi !== 'all') queryParams.append('prodi', prodi);

                const r = await fetch(`/admin/kuesioner-dosen/truncate?${queryParams.toString()}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    const selector = document.getElementById('kmFilterTahun');
                    if (selector) selector.value = '';
                    loadKMTable('');
                } else {
                    showToast(res.message || 'Gagal mengosongkan.', 'warning');
                }
            } catch (e) {
                console.error(e);
                showToast('Gagal mengosongkan data (Terjadi kesalahan sistem).', 'warning');
            }
        }

        // Keep backward compat for old sidebar calls
        function fetchKuesionerStats(tahun) { 
            if (currentTitle === 'Kuesioner Mahasiswa') loadKMTable(tahun || '');
            else loadKuesionerTable(tahun || '');
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
                        <!-- Source type selector -->
                        <div class="mb-4">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Sumber Video</label>
                            <div class="flex gap-3">
                                <button type="button" onclick="setVideoSource('file')" id="gvSrcFile" class="flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all">
                                    <i class="fas fa-upload mr-1"></i> Upload Lokal
                                </button>
                                <button type="button" onclick="setVideoSource('link')" id="gvSrcLink" class="flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all">
                                    <i class="fab fa-youtube mr-1"></i> Link YouTube/URL
                                </button>
                            </div>
                        </div>
                        <div id="gvFileSection" class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Upload Video (Lokal - Max 40MB)</label>
                            <input type="file" id="gv_file" accept="video/mp4,video/x-matroska,video/x-ms-wmv" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 transition-all">
                            <p class="text-[9px] text-slate-400 mt-2 italic font-bold">Format: MP4, MKV, WMV. Limit server: 40MB.</p>
                        </div>
                        <div id="gvLinkSection" class="mb-6 hidden">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link YouTube / URL Video</label>
                            <input type="text" id="gv_link" placeholder="https://www.youtube.com/watch?v=... atau URL video lain"
                                class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            <p class="text-[9px] text-slate-400 mt-2 italic font-bold">Masukkan link YouTube lengkap atau URL video publik.</p>
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
                    let isLocal = false;
                    if (d.link_youtube) {
                        const m = d.link_youtube.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/);
                        if (m) youtubeId = m[1];
                        else if (!d.link_youtube.startsWith('http')) isLocal = true;
                    }
                    const thumbHtml = youtubeId 
                        ? `<img src="https://img.youtube.com/vi/${youtubeId}/default.jpg" class="w-full h-full object-cover">`
                        : isLocal 
                            ? `<div class="w-full h-full flex items-center justify-center bg-slate-100"><i class="fas fa-film text-slate-400 text-lg"></i></div>`
                            : `<div class="w-full h-full flex items-center justify-center bg-slate-100"><i class="fas fa-video-slash text-slate-300 text-lg"></i></div>`;  

                    return `
                    <tr class="hover:bg-blue-50/10 border-b border-slate-50 transition-colors">
                        <td class="px-8 py-4 text-center text-[11px] font-black text-slate-400 uppercase">${String(i+1).padStart(2,'0')}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative w-12 h-8 rounded-lg overflow-hidden group/thumb cursor-pointer" 
                                     onclick="playDashboardVideo('${d.link_youtube || ''}', '${d.judul.replace(/'/g,"\\'")}')">
                                    ${thumbHtml}
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

        function setVideoSource(type) {
            const fileSection = document.getElementById('gvFileSection');
            const linkSection = document.getElementById('gvLinkSection');
            const btnFile = document.getElementById('gvSrcFile');
            const btnLink = document.getElementById('gvSrcLink');
            if (type === 'file') {
                fileSection.classList.remove('hidden');
                linkSection.classList.add('hidden');
                btnFile.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                btnLink.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            } else {
                fileSection.classList.add('hidden');
                linkSection.classList.remove('hidden');
                btnLink.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                btnFile.className = 'flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            }
        }

        function submitUploadVideo() {
            const judul = document.getElementById('gv_judul').value;
            const fileSectionVisible = !document.getElementById('gvFileSection').classList.contains('hidden');
            const file = document.getElementById('gv_file').files[0];
            const link = document.getElementById('gv_link').value.trim();
            const desc = document.getElementById('gv_deskripsi').value;
            if(!judul) return showToast('Judul video wajib diisi', 'warning');
            if(fileSectionVisible && !file) return showToast('File video wajib diunggah', 'warning');
            if(!fileSectionVisible && !link) return showToast('Link video wajib diisi', 'warning');

            const fd = new FormData();
            fd.append('judul', judul);
            fd.append('deskripsi', desc);
            if(fileSectionVisible && file) fd.append('video_file', file);
            if(!fileSectionVisible && link) fd.append('link_youtube', link);
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
            const evLink = document.getElementById('ev_link');
            if (evLink) evLink.value = link.trim();
            // Auto-detect source type
            const isLocal = link && !link.startsWith('http');
            const isYoutube = link && link.startsWith('http');
            setEditVideoSource(isLocal ? 'file' : (isYoutube ? 'link' : 'file'));
            if (isYoutube && evLink) evLink.value = link.trim();
            document.getElementById('editVideoModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editVideoModal').classList.remove('opacity-0');
                document.getElementById('editVideoModalBox').classList.remove('scale-95');
            }, 10);
        }

        function setEditVideoSource(type) {
            const fileSection = document.getElementById('evFileSection');
            const linkSection = document.getElementById('evLinkSection');
            const btnFile = document.getElementById('evSrcFile');
            const btnLink = document.getElementById('evSrcLink');
            if (!fileSection || !linkSection) return;
            if (type === 'file') {
                fileSection.classList.remove('hidden');
                linkSection.classList.add('hidden');
                if(btnFile) btnFile.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                if(btnLink) btnLink.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            } else {
                fileSection.classList.add('hidden');
                linkSection.classList.remove('hidden');
                if(btnLink) btnLink.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all';
                if(btnFile) btnFile.className = 'flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all';
            }
        }
        function closeEditVideoModal() {
            document.getElementById('editVideoModal').classList.add('opacity-0');
            document.getElementById('editVideoModalBox').classList.add('scale-95');
            setTimeout(() => document.getElementById('editVideoModal').classList.add('hidden'), 200);
        }
        function saveEditVideo() {
            const judul = document.getElementById('ev_judul').value;
            const desc = document.getElementById('ev_deskripsi').value;
            const fileSectionVisible = document.getElementById('evFileSection') && !document.getElementById('evFileSection').classList.contains('hidden');
            const file = document.getElementById('ev_file') ? document.getElementById('ev_file').files[0] : null;
            const link = document.getElementById('ev_link') ? document.getElementById('ev_link').value.trim() : '';
            if(!judul) return showToast('Judul video wajib diisi', 'warning');
            const fd = new FormData();
            fd.append('judul', judul);
            if(desc) fd.append('deskripsi', desc);
            if(fileSectionVisible && file) fd.append('video_file', file);
            if(!fileSectionVisible && link) fd.append('link_youtube', link);
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

        // ================================================================
        // KUESIONER — Manajemen Pertanyaan
        // ================================================================
        let currentKuesionerId = null;

        function openManageQuestions(id, name) {
            currentKuesionerId = id;
            document.getElementById('mq_kuesioner_name').innerText = name;
            
            fetchQuestions(id);
            
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('manageQuestionsModal');
            
            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.remove('scale-95', 'opacity-0');
                modal.style.opacity = '1';
            }, 10);
        }

        function closeManageQuestionsModal() {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('manageQuestionsModal');
            
            modal.classList.add('scale-95', 'opacity-0');
            modal.style.opacity = '0';
            overlay.classList.add('opacity-0', 'pointer-events-none');
            
            setTimeout(() => {
                overlay.classList.add('hidden');
                modal.classList.add('hidden');
            }, 300);
        }

        function fetchQuestions(kuesionerId) {
            const list = document.getElementById('mq_questions_list');
            list.innerHTML = `<tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold">Memuat pertanyaan...</td></tr>`;

            fetch(`/admin/kuesioner/${kuesionerId}/pertanyaan`)
                .then(r => r.json())
                .then(res => {
                    if (res.success && res.data.length > 0) {
                        list.innerHTML = "";
                        res.data.forEach(q => {
                            list.innerHTML += `
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-400">${q.urutan}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-700">${q.pertanyaan}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full ${q.tipe_jawaban == 'skala_likert' ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600'}">
                                            ${q.tipe_jawaban.replace('_', ' ')}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="deleteQuestion(${q.id})" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-all shadow-sm">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        list.innerHTML = `<tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold italic text-xs">Belum ada pertanyaan. Silakan tambahkan di atas.</td></tr>`;
                    }
                })
                .catch(err => {
                    showToast('Gagal memuat daftar pertanyaan.', 'warning');
                });
        }

        function submitAddQuestion() {
            const pertanyaan = document.getElementById('mq_pertanyaan').value;
            const tipe = document.getElementById('mq_tipe').value;
            const urutan = document.getElementById('mq_urutan').value;
            const opsi = document.getElementById('mq_opsi').value;

            if (!pertanyaan) {
                showToast('Teks pertanyaan wajib diisi.', 'warning');
                return;
            }

            fetch('/admin/kuesioner/pertanyaan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    kuesioner_id: currentKuesionerId,
                    pertanyaan: pertanyaan,
                    tipe_jawaban: tipe,
                    opsi_jawaban: opsi,
                    urutan: urutan
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    document.getElementById('mq_pertanyaan').value = "";
                    document.getElementById('mq_opsi').value = "";
                    fetchQuestions(currentKuesionerId);
                } else {
                    showToast(res.message, 'warning');
                }
            })
            .catch(err => {
                showToast('Gagal menambahkan pertanyaan.', 'warning');
            });
        }

        function deleteQuestion(id) {
            if (confirm("Hapus pertanyaan ini?")) {
                fetch(`/admin/kuesioner/pertanyaan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showToast(res.message, 'success');
                        fetchQuestions(currentKuesionerId);
                    }
                });
            }
        }

        document.getElementById('mq_tipe')?.addEventListener('change', function() {
            const container = document.getElementById('mq_opsi_container');
            if (this.value === 'pilihan_ganda') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        });
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
                <!-- Edit Source Selector -->
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Sumber Video</label>
                    <div class="flex gap-3 mb-4">
                        <button type="button" onclick="setEditVideoSource('file')" id="evSrcFile" class="flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all">
                            <i class="fas fa-upload mr-1"></i> Upload Lokal
                        </button>
                        <button type="button" onclick="setEditVideoSource('link')" id="evSrcLink" class="flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all">
                            <i class="fab fa-youtube mr-1"></i> Link YouTube/URL
                        </button>
                    </div>
                </div>
                <div id="evFileSection">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti File Video (Lokal - Max 40MB)</label>
                    <input type="file" id="ev_file" accept="video/mp4,video/x-matroska,video/x-ms-wmv" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                    <p class="text-[9px] text-slate-400 mt-1 font-bold italic">Biarkan kosong jika tidak ingin mengganti video.</p>
                </div>
                <div id="evLinkSection" class="hidden">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link YouTube / URL Video</label>
                    <input type="text" id="ev_link" placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
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
    <!-- MANAGE QUESTIONS MODAL -->
    <div id="manageQuestionsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="manageQuestionsModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-4xl overflow-hidden scale-95 transition-transform duration-200 flex flex-col max-h-[90vh]">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Kelola Pertanyaan Kuesioner</h3>
                    <p id="mq_kuesioner_name" class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">Nama Kuesioner</p>
                </div>
                <button onclick="closeManageQuestionsModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-10 overflow-y-auto custom-scrollbar flex-grow">
                <!-- Add Question Form -->
                <div class="mb-10 p-8 rounded-3xl border border-slate-200 bg-slate-50/50">
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-6">Tambah Pertanyaan Baru</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Pertanyaan</label>
                            <input type="text" id="mq_pertanyaan" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Jawaban</label>
                            <select id="mq_tipe" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-white cursor-pointer">
                                <option value="skala_likert">Skala Likert (1-5)</option>
                                <option value="teks">Jawaban Teks</option>
                                <option value="pilihan_ganda">Pilihan Ganda</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Urutan (Angka)</label>
                            <input type="number" id="mq_urutan" value="0" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-white">
                        </div>
                        <div id="mq_opsi_container" class="md:col-span-2 hidden">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Opsi Jawaban (Pisahkan dengan koma)</label>
                            <input type="text" id="mq_opsi" placeholder="Sangat Baik, Baik, Cukup, Kurang" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-white">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button onclick="submitAddQuestion()" class="bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest text-[10px] px-8 py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                            <i class="fas fa-plus mr-2"></i> Tambahkan Pertanyaan
                        </button>
                    </div>
                </div>

                <div class="mb-4 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Pertanyaan Aktif</h4>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest bg-emerald-50/10 mb-3 border-b-2 border-slate-100">Urutan</th>
                                <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest bg-emerald-50/10 mb-3 border-b-2 border-slate-100">Pertanyaan</th>
                                <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest bg-emerald-50/10 mb-3 border-b-2 border-slate-100">Tipe</th>
                                <th class="px-6 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest bg-emerald-50/10 mb-3 border-b-2 border-slate-100 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="mq_questions_list" class="divide-y divide-slate-100">
                            <!-- Questions will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>