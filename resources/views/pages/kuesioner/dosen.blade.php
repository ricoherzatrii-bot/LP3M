@extends('layouts.app')
@section('title', 'Kuesioner Dosen & Karyawan - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        
        <!-- Upper Filters Section (Consolidated Style) -->
        <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 shadow-xl border border-slate-100 dark:border-white/5 relative overflow-hidden mb-12">
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8 relative z-10">
                <div>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter uppercase mb-2">Pencarian & Filter</h3>
                    <p class="text-[#ba181b] font-black text-sm uppercase tracking-tight">Kuesioner Dosen & Karyawan</p>
                </div>

                <form method="GET" action="{{ route('kuesioner.dosen') }}" class="flex flex-wrap items-center gap-4 w-full xl:w-auto">
                    <div class="relative group min-w-[200px]">
                        <select name="tahun_akademik" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 text-slate-900 dark:text-slate-200 text-[11px] font-black rounded-2xl px-6 py-4 pr-10 appearance-none focus:ring-4 focus:ring-blue-500/10 transition-all uppercase tracking-widest shadow-sm">
                            <option value="">Pilih Tahun Akademik</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun || ($kuesioner && $kuesioner->tahun_akademik == $tahun) ? 'selected' : '' }}>Tahun {{ $tahun }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-calendar-alt absolute right-5 top-1/2 -translate-y-1/2 text-[#ba181b] pointer-events-none"></i>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <div class="bg-white dark:bg-slate-900 rounded-[4rem] p-8 md:p-14 shadow-2xl border border-slate-100 dark:border-white/5 relative overflow-hidden group mb-12">
                 <div class="absolute -top-32 -right-32 w-80 h-80 bg-red-500/5 rounded-full blur-[100px] pointer-events-none group-hover:bg-red-500/10 transition-all duration-1000"></div>
                 
                 <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-14 relative z-10">
                    <div class="flex items-center gap-6">
                        <div class="h-12 w-2 bg-[#ba181b] rounded-full"></div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white tracking-tighter uppercase">
                                {{ $kuesioner->judul ?? 'Kepuasan Dosen dan Tenaga Kependidikan' }}
                            </h1>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mt-1">Status Kuesioner: <span class="text-emerald-500">Aktif</span></p>
                        </div>
                    </div>
                    
                    <!-- RESPONDEN BOX -->
                    <div class="bg-slate-900 dark:bg-slate-800 text-white px-10 py-5 rounded-[2rem] shadow-2xl relative overflow-hidden group/resp">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-600/20 to-transparent opacity-0 group-hover/resp:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10">
                            <div class="text-[10px] font-black uppercase tracking-[0.3em] mb-1 opacity-60">Total Responden</div>
                            <div class="text-4xl font-black tracking-tighter">{{ $respondenCount ?? 0 }}</div>
                        </div>
                    </div>
                 </div>

                 <!-- CHART SECTION -->
                 <div class="relative z-10 w-full mb-16">
                     <div class="mb-8 flex items-center justify-between">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.3em]">Visualisasi Statistik</h3>
                        <div class="flex flex-wrap gap-6">
                            @php
                                $legendItems = [
                                    ['color' => '#0056b3', 'label' => 'Sangat Setuju'],
                                    ['color' => '#22d3ee', 'label' => 'Setuju'],
                                    ['color' => '#f472b6', 'label' => 'Cukup Setuju'],
                                    ['color' => '#f97316', 'label' => 'Tidak Setuju'],
                                    ['color' => '#dc2626', 'label' => 'Sangat Tidak Setuju']
                                ];
                            @endphp
                            @foreach($legendItems as $item)
                            <div class="flex items-center gap-2.5">
                                <div class="w-3.5 h-3.5 rounded-full" style="background-color: {{ $item['color'] }}"></div>
                                <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ $item['label'] }}</span>
                            </div>
                            @endforeach
                        </div>
                     </div>
                     <div class="h-[600px] w-full">
                         <canvas id="kuesionerChart"></canvas>
                     </div>
                 </div>


            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartDataRaw = @json($chartData);
        const hasData = chartDataRaw && chartDataRaw.length > 0;
        
        const labels = hasData ? chartDataRaw.map(item => {
            let text = item.program;
            return text.length > 35 ? text.substring(0, 35) + '...' : text;
        }) : ['Belum Ada Data Statistik'];

        const themeColors = {
            ss:  '#0056b3', // Sangat Setuju (Blue)
            s:   '#22d3ee', // Setuju (Cyan)
            cs:  '#f472b6', // Cukup Setuju (Pink)
            ts:  '#f97316', // Tidak Setuju (Orange)
            sts: '#dc2626'  // Sangat Tidak Setuju (Red)
        };

        const datasets = [
            {
                label: 'Sangat Setuju',
                data: hasData ? chartDataRaw.map(item => item.sangat_setuju) : [0],
                backgroundColor: themeColors.ss,
                borderRadius: 6,
                barPercentage: 0.8,
                categoryPercentage: 0.8
            },
            {
                label: 'Setuju',
                data: hasData ? chartDataRaw.map(item => item.setuju) : [0],
                backgroundColor: themeColors.s,
                borderRadius: 6,
                barPercentage: 0.8,
                categoryPercentage: 0.8
            },
            {
                label: 'Cukup Setuju',
                data: hasData ? chartDataRaw.map(item => item.cukup_setuju) : [0],
                backgroundColor: themeColors.cs,
                borderRadius: 6,
                barPercentage: 0.8,
                categoryPercentage: 0.8
            },
            {
                label: 'Tidak Setuju',
                data: hasData ? chartDataRaw.map(item => item.tidak_setuju) : [0],
                backgroundColor: themeColors.ts,
                borderRadius: 6,
                barPercentage: 0.8,
                categoryPercentage: 0.8
            },
            {
                label: 'Sangat Tidak Setuju',
                data: hasData ? chartDataRaw.map(item => item.sangat_tidak_setuju) : [0],
                backgroundColor: themeColors.sts,
                borderRadius: 6,
                barPercentage: 0.8,
                categoryPercentage: 0.8
            }
        ];

        const ctx = document.getElementById('kuesionerChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        titleFont: { size: 10, weight: 'bold', family: 'Inter' },
                        bodyFont: { size: 12, weight: 'bold', family: 'Inter' },
                        displayColors: true,
                        callbacks: {
                            label: (context) => ` ${context.dataset.label}: ${context.raw.toFixed(1)}%`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                        ticks: {
                            font: { size: 11, weight: 'bold' },
                            color: '#94a3b8',
                            callback: (value) => value + '%'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, weight: 'bold' },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
