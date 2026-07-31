<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPM Politeknik Jambi</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'serif-luxury': ['Arial', 'Helvetica Neue', 'Helvetica', 'sans-serif'],
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
        body { font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif; }
        .font-playfair { font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif; }
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
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 transition-colors duration-500">

    {{-- Kita kirim variabel $allProfil ke navbar agar bisa dibaca --}}
    @include('components.navbar', ['allProfil' => $allProfil ?? []])

    <main>
        @yield('content')
    </main>

    <footer class="bg-[#004494] pt-32 pb-12 border-t border-[#003377]">
        <div class="container mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-start gap-20 mb-24">
                <div class="max-w-xs">
                    <div class="bg-white p-2 rounded-xl inline-block mb-8">
                        <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" alt="Logo" class="h-10 transition-all cursor-pointer">
                    </div>
                    <p class="text-blue-100 text-sm font-light leading-relaxed mb-8">
                        Lembaga Penjamin Mutu Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi nasional.
                    </p>
                    <div class="flex gap-4 relative z-50">
                        <a href="{{ optional($socialLinks->get('instagram'))->url ?? 'https://www.instagram.com/politeknikjambi?igsh=MW1scnJubzYxbXI1OA==' }}" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-instagram"></i></a>
                        <a href="{{ optional($socialLinks->get('tiktok'))->url ?? 'https://www.tiktok.com/@politeknikjambi?_r=1&_t=ZS-97xqcpSv8SK' }}" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-tiktok"></i></a>
                        <a href="{{ optional($socialLinks->get('youtube'))->url ?? 'https://youtube.com/@poltekjambi?si=gP6jTcGudVbPtwB1' }}" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-yellow-400 hover:text-[#004494] hover:border-yellow-400 transition-all cursor-pointer"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-20 uppercase font-black text-[10px] tracking-[0.2em] text-blue-200">
                    <div class="space-y-6">
                        <div class="text-yellow-400 mb-2">Tautan Utama</div>
                        <a href="{{ route('login') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Login Dashboard</a>
                        <a href="{{ url('/spmi/dokumen-spmi') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Dokumen SPMI</a>
                        <a href="{{ route('capaian.laporan_ami') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Laporan AMI</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-yellow-400 mb-2">Informasi</div>
                        <a href="{{ route('profil.show', 'visi-dan-misi') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Visi & Misi</a>
                        <a href="{{ route('akreditasi.index') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Akreditasi</a>
                        <a href="{{ route('gallery.index') }}" class="block text-white hover:text-yellow-400 hover:translate-x-2 transition">Galeri</a>
                    </div>
                    <div class="space-y-6">
                        <div class="text-yellow-400 mb-2">Alamat</div>
                        <span class="block lowercase font-medium text-white">Jalan Lingkar Barat II, Lorong Veteran</span>
                        <span class="block lowercase font-medium text-white">Kelurahan: Pinang Merah / Bagan Pete</span>
                        <span class="block lowercase font-medium text-white">Kecamatan: Alam Barajo</span>
                         <span class="block lowercase font-medium text-white">Kota: Kota Jambi, 36129</span>
                    </div>
                </div>
            </div>
            <div class="pt-12 border-t border-white/10 flex flex-col md:flex-row justify-between gap-8 items-center">
                <span class="text-[10px] font-bold text-blue-200 uppercase tracking-[0.3em]">© 2026 LPM Politeknik Jambi.</span>
                <div class="flex gap-10 text-[9px] font-black uppercase tracking-widest text-blue-200">
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