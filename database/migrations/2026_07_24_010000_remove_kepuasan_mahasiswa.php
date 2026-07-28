<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('capaians')) {
            return;
        }

        DB::table('capaians')->where('kategori', 'Kepuasan Mahasiswa')->delete();

        DB::statement("ALTER TABLE capaians MODIFY kategori ENUM('Renop', 'Capaian Renstra', 'Kepuasan Dosen Dan Tendik') NOT NULL");
    }

    public function down(): void
    {
        if (!Schema::hasTable('capaians')) {
            return;
        }

        DB::statement("ALTER TABLE capaians MODIFY kategori ENUM('Renop', 'Capaian Renstra', 'Kepuasan Mahasiswa', 'Kepuasan Dosen Dan Tendik') NOT NULL");
    }
};
