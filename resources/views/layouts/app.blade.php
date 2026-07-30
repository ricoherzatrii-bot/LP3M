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

    <footer class="bg-[#0056b3] py-12 text-white border-t border-[#004494] transition-colors duration-500">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div class="mb-6">
                <img src="{{ optional($brandAssets->get('logo_poljam'))->logo_url ?? asset('/images/logo-poljam.png') }}" class="h-16 w-auto mx-auto object-contain bg-white rounded-full p-2 shadow-lg" alt="Logo">
            </div>
            <p class="text-sm tracking-widest uppercase text-white/90">&copy; 2026 LPM Politeknik Jambi</p>
            <p class="text-xs mt-2 font-light text-white/50">Internal Quality Assurance System (IQAS)</p>
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