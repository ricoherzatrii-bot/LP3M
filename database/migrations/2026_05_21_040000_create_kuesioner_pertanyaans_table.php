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
        if (!Schema::hasTable('kuesioner_pertanyaans')) {
            Schema::create('kuesioner_pertanyaans', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kuesioner_id');
                $table->text('pertanyaan');
                $table->enum('tipe_jawaban', ['skala_likert', 'teks', 'pilihan_ganda'])->default('skala_likert');
                $table->text('opsi_jawaban')->nullable(); // For multiple choice / custom scales
                $table->integer('urutan')->default(0);
                $table->timestamps();

                $table->foreign('kuesioner_id')->references('id')->on('kuesioners')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuesioner_pertanyaans');
    }
};
