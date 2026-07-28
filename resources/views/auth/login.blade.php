<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Masuk |Politeknik Jambi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif; 
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="inline-block bg-white p-3 rounded-2xl shadow-2xl mb-6">
                <img src="{{ asset('/images/logo-poljam.png') }}" alt="Logo Poljam" class="h-16 w-auto">
            </div>
            <h1 class="text-white text-2xl font-extrabold tracking-tight">PORTAL LOGIN</h1>
            <p class="text-blue-300/60 text-sm font-semibold uppercase tracking-[0.2em] mt-2">Politeknik Jambi</p>
        </div>

        <!-- Kartu Login -->
        <div class="glass-effect rounded-[32px] p-10 shadow-2xl">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                @if ($errors->any())
                    <div class="rounded-xl border border-red-400/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div>
                    <label class="block text-blue-100 text-xs font-extrabold uppercase tracking-widest mb-2 ml-1">Nama Pengguna / NIP</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-400">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        <input type="text" name="username" required
                            class="block w-full pl-11 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Masukkan nama pengguna Anda">
                    </div>
                </div>

                <div>
                    <label class="block text-blue-100 text-xs font-extrabold uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="login-password" type="password" name="password" required
                            class="block w-full pl-11 pr-10 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="••••••••">
                        <button type="button" id="toggleLoginPassword" aria-label="Toggle password visibility" class="absolute inset-y-0 right-2 flex items-center text-blue-300">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-extrabold py-4 rounded-2xl shadow-lg shadow-blue-900/50 transform transition active:scale-[0.98]">
                    MASUK KE SISTEM
                </button>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-10">
            <a href="{{ route('home') }}" class="text-blue-300/50 hover:text-white text-xs font-bold transition uppercase tracking-widest">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
            <p class="text-[10px] text-blue-100/20 font-bold uppercase tracking-[0.3em] mt-8">
                &copy; 2026 Lembaga Penjamin Mutu Politeknik Jambi
            </p>
        </div>
    </div>

</body>
<script>
    (function() {
        var toggle = document.getElementById('toggleLoginPassword');
        var input = document.getElementById('login-password');
        if (toggle && input) {
            toggle.addEventListener('click', function() {
                if (input.type === 'password') {
                    input.type = 'text';
                    this.querySelector('i').classList.remove('fa-eye');
                    this.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.querySelector('i').classList.remove('fa-eye-slash');
                    this.querySelector('i').classList.add('fa-eye');
                }
            });
        }
    })();
</script>
</html>
</html>