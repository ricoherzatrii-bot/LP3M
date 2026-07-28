<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brand_assets', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('logo_file')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('brand_assets')) {
            DB::table('brand_assets')->insertOrIgnore([
                ['key' => 'logo_poljam', 'logo_file' => 'images/logo-poljam.png'],
                ['key' => 'logo_emblem', 'logo_file' => 'images/logo-emblem.png'],
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('brand_assets');
    }
};
