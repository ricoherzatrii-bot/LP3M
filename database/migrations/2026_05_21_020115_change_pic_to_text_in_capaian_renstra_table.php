<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('capaian_renstra', function ($table) {
                $table->text('pic')->nullable()->change();
            });
        } catch (\Exception $e) {
            // Column may already be text type, safe to ignore
        }
    }

    public function down(): void
    {
        Schema::table('capaian_renstra', function ($table) {
            $table->string('pic', 255)->nullable()->change();
        });
    }
};
