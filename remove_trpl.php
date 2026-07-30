<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$old = 'D4 Teknologi Rekayasa Perangkat Lunak (TRPL)';
$new = 'D4 Teknologi Rekayasa Perangkat Lunak';

// Update Kuesioner (prodi column)
\App\Models\KuesionerDosenKaryawan::where('prodi', $old)->update(['prodi' => $new]);

// Update Akreditasi (judul column)
\App\Models\Akreditasi::where('kategori', 'Akreditasi')->where('judul', $old)->update(['judul' => $new]);

// Update Prodis (nama column)
\App\Models\Prodi::where('nama', $old)->update(['nama' => $new]);

echo "Database updated to remove (TRPL)\n";
