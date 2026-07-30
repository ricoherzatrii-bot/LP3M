<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$profils = App\Models\Profil::orderBy('id')->get(['id', 'judul', 'kategori', 'slug']);
file_put_contents('profil_dump.json', json_encode($profils, JSON_PRETTY_PRINT));
