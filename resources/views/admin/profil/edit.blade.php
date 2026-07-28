<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Profil - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-800">✏️ Edit Data Profil</h1>
            <p class="text-slate-500 mt-2">Ubah informasi data profil yang sudah ada</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.profil.update', $profil->id) }}" method="POST">
                @csrf

                <!-- Judul -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">
                        <i class="fas fa-heading mr-2 text-blue-600"></i> Judul
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $profil->judul) }}" required 
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-blue-600 focus:outline-none transition @error('judul') border-red-500 @enderror"
                        placeholder="Masukkan judul profil">
                    @error('judul')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">
                        <i class="fas fa-folder mr-2 text-blue-600"></i> Kategori
                    </label>
                    <select name="kategori" required
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-blue-600 focus:outline-none transition @error('kategori') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $profil->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">
                        <i class="fas fa-link mr-2 text-blue-600"></i> Slug <span class="text-slate-500 text-sm">(opsional, auto-generate dari judul jika kosong)</span>
                    </label>
                    <input type="text" name="slug" value="{{ old('slug', $profil->slug) }}"
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-blue-600 focus:outline-none transition @error('slug') border-red-500 @enderror"
                        placeholder="contoh: visi-dan-misi">
                    @error('slug')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penulis -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2 text-blue-600"></i> Penulis <span class="text-slate-500 text-sm">(opsional)</span>
                    </label>
                    <input type="text" name="penulis" value="{{ old('penulis', $profil->penulis) }}"
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-blue-600 focus:outline-none transition"
                        placeholder="Nama penulis/kontributor">
                </div>

                <!-- Isi Konten -->
                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">
                        <i class="fas fa-file-alt mr-2 text-blue-600"></i> Isi Konten
                    </label>
                    <textarea name="isi_konten" id="isi_konten" required
                        class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-blue-600 focus:outline-none transition @error('isi_konten') border-red-500 @enderror"
                        placeholder="Tulis isi konten di sini...">{{ old('isi_konten', $profil->isi_konten) }}</textarea>
                    @error('isi_konten')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-4 pt-6 border-t border-slate-200">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition flex-1">
                        <i class="fas fa-save mr-2"></i> Update Data Profil
                    </button>
                    <a href="{{ route('admin.profil.index') }}" class="bg-slate-400 hover:bg-slate-500 text-white px-8 py-3 rounded-lg font-semibold transition flex-1 text-center">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
            <p class="text-blue-700">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Dibuat:</strong> {{ $profil->created_at->format('d M Y H:i') }}
            </p>
        </div>

        <!-- Back Link -->
        <div class="mt-8">
            <a href="{{ route('admin.profil.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Profil
            </a>
        </div>
    </div>

    <script>
        // Initialize TinyMCE untuk editor rich text
        tinymce.init({
            selector: '#isi_konten',
            height: 400,
            plugins: 'link image code lists',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image code',
            automatic_uploads: true,
            images_upload_handler: function (blobInfo, success, failure) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.upload_content_image') }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.responseType = 'json';
                xhr.onload = function() {
                    const json = xhr.response;
                    if (xhr.status !== 200 || !json || !json.url) {
                        failure(json?.message || 'Gagal mengunggah gambar.');
                        return;
                    }
                    success(json.url);
                };
                xhr.onerror = function() {
                    failure('Gagal mengunggah gambar.');
                };
                const formData = new FormData();
                formData.append('upload', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
            content_css: 'default',
            branding: false,
        });

        // Auto-generate slug dari judul
        document.querySelector('input[name="judul"]').addEventListener('keyup', function() {
            const slugField = document.querySelector('input[name="slug"]');
            if (slugField.value === '') {
                slugField.value = this value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '');
            }
        });
    </script>
</body>
</html>
