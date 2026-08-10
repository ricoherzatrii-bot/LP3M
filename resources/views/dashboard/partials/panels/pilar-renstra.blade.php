// Fungsi utilitas untuk escaping string HTML guna mencegah XSS
function escapeHtmlPilar(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function loadPilarRenstraPanel() {
    const content = document.getElementById('dynamic-content');
    content.innerHTML = `
    <div class="max-w-7xl mx-auto pb-12">
        <!-- Header -->
        <div class="bg-white/85 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-columns"></i></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.6)]"></span>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Konfigurasi Pilar</p>
                </div>
                <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Pilar Renstra</h2>
                <div class="flex items-center gap-3 mt-2">
                     <p class="text-slate-500 text-sm">Kelola data 8 Pilar (Tujuan) Renstra yang ditampilkan di halaman publik.</p>
                     <button onclick="openPilarModal()" class="ml-4 bg-indigo-600 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 transition-all flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Pilar
                     </button>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white/85 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="px-10 py-7 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-xl font-black text-slate-800 font-display">Daftar Pilar Terdaftar</h3>
                <button onclick="fetchPilarList()" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-300 flex items-center justify-center transition-all">
                    <i class="fas fa-sync-alt text-sm"></i>
                </button>
            </div>
            <div class="overflow-x-auto max-h-[600px]">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center w-16">Urutan</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center w-20">Kode</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Judul Pilar</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center w-24">Warna</th>
                            <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pilar-tbody" class="divide-y divide-slate-50">
                        <tr><td colspan="5" class="px-8 py-10 text-center text-slate-400 font-medium font-display">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    `;
    fetchPilarList();
}

function fetchPilarList() {
    const tbody = document.getElementById('pilar-tbody');
    if(!tbody) return;
    tbody.innerHTML = '<tr><td colspan="5" class="px-8 py-10 text-center"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...</td></tr>';
    
    fetch('/admin/pilar-renstra')
        .then(r => r.json())
        .then(res => {
            if (res.success && res.data.length > 0) {
                tbody.innerHTML = res.data.map(item => `
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-xs font-black text-slate-600">${escapeHtmlPilar(item.urutan)}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-[11px] font-black text-white shadow-sm" style="background-color: ${escapeHtmlPilar(item.warna)}">${escapeHtmlPilar(item.kode)}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-800 leading-relaxed">${escapeHtmlPilar(item.judul)}</div>
                            <div class="text-[9px] font-medium text-slate-400 uppercase tracking-widest mt-1">${escapeHtmlPilar(item.gradient_class)}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-6 h-6 rounded-lg border border-slate-200 shadow-sm" style="background-color: ${escapeHtmlPilar(item.warna)}"></div>
                                <span class="text-[10px] font-mono font-bold text-slate-500">${escapeHtmlPilar(item.warna)}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick='openPilarModal(${JSON.stringify(item).replace(/'/g, "&#39;")})' class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition-all border border-indigo-100"><i class="fas fa-edit text-[10px]"></i></button>
                                <button onclick="deletePilar(${item.id})" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all border border-rose-100"><i class="fas fa-trash text-[10px]"></i></button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="5" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Belum ada data pilar. Klik "Tambah Pilar" untuk memulai.</td></tr>';
            }
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = '<tr><td colspan="5" class="px-8 py-16 text-center text-rose-400 font-bold uppercase tracking-widest text-[10px]">Gagal memuat data pilar.</td></tr>';
        });
}

function openPilarModal(item = null) {
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

    // Set the submit handler
    if (item) {
        document.getElementById('modalEdit').setAttribute('data-submit-fn', 'submitPilar');
        document.getElementById('modalEdit').setAttribute('data-is-edit', 'true');
    } else {
        document.getElementById('modalTambah').setAttribute('data-submit-fn', 'submitPilar');
        document.getElementById('modalTambah').setAttribute('data-is-edit', 'false');
    }

    const gradientOptions = [
        { value: 'bg-gradient-to-br from-[#1e3a8a] to-blue-900', label: 'Blue Dark' },
        { value: 'bg-gradient-to-br from-[#16a085] to-emerald-800', label: 'Emerald' },
        { value: 'bg-gradient-to-br from-[#e91e63] to-pink-800', label: 'Pink' },
        { value: 'bg-gradient-to-br from-[#e67e22] to-orange-700', label: 'Orange' },
        { value: 'bg-gradient-to-br from-[#f1c40f] to-amber-600', label: 'Amber' },
        { value: 'bg-gradient-to-br from-[#2ecc71] to-green-700', label: 'Green' },
        { value: 'bg-gradient-to-br from-[#8e44ad] to-purple-900', label: 'Purple' },
        { value: 'bg-gradient-to-br from-[#3498db] to-blue-600', label: 'Blue' },
        { value: 'bg-gradient-to-br from-[#e74c3c] to-red-800', label: 'Red' },
        { value: 'bg-gradient-to-br from-[#1abc9c] to-teal-700', label: 'Teal' },
    ];

    let fieldsHtml = `
        <input type="hidden" id="pilar_id" value="${item ? escapeHtmlPilar(item.id) : ''}">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kode (Nomor Romawi)</label>
                <input type="text" id="pilar_kode" value="${item ? escapeHtmlPilar(item.kode) : ''}" placeholder="Contoh: I, II, III" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Urutan Tampil</label>
                <input type="number" id="pilar_urutan" value="${item ? escapeHtmlPilar(item.urutan) : '1'}" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Pilar / Tujuan</label>
            <textarea id="pilar_judul" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 outline-none">${item ? escapeHtmlPilar(item.judul) : ''}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Warna Hex</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="pilar_warna_picker" value="${item ? item.warna : '#1e3a8a'}" class="w-10 h-10 rounded-lg border border-slate-200 cursor-pointer" onchange="document.getElementById('pilar_warna').value = this.value">
                    <input type="text" id="pilar_warna" value="${item ? escapeHtmlPilar(item.warna) : '#1e3a8a'}" placeholder="#1e3a8a" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono font-semibold focus:ring-2 focus:ring-indigo-500 outline-none" onchange="document.getElementById('pilar_warna_picker').value = this.value">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Gradient Style</label>
                <select id="pilar_gradient" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 outline-none">
                    ${gradientOptions.map(opt => `<option value="${escapeHtmlPilar(opt.value)}" ${item && item.gradient_class === opt.value ? 'selected' : ''}>${escapeHtmlPilar(opt.label)} — ${escapeHtmlPilar(opt.value)}</option>`).join('')}
                </select>
            </div>
        </div>
    `;
    container.innerHTML = fieldsHtml;
}

function submitPilar(isEdit = false) {
    const id = document.getElementById('pilar_id').value;
    const data = {
        kode:           document.getElementById('pilar_kode').value,
        judul:          document.getElementById('pilar_judul').value,
        warna:          document.getElementById('pilar_warna').value,
        gradient_class: document.getElementById('pilar_gradient').value,
        urutan:         document.getElementById('pilar_urutan').value,
        _token:         '{{ csrf_token() }}'
    };

    const url = isEdit ? `/admin/pilar-renstra/${id}/update` : '/admin/pilar-renstra/store';
    
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
            fetchPilarList();
        } else {
            showToast(res.message || 'Gagal menyimpan data.', 'warning');
        }
    })
    .catch(err => {
        console.error(err);
        showToast('Terjadi kesalahan sistem.', 'warning');
    });
}

async function deletePilar(id) {
    if (!(await window.swalConfirm('Hapus pilar Renstra ini?'))) return;
    fetch(`/admin/pilar-renstra/delete/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            fetchPilarList();
        } else {
            showToast(res.message || 'Gagal menghapus data.', 'warning');
        }
    });
}
