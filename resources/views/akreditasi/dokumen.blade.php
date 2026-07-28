@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-32 pb-20 transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400 block mb-2">Supporting Documents</span>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">
                    Dokumen Pendukung Akreditasi
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2">
                    Unduh instrumen, panduan, dan pedoman resmi untuk akreditasi dari lembaga penjaminan mutu.
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-900/80 px-5 py-3 rounded-2xl border border-slate-100 dark:border-white/10 shadow-sm self-start transition-colors duration-500">
                <i class="fas fa-shield-alt text-blue-600 dark:text-blue-400 text-sm"></i>
                <span class="text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider">LPM Official Repository</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($data as $item)
            @php
                // Mapping judul ke link portal resmi (LP3M Poljam)
                $externalLinks = [
                    'Pedoman Akreditasi PT' => 'https://www.banpt.or.id/?page_id=35',
                    'Pedoman Akreditasi LAMTEKNIK' => 'https://lamteknik.or.id/akreditasi/instrumen-akreditasi/',
                    'Pedoman Akreditasi LAMINFOKOM' => 'https://laminfokom.or.id/official/instrumen1.html',
                    'Pedoman Akreditasi LAMEMBA' => 'https://lamemba.or.id/instrumen-akreditasi/',
                ];
                $logoDomains = [
                    'Pedoman Akreditasi PT' => 'www.banpt.or.id',
                    'Pedoman Akreditasi LAMTEKNIK' => 'lamteknik.or.id',
                    'Pedoman Akreditasi LAMINFOKOM' => 'laminfokom.or.id',
                    'Pedoman Akreditasi LAMEMBA' => 'lamemba.or.id',
                ];
                // Cek jika field file_dokumen berisi URL website eksternal
                $isFileUrl = str_starts_with($item->file_dokumen, 'http://') || str_starts_with($item->file_dokumen, 'https://');
                $externalUrl = $externalLinks[$item->judul] ?? ($isFileUrl ? $item->file_dokumen : null);
                $logoUrl = isset($logoDomains[$item->judul])
                    ? 'https://www.google.com/s2/favicons?domain=' . $logoDomains[$item->judul] . '&sz=128'
                    : null;
                $fotoUrl = $item->foto_logo
                    ? (str_starts_with($item->foto_logo, 'http://') || str_starts_with($item->foto_logo, 'https://')
                        ? $item->foto_logo
                        : asset('storage/' . $item->foto_logo))
                    : $logoUrl;
            @endphp
            <div class="bg-white dark:bg-slate-900/70 p-8 rounded-3xl border border-slate-100 dark:border-white/10 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-[100px] h-[100px] bg-red-50 dark:bg-rose-500/10 text-red-500 dark:text-rose-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        @if($fotoUrl)
                            <img src="{{ $fotoUrl }}" alt="Logo {{ $item->judul }}" class="w-[100px] h-[100px] object-contain" onerror="this.hidden=true; this.nextElementSibling.hidden=false;">
                        @endif
                        <i class="fas fa-file-pdf text-xl" @if($fotoUrl) hidden @endif></i>
                    </div>
                    <a href="{{ $externalUrl ?? asset('documents/' . $item->file_dokumen) }}" 
                       {{ $externalUrl ? 'target="_blank"' : 'download' }}
                       class="block group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        <h3 class="font-extrabold text-lg text-slate-900 dark:text-white mb-2 leading-snug">
                            {{ $item->judul }}
                        </h3>
                    </a>
                    <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-widest font-bold mb-4">
                        Kategori: {{ $item->kategori }}
                    </p>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-50 dark:border-white/10 flex items-center justify-between">
                    <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Format: PDF Document</span>
                    <a href="{{ $externalUrl ?? asset('documents/' . $item->file_dokumen) }}" 
                       {{ $externalUrl ? 'target="_blank"' : 'download' }} 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 dark:bg-blue-500 text-white text-xs font-bold hover:bg-blue-700 dark:hover:bg-blue-400 transition active:scale-95 shadow-md shadow-blue-100 dark:shadow-blue-950/30">
                        @if($externalUrl)
                            <i class="fas fa-external-link-alt"></i> Kunjungi Website
                        @else
                            <i class="fas fa-download"></i> Unduh File
                        @endif
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white dark:bg-slate-900/70 py-16 px-6 text-center rounded-3xl border border-slate-100 dark:border-white/10 shadow-sm text-slate-400 dark:text-slate-500 transition-colors duration-500">
                <div class="flex flex-col items-center justify-center gap-3">
                    <i class="fas fa-folder-open text-4xl opacity-30"></i>
                    <span class="font-bold text-slate-700 dark:text-slate-200">Belum Ada Dokumen Pendukung</span>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Silakan hubungi administrator LPM untuk mengunggah dokumen baru.</span>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
