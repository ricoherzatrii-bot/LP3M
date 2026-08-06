<!-- DASHBOARD OVERVIEW PANELS -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-12">
    <div class="stagger-1 stat-card bg-white/80 backdrop-blur-xl rounded-[2rem] p-8 border border-white shadow-[0_10px_30px_rgba(0,0,0,0.08)] relative overflow-hidden h-full">
        <div class="absolute top-0 right-0 w-28 h-28 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-8 -top-10 w-44 h-44 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <!-- Header -->
        <div class="flex justify-between items-start relative z-10 mb-6">
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Akreditasi</p>
                <h3 class="text-2xl font-black text-slate-900 font-display">Program Studi & Status</h3>
            </div>
            <div class="w-12 h-12 rounded-3xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner border border-blue-100">
                <i class="fas fa-university"></i>
            </div>
        </div>

        <!-- Total Prodi Stat -->
        <div class="relative z-10 mb-6">
            <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 p-6 border border-blue-100/50">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="fas fa-university"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-400 mb-1">Total Program Studi</p>
                        <h3 class="text-4xl font-black text-slate-900 font-display">{{ $totalProdi ?? 8 }}</h3>
                    </div>
                </div>
            </div>
            <!-- Mini stat badges -->
            <div class="mt-4 flex gap-3">
                <div class="flex items-center gap-1.5 bg-emerald-50 border border-emerald-100 rounded-xl px-3 py-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-[11px] font-bold text-emerald-700">Unggul: {{ $akreditasiUnggul ?? 5 }}</span>
                </div>
                <div class="flex items-center gap-1.5 bg-blue-50 border border-blue-100 rounded-xl px-3 py-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-[11px] font-bold text-blue-700">Baik: {{ $akreditasiBaik ?? 7 }}</span>
                </div>
            </div>
        </div>
        <!-- Donut Chart below -->
        <div class="relative z-10 w-full">
            <div class="relative w-full h-[240px]"><canvas id="accreditationDonutChart"></canvas></div>
        </div>
    </div>

    <div class="stagger-3 bg-white/80 backdrop-blur-xl rounded-[2rem] p-8 border border-white shadow-[0_10px_30px_rgba(0,0,0,0.08)] relative overflow-hidden h-full">
        <div class="absolute -right-8 -top-10 w-44 h-44 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="flex justify-between items-start relative z-10 mb-6">
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Renstra</p>
                <h3 class="text-2xl font-black text-slate-900 font-display">Growth Performance Trend</h3>
            </div>
            <div class="w-12 h-12 rounded-3xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner border border-indigo-100">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="relative w-full h-[650px]">
            <div id="chartTooltip" class="opacity-0 absolute pointer-events-none z-[100] text-[11px] font-bold bg-white text-slate-900 px-5 py-4 rounded-2xl shadow-[0_20px_50px_-10px_rgba(0,0,0,0.5)] border border-slate-200 transition-opacity duration-200 max-w-[350px]"></div>
            <canvas id="mainChart"></canvas>
        </div>
    </div>
</div>

<div class="stagger-4 bg-white/80 backdrop-blur-xl rounded-[2rem] p-8 border border-white shadow-[0_10px_30px_rgba(0,0,0,0.08)] relative overflow-hidden mb-12">
    <div class="absolute -right-10 -top-10 w-36 h-36 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="flex justify-between items-start relative z-10 mb-6">
        <div>
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Kuesioner</p>
            <h3 class="text-2xl font-black text-slate-900 font-display">Grafik Kepuasan</h3>
        </div>
        <div class="w-12 h-12 rounded-3xl bg-slate-50 text-slate-600 flex items-center justify-center shadow-inner border border-slate-200">
            <i class="fas fa-smile"></i>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-8">
        <div>
            <h4 class="text-xs font-black tracking-widest uppercase text-center text-blue-600 mb-2">Dosen & Karyawan</h4>
            <div class="relative w-full h-[320px]"><canvas id="kuesionerDosenChart"></canvas></div>
        </div>
    </div>
</div>
