@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-32 pb-20 transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-4 uppercase tracking-tighter">
            Sistem Penjaminan Mutu Internal (SPMI)
        </h1>
        <p class="text-slate-600 mb-12 max-w-2xl">
            Halaman ini berisi dokumen dan standar mutu internal Politeknik Jambi.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-100 dark:border-white/10 shadow-sm">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 dark:text-white mb-2">Dokumen Kebijakan</h3>
                <p class="text-sm text-slate-500 mb-6">Kebijakan mutu yang menjadi landasan utama SPMI.</p>
                <a href="#" class="text-blue-600 font-bold text-sm uppercase tracking-wider">Lihat Dokumen →</a>
            </div>
            </div>
    </div>
</div>
@endsection