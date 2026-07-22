@extends('layouts.app')
@section('title', 'Renop - Politeknik Jambi')
@section('content')

<div class="relative min-h-screen bg-white dark:bg-slate-950 pt-8 pb-24 font-sans overflow-hidden transition-colors duration-500">
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-16">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4">Renop</h1>
        <p class="text-slate-500 mb-8">Daftar Renop yang dikelola oleh LPM Politeknik Jambi. Klik "Baca Dokumen" untuk membuka, atau gunakan "Unduh" untuk mendapatkan salinan (jika tersedia).</p>

        <div class="grid md:grid-cols-2 gap-6">
            @forelse($items as $item)
            @php
                $excerpt = strip_tags($item->deskripsi ?? '');
                $excerpt = \Illuminate\Support\Str::limit($excerpt, 220);
                $rawLink = trim($item->link_file ?? '');
                if (\Illuminate\Support\Str::startsWith($rawLink, ['http://','https://'])) {
                    $href = $rawLink;
                } elseif (\Illuminate\Support\Str::startsWith($rawLink, 'www.')) {
                    $href = 'https://' . $rawLink;
                } else {
                    $href = $rawLink ? asset('storage/' . ltrim($rawLink, '/')) : '#';
                }
            @endphp
            <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex gap-4">
                    <div class="w-28 flex-shrink-0 flex items-center justify-center bg-white rounded-lg border border-slate-200">
                        <div class="text-center p-2">
                            <i class="fas fa-file-pdf text-4xl text-red-600"></i>
                            <div class="text-[11px] font-bold text-slate-600 mt-2">DOKUMEN</div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $item->judul }}</h3>
                        <div class="text-sm text-slate-600 mb-4">{{ $excerpt }}</div>
                        <div class="flex items-center gap-3">
                            <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-full font-bold text-sm flex items-center gap-2">
                                <i class="fas fa-eye"></i> Baca Dokumen
                            </a>
                            <a href="{{ route('capaian.download', $item->id) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-full font-bold text-sm flex items-center gap-2">
                                <i class="fas fa-download"></i> Unduh / Ambil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-20 text-slate-500 font-bold">Belum ada data Renop yang terdaftar.</div>
            @endforelse
        </div>

    </div>
</div>

@endsection
