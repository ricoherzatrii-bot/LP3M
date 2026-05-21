@extends('layouts.app')
@section('title', 'Kuesioner Dosen & Karyawan - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-white dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4 font-serif-luxury">{{ $kuesioner->judul ?? 'Kuesioner Dosen & Karyawan' }}</h1>
                
                <div class="flex items-center gap-3 text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-8 border-b border-slate-100 dark:border-white/10 pb-4">
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

                <!-- Banner -->
                <div class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold text-center py-4 rounded-xl shadow-lg mb-8 uppercase tracking-widest text-xs md:text-sm">
                    KEPUASAN DOSEN DAN TENAGA KEPENDIDIKAN POLITEKNIK JAMBI
                </div>

                <!-- Filters & Stats -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-10">
                    <form class="w-full md:w-1/2 relative" method="GET" action="{{ route('kuesioner.dosen') }}">
                        <select name="tahun_akademik" onchange="this.form.submit()" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 appearance-none font-medium shadow-sm transition-colors">
                            <option value="">Pilih Tahun Akademik</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun || ($kuesioner && $kuesioner->tahun_akademik == $tahun) ? 'selected' : '' }}>Tahun {{ $tahun }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-[10px] pointer-events-none"></i>
                    </form>
                    <div class="bg-blue-100 dark:bg-blue-900/30 rounded-xl px-12 py-3 text-center shadow-inner">
                        <div class="text-[10px] font-bold text-blue-800 dark:text-blue-400 uppercase tracking-widest mb-0">Responden</div>
                        <div class="text-xl font-black text-blue-900 dark:text-blue-200">0</div>
                    </div>
                </div>

                <!-- Redesigned Chart Container (Reference-Based) -->
                <div class="bg-white dark:bg-slate-900 rounded-[32px] p-6 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-white/10 mb-10">
                    <div class="grid lg:grid-cols-3 gap-12 items-center">
                        
                        <!-- Left: Grouped Bar Chart (2/3) -->
                        <div class="lg:col-span-2">
                            <div class="h-[400px] w-full">
                                <canvas id="groupedBarChart"></canvas>
                            </div>
                        </div>

                        <!-- Right: Radial Gauges (1/3) -->
                        <div class="lg:col-span-1 space-y-12">
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 relative">
                                    <canvas id="gauge1"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-lg font-black text-slate-900 dark:text-white">77%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-800 font-bold text-lg mb-1">Kepuasan SDM</h4>
                                    <p class="text-[10px] text-slate-500 leading-relaxed">Indikator ketersediaan tenaga pendidik dan kependidikan.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 relative">
                                    <canvas id="gauge2"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-lg font-black text-slate-900 dark:text-white">67%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-800 font-bold text-lg mb-1">Fasilitas</h4>
                                    <p class="text-[10px] text-slate-500 leading-relaxed">Kelengkapan sarana dan prasarana penunjang.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // --- 1. GROUPED BAR CHART ---
                        const ctxBar = document.getElementById('groupedBarChart').getContext('2d');
                        new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: ['Januari', 'Februari', 'Maret', 'April'],
                                datasets: [
                                    {
                                        label: 'Realisasi',
                                        data: [7, 8, 15, 18],
                                        backgroundColor: 'rgba(244, 63, 94, 0.8)', // Soft Red
                                        borderRadius: 8,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.6
                                    },
                                    {
                                        label: 'Target',
                                        data: [6, 8, 10, 14],
                                        backgroundColor: 'rgba(245, 158, 11, 0.8)', // Soft Yellow
                                        borderRadius: 8,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.6
                                    },
                                    {
                                        label: 'Tahun Lalu',
                                        data: [5, 4, 5, 8],
                                        backgroundColor: 'rgba(34, 197, 94, 0.8)', // Soft Green
                                        borderRadius: 8,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.6
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
                                        grid: { color: 'rgba(0,0,0,0.05)', darkColor: 'rgba(255,255,255,0.05)', drawBorder: false },
                                        ticks: { color: '#94a3b8', font: { size: 10 } }
                                    },
                                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { weight: 'bold' } } }
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
                                        borderRadius: 10
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

                        createGauge('gauge1', 'rgba(244, 63, 94, 0.8)', 77);
                        createGauge('gauge2', 'rgba(245, 158, 11, 0.8)', 67);
                    });
                </script>

                <!-- Keterangan Section -->
                <div class="mt-8">
                     <p class="text-center text-slate-400 text-xs italic leading-relaxed max-w-2xl mx-auto">
                        Data kuesioner ini menunjukkan tren kepuasan dosen dan tenaga kependidikan secara berkala. Grafik batang di atas membandingkan realisasi pencapaian dengan target yang telah ditetapkan institusi.
                     </p>
                </div>
            </div>

            <!-- SIDEBAR (1/3) -->
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
                        <a href="{{ route('kuesioner.mahasiswa') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Kuesioner Mahasiswa</a>
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
