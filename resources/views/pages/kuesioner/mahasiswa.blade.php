@extends('layouts.app')
@section('title', 'Kuesioner Mahasiswa - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <!-- Upper Filters Section -->
        <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 shadow-xl border border-slate-100 dark:border-white/5 relative mb-12 z-20">
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8 relative z-10">
                <div>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter uppercase mb-2">Pencarian & Filter</h3>
                    <p class="text-blue-600 dark:text-blue-400 font-black text-sm uppercase tracking-tight">Kuesioner Mahasiswa</p>
                </div>

                <form method="GET" action="{{ route('kuesioner.mahasiswa') }}" class="flex flex-wrap items-center gap-4 w-full xl:w-auto" id="filter-form">
                    <!-- Filter Tahun (Custom Multi-select) -->
                    @php
                        $selectedYears = request('tahun_akademik');
                        if (is_null($selectedYears) && !request()->has('tahun_akademik')) {
                            $selectedYears = $tahunList->count() > 0 ? [$tahunList->first()] : [];
                        } else {
                            $selectedYears = (array) $selectedYears;
                        }
                        $isAllSelected = in_array('all', $selectedYears) || (count($selectedYears) > 0 && count(array_diff($tahunList->toArray(), $selectedYears)) === 0);
                    @endphp
                    
                    <div class="relative min-w-[220px]" id="tahun-select-container">
                        <button type="button" id="tahun-select-btn" class="w-full flex justify-between items-center bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-white/5 text-slate-900 dark:text-slate-200 text-[11px] font-black rounded-2xl px-6 py-4 pr-11 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all uppercase tracking-widest shadow-sm text-left relative">
                            <span id="tahun-select-label" class="block truncate max-w-[150px]">
                                @if ($isAllSelected || empty($selectedYears))
                                    Semua Tahun Akademik
                                @elseif (count($selectedYears) === 1)
                                    {{ $selectedYears[0] }}
                                @else
                                    {{ count($selectedYears) }} Tahun Terpilih
                                @endif
                            </span>
                            <i class="fas fa-calendar-alt text-blue-500 absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="tahun-dropdown-menu" class="hidden absolute left-0 mt-2 z-[60] w-72 bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 rounded-3xl shadow-2xl p-5 transition-all duration-300">
                            <div class="flex flex-col gap-2 max-h-48 overflow-y-auto custom-scrollbar">
                                <label class="flex items-center gap-3 text-xs font-black text-slate-700 dark:text-slate-250 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 p-2.5 rounded-xl transition-all">
                                    <input type="checkbox" id="check-all-tahun" value="all" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500/20 border-slate-200 dark:border-white/10 dark:bg-slate-800" {{ $isAllSelected ? 'checked' : '' }}>
                                    <span class="tracking-wider uppercase">PILIH SEMUA</span>
                                </label>
                                <hr class="border-slate-100 dark:border-white/5 my-1">
                                @foreach($tahunList as $tahun)
                                    @php
                                        $isChecked = in_array($tahun, $selectedYears) || $isAllSelected;
                                    @endphp
                                    <label class="flex items-center gap-3 text-xs font-bold text-slate-600 dark:text-slate-350 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 p-2.5 rounded-xl transition-all">
                                        <input type="checkbox" name="tahun_akademik[]" value="{{ $tahun }}" class="checkbox-tahun w-4 h-4 rounded text-blue-600 focus:ring-blue-500/20 border-slate-200 dark:border-white/10 dark:bg-slate-800" {{ $isChecked ? 'checked' : '' }}>
                                        <span class="tracking-wider uppercase">{{ $tahun }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-white/5">
                                <button type="button" id="tahun-apply-btn" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-[10px] font-black py-3 rounded-2xl uppercase tracking-widest transition-all shadow-md shadow-blue-500/10">Terapkan</button>
                            </div>
                        </div>
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
        // --- Custom Multi-Select Dropdown for Tahun Akademik ---
        const dropdownBtn = document.getElementById('tahun-select-btn');
        const dropdownMenu = document.getElementById('tahun-dropdown-menu');
        const checkAll = document.getElementById('check-all-tahun');
        const checkboxes = document.querySelectorAll('.checkbox-tahun');
        const applyBtn = document.getElementById('tahun-apply-btn');
        const filterForm = document.getElementById('filter-form');

        if (dropdownBtn && dropdownMenu) {
            // Toggle dropdown visibility
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#tahun-select-container')) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // "Pilih Semua" logic
            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = checkAll.checked;
                    });
                    updateLabel();
                });
            }

            // Individual checkbox logic
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!cb.checked && checkAll) {
                        checkAll.checked = false;
                    } else if (cb.checked && checkAll) {
                        const allChecked = Array.from(checkboxes).every(item => item.checked);
                        if (allChecked) checkAll.checked = true;
                    }
                    updateLabel();
                });
            });

            // Submit on apply
            if (applyBtn) {
                applyBtn.addEventListener('click', function() {
                    filterForm.submit();
                });
            }

            function updateLabel() {
                const checkedBoxes = Array.from(checkboxes).filter(item => item.checked);
                const label = document.getElementById('tahun-select-label');
                
                if (checkAll && checkAll.checked) {
                    label.textContent = "Semua Tahun Akademik";
                } else if (checkedBoxes.length === 0) {
                    label.textContent = "Semua Tahun Akademik";
                } else if (checkedBoxes.length === 1) {
                    label.textContent = checkedBoxes[0].value;
                } else {
                    label.textContent = checkedBoxes.length + " Tahun Terpilih";
                }
            }
        }

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
                    data: hasData ? chartDataRaw.map(item => item.sangat_setuju) : [0],
                    backgroundColor: colors.sangat_baik, 
                    borderRadius: 4,
                    barPercentage: 0.8,
                    categoryPercentage: 0.8
                },
                { 
                    label: 'Baik', 
                    data: hasData ? chartDataRaw.map(item => item.setuju) : [0],
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
