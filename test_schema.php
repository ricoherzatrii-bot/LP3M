<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = ['kuesioner', 'kuesioner_mahasiswa', 'kuesioner_dosen_karyawan'];

foreach($tables as $t) {
    echo "Table $t:\n";
    print_r(Schema::getColumnListing($t));
    echo "\n";
}
