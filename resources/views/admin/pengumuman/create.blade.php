<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengumuman - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .form-input { transition: border-color 0.3s, box-shadow 0.3s; }
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-800">➕ Tambah Pengumuman Baru</h1>
            <p class="text-slate-500 mt-2">Isi form di bawah untuk menambahkan pengumuman baru</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul -->
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fas fa-heading mr-2"></i> Judul Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" id="judul" class="form-input w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none @error('judul') border-red-500 @enderror" 
                           placeholder="Masukkan judul pengumuman" value="{{ old('judul') }}" required>
                    @error('judul')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Konten -->
                <div class="mb-6">
                    <label for="isi_konten" class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fas fa-file-alt mr-2"></i> Isi Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi_konten" id="isi_konten" class="form-input w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none @error('isi_konten') border-red-500 @enderror" 
                              placeholder="Masukkan isi konten pengumuman" rows="10" required>{{ old('isi_konten') }}</textarea>
                    <script>
                        CKEDITOR.replace('isi_konten', {
                            height: 400,
                            toolbar: [
                                ['Bold', 'Italic', 'Underline', 'Strike'],
                                ['NumberedList', 'BulletedList'],
                                ['Link', 'Unlink'],
                                ['Image'],
                                ['Undo', 'Redo']
                            ]
                        });
                    </script>
                    @error('isi_konten')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-6">
                    <label for="gambar" class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fas fa-image mr-2"></i> Gambar Fitur
                    </label>
                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 cursor-pointer hover:border-blue-500 transition" onclick="document.getElementById('gambar').click()">
                        <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*" onchange="previewImage(event)">
                        <div class="text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-slate-400 mb-2 block"></i>
                            <p class="text-slate-600 font-medium">Klik untuk upload gambar</p>
                            <p class="text-slate-500 text-sm">atau drag & drop gambar di sini</p>
                            <p class="text-slate-400 text-xs mt-2">Maksimal 2MB (JPEG, PNG, GIF)</p>
                        </div>
                    </div>
                    <div id="preview" class="mt-4"></div>
                    @error('gambar')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fas fa-toggle-on mr-2"></i> Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" class="form-input w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none @error('status') border-red-500 @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 mt-8">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Pengumuman
                    </button>
                    <a href="{{ route('admin.pengumuman.index') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-800 px-6 py-3 rounded-lg font-semibold transition flex items-center">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('admin.pengumuman.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pengumuman
            </a>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="relative inline-block">
                            <img src="${e.target.result}" alt="Preview" class="rounded-lg max-h-64">
                            <button type="button" onclick="clearImage()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        }

        function clearImage() {
            document.getElementById('gambar').value = '';
            document.getElementById('preview').innerHTML = '';
        }
    </script>
</body>
</html>
