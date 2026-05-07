<!-- NAVIGATION BAR -->
<nav class="glass-nav sticky top-0 z-50 border-b border-slate-100 bg-white/90 backdrop-blur-md">
    <!-- Diubah ke px-6 lg:px-16 agar sejajar dengan Top Bar & Hero -->
    <div class="w-full px-6 lg:px-16 py-5 flex justify-between items-center">
        
        <!-- SISI KIRI: Logo Section -->
        <a href="{{ url('/') }}" class="flex items-center gap-4 group cursor-pointer">
            <div class="relative overflow-hidden rounded-lg">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="flex flex-col">
                <span class="block text-lg font-black tracking-tighter text-slate-900 leading-none uppercase">LPM POLJAM</span>
                <span class="text-[9px] font-bold text-blue-700 uppercase tracking-widest leading-none">Internal Quality Assurance</span>
            </div>
        </a>

        <!-- SISI KANAN: Navigasi Menu -->
        <div class="hidden xl:flex items-center gap-8 text-[11px] font-bold uppercase tracking-widest text-slate-600">
            <a href="{{ url('/') }}" class="text-blue-700 nav-link-active">Home</a>
            
            <!-- Menu Profil Dropdown -->
            <div class="relative group py-2">
                <span class="flex items-center gap-1 hover:text-blue-700 transition cursor-pointer">
                    Profil <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                </span>
                <div class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-4 z-50 overflow-hidden">
                    <div class="p-2 flex flex-col">
                        @php
                            $menus = [
                                ['slug' => 'visi-misi', 'label' => 'Visi & Misi'],
                                ['slug' => 'struktur', 'label' => 'Struktur Organisasi'],
                                ['slug' => 'kebijakan', 'label' => 'Kebijakan Mutu'],
                            ];
                        @endphp
                        @foreach($menus as $m)
                            <a href="#" class="px-4 py-2 hover:bg-blue-50 rounded-xl text-slate-700 font-semibold transition normal-case">
                                {{ $m['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Menu Lainnya -->
            <a href="#" class="hover:text-blue-700 transition">SPMI</a>
            <a href="#" class="hover:text-blue-700 transition">Akreditasi</a>
            <a href="#" class="hover:text-blue-700 transition">Kuesioner</a>
            
            <!-- Menu Galeri dengan Border Separator -->
            <a href="#" class="hover:text-blue-700 transition border-l pl-8 border-slate-200">Galeri</a>

            <!-- Tombol Login -->
            <a href="#" class="bg-blue-600 text-white px-7 py-3 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-200 active:scale-95">
                LOGIN PORTAL
            </a>
        </div>
    </div>
</nav>