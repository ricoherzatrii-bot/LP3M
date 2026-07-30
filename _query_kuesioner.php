<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$mhs = \App\Models\KuesionerDosenKaryawan::where('kategori', 'Mahasiswa')->limit(3)->get();
echo "Mahasiswa Rows:" . PHP_EOL;
foreach($mhs as $row) {
    echo json_encode($row) . PHP_EOL;
}
