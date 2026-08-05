<div class="sticky top-0 z-50">
    <!-- TOP BAR -->
    <div class="bg-[#0056b3] border-b border-white/10 hidden lg:block relative z-[60]">
        <div class="w-full px-6 lg:px-16 py-2.5 flex justify-between items-center">
            <!-- Contact Info -->
            <div class="flex items-center gap-8 text-[9px] font-black text-white/90 tracking-widest uppercase">
                <a href="{{ optional($socialLinks->get('email'))->url ?? 'mailto:lpm@politeknikjambi.ac.id' }}" class="flex items-center gap-2.5 hover:text-white transition-colors group">
                    <i class="fas fa-envelope text-yellow-400 group-hover:scale-110 transition-transform"></i> 
                    <span>{{ preg_replace('/^mailto:/', '', optional($socialLinks->get('email'))->url ?? 'lpm@politeknikjambi.ac.id') }}</span>
                </a>
                <a href="{{ optional($socialLinks->get('phone'))->url ?? 'tel:+62741123456' }}" class="flex items-center gap-2.5 hover:text-white transition-colors group">
                    <i class="fas fa-phone text-yellow-400 group-hover:scale-110 transition-transform"></i> 
                    <span>{{ preg_replace('/^tel:/', '', optional($socialLinks->get('phone'))->url ?? '+62 741 123 456') }}</span>
                </a>
            </div>

            <!-- Right: Social & Language -->
            <div class="flex items-center justify-end gap-5 flex-none">
                <div class="flex items-center gap-5 text-white/60 text-xs">
                    <a href="{{ optional($socialLinks->get('instagram'))->url ?? 'https://www.instagram.com/politeknikjambi?igsh=MW1scnJubzYxbXI1OA==' }}" target="_blank" class="hover:text-yellow-400 transition-all hover:scale-125"><i class="fab fa-instagram"></i></a>
                    <a href="{{ optional($socialLinks->get('tiktok'))->url ?? 'https://www.tiktok.com/@politeknikjambi?_r=1&_t=ZS-97xqcpSv8SK' }}" target="_blank" class="hover:text-yellow-400 transition-all hover:scale-125"><i class="fab fa-tiktok"></i></a>
                    <a href="{{ optional($socialLinks->get('youtube'))->url ?? 'https://youtube.com/@poltekjambi?si=gP6jTcGudVbPtwB1' }}" target="_blank" class="hover:text-yellow-400 transition-all hover:scale-125"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="h-4 w-[1px] bg-white/20"></div>
                <div class="flex items-center gap-6 text-[9px] font-black tracking-[0.2em] text-white">
                    <button type="button" class="theme-toggle-btn w-12 h-12 text-white hover:text-yellow-400 transition-all flex items-center justify-center active:scale-95 group" title="Toggle Mode">
                        <i class="theme-toggle-dark-icon hidden fas fa-moon text-lg transition-transform group-hover:-rotate-12"></i>
                        <i class="theme-toggle-light-icon hidden fas fa-sun text-lg transition-transform group-hover:rotate-45"></i>
                    </button>
                    <a href="javascript:void(0);" onclick="changeLanguage('ind')" class="flex items-center gap-2 hover:text-yellow-400 transition-all group">
                        IND <img src="https://flagcdn.com/w20/id.png" class="w-4 h-auto rounded-sm shadow-sm group-hover:scale-110 transition-transform" alt="IND">
                    </a>
                   <a href="javascript:void(0);" onclick="changeLanguage('en')" class="flex items-center gap-2 opacity-50 hover:opacity-100 hover:text-yellow-400 transition-all group">
                        EN <img src="https://flagcdn.com/w20/us.png" class="w-3.5 h-auto rounded-sm group-hover:scale-110 transition-transform" alt="EN">
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="sticky top-0 z-50 bg-[#0056b3] shadow-md border-b border-[#004494]">
        <div class="w-full px-4 sm:px-6 lg:px-16 py-3 lg:py-4 flex items-center justify-between gap-3 xl:hidden">
            <a href="{{ url('/') }}" class="flex items-center gap-3.5 min-w-0 group">
                <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="Logo" class="h-12 w-auto transition-transform duration-500 group-hover:scale-105">
                <div class="flex flex-col justify-center text-left min-w-0">
                    <span class="block text-white font-extrabold text-xl leading-tight tracking-wide select-none">Politeknik Jambi</span>
                    <span class="block text-white/90 text-[10px] font-black uppercase tracking-[0.2em] leading-tight select-none">
                        LEMBAGA PERENCANAAN PENGEMBANGAN<br>& PENJAMINAN MUTU
                    </span>
                </div>
            </a>
            <div class="flex items-center gap-2">
                @guest
                @endguest
                <button type="button" id="mobile-search-toggle" class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white" aria-label="Cari">
                    <i id="mobile-search-icon" class="fas fa-search"></i>
                </button>
                <button type="button" class="theme-toggle-btn w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white" title="Toggle Mode">
                    <i class="theme-toggle-dark-icon hidden fas fa-moon text-base transition-transform group-hover:-rotate-12"></i>
                    <i class="theme-toggle-light-icon hidden fas fa-sun text-base transition-transform group-hover:rotate-45"></i>
                </button>
                <button type="button" id="mobile-menu-toggle" class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white" aria-label="Buka menu">
                    <i id="mobile-menu-icon" class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <div id="mobile-search-panel" class="hidden border-t border-white/10 bg-[#0056b3] px-4 sm:px-6 py-3 xl:hidden">
            <form action="{{ route('search') }}" method="GET" class="flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-3 py-2 shadow-sm backdrop-blur-sm">
                <i class="fas fa-search text-white/80"></i>
                <input type="text" name="q" placeholder="Cari informasi..." autocomplete="off" class="w-full bg-transparent text-sm text-white placeholder-white/70 outline-none" required>
                <button type="submit" class="rounded-xl bg-white/15 px-3 py-1.5 text-sm font-semibold text-white">Cari</button>
            </form>
        </div>

        <div id="mobile-menu-panel" class="hidden border-t border-white/10 bg-[#0056b3] xl:hidden">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 py-4">
                <div class="rounded-[1.5rem] border border-white/10 bg-white/10 p-2 shadow-[0_20px_50px_rgba(0,0,0,0.18)] backdrop-blur-md">
                    <div class="mb-2 rounded-xl border border-white/10 bg-white/10 px-3 py-2 text-[10px] font-black uppercase tracking-[0.25em] text-white/80">
                        Menu Utama
                    </div>
                    <div class="space-y-2">
                        <a href="{{ url('/') }}" class="flex items-center justify-between rounded-xl border border-white/10 bg-[#0b4f9b]/50 px-3 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white shadow-sm hover:bg-white/10 {{ Request::is('/') ? 'bg-white/15 text-yellow-400' : '' }}">
                            <span>Home</span><i class="fas fa-home"></i>
                        </a>

                        <div>
                            <button type="button" data-mobile-section="mobile-profil" class="w-full flex items-center justify-between rounded-xl border border-white/10 bg-[#0b4f9b]/40 px-3 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white hover:bg-white/10">
                                <span>Profil</span><i class="fas fa-chevron-down text-[10px]"></i>
                            </button>
                            <div id="mobile-profil" class="hidden mt-2 space-y-2 rounded-xl bg-white/10 p-2">
                                @if(isset($allProfil) && count($allProfil) > 0)
                                    @foreach($allProfil as $m)
                                        @if($m->slug === 'artikel')
                                            <a href="{{ route('artikel.index') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">{{ $m->judul }}</a>
                                        @else
                                            <a href="{{ route('profil.show', $m->slug) }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">{{ $m->judul }}</a>
                                        @endif
                                    @endforeach
                                @endif
                                <a href="{{ route('pengumuman.index') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Pengumuman</a>
                            </div>
                        </div>

                        <div>
                            <button type="button" data-mobile-section="mobile-akreditasi" class="w-full flex items-center justify-between rounded-xl border border-white/10 bg-[#0b4f9b]/40 px-3 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white hover:bg-white/10">
                                <span>Akreditasi</span><i class="fas fa-chevron-down text-[10px]"></i>
                            </button>
                            <div id="mobile-akreditasi" class="hidden mt-2 space-y-2 rounded-xl bg-white/10 p-2">
                                <a href="{{ route('akreditasi.index') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Data Akreditasi</a>
                                <a href="{{ route('akreditasi.dokumen') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Dokumen Pendukung</a>
                            </div>
                        </div>

                        <div>
                            <button type="button" data-mobile-section="mobile-capaian" class="w-full flex items-center justify-between rounded-xl border border-white/10 bg-[#0b4f9b]/40 px-3 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white hover:bg-white/10">
                                <span>Capaian</span><i class="fas fa-chevron-down text-[10px]"></i>
                            </button>
                            <div id="mobile-capaian" class="hidden mt-2 space-y-2 rounded-xl bg-white/10 p-2">
                                <a href="{{ url('/capaian/renop') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Renop</a>
                                <a href="{{ route('renstra.publicIndex') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Capaian Renstra</a>
                                <a href="{{ route('capaian.laporan_ami') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Laporan AMI</a>
                                <a href="{{ route('capaian.rtm') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">RTM</a>
                            </div>
                        </div>

                        <a href="{{ url('/spmi/dokumen-spmi') }}" class="flex items-center justify-between rounded-xl border border-white/10 bg-[#0b4f9b]/40 px-3 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white hover:bg-white/10">
                            <span>SPMI</span><i class="fas fa-file-alt"></i>
                        </a>

                        <div>
                            <button type="button" data-mobile-section="mobile-kuesioner" class="w-full flex items-center justify-between rounded-xl border border-white/10 bg-[#0b4f9b]/40 px-3 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white hover:bg-white/10">
                                <span>Kuesioner</span><i class="fas fa-chevron-down text-[10px]"></i>
                            </button>
                            <div id="mobile-kuesioner" class="hidden mt-2 space-y-2 rounded-xl bg-white/10 p-2">
                                <a href="{{ route('kuesioner.dosen') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Dosen & Karyawan</a>
                                <a href="{{ route('kuesioner.mahasiswa') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Mahasiswa</a>
                            </div>
                        </div>

                        <div>
                            <button type="button" data-mobile-section="mobile-galeri" class="w-full flex items-center justify-between rounded-xl border border-white/10 bg-[#0b4f9b]/40 px-3 py-3 text-sm font-bold uppercase tracking-[0.2em] text-white hover:bg-white/10">
                                <span>Galeri</span><i class="fas fa-chevron-down text-[10px]"></i>
                            </button>
                            <div id="mobile-galeri" class="hidden mt-2 space-y-2 rounded-xl bg-white/10 p-2">
                                <a href="{{ route('gallery.index') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Foto Kegiatan</a>
                                <a href="{{ route('gallery.video') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 hover:bg-white/10">Video</a>
                            </div>
                        </div>
                        @guest
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden xl:flex w-full px-6 lg:px-16 py-4 justify-between items-center">
            
            <a href="{{ url('/') }}" class="flex items-center gap-3.5 group cursor-pointer">
                <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="Logo" class="h-14 w-auto group-hover:scale-110 transition-transform duration-500">
                <div class="flex flex-col justify-center text-left">
                    <span class="text-white font-extrabold text-xl leading-[1.1] tracking-wide select-none group-hover:scale-105 transition-transform duration-500 origin-left">
                        Politeknik Jambi
                    </span>
                    <div class="h-[1.5px] bg-white/40 my-0.5 w-full opacity-80"></div>
                    <span class="text-white/90 text-[9.3px] font-bold italic leading-none uppercase tracking-wider select-none">
                        Lembaga Perencanaan Pengembangan
                    </span>
                    <span class="text-white/90 text-[9.3px] font-bold italic leading-[1.3] uppercase tracking-wider select-none">
                        & Penjaminan Mutu
                    </span>
                </div>
            </a>

            <div class="hidden xl:flex items-center justify-end flex-1 gap-10 text-[11px] font-extrabold uppercase tracking-[0.15em] text-white">
                
                <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'text-yellow-400' : '' }} hover:text-yellow-400 transition-all duration-300"><i class="fas fa-home"></i></a>
                
                <div class="relative group py-2">
                    <span class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer {{ Request::is('profil*') ? 'text-yellow-400' : '' }}">
                        PROFIL <i class="fas fa-chevron-down text-[8px] opacity-50 group-hover:rotate-180 transition-transform duration-300"></i>
                    </span>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-64 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.2)] rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 transform translate-y-4 z-50 overflow-hidden">
                        <div class="p-3 flex flex-col">
                            @if(isset($allProfil) && count($allProfil) > 0)
                                @foreach($allProfil as $m)
                                    @if($m->slug === 'artikel')
                                        <a href="{{ route('artikel.index') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex items-center justify-between">
                                            {{ $m->judul }}
                                            <i class="fas fa-chevron-right text-[8px] opacity-0 group-hover/item:opacity-100 transition-all"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('profil.show', $m->slug) }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex items-center justify-between">
                                            {{ $m->judul }}
                                            <i class="fas fa-chevron-right text-[8px] opacity-0 group-hover/item:opacity-100 transition-all"></i>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                            <a href="{{ route('pengumuman.index') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex items-center justify-between {{ Request::is('pengumuman*') ? 'bg-blue-50 text-blue-700' : '' }}">
                                <span>📢 Pengumuman</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-0 group-hover/item:opacity-100 transition-all"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative group py-2">
                    <span class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer {{ Request::is('akreditasi*') ? 'text-yellow-400' : '' }}">
                        AKREDITASI <i class="fas fa-chevron-down text-[8px] opacity-50 group-hover:rotate-180 transition-transform duration-300"></i>
                    </span>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-64 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.2)] rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 transform translate-y-4 z-50 overflow-hidden">
                        <div class="p-3 flex flex-col">
                            <a href="{{ route('akreditasi.index') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 flex justify-between items-center group/item">
                                <span class="normal-case">Data Akreditasi</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('akreditasi.dokumen') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 flex justify-between items-center group/item">
                                <span class="normal-case">Dokumen Pendukung</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative group py-2">
                    <span class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer {{ Request::is('capaian*') ? 'text-yellow-400' : '' }}">
                        CAPAIAN <i class="fas fa-chevron-down text-[8px] opacity-50 group-hover:rotate-180 transition-transform duration-300"></i>
                    </span>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-72 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.2)] rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 transform translate-y-4 z-50 overflow-hidden">
                        <div class="p-3 flex flex-col">
                            <a href="{{ url('/capaian/renop') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex justify-between items-center group/item">
                                <span>Renop</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('renstra.publicIndex') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex justify-between items-center group/item">
                                <span>Capaian Renstra</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('capaian.laporan_ami') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex justify-between items-center group/item">
                                <span>Laporan AMI</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('capaian.rtm') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex justify-between items-center group/item">
                                <span>RTM</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/spmi/dokumen-spmi') }}" class="{{ Request::is('spmi/dokumen-spmi*') ? 'text-yellow-400' : '' }} hover:text-yellow-400 transition-all duration-300">SPMI</a>

                <div class="relative group py-2">
                    <span class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer {{ Request::is('kuesioner*') ? 'text-yellow-400' : '' }}">
                        KUESIONER <i class="fas fa-chevron-down text-[8px] opacity-50 group-hover:rotate-180 transition-transform duration-300"></i>
                    </span>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-72 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.2)] rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 transform translate-y-4 z-50 overflow-hidden">
                        <div class="p-3 flex flex-col">
                            <a href="{{ route('kuesioner.dosen') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case">
                                Kuesioner Dosen & Karyawan
                            </a>
                            <a href="{{ route('kuesioner.mahasiswa') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case">
                                Kuesioner Mahasiswa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- VERTICAL SEPARATOR -->
                

                <div class="relative group py-2">
                    <span class="flex items-center gap-2 hover:text-yellow-400 transition cursor-pointer {{ Request::is('galeri*') ? 'text-yellow-400' : '' }}">
                        GALERI <i class="fas fa-chevron-down text-[8px] opacity-50 group-hover:rotate-180 transition-transform duration-300"></i>
                    </span>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 w-60 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.2)] rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 transform translate-y-4 z-50 overflow-hidden">
                        <div class="p-3 flex flex-col">
                            <a href="{{ route('gallery.index') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex justify-between items-center group/item {{ Request::is('galeri') ? 'bg-blue-50 text-blue-700' : '' }}">
                                <span>Foto Kegiatan</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('gallery.video') }}" class="px-5 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl text-slate-700 font-bold transition-all duration-300 normal-case flex justify-between items-center group/item {{ Request::is('galeri/video') ? 'bg-blue-50 text-blue-700' : '' }}">
                                <span>Video</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- RIGHT ICONS -->
                <div class="flex items-center ">
                    <form action="{{ route('search') }}" method="GET" id="search-form" class="flex items-center">
                        <div id="search-container" class="flex items-center overflow-hidden transition-all duration-500 w-0 opacity-0">
                            <input type="text" name="q" id="search-input" placeholder="Cari..." 
                                class="bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-4 py-1.5 text-white placeholder-white/50 text-[10px] focus:outline-none focus:ring-1 focus:ring-yellow-400 w-40">
                        </div>
                        <button type="button" id="search-toggle" class="w-10 h-10 text-white hover:text-yellow-400 transition-all flex items-center justify-center active:scale-90 group">
                            <i class="fas fa-search text-base transition-transform group-hover:scale-110"></i>
                        </button>
                    </form>



                
                    @guest
                        <!-- Login link removed as requested -->
                    @endguest
                </div>

                <script>
                    // Theme Toggle Logic
                    const themeToggleBtns = document.querySelectorAll('.theme-toggle-btn');
                    const darkIcons = document.querySelectorAll('.theme-toggle-dark-icon');
                    const lightIcons = document.querySelectorAll('.theme-toggle-light-icon');

                    const setThemeIcons = () => {
                        const isDark = document.documentElement.classList.contains('dark');
                        darkIcons.forEach(icon => icon.classList.toggle('hidden', isDark));
                        lightIcons.forEach(icon => icon.classList.toggle('hidden', !isDark));
                    };

                    setThemeIcons();

                    themeToggleBtns.forEach(button => {
                        button.addEventListener('click', function() {
                            const isDark = document.documentElement.classList.contains('dark');
                            if (isDark) {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('theme', 'light');
                            } else {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('theme', 'dark');
                            }
                            setThemeIcons();
                        });
                    });

                    document.addEventListener('DOMContentLoaded', function() {
                        const searchToggle = document.getElementById('search-toggle');
                        const searchContainer = document.getElementById('search-container');
                        const searchInput = document.getElementById('search-input');
                        const searchIcon = searchToggle.querySelector('i');

                        searchToggle.addEventListener('click', function() {
                            const isExpanded = searchContainer.classList.contains('w-56');
                            if (isExpanded) {
                                searchContainer.classList.remove('w-56', 'opacity-100', 'mr-4');
                                searchContainer.classList.add('w-0', 'opacity-0');
                                searchIcon.classList.replace('fa-times', 'fa-search');
                                searchIcon.classList.remove('text-yellow-400');
                            } else {
                                searchContainer.classList.remove('w-0', 'opacity-0');
                                searchContainer.classList.add('w-56', 'opacity-100', 'mr-4');
                                searchIcon.classList.replace('fa-search', 'fa-times');
                                searchIcon.classList.add('text-yellow-400');
                                setTimeout(() => searchInput.focus(), 300);
                            }
                        });

                        // Close on Escape
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' && searchContainer.classList.contains('w-56')) {
                                searchToggle.click();
                            }
                        });
                    });
                </script>

                <!-- Google Translate Integration -->
                <script type="text/javascript">
                    if (typeof googleTranslateElementInit === 'undefined') {
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'id', includedLanguages: 'en,id', autoDisplay: false}, 'google_translate_element');
                        }
                    }
                    if (typeof changeLanguage === 'undefined') {
                        function changeLanguage(lang) {
                            var selectField = document.querySelector(".goog-te-combo");
                            if(selectField) {
                                selectField.value = lang;
                                selectField.dispatchEvent(new Event('change'));
                            }
                        }
                    }
                </script>
                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                <div id="google_translate_element" style="display:none;"></div>

            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('mobile-menu-toggle');
            const panel = document.getElementById('mobile-menu-panel');
            const icon = document.getElementById('mobile-menu-icon');
            const searchToggle = document.getElementById('mobile-search-toggle');
            const searchPanel = document.getElementById('mobile-search-panel');
            const searchIcon = document.getElementById('mobile-search-icon');
            const searchInput = searchPanel ? searchPanel.querySelector('input') : null;

            if (toggle && panel) {
                toggle.addEventListener('click', function () {
                    const isOpen = !panel.classList.contains('hidden');
                    panel.classList.toggle('hidden', isOpen);
                    panel.classList.toggle('block', !isOpen);
                    if (icon) {
                        icon.classList.toggle('fa-bars', isOpen);
                        icon.classList.toggle('fa-times', !isOpen);
                    }
                    if (!isOpen && searchPanel) {
                        searchPanel.classList.add('hidden');
                        if (searchIcon) {
                            searchIcon.classList.remove('fa-times');
                            searchIcon.classList.add('fa-search');
                        }
                    }
                });
            }

            if (searchToggle && searchPanel) {
                searchToggle.addEventListener('click', function () {
                    const isOpen = searchPanel.classList.contains('hidden');
                    searchPanel.classList.toggle('hidden', !isOpen);
                    if (searchIcon) {
                        searchIcon.classList.toggle('fa-search', !isOpen);
                        searchIcon.classList.toggle('fa-times', isOpen);
                    }
                    if (isOpen && searchInput) {
                        setTimeout(function () {
                            searchInput.focus();
                        }, 100);
                    }
                    if (panel && !panel.classList.contains('hidden')) {
                        panel.classList.add('hidden');
                        panel.classList.remove('block');
                        if (icon) {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
            }

            document.querySelectorAll('[data-mobile-section]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const targetId = button.getAttribute('data-mobile-section');
                    const target = document.getElementById(targetId);
                    if (!target) return;

                    const shouldOpen = target.classList.contains('hidden');
                    document.querySelectorAll('[data-mobile-section]').forEach(function (otherButton) {
                        const otherTarget = document.getElementById(otherButton.getAttribute('data-mobile-section'));
                        if (otherTarget && otherTarget !== target) {
                            otherTarget.classList.add('hidden');
                            otherTarget.classList.remove('block');
                        }
                    });

                    target.classList.toggle('hidden', !shouldOpen);
                    target.classList.toggle('block', shouldOpen);
                });
            });
        });
    </script>
</div>