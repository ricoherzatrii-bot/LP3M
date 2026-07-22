<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengumuman - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .table-hover:hover { background-color: #f0f9ff; transition: background-color 0.2s; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-slate-800">📢 Kelola Pengumuman</h1>
                <p class="text-slate-500 mt-2">Tambah, edit, atau hapus pengumuman di sistem</p>
            </div>
            <a href="{{ route('admin.pengumuman.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition">
                <i class="fas fa-plus mr-2"></i> Tambah Pengumuman
            </a>
        </div>

        <!-- Success Alert -->
        @if ($message = Session::get('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <div>
                        <p class="text-green-700 font-semibold">Berhasil!</p>
                        <p class="text-green-600">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            @if ($pengumumans->count() > 0)
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left">No</th>
                            <th class="px-6 py-4 text-left">Judul</th>
                            <th class="px-6 py-4 text-left">Tanggal</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Views</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengumumans as $idx => $pengumuman)
                            <tr class="table-hover border-b border-slate-200">
                                <td class="px-6 py-4 text-slate-700">{{ $idx + 1 }}</td>
                                <td class="px-6 py-4 text-slate-700 font-medium">{{ $pengumuman->judul }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $pengumuman->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="@if($pengumuman->status === 'aktif') bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif px-3 py-1 rounded-full text-sm font-medium">
                                        {{ ucfirst($pengumuman->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $pengumuman->hits }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded inline-flex items-center mr-2 text-sm transition">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm transition">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-folder-open text-6xl text-slate-300 mb-4"></i>
                    <p class="text-slate-500 text-lg">Belum ada pengumuman</p>
                    <a href="{{ route('admin.pengumuman.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i> Tambah Pengumuman Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($pengumumans->hasPages())
            <div class="mt-6">
                {{ $pengumumans->links() }}
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
