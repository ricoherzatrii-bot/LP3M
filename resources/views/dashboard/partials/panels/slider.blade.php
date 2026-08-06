function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function loadSliderPanel() {
            currentTitle = 'Slider Homepage';
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;

            setTimeout(() => {
                content.innerHTML = `
                <div class="max-w-7xl mx-auto pb-12 overflow-x-auto">
                    <!-- Header -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-visible sticky top-4 z-20">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-images"></i></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Visual</p>
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Slider Homepage</h2>
                            <p class="text-slate-500 text-sm mt-2">Kelola gambar slide utama yang tampil di halaman depan website.</p>
                        </div>
                        <button onclick="openSliderModal()" class="bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.2)] transition-all hover:-translate-y-1 flex items-center gap-3 relative z-10">
                            <i class="fas fa-plus"></i> Tambah Slide
                        </button>
                    </div>

                    <!-- Slider Cards Grid -->
                    <div id="slider-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Loading State -->
                        <div class="col-span-full py-20 text-center">
                            <i class="fas fa-spinner fa-spin text-4xl text-slate-300"></i>
                            <p class="mt-4 text-slate-400 font-bold uppercase tracking-widest text-[10px]">Memuat Slide...</p>
                        </div>
                    </div>
                </div>

                <!-- SLIDER MODAL -->
                <div id="sliderModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto overflow-x-hidden transform transition-all duration-300 scale-95 opacity-0" id="sliderModalInner">
                        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <div>
                                <h3 class="font-black text-slate-800 text-xl font-display tracking-tight mb-1" id="sliderModalTitle">Tambah Slide</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Slider Homepage</p>
                            </div>
                            <button onclick="closeSliderModal()" class="w-12 h-12 rounded-2xl bg-white hover:bg-slate-100 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all hover:rotate-90"><i class="fas fa-times text-lg"></i></button>
                        </div>
                        <form id="sliderForm" onsubmit="event.preventDefault(); submitSlider();" class="p-10 space-y-5">
                            <input type="hidden" id="slider_id">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Judul Utama</label>
                                <input type="text" id="sl_judul" placeholder="Contoh: Implementasi Standar Mutu" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Sub Judul / Deskripsi Singkat</label>
                                <textarea id="sl_sub_judul" rows="2" placeholder="Deskripsi singkat yang tampil di bawah judul..." class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Urutan Tampil</label>
                                    <input type="number" id="sl_urutan" value="0" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Link URL (Opsional)</label>
                                    <input type="text" id="sl_link" placeholder="#" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2">Gambar Slide (Rekomendasi: 1920x800)</label>
                                <div id="slider-drop-area" class="relative border-2 border-dashed border-slate-200 hover:border-blue-400 bg-slate-50/50 rounded-2xl p-6 text-center transition-all group cursor-pointer">
                                    <input type="file" id="sl_gambar" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewSliderImage(this)">
                                    <div id="sl_preview_container" class="hidden mb-4">
                                        <img id="sl_preview_img" class="max-h-32 mx-auto rounded-xl shadow-sm border-2 border-white">
                                    </div>
                                    <div id="sl_placeholder">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-slate-300 group-hover:text-blue-500 transition-colors mb-2"></i>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Klik atau seret gambar ke sini</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                                <button type="button" onclick="closeSliderModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-[10px] uppercase tracking-widest hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                                <button type="submit" id="sliderSubmitBtn" class="px-6 py-3 bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all hover:-translate-y-0.5">Simpan Slide</button>
                            </div>
                        </form>
                    </div>
                </div>
                `;
                content.style.opacity = 1;
                fetchSliderList();
            }, 300);
        }

        function fetchSliderList() {
            const grid = document.getElementById('slider-grid');
            if(!grid) return;

            fetch('/admin/slider')
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        if (res.data.length === 0) {
                            grid.innerHTML = `<div class="col-span-full py-20 text-center bg-white/40 rounded-[2rem] border border-dashed border-slate-200">
                                <i class="fas fa-images text-4xl text-slate-200 mb-4 block"></i>
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-[11px]">Belum ada slide. Klik "Tambah Slide" di atas.</p>
                            </div>`;
                            return;
                        }

                        grid.innerHTML = res.data.map(m => `
                            <div class="group relative bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_10px_30px_rgba(0,0,0,0.02)] overflow-hidden hover:shadow-[0_20px_50px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-500">
                                <div class="aspect-[16/9] w-full overflow-hidden relative">
                                    <img src="/storage/${escapeHtml(m.gambar)}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='/images/gedung-poljam.png'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
                                    <div class="absolute top-4 right-4 flex gap-2">
                                        <button onclick='openSliderModal(${JSON.stringify(m).replace(/'/g, "&apos;")})' class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-md text-blue-600 shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><i class="fas fa-pen text-[10px]"></i></button>
                                        <button onclick="deleteSlider(${m.id})" class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-md text-rose-600 shadow-lg flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all"><i class="fas fa-trash text-[10px]"></i></button>
                                    </div>
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg shadow-lg">Urutan: ${escapeHtml(m.urutan)}</span>
                                    </div>
                                </div>
                                <div class="p-8">
                                    <h4 class="text-slate-800 font-black text-lg line-clamp-1 mb-2 font-display tracking-tight">${escapeHtml(m.judul || 'Tanpa Judul')}</h4>
                                    <p class="text-slate-500 text-xs line-clamp-2 font-medium leading-relaxed mb-4">${escapeHtml(m.sub_judul || '-')}</p>
                                    <div class="flex items-center gap-2 text-[9px] font-black text-blue-500 uppercase tracking-widest">
                                        <i class="fas fa-link"></i>
                                        <span class="truncate">${escapeHtml(m.link_url || '#')}</span>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    }
                })
                .catch(() => showToast('Gagal memuat slider.', 'warning'));
        }

        function openSliderModal(data = null) {
            const modal = document.getElementById('sliderModal');
            const inner = document.getElementById('sliderModalInner');
            const form  = document.getElementById('sliderForm');
            const title = document.getElementById('sliderModalTitle');
            
            form.reset();
            document.getElementById('slider_id').value = '';
            document.getElementById('sl_preview_container').classList.add('hidden');
            document.getElementById('sl_placeholder').classList.remove('hidden');

            if (data) {
                title.textContent = 'Edit Slide';
                document.getElementById('slider_id').value = data.id;
                document.getElementById('sl_judul').value = data.judul || '';
                document.getElementById('sl_sub_judul').value = data.sub_judul || '';
                document.getElementById('sl_urutan').value = data.urutan || 0;
                document.getElementById('sl_link').value = data.link_url || '';
                
                if (data.gambar) {
                    document.getElementById('sl_preview_img').src = '/storage/' + data.gambar;
                    document.getElementById('sl_preview_container').classList.remove('hidden');
                    document.getElementById('sl_placeholder').classList.add('hidden');
                }
            } else {
                title.textContent = 'Tambah Slide';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                inner.classList.remove('scale-95', 'opacity-0');
            }, 50);
        }

        function closeSliderModal() {
            const modal = document.getElementById('sliderModal');
            const inner = document.getElementById('sliderModalInner');
            inner.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function previewSliderImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('sl_preview_img').src = e.target.result;
                    document.getElementById('sl_preview_container').classList.remove('hidden');
                    document.getElementById('sl_placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function submitSlider() {
            const id = document.getElementById('slider_id').value;
            const btn = document.getElementById('sliderSubmitBtn');
            const originalText = btn.innerHTML;
            
            const fd = new FormData();
            fd.append('judul', document.getElementById('sl_judul').value);
            fd.append('sub_judul', document.getElementById('sl_sub_judul').value);
            fd.append('urutan', document.getElementById('sl_urutan').value);
            fd.append('link_url', document.getElementById('sl_link').value);
            fd.append('_token', '{{ csrf_token() }}');
            
            const fileInput = document.getElementById('sl_gambar');
            if (fileInput.files.length > 0) {
                fd.append('gambar', fileInput.files[0]);
            } else if (!id) {
                showToast('Gambar slide wajib diupload!', 'warning');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';

            const url = id ? `/admin/slider/${id}/update` : '/admin/slider';
            
            fetch(url, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(res => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    if (res.success) {
                        showToast(res.message, 'success');
                        closeSliderModal();
                        fetchSliderList();
                    } else {
                        showToast(res.message || 'Gagal menyimpan.', 'warning');
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    showToast('Terjadi kesalahan server.', 'warning');
                });
        }

        async function deleteSlider(id) {
            if (!(await window.swalConfirm('Hapus slide ini?'))) return;
            fetch(`/admin/slider/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    fetchSliderList();
                } else {
                    showToast(res.message || 'Gagal menghapus.', 'warning');
                }
            })
            .catch(() => showToast('Terjadi kesalahan koneksi.', 'warning'));
        }
