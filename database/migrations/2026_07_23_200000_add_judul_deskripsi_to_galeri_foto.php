<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('galeri_foto')) {
            Schema::table('galeri_foto', function (Blueprint $table) {
                if (!Schema::hasColumn('galeri_foto', 'judul')) {
                    $table->string('judul')->nullable()->after('file_path');
                }
                if (!Schema::hasColumn('galeri_foto', 'deskripsi')) {
                    $table->text('deskripsi')->nullable()->after('judul');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('galeri_foto')) {
            Schema::table('galeri_foto', function (Blueprint $table) {
                if (Schema::hasColumn('galeri_foto', 'deskripsi')) {
                    $table->dropColumn('deskripsi');
                }
                if (Schema::hasColumn('galeri_foto', 'judul')) {
                    $table->dropColumn('judul');
                }
            });
        }
    }
};
