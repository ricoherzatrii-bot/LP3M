<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('capaians')) {
            Schema::create('capaians', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->enum('kategori', ['Renop', 'Capaian Renstra', 'Kepuasan Mahasiswa', 'Kepuasan Dosen Dan Tendik']);
                $table->string('sub_kategori')->nullable();
                $table->text('deskripsi')->nullable();
                $table->decimal('persentase_capaian', 5, 2)->nullable();
                $table->string('file_dokumen')->nullable();
                $table->string('link_file')->nullable();
                $table->string('slug')->nullable();
                $table->integer('hits')->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('capaians', function (Blueprint $table) {
                if (!Schema::hasColumn('capaians', 'link_file')) {
                    $table->string('link_file')->nullable()->after('file_dokumen');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('capaians');
    }
};
