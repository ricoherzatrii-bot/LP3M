@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-slate-50 py-20">
    <div class="container mx-auto px-4 text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 font-playfair inline-block relative">
            {{ $profil->judul }}
            <div class="absolute -bottom-2 left-0 w-full h-1 bg-blue-600 rounded-full"></div>
        </h1>
    </div>

    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-2xl shadow-blue-900/5 p-8 md:p-12 border-t-8 border-blue-700">
            <div class="prose prose-slate max-w-none prose-h3:text-blue-800 prose-li:list-disc">
                {!! $profil->isi_konten !!}
            </div>
        </div>
    </div>
</section>
@endsection