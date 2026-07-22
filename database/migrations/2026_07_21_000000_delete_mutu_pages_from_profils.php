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
        if (Schema::hasTable('profils')) {
            DB::table('profils')->whereIn('slug', [
                'kebijakan-mutu-poljam',
                'sasaran-mutu-poljam',
                'standar-mutu-poljam',
                'sasaran-mutu-lpm'
            ])->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op - rows cannot be easily recovered dynamically unless re-seeded
    }
};
