<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Menangani Menu Profil Dinamis (Visi Misi, Job Desk, Artikel, dll)
     */
    public function show($slug)
    {
        // Cari data berdasarkan slug
        $profil = Profil::where('slug', $slug)->first();

        // Cek jika data tidak ada, jangan langsung error agar bisa kita debug
        if (!$profil) {
            return "Data dengan slug ($slug) tidak ditemukan di database. Coba cek tabel 'profils' kolom 'slug'.";
        }

        // UNTUK DEBUG: Hapus tanda // di bawah ini kalau mau cek isi datanya keluar atau tidak
        // dd($profil->content); 

        // Pastikan path view ini BENAR: folder 'pages' -> folder 'profil' -> file 'show.blade.php'
        return view('pages.profil.show', compact('profil'));
    }

    /**
     * Menangani Menu SPMI Dinamis
     */
    public function showSpmi($slug)
    {
        $profil = Profil::where('slug', $slug)->firstOrFail();
        return view('pages.profil.show', compact('profil'));
    }

    /**
     * Menangani Menu Akreditasi
     */
    public function akreditasiIndex() {
        return view('pages.akreditasi.index');
    }

    public function akreditasiDokumen() {
        return view('pages.akreditasi.dokumen');
    }

    /**
     * Menangani Menu Kuesioner
     */
    public function kuesionerDosen() {
        return view('pages.kuesioner.dosen');
    }

    public function kuesionerMahasiswa() {
        return view('pages.kuesioner.mahasiswa');
    }

    /**
     * Menangani Menu Galeri
     */
    public function galleryIndex() {
        return view('pages.gallery.index');
    }
}