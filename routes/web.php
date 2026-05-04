<?php

use Illuminate\Support\Facades\Route;

// Rute Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rute Halaman Login
Route::get('/login', function () {
    // Validasi fisik: Pastikan file ada di resources/views/auth/login.blade.php
    return view('auth.login'); 
})->name('login')->middleware('guest');

// Rute Proses Login
Route::post('/login', function () {
    // Implementasikan logic auth di sini (misal: Auth::attempt)
})->name('login.post');