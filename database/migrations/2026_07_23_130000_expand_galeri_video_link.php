<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        if (Schema::hasTable('galeri_video') && Schema::hasColumn('galeri_video', 'link_youtube')) {
            DB::statement('ALTER TABLE `galeri_video` MODIFY `link_youtube` TEXT NULL');
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        if (Schema::hasTable('galeri_video') && Schema::hasColumn('galeri_video', 'link_youtube')) {
            DB::statement('ALTER TABLE `galeri_video` MODIFY `link_youtube` VARCHAR(255) NULL');
        }
    }
};