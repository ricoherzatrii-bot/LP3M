<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the kuesioner table (singular) if it doesn't exist
        if (!Schema::hasTable('kuesioner') && !Schema::hasTable('kuesioners')) {
            Schema::create('kuesioner', function (Blueprint $table) {
                $table->id();
                $table->string('judul', 255);
                $table->enum('kategori', ['Dosen & Karyawan', 'Mahasiswa']);
                $table->string('prodi', 100)->nullable();
                $table->string('tahun_akademik', 20)->default('2023/2024');
                $table->text('isi_artikel')->nullable();
                $table->text('link_embed_grafik')->nullable();
                $table->text('link_google_form')->nullable();
                $table->string('slug', 255)->nullable()->unique();
                $table->integer('hits')->default(0);
                $table->timestamps();
            });

            // Seed with original data from db_lp3m_poljam.sql
            DB::table('kuesioner')->insert([
                ['id' => 1, 'judul' => 'Kuesioner Dosen & Karyawan', 'kategori' => 'Dosen & Karyawan', 'prodi' => null, 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuesioner-dosen-karyawan', 'hits' => 1030, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 2, 'judul' => 'Kuisioner Mahasiswa - D3 Teknik Elektronika', 'kategori' => 'Mahasiswa', 'prodi' => 'D3 - Teknik Elektronika', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d3-teknik-elektronika', 'hits' => 3673, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 3, 'judul' => 'Kuisioner Mahasiswa - D3 Teknik Mesin', 'kategori' => 'Mahasiswa', 'prodi' => 'D3 - Teknik Mesin', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d3-teknik-mesin', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 4, 'judul' => 'Kuisioner Mahasiswa - D3 Teknik Listrik', 'kategori' => 'Mahasiswa', 'prodi' => 'D3 - Teknik Listrik', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d3-teknik-listrik', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 5, 'judul' => 'Kuisioner Mahasiswa - D4 Akuntansi Perpajakan', 'kategori' => 'Mahasiswa', 'prodi' => 'D4 - Akuntansi Perpajakan', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d4-akuntansi-perpajakan', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 6, 'judul' => 'Kuisioner Mahasiswa - D4 Teknologi Rekayasa Perangkat Lunak', 'kategori' => 'Mahasiswa', 'prodi' => 'D4 - TRPL', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d4-trpl', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 7, 'judul' => 'Kuisioner Mahasiswa - D4 Bisnis Digital', 'kategori' => 'Mahasiswa', 'prodi' => 'D4 - Bisnis Digital', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d4-bisnis-digital', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 8, 'judul' => 'Kuisioner Mahasiswa - D4 TRAB', 'kategori' => 'Mahasiswa', 'prodi' => 'D4 - TRAB', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d4-trab', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 9, 'judul' => 'Kuisioner Mahasiswa - D4 TRLOG', 'kategori' => 'Mahasiswa', 'prodi' => 'D4 - TRLOG', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-d4-trlog', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
                ['id' => 10, 'judul' => 'Kuisioner Mahasiswa - All Pages', 'kategori' => 'Mahasiswa', 'prodi' => 'Semua Prodi', 'tahun_akademik' => '2023/2024', 'isi_artikel' => null, 'link_embed_grafik' => null, 'link_google_form' => null, 'slug' => 'kuisioner-mahasiswa-all-pages', 'hits' => 0, 'created_at' => '2026-05-04 07:01:24', 'updated_at' => '2026-05-04 07:01:24'],
            ]);
        } elseif (Schema::hasTable('kuesioners')) {
            // If old plural table exists, rename it
            Schema::rename('kuesioners', 'kuesioner');
        }

        // 2. Create kuesioner_pertanyaan table (singular) if it doesn't exist
        if (!Schema::hasTable('kuesioner_pertanyaan') && !Schema::hasTable('kuesioner_pertanyaans')) {
            Schema::create('kuesioner_pertanyaan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kuesioner_id');
                $table->text('pertanyaan');
                $table->enum('tipe_jawaban', ['skala_likert', 'teks', 'pilihan_ganda'])->default('skala_likert');
                $table->text('opsi_jawaban')->nullable();
                $table->integer('urutan')->default(0);
                $table->timestamps();

                $table->foreign('kuesioner_id')->references('id')->on('kuesioner')->onDelete('cascade');
            });
        } elseif (Schema::hasTable('kuesioner_pertanyaans')) {
            Schema::rename('kuesioner_pertanyaans', 'kuesioner_pertanyaan');
        }

        // 3. Create kuesioner_response table (singular) if it doesn't exist
        if (!Schema::hasTable('kuesioner_response') && !Schema::hasTable('kuesioner_responses')) {
            Schema::create('kuesioner_response', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kuesioner_id');
                $table->unsignedBigInteger('pertanyaan_id');
                $table->text('jawaban');
                $table->string('session_id')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamps();

                $table->foreign('kuesioner_id')->references('id')->on('kuesioner')->onDelete('cascade');
                $table->foreign('pertanyaan_id')->references('id')->on('kuesioner_pertanyaan')->onDelete('cascade');
            });
        } elseif (Schema::hasTable('kuesioner_responses')) {
            Schema::rename('kuesioner_responses', 'kuesioner_response');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kuesioner_response');
        Schema::dropIfExists('kuesioner_pertanyaan');
        Schema::dropIfExists('kuesioner');
    }
};
