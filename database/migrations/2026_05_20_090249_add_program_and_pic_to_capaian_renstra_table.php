<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('capaian_renstra', function (Blueprint $table) {
            if (!Schema::hasColumn('capaian_renstra', 'program')) {
                $table->string('program')->nullable();
            }
            if (!Schema::hasColumn('capaian_renstra', 'pic')) {
                $table->string('pic')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('capaian_renstra', function (Blueprint $table) {
            $table->dropColumn(['program', 'pic']);
        });
    }
};
