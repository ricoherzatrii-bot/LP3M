<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        // Insert default social links
        DB::table('social_links')->insert([
            ['key' => 'phone', 'url' => 'tel:+62741123456', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'email', 'url' => 'mailto:lpm@politeknikjambi.ac.id', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'instagram', 'url' => 'https://www.instagram.com/politeknikjambi?igsh=MW1scnJubzYxbXI1OA==', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'tiktok', 'url' => 'https://www.tiktok.com/@politeknikjambi?_r=1&_t=ZS-97xqcpSv8SK', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'youtube', 'url' => 'https://youtube.com/@poltekjambi?si=gP6jTcGudVbPtwB1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
