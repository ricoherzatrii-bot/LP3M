<nav class="sticky top-0 z-50 bg-[#0056b3] shadow-md border-b border-[#004494]">
    <div class="w-full px-6 lg:px-16 py-5 flex justify-between items-center">
        
        <a href="{{ url('/') }}" class="flex items-center gap-4 group cursor-pointer">
            <div class="relative overflow-hidden rounded-lg bg-white p-1">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="flex flex-col">
                <span class="block text-lg font-black tracking-tighter text-white leading-none uppercase">LPM POLJAM</span>
                <span class="text-[9px] font-bold text-yellow-400 uppercase tracking-widest leading-none">Internal Quality Assurance</span>
            </div>
        </a>

        <div class="hidden xl:flex items-center gap-8 text-[11px] font-bold uppercase tracking-widest text-white">
            
            <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'text-yellow-400 nav-link-active' : '' }} hover:text-yellow-400 transition">Home</a>
            
            <div class="relative group py-2">
                <span class="flex items-center gap-1 hover:text-yellow-400 transition cursor-pointer {{ Request::is('profil*') ? 'text-yellow-400' : '' }}">
                    Profil <i class="fas fa-chevron-down text-[8px] opacity-60"></i>
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
                <span class="flex items-center gap-1 hover:text-yellow-400 transition cursor-pointer {{ Request::is('akreditasi*') ? 'text-yellow-400' : '' }}">
                    Akreditasi <i class="fas fa-chevron-down text-[8px] opacity-60"></i>
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
                <span class="flex items-center gap-1 hover:text-yellow-400 transition cursor-pointer {{ Request::is('capaian*') ? 'text-yellow-400' : '' }}">
                    Capaian <i class="fas fa-chevron-down text-[8px] opacity-60"></i>
                </span>
                <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        <a href="{{ url('/spmi/dokumen-spmi') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Dokumen SPMI</a>
                        <a href="{{ url('/capaian/renop') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Renop</a>
                        <a href="{{ route('renstra.publicIndex') }}" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">Capaian Renstra</a>
                        
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
                <span class="flex items-center gap-1 hover:text-yellow-400 transition cursor-pointer {{ Request::is('kuesioner*') ? 'text-yellow-400' : '' }}">
                    Kuesioner <i class="fas fa-chevron-down text-[8px] opacity-60"></i>
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

            <div class="relative group py-2 border-l pl-8 border-white/20">
                <span class="flex items-center gap-1 hover:text-yellow-400 transition cursor-pointer {{ Request::is('galeri*') ? 'text-yellow-400' : '' }}">
                    Galeri <i class="fas fa-chevron-down text-[8px] opacity-60"></i>
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

            <!-- SEARCH BAR -->
            <div class="relative flex items-center">
                <form action="{{ route('search') }}" method="GET" id="search-form" class="flex items-center">
                    <div id="search-container" class="flex items-center overflow-hidden transition-all duration-500 w-0 opacity-0">
                        <input type="text" name="q" id="search-input" placeholder="Cari informasi..." 
                            class="bg-white/10 dark:bg-slate-800/50 backdrop-blur-md border border-white/20 dark:border-white/10 rounded-full px-5 py-2 text-white placeholder-white/50 text-xs focus:outline-none focus:ring-1 focus:ring-yellow-400 w-48">
                    </div>
                    <button type="button" id="search-toggle" class="w-12 h-12 text-white hover:text-yellow-400 transition-all flex items-center justify-center active:scale-90 group">
                        <i class="fas fa-search text-lg transition-transform group-hover:scale-110"></i>
                    </button>
                </form>
            </div>

            <!-- THEME TOGGLE -->
            <button id="theme-toggle" class="w-12 h-12 text-white hover:text-yellow-400 transition-all flex items-center justify-center active:scale-95 group" title="Toggle Mode">
                <i id="theme-toggle-dark-icon" class="hidden fas fa-moon text-lg transition-transform group-hover:-rotate-12"></i>
                <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-lg transition-transform group-hover:rotate-45"></i>
            </button>

            <a href="{{ url('/login') }}" title="Login Portal" class="w-12 h-12 bg-yellow-400 text-[#0056b3] rounded-full flex items-center justify-center hover:bg-yellow-300 hover:scale-110 transition-all shadow-lg shadow-black/20 active:scale-95 group">
                <i class="fas fa-user-shield text-xl transition-transform group-hover:rotate-12"></i>
            </a>

            <script>
                // Theme Toggle Logic
                const themeToggleBtn = document.getElementById('theme-toggle');
                const darkIcon = document.getElementById('theme-toggle-dark-icon');
                const lightIcon = document.getElementById('theme-toggle-light-icon');

                if (document.documentElement.classList.contains('dark')) {
                    lightIcon.classList.remove('hidden');
                } else {
                    darkIcon.classList.remove('hidden');
                }

                themeToggleBtn.addEventListener('click', function() {
                    darkIcon.classList.toggle('hidden');
                    lightIcon.classList.toggle('hidden');

                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                });
            </script>

            <script>
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

        </div>
    </div>
</nav>