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
        if (!Schema::hasTable('artikels')) {
            Schema::create('artikels', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('isi_konten')->nullable();
                $table->string('kategori')->nullable();
                $table->string('penulis')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('artikels', function (Blueprint $table) {
            if (!Schema::hasColumn('artikels', 'slug')) {
                $table->string('slug')->after('judul')->nullable();
            }
            if (!Schema::hasColumn('artikels', 'gambar_fitur')) {
                $table->string('gambar_fitur')->after('kategori')->nullable();
            }
            if (!Schema::hasColumn('artikels', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            $table->dropColumn(['slug', 'gambar_fitur']);
        });
    }
};
