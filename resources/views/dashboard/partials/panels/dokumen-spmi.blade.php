// Fungsi Helper untuk Mencegah XSS (Escaping Output pada Template Literal)
function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function loadDokumenSpmiPanel() {
    const content = document.getElementById('dynamic-content');
    content.innerHTML = `
    <div class="max-w-7xl mx-auto pb-12">
        <!-- Header -->
        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-file-alt"></i></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Dokumen</p>
                </div>
                <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Dokumen SPMI</h2>
                <p class="text-slate-500 text-sm mt-2">Upload, kelola, dan hapus dokumen SPMI. Perubahan langsung tampil di halaman publik.</p>
            </div>
            <a href="/spmi/dokumen-spmi" target="_blank" class="relative z-10 inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-5 py-3 rounded-xl transition-all">
                <i class="fas fa-external-link-alt text-xs"></i> Lihat Halaman Publik
            </a>
        </div>

        <!-- Upload Form -->
        <div id="uploadFormContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Upload Dokumen Baru</h3>
                <button onclick="toggleUploadForm()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest"><i class="fas fa-times mr-1"></i> Tutup</button>
            </div>
            <form id="uploadDokumenForm" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" id="ud_judul" placeholder="Contoh: Standar Mutu Penelitian" required
                            class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun <span class="text-rose-500">*</span></label>
                        <input type="number" id="ud_tahun" min="2000" max="2099" placeholder="${new Date().getFullYear()}" required
                            class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                        <input type="text" id="ud_kategori" placeholder="Ketik kategori baru atau pilih..." list="kategori_list"
                            class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                        <datalist id="kategori_list">
                            <option value="Dokumen SPMI">
                            <option value="Standar Mutu">
                            <option value="Kebijakan Mutu">
                            <option value="Prosedur Mutu">
                            <option value="Formulir Mutu">
                            <option value="Dokumen Pendukung">
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                        <input type="text" id="ud_deskripsi" placeholder="Opsional — keterangan singkat dokumen"
                            class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Drag & Drop Zone -->
                <div id="dropzone" onclick="document.getElementById('ud_file').click()"
                    class="border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-3xl p-12 flex flex-col items-center justify-center cursor-pointer transition-all bg-slate-50 hover:bg-blue-50/30 group">
                    <div id="dropzone-icon" class="w-16 h-16 rounded-2xl bg-white border border-slate-200 group-hover:border-blue-200 shadow-sm flex items-center justify-center mb-4 transition-all">
                        <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>
                    </div>
                    <p id="dropzone-text" class="text-sm font-bold text-slate-500 group-hover:text-blue-600 transition-colors">Klik atau seret file ke sini</p>
                    <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP — Maks. 20MB</p>
                    <input type="file" id="ud_file" name="file" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar">
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" id="uploadBtn" onclick="submitUploadDokumen()"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-widest px-10 py-4 rounded-2xl shadow-[0_10px_25px_rgba(37,99,235,0.3)] hover:-translate-y-1 transition-all flex items-center gap-3">
                        <i class="fas fa-upload"></i> Upload Dokumen
                    </button>
                </div>
            </form>
        </div>

        <!-- Dokumen Table -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="px-10 py-7 border-b border-slate-100 flex flex-wrap items-center justify-between bg-slate-50/50 gap-4">
                <div>
                    <h3 class="text-xl font-black text-slate-800 font-display">Daftar Dokumen</h3>
                    <p id="dok-count" class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Memuat...</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="toggleUploadForm()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all shadow-sm flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Dokumen
                    </button>
                    <button onclick="fetchDokumenList()" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 flex items-center justify-center transition-all" title="Refresh">
                        <i class="fas fa-sync-alt text-sm"></i>
                    </button>
                </div>
            </div>
            <div id="dokumen-table-wrap" class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-12">#</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Judul Dokumen</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-24">Tahun</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-36">Kategori</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-28">File</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-20">↓</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dokumen-tbody" class="divide-y divide-slate-50">
                        <tr><td colspan="7" class="px-8 py-10 text-center text-slate-400 font-medium">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editDokumenModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden">
            <div class="px-10 py-7 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-xl font-display">Edit Dokumen</h3>
                <button onclick="closeEditDokModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-10 space-y-4">
                <input type="hidden" id="edit_dok_id">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Dokumen</label>
                    <input type="text" id="edit_judul" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun</label>
                        <input type="number" id="edit_tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                        <input type="text" id="edit_kategori" list="kategori_list" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                    <input type="text" id="edit_deskripsi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti File (opsional)</label>
                    <input type="file" id="edit_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                        class="w-full p-3 border border-slate-200 rounded-2xl text-sm text-slate-600 bg-slate-50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold file:text-xs">
                    <p id="edit_current_file" class="text-xs text-slate-400 mt-2"></p>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button onclick="closeEditDokModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs rounded-2xl hover:bg-slate-50 transition tracking-widest uppercase">Batal</button>
                    <button onclick="submitEditDokumen()" class="px-8 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    `;

    // Drag-drop events
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('ud_file');
    if (dropzone && fileInput) {
        dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('border-blue-400', 'bg-blue-50/50'); });
        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-blue-400', 'bg-blue-50/50'));
        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('border-blue-400', 'bg-blue-50/50');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                updateDropzoneUI(e.dataTransfer.files[0]);
            }
        });
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) updateDropzoneUI(fileInput.files[0]);
        });
    }

    fetchDokumenList();
}

function updateDropzoneUI(file) {
    const ext = file.name.split('.').pop().toLowerCase();
    const icons = { pdf: 'fa-file-pdf text-red-500', doc: 'fa-file-word text-blue-500', docx: 'fa-file-word text-blue-500', xls: 'fa-file-excel text-green-500', xlsx: 'fa-file-excel text-green-500' };
    const iconClass = icons[ext] || 'fa-file-alt text-slate-500';
    const size = (file.size / (1024*1024)).toFixed(2) + ' MB';
    document.getElementById('dropzone-icon').innerHTML = `<i class="fas ${escapeHtml(iconClass)} text-3xl"></i>`;
    document.getElementById('dropzone-text').textContent = `✓ ${file.name} (${size})`;
    document.getElementById('dropzone-text').classList.add('text-blue-600');
}

function fetchDokumenList() {
    fetch('/admin/dokumen-spmi')
        .then(r => r.json())
        .then(res => {
            if (!res.success) return;
            const tbody = document.getElementById('dokumen-tbody');
            const countEl = document.getElementById('dok-count');
            if (!tbody) return;

            countEl.textContent = res.data.length + ' dokumen tersimpan di database';

            if (res.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="px-8 py-12 text-center text-slate-400 font-medium"><i class="fas fa-folder-open text-3xl block mb-3 opacity-30"></i>Belum ada dokumen. Upload dokumen pertama Anda di atas.</td></tr>`;
                return;
            }

            tbody.innerHTML = res.data.map((d, i) => `
                <tr class="hover:bg-blue-50/20 transition-colors group">
                    <td class="px-8 py-6 text-center">
                        <span class="text-[11px] font-black text-slate-400">${String(i+1).padStart(2,'0')}</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                <i class="${escapeHtml(d.icon_class) || 'fas fa-file-alt text-slate-400'} text-sm"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm leading-snug">${escapeHtml(d.judul)}</p>
                                ${d.deskripsi ? `<p class="text-xs text-slate-400 mt-0.5 line-clamp-1">${escapeHtml(d.deskripsi)}</p>` : ''}
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-black px-3 py-1.5 rounded-xl">${escapeHtml(String(d.tahun))}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-semibold text-slate-500">${escapeHtml(d.kategori)}</span>
                    </td>
                    <td class="px-8 py-6">
                        ${d.nama_file ? `
                        <div>
                            <span class="inline-block bg-slate-100 text-slate-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">${escapeHtml(d.tipe_file || 'file')}</span>
                            <p class="text-[10px] text-slate-400 mt-1">${escapeHtml(d.ukuran_file || '')}</p>
                        </div>` : '<span class="text-slate-300 text-xs">—</span>'}
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="text-sm font-bold text-slate-500">${escapeHtml(String(d.downloads))}</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-2">
                            <button onclick="openEditDokModal(${escapeHtml(JSON.stringify(d)).replace(/"/g,'&quot;')})"
                                class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Edit">
                                <i class="fas fa-pen text-xs"></i>
                            </button>
                            <button onclick="deleteDokumen(${d.id}, this)"
                                class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        })
        .catch(() => showToast('Gagal memuat daftar dokumen.', 'warning'));
}

function submitUploadDokumen() {
    const judul = document.getElementById('ud_judul')?.value?.trim();
    const tahun = document.getElementById('ud_tahun')?.value?.trim();
    const file  = document.getElementById('ud_file')?.files[0];

    if (!judul) { showToast('Judul dokumen wajib diisi!', 'warning'); return; }
    if (!tahun) { showToast('Tahun wajib diisi!', 'warning'); return; }
    if (!file)  { showToast('Pilih file untuk diupload!', 'warning'); return; }

    const formData = new FormData();
    formData.append('judul',    judul);
    formData.append('tahun',    tahun);
    formData.append('deskripsi', document.getElementById('ud_deskripsi')?.value || '');
    formData.append('kategori', document.getElementById('ud_kategori')?.value || 'Dokumen SPMI');
    formData.append('file',     file);
    formData.append('_token',   '{{ csrf_token() }}');

    const btn = document.getElementById('uploadBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';

    fetch('/admin/dokumen-spmi/upload', { 
        method: 'POST', 
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(async r => {
            const data = await r.json();
            if (!r.ok) {
                throw new Error(data.message || 'Terjadi kesalahan sistem.');
            }
            return data;
        })
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-upload"></i> Upload Dokumen';
            if (res.success) {
                showToast(res.message, 'success');
                document.getElementById('ud_judul').value = '';
                document.getElementById('ud_tahun').value = '';
                document.getElementById('ud_deskripsi').value = '';
                document.getElementById('ud_file').value = '';
                document.getElementById('dropzone-text').textContent = 'Klik atau seret file ke sini';
                document.getElementById('dropzone-text').classList.remove('text-blue-600');
                document.getElementById('dropzone-icon').innerHTML = '<i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>';
                fetchDokumenList();
            } else {
                showToast(res.message || 'Upload gagal.', 'warning');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-upload"></i> Upload Dokumen';
            showToast(err.message || 'Terjadi kesalahan saat upload.', 'warning');
        });
}

function openEditDokModal(d) {
    document.getElementById('edit_dok_id').value   = d.id;
    document.getElementById('edit_judul').value    = d.judul;
    document.getElementById('edit_tahun').value    = d.tahun;
    document.getElementById('edit_deskripsi').value= d.deskripsi || '';
    document.getElementById('edit_current_file').textContent = d.nama_file ? 'File saat ini: ' + d.nama_file + ' (' + (d.ukuran_file||'') + ')' : 'Belum ada file';
    document.getElementById('edit_kategori').value = d.kategori;
    document.getElementById('editDokumenModal').classList.remove('hidden');
}

function closeEditDokModal() {
    document.getElementById('editDokumenModal').classList.add('hidden');
    document.getElementById('edit_file').value = '';
}

function submitEditDokumen() {
    const id = document.getElementById('edit_dok_id').value;
    const formData = new FormData();
    formData.append('judul',    document.getElementById('edit_judul').value);
    formData.append('tahun',    document.getElementById('edit_tahun').value);
    formData.append('deskripsi',document.getElementById('edit_deskripsi').value);
    formData.append('kategori', document.getElementById('edit_kategori').value);
    formData.append('_token',   '{{ csrf_token() }}');
    formData.append('_method',  'POST');
    const fileEl = document.getElementById('edit_file');
    if (fileEl.files.length > 0) formData.append('file', fileEl.files[0]);

    fetch(`/admin/dokumen-spmi/${id}/update`, { method: 'POST', body: formData })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                showToast(res.message, 'success');
                closeEditDokModal();
                fetchDokumenList();
            } else {
                showToast(res.message || 'Gagal menyimpan.', 'warning');
            }
        })
        .catch(() => showToast('Terjadi kesalahan.', 'warning'));
}

async function deleteDokumen(id, btn) {
    if (!(await window.swalConfirm('Hapus dokumen ini beserta file-nya secara permanen?'))) return;
    fetch(`/admin/dokumen-spmi/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            const row = btn.closest('tr');
            row.style.opacity = 0; row.style.transform = 'translateX(20px)'; row.style.transition = 'all 0.3s';
            setTimeout(() => { row.remove(); fetchDokumenList(); }, 300);
        } else {
            showToast(res.message || 'Gagal menghapus.', 'warning');
        }
    })
    .catch(() => showToast('Terjadi kesalahan.', 'warning'));
}