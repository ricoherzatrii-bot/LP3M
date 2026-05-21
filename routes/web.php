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
    $sliderItems = \App\Models\Profil::latest()->take(5)->get();
    return view('welcome', compact('allProfil', 'sliderItems'));
})->name('home');

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
Route::get('/capaian/{slug}', [ProfilController::class, 'showCapaian'])->name('capaian.show');

// --- RUTE KUESIONER ---
Route::get('/kuesioner', function() { return view('pages.kuesioner.index'); })->name('kuesioner.index');
Route::get('/kuesioner/dosen', [ProfilController::class, 'kuesionerDosen'])->name('kuesioner.dosen');
Route::get('/kuesioner/mahasiswa', [ProfilController::class, 'kuesionerMahasiswa'])->name('kuesioner.mahasiswa');

// --- RUTE LAINNYA ---
Route::get('/galeri', [ProfilController::class, 'galleryIndex'])->name('gallery.index');
Route::get('/galeri/video', [ProfilController::class, 'galleryVideo'])->name('gallery.video');


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
Route::get('/profil', [ProfilController::class, 'index'])->name('admin.profil.index');
Route::post('/profil', [ProfilController::class, 'store'])->name('admin.profil.store');

// ============================================
// --- SISTEM MANAJEMEN DOKUMEN SPMI ---
// ============================================
Route::get('/admin/dokumen-spmi', [\App\Http\Controllers\DokumenSpmiController::class, 'index'])->name('admin.dokumen_spmi.index');
Route::post('/admin/dokumen-spmi/upload', [\App\Http\Controllers\DokumenSpmiController::class, 'store'])->name('admin.dokumen_spmi.store');
Route::post('/admin/dokumen-spmi/{id}/update', [\App\Http\Controllers\DokumenSpmiController::class, 'update'])->name('admin.dokumen_spmi.update');
Route::delete('/admin/dokumen-spmi/{id}', [\App\Http\Controllers\DokumenSpmiController::class, 'destroy'])->name('admin.dokumen_spmi.destroy');
Route::get('/dokumen-spmi/{id}/download', [\App\Http\Controllers\DokumenSpmiController::class, 'download'])->name('dokumen_spmi.download');

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
Route::post('/admin/renstra/import', [\App\Http\Controllers\RenstraController::class, 'import'])->name('admin.renstra.import');
Route::delete('/admin/renstra/truncate', [\App\Http\Controllers\RenstraController::class, 'truncate'])->name('admin.renstra.truncate');