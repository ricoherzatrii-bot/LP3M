@extends('layouts.app')

@section('content')
@php
    $baikSekali = $data->filter(function($item) {
        return str_contains(strtolower($item->peringkat), 'sekali');
    })->count();
    
    $baik = $data->filter(function($item) {
        $p = str_contains(strtolower($item->peringkat), 'baik') && !str_contains(strtolower($item->peringkat), 'sekali');
        return $p;
    })->count();
    
    $total = $baikSekali + $baik;
    $percBaikSekali = $total > 0 ? round(($baikSekali / $total) * 100) : 0;
    $percBaik = $total > 0 ? round(($baik / $total) * 100) : 0;
@endphp

<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-32 pb-20 transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-blue-600 block mb-2">Internal Quality Assurance</span>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">
                    Status Akreditasi Program Studi
                </h1>
                <p class="text-slate-500 mt-2">
                    Daftar peringkat akreditasi resmi untuk seluruh program studi di Politeknik Jambi.
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-900 px-5 py-3 rounded-2xl border border-slate-100 dark:border-white/10 shadow-sm self-start">
                <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Terintegrasi Sistem BAN-PT</span>
            </div>
        </div>

        <!-- Comparison Chart Area -->
        @if($total > 0)
        <div class="mb-12">
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-white/10 shadow-xl p-10 flex flex-col md:flex-row items-center gap-10">
                <div class="relative w-48 h-48 flex-shrink-0">
                    <canvas id="accreditationChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-slate-800 dark:text-white leading-none">{{ $total }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Total Prodi</span>
                    </div>
                </div>
                <div class="flex-grow space-y-6">
                    <div>
                        <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight mb-2">Perbandingan Akreditasi</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium">Visualisasi persentase distribusi peringkat akreditasi "Baik" dan "Baik Sekali" pada seluruh program studi Politeknik Jambi.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-5 rounded-2xl bg-blue-50/50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 transition-all hover:shadow-lg hover:shadow-blue-500/5 group">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(37,99,235,0.5)]"></div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-blue-500 transition-colors">Baik Sekali</span>
                            </div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tighter">{{ $percBaikSekali }}%</span>
                                <span class="text-[10px] font-bold text-slate-400">({{ $baikSekali }} <span class="hidden sm:inline">Prodi</span>)</span>
                            </div>
                        </div>
                        <div class="p-5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/30 transition-all hover:shadow-lg hover:shadow-emerald-500/5 group">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-emerald-500 transition-colors">Baik</span>
                            </div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 tracking-tighter">{{ $percBaik }}%</span>
                                <span class="text-[10px] font-bold text-slate-400">({{ $baik }} <span class="hidden sm:inline">Prodi</span>)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-white/10 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 dark:bg-slate-800 text-white text-[11px] font-bold uppercase tracking-wider border-b border-slate-800 dark:border-white/5">
                            <th class="py-5 px-8">No</th>
                            <th class="py-5 px-6">Nama Program Studi</th>
                            <th class="py-5 px-6">Peringkat Akreditasi</th>
                            <th class="py-5 px-6">Masa Berlaku (Kedaluwarsa)</th>
                            <th class="py-5 px-8 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-sm">
                        @forelse($data as $key => $item)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-white/5 transition-colors">
                            <td class="py-5 px-8 font-bold text-slate-400">{{ $key + 1 }}</td>
                            <td class="py-5 px-6">
                                <div class="font-extrabold text-slate-900 dark:text-slate-100">{{ $item->judul }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">Politeknik Jambi</div>
                            </td>
                            <td class="py-5 px-6">
                                @if(strtolower($item->peringkat) === 'unggul')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/30">
                                        <i class="fas fa-crown text-[10px]"></i> Unggul
                                    </span>
                                @elseif(str_contains(strtolower($item->peringkat), 'sekali'))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800/30">
                                        <i class="fas fa-star text-[10px]"></i> Baik Sekali
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/30">
                                        <i class="fas fa-check-circle text-[10px]"></i> {{ $item->peringkat ?? 'Terakreditasi' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 px-6 text-slate-500 font-medium">
                                {{ $item->tanggal_kedaluwarsa ? \Carbon\Carbon::parse($item->tanggal_kedaluwarsa)->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="py-5 px-8 text-right">
                                <a href="https://banpt.or.id" target="_blank" class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-xs font-bold text-blue-600 hover:bg-blue-50 transition">
                                    Cek BAN-PT <i class="fas fa-external-link-alt text-[9px]"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <i class="fas fa-folder-open text-3xl opacity-30"></i>
                                    <span>Belum ada data akreditasi yang tersimpan.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('accreditationChart');
        if (!ctx) return;

        new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Baik Sekali', 'Baik'],
                datasets: [{
                    data: [{{ $baikSekali }}, {{ $baik }}],
                    backgroundColor: [
                        '#2563eb', // blue-600
                        '#10b981'  // emerald-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 15,
                    borderRadius: 4
                }]
            },
            options: {
                cutout: '78%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 13, weight: '900' },
                        bodyFont: { size: 12, weight: '600' },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.parsed + ' Prodi';
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    });
</script>
@endpush