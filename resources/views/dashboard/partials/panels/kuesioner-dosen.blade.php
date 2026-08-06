function loadKuesionerDosenPanel() {
            currentTitle = 'Kuesioner Dosen & Karyawan';
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;

            setTimeout(() => {
                content.innerHTML = `
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header Area -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col lg:flex-row justify-between items-center gap-8 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
                            <div class="flex items-center justify-center lg:justify-start gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Survei Kepuasan Internal</p>
                            </div>
                            <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">Kuesioner Dosen & Karyawan</h2>
                            <p class="text-slate-500 text-sm mt-4 font-medium">Kelola data persentase kepuasan melalui excel, tambah/edit/hapus, dan pantau visualisasinya.</p>
                        </div>
                        
                        <div class="flex flex-wrap justify-center gap-3 relative z-10">
                            <button onclick="toggleImportKuesioner()" class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-file-excel"></i> Import Excel
                            </button>
                            <button onclick="openKuesionerAddModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-plus"></i> Tambah Data
                            </button>
                            <button onclick="truncateKuesionerDosen()" class="bg-white border border-rose-100 text-rose-500 hover:bg-rose-50 text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-sm transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-trash-alt"></i> Kosongkan
                            </button>
                        </div>
                    </div>

                    <!-- Import Form (Hidden by default) -->
                    <div id="importKuesionerContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
                            <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Import Data via Excel</h3>
                            <button onclick="toggleImportKuesioner()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest flex items-center gap-2"><i class="fas fa-times"></i> Batal</button>
                        </div>
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 mb-8">
                            <h4 class="text-xs font-black text-blue-700 mb-3 flex items-center gap-2"><i class="fas fa-info-circle"></i> Format Kolom Excel yang Terdeteksi Otomatis</h4>
                            <div class="grid grid-cols-6 gap-2 text-center">
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom A</p><p class="text-[10px] font-bold text-blue-700">Program</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom B</p><p class="text-[10px] font-bold text-emerald-600">Sangat Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom C</p><p class="text-[10px] font-bold text-blue-600">Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom D</p><p class="text-[10px] font-bold text-yellow-600">Cukup Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom E</p><p class="text-[10px] font-bold text-orange-600">Tidak Setuju</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-blue-100"><p class="text-[9px] font-black text-slate-600">Kolom F</p><p class="text-[10px] font-bold text-rose-600">Sangat Tidak</p></div>
                            </div>
                            <p class="text-[10px] text-blue-600 mt-3 font-medium"><i class="fas fa-magic mr-1"></i> Baris pertama (header) akan dilewati otomatis. Data langsung terverifikasi dan masuk ke database.</p>
                            <a href="/admin/kuesioner-dosen/template" class="inline-flex items-center gap-2 mt-3 bg-white border border-blue-200 text-blue-700 text-[10px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl hover:bg-blue-100 transition-all shadow-sm"><i class="fas fa-download"></i> Download Template CSV</a>
                        </div>
                        <form id="importKuesionerForm" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Pilih Tahun Akademik</label>
                                <input type="text" id="kuesioner_tahun" placeholder="Contoh: 2023/2024" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div class="flex-grow">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">File Excel (.xlsx / .xls)</label>
                                <input type="file" id="kuesioner_file" accept=".xlsx, .xls" required
                                    class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                            </div>
                            <div class="md:col-span-2">
                                <button type="button" onclick="submitImportKuesioner()" id="importKuesionerBtn" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all hover:shadow-2xl hover:-translate-y-0.5">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Upload & Verifikasi Data Otomatis
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Filter Bar -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white shadow-sm p-4 mb-6 flex flex-wrap items-center gap-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Filter Tahun:</span>
                        <select onchange="loadKuesionerTable(this.value)" id="kdFilterTahun" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 outline-none focus:border-blue-500 min-w-[160px]">
                            <option value="">Semua Tahun</option>
                        </select>
                        <span class="ml-auto text-[10px] font-bold text-slate-400 uppercase tracking-widest" id="kdTotalCount">0 Data</span>
                    </div>

                    <!-- Data Table -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-5 border-b border-slate-100 w-16 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">No</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Tahun Akademik</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Program</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-emerald-500 tracking-[0.15em]">SS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-blue-500 tracking-[0.15em]">S</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-yellow-500 tracking-[0.15em]">CS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-orange-500 tracking-[0.15em]">TS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-rose-500 tracking-[0.15em]">STS</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-right w-36 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kdTableBody" class="divide-y divide-slate-50">
                                    <tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-10 border border-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] min-h-[450px] flex flex-col">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Visualisasi Data</h3>
                                <p class="text-slate-800 font-bold text-lg" id="chartTitle">Grafik Kepuasan Dosen & Karyawan</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center shadow-inner border border-blue-100"><i class="fas fa-chart-bar"></i></div>
                        </div>
                        <div class="flex-grow flex items-center justify-center relative" style="min-height:350px">
                            <canvas id="kuesionerLiveChart"></canvas>
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100 flex flex-wrap gap-4 justify-center">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(34,197,94,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(59,130,246,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(234,179,8,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Cukup Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(249,115,22,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tidak Setuju</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(239,68,68,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Tidak Setuju</span></div>
                        </div>
                    </div>
                </div>

                <!-- KUESIONER ADD/EDIT MODAL -->
                <div id="kdModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4" style="transition: opacity .3s ease;">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-transform duration-300" id="kdModalInner">
                        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <div>
                                <h3 class="font-black text-slate-800 text-xl font-display tracking-tight mb-1" id="kdModalTitle">Tambah Data</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kuesioner Dosen & Karyawan</p>
                            </div>
                            <button onclick="closeKdModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
                        </div>
                        <div class="p-10 space-y-5">
                            <input type="hidden" id="kd_edit_id">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Tahun Akademik</label>
                                <input type="text" id="kd_tahun" placeholder="Contoh: 2023/2024" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Program Studi</label>
                                <input type="text" id="kd_program" placeholder="Contoh: D3 Teknik Informatika" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div class="grid grid-cols-5 gap-3">
                                <div>
                                    <label class="block text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-2 text-center">SS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_ss" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-blue-500 uppercase tracking-widest mb-2 text-center">S (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_s" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-yellow-500 uppercase tracking-widest mb-2 text-center">CS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_cs" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-orange-500 uppercase tracking-widest mb-2 text-center">TS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_ts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-rose-500 uppercase tracking-widest mb-2 text-center">STS (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="kd_sts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all">
                                </div>
                            </div>
                            <div class="flex justify-end gap-4 pt-4 border-t border-slate-100">
                                <button onclick="closeKdModal()" class="px-6 py-3.5 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                                <button onclick="submitKdForm()" id="kdSubmitBtn" class="px-6 py-3.5 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.25)] hover:bg-blue-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                content.style.opacity = 1;
                initKuesionerPanel();
            }, 300);
        }

        async function initKuesionerPanel() {
            try {
                const r = await fetch('/admin/kuesioner-dosen/data');
                const res = await r.json();
                if (!res.success) return;
                
                kuesionerData = res.data;
                const years = res.years;
                const selector = document.getElementById('kdFilterTahun');
                if (selector) {
                    selector.innerHTML = '<option value="">Semua Tahun</option>';
                    years.forEach(y => {
                        const opt = document.createElement('option');
                        opt.value = y; opt.textContent = y;
                        selector.appendChild(opt);
                    });
                }
                renderKuesionerTable(kuesionerData);
                renderKuesionerChart(kuesionerData);
            } catch(e) {
                console.error(e);
                showToast('Gagal memuat data kuesioner.', 'warning');
            }
        }

        async function loadKuesionerTable(tahun = '') {
            try {
                const url = tahun ? `/admin/kuesioner-dosen/data?tahun_akademik=${encodeURIComponent(tahun)}` : '/admin/kuesioner-dosen/data';
                const r = await fetch(url);
                const res = await r.json();
                if (!res.success) return;
                kuesionerData = res.data;
                renderKuesionerTable(kuesionerData);
                renderKuesionerChart(kuesionerData);
            } catch(e) {
                showToast('Gagal memuat data.', 'warning');
            }
        }

        function renderKuesionerTable(data) {
            const tbody = document.getElementById('kdTableBody');
            const countEl = document.getElementById('kdTotalCount');
            if (countEl) countEl.textContent = data.length + ' Data';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Belum ada data. Silakan import Excel atau tambah data manual.</td></tr>';
                return;
            }

            tbody.innerHTML = data.map((item, idx) => `
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-6 py-5 text-center font-black text-slate-400 text-xs">${idx + 1}</td>
                    <td class="px-6 py-5 text-xs font-bold text-slate-600">
                        <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg border border-indigo-100">
                            <i class="fas fa-calendar-alt text-[9px]"></i> ${item.tahun_akademik}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-sm font-bold text-slate-800">${item.program}</td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-black px-2.5 py-1 rounded-lg border border-emerald-100">${item.sangat_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-blue-50 text-blue-700 text-xs font-black px-2.5 py-1 rounded-lg border border-blue-100">${item.setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-yellow-50 text-yellow-700 text-xs font-black px-2.5 py-1 rounded-lg border border-yellow-100">${item.cukup_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-orange-50 text-orange-700 text-xs font-black px-2.5 py-1 rounded-lg border border-orange-100">${item.tidak_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-rose-50 text-rose-700 text-xs font-black px-2.5 py-1 rounded-lg border border-rose-100">${item.sangat_tidak_setuju}%</span></td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <button onclick="openKuesionerEditModal(${item.id})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Edit"><i class="fas fa-pen text-xs"></i></button>
                            <button onclick="deleteKuesionerRow(${item.id})" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderKuesionerChart(data) {
            const chartTitle = document.getElementById('chartTitle');
            if (data.length === 0) {
                if (kuesionerChart) kuesionerChart.destroy();
                kuesionerChart = null;
                if (chartTitle) chartTitle.textContent = 'Belum Ada Data';
                return;
            }

            const activeTahun = data[0].tahun_akademik;
            if (chartTitle) chartTitle.textContent = `Kepuasan Dosen & Karyawan — T.A ${activeTahun}`;

            const labels = data.map(i => {
                let t = i.program;
                return t.length > 18 ? t.substring(0, 18) + '…' : t;
            });

            const datasets = [
                { label: 'Sangat Setuju', data: data.map(i => i.sangat_setuju), backgroundColor: 'rgba(34, 197, 94, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Setuju', data: data.map(i => i.setuju), backgroundColor: 'rgba(59, 130, 246, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Cukup Setuju', data: data.map(i => i.cukup_setuju), backgroundColor: 'rgba(234, 179, 8, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Tidak Setuju', data: data.map(i => i.tidak_setuju), backgroundColor: 'rgba(249, 115, 22, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 },
                { label: 'Sangat Tidak Setuju', data: data.map(i => i.sangat_tidak_setuju), backgroundColor: 'rgba(239, 68, 68, 0.85)', borderRadius: 6, barPercentage: 0.75, categoryPercentage: 0.8 }
            ];

            const ctx = document.getElementById('kuesionerLiveChart');
            if (!ctx) return;
            if (kuesionerChart) kuesionerChart.destroy();
            kuesionerChart = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index', intersect: false,
                            backgroundColor: 'rgba(15,23,42,0.9)', titleFont: { family: 'Inter', size: 12, weight: 'bold' }, bodyFont: { family: 'Inter', size: 11 },
                            padding: 14, cornerRadius: 12, displayColors: true, boxPadding: 4,
                            callbacks: {
                                title: ctx => { const i = ctx[0].dataIndex; return data[i] ? data[i].program : ctx[0].label; },
                                label: ctx => ' ' + ctx.dataset.label + ': ' + ctx.parsed.y + '%'
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, max: 100, grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false }, ticks: { font: { family: 'Inter', size: 10, weight: 'bold' }, color: '#94a3b8', callback: v => v + '%' } },
                        x: { grid: { display: false, drawBorder: false }, ticks: { font: { family: 'Inter', size: 9, weight: 'bold' }, color: '#64748b', maxRotation: 45 } }
                    },
                    animation: { duration: 1200, easing: 'easeOutQuart' }
                }
            });
        }

        function openKuesionerAddModal() {
            kuesionerEditId = null;
            document.getElementById('kdModalTitle').textContent = 'Tambah Data Baru';
            document.getElementById('kd_edit_id').value = '';
            document.getElementById('kd_tahun').value = '';
            document.getElementById('kd_program').value = '';
            document.getElementById('kd_ss').value = '';
            document.getElementById('kd_s').value = '';
            document.getElementById('kd_cs').value = '';
            document.getElementById('kd_ts').value = '';
            document.getElementById('kd_sts').value = '';
            document.getElementById('kdModal').classList.remove('hidden');
        }

        function openKuesionerEditModal(id) {
            const item = kuesionerData.find(d => d.id === id);
            if (!item) return;
            kuesionerEditId = id;
            document.getElementById('kdModalTitle').textContent = 'Edit Data';
            document.getElementById('kd_edit_id').value = id;
            document.getElementById('kd_tahun').value = item.tahun_akademik;
            document.getElementById('kd_program').value = item.program;
            document.getElementById('kd_ss').value = item.sangat_setuju;
            document.getElementById('kd_s').value = item.setuju;
            document.getElementById('kd_cs').value = item.cukup_setuju;
            document.getElementById('kd_ts').value = item.tidak_setuju;
            document.getElementById('kd_sts').value = item.sangat_tidak_setuju;
            document.getElementById('kdModal').classList.remove('hidden');
        }

        function closeKdModal() {
            document.getElementById('kdModal').classList.add('hidden');
            kuesionerEditId = null;
        }

        async function submitKdForm() {
            const payload = {
                tahun_akademik: document.getElementById('kd_tahun').value,
                program: document.getElementById('kd_program').value,
                sangat_setuju: parseFloat(document.getElementById('kd_ss').value) || 0,
                setuju: parseFloat(document.getElementById('kd_s').value) || 0,
                cukup_setuju: parseFloat(document.getElementById('kd_cs').value) || 0,
                tidak_setuju: parseFloat(document.getElementById('kd_ts').value) || 0,
                sangat_tidak_setuju: parseFloat(document.getElementById('kd_sts').value) || 0,
            };
            if (!payload.tahun_akademik || !payload.program) return showToast('Tahun akademik dan program wajib diisi.', 'warning');

            const isEdit = !!kuesionerEditId;
            const url = isEdit ? `/admin/kuesioner-dosen/${kuesionerEditId}/update` : '/admin/kuesioner-dosen/store';

            try {
                const r = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    closeKdModal();
                    const filterTahun = document.getElementById('kdFilterTahun').value;
                    loadKuesionerTable(filterTahun);
                } else {
                    showToast(res.message || 'Gagal menyimpan.', 'warning');
                }
            } catch (e) {
                showToast('Terjadi kesalahan.', 'warning');
            }
        }

        async function deleteKuesionerRow(id) {
            if (!(await window.swalConfirm('Yakin ingin menghapus data ini?'))) return;
            try {
                const r = await fetch(`/admin/kuesioner-dosen/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    const filterTahun = document.getElementById('kdFilterTahun').value;
                    loadKuesionerTable(filterTahun);
                }
            } catch (e) {
                showToast('Gagal menghapus data.', 'warning');
            }
        }

        function toggleImportKuesioner() {
            const container = document.getElementById('importKuesionerContainer');
            if (!container) return;
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                setTimeout(() => container.classList.remove('opacity-0', 'translate-y-4'), 10);
            } else {
                container.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => container.classList.add('hidden'), 300);
            }
        }

        async function submitImportKuesioner() {
            const tahun = document.getElementById('kuesioner_tahun').value;
            const file = document.getElementById('kuesioner_file').files[0];
            if (!tahun || !file) return showToast('Tahun akademik dan file excel wajib diisi', 'warning');

            const btn = document.getElementById('importKuesionerBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sedang Memproses & Memverifikasi...';

            const fd = new FormData();
            fd.append('tahun_akademik', tahun);
            fd.append('file', file);
            fd.append('_token', '{{ csrf_token() }}');

            try {
                const r = await fetch('/admin/kuesioner-dosen/import', {
                    method: 'POST', body: fd, headers: { 'Accept': 'application/json' }
                });
                const res = await r.json();
                btn.disabled = false;
                btn.innerHTML = originalText;

                if (res.success) {
                    showToast(res.message, 'success');
                    toggleImportKuesioner();
                    document.getElementById('importKuesionerForm').reset();
                    // Refresh table and re-populate year filter
                    const selector = document.getElementById('kdFilterTahun');
                    if (selector) selector.innerHTML = '<option value="">Semua Tahun</option>';
                    loadKuesionerTable('');
                } else {
                    showToast(res.message || 'Gagal mengimpor.', 'warning');
                }
            } catch (e) {
                btn.disabled = false;
                btn.innerHTML = originalText;
                showToast('Terjadi kesalahan pada sistem.', 'warning');
            }
        }

        async function truncateKuesionerDosen() {
            const currentYears = [...new Set(kuesionerData.map(item => {
                const yearPart = String(item.tahun_akademik || '').trim().split(/\s+/)[0];
                return yearPart;
            }).filter(Boolean))].sort();

            const { value: formValues } = await Swal.fire({
                title: 'Kosongkan Data Kuesioner Dosen & Karyawan',
                html: `
                    <div class="mb-4">
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Tahun Akademik:</label>
                        <select id="swal-kd-tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-white transition-all">
                            <option value="">Semua Tahun</option>
                            ${currentYears.map(y => `<option value="${y}">${y}</option>`).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Semester:</label>
                        <select id="swal-kd-semester" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-white transition-all">
                            <option value="">Semua Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'KOSONGKAN',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-[2.5rem] p-10',
                    confirmButton: 'rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4 mr-2',
                    cancelButton: 'rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4'
                },
                preConfirm: () => {
                    return {
                        tahun: document.getElementById('swal-kd-tahun').value,
                        semester: document.getElementById('swal-kd-semester').value
                    }
                }
            });

            if (!formValues) return;

            const { tahun, semester } = formValues;
            const semesterText = semester ? ` semester ${semester}` : '';
            const yearText = tahun ? ` tahun ${tahun}` : '';
            const msg = (tahun || semester)
                ? `Hapus semua data kuesioner untuk${yearText}${semesterText}?`
                : 'Hapus SEMUA data kuesioner dosen & karyawan?';
            if (!(await window.swalConfirm(msg))) return;

            try {
                const queryParams = new URLSearchParams({
                    kategori: 'Dosen & Karyawan'
                });
                if (tahun) queryParams.append('tahun_akademik', tahun);
                if (semester) queryParams.append('semester', semester);

                const r = await fetch(`/admin/kuesioner-dosen/truncate?${queryParams.toString()}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    const selector = document.getElementById('kdFilterTahun');
                    if (selector) selector.value = '';
                    loadKuesionerTable('');
                } else {
                    showToast(res.message || 'Gagal menghapus data.', 'warning');
                }
            } catch (e) {
                console.error(e);
                showToast('Gagal mengosongkan data (Terjadi kesalahan sistem).', 'warning');
            }
        }