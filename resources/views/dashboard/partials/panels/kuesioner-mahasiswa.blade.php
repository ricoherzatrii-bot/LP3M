 function loadKuesionerMahasiswaPanel() {
            currentTitle = 'Kuesioner Mahasiswa';
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;

            setTimeout(() => {
                content.innerHTML = `
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header Area -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col lg:flex-row justify-between items-center gap-8 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-user-graduate"></i></div>
                        <div class="relative z-10 w-full lg:w-auto text-center lg:text-left">
                            <div class="flex items-center justify-center lg:justify-start gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Survei Kepuasan Mahasiswa</p>
                            </div>
                            <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">Kuesioner Mahasiswa</h2>
                            <p class="text-slate-500 text-sm mt-4 font-medium">Kelola data kepuasan mahasiswa melalui upload excel dan pantau visualisasi grafiknya.</p>
                        </div>
                        
                        <div class="flex flex-wrap justify-center gap-3 relative z-10">
                            <button onclick="toggleImportKM()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(79,70,229,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-file-excel"></i> Import Excel
                            </button>
                            <button onclick="openKMAddModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-[0_10px_20px_rgba(16,185,129,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-plus"></i> Tambah Data
                            </button>
                            <button onclick="truncateKM()" class="bg-white border border-rose-100 text-rose-500 hover:bg-rose-50 text-[11px] font-black uppercase tracking-widest px-6 py-4 rounded-2xl shadow-sm transition-all hover:-translate-y-1 flex items-center gap-3">
                                <i class="fas fa-trash-alt"></i> Kosongkan
                            </button>
                        </div>
                    </div>

                    <!-- Import Form -->
                    <div id="importKMContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                        <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
                            <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Import Data Mahasiswa via Excel</h3>
                            <button onclick="toggleImportKM()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest flex items-center gap-2"><i class="fas fa-times"></i> Batal</button>
                        </div>
                        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 mb-8">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-xs font-black text-indigo-700 mb-1 flex items-center gap-2"><i class="fas fa-info-circle"></i> Format Baru: Excel Pivoted (Horizontal)</h4>
                                    <p class="text-[10px] text-indigo-500 font-medium leading-relaxed">Aspek Penilaian berada di Baris Header (Kolom C ke kanan). Kriteria (SB, B, K, SK) berada di Baris 2 - 5.</p>
                                </div>
                                <span class="bg-indigo-100 text-indigo-700 text-[9px] font-black px-2 py-1 rounded">REKOMENDASI</span>
                            </div>
                            <div class="grid grid-cols-5 gap-2 text-center mb-3">
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100"><p class="text-[8px] font-black text-slate-500">Kolom A</p><p class="text-[9px] font-bold text-slate-400">Tahun</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100"><p class="text-[8px] font-black text-slate-500">Kolom B</p><p class="text-[9px] font-bold text-slate-800">Kriteria</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100 shadow-sm"><p class="text-[8px] font-black text-indigo-500">Kolom C</p><p class="text-[9px] font-bold text-indigo-700 italic">Aspek 1</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100 shadow-sm"><p class="text-[8px] font-black text-indigo-500">Kolom D</p><p class="text-[9px] font-bold text-indigo-700 italic">Aspek 2</p></div>
                                <div class="bg-white rounded-lg py-2 px-1 border border-indigo-100 shadow-sm"><p class="text-[8px] font-black text-indigo-500">Kolom E</p><p class="text-[9px] font-bold text-indigo-700 italic">dst...</p></div>
                            </div>
                            <div class="flex items-center gap-4 text-[9px] text-slate-500 font-bold bg-white/50 p-2 rounded-xl border border-slate-100">
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-emerald-500"></i> Sangat Baik</span>
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-blue-500"></i> Baik</span>
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-orange-500"></i> Kurang</span>
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-rose-500"></i> Sangat Kurang</span>
                            </div>
                            <a href="/admin/kuesioner-mahasiswa/template" class="inline-flex items-center gap-2 mt-3 bg-white border border-indigo-200 text-indigo-700 text-[10px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl hover:bg-indigo-100 transition-all shadow-sm"><i class="fas fa-download"></i> Download Template CSV</a>
                        </div>
                        <form id="importKMForm" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Tahun Akademik</label>
                                <input type="text" id="km_import_tahun" placeholder="Contoh: 2023/2024 (Otomatis jika dari Excel)"
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Program Studi</label>
                                <select id="km_import_prodi" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                    <option value="">Pilih Program Studi</option>
                                </select>
                            </div>
                            <div class="flex-grow">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">File Excel (.xlsx / .xls)</label>
                                <input type="file" id="km_import_file" accept=".xlsx, .xls" required
                                    class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                            </div>
                            <div class="md:col-span-3">
                                <button type="button" onclick="submitImportKM()" id="importKMBtn" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all hover:shadow-2xl hover:-translate-y-0.5">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i> Jalankan Import Data Mahasiswa
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Filter Bar -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl border border-white shadow-sm p-4 mb-6 flex flex-wrap items-center gap-4">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Filter Tahun:</span>
                        <select onchange="loadKMTable(this.value)" id="kmFilterTahun" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-700 outline-none focus:border-indigo-500 min-w-[160px]">
                            <option value="">Semua Tahun</option>
                        </select>
                        <span class="ml-auto text-[10px] font-bold text-slate-400 uppercase tracking-widest" id="kmTotalCount">0 Data</span>
                    </div>

                    <!-- Data Table -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-5 border-b border-slate-100 w-16 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">No</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Tahun & Prodi</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Aspek Penilaian</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-emerald-500 tracking-[0.15em]">SB</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-blue-500 tracking-[0.15em]">B</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-orange-500 tracking-[0.15em]">K</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-center text-[10px] uppercase font-black text-rose-500 tracking-[0.15em]">SK</th>
                                        <th class="px-6 py-5 border-b border-slate-100 text-right w-36 text-[10px] uppercase font-black text-slate-400 tracking-[0.15em]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kmTableBody" class="divide-y divide-slate-50">
                                    <tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-10 border border-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] min-h-[450px] flex flex-col">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Visualisasi Data Mahasiswa</h3>
                                <p class="text-slate-800 font-bold text-lg" id="chartTitleStudent">Grafik Kepuasan Mahasiswa</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-inner border border-indigo-100"><i class="fas fa-graduation-cap"></i></div>
                        </div>
                        <div class="flex-grow flex items-center justify-center relative" style="min-height:350px">
                            <canvas id="kmLiveChart"></canvas>
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100 flex flex-wrap gap-4 justify-center">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(34,197,94,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Baik</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(59,130,246,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Baik</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(249,115,22,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kurang</span></div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-md" style="background:rgba(239,68,68,0.85)"></span><span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sangat Kurang</span></div>
                        </div>
                    </div>
                </div>

                <!-- KM ADD/EDIT MODAL -->
                <div id="kmModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4" style="transition: opacity .3s ease;">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-transform duration-300" id="kmModalInner">
                        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <div>
                                <h3 class="font-black text-slate-800 text-xl font-display tracking-tight mb-1" id="kmModalTitle">Tambah Data</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kuesioner Mahasiswa</p>
                            </div>
                            <button onclick="closeKMModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
                        </div>
                        <div class="p-10 space-y-5">
                            <input type="hidden" id="km_edit_id">
                             <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Tahun Akademik</label>
                                    <input type="text" id="km_tahun" placeholder="2023/2024" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Program Studi</label>
                                    <select id="km_prodi" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                        <option value="">Pilih Program Studi</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Aspek Penilaian</label>
                                <input type="text" id="km_program" placeholder="Contoh: Reliability" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <div>
                                    <label class="block text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-2 text-center">SB (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_ss" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-blue-500 uppercase tracking-widest mb-2 text-center">B (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_s" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-orange-500 uppercase tracking-widest mb-2 text-center">K (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_ts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-rose-500 uppercase tracking-widest mb-2 text-center">SK (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="km_sts" placeholder="0" class="w-full p-3 border border-slate-200 rounded-xl text-center text-sm font-bold text-slate-700 bg-slate-50 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all">
                                </div>
                            </div>
                            <div class="flex justify-end gap-4 pt-4 border-t border-slate-100">
                                <button onclick="closeKMModal()" class="px-6 py-3.5 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase">Batal</button>
                                <button onclick="submitKMForm()" id="kmSubmitBtn" class="px-6 py-3.5 bg-indigo-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(79,70,229,0.25)] hover:bg-indigo-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                content.style.opacity = 1;
                initKuesionerMahasiswaPanel();
            }, 300);
        }

        async function initKuesionerMahasiswaPanel() {
            try {
                const r = await fetch('/admin/kuesioner-dosen/data?kategori=Mahasiswa');
                const res = await r.json();
                if (!res.success) return;
                
                kuesionerDataStudent = res.data;
                const years = res.years;
                const selector = document.getElementById('kmFilterTahun');
                if (selector) {
                    selector.innerHTML = '<option value="">Semua Tahun</option>';
                    years.forEach(y => {
                        const opt = document.createElement('option');
                        opt.value = y; opt.textContent = y;
                        selector.appendChild(opt);
                    });
                }

                const prodiSelect = document.getElementById('km_import_prodi');
                const manualProdiSelect = document.getElementById('km_prodi');
                if (prodiSelect) {
                    const uniqueProdis = res.prodis && res.prodis.length > 0 ? res.prodis : [...new Set(res.data.map(i => i.prodi).filter(Boolean))].sort();
                    const optionsHtml = '<option value="">Pilih Program Studi</option>' + uniqueProdis.map(p => `<option value="${p}">${p}</option>`).join('');
                    prodiSelect.innerHTML = optionsHtml;
                    if(manualProdiSelect) manualProdiSelect.innerHTML = optionsHtml;
                }

                renderKMTable(kuesionerDataStudent);
                renderKMChart(kuesionerDataStudent);
            } catch(e) {
                showToast('Gagal memuat data kuesioner mahasiswa.', 'warning');
            }
        }

        async function loadKMTable(tahun = '') {
            try {
                const url = `/admin/kuesioner-dosen/data?kategori=Mahasiswa${tahun ? '&tahun_akademik='+encodeURIComponent(tahun) : ''}`;
                const r = await fetch(url);
                const res = await r.json();
                if (!res.success) return;
                kuesionerDataStudent = res.data;
                renderKMTable(kuesionerDataStudent);
                renderKMChart(kuesionerDataStudent);
            } catch(e) {
                showToast('Gagal memuat data.', 'warning');
            }
        }

        function renderKMTable(data) {
            const tbody = document.getElementById('kmTableBody');
            const countEl = document.getElementById('kmTotalCount');
            if (countEl) countEl.textContent = data.length + ' Data';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Belum ada data mahasiswa. Silakan import Excel atau tambah manual.</td></tr>';
                return;
            }

            tbody.innerHTML = data.map((item, idx) => `
                <tr class="hover:bg-indigo-50/30 transition-colors group">
                    <td class="px-6 py-5 text-center font-black text-slate-400 text-xs">${idx + 1}</td>
                    <td class="px-6 py-5 text-xs font-bold text-slate-600">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg border border-indigo-100 w-fit">
                                <i class="fas fa-calendar-alt text-[9px]"></i> ${item.tahun_akademik}
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-600 px-3 py-1 rounded-lg border border-slate-100 w-fit text-[9px]">
                                <i class="fas fa-university text-[8px]"></i> ${item.prodi || '-'}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm font-bold text-slate-800">${item.program}</td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-black px-2.5 py-1 rounded-lg border border-emerald-100">${item.sangat_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-blue-50 text-blue-700 text-xs font-black px-2.5 py-1 rounded-lg border border-blue-100">${item.setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-orange-50 text-orange-700 text-xs font-black px-2.5 py-1 rounded-lg border border-orange-100">${item.tidak_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-rose-50 text-rose-700 text-xs font-black px-2.5 py-1 rounded-lg border border-rose-100">${item.sangat_tidak_setuju}%</span></td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <button onclick="openKMEditModal(${item.id})" class="text-slate-400 hover:text-indigo-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Edit"><i class="fas fa-pen text-xs"></i></button>
                            <button onclick="deleteKMRow(${item.id})" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderKMChart(data) {
            const chartTitle = document.getElementById('chartTitleStudent');
            if (data.length === 0) {
                if (kuesionerChartStudent) kuesionerChartStudent.destroy();
                kuesionerChartStudent = null;
                if (chartTitle) chartTitle.textContent = 'Belum Ada Data';
                return;
            }

            const activeTahun = data[0].tahun_akademik;
            if (chartTitle) chartTitle.textContent = `Kepuasan Mahasiswa — T.A ${activeTahun}`;

            const labels = data.map(i => i.program.length > 20 ? i.program.substring(0, 20) + '...' : i.program);
            const datasets = [
                { label: 'Sangat Baik', data: data.map(i => i.sangat_setuju), backgroundColor: 'rgba(34, 197, 94, 0.85)', borderRadius: 6 },
                { label: 'Baik', data: data.map(i => i.setuju), backgroundColor: 'rgba(59, 130, 246, 0.85)', borderRadius: 6 },
                { label: 'Kurang', data: data.map(i => i.tidak_setuju), backgroundColor: 'rgba(249, 115, 22, 0.85)', borderRadius: 6 },
                { label: 'Sangat Kurang', data: data.map(i => i.sangat_tidak_setuju), backgroundColor: 'rgba(239, 68, 68, 0.85)', borderRadius: 6 }
            ];

            const ctx = document.getElementById('kmLiveChart');
            if (!ctx) return;
            if (kuesionerChartStudent) kuesionerChartStudent.destroy();
            kuesionerChartStudent = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: { labels, datasets },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, max: 100, ticks: { callback: v => v + '%' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        function openKMAddModal() {
            kuesionerEditIdStudent = null;
            if (document.getElementById('kmModalTitle')) document.getElementById('kmModalTitle').textContent = 'Tambah Data Kuesioner Mahasiswa';
            document.getElementById('km_edit_id').value = '';
            document.getElementById('km_tahun').value = '';
            document.getElementById('km_prodi').value = '';
            document.getElementById('km_program').value = '';
            document.getElementById('km_ss').value = '';
            document.getElementById('km_s').value = '';
            document.getElementById('km_ts').value = '';
            document.getElementById('km_sts').value = '';
            document.getElementById('kmModal').classList.remove('hidden');
        }

        function openKMEditModal(id) {
            const item = kuesionerDataStudent.find(d => d.id === id);
            if (!item) return;
            kuesionerEditIdStudent = id;
            document.getElementById('kmModalTitle').textContent = 'Edit Data Kuesioner Mahasiswa';
            document.getElementById('km_edit_id').value = id;
            document.getElementById('km_tahun').value = item.tahun_akademik;
            document.getElementById('km_prodi').value = item.prodi || '';
            document.getElementById('km_program').value = item.program;
            document.getElementById('km_ss').value = item.sangat_setuju;
            document.getElementById('km_s').value = item.setuju;
            document.getElementById('km_ts').value = item.tidak_setuju;
            document.getElementById('km_sts').value = item.sangat_tidak_setuju;
            document.getElementById('kmModal').classList.remove('hidden');
        }

        function closeKMModal() {
            document.getElementById('kmModal').classList.add('hidden');
            kuesionerEditIdStudent = null;
        }

        async function submitKMForm() {
            const payload = {
                tahun_akademik: document.getElementById('km_tahun').value,
                prodi: document.getElementById('km_prodi').value,
                program: document.getElementById('km_program').value,
                kategori: 'Mahasiswa',
                sangat_setuju: parseFloat(document.getElementById('km_ss').value) || 0,
                setuju: parseFloat(document.getElementById('km_s').value) || 0,
                tidak_setuju: parseFloat(document.getElementById('km_ts').value) || 0,
                sangat_tidak_setuju: parseFloat(document.getElementById('km_sts').value) || 0,
                cukup_setuju: 0
            };
            if (!payload.tahun_akademik || !payload.program) return showToast('Harap isi semua field utama.', 'warning');

            const isEdit = !!kuesionerEditIdStudent;
            const url = isEdit ? `/admin/kuesioner-dosen/${kuesionerEditIdStudent}/update` : '/admin/kuesioner-dosen/store';

            try {
                const r = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    closeKMModal();
                    loadKMTable(document.getElementById('kmFilterTahun').value);
                }
            } catch (e) { showToast('Gagal menyimpan data.', 'warning'); }
        }

        async function deleteKMRow(id) {
            if (!(await window.swalConfirm('Hapus data ini?'))) return;
            try {
                const r = await fetch(`/admin/kuesioner-dosen/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    loadKMTable(document.getElementById('kmFilterTahun').value);
                }
            } catch (e) { showToast('Gagal menghapus.', 'warning'); }
        }

        function toggleImportKM() {
            const container = document.getElementById('importKMContainer');
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                setTimeout(() => container.classList.remove('opacity-0', 'translate-y-4'), 10);
            } else {
                container.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => container.classList.add('hidden'), 300);
            }
        }

        async function submitImportKM() {
            const tahun = document.getElementById('km_import_tahun').value;
            const prodi = document.getElementById('km_import_prodi').value;
            const file = document.getElementById('km_import_file').files[0];
            if (!prodi || !file) return showToast('Lengkapi form import (Prodi, File).', 'warning');

            const btn = document.getElementById('importKMBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengimpor...';

            const fd = new FormData();
            fd.append('tahun_akademik', tahun);
            fd.append('prodi', prodi);
            fd.append('file', file);
            fd.append('kategori', 'Mahasiswa');
            fd.append('_token', '{{ csrf_token() }}');

            try {
                const r = await fetch('/admin/kuesioner-dosen/import', { method: 'POST', body: fd });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    toggleImportKM();
                    loadKMTable('');
                } else showToast(res.message, 'warning');
            } catch (e) { showToast('Terjadi kesalahan import.', 'warning'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-cloud-upload-alt mr-2"></i> Jalankan Import Data Mahasiswa';
            }
        }

        async function truncateKM() {
            const currentData = (typeof kuesionerDataStudent !== 'undefined') ? kuesionerDataStudent : [];
            const uniqueProdis = [...new Set(currentData.map(item => item.prodi).filter(Boolean))].sort();
            const uniqueYears = [...new Set(currentData.map(item => item.tahun_akademik).filter(Boolean))].sort();

            let prodiOptionsHtml = '<option value="all">Semua Program Studi</option>';
            uniqueProdis.forEach(p => {
                prodiOptionsHtml += `<option value="${p}">${p}</option>`;
            });

            let tahunOptionsHtml = '<option value="">Semua Tahun</option>';
            uniqueYears.forEach(y => {
                const isSelected = document.getElementById('kmFilterTahun')?.value === y ? 'selected' : '';
                tahunOptionsHtml += `<option value="${y}" ${isSelected}>${y}</option>`;
            });

            const { value: formValues } = await Swal.fire({
                title: 'Kosongkan Data Mahasiswa',
                html: `
                    <div class="mb-4">
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Program Studi:</label>
                        <select id="swal-prodi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            ${prodiOptionsHtml}
                        </select>
                    </div>
                    <div>
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Tahun Akademik:</label>
                        <select id="swal-tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            ${tahunOptionsHtml}
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
                        prodi: document.getElementById('swal-prodi').value,
                        tahun: document.getElementById('swal-tahun').value
                    }
                }
            });

            if (!formValues) return;

            const { prodi, tahun } = formValues;
            const prodiText = prodi !== 'all' ? `prodi "${prodi}"` : 'SEMUA prodi';
            const tahunText = tahun ? `tahun akademik "${tahun}"` : 'SEMUA tahun akademik';
            const msgConfirm = `Apakah Anda yakin ingin menghapus data kuesioner Mahasiswa untuk ${prodiText} di ${tahunText}?`;

            if (!(await window.swalConfirm(msgConfirm))) return;

            try {
                const queryParams = new URLSearchParams({
                    kategori: 'Mahasiswa'
                });
                if (tahun) queryParams.append('tahun_akademik', tahun);
                if (prodi && prodi !== 'all') queryParams.append('prodi', prodi);

                const r = await fetch(`/admin/kuesioner-dosen/truncate?${queryParams.toString()}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                const res = await r.json();
                if (res.success) {
                    showToast(res.message, 'success');
                    const selector = document.getElementById('kmFilterTahun');
                    if (selector) selector.value = '';
                    loadKMTable('');
                } else {
                    showToast(res.message || 'Gagal mengosongkan.', 'warning');
                }
            } catch (e) {
                console.error(e);
                showToast('Gagal mengosongkan data (Terjadi kesalahan sistem).', 'warning');
            }
        }

        // Keep backward compat for old sidebar calls
        function fetchKuesionerStats(tahun) { 
            if (currentTitle === 'Kuesioner Mahasiswa') loadKMTable(tahun || '');
            else loadKuesionerTable(tahun || '');
        }