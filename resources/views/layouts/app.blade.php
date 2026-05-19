<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPM Politeknik Jambi</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        .glass-nav { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
        }
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
<body class="bg-slate-50">

    {{-- Kita kirim variabel $allProfil ke navbar agar bisa dibaca --}}
    @include('components.navbar', ['allProfil' => $allProfil ?? []])

    <main>
        @yield('content')
    </main>

    <footer class="bg-slate-900 py-12 text-slate-400">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div class="mb-6">
                <img src="{{ asset('images/logo-poljam.png') }}" class="h-10 mx-auto grayscale opacity-50" alt="Logo">
            </div>
            <p class="text-sm tracking-widest uppercase">&copy; 2026 LPM Politeknik Jambi</p>
            <p class="text-xs mt-2 opacity-50 font-light">Internal Quality Assurance System (IQAS)</p>
        </div>
    </footer>

</body>
</html>