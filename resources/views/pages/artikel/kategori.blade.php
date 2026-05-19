@extends('layouts.app')
@section('title', $data['title'] . ' - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-900 pt-8 pb-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm mb-8">
                    <a href="{{ route('artikel.index') }}" class="text-blue-400 hover:text-blue-300 transition">Artikel</a>
                    <i class="fas fa-chevron-right text-slate-600 text-[9px]"></i>
                    <span class="text-slate-400">{{ $data['title'] }}</span>
                </div>

                <!-- Article List -->
                <div class="space-y-10">
                    @foreach($data['items'] as $item)
                    <article class="group bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 overflow-hidden hover:border-blue-500/30 transition-all duration-500">
                        <!-- Article Image -->
                        <div class="h-64 overflow-hidden">
                            <img src="{{ asset('images/gedung-poljam.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $item['judul'] }}">
                        </div>
                        <!-- Article Content -->
                        <div class="p-8">
                            <h2 class="text-xl font-bold text-white mb-4 group-hover:text-blue-400 transition leading-tight">{{ $item['judul'] }}</h2>
                            <div class="flex flex-wrap items-center gap-3 text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4">
                                <span>Admin</span> 
                                <span class="text-white/20">/</span>
                                <span>{{ $data['title'] }}</span> 
                                <span class="text-white/20">/</span>
                                <span>{{ $item['tanggal'] }}</span>
                                <span class="text-white/20">/</span>
                                <span>Hits: {{ number_format($item['hits']) }}</span>
                            </div>
                            <p class="text-slate-400 text-sm leading-relaxed mb-5">{{ $item['deskripsi'] }}</p>
                            <a href="#" class="text-blue-400 text-sm font-semibold hover:text-blue-300 transition">
                                Read more ... {{ $item['judul'] }}
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800/60 border border-white/10 text-slate-500 text-sm cursor-pointer hover:border-blue-500/40 transition">&laquo;</span>
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800/60 border border-white/10 text-slate-500 text-sm cursor-pointer hover:border-blue-500/40 transition">&lsaquo;</span>
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-600 text-white text-sm font-bold">1</span>
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800/60 border border-white/10 text-slate-400 text-sm cursor-pointer hover:border-blue-500/40 transition">2</span>
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800/60 border border-white/10 text-slate-500 text-sm cursor-pointer hover:border-blue-500/40 transition">&rsaquo;</span>
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-800/60 border border-white/10 text-slate-500 text-sm cursor-pointer hover:border-blue-500/40 transition">&raquo;</span>
                    </div>
                    <span class="text-slate-500 text-sm">Page 1 of 2</span>
                </div>
            </div>

            <!-- SIDEBAR (1/3) -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 p-6">
                    <div class="relative">
                        <input type="text" placeholder="Search ..." class="w-full bg-slate-700/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    </div>
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

                <!-- Pengunjung -->
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl border border-white/10 p-6">
                    <h4 class="text-white font-bold text-lg mb-4 pb-4 border-b border-white/10">Pengunjung</h4>
                    <p class="text-slate-500 text-sm">We have <span class="text-blue-400 font-bold">6</span> guests and <span class="text-blue-400 font-bold">no</span> members online</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
