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
        Schema::table('capaian_renstra', function (Blueprint $table) {
            $table->text('program')->nullable()->change();
            $table->text('indikator')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capaian_renstra', function (Blueprint $table) {
            $table->string('program')->nullable()->change();
            $table->string('indikator')->nullable()->change();
        });
    }
};
