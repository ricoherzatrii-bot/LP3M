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
    return view('welcome', compact('allProfil'));
})->name('home');

// --- HALAMAN ARTIKEL ---
Route::get('/artikel', [ProfilController::class, 'artikelIndex'])->name('artikel.index');
Route::get('/artikel/{kategori}', [ProfilController::class, 'artikelKategori'])->name('artikel.kategori');

// --- RUTE PROFIL (Dinamis Front-End) ---
Route::get('/profil/{slug}', [ProfilController::class, 'show'])->name('profil.show');

// --- RUTE SPMI ---
Route::get('/spmi', function() { return view('pages.spmi.index'); })->name('spmi.index');
Route::get('/spmi/{slug}', [ProfilController::class, 'showSpmi'])->name('spmi.show');

// --- RUTE AKREDITASI ---
Route::get('/akreditasi', [ProfilController::class, 'akreditasiIndex'])->name('akreditasi.index');
Route::get('/akreditasi/dokumen', [ProfilController::class, 'akreditasiDokumen'])->name('akreditasi.dokumen');

// --- RUTE CAPAIAN ---
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Fitur Olah Profil di dalam Back-End Admin
Route::get('/profil', [ProfilController::class, 'index'])->name('admin.profil.index');
Route::post('/profil', [ProfilController::class, 'store'])->name('admin.profil.store');