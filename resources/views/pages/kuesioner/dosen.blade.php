@extends('layouts.app')
@section('title', 'Kuesioner Dosen & Karyawan - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <!-- ====================================================================== -->
                <!-- PREMIUM HERO SECTION — Immersive Luxury Experience                     -->
                <!-- ====================================================================== -->
                <div class="relative mb-16 rounded-[3rem] overflow-hidden group shadow-2xl">
                    <!-- Dynamic Gradient Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-indigo-800 to-purple-900 transition-all duration-1000 group-hover:scale-110"></div>
                    
                    <!-- Decorative Glass Elements -->
                    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl -ml-48 -mb-48 animate-pulse" style="animation-delay: 2s;"></div>

                    <!-- Hero Content -->
                    <div class="relative z-10 px-8 py-16 md:px-12 md:py-24 flex flex-col items-center text-center">
                        <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.2em] mb-8">
                            <i class="fas fa-star text-yellow-400"></i> Premium Service
                        </div>
                        
                        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight tracking-tighter font-serif-luxury">
                            Kuesioner <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-indigo-100">Dosen & Karyawan</span>
                        </h1>
                        
                        <p class="text-blue-100/80 text-sm md:text-base font-medium max-w-2xl leading-relaxed">
                            Kontribusi Anda sangat berharga bagi kami. Bersama-sama, kita tingkatkan standar kualitas layanan pendidikan melalui evaluasi yang transparan dan akurat.
                        </p>

                        <!-- Stats Quick Glance -->
                        <div class="flex flex-wrap justify-center gap-8 mt-12">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/10 shadow-lg">
                                    <i class="fas fa-users text-lg"></i>
                                </div>
                                <div class="text-left">
                                    <div class="text-white font-black text-lg leading-none mb-1">Real-time</div>
                                    <div class="text-blue-200/60 text-[9px] font-bold uppercase tracking-widest">Verifikasi Sistem</div>
                                </div>
                            </div>
                            <div class="w-px h-12 bg-white/10 hidden sm:block"></div>
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/10 shadow-lg">
                                    <i class="fas fa-shield-halved text-lg"></i>
                                </div>
                                <div class="text-left">
                                    <div class="text-white font-black text-lg leading-none mb-1">Data Aman</div>
                                    <div class="text-blue-200/60 text-[9px] font-bold uppercase tracking-widest">Rahasia & Terlindungi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters & Stats Overview -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                    <form class="w-full md:w-auto flex-1 relative group" method="GET" action="{{ route('kuesioner.dosen') }}">
                        <select name="tahun_akademik" onchange="this.form.submit()" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 text-slate-700 dark:text-slate-300 text-sm rounded-2xl px-6 py-4 focus:outline-none focus:ring-4 focus:ring-blue-500/10 appearance-none font-bold shadow-xl shadow-slate-200/50 dark:shadow-none transition-all">
                            <option value="">Pilih Tahun Akademik</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun || ($kuesioner && $kuesioner->tahun_akademik == $tahun) ? 'selected' : '' }}>Tahun Akademik {{ $tahun }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-blue-500 group-hover:translate-x-1 transition-transform">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </div>
                    </form>
                    
                    <div class="flex items-center gap-4 bg-white dark:bg-slate-900 p-2 pr-8 rounded-[1.5rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-white/5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-400/10 flex items-center justify-center text-blue-600 dark:text-blue-400">
                             <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Responden</div>
                            <div class="text-xl font-black text-slate-900 dark:text-white leading-none">Terverifikasi</div>
                        </div>
                    </div>
                </div>

                <!-- ====================================================================== -->
                <!-- FORM CONTAINER — Enhanced Glassmorphism Focus                          -->
                <!-- ====================================================================== -->
                @if($kuesioner && $kuesioner->link_google_form)
                <div id="kuesionerFormSection" class="mb-20 transform transition-all duration-700 hover:translate-y-[-8px]">
                    <div class="bg-white dark:bg-slate-900 rounded-[3.5rem] p-4 md:p-14 shadow-[0_50px_100px_rgba(0,0,0,0.06)] border border-slate-100 dark:border-white/5 relative overflow-hidden">
                        <!-- Backdrop Blur layers -->
                        <div class="absolute inset-0 bg-gradient-to-b from-blue-50/50 to-transparent dark:from-blue-900/10 pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Section Header -->
                            <div class="flex flex-col items-center mb-16 text-center">
                                <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-blue-600 to-indigo-700 p-0.5 shadow-2xl shadow-blue-500/20 mb-10 transform -rotate-6 hover:rotate-0 transition-all duration-700">
                                    <div class="w-full h-full bg-white dark:bg-slate-900 rounded-[1.8rem] flex items-center justify-center">
                                        <i class="fas fa-feather-pointed text-4xl bg-clip-text text-transparent bg-gradient-to-br from-blue-600 to-indigo-700"></i>
                                    </div>
                                </div>
                                <h2 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-6 tracking-tight font-serif-luxury">Partisipasi Kuesioner</h2>
                                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md font-medium leading-relaxed">Silakan lengkapi formulir evaluasi di bawah ini secara objektif untuk pengembangan institusi.</p>
                                <div class="h-1.5 w-24 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mt-8"></div>
                            </div>

                            <!-- The Google Form Iframe with Enhanced Frame -->
                            <div class="w-full rounded-[3rem] overflow-hidden border-[6px] border-slate-50 dark:border-slate-800/50 shadow-2xl bg-white dark:bg-slate-950 relative min-h-[600px] md:min-h-[850px]">
                                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-600 z-20"></div>
                                <iframe src="{{ $kuesioner->link_google_form }}" width="100%" height="850" frameborder="0" marginheight="0" marginwidth="0" class="w-full scale-[0.99] hover:scale-100 transition-transform duration-1000 ease-out origin-center">Memuat…</iframe>
                            </div>

                            <!-- Professional Action Bar -->
                            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <a href="{{ $kuesioner->link_google_form }}" target="_blank" class="group relative overflow-hidden bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white py-6 px-10 rounded-[2rem] font-black text-xs uppercase tracking-[0.25em] transition-all hover:bg-slate-200 dark:hover:bg-slate-750 flex items-center justify-center gap-5">
                                    <i class="fas fa-external-link-alt group-hover:rotate-12 transition-transform text-blue-500"></i>
                                    <span>Buka di Layar Penuh</span>
                                    <div class="absolute inset-0 border-2 border-transparent group-hover:border-blue-500/20 rounded-[2rem] pointer-events-none transition-all"></div>
                                </a>
                                <button onclick="window.scrollTo({top: document.getElementById('chartSection').offsetTop - 50, behavior: 'smooth'})" class="group relative overflow-hidden bg-slate-950 dark:bg-blue-600 text-white py-6 px-10 rounded-[2rem] font-black text-xs uppercase tracking-[0.25em] shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all flex items-center justify-center gap-5">
                                    <span>Data Statistik</span>
                                    <i class="fas fa-arrow-down group-hover:translate-y-2 transition-transform"></i>
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
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
                    <h3 class="text-2xl font-black text-slate-400 dark:text-slate-500 mb-4 font-serif-luxury">Akses Belum Tersedia</h3>
                    <p class="text-slate-400 dark:text-slate-600 text-sm max-w-xs mx-auto font-medium">Link kuesioner sedang dalam tahap sinkronisasi sistem.</p>
                </div>
                @endif

                <!-- ====================================================================== -->
                <!-- CHART SECTION — Data Visualization                                     -->
                <!-- ====================================================================== -->
                <div id="chartSection" class="bg-white dark:bg-slate-900 rounded-[3.5rem] p-8 md:p-14 shadow-2xl border border-slate-100 dark:border-white/5 mb-16 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8">
                         <div class="w-12 h-12 rounded-2xl bg-blue-500/5 flex items-center justify-center text-blue-500/20">
                             <i class="fas fa-chart-simple text-2xl"></i>
                         </div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tighter mb-2">Visualisasi Kepuasan</h2>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Update Terakhir: <span class="text-blue-500">{{ date('d F Y') }}</span></p>
                        </div>
                        <div class="h-1 w-20 bg-slate-100 dark:bg-white/10 hidden md:block"></div>
                    </div>

                    <div class="grid lg:grid-cols-3 gap-16 items-center">
                        <!-- Left: Grouped Bar Chart (2/3) -->
                        <div class="lg:col-span-2">
                            <div class="h-[450px] w-full relative">
                                <canvas id="groupedBarChart"></canvas>
                            </div>
                        </div>

                        <!-- Right: Radial Gauges (1/3) -->
                        <div class="lg:col-span-1 space-y-16">
                            <div class="group flex items-center gap-8 p-6 rounded-3xl hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                                <div class="w-28 h-28 relative transform group-hover:scale-110 transition-transform">
                                    <canvas id="gauge1"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-xl font-black text-slate-900 dark:text-white">92%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-900 dark:text-white font-black text-lg mb-2">Internal</h4>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Kualitas layanan administrasi akademik.</p>
                                </div>
                            </div>

                            <div class="group flex items-center gap-8 p-6 rounded-3xl hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                                <div class="w-28 h-28 relative transform group-hover:scale-110 transition-transform">
                                    <canvas id="gauge2"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-xl font-black text-slate-900 dark:text-white">88%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-900 dark:text-white font-black text-lg mb-2">Eksternal</h4>
                                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Fasilitas dan sarana penunjang kampus.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="bg-blue-600 dark:bg-indigo-900 rounded-[2.5rem] p-10 text-center shadow-xl shadow-blue-500/20">
                    <p class="text-white text-sm font-medium leading-relaxed max-w-2xl mx-auto opacity-90">
                        "Kuesioner ini merupakan bagian dari siklus PPEPP (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, dan Peningkatan) untuk menjamin standar mutu di Politeknik Jambi."
                    </p>
                </div>
            </div>

            <!-- SIDEBAR (1/3) -->
            <div class="space-y-10">
                <!-- Search Box -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-white/5 group">
                    <h4 class="text-slate-900 dark:text-white font-black text-sm uppercase tracking-widest mb-6">Pencarian</h4>
                    <div class="relative">
                        <input type="text" placeholder="Temukan informasi..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 placeholder-slate-400 dark:text-white transition-all">
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-blue-500">
                            <i class="fas fa-search text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Featured Navigation -->
                <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-white/5">
                    <h4 class="text-slate-900 dark:text-white font-black text-sm uppercase tracking-widest mb-8 pb-4 border-b-2 border-blue-500/10">Menu Terkait</h4>
                    <div class="grid grid-cols-1 gap-4">
                        @php
                            $related = [
                                ['icon' => 'user-graduate', 'title' => 'Kuesioner Mahasiswa', 'link' => route('kuesioner.mahasiswa'), 'color' => 'emerald'],
                                ['icon' => 'scroll', 'title' => 'Visi & Misi Kami', 'link' => route('profil.show', 'visi-dan-misi'), 'color' => 'blue'],
                                ['icon' => 'newspaper', 'title' => 'Update Berita', 'link' => route('artikel.index'), 'color' => 'indigo'],
                                ['icon' => 'globe', 'title' => 'E-SPMI Poljam', 'link' => 'https://e-spmi.politeknikjambi.ac.id', 'color' => 'cyan'],
                                ['icon' => 'microchip', 'title' => 'Strategic Plan', 'link' => route('spmi.show', 'rtm'), 'color' => 'purple'],
                            ];
                        @endphp

                        @foreach($related as $item)
                        <a href="{{ $item['link'] }}" class="group flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                            <div class="w-10 h-10 rounded-xl bg-{{ $item['color'] }}-500/10 flex items-center justify-center text-{{ $item['color'] }}-600 transition-transform group-hover:scale-110">
                                <i class="fas fa-{{ $item['icon'] }} text-sm"></i>
                            </div>
                            <span class="text-xs font-black text-slate-700 dark:text-slate-300 group-hover:text-blue-500 transition-colors uppercase tracking-wider">{{ $item['title'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Help -->
                <div class="relative rounded-[2.5rem] overflow-hidden p-1 px-8 py-10 bg-slate-900 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-900 opacity-20 group-hover:scale-110 transition-transform duration-1000"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center text-white mb-6">
                            <i class="fas fa-headset text-2xl"></i>
                        </div>
                        <h5 class="text-white font-black text-lg mb-2">Butuh Bantuan?</h5>
                        <p class="text-blue-100/60 text-[10px] uppercase font-bold tracking-widest mb-8">Layanan Support LPM Poljam</p>
                        <a href="#" class="w-full bg-white text-slate-900 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-500 hover:text-white transition-all shadow-xl">Hubungi Kami</a>
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
        }) : ['No Data Available'];

        const colors = [
            'rgba(34, 197, 94, 0.9)', 
            'rgba(59, 130, 246, 0.9)', 
            'rgba(234, 179, 8, 0.9)', 
            'rgba(249, 115, 22, 0.9)', 
            'rgba(239, 68, 68, 0.9)'
        ];

        const datasets = [
            { label: 'Sangat Setuju', data: hasData ? chartDataRaw.map(item => item.sangat_setuju) : [0], backgroundColor: colors[0], borderRadius: 8 },
            { label: 'Setuju', data: hasData ? chartDataRaw.map(item => item.setuju) : [0], backgroundColor: colors[1], borderRadius: 8 },
            { label: 'Cukup', data: hasData ? chartDataRaw.map(item => item.cukup_setuju) : [0], backgroundColor: colors[2], borderRadius: 8 },
            { label: 'Tidak Setuju', data: hasData ? chartDataRaw.map(item => item.tidak_setuju) : [0], backgroundColor: colors[3], borderRadius: 8 },
            { label: 'Sangat Tidak', data: hasData ? chartDataRaw.map(item => item.sangat_tidak_setuju) : [0], backgroundColor: colors[4], borderRadius: 8 }
        ];

        new Chart(document.getElementById('groupedBarChart').getContext('2d'), {
            type: 'bar',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: true, position: 'bottom', labels: { usePointStyle: true, boxWidth: 6, font: { weight: 'bold', size: 10 } } },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { callback: v => v + "%", font: { size: 10, weight: 'bold' } }, grid: { color: 'rgba(0,0,0,0.03)' } },
                    x: { ticks: { font: { size: 9, weight: 'bold' } }, grid: { display: false } }
                }
            }
        });

        // --- 2. RADIAL GAUGES ---
        const createGauge = (id, color, value) => {
            new Chart(document.getElementById(id).getContext('2d'), {
                type: 'doughnut',
                data: { datasets: [{ data: [value, 100 - value], backgroundColor: [color, '#f1f5f9'], borderWidth: 0, borderRadius: 10 }] },
                options: { cutout: '80%', plugins: { legend: { display: false }, tooltip: { enabled: false } }, animation: { duration: 2500 } }
            });
        };

        createGauge('gauge1', '#2dd4bf', 92);
        createGauge('gauge2', '#fbbf24', 88);
    });
</script>

@endsection
