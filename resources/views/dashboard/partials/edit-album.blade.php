<!-- EDIT ALBUM MODAL -->
    <div id="editAlbumModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="editAlbumModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden scale-95 transition-transform duration-200 flex flex-col max-h-[90vh]">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Edit Album Foto</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Perbarui nama & sampul album</p>
                </div>
                <button onclick="closeEditAlbumModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-grow space-y-5">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Album <span class="text-rose-500">*</span></label>
                    <input type="text" id="ea_nama" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti Sampul (Upload - Max 5MB)</label>
                    <input type="file" id="ea_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Atau Link Gambar</label>
                    <input type="text" id="ea_link" placeholder="https://..." class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 shrink-0 bg-white">
                <div class="flex justify-end gap-3">
                    <button onclick="closeEditAlbumModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors uppercase tracking-widest">Batal</button>
                    <button onclick="saveEditAlbum()" class="px-6 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all uppercase tracking-widest"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
     <!-- EDIT VIDEO MODAL -->
    <div id="editVideoModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="editVideoModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden scale-95 transition-transform duration-200 flex flex-col max-h-[90vh]">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Edit Video</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Perbarui data video</p>
                </div>
                <button onclick="closeEditVideoModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-grow space-y-5">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Video <span class="text-rose-500">*</span></label>
                    <input type="text" id="ev_judul" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                    <input type="text" id="ev_deskripsi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <!-- Edit Source Selector -->
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Sumber Video</label>
                    <div class="flex gap-3 mb-4">
                        <button type="button" onclick="setEditVideoSource('file')" id="evSrcFile" class="flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all">
                            <i class="fas fa-upload mr-1"></i> Upload Lokal
                        </button>
                        <button type="button" onclick="setEditVideoSource('link')" id="evSrcLink" class="flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all">
                            <i class="fab fa-youtube mr-1"></i> Link YouTube/URL
                        </button>
                    </div>
                </div>
                <div id="evFileSection">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti File Video (Lokal - Max 40MB)</label>
                    <input type="file" id="ev_file" accept="video/mp4,video/x-matroska,video/x-ms-wmv" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                    <p class="text-[9px] text-slate-400 mt-1 font-bold italic">Biarkan kosong jika tidak ingin mengganti video.</p>
                </div>
                <div id="evLinkSection" class="hidden">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link YouTube / URL Video</label>
                    <input type="text" id="ev_link" placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 shrink-0 bg-white">
                <div class="flex justify-end gap-3">
                    <button onclick="closeEditVideoModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors uppercase tracking-widest">Batal</button>
                    <button onclick="saveEditVideo()" class="px-6 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all uppercase tracking-widest"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MANAGE PHOTOS MODAL -->
    <div id="managePhotosModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="managePhotosModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-4xl overflow-hidden scale-95 transition-transform duration-200 flex flex-col max-h-[90vh]">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Kelola Foto Album</h3>
                    <p id="mp_album_name" class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">Nama Album</p>
                </div>
                <button onclick="closeManagePhotosModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-10 overflow-y-auto custom-scrollbar flex-grow">
                <!-- Upload Area -->
                <div class="mb-10 p-8 rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Foto</label>
                            <input type="text" id="mp_title" placeholder="Contoh: Kegiatan Workshop" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm font-semibold text-slate-700 bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Foto</label>
                            <input type="text" id="mp_description" placeholder="Keterangan singkat foto" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm font-semibold text-slate-700 bg-white">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link Foto (Opsional)</label>
                        <textarea id="mp_links" rows="3" placeholder="Masukkan satu URL foto per baris atau paste beberapa link langsung" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none text-sm font-semibold text-slate-700 bg-white"></textarea>
                        <p class="text-[9px] text-slate-400 mt-2 leading-relaxed font-semibold uppercase tracking-wider italic">Bisa diisi dengan link foto dari Google Drive, Unsplash, CDN, atau URL gambar lain.</p>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="flex-grow w-full">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Tambah Foto Baru (Pilih banyak foto sekaligus)</label>
                            <input type="file" id="mp_files" multiple accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all cursor-pointer">
                        </div>
                        <button id="mp_upload_btn" onclick="submitAddPhotos()" class="shrink-0 bg-emerald-500 hover:bg-emerald-600 text-white font-black uppercase tracking-widest text-[10px] px-8 py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-95">
                            <i class="fas fa-upload mr-2"></i> Unggah Foto
                        </button>
                    </div>
                    <p class="text-[9px] text-slate-400 mt-4 leading-relaxed font-semibold uppercase tracking-wider italic">* Ukuran file disarankan di bawah 10MB per foto. Anda dapat memilih beberapa file sekaligus.</p>
                </div>

                <div class="mb-4 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Foto dalam Album</h4>
                </div>
                
                <div id="mp_photos_grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <!-- Photos will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT PHOTO MODAL -->
    <div id="editPhotoModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="editPhotoModalBox" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden scale-95 transition-transform duration-200 flex flex-col max-h-[90vh]">
            <div class="px-10 py-8 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Edit Foto</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Perbarui judul, deskripsi, atau file foto</p>
                </div>
                <button onclick="closeEditPhotoModal()" class="w-10 h-10 rounded-2xl bg-white hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-grow space-y-5">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Judul Foto</label>
                    <input type="text" id="ep_title" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                    <input type="text" id="ep_description" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ganti File Foto</label>
                    <input type="file" id="ep_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 shrink-0 bg-white">
                <div class="flex justify-end gap-3">
                    <button onclick="closeEditPhotoModal()" class="px-6 py-3 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors uppercase tracking-widest">Batal</button>
                    <button onclick="saveEditPhoto()" class="px-6 py-3 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-emerald-700 transition-all uppercase tracking-widest"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>