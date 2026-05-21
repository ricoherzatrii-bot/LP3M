@extends('layouts.app')
@section('title', 'Capaian Renstra - Politeknik Jambi')
@section('content')

<div class="relative min-h-screen bg-slate-50 dark:bg-[#0A0F1C] pb-24 font-sans overflow-hidden transition-colors duration-500">
    {{-- ===== BACKGROUND ===== --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(37,99,235,0.1),transparent_70%)]"></div>
        <div class="absolute top-1/4 -right-1/4 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-emerald-600/10 rounded-full blur-[120px]"></div>
    </div>

    {{-- ===== HERO HEADER ===== --}}
    <div class="relative z-10 pt-24 pb-16 text-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-16">
            <div class="inline-flex items-center gap-2.5 bg-blue-500/10 border border-blue-500/20 px-4 py-2 rounded-xl text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-6 backdrop-blur-md">
                <i class="fas fa-chart-line"></i> Strategic Plan Achievement
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white mb-6 tracking-tighter" style="font-family: 'Space Grotesk', sans-serif;">
                CAPAIAN <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-emerald-400">RENSTRA</span>
            </h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm md:text-lg max-w-3xl mx-auto leading-relaxed border-l-2 border-blue-500/30 pl-6">
                Visualisasi pencapaian indikator kinerja utama sesuai dengan Rencana Strategis Politeknik Jambi. Data diperbarui secara berkala untuk menjamin transparansi mutu.
            </p>
        </div>
    </div>

    {{-- ===== CONTENT AREA ===== --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16">
        
        @if($data->isEmpty())
        <div class="bg-slate-800/20 backdrop-blur-xl rounded-[2.5rem] border border-white/5 p-20 text-center">
            <div class="w-20 h-20 bg-slate-800/50 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-white/10">
                <i class="fas fa-chart-bar text-slate-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Data Belum Tersedia</h3>
            <p class="text-slate-500 max-w-sm mx-auto">Sistem sedang menyiapkan data capaian Renstra terbaru. Silakan kembali beberapa saat lagi.</p>
        </div>
        @else
        
        <!-- Statistics Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white dark:bg-slate-800/40 backdrop-blur-xl p-8 rounded-[2rem] border border-slate-200 dark:border-white/5 group hover:border-blue-500/30 transition-all duration-500 shadow-sm">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Total Program</p>
                <div class="flex items-end gap-3">
                    <span class="text-4xl font-black text-slate-900 dark:text-white group-hover:text-blue-400 transition-colors">{{ $data->count() }}</span>
                    <span class="text-slate-500 text-xs font-bold mb-1.5 uppercase tracking-widest">Pilar Strategis</span>
                </div>
            </div>
            @php 
                $allData = $data->flatten(); 
            @endphp
            <div class="bg-white dark:bg-slate-800/40 backdrop-blur-xl p-8 rounded-[2rem] border border-slate-200 dark:border-white/5 group hover:border-emerald-500/30 transition-all duration-500 shadow-sm">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Rerata Capaian</p>
                <div class="flex items-end gap-3">
                    <span class="text-4xl font-black text-slate-900 dark:text-white group-hover:text-emerald-400 transition-colors">
                        {{ number_format($allData->avg('realisasi'), 1) }}%
                    </span>
                    <span class="text-slate-500 text-xs font-bold mb-1.5 uppercase tracking-widest">Indikator</span>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800/40 backdrop-blur-xl p-8 rounded-[2rem] border border-slate-200 dark:border-white/5 group hover:border-amber-500/30 transition-all duration-500 shadow-sm">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Rentang Waktu</p>
                <div class="flex items-end gap-3">
                    <span class="text-4xl font-black text-slate-900 dark:text-white group-hover:text-amber-400 transition-colors">
                        {{ $allData->min('tahun') }} - {{ $allData->max('tahun') }}
                    </span>
                    <span class="text-slate-500 text-xs font-bold mb-1.5 uppercase tracking-widest">Renstra</span>
                </div>
            </div>
        </div>

        <!-- Sunburst Hierarchy Visual -->
        <div class="mb-16">
            <div class="bg-white dark:bg-slate-800/40 backdrop-blur-xl p-10 lg:p-16 rounded-[3rem] border border-slate-200 dark:border-white/5 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"></div>
                <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col items-center text-center mb-12">
                    <div class="inline-flex items-center gap-2 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 px-4 py-1.5 rounded-full text-[9px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.3em] mb-6">
                        <i class="fas fa-project-diagram"></i> Hierarchical Map
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 tracking-tighter uppercase font-display">PETA CAPAIAN <span class="text-blue-400">HIERARKI</span></h2>
                    <p class="text-slate-500 text-sm max-w-2xl leading-relaxed">Klik pada lingkaran untuk mendalami rincian (drill-down) dari Program ke Indikator Kinerja.</p>
                </div>

                <div id="sunburstContainer" class="w-full h-[700px] md:h-[850px] relative z-10">
                    <!-- ECharts will be rendered here -->
                </div>
            </div>
        </div>

        @foreach($data as $programName => $items)
        <div class="mb-20">
            <!-- Program Header -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight uppercase">{{ $programName ?: 'Program Strategis Umum' }}</h2>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Grup Indikator Kinerja</p>
                </div>
                <div class="flex-grow border-t border-white/5 ml-4"></div>
            </div>

            <!-- Chart & Table Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Chart -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-slate-200 dark:border-white/5 shadow-2xl relative overflow-hidden">
                    <div class="flex justify-between items-start mb-10 relative z-10">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white font-display mb-2">Visualisasi Capaian</h3>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Target</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Realisasi</span>
                            </div>
                        </div>
                    </div>
                    <div class="relative h-[400px] w-full">
                        <canvas id="chart-{{ Str::slug($programName) }}"></canvas>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-xl rounded-[2.5rem] border border-slate-200 dark:border-white/5 overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-900/60 transition-colors">
                                    <th class="px-8 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest">Indikator</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center">PIC</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center">Tahun</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-slate-400">
                                @foreach($items as $item)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="text-xs font-bold text-slate-300 transition-colors group-hover:text-blue-300 truncate max-w-[200px]" title="{{ $item->indikator }}">
                                            {{ $item->indikator }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="text-[9px] font-black text-slate-500 uppercase bg-slate-700/30 px-2 py-1 rounded">{{ $item->pic ?: '-' }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-center text-[10px] font-black text-blue-400">{{ $item->tahun }}</td>
                                    <td class="px-8 py-5 text-right">
                                        @php
                                            $diff = $item->realisasi - $item->target;
                                            $icon = $diff >= 0 ? 'fa-check-circle text-emerald-400' : 'fa-exclamation-circle text-rose-400';
                                        @endphp
                                        <i class="fas {{ $icon }}"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupedData = @json($data);
        
        // ===== INITIALIZE SUNBURST CHART =====
        const sunburstDom = document.getElementById('sunburstContainer');
        if(sunburstDom) {
            const myChart = echarts.init(sunburstDom);
            
            const sunburstData = Object.keys(groupedData).map((program, idx) => {
                const items = groupedData[program];
                const colors = ['#60A5FA', '#34D399', '#FB7185', '#FBBF24', '#A78BFA', '#2DD4BF'];
                
                return {
                    name: program ? (program.length > 30 ? program.substring(0, 30) + '...' : program) : 'Lainnya',
                    fullName: program,
                    itemStyle: { color: colors[idx % colors.length] },
                    children: items.map(item => ({
                        name: item.indikator.length > 20 ? item.indikator.substring(0, 20) + '...' : item.indikator,
                        fullName: item.indikator,
                        value: item.realisasi,
                        itemStyle: { 
                            color: item.realisasi >= item.target ? '#10B981' : '#F43F5E',
                            opacity: 0.8
                        }
                    }))
                };
            });

            const option = {
                title: {
                    text: 'RENSTRA\nPOLJAM',
                    left: 'center',
                    top: 'center',
                    textStyle: {
                        color: '#fff',
                        fontSize: 16,
                        fontWeight: '900',
                        fontFamily: 'Space Grotesk',
                        lineHeight: 20
                    }
                },
                tooltip: {
                    formatter: function(params) {
                        return `<div class="bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-white/10 p-4 rounded-2xl font-sans">
                                    <p class="text-[10px] text-blue-400 font-black uppercase tracking-widest mb-2">${params.data.fullName || params.name}</p>
                                    ${params.value ? `<div class="flex items-center gap-3">
                                        <p class="text-2xl text-slate-900 dark:text-white font-black">${params.value}%</p>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-slate-500 font-bold uppercase">Realisasi</span>
                                            <span class="text-[9px] ${params.value >= 80 ? 'text-emerald-400' : 'text-amber-400'} font-bold uppercase tracking-tighter">Performance</span>
                                        </div>
                                    </div>` : ''}
                                </div>`;
                    },
                    padding: 0,
                    backgroundColor: 'transparent',
                    borderWidth: 0
                },
                series: {
                    type: 'sunburst',
                    data: sunburstData,
                    radius: ['15%', '95%'],
                    sort: null,
                    emphasis: { focus: 'ancestor' },
                    levels: [
                        {},
                        {
                            r0: '15%', r: '45%',
                            itemStyle: { borderWidth: 3, borderColor: '#fff0', borderRadius: 8 },
                            label: { rotate: 'tangential', color: '#fff', fontSize: 12, fontWeight: '900', minAngle: 10 }
                        },
                        {
                            r0: '45%', r: '85%',
                            itemStyle: { borderWidth: 2, borderColor: '#fff0', borderRadius: 4 },
                            label: { color: '#ffffff', fontSize: 10, padding: [0, 5], minAngle: 5, fontWeight: '500' }
                        },
                        {
                            r0: '85%', r: '90%',
                            itemStyle: { shadowBlur: 20, shadowColor: 'rgba(0,0,0,0.5)', opacity: 0.3 },
                            label: { show: false }
                        }
                    ],
                    animationDuration: 2500,
                    animationEasing: 'cubicOut'
                }
            };

            myChart.setOption(option);
            window.addEventListener('resize', () => myChart.resize());
        }

        // ===== BAR CHARTS =====
        Object.keys(groupedData).forEach(program => {
            const items = groupedData[program];
            const canvasId = 'chart-' + slugify(program);
            const ctx = document.getElementById(canvasId);
            if(!ctx) return;

            const labels = items.map(item => item.indikator.length > 25 ? item.indikator.substring(0, 25) + '...' : item.indikator);
            const targets = items.map(item => item.target);
            const realizations = items.map(item => item.realisasi);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Target (%)',
                            data: targets,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1,
                            borderRadius: 8,
                            barPercentage: 0.7,
                            categoryPercentage: 0.6
                        },
                        {
                            label: 'Realisasi (%)',
                            data: realizations,
                            backgroundColor: 'rgba(16, 185, 129, 0.5)',
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 1,
                            borderRadius: 8,
                            barPercentage: 0.7,
                            categoryPercentage: 0.6
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            padding: 12,
                            cornerRadius: 12,
                            callbacks: {
                                title: (context) => items[context[0].dataIndex].indikator,
                                label: (context) => ` ${context.dataset.label}: ${context.raw}%`
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                            ticks: { color: 'rgba(148, 163, 184, 0.6)', font: { size: 10 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { color: 'rgba(71, 85, 105, 0.8)', font: { weight: 'bold', size: 10 } }
                        }
                    }
                }
            });
        });

        function slugify(text) {
            if(!text) return '';
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }
    });
</script>
@endpush

<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;600;700;800&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
    }
</style>

@endsection
