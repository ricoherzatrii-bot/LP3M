<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('akreditasi') && !Schema::hasColumn('akreditasi', 'foto_logo')) {
            Schema::table('akreditasi', function (Blueprint $table) {
                $table->string('foto_logo')->nullable()->after('file_dokumen');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('akreditasi') && Schema::hasColumn('akreditasi', 'foto_logo')) {
            Schema::table('akreditasi', function (Blueprint $table) {
                $table->dropColumn('foto_logo');
            });
        }
    }
};