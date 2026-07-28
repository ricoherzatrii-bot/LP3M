<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->renameIfNeeded('galeri_albums', 'galeri_album');
        $this->renameIfNeeded('galeri_fotos', 'galeri_foto');
        $this->renameIfNeeded('galeri_videos', 'galeri_video');

        if (!Schema::hasTable('galeri_album')) {
            Schema::create('galeri_album', function (Blueprint $table) {
                $table->id();
                $table->string('nama_album');
                $table->string('slug')->nullable();
                $table->string('sampul_foto')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('galeri_foto')) {
            Schema::create('galeri_foto', function (Blueprint $table) {
                $table->id();
                $table->foreignId('album_id')->constrained('galeri_album')->cascadeOnDelete();
                $table->string('file_path');
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('galeri_video')) {
            Schema::create('galeri_video', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('link_youtube')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('slug')->nullable();
                $table->timestamps();
            });
        }

        $this->addUpdatedAtIfMissing('galeri_album');
        $this->addUpdatedAtIfMissing('galeri_foto');
        $this->addUpdatedAtIfMissing('galeri_video');
    }

    public function down(): void
    {
        // Keep existing gallery data when rolling back this compatibility migration.
    }

    private function renameIfNeeded(string $from, string $to): void
    {
        if (!Schema::hasTable($to) && Schema::hasTable($from)) {
            Schema::rename($from, $to);
        }
    }

    private function addUpdatedAtIfMissing(string $table): void
    {
        if (Schema::hasTable($table) && !Schema::hasColumn($table, 'updated_at')) {
            Schema::table($table, function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable();
            });
        }
    }
};
