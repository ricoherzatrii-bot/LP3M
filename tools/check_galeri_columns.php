<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

echo 'judul: ' . (Schema::hasColumn('galeri_foto', 'judul') ? 'yes' : 'no') . PHP_EOL;
echo 'deskripsi: ' . (Schema::hasColumn('galeri_foto', 'deskripsi') ? 'yes' : 'no') . PHP_EOL;
