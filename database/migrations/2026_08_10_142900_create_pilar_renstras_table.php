<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pilar_renstra')) {
            Schema::create('pilar_renstra', function (Blueprint $table) {
                $table->id();
                $table->string('kode', 10);
                $table->text('judul');
                $table->string('warna', 20)->default('#1e3a8a');
                $table->string('gradient_class')->default('bg-gradient-to-br from-[#1e3a8a] to-blue-900');
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pilar_renstra');
    }
};
