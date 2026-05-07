@extends('layouts.app') <!-- Pastikan ini sesuai dengan nama layout kamu -->

@section('content')
<!-- HEADER HALAMAN -->
<div class="bg-slate-50 py-20 border-b border-slate-100">
    <div class="w-full px-6 lg:px-16 text-center">
        <h1 class="font-serif-luxury text-6xl text-slate-900 leading-tight mb-4 uppercase">Visi & Misi</h1>
        <p class="text-blue-700 font-bold tracking-[0.3em] text-[10px] uppercase">Lembaga Penjaminan Mutu (LPM) Politeknik Jambi</p>
    </div>
</div>

<!-- KONTEN VISI MISI -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-50 rounded-full blur-[120px] opacity-50 -z-10"></div>
    
    <div class="w-full px-6 lg:px-16">
        <div class="flex flex-col lg:flex-row gap-16 items-start">
            
            <!-- VISI -->
            <div class="lg:w-1/3 sticky top-32">
                <div class="inline-flex items-center gap-3 py-2 px-5 bg-blue-50 rounded-full mb-6">
                    <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Core Vision</span>
                </div>
                
                <div class="group p-8 bg-slate-950 rounded-[40px] shadow-2xl transition-all duration-500">
                    <div class="text-blue-500 mb-6">
                        <i class="fas fa-quote-left text-4xl opacity-50"></i>
                    </div>
                    <p class="text-white text-xl leading-relaxed font-light italic">
                        "Terwujudnya LP3M sebagai lembaga unggul dalam pengelolaan sistem penjaminan mutu pendidikan yang berkarakter dalam kebersamaan pada tahun 2025."
                    </p>
                    <div class="mt-8 pt-6 border-t border-white/10 flex items-center gap-4">
                        <div class="w-10 h-1 bg-blue-600"></div>
                        <span class="text-white/40 uppercase tracking-widest text-[10px] font-bold">LPM POLJAM</span>
                    </div>
                </div>
            </div>

            <!-- MISI (Grid Cards) -->
            <div class="lg:w-2/3">
                <div class="grid md:grid-cols-2 gap-6">
                    @php
                        $misi = [
                            [
                                'icon' => 'fa-tasks',
                                'title' => 'Pengelolaan SPMI',
                                'desc' => 'Mengelola Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin kualitas kinerja di bidang pendidikan akademik dan vokasi.'
                            ],
                            [
                                'icon' => 'fa-microscope',
                                'title' => 'Mutu Penelitian',
                                'desc' => 'Mengelola Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin kualitas kinerja di bidang penelitian dan pengabdian kepada masyarakat.'
                            ],
                            [
                                'icon' => 'fa-university',
                                'title' => 'Tata Kelola Institusi',
                                'desc' => 'Mengelola Sistem Penjaminan Mutu Internal (SPMI) untuk menjamin tata kelola dan kinerja institusi serta unit kerja di bawahnya.'
                            ],
                            [
                                'icon' => 'fa-sync-alt',
                                'title' => 'Peningkatan Berkelanjutan',
                                'desc' => 'Mengembangkan sistem evaluasi dan monitoring secara digital untuk memastikan peningkatan mutu berkelanjutan di Politeknik Jambi.'
                            ]
                        ];
                    @endphp

                    @foreach($misi as $item)
                    <div class="p-10 bg-slate-50 rounded-[40px] border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group">
                        <div class="w-16 h-16 bg-white shadow-lg rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-700 transition-colors duration-500">
                            <i class="fas {{ $item['icon'] }} text-blue-700 group-hover:text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 tracking-tight">{{ $item['title'] }}</h4>
                        <p class="text-slate-500 leading-relaxed font-light text-sm">
                            {{ $item['desc'] }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
@endsection