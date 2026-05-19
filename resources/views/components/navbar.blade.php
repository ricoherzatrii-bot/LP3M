<nav class="glass-nav sticky top-0 z-50 border-b border-slate-100 bg-white/90 backdrop-blur-md">
    <div class="w-full px-6 lg:px-16 py-5 flex justify-between items-center">
        
        <a href="{{ url('/') }}" class="flex items-center gap-4 group cursor-pointer">
            <div class="relative overflow-hidden rounded-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="flex flex-col">
                <span class="block text-lg font-black tracking-tighter text-slate-900 leading-none uppercase">LPM POLJAM</span>
                <span class="text-[9px] font-bold text-blue-700 uppercase tracking-widest leading-none">Internal Quality Assurance</span>
            </div>
        </a>

        <div class="hidden xl:flex items-center gap-8 text-[11px] font-bold uppercase tracking-widest text-slate-600">
            
            <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'text-blue-700 nav-link-active' : '' }} hover:text-blue-700 transition">Home</a>
            
            <div class="relative group py-2">
                <span class="flex items-center gap-1 hover:text-blue-700 transition cursor-pointer {{ Request::is('profil*') ? 'text-blue-700' : '' }}">
                    Profil <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        @if(isset($allProfil) && $allProfil->count() > 0)
                            @foreach($allProfil as $m)
                                @if($m->slug === 'artikel')
                                    <a href="{{ route('artikel.index') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">
                                        {{ $m->judul }}
                                    </a>
                                @else
                                    <a href="{{ route('profil.show', $m->slug) }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">
                                        {{ $m->judul }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="relative group py-2">
                <span class="flex items-center gap-1 hover:text-blue-700 transition cursor-pointer {{ Request::is('spmi*') ? 'text-blue-700' : '' }}">
                    SPMI <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                <div class="absolute top-full left-0 w-56 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        <a href="{{ url('/spmi/dokumen-spmi') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Dokumen SPMI</a>
                        <a href="{{ url('/spmi/unit') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Unit</a>
                        <a href="{{ url('/spmi/rtm') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">RTM</a>
                        <a href="{{ url('/spmi/dokumen-mutu-spmi') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Dokumen Mutu SPMI</a>
                        <a href="https://e-spmi.politeknikjambi.ac.id" target="_blank" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-blue-600 font-semibold transition flex justify-between items-center">
                            e-spmiPoljam <i class="fas fa-external-link-alt text-[9px] opacity-50"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="relative group py-2">
                <span class="flex items-center gap-1 hover:text-blue-700 transition cursor-pointer {{ Request::is('akreditasi*') ? 'text-blue-700' : '' }}">
                    Akreditasi <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                <div class="absolute top-full left-0 w-60 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        <a href="{{ route('akreditasi.index') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition flex justify-between items-center group/item">
                            <span>Data Akreditasi</span>
                            <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('akreditasi.dokumen') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition flex justify-between items-center group/item">
                            <span>Dokumen Pendukung</span>
                            <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="relative group py-2">
                <span class="flex items-center gap-1 hover:text-blue-700 transition cursor-pointer {{ Request::is('capaian*') ? 'text-blue-700' : '' }}">
                    Capaian <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        <a href="{{ url('/capaian/renop') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Renop</a>
                        <a href="{{ url('/capaian/capaian-renstra') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Capaian Renstra</a>
                        
                        <!-- Kepuasan Mahasiswa dengan Sub-Menu -->
                        <div class="relative group/sub">
                            <a href="{{ url('/capaian/kepuasan-mahasiswa') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-blue-600 font-semibold transition flex justify-between items-center">
                                <span>Kepuasan Mahasiswa</span>
                                <i class="fas fa-chevron-right text-[8px] opacity-40"></i>
                            </a>
                            <!-- Sub-Menu -->
                            <div class="absolute top-0 left-full ml-1 w-52 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-300 z-50 overflow-hidden">
                                <div class="p-2 flex flex-col">
                                    <a href="{{ url('/capaian/kepuasan-mahasiswa-poljam-2020-2021') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Poljam 2020/2021</a>
                                    <a href="{{ url('/capaian/kepuasan-mahasiswa-prodi-2020-2021') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Prodi 2020/2021</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('/capaian/kepuasan-dosen-dan-tendik') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Kepuasan Dosen Dan Tendik</a>
                    </div>
                </div>
            </div>

            <div class="relative group py-2">
                <span class="flex items-center gap-1 hover:text-blue-700 transition cursor-pointer {{ Request::is('kuesioner*') ? 'text-blue-700' : '' }}">
                    Kuesioner <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                <div class="absolute top-full left-0 w-60 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        <a href="{{ route('kuesioner.dosen') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">
                            Kuesioner Dosen & Karyawan
                        </a>
                        <a href="{{ route('kuesioner.mahasiswa') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">
                            Kuesioner Mahasiswa
                        </a>
                    </div>
                </div>
            </div>

            <div class="relative group py-2 border-l pl-8 border-slate-200">
                <span class="flex items-center gap-1 hover:text-blue-700 transition cursor-pointer {{ Request::is('galeri*') ? 'text-blue-700' : '' }}">
                    Galeri <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                <div class="absolute top-full left-0 w-52 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        <a href="{{ route('gallery.index') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case flex justify-between items-center group/item {{ Request::is('galeri') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <span>Foto Kegiatan</span>
                            <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('gallery.video') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case flex justify-between items-center group/item {{ Request::is('galeri/video') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <span>Video</span>
                            <i class="fas fa-chevron-right text-[8px] opacity-30 group-hover/item:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ url('/login') }}" class="bg-blue-600 text-white px-7 py-3 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-200 active:scale-95">LOGIN PORTAL</a>
        </div>
    </div>
</nav>