<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop unused tables
        Schema::dropIfExists('capaians');
        Schema::dropIfExists('spmis');

        // Rename tables if they exist
        if (Schema::hasTable('akreditasis')) {
            Schema::rename('akreditasis', 'akreditasi');
        }
        if (Schema::hasTable('artikels')) {
            Schema::rename('artikels', 'artikel');
        }
        if (Schema::hasTable('galeri_albums')) {
            Schema::rename('galeri_albums', 'galeri_album');
        }
        if (Schema::hasTable('galeri_fotos')) {
            Schema::rename('galeri_fotos', 'galeri_foto');
        }
        if (Schema::hasTable('galeri_videos')) {
            Schema::rename('galeri_videos', 'galeri_video');
        }
        if (Schema::hasTable('kuesioner_dosen_karyawans')) {
            Schema::rename('kuesioner_dosen_karyawans', 'kuesioner_dosen_karyawan');
        }
        if (Schema::hasTable('kuesioner_mahasiswas')) {
            Schema::rename('kuesioner_mahasiswas', 'kuesioner_mahasiswa');
        }
        if (Schema::hasTable('profils')) {
            Schema::rename('profils', 'profil');
        }
        if (Schema::hasTable('sliders')) {
            Schema::rename('sliders', 'slider');
        }
    }

    public function down(): void
    {
        // Revert rename
        if (Schema::hasTable('akreditasi')) {
            Schema::rename('akreditasi', 'akreditasis');
        }
        if (Schema::hasTable('artikel')) {
            Schema::rename('artikel', 'artikels');
        }
        if (Schema::hasTable('galeri_album')) {
            Schema::rename('galeri_album', 'galeri_albums');
        }
        if (Schema::hasTable('galeri_foto')) {
            Schema::rename('galeri_foto', 'galeri_fotos');
        }
        if (Schema::hasTable('galeri_video')) {
            Schema::rename('galeri_video', 'galeri_videos');
        }
        if (Schema::hasTable('kuesioner_dosen_karyawan')) {
            Schema::rename('kuesioner_dosen_karyawan', 'kuesioner_dosen_karyawans');
        }
        if (Schema::hasTable('kuesioner_mahasiswa')) {
            Schema::rename('kuesioner_mahasiswa', 'kuesioner_mahasiswas');
        }
        if (Schema::hasTable('profil')) {
            Schema::rename('profil', 'profils');
        }
        if (Schema::hasTable('slider')) {
            Schema::rename('slider', 'sliders');
        }
    }
};
