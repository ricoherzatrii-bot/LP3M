@extends('layouts.app')
@section('title', 'Galeri Foto - Politeknik Jambi')
@section('content')

<div class="relative min-h-screen bg-slate-50 dark:bg-slate-950 pb-24 font-sans overflow-hidden transition-colors duration-500">
    {{-- ===== BACKGROUND ===== --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gedung-poljam.png') }}"
             class="w-full h-full object-cover opacity-5 dark:opacity-20 transition-opacity duration-500" alt="Politeknik Jambi">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-50/90 dark:from-slate-950 via-slate-50/50 dark:via-slate-900/80 to-slate-50 dark:to-slate-950 transition-colors duration-500"></div>
    </div>

    {{-- ===== HERO HEADER ===== --}}
    <div class="relative z-10 pt-20 pb-16 text-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-16">
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white mb-4 tracking-tighter" style="font-family: 'Arial', sans-serif;">
                GALERI <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">AKTIVITAS</span>
            </h1>
            <p class="text-slate-400 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Dokumentasi visual berbagai kegiatan akademik dan non-akademik di lingkungan Politeknik Jambi.
            </p>
        </div>
    </div>

    {{-- ===== TABS NAV ===== --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16 mb-12">
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('gallery.index') }}" 
               class="px-8 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-500 {{ Route::is('gallery.index') ? 'bg-blue-600 text-white shadow-[0_15px_30px_rgba(37,99,235,0.4)] scale-105' : 'bg-white dark:bg-white/5 text-slate-500 dark:text-slate-500 border border-slate-200 dark:border-white/5 hover:bg-slate-100 dark:hover:bg-white/10' }}">
                <i class="fas fa-image mr-2 text-sm"></i> Foto
            </a>
            <a href="{{ route('gallery.video') }}" 
               class="px-8 py-3.5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-500 {{ Route::is('gallery.video') ? 'bg-blue-600 text-white shadow-[0_15px_30px_rgba(37,99,235,0.4)] scale-105' : 'bg-white dark:bg-white/5 text-slate-500 dark:text-slate-500 border border-slate-200 dark:border-white/5 hover:bg-slate-100 dark:hover:bg-white/10' }}">
                <i class="fas fa-video mr-2 text-sm"></i> Video
            </a>
        </div>
    </div>

    {{-- ===== ALBUM GRID ===== --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16 pt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
            @foreach($albums as $album)
            <div class="group relative bg-white dark:bg-slate-800/40 backdrop-blur-xl rounded-[2.5rem] border border-slate-200 dark:border-white/5 overflow-hidden hover:border-blue-500/30 transition-all duration-700 hover:-translate-y-3 hover:shadow-[0_30px_60px_rgba(0,0,0,0.1)] dark:hover:shadow-[0_30px_60px_rgba(0,0,0,0.4)]">
                {{-- Cover Image --}}
                <div class="relative aspect-[4/3] overflow-hidden">
                    @php
                        $coverUrl = asset('images/gedung-poljam.png');
                        if ($album->sampul_foto) {
                            $coverUrl = str_starts_with($album->sampul_foto, 'http') ? $album->sampul_foto : asset('storage/gallery/' . $album->sampul_foto);
                        } elseif ($album->firstFoto) {
                            $coverUrl = str_starts_with($album->firstFoto->file_path, 'http')
                                ? $album->firstFoto->file_path
                                : asset('storage/gallery/' . $album->firstFoto->file_path);
                        }
                    @endphp
                    <img src="{{ $coverUrl }}" 
                         alt="{{ $album->nama_album }}" 
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                         onerror="this.src='{{ asset('images/gedung-poljam.png') }}'">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-80"></div>
                </div>

                {{-- Card Content --}}
                <div class="p-8 pb-10">
                    <div class="flex items-center gap-3 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-4">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $album->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 tracking-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $album->nama_album }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-2 mb-8 opacity-70">
                        Dokumentasi lengkap kegiatan {{ strtolower($album->nama_album) }} di kampus Politeknik Jambi.
                    </p>
                    
                    <div class="flex items-center justify-between border-t border-white/5 pt-6">
                        <div class="flex items-center gap-2 text-slate-500 text-[10px] font-black uppercase tracking-widest">
                            <i class="fas fa-camera-retro text-xs"></i>
                            <span>{{ $album->fotos->count() }} Foto</span>
                        </div>
                        <button onclick="openGallery({{ $album->id }}, '{{ addslashes($album->nama_album) }}')" 
                                class="bg-blue-600/10 hover:bg-blue-600 text-blue-400 hover:text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all hover:shadow-lg hover:shadow-blue-500/20 active:scale-95">
                            Buka Album
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Lightbox Overlay --}}
<div id="lightbox" class="fixed inset-0 z-[100] bg-slate-950/98 backdrop-blur-2xl hidden flex-col transition-all duration-500 opacity-0 translate-y-10">
    <div class="p-8 flex justify-between items-center relative z-10 border-b border-white/5">
        <div>
            <h4 id="lightboxTitle" class="text-white font-black text-2xl tracking-tighter" style="font-family: 'Arial', sans-serif;">Album Title</h4>
            <div class="flex items-center gap-3 text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-2">
                <span class="text-blue-500">Galeri Foto</span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                <span id="photoCount">0 Foto</span>
            </div>
        </div>
        <button onclick="closeGallery()" class="w-14 h-14 rounded-3xl bg-white/5 border border-white/10 text-white hover:bg-rose-500 hover:border-rose-400 flex items-center justify-center transition-all hover:rotate-90">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto p-6 md:p-16 custom-scrollbar">
        <div id="photosGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-8">
            <!-- Photos will be loaded here -->
        </div>
    </div>
</div>

<script>
    function openGallery(albumId, title) {
        const lightbox = document.getElementById('lightbox');
        const grid = document.getElementById('photosGrid');
        const titleEl = document.getElementById('lightboxTitle');
        const countEl = document.getElementById('photoCount');

        titleEl.innerText = title;
        grid.innerHTML = '<div class="col-span-full py-40 text-center"><i class="fas fa-spinner fa-spin text-blue-500 text-5xl"></i><p class="text-slate-500 font-bold uppercase tracking-widest text-[10px] mt-6">Menyiapkan Foto...</p></div>';
        
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        setTimeout(() => {
            lightbox.classList.remove('opacity-0', 'translate-y-10');
        }, 10);
        document.body.style.overflow = 'hidden';

        fetch(`/admin/galeri-album/${albumId}/photos`)
            .then(r => r.json())
                    .then(res => {
                if (res.success) {
                    countEl.innerText = res.data.length + ' Foto';
                    grid.innerHTML = res.data.map((p, i) => {
                        const photoUrl = p.file_path.startsWith('http') ? p.file_path : '/storage/gallery/' + p.file_path;
                        const title = p.judul ? p.judul : '';
                        const description = p.deskripsi ? p.deskripsi : '';
                        // escape single quotes for inline onclick
                        const escTitle = (title || '').replace(/'/g, "\\'");
                        const escDesc = (description || '').replace(/'/g, "\\'");
                        return `
                        <div class="group relative aspect-square rounded-[1.5rem] overflow-hidden border border-white/5 cursor-pointer bg-slate-900/50" 
                             style="animation: emerge 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) ${i * 0.05}s both;"
                             onclick="enlargeImage('${photoUrl}', '${escTitle}', '${escDesc}')">
                            <img src="${photoUrl}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                            <div class="p-3 bg-white/5 text-white flex flex-col gap-1">
                                ${title ? `<div class="text-sm font-semibold truncate text-white">${title}</div>` : ''}
                                ${description ? `<div class="text-[11px] text-slate-200 line-clamp-2">${description}</div>` : ''}
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-600/40 text-white opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center scale-75 group-hover:scale-100 transition-transform duration-500">
                                    <i class="fas fa-expand-alt text-xl"></i>
                                </div>
                            </div>
                        </div>
                    `;
                    }).join('') || '<div class="col-span-full py-20 text-center text-slate-500 font-bold uppercase tracking-widest text-xs">Album ini belum memiliki foto.</div>';
                }
            })
            .catch(() => {
                grid.innerHTML = '<div class="col-span-full py-20 text-center text-rose-500 font-bold uppercase tracking-widest text-xs">Gagal memuat foto.</div>';
            });
    }

    function closeGallery() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('opacity-0', 'translate-y-10');
        setTimeout(() => {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
        }, 500);
        document.body.style.overflow = '';
    }

    function enlargeImage(src, title, description) {
        const html = `
            <div class="w-full flex flex-col items-center gap-4">
                <img src="${src}" class="max-h-[70vh] w-auto rounded-2xl shadow-2xl border border-white/10" />
                ${description ? `<div class="text-sm text-slate-200 max-w-3xl text-left">${description}</div>` : ''}
            </div>
        `;

        Swal.fire({
            title: title || '',
            html: html,
            showConfirmButton: false,
            background: 'transparent',
            backdrop: 'rgba(0,0,0,0.98)',
            width: '95%',
            showCloseButton: true,
            customClass: {
                popup: 'bg-transparent',
            }
        });
    }
</script>

<style>
    
    @keyframes emerge {
        from { opacity: 0; transform: scale(0.7) translateY(40px) rotate(-5deg); }
        to { opacity: 1; transform: scale(1) translateY(0) rotate(0); }
    }
    
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
</style>
@endsection
