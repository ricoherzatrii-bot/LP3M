<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$p1 = \App\Models\Prodi::pluck('nama')->toArray();
$p2 = \App\Models\Akreditasi::where('kategori', 'Akreditasi')->pluck('judul')->toArray();
$p3 = \App\Models\KuesionerDosenKaryawan::whereNotNull('prodi')->distinct()->pluck('prodi')->toArray();
$m = array_merge($p1,$p2,$p3);
$m = array_filter(array_unique(array_map('trim', $m)));
sort($m);
echo json_encode(array_values($m), JSON_PRETTY_PRINT);
