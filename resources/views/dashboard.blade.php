<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin LPM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .submenu-item:hover {
            border-left: 2px solid #60a5fa;
            padding-left: 14px !important;
            color: white !important;
        }
        .submenu-item {
            transition: all 0.2s ease-in-out;
        }
        /* Custom scrollbar untuk sidebar agar tetap rapi */
        aside::-webkit-scrollbar {
            width: 4px;
        }
        aside::-webkit-scrollbar-thumb {
            background: #1e40af;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Vertikal -->
        <aside class="w-72 bg-blue-900 text-white flex-shrink-0 flex flex-col shadow-2xl overflow-y-auto">
            
            <!-- Memanggil bagian logo -->
            @include('logo')

            <!-- Menu List -->
            <nav class="flex-1 p-4 space-y-1">
                
                <!-- Home -->
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-blue-800 text-white shadow-md transition">
                    <i class="fas fa-home text-blue-400"></i>
                    <span class="text-sm font-bold uppercase tracking-wider">Home</span>
                </a>

                <!-- Profil Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuProfil')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-university text-blue-400 group-hover:text-white"></i>
                            <span class="text-sm font-medium">Profil</span>
                        </div>
                        <i id="icon-menuProfil" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuProfil" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-bullseye fa-xs"></i> <span>Visi Dan Misi</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-hand-holding-heart fa-xs"></i> <span>Moto Dan Janji Layanan</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-shield-alt fa-xs"></i> <span>Kebijakan Mutu POLJAM</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-check-circle fa-xs"></i> <span>Sasaran Mutu POLJAM</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-list-check fa-xs"></i> <span>Standar Mutu POLJAM</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-tasks fa-xs"></i> <span>Sasaran Mutu LPM</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-sitemap fa-xs"></i> <span>Struktur Organisasi</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-user-tag fa-xs"></i> <span>Job Deskripsi</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-clock fa-xs"></i> <span>Standar Waktu Pelayanan</span></a>
                    </div>
                </div>

                <!-- SPMI Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuSPMI')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-signature text-blue-400 group-hover:text-white"></i>
                            <span class="text-sm font-medium">SPMI</span>
                        </div>
                        <i id="icon-menuSPMI" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuSPMI" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-folder-open fa-xs"></i> <span>Dokumen SPMI</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-users-cog fa-xs"></i> <span>Unit</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-sync fa-xs"></i> <span>RTM</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-file-contract fa-xs"></i> <span>Dokumen Mutu SPMI</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-globe fa-xs"></i> <span>e-spmiPoljam</span></a>
                    </div>
                </div>

                <!-- Akreditasi Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuAkreditasi')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-award text-blue-400 group-hover:text-white"></i>
                            <span class="text-sm font-medium">Akreditasi</span>
                        </div>
                        <i id="icon-menuAkreditasi" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuAkreditasi" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-graduation-cap fa-xs"></i> <span>BAN-PT</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-tools fa-xs"></i> <span>LAM-TEKNIK</span></a>
                    </div>
                </div>

                <!-- Capaian Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuCapaian')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-chart-line text-blue-400 group-hover:text-white"></i>
                            <span class="text-sm font-medium">Capaian</span>
                        </div>
                        <i id="icon-menuCapaian" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuCapaian" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-file-alt fa-xs"></i> <span>Renop</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-chart-bar fa-xs"></i> <span>Capaian Renstra</span></a>
                        
                        <div>
                            <button onclick="toggleMenu('subMenuKepuasan')" class="w-full flex items-center justify-between py-1 hover:text-white transition group/sub">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user-graduate fa-xs"></i>
                                    <span>Kepuasan Mahasiswa</span>
                                </div>
                                <i id="icon-subMenuKepuasan" class="fas fa-chevron-right text-[8px] transition-transform duration-300"></i>
                            </button>
                            <div id="subMenuKepuasan" class="hidden pl-4 mt-2 space-y-2 border-l border-blue-600 ml-1">
                                <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-calendar-alt fa-xs"></i> <span>Poljam 2020/2021</span></a>
                                <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-calendar-check fa-xs"></i> <span>Prodi 2020/2021</span></a>
                            </div>
                        </div>

                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-chalkboard-teacher fa-xs"></i> <span>Kepuasan Dosen & Tendik</span></a>
                    </div>
                </div>

                <!-- Kuesioner Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuKuesioner')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-poll text-blue-400 group-hover:text-white"></i>
                            <span class="text-sm font-medium">Kuesioner</span>
                        </div>
                        <i id="icon-menuKuesioner" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuKuesioner" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-user-edit fa-xs"></i> <span>Mahasiswa</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-user-tie fa-xs"></i> <span>Dosen & Karyawan</span></a>
                    </div>
                </div>

                <!-- MENU BERITA (BARU) -->
                <div>
                    <button onclick="toggleMenu('menuBerita')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-bullhorn text-blue-400 group-hover:text-white"></i>
                            <span class="text-sm font-medium">Berita</span>
                        </div>
                        <i id="icon-menuBerita" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuBerita" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-list fa-xs"></i> <span>Daftar Berita</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-plus-circle fa-xs"></i> <span>Tambah Berita</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-tags fa-xs"></i> <span>Kategori Berita</span></a>
                    </div>
                </div>

                <!-- Galeri Dropdown -->
                <div>
                    <button onclick="toggleMenu('menuGaleri')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-images text-blue-400 group-hover:text-white"></i>
                            <span class="text-sm font-medium">Galeri</span>
                        </div>
                        <i id="icon-menuGaleri" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                    </button>
                    <div id="menuGaleri" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-image fa-xs"></i> <span>Foto</span></a>
                        <a href="#" class="submenu-item block py-1 flex items-center space-x-2"><i class="fas fa-photo-video fa-xs"></i> <span>Album</span></a>
                    </div>
                </div>

                <!-- ARTIKEL -->
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
                    <i class="fas fa-newspaper text-blue-400 group-hover:text-white"></i>
                    <span class="text-sm font-medium">Artikel</span>
                </a>

            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-blue-800 bg-blue-950">
                <button class="w-full bg-red-600 hover:bg-red-700 py-2.5 rounded-lg text-xs font-bold transition shadow-lg flex items-center justify-center space-x-2 text-white">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>KELUAR SISTEM</span>
                </button>
            </div>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <div class="p-10 text-center">
                <h2 class="text-3xl font-extrabold text-blue-900">Selamat Datang di Administrator LPM</h2>
                <div class="h-1 w-24 bg-blue-500 mx-auto mt-4 rounded-full"></div>
                <p class="text-gray-500 mt-4 italic font-medium">Politeknik Jambi - Sistem Penjaminan Mutu Internal</p>
            </div>
        </main>
    </div>
    <!-- Profil Dropdown -->
<div>
    <button onclick="toggleMenu('menuProfil')" class="w-full flex items-center justify-between py-3 px-4 rounded-lg hover:bg-blue-800 transition group">
        <div class="flex items-center space-x-3">
            <i class="fas fa-university text-blue-400 group-hover:text-white"></i>
            <span class="text-sm font-medium">Profil</span>
        </div>
        <i id="icon-menuProfil" class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
    </button>

    <div id="menuProfil" class="hidden pl-11 pr-4 py-2 space-y-2 text-xs text-blue-200 border-l border-blue-800 ml-6 mt-1">

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-bullseye fa-xs"></i>
                <span>Visi Dan Misi</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-hand-holding-heart fa-xs"></i>
                <span>Moto Dan Janji Layanan</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-shield-alt fa-xs"></i>
                <span>Kebijakan Mutu POLJAM</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-check-circle fa-xs"></i>
                <span>Sasaran Mutu POLJAM</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-list-check fa-xs"></i>
                <span>Standar Mutu POLJAM</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-tasks fa-xs"></i>
                <span>Sasaran Mutu LPM</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-sitemap fa-xs"></i>
                <span>Struktur Organisasi</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-user-tag fa-xs"></i>
                <span>Job Deskripsi</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="submenu-item flex items-center space-x-2">
                <i class="fas fa-clock fa-xs"></i>
                <span>Standar Waktu Pelayanan</span>
            </a>
            <div class="flex space-x-2">
                <a href="#"><i class="fas fa-edit text-yellow-400"></i></a>
                <a href="#"><i class="fas fa-trash text-red-400"></i></a>
            </div>
        </div>

    </div>
</div>

    <script>
        function toggleMenu(id) {
            const menu = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-90');
            } else {
                menu.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-90');
            }
        }
    </script>
</body>
</html>