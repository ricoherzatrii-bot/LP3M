<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$columns = Schema::getColumnListing('profils');
file_put_contents('columns.txt', json_encode($columns));
echo "Saved to columns.txt";
