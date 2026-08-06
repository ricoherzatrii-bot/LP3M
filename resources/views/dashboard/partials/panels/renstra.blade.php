// Fungsi utilitas untuk escaping string HTML guna mencegah XSS
function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function loadRenstraPanel() {
    const content = document.getElementById('dynamic-content');
    content.innerHTML = `
    <div class="max-w-7xl mx-auto pb-12">
        <!-- Header -->
        <div class="bg-white/85 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-chart-bar"></i></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.6)]"></span>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Capaian Kinerja</p>
                </div>
                <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Capaian Renstra</h2>
                <div class="flex items-center gap-3 mt-2">
                     <p class="text-slate-500 text-sm">Kelola data Renstra secara mendetail melalui tabel di bawah atau melalui Impor Excel.</p>
                     <button onclick="openRenstraModal()" class="ml-4 bg-blue-600 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Data
                     </button>
                </div>
            </div>
        </div>

        <!-- Import Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-1 bg-white/85 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10">
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 pb-4 border-b border-slate-100">Sync Matriks Renstra</h3>
                <form id="importRenstraForm" onsubmit="event.preventDefault(); submitImportRenstra();" class="space-y-6">
                    <div class="p-6 rounded-2xl bg-blue-50/50 border border-blue-100/50 space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-blue-400 uppercase tracking-widest mb-3">File Matriks (.xlsx)</label>
                            <input type="file" id="renstra_file" accept=".xlsx,.xls" required
                                class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-blue-400 uppercase tracking-widest mb-3">Tahun (Opsional - Timpa Tahun di Excel)</label>
                            <select id="renstra_import_year" class="w-full bg-white border border-blue-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-700 outline-none focus:ring-4 focus:ring-blue-500/10 transition-all">
                                <option value="">Gunakan Tahun dari Excel</option>
                                @foreach(range(date('Y')-5, date('Y')+5) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="renstraImportBtn" class="w-full bg-slate-900 text-white font-black uppercase tracking-widest text-[10px] py-4 rounded-2xl shadow-lg hover:bg-slate-800 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-sync-alt"></i> Process & Sync Matrix
                    </button>
                    <button type="button" onclick="truncateRenstra()" class="w-full bg-rose-50 text-rose-600 border border-rose-100 font-black uppercase tracking-widest text-[10px] py-4 rounded-2xl hover:bg-rose-100 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-trash-alt"></i> Kosongkan Data
                    </button>
                </form>
                <a href="{{ route('admin.renstra.template') }}" class="inline-flex items-center justify-center gap-2 w-full mt-4 bg-white border border-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-widest px-4 py-4 rounded-2xl hover:bg-slate-50 transition-all shadow-sm">
                    <i class="fas fa-download"></i> Download Template CSV
                </a>
            </div>

            <div class="lg:col-span-2 bg-white/85 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="px-10 py-7 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-6">
                        <h3 class="text-xl font-black text-slate-800 font-display">Data Terdaftar</h3>
                        <select id="filter-tahun-renstra" onchange="fetchRenstraList()" class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest outline-none focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                            <option value="">Semua Tahun</option>
                            @foreach(range(date('Y')-5, date('Y')+5) as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                     <button onclick="fetchRenstraList()" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 flex items-center justify-center transition-all">
                        <i class="fas fa-sync-alt text-sm"></i>
                    </button>
                </div>
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/50 sticky top-0 z-10">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Tahun</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Program</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Persentase (Capaian)</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="renstra-tbody" class="divide-y divide-slate-50">
                            <tr><td colspan="4" class="px-8 py-10 text-center text-slate-400 font-medium font-display">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    `;
    fetchRenstraList();
}

function fetchRenstraList() {
    const tbody = document.getElementById('renstra-tbody');
    if(!tbody) return;
    const filterTahun = document.getElementById('filter-tahun-renstra')?.value || '';
    tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-10 text-center"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...</td></tr>';
    
    fetch('/admin/renstra')
        .then(r => r.json())
        .then(res => {
            if (res.success && res.data.length > 0) {
                let filteredData = res.data;
                if(filterTahun) {
                    filteredData = res.data.filter(item => item.tahun == filterTahun);
                }

                tbody.innerHTML = filteredData.map(item => `
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-4 text-xs font-black text-slate-800 text-center tracking-tighter">${escapeHtml(item.tahun)}</td>
                        <td class="px-8 py-4">
                            <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">${escapeHtml(item.program || '-')}</div>
                            <div class="text-[9px] font-medium text-slate-400 uppercase tracking-widest italic">${escapeHtml(item.indikator)}</div>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <div class="w-12 h-1.5 bg-slate-100 rounded-full overflow-hidden shadow-inner flex-shrink-0">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: ${escapeHtml(item.realisasi)}%"></div>
                                </div>
                                <span class="text-xs font-black text-slate-700">${escapeHtml(item.realisasi)}%</span>
                            </div>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick='openRenstraModal(${JSON.stringify(item).replace(/'/g, "&#39;")})' class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all border border-blue-100"><i class="fas fa-edit text-[10px]"></i></button>
                                <button onclick="deleteRenstra(${item.id})" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all border border-rose-100"><i class="fas fa-trash text-[10px]"></i></button>
                            </div>
                        </td>
                    </tr>
                `).join('');

                if(filteredData.length === 0 && filterTahun) {
                   tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Data untuk tahun ' + escapeHtml(filterTahun) + ' tidak ditemukan.</td></tr>';
                }
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Data Renstra masih kosong.</td></tr>';
            }
        });
}

function submitImportRenstra() {
    const fileInput = document.getElementById('renstra_file');
    const yearOverride = document.getElementById('renstra_import_year')?.value;
    const file = fileInput.files[0];
    if (!file) return;

    const btn = document.getElementById('renstraImportBtn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Syncing Matrix...';

    const fd = new FormData();
    fd.append('file', file);
    if (yearOverride) fd.append('tahun_override', yearOverride);
    fd.append('_token', '{{ csrf_token() }}');

    fetch('/admin/renstra/import', {
        method: 'POST',
        body: fd,
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        if (res.success) {
            showToast(res.message, 'success');
            document.getElementById('renstra_file').value = '';
            fetchRenstraList();
        } else {
            showToast(res.message || 'Gagal mengimpor data.', 'warning');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        console.error(err);
        showToast('Terjadi kesalahan koneksi atau server saat mengimpor.', 'warning');
    });
}

function openRenstraModal(item = null) {
    const overlay = document.getElementById('modalOverlay');
    const modal   = item ? document.getElementById('modalEdit') : document.getElementById('modalTambah');
    const container = item ? document.getElementById('edit-fields-container') : document.getElementById('add-fields-container');
    
    document.getElementById('modalEdit').classList.add('hidden');
    document.getElementById('modalTambah').classList.add('hidden');
    
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    overlay.style.opacity = '1';
    overlay.style.pointerEvents = 'auto';
    setTimeout(() => modal.classList.remove('scale-95'), 10);

    let fieldsHtml = `
        <input type="hidden" id="renstra_id" value="${item ? escapeHtml(item.id) : ''}">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Program / Kelompok</label>
            <input type="text" id="renstra_program" value="${item ? escapeHtml(item.program || '') : ''}" placeholder="Contoh: R 1: Kesiapan Kerja Lulusan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Indikator Kinerja</label>
            <textarea id="renstra_indikator" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">${item ? escapeHtml(item.indikator) : ''}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">PIC</label>
                <input type="text" id="renstra_pic" value="${item ? escapeHtml(item.pic || '') : ''}" placeholder="WD 1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun (YYYY)</label>
                <input type="number" id="renstra_tahun" value="${item ? escapeHtml(item.tahun) : new Date().getFullYear()}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Target (%)</label>
                <input type="number" step="0.01" id="renstra_target" value="${item ? escapeHtml(item.target) : 0}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Realisasi (%)</label>
                <input type="number" step="0.01" id="renstra_realisasi" value="${item ? escapeHtml(item.realisasi) : 0}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>
    `;
    container.innerHTML = fieldsHtml;
}

function submitRenstra(isEdit = false) {
    const id = document.getElementById('renstra_id').value;
    const data = {
        program:   document.getElementById('renstra_program').value,
        indikator: document.getElementById('renstra_indikator').value,
        pic:       document.getElementById('renstra_pic').value,
        tahun:     document.getElementById('renstra_tahun').value,
        target:    document.getElementById('renstra_target').value,
        realisasi: document.getElementById('renstra_realisasi').value,
        _token:    '{{ csrf_token() }}'
    };

    const url = isEdit ? `/admin/renstra/${id}/update` : '/admin/renstra/store';
    
    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            closeModal();
            fetchRenstraList();
        } else {
            showToast(res.message || 'Gagal menyimpan data.', 'warning');
        }
    })
    .catch(err => {
        console.error(err);
        showToast('Terjadi kesalahan sistem.', 'warning');
    });
}

async function deleteRenstra(id) {
    if (!(await window.swalConfirm('Hapus data Renstra ini?'))) return;
    fetch(`/admin/renstra/delete/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            fetchRenstraList();
        } else {
            showToast(res.message || 'Gagal menghapus data.', 'warning');
        }
    });
}

async function truncateRenstra() {
    if (!(await window.swalConfirm('Peringatan: Semua data Renstra akan dihapus secara permanen. Lanjutkan?'))) return;
    fetch('/admin/renstra/truncate', {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            fetchRenstraList();
        }
    });
}