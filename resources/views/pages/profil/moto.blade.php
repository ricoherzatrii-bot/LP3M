@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-16">
            <h1 class="text-4xl font-black text-slate-900 mb-4 font-playfair">{{ $profil->judul }}</h1>
            <p class="text-slate-500 italic uppercase tracking-widest text-sm font-bold">LPM Politeknik Jambi</p>
        </div>

        <div class="max-w-4xl mx-auto bg-blue-50 rounded-[2rem] p-8 md:p-16 border border-blue-100 relative overflow-hidden">
            <!-- Dekorasi Icon -->
            <i class="fas fa-quote-right absolute -bottom-10 -right-10 text-blue-100 text-9xl"></i>
            
            <div class="relative z-10 prose prose-blue prose-xl max-w-none text-slate-700">
                {!! $profil->isi_konten !!}
            </div>
        </div>
    </div>
</section>
@endsection