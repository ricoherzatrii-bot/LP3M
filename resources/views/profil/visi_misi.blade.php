@extends('layouts.app')

@section('content')
<!-- Hero Section / Header -->
<div class="relative bg-slate-900 py-24 overflow-hidden">
    <!-- Dekorasi Background -->
    <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 translate-y-12 -translate-x-12 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
        <nav class="flex justify-center mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm font-medium text-blue-400 uppercase tracking-widest">
                <li>Profil</li>
                <li><i class="fas fa-chevron-right text-[10px] mx-2 text-slate-600"></i></li>
                <li class="text-slate-300">Visi & Misi</li>
            </ol>
        </nav>
        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-4">
            Visi & <span class="text-blue-500">Misi LP3M</span>
        </h1>
        <p class="text-slate-400 max-w-2xl mx-auto text-lg font-light">
            Lembaga Penjaminan Mutu (LPM) Politeknik Jambi berkomitmen menjaga standar kualitas pendidikan tinggi yang unggul dan berkelanjutan.
        </p>
    </div>
</div>

<!-- Content Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Sisi Kiri: Visi (Sticky) -->
            <div class="lg:w-2/5">
                <div class="sticky top-32">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="h-1 w-12 bg-blue-600 rounded-full"></span>
                        <span class="text-blue-600 font-bold text-sm uppercase tracking-widest">The Vision</span>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-8 leading-tight">
                        Menjadi Pusat Penjaminan <br> Mutu yang <span class="italic text-blue-600 font-serif">Akurat & Terpercaya</span>
                    </h2>
                    
                    <div class="relative p-10 bg-slate-50 rounded-[2rem] border border-slate-100 shadow-xl shadow-blue-900/5">
                        <i class="fas fa-quote-left text-4xl text-blue-200 absolute top-8 left-8"></i>
                        <p class="relative z-10 text-xl text-slate-700 leading-relaxed italic font-medium">
                            "Terwujudnya LP3M sebagai lembaga unggul dalam pengelolaan sistem penjaminan mutu pendidikan yang berkarakter dalam kebersamaan pada tahun 2025."
                        </p>
                        <div class="mt-8 flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-university"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">LPM Poljam</p>
                                <p class="text-xs text-slate-500 uppercase tracking-tighter">Politeknik Jambi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sisi Kanan: Misi (List) -->
            <div class="lg:w-3/5">
                <div class="flex items-center gap-2 mb-6">
                    <span class="h-1 w-12 bg-blue-600 rounded-full"></span>
                    <span class="text-blue-600 font-bold text-sm uppercase tracking-widest">Our Mission</span>
                </div>
                
                <div class="space-y-6">
                    @php
                        $misi_items = [
                            [
                                'icon' => 'fa-tasks',
                                'title' => 'Pengelolaan SPMI Pendidikan',
                                'desc' => 'Mengelola Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin kualitas kinerja di bidang pendidikan akademik dan vokasi.'
                            ],
                            [
                                'icon' => 'fa-microscope',
                                'title' => 'Mutu Penelitian & Pengabdian',
                                'desc' => 'Menjamin kualitas kinerja di bidang penelitian dan pengabdian kepada masyarakat melalui pengawasan standar yang ketat.'
                            ],
                            [
                                'icon' => 'fa-shield-alt',
                                'title' => 'Tata Kelola Institusi',
                                'desc' => 'Menjamin tata kelola dan kinerja institusi serta seluruh unit kerja di bawah naungan Politeknik Jambi.'
                            ],
                            [
                                'icon' => 'fa-chart-line',
                                'title' => 'Peningkatan Berkelanjutan',
                                'desc' => 'Membangun budaya mutu melalui evaluasi mandiri dan tindakan korektif demi kemajuan institusi yang terukur.'
                            ]
                        ];
                    @endphp

                    @foreach($misi_items as $index => $item)
                    <div class="group flex gap-6 p-8 bg-white border border-slate-100 rounded-[2rem] hover:shadow-2xl hover:shadow-blue-900/10 hover:border-blue-100 transition-all duration-500">
                        <div class="flex-shrink-0 w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 shadow-inner">
                            <i class="fas {{ $item['icon'] }} text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-slate-900 mb-2">{{ $item['title'] }}</h4>
                            <p class="text-slate-500 leading-relaxed">
                                {{ $item['desc'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Footer Content / Call to Action -->
<section class="pb-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="bg-blue-600 rounded-[3rem] p-12 text-center text-white relative overflow-hidden shadow-2xl shadow-blue-500/40">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
            <h3 class="text-3xl font-bold mb-4 relative z-10">Membangun Budaya Mutu Bersama</h3>
            <p class="text-blue-100 mb-8 max-w-xl mx-auto font-light relative z-10 text-lg">
                Kepuasan stakeholder adalah prioritas utama kami dalam mewujudkan pendidikan vokasi yang berdaya saing global.
            </p>
            <a href="{{ route('akreditasi.index') }}" class="relative z-10 bg-white text-blue-600 px-8 py-4 rounded-full font-bold hover:bg-slate-100 transition-colors inline-flex items-center gap-2">
                Lihat Data Akreditasi <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
@endsection