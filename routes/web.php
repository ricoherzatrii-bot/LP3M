<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN UTAMA ---
Route::get('/', function () {
    $allProfil = \App\Models\Profil::all();
    return view('welcome', compact('allProfil'));
})->name('home');

// --- HALAMAN ARTIKEL ---
Route::get('/artikel', [ProfilController::class, 'artikelIndex'])->name('artikel.index');
Route::get('/artikel/{kategori}', [ProfilController::class, 'artikelKategori'])->name('artikel.kategori');


// --- RUTE PROFIL (Dinamis) ---
// Rute ini menangani Visi Misi, Struktur Organisasi, dll
Route::get('/profil/{slug}', [ProfilController::class, 'show'])->name('profil.show');


// --- RUTE SPMI ---
// Jika SPMI punya halaman index sendiri, tambahkan ini:
Route::get('/spmi', function() { return view('pages.spmi.index'); })->name('spmi.index');
// Untuk detail dokumen SPMI secara dinamis
Route::get('/spmi/{slug}', [ProfilController::class, 'showSpmi'])->name('spmi.show');


// --- RUTE AKREDITASI ---
Route::get('/akreditasi', [ProfilController::class, 'akreditasiIndex'])->name('akreditasi.index');
Route::get('/akreditasi/dokumen', [ProfilController::class, 'akreditasiDokumen'])->name('akreditasi.dokumen');


// --- RUTE CAPAIAN ---
Route::get('/capaian/{slug}', [ProfilController::class, 'showCapaian'])->name('capaian.show');


// --- RUTE KUESIONER ---
// Halaman utama kuesioner (jika ada)
Route::get('/kuesioner', function() { return view('pages.kuesioner.index'); })->name('kuesioner.index');
Route::get('/kuesioner/dosen', [ProfilController::class, 'kuesionerDosen'])->name('kuesioner.dosen');
Route::get('/kuesioner/mahasiswa', [ProfilController::class, 'kuesionerMahasiswa'])->name('kuesioner.mahasiswa');


// --- RUTE LAINNYA ---
Route::get('/galeri', [ProfilController::class, 'galleryIndex'])->name('gallery.index');
Route::get('/galeri/video', [ProfilController::class, 'galleryVideo'])->name('gallery.video');

// Rute Login (Sesuaikan jika kamu menggunakan Laravel Breeze/Jetstream)
Route::get('/login', function() { 
    return view('auth.login'); 
})->name('login');