<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$p1 = \App\Models\Prodi::pluck('nama')->toArray();
$p2 = \App\Models\Akreditasi::where('kategori', 'Akreditasi')->pluck('judul')->toArray();
$p3 = \App\Models\KuesionerDosenKaryawan::whereNotNull('prodi')->distinct()->pluck('prodi')->toArray();

echo "PRODIS TABLE:\n";
print_r($p1);
echo "\nAKREDITASI TABLE:\n";
print_r($p2);
echo "\nKUESIONER TABLE:\n";
print_r($p3);
