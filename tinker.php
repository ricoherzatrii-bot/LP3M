<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$prodi = new \App\Models\Prodi();
$prodi->kode = "<img src=x onerror=\"document.body.style.background='blue';\">";
$prodi->nama = 'Test XSS';
$prodi->save();
echo "Inserted Prodi ID: " . $prodi->id . "\n";
