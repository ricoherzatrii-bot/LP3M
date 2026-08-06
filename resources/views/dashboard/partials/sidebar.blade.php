 <aside id="mobileSidebar" class="fixed inset-y-0 left-0 z-[70] flex w-[85vw] max-w-[320px] -translate-x-full flex-col overflow-hidden border border-white/10 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 shadow-2xl transition-transform duration-300 ease-in-out md:static md:w-[280px] md:translate-x-0 md:rounded-3xl md:flex-shrink-0 lg:w-[320px]">
            
            <!-- Abstract Sidebar Background Glows -->
            <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-blue-600/20 to-transparent pointer-events-none"></div>
            <div class="absolute -left-20 top-20 w-40 h-40 bg-blue-500/20 rounded-full blur-[50px] pointer-events-none"></div>

            <!-- Brand -->
            <div class="px-8 py-8 flex items-center gap-3 border-b border-white/5 relative z-10">
                <div class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.3)] border border-blue-400/30 p-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 backdrop-blur-sm pointer-events-none"></div>
                    <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="LPM" class="h-full w-full object-contain relative z-10 drop-shadow-md" onerror="this.src='https://ui-avatars.com/api/?name=PJ&background=transparent&color=fff&bold=true'">
                </div>
                <div class="flex-1">
                    <h1 class="text-xl font-black tracking-tighter text-white leading-none font-display">Politeknik Jambi</h1>
                    <div class="mt-2">
                        <span class="text-[9px] font-bold text-white/90 uppercase tracking-[0.12em]">LP3M / Sistem Online</span>
                    </div>
                </div>
                <button onclick="closeMobileSidebar()" class="md:hidden flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/10 text-white transition hover:bg-white/20">
                    <i class="fas fa-times"></i>
                </button>
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
                    <button type="button" data-toggle-target="menuProfil" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-university text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Profil Kampus</span>
                        </div>
                        <i id="icon-menuProfil" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuProfil" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <button type="button" data-page="Visi Dan Misi" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-bullseye opacity-40 text-[10px] w-3"></i> <span>Visi Dan Misi</span></button>
                        <button type="button" data-page="Moto Dan Janji Layanan" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-handshake opacity-40 text-[10px] w-3"></i> <span>Moto Dan Janji Layanan</span></button>
                        <button type="button" data-page="Struktur Organisasi" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-sitemap opacity-40 text-[10px] w-3"></i> <span>Struktur Organisasi</span></button>
                        <button type="button" data-page="Job Deskripsi" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-user-tag opacity-40 text-[10px] w-3"></i> <span>Job Deskripsi</span></button>
                        <button type="button" data-page="Standar Waktu Pelayanan" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-clock opacity-40 text-[10px] w-3"></i> <span>Standar Waktu Pelayanan</span></button>
                        <button type="button" data-page="Artikel Ilmiah" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-newspaper opacity-40 text-[10px] w-3"></i> <span>Artikel / Berita</span></button>
                        <button type="button" data-page="Pengumuman" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-bullhorn opacity-40 text-[10px] w-3"></i> <span>📢 Pengumuman</span></button>
                    </div>
                </div>



                <!-- Modul Akreditasi -->
                <div class="mb-1">
                    <button type="button" data-toggle-target="menuAkreditasi" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-award text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Akreditasi</span>
                        </div>
                        <i id="icon-menuAkreditasi" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuAkreditasi" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <button type="button" data-page="Akreditasi" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-graduation-cap opacity-40 text-[10px] w-3 text-center"></i> <span>Akreditasi</span></button>
                        <button type="button" data-page="Dokumen Akreditasi" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-file-pdf opacity-40 text-[10px] w-3 text-center"></i> <span>Dokumen Akreditasi</span></button>
                    </div>
                </div>

                <!-- Modul Capaian -->
                <div class="mb-1">
                    <button type="button" data-toggle-target="menuCapaian" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-chart-line text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Capaian Kinerja</span>
                        </div>
                        <i id="icon-menuCapaian" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuCapaian" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <button type="button" data-page="Dokumen SPMI" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-folder opacity-40 text-[10px] w-3 text-center"></i> <span>Dokumen SPMI</span></button>
                        <button type="button" data-page="Renop" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-file-alt opacity-40 text-[10px] w-3"></i> <span>Renop</span></button>
                        <button type="button" onclick="loadRenstraPanel()" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-chart-bar opacity-40 text-[10px] w-3"></i> <span>Capaian Renstra</span></button>
                        <button type="button" data-page="Laporan AMI" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-file-invoice opacity-40 text-[10px] w-3 text-center"></i> <span>Laporan AMI</span></button>
                        <button type="button" data-page="RTM" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-handshake opacity-40 text-[10px] w-3 text-center"></i> <span>RTM</span></button>
                    </div>
                </div>

                <!-- Modul Slider -->
                <div class="mb-1">
                    <button type="button" onclick="loadSliderPanel()" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
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
                    <button type="button" data-toggle-target="menuKuesioner" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-clipboard-question text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Kuesioner</span>
                        </div>
                        <i id="icon-menuKuesioner" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuKuesioner" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <button type="button" data-page="Kuesioner Dosen & Karyawan" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-user-tie opacity-40 text-[10px] w-3 text-center"></i> <span>Kuesioner Dosen & Karyawan</span></button>
                        <button type="button" data-page="Kuesioner Mahasiswa" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-user-graduate opacity-40 text-[10px] w-3 text-center"></i> <span>Kuesioner Mahasiswa</span></button>
                    </div>
                </div>

                <!-- Modul Galeri -->
                <div class="mb-1">
                    <button type="button" data-toggle-target="menuGaleri" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-images text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Galeri Kampus</span>
                        </div>
                        <i id="icon-menuGaleri" class="fas fa-chevron-right text-[10px] opacity-40 group-hover:opacity-100 transition-all duration-300"></i>
                    </button>
                    <div id="menuGaleri" class="hidden overflow-hidden pl-4 pr-4 py-2 space-y-0.5 text-[12px] text-white border-l-2 border-white/40 ml-8 mt-1 mb-3">
                        <button type="button" data-page="Dokumentasi Foto" onclick="loadGaleriFotoPanel()" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-image opacity-40 text-[10px] w-3"></i> <span>Dokumentasi Foto</span></button>
                        <button type="button" data-page="Galeri Video" onclick="loadGaleriVideoPanel()" class="submenu-item w-full text-left py-2.5 px-3 flex items-center space-x-3 cursor-pointer"><i class="fas fa-video opacity-40 text-[10px] w-3"></i> <span>Galeri Video</span></button>
                    </div>
                </div>

                <!-- Modul Program Studi -->
                <div class="mb-1">
                    <button type="button" data-page="Program Studi" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-graduation-cap text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Program Studi</span>
                        </div>
                    </button>
                </div>

                <div class="mb-1">
                    <button type="button" data-page="Media Sosial" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-hashtag text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Media Sosial</span>
                        </div>
                    </button>
                </div>

                <div class="mb-1">
                    <button type="button" data-page="Logo Poljam" class="w-full sidebar-item flex items-center justify-between py-3.5 px-4 rounded-2xl text-white hover:bg-white/10 font-bold group">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center group-hover:bg-white/30 group-hover:text-white text-white transition-colors">
                                <i class="fas fa-image text-sm"></i>
                            </div>
                            <span class="text-[13px] font-semibold tracking-wide">Logo Poljam</span>
                        </div>
                    </button>
                </div>

            </nav>

            <!-- User Profile Bottom -->
            <div id="userProfileArea" class="p-6 mt-auto border-t border-white/5 bg-slate-900/50 backdrop-blur-md relative z-20">
                <div onclick="toggleProfileDropdown()" class="flex items-center gap-4 bg-white/5 p-3 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors cursor-pointer group">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=2563eb&color=fff&bold=true" class="w-10 h-10 rounded-xl shadow-lg" alt="{{ auth()->user()->name ?? 'Admin' }}">
                        <div class="flex-1">
                            <h2 class="text-sm font-bold text-white leading-tight">{{ auth()->user()->name ?? 'Super Admin' }}</h2>
                    <i class="fas fa-ellipsis-v text-slate-500 group-hover:text-white transition-colors p-2"></i>
                </div>
                
                <!-- Profile Dropdown -->
                <div id="profileDropdown" class="hidden absolute bottom-[90px] left-6 right-6 bg-slate-800 border border-white/10 rounded-2xl p-2 shadow-2xl animate-fade-in origin-bottom">
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                            <i class="fas fa-users w-4"></i> Manajemen Pengguna
                        </a>
                        <div class="h-px bg-white/10 my-1 mx-2"></div>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-sm font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-xl transition-colors">
                            <i class="fas fa-sign-out-alt w-4"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>