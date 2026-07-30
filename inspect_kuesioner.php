<?php
$db = new PDO('sqlite:database/database.sqlite');
$tables = $db->query('SELECT name FROM sqlite_master WHERE type="table" AND name LIKE "%kuesioner%"')->fetchAll();

foreach($tables as $t) {
    echo "TABLE: " . $t['name'] . "\n";
    $cols = $db->query('PRAGMA table_info(' . $t['name'] . ')')->fetchAll();
    foreach($cols as $c) {
        echo "  - " . $c['name'] . " (" . $c['type'] . ")\n";
    }
    echo "\n";
}
