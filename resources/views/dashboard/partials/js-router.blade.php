function loadPage(title) {
            // Modul Galeri khusus
            if (title === 'Dokumentasi Foto') {
                loadGaleriFotoPanel();
                return;
            }
            if (title === 'Galeri Video') {
                loadGaleriVideoPanel();
                return;
            }
            if (title === 'Kepuasan Dosen & Tendik' || title === 'Kuesioner Dosen & Karyawan') {
                loadKuesionerDosenPanel();
                return;
            }
            if (title === 'Kuesioner Mahasiswa') {
                loadKuesionerMahasiswaPanel();
                return;
            }


            currentTitle = title;
            const content = document.getElementById('dynamic-content');
            content.style.opacity = 0;
            
            setTimeout(() => {

                // ============================================================
                // DOKUMEN SPMI — Panel Upload Khusus
                // ============================================================
                if (title === 'Dokumen SPMI') {
                    loadDokumenSpmiPanel();
                    content.style.opacity = 1;
                    return;
                }

                // ============================================================
                // LAPORAN AMI — Panel Upload Khusus
                // ============================================================
                if (title === 'Laporan AMI') {
                    loadLaporanAmiPanel();
                    content.style.opacity = 1;
                    return;
                }

                // ============================================================
                // RTM — Panel Upload Khusus
                // ============================================================
                if (title === 'RTM') {
                    loadRtmPanel();
                    content.style.opacity = 1;
                    return;
                }

                if (title === 'Pengaturan Sistem') {
                    content.innerHTML = `
                    <div class="max-w-5xl mx-auto pb-12">
                        <!-- Brand (matching frontend) -->
                        <div class="px-8 py-8 flex items-center space-x-4 border-b border-white/5 relative z-10">
                            <div class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.3)] border border-blue-400/30 p-2 relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 backdrop-blur-sm pointer-events-none"></div>
                                <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="Logo" class="h-full w-full object-contain relative z-10 drop-shadow-md" onerror="this.src='https://ui-avatars.com/api/?name=PJ&background=transparent&color=fff&bold=true'">
                            </div>
                            <div class="flex-1">
                                <h1 class="text-xl font-black tracking-tighter text-white leading-none font-display">Politeknik Jambi</h1>
                                    <div class="mt-2">
                                        <span class="text-[9px] font-bold text-white/90 uppercase tracking-[0.12em]">LP3M / Sistem Online</span>
                                    </div>
                            </div>
                        </div>
                                <h3 class="w-full text-left text-[11px] font-black text-slate-400 mb-6 uppercase tracking-[0.2em] border-b border-slate-100 pb-4">Profil Administrator</h3>
                                <div class="relative mb-6 group cursor-pointer">
                                    <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff&bold=true&size=150" class="w-32 h-32 rounded-full shadow-xl border-4 border-white transition-transform group-hover:scale-105" alt="Admin">
                                    <div class="absolute inset-0 bg-slate-900/50 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <i class="fas fa-camera text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="w-full space-y-4 text-left">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Nama Lengkap</label>
                                        <input type="text" value="Super Admin" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Email Utama</label>
                                        <input type="email" value="admin@politeknikjambi.ac.id" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-2 space-y-8">
                                <!-- Card 2: Identitas Kampus -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)]">
                                    <h3 class="text-[11px] font-black text-slate-400 mb-6 uppercase tracking-[0.2em] border-b border-slate-100 pb-4">Identitas & Kontak Lembaga</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Nama Lembaga / Sistem</label>
                                            <input type="text" value="LP3M Politeknik Jambi" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Nomor Telepon Resmi</label>
                                            <input type="text" value="0852-7351-8763" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Email Resmi</label>
                                            <input type="email" value="info@politeknikjambi.ac.id" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-8 flex justify-end gap-4">
                            <button onclick="showHome()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase shadow-sm">Kembali</button>
                        </div>
                    </div>
                    `;
                    content.style.opacity = 1;
                    return;
                }

                // Ambil data real-time via API
                fetch(`/admin/page-data?title=${encodeURIComponent(title)}`)
                    .then(r => r.json())
                    .then(res => {
                        if (!res.success) {
                            showToast(res.message, 'warning');
                            showHome();
                            return;
                        }

                        loadedFields = res.fields;
                        loadedDefaults = res.defaults || {};

                        if (res.type === 'single') {
                            content.innerHTML = `
                            <div class="max-w-5xl mx-auto pb-12">
                                <!-- Page Header -->
                                <div class="bg-white/80 backdrop-blur-xl p-10 lg:p-12 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 relative overflow-hidden">
                                    <div class="absolute -right-10 -top-10 text-[200px] text-slate-100 opacity-50 pointer-events-none transform -rotate-12">
                                        <i class="fas fa-pen-nib"></i>
                                    </div>
                                    <div class="relative z-10">
                                        <div class="flex items-center gap-3 mb-4">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Konten Tunggal</p>
                                        </div>
                                        <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none mb-4">${title}</h2>
                                        <p class="text-slate-500 font-medium">Perbarui deskripsi ${title} secara langsung. Perubahan akan langsung disimpan secara permanen di database dan tayang di front-end.</p>
                                    </div>
                                </div>

                                <!-- Form Area -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10">
                                    <textarea id="single-editor-textarea" rows="12" class="w-full p-6 border border-slate-200 rounded-3xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-medium text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all resize-y shadow-inner leading-relaxed" placeholder="Ketik konten ${title} di sini...">${res.data.isi_konten || ''}</textarea>
                                    
                                    <div class="mt-10 flex justify-end gap-4 border-t border-slate-100 pt-8">
                                        <button onclick="showHome()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase shadow-sm">Batal</button>
                                        <button onclick="saveSingleContent()" class="px-8 py-4 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.3)] hover:bg-blue-700 transition-all hover:-translate-y-1 tracking-widest uppercase flex items-center gap-3">
                                            <i class="fas fa-save text-sm"></i>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            `;
                        } else {
                            // Tipe Tabel / List
                            retrievedData = res.data;

                            // Bangun headers
                            let headersHtml = `<th class="px-10 py-6 border-b border-slate-100 w-24 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">UID</th>`;
                            res.fields.forEach(field => {
                                const label = field.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                                headersHtml += `<th class="px-10 py-6 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">${label}</th>`;
                            });
                            headersHtml += `<th class="px-10 py-6 border-b border-slate-100 text-right w-48 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Manajemen</th>`;

                            // Bangun rows
                            let rowsHtml = "";
                            if (res.data.length === 0) {
                                rowsHtml = `<tr><td colspan="${res.fields.length + 2}" class="px-10 py-12 text-center font-bold text-slate-400">Belum ada data entri di database untuk modul ini.</td></tr>`;
                            } else {
                                res.data.forEach((item, index) => {
                                    const paddedIndex = String(index + 1).padStart(3, '0');
                                    let cellsHtml = `<td class="px-10 py-8 font-black text-slate-400 text-center font-display">${paddedIndex}</td>`;
                                    
                                    res.fields.forEach(field => {
                                        let displayVal = item[field] || "";
                                        // Safely strip HTML tags using regex to avoid parsing/executing embedded scripts
                                        if (typeof displayVal === 'string') {
                                            displayVal = displayVal.replace(/<[^>]*>/g, '');
                                        }
                                        // truncate if too long
                                        if (displayVal.length > 80) {
                                            displayVal = displayVal.slice(0, 80) + '...';
                                        }
                                        // Escape HTML entities to prevent XSS when inserting into DOM
                                        displayVal = String(displayVal).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                                        cellsHtml += `<td class="px-10 py-8 leading-relaxed font-semibold text-slate-700 text-sm">${displayVal}</td>`;
                                    });

                                     cellsHtml += `
                                    <td class="px-10 py-8">
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="openModalEdit(${item.id})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Edit"><i class="fas fa-pen text-sm"></i></button>
                                            ${(currentTitle.includes('Kuesioner') || currentTitle.includes('Kuisioner')) ? 
                                                `<button onclick="openManageQuestions(${item.id}, '${item.judul}')" class="text-slate-400 hover:text-emerald-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Kelola Pertanyaan"><i class="fas fa-question text-sm"></i></button>` : ''}
                                            <button onclick="confirmDelete(${item.id}, this)" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Hapus"><i class="fas fa-trash text-sm"></i></button>
                                        </div>
                                    </td>
                                    `;
                                    rowsHtml += `<tr class="hover:bg-slate-50/50 transition-colors group">${cellsHtml}</tr>`;
                                });
                            }

                            content.innerHTML = `
                            <div class="max-w-7xl mx-auto pb-12">
                                <!-- Page Header -->
                                <div class="bg-white/80 backdrop-blur-xl p-10 lg:p-12 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
                                    <div class="absolute -right-20 -top-20 text-[200px] text-slate-100 opacity-50 pointer-events-none transform -rotate-12">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div class="relative z-10">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Modul Aktif</p>
                                        </div>
                                        <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">${title}</h2>
                                    </div>
                                    <div class="flex gap-4 items-center relative z-10">
                                        ${(title === 'Kuesioner Dosen & Karyawan') ? `
                                            <button onclick="openImportKuesioner()" class="bg-emerald-600 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(16,185,129,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(16,185,129,0.3)] hover:bg-emerald-700">
                                                <i class="fas fa-file-excel"></i>
                                                <span class="tracking-widest uppercase text-[10px]">Impor Excel</span>
                                            </button>
                                        ` : ''}
                                        <button onclick="openTambah()" class="bg-slate-900 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(15,23,42,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.3)] hover:bg-slate-800">
                                            <i class="fas fa-plus"></i>
                                            <span class="tracking-widest uppercase text-[10px]">Tambah Entri</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Table Area -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)]">
                                    <div class="overflow-x-auto table-responsive">
                                        <table class="w-full text-left border-collapse">
                                            <thead class="bg-slate-50/50">
                                                <tr>
                                                    ${headersHtml}
                                                </tr>
                                            </thead>
                                            <tbody id="table-body" class="divide-y divide-slate-50">
                                                ${rowsHtml}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            `;
                        }
                        content.style.opacity = 1;
                        // Initialize Rich Editor for single editor
                        if (res.type === 'single') {
                            setTimeout(() => initRichEditor('#single-editor-textarea'), 200);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Gagal memuat data dari server.', 'warning');
                        showHome();
                    });
            }, 300);
        }
