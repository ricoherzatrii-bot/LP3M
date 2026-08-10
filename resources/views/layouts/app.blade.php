<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPM Politeknik Jambi</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                        'serif-luxury': ['Roboto', 'sans-serif'],
                        display: ['Roboto', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Roboto', sans-serif; }
        .font-playfair { font-family: 'Roboto', sans-serif; }
        .glass-nav { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
        }
        /* Mobile-friendly aspect ratio */
        .aspect-video { aspect-ratio: 16 / 9; }
        .aspect-square { aspect-ratio: 1 / 1; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        
        /* Indikator aktif sederhana */
        .nav-link-active { color: #1d4ed8; position: relative; }
        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #1d4ed8;
        }
        
        /* Tambahkan kelancaran transisi untuk dropdown */
        .dropdown-animate {
            transition: all 0.3s ease-in-out;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 transition-colors duration-500">

    {{-- Kita kirim variabel $allProfil ke navbar agar bisa dibaca --}}
    @include('components.navbar', ['allProfil' => $allProfil ?? []])

    <main>
        @yield('content')
    </main>

    <footer class="bg-[#003377] pt-24 pb-12 border-t border-[#004494]">
    <div class="container mx-auto px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
            
            <!-- Kolom 1: Branding -->
            <div class="col-span-1 lg:col-span-1">
                <div class="bg-white p-3 rounded-lg inline-block mb-6 shadow-lg shadow-black/10">
                    <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="Logo Poljam" class="h-10">
                </div>
                <p class="text-blue-100 text-sm font-medium leading-relaxed mb-8 opacity-80">
                    Lembaga Penjamin Mutu Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi nasional dengan integritas.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#003377] transition-all duration-300"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#003377] transition-all duration-300"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#003377] transition-all duration-300"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <!-- Kolom 2: Tautan Utama -->
            <div>
                <h4 class="text-yellow-400 font-bold uppercase text-xs tracking-[0.2em] mb-6 border-b border-white/10 pb-2">Tautan Utama</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('login') }}" class="text-blue-100 hover:text-white transition-all text-xs font-semibold flex items-center"><span class="mr-2">→</span> Login Dashboard</a></li>
                    <li><a href="{{ url('/spmi/dokumen-spmi') }}" class="text-blue-100 hover:text-white transition-all text-xs font-semibold flex items-center"><span class="mr-2">→</span> Dokumen SPMI</a></li>
                    <li><a href="{{ route('capaian.laporan_ami') }}" class="text-blue-100 hover:text-white transition-all text-xs font-semibold flex items-center"><span class="mr-2">→</span> Laporan AMI</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Informasi -->
            <div>
                <h4 class="text-yellow-400 font-bold uppercase text-xs tracking-[0.2em] mb-6 border-b border-white/10 pb-2">Informasi</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('profil.show', 'visi-dan-misi') }}" class="text-blue-100 hover:text-white transition-all text-xs font-semibold flex items-center"><span class="mr-2">→</span> Visi & Misi</a></li>
                    <li><a href="{{ route('akreditasi.index') }}" class="text-blue-100 hover:text-white transition-all text-xs font-semibold flex items-center"><span class="mr-2">→</span> Akreditasi</a></li>
                    <li><a href="{{ route('gallery.index') }}" class="text-blue-100 hover:text-white transition-all text-xs font-semibold flex items-center"><span class="mr-2">→</span> Galeri</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Alamat -->
            <div>
                <h4 class="text-yellow-400 font-bold uppercase text-xs tracking-[0.2em] mb-6 border-b border-white/10 pb-2">Kontak Alamat</h4>
                <p class="text-blue-100 text-xs font-medium leading-relaxed opacity-90">
                    Jalan Lingkar Barat II, Lorong Veteran, Kelurahan Pinang Merah / Bagan Pete, Kecamatan Alam Barajo, Kota Jambi, 36129.
                </p>
                <div class="mt-4">
                    <a href="https://maps.google.com" target="_blank" class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest hover:underline">Lihat di Maps</a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-[10px] font-bold text-white/50 uppercase tracking-[0.2em]">© 2026 LPM Politeknik Jambi. All Rights Reserved.</span>
            <div class="flex gap-6">
                <a href="#" class="text-[9px] font-bold text-white/50 hover:text-yellow-400 uppercase tracking-widest">Privacy Policy</a>
                <a href="#" class="text-[9px] font-bold text-white/50 hover:text-yellow-400 uppercase tracking-widest">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

    @stack('scripts')
    <script>
        // Global password toggle: insert an eye-button for any password input that lacks one
        (function(){
            function ensureToggleForInput(input) {
                if (!input || input.type !== 'password') return;
                var parent = input.parentElement;
                if (!parent) return;
                if (parent.querySelector('.toggle-password')) return;
                // ensure parent positioned
                var style = window.getComputedStyle(parent);
                if (style.position === 'static') parent.style.position = 'relative';

                if (!input.id) input.id = 'pw_' + Math.random().toString(36).slice(2,9);

                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer';
                btn.setAttribute('data-target', input.id);
                btn.setAttribute('aria-label', 'Toggle password visibility');
                btn.innerHTML = '<i class="fa fa-eye"></i>';
                parent.appendChild(btn);

                btn.addEventListener('click', function(){
                    var tgt = document.getElementById(this.dataset.target);
                    var icon = this.querySelector('i');
                    if (!tgt) return;
                    if (tgt.type === 'password') { tgt.type = 'text'; if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); } }
                    else { tgt.type = 'password'; if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); } }
                });
            }

            function scanAndAttach(){
                document.querySelectorAll('input[type="password"]').forEach(function(i){ ensureToggleForInput(i); });
            }

            // initial run
            document.addEventListener('DOMContentLoaded', scanAndAttach);
            // also observe DOM for dynamically added inputs
            var obs = new MutationObserver(function(m){ scanAndAttach(); });
            obs.observe(document.body, { childList: true, subtree: true });
        })();
    </script>
</body>
</html>