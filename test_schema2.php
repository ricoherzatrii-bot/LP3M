<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$out = [];
foreach(['kuesioner', 'kuesioner_mahasiswa', 'kuesioner_dosen_karyawan'] as $t) {
    if (Schema::hasTable($t)) {
        $out[$t] = Schema::getColumnListing($t);
    } else {
        $out[$t] = "Does not exist";
    }
}
file_put_contents('out.json', json_encode($out, JSON_PRETTY_PRINT));
