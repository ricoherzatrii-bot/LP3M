let b="",ne="";function z(e,t,a=""){let s="";a&&(s+=`<option value="">${a}</option>`);for(let l=e;l<=t;l++)s+=`<option value="${l}">${l}</option>`;return s}ne=document.getElementById("dynamic-content")?.innerHTML||"";function i(e,t="success"){const a=document.getElementById("toastContainer"),s=document.createElement("div");s.className="flex items-center gap-4 px-6 py-4 rounded-2xl shadow-[0_15px_40px_rgba(0,0,0,0.1)] border bg-white/90 backdrop-blur-xl transform transition-all duration-500 translate-y-10 opacity-0 pointer-events-auto";const l=t==="success"?'<div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg"><i class="fas fa-check"></i></div>':'<div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-lg"><i class="fas fa-exclamation"></i></div>';s.classList.add(t==="success"?"border-emerald-100":"border-rose-100"),s.innerHTML=`
                ${l}
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-slate-800">${t==="success"?"Berhasil":"Peringatan"}</h4>
                    <p class="text-xs font-medium text-slate-500">${e}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-2 w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button>
            `,a.appendChild(s),requestAnimationFrame(()=>{s.classList.remove("translate-y-10","opacity-0")}),setTimeout(()=>{s.classList.add("translate-y-10","opacity-0"),setTimeout(()=>s.remove(),500)},4e3)}function Me(){document.getElementById("profileDropdown").classList.toggle("hidden")}document.addEventListener("click",function(e){const t=document.getElementById("userProfileArea"),a=document.getElementById("profileDropdown");t&&!t.contains(e.target)&&!a.classList.contains("hidden")&&a.classList.add("hidden")});function N(){const e=new Date,t={hour:"2-digit",minute:"2-digit",second:"2-digit"},a={weekday:"long",year:"numeric",month:"long",day:"numeric"};document.getElementById("clock").innerText=e.toLocaleTimeString("id-ID",t),document.getElementById("date-display").innerText=e.toLocaleDateString("id-ID",a)}setInterval(N,1e3);N();function Le(e){const t=document.getElementById(e),a=document.getElementById("icon-"+e);t.classList.contains("hidden")?(e.startsWith("menu")&&document.querySelectorAll('[id^="menu"]').forEach(s=>{if(s.id!==e&&!s.classList.contains("hidden")&&s.id!=="modalOverlay"&&s.id!=="modalEdit"&&s.id!=="modalTambah"){s.classList.add("hidden");const l=document.getElementById("icon-"+s.id);l&&(l.style.transform="rotate(0deg)")}}),t.classList.remove("hidden"),t.classList.add("animate-fade-in"),a&&(a.style.transform="rotate(90deg)")):(t.classList.add("hidden"),t.classList.remove("animate-fade-in"),a&&(a.style.transform="rotate(0deg)"))}function T(){const e=document.getElementById("dynamic-content");e.style.opacity=0,setTimeout(()=>{e.innerHTML=ne,e.style.opacity=1},300)}let y=[],H={},oe=null,V=[],g={};class Se{constructor(t){this.loader=t}upload(){return this.loader.file.then(t=>new Promise((a,s)=>{const l=new FormData;l.append("upload",t);const o=new XMLHttpRequest;o.open("POST",window.dashboardConfig.uploadImageRoute,!0),o.setRequestHeader("X-CSRF-TOKEN",window.dashboardConfig.csrfToken),o.responseType="json",o.addEventListener("load",()=>{o.status>=200&&o.status<300&&o.response?.url?a({default:o.response.url}):s(o.response?.message||"Gagal mengunggah gambar.")}),o.addEventListener("error",()=>s("Gagal mengunggah gambar.")),o.addEventListener("abort",()=>s("Upload gambar dibatalkan.")),o.send(l)}))}abort(){}}async function A(e){const t=document.querySelectorAll(e);for(const a of t)if(!a.dataset.editorId)try{const s=await ClassicEditor.create(a,{toolbar:["heading","|","bold","italic","link","imageUpload","bulletedList","numberedList","blockQuote","insertTable","undo","redo"]});s.plugins.get("FileRepository").createUploadAdapter=o=>new Se(o);const l="editor-"+Math.random().toString(36).substr(2,9);a.dataset.editorId=l,g[l]=s,s.model.document.on("change:data",()=>{a.value=s.getData()})}catch(s){console.error("CKEditor initialization failed:",s)}}function ie(){Object.values(g).forEach(e=>{e.destroy().catch(t=>console.error("Destroy failed:",t))}),g={},document.querySelectorAll("[data-editor-id]").forEach(e=>delete e.dataset.editorId)}function L(e){if(e==="Dokumentasi Foto"){we();return}if(e==="Galeri Video"){_e();return}if(e==="Kepuasan Dosen & Tendik"||e==="Kuesioner Dosen & Karyawan"){me();return}if(e==="Kuesioner Mahasiswa"){he();return}b=e;const t=document.getElementById("dynamic-content");t.style.opacity=0,setTimeout(()=>{if(e==="Dokumen SPMI"){ce(),t.style.opacity=1;return}if(e==="Laporan AMI"){ue(),t.style.opacity=1;return}if(e==="RTM"){pe(),t.style.opacity=1;return}if(e==="Media Sosial"){re();return}if(e==="Pengaturan Sistem"){t.innerHTML=`
                    <div class="max-w-5xl mx-auto pb-12">
                        <!-- Header -->
                        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 relative overflow-hidden flex justify-between items-center">
                            <div class="relative z-10">
                                <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display mb-2">Pengaturan Sistem</h2>
                                <p class="text-slate-500 font-medium">Konfigurasi profil admin, identitas kampus, dan keamanan akun.</p>
                            </div>
                            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-2xl shadow-inner border border-blue-100 relative z-10">
                                <i class="fas fa-cog animate-[spin_10s_linear_infinite]"></i>
                            </div>
                            <div class="absolute -right-10 -top-10 text-[200px] text-slate-100 opacity-50 pointer-events-none transform -rotate-12">
                                <i class="fas fa-sliders-h"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Card 1: Profil Admin -->
                            <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] flex flex-col items-center text-center">
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
                                            <input type="email" value="lpm@politeknikjambi.ac.id" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all" readonly>
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
                    `,t.style.opacity=1;return}fetch(`/admin/page-data?title=${encodeURIComponent(e)}`).then(a=>a.json()).then(a=>{if(!a.success){i(a.message,"warning"),T();return}if(y=a.fields,H=a.defaults||{},a.type==="single")t.innerHTML=`
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
                                        <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none mb-4">${e}</h2>
                                        <p class="text-slate-500 font-medium">Perbarui deskripsi ${e} secara langsung. Perubahan akan langsung disimpan secara permanen di database dan tayang di front-end.</p>
                                    </div>
                                </div>

                                <!-- Form Area -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10">
                                    <textarea id="single-editor-textarea" rows="12" class="w-full p-6 border border-slate-200 rounded-3xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-medium text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all resize-y shadow-inner leading-relaxed" placeholder="Ketik konten ${e} di sini...">${a.data.isi_konten||""}</textarea>
                                    
                                    <div class="mt-10 flex justify-end gap-4 border-t border-slate-100 pt-8">
                                        <button onclick="showHome()" class="px-8 py-4 text-slate-500 bg-white border border-slate-200 font-bold text-xs hover:bg-slate-50 rounded-2xl transition-colors tracking-widest uppercase shadow-sm">Batal</button>
                                        <button onclick="saveSingleContent()" class="px-8 py-4 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-[0_10px_20px_rgba(37,99,235,0.3)] hover:bg-blue-700 transition-all hover:-translate-y-1 tracking-widest uppercase flex items-center gap-3">
                                            <i class="fas fa-save text-sm"></i>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            `;else{V=a.data;let s='<th class="px-10 py-6 border-b border-slate-100 w-24 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">UID</th>';a.fields.forEach(o=>{const n=o.split("_").map(r=>r.charAt(0).toUpperCase()+r.slice(1)).join(" ");s+=`<th class="px-10 py-6 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">${n}</th>`}),s+='<th class="px-10 py-6 border-b border-slate-100 text-right w-48 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Manajemen</th>';let l="";a.data.length===0?l=`<tr><td colspan="${a.fields.length+2}" class="px-10 py-12 text-center font-bold text-slate-400">Belum ada data entri di database untuk modul ini.</td></tr>`:a.data.forEach((o,n)=>{let d=`<td class="px-10 py-8 font-black text-slate-400 text-center font-display">${String(n+1).padStart(3,"0")}</td>`;a.fields.forEach(c=>{let p=o[c]||"";if(typeof p=="string"&&p.includes("<")){const u=document.createElement("div");u.innerHTML=p,p=u.textContent||u.innerText||""}p.length>80&&(p=p.slice(0,80)+"..."),d+=`<td class="px-10 py-8 leading-relaxed font-semibold text-slate-700 text-sm">${p}</td>`}),d+=`
                                    <td class="px-10 py-8">
                                        <div class="flex justify-end space-x-2">
                                            <button onclick="openModalEdit(${o.id})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Edit"><i class="fas fa-pen text-sm"></i></button>
                                            ${b.includes("Kuesioner")||b.includes("Kuisioner")?`<button onclick="openManageQuestions(${o.id}, '${o.judul}')" class="text-slate-400 hover:text-emerald-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Kelola Pertanyaan"><i class="fas fa-question text-sm"></i></button>`:""}
                                            <button onclick="confirmDelete(${o.id}, this)" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Hapus"><i class="fas fa-trash text-sm"></i></button>
                                        </div>
                                    </td>
                                    `,l+=`<tr class="hover:bg-slate-50/50 transition-colors group">${d}</tr>`}),t.innerHTML=`
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
                                        <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">${e}</h2>
                                    </div>
                                    <div class="flex gap-4 items-center relative z-10">
                                        ${e==="Kuesioner Dosen & Karyawan"?`
                                            <button onclick="openImportKuesioner()" class="bg-emerald-600 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(16,185,129,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(16,185,129,0.3)] hover:bg-emerald-700">
                                                <i class="fas fa-file-excel"></i>
                                                <span class="tracking-widest uppercase text-[10px]">Impor Excel</span>
                                            </button>
                                        `:""}
                                        <button onclick="openTambah()" class="bg-slate-900 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(15,23,42,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.3)] hover:bg-slate-800">
                                            <i class="fas fa-plus"></i>
                                            <span class="tracking-widest uppercase text-[10px]">Tambah Entri</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Table Area -->
                                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)]">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead class="bg-slate-50/50">
                                                <tr>
                                                    ${s}
                                                </tr>
                                            </thead>
                                            <tbody id="table-body" class="divide-y divide-slate-50">
                                                ${l}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            `}t.style.opacity=1,a.type==="single"&&setTimeout(()=>A("#single-editor-textarea"),200)}).catch(a=>{console.error(a),i("Gagal memuat data dari server.","warning"),T()})},300)}function $e(){const e=document.getElementById("single-editor-textarea"),t=e.dataset.editorId,a=g[t]?g[t].getData():e.value;fetch("/admin/save-page-data",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":window.dashboardConfig.csrfToken},body:JSON.stringify({title:b,isi_konten:a})}).then(s=>s.json()).then(s=>{s.success?(i(s.message,"success"),L(b)):i(s.message,"warning")}).catch(s=>{i("Gagal memproses pembaruan data.","warning")})}function re(){b="Media Sosial";const e=document.getElementById("dynamic-content");e.style.opacity=0,fetch(`/admin/page-data?title=${encodeURIComponent(b)}`).then(t=>t.json()).then(t=>{if(!t.success){i(t.message,"warning"),T();return}y=t.fields,H=t.defaults||{},V=t.data;let a='<th class="px-10 py-6 border-b border-slate-100 w-24 text-center text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">UID</th>';t.fields.forEach(l=>{const o=l.split("_").map(n=>n.charAt(0).toUpperCase()+n.slice(1)).join(" ");a+=`<th class="px-10 py-6 border-b border-slate-100 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">${o}</th>`}),a+='<th class="px-10 py-6 border-b border-slate-100 text-right w-48 text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Manajemen</th>';let s="";t.data.length===0?s=`<tr><td colspan="${t.fields.length+2}" class="px-10 py-12 text-center font-bold text-slate-400">Belum ada data medsos. Tambah entri untuk melihatnya di sini.</td></tr>`:t.data.forEach((l,o)=>{let r=`<td class="px-10 py-8 font-black text-slate-400 text-center font-display">${String(o+1).padStart(3,"0")}</td>`;t.fields.forEach(d=>{let c=l[d]||"";if(typeof c=="string"&&c.includes("<")){const p=document.createElement("div");p.innerHTML=c,c=p.textContent||p.innerText||""}c.length>80&&(c=c.slice(0,80)+"..."),r+=`<td class="px-10 py-8 leading-relaxed font-semibold text-slate-700 text-sm">${c}</td>`}),r+=`
                                <td class="px-10 py-8">
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="openModalEdit(${l.id})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Edit"><i class="fas fa-pen text-sm"></i></button>
                                        <button onclick="confirmDelete(${l.id}, this)" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 transition-all w-12 h-12 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center hover:-translate-y-1" title="Hapus"><i class="fas fa-trash text-sm"></i></button>
                                    </div>
                                </td>
                            `,s+=`<tr class="hover:bg-slate-50/50 transition-colors group">${r}</tr>`}),e.innerHTML=`
                    <div class="max-w-7xl mx-auto pb-12">
                        <div class="bg-white/80 backdrop-blur-xl p-10 lg:p-12 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
                            <div class="absolute -right-20 -top-20 text-[200px] text-slate-100 opacity-50 pointer-events-none transform -rotate-12">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Konten</p>
                                </div>
                                <h2 class="text-4xl lg:text-5xl font-black text-slate-800 tracking-tighter font-display leading-none">Media Sosial</h2>
                                <p class="text-slate-500 font-medium mt-3">Kelola link media sosial dan kontak resmi LP3M. Perubahan akan langsung tersimpan di database dan tercermin di halaman publik.</p>
                            </div>
                            <div class="relative z-10">
                                <button onclick="openTambah()" class="bg-slate-900 text-white px-8 py-4 rounded-2xl flex items-center gap-3 text-xs font-bold transition-all shadow-[0_15px_30px_rgba(15,23,42,0.2)] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(15,23,42,0.3)] hover:bg-slate-800">
                                    <i class="fas fa-plus"></i>
                                    <span class="tracking-widest uppercase text-[10px]">Tambah Entri</span>
                                </button>
                            </div>
                        </div>
                        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] overflow-hidden border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)]">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-slate-50/50">
                                        <tr>${a}</tr>
                                    </thead>
                                    <tbody id="table-body" class="divide-y divide-slate-50">${s}</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    `,e.style.opacity=1}).catch(t=>{console.error(t),i("Gagal memuat data Media Sosial.","warning"),T()})}function O(){const e=document.getElementById("modalOverlay");e.classList.remove("hidden"),setTimeout(()=>{e.classList.remove("opacity-0","pointer-events-none")},10)}function de(){const e=document.getElementById("modalOverlay");e.classList.add("opacity-0","pointer-events-none"),setTimeout(()=>{e.classList.add("hidden"),document.getElementById("modalEdit").classList.add("hidden"),document.getElementById("modalTambah").classList.add("hidden")},300)}function S(){document.getElementById("modalEdit").classList.add("scale-95"),document.getElementById("modalTambah").classList.add("scale-95"),ie(),de()}function De(e){oe=e;const t=V.find(s=>s.id==e);if(!t)return;q("edit-fields-container",y,t),O();const a=document.getElementById("modalEdit");a.classList.remove("hidden"),setTimeout(()=>a.classList.remove("scale-95"),10),setTimeout(()=>A('textarea[id^="field-"]'),300)}function Ce(){q("add-fields-container",y,H),O();const e=document.getElementById("modalTambah");e.classList.remove("hidden"),setTimeout(()=>e.classList.remove("scale-95"),10),setTimeout(()=>A('textarea[id^="field-"]'),300)}const X=e=>e.toLowerCase().includes("gambar")||e.toLowerCase().includes("foto")||e.toLowerCase().includes("file"),Ke=e=>e.toLowerCase()==="status";function q(e,t,a={}){const s=document.getElementById(e);s.innerHTML="",t.forEach(l=>{const o=l.split("_").map(p=>p.charAt(0).toUpperCase()+p.slice(1)).join(" "),n=a[l]||"",r=["isi_konten","deskripsi","konten"].includes(l),d=l.toLowerCase().includes("tanggal")||l.toLowerCase().includes("date");let c="";if(Ke(l))c=`<select id="field-${e}-${l}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">
                        <option value="aktif" ${n==="aktif"?"selected":""}>Aktif</option>
                        <option value="non-aktif" ${n==="non-aktif"?"selected":""}>Non-Aktif</option>
                    </select>`;else if(X(l)){const p=n&&(n.startsWith("http://")||n.startsWith("https://"));let u="";if(n&&!p){let x=n;!x.startsWith("http://")&&!x.startsWith("https://")&&(x.startsWith("storage/")?x="/"+x:x.startsWith("/")||(x="/"+x)),u=`<div class="mb-3"><img src="${x}" class="h-24 w-auto rounded-xl border border-slate-200 shadow-sm object-cover" onerror="this.style.display='none'"><p class="text-[10px] text-slate-400 mt-1 font-semibold">File/Gambar saat ini: ${n}</p></div>`}const P=l.toLowerCase().includes("file")||l.toLowerCase().includes("dokumen");let h="",B="image/*",le="Format: JPG, PNG, WEBP. Max: 2MB";P&&(B=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,image/*",le="Format: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR, Gambar. Max: 10MB",h=`
                            <div class="mt-2">
                                <label class="block text-[9px] font-black text-slate-400 mb-1 uppercase tracking-[0.2em]">Atau Hubungkan ke URL Website (misal: https://example.com)</label>
                                <input type="text" id="field-${e}-${l}-url" value="${p?n:""}" placeholder="https://example.com" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">
                            </div>
                        `),c=`
                        ${u}
                        <input type="file" id="field-${e}-${l}" accept="${B}" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:tracking-widest file:shadow-lg transition-all cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">${le}</p>
                        ${h}
                    `}else r?c=`<textarea id="field-${e}-${l}" rows="5" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner leading-relaxed">${n}</textarea>`:d?(n&&n.includes("-"),c=`<input type="date" id="field-${e}-${l}" value="${n}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">`):c=`<input type="text" id="field-${e}-${l}" value="${n}" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 hover:bg-white focus:bg-white transition-all shadow-inner">`;s.innerHTML+=`
                    <div class="mb-4">
                        <label class="block text-[11px] font-black text-slate-400 mb-2 uppercase tracking-[0.2em]">${o}</label>
                        ${c}
                    </div>
                `})}function Pe(){if(document.getElementById("renstra_id")){J(!0);return}const e=new FormData;e.append("title",b),e.append("id",oe),y.forEach(t=>{const a=`field-edit-fields-container-${t}`,s=document.getElementById(a);if(X(t)){const l=document.getElementById(`${a}-url`);s.files&&s.files[0]?e.append(t,s.files[0]):l&&l.value.trim()!==""?e.append(t,l.value.trim()):t==="link_file"&&s&&s.value&&e.append(t,s.value)}else{const l=s.dataset.editorId,o=l&&g[l]?g[l].getData():s.value;e.append(t,o)}}),fetch("/admin/save-page-data",{method:"POST",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken},body:e}).then(t=>t.json()).then(t=>{t.success?(i(t.message,"success"),S(),L(b)):i(t.message,"warning")}).catch(t=>{i("Gagal memperbarui data.","warning")})}function Fe(){if(document.getElementById("renstra_id")){J(!1);return}const e=new FormData;e.append("title",b);let t=!1;if(y.forEach(a=>{const s=`field-add-fields-container-${a}`,l=document.getElementById(s);if(X(a)){const o=document.getElementById(`${s}-url`);l.files&&l.files[0]?e.append(a,l.files[0]):o&&o.value.trim()!==""?e.append(a,o.value.trim()):a==="link_file"&&l&&l.value&&e.append(a,l.value)}else{const o=l.dataset.editorId,n=o&&g[o]?g[o].getData():l.value;(n.trim()===""||n.trim()==="<p></p>")&&(H[a]||(t=!0)),e.append(a,n)}}),t){alert("Validasi Gagal: Semua kolom isian harus diisi.");return}fetch("/admin/add-row",{method:"POST",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken},body:e}).then(a=>a.json()).then(a=>{a.success?(i(a.message,"success"),S(),L(b)):i(a.message,"warning")}).catch(a=>{i("Gagal menambahkan data baru.","warning")})}function He(){O();const e=document.getElementById("modalImportKuesioner");e.classList.remove("hidden"),setTimeout(()=>e.classList.remove("scale-95"),10)}function Ae(){const e=document.getElementById("ik_tahun").value,t=document.getElementById("ik_file").files[0],a=document.getElementById("ik_submit_btn");if(!e||!t){i("Tahun dan File wajib diisi.","warning");return}const s=new FormData;s.append("tahun_akademik",e),s.append("file",t),s.append("_token",window.dashboardConfig.csrfToken),a.disabled=!0,a.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Mengimpor...',fetch("/admin/kuesioner-dosen/import",{method:"POST",body:s}).then(l=>l.json()).then(l=>{a.disabled=!1,a.innerHTML="Mulai Impor",l.success?(i(l.message,"success"),S(),L(b)):i(l.message||"Gagal mengimpor data.","warning")}).catch(l=>{a.disabled=!1,a.innerHTML="Mulai Impor",console.error(l),i("Terjadi kesalahan saat mengimpor.","warning")})}function Oe(e,t){confirm("Tindakan destruktif: Anda yakin ingin menghapus record ini dari basis data secara permanen?")&&fetch("/admin/delete-row",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":window.dashboardConfig.csrfToken},body:JSON.stringify({title:b,id:e})}).then(a=>a.json()).then(a=>{if(a.success){i(a.message,"success");const s=t.closest("tr");s.style.opacity=0,s.style.transform="translateX(20px)",s.style.transition="all 0.3s ease",setTimeout(()=>s.remove(),300)}else i(a.message,"warning")}).catch(a=>{i("Gagal menghapus data.","warning")})}function Re(){const e=document.getElementById("dynamic-content");e.innerHTML=`
            <div class="max-w-7xl mx-auto pb-12">
                <!-- Header -->
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
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
                    <div class="lg:col-span-1 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10">
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
                                        ${z(new Date().getFullYear()-5,new Date().getFullYear()+5,"Gunakan Tahun dari Excel")}
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
                        <div class="mt-8 p-6 rounded-2xl bg-amber-50 border border-amber-100">
                            <h4 class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-2"><i class="fas fa-info-circle mr-1"></i> Format Matriks (Column A-I)</h4>
                            <p class="text-[10px] text-amber-600 leading-relaxed font-semibold">
                                Kolom A: Tahun<br>
                                Kolom B-I: Pillar Strategic (I - VIII)<br>
                                Baris 1: Judul/Header Pillar
                            </p>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] overflow-hidden">
                        <div class="px-10 py-7 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-6">
                                <h3 class="text-xl font-black text-slate-800 font-display">Data Terdaftar</h3>
                                <select id="filter-tahun-renstra" onchange="fetchRenstraList()" class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest outline-none focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                                    ${z(new Date().getFullYear()-5,new Date().getFullYear()+5,"Semua Tahun")}
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
            `,w()}function w(){const e=document.getElementById("renstra-tbody");if(!e)return;const t=document.getElementById("filter-tahun-renstra")?.value||"";e.innerHTML='<tr><td colspan="4" class="px-8 py-10 text-center"><i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...</td></tr>',fetch("/admin/renstra").then(a=>a.json()).then(a=>{if(a.success&&a.data.length>0){let s=a.data;t&&(s=a.data.filter(l=>l.tahun==t)),e.innerHTML=s.map(l=>`
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-4 text-xs font-black text-slate-800 text-center tracking-tighter">${l.tahun}</td>
                                <td class="px-8 py-4">
                                    <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">${l.program||"-"}</div>
                                    <div class="text-[9px] font-medium text-slate-400 uppercase tracking-widest italic">${l.indikator}</div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <div class="w-12 h-1.5 bg-slate-100 rounded-full overflow-hidden shadow-inner flex-shrink-0">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: ${l.realisasi}%"></div>
                                        </div>
                                        <span class="text-xs font-black text-slate-700">${l.realisasi}%</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick='openRenstraModal(${JSON.stringify(l)})' class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all border border-blue-100"><i class="fas fa-edit text-[10px]"></i></button>
                                        <button onclick="deleteRenstra(${l.id})" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-all border border-rose-100"><i class="fas fa-trash text-[10px]"></i></button>
                                    </div>
                                </td>
                            </tr>
                        `).join(""),s.length===0&&t&&(e.innerHTML='<tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Data untuk tahun '+t+" tidak ditemukan.</td></tr>")}else e.innerHTML='<tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">Data Renstra masih kosong.</td></tr>'})}function Ue(){const e=document.getElementById("renstra_file"),t=document.getElementById("renstra_import_year")?.value,a=e.files[0];if(!a)return;const s=document.getElementById("renstraImportBtn"),l=s.innerHTML;s.disabled=!0,s.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Syncing Matrix...';const o=new FormData;o.append("file",a),t&&o.append("tahun_override",t),o.append("_token",window.dashboardConfig.csrfToken),fetch("/admin/renstra/import",{method:"POST",body:o,headers:{Accept:"application/json"}}).then(n=>n.json()).then(n=>{s.disabled=!1,s.innerHTML=l,n.success?(i(n.message,"success"),document.getElementById("renstra_file").value="",w()):i(n.message||"Gagal mengimpor data.","warning")}).catch(n=>{s.disabled=!1,s.innerHTML=l,console.error(n),i("Terjadi kesalahan koneksi atau server saat mengimpor.","warning")})}function Ge(e=null){const t=document.getElementById("modalOverlay"),a=e?document.getElementById("modalEdit"):document.getElementById("modalTambah"),s=e?document.getElementById("edit-fields-container"):document.getElementById("add-fields-container");document.getElementById("modalEdit").classList.add("hidden"),document.getElementById("modalTambah").classList.add("hidden"),a.classList.remove("hidden"),t.classList.remove("hidden"),t.style.opacity="1",t.style.pointerEvents="auto",setTimeout(()=>a.classList.remove("scale-95"),10);let l=`
                <input type="hidden" id="renstra_id" value="${e?e.id:""}">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Program / Kelompok</label>
                    <input type="text" id="renstra_program" value="${e&&e.program||""}" placeholder="Contoh: R 1: Kesiapan Kerja Lulusan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Indikator Kinerja</label>
                    <textarea id="renstra_indikator" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">${e?e.indikator:""}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">PIC</label>
                        <input type="text" id="renstra_pic" value="${e&&e.pic||""}" placeholder="WD 1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tahun (YYYY)</label>
                        <input type="number" id="renstra_tahun" value="${e?e.tahun:new Date().getFullYear()}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Target (%)</label>
                        <input type="number" step="0.01" id="renstra_target" value="${e?e.target:0}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Realisasi (%)</label>
                        <input type="number" step="0.01" id="renstra_realisasi" value="${e?e.realisasi:0}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            `;s.innerHTML=l}function J(e=!1){const t=document.getElementById("renstra_id").value,a={program:document.getElementById("renstra_program").value,indikator:document.getElementById("renstra_indikator").value,pic:document.getElementById("renstra_pic").value,tahun:document.getElementById("renstra_tahun").value,target:document.getElementById("renstra_target").value,realisasi:document.getElementById("renstra_realisasi").value,_token:window.dashboardConfig.csrfToken},s=e?`/admin/renstra/${t}/update`:"/admin/renstra/store";fetch(s,{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(a)}).then(l=>l.json()).then(l=>{l.success?(i(l.message,"success"),S(),w()):i(l.message||"Gagal menyimpan data.","warning")}).catch(l=>{console.error(l),i("Terjadi kesalahan sistem.","warning")})}function ze(e){confirm("Hapus data Renstra ini?")&&fetch(`/admin/renstra/delete/${e}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken}}).then(t=>t.json()).then(t=>{t.success?(i(t.message,"success"),w()):i(t.message||"Gagal menghapus data.","warning")})}function Ne(){confirm("Peringatan: Semua data Renstra akan dihapus secara permanen. Lanjutkan?")&&fetch("/admin/renstra/truncate",{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken}}).then(e=>e.json()).then(e=>{e.success&&(i(e.message,"success"),w())})}function ce(){const e=document.getElementById("dynamic-content");e.innerHTML=`
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
                                <input type="text" id="ud_deskripsi" placeholder="Opsional â€” keterangan singkat dokumen"
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
                            <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP â€” Maks. 20MB</p>
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
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-20">â†“</th>
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
            `;const t=document.getElementById("dropzone"),a=document.getElementById("ud_file");t&&a&&(t.addEventListener("dragover",s=>{s.preventDefault(),t.classList.add("border-blue-400","bg-blue-50/50")}),t.addEventListener("dragleave",()=>t.classList.remove("border-blue-400","bg-blue-50/50")),t.addEventListener("drop",s=>{s.preventDefault(),t.classList.remove("border-blue-400","bg-blue-50/50"),s.dataTransfer.files.length>0&&(a.files=s.dataTransfer.files,I(s.dataTransfer.files[0]))}),a.addEventListener("change",()=>{a.files.length>0&&I(a.files[0])})),$()}function I(e){const t=e.name.split(".").pop().toLowerCase(),s={pdf:"fa-file-pdf text-red-500",doc:"fa-file-word text-blue-500",docx:"fa-file-word text-blue-500",xls:"fa-file-excel text-green-500",xlsx:"fa-file-excel text-green-500"}[t]||"fa-file-alt text-slate-500",l=(e.size/(1024*1024)).toFixed(2)+" MB";document.getElementById("dropzone-icon").innerHTML=`<i class="fas ${s} text-3xl"></i>`,document.getElementById("dropzone-text").textContent=`âœ“ ${e.name} (${l})`,document.getElementById("dropzone-text").classList.add("text-blue-600")}function $(){fetch("/admin/dokumen-spmi").then(e=>e.json()).then(e=>{if(!e.success)return;const t=document.getElementById("dokumen-tbody"),a=document.getElementById("dok-count");if(t){if(a.textContent=e.data.length+" dokumen tersimpan di database",e.data.length===0){t.innerHTML='<tr><td colspan="7" class="px-8 py-12 text-center text-slate-400 font-medium"><i class="fas fa-folder-open text-3xl block mb-3 opacity-30"></i>Belum ada dokumen. Upload dokumen pertama Anda di atas.</td></tr>';return}t.innerHTML=e.data.map((s,l)=>`
                        <tr class="hover:bg-blue-50/20 transition-colors group">
                            <td class="px-8 py-6 text-center">
                                <span class="text-[11px] font-black text-slate-400">${String(l+1).padStart(2,"0")}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <i class="${s.icon_class||"fas fa-file-alt text-slate-400"} text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm leading-snug">${s.judul}</p>
                                        ${s.deskripsi?`<p class="text-xs text-slate-400 mt-0.5 line-clamp-1">${s.deskripsi}</p>`:""}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-black px-3 py-1.5 rounded-xl">${s.tahun}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-semibold text-slate-500">${s.kategori}</span>
                            </td>
                            <td class="px-8 py-6">
                                ${s.nama_file?`
                                <div>
                                    <span class="inline-block bg-slate-100 text-slate-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">${s.tipe_file||"file"}</span>
                                    <p class="text-[10px] text-slate-400 mt-1">${s.ukuran_file||""}</p>
                                </div>`:'<span class="text-slate-300 text-xs">â€”</span>'}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-sm font-bold text-slate-500">${s.downloads}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <button onclick="openEditDokModal(${JSON.stringify(s).replace(/"/g,"&quot;")})"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <button onclick="deleteDokumen(${s.id}, this)"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join("")}}).catch(()=>i("Gagal memuat daftar dokumen.","warning"))}function Ve(){const e=document.getElementById("ud_judul")?.value?.trim(),t=document.getElementById("ud_tahun")?.value?.trim(),a=document.getElementById("ud_file")?.files[0];if(!e){i("Judul dokumen wajib diisi!","warning");return}if(!t){i("Tahun wajib diisi!","warning");return}if(!a){i("Pilih file untuk diupload!","warning");return}const s=new FormData;s.append("judul",e),s.append("tahun",t),s.append("deskripsi",document.getElementById("ud_deskripsi")?.value||""),s.append("kategori",document.getElementById("ud_kategori")?.value||"Dokumen SPMI"),s.append("file",a),s.append("_token",window.dashboardConfig.csrfToken);const l=document.getElementById("uploadBtn");l.disabled=!0,l.innerHTML='<i class="fas fa-spinner fa-spin"></i> Mengupload...',fetch("/admin/dokumen-spmi/upload",{method:"POST",body:s,headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then(async o=>{const n=await o.json();if(!o.ok)throw new Error(n.message||"Terjadi kesalahan sistem.");return n}).then(o=>{l.disabled=!1,l.innerHTML='<i class="fas fa-upload"></i> Upload Dokumen',o.success?(i(o.message,"success"),document.getElementById("ud_judul").value="",document.getElementById("ud_tahun").value="",document.getElementById("ud_deskripsi").value="",document.getElementById("ud_file").value="",document.getElementById("dropzone-text").textContent="Klik atau seret file ke sini",document.getElementById("dropzone-text").classList.remove("text-blue-600"),document.getElementById("dropzone-icon").innerHTML='<i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>',$()):i(o.message||"Upload gagal.","warning")}).catch(o=>{l.disabled=!1,l.innerHTML='<i class="fas fa-upload"></i> Upload Dokumen',i(o.message||"Terjadi kesalahan saat upload.","warning")})}function Xe(e){document.getElementById("edit_dok_id").value=e.id,document.getElementById("edit_judul").value=e.judul,document.getElementById("edit_tahun").value=e.tahun,document.getElementById("edit_deskripsi").value=e.deskripsi||"",document.getElementById("edit_current_file").textContent=e.nama_file?"File saat ini: "+e.nama_file+" ("+(e.ukuran_file||"")+")":"Belum ada file",document.getElementById("edit_kategori").value=e.kategori,document.getElementById("editDokumenModal").classList.remove("hidden")}function W(){document.getElementById("editDokumenModal").classList.add("hidden"),document.getElementById("edit_file").value=""}function qe(){const e=document.getElementById("edit_dok_id").value,t=new FormData;t.append("judul",document.getElementById("edit_judul").value),t.append("tahun",document.getElementById("edit_tahun").value),t.append("deskripsi",document.getElementById("edit_deskripsi").value),t.append("kategori",document.getElementById("edit_kategori").value),t.append("_token",window.dashboardConfig.csrfToken),t.append("_method","POST");const a=document.getElementById("edit_file");a.files.length>0&&t.append("file",a.files[0]),fetch(`/admin/dokumen-spmi/${e}/update`,{method:"POST",body:t}).then(s=>s.json()).then(s=>{s.success?(i(s.message,"success"),W(),$()):i(s.message||"Gagal menyimpan.","warning")}).catch(()=>i("Terjadi kesalahan.","warning"))}function Je(e,t){confirm("Hapus dokumen ini beserta file-nya secara permanen?")&&fetch(`/admin/dokumen-spmi/${e}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"}}).then(a=>a.json()).then(a=>{if(a.success){i(a.message,"success");const s=t.closest("tr");s.style.opacity=0,s.style.transform="translateX(20px)",s.style.transition="all 0.3s",setTimeout(()=>{s.remove(),$()},300)}else i(a.message||"Gagal menghapus.","warning")}).catch(()=>i("Terjadi kesalahan.","warning"))}function Y(e){const t=document.getElementById("dynamic-content");t.style.opacity=0,setTimeout(()=>{t.innerHTML=`
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas ${e.iconClass||"fa-file-alt"}"></i></div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="w-2 h-2 rounded-full ${e.bgDotClass||"bg-blue-500"} shadow-[0_0_10px_rgba(59,130,246,0.6)]"></span>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Dokumen</p>
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">${e.title}</h2>
                            <p class="text-slate-500 text-sm mt-2">${e.subtitle}</p>
                        </div>
                        <a href="${e.publicUrl}" target="_blank" class="relative z-10 inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-5 py-3 rounded-xl transition-all">
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
                                    <input type="text" id="ud_judul" placeholder="Contoh: ${e.placeholderTitle}" required
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
                                        ${e.categories.map(l=>`<option value="${l}"></option>`).join("")}
                                    </datalist>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                                    <input type="text" id="ud_deskripsi" placeholder="Opsional â€” keterangan singkat dokumen"
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
                                <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP â€” Maks. 20MB</p>
                                <input type="file" id="ud_file" name="file" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar">
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button" id="uploadBtn" onclick="submitUploadPdfDocument('${e.apiBase}')"
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
                                <button onclick="fetchPdfDocumentList('${e.apiBase}', '${e.downloadBase}')" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 flex items-center justify-center transition-all" title="Refresh">
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
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 w-20">downloads</th>
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
                                <button onclick="submitEditPdfDocument('${e.apiBase}', '${e.downloadBase}')" class="px-8 py-3 bg-blue-600 text-white font-bold text-xs rounded-2xl shadow-lg hover:bg-blue-700 transition-all hover:-translate-y-0.5 tracking-widest uppercase flex items-center gap-2">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;const a=document.getElementById("dropzone"),s=document.getElementById("ud_file");a&&s&&(a.addEventListener("dragover",l=>{l.preventDefault(),a.classList.add("border-blue-400","bg-blue-50/50")}),a.addEventListener("dragleave",()=>a.classList.remove("border-blue-400","bg-blue-50/50")),a.addEventListener("drop",l=>{l.preventDefault(),a.classList.remove("border-blue-400","bg-blue-50/50"),l.dataTransfer.files.length>0&&(s.files=l.dataTransfer.files,I(l.dataTransfer.files[0]))}),s.addEventListener("change",()=>{s.files.length>0&&I(s.files[0])})),D(e.apiBase,e.downloadBase),t.style.opacity=1},300)}function D(e,t){fetch(e).then(a=>a.json()).then(a=>{if(!a.success)return;const s=document.getElementById("dokumen-tbody"),l=document.getElementById("dok-count");if(s){if(l.textContent=a.data.length+" dokumen tersimpan di database",a.data.length===0){s.innerHTML='<tr><td colspan="7" class="px-8 py-12 text-center text-slate-400 font-medium"><i class="fas fa-folder-open text-3xl block mb-3 opacity-30"></i>Belum ada dokumen. Upload dokumen pertama Anda di atas.</td></tr>';return}s.innerHTML=a.data.map((o,n)=>`
                        <tr class="hover:bg-blue-50/20 transition-colors group">
                            <td class="px-8 py-6 text-center">
                                <span class="text-[11px] font-black text-slate-400">${String(n+1).padStart(2,"0")}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <i class="${o.icon_class||"fas fa-file-alt text-slate-400"} text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm leading-snug">${o.judul}</p>
                                        ${o.deskripsi?`<p class="text-xs text-slate-400 mt-0.5 line-clamp-1">${o.deskripsi}</p>`:""}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-black px-3 py-1.5 rounded-xl">${o.tahun}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-semibold text-slate-500">${o.kategori}</span>
                            </td>
                            <td class="px-8 py-6">
                                ${o.nama_file?`
                                <div>
                                    <span class="inline-block bg-slate-100 text-slate-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">${o.tipe_file||"file"}</span>
                                    <p class="text-[10px] text-slate-400 mt-1">${o.ukuran_file||""}</p>
                                </div>`:'<span class="text-slate-300 text-xs">â€”</span>'}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="text-sm font-bold text-slate-500">${o.downloads||0}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                     <a href="${t}/${o.id}/download" target="_blank"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Download">
                                        <i class="fas fa-download text-xs"></i>
                                    </a>
                                    <button onclick="openEditPdfDocModal(${JSON.stringify(o).replace(/"/g,"&quot;")})"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <button onclick="deletePdfDocument('${e}', '${t}', ${o.id}, this)"
                                        class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:-translate-y-0.5 flex items-center justify-center transition-all shadow-sm" title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join("")}}).catch(()=>i("Gagal memuat daftar dokumen.","warning"))}function We(e){const t=document.getElementById("ud_judul")?.value?.trim(),a=document.getElementById("ud_tahun")?.value?.trim(),s=document.getElementById("ud_file")?.files[0];if(!t){i("Judul dokumen wajib diisi!","warning");return}if(!a){i("Tahun wajib diisi!","warning");return}if(!s){i("Pilih file untuk diupload!","warning");return}const l=new FormData;l.append("judul",t),l.append("tahun",a),l.append("deskripsi",document.getElementById("ud_deskripsi")?.value||""),l.append("kategori",document.getElementById("ud_kategori")?.value||""),l.append("file",s),l.append("_token",window.dashboardConfig.csrfToken);const o=document.getElementById("uploadBtn");o.disabled=!0,o.innerHTML='<i class="fas fa-spinner fa-spin"></i> Mengupload...',fetch(`${e}/upload`,{method:"POST",body:l,headers:{Accept:"application/json","X-Requested-With":"XMLHttpRequest"}}).then(async n=>{const r=await n.json();if(!n.ok)throw new Error(r.message||"Terjadi kesalahan sistem.");return r}).then(n=>{o.disabled=!1,o.innerHTML='<i class="fas fa-upload"></i> Upload Dokumen',n.success?(i(n.message,"success"),document.getElementById("ud_judul").value="",document.getElementById("ud_tahun").value="",document.getElementById("ud_deskripsi").value="",document.getElementById("ud_file").value="",document.getElementById("dropzone-text").textContent="Klik atau seret file ke sini",document.getElementById("dropzone-text").classList.remove("text-blue-600"),document.getElementById("dropzone-icon").innerHTML='<i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>',D(e,e.replace("/admin",""))):i(n.message||"Upload gagal.","warning")}).catch(n=>{o.disabled=!1,o.innerHTML='<i class="fas fa-upload"></i> Upload Dokumen',i(n.message||"Terjadi kesalahan saat upload.","warning")})}function Ye(e){document.getElementById("edit_dok_id").value=e.id,document.getElementById("edit_judul").value=e.judul,document.getElementById("edit_tahun").value=e.tahun,document.getElementById("edit_deskripsi").value=e.deskripsi||"",document.getElementById("edit_current_file").textContent=e.nama_file?"File saat ini: "+e.nama_file+" ("+(e.ukuran_file||"")+")":"Belum ada file",document.getElementById("edit_kategori").value=e.kategori,document.getElementById("editDokumenModal").classList.remove("hidden")}function Qe(e,t){const a=document.getElementById("edit_dok_id").value,s=new FormData;s.append("judul",document.getElementById("edit_judul").value),s.append("tahun",document.getElementById("edit_tahun").value),s.append("deskripsi",document.getElementById("edit_deskripsi").value),s.append("kategori",document.getElementById("edit_kategori").value),s.append("_token",window.dashboardConfig.csrfToken),s.append("_method","POST");const l=document.getElementById("edit_file");l.files.length>0&&s.append("file",l.files[0]),fetch(`${e}/${a}/update`,{method:"POST",body:s}).then(o=>o.json()).then(o=>{o.success?(i(o.message,"success"),W(),D(e,t)):i(o.message||"Gagal menyimpan.","warning")}).catch(()=>i("Terjadi kesalahan.","warning"))}function Ze(e,t,a,s){confirm("Hapus dokumen ini beserta file-nya secara permanen?")&&fetch(`${e}/${a}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"}}).then(l=>l.json()).then(l=>{if(l.success){i(l.message,"success");const o=s.closest("tr");o.style.opacity=0,o.style.transform="translateX(20px)",o.style.transition="all 0.3s",setTimeout(()=>{o.remove(),D(e,t)},300)}else i(l.message||"Gagal menghapus.","warning")}).catch(()=>i("Terjadi kesalahan.","warning"))}function ue(){Y({title:"Laporan AMI",subtitle:"Upload, kelola, dan hapus laporan Audit Mutu Internal (AMI). Perubahan langsung tampil di halaman publik.",placeholderTitle:"Laporan AMI Tahun 2026",publicUrl:"/capaian/laporan-ami",apiBase:"/admin/laporan-ami",downloadBase:"/laporan-ami",iconClass:"fa-file-invoice",bgDotClass:"bg-emerald-500",categories:["Laporan AMI","Audit Mutu Internal","Formulir AMI","Dokumen Pendukung"]})}function pe(){Y({title:"RTM",subtitle:"Upload, kelola, dan hapus dokumen Rapat Tinjauan Manajemen (RTM). Perubahan langsung tampil di halaman publik.",placeholderTitle:"RTM Tahun 2026",publicUrl:"/capaian/rtm",apiBase:"/admin/rtm",downloadBase:"/rtm",iconClass:"fa-file-signature",bgDotClass:"bg-indigo-500",categories:["RTM","Rapat Tinjauan Manajemen","Dokumen RTM","Dokumen Pendukung"]})}function et(){b="Slider Homepage";const e=document.getElementById("dynamic-content");e.style.opacity=0,setTimeout(()=>{e.innerHTML=`
                <div class="max-w-7xl mx-auto pb-12">
                    <!-- Header -->
                    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
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
                    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="sliderModalInner">
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
                `,e.style.opacity=1,R()},300)}function R(){const e=document.getElementById("slider-grid");e&&fetch("/admin/slider").then(t=>t.json()).then(t=>{if(t.success){if(t.data.length===0){e.innerHTML=`<div class="col-span-full py-20 text-center bg-white/40 rounded-[2rem] border border-dashed border-slate-200">
                                <i class="fas fa-images text-4xl text-slate-200 mb-4 block"></i>
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-[11px]">Belum ada slide. Klik "Tambah Slide" di atas.</p>
                            </div>`;return}e.innerHTML=t.data.map(a=>`
                            <div class="group relative bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_10px_30px_rgba(0,0,0,0.02)] overflow-hidden hover:shadow-[0_20px_50px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-500">
                                <div class="aspect-[16/9] w-full overflow-hidden relative">
                                    <img src="/storage/${a.gambar}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='/images/gedung-poljam.png'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
                                    <div class="absolute top-4 right-4 flex gap-2">
                                        <button onclick='openSliderModal(${JSON.stringify(a).replace(/'/g,"&apos;")})' class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-md text-blue-600 shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><i class="fas fa-pen text-[10px]"></i></button>
                                        <button onclick="deleteSlider(${a.id})" class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-md text-rose-600 shadow-lg flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all"><i class="fas fa-trash text-[10px]"></i></button>
                                    </div>
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg shadow-lg">Urutan: ${a.urutan}</span>
                                    </div>
                                </div>
                                <div class="p-8">
                                    <h4 class="text-slate-800 font-black text-lg line-clamp-1 mb-2 font-display tracking-tight">${a.judul||"Tanpa Judul"}</h4>
                                    <p class="text-slate-500 text-xs line-clamp-2 font-medium leading-relaxed mb-4">${a.sub_judul||"-"}</p>
                                    <div class="flex items-center gap-2 text-[9px] font-black text-blue-500 uppercase tracking-widest">
                                        <i class="fas fa-link"></i>
                                        <span class="truncate">${a.link_url||"#"}</span>
                                    </div>
                                </div>
                            </div>
                        `).join("")}}).catch(()=>i("Gagal memuat slider.","warning"))}function tt(e=null){const t=document.getElementById("sliderModal"),a=document.getElementById("sliderModalInner"),s=document.getElementById("sliderForm"),l=document.getElementById("sliderModalTitle");s.reset(),document.getElementById("slider_id").value="",document.getElementById("sl_preview_container").classList.add("hidden"),document.getElementById("sl_placeholder").classList.remove("hidden"),e?(l.textContent="Edit Slide",document.getElementById("slider_id").value=e.id,document.getElementById("sl_judul").value=e.judul||"",document.getElementById("sl_sub_judul").value=e.sub_judul||"",document.getElementById("sl_urutan").value=e.urutan||0,document.getElementById("sl_link").value=e.link_url||"",e.gambar&&(document.getElementById("sl_preview_img").src="/storage/"+e.gambar,document.getElementById("sl_preview_container").classList.remove("hidden"),document.getElementById("sl_placeholder").classList.add("hidden"))):l.textContent="Tambah Slide",t.classList.remove("hidden"),t.classList.add("flex"),setTimeout(()=>{a.classList.remove("scale-95","opacity-0")},50)}function be(){const e=document.getElementById("sliderModal");document.getElementById("sliderModalInner").classList.add("scale-95","opacity-0"),setTimeout(()=>{e.classList.add("hidden"),e.classList.remove("flex")},300)}function at(e){if(e.files&&e.files[0]){const t=new FileReader;t.onload=function(a){document.getElementById("sl_preview_img").src=a.target.result,document.getElementById("sl_preview_container").classList.remove("hidden"),document.getElementById("sl_placeholder").classList.add("hidden")},t.readAsDataURL(e.files[0])}}function st(){const e=document.getElementById("slider_id").value,t=document.getElementById("sliderSubmitBtn"),a=t.innerHTML,s=new FormData;s.append("judul",document.getElementById("sl_judul").value),s.append("sub_judul",document.getElementById("sl_sub_judul").value),s.append("urutan",document.getElementById("sl_urutan").value),s.append("link_url",document.getElementById("sl_link").value),s.append("_token",window.dashboardConfig.csrfToken);const l=document.getElementById("sl_gambar");if(l.files.length>0)s.append("gambar",l.files[0]);else if(!e){i("Gambar slide wajib diupload!","warning");return}t.disabled=!0,t.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';const o=e?`/admin/slider/${e}/update`:"/admin/slider";fetch(o,{method:"POST",body:s}).then(n=>n.json()).then(n=>{t.disabled=!1,t.innerHTML=a,n.success?(i(n.message,"success"),be(),R()):i(n.message||"Gagal menyimpan.","warning")}).catch(()=>{t.disabled=!1,t.innerHTML=a,i("Terjadi kesalahan server.","warning")})}function lt(e){confirm("Hapus slide ini?")&&fetch(`/admin/slider/${e}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"}}).then(t=>t.json()).then(t=>{t.success?(i(t.message,"success"),R()):i(t.message||"Gagal menghapus.","warning")}).catch(()=>i("Terjadi kesalahan koneksi.","warning"))}let f=[],k=null,j=null,m=[],v=null,M=null;function me(){b="Kuesioner Dosen & Karyawan";const e=document.getElementById("dynamic-content");e.style.opacity=0,setTimeout(()=>{e.innerHTML=`
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
                                <button type="button" onclick="submitImportKuesionerDosen()" id="importKuesionerBtn" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all hover:shadow-2xl hover:-translate-y-0.5">
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
                `,e.style.opacity=1,xe()},300)}async function xe(){try{const t=await(await fetch("/admin/kuesioner-dosen/data")).json();if(!t.success)return;f=t.data;const a=t.years,s=document.getElementById("kdFilterTahun");s&&(s.innerHTML='<option value="">Semua Tahun</option>',a.forEach(l=>{const o=document.createElement("option");o.value=l,o.textContent=l,s.appendChild(o)})),Q(f),Z(f)}catch(e){console.error(e),i("Gagal memuat data kuesioner.","warning")}}async function _(e=""){try{const t=e?`/admin/kuesioner-dosen/data?tahun_akademik=${encodeURIComponent(e)}`:"/admin/kuesioner-dosen/data",s=await(await fetch(t)).json();if(!s.success)return;f=s.data,Q(f),Z(f)}catch{i("Gagal memuat data.","warning")}}function Q(e){const t=document.getElementById("kdTableBody"),a=document.getElementById("kdTotalCount");if(a&&(a.textContent=e.length+" Data"),e.length===0){t.innerHTML='<tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Belum ada data. Silakan import Excel atau tambah data manual.</td></tr>';return}t.innerHTML=e.map((s,l)=>`
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="px-6 py-5 text-center font-black text-slate-400 text-xs">${l+1}</td>
                    <td class="px-6 py-5 text-xs font-bold text-slate-600">
                        <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg border border-indigo-100">
                            <i class="fas fa-calendar-alt text-[9px]"></i> ${s.tahun_akademik}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-sm font-bold text-slate-800">${s.program}</td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-black px-2.5 py-1 rounded-lg border border-emerald-100">${s.sangat_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-blue-50 text-blue-700 text-xs font-black px-2.5 py-1 rounded-lg border border-blue-100">${s.setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-yellow-50 text-yellow-700 text-xs font-black px-2.5 py-1 rounded-lg border border-yellow-100">${s.cukup_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-orange-50 text-orange-700 text-xs font-black px-2.5 py-1 rounded-lg border border-orange-100">${s.tidak_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-rose-50 text-rose-700 text-xs font-black px-2.5 py-1 rounded-lg border border-rose-100">${s.sangat_tidak_setuju}%</span></td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <button onclick="openKuesionerEditModal(${s.id})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Edit"><i class="fas fa-pen text-xs"></i></button>
                            <button onclick="deleteKuesionerRow(${s.id})" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    </td>
                </tr>
            `).join("")}function Z(e){const t=document.getElementById("chartTitle");if(e.length===0){k&&k.destroy(),k=null,t&&(t.textContent="Belum Ada Data");return}const a=e[0].tahun_akademik;t&&(t.textContent=`Kepuasan Dosen & Karyawan â€” T.A ${a}`);const s=e.map(n=>{let r=n.program;return r.length>18?r.substring(0,18)+"â€¦":r}),l=[{label:"Sangat Setuju",data:e.map(n=>n.sangat_setuju),backgroundColor:"rgba(34, 197, 94, 0.85)",borderRadius:6,barPercentage:.75,categoryPercentage:.8},{label:"Setuju",data:e.map(n=>n.setuju),backgroundColor:"rgba(59, 130, 246, 0.85)",borderRadius:6,barPercentage:.75,categoryPercentage:.8},{label:"Cukup Setuju",data:e.map(n=>n.cukup_setuju),backgroundColor:"rgba(234, 179, 8, 0.85)",borderRadius:6,barPercentage:.75,categoryPercentage:.8},{label:"Tidak Setuju",data:e.map(n=>n.tidak_setuju),backgroundColor:"rgba(249, 115, 22, 0.85)",borderRadius:6,barPercentage:.75,categoryPercentage:.8},{label:"Sangat Tidak Setuju",data:e.map(n=>n.sangat_tidak_setuju),backgroundColor:"rgba(239, 68, 68, 0.85)",borderRadius:6,barPercentage:.75,categoryPercentage:.8}],o=document.getElementById("kuesionerLiveChart");o&&(k&&k.destroy(),k=new Chart(o.getContext("2d"),{type:"bar",data:{labels:s,datasets:l},options:{responsive:!0,maintainAspectRatio:!1,plugins:{legend:{display:!1},tooltip:{mode:"index",intersect:!1,backgroundColor:"rgba(15,23,42,0.9)",titleFont:{family:"Inter",size:12,weight:"bold"},bodyFont:{family:"Inter",size:11},padding:14,cornerRadius:12,displayColors:!0,boxPadding:4,callbacks:{title:n=>{const r=n[0].dataIndex;return e[r]?e[r].program:n[0].label},label:n=>" "+n.dataset.label+": "+n.parsed.y+"%"}}},scales:{y:{beginAtZero:!0,max:100,grid:{color:"rgba(0,0,0,0.03)",drawBorder:!1},ticks:{font:{family:"Inter",size:10,weight:"bold"},color:"#94a3b8",callback:n=>n+"%"}},x:{grid:{display:!1,drawBorder:!1},ticks:{font:{family:"Inter",size:9,weight:"bold"},color:"#64748b",maxRotation:45}}},animation:{duration:1200,easing:"easeOutQuart"}}}))}function nt(){j=null,document.getElementById("kdModalTitle").textContent="Tambah Data Baru",document.getElementById("kd_edit_id").value="",document.getElementById("kd_tahun").value="",document.getElementById("kd_program").value="",document.getElementById("kd_ss").value="",document.getElementById("kd_s").value="",document.getElementById("kd_cs").value="",document.getElementById("kd_ts").value="",document.getElementById("kd_sts").value="",document.getElementById("kdModal").classList.remove("hidden")}function ot(e){const t=f.find(a=>a.id===e);t&&(j=e,document.getElementById("kdModalTitle").textContent="Edit Data",document.getElementById("kd_edit_id").value=e,document.getElementById("kd_tahun").value=t.tahun_akademik,document.getElementById("kd_program").value=t.program,document.getElementById("kd_ss").value=t.sangat_setuju,document.getElementById("kd_s").value=t.setuju,document.getElementById("kd_cs").value=t.cukup_setuju,document.getElementById("kd_ts").value=t.tidak_setuju,document.getElementById("kd_sts").value=t.sangat_tidak_setuju,document.getElementById("kdModal").classList.remove("hidden"))}function fe(){document.getElementById("kdModal").classList.add("hidden"),j=null}async function it(){const e={tahun_akademik:document.getElementById("kd_tahun").value,program:document.getElementById("kd_program").value,sangat_setuju:parseFloat(document.getElementById("kd_ss").value)||0,setuju:parseFloat(document.getElementById("kd_s").value)||0,cukup_setuju:parseFloat(document.getElementById("kd_cs").value)||0,tidak_setuju:parseFloat(document.getElementById("kd_ts").value)||0,sangat_tidak_setuju:parseFloat(document.getElementById("kd_sts").value)||0};if(!e.tahun_akademik||!e.program)return i("Tahun akademik dan program wajib diisi.","warning");const a=!!j?`/admin/kuesioner-dosen/${j}/update`:"/admin/kuesioner-dosen/store";try{const l=await(await fetch(a,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"},body:JSON.stringify(e)})).json();if(l.success){i(l.message,"success"),fe();const o=document.getElementById("kdFilterTahun").value;_(o)}else i(l.message||"Gagal menyimpan.","warning")}catch{i("Terjadi kesalahan.","warning")}}async function rt(e){if(confirm("Yakin ingin menghapus data ini?"))try{const a=await(await fetch(`/admin/kuesioner-dosen/${e}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"}})).json();if(a.success){i(a.message,"success");const s=document.getElementById("kdFilterTahun").value;_(s)}}catch{i("Gagal menghapus data.","warning")}}function ge(){const e=document.getElementById("importKuesionerContainer");e&&(e.classList.contains("hidden")?(e.classList.remove("hidden"),setTimeout(()=>e.classList.remove("opacity-0","translate-y-4"),10)):(e.classList.add("opacity-0","translate-y-4"),setTimeout(()=>e.classList.add("hidden"),300)))}async function dt(){const e=document.getElementById("kuesioner_tahun").value,t=document.getElementById("kuesioner_file").files[0];if(!e||!t)return i("Tahun akademik dan file excel wajib diisi","warning");const a=document.getElementById("importKuesionerBtn"),s=a.innerHTML;a.disabled=!0,a.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Sedang Memproses & Memverifikasi...';const l=new FormData;l.append("tahun_akademik",e),l.append("file",t),l.append("_token",window.dashboardConfig.csrfToken);try{const n=await(await fetch("/admin/kuesioner-dosen/import",{method:"POST",body:l,headers:{Accept:"application/json"}})).json();if(a.disabled=!1,a.innerHTML=s,n.success){i(n.message,"success"),ge(),document.getElementById("importKuesionerForm").reset();const r=document.getElementById("kdFilterTahun");r&&(r.innerHTML='<option value="">Semua Tahun</option>'),_("")}else i(n.message||"Gagal mengimpor.","warning")}catch{a.disabled=!1,a.innerHTML=s,i("Terjadi kesalahan pada sistem.","warning")}}async function ct(){const e=typeof f<"u"?f:[],t=[...new Set(e.map(d=>String(d.tahun_akademik||"").trim().split(/\s+/)[0]).filter(Boolean))].sort();let a='<option value="">Semua Tahun Akademik</option>';t.forEach(d=>{const c=document.getElementById("kdFilterTahun")?.value===d?"selected":"";a+=`<option value="${d}" ${c}>${d}</option>`});const{value:s}=await Swal.fire({title:"Kosongkan Data Dosen & Karyawan",html:`
                    <div class="mb-4">
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Tahun Akademik:</label>
                        <select id="swal-kd-tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            ${a}
                        </select>
                    </div>
                    <div>
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Semester:</label>
                        <select id="swal-kd-semester" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            <option value="">Semua Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                `,focusConfirm:!1,showCancelButton:!0,confirmButtonText:"KOSONGKAN",cancelButtonText:"Batal",confirmButtonColor:"#ef4444",customClass:{popup:"rounded-[2.5rem] p-10",confirmButton:"rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4 mr-2",cancelButton:"rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4"},preConfirm:()=>({tahun:document.getElementById("swal-kd-tahun").value,semester:document.getElementById("swal-kd-semester").value})});if(!s)return;const{tahun:l,semester:o}=s,n=l?`tahun akademik "${l}"`:"SEMUA tahun akademik",r=o?` semester ${o}`:"";if(confirm(`Apakah Anda yakin ingin menghapus data kuesioner Dosen & Karyawan untuk ${n}${r}?`))try{const d=new URLSearchParams({kategori:"Dosen & Karyawan"});l&&d.append("tahun_akademik",l),o&&d.append("semester",o);const p=await(await fetch(`/admin/kuesioner-dosen/truncate?${d.toString()}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"}})).json();if(p.success){i(p.message,"success");const u=document.getElementById("kdFilterTahun");u&&(u.value=""),_("")}else i(p.message||"Gagal menghapus data.","warning")}catch(d){console.error(d),i("Gagal mengosongkan data (Terjadi kesalahan sistem).","warning")}}function he(){b="Kuesioner Mahasiswa";const e=document.getElementById("dynamic-content");e.style.opacity=0,setTimeout(()=>{e.innerHTML=`
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
                                    <input type="text" id="km_prodi" placeholder="Contoh: Teknik Informatika" class="w-full p-3.5 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
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
                `,e.style.opacity=1,ke()},300)}async function ke(){try{const e=await fetch("/admin/kuesioner-dosen/data?kategori=Mahasiswa");console.log("initKuesionerMahasiswaPanel: fetch status",e.status,e.statusText);const t=await e.text();if(console.log("initKuesionerMahasiswaPanel: raw response preview",t.slice(0,2e3)),!e.ok)throw new Error("HTTP error "+e.status+" "+e.statusText);let a;try{a=JSON.parse(t)}catch(n){throw console.error("initKuesionerMahasiswaPanel: JSON parse error",n),new Error("JSON parse error: "+n.message)}if(!a.success)throw console.warn("initKuesionerMahasiswaPanel: response.success is falsy",a),new Error("Response success false");m=a.data;const s=document.getElementById("km_import_prodi");s&&(s.innerHTML='<option value="">Pilih Program Studi</option>',((Array.isArray(a.prodis)?a.prodis:null)||[...new Set(m.map(d=>d.prodi).filter(Boolean))].sort()).forEach(d=>{const c=document.createElement("option");c.value=d,c.textContent=d,s.appendChild(c)}));const l=a.years,o=document.getElementById("kmFilterTahun");o&&(o.innerHTML='<option value="">Semua Tahun</option>',l.forEach(n=>{const r=document.createElement("option");r.value=n,r.textContent=n,o.appendChild(r)})),ee(m),te(m)}catch(e){console.error("initKuesionerMahasiswaPanel error",e),i("Gagal memuat data kuesioner mahasiswa. "+(e.message||""),"warning")}}async function E(e=""){try{const t=`/admin/kuesioner-dosen/data?kategori=Mahasiswa${e?"&tahun_akademik="+encodeURIComponent(e):""}`,s=await(await fetch(t)).json();if(!s.success)return;m=s.data,ee(m),te(m)}catch{i("Gagal memuat data.","warning")}}function ee(e){const t=document.getElementById("kmTableBody"),a=document.getElementById("kmTotalCount");if(a&&(a.textContent=e.length+" Data"),e.length===0){t.innerHTML='<tr><td colspan="9" class="px-6 py-12 text-center font-bold text-slate-300 italic">Belum ada data mahasiswa. Silakan import Excel atau tambah manual.</td></tr>';return}t.innerHTML=e.map((s,l)=>`
                <tr class="hover:bg-indigo-50/30 transition-colors group">
                    <td class="px-6 py-5 text-center font-black text-slate-400 text-xs">${l+1}</td>
                    <td class="px-6 py-5 text-xs font-bold text-slate-600">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg border border-indigo-100 w-fit">
                                <i class="fas fa-calendar-alt text-[9px]"></i> ${s.tahun_akademik}
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-600 px-3 py-1 rounded-lg border border-slate-100 w-fit text-[9px]">
                                <i class="fas fa-university text-[8px]"></i> ${s.prodi||"-"}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm font-bold text-slate-800">${s.program}</td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-black px-2.5 py-1 rounded-lg border border-emerald-100">${s.sangat_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-blue-50 text-blue-700 text-xs font-black px-2.5 py-1 rounded-lg border border-blue-100">${s.setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-orange-50 text-orange-700 text-xs font-black px-2.5 py-1 rounded-lg border border-orange-100">${s.tidak_setuju}%</span></td>
                    <td class="px-6 py-5 text-center"><span class="inline-block bg-rose-50 text-rose-700 text-xs font-black px-2.5 py-1 rounded-lg border border-rose-100">${s.sangat_tidak_setuju}%</span></td>
                    <td class="px-6 py-5">
                        <div class="flex justify-end gap-2">
                            <button onclick="openKMEditModal(${s.id})" class="text-slate-400 hover:text-indigo-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Edit"><i class="fas fa-pen text-xs"></i></button>
                            <button onclick="deleteKMRow(${s.id})" class="text-slate-400 hover:text-rose-600 bg-white border border-slate-200 w-10 h-10 rounded-xl shadow-sm hover:shadow-md flex items-center justify-center transition-all hover:-translate-y-0.5" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    </td>
                </tr>
            `).join("")}function te(e){const t=document.getElementById("chartTitleStudent");if(e.length===0){v&&v.destroy(),v=null,t&&(t.textContent="Belum Ada Data");return}const a=e[0].tahun_akademik;t&&(t.textContent=`Kepuasan Mahasiswa â€” T.A ${a}`);const s=e.map(n=>n.program.length>20?n.program.substring(0,20)+"...":n.program),l=[{label:"Sangat Baik",data:e.map(n=>n.sangat_setuju),backgroundColor:"rgba(34, 197, 94, 0.85)",borderRadius:6},{label:"Baik",data:e.map(n=>n.setuju),backgroundColor:"rgba(59, 130, 246, 0.85)",borderRadius:6},{label:"Kurang",data:e.map(n=>n.tidak_setuju),backgroundColor:"rgba(249, 115, 22, 0.85)",borderRadius:6},{label:"Sangat Kurang",data:e.map(n=>n.sangat_tidak_setuju),backgroundColor:"rgba(239, 68, 68, 0.85)",borderRadius:6}],o=document.getElementById("kmLiveChart");o&&(v&&v.destroy(),v=new Chart(o.getContext("2d"),{type:"bar",data:{labels:s,datasets:l},options:{responsive:!0,maintainAspectRatio:!1,plugins:{legend:{display:!1}},scales:{y:{beginAtZero:!0,max:100,ticks:{callback:n=>n+"%"}},x:{grid:{display:!1}}}}}))}function ut(){M=null,document.getElementById("kmModalTitle")&&(document.getElementById("kmModalTitle").textContent="Tambah Data Kuesioner Mahasiswa"),document.getElementById("km_edit_id").value="",document.getElementById("km_tahun").value="",document.getElementById("km_prodi").value="",document.getElementById("km_program").value="",document.getElementById("km_ss").value="",document.getElementById("km_s").value="",document.getElementById("km_ts").value="",document.getElementById("km_sts").value="",document.getElementById("kmModal").classList.remove("hidden")}function pt(e){const t=m.find(a=>a.id===e);t&&(M=e,document.getElementById("kmModalTitle").textContent="Edit Data Kuesioner Mahasiswa",document.getElementById("km_edit_id").value=e,document.getElementById("km_tahun").value=t.tahun_akademik,document.getElementById("km_prodi").value=t.prodi||"",document.getElementById("km_program").value=t.program,document.getElementById("km_ss").value=t.sangat_setuju,document.getElementById("km_s").value=t.setuju,document.getElementById("km_ts").value=t.tidak_setuju,document.getElementById("km_sts").value=t.sangat_tidak_setuju,document.getElementById("kmModal").classList.remove("hidden"))}function ve(){document.getElementById("kmModal").classList.add("hidden"),M=null}async function bt(){const e={tahun_akademik:document.getElementById("km_tahun").value,prodi:document.getElementById("km_prodi").value,program:document.getElementById("km_program").value,kategori:"Mahasiswa",sangat_setuju:parseFloat(document.getElementById("km_ss").value)||0,setuju:parseFloat(document.getElementById("km_s").value)||0,tidak_setuju:parseFloat(document.getElementById("km_ts").value)||0,sangat_tidak_setuju:parseFloat(document.getElementById("km_sts").value)||0,cukup_setuju:0};if(!e.tahun_akademik||!e.program)return i("Harap isi semua field utama.","warning");const a=!!M?`/admin/kuesioner-dosen/${M}/update`:"/admin/kuesioner-dosen/store";try{const l=await(await fetch(a,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"},body:JSON.stringify(e)})).json();l.success&&(i(l.message,"success"),ve(),E(document.getElementById("kmFilterTahun").value))}catch{i("Gagal menyimpan data.","warning")}}async function mt(e){if(confirm("Hapus data ini?"))try{const a=await(await fetch(`/admin/kuesioner-dosen/${e}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken}})).json();a.success&&(i(a.message,"success"),E(document.getElementById("kmFilterTahun").value))}catch{i("Gagal menghapus.","warning")}}function ye(){const e=document.getElementById("importKMContainer");e.classList.contains("hidden")?(e.classList.remove("hidden"),setTimeout(()=>e.classList.remove("opacity-0","translate-y-4"),10)):(e.classList.add("opacity-0","translate-y-4"),setTimeout(()=>e.classList.add("hidden"),300))}async function xt(){const e=document.getElementById("km_import_tahun").value,t=document.getElementById("km_import_prodi").value,a=document.getElementById("km_import_file").files[0];if(!t||!a)return i("Lengkapi form import (Prodi, File).","warning");const s=document.getElementById("importKMBtn");s.disabled=!0,s.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Mengimpor...';const l=new FormData;l.append("tahun_akademik",e),l.append("prodi",t),l.append("file",a),l.append("kategori","Mahasiswa"),l.append("_token",window.dashboardConfig.csrfToken);try{const n=await(await fetch("/admin/kuesioner-dosen/import",{method:"POST",body:l})).json();n.success?(i(n.message,"success"),ye(),E("")):i(n.message,"warning")}catch{i("Terjadi kesalahan import.","warning")}finally{s.disabled=!1,s.innerHTML='<i class="fas fa-cloud-upload-alt mr-2"></i> Jalankan Import Data Mahasiswa'}}async function ft(){const e=typeof m<"u"?m:[],t=[...new Set(e.map(u=>u.prodi).filter(Boolean))].sort(),a=[...new Set(e.map(u=>u.tahun_akademik).filter(Boolean))].sort();let s='<option value="all">Semua Program Studi</option>';t.forEach(u=>{s+=`<option value="${u}">${u}</option>`});let l='<option value="">Semua Tahun</option>';a.forEach(u=>{const P=document.getElementById("kmFilterTahun")?.value===u?"selected":"";l+=`<option value="${u}" ${P}>${u}</option>`});const{value:o}=await Swal.fire({title:"Kosongkan Data Mahasiswa",html:`
                    <div class="mb-4">
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Program Studi:</label>
                        <select id="swal-prodi" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            ${s}
                        </select>
                    </div>
                    <div>
                        <label class="block text-left font-semibold text-xs text-slate-400 uppercase tracking-wider mb-2">Pilih Tahun Akademik:</label>
                        <select id="swal-tahun" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50 transition-all">
                            ${l}
                        </select>
                    </div>
                `,focusConfirm:!1,showCancelButton:!0,confirmButtonText:"KOSONGKAN",cancelButtonText:"Batal",confirmButtonColor:"#ef4444",customClass:{popup:"rounded-[2.5rem] p-10",confirmButton:"rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4 mr-2",cancelButton:"rounded-xl font-bold uppercase tracking-wider text-xs px-6 py-4"},preConfirm:()=>({prodi:document.getElementById("swal-prodi").value,tahun:document.getElementById("swal-tahun").value})});if(!o)return;const{prodi:n,tahun:r}=o,d=n!=="all"?`prodi "${n}"`:"SEMUA prodi",c=r?`tahun akademik "${r}"`:"SEMUA tahun akademik",p=`Apakah Anda yakin ingin menghapus data kuesioner Mahasiswa untuk ${d} di ${c}?`;if(confirm(p))try{const u=new URLSearchParams({kategori:"Mahasiswa"});r&&u.append("tahun_akademik",r),n&&n!=="all"&&u.append("prodi",n);const h=await(await fetch(`/admin/kuesioner-dosen/truncate?${u.toString()}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"}})).json();if(h.success){i(h.message,"success");const B=document.getElementById("kmFilterTahun");B&&(B.value=""),E("")}else i(h.message||"Gagal mengosongkan.","warning")}catch(u){console.error(u),i("Gagal mengosongkan data (Terjadi kesalahan sistem).","warning")}}function gt(e){b==="Kuesioner Mahasiswa"?E(e||""):_(e||"")}function we(){const e=document.getElementById("dynamic-content");e.innerHTML=`
            <div class="max-w-7xl mx-auto pb-12">
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-images"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.6)]"></span>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Media</p>
                        </div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Galeri Foto</h2>
                        <p class="text-slate-500 text-sm mt-2">Daftar album dan foto kegiatan kampus.</p>
                    </div>
                    <button onclick="toggleUploadForm()" class="relative z-10 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl shadow-[0_8px_20px_rgba(37,99,235,0.2)] transition-all hover:-translate-y-1">
                        <i class="fas fa-plus mr-2 text-[10px]"></i> Tambah Album
                    </button>
                </div>

                <div id="uploadFormContainer" class="hidden opacity-0 translate-y-4 bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.03)] p-10 mb-8 transition-all duration-300">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                        <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Tambah Album Baru</h3>
                        <button onclick="toggleUploadForm()" class="text-slate-400 hover:text-rose-500 transition-colors text-xs font-bold uppercase tracking-widest"><i class="fas fa-times mr-1"></i> Batal</button>
                    </div>
                    <form id="uploadGaleriFotoForm" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Album <span class="text-rose-500">*</span></label>
                                <input type="text" id="ga_nama" placeholder="Contoh: Wisuda Ke-15 Politeknik Jambi" required
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link Sampul (Opsional)</label>
                                <input type="text" id="ga_link" placeholder="Pasang link gambar jika tidak upload file"
                                    class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Sampul Foto (Lokal)</label>
                            <input type="file" id="ga_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                        </div>
                        <button type="button" onclick="submitUploadAlbum()" id="uploadAlbumBtn" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-black uppercase tracking-widest text-[11px] py-5 rounded-2xl shadow-xl transition-all">
                            <i class="fas fa-save mr-2"></i> Simpan Album
                        </button>
                    </form>
                </div>

                <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-[0_15px_40px_rgba(0,0,0,0.02)] overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-20 text-center">No</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Album</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="galeri-foto-tbody"></tbody>
                    </table>
                </div>
            </div>
            `,C()}function _e(){const e=document.getElementById("dynamic-content");e.innerHTML=`
            <div class="max-w-7xl mx-auto pb-12">
                <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-white mb-8 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 text-[180px] text-slate-100 opacity-40 pointer-events-none -rotate-12"><i class="fas fa-video"></i></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-2 h-2 rounded-full bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.6)]"></span>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.3em]">Manajemen Video</p>
                        </div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tighter font-display">Galeri Video</h2>
                        <p class="text-slate-500 text-sm mt-2">Upload file video atau pasang link video apa saja.</p>
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
                                    <i class="fas fa-link mr-1"></i> Link Video Apa Saja
                                </button>
                            </div>
                        </div>
                        <div id="gvFileSection" class="mb-6">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Upload Video (Lokal - Max 40MB)</label>
                            <input type="file" id="gv_file" accept="video/mp4,video/x-matroska,video/x-ms-wmv" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 transition-all">
                            <p class="text-[9px] text-slate-400 mt-2 italic font-bold">Format: MP4, MKV, WMV. Limit server: 40MB.</p>
                        </div>
                        <div id="gvLinkSection" class="mb-6 hidden">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Link Video Apa Saja</label>
                            <input type="text" id="gv_link" placeholder="Tempel link video apa saja"
                                class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-sm font-semibold text-slate-700 bg-slate-50">
                            <p class="text-[9px] text-slate-400 mt-2 italic font-bold">Bisa menggunakan link YouTube, TikTok, Vimeo, Google Drive, CDN, atau link video lainnya.</p>
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
            `,K()}function C(){fetch("/admin/galeri-album").then(e=>e.json()).then(e=>{const t=document.getElementById("galeri-foto-tbody");!t||!e.success||(t.innerHTML=e.data.map((a,s)=>{let l="/images/gedung-poljam.png";return a.sampul_foto?l=a.sampul_foto.startsWith("http")?a.sampul_foto:"/storage/gallery/"+a.sampul_foto:a.first_foto&&(l=a.first_foto.file_path.startsWith("http")?a.first_foto.file_path:"/storage/gallery/"+a.first_foto.file_path),`
                    <tr class="hover:bg-blue-50/10 border-b border-slate-50 transition-colors">
                        <td class="px-8 py-4 text-center text-[11px] font-black text-slate-400 uppercase">${String(s+1).padStart(2,"0")}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <img src="${l}" 
                                     class="w-12 h-8 rounded-lg object-cover shadow-sm bg-slate-100" onerror="this.src='/images/gedung-poljam.png'">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">${a.nama_album}</p>
                                    <p class="text-[10px] text-slate-400">${a.created_at?a.created_at.substring(0,10):""}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-end gap-2">
                                <button onclick="openManagePhotos(${a.id}, '${a.nama_album.replace(/'/g,"\\'")}')"
                                    class="text-emerald-500 hover:text-emerald-700 py-2 px-3 bg-emerald-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-images mr-1"></i> Foto
                                </button>
                                <button onclick="openEditAlbum(${a.id}, '${a.nama_album.replace(/'/g,"\\'")}')"
                                    class="text-blue-500 hover:text-blue-700 py-2 px-3 bg-blue-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-pen mr-1"></i>
                                </button>
                                <button onclick="deleteAlbum(${a.id})" class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`}).join("")||'<tr><td colspan="3" class="px-8 py-10 text-center text-slate-300">Belum ada album.</td></tr>')})}function K(){fetch("/admin/galeri-video").then(e=>e.json()).then(e=>{const t=document.getElementById("galeri-video-tbody");!t||!e.success||(t.innerHTML=e.data.map((a,s)=>{let l=null,o=null,n=!1;if(a.link_youtube){const d=a.link_youtube.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/);d&&(l=d[1]);const c=a.link_youtube.match(/tiktok\.com\/(?:@[^/]+\/video\/|embed\/v2\/)(\d+)/i);c?o=c[1]:a.link_youtube.startsWith("http")||(n=!0)}const r=l?`<img src="https://img.youtube.com/vi/${l}/default.jpg" class="w-full h-full object-cover">`:o?'<div class="w-full h-full flex items-center justify-center bg-slate-900 text-white"><i class="fab fa-tiktok text-lg"></i></div>':n?'<div class="w-full h-full flex items-center justify-center bg-slate-100"><i class="fas fa-film text-slate-400 text-lg"></i></div>':'<div class="w-full h-full flex items-center justify-center bg-slate-100"><i class="fas fa-video-slash text-slate-300 text-lg"></i></div>';return`
                    <tr class="hover:bg-blue-50/10 border-b border-slate-50 transition-colors">
                        <td class="px-8 py-4 text-center text-[11px] font-black text-slate-400 uppercase">${String(s+1).padStart(2,"0")}</td>
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative w-12 h-8 rounded-lg overflow-hidden group/thumb cursor-pointer" 
                                     onclick="playDashboardVideo('${a.link_youtube||""}', '${a.judul.replace(/'/g,"\\'")}')">
                                    ${r}
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-white opacity-0 group-hover/thumb:opacity-100 transition-opacity">
                                        <i class="fas fa-play text-[10px]"></i>
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate">${a.judul}</p>
                                    <p class="text-[10px] text-slate-400 max-w-xs truncate">${a.link_youtube||"-"}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-end gap-2">
                                <button onclick="playDashboardVideo('${a.link_youtube||""}', '${a.judul.replace(/'/g,"\\'")}')"
                                    class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button onclick="openEditVideo(${a.id}, '${a.judul.replace(/'/g,"\\'")}', '${(a.link_youtube||"").replace(/'/g,"\\'")}', '${(a.deskripsi||"").replace(/'/g,"\\'")}')"
                                    class="text-blue-500 hover:text-blue-700 py-2 px-3 bg-blue-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-pen mr-1"></i>
                                </button>
                                <button onclick="deleteVideo(${a.id})" class="text-rose-500 hover:text-rose-700 py-2 px-3 bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`}).join("")||'<tr><td colspan="3" class="px-8 py-10 text-center text-slate-300">Belum ada video.</td></tr>')})}function ht(){const e=document.getElementById("ga_nama").value,t=document.getElementById("ga_file").files[0],a=document.getElementById("ga_link").value;if(!e)return i("Nama album wajib diisi","warning");const s=new FormData;s.append("nama_album",e),t&&s.append("sampul_foto",t),a&&s.append("link_extern",a),s.append("_token",window.dashboardConfig.csrfToken);const l=document.getElementById("uploadAlbumBtn"),o=l.innerHTML;l.disabled=!0,l.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...',fetch("/admin/galeri-album/upload",{method:"POST",body:s,headers:{Accept:"application/json"}}).then(n=>n.ok?n.json():n.json().then(r=>{throw r})).then(n=>{l.disabled=!1,l.innerHTML=o,n.success?(i(n.message,"success"),ae(),C(),document.getElementById("uploadGaleriFotoForm").reset()):i(n.message||"Gagal menyimpan.","warning")}).catch(n=>{l.disabled=!1,l.innerHTML=o,console.error(n);let r="Terjadi kesalahan sistem.";n.errors?r=Object.values(n.errors).flat().join(" "):n.message&&(r=n.message),i(r,"warning")})}function kt(e){const t=document.getElementById("gvFileSection"),a=document.getElementById("gvLinkSection"),s=document.getElementById("gvSrcFile"),l=document.getElementById("gvSrcLink");e==="file"?(t.classList.remove("hidden"),a.classList.add("hidden"),s.className="flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all",l.className="flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all"):(t.classList.add("hidden"),a.classList.remove("hidden"),l.className="flex-1 py-3 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all",s.className="flex-1 py-3 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all")}function vt(){const e=document.getElementById("gv_judul").value,t=!document.getElementById("gvFileSection").classList.contains("hidden"),a=document.getElementById("gv_file").files[0],s=document.getElementById("gv_link").value.trim(),l=document.getElementById("gv_deskripsi").value;if(!e)return i("Judul video wajib diisi","warning");if(t&&!a)return i("File video wajib diunggah","warning");if(!t&&!s)return i("Link video wajib diisi","warning");const o=new FormData;o.append("judul",e),o.append("deskripsi",l),t&&a&&o.append("video_file",a),!t&&s&&o.append("link_youtube",s),o.append("_token",window.dashboardConfig.csrfToken);const n=document.getElementById("uploadVideoBtn"),r=n.innerHTML;n.disabled=!0,n.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...',fetch("/admin/galeri-video/upload",{method:"POST",body:o,headers:{Accept:"application/json"}}).then(d=>d.ok?d.json():d.json().then(c=>{throw c})).then(d=>{n.disabled=!1,n.innerHTML=r,d.success?(i(d.message,"success"),ae(),K(),document.getElementById("uploadGaleriVideoForm").reset()):i(d.message||"Gagal menyimpan.","warning")}).catch(d=>{n.disabled=!1,n.innerHTML=r,console.error(d);let c="Terjadi kesalahan sistem.";d.errors?c=Object.values(d.errors).flat().join(" "):d.message&&(c=d.message),i(c,"warning")})}function yt(e){confirm("Hapus album ini secara permanen?")&&fetch("/admin/galeri-album/"+e,{method:"DELETE",body:new FormData,headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken}}).then(t=>t.json()).then(t=>{t.success&&(i(t.message,"success"),C())})}function wt(e){confirm("Hapus video ini secara permanen?")&&fetch("/admin/galeri-video/"+e,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken}}).then(t=>t.json()).then(t=>{t.success&&(i(t.message,"success"),K())})}function ae(){const e=document.getElementById("uploadFormContainer");e&&(e.classList.contains("hidden")?(e.classList.remove("hidden"),setTimeout(()=>{e.classList.remove("opacity-0","translate-y-4")},10)):(e.classList.add("opacity-0","translate-y-4"),setTimeout(()=>{e.classList.add("hidden")},300)))}let Ee=null;function _t(e,t){Ee=e,document.getElementById("ea_nama").value=t,document.getElementById("ea_link").value="",document.getElementById("editAlbumModal").classList.remove("hidden"),setTimeout(()=>{document.getElementById("editAlbumModal").classList.remove("opacity-0"),document.getElementById("editAlbumModalBox").classList.remove("scale-95")},10)}function Be(){document.getElementById("editAlbumModal").classList.add("opacity-0"),document.getElementById("editAlbumModalBox").classList.add("scale-95"),setTimeout(()=>document.getElementById("editAlbumModal").classList.add("hidden"),200)}function Et(){const e=document.getElementById("ea_nama").value,t=document.getElementById("ea_file").files[0],a=document.getElementById("ea_link").value;if(!e)return i("Nama album wajib diisi","warning");const s=new FormData;s.append("nama_album",e),t&&s.append("sampul_foto",t),a&&s.append("link_extern",a),s.append("_token",window.dashboardConfig.csrfToken),fetch("/admin/galeri-album/"+Ee+"/update",{method:"POST",body:s,headers:{Accept:"application/json"}}).then(l=>l.ok?l.json():l.json().then(o=>{throw o})).then(l=>{l.success?(i(l.message,"success"),Be(),C()):i(l.message||"Gagal menyimpan.","warning")}).catch(l=>{console.error(l);let o="Gagal memperbarui album.";l.errors&&(o=Object.values(l.errors).flat().join(" ")),i(o,"warning")})}let Te=null;function Bt(e,t,a,s){Te=e,document.getElementById("ev_judul").value=t.trim(),document.getElementById("ev_deskripsi").value=s.trim();const l=document.getElementById("ev_link");l&&(l.value=a.trim());const o=a&&!a.startsWith("http"),n=a&&a.startsWith("http");Ie(o?"file":n?"link":"file"),n&&l&&(l.value=a.trim()),document.getElementById("editVideoModal").classList.remove("hidden"),setTimeout(()=>{document.getElementById("editVideoModal").classList.remove("opacity-0"),document.getElementById("editVideoModalBox").classList.remove("scale-95")},10)}function Ie(e){const t=document.getElementById("evFileSection"),a=document.getElementById("evLinkSection"),s=document.getElementById("evSrcFile"),l=document.getElementById("evSrcLink");!t||!a||(e==="file"?(t.classList.remove("hidden"),a.classList.add("hidden"),s&&(s.className="flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all"),l&&(l.className="flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all")):(t.classList.add("hidden"),a.classList.remove("hidden"),l&&(l.className="flex-1 py-2.5 px-4 rounded-xl border-2 border-blue-500 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-widest transition-all"),s&&(s.className="flex-1 py-2.5 px-4 rounded-xl border-2 border-slate-200 bg-white text-slate-500 font-black text-[10px] uppercase tracking-widest transition-all")))}function je(){document.getElementById("editVideoModal").classList.add("opacity-0"),document.getElementById("editVideoModalBox").classList.add("scale-95"),setTimeout(()=>document.getElementById("editVideoModal").classList.add("hidden"),200)}function Tt(){const e=document.getElementById("ev_judul").value,t=document.getElementById("ev_deskripsi").value,a=document.getElementById("evFileSection")&&!document.getElementById("evFileSection").classList.contains("hidden"),s=document.getElementById("ev_file")?document.getElementById("ev_file").files[0]:null,l=document.getElementById("ev_link")?document.getElementById("ev_link").value.trim():"";if(!e)return i("Judul video wajib diisi","warning");const o=new FormData;o.append("judul",e),t&&o.append("deskripsi",t),a&&s&&o.append("video_file",s),!a&&l&&o.append("link_youtube",l),o.append("_token",window.dashboardConfig.csrfToken),fetch("/admin/galeri-video/"+Te+"/update",{method:"POST",body:o,headers:{Accept:"application/json"}}).then(n=>n.ok?n.json():n.json().then(r=>{throw r})).then(n=>{n.success?(i(n.message,"success"),je(),K()):i(n.message||"Gagal menyimpan.","warning")}).catch(n=>{console.error(n);let r="Gagal memperbarui video.";n.errors&&(r=Object.values(n.errors).flat().join(" ")),i(r,"warning")})}let se=null;function It(e,t){se=e,document.getElementById("mp_album_name").innerText=t,document.getElementById("managePhotosModal").classList.remove("hidden"),setTimeout(()=>{document.getElementById("managePhotosModal").classList.remove("opacity-0"),document.getElementById("managePhotosModalBox").classList.remove("scale-95")},10),U()}function jt(){document.getElementById("managePhotosModal").classList.add("opacity-0"),document.getElementById("managePhotosModalBox").classList.add("scale-95"),setTimeout(()=>document.getElementById("managePhotosModal").classList.add("hidden"),200)}function U(){const e=document.getElementById("mp_photos_grid");e.innerHTML='<div class="col-span-full py-10 text-center"><i class="fas fa-spinner fa-spin text-slate-300 text-2xl"></i></div>',fetch(`/admin/galeri-album/${se}/photos`).then(t=>t.json()).then(t=>{t.success&&(e.innerHTML=t.data.map(a=>{const s=a.file_path.startsWith("http")?a.file_path:"/storage/gallery/"+a.file_path,l=a.judul?a.judul:"",o=a.deskripsi?a.deskripsi:"",n=(l||"").replace(/'/g,"\\'"),r=(o||"").replace(/'/g,"\\'");return`
                                <div class="relative group rounded-2xl overflow-hidden aspect-square border border-slate-100 bg-slate-50">
                                    <img src="${s}" class="w-full h-full object-cover">
                                    <div class="p-2 absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white">
                                        ${l?`<div class="text-sm font-semibold truncate">${l}</div>`:""}
                                        ${o?`<div class="text-[11px] opacity-80 line-clamp-1">${o}</div>`:""}
                                    </div>
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                        <button onclick="deletePhoto(${a.id})" class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center hover:bg-rose-600 transition-colors">
                                            <i class="fas fa-trash text-[10px]"></i>
                                        </button>
                                        <button onclick="enlargeImage('${s}', '${n}', '${r}')" class="w-8 h-8 rounded-lg bg-white text-slate-900 flex items-center justify-center hover:bg-slate-100 transition-colors">
                                            <i class="fas fa-expand-alt text-[12px]"></i>
                                        </button>
                                    </div>
                                </div>
                            `}).join("")||'<div class="col-span-full py-10 text-center text-slate-300 font-semibold uppercase tracking-widest text-[10px]">Belum ada foto di album ini.</div>')})}function Mt(){const e=document.getElementById("mp_files").files,t=document.getElementById("mp_links"),a=document.getElementById("mp_judul"),s=document.getElementById("mp_deskripsi"),l=t?t.value.trim():"";if(e.length===0&&!l)return i("Pilih foto atau isi link foto terlebih dahulu","warning");const o=document.getElementById("mp_upload_btn"),n=o.innerHTML;o.disabled=!0,o.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';const r=new FormData;for(let d=0;d<e.length;d++)r.append("photos[]",e[d]);l&&r.append("photo_links",l),a&&a.value.trim()&&r.append("judul",a.value.trim()),s&&s.value.trim()&&r.append("deskripsi",s.value.trim()),r.append("_token",window.dashboardConfig.csrfToken),fetch(`/admin/galeri-album/${se}/photos/upload`,{method:"POST",body:r,headers:{Accept:"application/json"}}).then(d=>d.ok?d.json():d.json().then(c=>{throw c})).then(d=>{o.disabled=!1,o.innerHTML=n,d.success&&(i(d.message,"success"),document.getElementById("mp_files").value="",t&&(t.value=""),a&&(a.value=""),s&&(s.value=""),U())}).catch(d=>{o.disabled=!1,o.innerHTML=n;let c="Gagal mengunggah foto.";d.errors?c=Object.values(d.errors).flat().join(" "):d.message&&(c=d.message),i(c,"warning")})}function Lt(e){confirm("Hapus foto ini?")&&fetch(`/admin/galeri-foto/${e}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken,Accept:"application/json"}}).then(t=>t.json()).then(t=>{t.success&&(i(t.message,"success"),U())})}function St(e,t){let a=null,s=null,l=!1,o=!1;if(e){const n=/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([^"&?\/ ]{11})/,r=e.match(n);if(r&&r[1])a=r[1];else{const d=e.match(/tiktok\.com\/(?:@[^/]+\/video\/|embed\/v2\/)(\d+)/i);d?s=d[1]:/((^|\.)?(vt|vm|www)?\.?tiktok\.com)/i.test(e)?o=!0:e.startsWith("http")||(l=!0)}}if(a)Swal.fire({title:`<span class="text-slate-800 font-bold text-lg">${t}</span>`,html:`
                        <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl border border-slate-100 mt-4">
                            <iframe width="100%" height="100%" 
                                src="https://www.youtube.com/embed/${a}?autoplay=1&rel=0&modestbranding=1&playsinline=1&enablejsapi=1" 
                                title="${t}" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen></iframe>
                        </div>
                    `,background:"#fff",width:"800px",showConfirmButton:!1,showCloseButton:!0,customClass:{popup:"rounded-[2.5rem] border border-white shadow-2xl",closeButton:"text-slate-400 hover:text-rose-500"}});else if(s)Swal.fire({title:`<span class="text-slate-800 font-bold text-lg">${t}</span>`,html:`
                        <div class="aspect-[9/16] max-h-[70vh] rounded-2xl overflow-hidden shadow-2xl border border-slate-100 mt-4 mx-auto">
                            <iframe width="100%" height="100%"
                                src="https://www.tiktok.com/player/v1/${s}?description=1&music_info=1"
                                title="${t}" frameborder="0"
                                allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                                allowfullscreen></iframe>
                        </div>
                    `,background:"#fff",width:"500px",showConfirmButton:!1,showCloseButton:!0});else if(o)Swal.fire({title:`<span class="text-slate-800 font-bold text-lg">${t}</span>`,html:`
                        <div class="w-full max-w-[420px] rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-black text-white p-8 text-center shadow-2xl border border-white/10 mt-4 mx-auto">
                            <i class="fab fa-tiktok text-5xl mb-4 text-cyan-400"></i>
                            <h3 class="text-xl font-bold mb-2">Video TikTok</h3>
                            <p class="text-sm text-slate-400 mb-6">Link ini tidak bisa diputar langsung di halaman ini. Buka langsung lewat TikTok agar kontennya terbuka.</p>
                            <a href="${e}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-100">
                                <i class="fab fa-tiktok"></i> Buka di TikTok
                            </a>
                        </div>
                    `,background:"#fff",width:"480px",showConfirmButton:!1,showCloseButton:!0,customClass:{popup:"rounded-[2.5rem] border border-white shadow-2xl",closeButton:"text-slate-400 hover:text-rose-500"}});else if(l){const n="/storage/gallery/videos/"+e;Swal.fire({title:`<span class="text-slate-800 font-bold text-lg">${t}</span>`,html:`
                        <div class="rounded-2xl overflow-hidden shadow-2xl border border-slate-100 mt-4">
                            <video width="100%" height="auto" controls autoplay playsinline style="max-height: 70vh;">
                                <source src="${n}" type="video/mp4">
                                Browser Anda tidak mendukung tag pemutar video HTML5.
                            </video>
                        </div>
                    `,background:"#fff",width:"800px",showConfirmButton:!1,showCloseButton:!0,customClass:{popup:"rounded-[2.5rem] border border-white shadow-2xl",closeButton:"text-slate-400 hover:text-rose-500"}})}else i("Url video tidak valid atau video tidak ditemukan.","warning")}let F=null;function $t(e,t){F=e,document.getElementById("mq_kuesioner_name").innerText=t,G(e);const a=document.getElementById("modalOverlay"),s=document.getElementById("manageQuestionsModal");a.classList.remove("hidden"),s.classList.remove("hidden"),setTimeout(()=>{a.classList.remove("opacity-0","pointer-events-none"),s.classList.remove("scale-95","opacity-0"),s.style.opacity="1"},10)}function Dt(){const e=document.getElementById("modalOverlay"),t=document.getElementById("manageQuestionsModal");t.classList.add("scale-95","opacity-0"),t.style.opacity="0",e.classList.add("opacity-0","pointer-events-none"),setTimeout(()=>{e.classList.add("hidden"),t.classList.add("hidden")},300)}function G(e){const t=document.getElementById("mq_questions_list");t.innerHTML='<tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold">Memuat pertanyaan...</td></tr>',fetch(`/admin/kuesioner/${e}/pertanyaan`).then(a=>a.json()).then(a=>{a.success&&a.data.length>0?(t.innerHTML="",a.data.forEach(s=>{t.innerHTML+=`
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-400">${s.urutan}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-700">${s.pertanyaan}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full ${s.tipe_jawaban=="skala_likert"?"bg-blue-50 text-blue-600":"bg-emerald-50 text-emerald-600"}">
                                            ${s.tipe_jawaban.replace("_"," ")}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="deleteQuestion(${s.id})" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-rose-500 hover:bg-rose-50 flex items-center justify-center transition-all shadow-sm">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            `})):t.innerHTML='<tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold italic text-xs">Belum ada pertanyaan. Silakan tambahkan di atas.</td></tr>'}).catch(a=>{i("Gagal memuat daftar pertanyaan.","warning")})}function Ct(){const e=document.getElementById("mq_pertanyaan").value,t=document.getElementById("mq_tipe").value,a=document.getElementById("mq_urutan").value,s=document.getElementById("mq_opsi").value;if(!e){i("Teks pertanyaan wajib diisi.","warning");return}fetch("/admin/kuesioner/pertanyaan",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":window.dashboardConfig.csrfToken},body:JSON.stringify({kuesioner_id:F,pertanyaan:e,tipe_jawaban:t,opsi_jawaban:s,urutan:a})}).then(l=>l.json()).then(l=>{l.success?(i(l.message,"success"),document.getElementById("mq_pertanyaan").value="",document.getElementById("mq_opsi").value="",G(F)):i(l.message,"warning")}).catch(l=>{i("Gagal menambahkan pertanyaan.","warning")})}function Kt(e){confirm("Hapus pertanyaan ini?")&&fetch(`/admin/kuesioner/pertanyaan/${e}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":window.dashboardConfig.csrfToken}}).then(t=>t.json()).then(t=>{t.success&&(i(t.message,"success"),G(F))})}document.getElementById("mq_tipe")?.addEventListener("change",function(){const e=document.getElementById("mq_opsi_container");this.value==="pilihan_ganda"?e.classList.remove("hidden"):e.classList.add("hidden")});Object.assign(window,{addNewData:Fe,closeEditAlbumModal:Be,closeEditDokModal:W,closeEditVideoModal:je,closeKdModal:fe,closeKMModal:ve,closeManagePhotosModal:jt,closeManageQuestionsModal:Dt,closeModal:S,closeSliderModal:be,confirmDelete:Oe,deleteAlbum:yt,deleteDokumen:Je,deleteKMRow:mt,deleteKuesionerRow:rt,deletePdfDocument:Ze,deletePhoto:Lt,deleteQuestion:Kt,deleteRenstra:ze,deleteSlider:lt,deleteVideo:wt,destroyEditors:ie,fetchAlbumPhotos:U,fetchAlbums:C,fetchDokumenList:$,fetchKuesionerStats:gt,fetchPdfDocumentList:D,fetchQuestions:G,fetchRenstraList:w,fetchSliderList:R,fetchVideos:K,generateFormFields:q,generateYearOptions:z,hideOverlay:de,initKuesionerMahasiswaPanel:ke,initKuesionerPanel:xe,initRichEditor:A,loadDokumenSpmiPanel:ce,loadGaleriFotoPanel:we,loadGaleriVideoPanel:_e,loadKMTable:E,loadKuesionerDosenPanel:me,loadKuesionerMahasiswaPanel:he,loadKuesionerTable:_,loadLaporanAmiPanel:ue,loadPage:L,loadPdfDocumentPanel:Y,loadRenstraPanel:Re,loadRtmPanel:pe,loadSliderPanel:et,loadSocialMediaPage:re,openEditAlbum:_t,openEditDokModal:Xe,openEditPdfDocModal:Ye,openEditVideo:Bt,openImportKuesioner:He,openKMAddModal:ut,openKMEditModal:pt,openKuesionerAddModal:nt,openKuesionerEditModal:ot,openManagePhotos:It,openManageQuestions:$t,openModalEdit:De,openRenstraModal:Ge,openSliderModal:tt,openTambah:Ce,playDashboardVideo:St,previewSliderImage:at,renderKMChart:te,renderKMTable:ee,renderKuesionerChart:Z,renderKuesionerTable:Q,saveData:Pe,saveEditAlbum:Et,saveEditVideo:Tt,saveSingleContent:$e,setEditVideoSource:Ie,setVideoSource:kt,showHome:T,showOverlay:O,showToast:i,submitAddPhotos:Mt,submitAddQuestion:Ct,submitEditDokumen:qe,submitEditPdfDocument:Qe,submitImportKM:xt,submitImportKuesioner:dt,submitImportKuesionerDosen:Ae,submitImportRenstra:Ue,submitKdForm:it,submitKMForm:bt,submitRenstra:J,submitSlider:st,submitUploadAlbum:ht,submitUploadDokumen:Ve,submitUploadPdfDocument:We,submitUploadVideo:vt,toggleImportKM:ye,toggleImportKuesioner:ge,toggleMenu:Le,toggleProfileDropdown:Me,toggleUploadForm:ae,truncateKM:ft,truncateKuesionerDosen:ct,truncateRenstra:Ne,updateClock:N,updateDropzoneUI:I});
