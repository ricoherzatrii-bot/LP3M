<?php
$logPath = __DIR__ . '/storage/logs/laravel.log';
if (!file_exists($logPath)) {
    die("Log file not found.\n");
}
$content = file_get_contents($logPath);
preg_match_all('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] \w+\.ERROR: (.*?)(?=\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|$)/s', $content, $matches);
if (!empty($matches[1])) {
    $lastError = end($matches[1]);
    $lines = explode("\n", $lastError);
    echo "ERROR MESSAGE: " . $lines[0] . "\n\n";
    echo "STACK TRACE (BASENAMES ONLY):\n";
    foreach ($lines as $line) {
        if (strpos($line, 'Poljam-Project') !== false && strpos($line, 'vendor') === false) {
            // Replace long path with short path
            $short = str_replace('C:/Users/USER/Poljam-Project/', '', $line);
            echo trim($short) . "\n";
        }
    }
} else {
    echo "No errors found.\n";
}
