<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('dokumen_spmi')) {
            Schema::create('dokumen_spmi', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->year('tahun');
                $table->text('deskripsi')->nullable();
                $table->string('nama_file')->nullable();
                $table->string('path_file')->nullable();
                $table->string('ukuran_file')->nullable();
                $table->string('tipe_file')->nullable();
                $table->string('kategori')->default('Dokumen SPMI');
                $table->string('slug')->nullable();
                $table->integer('downloads')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_spmi');
    }
};
