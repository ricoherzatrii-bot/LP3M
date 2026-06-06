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
        Schema::create('kuesioner_dosen_karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->text('program');
            $table->double('sangat_setuju')->default(0);
            $table->double('setuju')->default(0);
            $table->double('cukup_setuju')->default(0);
            $table->double('tidak_setuju')->default(0);
            $table->double('sangat_tidak_setuju')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioner_dosen_karyawans');
    }
};
