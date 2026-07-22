<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('home_counters');
        Schema::dropIfExists('kontens');
        Schema::dropIfExists('galeris');
        Schema::dropIfExists('links');
        Schema::dropIfExists('pengumumans');
        Schema::dropIfExists('beritas');
    }

    public function down(): void
    {
        // Tables can be recreated from db_lp3m_poljam.sql if needed
    }
};
