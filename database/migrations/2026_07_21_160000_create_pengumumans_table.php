<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pengumumans')) {
            Schema::create('pengumumans', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('isi_konten');
                $table->string('slug');
                $table->string('gambar')->nullable();
                $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
                $table->string('kategori')->default('Pengumuman');
                $table->integer('hits')->default(0);
                $table->timestamps();
                
                // Add index for queries
                $table->index('slug');
                $table->index('status');
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
    }
};
