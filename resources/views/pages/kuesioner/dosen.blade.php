@extends('layouts.app')
@section('title', 'Kuesioner Dosen & Karyawan - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-900 pt-8 pb-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <h1 class="text-4xl font-bold text-white mb-4 font-serif-luxury">{{ $kuesioner->judul ?? 'Kuesioner Dosen & Karyawan' }}</h1>
                
                <div class="flex items-center gap-3 text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-8 border-b border-white/10 pb-4">
                    <span>Admin</span> <span class="text-white/20">•</span>
                    <span>Kuesioner</span> <span class="text-white/20">•</span>
                    <span>{{ $kuesioner ? $kuesioner->created_at->format('d F Y') : date('d F Y') }}</span> <span class="text-white/20">•</span>
                    <span>Hits: {{ $kuesioner->hits ?? 0 }}</span>
                    
                    <!-- Social Icons -->
                    <div class="ml-auto flex gap-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-400 hover:text-white transition"><i class="fab fa-twitter text-xs"></i></a>
                    </div>
                </div>

                <!-- Banner -->
                <div class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold text-center py-4 rounded-xl shadow-lg mb-8 uppercase tracking-widest text-xs md:text-sm">
                    KEPUASAN DOSEN DAN TENAGA KEPENDIDIKAN POLITEKNIK JAMBI
                </div>

                <!-- Filters & Stats -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-10">
                    <form class="w-full md:w-1/2 relative" method="GET" action="{{ route('kuesioner.dosen') }}">
                        <select name="tahun_akademik" onchange="this.form.submit()" class="w-full bg-slate-800 border border-white/10 text-slate-300 text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 appearance-none font-medium">
                            <option value="">Pilih Tahun Akademik</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun || ($kuesioner && $kuesioner->tahun_akademik == $tahun) ? 'selected' : '' }}>Tahun {{ $tahun }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-[10px] pointer-events-none"></i>
                    </form>
                    <div class="bg-slate-400 rounded-xl px-12 py-3 text-center shadow-inner">
                        <div class="text-[10px] font-bold text-slate-800 uppercase tracking-widest mb-0">Responden</div>
                        <div class="text-xl font-black text-slate-900">0</div>
                    </div>
                </div>

                <!-- Chart Container -->
                <div class="bg-white rounded-3xl p-4 md:p-8 shadow-2xl relative border border-slate-100 overflow-hidden">
                    <div class="h-[600px] w-full">
                        @if($kuesioner && $kuesioner->link_embed_grafik)
                            <iframe src="{{ $kuesioner->link_embed_grafik }}" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                        @else
                            <div class="flex items-center justify-center h-full flex-col text-slate-400">
                                <i class="fas fa-chart-bar text-6xl mb-4 opacity-20"></i>
                                <p>Belum ada data grafik yang dilampirkan untuk kuesioner ini.</p>
                            </div>
                        @endif
                    </div>
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
                        <a href="{{ route('kuesioner.mahasiswa') }}" class="block text-slate-400 hover:text-blue-400 transition text-sm pb-4 border-b border-white/5">Kuesioner Mahasiswa</a>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-slate-400 hover:text-blue-400 transition text-sm pb-4 border-b border-white/5">Visi Dan Misi</a>
                        <a href="{{ route('artikel.index') }}" class="block text-slate-400 hover:text-blue-400 transition text-sm pb-4 border-b border-white/5">PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding</a>
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
</div>

@endsection
