function loadGaleriVideoPanel() {

            const content = document.getElementById('dynamic-content');
            content.innerHTML = `
            <div class="max-w-7xl mx-auto pb-12">
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-video"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-2 h-2 rounded-full bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.6)]"></span>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Video</p>
                        </div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Galeri Video</h2>
                        <p class="text-slate-500 text-sm mt-2">Upload file video atau pasang link YouTube.</p>
                    </div>
                    <button onclick="toggleUploadForm()" class="relative z-10 bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-[0_8px_20px_rgba(0,0,0,0.1)] transition-all hover:-translate-y-1">
                        <i class="fas fa-plus mr-2 text-[10px]"></i> Tambah Video
                    </button>
                </div>

                <div id="uploadFormContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Tambah Video Baru</h3>
                        <button onclick="toggleUploadForm()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest"><i class="fas fa-times mr-1"></i> Batal</button>
                    </div>
                    <form id="uploadGaleriVideoForm" enctype="multipart/form-data">
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Video <span class="text-rose-500">*</span></label>
                            <input type="text" id="gv_judul" placeholder="Contoh: Profil LPM Poljam 2024" required
                                class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                        </div>
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                            <input type="text" id="gv_deskripsi" placeholder="Keterangan singkat tentang video ini"
                                class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                        </div>
                        <!-- Source type selector -->
                        <div class="mb-4">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Sumber Video</label>
                            <div class="flex gap-3">
                                <button type="button" onclick="setVideoSource('file')" id="gvSrcFile" class="flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all">
                                    <i class="fas fa-upload mr-1"></i> Upload Lokal
                                </button>
                                <button type="button" onclick="setVideoSource('link')" id="gvSrcLink" class="flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all">
                                    <i class="fab fa-youtube mr-1"></i> Link YouTube/URL
                                </button>
                            </div>
                        </div>
                        <div id="gvFileSection" class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Upload Video (Lokal - Max 40MB)</label>
                            <input type="file" id="gv_file" accept="video/mp4,video/x-matroska,video/x-ms-wmv" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 transition-all">
                            <p class="text-[9px] text-slate-400 mt-2 italic font-bold">Format: MP4, MKV, WMV. Limit server: 40MB.</p>
                        </div>
                        <div id="gvLinkSection" class="mb-6 hidden">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link YouTube / URL Video</label>
                            <input type="text" id="gv_link" placeholder="https://www.youtube.com/watch?v=... atau URL video lain"
                                class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            <p class="text-[9px] text-slate-400 mt-2 italic font-bold">Masukkan link YouTube lengkap atau URL video publik.</p>
                        </div>
                        <button type="button" onclick="submitUploadVideo()" id="uploadVideoBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all">
                            <i class="fas fa-save mr-2"></i> Simpan Video
                        </button>
                    </form>
                </div>

                <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.02)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-20 text-center">No</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Judul Video</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="galeri-video-tbody"></tbody>
                    </table>
                </div>
            </div>
            `;
            fetchVideos();
        }
