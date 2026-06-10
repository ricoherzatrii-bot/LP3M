@extends('layouts.app')
@section('title', 'Kuesioner Mahasiswa - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-4 gap-10">

            <!-- MAIN CONTENT (3/4) -->
            <div class="lg:col-span-3">
                <!-- ====================================================================== -->
                <!-- PREMIUM HERO SECTION — Immersive Luxury Experience                     -->
                <!-- ====================================================================== -->
                <div class="relative mb-16 rounded-[3.5rem] overflow-hidden group shadow-2xl">
                    <!-- Dynamic Gradient Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-700 via-blue-800 to-emerald-900 transition-all duration-1000 group-hover:scale-110"></div>
                    
                    <!-- Decorative Glass Elements -->
                    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl -mr-64 -mt-64 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-3xl -ml-64 -mb-64 animate-pulse" style="animation-delay: 2s;"></div>

                    <!-- Hero Content -->
                    <div class="relative z-10 px-8 py-16 md:px-14 md:py-24 flex flex-col items-center text-center">
                        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.3em] mb-10 shadow-xl">
                            <i class="fas fa-graduation-cap text-emerald-400"></i> Empowering Futures
                        </div>
                        
                        <h1 class="text-4xl md:text-6xl font-black text-white mb-8 leading-tight tracking-tighter font-serif-luxury">
                            Kuesioner <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-200 to-indigo-100">Mahasiswa</span>
                        </h1>
                        
                        <p class="text-blue-100/90 text-sm md:text-lg font-medium max-w-2xl leading-relaxed mb-12">
                            Suaramu adalah masa depan kampus kita. Bagikan pengalaman belajarmu untuk membantu kami menciptakan ekosistem akademik yang lebih baik dan inklusif.
                        </p>

                        <!-- Stats Quick Glance -->
                        <div class="flex flex-wrap justify-center gap-10">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/10 shadow-2xl group-hover:rotate-6 transition-transform">
                                    <i class="fas fa-user-graduate text-xl"></i>
                                </div>
                                <div class="text-left">
                                    <div class="text-white font-black text-xl mb-1">Terintegrasi</div>
                                    <div class="text-emerald-200/60 text-[10px] font-bold uppercase tracking-[0.2em]">Sistem Online</div>
                                </div>
                            </div>
                            <div class="w-[2px] h-12 bg-white/10 hidden sm:block"></div>
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/10 shadow-2xl group-hover:-rotate-6 transition-transform">
                                    <i class="fas fa-fingerprint text-xl"></i>
                                </div>
                                <div class="text-left">
                                    <div class="text-white font-black text-xl mb-1">Anonim</div>
                                    <div class="text-emerald-200/60 text-[10px] font-bold uppercase tracking-[0.2em]">Privasi Terjamin</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters & Context -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-16">
                    <div class="flex-1 w-full">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
                            <h2 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">Hasil Evaluasi Prodi</h2>
                        </div>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest pl-6">Program Studi: <span class="text-blue-600 dark:text-blue-400 font-black">{{ request('prodi') ?? 'Seluruh Program Studi' }}</span></p>
                    </div>

                    <form method="GET" action="{{ route('kuesioner.mahasiswa') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        @if(request('prodi'))
                            <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                        @endif
                        <div class="relative group">
                            <select name="tahun_akademik" onchange="this.form.submit()" class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 text-slate-900 dark:text-slate-200 text-[11px] font-black rounded-2xl px-8 py-5 pr-14 focus:ring-4 focus:ring-blue-500/10 appearance-none shadow-xl transition-all uppercase tracking-widest">
                                <option value="">Semua Tahun</option>
                                @foreach($tahunList as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun || ($kuesioner && $kuesioner->tahun_akademik == $tahun) ? 'selected' : '' }}>Tahun {{ $tahun }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-blue-500 pointer-events-none group-hover:translate-y-0.5 transition-transform"></i>
                        </div>
                    </form>
                </div>

                <!-- ====================================================================== -->
                <!-- FORM CONTAINER — Enhanced Glassmorphism Focus                          -->
                <!-- ====================================================================== -->
                @if($kuesioner && $kuesioner->link_google_form)
                <div id="kuesionerFormSection" class="mb-24 transform transition-all duration-700 hover:translate-y-[-8px]">
                    <div class="bg-white dark:bg-slate-900 rounded-[4rem] p-4 md:p-14 shadow-[0_50px_100px_rgba(0,0,0,0.06)] border border-slate-100 dark:border-white/5 relative overflow-hidden">
                        <!-- Backdrop Blur layers -->
                        <div class="absolute inset-0 bg-gradient-to-b from-emerald-50/50 to-transparent dark:from-emerald-900/10 pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Section Header -->
                            <div class="flex flex-col items-center mb-16 text-center">
                                <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-emerald-600 to-teal-700 p-0.5 shadow-2xl shadow-emerald-500/20 mb-10 transform rotate-6 hover:rotate-0 transition-all duration-700">
                                    <div class="w-full h-full bg-white dark:bg-slate-900 rounded-[1.8rem] flex items-center justify-center">
                                        <i class="fas fa-edit text-4xl bg-clip-text text-transparent bg-gradient-to-br from-emerald-600 to-teal-700"></i>
                                    </div>
                                </div>
                                <h2 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-6 tracking-tight font-serif-luxury">Partisipasi Kuesioner</h2>
                                <div class="h-1.5 w-24 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full mb-8"></div>
                                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-sm font-medium leading-relaxed">Berikan penilaian objektif atas layanan kependidikan Poljam selama periode perkuliahan Anda.</p>
                            </div>

                            <!-- The Google Form Iframe with Enhanced Frame -->
                            <div class="w-full rounded-[3.5rem] overflow-hidden border-[8px] border-slate-50 dark:border-slate-800/50 shadow-2xl bg-white dark:bg-slate-950 relative min-h-[500px] md:min-h-[850px]">
                                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-500 via-teal-600 to-blue-600 z-20"></div>
                                <iframe src="{{ $kuesioner->link_google_form }}" width="100%" height="850" frameborder="0" marginheight="0" marginwidth="0" class="w-full scale-[0.99] hover:scale-100 transition-transform duration-1000 ease-out origin-center">Memuat…</iframe>
                            </div>

                            <!-- Action Bar -->
                            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <a href="{{ $kuesioner->link_google_form }}" target="_blank" class="group relative overflow-hidden bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white py-6 px-10 rounded-[2.5rem] font-black text-xs uppercase tracking-[0.3em] transition-all hover:bg-slate-200 dark:hover:bg-slate-750 flex items-center justify-center gap-5">
                                    <i class="fas fa-external-link-alt group-hover:rotate-12 transition-transform text-emerald-500"></i>
                                    <span>Buka di Tab Baru</span>
                                </a>
                                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="group bg-slate-950 dark:bg-emerald-600 text-white py-6 px-10 rounded-[2.5rem] font-black text-xs uppercase tracking-[0.3em] shadow-2xl hover:shadow-emerald-500/50 transition-all flex items-center justify-center gap-5">
                                    <span>Kembali ke Atas</span>
                                    <i class="fas fa-arrow-up group-hover:-translate-y-2 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-24 bg-white dark:bg-slate-900/50 rounded-[4rem] p-20 text-center border-2 border-dashed border-slate-200 dark:border-white/5 shadow-inner">
                    <div class="w-24 h-24 rounded-full bg-slate-50 dark:bg-slate-800 mx-auto mb-10 flex items-center justify-center shadow-lg transform rotate-12">
                        <i class="fas fa-hourglass-start text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-400 dark:text-slate-500 mb-4 font-serif-luxury">Kuesioner Belum Tersedia</h3>
                    <p class="text-slate-400 dark:text-slate-600 text-sm max-w-xs mx-auto font-medium">Silakan hubungi Kaprodi Anda untuk informasi mengenai kuesioner periode ini.</p>
                </div>
                @endif

                <!-- ====================================================================== -->
                <!-- CHART CONTAINER — Data Visuals                                         -->
                <!-- ====================================================================== -->
                <div class="bg-white dark:bg-slate-900 rounded-[4rem] p-8 md:p-16 shadow-2xl border border-slate-100 dark:border-white/5 relative overflow-hidden group mb-12">
                     <div class="absolute -top-32 -right-32 w-80 h-80 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none group-hover:bg-blue-500/10 transition-all duration-1000"></div>
                     
                     <div class="grid lg:grid-cols-3 gap-20 items-center relative z-10">
                        <!-- Left: Grouped Bar Chart (2/3) -->
                        <div class="lg:col-span-2">
                            <div class="h-[500px] w-full">
                                <canvas id="groupedBarChart"></canvas>
                            </div>
                        </div>

                        <!-- Right: Radial Gauges (1/3) -->
                        <div class="lg:col-span-1 space-y-16">
                            <div class="text-center md:text-left mb-10">
                                <h4 class="text-slate-900 dark:text-white font-black text-xl mb-2 tracking-tighter">Key Metrics</h4>
                                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Kepuasan Layanan Mahasiswa</p>
                            </div>

                            <div class="flex items-center gap-10">
                                <div class="w-32 h-32 relative group/gauge">
                                    <canvas id="gauge1"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-2xl font-black text-slate-900 dark:text-white group-hover/gauge:scale-125 transition-transform">85%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-900 dark:text-white font-black text-lg mb-2">Akademik</h4>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed italic">Proses pembelajaran & Kurikulum.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-10">
                                <div class="w-32 h-32 relative group/gauge">
                                    <canvas id="gauge2"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-2xl font-black text-slate-900 dark:text-white group-hover/gauge:scale-125 transition-transform">79%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-900 dark:text-white font-black text-lg mb-2">Layanan</h4>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed italic">Sarana prasarana & Kemahasiswaan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR (1/4) -->
            <div class="lg:col-span-1 space-y-10">
                <!-- Search Box -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-white/5 group">
                    <h4 class="text-slate-900 dark:text-white font-black text-sm uppercase tracking-widest mb-8 border-l-4 border-blue-500 pl-4">Search Portal</h4>
                    <div class="relative">
                        <input type="text" placeholder="Temukan profil..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 placeholder-slate-400 dark:text-white transition-all">
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-blue-500">
                            <i class="fas fa-search text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Navigation List -->
                <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-10 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-white/5">
                    <h4 class="text-slate-900 dark:text-white font-black text-sm uppercase tracking-widest mb-10">Program Studi</h4>
                    <div class="space-y-4">
                        @foreach($prodiList as $prodi)
                        <a href="{{ route('kuesioner.mahasiswa', ['prodi' => $prodi]) }}" class="group flex items-center justify-between p-5 rounded-3xl @if(request('prodi') == $prodi) bg-blue-600 text-white shadow-xl shadow-blue-500/20 @else bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 @endif hover:-translate-y-1 transition-all">
                             <span class="text-[11px] font-black uppercase tracking-wider">{{ $prodi }}</span>
                             <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Featured News/Articles -->
                <div class="relative rounded-[3rem] overflow-hidden p-1 bg-slate-900 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-emerald-900 opacity-20 group-hover:scale-110 transition-transform duration-1000"></div>
                    <div class="relative z-10 p-10 flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-[1.5rem] bg-white/10 flex items-center justify-center text-white mb-8 shadow-2xl transform -rotate-12">
                            <i class="fas fa-rocket text-2xl"></i>
                        </div>
                        <h5 class="text-white font-black text-xl mb-4 leading-tight tracking-tighter">LPM Politeknik Jambi Digital Portal</h5>
                        <p class="text-blue-100/60 text-[10px] uppercase font-bold tracking-[0.3em] mb-12">Standardized Quality Assurance</p>
                        <a href="{{ route('artikel.index') }}" class="w-full bg-white text-slate-900 py-5 rounded-[2rem] font-black text-[10px] uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all shadow-2xl">Jelajahi Artikel</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. GROUPED BAR CHART ---
        const chartDataRaw = @json($chartData);
        const hasData = chartDataRaw && chartDataRaw.length > 0;
        
        const labels = hasData ? chartDataRaw.map(item => {
            let text = item.program;
            return text.length > 25 ? text.substring(0, 25) + '...' : text;
        }) : ['Belum Ada Data Statistik'];

        const themeColors = [
            'rgba(16, 185, 129, 0.9)', // Emerald
            'rgba(59, 130, 246, 0.9)', // Blue
            'rgba(245, 158, 11, 0.9)', // Amber
            'rgba(249, 115, 22, 0.9)', // Orange
            'rgba(239, 68, 68, 0.9)'  // Red
        ];

        const datasets = [
            { label: 'Sangat Setuju', data: hasData ? chartDataRaw.map(item => item.sangat_setuju) : [0], backgroundColor: themeColors[0], borderRadius: 12 },
            { label: 'Setuju', data: hasData ? chartDataRaw.map(item => item.setuju) : [0], backgroundColor: themeColors[1], borderRadius: 12 },
            { label: 'Cukup', data: hasData ? chartDataRaw.map(item => item.cukup_setuju) : [0], backgroundColor: themeColors[2], borderRadius: 12 },
            { label: 'Tidak Setuju', data: hasData ? chartDataRaw.map(item => item.tidak_setuju) : [0], backgroundColor: themeColors[3], borderRadius: 12 },
            { label: 'Sangat Tidak', data: hasData ? chartDataRaw.map(item => item.sangat_tidak_setuju) : [0], backgroundColor: themeColors[4], borderRadius: 12 }
        ];

        new Chart(document.getElementById('groupedBarChart').getContext('2d'), {
            type: 'bar',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: true, position: 'bottom', labels: { usePointStyle: true, boxWidth: 6, font: { weight: 'black', size: 10 } } },
                    tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', padding: 15, titleFont: { size: 12, weight: 'black' }, bodyFont: { size: 11 } }
                },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { font: { weight: 'black', size: 10 }, callback: v => v + "%" }, grid: { color: 'rgba(0,0,0,0.03)' } },
                    x: { ticks: { font: { weight: 'black', size: 9 } }, grid: { display: false } }
                }
            }
        });

        // --- 2. RADIAL GAUGES ---
        const createGauge = (id, color, value) => {
            new Chart(document.getElementById(id).getContext('2d'), {
                type: 'doughnut',
                data: { datasets: [{ data: [value, 100 - value], backgroundColor: [color, '#f8fafc'], borderWidth: 0, borderRadius: 15 }] },
                options: { cutout: '80%', plugins: { legend: { display: false }, tooltip: { enabled: false } }, animation: { duration: 3000, easing: 'easeOutQuart' } }
            });
        };

        createGauge('gauge1', '#10b981', 85);
        createGauge('gauge2', '#3b82f6', 79);
    });
</script>

@endsection
