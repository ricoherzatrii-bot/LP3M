<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- RUTE PROFIL (Dinamis dari Database) ---
// Kita gunakan rute dinamis agar data visi-misi diambil dari controller & DB
Route::get('/profil/{slug}', [ProfilController::class, 'show'])->name('profil.show');

// RUTE SPMI
Route::get('/spmi/{slug}', [ProfilController::class, 'showSpmi'])->name('spmi.show');

// RUTE AKREDITASI
Route::get('/akreditasi', [ProfilController::class, 'akreditasiIndex'])->name('akreditasi.index');
Route::get('/akreditasi/dokumen', [ProfilController::class, 'akreditasiDokumen'])->name('akreditasi.dokumen');

// RUTE KUESIONER
Route::get('/kuesioner/dosen', [ProfilController::class, 'kuesionerDosen'])->name('kuesioner.dosen');
Route::get('/kuesioner/mahasiswa', [ProfilController::class, 'kuesionerMahasiswa'])->name('kuesioner.mahasiswa');

// RUTE LAINNYA
Route::get('/galeri', [ProfilController::class, 'galleryIndex'])->name('gallery.index');
Route::get('/login', function() { return view('auth.login'); })->name('login');