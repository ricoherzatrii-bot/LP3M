<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = '';
try {
    $rows = \DB::select("SHOW CREATE TABLE `galeri_videos`");
    $output .= "CREATE TABLE STATEMENT:\n";
    $output .= $rows[0]->{'Create Table'} . "\n";
} catch (\Exception $e) {
    $output .= "ERROR: " . $e->getMessage() . "\n";
}

file_put_contents(__DIR__ . '/temp_output.txt', $output);
echo "Done.\n";
