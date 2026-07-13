<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = '';

// 1. Test Video Upload (YouTube link)
try {
    $video = \App\Models\GaleriVideo::create([
        'judul' => 'Test Video YouTube',
        'slug' => \Illuminate\Support\Str::slug('Test Video YouTube'),
        'link_youtube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'deskripsi' => 'Video test untuk verifikasi'
    ]);
    $output .= "✓ Video created: ID={$video->id}, Judul={$video->judul}\n";
} catch (\Exception $e) {
    $output .= "✗ Video creation failed: " . $e->getMessage() . "\n";
}

// 2. Check GaleriVideo records
try {
    $videos = \App\Models\GaleriVideo::all();
    $output .= "\nTotal videos in DB: " . $videos->count() . "\n";
    foreach ($videos as $v) {
        $output .= "  - [{$v->id}] {$v->judul} | src: {$v->link_youtube}\n";
    }
} catch (\Exception $e) {
    $output .= "✗ Video fetch failed: " . $e->getMessage() . "\n";
}

// 3. Check kuesioner_dosen_karyawans records
try {
    $kdk = \App\Models\KuesionerDosenKaryawan::count();
    $output .= "\nTotal kuesioner_dosen_karyawans records: {$kdk}\n";
    
    $byKategori = \App\Models\KuesionerDosenKaryawan::select('kategori', \DB::raw('COUNT(*) as cnt'))
        ->groupBy('kategori')->get();
    foreach ($byKategori as $row) {
        $output .= "  - Kategori: {$row->kategori} => {$row->cnt} records\n";
    }
} catch (\Exception $e) {
    $output .= "✗ Kuesioner DosenKaryawan fetch failed: " . $e->getMessage() . "\n";
}

// 4. Check kuesioner_mahasiswas table
try {
    $hasMahasiswa = \DB::select("SELECT COUNT(*) as cnt FROM kuesioner_mahasiswas");
    $output .= "\nkuesioner_mahasiswas table exists: YES, records: {$hasMahasiswa[0]->cnt}\n";
} catch (\Exception $e) {
    $output .= "✗ kuesioner_mahasiswas check failed: " . $e->getMessage() . "\n";
}

// 5. Check kuesioner_dosen_karyawans schema
try {
    $cols = \DB::select("SHOW COLUMNS FROM kuesioner_dosen_karyawans");
    $output .= "\nkuesioner_dosen_karyawans columns:\n";
    foreach ($cols as $col) {
        $output .= "  - {$col->Field} ({$col->Type})\n";
    }
} catch (\Exception $e) {
    $output .= "✗ Schema check failed: " . $e->getMessage() . "\n";
}

// 6. Check kuesioner_mahasiswas schema
try {
    $cols = \DB::select("SHOW COLUMNS FROM kuesioner_mahasiswas");
    $output .= "\nkuesioner_mahasiswas columns:\n";
    foreach ($cols as $col) {
        $output .= "  - {$col->Field} ({$col->Type})\n";
    }
} catch (\Exception $e) {
    $output .= "✗ Schema check failed: " . $e->getMessage() . "\n";
}

file_put_contents(__DIR__ . '/temp_verify_output.txt', $output);
echo "Done.\n";
