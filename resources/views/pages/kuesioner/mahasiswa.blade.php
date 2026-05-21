@extends('layouts.app')
@section('title', 'Kuesioner Mahasiswa - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-white dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-4 gap-10">

            <!-- MAIN CONTENT (3/4) -->
            <div class="lg:col-span-3">
                <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4 font-serif-luxury">{{ $kuesioner->judul ?? 'Kuesioner Mahasiswa' }}</h1>
                
                <div class="flex items-center gap-3 text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-8 border-b border-white/10 pb-4">
                    <span>Admin</span> <span class="text-white/20">•</span>
                    <span>Kuesioner</span> <span class="text-white/20">•</span>
                    <span>{{ $kuesioner ? $kuesioner->created_at->format('d F Y') : date('d F Y') }}</span> <span class="text-white/20">•</span>
                    <span>Hits: {{ $kuesioner->hits ?? 0 }}</span>
                    
                    <!-- Social Icons -->
                    <div class="ml-auto flex gap-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-400 hover:text-white transition"><i class="fab fa-twitter text-xs"></i></a>
                    </div>
                </div>

                <!-- Inner Layout: Content + Article Index -->
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Chart Area -->
                    <div class="w-full md:w-3/4">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
                            <h2 id="chartTitle" class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white uppercase tracking-widest">
                                KUESIONER PRODI <br> <span class="text-blue-600 dark:text-blue-400" id="prodiName">{{ request('prodi') ?? 'SEMUA PRODI' }}</span>
                            </h2>
                            <form method="GET" action="{{ route('kuesioner.mahasiswa') }}" class="flex gap-2 w-full md:w-auto">
                                @if(request('prodi'))
                                    <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                                @endif
                                <select name="tahun_akademik" onchange="this.form.submit()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 text-[10px] md:text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500 font-medium shadow-sm transition-colors">
                                    <option value="">Semua Tahun</option>
                                    @foreach($tahunList as $tahun)
                                        <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun || ($kuesioner && $kuesioner->tahun_akademik == $tahun) ? 'selected' : '' }}>Tahun {{ $tahun }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- Redesigned Chart Container (Reference-Based) -->
                        <div class="bg-white dark:bg-slate-900 rounded-[32px] p-6 md:p-8 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-white/10 mb-10">
                            <div class="grid lg:grid-cols-3 gap-8 items-center">
                                
                                <!-- Left: Grouped Bar Chart (2/3) -->
                                <div class="lg:col-span-2">
                                    <div class="h-[400px] w-full">
                                        <canvas id="groupedBarChartMahasiswa"></canvas>
                                    </div>
                                </div>

                                <!-- Right: Radial Gauges (1/3) -->
                                <div class="lg:col-span-1 space-y-10">
                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-20 relative">
                                            <canvas id="mgauge1"></canvas>
                                            <div class="absolute inset-0 flex items-center justify-center text-sm font-black text-slate-900 dark:text-white">82%</div>
                                        </div>
                                        <div>
                                            <h4 class="text-slate-800 font-bold text-sm mb-1">Kepuasan Lulusan</h4>
                                            <p class="text-[9px] text-slate-500 leading-tight">Indikator daya saing lulusan.</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-20 relative">
                                            <canvas id="mgauge2"></canvas>
                                            <div class="absolute inset-0 flex items-center justify-center text-sm font-black text-slate-900 dark:text-white">88%</div>
                                        </div>
                                        <div>
                                            <h4 class="text-slate-800 font-bold text-sm mb-1">Kurikulum</h4>
                                            <p class="text-[9px] text-slate-500 leading-tight">Relevansi materi kerja.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // --- 1. GROUPED BAR CHART ---
                                const ctxBar = document.getElementById('groupedBarChartMahasiswa').getContext('2d');
                                new Chart(ctxBar, {
                                    type: 'bar',
                                    data: {
                                        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
                                        datasets: [
                                            {
                                                label: 'Sangat Puas',
                                                data: [12, 14, 18, 22],
                                                backgroundColor: 'rgba(16, 185, 129, 0.8)', // Emerald
                                                borderRadius: 6
                                            },
                                            {
                                                label: 'Puas',
                                                data: [8, 10, 12, 15],
                                                backgroundColor: 'rgba(59, 130, 246, 0.8)', // Blue
                                                borderRadius: 6
                                            },
                                            {
                                                label: 'Cukup',
                                                data: [5, 4, 6, 3],
                                                backgroundColor: 'rgba(245, 158, 11, 0.8)', // Amber
                                                borderRadius: 6
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: { legend: { display: false } },
                                        scales: {
                                            y: { 
                                                beginAtZero: true,
                                                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                                ticks: { color: '#94a3b8', font: { size: 9 } }
                                            },
                                            x: { grid: { display: false }, ticks: { color: '#64748b', font: { weight: 'bold', size: 10 } } }
                                        }
                                    }
                                });

                                // --- 2. RADIAL GAUGES ---
                                const createGauge = (id, color, value) => {
                                    new Chart(document.getElementById(id).getContext('2d'), {
                                        type: 'doughnut',
                                        data: {
                                            datasets: [{
                                                data: [value, 100 - value],
                                                backgroundColor: [color, 'rgba(0,0,0,0.05)'],
                                                borderWidth: 0,
                                                borderRadius: 8
                                            }]
                                        },
                                        options: {
                                            cutout: '80%',
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: { legend: { display: false }, tooltip: { enabled: false } },
                                            animation: { animateRotate: true, duration: 2000 }
                                        }
                                    });
                                };

                                createGauge('mgauge1', 'rgba(16, 185, 129, 0.8)', 82);
                                createGauge('mgauge2', 'rgba(59, 130, 246, 0.8)', 88);
                            });
                        </script>

                        <!-- Keterangan Section -->
                        <div class="mt-12 bg-slate-800/20 backdrop-blur-sm rounded-2xl p-6 border border-white/5">
                            <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                                <i class="fas fa-circle-info text-blue-500"></i> Interpretasi Data
                            </h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Grafik di atas menunjukkan distribusi tingkat kepuasan mahasiswa {{ request('prodi') ? 'di prodi ' . request('prodi') : 'secara keseluruhan' }} untuk tahun akademik {{ request('tahun_akademik') ?? '2023/2024' }}. Mayoritas mahasiswa (80%) menyatakan puas atau sangat puas dengan layanan pendidikan yang diberikan.
                            </p>
                        </div>
                    </div>

                    <!-- Article Index / Prodi List -->
                    <div class="w-full md:w-1/4">
                        <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-2xl border border-slate-200 dark:border-white/10 p-5 sticky top-24 shadow-sm">
                            <h3 class="text-slate-900 dark:text-white font-bold text-sm uppercase tracking-widest mb-4 border-b border-slate-100 dark:border-white/10 pb-3">Daftar Prodi</h3>
                            <div class="space-y-2 text-xs font-medium">
                                <a href="{{ request()->fullUrlWithQuery(['prodi' => null]) }}" class="block w-full text-left px-3 py-2 rounded-lg transition-all {{ !request('prodi') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-white border border-transparent' }}">Semua Prodi</a>
                                @foreach($prodiList as $prodi)
                                    <a href="{{ request()->fullUrlWithQuery(['prodi' => $prodi]) }}" class="block w-full text-left px-3 py-2 rounded-lg transition-all {{ request('prodi') == $prodi ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-blue-600 dark:hover:text-white border border-transparent' }}">{{ $prodi }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN SIDEBAR (1/4) -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <div class="relative">
                        <input type="text" placeholder="Search ..." class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 transition">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Sering Dibaca -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <h4 class="text-slate-900 dark:text-white font-bold text-lg mb-6 pb-4 border-b border-slate-100 dark:border-white/10">Sering Dibaca</h4>
                    <div class="space-y-4">
                        <a href="{{ route('kuesioner.dosen') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Kuesioner Dosen & Karyawan</a>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Visi Dan Misi</a>
                        <a href="{{ route('artikel.index') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding</a>
                        <a href="https://e-spmi.politeknikjambi.ac.id" target="_blank" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">e-spmiPoljam</a>
                        <a href="{{ route('spmi.show', 'rtm') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm">RTM</a>
                    </div>
                </div>


            </div>
            
        </div>
    </div>
</div>



@endsection
