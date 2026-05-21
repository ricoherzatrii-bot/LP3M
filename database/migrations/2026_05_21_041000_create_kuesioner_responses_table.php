<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('kuesioner_responses')) {
            Schema::create('kuesioner_responses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('kuesioner_id');
                $table->unsignedBigInteger('pertanyaan_id');
                $table->text('jawaban');
                $table->string('session_id')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamps();

                $table->foreign('kuesioner_id')->references('id')->on('kuesioners')->onDelete('cascade');
                $table->foreign('pertanyaan_id')->references('id')->on('kuesioner_pertanyaans')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kuesioner_responses');
    }
};
