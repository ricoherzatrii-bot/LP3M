<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif;
            background: radial-gradient(circle at top left, rgba(56, 189, 248, 0.22), transparent 20%),
                        radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 18%),
                        linear-gradient(180deg, #0b1120 0%, #111827 100%);
        }
        .toggle-password {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 9999px;
            background: rgba(255,255,255,0.02);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            transition: background .15s ease, transform .08s ease;
            z-index: 20;
        }
        .toggle-password:hover { background: rgba(255,255,255,0.04); transform: translateY(-1px); }
        .toggle-password i { color: rgba(203,213,225,0.9); font-size: 14px; }
    </style>
</head>
<body class="min-h-screen px-4 py-10 text-slate-100">
    <div class="max-w-7xl mx-auto">
        <div class="rounded-[32px] border border-white/10 bg-slate-950/85 shadow-[0_35px_110px_rgba(15,23,42,0.35)] backdrop-blur-xl">
            <div class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-700 px-8 py-10 rounded-t-[32px] shadow-lg shadow-slate-950/10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-200/70">Dashboard Backend</p>
                        <h1 class="mt-3 text-3xl font-black tracking-tight text-white">Manajemen Pengguna</h1>
                        <p class="mt-2 max-w-2xl text-sm text-slate-200/80">Tambah, edit, dan kelola akun pengguna backend dengan tampilan konsisten seperti halaman dashboard.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <button id="toggleCreateUser" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-slate-950/10 transition hover:bg-slate-100">Tambah Pengguna Baru</button>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/10 transition hover:bg-white/10">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>

            <div class="px-6 py-8 sm:px-10">
                @if (session('success'))
                    <div class="mb-6 rounded-[28px] border border-emerald-400/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-100 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-[28px] border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-100 shadow-sm">
                        <p class="font-semibold">Terjadi kesalahan:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5 text-rose-100/90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[1.45fr_0.95fr]">
                    <section class="rounded-[28px] border border-white/10 bg-slate-950/85 p-6 shadow-[0_30px_70px_rgba(15,23,42,0.22)]">
                        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-white">Daftar Pengguna</h2>
                                <p class="mt-1 text-sm text-slate-400">Klik Detail untuk membuka panel edit pengguna.</p>
                            </div>
                            <div class="rounded-3xl bg-slate-900/90 px-4 py-2 text-sm text-slate-300">Total pengguna: {{ $users->count() }}</div>
                        </div>

                        <div class="overflow-hidden rounded-[24px] border border-slate-800 bg-slate-950/90">
                            <table class="min-w-full text-left text-sm text-slate-300">
                                <thead class="bg-slate-900/90 text-slate-400">
                                    <tr>
                                        <th class="px-5 py-4">Nama</th>
                                        <th class="px-5 py-4">Username</th>
                                        <th class="px-5 py-4">Email</th>
                                        <th class="px-5 py-4">Admin</th>
                                        <th class="px-5 py-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="border-b border-slate-800 bg-slate-950/80 hover:bg-slate-900/80">
                                            <td class="px-5 py-4 font-medium text-white">{{ $user->name }}</td>
                                            <td class="px-5 py-4">{{ $user->username }}</td>
                                            <td class="px-5 py-4">{{ $user->email }}</td>
                                            <td class="px-5 py-4">{{ $user->is_admin ? 'Ya' : 'Tidak' }}</td>
                                            <td class="px-5 py-4">
                                                <button type="button" data-target="user-detail-{{ $user->id }}" class="toggleDetail rounded-full border border-slate-700 bg-slate-900/90 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-slate-500 hover:bg-slate-800">Detail</button>
                                            </td>
                                        </tr>
                                        <tr class="bg-slate-950/95 hidden" id="user-detail-{{ $user->id }}">
                                            <td colspan="5" class="px-5 py-5">
                                                <div class="space-y-5 rounded-[28px] border border-white/10 bg-slate-900/95 p-6 shadow-[0_25px_70px_rgba(15,23,42,0.18)]">
                                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                                        <div>
                                                            <h3 class="text-lg font-semibold text-white">Detail Pengguna</h3>
                                                            <p class="text-sm text-slate-400">Ubah nama, username, email, atau password pengguna.</p>
                                                        </div>
                                                        <button type="button" data-target="user-detail-{{ $user->id }}" class="closeDetail rounded-2xl border border-slate-700 bg-slate-900/90 px-4 py-2 text-sm text-slate-200 transition hover:bg-slate-800">Tutup</button>
                                                    </div>
                                                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid gap-4 md:grid-cols-2">
                                                            <div>
                                                                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Nama</label>
                                                                <input type="text" name="name" value="{{ $user->name }}" required class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                                            </div>
                                                            <div>
                                                                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Username</label>
                                                                <input type="text" name="username" value="{{ $user->username }}" required class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                                            </div>
                                                            <div>
                                                                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Email</label>
                                                                <input type="email" name="email" value="{{ $user->email }}" required class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                                            </div>
                                                            <div>
                                                                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Password Lama</label>
                                                                <div class="relative">
                                                                    <input id="old-password-{{ $user->id }}" type="password" name="old_password" value="{{ $user->password_plain }}" autocomplete="new-password" placeholder="Isi untuk verifikasi (opsional)" class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                                                    <button type="button" data-target="old-password-{{ $user->id }}" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Password Baru</label>
                                                                <div class="relative">
                                                                    <input id="password-{{ $user->id }}" type="password" name="password" autocomplete="new-password" placeholder="Kosongkan jika tidak ingin ubah" class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                                                    <button type="button" data-target="password-{{ $user->id }}" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer">
                                                                        <i class="fa fa-eye"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label class="flex items-center gap-3 text-sm text-slate-300">
                                                            <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-sky-500 focus:ring-sky-500" />
                                                            Jadikan admin
                                                        </label>
                                                        <div class="flex flex-wrap items-center gap-3">
                                                            <button type="submit" class="rounded-3xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-400">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                    @if (Auth::user()->id !== $user->id)
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" class="mt-3 flex justify-end">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="rounded-3xl bg-rose-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">Hapus Pengguna</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <aside class="space-y-6">
                        <div class="rounded-[28px] border border-white/10 bg-slate-950/85 p-6 shadow-[0_30px_90px_rgba(15,23,42,0.2)]" id="createUserPanel" style="display: none;">
                            <div class="mb-6 flex items-center justify-between gap-3">
                                <div>
                                    <h2 class="text-lg font-semibold text-white">Buat Pengguna Baru</h2>
                                    <p class="text-sm text-slate-400">Form ini hanya muncul saat tombol tambah diklik.</p>
                                </div>
                                <button id="closeCreateUser" type="button" class="rounded-2xl border border-slate-700 bg-slate-900/90 px-4 py-2 text-sm text-slate-200 transition hover:bg-slate-800">Tutup</button>
                            </div>
                            <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Nama</label>
                                    <input type="text" name="name" required class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Username</label>
                                    <input type="text" name="username" required class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Email</label>
                                    <input type="email" name="email" required class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Password</label>
                                    <div class="relative">
                                        <input id="create-password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-3xl border border-slate-700 bg-slate-950/90 px-4 py-3 text-white outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20" />
                                        <button type="button" data-target="create-password" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <label class="flex items-center gap-3 text-sm text-slate-300">
                                    <input type="checkbox" name="is_admin" value="1" class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-sky-500 focus:ring-sky-500" />
                                    Jadikan admin
                                </label>
                                <button type="submit" class="w-full rounded-3xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-400">Simpan Pengguna</button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleCreateUser').addEventListener('click', function() {
            document.getElementById('createUserPanel').style.display = 'block';
            this.disabled = true;
        });

        document.getElementById('closeCreateUser').addEventListener('click', function() {
            document.getElementById('createUserPanel').style.display = 'none';
            document.getElementById('toggleCreateUser').disabled = false;
        });

        document.querySelectorAll('.toggleDetail').forEach(function(button) {
            button.addEventListener('click', function() {
                var target = document.getElementById(this.dataset.target);
                if (target) {
                    target.classList.toggle('hidden');
                }
            });
        });

        document.querySelectorAll('.closeDetail').forEach(function(button) {
            button.addEventListener('click', function() {
                var target = document.getElementById(this.dataset.target);
                if (target) {
                    target.classList.add('hidden');
                }
            });
        });

        // Password visibility toggles for dynamic inputs (existing buttons)
        document.querySelectorAll('.toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetId = this.dataset.target;
                var input = document.getElementById(targetId);
                if (!input) return;
                var icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
                } else {
                    input.type = 'password';
                    if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
                }
            });
        });

        // Auto-insert toggle buttons for any password inputs that don't have one
        (function() {
            var pwInputs = Array.from(document.querySelectorAll('input[type="password"]'));
            var counter = 0;
            pwInputs.forEach(function(input) {
                // if parent contains an existing .toggle-password, skip
                var parent = input.parentElement;
                if (!parent) return;
                if (parent.querySelector('.toggle-password')) return;

                // ensure the parent is positioned so absolute button works
                var parentStyle = window.getComputedStyle(parent);
                if (parentStyle.position === 'static') {
                    parent.style.position = 'relative';
                }

                // ensure input has id
                if (!input.id) {
                    input.id = 'auto-pw-' + (counter++);
                }

                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 cursor-pointer';
                btn.setAttribute('data-target', input.id);
                btn.setAttribute('aria-label', 'Toggle password visibility');
                btn.innerHTML = '<i class="fa fa-eye"></i>';

                parent.appendChild(btn);

                btn.addEventListener('click', function() {
                    var inputEl = document.getElementById(this.dataset.target);
                    var icon = this.querySelector('i');
                    if (!inputEl) return;
                    if (inputEl.type === 'password') {
                        inputEl.type = 'text';
                        if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
                    } else {
                        inputEl.type = 'password';
                        if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
                    }
                });
            });
        })();
    </script>
</body>
</html>
