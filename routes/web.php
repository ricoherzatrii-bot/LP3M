<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN UTAMA (FRONT-END) ---
// Mengarah ke halaman depan dulu
Route::get('/', function () {
    $allProfil = \App\Models\Profil::all();
    $sliders = \App\Models\Slider::orderBy('urutan', 'asc')->get();
    
    $sliderItems = collect();
    if ($sliders->count() > 0) {
        foreach($sliders as $s) {
            $sliderItems->push((object)[
                'judul' => $s->judul,
                'subjudul' => $s->sub_judul,
                'gambar' => $s->gambar,
                'url' => $s->link_url ?? '#',
                'is_external' => true
            ]);
        }
    } else {
        // Fallback ke Artikel
        $articles = \App\Models\Artikel::latest()->take(5)->get();
        foreach($articles as $a) {
            $sliderItems->push((object)[
                'judul' => $a->judul,
                'subjudul' => Str::limit(strip_tags($a->isi_konten), 100),
                'gambar' => $a->gambar_fitur,
                'url' => route('berita.show', $a->slug),
                'is_external' => false,
                'created_at' => $a->created_at
            ]);
        }
    }

    $beritaList = \App\Models\Artikel::latest()->paginate(6);
    return view('welcome', compact('allProfil', 'sliderItems', 'beritaList'));
})->name('home');

// --- HALAMAN DETAIL BERITA ---
Route::get('/berita/{slug}', function ($slug) {
    $allProfil = \App\Models\Profil::all();
    $berita = \App\Models\Artikel::where('slug', $slug)->firstOrFail();
    $recentBerita = \App\Models\Artikel::where('id', '!=', $berita->id)->latest()->take(5)->get();
    return view('pages.berita.show', compact('allProfil', 'berita', 'recentBerita'));
})->name('berita.show');

// --- HALAMAN ARTIKEL ---
Route::get('/artikel', [ProfilController::class, 'artikelIndex'])->name('artikel.index');
Route::get('/artikel/{kategori}', [ProfilController::class, 'artikelKategori'])->name('artikel.kategori');

// --- RUTE PENCARIAN ---
Route::get('/search', [ProfilController::class, 'search'])->name('search');

// --- RUTE PROFIL (Dinamis Front-End) ---
Route::get('/profil/{slug}', [ProfilController::class, 'show'])->name('profil.show');

// --- RUTE SPMI ---
Route::get('/spmi', function() { return view('pages.spmi.index'); })->name('spmi.index');
// Rute spesifik harus SEBELUM wildcard {slug}
Route::get('/spmi/dokumen-spmi', [\App\Http\Controllers\ProfilController::class, 'dokumenSpmiPublic'])->name('spmi.dokumen');
Route::get('/spmi/{slug}', [ProfilController::class, 'showSpmi'])->name('spmi.show');

// --- RUTE AKREDITASI ---
Route::get('/akreditasi', [ProfilController::class, 'akreditasiIndex'])->name('akreditasi.index');
Route::get('/akreditasi/dokumen', [ProfilController::class, 'akreditasiDokumen'])->name('akreditasi.dokumen');

// --- RUTE CAPAIAN ---
Route::get('/capaian-renstra', [\App\Http\Controllers\RenstraController::class, 'publicIndex'])->name('renstra.publicIndex');
Route::get('/capaian/laporan-ami', [\App\Http\Controllers\ProfilController::class, 'laporanAmiPublic'])->name('capaian.laporan_ami');
Route::get('/capaian/rtm', [\App\Http\Controllers\ProfilController::class, 'rtmPublic'])->name('capaian.rtm');
// Dedicated Renop listing (maps to category 'Renop')
Route::get('/capaian/renop', [ProfilController::class, 'renopIndex'])->name('capaian.renop');

// Download helper for Capaian entries (will redirect for external links or stream local files)
Route::get('/capaian/download/{id}', [ProfilController::class, 'downloadCapaian'])->name('capaian.download');

Route::get('/capaian/{slug}', [ProfilController::class, 'showCapaian'])->name('capaian.show');

// --- RUTE KUESIONER ---
Route::get('/kuesioner', function() { return view('pages.kuesioner.index'); })->name('kuesioner.index');
Route::get('/kuesioner/dosen', [ProfilController::class, 'kuesionerDosen'])->name('kuesioner.dosen');
Route::get('/kuesioner/mahasiswa', [ProfilController::class, 'kuesionerMahasiswa'])->name('kuesioner.mahasiswa');

// --- RUTE LAINNYA ---
Route::get('/galeri', [ProfilController::class, 'galleryIndex'])->name('gallery.index');
Route::get('/galeri/video', [ProfilController::class, 'galleryVideo'])->name('gallery.video');

// --- RUTE PENGUMUMAN ---
Route::get('/pengumuman', [\App\Http\Controllers\PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [\App\Http\Controllers\PengumumanController::class, 'show'])->name('pengumuman.show');


// ==========================================
// --- HALAMAN LOGIN & BACK-END (DASHBOARD) ---
// ==========================================

// Jalur untuk membuka halaman Login
Route::get('/login', function() { 
    return view('auth.login'); 
})->name('login');

// Jalur untuk memproses login (mengarahkan langsung ke back-end)
Route::post('/login', function() {
    return redirect()->route('dashboard');
})->name('login.post');

// Jalur halaman utama Dashboard setelah login
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// API Admin untuk olah database dinamis di dashboard
Route::get('/admin/page-data', [App\Http\Controllers\DashboardController::class, 'getPageData'])->name('admin.page_data');
Route::post('/admin/save-page-data', [App\Http\Controllers\DashboardController::class, 'savePageData'])->name('admin.save_page_data');
Route::post('/admin/add-row', [App\Http\Controllers\DashboardController::class, 'addRow'])->name('admin.add_row');
Route::post('/admin/delete-row', [App\Http\Controllers\DashboardController::class, 'deleteRow'])->name('admin.delete_row');

// Fitur Olah Profil di dalam Back-End Admin
Route::get('/profil', [ProfilController::class, 'indexAdmin'])->name('admin.profil.index');
Route::post('/profil', [ProfilController::class, 'store'])->name('admin.profil.store');
Route::get('/profil/create', [ProfilController::class, 'create'])->name('admin.profil.create');
Route::post('/profil/save', [ProfilController::class, 'saveData'])->name('admin.profil.save');
Route::get('/profil/{id}/edit', [ProfilController::class, 'edit'])->name('admin.profil.edit');
Route::post('/profil/{id}/update', [ProfilController::class, 'update'])->name('admin.profil.update');
Route::delete('/profil/{id}', [ProfilController::class, 'destroy'])->name('admin.profil.destroy');

// ============================================
// --- SISTEM MANAJEMEN DOKUMEN SPMI ---
// ============================================
Route::get('/admin/dokumen-spmi', [\App\Http\Controllers\DokumenSpmiController::class, 'index'])->name('admin.dokumen_spmi.index');
Route::post('/admin/dokumen-spmi/upload', [\App\Http\Controllers\DokumenSpmiController::class, 'store'])->name('admin.dokumen_spmi.store');
Route::post('/admin/dokumen-spmi/{id}/update', [\App\Http\Controllers\DokumenSpmiController::class, 'update'])->name('admin.dokumen_spmi.update');
Route::delete('/admin/dokumen-spmi/{id}', [\App\Http\Controllers\DokumenSpmiController::class, 'destroy'])->name('admin.dokumen_spmi.destroy');
Route::get('/dokumen-spmi/{id}/download', [\App\Http\Controllers\DokumenSpmiController::class, 'download'])->name('dokumen_spmi.download');

// ============================================
// --- SISTEM MANAJEMEN LAPORAN AMI ---
// ============================================
Route::get('/admin/laporan-ami', [\App\Http\Controllers\LaporanAmiController::class, 'index'])->name('admin.laporan_ami.index');
Route::post('/admin/laporan-ami/upload', [\App\Http\Controllers\LaporanAmiController::class, 'store'])->name('admin.laporan_ami.store');
Route::post('/admin/laporan-ami/{id}/update', [\App\Http\Controllers\LaporanAmiController::class, 'update'])->name('admin.laporan_ami.update');
Route::delete('/admin/laporan-ami/{id}', [\App\Http\Controllers\LaporanAmiController::class, 'destroy'])->name('admin.laporan_ami.destroy');
Route::get('/laporan-ami/{id}/download', [\App\Http\Controllers\LaporanAmiController::class, 'download'])->name('laporan_ami.download');

// ============================================
// --- SISTEM MANAJEMEN RTM ---
// ============================================
Route::get('/admin/rtm', [\App\Http\Controllers\RtmController::class, 'index'])->name('admin.rtm.index');
Route::post('/admin/rtm/upload', [\App\Http\Controllers\RtmController::class, 'store'])->name('admin.rtm.store');
Route::post('/admin/rtm/{id}/update', [\App\Http\Controllers\RtmController::class, 'update'])->name('admin.rtm.update');
Route::delete('/admin/rtm/{id}', [\App\Http\Controllers\RtmController::class, 'destroy'])->name('admin.rtm.destroy');
Route::get('/rtm/{id}/download', [\App\Http\Controllers\RtmController::class, 'download'])->name('rtm.download');

// --- SISTEM MANAJEMEN SLIDER HOMEPAGE ---
Route::get('/admin/slider', [\App\Http\Controllers\SliderController::class, 'index'])->name('admin.slider.index');
Route::post('/admin/slider', [\App\Http\Controllers\SliderController::class, 'store'])->name('admin.slider.store');
Route::post('/admin/slider/{id}/update', [\App\Http\Controllers\SliderController::class, 'update'])->name('admin.slider.update');
Route::delete('/admin/slider/{id}', [\App\Http\Controllers\SliderController::class, 'destroy'])->name('admin.slider.destroy');

// (Rute publik dokumen SPMI sudah dipindah ke bagian RUTE SPMI di atas)

// ============================================
// --- SISTEM MANAJEMEN GALERI (FOTO & VIDEO) ---
// ============================================
Route::get('/admin/galeri-album', [\App\Http\Controllers\GaleriController::class, 'getAlbums'])->name('admin.galeri_album.index');
Route::post('/admin/galeri-album/upload', [\App\Http\Controllers\GaleriController::class, 'uploadAlbum'])->name('admin.galeri_album.store');
Route::post('/admin/galeri-album/{id}/update', [\App\Http\Controllers\GaleriController::class, 'updateAlbum'])->name('admin.galeri_album.update');
Route::delete('/admin/galeri-album/{id}', [\App\Http\Controllers\GaleriController::class, 'deleteAlbum'])->name('admin.galeri_album.destroy');
Route::get('/admin/galeri-album/{album_id}/photos', [\App\Http\Controllers\GaleriController::class, 'getPhotos']);
Route::post('/admin/galeri-album/{album_id}/photos/upload', [\App\Http\Controllers\GaleriController::class, 'uploadPhotos']);
Route::delete('/admin/galeri-foto/{id}', [\App\Http\Controllers\GaleriController::class, 'deletePhoto']);

Route::get('/admin/galeri-video', [\App\Http\Controllers\GaleriController::class, 'getVideos'])->name('admin.galeri_video.index');
Route::post('/admin/galeri-video/upload', [\App\Http\Controllers\GaleriController::class, 'uploadVideo'])->name('admin.galeri_video.store');
Route::post('/admin/galeri-video/{id}/update', [\App\Http\Controllers\GaleriController::class, 'updateVideo'])->name('admin.galeri_video.update');
Route::delete('/admin/galeri-video/{id}', [\App\Http\Controllers\GaleriController::class, 'deleteVideo'])->name('admin.galeri_video.destroy');

// ============================================
// --- SISTEM MANAJEMEN CAPAIAN RENSTRA ---
// ============================================
Route::get('/admin/renstra', [\App\Http\Controllers\RenstraController::class, 'index'])->name('admin.renstra.index');
Route::post('/admin/renstra/store', [\App\Http\Controllers\RenstraController::class, 'store'])->name('admin.renstra.store');
Route::post('/admin/renstra/{id}/update', [\App\Http\Controllers\RenstraController::class, 'update'])->name('admin.renstra.update');
Route::delete('/admin/renstra/delete/{id}', [\App\Http\Controllers\RenstraController::class, 'destroy'])->name('admin.renstra.destroy');
Route::post('/admin/renstra/import', [\App\Http\Controllers\RenstraController::class, 'import'])->name('admin.renstra.import');
Route::delete('/admin/renstra/truncate', [\App\Http\Controllers\RenstraController::class, 'truncate'])->name('admin.renstra.truncate');
Route::get('/admin/renstra/template', [\App\Http\Controllers\RenstraController::class, 'downloadTemplate'])->name('admin.renstra.template');
Route::get('/api/renstra/indicator-stats', [\App\Http\Controllers\RenstraController::class, 'getIndicatorStats'])->name('renstra.indicator_stats');
Route::post('/api/renstra/bulk-update', [\App\Http\Controllers\RenstraController::class, 'bulkUpdate'])->name('renstra.bulk_update');

// ============================================
// --- SISTEM MANAJEMEN PERTANYAAN KUESIONER ---
// ============================================
Route::get('/admin/kuesioner/{id}/pertanyaan', [\App\Http\Controllers\KuesionerPertanyaanController::class, 'index'])->name('admin.kuesioner.pertanyaan.index');
Route::post('/admin/kuesioner/pertanyaan', [\App\Http\Controllers\KuesionerPertanyaanController::class, 'store'])->name('admin.kuesioner.pertanyaan.store');
Route::post('/admin/kuesioner/pertanyaan/{id}/update', [\App\Http\Controllers\KuesionerPertanyaanController::class, 'update'])->name('admin.kuesioner.pertanyaan.update');
Route::delete('/admin/kuesioner/pertanyaan/{id}', [\App\Http\Controllers\KuesionerPertanyaanController::class, 'destroy'])->name('admin.kuesioner.pertanyaan.destroy');

// Public: Submit Kuesioner Response
Route::post('/kuesioner/submit', [\App\Http\Controllers\KuesionerPertanyaanController::class, 'submitResponse'])->name('kuesioner.submit');

// ============================================
// --- MANAJEMEN KUESIONER DOSEN & KARYAWAN ---
// ============================================
Route::get('/admin/kuesioner-dosen/data', [\App\Http\Controllers\KuesionerDosenKaryawanController::class, 'index'])->name('admin.kuesioner_dosen.index');
Route::post('/admin/kuesioner-dosen/store', [\App\Http\Controllers\KuesionerDosenKaryawanController::class, 'store'])->name('admin.kuesioner_dosen.store');
Route::post('/admin/kuesioner-dosen/{id}/update', [\App\Http\Controllers\KuesionerDosenKaryawanController::class, 'update'])->name('admin.kuesioner_dosen.update');
Route::delete('/admin/kuesioner-dosen/truncate', [\App\Http\Controllers\KuesionerDosenKaryawanController::class, 'truncate'])->name('admin.kuesioner_dosen.truncate');
Route::delete('/admin/kuesioner-dosen/{id}', [\App\Http\Controllers\KuesionerDosenKaryawanController::class, 'destroy'])->name('admin.kuesioner_dosen.destroy');
Route::post('/admin/kuesioner-dosen/import', [\App\Http\Controllers\KuesionerDosenKaryawanController::class, 'import'])->name('admin.kuesioner_dosen.import');

// ============================================
// --- SISTEM MANAJEMEN PENGUMUMAN (API) ---
// ============================================
Route::get('/api/pengumuman/all', [\App\Http\Controllers\PengumumanController::class, 'getAll'])->name('api.pengumuman.all');
Route::post('/api/pengumuman/store', [\App\Http\Controllers\PengumumanController::class, 'store'])->name('api.pengumuman.store');
Route::post('/api/pengumuman/{id}/update', [\App\Http\Controllers\PengumumanController::class, 'update'])->name('api.pengumuman.update');
Route::delete('/api/pengumuman/{id}', [\App\Http\Controllers\PengumumanController::class, 'destroy'])->name('api.pengumuman.destroy');

// ============================================
// --- SISTEM MANAJEMEN PENGUMUMAN (Legacy) ---
// ============================================
Route::get('/admin/pengumuman', [\App\Http\Controllers\PengumumanController::class, 'adminIndex'])->name('admin.pengumuman.index');
Route::get('/admin/pengumuman/create', [\App\Http\Controllers\PengumumanController::class, 'create'])->name('admin.pengumuman.create');
Route::post('/admin/pengumuman', [\App\Http\Controllers\PengumumanController::class, 'store'])->name('admin.pengumuman.store');
Route::get('/admin/pengumuman/{pengumuman}/edit', [\App\Http\Controllers\PengumumanController::class, 'edit'])->name('admin.pengumuman.edit');
Route::post('/admin/pengumuman/{pengumuman}/update', [\App\Http\Controllers\PengumumanController::class, 'update'])->name('admin.pengumuman.update');
Route::delete('/admin/pengumuman/{pengumuman}', [\App\Http\Controllers\PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');

Route::get('/admin/kuesioner-dosen/stats', [\App\Http\Controllers\KuesionerDosenKaryawanController::class, 'getStats'])->name('admin.kuesioner_dosen.stats');