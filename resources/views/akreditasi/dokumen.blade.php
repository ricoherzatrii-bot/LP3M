@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 pt-32 pb-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-blue-600 block mb-2">Supporting Documents</span>
                <h1 class="text-4xl font-black text-slate-900 uppercase tracking-tighter">
                    Dokumen Pendukung Akreditasi
                </h1>
                <p class="text-slate-500 mt-2">
                    Unduh instrumen, panduan, dan pedoman resmi untuk akreditasi dari lembaga penjaminan mutu.
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl border border-slate-100 shadow-sm self-start">
                <i class="fas fa-shield-alt text-blue-600 text-sm"></i>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">LPM Official Repository</span>
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
                // Cek jika field file_dokumen berisi URL website eksternal
                $isFileUrl = str_starts_with($item->file_dokumen, 'http://') || str_starts_with($item->file_dokumen, 'https://');
                $externalUrl = $externalLinks[$item->judul] ?? ($isFileUrl ? $item->file_dokumen : null);
            @endphp
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-pdf text-xl"></i>
                    </div>
                    <a href="{{ $externalUrl ?? asset('documents/' . $item->file_dokumen) }}" 
                       {{ $externalUrl ? 'target="_blank"' : 'download' }}
                       class="block group-hover:text-blue-600 transition-colors">
                        <h3 class="font-extrabold text-lg text-slate-900 mb-2 leading-snug">
                            {{ $item->judul }}
                        </h3>
                    </a>
                    <p class="text-slate-400 text-xs uppercase tracking-widest font-bold mb-4">
                        Kategori: {{ $item->kategori }}
                    </p>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs text-slate-400 font-medium">Format: PDF Document</span>
                    <a href="{{ $externalUrl ?? asset('documents/' . $item->file_dokumen) }}" 
                       {{ $externalUrl ? 'target="_blank"' : 'download' }} 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition active:scale-95 shadow-md shadow-blue-100">
                        @if($externalUrl)
                            <i class="fas fa-external-link-alt"></i> Kunjungi Website
                        @else
                            <i class="fas fa-download"></i> Unduh File
                        @endif
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white py-16 px-6 text-center rounded-3xl border border-slate-100 shadow-sm text-slate-400">
                <div class="flex flex-col items-center justify-center gap-3">
                    <i class="fas fa-folder-open text-4xl opacity-30"></i>
                    <span class="font-bold text-slate-700">Belum Ada Dokumen Pendukung</span>
                    <span class="text-xs text-slate-400">Silakan hubungi administrator LPM untuk mengunggah dokumen baru.</span>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
