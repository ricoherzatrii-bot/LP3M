<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kuesioner_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik')->nullable();
            $table->string('prodi')->nullable();
            $table->string('program')->nullable(); // Aspek
            $table->decimal('sangat_setuju', 8, 2)->default(0);
            $table->decimal('setuju', 8, 2)->default(0);
            $table->decimal('cukup_setuju', 8, 2)->default(0);
            $table->decimal('tidak_setuju', 8, 2)->default(0);
            $table->decimal('sangat_tidak_setuju', 8, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioner_mahasiswas');
    }
};
