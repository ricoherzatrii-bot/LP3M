<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$output = '';

// 1. Test video gallery page rendering
try {
    $request = Illuminate\Http\Request::create('/galeri/video', 'GET');
    $response = app()->handle($request);
    $html = $response->getContent();
    
    $hasEmbed = (strpos($html, 'youtube.com/embed') !== false);
    $hasTitle = (strpos($html, 'Test Video YouTube') !== false);
    $hasEmptyMsg = (strpos($html, 'fa-video-slash') !== false);
    
    $output .= "=== Video Gallery Page ===\n";
    $output .= "YouTube embed found: " . ($hasEmbed ? "YES ✓" : "NO ✗") . "\n";
    $output .= "Video title found: " . ($hasTitle ? "YES ✓" : "NO ✗") . "\n";
    $output .= "Empty gallery message: " . ($hasEmptyMsg ? "YES (empty)" : "NO (has content) ✓") . "\n";
} catch (\Exception $e) {
    $output .= "✗ Video gallery page error: " . $e->getMessage() . "\n";
}

// 2. Test kuesioner mahasiswa page
try {
    $request = Illuminate\Http\Request::create('/kuesioner/mahasiswa', 'GET');
    $response = app()->handle($request);
    $html = $response->getContent();
    $statusCode = $response->getStatusCode();
    
    $hasTahunFilter = (strpos($html, 'tahun-select-btn') !== false || strpos($html, 'tahun_akademik') !== false);
    $hasProdiFilter = (strpos($html, 'prodi') !== false);
    $hasChart = (strpos($html, 'chart.js') !== false || strpos($html, 'Chart.js') !== false);
    
    $output .= "\n=== Kuesioner Mahasiswa Page ===\n";
    $output .= "Status: {$statusCode}\n";
    $output .= "Tahun filter: " . ($hasTahunFilter ? "YES ✓" : "NO ✗") . "\n";
    $output .= "Prodi filter: " . ($hasProdiFilter ? "YES ✓" : "NO ✗") . "\n";
    $output .= "Chart.js loaded: " . ($hasChart ? "YES ✓" : "NO ✗") . "\n";
} catch (\Exception $e) {
    $output .= "✗ Kuesioner Mahasiswa page error: " . $e->getMessage() . "\n";
}

// 3. Test kuesioner dosen page
try {
    $request = Illuminate\Http\Request::create('/kuesioner/dosen', 'GET');
    $response = app()->handle($request);
    $html = $response->getContent();
    $statusCode = $response->getStatusCode();
    
    $hasChart = (strpos($html, 'chart.js') !== false || strpos($html, 'Chart.js') !== false);
    $hasData = (strpos($html, 'chartDataRaw') !== false);
    
    $output .= "\n=== Kuesioner Dosen Page ===\n";
    $output .= "Status: {$statusCode}\n";
    $output .= "Chart.js loaded: " . ($hasChart ? "YES ✓" : "NO ✗") . "\n";
    $output .= "Chart data present: " . ($hasData ? "YES ✓" : "NO ✗") . "\n";
} catch (\Exception $e) {
    $output .= "✗ Kuesioner Dosen page error: " . $e->getMessage() . "\n";
}

// 4. Test dashboard page
try {
    $request = Illuminate\Http\Request::create('/dashboard', 'GET');
    $response = app()->handle($request);
    $statusCode = $response->getStatusCode();
    $html = $response->getContent();
    
    $hasKMPanel = (strpos($html, 'Kuesioner Mahasiswa') !== false);
    $hasGaleriPanel = (strpos($html, 'Galeri') !== false || strpos($html, 'galeri') !== false);
    
    $output .= "\n=== Dashboard Page ===\n";
    $output .= "Status: {$statusCode}\n";
    $output .= "KM panel found: " . ($hasKMPanel ? "YES ✓" : "NO ✗") . "\n";
    $output .= "Galeri panel found: " . ($hasGaleriPanel ? "YES ✓" : "NO ✗") . "\n";
} catch (\Exception $e) {
    $output .= "✗ Dashboard page error: " . $e->getMessage() . "\n";
}

file_put_contents(__DIR__ . '/temp_page_verify.txt', $output);
echo "Done.\n";
