@extends('layouts.app')
@section('title', 'Capaian Renstra - Politeknik Jambi')
@section('content')

@php
    $allAvailableYears = $availableYears;
    $minYear = $allAvailableYears->min();
    $maxYear = $allAvailableYears->max();
@endphp

<div class="font-sans bg-slate-100 dark:bg-[#0b1120] min-h-screen transition-colors duration-300 pb-20">

    {{-- ===== HERO BANNER ===== --}}
    <div class="w-full bg-[#0b1120] py-16 px-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-transparent to-cyan-500/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase leading-tight drop-shadow-2xl" style="font-family:'Space Grotesk',sans-serif;">
                PERFORMANCE <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">MONITORING</span>
            </h1>
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 mt-6">
                <p class="text-slate-400 text-sm font-bold uppercase tracking-[0.3em]">Politeknik Jambi – Capaian Renstra Institusi</p>
                <button onclick="toggleAdminPanel()" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/20 px-6 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2 group">
                    <i class="fas fa-cog group-hover:rotate-90 transition-transform"></i> Kelola Data
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 md:px-8 -mt-8 relative z-20">

        {{-- ===== YEAR FILTER ===== --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-2xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/20">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">Visualisasi Capaian</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Filter data berdasarkan tahun strategis</p>
                </div>
            </div>
            
            <div class="relative group min-w-[240px]">
                <select onchange="window.location.href='/capaian-renstra?tahun='+this.value"
                        class="w-full appearance-none bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer pr-12 transition-all hover:bg-slate-100 dark:hover:bg-slate-700">
                    @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                        Periode Tahun {{ $year }}
                    </option>
                    @endforeach
                </select>
                <div class="absolute right-5 top-1/2 -translate-y-1/2 w-6 h-6 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500 pointer-events-none group-hover:scale-110 transition-transform">
                    <i class="fas fa-calendar-alt text-[10px]"></i>
                </div>
            </div>
        </div>

        @if($availableYears->isEmpty())
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-20 text-center shadow-xl border border-slate-100 dark:border-white/5">
            <i class="fas fa-inbox text-slate-200 dark:text-slate-700 text-6xl mb-6"></i>
            <h3 class="text-xl font-bold text-slate-700 dark:text-white">Data Belum Tersedia</h3>
            <p class="text-slate-400 mt-2">Silakan import data Renstra terlebih dahulu melalu dashboard.</p>
        </div>
        @else

        {{-- ===== ADMIN MANAGEMENT PANEL (TOGGLEABLE) ===== --}}
        <div id="adminPanel" class="hidden animate-in fade-in slide-in-from-top-4 duration-500 mb-8">
            <div class="bg-slate-900 rounded-[2.5rem] p-10 shadow-2xl border border-slate-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10 text-9xl text-white pointer-events-none rotate-12"><i class="fas fa-file-excel"></i></div>
                
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-10">
                    {{-- Quick Import --}}
                    <div class="space-y-6">
                        <h4 class="text-cyan-400 text-[10px] font-black uppercase tracking-[0.3em]">Excel Quick Import</h4>
                        <div class="bg-slate-800/50 rounded-3xl p-8 border border-white/5">
                            <form onsubmit="event.preventDefault(); submitClientImport();" class="space-y-4">
                                <label class="block group cursor-pointer">
                                    <div class="border-2 border-dashed border-slate-700 group-hover:border-blue-500 rounded-2xl p-6 transition-all text-center">
                                        <i class="fas fa-cloud-upload-alt text-slate-500 group-hover:text-blue-500 text-2xl mb-2"></i>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pilih File .xlsx</p>
                                        <input type="file" id="client_excel" class="hidden" accept=".xlsx,.xls">
                                    </div>
                                </label>
                                <button type="submit" id="clientImportBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest text-[10px] py-4 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-upload"></i> Upload & Sync
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Live Editor Grid --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.3em]">Live Data Editor (Tahun {{ $selectedYear }})</h4>
                            <button onclick="saveGridChanges()" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                        <div class="bg-slate-800/50 rounded-3xl overflow-hidden border border-white/5">
                            <div class="overflow-x-auto max-h-[400px] no-scrollbar">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-slate-800 sticky top-0 z-10">
                                        <tr>
                                            <th class="px-6 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-700">Indikator</th>
                                            <th class="px-6 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-700 text-center w-20">Target</th>
                                            <th class="px-6 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-700 text-center w-20">Realisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="liveGridBody">
                                        @foreach($data->flatten() as $item)
                                        <tr data-id="{{ $item->id }}" class="border-b border-slate-800/50 hover:bg-white/5 transition-colors group">
                                            <td class="px-6 py-3">
                                                <input type="text" value="{{ $item->indikator }}" 
                                                       class="bg-transparent border-none focus:ring-0 text-xs font-bold text-slate-300 w-full p-0">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" step="0.01" value="{{ $item->target }}" 
                                                       oninput="syncLiveChart()"
                                                       class="grid-input bg-slate-900 border border-slate-700 rounded-lg text-[10px] font-black text-blue-400 text-center w-16 py-1.5 focus:border-blue-500 focus:ring-0">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" step="0.01" value="{{ $item->realisasi }}" 
                                                       oninput="syncLiveChart()"
                                                       class="grid-input bg-slate-900 border border-slate-700 rounded-lg text-[10px] font-black text-emerald-400 text-center w-16 py-1.5 focus:border-emerald-500 focus:ring-0">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== MAIN TREND CHART ===== --}}
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-200 dark:border-white/10 p-10 shadow-2xl mb-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10 gap-4">
                <div>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tighter">Tren Capaian <span class="text-blue-500">Tahunan</span></h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Rata-rata Target vs Realisasi Seluruh Indikator</p>
                </div>
                <div class="flex gap-6">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Target</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Realisasi</span>
                    </div>
                </div>
            </div>
            
            <div class="relative h-[400px]">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- ===== INDICATOR DETAIL SECTION ===== --}}
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-200 dark:border-white/10 p-10 shadow-2xl">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10 gap-6">
                <div class="max-w-md">
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tighter">Detail <span class="text-cyan-500">Capaian Indikator</span></h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Pilih indikator untuk melihat tren multi-tahun secara spesifik</p>
                </div>
                
                <div class="flex-1 w-full relative">
                    <select id="indicatorSelector" onchange="updateIndicatorChart(this.value)"
                            class="w-full appearance-none bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm font-bold text-slate-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 cursor-pointer pr-12 transition-all">
                        <option value="">Pilih Indikator Kinerja...</option>
                        @foreach($indicators as $program => $items)
                            <optgroup label="{{ $program ?: 'Lainnya' }}">
                                @foreach($items as $item)
                                    <option value="{{ $item->indikator }}">{{ $item->indikator }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-cyan-500 pointer-events-none">
                        <i class="fas fa-search text-xs"></i>
                    </div>
                </div>
            </div>

            <div id="noDataIndicator" class="h-[350px] flex flex-col items-center justify-center text-slate-400 bg-slate-50/50 dark:bg-slate-900/30 rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-800">
                <i class="fas fa-chart-area text-4xl mb-4 opacity-50"></i>
                <p class="font-bold uppercase tracking-widest text-[10px]">Silakan pilih indikator terlebih dahulu</p>
            </div>

            <div id="chartContainerIndicator" class="relative h-[350px] hidden">
                <canvas id="indicatorDetailChart"></canvas>
            </div>
        </div>

        @endif {{-- end availableYears not empty --}}

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark     = document.documentElement.classList.contains('dark');
    const gridColor  = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const tickColor  = isDark ? 'rgba(148,163,184,0.8)'  : 'rgba(71,85,105,0.8)';
    const bgTooltip  = isDark ? 'rgba(15,23,42,0.95)'    : 'rgba(255,255,255,0.97)';
    const txtTooltip = isDark ? '#fff'                    : '#0f172a';

    const yearlyStats  = @json($yearlyStats);

    const trendCtx = document.getElementById('trendChart');
    if (trendCtx && yearlyStats.length > 0) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: yearlyStats.map(s => s.tahun),
                datasets: [
                    {
                        label: 'Target (%)',
                        data: yearlyStats.map(s => s.avg_target),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59,130,246,0.05)',
                        borderWidth: 5,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3B82F6',
                        pointBorderWidth: 4,
                        pointRadius: 7, pointHoverRadius: 10,
                        fill: true, tension: 0.4
                    },
                    {
                        label: 'Realisasi (%)',
                        data: yearlyStats.map(s => s.avg_realisasi),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16,185,129,0.05)',
                        borderWidth: 5,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10B981',
                        pointBorderWidth: 4,
                        pointRadius: 7, pointHoverRadius: 10,
                        fill: true, tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: bgTooltip, titleColor: txtTooltip,
                        bodyColor: isDark ? '#94a3b8' : '#475569',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 16, weight: '900' },
                        padding: 16, 
                        cornerRadius: 16,
                        callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw}%` }
                    }
                },
                scales: {
                    x: { 
                        grid: { color: gridColor, drawBorder: false }, 
                        ticks: { color: tickColor, font: { weight: '900', size: 12 }, padding: 10 } 
                    },
                    y: {
                        beginAtZero: false, max: 100,
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: tickColor, font: { size: 11, weight: 'bold' }, padding: 10, callback: v => v + '%' }
                    }
                },
                interaction: { mode: 'index', intersect: false },
                animation: { duration: 2000, easing: 'easeOutQuart' }
            }
        });
    }

    let indicatorChart = null;

    window.updateIndicatorChart = function(indikator) {
        if (!indikator) {
            document.getElementById('noDataIndicator').classList.remove('hidden');
            document.getElementById('chartContainerIndicator').classList.add('hidden');
            return;
        }

        document.getElementById('noDataIndicator').classList.add('hidden');
        document.getElementById('chartContainerIndicator').classList.remove('hidden');

        fetch(`/api/renstra/indicator-stats?indikator=${encodeURIComponent(indikator)}`)
            .then(r => r.json())
            .then(res => {
                if (!res.success) return;
                
                const stats = res.data;
                const labels = stats.map(s => s.tahun);
                const targets = stats.map(s => s.target);
                const realisasi = stats.map(s => s.realisasi);

                if (indicatorChart) {
                    indicatorChart.destroy();
                }

                const ctx = document.getElementById('indicatorDetailChart').getContext('2d');
                indicatorChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Target (%)',
                                data: targets,
                                borderColor: '#06B6D4',
                                backgroundColor: 'rgba(6,182,212,0.05)',
                                borderWidth: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#06B6D4',
                                pointRadius: 5,
                                fill: true, tension: 0.4
                            },
                            {
                                label: 'Realisasi (%)',
                                data: realisasi,
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16,185,129,0.05)',
                                borderWidth: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#10B981',
                                pointRadius: 5,
                                fill: true, tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: bgTooltip, titleColor: txtTooltip,
                                padding: 12, cornerRadius: 12,
                                callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw}%` }
                            }
                        },
                        scales: {
                            x: { grid: { color: gridColor }, ticks: { color: tickColor, font: { weight: 'bold' } } },
                            y: { 
                                beginAtZero: true, max: 100, 
                                grid: { color: gridColor }, 
                                ticks: { color: tickColor, callback: v => v + '%' } 
                            }
                        }
                    }
                });
            });
    }

    // ===== LIVE SYNC & ADMIN PANEL LOGIC =====
    window.toggleAdminPanel = function() {
        const panel = document.getElementById('adminPanel');
        panel.classList.toggle('hidden');
    }

    window.syncLiveChart = function() {
        const rows = document.querySelectorAll('#liveGridBody tr');
        let sumTarget = 0, sumReal = 0, count = 0;
        
        rows.forEach(row => {
            const inputs = row.querySelectorAll('input');
            const target = parseFloat(inputs[1].value) || 0;
            const real   = parseFloat(inputs[2].value) || 0;
            sumTarget += target;
            sumReal += real;
            count++;
        });

        if (count > 0 && trendChart) {
            const avgTarget = +(sumTarget / count).toFixed(2);
            const avgReal   = +(sumReal / count).toFixed(2);
            
            // Update the last point of the trend chart (for current year)
            const yearIndex = yearlyStats.findIndex(s => s.tahun == "{{ $selectedYear }}");
            if (yearIndex !== -1) {
                trendChart.data.datasets[0].data[yearIndex] = avgTarget;
                trendChart.data.datasets[1].data[yearIndex] = avgReal;
                trendChart.update('none'); // silent update
            }
        }
    }

    window.saveGridChanges = function() {
        const rows = document.querySelectorAll('#liveGridBody tr');
        const data = Array.from(rows).map(row => {
            const inputs = row.querySelectorAll('input');
            return {
                id: row.dataset.id,
                indikator: inputs[0].value,
                target: inputs[1].value,
                realisasi: inputs[2].value
            };
        });

        fetch('/api/renstra/bulk-update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ data })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert('Data berhasil disimpan!');
                window.location.reload();
            } else {
                alert('Gagal menyimpan: ' + (res.message || 'Error Unknown'));
            }
        });
    }

    window.submitClientImport = function() {
        const fileInput = document.getElementById('client_excel');
        const file = fileInput.files[0];
        if (!file) { alert('Pilih file terlebih dahulu'); return; }

        const btn = document.getElementById('clientImportBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

        const fd = new FormData();
        fd.append('file', file);
        fd.append('_token', '{{ csrf_token() }}');

        fetch('/admin/renstra/import', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-upload"></i> Upload & Sync';
                if (res.success) {
                    alert('Data berhasil diimpor!');
                    window.location.reload();
                } else {
                    alert('Error: ' + res.message);
                }
            })
            .catch(err => {
                alert('Terjadi kesalahan koneksi.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-upload"></i> Upload & Sync';
            });
    }
});
</script>
@endpush

<style>
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;600;700;800&display=swap');
body { 
    font-family: 'Inter', sans-serif; 
    overflow-x: hidden;
}
</style>

@endsection
