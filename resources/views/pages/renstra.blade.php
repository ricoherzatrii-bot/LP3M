@extends('layouts.app')
@section('title', 'Capaian Renstra - Politeknik Jambi')
@section('content')

@php
    $allAvailableYears = $availableYears;
    $minYear = $allAvailableYears->min();
    $maxYear = $allAvailableYears->max();
    
    // Fallback sample data if database is empty to show the UI
    $isDemo = $availableYears->isEmpty();
    if ($isDemo) {
        $availableYears = collect([2021, 2022, 2023, 2024, 2025]);
        $selectedYears = collect([2024]);
        $data = collect(); 
    } else {
        $selectedYears = collect($selectedYears);
    }
@endphp

<div class="font-sans bg-slate-50 dark:bg-[#0b1120] min-h-screen transition-colors duration-300 pb-16">


    <div class="max-w-[1650px] mx-auto px-6 py-10">
        
        <div class="flex flex-col lg:flex-row gap-10">
            {{-- Left Sidebar: Logo, Filter, and Chart --}}
            <div class="w-full lg:w-1/3 space-y-8 animate-in slide-in-from-left duration-700">
                <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-10 shadow-2xl border border-slate-100 dark:border-white/5 flex flex-col items-center relative overflow-hidden backdrop-blur-xl">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl"></div>
                    <img src="{{ asset('images/logo.png') }}" class="w-56 mb-8 transform hover:scale-105 transition-transform duration-500" alt="Poljam Logo">
                    <div class="text-center relative z-10">
                        <h3 class="text-2xl font-black text-[#e67e22] leading-tight tracking-tight mb-1">Politeknik Jambi</h3>
                        <p class="text-[11px] font-black text-blue-800 dark:text-blue-400 uppercase tracking-widest leading-relaxed">Lembaga Perencanaan Pengembangan<br>& Penjaminan Mutu</p>
                    </div>

                    <div class="w-full mt-12 space-y-6">
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2 px-1">Periode Strategis (Pilih Tahun)</label>
                            <div class="relative group">
                                <div id="multiYearSelector" class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-white/5 rounded-2xl px-8 py-5 text-sm font-black text-slate-700 dark:text-white cursor-pointer transition-all hover:bg-slate-100 dark:hover:bg-slate-700 flex justify-between items-center" onclick="toggleYearDropdown()">
                                    <span id="selectedYearsText">
                                        @if($selectedYears->count() == $availableYears->count())
                                            SEMUA TAHUN (PRESENTASI)
                                        @elseif($selectedYears->count() == 1)
                                            TAHUN {{ $selectedYears->first() }}
                                        @else
                                            {{ $selectedYears->count() }} TAHUN TERPILIH
                                        @endif
                                    </span>
                                    <i class="fas fa-calendar-check text-blue-500"></i>
                                </div>
                                
                                <div id="yearDropdown" class="hidden relative mt-6 bg-slate-50 dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 rounded-3xl p-8 space-y-4 animate-in fade-in slide-in-from-top-4 duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun (Kecualikan)</span>
                                        <button type="button" onclick="selectAllYears()" class="text-[10px] font-black text-blue-500 uppercase hover:underline">Pilih Semua</button>
                                    </div>
                                    <div class="max-h-60 overflow-y-auto pr-2 space-y-2 no-scrollbar">
                                        @foreach($availableYears as $year)
                                        <label class="flex items-center p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-900/50 cursor-pointer transition-all group">
                                            <div class="relative flex items-center justify-center">
                                                <input type="checkbox" value="{{ $year }}" class="year-checkbox w-6 h-6 rounded-lg border-2 border-slate-200 dark:border-slate-700 text-blue-600 focus:ring-blue-500/20 mr-4 cursor-pointer transition-all" {{ $selectedYears->contains($year) ? 'checked' : '' }}>
                                            </div>
                                            <span class="text-sm font-bold text-slate-700 dark:text-white group-hover:text-blue-500 transition-colors flex-1" onclick="selectSingleYear(event, '{{ $year }}')">TAHUN STRATEGIS {{ $year }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    <button onclick="applyYearFilter()" class="w-full mt-2 bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest text-[10px] py-5 rounded-2xl shadow-xl shadow-blue-500/20 transition-all active:scale-95">
                                        Tampilkan Presentasi
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($isDemo)
                            <div class="bg-amber-500/10 border-2 border-amber-500/20 rounded-2xl p-5 flex items-center gap-4 animate-pulse">
                                <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-white text-lg">
                                    <i class="fas fa-vial"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-widest mb-0.5">Preview Mode</p>
                                    <p class="text-[9px] text-amber-500/80 font-bold leading-tight">Menampilkan data simulasi (Database kosong)</p>
                                </div>
                            </div>
                        @endif

                        <button onclick="toggleAdminPanel()" class="w-full bg-slate-900 hover:bg-slate-800 text-white px-8 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all flex items-center justify-center gap-4 shadow-xl active:scale-95 group">
                            <i class="fas fa-sliders-h opacity-50 group-hover:rotate-90 transition-transform"></i> Control Panel Management
                        </button>
                    </div>
                </div>

                {{-- Horizontal Multi-Year Chart --}}
                <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-10 shadow-2xl border border-slate-100 dark:border-white/5 animate-in fade-in zoom-in duration-1000 delay-300">
                    <div class="flex items-center justify-between mb-8 border-b border-slate-50 dark:border-white/5 pb-5">
                        <h4 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest">Growth Performance Trend</h4>
                        <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-500">
                            <i class="fas fa-chart-bar text-[10px]"></i>
                        </div>
                    </div>
                    <div class="relative h-[650px]">
                        <canvas id="horizontalProgramChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Right Main Content: 8 Pillars Grid --}}
            <div class="w-full lg:w-2/3 space-y-8 animate-in slide-in-from-right duration-700">
                <div class="bg-slate-800 dark:bg-slate-850 text-white py-6 px-10 rounded-[2rem] shadow-2xl border-b-8 border-slate-950 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 via-transparent to-purple-600/10 pointer-events-none group-hover:opacity-50 transition-opacity"></div>
                    <h3 class="text-2xl font-black tracking-[0.3em] uppercase text-center relative z-10 drop-shadow-lg">CAPAIAN 8 PILAR (TUJUAN) POLJAM</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                        $pillars = [
                            ['id' => 'I', 'title' => 'Pengembangan Sistem Pengelolaan berbasis SMART Campus untuk Menuju kwalitas Regional', 'color' => '#1e3a8a', 'bg' => 'bg-gradient-to-br from-[#1e3a8a] to-blue-900', 'demo' => 85.5],
                            ['id' => 'V', 'title' => 'Kualitas sumberdaya manusia melalui manajemen berbasis kinerja', 'color' => '#f1c40f', 'bg' => 'bg-gradient-to-br from-[#f1c40f] to-amber-600', 'demo' => 92.0],
                            ['id' => 'II', 'title' => 'Membangun Poltek Jambi branding melalui global networking for global partnership', 'color' => '#16a085', 'bg' => 'bg-gradient-to-br from-[#16a085] to-emerald-800', 'demo' => 78.4],
                            ['id' => 'VI', 'title' => 'Kualitas manajemen aset yang integratif, efektif dan efisien melalui kebijakan resources sharing, berwawasan lingkungandan berkelanjutan', 'color' => '#2ecc71', 'bg' => 'bg-gradient-to-br from-[#2ecc71] to-green-700', 'demo' => 88.9],
                            ['id' => 'III', 'title' => 'Menjadi pusat penyelenggaraan kegiatan akademik yang unggul dan berlandaskan academic exellence berstandar nasional dan internasional', 'color' => '#e91e63', 'bg' => 'bg-gradient-to-br from-[#e91e63] to-pink-800', 'demo' => 95.2],
                            ['id' => 'VII', 'title' => 'Kapasitas institusi dalam pengelolaan', 'color' => '#8e44ad', 'bg' => 'bg-gradient-to-br from-[#8e44ad] to-purple-900', 'demo' => 82.1],
                            ['id' => 'IV', 'title' => 'Menjadi pusat penelitian yang unggul (research exellence) sesuai perkembangan IPTEKS yang berorientasi pada pemberdayaan masyarakat.', 'color' => '#e67e22', 'bg' => 'bg-gradient-to-br from-[#e67e22] to-orange-700', 'demo' => 74.6],
                            ['id' => 'VIII', 'title' => 'Kemandirian keuangan dengan pengelolaan yang akuntabel dan transparan, efektif, dan efisien sesuai standar yang berlaku.', 'color' => '#3498db', 'bg' => 'bg-gradient-to-br from-[#3498db] to-blue-600', 'demo' => 100.0],
                        ];
                    @endphp

                    @foreach($pillars as $pillar)
                        <div class="{{ $pillar['bg'] }} text-white p-10 rounded-[3rem] shadow-2xl min-h-[250px] flex flex-col justify-between transform transition-all hover:scale-[1.03] hover:-translate-y-2 cursor-pointer border border-white/20 group relative overflow-hidden backdrop-filter">
                            <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/15 transition-all duration-700"></div>
                            <div class="relative z-10">
                                <h4 class="text-[12px] font-black uppercase leading-relaxed mb-6 tracking-widest drop-shadow-sm">
                                    <span class="bg-white/20 text-[10px] px-3 py-1.5 rounded-xl mr-3 border border-white/20">{{ $pillar['id'] }}</span> {{ $pillar['title'] }}
                                </h4>
                            </div>
                            <div class="text-right relative z-10">
                                @php
                                    $avgRealisasi = 0;
                                    if (!$isDemo) {
                                        $programData = $data->filter(function($items, $program) use ($pillar) {
                                            return str_starts_with($program, $pillar['id'] . '.');
                                        })->first();
                                        $avgRealisasi = $programData ? round($programData->avg('realisasi'), 2) : 0;
                                    } else {
                                        $avgRealisasi = $pillar['demo'];
                                    }
                                @endphp
                                <div class="flex items-baseline justify-end gap-2 group-hover:scale-110 transition-transform">
                                    <span class="text-7xl font-black tracking-tighter drop-shadow-2xl">{{ $avgRealisasi }}</span>
                                    <span class="text-3xl font-black opacity-50">%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===== ADMIN MANAGEMENT PANEL (TOGGLEABLE) ===== --}}
        <div id="adminPanel" class="hidden animate-in fade-in slide-in-from-top-10 duration-700 my-10">
            <div class="bg-slate-900 rounded-[3rem] p-12 shadow-2xl border border-slate-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-12 opacity-5 text-9xl text-white pointer-events-none rotate-12"><i class="fas fa-database"></i></div>
                
                <h3 class="text-white text-2xl font-black uppercase tracking-widest mb-10 border-b border-white/10 pb-6 flex items-center gap-4">
                    <i class="fas fa-tools text-blue-500"></i> Renstra Data Engine
                </h3>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-12">
                    {{-- Quick Import --}}
                    <div class="space-y-6">
                        <h4 class="text-cyan-400 text-[10px] font-black uppercase tracking-[0.4em]">Excel Synchronization</h4>
                        <div class="bg-black/30 rounded-3xl p-10 border border-white/5 backdrop-blur-md">
                            <form onsubmit="event.preventDefault(); submitClientImport();" class="space-y-6">
                                <label class="block group cursor-pointer">
                                    <div class="border-2 border-dashed border-slate-700 group-hover:border-blue-500 group-hover:bg-blue-500/5 rounded-2xl p-10 transition-all text-center">
                                        <i class="fas fa-file-excel text-slate-500 group-hover:text-blue-500 text-4xl mb-4"></i>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Drag & Drop Excel (.xlsx)</p>
                                        <input type="file" id="client_excel" class="hidden" accept=".xlsx,.xls">
                                    </div>
                                </label>
                                <button type="submit" id="clientImportBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all flex items-center justify-center gap-4 active:scale-95">
                                    <i class="fas fa-sync-alt"></i> Upload & Process Engine
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Live Editor Grid --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.4em]">Live Matrix Editor (Periode: {{ $selectedYears->count() > 1 ? 'Multi-Tahun' : 'Tahun ' . $selectedYears->first() }})</h4>
                            <button onclick="saveGridChanges()" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-2xl shadow-emerald-500/30 transition-all flex items-center gap-3 active:scale-95">
                                <i class="fas fa-cloud-upload-alt text-lg"></i> Commit Changes
                            </button>
                        </div>
                        <div class="bg-black/30 rounded-3xl overflow-hidden border border-white/5 backdrop-blur-md">
                            <div class="overflow-x-auto max-h-[450px] no-scrollbar">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-slate-800/80 sticky top-0 z-10 backdrop-blur-md">
                                        <tr>
                                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-white/5">Performance Indicator</th>
                                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-white/5 text-center w-28">Target %</th>
                                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-white/5 text-center w-28">Real %</th>
                                        </tr>
                                    </thead>
                                    <tbody id="liveGridBody">
                                        @forelse($data->flatten() as $item)
                                        <tr data-id="{{ $item->id }}" class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                                            <td class="px-8 py-4">
                                                <input type="text" value="{{ $item->indikator }}" 
                                                       class="bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-300 w-full p-0">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number" step="0.01" value="{{ $item->target }}" 
                                                       class="grid-input bg-slate-900/50 border border-slate-700 rounded-xl text-xs font-black text-blue-400 text-center w-20 py-2 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number" step="0.01" value="{{ $item->realisasi }}" 
                                                       class="grid-input bg-slate-900/50 border border-slate-700 rounded-xl text-xs font-black text-emerald-400 text-center w-20 py-2 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="px-8 py-20 text-center text-slate-500 font-bold uppercase tracking-widest text-[11px] italic">
                                                ( No Live Data - Please Sync using Excel )
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16 space-y-12">
            <div class="bg-white dark:bg-slate-800 rounded-[3.5rem] p-16 shadow-2xl border border-slate-100 dark:border-white/5 relative overflow-hidden">
                <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl"></div>
                <div class="flex items-center justify-between mb-12 pb-8 border-b border-slate-100 dark:border-white/5 relative z-10">
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-widest uppercase mb-2">Breakdown Indikator Kinerja</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-[0.4em]">Detail Realisasi Per Butir Perencanaan - Periode {{ $selectedYears->implode(', ') }}</p>
                    </div>
                    <div class="w-16 h-16 rounded-3xl bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-white/5 flex items-center justify-center text-blue-500 text-2xl shadow-inner">
                        <i class="fas fa-list-check"></i>
                    </div>
                </div>

                <div class="space-y-16 relative z-10">
                    @forelse($data as $program => $items)
                    <div class="animate-in fade-in slide-in-from-bottom-10 duration-700">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-10 py-6 rounded-[2rem] mb-8 shadow-xl transform -rotate-1 origin-left hover:rotate-0 transition-transform">
                            <h4 class="font-black text-white text-xl tracking-tight uppercase">{{ $program ?: 'Uncategorized Program' }}</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-4">
                            @foreach($items as $item)
                            <div class="bg-white dark:bg-slate-950/50 p-8 rounded-[3rem] border border-slate-100 dark:border-white/5 hover:border-blue-500/50 transition-all group shadow-sm hover:shadow-2xl hover:-translate-y-1">
                                <div class="flex gap-6">
                                    <div class="flex-1">
                                        <p class="text-sm font-black text-slate-700 dark:text-slate-300 leading-relaxed mb-8 min-h-[3rem]">{{ $item->indikator }}</p>
                                        <div class="space-y-3">
                                            <div class="flex justify-between text-[11px] font-black uppercase tracking-widest text-slate-400">
                                                <span>Target pencapaian</span>
                                                <span class="text-slate-800 dark:text-white">{{ $item->target }}%</span>
                                            </div>
                                            <div class="flex justify-between text-[11px] font-black uppercase tracking-widest text-slate-400">
                                                <span>Progress Realisasi</span>
                                                <span class="{{ $item->realisasi >= $item->target ? 'text-emerald-500' : 'text-blue-500' }} animate-pulse">{{ $item->realisasi }}%</span>
                                            </div>
                                            <div class="h-4 w-full bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden shadow-inner p-1">
                                                <div class="h-full {{ $item->realisasi >= $item->target ? 'bg-gradient-to-r from-emerald-400 to-emerald-600' : 'bg-gradient-to-r from-blue-400 to-blue-600' }} transition-all duration-1000 rounded-full shadow-lg" style="width: {{ min($item->realisasi, 100) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 rounded-[2rem] bg-slate-50 dark:bg-slate-900 border-4 {{ $item->realisasi >= $item->target ? 'border-emerald-500/20 text-emerald-500 shadow-emerald-500/10' : 'border-blue-500/20 text-blue-500 shadow-blue-500/10' }} flex items-center justify-center text-[14px] font-black shadow-xl italic transform group-hover:rotate-12 transition-transform">
                                            {{ round($item->realisasi, 0) }}%
                                        </div>
                                        <span class="text-[9px] font-black text-slate-400 uppercase mt-2 tracking-widest">Score</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                        @if(!$isDemo)
                        <div class="py-32 text-center opacity-40">
                            <i class="fas fa-chart-line text-8xl mb-8 text-slate-300"></i>
                            <h5 class="text-2xl font-black uppercase tracking-[0.2em] mb-2 text-slate-400">Deep Insights Not Available</h5>
                            <p class="text-xs font-bold text-slate-500">Silakan lengkapi data melalui Excel import untuk visualisasi mendalam.</p>
                        </div>
                        @else
                        {{-- Mockup Detail for Preview --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-4 opacity-50 blur-[1px]">
                            @for($i=0; $i<4; $i++)
                            <div class="bg-slate-50 dark:bg-slate-950/50 p-8 rounded-[3rem] border border-slate-200 border-dashed">
                                <div class="w-2/3 h-4 bg-slate-200 dark:bg-slate-800 rounded-lg mb-6"></div>
                                <div class="w-full h-8 bg-slate-100 dark:bg-slate-900 rounded-xl"></div>
                            </div>
                            @endfor
                        </div>
                        @endif
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark     = document.documentElement.classList.contains('dark');
    const gridColor  = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const tickColor  = isDark ? 'rgba(148,163,184,0.8)'  : 'rgba(71,85,105,0.8)';
    
    // Data for Horizontal Multi-Year Chart
    const allProgramStats = @json($allProgramStats);
    const availableYears = @json($availableYears).sort();
    const selectedYears = @json($selectedYears->sort()->values());
    const isDemo = @json($isDemo);
    
    const pillarColors = {
        'I': '#1e3a8a',
        'V': '#f1c40f',
        'II': '#16a085', 
        'VI': '#2ecc71',
        'III': '#e91e63',
        'VII': '#8e44ad',
        'IV': '#e67e22',
        'VIII': '#3498db'
    };

    const pillarLabelsShort = {
        'I': 'Pilar I',
        'II': 'Pilar II',
        'III': 'Pilar III',
        'IV': 'Pilar IV',
        'V': 'Pilar V',
        'VI': 'Pilar VI',
        'VII': 'Pilar VII',
        'VIII': 'Pilar VIII'
    };

    const datasets = Object.keys(pillarColors).map(key => {
        return {
            label: pillarLabelsShort[key],
            backgroundColor: pillarColors[key],
            borderRadius: 6,
            data: selectedYears.map(year => {
                if (isDemo) {
                    // Random-ish but stable demo data
                    const base = { 'I':80, 'II':70, 'III':90, 'IV':65, 'V':85, 'VI':75, 'VII':80, 'VIII':95 }[key];
                    return base + (year - 2021) * 3;
                }
                const progKey = Object.keys(allProgramStats).find(p => p.startsWith(key + '.'));
                if (progKey) {
                    const stats = allProgramStats[progKey].find(s => s.tahun == year);
                    return stats ? stats.avg_realisasi : 0;
                }
                return 0;
            }),
            barThickness: 8,
            maxBarThickness: 10,
        };
    });

    const ctxHorizontal = document.getElementById('horizontalProgramChart');
    if (ctxHorizontal) {
        new Chart(ctxHorizontal, {
            type: 'bar',
            data: {
                labels: selectedYears,
                datasets: datasets
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: tickColor,
                            font: { size: 10, weight: '900' },
                            boxWidth: 12,
                            padding: 20
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: isDark ? '#0f172a' : '#fff',
                        titleColor: isDark ? '#fff' : '#0f172a',
                        bodyColor: isDark ? '#94a3b8' : '#475569',
                        padding: 16,
                        cornerRadius: 16,
                        callbacks: {
                            label: function(context) {
                                return ` ${context.dataset.label}: ${context.raw}%`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { 
                            color: tickColor, 
                            font: { size: 10, weight: 'bold' },
                            callback: v => v + '%'
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { 
                            color: tickColor, 
                            font: { size: 12, weight: '900' }
                        }
                    }
                },
                animation: { duration: 2500, easing: 'easeOutQuart' }
            }
        });
    }

    // ===== ADMIN PANEL LOGIC =====
    window.toggleAdminPanel = function() {
        const panel = document.getElementById('adminPanel');
        if (panel) {
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) {
                panel.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }

    window.submitClientImport = function() {
        const fileInput = document.getElementById('client_excel');
        const file = fileInput.files[0];
        if (!file) { Swal.fire('Error', 'Pilih file terlebih dahulu', 'warning'); return; }

        const btn = document.getElementById('clientImportBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Syncing Matrix...';

        const fd = new FormData();
        fd.append('file', file);
        fd.append('_token', '{{ csrf_token() }}');

        fetch('/admin/renstra/import', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync-alt"></i> Upload & Process Engine';
                if (res.success) {
                    Swal.fire('Success!', 'Data Renstra Berhasil Tersinkronisasi!', 'success').then(() => window.location.reload());
                } else {
                    Swal.fire('Failed!', res.message, 'error');
                }
            })
            .catch(err => {
                Swal.fire('Error!', 'Connection Error.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync-alt"></i> Upload & Process Engine';
            });
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

        if (data.length === 0) return;

        fetch('/api/renstra/bulk-update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ data })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                Swal.fire('Committed!', 'Matrix data updated successfully!', 'success').then(() => window.location.reload());
            } else {
                Swal.fire('Error!', res.message || 'Unknown matrix error', 'error');
            }
        });
    }

    // ===== MULTI-YEAR FILTER LOGIC =====
    window.toggleYearDropdown = function() {
        const dropdown = document.getElementById('yearDropdown');
        dropdown.classList.toggle('hidden');
    }

    window.selectAllYears = function() {
        const checkboxes = document.querySelectorAll('.year-checkbox');
        const allChecked = Array.from(checkboxes).every(c => c.checked);
        checkboxes.forEach(c => c.checked = !allChecked);
    }

    window.selectSingleYear = function(event, year) {
        event.preventDefault();
        event.stopPropagation();
        
        const url = new URL(window.location.href);
        url.searchParams.set('tahun', year);
        window.location.href = url.toString();
    }

    window.applyYearFilter = function() {
        const checkboxes = document.querySelectorAll('.year-checkbox:checked');
        const selectedYears = Array.from(checkboxes).map(c => c.value);
        
        if (selectedYears.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Tahun',
                text: 'Silakan pilih minimal satu tahun presentasi.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        const url = new URL(window.location.href);
        url.searchParams.set('tahun', selectedYears.join(','));
        window.location.href = url.toString();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const selector = document.getElementById('multiYearSelector');
        const dropdown = document.getElementById('yearDropdown');
        if (selector && dropdown && !selector.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;600;700;800;900&display=swap');
body { 
    font-family: 'Inter', sans-serif; 
}
.no-scrollbar::-webkit-scrollbar { display: none; }
select {
    -webkit-appearance: none;
    -moz-appearance: none;
}
</style>
@endpush
