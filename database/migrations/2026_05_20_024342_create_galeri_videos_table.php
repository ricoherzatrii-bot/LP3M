<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('galeri_videos')) {
            Schema::create('galeri_videos', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('link_youtube')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri_videos');
    }
};
