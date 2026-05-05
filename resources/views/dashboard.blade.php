<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin LPM | Politeknik Jambi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Sidebar Styling */
        .submenu-item:hover {
            border-left: 3px solid #60a5fa;
            padding-left: 18px !important;
            color: white !important;
            background: rgba(255, 255, 255, 0.05);
        }
        .submenu-item { transition: all 0.2s ease-in-out; cursor: pointer; }
        
        aside::-webkit-scrollbar { width: 4px; }
        aside::-webkit-scrollbar-thumb { background: #1e40af; border-radius: 10px; }

        /* Efek Interaktif Tabel (Saran Pengeditan) */
        #table-body tr { transition: all 0.2s ease; }
        #table-body tr:hover {
            background-color: #f1f5f9 !important;
            box-shadow: inset 4px 0 0 #2563eb;
        }

        /* Animasi Highlight Data Baru */
        @keyframes highlightRow {
            0% { background-color: #dcfce7; }
            100% { background-color: transparent; }
        }
        .row-added { animation: highlightRow 2s ease-out; }

        .sidebar-item { transition: all 0.2s; }
        .sidebar-item:hover { background-color: #1e40af; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Vertikal -->
        <aside class="w-72 bg-[#0f172a] text-gray-300 flex-shrink-0 flex flex-col shadow-2xl overflow-y-auto border-r border-slate-800">
            
            <div class="px-6 py-8 flex items-center space-x-4 border-b border-slate-800">
                <div class="flex-shrink-0 bg-white h-12 w-12 rounded-xl flex items-center justify-center shadow-lg overflow-hidden">
                    <img src="images/logo.png" alt="Logo" class="h-full w-full object-contain p-1">
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight text-white leading-none uppercase">LPM Poljam</h1>
                    <p class="text-[10px] font-bold text-blue-500 mt-1 uppercase tracking-widest">Administrator</p>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                
                <a href="javascript:void(0)" onclick="showHome()" class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-blue-600 text-white shadow-lg shadow-blue-900/20 transition mb-4">
                    <i class="fas fa-home"></i>
                    <span class="text-sm font-bold uppercase tracking-wider">Home</span>
                </a>

                <!-- Profil Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuProfil')" class="w-full sidebar-item flex items-center justify-between py-3 px-4 rounded-lg hover:text-white transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-university text-blue-400"></i>
                            <span class="text-sm font-medium">Profil</span>
                        </div>
                        <i id="icon-menuProfil" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuProfil" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-gray-400 border-l border-slate-700 ml-6 mt-1">
                        <a onclick="loadPage('Visi Dan Misi')" class="submenu-item block py-1">Visi Dan Misi</a>
                        <a onclick="loadPage('Moto Dan Janji Layanan')" class="submenu-item block py-1">Moto Dan Janji Layanan</a>
                        <a onclick="loadPage('Kebijakan Mutu POLJAM')" class="submenu-item block py-1">Kebijakan Mutu POLJAM</a>
                        <a onclick="loadPage('Sasaran Mutu POLJAM')" class="submenu-item block py-1">Sasaran Mutu POLJAM</a>
                        <a onclick="loadPage('Standar Mutu POLJAM')" class="submenu-item block py-1">Standar Mutu POLJAM</a>
                        <a onclick="loadPage('Sasaran Mutu LPM')" class="submenu-item block py-1">Sasaran Mutu LPM</a>
                        <a onclick="loadPage('Struktur Organisasi')" class="submenu-item block py-1">Struktur Organisasi</a>
                        <a onclick="loadPage('Job Deskripsi')" class="submenu-item block py-1">Job Deskripsi</a>
                        <a onclick="loadPage('Standar Waktu Pelayanan')" class="submenu-item block py-1">Standar Waktu Pelayanan</a>
                    </div>
                </div>

                <!-- SPMI Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuSPMI')" class="w-full sidebar-item flex items-center justify-between py-3 px-4 rounded-lg hover:text-white transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-signature text-blue-400"></i>
                            <span class="text-sm font-medium">SPMI</span>
                        </div>
                        <i id="icon-menuSPMI" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuSPMI" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-gray-400 border-l border-slate-700 ml-6 mt-1">
                        <a onclick="loadPage('Dokumen SPMI')" class="submenu-item block py-1">Dokumen SPMI</a>
                        <a onclick="loadPage('Unit')" class="submenu-item block py-1">Unit</a>
                        <a onclick="loadPage('RTM')" class="submenu-item block py-1">RTM</a>
                        <a onclick="loadPage('Dokumen Mutu SPMI')" class="submenu-item block py-1">Dokumen Mutu SPMI</a>
                        <a onclick="loadPage('e-spmiPoljam')" class="submenu-item block py-1">e-spmiPoljam</a>
                    </div>
                </div>

                <!-- Akreditasi Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuAkreditasi')" class="w-full sidebar-item flex items-center justify-between py-3 px-4 rounded-lg hover:text-white transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-award text-blue-400"></i>
                            <span class="text-sm font-medium">Akreditasi</span>
                        </div>
                        <i id="icon-menuAkreditasi" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuAkreditasi" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-gray-400 border-l border-slate-700 ml-6 mt-1">
                        <a onclick="loadPage('Akreditas')" class="submenu-item block py-1">Akreditas</a>
                        <a onclick="loadPage('Dokuemen Akreditas')" class="submenu-item block py-1">Dokumen Akreditas</a>
                    </div>
                </div>

                <!-- Capaian Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuCapaian')" class="w-full sidebar-item flex items-center justify-between py-3 px-4 rounded-lg hover:text-white transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-chart-line text-blue-400"></i>
                            <span class="text-sm font-medium">Capaian</span>
                        </div>
                        <i id="icon-menuCapaian" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuCapaian" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-gray-400 border-l border-slate-700 ml-6 mt-1">
                        <a onclick="loadPage('Renop')" class="submenu-item block py-1">Renop</a>
                        <a onclick="loadPage('Capaian Renstra')" class="submenu-item block py-1">Capaian Renstra</a>
                        <a onclick="loadPage('Kepuasan Mahasiswa Poljam 2020/2021')" class="submenu-item block py-1">Kepuasan Mhs Poljam</a>
                        <a onclick="loadPage('Kepuasan Dosen & Tendik')" class="submenu-item block py-1">Kepuasan Dosen & Tendik</a>
                    </div>
                </div>

                <!-- Kuesioner Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuKuesioner')" class="w-full sidebar-item flex items-center justify-between py-3 px-4 rounded-lg hover:text-white transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-poll text-blue-400"></i>
                            <span class="text-sm font-medium">Kuesioner</span>
                        </div>
                        <i id="icon-menuKuesioner" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuKuesioner" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-gray-400 border-l border-slate-700 ml-6 mt-1">
                        <a onclick="loadPage('Kuesioner Mahasiswa')" class="submenu-item block py-1">Mahasiswa</a>
                        <a onclick="loadPage('Kuesioner Dosen & Karyawan')" class="submenu-item block py-1">Dosen & Karyawan</a>
                    </div>
                </div>

                <!-- Berita Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuBerita')" class="w-full sidebar-item flex items-center justify-between py-3 px-4 rounded-lg hover:text-white transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-bullhorn text-blue-400"></i>
                            <span class="text-sm font-medium">Berita</span>
                        </div>
                        <i id="icon-menuBerita" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuBerita" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-gray-400 border-l border-slate-700 ml-6 mt-1">
                        <a onclick="loadPage('Daftar Berita')" class="submenu-item block py-1">Daftar Berita</a>
                        <a onclick="loadPage('Tambah Berita')" class="submenu-item block py-1">Tambah Berita</a>
                        <a onclick="loadPage('Kategori Berita')" class="submenu-item block py-1">Kategori Berita</a>
                    </div>
                </div>

                <a onclick="loadPage('Artikel')" class="submenu-item sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg hover:text-white transition group">
                    <i class="fas fa-newspaper text-blue-400"></i>
                    <span class="text-sm font-medium">Artikel</span>
                </a>

            </nav>

            <div class="p-4 border-t border-slate-800 bg-[#0b1120]">
                <button class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-lg text-xs font-bold transition shadow-lg flex items-center justify-center space-x-2 text-white">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>KELUAR SISTEM</span>
                </button>
            </div>
        </aside>

        <!-- Konten Utama -->
        <main id="mainContent" class="flex-1 overflow-y-auto bg-gray-50">
            <div id="dynamic-area" class="p-12 text-center mt-20">
                <div class="inline-block p-4 rounded-2xl bg-blue-50 mb-6">
                    <i class="fas fa-shield-alt text-5xl text-blue-600"></i>
                </div>
                <h2 class="text-4xl font-extrabold text-slate-800">Selamat Datang di Administrator LPM</h2>
                <div class="h-1.5 w-20 bg-blue-500 mx-auto mt-6 rounded-full"></div>
                <p class="text-slate-500 mt-6 text-lg font-medium">Politeknik Jambi - Sistem Penjaminan Mutu Internal</p>
            </div>
        </main>
    </div>

    <!-- MODAL EDIT DATA -->
    <div id="modalEdit" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center text-white">
                <h3 class="font-bold flex items-center space-x-2"><i class="fas fa-edit"></i> <span>EDIT KONTEN</span></h3>
                <button onclick="closeModal()" class="hover:rotate-90 transition duration-200"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-8">
                <textarea id="editValue" rows="5" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-700 bg-gray-50"></textarea>
                <div class="mt-8 flex justify-end space-x-3">
                    <button onclick="closeModal()" class="px-5 py-2.5 text-gray-400 font-bold text-xs hover:bg-gray-100 rounded-lg">BATAL</button>
                    <button onclick="saveData()" class="px-8 py-2.5 bg-blue-600 text-white font-bold text-xs rounded-lg shadow-lg hover:bg-blue-700 transition transform active:scale-95">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH DATA -->
    <div id="modalTambah" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="bg-emerald-600 px-6 py-4 flex justify-between items-center text-white">
                <h3 class="font-bold flex items-center space-x-2"><i class="fas fa-plus-circle"></i> <span>DATA BARU</span></h3>
                <button onclick="closeTambah()" class="hover:rotate-90 transition duration-200"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-8">
                <textarea id="addValue" rows="5" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm text-gray-700 bg-gray-50" placeholder="Masukkan deskripsi..."></textarea>
                <div class="mt-8 flex justify-end space-x-3">
                    <button onclick="closeTambah()" class="px-5 py-2.5 text-gray-400 font-bold text-xs hover:bg-gray-100 rounded-lg">BATAL</button>
                    <button onclick="addNewData()" class="px-8 py-2.5 bg-emerald-600 text-white font-bold text-xs rounded-lg shadow-lg hover:bg-emerald-700 transition transform active:scale-95">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTitle = ""; 

        function toggleMenu(id) {
            const menu = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            menu.classList.toggle('hidden');
            if (icon) icon.classList.toggle('rotate-90');
        }

        function showHome() {
            document.getElementById('mainContent').innerHTML = `
                <div class="p-12 text-center mt-20">
                    <div class="inline-block p-4 rounded-2xl bg-blue-50 mb-6"><i class="fas fa-shield-alt text-5xl text-blue-600"></i></div>
                    <h2 class="text-4xl font-extrabold text-slate-800">Selamat Datang di Administrator LPM</h2>
                    <p class="text-slate-500 mt-6 text-lg font-medium">Politeknik Jambi - Sistem Penjaminan Mutu Internal</p>
                </div>`;
        }

        function loadPage(title) {
            currentTitle = title;
            const contentData = `Arsip dokumen untuk modul ${title}.`;
            
            document.getElementById('mainContent').innerHTML = `
                <div class="p-8">
                    <div class="flex justify-between items-center bg-white p-8 rounded-t-2xl border-b shadow-sm">
                        <div>
                            <h2 class="text-2xl font-black text-slate-800">${title}</h2>
                            <p class="text-[10px] text-blue-500 font-bold mt-1 uppercase tracking-widest">Management > ${title}</p>
                        </div>
                        <button onclick="openTambah()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl flex items-center space-x-2 text-xs font-bold transition shadow-lg active:scale-95">
                            <i class="fas fa-plus"></i><span>TAMBAH DATA</span>
                        </button>
                    </div>
                    <!-- FITUR PENCARIAN -->
                    <div class="px-8 py-4 bg-slate-50 border-b border-gray-100 flex items-center">
                        <div class="relative w-full max-w-xs">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fas fa-search text-xs"></i></span>
                            <input type="text" id="tableSearch" onkeyup="filterTable()" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-xs outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cari data di sini...">
                        </div>
                    </div>
                    <div class="bg-white rounded-b-2xl shadow-xl overflow-hidden border border-gray-100">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-black tracking-widest">
                                <tr>
                                    <th class="px-8 py-5 border-b w-24 text-center">ID</th>
                                    <th class="px-8 py-5 border-b">Isi Konten</th>
                                    <th class="px-8 py-5 border-b text-center w-48">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-body" class="text-sm text-slate-600 divide-y divide-gray-50">
                                <tr>
                                    <td class="px-8 py-5 font-bold text-blue-600 text-center">#1</td>
                                    <td id="desc-content" class="px-8 py-5 leading-relaxed font-medium">${contentData}</td>
                                    <td class="px-8 py-5">
                                        <div class="flex justify-center space-x-3">
                                            <button onclick="openModal('${contentData}')" class="text-amber-500 hover:bg-amber-50 p-2.5 rounded-xl"><i class="fas fa-edit"></i></button>
                                            <button onclick="confirmDelete(this)" class="text-rose-500 hover:bg-rose-50 p-2.5 rounded-xl"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>`;
        }

        // FUNGSI PENCARIAN (SEARCH)
        function filterTable() {
            const input = document.getElementById("tableSearch");
            const filter = input.value.toUpperCase();
            const table = document.getElementById("table-body");
            const tr = table.getElementsByTagName("tr");
            for (let i = 0; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                }
            }
        }

        function openModal(val) { document.getElementById('editValue').value = val; document.getElementById('modalEdit').classList.remove('hidden'); }
        function closeModal() { document.getElementById('modalEdit').classList.add('hidden'); }
        function saveData() {
            document.getElementById('desc-content').innerText = document.getElementById('editValue').value;
            closeModal();
        }

        function openTambah() { document.getElementById('addValue').value = ""; document.getElementById('modalTambah').classList.remove('hidden'); }
        function closeTambah() { document.getElementById('modalTambah').classList.add('hidden'); }
        
        function addNewData() {
            const val = document.getElementById('addValue').value;
            if(!val.trim()) return alert("Kosong!");
            const tableBody = document.getElementById("table-body");
            const newRow = `
                <tr class="row-added">
                    <td class="px-8 py-5 font-bold text-blue-600 text-center">#${tableBody.rows.length + 1}</td>
                    <td class="px-8 py-5 leading-relaxed font-medium">${val}</td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex justify-center space-x-3">
                            <button onclick="openModal('${val}')" class="text-amber-500 p-2.5"><i class="fas fa-edit"></i></button>
                            <button onclick="confirmDelete(this)" class="text-rose-500 p-2.5"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            closeTambah();
        }

        function confirmDelete(btn) { if(confirm("Hapus data?")) btn.closest('tr').remove(); }
    </script>
</body>
</html>