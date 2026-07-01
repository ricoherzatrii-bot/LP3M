@extends('layouts.app')
@section('title', 'Kuesioner Mahasiswa - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <!-- Upper Filters Section -->
        <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 shadow-xl border border-slate-100 dark:border-white/5 relative overflow-hidden mb-12">
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8 relative z-10">
                <div>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter uppercase mb-2">Pencarian & Filter</h3>
                    <p class="text-blue-600 dark:text-blue-400 font-black text-sm uppercase tracking-tight">Kuesioner Mahasiswa</p>
                </div>

                <form method="GET" action="{{ route('kuesioner.mahasiswa') }}" class="flex flex-wrap items-center gap-4 w-full xl:w-auto">
                    <!-- Filter Tahun -->
                    <div class="relative group min-w-[160px]">
                        <select name="tahun_akademik" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 text-slate-900 dark:text-slate-200 text-[11px] font-black rounded-2xl px-6 py-4 pr-10 appearance-none focus:ring-4 focus:ring-blue-500/10 transition-all uppercase tracking-widest shadow-sm">
                            <option value="">Tahun Akademik</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-calendar-alt absolute right-5 top-1/2 -translate-y-1/2 text-blue-500 pointer-events-none"></i>
                    </div>

                    <!-- Filter Prodi -->
                    <div class="relative group min-w-[200px]">
                        <select name="prodi" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 text-slate-900 dark:text-slate-200 text-[11px] font-black rounded-2xl px-6 py-4 pr-10 appearance-none focus:ring-4 focus:ring-blue-500/10 transition-all uppercase tracking-widest shadow-sm">
                            <option value="all" {{ request('prodi') == 'all' || !request('prodi') ? 'selected' : '' }}>Semua Program Studi (All Page)</option>
                            @foreach($prodiList as $prodi)
                                <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-graduation-cap absolute right-5 top-1/2 -translate-y-1/2 text-blue-500 pointer-events-none"></i>
                    </div>

                    <!-- Filter Aspek -->
                    <div class="relative group min-w-[160px]">
                        <select name="aspek" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 text-slate-900 dark:text-slate-200 text-[11px] font-black rounded-2xl px-6 py-4 pr-10 appearance-none focus:ring-4 focus:ring-blue-500/10 transition-all uppercase tracking-widest shadow-sm">
                            <option value="">Semua Aspek</option>
                            @foreach($aspekList as $aspek)
                                <option value="{{ $aspek }}" {{ request('aspek') == $aspek ? 'selected' : '' }}>{{ $aspek }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-tasks absolute right-5 top-1/2 -translate-y-1/2 text-blue-500 pointer-events-none"></i>
                    </div>
                </form>
            </div>
        </div>

        <!-- Charts Section -->
        <div>
            @foreach($chartData as $prodiName => $prodiChartData)
            <div class="bg-white dark:bg-slate-900 rounded-[4rem] p-8 md:p-14 shadow-2xl border border-slate-100 dark:border-white/5 relative overflow-hidden group mb-12">
                 <div class="absolute -top-32 -right-32 w-80 h-80 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none group-hover:bg-blue-500/10 transition-all duration-1000"></div>
                 
                 <!-- Chart Header -->
                 <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8 mb-14 relative z-10">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter uppercase mb-2">KUISIONER PRODI</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-black text-lg uppercase tracking-tight">{{ $prodiName }}</p>
                    </div>
                 </div>

                 <div class="relative z-10">
                    <div class="h-[500px] w-full">
                        <canvas id="chart-{{ \Illuminate\Support\Str::slug($prodiName) }}" class="prodi-chart" data-prodi="{{ $prodiName }}" data-chart-data='@json($prodiChartData)'></canvas>
                    </div>
                 </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. SPECIALIZED 4-SCALE BAR CHART (LOOP FOR ALL CANVASES) ---
        const colors = {
            sangat_baik: '#10b981',  // Green
            baik: '#3b82f6',         // Blue
            kurang: '#f97316',       // Orange
            sangat_kurang: '#ef4444' // Red
        };

        const canvases = document.querySelectorAll('.prodi-chart');
        canvases.forEach(canvas => {
            const chartDataRaw = JSON.parse(canvas.getAttribute('data-chart-data'));
            const hasData = chartDataRaw && chartDataRaw.length > 0;
            
            const labels = hasData ? chartDataRaw.map(item => {
                let text = item.program;
                return text.length > 35 ? text.substring(0, 35) + '...' : text;
            }) : ['Belum Ada Data Statistik'];

            const datasets = [
                { 
                    label: 'Sangat Baik', 
                    data: hasData ? chartDataRaw.map(item => item.setuju) : [0],
                    backgroundColor: colors.sangat_baik, 
                    borderRadius: 4,
                    barPercentage: 0.8,
                    categoryPercentage: 0.8
                },
                { 
                    label: 'Baik', 
                    data: hasData ? chartDataRaw.map(item => item.sangat_setuju) : [0],
                    backgroundColor: colors.baik, 
                    borderRadius: 4,
                    barPercentage: 0.8,
                    categoryPercentage: 0.8
                },
                { 
                    label: 'Kurang', 
                    data: hasData ? chartDataRaw.map(item => item.tidak_setuju) : [0], 
                    backgroundColor: colors.kurang, 
                    borderRadius: 4,
                    barPercentage: 0.8,
                    categoryPercentage: 0.8
                },
                { 
                    label: 'Sangat Kurang', 
                    data: hasData ? chartDataRaw.map(item => item.sangat_tidak_setuju) : [0], 
                    backgroundColor: colors.sangat_kurang, 
                    borderRadius: 4,
                    barPercentage: 0.8,
                    categoryPercentage: 0.8
                }
            ];

            new Chart(canvas.getContext('2d'), {
                type: 'bar',
                data: { labels: labels, datasets: datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            display: true, 
                            position: 'top', 
                            align: 'end',
                            labels: { 
                                usePointStyle: true, 
                                pointStyle: 'rect',
                                boxWidth: 20, 
                                boxHeight: 12,
                                font: { weight: 'bold', size: 12 },
                                padding: 15
                            } 
                        },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            max: 100, 
                            ticks: { 
                                font: { weight: 'bold', size: 11 }, 
                                callback: v => v + "%",
                                stepSize: 10
                            }, 
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false } 
                        },
                        x: { 
                            ticks: { font: { weight: 'bold', size: 11 } }, 
                            grid: { display: false } 
                        }
                    }
                }
            });
        });

    });
</script>

@endsection
