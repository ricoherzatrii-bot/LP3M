<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = '';

// Fix galeri_videos table: add AUTO_INCREMENT and PRIMARY KEY
try {
    // Check if primary key exists
    $pkCheck = \DB::select("SHOW KEYS FROM galeri_videos WHERE Key_name = 'PRIMARY'");
    if (empty($pkCheck)) {
        \DB::statement("ALTER TABLE galeri_videos MODIFY id bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY");
        $output .= "✓ Added AUTO_INCREMENT + PRIMARY KEY to galeri_videos.id\n";
    } else {
        // Primary key exists but AUTO_INCREMENT might be missing
        \DB::statement("ALTER TABLE galeri_videos MODIFY id bigint(20) unsigned NOT NULL AUTO_INCREMENT");
        $output .= "✓ Added AUTO_INCREMENT to galeri_videos.id (PK already existed)\n";
    }
} catch (\Exception $e) {
    $output .= "✗ Fix failed: " . $e->getMessage() . "\n";
}

// Now test creating a video
try {
    $video = \App\Models\GaleriVideo::create([
        'judul' => 'Test Video YouTube',
        'slug' => \Illuminate\Support\Str::slug('Test Video YouTube'),
        'link_youtube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'deskripsi' => 'Video test untuk verifikasi'
    ]);
    $output .= "✓ Video created successfully: ID={$video->id}, Judul={$video->judul}\n";
} catch (\Exception $e) {
    $output .= "✗ Video creation still failed: " . $e->getMessage() . "\n";
}

// Verify the table structure now
try {
    $rows = \DB::select("SHOW CREATE TABLE galeri_videos");
    $output .= "\nFinal CREATE TABLE:\n" . $rows[0]->{'Create Table'} . "\n";
} catch (\Exception $e) {
    $output .= "✗ Show create table failed: " . $e->getMessage() . "\n";
}

// List all videos
try {
    $videos = \App\Models\GaleriVideo::all();
    $output .= "\nTotal videos: " . $videos->count() . "\n";
    foreach ($videos as $v) {
        $output .= "  - [{$v->id}] {$v->judul} | src: {$v->link_youtube}\n";
    }
} catch (\Exception $e) {
    $output .= "✗ " . $e->getMessage() . "\n";
}

file_put_contents(__DIR__ . '/temp_fix_video.txt', $output);
echo "Done.\n";
