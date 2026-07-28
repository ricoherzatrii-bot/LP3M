<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
foreach (DB::select('SHOW TABLES') as $row) {
    foreach ($row as $table) {
        echo $table . PHP_EOL;
    }
}
