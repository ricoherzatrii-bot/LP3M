@extends('layouts.app')
@section('title', 'Kuesioner Dosen & Karyawan - LPM Politeknik Jambi')
@section('content')

<div class="min-h-screen bg-white dark:bg-slate-950 pt-8 pb-24 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-16">
        <div class="grid lg:grid-cols-3 gap-10">

            <!-- MAIN CONTENT (2/3) -->
            <div class="lg:col-span-2">
                <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4 font-serif-luxury">{{ $kuesioner->judul ?? 'Kuesioner Dosen & Karyawan' }}</h1>
                
                <div class="flex items-center gap-3 text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mb-8 border-b border-slate-100 dark:border-white/10 pb-4">
                    <span>Admin</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>Kuesioner</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>{{ $kuesioner ? $kuesioner->created_at->format('d F Y') : date('d F Y') }}</span> <span class="text-slate-300 dark:text-white/20">•</span>
                    <span>Hits: {{ $kuesioner->hits ?? 0 }}</span>
                    
                    <!-- Social Icons -->
                    <div class="ml-auto flex gap-3">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:bg-blue-400 hover:text-white transition"><i class="fab fa-twitter text-xs"></i></a>
                    </div>
                </div>

                <!-- Banner -->
                <div class="bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold text-center py-4 rounded-xl shadow-lg mb-8 uppercase tracking-widest text-xs md:text-sm">
                    KEPUASAN DOSEN DAN TENAGA KEPENDIDIKAN POLITEKNIK JAMBI
                </div>

                <!-- Filters & Stats -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-10">
                    <form class="w-full md:w-1/2 relative" method="GET" action="{{ route('kuesioner.dosen') }}">
                        <select name="tahun_akademik" onchange="this.form.submit()" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 appearance-none font-medium shadow-sm transition-colors">
                            <option value="">Pilih Tahun Akademik</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun_akademik') == $tahun || ($kuesioner && $kuesioner->tahun_akademik == $tahun) ? 'selected' : '' }}>Tahun {{ $tahun }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-[10px] pointer-events-none"></i>
                    </form>
                    <div class="bg-blue-100 dark:bg-blue-900/30 rounded-xl px-12 py-3 text-center shadow-inner">
                        <div class="text-[10px] font-bold text-blue-800 dark:text-blue-400 uppercase tracking-widest mb-0">Responden</div>
                        <div class="text-xl font-black text-blue-900 dark:text-blue-200">0</div>
                    </div>
                </div>

                <!-- ====================================================================== -->
                <!-- ISI KUESIONER — Premium Interactive Form Section                       -->
                <!-- ====================================================================== -->
                @if($pertanyaans->count() > 0)
                <div id="kuesionerFormSection" class="mb-12">
                    <!-- Toggle Button -->
                    <button onclick="toggleKuesionerForm()" id="toggleFormBtn" class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white py-5 rounded-2xl font-bold text-sm uppercase tracking-widest shadow-[0_10px_30px_rgba(79,70,229,0.3)] hover:shadow-[0_15px_40px_rgba(79,70,229,0.4)] transition-all hover:-translate-y-0.5 flex items-center justify-center gap-3 group">
                        <i class="fas fa-clipboard-list text-lg group-hover:scale-110 transition-transform"></i>
                        <span>Isi Kuesioner Sekarang</span>
                        <i class="fas fa-chevron-down text-xs transition-transform" id="toggleFormIcon"></i>
                    </button>

                    <!-- The Form Panel -->
                    <div id="kuesionerFormPanel" class="hidden mt-6 opacity-0 translate-y-4 transition-all duration-500">
                        <form id="kuesionerForm" class="space-y-0">
                            @csrf
                            <input type="hidden" name="kuesioner_id" value="{{ $kuesioner->id ?? '' }}">

                            <!-- Progress Bar -->
                            <div class="bg-white dark:bg-slate-900 rounded-t-[2rem] p-6 pb-4 border border-b-0 border-slate-100 dark:border-white/10">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Progress Pengisian</span>
                                    <span id="progressText" class="text-[10px] font-black text-blue-600 uppercase tracking-widest">0 / {{ $pertanyaans->count() }}</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div id="progressBar" class="h-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-full transition-all duration-500 ease-out" style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Questions List -->
                            <div class="bg-white dark:bg-slate-900 border border-t-0 border-slate-100 dark:border-white/10 rounded-b-[2rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.04)]">
                                @foreach($pertanyaans as $index => $q)
                                <div class="p-8 {{ !$loop->last ? 'border-b border-slate-100 dark:border-white/10' : '' }} hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors question-item" data-index="{{ $index }}">
                                    <div class="flex items-start gap-5">
                                        <!-- Number Badge -->
                                        <div class="w-10 h-10 shrink-0 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-sm font-black shadow-lg shadow-blue-200 dark:shadow-blue-900/30">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-grow">
                                            <label class="block text-slate-800 dark:text-white font-bold text-[15px] mb-4 leading-relaxed">
                                                {{ $q->pertanyaan }}
                                            </label>

                                            @if($q->tipe_jawaban == 'skala_likert')
                                            <!-- Likert Scale: Beautiful Star/Button Selection -->
                                            <div class="flex flex-wrap gap-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group">
                                                    <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $i }}" class="hidden peer kuesioner-input" onchange="updateProgress()">
                                                    <div class="w-14 h-14 rounded-xl border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center text-sm font-black text-slate-400 dark:text-slate-500 
                                                        peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-blue-200 dark:peer-checked:shadow-blue-900/30
                                                        hover:border-blue-300 hover:text-blue-500 transition-all group-hover:scale-105">
                                                        {{ $i }}
                                                    </div>
                                                </label>
                                                @endfor
                                            </div>
                                            <div class="flex justify-between mt-2 text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">
                                                <span>Sangat Tidak Puas</span>
                                                <span>Sangat Puas</span>
                                            </div>

                                            @elseif($q->tipe_jawaban == 'teks')
                                            <!-- Text Input -->
                                            <textarea name="jawaban[{{ $q->id }}]" rows="3" placeholder="Ketik jawaban Anda di sini..." 
                                                class="kuesioner-input w-full p-4 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 hover:bg-white dark:hover:bg-slate-700 focus:bg-white dark:focus:bg-slate-700 transition-all resize-none leading-relaxed"
                                                oninput="updateProgress()"></textarea>

                                            @elseif($q->tipe_jawaban == 'pilihan_ganda')
                                            <!-- Multiple Choice -->
                                            <div class="space-y-3">
                                                @foreach(explode(',', $q->opsi_jawaban ?? '') as $opsi)
                                                @if(trim($opsi))
                                                <label class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl border border-transparent hover:border-blue-200 dark:hover:border-blue-800 cursor-pointer transition-all group">
                                                    <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ trim($opsi) }}" class="hidden peer kuesioner-input" onchange="updateProgress()">
                                                    <div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-600 peer-checked:border-blue-500 peer-checked:bg-blue-500 relative transition-all shrink-0">
                                                        <div class="absolute inset-1 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                                    </div>
                                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400 peer-checked:text-blue-600 dark:peer-checked:text-blue-400 transition-colors">{{ trim($opsi) }}</span>
                                                </label>
                                                @endif
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <!-- Submit Button Area -->
                                <div class="p-8 bg-slate-50/50 dark:bg-slate-800/30">
                                    <button type="button" onclick="submitKuesioner()" id="submitKuesionerBtn"
                                        class="w-full bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white py-5 rounded-2xl font-bold text-sm uppercase tracking-widest shadow-[0_10px_30px_rgba(16,185,129,0.3)] hover:shadow-[0_15px_40px_rgba(16,185,129,0.4)] transition-all hover:-translate-y-0.5 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Kirim Jawaban Kuesioner</span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Success State -->
                        <div id="kuesionerSuccessState" class="hidden">
                            <div class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-emerald-900/20 dark:via-teal-900/20 dark:to-cyan-900/20 rounded-[2rem] p-12 text-center border border-emerald-100 dark:border-emerald-800/30 shadow-[0_20px_50px_rgba(16,185,129,0.1)]">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 mx-auto mb-6 flex items-center justify-center shadow-2xl shadow-emerald-200 dark:shadow-emerald-900/40 animate-bounce">
                                    <i class="fas fa-check text-white text-3xl"></i>
                                </div>
                                <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3 tracking-tight">Terima Kasih! 🎉</h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-md mx-auto">
                                    Jawaban kuesioner Anda telah berhasil dikirim dan akan digunakan untuk meningkatkan kualitas layanan pendidikan di Politeknik Jambi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- No Questions Prompt -->
                <div class="mb-12 bg-slate-50 dark:bg-slate-900 rounded-[2rem] p-10 text-center border border-slate-100 dark:border-white/10">
                    <i class="fas fa-clipboard-question text-4xl text-slate-300 dark:text-slate-600 mb-4"></i>
                    <p class="text-slate-400 dark:text-slate-500 text-sm font-medium">Belum ada pertanyaan kuesioner yang tersedia untuk periode ini.</p>
                </div>
                @endif

                <!-- Redesigned Chart Container (Reference-Based) -->
                <div class="bg-white dark:bg-slate-900 rounded-[32px] p-6 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-white/10 mb-10">
                    <div class="grid lg:grid-cols-3 gap-12 items-center">
                        
                        <!-- Left: Grouped Bar Chart (2/3) -->
                        <div class="lg:col-span-2">
                            <div class="h-[400px] w-full">
                                <canvas id="groupedBarChart"></canvas>
                            </div>
                        </div>

                        <!-- Right: Radial Gauges (1/3) -->
                        <div class="lg:col-span-1 space-y-12">
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 relative">
                                    <canvas id="gauge1"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-lg font-black text-slate-900 dark:text-white">77%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-800 dark:text-white font-bold text-lg mb-1">Kepuasan SDM</h4>
                                    <p class="text-[10px] text-slate-500 leading-relaxed">Indikator ketersediaan tenaga pendidik dan kependidikan.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 relative">
                                    <canvas id="gauge2"></canvas>
                                    <div class="absolute inset-0 flex items-center justify-center text-lg font-black text-slate-900 dark:text-white">67%</div>
                                </div>
                                <div>
                                    <h4 class="text-slate-800 dark:text-white font-bold text-lg mb-1">Fasilitas</h4>
                                    <p class="text-[10px] text-slate-500 leading-relaxed">Kelengkapan sarana dan prasarana penunjang.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // --- 1. GROUPED BAR CHART ---
                        const ctxBar = document.getElementById('groupedBarChart').getContext('2d');
                        new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: ['Januari', 'Februari', 'Maret', 'April'],
                                datasets: [
                                    {
                                        label: 'Realisasi',
                                        data: [7, 8, 15, 18],
                                        backgroundColor: 'rgba(244, 63, 94, 0.8)',
                                        borderRadius: 8,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.6
                                    },
                                    {
                                        label: 'Target',
                                        data: [6, 8, 10, 14],
                                        backgroundColor: 'rgba(245, 158, 11, 0.8)',
                                        borderRadius: 8,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.6
                                    },
                                    {
                                        label: 'Tahun Lalu',
                                        data: [5, 4, 5, 8],
                                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                                        borderRadius: 8,
                                        barPercentage: 0.8,
                                        categoryPercentage: 0.6
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: { 
                                        beginAtZero: true,
                                        grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                        ticks: { color: '#94a3b8', font: { size: 10 } }
                                    },
                                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { weight: 'bold' } } }
                                }
                            }
                        });

                        // --- 2. RADIAL GAUGES ---
                        const createGauge = (id, color, value) => {
                            new Chart(document.getElementById(id).getContext('2d'), {
                                type: 'doughnut',
                                data: {
                                    datasets: [{
                                        data: [value, 100 - value],
                                        backgroundColor: [color, 'rgba(0,0,0,0.05)'],
                                        borderWidth: 0,
                                        borderRadius: 10
                                    }]
                                },
                                options: {
                                    cutout: '80%',
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                                    animation: { animateRotate: true, duration: 2000 }
                                }
                            });
                        };

                        createGauge('gauge1', 'rgba(244, 63, 94, 0.8)', 77);
                        createGauge('gauge2', 'rgba(245, 158, 11, 0.8)', 67);
                    });

                    // ====================================================================
                    // ISI KUESIONER — Interactive Form Logic
                    // ====================================================================
                    const totalQuestions = {{ $pertanyaans->count() }};

                    function toggleKuesionerForm() {
                        const panel = document.getElementById('kuesionerFormPanel');
                        const icon = document.getElementById('toggleFormIcon');
                        if (panel.classList.contains('hidden')) {
                            panel.classList.remove('hidden');
                            setTimeout(() => {
                                panel.classList.remove('opacity-0', 'translate-y-4');
                            }, 10);
                            icon.style.transform = 'rotate(180deg)';
                        } else {
                            panel.classList.add('opacity-0', 'translate-y-4');
                            icon.style.transform = 'rotate(0deg)';
                            setTimeout(() => panel.classList.add('hidden'), 500);
                        }
                    }

                    function updateProgress() {
                        const inputs = document.querySelectorAll('.kuesioner-input');
                        const answered = new Set();
                        inputs.forEach(input => {
                            const name = input.name;
                            if (input.type === 'radio' && input.checked) answered.add(name);
                            if (input.type === 'textarea' && input.value.trim()) answered.add(name);
                        });
                        const count = answered.size;
                        const pct = totalQuestions > 0 ? Math.round((count / totalQuestions) * 100) : 0;
                        const bar = document.getElementById('progressBar');
                        const text = document.getElementById('progressText');
                        if (bar) bar.style.width = pct + '%';
                        if (text) text.textContent = count + ' / ' + totalQuestions;
                    }

                    function submitKuesioner() {
                        const form = document.getElementById('kuesionerForm');
                        const formData = new FormData(form);
                        const payload = { kuesioner_id: formData.get('kuesioner_id'), jawaban: {} };

                        for (const [key, value] of formData.entries()) {
                            const match = key.match(/jawaban\[(\d+)\]/);
                            if (match) {
                                payload.jawaban[match[1]] = value;
                            }
                        }

                        if (Object.keys(payload.jawaban).length === 0) {
                            alert('Silakan jawab minimal satu pertanyaan sebelum mengirim.');
                            return;
                        }

                        const btn = document.getElementById('submitKuesionerBtn');
                        btn.disabled = true;
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mengirim...</span>';

                        fetch('{{ route("kuesioner.submit") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(r => r.json())
                        .then(res => {
                            if (res.success) {
                                document.getElementById('kuesionerForm').classList.add('hidden');
                                document.getElementById('kuesionerSuccessState').classList.remove('hidden');
                            } else {
                                alert(res.message || 'Terjadi kesalahan.');
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Kirim Jawaban Kuesioner</span>';
                            }
                        })
                        .catch(err => {
                            alert('Gagal mengirim. Coba lagi.');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Kirim Jawaban Kuesioner</span>';
                        });
                    }
                </script>

                <!-- Keterangan Section -->
                <div class="mt-8">
                     <p class="text-center text-slate-400 dark:text-slate-500 text-xs italic leading-relaxed max-w-2xl mx-auto">
                        Data kuesioner ini menunjukkan tren kepuasan dosen dan tenaga kependidikan secara berkala. Grafik batang di atas membandingkan realisasi pencapaian dengan target yang telah ditetapkan institusi.
                     </p>
                </div>
            </div>

            <!-- SIDEBAR (1/3) -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <div class="relative">
                        <input type="text" placeholder="Search ..." class="w-full bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 transition">
                        <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Sering Dibaca -->
                <div class="bg-white dark:bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-200 dark:border-white/10 p-6 shadow-sm">
                    <h4 class="text-slate-900 dark:text-white font-bold text-lg mb-6 pb-4 border-b border-slate-100 dark:border-white/10">Sering Dibaca</h4>
                    <div class="space-y-4">
                        <a href="{{ route('kuesioner.mahasiswa') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Kuesioner Mahasiswa</a>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">Visi Dan Misi</a>
                        <a href="{{ route('artikel.index') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">PPM STIKES Baiturrahim Jambi melakukan Kegiatan Studi Banding</a>
                        <a href="https://e-spmi.politeknikjambi.ac.id" target="_blank" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm pb-4 border-b border-slate-100 dark:border-white/5">e-spmiPoljam</a>
                        <a href="{{ route('spmi.show', 'rtm') }}" class="block text-slate-600 dark:text-slate-400 hover:text-blue-500 transition text-sm">RTM</a>
                    </div>
                </div>


            </div>
            
        </div>
    </div>
</div>

@endsection
