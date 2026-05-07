@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-slate-50 py-20">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <div class="bg-slate-900 p-8 md:p-12 text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white font-playfair">{{ $profil->judul }}</h1>
                <p class="text-blue-400 mt-2 font-bold uppercase tracking-widest text-xs">LPM Politeknik Jambi</p>
            </div>
            
            <div class="p-8 md:p-12">
                <!-- Wrapper untuk konten/gambar struktur -->
                <div class="flex justify-center">
                    <div class="prose prose-slate max-w-none overflow-x-auto">
                        {!! $profil->isi_konten !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection