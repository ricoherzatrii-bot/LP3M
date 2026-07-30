<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$data = \Illuminate\Support\Facades\DB::table('kuesioner_dosen_karyawan')->where('kategori', 'Dosen & Karyawan')->first();
file_put_contents('test_dosen.json', json_encode($data, JSON_PRETTY_PRINT));
